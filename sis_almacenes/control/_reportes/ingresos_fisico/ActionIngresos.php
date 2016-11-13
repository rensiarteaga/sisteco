<?php

session_start();

include_once("../../rcm_LibModeloAlmacenes.php");
$nombre_archivo = 'ActionIngresos.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
			$id_ingreso=$maestro_id_ingreso;
			
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
			$_SESSION['id_ingreso']=$var; 
			echo($var);
			exit();*/
			
			 
			$_SESSION['rep_ing_id_ingreso']=$id_ingreso; 
			header("location:PDFIngresos.php?id_ingreso=$id_ingreso");
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