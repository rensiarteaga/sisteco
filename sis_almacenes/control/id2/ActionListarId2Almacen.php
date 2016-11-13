<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarGrupo.php
Propósito:				Permite desplegar los Grupos
Tabla:					tal_grupo
Parámetros:				$cant
Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		28-09-2007
Versión:				1.0.0
Autor:					Susana Castro Guaman.
**********************************************************
*/
session_start();
include_once("../LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = 'ActionListarId1Almacen.php';

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

	if($sort == "") $sortcol = 'id_id2';
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
	/*$criterio_filtro = $cond->obtener_criterio_filtro();
	//$criterio_filtro = $criterio_filtro." AND ALMACE.id_almacen = $id_almacen	";
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,"al_id2");
	$sortcol = $crit_sort->get_criterio_sort();
	//Obtiene el criterio de orden de columnas
	/*$crit_sort = new cls_criterio_sort($sortcol,$sortdir,"id_subgrupo");
	$sortcol = $crit_sort->get_criterio_sort();*/
    
	$criterio_filtro = $cond->obtener_criterio_filtro();
    $criterio_filtro = $criterio_filtro." AND ALMACE.id_almacen = $id_almacen	";
	//Obtiene el total de los registros
	$res = $Custom->ContarId2Almacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarId2Almacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		if($origen=='filtro'){
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_id2','%');
			$xml->add_nodo('nombre','todos');
			$xml->add_nodo('codigo','todos');
			$xml->add_nodo('descripcion','todos');
			$xml->add_nodo('observaciones','todos');
			$xml->add_nodo('estado_registro','activo');
			$xml->fin_rama();
		}

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_id2', $f["id_id2"]);
			$xml->add_nodo('codigo', $f["codigo"]);
			$xml->add_nodo('nombre', $f["nombre"]);
			$xml->add_nodo('descripcion', $f["descripcion"]);
			$xml->add_nodo('nivel_convertido', $f["nivel_convertido"]);
			$xml->add_nodo('convertido', $f["convertido"]);
			$xml->add_nodo('observaciones', $f["observaciones"]);
			$xml->add_nodo('estado_registro', $f["estado_registro"]);
			$xml->add_nodo('fecha_reg', $f["fecha_reg"]);
			$xml->add_nodo('id_id', $f["id_id1"]);
			$xml->add_nodo('id_subgrupo', $f["id_subgrupo"]);
			$xml->add_nodo('id_grupo', $f["id_grupo"]);
			$xml->add_nodo('id_supergrupo', $f["id_supergrupo"]);
			$xml->add_nodo('desc_id1', $f["desc_id1"]);
			$xml->add_nodo('desc_subgrupo', $f["desc_subgrupo"]);
			$xml->add_nodo('desc_grupo', $f["desc_grupo"]);
			$xml->add_nodo('desc_supergrupo', $f["desc_supergrupo"]);
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
