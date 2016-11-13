<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarMotivoIngreso.php
Propósito:				Permite insertar y modificar datos en la tabla tal_motivo_ingreso
Tabla:					tal_tal_motivo_ingreso
Parámetros:				$hidden_id_motivo_ingreso
						$txt_nombre
						$txt_descripcion
						$txt_estado_registro
						$txt_fecha_reg

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-10-17 15:49:42
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = "ActionGuardarMotivoIngreso.php";

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
			$hidden_id_motivo_ingreso= $_GET["hidden_id_motivo_ingreso_$j"];
			$txt_nombre= $_GET["txt_nombre_$j"];
			$txt_descripcion= $_GET["txt_descripcion_$j"];
			$txt_estado_registro= $_GET["txt_estado_registro_$j"];
			$txt_fecha_reg= $_GET["txt_fecha_reg_$j"];
			$txt_codigo= $_GET["txt_codigo_$j"];
			$txt_tipo= $_GET["txt_tipo_$j"];

		}
		else
		{
			$hidden_id_motivo_ingreso=$_POST["hidden_id_motivo_ingreso_$j"];
			$txt_nombre=$_POST["txt_nombre_$j"];
			$txt_descripcion=$_POST["txt_descripcion_$j"];
			$txt_estado_registro=$_POST["txt_estado_registro_$j"];
			$txt_fecha_reg=$_POST["txt_fecha_reg_$j"];
			$txt_codigo= $_POST["txt_codigo_$j"];
			$txt_tipo= $_POST["txt_tipo_$j"];

		}

		if ($hidden_id_motivo_ingreso == "undefined" || $hidden_id_motivo_ingreso == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarMotivoIngreso("insert",$hidden_id_motivo_ingreso, $txt_nombre,$txt_descripcion,$txt_estado_registro,$txt_fecha_reg,$txt_codigo,$txt_tipo);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tal_motivo_ingreso
			$res = $Custom -> InsertarMotivoIngreso($hidden_id_motivo_ingreso, $txt_nombre, $txt_descripcion, $txt_estado_registro, $txt_fecha_reg,$txt_codigo,$txt_tipo);

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
			$res = $Custom->ValidarMotivoIngreso("update",$hidden_id_motivo_ingreso, $txt_nombre, $txt_descripcion, $txt_estado_registro, $txt_fecha_reg,$txt_codigo,$txt_tipo);

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

			$res = $Custom->ModificarMotivoIngreso($hidden_id_motivo_ingreso, $txt_nombre, $txt_descripcion, $txt_estado_registro, $txt_fecha_reg,$txt_codigo,$txt_tipo);

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
	if($sortcol == "") $sortcol = "id_motivo_ingreso";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarMotivoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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