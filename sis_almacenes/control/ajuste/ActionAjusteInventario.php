<?php
/*
**********************************************************
Nombre de archivo:	    ActionAjusteInventario.php
Fecha de Creación:		
Versión:				
Autor:					
**********************************************************
*/
session_start();
include_once("../LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = 'ActionAjusteInventario.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	//Verifica si los datos vienen por POST o GET
	if (sizeof($_GET) > 0)
	{
		$get=true;
		$cont=1;
		
		//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
		//valores permitidos de $cod -> "si", "no"
		switch ($cod)
		{
			case "si":
				$decodificar = true;
				break;
			case "no":
				$decodificar = false;
				break;
			default:
				$decodificar = true;
				break;
		}
	}
	elseif(sizeof($_POST) > 0)
	{
		$get = false;
		$cont =  $_POST['cantidad_ids'];
		
		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = 'NIVEL = 4';
		echo $resp->get_mensaje();
		exit;
	}
	
	//Envia al Custom la bandera que indica si se decodificará o no
	$Custom->decodificar = $decodificar;

	//Realiza el bucle por todos los ids mandados
	
		if ($get)
		{
			$txt_id_almacen			= $_GET["txt_id_almacen"];
			$txt_id_almacen_logico  = $_GET["txt_id_almacen_logico"];
			$txt_tipo_ajuste		= $_GET["txt_tipo_ajuste"];
			$txt_id_ep				= $_GET["hidden_id_ep1"];
			$txt_id_item			= $_GET["txt_id_item"];
			$txt_cantidad			= $_GET["txt_cantidad"];
			$txt_estado_item		= $_GET["txt_estado_item"];
			
		}
		else
		{
			$txt_id_almacen			= $_POST["txt_id_almacen"];
			$txt_id_almacen_logico  = $_POST["txt_id_almacen_logico"];
			$txt_tipo_ajuste		= $_POST["txt_tipo_ajuste"];
			$txt_id_ep				= $_POST["hidden_id_ep1"];
			$txt_id_item			= $_POST["txt_id_item"];
			$txt_cantidad			= $_POST["txt_cantidad"];
			$txt_estado_item		= $_POST["txt_estado_item"];
			
		}
		

		$res = $Custom->AjusteInventario($txt_id_ep,$txt_id_almacen,$txt_id_almacen_logico,$txt_tipo_ajuste,$txt_id_item,$txt_cantidad,$txt_estado_item);
			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
	

	

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = 'Se guardaron todos los datos.';
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'id_inventario';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro = '0=0';

	

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo('TotalCount', $total_registros);
	$resp->add_nodo('mensaje', $mensaje_exito);
	$resp->add_nodo('tiempo_resp', '200');
	echo $resp->get_mensaje();
	exit;
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 1';
	echo $resp->get_mensaje();
	exit;
}
?>