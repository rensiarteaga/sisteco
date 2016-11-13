<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarTipoDocumentoAdq.php
Propósito:				Devuelve el tipo de documento de adquisiciones a partir de id_cotizacion e id_plan_pago
Tabla:					f_ts_ad_obtener_tipo_documento
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Tipo de Documento
Fecha de Creación:		22/05/2009
Versión:				1.0.0
Autor:					RCM
**********************************************************
*/
session_start();
include_once('../LibModeloTesoreria.php');

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = 'ActionListarTipoDocumentoAdq.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
	$id_cotizacion;
	$id_plan_pago;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ObtenerTipoDocumentoAdq($id_cotizacion,$id_plan_pago);

	if(!$res){
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true,'406');
		$resp->mensaje_error = $Custom->salida[1];
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;
		echo $resp->get_mensaje();
		exit;
	}
	$respuesta=$Custom->salida;
	$xml = new cls_manejo_xml('ROOT');
	$xml->add_nodo('tipo_documento',$respuesta[1]);
	$xml->add_nodo('tipo',$respuesta[2]);
	$xml->mostrar_xml();
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