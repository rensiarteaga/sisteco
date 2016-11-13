<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarEmpleadoTpmFrppa.php
Propósito:				Permite insertar y modificar datos en la tabla tkp_empleado_tpm_frppa
Tabla:					tkp_tkp_empleado_tpm_frppa
Parámetros:				$hidden_id_empleado_frppa
						$txt_id_empleado
						$txt_fecha_registro
						$txt_hora_ingreso
						$txt_id_fina_regi_prog_proy_acti

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-10-18 09:44:24
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = "ActionGuardarEmpleadoTpmFrppa.php";

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
			$hidden_id_empleado_frppa= $_GET["hidden_id_empleado_frppa_$j"];
			$txt_id_empleado= $_GET["txt_id_empleado_$j"];
			$txt_fecha_registro= $_GET["txt_fecha_registro_$j"];
			$txt_hora_ingreso= $_GET["txt_hora_ingreso_$j"];
            $txt_id_financiador= $_GET["txt_id_financiador_$j"];
			$txt_id_regional	= $_GET["txt_id_regional_$j"];
			$txt_id_programa	= $_GET["txt_id_programa_$j"];
			$txt_id_proyecto	= $_GET["txt_id_proyecto_$j"];
			$txt_id_actividad	= $_GET["txt_id_actividad_$j"];
				$estado_reg= $_GET["estado_reg_$j"];
		}
		else
		{
			$hidden_id_empleado_frppa=$_POST["hidden_id_empleado_frppa_$j"];
			$txt_id_empleado=$_POST["txt_id_empleado_$j"];
			$txt_fecha_registro=$_POST["txt_fecha_registro_$j"];
			$txt_hora_ingreso=$_POST["txt_hora_ingreso_$j"];
            $txt_id_financiador= $_POST["txt_id_financiador_$j"];
			$txt_id_regional	= $_POST["txt_id_regional_$j"];
			$txt_id_programa	= $_POST["txt_id_programa_$j"];
			$txt_id_proyecto	= $_POST["txt_id_proyecto_$j"];
			$txt_id_actividad	= $_POST["txt_id_actividad_$j"];
			$estado_reg= $_POST["estado_reg_$j"];
		}

		if ($hidden_id_empleado_frppa == "undefined" || $hidden_id_empleado_frppa == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarEmpleadoTpmFrppa("insert",$hidden_id_empleado_frppa, $txt_id_empleado,$txt_fecha_registro,$txt_hora_ingreso,$txt_id_financiador,$txt_id_regional,$txt_id_programa,$txt_id_proyecto,$txt_id_actividad,$estado_reg);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tkp_empleado_tpm_frppa
			$res = $Custom -> InsertarEmpleadoTpmFrppa($hidden_id_empleado_frppa, $txt_id_empleado, $txt_fecha_registro, $txt_hora_ingreso, $txt_id_financiador,$txt_id_regional,$txt_id_programa,$txt_id_proyecto,$txt_id_actividad,$estado_reg);

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
			$res = $Custom->ValidarEmpleadoTpmFrppa("update",$hidden_id_empleado_frppa, $txt_id_empleado, $txt_fecha_registro, $txt_hora_ingreso, $txt_id_financiador,$txt_id_regional,$txt_id_programa,$txt_id_proyecto,$txt_id_actividad,$estado_reg);

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

			$res = $Custom->ModificarEmpleadoTpmFrppa($hidden_id_empleado_frppa, $txt_id_empleado, $txt_fecha_registro, $txt_hora_ingreso, $txt_id_financiador,$txt_id_regional,$txt_id_programa,$txt_id_proyecto,$txt_id_actividad,$estado_reg);

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
	if($sortcol == "") $sortcol = "id_empleado_frppa";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "EMPLEA.id_empleado=''$m_id_empleado''";

	$res = $Custom->ContarEmpleadoTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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