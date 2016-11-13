<?php
session_start();
//include_once("../../rcm_LibModeloAlmacenes.php");
include_once("../../LibModeloActivoFijo.php");
$nombre_archivo = 'ActionPDFActivoFijoEstadoEPEmpleado.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{		
	$id_financiador            =  $txt_id_financiador;
	$id_regional               =  $txt_id_regional;
	$id_programa               =  $txt_id_programa;
	$id_proyecto               =  $txt_id_proyecto;
	$id_actividad              =  $txt_id_actividad;
	$id_empleado               =  $txt_id_empleado;
	
	/*echo $id_empleado;
	exit;*/
	header("location:PDFActivoFijoEstadoEPEmpleado.php?id_financiador=$id_financiador&id_regional=$id_regional&id_programa=$id_programa&id_proyecto=$id_proyecto&id_actividad=$id_actividad&id_empleado=$id_empleado");		
			
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