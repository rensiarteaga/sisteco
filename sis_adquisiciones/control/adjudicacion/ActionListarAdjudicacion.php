<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarAdjudicacion.php
Propósito:				Permite realizar el listado en tad_cotizacion_det, proceso_compra_det, solicitud_det, grupo_sp_det, solicitud_proceso_compra
Tabla:					t_tad_cotizacion_det, grupo_sp_det, proceso_compra_det, solicitud_compra_det
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-28 17:32:17
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionListarAdjudicacion.php';


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

	if($sort == '') $sortcol = 'cotdet.id_cotizacion_det';
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
	
	//$cond->add_criterio_extra("COTIZA.id_cotizacion",$m_id_cotizacion);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	if($cant_cotizada>0){//para los procesos grandes que requieren que se tenga cotizaciones para adjudicar, en el caso de las compras directas no hay esta restriccion
	    $criterio_filtro=$criterio_filtro." AND cotdet.precio>0";
	}
	
	//Obtiene el total de los registros
	$res = $Custom -> ContarAdjudicacion($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_cotizacion,$id_item,$id_servicio);

	if($res) $total_registros= $Custom->salida;

	
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarAdjudicacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_cotizacion,$id_item,$id_servicio);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		$grupo='';
		$llave=0;

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_proceso_compra_det',$f["id_proceso_compra_det"]);
			$xml->add_nodo('id_proceso_compra',$f["id_proceso_compra"]);
			$xml->add_nodo('id_item',$f["id_item"]);
			$xml->add_nodo('id_servicio',$f["id_servicio"]);
			$xml->add_nodo('cantidad_proceso',$f["cantidad_proceso"]);
			$xml->add_nodo('precio_ref_proceso',$f["precio_ref_proceso"]);
			$xml->add_nodo('cantidad_solicitada',$f["cantidad_solicitada"]);
			$xml->add_nodo('precio_ref_solicitado',$f["precio_ref_solicitado"]);
			$xml->add_nodo('cantidad_cotizada',$f["cantidad_cotizada"]);
			$xml->add_nodo('precio_cotizado',$f["precio_cotizado"]);
			$xml->add_nodo('id_solicitud_compra_det',$f["id_solicitud_compra_det"]);
			$xml->add_nodo('cantidad_adjudicada',$f["cantidad_adjudicada"]);
			$xml->add_nodo('item',$f["item"]);
			$xml->add_nodo('reformular',$f["reformular"]);
			$xml->add_nodo('id_cotizado',$f["id_cotizado"]); // item o servicio cotizado
			$xml->add_nodo('monto_aprobado',$f["monto_aprobado"]);
			$xml->add_nodo('id_adjudicacion',$f["id_adjudicacion"]);
			$xml->add_nodo('adjudicado',$f["adjudicado"]);
			$xml->add_nodo('id_cotizacion_det',$f["id_cotizacion_det"]);
			$xml->add_nodo('cantidad',$f["cantidad"]);
			$xml->add_nodo('monto_ref_reformulado',$f["monto_ref_reformulado"]);
			$xml->add_nodo('num_sol',$f["periodo"].'/'.$f["num_solicitud"]);
			$xml->add_nodo('motivo_ref',$f["motivo_ref"]);
			$xml->add_nodo('total_adjudicado_por_detalle',$f["total_adjudicado_por_detalle"]);
			if($f["total_adjudicado_por_detalle"]<$f["cantidad_solicitada"]){
			    $xml->add_nodo('falta_adjudicar',$f["total_adjudicado_por_detalle"]);
			}else{
			    $xml->add_nodo('falta_adjudicar',$f["cantidad_solicitada"]);
			}
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