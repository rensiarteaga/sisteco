<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarItem.php
Propósito:				Permite desplegar datos de los Items
Tabla:					tal_item
Parámetros:				$cant
$puntero
$sortcol
$sortdir
$criterio_filtro
$id_usuario_asignacion

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		29-09-2007
Versión:				1.0.0
Autor:					Rodrigo Chumacero Moscoso
**********************************************************
*/
session_start();
include_once("../LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = 'ActionListarItem.php';


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

	if($sort == "") $sortcol = 'ite.id_item';
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
	$criterio_filtro = $cond->obtener_criterio_filtro();
	//  $crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Item');
	//$sortcol = $crit_sort->get_criterio_sort();
	//Obtiene el total de los registros
	$res = $Custom->ContarItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros= $Custom->salida;

	//$cond = new cls_criterio_filtro($decodificar);


	//filtra el id3
	$condicion= "ite.id_id3=''$id_id3'' and ite.codigo!=''".$codigo_id3."00''";


	$res = $Custom->ListarItem("NULL",0,'ite.id_item desc, ite.codigo desc','desc',$condicion,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	//	$res = $Custom->ContarItem("NULL",0,'id_item','asc',$condicion,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res){

		foreach ($Custom->salida as $f)
		{
			$tmp['codigo'] = utf8_encode($f["codigo"]);
			$cadena = substr($f["codigo"],9);		
			break;
		}
        if($cadena==null){
        $cadena=0;        
        }

		$tmp['success'] = 'true';
		$tmp['cantidad'] = $cadena;
		echo json_encode($tmp);
		exit;
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