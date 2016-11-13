<?php
/**
 * Nombre del archivo:	ActionSaveDepreciacion.php
 * Propósito:			Permite insertar y modificar Depreciaciones
 * Tabla:				taf_depreciacion
 * Parámetros:			
 * Valores de Retorno:	
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creación:		08-06-2007
 */
session_start();
include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionSaveDepreciacion.php';

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
			$hidden_id_depreciacion = $_GET["hidden_id_depreciacion_$j"];
			$txt_fecha_desde = $_GET["txt_fecha_desde_$j"];
			$txt_fecha_hasta = $_GET["txt_fecha_hasta_$j"];
			$txt_monto_vigente_ant = $_GET["txt_monto_vigente_ant_$j"];
			$txt_monto_vigente = $_GET["txt_monto_vigente_$j"];
			$txt_vida_util = $_GET["txt_vida_util_$j"];
			$txt_tipo_cambio_ini = $_GET["txt_tipo_cambio_ini_$j"];
			$txt_tipo_cambio_fin = $_GET["txt_tipo_cambio_fin_$j"];
			$txt_depreciacion_acum_ant = $_GET["txt_depreciacion_acum_ant_$j"];
			$txt_depreciacion = $_GET["txt_depreciacion_$j"];
			$txt_nuevo_monto = $_GET["txt_nuevo_monto_$j"];
			$txt_fecha_reg = $_GET["txt_fecha_reg_$j"];
			$txt_estado = $_GET["txt_estado_$j"];
			$txt_depreciacion_acum = $_GET["txt_depreciacion_acum_$j"];
			$txt_id_activo_fijo = $_GET["txt_id_moneda_$j"];
			$txt_id_moneda = $_GET["txt_id_moneda_$j"];
		}
		else
		{
			$hidden_id_depreciacion = $_POST["hidden_id_depreciacion_$j"];
			$txt_fecha_desde = $_POST["txt_fecha_desde_$j"];
			$txt_fecha_hasta = $_POST["txt_fecha_hasta_$j"];
			$txt_monto_vigente_ant = $_POST["txt_monto_vigente_ant_$j"];
			$txt_monto_vigente = $_POST["txt_monto_vigente_$j"];
			$txt_vida_util = $_POST["txt_vida_util_$j"];
			$txt_tipo_cambio_ini = $_POST["txt_tipo_cambio_ini_$j"];
			$txt_tipo_cambio_fin = $_POST["txt_tipo_cambio_fin_$j"];
			$txt_depreciacion_acum_ant = $_POST["txt_depreciacion_acum_ant_$j"];
			$txt_depreciacion = $_POST["txt_depreciacion_$j"];
			$txt_nuevo_monto = $_POST["txt_nuevo_monto_$j"];
			$txt_fecha_reg = $_POST["txt_fecha_reg_$j"];
			$txt_estado = $_POST["txt_estado_$j"];
			$txt_depreciacion_acum = $_POST["txt_depreciacion_acum_$j"];
			$txt_id_activo_fijo = $_POST["txt_id_moneda_$j"];
			$txt_id_moneda = $_POST["txt_id_moneda_$j"];
		}

		if ($hidden_id_depreciacion == "undefined" || $hidden_id_depreciacion == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarDepreciacion("insert", $hidden_id_depreciacion, $txt_fecha_desde, $txt_fecha_hasta, $txt_monto_vigente_ant, $txt_monto_vigente, $txt_vida_util, $txt_tipo_cambio_ini, $txt_tipo_cambio_fin, $txt_depreciacion_acum_ant, $txt_depreciacion, $txt_nuevo_monto, $txt_fecha_reg, $txt_estado, $txt_depreciacion_acum, $txt_id_activo_fijo, $txt_id_moneda);
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
			$res = $Custom -> CrearDepreciacion($hidden_id_depreciacion, $txt_fecha_desde, $txt_fecha_hasta, $txt_monto_vigente_ant, $txt_monto_vigente, $txt_vida_util, $txt_tipo_cambio_ini, $txt_tipo_cambio_fin, $txt_depreciacion_acum_ant, $txt_depreciacion, $txt_nuevo_monto, $txt_fecha_reg, $txt_estado, $txt_depreciacion_acum, $txt_id_activo_fijo, $txt_id_moneda);
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
			$res = $Custom->ValidarDepreciacion("update", $hidden_id_depreciacion, $txt_fecha_desde, $txt_fecha_hasta, $txt_monto_vigente_ant, $txt_monto_vigente, $txt_vida_util, $txt_tipo_cambio_ini, $txt_tipo_cambio_fin, $txt_depreciacion_acum_ant, $txt_depreciacion, $txt_nuevo_monto, $txt_fecha_reg, $txt_estado, $txt_depreciacion_acum, $txt_id_activo_fijo, $txt_id_moneda);
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

			$res = $Custom -> ModificarDepreciacion($hidden_id_depreciacion, $txt_fecha_desde, $txt_fecha_hasta, $txt_monto_vigente_ant, $txt_monto_vigente, $txt_vida_util, $txt_tipo_cambio_ini, $txt_tipo_cambio_fin, $txt_depreciacion_acum_ant, $txt_depreciacion, $txt_nuevo_monto, $txt_fecha_reg, $txt_estado, $txt_depreciacion_acum, $txt_id_activo_fijo, $txt_id_moneda);
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
	if($criterio_filtro == "") $criterio_filtro = '0=0';

	$res = $Custom->ContarListaDepreciacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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