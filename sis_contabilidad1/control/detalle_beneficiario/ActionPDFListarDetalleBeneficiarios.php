<?php

session_start();
include_once('../LibModeloContabilidad.php');
$Custom = new cls_CustomDBContabilidad();

$nombre_archivo = 'ActionPDFSolicitud.php';



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

if($sort == '') $sortcol = 'SOLCOM.id_solicitud_compra';
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
	$criterio_filtro = $criterio_filtro . ' AND id_archivo_control = '.$id_archivo_control;
	
	$criterio_filtro = $cond->obtener_criterio_filtro();
	$criterio_filtro = $criterio_filtro . ' AND id_archivo_control = '.$id_archivo_control;
	$_SESSION['PDF_mes_periodo']=$mes_per_fiscal;
	$_SESSION['PDF_anio_periodo']=$anio_per_fiscal;
	$_SESSION['PDF_tipo_reporte']=$tipo_reporte;
	$detalle = array();
	
	$detalle = $Custom-> ListarDetalleBeneficiariosSCIRep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$_SESSION['PDF_detalle_beneficiarios']=$Custom->salida;
    
	header("location: ../../vista/recuperacion_vejez_gral/PDFDetalleBeneficiarios.php");
}
else
{
	header("HTTP/1.0 401 No autorizado");
	header('Content-Type: text/plain; charset=iso-8859-1');
	echo "No tiene los permisos necesarios ";
}

?>