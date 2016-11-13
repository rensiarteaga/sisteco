<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarMontoViatico.php
Propósito:				Permite realizar el listado en tts_viatico
Tabla:					tts_tts_viatico
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-11-12 11:42:20
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloTesoreria.php');

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = 'ActionListarMontoViatico .php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{

	

	
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarMontosViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_destino,$cobertura,$id_moneda);
	$f=$Custom->salida[0];
	if($res && $f['importe_pasaje']!='')
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',1);
		
		
			$xml->add_rama('ROWS');
			$xml->add_nodo('importe_pasaje',$f["importe_pasaje"]);
			$xml->add_nodo('importe_hotel',$f["importe_hotel"]);
			$xml->add_nodo('importe_viaticos',$f["importe_viaticos"]);
			

			$xml->fin_rama();
		
		$xml->mostrar_xml();
	}
	elseif($f['importe_pasaje']=='')
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true,'406');
		$resp->mensaje_error = 'No Existe Tipo de Cambio para la Fecha Actual';
		$resp->origen = 'f_ts_obtener_viaticos';
		$resp->proc = 'TS_SOLVIA_SEL';
		$resp->nivel = '4';
		$resp->query = '';
		echo $resp->get_mensaje();
		exit;
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