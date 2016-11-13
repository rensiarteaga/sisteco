<?php
session_start();
include_once('../../LibModeloContabilidad.php');
$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionPDFLibroCompras.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{		
	$id_moneda                =  $id_moneda;
	$txt_fecha_inicio         =  $txt_fecha_inicio;
	$txt_fecha_fin            =  $txt_fecha_fin;
	$sw_debito_credito            =  $sw_debito_credito;
	
	/*echo "hhoooo".$sw_debito_credito;
	exit;*/
	
	$Prueba=split("/",$txt_fecha_inicio);
	$Prueba2=split("/",$txt_fecha_fin);
	
	$_SESSION['rep_sci_fecha_inicio']=$Prueba[1]."/".$Prueba[0]."/".$Prueba[2];
	$_SESSION['rep_sci_fecha_fin']=$Prueba2[1]."/".$Prueba2[0]."/".$Prueba2[2];;
	$_SESSION['txt_desc_moneda']=utf8_decode($_GET['txt_desc_moneda']);
 
		if($sw_debito_credito=='1'){

		header("location:PDFLibroCompras.php?id_moneda=$id_moneda&fecha_inicio=$txt_fecha_inicio&fecha_fin=$txt_fecha_fin&sw_debito_credito=$sw_debito_credito&id_depto=$id_depto");			
		}
		if($sw_debito_credito=='2'){
			
		header("location:PDFLibroVentas.php?id_moneda=$id_moneda&fecha_inicio=$txt_fecha_inicio&fecha_fin=$txt_fecha_fin&sw_debito_credito=$sw_debito_credito&id_depto=$id_depto");		
		}
		
}
else
{	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;

}?>