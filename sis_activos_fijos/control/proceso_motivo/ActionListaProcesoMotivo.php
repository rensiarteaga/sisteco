<?php
/*
**********************************************************
Nombre de archivo:	    ActionListaProcesoMotivo.php
Propósito:				Permite desplegar los ProcesoMotivos registrados
Tabla:					taf_proceso_motivo
Parámetros:				$cant
$puntero
$sortcol
$sortdir
$criterio_filtro
$id_usuario_asignacion

Valores de Retorno:    	Listado de ProcesoMotivos
Fecha de Creación:		05- 06 - 07
Versión:				1.0.0
Autor:					Mercedes Zambrana Meneses
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");

$CustomActivos = new cls_CustomDBActivoFijo();
$nombre_archivo='ActionListaProcesoMotivo.php';

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

	if($sort == "") $sortcol = 'descripcion';
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

	//Se aumenta el criterio del maestro (id_tipo_activo)
	
	$cond->add_criterio_extra("promot.id_proceso",$maestro_id_proceso);
	$criterio_filtro = $cond->obtener_criterio_filtro();


	$res = $CustomActivos->ContarListaProcesoMotivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res)
	{
		$total_registros= $CustomActivos->salida[0][0];

	}

	//Obtiene el conjunto de datos de la consulta
	$res = $CustomActivos->ListarProcesoMotivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);


	if($res)
	{
		//exit;
		// PREPARA EL ARCHIVO XML
		$_xml= new cls_manejo_xml('ROOT');
		$_xml->add_nodo('TotalCount',$total_registros);

		foreach ($CustomActivos->salida as $f)
		{
			$_xml->add_rama('ROWS');
			$_xml->add_nodo('id_motivo',$f["id_motivo"]);
			$_xml->add_nodo('descripcion',$f["descripcion"]);
			$_xml->add_nodo('id_proceso',$f["id_proceso"]);
			$_xml->add_nodo('des_proceso',$f["des_proceso"]);
			$_xml->fin_rama();
		}
		header('HTTP/1.0 200 OK');
		header('Content-Type:text/xml');
		$_xml->mostrar_xml();
	}
	else
	{
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