<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarMemoriaCalculo.php
Propósito:				Permite realizar el listado en tpr_memoria_calculo
Tabla:					t_tpr_memoria_calculo
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-07-10 09:08:19
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarMemoriaCalculo .php';

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

	if($sort == '') $sortcol = 'desc_ingas_item_serv';
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
	
	$cond->add_criterio_extra("PARPRE.id_partida_presupuesto",$id_partida_presupuesto);	
	
	//if($id_moneda){
	//	$cond->add_criterio_extra("MEMSER.id_moneda",$id_moneda);	
	//}

	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	$criterio_filtro2=$criterio_filtro;
	
	if($tipo_memoria=='1'){
		$criterio_filtro=$criterio_filtro."  and COALESCE(MEMING.id_moneda,".$id_moneda.")=".$id_moneda." ";
	}
	if($tipo_memoria=='2'){
		$criterio_filtro=$criterio_filtro."  and COALESCE(MEINGA.id_moneda,".$id_moneda.")=".$id_moneda." ";
	}
	if($tipo_memoria=='3'){
		$criterio_filtro=$criterio_filtro."  and COALESCE(MEINGA.id_moneda,".$id_moneda.")=".$id_moneda." ";
	}
	if($tipo_memoria=='4'){
		$criterio_filtro=$criterio_filtro."  and COALESCE(MEMPAS.id_moneda,".$id_moneda.")=".$id_moneda." ";
	}
	if($tipo_memoria=='5'){
		$criterio_filtro=$criterio_filtro."  and COALESCE(MEMVIA.id_moneda,".$id_moneda.")=".$id_moneda." ";
	}
	if($tipo_memoria=='6'){
		$criterio_filtro=$criterio_filtro."  and COALESCE(MERRHH.id_moneda,".$id_moneda.")=".$id_moneda." ";
	}
	if($tipo_memoria=='7'){
		$criterio_filtro=$criterio_filtro."  and COALESCE(MEMSER.id_moneda,".$id_moneda.")=".$id_moneda." ";
	}
	if($tipo_memoria=='8'){
		$criterio_filtro=$criterio_filtro."  and COALESCE(MERRHH.id_moneda,".$id_moneda.")=".$id_moneda." ";
	}
	if($tipo_memoria=='9'){
		$criterio_filtro=$criterio_filtro."  and COALESCE(MEMCOM.id_moneda,".$id_moneda.")=".$id_moneda." ";
	}
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'MemoriaCalculo');
	$sortcol = $crit_sort->get_criterio_sort();	

	//Obtiene el total de los registros
	$res = $Custom -> ContarMemoriaCalculo($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro2,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarMemoriaCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{ 			
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_memoria_calculo',$f["id_memoria_calculo"]);
			$xml->add_nodo('id_concepto_ingas',$f["id_concepto_ingas"]);
			$xml->add_nodo('desc_concepto_ingas',$f["desc_concepto_ingas"]);
			$xml->add_nodo('justificacion',$f["justificacion"]);
			$xml->add_nodo('tipo_detalle',$f["tipo_detalle"]);
			$xml->add_nodo('id_partida_presupuesto',$f["id_partida_presupuesto"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('des_moneda',$f["des_moneda"]);
			$xml->add_nodo('costo_estimado',$f["costo_estimado"]);
			$xml->add_nodo('tipo_cambio',$f["tipo_cambio"]);
			$xml->add_nodo('total',$f["total"]);
			//$xml->add_nodo('total',number_format($f["total"],0,'','.'));	
			$xml->add_nodo('id_moneda2',$f["id_moneda2"]);
			$xml->add_nodo('desc_moneda2',$f["desc_moneda2"]);		

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