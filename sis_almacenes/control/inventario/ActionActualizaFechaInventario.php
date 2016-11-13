<?php
/*
**********************************************************
Nombre de archivo:	    ActionActualizaFechaInventario.php
Propósito:				Permite convertir un material a item
Tabla:					tal_inventario
Parámetros:				$hidden_id_inventario
Valores de Retorno:    	Número de registros
Fecha de Creación:		01-11-2007
Versión:				1.0.0
Autor:					Susana Castro Guaman
**********************************************************
*/
session_start();
include_once("../scg_LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = 'ActionActualizaFechaInventario.php';

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
		{	case "si":
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
	{	$get = false;
		$cont =  $_POST['cantidad_ids'];
		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{	$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para crear item.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = 'NIVEL = 4';
		echo $resp->get_mensaje();
		exit;
	}
	//Envia al Custom la bandera que indica si se decodificará o no
	$Custom->decodificar = $decodificar;
	//Realiza el bucle por todos los ids mandados
	for($j = 0;$j < $cont; $j++)
	{	if ($get)
		{	$hidden_id_inventario = $_GET["txt_id_inventario_$j"];
			}
		else
		{$hidden_id_inventario = $_POST["txt_id_inventario_$j"];
		}

		////////////////////crea item/////////////////////
		if ($hidden_id_inventario == "undefined" || $hidden_id_inventario == "")
		 {	//Error de validación
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = "Inventario inexistente";
			$resp->origen = $nombre_archivo;
			$resp->proc = "";
			$resp->nivel = "3";
			echo $resp->get_mensaje();
			exit;
		 } 
		 else
		 {    $res = $Custom->ActualizaFechaInventario($hidden_id_inventario);
			if(!$res)
			{	//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] . " (iteración $cont)";
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;	}
				 }

	}//END FOR
	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = 'Se Rechazó el inventario correctamente.';
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
{   $resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 1';
	echo $resp->get_mensaje();
	exit;
}
?>