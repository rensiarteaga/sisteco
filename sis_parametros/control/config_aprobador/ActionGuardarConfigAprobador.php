<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarConfigAprobador.php
Propósito:				Permite insertar y modificar datos en la tabla tpm_config_aprobador
Tabla:					tpm_config_aprobador
Parámetros:				$hidden_id_contratista
						$txt_codigo
						$txt_observaciones
						$txt_estado_registro
						$txt_fecha_reg
						$txt_id_institucion
						$txt_id_persona

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-11-06 21:05:13
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloParametros.php");

$Custom = new cls_CustomDBParametros();
$nombre_archivo = "ActionGuardarConfigAprobador.php";

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
			$hidden_id_config_aprobador= $_GET["hidden_id_config_aprobador_$j"];
			$txt_id_gestion= $_GET["txt_id_gestion_$j"];
			$txt_id_presupuesto= $_GET["txt_id_presupuesto_$j"];
			$txt_id_uo= $_GET["txt_id_uo_$j"];
			$txt_concepto= $_GET["txt_concepto_$j"];
			$txt_min_monto= $_GET["txt_min_monto_$j"];
			$txt_max_monto= $_GET["txt_max_monto_$j"];
			$txt_id_empleado= $_GET["txt_id_empleado_$j"];
            $txt_prioridad= $_GET["txt_prioridad_$j"];
			$txt_estado= $_GET["txt_estado_$j"];
			$txt_fecha_expiracion= $_GET["txt_fecha_expiracion_$j"];
		}
		else
		{
			$hidden_id_config_aprobador= $_POST["hidden_id_config_aprobador_$j"];
			$txt_id_gestion= $_POST["txt_id_gestion_$j"];
			$txt_id_presupuesto= $_POST["txt_id_presupuesto_$j"];
			$txt_id_uo= $_POST["txt_id_uo_$j"];
			$txt_concepto= $_POST["txt_concepto_$j"];
			$txt_min_monto= $_POST["txt_min_monto_$j"];
			$txt_max_monto= $_POST["txt_max_monto_$j"];
			$txt_id_empleado= $_POST["txt_id_empleado_$j"];
            $txt_prioridad= $_POST["txt_prioridad_$j"];
			$txt_estado= $_POST["txt_estado_$j"];
			$txt_fecha_expiracion= $_POST["txt_fecha_expiracion_$j"];
		}

		if ($hidden_id_config_aprobador == "undefined" || $hidden_id_config_aprobador == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			                                            
			$res = $Custom->ValidarConfigAprobador("insert",$hidden_id_config_aprobador, $txt_id_gestion,$txt_id_presupuesto,$txt_id_uo,$txt_concepto,$txt_min_monto,$txt_max_monto,$txt_id_empleado,$txt_prioridad);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpm_contratista
			$res = $Custom -> InsertarConfigAprobador($hidden_id_config_aprobador, $txt_id_gestion,$txt_id_presupuesto,$txt_id_uo,$txt_concepto,$txt_min_monto,$txt_max_monto,$txt_id_empleado,$txt_prioridad,$txt_estado,$txt_fecha_expiracion);

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
			$res = $Custom->ValidarConfigAprobador("update",$hidden_id_config_aprobador, $txt_id_gestion,$txt_id_presupuesto,$txt_id_uo,$txt_concepto,$txt_min_monto,$txt_max_monto,$txt_id_empleado,$txt_prioridad);

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

			$res = $Custom->ModificarConfigAprobador($hidden_id_config_aprobador, $txt_id_gestion,$txt_id_presupuesto,$txt_id_uo,$txt_concepto,$txt_min_monto,$txt_max_monto,$txt_id_empleado,$txt_prioridad,$txt_estado,$txt_fecha_expiracion);

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
	if($sortcol == "") $sortcol = "id_config_aprobador";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarConfigAprobador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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