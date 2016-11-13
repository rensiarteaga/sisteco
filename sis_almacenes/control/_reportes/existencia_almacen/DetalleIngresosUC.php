<?php

session_start();

include_once("../../rcm_LibModeloAlmacenes.php");
$nombre_archivo = 'UnidadConstructiva.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
			$id_composicion_tuc=$maestro_id_composicion_tuc;
			$node=$maestro_id_tipo_unidad_constructiva;
			$tipo=$maestro_tipo;
			$nombre=$maestro_nombre;
			$terminado=$maestro_terminado;
			$_SESSION['nombre_pie']=$maestro_nombre;
			$_SESSION['nombre_cabecera']=$maestro_nombre;
			$_SESSION['nombre']=$maestro_nombre;
			$nombre_padre=$maestro_nombre_padre;
			$_SESSION['tipo_maestro']=$maestro_tipo;
			$_SESSION['nombre_padre']=$maestro_nombre_padre; 
			//echo($id_composicion_tuc);
			//exit();
			header("location:PDFDetalleIngresosUC.php?node=$node&terminado=$terminado&tipo=$tipo&nombre=$nombre&nombre_padre=$nombre_padre");
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