<?php
/**
**********************************************************
Nombre de archivo:	    ActionSaveFiles.php
Prop�sito:				Permite desplegar tramite estado
Tabla:					
Par�metros:				$cant
$puntero
$sortcol
$sortdirx
$criterio_filtro
$id_usuario_asignacion

Valores de Retorno:    
Fecha de Creaci�n:		27-10-2014
Versi�n:				1.0.0
Autor:					UNKNOW
**********************************************************
*/
session_start();
include_once("../LibModeloAlma.php"); 
$Custom = new cls_CustomDBAlma();
$nombre_archivo = 'ActionSaveFiles.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}

if($_SESSION['autentificado']=="SI")
{
		include_once("../../lib/funciones.inc.php");
		
		$id_proy=$id_proyecto;
	
		$f = new funciones();
		$ruta=$f->public_base_directory();//'/opt/lampp/htdocs/endesis_almacenes/sis_almacenes/archivos_proyectos/';
		//$ruta='/opt/lampp/htdocs/endesis_almacenes/sis_almacenes/archivos_proyectos/';
		$nombre_archivo = $HTTP_POST_FILES['txt_archivo']['name'];
		$arch = $HTTP_POST_FILES['txt_archivo']['tmp_name'];
		
		$file = $f->carga_archivo( $_FILES['txt_archivo'],$ruta); 
		
		//$res = $Custom->ProcesarArchivo($file,$id_proy,$ruta);
		$res = $Custom->ProcesarArchivoItemsProyecto($file,$id_proy,$ruta);
		
		if(!$res)
		{
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = $Custom->salida[1];
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje();
			exit();
		}
		else
		{
			$mensaje_exito = 'Se cargaron los registros satisfactoriamente';
			$resp = new cls_manejo_mensajes(false);
			$resp->add_nodo('mensaje', $mensaje_exito);
			$resp->add_nodo('tiempo_resp', '200');
			echo $resp->get_mensaje();
			exit;
		}

}	
?>
