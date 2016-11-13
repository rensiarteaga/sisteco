<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarProcesoCompraDir.php
Propósito:				Permite realizar el listado en tad_proceso_compra
Tabla:					t_tad_proceso_compra
Parámetros:				id_proceso_compra

Valores de Retorno:    inicia una nueva convocatoria


**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionFinalizarProcesoCompraDir.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI'){

    $res = $Custom-> FinalizarProcesoCompraDir($id_proceso_compra,$_SESSION["ss_id_empresa"]);
	if(!$res){
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true,'406');
		$num_convocatoria++;
		//$resp->mensaje_error = $Custom->salida[1]."<br> El proceso ya tiene una $num_convocatoria  convocatoria";
		$resp->mensaje_error = $Custom->salida[1];
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;
		echo $resp->get_mensaje();
		exit;
	}
	
	//Devuelve el Id del TUC creado
	$tmp['success']=true;
	$tmp['respuesta'] = $Custom->salida[2];
	echo json_encode($tmp);
	exit;
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