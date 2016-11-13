<?php
session_start();
/**
 * Autor: Elmer Velasquez
 * Fecha de creacion: 01/02/2013
 * Descripción: llamada a la funcion para la creacion del reporte de Detalle de la Asociacion de los Activos Fijos de los Proceso de ALta y Baja de Activos Fijos
 * **/

include_once('../../LibModeloActivoFijo.php');
$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = "ActionPDFDetalleAsociacionTipoEP.php";



if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    if($limit == "") $cant = 15;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

if($sort == '') $sortcol = 'tab_4.id_tipo_activo';
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

	$cond->add_criterio_extra("afgp.id_grupo_proceso",$id_grupo_proceso);
	$criterio_filtro = $cond->obtener_criterio_filtro();
	$criterio_filtro=$id_grupo_proceso; 
	//echo $criterio_filtro;exit;
		$res = $Custom-> PDFDetalleAsociacionTipoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		if($res)
		{
			
			$_SESSION['PDF_detalle_asociacion_tipo_ep']=$Custom->salida;
			//echo count( $_SESSION['PDF_detalle_asociacion_tipo_ep']) ;
			
			header('location: ../../../vista/_reportes/asociacion_tipo_ep/PDFDetalleAsociacionTipoEP.php');  
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
		}
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>