<?php
session_start();
include_once("../../LibModeloControlAsistencia.php");
include_once("../../../../sis_kardex_personal/modelo/cls_CustomDBKardexPersonal.php");
$nombre_archivo='DetalleNoTrab.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
		    $Custom = new cls_CustomDBControlAsistencia();
		    $CustomKardex=new cls_CustomDBKardexPersonal();
			$id_empleado=$txt_id_empleado;
			$fecha_ini=$txt_fecha_ini;
			$fecha_fin=$txt_fecha_fin;
			 $_SESSION['fecha_desde']=$fecha_ini;
			 $_SESSION['fecha_hasta']=$fecha_fin;
			 $cant=10;
			 $puntero=0;
			 $sortcol='EMPLEA.id_empleado';
			 $sortdir='asc';
			 $criterio_filtro='EMPLEA.id_empleado='.$id_empleado;
			 $CustomKardex->ListarEmpleado_($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
			 $_SESSION['funcionario']=$CustomKardex->salida[0][2];
			 header("location:PDFDetalleNoTrab.php?id_empleado=".$id_empleado."&fecha_ini=".$fecha_ini."&fecha_fin=".$fecha_fin); 			
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