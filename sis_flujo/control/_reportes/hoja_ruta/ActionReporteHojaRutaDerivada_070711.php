<?php

session_start();

include_once("../../LibModeloFlujo.php"); 
//include_once('../../../../lib/lib_control/cls_manejo_reportes.php');

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = 'ActionReporteHojaRutaDerivada.php';


if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	/*echo $id_correspondencia;
	echo '    ';
	echo $id_uo_rep;
	exit ();*/

	
	/*$arr_id_correspondencia = array($id_correspondencia);
	echo $arr_id_correspondencia;
	echo $arr_id_correspondencia[0];
	echo $arr_id_correspondencia[1];
	echo $arr_id_correspondencia[2];
	exit ();*/
	
	//$id_correspondencia2= array(659,656,627); 
	/*echo $id_correspondencia[0];
	echo $id_correspondencia[1];
	echo $id_correspondencia[2];
	exit ();*/

	//de la cadena de numeros separada por comas insertamos en un arreglo mediante la funcion explode
	$arr_id_correspondencia=explode(',',$id_correspondencia);	
	
	
	$_SESSION['PDF_id_uo_rep']=$id_uo_rep;
	$_SESSION['PDF_desc_uo']= utf8_decode( $desc_uo );
	$_SESSION['PDF_arreglo_id_correspondencia']=$arr_id_correspondencia;
	
	header("location: PDFHojaRutaDerivada.php");
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