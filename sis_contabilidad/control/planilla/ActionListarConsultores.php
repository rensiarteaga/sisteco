<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarConsultores.php
Propósito:				Permite realizar el listado en tad_cotizacion
Tabla:					t_tad_cotizacion
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-28 16:58:46
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarConsultores.php';

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
	if($sort == '') $sortcol = 'id_cotizacion';
	//else {if($sortcol=='numeracion_periodo'){$sortcol='num_cotizacion';}
	else{
	$sortcol = $sort;}//}
	
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
	
	if($en_planilla=='si'){
		$num_sol=" pla.id_planilla=".$m_id_planilla." and   ";
	}else{
		$num_sol=" AND c.id_depto_tesoro=$m_id_depto_tesoro AND c.id_cotizacion not in (select id_cotizacion from compro.tad_plan_pago where id_planilla>0) and PLA.estado=''pendiente'' ";
	}
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	//Obtiene el criterio de orden de columnas
	if($sortcol=='numeracion_periodo'){
		$sortcol='num_cotizacion';
	}
	elseif($sortcol=='numeracion_oc'){
		$sortcol='num_orden_compra';
	}else{
		$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Cotizacion');
		$sortcol = $crit_sort->get_criterio_sort();
	}
	
	//Obtiene el total de los registros
	$res = $Custom -> ContarConsultores($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$num_sol);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarConsultores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$num_sol);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_cotizacion',$f["id_cotizacion"]);
			$xml->add_nodo('desc_proveedor',$f["desc_proveedor"]);
			$xml->add_nodo('num_os',$f["num_os"]);
			$xml->add_nodo('codigo_proceso',$f["codigo_proceso"]);
			$xml->add_nodo('observaciones',$f["observaciones"]);
			$xml->add_nodo('num_sol',$f["num_sol"]);
			$xml->add_nodo('prox_pago',$f["prox_pago"]);
			$xml->add_nodo('fecha_prox_pago',$f["fecha_prox_pago"]);
			$xml->add_nodo('nro_contrato',$f["nro_contrato"]);
			$xml->add_nodo('id_plan_pago',$f["id_plan_pago"]);
			
			$xml->add_nodo('monto',$f["monto"]);
			$xml->add_nodo('fecha_pagado',$f["fecha_pagado"]);
			$xml->add_nodo('tipo_plantilla',$f["tipo_plantilla"]);
			$xml->add_nodo('num_factura',$f["num_factura"]);
			$xml->add_nodo('fecha_factura',$f["fecha_factura"]);
			$xml->add_nodo('desc_plantilla',$f["desc_plantilla"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('nit',$f["nit"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
			$xml->add_nodo('tipo',$f["tipo"]);
			$xml->add_nodo('id_documento',$f["id_documento"]);
			$xml->add_nodo('por_anticipo',$f["por_anticipo"]);
			$xml->add_nodo('por_retgar',$f["por_retgar"]);
			$xml->add_nodo('multas',$f["multas"]);
			$xml->add_nodo('id_cuenta_bancaria',$f["id_cuenta_bancaria"]);
			$xml->add_nodo('cuenta_bancaria',$f["cuenta_bancaria"]);
			$xml->add_nodo('tipo_cheque',$f["tipo_cheque"]);
			$xml->add_nodo('monto_a_pagar',$f["monto_a_pagar"]);
			$xml->add_nodo('nro_cuenta_proveedor',$f["nro_cuenta_proveedor"]);
			
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

