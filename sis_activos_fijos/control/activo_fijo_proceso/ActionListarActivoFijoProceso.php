<?php
/*
**********************************************************
Nombre de archivo:	    ActionListaActivoFijoProceso.php
Propósito:				Permite desplegar los ActivoFijoProceso registrados
Tabla:					taf_activo_fijo_proceso
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro
						$id_usuario_asignacion

Valores de Retorno:    	Listado de ActivoFijoProceso
Fecha de Creación:		06- 06 - 07
Versión:				1.0.0
Autor:					Mercedes Zambrana Meneses
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");

$CustomActivos = new cls_CustomDBActivoFijo();
$nombre_archivo='ActionListaActivoFijoProceso.php';

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
	
	//Verifica si tiene un id_proceso por defecto, para sólo mostrar la información de un proceso específico
	if($id_grupo_proceso != '' && $id_grupo_proceso != 'undefined')
	{
		$cond->add_condicion_filtro('afp.id_grupo_proceso', $id_grupo_proceso, 'true');
	}
	
	//Verifica si debe filtrar por un estado específico
	if($estado != '' && $estado != 'undefined')
	{
		$cond->add_condicion_filtro('afproc.estado', $estado, 'true');
	}
	
	 
	//Obtiene el criterio del filtro
	$criterio_filtro = $cond->obtener_criterio_filtro();
	if($maestro_id_activo_fijo>0){
		$criterio_filtro=$criterio_filtro. " AND afp.id_activo_fijo=$maestro_id_activo_fijo";
	}
	$res = $CustomActivos->ContarActivoFijoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	if($res)
	{
		$total_registros= $CustomActivos->salida;
	}
	
	//Obtiene el conjunto de datos de la consulta
	
	$res = $CustomActivos->ListarActivoFijoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);

	if($res)
	{	
		
		// PREPARA EL ARCHIVO XML
		$xml= new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		foreach ($CustomActivos->salida as $f)
		{ 
		    $xml->add_rama('ROWS');
		    $xml->add_nodo('id_activo_fijo_proceso',$f["id_activo_fijo_proceso"]);
		    $xml->add_nodo('id_activo_fijo',$f["id_activo_fijo"]);
		    $xml->add_nodo('id_sub_tipo_activo',$f["id_sub_tipo_activo"]);
		    $xml->add_nodo('id_tipo_activo',$f["id_tipo_activo"]);
		    $xml->add_nodo('id_transaccion',$f["id_transaccion"]);
		    $xml->add_nodo('id_grupo_proceso', $f["id_grupo_proceso"]);
		    $xml->add_nodo('id_presupuesto',$f["id_presupuesto"]);
		    $xml->add_nodo('vida_util_anterior',$f["vida_util_anterior"]);
		    $xml->add_nodo('vida_util_actual',$f["vida_util_actual"]);
		    $xml->add_nodo('monto_vigente_anterior',$f["monto_vigente_anterior"]);
		    $xml->add_nodo('monto_vigente_actual',$f["monto_vigente_actual"]);
		    $xml->add_nodo('depreciacion',$f["depreciacion"]);
		    $xml->add_nodo('depreciacion_acumulada',$f["depreciacion_acumulada"]);
		    $xml->add_nodo('depreciacion_acumulada_anterior',$f["depreciacion_acumulada_anterior"]);
		    $xml->add_nodo('depreciacion_acumulada_actualiz',$f["depreciacion_acumulada_actualiz"]);
 			$xml->add_nodo('monto_actualiz_ant', $f["monto_actualiz_ant"]);
		    $xml->add_nodo('monto_actualiz', $f["monto_actualiz"]);
		    $xml->add_nodo('desc_tipo_activo', $f["desc_tipo_activo"]);
		    $xml->add_nodo('desc_sub_tipo_activo', $f["desc_sub_tipo_activo"]);
		    $xml->add_nodo('desc_activo', $f["desc_activo"]);
		    $xml->add_nodo('desc_presupuesto', $f["desc_presupuesto"]);
		    $xml->add_nodo('monto_revalorizacion', $f["monto_revalorizacion"]);
		    $xml->add_nodo('vida_util_revalorizacion', $f["vida_util_revalorizacion"]);
		    $xml->add_nodo('fecha_ini_dep', $f["fecha_ini_dep"]);
		    $xml->add_nodo('desc_proceso', $f["desc_proceso"]);
		    $xml->add_nodo('estado', $f["estado"]);
		    $xml->add_nodo('observaciones', $f["observaciones"]);
		    $xml->add_nodo('estado_detalle', $f["estado_detalle"]);
		    $xml->add_nodo('asignar', $f["asignar"]);
		    
		    $xml->fin_rama();
		}
		/*header('HTTP/1.0 200 OK');
		header('Content-Type:text/xml');
		echo $xml -> cadena_xml();
		exit;*/
		$xml->mostrar_xml();
	}
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = $CustomActivos->salida[1];
		$resp->origen = $CustomActivos->salida[2];
		$resp->proc = $CustomActivos->salida[3];
		$resp->nivel = $CustomActivos->salida[4];
		$resp->query = $CustomActivos->query;
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