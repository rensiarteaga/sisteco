<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDevPasaje.php
Propósito:				Permite realizar el listado en tts_devengado_detalle
Tabla:					t_tts_devengado_detalle
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-10-21 15:43:29
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();

include_once('../LibModeloTesoreria.php');
$Custom = new cls_CustomDBTesoreria();


$nombre_archivo = 'ActionListarDevPasaje.php';

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

	if($sort == '') $sortcol = 'pasaje_nro, nota_debito';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
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
	
	//$cond->add_criterio_extra("DEVENG.id_devengado",$m_id_devengado);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	if($m_gestion !='')
	{
		$criterio_filtro=$criterio_filtro." AND CTADET.id_presupuesto in (select id_presupuesto from presto.tpr_presupuesto
																								  where id_parametro in (select id_parametro from presto.tpr_parametro where id_gestion=$m_gestion)) ";
	}
	else
	{
		$criterio_filtro=$criterio_filtro." AND CTADET.id_presupuesto in (0) ";
	}
	
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'');
	$sortcol = $crit_sort->get_criterio_sort();


	//Obtiene el total de los registros
	$res = $Custom -> ContarDevPasaje($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarDevPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_cuenta_doc_det',$f["id_cuenta_doc_det"]);
			$xml->add_nodo('sw_select',$f["sw_select"]);
			$xml->add_nodo('partida',$f["partida"]);
			$xml->add_nodo('desc_presupuesto',$f["desc_presupuesto"]);
			$xml->add_nodo('pasaje_orden',$f["pasaje_orden"]);
			$xml->add_nodo('nota_debito',$f["nota_debito"]);
			$xml->add_nodo('pasaje_nro',$f["pasaje_nro"]);
			$xml->add_nodo('importe',$f["importe"]);
			$xml->add_nodo('pasaje_cobrar',$f["pasaje_cobrar"]);
			$xml->add_nodo('pasaje_credito',$f["pasaje_credito"]);
			$xml->add_nodo('importe_total',$f["importe_total"]);
			$xml->add_nodo('fecha_sol',$f["fecha_sol"]);
			$xml->add_nodo('recorrido',$f["recorrido"]);
			$xml->add_nodo('res_pago',$f["res_pago"]);
			$xml->add_nodo('res_dev',$f["res_dev"]);
			$xml->add_nodo('nro_documento',$f["nro_documento"]);
			
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