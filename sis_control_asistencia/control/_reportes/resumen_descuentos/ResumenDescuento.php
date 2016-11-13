<?php
session_start();
include_once("../../LibModeloControlAsistencia.php");
include_once("../../../../sis_kardex_personal/modelo/cls_CustomDBKardexPersonal.php");
$nombre_archivo='LecturaDepurada.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
		    $Custom = new cls_CustomDBControlAsistencia();
		    $fecha_ini=$txt_fecha_ini;
			$fecha_fin=$txt_fecha_fin;
			$tipo_contrato=$txt_tipo_contrato;
			$id_empleado=1;
			 $_SESSION['fecha_desde_resumen_descuento_semana']=$fecha_ini;
			 $_SESSION['fecha_hasta_resumen_descuento_semana']=$fecha_fin;
			 $_SESSION['tipo_contrato']=$tipo_contrato;
			 $cant=10;
			 $puntero=0;
			 $sortcol='DESC.id_descuento';
			 $sortdir='asc';
			 $criterio_filtro='0=0';
			 $Custom->Descuento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$txt_fecha_ini,$txt_fecha_fin,$tipo_contrato);
			

			 
			 header("location:PDFResumenDescuento.php?fecha_ini=".$fecha_ini."&fecha_fin=".$fecha_fin."&id_empleado=".$id_empleado); 			
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