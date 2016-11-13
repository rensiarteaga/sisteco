<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarSeguimientoSolicitud.php
Propósito:				Permite realizar el listado en tad_solicitud_compra
Tabla:					t_tad_solicitud_compra
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-15 19:39:23
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionListarSeguimientoSolicitud .php';

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

	if($sort == ''){ $sortcol = "id_solicitud_compra DESC " ;}
	elseif($sort=='numeracion_periodo')$sortcol="periodo $dir,num_solicitud $dir ";
	else $sortcol = "$sort $dir";

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
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	
	if($filtro){
		$criterio_filtro=$criterio_filtro." AND ".$filtro;
	}
	
	if($m_id_solicitud_compra>0){
		$criterio_filtro=$criterio_filtro." AND SEGSOL.id_solicitud_compra=$m_id_solicitud_compra";
	}

	if($bien==1){
		$criterio_filtro=$criterio_filtro." AND SEGSOL.id_tipo_adq=4 ";
	}
	if($bien==2){
		
		$criterio_filtro=$criterio_filtro." AND SEGSOL.id_tipo_adq!=4 ";
		
	}	
	
	
	if($tipo=='historico'){
	    $criterio_filtro=$criterio_filtro. " AND ESTCOM.nombre!=''borrador'' AND ESTCOM.nombre!=''pendiente_pre_aprobacion'' ";
	}
