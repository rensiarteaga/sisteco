<?php

session_start();

include_once("../../rcm_LibModeloAlmacenes.php");
$nombre_archivo = 'ActionResumenDiarioIngresos.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{

	$id_salida=$maestro_id_salida;
	$_SESSION['res_sal_fecha_desde']=$txt_fecha_desde;
	$_SESSION['res_sal_fecha_hasta']=$txt_fecha_hasta;
	
	$_SESSION['res_sal_id_financiador']=$txt_id_financiador;
	$_SESSION['res_sal_id_regional']=$txt_id_regional;
	$_SESSION['res_sal_id_programa']=$txt_id_programa;
	$_SESSION['res_sal_id_proyecto']=$txt_id_proyecto;
	$_SESSION['res_sal_id_actividad']=$txt_id_actividad;	
	$_SESSION['res_sal_id_parametro_almacen']=$txt_id_parametro_almacen;
	
	$_SESSION['res_sal_gestion']=$gestion;
	$_SESSION['res_sal_codigo_ep']=$codigo_ep;
	$_SESSION['res_sal_solicitante']=$txt_solicitante;
	$_SESSION['res_sal_id_almacen']=$txt_id_almacen;
	$_SESSION['res_sal_id_almacen_logico']=$txt_id_almacen_logico;
	$_SESSION['res_sal_desc_almacen']=$txt_desc_almacen;
	$_SESSION['res_sal_desc_almacen_logico']=$txt_desc_almacen_logico;
	header("location:PDFResumenDiarioIngresos.php?res_sal_fecha_desde=$txt_fecha_desde&res_sal_fecha_hasta=$txt_fecha_hasta");
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