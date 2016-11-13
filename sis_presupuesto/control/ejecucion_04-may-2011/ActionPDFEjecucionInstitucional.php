<?php
session_start();
include_once("../LibModeloPresupuesto.php");
/**
 * Nombre de la clase:	ActionPDFEjecucionInstitucional.php
 * Propósito:			Permite ejecutar toda la funcionalidad del reporte Ejecucion Institucional
 * Autor:				Ana Maria villegas Quispe
 * Fecha creación:		10/02/2010
 */
$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionPDFEjecucionInstitucional.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	
		
		
		$_SESSION['PDF_tipo_pres']=$_GET['id_tipo_pres'];
		$_SESSION['PDF_id_parametro']=$_GET['id_parametro'];
		$_SESSION['PDF_id_moneda']=$_GET['id_moneda'];
		$_SESSION['PDF_regional']=$_GET['regional'];
		$_SESSION['PDF_financiador']=$_GET['financiador'];
		$_SESSION['PDF_programa']=$_GET['programa'];
		$_SESSION['PDF_proyecto']=$_GET['proyecto'];
		$_SESSION['PDF_actividad']=$_GET['actividad'];
		$_SESSION['PDF_unidad_organizacional']=$_GET['unidad_organizacional'];
		$_SESSION['PDF_Fuente_financiamiento']=$_GET['fuente_financiamiento'];
		$_SESSION['PDF_desc_moneda']=$_GET['desc_moneda'];
		$_SESSION['PDF_desc_pres']=utf8_decode($_GET['desc_pres']);
		$_SESSION['PDF_gestion_pres']=$_GET['gestion_pres'];
		$_SESSION['PDF_fecha_desde']=$_GET['fecha_desde'];
		$_SESSION['PDF_fecha_hasta']=$_GET['fecha_hasta'];	
		$_SESSION['PDF_m_id_presupuesto']=$_GET['id_presupuesto'];	
		$_SESSION['PDF_desc_presupuesto']=$_GET['desc_presupuesto'];	
		
		//Se obtiene la fecha en formato para mostrar
		$_SESSION['PDF_fecha_fin']= substr( $_SESSION['PDF_fecha_hasta'],3,2)."/".substr($_SESSION['PDF_fecha_hasta'],0,2)."/".substr( $_SESSION['PDF_fecha_hasta'],6,4);
		$_SESSION['PDF_fecha_ini']= substr( $_SESSION['PDF_fecha_desde'],3,2)."/".substr($_SESSION['PDF_fecha_desde'],0,2)."/".substr( $_SESSION['PDF_fecha_desde'],6,4);
		
		
		if($tipo_reporte=='false'){
			
			$EjecucionInstitucional=array();
			$EjecucionInstitucional = $Custom->ListarEjecucionInstitucional(0,0,'codigo_partida','asc','0=0 ',"'(".$_SESSION['PDF_tipo_pres'].")'",$_SESSION['PDF_id_parametro'],$_SESSION['PDF_id_moneda'],$_SESSION['PDF_fecha_hasta'],$_SESSION['PDF_fecha_desde'],$_SESSION['PDF_m_id_presupuesto']);
			$_SESSION['PDF_det_ejecucion_institucional']=$Custom->salida;
			header("location: ../../vista/ejecucion_institucional/PDFEjecucionInstitucional.php");
		}
		else{
			$EjecucionInstitucional=array();
			$EjecucionInstitucional = $Custom->ListarEjecucionInstitucionalPresupuesto(0,0,'codigo_partida','asc','0=0 ',"'(".$_SESSION['PDF_tipo_pres'].")'",$_SESSION['PDF_id_parametro'],$_SESSION['PDF_m_id_presupuesto']);
			$_SESSION['PDF_ejecucion_institucional_presupuesto']=$Custom->salida;
			header("location: ../../vista/ejecucion_institucional/TXTEjecucionInstitucional.php");
			
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