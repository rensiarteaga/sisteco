<?php
session_start();
//include_once("../../rcm_LibModeloAlmacenes.php");
include_once("../../LibModeloActivoFijo.php");
$nombre_archivo = 'ActionPDFActivoFijoBaja.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{		
			///////////////////////////////////
	$id_financiador            =  $hidden_id_financiador;
	$id_regional               =  $hidden_id_regional;
	$id_programa               =  $hidden_id_programa;
	$id_proyecto               =  $hidden_id_proyecto;
	$id_actividad              =  $hidden_id_actividad;
	$id_tipo_activo            =  $hidden_id_tipo_activo;
	$id_sub_tipo_activo        =  $hidden_id_sub_tipo_activo;
	$fecha_proceso1             =  $txt_fecha_proceso1;
	$fecha_proceso2             =  $txt_fecha_proceso2;
	$estado                    =  $txt_estado;	
	$_SESSION['rep_af_baja_proceso1']=$txt_fecha_proceso1;
	$_SESSION['rep_af_baja_proceso2']=$txt_fecha_proceso2;
	
	//añadido 28/04/2014
	
	$proyecto = $txt_activo_proyecto;
	header("location:PDFActivoFijoBaja.php?id_financiador=$id_financiador&id_regional=$id_regional&id_programa=$id_programa&id_proyecto=$id_proyecto&id_actividad=$id_actividad&id_tipo_activo=$id_tipo_activo&id_sub_tipo_activo=$id_sub_tipo_activo&fecha_proceso1=$fecha_proceso1&fecha_proceso2=$fecha_proceso2&proyecto=$proyecto");
	
	//fin añadido 28/04/2014
					
			
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