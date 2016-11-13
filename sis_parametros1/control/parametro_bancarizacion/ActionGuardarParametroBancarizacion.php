<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarParametroBancarizacion.php
Propósito:				Permite insertar y modificar datos en la tabla tpm_ParametroBancarizacion
Tabla:					tpm_tpm_ParametroBancarizacion
Parámetros:				$id_ParametroBancarizacion
						$razon_social
						$denominacion
						$nro_nit
						$codigo

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		22.07.2015
Versión:				1.0.0
Autor:					Mercedes Zambrana Meneses
**********************************************************
*/
session_start();
include_once("../LibModeloParametros.php");

$Custom = new cls_CustomDBParametros();
$nombre_archivo = "ActionGuardarParametroBancarizacion.php";

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
			$id_parametro_bancarizacion= $_GET["id_parametro_bancarizacion_$j"];
			$monto=$_GET["monto_$j"];
			$id_moneda=$_GET["id_moneda_$j"];
			$estado_reg=$_GET["estado_reg_$j"];
			$fecha_ini=$_GET["fecha_ini_$j"];
			$fecha_fin=$_GET["fecha_fin_$j"];
			$usuario_reg=$_GET["usuario_reg_$j"];
			$fecha_reg=$_GET["fecha_reg_$j"];
			$desc_moneda=$_GET["desc_moneda_$j"];
		}
		else
		{
			$id_parametro_bancarizacion= $_POST["id_parametro_bancarizacion_$j"];
			$monto=$_POST["monto_$j"];
			$id_moneda=$_POST["id_moneda_$j"];
			$estado_reg=$_POST["estado_reg_$j"];
			$fecha_ini=$_POST["fecha_ini_$j"];
			$fecha_fin=$_POST["fecha_fin_$j"];
			$usuario_reg=$_POST["usuario_reg_$j"];
			$fecha_reg=$_POST["fecha_reg_$j"];
			$desc_moneda=$_POST["desc_moneda_$j"];
		}

		if ($id_parametro_bancarizacion == "undefined" || $id_parametro_bancarizacion == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarParametroBancarizacion("insert",$id_parametro_bancarizacion,$monto, $id_moneda,$fecha_ini);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpm_ParametroBancarizacion
			$res = $Custom -> InsertarParametroBancarizacion($id_parametro_bancarizacion,$monto, $id_moneda,$fecha_ini);

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
			$res = $Custom->ValidarParametroBancarizacion("update",$id_parametro_bancarizacion,$monto, $id_moneda,$fecha_ini);

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

			$res = $Custom->ModificarParametroBancarizacion($id_parametro_bancarizacion,$monto, $id_moneda,$estado_reg,$fecha_ini,$fecha_fin);

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
	if($sortcol == "") $sortcol = "id_parametro_bancarizacion";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarParametroBancarizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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