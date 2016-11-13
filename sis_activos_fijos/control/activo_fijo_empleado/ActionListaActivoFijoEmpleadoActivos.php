<?php
/**
**********************************************************
Nombre de archivo:	    ActionListaActivoFijoijoEmpleado.php
Propósito:				Permite desplegar los Activo_fijo_empleado registradas
Tabla:					taf_activo_fijo_empleado
Parámetros:				$cant
$puntero
$sortcol
$sortdir
$criterio_filtro
$id_usuario_asignacion

Valores de Retorno:    	Listado de Activo_fijo_empleado y total de registros listados
Fecha de Creación:		06 - 06- 07
Versión:				1.0.0
Autor:					Rodrigo Chumacero M.
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionListaActivoFijoEmpleado.php';


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

	if($sort == "") $sortcol = 'af.codigo,afe.id_activo_fijo_empleado';
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

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=="") $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	///aquiiiii
	//$cond->add_criterio_extra("afe.id_activo_fijo",$maestro_id_activo_fijo);
	//$criterio_filtro="afe.estado=''activo''";	
	
	if($id_empleado)
		$cond->add_criterio_extra("afe.id_empleado",$id_empleado);
	
	$criterio_filtro = $cond->obtener_criterio_filtro();
	$criterio_filtro=$criterio_filtro." AND afe.estado=''activo''";
		
	/*if($band==1){
		$criterio_filtro=$criterio_filtro." AND afe.estado=''activo''";
	}*/
	//Obtiene el total de los registros
	$res = $Custom->ContarListaActivoFijoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros= $Custom->salida;
		
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarActivoFijoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{	$xml->add_rama('ROWS');
			$xml->add_nodo('id_activo_fijo_empleado', $f["id_activo_fijo_empleado"]);
			$xml->add_nodo('fecha_reg', $f["fecha_reg"]);
			$xml->add_nodo('estado', $f["estado"]);
			$xml->add_nodo('id_activo_fijo', $f["id_activo_fijo"]);
			$xml->add_nodo('id_empleado', $f["id_empleado"]);
			$xml->add_nodo('desc_activo_fijo', $f["desc_activo_fijo"]);
			$xml->add_nodo('desc_empleado', $f["desc_empleado"]);
			$xml->add_nodo('fecha_asig', $f["fecha_asig"]);
			$xml->add_nodo('descripcion_larga', $f["descripcion_larga"]);
			$xml->add_nodo('codigo', $f["codigo"]);
			
			$xml->fin_rama();
		}
		/*header('HTTP/1.0 200 OK');
		header('Content-Type:text/xml');
		echo $xml -> cadena_xml();
		exit;*/
		$xml->mostrar_xml();
	}
	else
	{	//Se produjo un error
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

}?>
