<?php
session_start();
//include_once("../../rcm_LibModeloAlmacenes.php");
include_once("../../LibModeloActivoFijo.php");
$nombre_archivo = 'ActionPDFDetalleDepreciacion.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$id_fina_regi_prog_proy_acti  =  $txt_id_fina_regi_prog_proy_acti;
	
	$id_financiador            =  $txt_id_financiador;
	$id_regional               =  $txt_id_regional;
	$id_programa               =  $txt_id_programa;
	$id_proyecto               =  $txt_id_proyecto;
	$id_actividad              =  $txt_id_actividad;
	
	/*if ($get)
		{	
			$id_fina_regi_prog_proy_acti= $_GET["id_fina_regi_prog_proy_acti"];	
				
				$id_financiador = $_GET["txt_id_financiador"];
				$id_regional	= $_GET["txt_id_regional"];
				$id_programa	= $_GET["txt_id_programa"];
				$id_proyecto	= $_GET["txt_id_proyecto"];
				$id_actividad	= $_GET["txt_id_actividad"];
		}
		else
		{		
			$id_fina_regi_prog_proy_acti= $_GET["id_fina_regi_prog_proy_acti"];	
				$id_financiador= $_POST["txt_id_financiador"];
				$id_regional	= $_POST["txt_id_regional"];
				$id_programa	= $_POST["txt_id_programa"];
				$id_proyecto	= $_POST["txt_id_proyecto"];
				$id_actividad	= $_POST["txt_id_actividad"];				
		}*/		
		
	
	
	echo financiador ;
	echo $id_financiador;
	echo ep ;
	echo $id_fina_regi_prog_proy_acti;
	echo llega;
	exit();
	
	$id_activo_fijo            =  $txt_id_activo_fijo;
	$fecha_desde               =  $txt_fecha_desde;
	$fecha_hasta               =  $txt_fecha_hasta;
	$tipo_data				   =  $txt_tipo_data_rep;
	

	header("location:PDFDetalleDepreciacion.php?id_financiador=$id_financiador&id_regional=$id_regional&id_programa=$id_programa&id_proyecto=$id_proyecto&id_actividad=$id_actividad&fecha_desde=$fecha_desde&fecha_hasta=$fecha_hasta&id_activo_fijo=$id_activo_fijo&tipo_data=$tipo_data");
	//header("location:PDFDetalleDepreciacion.php?id_fina_regi_prog_proy_acti=$id_fina_regi_prog_proy_acti&fecha_desde=$fecha_desde&fecha_hasta=$fecha_hasta&id_activo_fijo=$id_activo_fijo&tipo_data=$tipo_data");

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