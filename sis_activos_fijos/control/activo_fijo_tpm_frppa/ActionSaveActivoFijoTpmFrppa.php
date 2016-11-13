<?php
/**
 * Nombre del archivo:	ActionSaveActivoFijoTpmFrppa.php
 * Propósito:			Permite insertar y modificar registros de las relaciones de la estructura programática con Activos Fijos
 * Tabla:				taf_activo_fijo_tpm_frppa
 * Parámetros:			
 * Valores de Retorno:	
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creación:		21-06-2007
 */
session_start();
include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionSaveActivoFijoTpmFrppa.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
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
		$cont =  $_POST['cantidad_ids'];
		
		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = 'NIVEL = 4';
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
			$hidden_id_activo_fijo_frppa = $_GET["hidden_id_activo_fijo_frppa_$j"];
			$txt_estado = $_GET["txt_estado_$j"];
			$txt_fecha_reg = $_GET["txt_fecha_reg_$j"];
			$hidden_id_activo_fijo = $_GET["hidden_id_activo_fijo"];
			$hidden_id_financiador = $_GET["hidden_id_financiador_$j"];
			$hidden_id_regional = $_GET["hidden_id_regional_$j"];
			$hidden_id_programa = $_GET["hidden_id_programa_$j"];
			$hidden_id_proyecto = $_GET["hidden_id_proyecto_$j"];
			$hidden_id_actividad = $_GET["hidden_id_actividad_$j"];
		}
		else
		{
			$hidden_id_activo_fijo_frppa = $_POST["hidden_id_activo_fijo_frppa_$j"];
			$txt_estado = $_POST["txt_estado_$j"];
			$txt_fecha_reg = $_POST["txt_fecha_reg_$j"];
			$hidden_id_activo_fijo = $_POST["hidden_id_activo_fijo"];
			$hidden_id_financiador = $_POST["hidden_id_financiador_$j"];
			$hidden_id_regional = $_POST["hidden_id_regional_$j"];
			$hidden_id_programa = $_POST["hidden_id_programa_$j"];
			$hidden_id_proyecto = $_POST["hidden_id_proyecto_$j"];
			$hidden_id_actividad = $_POST["hidden_id_actividad_$j"];
		}

		if ($hidden_id_activo_fijo_frppa == "undefined" || $hidden_id_activo_fijo_frppa == "")
		{
			////////////////////Inserción/////////////////////
			
			//Por defecto se coloca el estado como activo en caso de inserción
			$txt_estado = "activo";

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarActivoFijoTpmFrppa("insert", $hidden_id_activo_fijo_frppa, $txt_estado, $txt_fecha_reg, $hidden_id_activo_fijo, $hidden_id_financiador, $hidden_id_regional, $hidden_id_programa, $hidden_id_proyecto, $hidden_id_actividad);
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

			//Validación satisfactoria, se ejecuta la inserción de la unidad constructiva
			$res = $Custom -> CrearActivoFijoTpmFrppa($hidden_id_activo_fijo_frppa, $txt_estado, $txt_fecha_reg, $hidden_id_activo_fijo, $hidden_id_financiador, $hidden_id_regional, $hidden_id_programa, $hidden_id_proyecto, $hidden_id_actividad);
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
			$txt_estado = "activo";
			$res = $Custom->ValidarActivoFijoTpmFrppa("update", $hidden_id_activo_fijo_frppa, $txt_estado, $txt_fecha_reg, $hidden_id_activo_fijo, $hidden_id_financiador, $hidden_id_regional, $hidden_id_programa, $hidden_id_proyecto, $hidden_id_actividad);
			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel =$Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			$res = $Custom -> ModificarActivoFijoTpmFrppa($hidden_id_activo_fijo_frppa, $txt_estado, $txt_fecha_reg, $hidden_id_activo_fijo, $hidden_id_financiador, $hidden_id_regional, $hidden_id_programa, $hidden_id_proyecto, $hidden_id_actividad);
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
	if($cont > 1) $mensaje_exito = 'Se guardaron todos los datos.';
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'nombres';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro = "AFFRPPA.id_activo_fijo = $hidden_id_activo_fijo";

	$res = $Custom->ContarListaActivoFijoTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo('TotalCount', $total_registros);
	$resp->add_nodo('mensaje', $mensaje_exito);
	$resp->add_nodo('tiempo_resp', '200');
	echo $resp->get_mensaje();
	exit;
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 1';
	echo $resp->get_mensaje();
	exit;
}
?>