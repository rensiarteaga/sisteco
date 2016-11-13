<?php
/**
* Nombre de archivo:	    ActionListaActivoFijo.php
* Propósito:				Permite desplegar los regitros de los Activos Fijos
* Tabla:					taf_activo_fijo
* Parámetros:
* Valores de Retorno:   	Listado de los Activos Fijos, y el total de registros listados
* Autor:					Rodrigo Chumacero Moscoso
* Fecha de Creación:		12-06-2007
*/

session_start();

include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionListaActivoFijo.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	//Parámetros del filtro
	if($limit == "") $cant = 15;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

	if($sort == "") $sortcol = 'AF.id_activo_fijo';
	//if($sort == "") $sortcol = 'AF.codigo';
	else $sortcol = $sort;

	if($dir == "") $sortdir = 'desc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> "si", "no"
	switch ($cod)
	{
		case "si":
			$decodificar = true;
			break;
		case "no":
			$decodificar = false;
			break;
		default:
			$decodificar = true;
			break;
	}

	if(sizeof($_GET)>0 )
	{
		$get = true;
	}
	else
	{
		$get = false;
	}
	if(sizeof($_POST)>0 )
	{
		$post = true;
	}
	else
	{
		$post = false;
	}
	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=="") $CantFiltros = 0;
	//echo $_GET["filterValue_0"];
	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	/*echo 'FiltroAvanzado:'.$_GET["filterAvanzado_0"];
	echo 'FiltroAvanzado:'.$_POST["filterAvanzado_0"];
	exit;*/

	for($i=0;$i<$CantFiltros;$i++)
	{ if($get)
	{	//Si encuenta responsable para el filtro lo reemplaza por nombre, apellido_paterno y apellido_materno
		$aux=str_replace('responsable','EMP.nombre#EMP.apellido_paterno#EMP.apellido_materno',$_GET["filterCol_$i"]);
		$cond->add_condicion_filtro($_GET["filterCol_$i"], $_GET["filterValue_$i"], $_GET["filterAvanzado_$i"]);
	}
	if($post)
	{	//Si encuenta responsable para el filtro lo reemplaza por nombre, apellido_paterno y apellido_materno
		$aux=str_replace('responsable','EMP.nombre#EMP.apellido_paterno#EMP.apellido_materno',$_POST["filterCol_$i"]);
		$cond->add_condicion_filtro($aux, $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	}

	/*****************************************/
	/*if($estado_activo != "" || $estado_activo != undefined|| $estado_activo!= null)
	{$cond->add_criterio_extra('AF.estado',"''$estado_activo''");
	}
	/*****************************************/
	if($maestro_id_tipo_activo!="" || $maestro_id_tipo_activo!= "undefined" || $maestro_id_tipo_activo != "null"){
		$cond->add_criterio_extra("TIP.id_tipo_activo",$maestro_id_tipo_activo);
	}
	$criterio_filtro = $cond->obtener_criterio_filtro();

	if($maestro_id_sub_tipo_activo!="" || $maestro_id_sub_tipo_activo!= "undefined" || $maestro_id_sub_tipo_activo != "null"){
		$cond->add_criterio_extra("SUB.id_sub_tipo_activo",$maestro_id_sub_tipo_activo);
	}
	$criterio_filtro = $cond->obtener_criterio_filtro();
	/*echo $criterio_filtro;
	exit;*/

	if($estado_activo!=''){
		$criterio_filtro=$criterio_filtro. "AND AF.estado not in (''en_proceso'')";
		if(Trim($estado_activo)=='ALTA'){
			$criterio_filtro=$criterio_filtro. " AND AF.estado in (''codificado'')";
		}else{
			$criterio_filtro=$criterio_filtro. " AND AF.estado in (''alta'')";
		}
	}
	
	if($id_ppto!=''){//para vista de grupo_proceso
		$criterio_filtro=$criterio_filtro." AND afep.id_presupuesto=$id_ppto";
	}
	if($id_depto!=''){//para vista de grupo_proceso
		$criterio_filtro=$criterio_filtro." AND DEPO.id_depto_af=$id_depto";
	}
	if($asignado=='si'){//para vista de grupo_proceso
		$criterio_filtro=$criterio_filtro." AND AFEMP.id_empleado is not null";
	}
	if($asignado=='no'){
		$criterio_filtro=$criterio_filtro." AND AFEMP.id_deposito is not null";
	}
	if(isset($tipo_af_bien) && $tipo_af_bien!=''){
		$criterio_filtro=$criterio_filtro." AND AF.tipo_af_bien=''$tipo_af_bien''";
	}
	/*echo $criterio_filtro;
	exit;*/
	//Obtiene el total de los registros
	$res = $Custom->ContarListaActivoFijo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarActivoFijo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res)
	{	$xml = new cls_manejo_xml('ROOT');
	$xml->add_nodo('TotalCount',$total_registros);
	//Verifica si el xml será para llenar un combo o no
	if($origen == 'filtro'){
		$xml->add_rama('ROWS');
		$xml->add_nodo('id_activo_fijo', '%');
		$xml->add_nodo('codigo', 'Todos los Activos Fijos');
		$xml->add_nodo('descripcion', 'Todos los Activos Fijos');
		$xml->add_nodo('descripcion_larga', '');
		$xml->add_nodo('vida_util_original', '');
		$xml->add_nodo('vida_util_restante', '');
		$xml->add_nodo('tasa_depreciacion', '');
		$xml->add_nodo('fecha_ultima_deprec', '');
		$xml->add_nodo('depreciacion_acum_ant', '');
		$xml->add_nodo('depreciacion_acum', '');
		$xml->add_nodo('depreciacion_periodo', '');
		$xml->add_nodo('flag_revaloriz', '');
		$xml->add_nodo('valor_rescate', '');
		$xml->add_nodo('fecha_compra', '');
		$xml->add_nodo('monto_compra_mon_orig', '');
		$xml->add_nodo('monto_compra', '');
		$xml->add_nodo('monto_actual', '');
		$xml->add_nodo('con_garantia', '');
		$xml->add_nodo('num_poliza_garantia', '');
		$xml->add_nodo('fecha_fin_gar', '');
		$xml->add_nodo('fecha_reg', '');
		$xml->add_nodo('foto_activo', '');
		$xml->add_nodo('num_factura', '');
		$xml->add_nodo('tipo_cambio', '');
		$xml->add_nodo('estado', '');
		$xml->add_nodo('observaciones', '');
		$xml->add_nodo('id_sub_tipo_activo', '');
		$xml->add_nodo('id_institucion', '');
		$xml->add_nodo('id_moneda', '');
		$xml->add_nodo('id_moneda_original', '');
		$xml->add_nodo('id_unidad_constructiva', '');
		$xml->add_nodo('desc_tipo_activo', '');
		$xml->add_nodo('desc_sub_tipo_activo', '');
		$xml->add_nodo('desc_unidad_constructiva', '');
		$xml->add_nodo('id_tipo_activo', '');
		$xml->add_nodo('nombre_moneda', '');
		$xml->add_nodo('nombre_moneda_orig', '');
		$xml->add_nodo('simbolo_moneda', '');
		$xml->add_nodo('simbolo_moneda_orig', '');
		$xml->add_nodo('nombre_institucion', '');
		$xml->add_nodo('fecha_ini_dep', '');
		$xml->add_nodo('ubicacion_fisica', '');
		$xml->add_nodo('orden_compra', '');
		$xml->add_nodo('responsable', '');
		$xml->add_nodo('id_estado_funcional', '');
		$xml->add_nodo('desc_estado_funcional', '');
		$xml->add_nodo('monto_compra_2', '');
		$xml->add_nodo('monto_actual_2', '');
		$xml->add_nodo('depreciacion_acum_2', '');
		$xml->add_nodo('depreciacion_acum_ant_2', '');
		$xml->add_nodo('depreciacion_periodo_2', '');
		$xml->add_nodo('vida_util_2', '');
		$xml->add_nodo('vida_util_restante_2', '');
		$xml->add_nodo('fecha_alta', '');
		$xml->add_nodo('id_deposito','');
		$xml->add_nodo('nombre_deposito','');
		$xml->add_nodo('tipo_af_bien', '');
		$xml->add_nodo('proyecto', '');
		$xml->fin_rama();
	}

	foreach ($Custom->salida as $f)
	{	$xml->add_rama('ROWS');
	$xml->add_nodo('id_activo_fijo', $f["id_activo_fijo"]);
	$xml->add_nodo('codigo', $f["codigo"]);
	
	
	$xml->add_nodo('descripcion', $f["descripcion"]);
	
	$xml->add_nodo('descripcion_larga', $f["descripcion_larga"]);
	$xml->add_nodo('vida_util_original', $f["vida_util_original"]);
	$xml->add_nodo('vida_util_restante', $f["vida_util_restante"]);
	$xml->add_nodo('tasa_depreciacion', $f["tasa_depreciacion"]);
	$xml->add_nodo('fecha_ultima_deprec', $f["fecha_ultima_deprec"]);
	$xml->add_nodo('depreciacion_acum_ant', $f["depreciacion_acum_ant"]);
	$xml->add_nodo('depreciacion_acum', $f["depreciacion_acum"]);
	$xml->add_nodo('depreciacion_periodo', $f["depreciacion_periodo"]);
	$xml->add_nodo('flag_revaloriz', $f["flag_revaloriz"]);
	$xml->add_nodo('valor_rescate', $f["valor_rescate"]);
	$xml->add_nodo('fecha_compra', $f["fecha_compra"]);
	$xml->add_nodo('monto_compra_mon_orig', $f["monto_compra_mon_orig"]);
	$xml->add_nodo('monto_compra', $f["monto_compra"]);
	$xml->add_nodo('monto_actual', $f["monto_actual"]);
	$xml->add_nodo('con_garantia', $f["con_garantia"]);
	$xml->add_nodo('num_poliza_garantia', $f["num_poliza_garantia"]);
	$xml->add_nodo('fecha_fin_gar', $f["fecha_fin_gar"]);
	$xml->add_nodo('fecha_reg', $f["fecha_reg"]);
	$xml->add_nodo('foto_activo', $f["foto_activo"]);
	$xml->add_nodo('num_factura', $f["num_factura"]);
	$xml->add_nodo('tipo_cambio', $f["tipo_cambio"]);
	$xml->add_nodo('estado', $f["estado"]);
	$xml->add_nodo('observaciones', $f["observaciones"]);
	$xml->add_nodo('id_sub_tipo_activo', $f["id_sub_tipo_activo"]);
	$xml->add_nodo('id_institucion', $f["id_institucion"]);
	$xml->add_nodo('id_moneda', $f["id_moneda"]);
	$xml->add_nodo('id_moneda_original', $f["id_moneda_original"]);
	$xml->add_nodo('id_unidad_constructiva', $f["id_unidad_constructiva"]);
	$xml->add_nodo('desc_tipo_activo', $f["desc_tipo_activo"]);
	$xml->add_nodo('desc_sub_tipo_activo', $f["desc_sub_tipo_activo"]);
	$xml->add_nodo('desc_unidad_constructiva', $f["desc_unidad_constructiva"]);
	$xml->add_nodo('id_tipo_activo', $f["id_tipo_activo"]);
	$xml->add_nodo('nombre_moneda', $f["nombre_moneda"]);
	$xml->add_nodo('nombre_moneda_orig', $f["nombre_moneda_orig"]);
	$xml->add_nodo('simbolo_moneda', $f["simbolo_moneda"]);
	$xml->add_nodo('simbolo_moneda_orig', $f["simbolo_moneda_orig"]);
	$xml->add_nodo('nombre_institucion', $f["nombre_institucion"]);
	$xml->add_nodo('fecha_ini_dep', $f["fecha_ini_dep"]);
	$xml->add_nodo('ubicacion_fisica', $f["ubicacion_fisica"]);
	$xml->add_nodo('orden_compra', $f["orden_compra"]);
	$xml->add_nodo('responsable', $f["responsable"]);
	$xml->add_nodo('id_estado_funcional', $f["id_estado_funcional"]);
	$xml->add_nodo('desc_estado_funcional', $f["desc_estado_funcional"]);
	$xml->add_nodo('monto_compra_2', $f["monto_compra_2"]);
	$xml->add_nodo('monto_actual_2', $f["monto_actual_2"]);
	$xml->add_nodo('depreciacion_acum_2', $f["depreciacion_acum_2"]);
	$xml->add_nodo('depreciacion_acum_ant_2', $f["depreciacion_acum_ant_2"]);
	$xml->add_nodo('depreciacion_periodo_2', $f["depreciacion_periodo_2"]);
	$xml->add_nodo('vida_util_2', $f["vida_util_2"]);	
	$xml->add_nodo('vida_util_restante_2', $f["vida_util_restante_2"]);	
	$xml->add_nodo('fecha_alta', $f["fecha_alta"]);	
	
	$xml->add_nodo('origen', $f["origen"]);
	$xml->add_nodo('id_depto', $f["id_depto"]);	
	$xml->add_nodo('desc_depto', $f["desc_depto"]);	
	$xml->add_nodo('id_cotizacion', $f["id_cotizacion"]);	
	if($f['id_cotizacion_det']!=''){
	$xml->add_nodo('desc_cotizacion',$f["orden_compra"].' - '.$f["desc_cotizacion"]);	}
	else{
		$xml->add_nodo('desc_cotizacion',$f["orden_compra"]);
	}
	$xml->add_nodo('id_cotizacion_det', $f["id_cotizacion_det"]);	
	$xml->add_nodo('desc_cotdet', $f["desc_cotdet"]);	
	
	$xml->add_nodo('id_ep', $f["id_ep"]);
	$xml->add_nodo('desc_ep', $f["desc_ep"]);
	$xml->add_nodo('id_unidad_organizacional', $f["id_unidad_organizacional"]);
	$xml->add_nodo('desc_unidad_organizacional', $f["desc_unidad_organizacional"]);
		
	
//	$xml->add_nodo('codigo_financiador', $f["codigo_financiador"]);
//	$xml->add_nodo('codigo_regional', $f["codigo_regional"]);
//	$xml->add_nodo('codigo_programa', $f["codigo_programa"]);
//	$xml->add_nodo('codigo_proyecto', $f["codigo_proyecto"]);
//	$xml->add_nodo('codigo_actividad', $f["codigo_actividad"]);
	
	if($f["id_cta_soldet"]==0){
		$xml->add_nodo('id_cta_soldet', '');
		$xml->add_nodo('cta_soldet', '');
	}else{
		$xml->add_nodo('id_cta_soldet', $f["id_cta_soldet"]);
		$xml->add_nodo('cta_soldet', $f["cta_soldet"]);
	}
	if($f["id_aux_soldet"]==0){
		$xml->add_nodo('id_aux_soldet', '');
		$xml->add_nodo('aux_soldet', '');
	}else{
		$xml->add_nodo('id_aux_soldet', $f["id_aux_soldet"]);
		$xml->add_nodo('aux_soldet', $f["aux_soldet"]);
	}
	
	$xml->add_nodo('id_lugar', $f["id_lugar"]);
	$xml->add_nodo('desc_lugar', $f["desc_lugar"]);
	$xml->add_nodo('id_ppto', $f["id_ppto"]);
	$xml->add_nodo('tipo_ppto', $f["tipo_ppto"]);
	$xml->add_nodo('id_gestion', $f["id_gestion"]);
	$xml->add_nodo('gestion', $f["gestion"]);
	$xml->add_nodo('desc_presupuesto', $f["desc_presupuesto"]);
	
	$xml->add_nodo('id_cta_proceso', $f["id_cta_proceso"]);
	$xml->add_nodo('id_aux_proceso', $f["id_aux_proceso"]);
	
	$xml->add_nodo('cta_proceso', $f["cta_proceso"]);
	$xml->add_nodo('aux_proceso', $f["aux_proceso"]);
	
	$xml->add_nodo('monto_proceso', $f["monto_proceso"]);
	$xml->add_nodo('vida_proceso', $f["vida_proceso"]);
	
	$xml->add_nodo('id_solicitud_compra', $f["id_solicitud_compra"]);
	$xml->add_nodo('clonacion', $f["clonacion"]);
	$xml->add_nodo('id_deposito', $f["id_deposito"]);
	$xml->add_nodo('nombre_deposito', $f["nombre_deposito"]);
	$xml->add_nodo('tipo_af_bien', $f["tipo_af_bien"]);
	$xml->add_nodo('proyecto', $f["proyecto"]);
	
	$xml->fin_rama();
	}
	//$xml->add_nodo('query',$Custom->query);
	$xml->mostrar_xml();
	/*header('HTTP/1.0 200 OK');
	header('Content-Type:text/xml');
	echo $xml -> cadena_xml();*/
	exit;
	}
	else
	{
		//Se produjo un error
		//$resp = new cls_manejo_mensajes(true, "503");
		$resp = new cls_manejo_mensajes(true, "406");
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
	$resp->mensaje_error = 'Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;

}?>
