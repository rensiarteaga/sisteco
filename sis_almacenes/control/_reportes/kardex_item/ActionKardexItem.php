<?php

session_start();

include_once("../../rac_LibModeloAlmacenes.php");
$nombre_archivo = 'ActionPedidoMateriales.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{

	$id_salida=$maestro_id_salida;
	$_SESSION['kard_item_fecha_desde']=$txt_fecha_desde;
	$_SESSION['kard_item_fecha_hasta']=$txt_fecha_hasta;
	$_SESSION['kard_item_id_item']=$txt_id_item;
	$_SESSION['kard_item_desc_almacen']=$txt_desc_almacen;
	header("location:PDFKardexItem.php");
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