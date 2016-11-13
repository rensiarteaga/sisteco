<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarParametroAlmacen.phpa
Propósito:				Permite insertar y modificar datos en la tabla tal_parametro_almacen
Tabla:					tal_tal_parametro_almacen
Parámetros:				$hidden_id_parametro_almacen
						$txt_dias_reserva
						$txt_cierre
						$txt_gestion
						$txt_bloqueado
						$txt_actualizar
						$txt_observaciones
						$txt_id_cuenta

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-10-18 15:38:46
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = "ActionGuardarParametroAlmacen.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
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
		$cont =  $_POST["cantidad_ids"];
		
		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar.";
		$resp->origen = "ORIGEN = ";
		$resp->proc = "PROC = ";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit;
	}
	
	//Envia al Custom la bandera que indica si se decodificará o no
	$Custom->decodificar = $decodificar;

	//Realiza el bucle por todos los ids mandados
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$hidden_id_parametro_almacen= $_GET["hidden_id_parametro_almacen_$j"];
			$txt_dias_reserva= $_GET["txt_dias_reserva_$j"];
			$txt_cierre= $_GET["txt_cierre_$j"];
			$txt_gestion= $_GET["txt_gestion_$j"];
			$txt_bloqueado= $_GET["txt_bloqueado_$j"];
			$txt_actualizar= $_GET["txt_actualizar_$j"];
			$txt_observaciones= $_GET["txt_observaciones_$j"];
			$txt_id_cuenta= $_GET["txt_id_cuenta_$j"];
			$txt_demasia_porc= $_GET["txt_demasia_porc_$j"];

		}
		else
		{
			$hidden_id_parametro_almacen=$_POST["hidden_id_parametro_almacen_$j"];
			$txt_dias_reserva=$_POST["txt_dias_reserva_$j"];
			$txt_cierre=$_POST["txt_cierre_$j"];
			$txt_gestion=$_POST["txt_gestion_$j"];
			$txt_bloqueado=$_POST["txt_bloqueado_$j"];
			$txt_actualizar=$_POST["txt_actualizar_$j"];
			$txt_observaciones=$_POST["txt_observaciones_$j"];
			$txt_id_cuenta=$_POST["txt_id_cuenta_$j"];
			$txt_demasia_porc= $_POST["txt_demasia_porc_$j"];

		}

		if ($hidden_id_parametro_almacen == "undefined" || $hidden_id_parametro_almacen == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarParametroAlmacen("insert",$hidden_id_parametro_almacen, $txt_dias_reserva,$txt_cierre,$txt_gestion,$txt_bloqueado,$txt_actualizar,$txt_observaciones,$txt_id_cuenta);

			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			//Validación satisfactoria, se ejecuta la inserción en la tabla tal_parametro_almacen
			$res = $Custom -> InsertarParametroAlmacen($hidden_id_parametro_almacen, $txt_dias_reserva, $txt_cierre, $txt_gestion, $txt_bloqueado, $txt_actualizar, $txt_observaciones, $txt_id_cuenta,$txt_demasia_porc);

			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] . " (iteración $cont)";
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		}
		else
		{	///////////////////////Modificación////////////////////
			
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarParametroAlmacen("update",$hidden_id_parametro_almacen, $txt_dias_reserva, $txt_cierre, $txt_gestion, $txt_bloqueado, $txt_actualizar, $txt_observaciones, $txt_id_cuenta);

			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			$res = $Custom->ModificarParametroAlmacen($hidden_id_parametro_almacen, $txt_dias_reserva, $txt_cierre, $txt_gestion, $txt_bloqueado, $txt_actualizar, $txt_observaciones, $txt_id_cuenta,$txt_demasia_porc);

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
		}

	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_parametro_almacen";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarParametroAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", $total_registros);
	$resp->add_nodo("mensaje", $mensaje_exito);
	$resp->add_nodo("tiempo_resp", "200");
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