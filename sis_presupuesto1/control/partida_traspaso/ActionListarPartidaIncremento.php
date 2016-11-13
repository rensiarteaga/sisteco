<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarPartidaTraspaso.php
Propósito:				Permite realizar el listado en tpr_partida_traspaso
Tabla:					tpr_tpr_partida_traspaso
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2009-02-04 19:45:09
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarPartidaIncremento.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_partida_traspaso';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'desc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> 'si', 'no'
	
	switch ($cod)
	{
		case 'si':
			$decodificar = true;
			break;
		case 'no':
			$decodificar = false;
			break;
		default:
			$decodificar = true;
			break;
	}

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	/*if($filtro_aprobacion=='si'){
		$cond->add_criterio_extra("PARTRA.estado_traspaso",3); //filtramos solamente los traspasos en estado autorizacion
	}*/
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();	
		
	if($filtro_incremento=='si')
	{			 
		$criterio_filtro=$criterio_filtro." and PARTRA.tipo_traspaso in (3) and PARTRA.estado_traspaso not in (2)";	//filtramos solamente los incrementos no concluidos
	}
	
	if($filtro_incremento_concluidos=='si')
	{
		$criterio_filtro=$criterio_filtro." and PARTRA.tipo_traspaso in (3) and PARTRA.estado_traspaso in (2) ";	//filtramos solamente los incrementos concluidos
	}
	
	if($filtro_aprobacion_incremento=='si')
	{		 
		$criterio_filtro=$criterio_filtro." and PARTRA.estado_traspaso in (3,5,6) and PARTRA.tipo_traspaso in (3)";	//filtramos solamente los incrementos en estado autorizacion
		
		//la siguiente linea fue comentada en cumplimiento al memorandum CBGAF-00327/11 referente a la aprobacion de traspasos a cargo de la GAF  12/01/2011
		//$criterio_filtro=$criterio_filtro." and	(USUARI2.id_usuario=".$_SESSION["ss_id_usuario"]." and PARTRA.estado_traspaso in (6) and PARTRA.tipo_traspaso in (3))";	//3=autorizacion  5=autorizacion origen 6=autorizacion destino
	}
	else 
	{
		if($m_id_gestion== "undefined"  || $m_id_gestion == "")
		{	        
	        $criterio_filtro=$criterio_filtro." AND PARAMP.gestion_pres=(select max(PARAMP.gestion_pres) from presto.tpr_parametro PARAMP) ";	
	    }
	    else 
	    {
	    	$criterio_filtro=$criterio_filtro." AND PARAMP.id_gestion=".$m_id_gestion;	    	
	    }	
	}
		
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'PartidaTraspaso');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarPartidaIncremento($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarPartidaIncremento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_partida_traspaso',$f["id_partida_traspaso"]);			
			$xml->add_nodo('id_partida_presupuesto_destino',$f["id_partida_presupuesto_destino"]);			
			$xml->add_nodo('id_partida_ejecucion_destino',$f["id_partida_ejecucion_destino"]);
			
			$xml->add_nodo('id_usu_autorizado_destino',$f["id_usu_autorizado_destino"]);
			$xml->add_nodo('desc_usuario_destino',$f["desc_usuario_destino"]);
			$xml->add_nodo('id_usu_autorizado_registro',$f["id_usu_autorizado_registro"]);
			$xml->add_nodo('desc_usuario_registro',$f["desc_usuario_registro"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
			$xml->add_nodo('importe_traspaso',$f["importe_traspaso"]);
			$xml->add_nodo('estado_traspaso',$f["estado_traspaso"]);
			$xml->add_nodo('fecha_traspaso',$f["fecha_traspaso"]);
			$xml->add_nodo('fecha_conclusion',$f["fecha_conclusion"]);
			$xml->add_nodo('justificacion',$f["justificacion"]);
			
			$xml->add_nodo('id_parametro',$f["id_parametro"]);
			$xml->add_nodo('desc_parametro',$f["desc_parametro"]);
			$xml->add_nodo('tipo_pres',$f["tipo_pres"]);			
			
			$xml->add_nodo('id_partida_destino',$f["id_partida_destino"]);
			$xml->add_nodo('desc_partida_destino',$f["desc_partida_destino"]);	
			
			$xml->add_nodo('id_presupuesto_destino',$f["id_presupuesto_destino"]);
			$xml->add_nodo('desc_presupuesto_destino',$f["desc_presupuesto_destino"]);
			$xml->add_nodo('tipo_traspaso',$f["tipo_traspaso"]);

			$xml->fin_rama();
		}
		$xml->mostrar_xml();
	}
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true,'406');
		$resp->mensaje_error = $Custom->salida[1];
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;
		echo $resp->get_mensaje();
		exit;
	}
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;

}?>