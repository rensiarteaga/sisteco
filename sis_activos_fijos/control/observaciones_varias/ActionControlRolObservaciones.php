<?php
/**
 * Nombre del archivo:	ActionControlrolObservaciones.php
 * Prop�sito:			Permite eliminar registros de las Reparaciones de los Activos Fijos
 * Tabla:				taf_observaciones_varias
 * Par�metros:			
 * Valores de Retorno:	
 * Autor:				UNKNOW
 * Fecha creaci�n:		31082015
 */
session_start();

include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionControlRolObservaciones.php';
if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
} 
if($_SESSION['autentificado']=="SI")
{
	//Par�metros del filtro
	if($limit == "") $cant = 15;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

	if($sort == "") $sortcol = ' ';
	else $sortcol = $sort;

	if($dir == "") $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
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

	//Obtiene el total de los registros
	if (isset($rol_observaciones))
	{
		$criterio_filtro .= " usu.id_usuario= $id_usuario AND usu.estado_reg=''activo'' AND usu.id_rol IN(
																									SELECT r.id_rol
																									FROM sss.tsg_rol r
																									WHERE r.nombre LIKE (''ACTIF - Observaciones Varias'')
																									ORDER BY r.id_rol DESC LIMIT 1)";
	}
	
	$res = $Custom->ContarControlObservacionesVarios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
	if($res)
	{
		$total_registros= $Custom->salida;
	}

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarControlObservacionesVarios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);

	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_rol', $f["id_rol"]);
			$xml->add_nodo('id_usuario', $f["id_usuario"]);
		
			$xml->fin_rama();
		}
		$xml->mostrar_xml();
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

}?>