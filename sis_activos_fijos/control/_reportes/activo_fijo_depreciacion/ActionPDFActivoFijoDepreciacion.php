<?php
/**
 * Nombre:				ActionPDFActivoFijoDepreciacion
 * Autor:				Silvia Ximena Ortiz Fernandez
 * Fecha creación:		09/02/2011
 *
 */
session_start();
include_once("../../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();

$nombre_archivo = 'ActionPDFActivoFijoDepreciacion.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 30000;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = '';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> 'si', 'no'
	
	switch ($cod)
	{
		case 'si':
			$decodificar = true;
			break;
		case 'no':
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
	$_SESSION["PDF_tipo_reporte"]=$tipo_reporte;
	$_SESSION["PDF_id_grupo_proceso"]=$m_id_grupo_proceso;
	$_SESSION["PDF_fecha_contabilizacion"]=$txt_fecha_contabilizacion;
	$_SESSION["PDF_descripcion"]=$txt_descripcion;

	if($tipo_reporte=='pdf')
		header("location:../../../vista/activo_fijo_proceso/PDFActivoFijoDepreciacion.php");
	else 
		header("location:../../../vista/activo_fijo_proceso/XLSActivoFijoDepreciacion.php");
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
?>