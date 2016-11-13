<?php
session_start();
//include_once("../../rcm_LibModeloAlmacenes.php");
include_once("../../LibModeloActivoFijo.php");
$nombre_archivo = 'ActionPDFActivoFijoDetalle.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
			
	$id_financiador            =  $hidden_id_financiador;
	$id_regional               =  $hidden_id_regional;
	$id_programa               =  $hidden_id_programa;
	$id_proyecto               =  $hidden_id_proyecto;
	$id_actividad              =  $hidden_id_actividad;
	$id_tipo_activo            =  $hidden_id_tipo_activo;
	$id_sub_tipo_activo        =  $hidden_id_sub_tipo_activo;
	$id_estado_funcional       =  $hidden_id_estado_funcional;
	$id_unidad_organizacional  =  $hidden_id_unidad_organizacional;
	$fecha_compra1             =  $txt_fecha_compra1;
	$fecha_compra2             =  $txt_fecha_compra2;
	$estado                    =  $txt_estado;
	$ubicacion_fisica		   =  $txt_ubicacion_fisica;
	
	/*echo "ubica: ".$ubicacion_fisica;
	exit;*/
	
	$_SESSION['rep_af_det_fecha1']=$txt_fecha_compra1;
	$_SESSION['rep_af_det_fecha2']=$txt_fecha_compra2;
	
			
	header("location:PDFActivoFijoDetalle.php?id_financiador=$id_financiador&id_regional=$id_regional&id_programa=$id_programa&id_proyecto=$id_proyecto&id_actividad=$id_actividad&id_tipo_activo=$id_tipo_activo&id_sub_tipo_activo=$id_sub_tipo_activo&id_estado_funcional=$id_estado_funcional&id_unidad_organizacional=$id_unidad_organizacional&fecha_compra1=$fecha_compra1&fecha_compra2=$fecha_compra2&estado=$estado&ubicacion_fisica=$ubicacion_fisica");		
			
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