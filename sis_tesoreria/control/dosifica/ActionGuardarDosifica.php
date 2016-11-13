<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarDosifica.php
Propósito:				Permite insertar y modificar datos en la tabla tts_dosifica
Tabla:					tts_tts_dosifica
Parámetros:				$id_dosifica
						$fecha_vence
						$llave_activar
						$nro_autoriza
						$nro_inicial
						$nro_final
						$estado_dosifica

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-10-21 10:19:31
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloTesoreria.php");

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = "ActionGuardarDosifica.php";

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
			$id_dosifica= $_GET["id_dosifica_$j"];
			$fecha_vence= $_GET["fecha_vence_$j"];
			$llave_activar= $_GET["llave_activar_$j"];
			$nro_autoriza= $_GET["nro_autoriza_$j"];
			$nro_inicial= $_GET["nro_inicial_$j"];
			$nro_final= $_GET["nro_final_$j"];
			$estado_dosifica= $_GET["estado_dosifica_$j"];

		}
		else
		{
			$id_dosifica=$_POST["id_dosifica_$j"];
			$fecha_vence=$_POST["fecha_vence_$j"];
			$llave_activar=$_POST["llave_activar_$j"];
			$nro_autoriza=$_POST["nro_autoriza_$j"];
			$nro_inicial=$_POST["nro_inicial_$j"];
			$nro_final=$_POST["nro_final_$j"];
			$estado_dosifica=$_POST["estado_dosifica_$j"];

		}

		if ($id_dosifica == "undefined" || $id_dosifica == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarDosifica("insert",$id_dosifica,$fecha_vence,$llave_activar,$nro_autoriza,$nro_inicial,$nro_final,$estado_dosifica);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tts_dosifica
			$res = $Custom -> InsertarDosifica($id_dosifica,$fecha_vence,$llave_activar,$nro_autoriza,$nro_inicial,$nro_final,$estado_dosifica);

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
			$res = $Custom->ValidarDosifica("update",$id_dosifica,$fecha_vence,$llave_activar,$nro_autoriza,$nro_inicial,$nro_final,$estado_dosifica);

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

			$res = $Custom->ModificarDosifica($id_dosifica,$fecha_vence,$llave_activar,$nro_autoriza,$nro_inicial,$nro_final,$estado_dosifica);

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
	if($sortcol == "") $sortcol = "id_dosifica";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarDosifica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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