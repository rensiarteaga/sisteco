<?php
session_start();
//include_once("../../rcm_LibModeloAlmacenes.php");
include_once("../../LibModeloActivoFijo.php");
$nombre_archivo = 'ActionPDFActivoFijoAsignacion.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{		
	$id_empleado =  $hidden_id_empleado;
	
	/*echo $id_empleado;
	exit;*/
	
	$CustomActivoFijo = new cls_CustomDBActivoFijo();
	$CustomActivoFijo->ListarAsignacionResponsable(0,30,$sortcol,$sortdir,'EMP.id_empleado='.$id_empleado,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);   
	foreach ($CustomActivoFijo->salida as $row){
		$txt_nombre_empleado=$row["desc_empleado"];
		$txt_cargo=$row["cargo"];
		$txt_unidad_organizacional=$row["uni_org"];
		$txt_responsable_af=$row["resp_af"];
		
	}
	/*echo $txt_responsable_af;
	exit;*/
	$_SESSION['rep_af_nombre_empleado']=$txt_nombre_empleado;
	$_SESSION['rep_af_cargo']=$txt_cargo;
	$_SESSION['rep_af_unidad_organizacional']=$txt_unidad_organizacional;
	$_SESSION['rep_af_responsable_af']=$txt_responsable_af;
	
	header("location:PDFActivoFijoAsignacion.php?id_financiador=$id_financiador&id_regional=$id_regional&id_programa=$id_programa&id_proyecto=$id_proyecto&id_actividad=$id_actividad&id_empleado=$id_empleado");		
			
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