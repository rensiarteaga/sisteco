<?php
session_start();


include_once('../../LibModeloAlmacenes.php');
$Custom = new cls_CustomDBAlmacenes();

$nombre_archivo = 'ActionReporteRelacionarCuentaPartida.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$cant = 100000;
	$puntero = 0;
	$sortcol = 'desc_servicio';
	$sortdir = 'asc';
	$_SESSION['gestion']=$txt_gestion;		
	/*$_SESSION['id_parametro']=$txt_id_param;
	$_SESSION['gestion']=$txt_gestion;		
	$_SESSION['periodo']=$txt_periodo;				
	$_SESSION['porcentaje']=$txt_porcentaje;		
	$_SESSION['categoria']=$txt_categoria;
	$_SESSION['ruta']=$txt_ruta;
		
	$_SESSION['tipo_orden']=$txt_tipo;					
		
	if($txt_orden =='cliente')
	{
		$_SESSION['ordenar_por']='cli.desc_cliente'; //revisar
	}
		
	if($txt_orden =='consumo')
	{
		$_SESSION['ordenar_por']='ccc.consumo_peri';	//revisar
	}

	if($txt_orden =='cod_ubi')
	{
		$_SESSION['ordenar_por']='cli.cod_ubica';
	}	*/				
		
	header("location: PDFRelacionarCuentaPartida.php");	
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
}
?>