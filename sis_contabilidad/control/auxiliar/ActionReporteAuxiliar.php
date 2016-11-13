<?php
session_start();
include_once('../LibModeloContabilidad.php');

$Custom = new cls_CustomDBContabilidad();

$nombre_archivo = 'ActionReporteAuxiliar.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
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
	$cant = 100000; 
	$puntero = 0;
	$sortcol = 'codigo_auxiliar';
	$sortdir = 'asc'; 
		
	if($CantFiltros=='') $CantFiltros = 0;
	
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"]);
	}	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	$_SESSION['criterio_filtro']=$criterio_filtro;	
	
	header("location: PDFAuxiliar.php");	
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