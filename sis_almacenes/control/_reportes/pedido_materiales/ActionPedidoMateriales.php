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
			
			/*echo "id_salidalllllll: ".$maestro_id_salida;
			exit;*/
			/*$node=$maestro_id_tipo_unidad_constructiva;
			$tipo=$maestro_tipo;
			$nombre=$maestro_nombre;
			$terminado=$maestro_terminado;
			$_SESSION['nombre_pie']=$maestro_nombre;
			$_SESSION['nombre_cabecera']=$maestro_nombre;
			$_SESSION['nombre']=$maestro_nombre;
			$nombre_padre=$maestro_nombre_padre;
			$_SESSION['tipo']=$maestro_tipo;
			$_SESSION['nombre_padre']=$maestro_nombre_padre; */
			//echo($id_composicion_tuc);
			//exit();
			$_SESSION['rep_mat_id_salida']=$id_salida; 
			
			header("location:PDFPedidoMateriales.php?id_salida=$id_salida");
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