<?php
/**
**********************************************************
Nombre de archivo:	    ActionObtenerIdEP.php
Propósito:				Permite insertar y modificar datos en la tabla tpm_fina_regi_prog_proy_acti
Tabla:					tpm_tpm_fina_regi_prog_proy_acti
Parámetros:				$hidden_id_fina_regi_prog_proy_acti
						$txt_id_prog_proy_acti
						$txt_id_regional
						$txt_id_financiador

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-11-06 20:47:11
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloParametros.php");

$Custom = new cls_CustomDBParametros();
$nombre_archivo = "ActionObtenerIdEP.php";

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


	if ($get)
	{
		$txt_id_financiador = $_GET["id_financiador"];
		$txt_id_regional	= $_GET["id_regional"];
		$txt_id_programa	= $_GET["id_programa"];
		$txt_id_proyecto	= $_GET["id_proyecto"];
		$txt_id_actividad	= $_GET["id_actividad"];
	}
	else
	{
		$txt_id_financiador = $_POST["id_financiador"];
		$txt_id_regional	= $_POST["id_regional"];
		$txt_id_programa	= $_POST["id_programa"];
		$txt_id_proyecto	= $_POST["id_proyecto"];
		$txt_id_actividad	= $_POST["id_actividad"];
	}


	//Validación satisfactoria, se ejecuta la inserción en la tabla tpm_fina_regi_prog_proy_acti
	$res = $Custom -> ObtenerIdEp($txt_id_financiador,$txt_id_regional,$txt_id_programa,$txt_id_proyecto,$txt_id_actividad);

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

	/*echo"<pre>";
	print_r($Custom->salida);
	echo"</pre>";
	exit;*/
	
	$aux['id_ep']=$Custom->salida[1];
	
	echo json_encode($aux);
	exit;


	//Arma el xml para desplegar el mensaje
	/*$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", 1);
	$resp->add_nodo("id_ep", $Custom->salida[1]);
	$resp->add_nodo("tiempo_resp", "200");
	echo $resp->get_mensaje();
	exit;*/
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