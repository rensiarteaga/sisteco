<?php

session_start();
/*include_once("../../../lib/funciones.inc.php");
$Funciones=new funciones();
$filtro1=$Funciones->eliminarespeciales($_GET["filtro1"]);
$filtro2=$Funciones->eliminarespeciales($_GET["filtro2"]);
$filtro3=$Funciones->eliminarespeciales($_GET["filtro3"]);
$titulo=$_GET["titulo"];
$valor=$_GET["valor"];*/

include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionPDFEjecucion_x_Fechas.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
/*echo "down down".utf8_decode($_GET['fecha_desde']);
exit; */
if($_SESSION['autentificado']=="SI")
{
	$cant = 100000;
	$puntero = 0;
	$sortcolA = 'CUEDOC.fecha_sol, PAREJE.fecha_com_eje';
	$sortdir = 'desc';
 
		$_SESSION['start']=utf8_decode($_GET['start']);
		$_SESSION['limit']=utf8_decode($_GET['limit']);
		$_SESSION['CantFiltros']=utf8_decode($_GET['CantFiltros']);
		$_SESSION['m_ids_depto']=utf8_decode($_GET['m_ids_depto']);
		$_SESSION['m_ids_presupuesto']=utf8_decode($_GET['m_ids_presupuesto']);
		$_SESSION['m_fecha_inicio']=utf8_decode($_GET['m_fecha_inicio']);
		$_SESSION['m_fecha_inicio_rep']=utf8_decode($_GET['m_fecha_inicio_rep']);
		$_SESSION['m_fecha_fin']=utf8_decode($_GET['m_fecha_fin']);
		$_SESSION['m_fecha_fin_rep']=utf8_decode($_GET['m_fecha_fin_rep']);
		$_SESSION['id_moneda']=utf8_decode($_GET['id_moneda']);
		$_SESSION['id_moneda_desc']=utf8_decode($_GET['id_moneda_desc']);
		$_SESSION['g_depto']=utf8_decode($_GET['g_depto']);
		$_SESSION['g_presupuesto']=utf8_decode($_GET['g_presupuesto']);
		 
	
		/*echo "down down".utf8_decode($_GET['id_presupuesto']);
		exit; */
		header("location:PDFEjecucionConsistenciaEjecucion.php");
	
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