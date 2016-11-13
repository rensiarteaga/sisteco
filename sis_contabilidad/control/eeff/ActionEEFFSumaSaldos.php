<?php
session_start();
 
$nombre_archivo = 'ActionEEFFSumaSaldos.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$cant = 100000;
	$puntero = 0;
	$sortcol = 'nro_cuenta';
	$sortdir = 'asc';
			
	$_SESSION['start']=utf8_decode($_GET['start']);
	$_SESSION['limit']=utf8_decode($_GET['limit']);
	$_SESSION['CantFiltros']=utf8_decode($_GET['CantFiltros']);
	
	$_SESSION['nivel']=utf8_decode($_GET['nivel']);
	$_SESSION['sw_actualizacion']=utf8_decode($_GET['sw_actualizacion']);
	$_SESSION['id_parametro']=utf8_decode($_GET['id_parametro']);
	$_SESSION['ids_depto']=utf8_decode($_GET['ids_depto']);
	$_SESSION['id_moneda']=utf8_decode($_GET['id_moneda']);
	$_SESSION['id_reporte_eeff']=utf8_decode($_GET['id_reporte_eeff']);
	$_SESSION['fecha_trans']=utf8_decode($_GET['fecha_trans']);
	$_SESSION['fecha_trans_ini']=utf8_decode($_GET['fecha_trans_ini']);
	$_SESSION['departamento']=utf8_decode($_GET['departamento']);
	$_SESSION['desc_moneda']=utf8_decode($_GET['desc_moneda']);
	$_SESSION['fecha_reporte']=$_GET['fecha_rep'];
	$_SESSION['fecha_reporte_ini']=$_GET['fecha_rep_ini'];
	$_SESSION['EEFF']= 'ESTADO DE COMPROBACIÓN DE SUMAS Y SALDOS';
			
	header("location:PDFEEFFSumaSaldos.php");

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