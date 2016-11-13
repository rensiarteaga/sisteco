<?php

session_start();

//include_once("../../rcm_LibModeloAlmacenes.php");
include_once('../../LibModeloAlmacenes.php');
$nombre_archivo = 'ActionClasificacionItem_.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
			$id_ingreso=$maestro_id_ingreso;
			
			/*$node=$maestro_id_tipo_unidad_constructiva;
			$tipo=$maestro_tipo;
			$nombre=$maestro_nombre;
			$terminado=$maestro_terminado;*/
			
			$_SESSION['id_supergrupo']=$txt_id_supergrupo;
			$_SESSION['id_grupo']=$txt_id_grupo;
			$_SESSION['id_subgrupo']=$txt_id_subgrupo;
			$_SESSION['id_id1']=$txt_id_id1;
			$_SESSION['id_id2']=$txt_id_id2;
			$_SESSION['id_id3']=$txt_id_id3;
			
			/*$_SESSION['nombre_cabecera']=$maestro_nombre;
			$_SESSION['nombre']=$maestro_nombre;
			$nombre_padre=$maestro_nombre_padre;
			$_SESSION['tipo']=$maestro_tipo;
			$_SESSION['id_ingreso']=$var; 
						
			 
			$_SESSION['rep_ing_id_ingreso']=$id_ingreso; */
			
			
			header("location:PDFClasificacionItem.php?");
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