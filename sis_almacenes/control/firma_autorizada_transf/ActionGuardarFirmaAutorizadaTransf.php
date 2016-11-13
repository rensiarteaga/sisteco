<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarFirmaAutorizadaTransf.php
Propósito:				Permite insertar y modificar datos en la tabla tal_firma_autorizada_transf
Tabla:					tal_tal_firma_autorizada_transf
Parámetros:				$hidden_id_firma_autorizada_transf
						$txt_estado_registro
						$txt_fecha_registro
						$txt_id_empleado
						$txt_id_motivo_ingreso_cuenta
						$txt_id_motivo_salida_cuenta

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-12-13 10:11:00
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../arv_LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = "ActionGuardarFirmaAutorizadaTransf.php";

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
			$hidden_id_firma_autorizada_transf= $_GET["hidden_id_firma_autorizada_transf_$j"];
			$txt_estado_registro= $_GET["txt_estado_registro_$j"];
			$txt_fecha_registro= $_GET["txt_fecha_registro_$j"];
			$txt_id_empleado= $_GET["txt_id_empleado_$j"];
			
			$txt_id_motivo_ingreso_cuenta= $_GET["txt_id_motivo_ingreso_cuenta_$j"];
			$txt_id_motivo_salida_cuenta= $_GET["txt_id_motivo_salida_cuenta_$j"];

		}
		else
		{
			$hidden_id_firma_autorizada_transf=$_POST["hidden_id_firma_autorizada_transf_$j"];
			$txt_estado_registro=$_POST["txt_estado_registro_$j"];
			$txt_fecha_registro=$_POST["txt_fecha_registro_$j"];
			$txt_id_empleado=$_POST["txt_id_empleado_$j"];
			$txt_id_motivo_ingreso_cuenta=$_POST["txt_id_motivo_ingreso_cuenta_$j"];
			$txt_id_motivo_salida_cuenta=$_POST["txt_id_motivo_salida_cuenta_$j"];

		}

		if ($hidden_id_firma_autorizada_transf == "undefined" || $hidden_id_firma_autorizada_transf == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarFirmaAutorizadaTransf("insert",$hidden_id_firma_autorizada_transf, $txt_estado_registro,$txt_fecha_registro,$txt_id_empleado,$txt_id_motivo_ingreso_cuenta,$txt_id_motivo_salida_cuenta);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tal_firma_autorizada_transf
			$res = $Custom -> InsertarFirmaAutorizadaTransf($hidden_id_firma_autorizada_transf, $txt_estado_registro, $txt_fecha_registro, $txt_id_empleado, $txt_id_motivo_ingreso_cuenta, $txt_id_motivo_salida_cuenta);

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
			$res = $Custom->ValidarFirmaAutorizadaTransf("update",$hidden_id_firma_autorizada_transf, $txt_estado_registro, $txt_fecha_registro, $txt_id_empleado, $txt_id_motivo_ingreso_cuenta, $txt_id_motivo_salida_cuenta);

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

			$res = $Custom->ModificarFirmaAutorizadaTransf($hidden_id_firma_autorizada_transf, $txt_estado_registro, $txt_fecha_registro, $txt_id_empleado, $txt_id_motivo_ingreso_cuenta, $txt_id_motivo_salida_cuenta);

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
	if($sortcol == "") $sortcol = "id_firma_autorizada_transf";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarFirmaAutorizadaTransf($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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