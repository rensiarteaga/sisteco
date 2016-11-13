<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCorrespondencia.php
Propósito:				Permite insertar y modificar datos en la tabla tfl_correspondencia
Tabla:					tfl_tfl_correspondencia
Parámetros:				$id_correspondencia
						$id_depto
						$id_documento
						$id_empleado_origen
						$id_uo_origen
						$id_institucion
						$id_persona
						$referencia
						$fecha_origen
						$hora_origen
						$fecha_destino
						$hora_destino
						$accion

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2011-02-11 10:52:59
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloSeguridad.php");

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = "ActionGuardarPersona.php";

$carpeta_destino = '../../control/persona/archivo/';

/*
 * TAMAÑO MAXIMO DEL ARCHIVO
 */

$tMax = 105857600;
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
		
		if($_POST["subearchivo"] == 'si')
			$cont =  1;
		else
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

	$id_persona = $_GET['id_persona']; 
	$txt_foto_persona = $_FILES['foto']['tmp_name'];
	$nombre_foto = $_FILES['foto']['name'];
	$extension = explode("/",$_FILES['foto']['type']);
	
	$res = $Custom->SubirFoto($id_persona, $txt_foto_persona, $nombre_foto, $numero, $extension[1], $_SESSION["ss_id_empleado"]);
		
	if($res)
		unlink('../../control/persona/archivo/'.$Custom->salida[2].'.'.$Custom->salida[3]);

	if(!$res)
	{
		//echo "<script languaje='javascript' type='text/javascript'>alert('Solamente el usuario puede cambiar su foto'); </script>"; exit;	
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = 'Solamente el usuario puede cambiar su foto';
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;
		echo $resp->get_mensaje();
		exit;
	}

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) 
		$mensaje_exito = "Se guardaron todos los datos.";
	else 
		$mensaje_exito = $Custom->salida[1];
	
	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", 1);
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