<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarProcesoCompra.php
Propósito:				Permite realizar el listado en tad_proceso_compra
Tabla:					t_tad_proceso_compra
Parámetros:				id_proceso_compra

Valores de Retorno:    inicia una nueva convocatoria
Fecha de Creación:		2008-06-2 11:00
Versión:				1.0.0
Autor:					Rensi Arteaga Copari
**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionNuevaConvocatoria.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{


	//Obtiene el conjunto de datos de la consulta
	$res = $Custom -> VerificarDatosReversion("pc.id_proceso_compra=$id_proceso_compra");
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',1);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			 /*varchar,proveedor text,impuestos varchar,num_factura integer,fecha_factura date,cantidad_sol numeric,cant_total numeric,id_moneda int4,
			 simbolo varchar,estado_vigente varchar,id_cotizacion int4*/
			
			$xml->add_nodo('comp_pg', $f['comp_pg']);
			$xml->add_nodo('eje_pg', $f['eje_pg']);
			$xml->add_nodo('comp_sg', $f['comp_sg']);
			$xml->add_nodo('eje_sg', $f['eje_sg']);
			$xml->fin_rama();
		}
		$xml->mostrar_xml();
	}
	else
	{
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