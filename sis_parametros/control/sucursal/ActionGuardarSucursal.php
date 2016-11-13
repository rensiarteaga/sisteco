<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarSucursal.php
Propósito:				Permite insertar y modificar datos en la tabla tpm_sucursal
Tabla:					tpm_tpm_sucursal
Parámetros:				$hidden_id_sucursal
						$txt_codigo
						$txt_direccion
						$txt_descripcion
						$txt_observaciones
						$txt_fecha_reg
						$txt_id_prog_proy_acti

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-10-24 18:28:46
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloParametros.php");

$Custom = new cls_CustomDBParametros();
$nombre_archivo = "ActionGuardarSucursal.php";

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
			$hidden_id_sucursal= $_GET["hidden_id_sucursal_$j"];
			$txt_nombre= $_GET["txt_nombre_$j"];
			$txt_razon_social= $_GET["txt_razon_social_$j"];
			$txt_nit= $_GET["txt_nit_$j"];
			$txt_direccion= $_GET["txt_direccion_$j"];
			$txt_proyecto= $_GET["txt_proyecto_$j"];
		}
		else
		{		
			$hidden_id_sucursal=$_POST["hidden_id_sucursal_$j"];
			$txt_nombre=$_POST["txt_nombre_$j"];
			$txt_direccion=$_POST["txt_direccion_$j"];
			$txt_razon_social=$_POST["txt_razon_social_$j"];
			$txt_nit=$_POST["txt_nit_$j"];
			$txt_proyecto=$_POST["txt_proyecto_$j"];

		}
/*
echo ('hidden_id_sucursal'.$hidden_id_sucursal);
echo ('txt_nombre'.$txt_nombre);
echo ('txt_direccion'.$txt_direccion);
echo ('txt_razon_social'.$txt_razon_social);
echo ('txt_nit'.$txt_nit);
echo ('txt_proyecto'.$txt_proyecto);
exit();*/
		if ($hidden_id_sucursal == "undefined" || $hidden_id_sucursal == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarSucursal("insert",$hidden_id_sucursal,$txt_nombre,$txt_razon_social,$txt_nit,$txt_direccion,$txt_proyecto);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpm_sucursal
			$res = $Custom -> InsertarSucursal($hidden_id_sucursal,$txt_nombre,$txt_razon_social,$txt_nit,$txt_direccion,$txt_proyecto);

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
			$res = $Custom->ValidarSucursal("update",$hidden_id_sucursal,$txt_nombre,$txt_razon_social,$txt_nit,$txt_direccion,$txt_proyecto);

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

			$res = $Custom->ModificarSucursal($hidden_id_sucursal,$txt_nombre,$txt_razon_social,$txt_nit,$txt_direccion,$txt_proyecto);

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
	if($sortcol == "") $sortcol = "id_sucursal";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarSucursal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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