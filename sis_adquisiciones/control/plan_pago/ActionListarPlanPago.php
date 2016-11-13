<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarPlanPago.php
Prop�sito:				Permite realizar el listado en tad_plan_pago
Tabla:					t_tad_plan_pago
Par�metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci�n:		2008-05-28 17:32:19
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionListarPlanPago .php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Par�metros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'nro_cuota';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
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
	$cond->add_criterio_extra("cotiza.id_cotizacion",$m_id_cotizacion);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'PlanPago');
	$sortcol = $crit_sort->get_criterio_sort();
	//ago2015: para reprogramacion de pagos
	if(isset($id) and $id!=null){
		$criterio_filtro=$criterio_filtro. "  and plapag.id_plan_pago=".$id. " and plapag.estado=''pendiente'' ";
	}
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarPlanPago($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_id_cotizacion);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarPlanPago($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_id_cotizacion);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('monto_a_pagar',$f["monto_a_pagar"]);
			$xml->add_nodo('cuota_a_pagar',$f["cuota_a_pagar"]);
			$xml->add_nodo('estado',$f["estado"]);
			$xml->add_nodo('fecha_pago',$f["fecha_pago"]);
			$xml->add_nodo('id_cotizacion',$f["id_cotizacion"]);
			$xml->add_nodo('id_plan_pago',$f["id_plan_pago"]);
			$xml->add_nodo('monto',$f["monto"]);
			$xml->add_nodo('nro_cuota',$f["nro_cuota"]);
			$xml->add_nodo('tipo_pago',$f["tipo_pago"]);
			$xml->add_nodo('precio_total',$f["precio_total"]);
			$xml->add_nodo('pagado',$f["pagado"]);
			$xml->add_nodo('falta_pagar',$f["falta_pagar"]);
			$xml->add_nodo('fecha_pagado',$f["fecha_pagado"]);
			$xml->add_nodo('estado_vigente',$f["estado_vigente"]);//de la cotizacion
			$xml->add_nodo('num_pagos',$f["num_pagos"]);//de la cotizacion
			$xml->add_nodo('num_factura',$f["num_factura"]);//de la cotizacion
			$xml->add_nodo('observaciones',$f["observaciones"]);//de la cotizacion
			$xml->add_nodo('boleta_garantia',$f["boleta_garantia"]);//de la cotizacion
			$xml->add_nodo('num_autoriza_factura',$f["num_autoriza_factura"]);//de la cotizacion
			$xml->add_nodo('cod_control_factura',$f["cod_control_factura"]);//de la cotizacion
			$xml->add_nodo('fecha_factura',$f["fecha_factura"]);//de la cotizacion
			$xml->add_nodo('multas',$f["multas"]);//de la cotizacion
			$xml->add_nodo('cantidad_entregada',$f["cantidad_entregada"]);//1 si la cantidad_entregada=cantidad_adjudicada
			$xml->add_nodo('tipo_adq',$f["tipo_adq"]);//tipo_adq
			
			$xml->add_nodo('monto_original',$f["monto_original"]);//monto_original
			$xml->add_nodo('retencion_bien',$f["retencion_bien"]);//retencion_bien
			$xml->add_nodo('retencion_servicio',$f["retencion_servicio"]);//retencion_servicio
			$xml->add_nodo('id_gestion',$f["id_gestion"]);
			$xml->add_nodo('gestion',$f["gestion"]);
			$xml->add_nodo('obs_conta',$f["obs_conta"]);
			//RAC: aumentado estos campos
			$xml->add_nodo('tipo_plantilla',$f["tipo_plantilla"]);//tipo_plantilla
			$xml->add_nodo('desc_plantilla',$f["desc_plantilla"]);//dec_plantilla
			$xml->add_nodo('id_cuenta_doc',$f["id_cuenta_doc"]);
			$xml->add_nodo('motivo',$f["motivo"]);
			$xml->add_nodo('por_anticipo',$f["por_anticipo"]);
			$xml->add_nodo('por_retgar',$f["por_retgar"]);
			$xml->add_nodo('retencion',$f["retencion"]);
			$xml->add_nodo('monto_no_pagado',$f["monto_no_pagado"]);
			$xml->add_nodo('fecha_devengado',$f["fecha_devengado"]);
			$xml->add_nodo('pago_integrado',$f["pago_integrado"]);
			$xml->add_nodo('id_comprobante',$f["id_comprobante"]);
			$xml->add_nodo('descuentos',$f["descuentos"]);
			$xml->add_nodo('obs_descuentos',$f["obs_descuentos"]);
			$xml->add_nodo('fk_id_plan_pago',$f["fk_id_plan_pago"]);
			$xml->add_nodo('id_devengado',$f["id_devengado"]);
			$xml->add_nodo('id_comprobante_pago',$f["id_comprobante_pago"]);
			$xml->add_nodo('id_planilla',$f["id_planilla"]);
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