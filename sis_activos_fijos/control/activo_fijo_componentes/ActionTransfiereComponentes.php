<?php
/**
 * Nombre del archivo:	ActionTransfiereComponentes.php
 * Propósito:			Permite transferir componentes entre activos fijos
 * Tabla:				taf_activo_fijo_componentes
 * Parámetros:			
 * Valores de Retorno:	
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creación:		11-07-2007
 */
session_start();

include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionTransfiereComponentes.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{

	if (sizeof($_GET) >0)
	{
		$get = true;
		$cont = 1;
	}
	elseif(sizeof($_POST) >0)
	{
		$get = false;
		$cont =  $_POST['cantidad_ids'];
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para la transferencia.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit;
	}



	if ($get)
	{
		$hidden_id_componente = $_GET["hidden_id_componente"];
		$hidden_id_activo_fijo = $_GET["hidden_id_activo_fijo"];
		$hidden_id_activo_fijo_destino = $_GET["hidden_id_activo_fijo_destino"];
	}
	else
	{
		$hidden_id_componente = $_POST["hidden_id_componente"];
		$hidden_id_activo_fijo = $_POST["hidden_id_activo_fijo"];
		$hidden_id_activo_fijo_destino = $_POST["hidden_id_activo_fijo_destino"];
	}

	if ($hidden_id_componente == "undefined" || $hidden_id_componente =="")
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existe el Componente especificado para transferir.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit;
	}
	else
	{
		//Eliminación
		$res = $Custom-> TransferirComponente($hidden_id_componente, $hidden_id_activo_fijo, $hidden_id_activo_fijo_destino);
		if(!$res)
		{
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = $Custom->salida[1] ;
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje();
			exit;
		}
	}


	//Guarda el mensaje de éxito de la operación realizada
	if($cont>1) $mensaje_exito = 'Transferencia realizada.';
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'id_componente';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro = '0=0';

	$res = $Custom->ContarListaActivoFijoComponentes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo('TotalCount', $total_registros);
	$resp->add_nodo('mensaje',$mensaje_exito);
	$resp->add_nodo('tiempo_resp', '200');
	echo $resp->get_mensaje();
	exit;
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp->get_mensaje();
	exit;
}
?>



