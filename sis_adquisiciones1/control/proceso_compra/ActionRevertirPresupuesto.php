<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarProcesoCompra.php
Propósito:				Permite realizar el listado en tad_proceso_compra
Tabla:					t_tad_proceso_compra
Parámetros:				id_proceso_compra

Valores de Retorno:    Revierte el presupuesto sobranteven el proceso
Fecha de Creación:		2008-06-2 11:00
Versión:				1.0.0
Autor:					Rensi Arteaga Copari
**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionRevertirPresupuesto.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{


	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->RevertirPresupuestoProceso($id_proceso_compra);
	if(!$res)
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true,'406');
		$num_convocatoria++;
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
	$tmp['respuesta'] = $Custom->salida[1];
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