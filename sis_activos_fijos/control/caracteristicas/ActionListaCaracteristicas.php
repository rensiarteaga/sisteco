<?php
/**
**********************************************************
Nombre de archivo:	    ActionListaCaracteristicas.php
Propósito:				Permite desplegar las Caracteristicas registradas
Tabla:					taf_caracteristicas
Parámetros:				$cant
$puntero
$sortcol
$sortdir
$criterio_filtro
$id_usuario_asignacion

Valores de Retorno:    	Listado de Caracteristicas y total de registros listados
Fecha de Creación:		06 - 06 - 07
Versión:				1.0.0
Autor:					Rodrigo Chumacero M.
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionListaCaracteristicas.php';


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
	$cond->add_criterio_extra("car.id_sub_tipo_activo",$maestro_id_sub_tipo_activo);
	$criterio_filtro = $cond->obtener_criterio_filtro();
	
	if(isset($maestro_id_subtipo) && $maestro_id_subtipo >0 )
		$criterio_filtro .=' AND ta.id_sub_tipo_activo like('.$maestro_id_subtipo.')';
	
	//Obtiene el total de los registros
	$res = $Custom->ContarListaCaracteristicas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros= $Custom->salida;
		
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCaracteristicas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_caracteristica', $f["id_caracteristica"]);
			$xml->add_nodo('descripcion', $f["descripcion"]);
			$xml->add_nodo('id_subtipo_activo', $f["id_subtipo_activo"]);
			$xml->add_nodo('desc_subtipo_activo', $f["desc_subtipo_activo"]);
				
			$xml->fin_rama();
		}
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

}?>
