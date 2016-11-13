<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarSolicitudCompra.php
Propósito:				Permite realizar el listado en tad_solicitud_compra
Tabla:					t_tad_solicitud_compra
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-12 10:00:28
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionListarSolicitudCompra.php';

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

	if($sort == '') $sortcol = 'id_solicitud_compra';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'desc';
	else $sortdir = $dir;

//	echo $sortcol;
//	echo $sortdir;
//	exit;
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
	if($sort=='numeracion_periodo'){$sortcol="periodo $sortdir,num_solicitud $sortdir";}
	else{$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'periodo');
	$sortcol = $crit_sort->get_criterio_sort();}
    
	
	$res = $Custom -> ContarTotalSolicitudCompra($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_solicitud_compra);

	if($res) //$total_registros= $Custom->salida;
//echo $criterio_filtro;
//exit;

		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',count($Custom->salida));	
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('nombre_categoria',$f["nombre_categoria"]);
			$xml->add_nodo('id_tipo_categoria',$f["id_tipo_categoria"]);
			$xml->add_nodo('doc_respaldo',$f["doc_respaldo"]);
			$xml->add_nodo('monto_total',$f["monto_total"]);
			$xml->add_nodo('correspondencia',$f["correspondencia"]);
			$xml->add_nodo('cambiar_aprobador',$f["cambiar_aprobador"]);
			$xml->add_nodo('diesel',$f["diesel"]);
			//2016
			$xml->add_nodo('correo',$f["correo"]);
			$xml->fin_rama();
		}
		$xml->mostrar_xml();

	//Obtiene el conjunto de datos de la consulta
	/*$res = $Custom->ListarSolicitudCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_empresa);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_solicitud_compra',$f["id_solicitud_compra"]);
			//$xml->add_nodo('desc_solicitud_compra',$f["desc_solicitud_compra"]);
			$xml->add_nodo('precio_total',$f["precio_total"]);
			$xml->add_nodo('observaciones',$f["observaciones"]);
			$xml->add_nodo('fecha_venc',$f["fecha_venc"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('hora_reg',$f["hora_reg"]);//
			$xml->add_nodo('localidad',$f["localidad"]);//
			$xml->add_nodo('num_solicitud',$f["num_solicitud"]);
			$xml->add_nodo('estado_reg',$f["estado_reg"]);
			$xml->add_nodo('estado_vigente_solicitud',$f["estado_vigente_solicitud"]);
			$xml->add_nodo('tipo_adjudicacion',$f["tipo_adjudicacion"]);
			$xml->add_nodo('modalidad',$f["modalidad"]);
			//$xml->add_nodo('id_solicitud_compra_ant',$f["id_solicitud_compra_ant"]);
			$xml->add_nodo('id_tipo_categoria_adq',$f["id_tipo_categoria_adq"]);
			$xml->add_nodo('desc_tipo_categoria_adq',$f["desc_tipo_categoria_adq"]);
			$xml->add_nodo('id_empleado_frppa_solicitante',$f["id_empleado_frppa_solicitante"]);
			$xml->add_nodo('solicitante',$f["solicitante"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
			//$xml->add_nodo('id_rpa',$f["id_rpa"]);
			//$xml->add_nodo('desc_rpa',$f["desc_rpa"]);
			$xml->add_nodo('id_usuario_transcriptor',$f["id_usuario_transcriptor"]);
			$xml->add_nodo('transcriptor',$f["transcriptor"]);
			$xml->add_nodo('id_unidad_organizacional',$f["id_unidad_organizacional"]);
			$xml->add_nodo('desc_unidad_organizacional',$f["desc_unidad_organizacional"]);
			$xml->add_nodo('id_empleado_frppa_pre_aprobacion',$f["id_empleado_frppa_pre_aprobacion"]);
			$xml->add_nodo('encargado_pre_aprobacion',$f["encargado_pre_aprobacion"]);
			$xml->add_nodo('id_empleado_frppa_aprobacion',$f["id_empleado_frppa_aprobacion"]);
			$xml->add_nodo('encargado_aprobacion',$f["encargado_aprobacion"]);
			$xml->add_nodo('id_empleado_frppa_gfa',$f["id_empleado_frppa_gfa"]);
			$xml->add_nodo('gfa',$f["gfa"]);
			//$xml->add_nodo('codigo_sicoes',$f["codigo_sicoes"]);
			//$xml->add_nodo('siguiente_estado',$f["siguiente_estado"]);
			$xml->add_nodo('periodo',$f["periodo"]);
			$xml->add_nodo('gestion',$f["gestion"]);
			//$xml->add_nodo('num_solicitud_sis',$f["num_solicitud_sis"]);
			//$xml->add_nodo('id_frppa',$f["id_frppa"]);
			$xml->add_nodo('id_tipo_adq',$f["id_tipo_adq"]);
			$xml->add_nodo('desc_tipo_adq',$f["desc_tipo_adq"]);
			$xml->add_nodo('tipo_adq',$f["tipo_adq"]);
			$xml->add_nodo('simbolo',$f["simbolo"]);
			//$xml->add_nodo('id_frppa',$f["id_frppa"]);
			$xml->add_nodo('observaciones_estado',$f["observaciones_estado"]);
			//$xml->add_nodo('tipo_cambio',$f["tipo_cambio"]);
			/*$xml->add_nodo('codigo_financiador',$f["codigo_financiador"]);
			$xml->add_nodo('codigo_regional',$f["codigo_regional"]);
			$xml->add_nodo('codigo_programa',$f["codigo_programa"]);
			$xml->add_nodo('codigo_proyecto',$f["codigo_proyecto"]);
			$xml->add_nodo('codigo_actividad',$f["codigo_actividad"]);*/
			/*$xml->add_nodo('id_parametro_adquisicion',$f["id_parametro_adquisicion"]);
			$xml->add_nodo('id_periodo',$f["id_periodo"]);
			$xml->add_nodo('id_moneda_base',$f["id_moneda_base"]);
			
			$xml->add_nodo('nombre_financiador',$f["nombre_financiador"]);
			$xml->add_nodo('nombre_regional',$f["nombre_regional"]);
			$xml->add_nodo('nombre_programa',$f["nombre_programa"]);
			$xml->add_nodo('nombre_proyecto',$f["nombre_proyecto"]);
			$xml->add_nodo('nombre_actividad',$f["nombre_actividad"]);
			
			$xml->add_nodo('id_orden_trabajo',$f["id_orden_trabajo"]);
			$xml->add_nodo('desc_orden',$f["desc_orden"]);
			
			$xml->add_nodo('id_almacen_logico',$f["id_almacen_logico"]);
			$xml->add_nodo('desc_almacen_logico',$f["desc_almacen_logico"]);
			$xml->add_nodo('desc_almacen',$f["desc_almacen"]);
			$xml->add_nodo('id_almacen',$f["id_almacen"]);*/
			
			/*$xml->add_nodo('id_financiador',$f["id_financiador"]);
			$xml->add_nodo('id_regional',$f["id_regional"]);
			$xml->add_nodo('id_programa',$f["id_programa"]);
			$xml->add_nodo('id_proyecto',$f["id_proyecto"]);
			$xml->add_nodo('id_actividad',$f["id_actividad"]);*/
			/*$xml->add_nodo('id_empleado',$f["id_empleado"]);
			$xml->add_nodo('id_uo_gerencia',$f["id_uo_gerencia"]);
			$xml->add_nodo('numeracion_periodo',$f["periodo"]."/".$f["num_solicitud"]);
			$xml->add_nodo('id_ep',$f["id_fina_regi_prog_proy_acti"]);
			$xml->add_nodo('id_depto',$f["id_depto"]);
			$xml->add_nodo('desc_depto',$f["desc_depto"]);
			$xml->add_nodo('proveedores_propuestos',$f["proveedores_propuestos"]);
			$xml->add_nodo('comite_calificacion',$f["comite_calificacion"]);
			$xml->add_nodo('comite_recepcion',$f["comite_recepcion"]);
			$xml->add_nodo('tiene_presupuesto',$f["tiene_presupuesto"]);
			$xml->add_nodo('avance',$f["avance"]);
			$xml->add_nodo('id_avance',$f["id_avance"]);
			$xml->add_nodo('nro_avance',$f["nro_avance"]);
			$xml->add_nodo('id_correspondencia',$f["id_correspondencia"]);
			$xml->add_nodo('correspondencia_asociada',$f["correspondencia_asociada"]);
			$xml->add_nodo('id_presupuesto',$f["id_presupuesto"]);
			$xml->add_nodo('desc_presupuesto',$f["desc_presupuesto"]);*/
			//$xml->add_nodo('tipo_presu',$f["tipo_presu"]);
			/*$xml->fin_rama();
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
	}*/
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