<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCotizacion.php
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
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionListarCotizacion .php';

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
	
	
	if($m_id_proceso_compra>0){
		$cond->add_criterio_extra("COTIZA.id_proceso_compra",$m_id_proceso_compra);
	}
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	if ($m_tipo!=1){
       $criterio_filtro=$criterio_filtro." AND COTIZA.estado_vigente!=''finalizado'' AND COTIZA.estado_vigente!=''anulado''";		
	}else {// usado en pantalla de procesos finalizados
		 $criterio_filtro=$criterio_filtro." AND COTIZA.estado_vigente=''finalizado''";		
	}	
	if($estado_vigente!=''){
	    $criterio_filtro=$criterio_filtro." AND (COTIZA.estado_vigente=''invitado'' or COTIZA.estado_vigente=''aperturado'')";
	}
	if($adjudicacion!=''){ //para la orden de compra==> lista solo cotizaciones que ya hayan sido adjudicadas
		//$criterio_filtro=$criterio_filtro. " AND (COTIZA.id_cotizacion in (select distinct id_cotizacion from compro.tad_cotizacion_det where estado=''adjudicado'')     OR COTIZA.id_cotizacion in (select distinct id_cotizacion from tad_cotizacion_det where estado=''cotizado'' and id_cotizacion_det in (select distinct id_cotizacion_det from tad_adjudicacion))";
		
		$criterio_filtro=$criterio_filtro. " AND (COTIZA.id_cotizacion in (select distinct id_cotizacion from compro.tad_cotizacion_det where estado=''adjudicado'' OR COTIZA.estado_vigente=''adjudicado'' OR COTIZA.estado_vigente=''orden_compra'' OR COTIZA.estado_vigente=''en_pago'' OR COTIZA.estado_vigente=''formulacion_pp''))";
	}
	
	
	if($proceso_adjudicacion=='si'){
		$criterio_filtro=$criterio_filtro." AND COTIZA.estado_vigente=''cotizado'' and COTIZA.estado_vigente!=''anulado'' and COTIZA.estado_vigente!=''finalizado''";
	}
	
	if($proceso_adj=='si'){//AND COTIZA.estado_vigente=''cotizado''  // era para listar solo las cotizaciones para las que se sacó resolucion de adjudicaion
		$criterio_filtro=$criterio_filtro." AND COTIZA.estado_vigente=''cotizado''";
	}
	if($id_cotizacion>0){//para el html del detalle de cotizacion
		$criterio_filtro=$criterio_filtro." AND COTIZA.id_cotizacion=''$id_cotizacion''";
	}
	
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
	$res = $Custom -> ContarCotizacion($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_cotizacion',$f["id_cotizacion"]);
			$xml->add_nodo('fecha_venc',$f["fecha_venc"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			
			
			$xml->add_nodo('garantia',$f["garantia"]);
			$xml->add_nodo('lugar_entrega',$f["lugar_entrega"]);
			$xml->add_nodo('forma_pago',$f["forma_pago"]);
			$xml->add_nodo('tiempo_validez_oferta',$f["tiempo_validez_oferta"]);
			$xml->add_nodo('fecha_entrega',$f["fecha_entrega"]);
			//$xml->add_nodo('fecha_limite',$f["fecha_limite"]);
			$xml->add_nodo('tipo_entrega',$f["tipo_entrega"]);
			$xml->add_nodo('observaciones',$f["observaciones"]);
			$xml->add_nodo('id_proceso_compra',$f["id_proceso_compra"]);
			//$xml->add_nodo('desc_proceso_compra',$f["desc_proceso_compra"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
			$xml->add_nodo('id_proveedor',$f["id_proveedor"]);
			$xml->add_nodo('desc_proveedor',$f["desc_proveedor"]);
			$xml->add_nodo('id_tipo_categoria_adq',$f["id_tipo_categoria_adq"]);
			//$xml->add_nodo('desc_tipo_categoria_adq',$f["desc_tipo_categoria_adq"]);
			$xml->add_nodo('precio_total',$f["precio_total"]);
			
			if($f["figura_acta"]=='si'){
			    $xml->add_nodo('figura_acta',"true");	
			}else{
				$xml->add_nodo('figura_acta',"false");
			}
			
			$xml->add_nodo('num_factura',$f["num_factura"]);
			$xml->add_nodo('num_orden_compra',$f["num_orden_compra"]);
			$xml->add_nodo('estado_vigente',$f["estado_vigente"]);
			$xml->add_nodo('estado_reg',$f["estado_reg"]);
			$xml->add_nodo('nombre_pago',$f["nombre_pago"]);
			$xml->add_nodo('siguiente_estado',$f["siguiente_estado"]);
			$xml->add_nodo('periodo',$f["periodo"]);
			$xml->add_nodo('gestion',$f["gestion"]);
			//$xml->add_nodo('num_orden_compra_sis',$f["num_orden_compra_sis"]);
			$xml->add_nodo('num_cotizacion',$f["num_cotizacion"]);
			$xml->add_nodo('fecha_orden_compra',$f["fecha_orden_compra"]);
			
			$xml->add_nodo('direccion_proveedor',$f["direccion_proveedor"]);
			$xml->add_nodo('mail_proveedor',$f["mail_proveedor"]);
			$xml->add_nodo('telefono1_proveedor',$f["telefono1_proveedor"]);
			$xml->add_nodo('telefono2_proveedor',$f["telefono2_proveedor"]);
			$xml->add_nodo('fax_proveedor',$f["fax_proveedor"]);
			$xml->add_nodo('fecha_cotizacion',$f["fecha_cotizacion"]);
			$xml->add_nodo('categoria',$f["categoria"]);
			$xml->add_nodo('num_pagos',$f["num_pagos"]);
			$xml->add_nodo('precio_total_moneda_cotizada',$f["precio_total_moneda_cotizada"]);
			$xml->add_nodo('num_detalle_cotizado',$f["num_detalle_cotizado"]);
			$xml->add_nodo('todo_pagado',$f["todo_pagado"]); //1 si ya se completó los pagos de la cotizacion
			//$xml->add_nodo('falta_anular',$f["falta_anular"]); //1 si falta anular los pagos para revertir OC
			$xml->add_nodo('id_moneda_base',$f["id_moneda_base"]); //para los detalles
			//$xml->add_nodo('num_detalle_cotizado_gral',$f["num_detalle_cotizado_gral"]);
			$xml->add_nodo('num_detalle_adjudicado_gral',$f["num_detalle_adjudicado_gral"]);
			$xml->add_nodo('precio_total_adjudicado',$f["precio_total_adjudicado"]);
			if($f["se_adjudica"]=='si'){
			    $xml->add_nodo('se_adjudica',"true");	
			}else{
				$xml->add_nodo('se_adjudica',"false");
			}
			$xml->add_nodo('num_detalle_adjudicado',$f["num_detalle_adjudicado"]);
			$xml->add_nodo('id_auxiliar',$f["id_auxiliar"]);
			//$xml->add_nodo('pago_completado',$f["pago_completado"]);
			$xml->add_nodo('cantidad_sol',$f["cantidad_sol"]);
			//$xml->add_nodo('cant_se_adjudica',$f["cant_se_adjudica"]);
			
			$xml->add_nodo('factura_total',$f["factura_total"]);
			//$xml->add_nodo('num_autoriza_factura',$f["num_autoriza_factura"]);
			//$xml->add_nodo('cod_control_factura',$f["cod_control_factura"]);
			$xml->add_nodo('fecha_factura',$f["fecha_factura"]);
            $xml->add_nodo('precio_total_adjudicado_con_impuestos',$f["precio_total_adjudicado_con_impuestos"]);					
            $xml->add_nodo('tipo_documento',$f["tipo_documento"]);	
            $xml->add_nodo('desc_documento',$f["desc_documento"]);	
            $xml->add_nodo('falta_adjudicar',$f["falta_adjudicar"]);				
			$xml->add_nodo('numeracion_periodo',$f["periodo"]."/".$f["num_cotizacion"]); //para el grid
			$xml->add_nodo('numeracion_oc',$f["periodo"]."/".$f["num_orden_compra"]); //para el grid
			$xml->add_nodo('id_empleado_adjudicacion',$f["id_empleado_adjudicacion"]);
			$xml->add_nodo('empleado_adjudicacion',$f["empleado_adjudicacion"]);
			$xml->add_nodo('justificacion_adjudicacion',$f["justificacion_adjudicacion"]);
			$xml->add_nodo('id_caja',$f["id_caja"]);
			$xml->add_nodo('caja',$f["caja"]);
			$xml->add_nodo('id_cajero',$f["id_cajero"]);
			$xml->add_nodo('cajero',$f["cajero"]);
			$xml->add_nodo('tipo_pago',$f["tipo_pago"]);
			$xml->add_nodo('avance',$f["avance"]);
			$xml->add_nodo('id_depto_tesoro',$f["id_depto_tesoro"]);
			$xml->add_nodo('depto_tesoro',$f["depto_tesoro"]);
			$xml->add_nodo('cant_pagos_def',$f["cant_pagos_def"]);
			$xml->add_nodo('habilita_otra_gestion',$f["habilita_otra_gestion"]);
			$xml->add_nodo('por_adelanto',$f["por_adelanto"]);
			$xml->add_nodo('por_retgar',$f["por_retgar"]);
			$xml->add_nodo('estado_adelanto',$f["estado_adelanto"]);
			$xml->add_nodo('estado_retgar',$f["estado_retgar"]);
			$xml->add_nodo('avance_habilitado',$f["avance_habilitado"]);
			$xml->add_nodo('nro_contrato',$f["nro_contrato"]);
			$xml->add_nodo('tiene_contrato',$f["tiene_contrato"]);
			$xml->add_nodo('monto_adelanto',$f["monto_adelanto"]);
			$xml->add_nodo('monto_adelanto_moneda_cotizada',$f["monto_adelanto_moneda_cotizada"]);
			$xml->add_nodo('total_cotizado',$f["total_cotizado"]);
			
			$xml->add_nodo('con_contrato',$f["con_contrato"]);
			$xml->add_nodo('total_aa',$f["total_aa"]);
			$xml->add_nodo('total_as',$f["total_as"]);
			$xml->add_nodo('total_dcto_anticipo',$f["total_dcto_anticipo"]);
			$xml->add_nodo('fecha_ini_ctto',$f["fecha_ini_ctto"]);
			$xml->add_nodo('fecha_fin_ctto',$f["fecha_fin_ctto"]);
			$xml->add_nodo('hora_reg',$f["hora_reg"]);
			$xml->add_nodo('usuario_reg',$f["usuario_reg"]);
			$xml->add_nodo('estado_devengado',$f["estado_devengado"]);
			$xml->add_nodo('fecha_adjudicacion',$f["fecha_adjudicacion"]);
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