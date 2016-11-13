<?php
session_start();
include_once("../LibModeloKardexPersonal.php");
$nombre_archivo='papeleta_pago.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
		    $Custom=new cls_CustomDBKardexPersonal();
			$id_empleado=$txt_id_empleado;
			$id_planilla=$txt_id_planilla;
			 
			 $cant=10;
			 $puntero=0;
			 $sortcol='EMPPLA.id_empleado';
			 $sortdir='asc';
			 $criterio_filtro='EMPPLA.id_empleado='.$id_empleado.' AND EMPPLA.id_planilla='.$id_planilla;
			 $Custom->ListarEmpleadoPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
			 $m_id_empleado_planilla=$Custom->salida[0][0];
			 /*echo $id_empleado."<BR>";
			 echo $id_planilla."<BR>";
			 echo $m_id_empleado_planilla."<BR>";
			 exit;*/
			 	header("location:ActionPDFBoletaPago.php?m_id_empleado_planilla=".$m_id_empleado_planilla."&id_planilla=".$id_planilla); 			
			 
			 
}
else
{
	$resp=new cls_manejo_mensajes(true,"401");
	$resp->mensaje_error='MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen="ORIGEN = $nombre_archivo";
	$resp->proc="PROC = $nombre_archivo";
	$resp->nivel='NIVEL = 3';
	echo $resp->get_mensaje();
	exit;
}?>