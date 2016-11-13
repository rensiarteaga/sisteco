<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarParametroKardex.php
Propósito:				Permite insertar y modificar datos en la tabla tkp_parametro_kardex
Tabla:					tkp_tkp_parametro_kardex
Parámetros:				$id_parametro_kardex
						$id_gestion

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2010-08-13 09:27:55
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = "ActionGuardarParametroKardex.php";

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
			$id_parametro_kardex= $_GET["id_parametro_kardex_$j"];
			$id_gestion= $_GET["id_gestion_$j"];
			$salario_min_nacional= $_GET["salario_min_nacional_$j"];
			$id_moneda= $_GET["id_moneda_$j"];
			$porcen_fijo_cooperativa= $_GET["porcen_fijo_cooperativa_$j"];
			$aporte_fijo_min_cooperativa= $_GET["aporte_fijo_min_cooperativa_$j"];
			$estado_reg= $_GET["estado_reg_$j"];
			$fecha_reg= $_GET["fecha_reg_$j"];
			$porcen_max_quincena= $_GET["porcen_max_quincena_$j"];
			$id_moneda_coop= $_GET["id_moneda_coop_$j"];
			$horas_mes_laboral= $_GET["horas_mes_laboral_$j"];
			$fecha_inicio=$_GET["fecha_inicio_$j"];
		}
		else
		{
			$id_parametro_kardex=$_POST["id_parametro_kardex_$j"];
			$id_gestion=$_POST["id_gestion_$j"];
			$salario_min_nacional= $_POST["salario_min_nacional_$j"];
			$id_moneda= $_POST["id_moneda_$j"];
			$porcen_fijo_cooperativa= $_POST["porcen_fijo_cooperativa_$j"];
			$aporte_fijo_min_cooperativa= $_POST["aporte_fijo_min_cooperativa_$j"];
			$estado_reg= $_POST["estado_reg_$j"];
			$fecha_reg= $_POST["fecha_reg_$j"];
			$porcen_max_quincena= $_POST["porcen_max_quincena_$j"];
			$id_moneda_coop= $_POST["id_moneda_coop_$j"];
			$horas_mes_laboral= $_POST["horas_mes_laboral_$j"];
			$fecha_inicio=$_POST["fecha_inicio_$j"];
		}

		if ($id_parametro_kardex == "undefined" || $id_parametro_kardex == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarParametroKardex("insert",$id_parametro_kardex,$id_gestion,$salario_min_nacional,$id_moneda,$porcen_fijo_cooperativa,$aporte_fijo_min_cooperativa,$estado_reg,$fecha_reg);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tkp_parametro_kardex
			$res = $Custom -> InsertarParametroKardex($id_parametro_kardex,$id_gestion,$salario_min_nacional,$id_moneda,$porcen_fijo_cooperativa,$aporte_fijo_min_cooperativa,$estado_reg,$fecha_reg,$porcen_max_quincena,$id_moneda_coop,$horas_mes_laboral);

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
			$res = $Custom->ValidarParametroKardex("update",$id_parametro_kardex,$id_gestion,$salario_min_nacional,$id_moneda,$porcen_fijo_cooperativa,$aporte_fijo_min_cooperativa,$estado_reg,$fecha_reg);

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

			$res = $Custom->ModificarParametroKardex($id_parametro_kardex,$id_gestion,$salario_min_nacional,$id_moneda,$porcen_fijo_cooperativa,$aporte_fijo_min_cooperativa,$estado_reg,$fecha_reg,$porcen_max_quincena,$id_moneda_coop,$horas_mes_laboral,$fecha_inicio);

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
	if($sortcol == "") $sortcol = "id_parametro_kardex";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarParametroKardex($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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