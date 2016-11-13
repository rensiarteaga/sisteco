<?php
/*
**********************************************************
Nombre de archivo:	    ActionListaActivoFijoGrupoProceso.php
Propósito:				Permite desplegar los ActivoFijoProceso registrados
Tabla:					taf_activo_fijo_proceso
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro
						$id_usuario_asignacion

Valores de Retorno:    	Listado de ActivoFijoProceso
Fecha de Creación:		09-07-2010
Versión:				1.0.0
Autor:					Mercedes Zambrana Meneses
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo='ActionListaActivoFijoGrupoProceso.php';

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

	if($sort == "") $sortcol = 'id_activo_fijo_proceso';
	else $sortcol = $sort;

	if($dir == "") $sortdir = 'asc';
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
	
	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=="") $CantFiltros = 0;
	
	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	//Obtiene el criterio del filtro
	$criterio_filtro = $cond->obtener_criterio_filtro();
	
	if($id_grupo_proceso>0){
		$criterio_filtro=$criterio_filtro. " AND afp.id_grupo_proceso=$id_grupo_proceso";
	}
	$res = $Custom->ContarActivoFijoGrupoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	if($res)
	{
		$total_registros= $Custom->salida;
	}
	
	//Obtiene el conjunto de datos de la consulta
	
	$res = $Custom->ListarActivoFijoGrupoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);

	if($res)
	{	
		
		// PREPARA EL ARCHIVO XML
		$xml= new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		foreach ($Custom->salida as $f)
		{ 
		    $xml->add_rama('ROWS');
		    $xml->add_nodo('id_activo_fijo_proceso',$f["id_activo_fijo_proceso"]);
		    $xml->add_nodo('monto_vigente_anterior',$f["monto_vigente_anterior"]);
		    $xml->add_nodo('monto_vigente_actual',$f["monto_vigente_actual"]);
		    $xml->add_nodo('vida_util_anterior',$f["vida_util_anterior"]);
		    $xml->add_nodo('vida_util_actual',$f["vida_util_actual"]);
		    $xml->add_nodo('fecha_reg',$f["fecha_reg"]);
		    $xml->add_nodo('estado',$f["estado"]);
		    $xml->add_nodo('id_activo_fijo',$f["id_activo_fijo"]);
		    $xml->add_nodo('desc_activo_fijo',$f["desc_activo_fijo"]);
		    $xml->add_nodo('id_proceso',$f["id_proceso"]);
		     $xml->add_nodo('codigo_proceso', $f["codigo_proceso"]);
		    $xml->add_nodo('desc_proceso', $f["desc_proceso"]);
		    $xml->add_nodo('id_motivo',$f["id_motivo"]);
 			$xml->add_nodo('desc_motivo', $f["desc_motivo"]);
		    $xml->add_nodo('aplicado', $f["aplicado"]);
		    $xml->add_nodo('fecha_aprobacion',$f["fecha_aprobacion"]);
		    $xml->add_nodo('fecha_aplicacion',$f["fecha_aplicacion"]);
		    $xml->add_nodo('descripcion', $f["descripcion"]);
		    $xml->add_nodo('documentacion', $f["documentacion"]);
		    
		    $xml->add_nodo('fecha_proceso', $f["fecha_proceso"]);
		    $xml->add_nodo('id_fina_regi_prog_proy_acti', $f["id_fina_regi_prog_proy_acti"]);
		    $xml->add_nodo('desc_ep', $f["desc_ep"]);
		    $xml->add_nodo('id_unidad_organizacional', $f["id_unidad_organizacional"]);
		    $xml->add_nodo('desc_uo', $f["desc_uo"]);
		    $xml->add_nodo('id_cuenta_org', $f["id_cuenta_org"]);
		    $xml->add_nodo('nro_cta_org', $f["codigo_cta_org"]);
		    $xml->add_nodo('nombre_cta_org', $f["nombre_cta_org"]);
		    $xml->add_nodo('id_auxiliar_org', $f["id_auxiliar_org"]);
		    $xml->add_nodo('codigo_aux_org', $f["codigo_aux_org"]);
		    $xml->add_nodo('nombre_aux_org', $f["nombre_aux_org"]);
		    $xml->add_nodo('id_cuenta_des', $f["id_cuenta_des"]);
		    
		    $xml->add_nodo('nro_cta_des', $f["nro_cta_des"]);
		    $xml->add_nodo('nombre_cta_des', $f["nombre_cta_des"]);
		    $xml->add_nodo('id_auxiliar_des', $f["id_auxiliar_des"]);
		    $xml->add_nodo('codigo_aux_des', $f["codigo_aux_des"]);
		    $xml->add_nodo('nombre_aux_des', $f["nombre_aux_des"]);
		    
 			$xml->add_nodo('id_transaccion', $f["id_transaccion"]);
		    $xml->add_nodo('desc_transaccion', $f["desc_transaccion"]);
		   
		    $xml->add_nodo('id_grupo_proceso', $f["id_grupo_proceso"]);
			$xml->add_nodo('desc_grupo_proceso', $f["desc_grupo_proceso"]);
			
			$xml->add_nodo('desc_cta_org', $f["nro_cta_org"].'-'.$f["nombre_cta_org"]);
		    $xml->add_nodo('desc_aux_org', $f["codigo_aux_org"].'-'.$f["nombre_aux_org"]);
		    
			$xml->add_nodo('desc_cta_des', $f["nro_cta_des"].'-'.$f["nombre_cta_des"]);
		    $xml->add_nodo('desc_aux_des', $f["codigo_aux_des"].'-'.$f["nombre_aux_des"]);
		    
		    $xml->add_nodo('id_ppto_org', $f["id_ppto_org"]);
		    $xml->add_nodo('id_ppto_des', $f["id_ppto_des"]);
		    $xml->add_nodo('desc_ppto_org', $f["desc_ppto_org"]);
		    $xml->add_nodo('desc_ppto_des', $f["desc_ppto_des"]);
		    $xml->add_nodo('id_sub_tipo_activo', $f["id_sub_tipo_activo"]);
		    $xml->add_nodo('id_gestion', $f["id_gestion"]);
		    $xml->fin_rama();
		}
		header('HTTP/1.0 200 OK');
		header('Content-Type:text/xml');
		echo $xml -> cadena_xml();
		exit;
		//$xml->mostrar_xml();
	}
	else
	{
		//Se produjo un error
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
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;

}
	 
	 
?>