//echo $sortcol;
//exit;
	//Obtiene el total de los registros
	$res = $Custom -> ContarSeguimientoSolicitud($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$vista);

	if($res) $total_registros= $Custom->salida;
	
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarSeguimientoSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$vista);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_solicitud_compra',$f["id_solicitud_compra"]);
			$xml->add_nodo('observaciones',$f["observaciones"]);
			$xml->add_nodo('localidad',$f["localidad"]);
			$xml->add_nodo('siguiente_estado',$f["siguiente_estado"]);
			$xml->add_nodo('tipo_adjudicacion',$f["tipo_adjudicacion"]);
			$xml->add_nodo('id_tipo_categoria_adq',$f["id_tipo_categoria_adq"]);
			$xml->add_nodo('desc_tipo_categoria_adq',$f["desc_tipo_categoria_adq"]);
			$xml->add_nodo('id_empleado_frppa_solicitante',$f["id_empleado_frppa_solicitante"]);
			$xml->add_nodo('desc_empleado_tpm_frppa',$f["desc_empleado_tpm_frppa"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
			$xml->add_nodo('id_rpa',$f["id_rpa"]);
			$xml->add_nodo('desc_rpa',$f["desc_rpa"]);
			$xml->add_nodo('id_cuenta',$f["id_cuenta"]);
			$xml->add_nodo('desc_cuenta',$f["desc_cuenta"]);
			$xml->add_nodo('id_unidad_organizacional',$f["id_unidad_organizacional"]);
			$xml->add_nodo('desc_unidad_organizacional',$f["desc_unidad_organizacional"]);

			$xml->add_nodo('id_financiador',$f["id_financiador"]);
			$xml->add_nodo('id_regional',$f["id_regional"]);
			$xml->add_nodo('id_programa',$f["id_programa"]);
			$xml->add_nodo('id_proyecto',$f["id_proyecto"]);
			$xml->add_nodo('id_actividad',$f["id_actividad"]);
			$xml->add_nodo('nombre_financiador',$f["nombre_financiador"]);
			$xml->add_nodo('nombre_regional',$f["nombre_regional"]);
			$xml->add_nodo('nombre_programa',$f["nombre_programa"]);
			$xml->add_nodo('nombre_proyecto',$f["nombre_proyecto"]);
			$xml->add_nodo('nombre_actividad',$f["nombre_actividad"]);
			/*$xml->add_nodo('codigo_financiador',$f["codigo_financiador"]);
			$xml->add_nodo('codigo_regional',$f["codigo_regional"]);
			$xml->add_nodo('codigo_programa',$f["codigo_programa"]);
			$xml->add_nodo('codigo_proyecto',$f["codigo_proyecto"]);
			$xml->add_nodo('codigo_actividad',$f["codigo_actividad"]);*/
			$xml->add_nodo('tipo_adq',$f["tipo_adq"]);
			$xml->add_nodo('num_solicitud',$f["num_solicitud"]);
			$xml->add_nodo('estado',$f["estado"]);
			$xml->add_nodo('reformulacion',$f["reformulacion"]);
			$xml->add_nodo('numeracion_periodo',$f["periodo"]."/".$f["num_solicitud"]);
			$xml->add_nodo('fecha_estado',$f["fecha_estado"]);
			$xml->add_nodo('gestion',$f["gestion"]);
			$xml->add_nodo('tiene_presupuesto',$f["tiene_presupuesto"]);
			$xml->add_nodo('justificacion',$f["justificacion"]);
			
			$xml->add_nodo('dias_max',$f["dias_max"]);
			$xml->add_nodo('dias_min',$f["dias_min"]);
			$xml->add_nodo('dias',$f["dias"]);
			$xml->add_nodo('preaprobador',$f["preaprobador"]);
			$xml->add_nodo('aprobador',$f["aprobador"]);
			$xml->add_nodo('fecha_sol',$f["fecha_sol"]);
			$xml->add_nodo('monto_total',$f["monto_total"]);
			if($f["permite_agrupar"]==1){
			    $xml->add_nodo('permite_agrupar','true');
			}
			else{
			   $xml->add_nodo('permite_agrupar','false');	
			}
			$xml->add_nodo('tiene_suplente',$f["tiene_suplente"]);
			$xml->add_nodo('suplente',$f["suplente"]);
			
			$xml->add_nodo('transcriptor',$f["transcriptor"]);
			$xml->add_nodo('nro_solicitud_cadena',$f["nro_solicitud_cadena"]);
			$xml->add_nodo('id_presupuesto',$f["id_presupuesto"]);
			$xml->add_nodo('desc_presupuesto',$f["desc_presupuesto"]);
			$xml->add_nodo('es_item',$f["es_item"]);
				
			$xml->fin_rama();
		/*
		$xml->add_rama('ROWS');
			$xml->add_nodo('id_solicitud_compra',$f["id_solicitud_compra"]);
			$xml->add_nodo('observaciones',$f["observaciones"]);
			$xml->add_nodo('localidad',$f["localidad"]);
			$xml->add_nodo('siguiente_estado',$f["siguiente_estado"]);
			$xml->add_nodo('tipo_adjudicacion',$f["tipo_adjudicacion"]);
			$xml->add_nodo('id_tipo_categoria_adq',$f["id_tipo_categoria_adq"]);
			$xml->add_nodo('desc_tipo_categoria_adq',$f["desc_tipo_categoria_adq"]);
			$xml->add_nodo('id_empleado_frppa_solicitante',$f["id_empleado_frppa_solicitante"]);
			$xml->add_nodo('desc_empleado_tpm_frppa',$f["desc_empleado_tpm_frppa"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
//			$xml->add_nodo('id_rpa',$f["id_rpa"]);
//			$xml->add_nodo('desc_rpa',$f["desc_rpa"]);
			$xml->add_nodo('id_cuenta',$f["id_cuenta"]);
			$xml->add_nodo('desc_cuenta',$f["desc_cuenta"]);
			$xml->add_nodo('id_unidad_organizacional',$f["id_unidad_organizacional"]);
			$xml->add_nodo('desc_unidad_organizacional',$f["desc_unidad_organizacional"]);

			$xml->add_nodo('id_financiador',$f["id_financiador"]);
			$xml->add_nodo('id_regional',$f["id_regional"]);
			$xml->add_nodo('id_programa',$f["id_programa"]);
			$xml->add_nodo('id_proyecto',$f["id_proyecto"]);
			$xml->add_nodo('id_actividad',$f["id_actividad"]);
			$xml->add_nodo('nombre_financiador',$f["nombre_financiador"]);
			$xml->add_nodo('nombre_regional',$f["nombre_regional"]);
			$xml->add_nodo('nombre_programa',$f["nombre_programa"]);
			$xml->add_nodo('nombre_proyecto',$f["nombre_proyecto"]);
			$xml->add_nodo('nombre_actividad',$f["nombre_actividad"]);
			$xml->add_nodo('codigo_financiador',$f["codigo_financiador"]);
			$xml->add_nodo('codigo_regional',$f["codigo_regional"]);
			$xml->add_nodo('codigo_programa',$f["codigo_programa"]);
			$xml->add_nodo('codigo_proyecto',$f["codigo_proyecto"]);
			$xml->add_nodo('codigo_actividad',$f["codigo_actividad"]);
			$xml->add_nodo('tipo_adq',$f["tipo_adq"]);
			$xml->add_nodo('num_solicitud',$f["num_solicitud"]);
			$xml->add_nodo('estado',$f["estado"]);
			$xml->add_nodo('reformulacion',$f["reformulacion"]);
			$xml->add_nodo('numeracion_periodo',$f["periodo"]."/".$f["num_solicitud"]);
			$xml->add_nodo('fecha_estado',$f["fecha_estado"]);
			$xml->add_nodo('gestion',$f["gestion"]);
			$xml->add_nodo('tiene_presupuesto',$f["tiene_presupuesto"]);
			$xml->add_nodo('justificacion',$f["justificacion"]);
			
			$xml->add_nodo('dias_max',$f["dias_max"]);
			$xml->add_nodo('dias_min',$f["dias_min"]);
			$xml->add_nodo('dias',$f["dias"]);
			$xml->add_nodo('preaprobador',$f["preaprobador"]);
			$xml->add_nodo('aprobador',$f["aprobador"]);
			$xml->add_nodo('fecha_sol',$f["fecha_sol"]);
			$xml->add_nodo('monto_total',$f["monto_total"]);
			if($f["permite_agrupar"]==1){
			    $xml->add_nodo('permite_agrupar','true');
			}
			else{
			   $xml->add_nodo('permite_agrupar','false');	
			}
			$xml->add_nodo('tiene_suplente',$f["tiene_suplente"]);
			$xml->add_nodo('suplente',$f["suplente"]);
			
			$xml->add_nodo('fecha_venc',$f["fecha_venc"]);
			$xml->add_nodo('hora_reg',$f["hora_reg"]);
			$xml->add_nodo('usuario_reg',$f["usuario_reg"]);
			$xml->add_nodo('depto',$f["depto"]);
		*/
		
		
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