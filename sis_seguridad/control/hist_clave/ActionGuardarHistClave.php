<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarHistClave.php
Propósito:				Permite insertar y modificar datos en la tabla tsg_hist_clave
Tabla:					tsg_tsg_hist_clave
Parámetros:				$hidden_id_hist_clave
						$txt_id_usuario
						$txt_fecha_cambio
						$txt_hora_cambio
						$txt_contrasenia_anterior

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-10-26 17:45:45
Versión:				1.0.0
Autor:					Mercedes Zambrana Meneses
**********************************************************
*/
session_start();
include_once("../LibModeloSeguridad.php");

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = "ActionGuardarHistClave.php";

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
			$hidden_id_hist_clave= $_GET["hidden_id_hist_clave_$j"];
			$txt_id_usuario= $_GET["txt_id_usuario_$j"];
			$txt_fecha_cambio= $_GET["txt_fecha_cambio_$j"];
			$txt_hora_cambio= $_GET["txt_hora_cambio_$j"];
			$txt_contrasenia_anterior= $_GET["txt_contrasenia_anterior_$j"];

		}
		else
		{
			$hidden_id_hist_clave=$_POST["hidden_id_hist_clave_$j"];
			$txt_id_usuario=$_POST["txt_id_usuario_$j"];
			$txt_fecha_cambio=$_POST["txt_fecha_cambio_$j"];
			$txt_hora_cambio=$_POST["txt_hora_cambio_$j"];
			$txt_contrasenia_anterior=$_POST["txt_contrasenia_anterior_$j"];

		}

		if ($hidden_id_hist_clave == "undefined" || $hidden_id_hist_clave == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarHistClave("insert",$hidden_id_hist_clave, $txt_id_usuario,$txt_fecha_cambio,$txt_hora_cambio,$txt_contrasenia_anterior);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tsg_hist_clave
			$res = $Custom -> InsertarHistClave($hidden_id_hist_clave, $txt_id_usuario, $txt_fecha_cambio, $txt_hora_cambio, $txt_contrasenia_anterior);

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
			$res = $Custom->ValidarHistClave("update",$hidden_id_hist_clave, $txt_id_usuario, $txt_fecha_cambio, $txt_hora_cambio, $txt_contrasenia_anterior);

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

			$res = $Custom->ModificarHistClave($hidden_id_hist_clave, $txt_id_usuario, $txt_fecha_cambio, $txt_hora_cambio, $txt_contrasenia_anterior);

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
	if($sortcol == "") $sortcol = "id_hist_clave";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "USUARI.id_usuario=''$m_id_usuario''";

	$res = $Custom->ContarHistClave($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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