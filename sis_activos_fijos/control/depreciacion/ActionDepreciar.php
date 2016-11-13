<?php
/**
 * Nombre del archivo:	ActionDepreciar.php
 * Propósito:			Ejecuta la depreciación de los activos fijos
 * Tabla:				taf_depreciacion
 * Parámetros:			$fecha_ini, $fecha_fin, $id_financiador, $id_regional, $id_programa, $id_regional, $id_actividad
 * 						$id_tipo_activo, $id_sub_tipo_activo, $id_activo_fijo
 * 						
 * Valores de Retorno:	
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creación:		03-07-2007
 */ 
session_start();
include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionDepreciar.php';

//echo "llega al action de Depreciar";
//exit();

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
	}
	elseif(sizeof($_POST) > 0)
	{
		$get = false;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen parámetros para ejecutar la depreciación.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = 'NIVEL = 4';
		$resp->get_mensaje();
		exit;
	}

	//Envia al Custom la bandera que indica si se decodificará o no
	$Custom->decodificar = $decodificar;

	if ($get)
	{
		$txt_mes_ini = $_GET["txt_mes_ini"];
		$txt_mes_fin = $_GET["txt_mes_fin"];
		$txt_gestion_ini = $_GET["txt_gestion_ini"];
		$txt_gestion_fin = $_GET["txt_gestion_fin"];
		$txt_id_depto = $_GET["txt_id_depto"];
		
	}
	else
	{
		//$txt_mes_ini = $_POST["txt_mes_ini"];
		$txt_mes_fin = $_POST["txt_mes_fin"];
		//$txt_gestion_ini = $_POST["txt_gestion_ini"];
		$txt_gestion_fin = $_POST["txt_gestion_fin"];
		$txt_id_depto = $_POST["txt_id_depto"];		
	}

	//Valida que la fecha fin sea mayor a la de inicio
	/*echo "pasa";
	exit;*/

	//formatea fecha, obtenemos el último día del mes_fin  en la gestion_fin
	//$time_ini=mktime(0,0,0,$txt_mes_ini +1,0,$txt_gestion_ini);
	$time_fin=mktime(0,0,0,$txt_mes_fin +1,0,$txt_gestion_fin);
	// Obtenemos la fecha
	//$dia_mes_ini = date("d",$time_ini);
	$dia_mes_fin = date("d",$time_fin);

	//$txt_fecha_ini = "$txt_mes_ini-$dia_mes_ini-$txt_gestion_ini";
	$txt_fecha_fin = "$txt_mes_fin-$dia_mes_fin-$txt_gestion_fin";

	//Se verifica que ninguno de los parámetros estén vacíos
	$sw = true;

	//Obtiene el código temporal con el cual generará el detalle de la depreciación
	$fecha = getdate();
	$codigo_temp = $_SESSION["ss_id_usuario"] .$fecha['hours'] .$fecha['minutes'] .$fecha['seconds'] .$fecha['mday'] .$fecha['mon'] .$fecha['year'];


	//if($txt_fecha_ini == "" && $txt_fecha_ini == "undefined") $sw = $sw && false;
	if($txt_fecha_fin == "" && $txt_fecha_fin == "undefined") $sw = $sw && false;
	if($txt_id_depto == "" && $txt_id_depto == "undefined") $sw = $sw && false;
	
	/*if($txt_id_regional == "" && $txt_id_regional == "undefined") $sw = $sw && false;
	if($txt_id_programa == "" && $txt_id_programa == "undefined") $sw = $sw && false;
	if($txt_id_proyecto == "" && $txt_id_proyecto == "undefined") $sw = $sw && false;
	if($txt_id_actividad == "" && $txt_id_actividad == "undefined") $sw = $sw && false;
	if($txt_id_tipo_activo == "" && $txt_id_tipo_activo == "undefined") $sw = $sw && false;
	if($txt_id_sub_tipo_activo == "" && $txt_id_sub_tipo_activo == "undefined") $sw = $sw && false;
	if($txt_id_activo_fijo == "" && $txt_id_activo_fijo == "undefined") $sw = $sw && false;/*
	
	/*echo "continua";
	exit;*/
	
	/*echo "sw= ".$sw;
	exit;*/

	if($sw)
	{/**********************************************/

		//Se ejecuta la depreciación
		/*echo "puerta";
		exit;*/
		$res = $Custom->Depreciar($txt_fecha_fin, $txt_id_depto,$codigo_temp);  //, $txt_id_financiador, $txt_id_regional, $txt_id_programa, $txt_id_proyecto, $txt_id_actividad, $txt_id_tipo_activo, $txt_id_sub_tipo_activo, $txt_id_activo_fijo, $codigo_temp);
		if(!$res)
		{
			//Error al ejecutar depreciación
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = $Custom->salida[1];
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->get_mensaje();
			exit;
		}
		else
		{
			//Arma el xml para desplegar el mensaje
			$resp = new cls_manejo_mensajes(false,"202");
			$resp->add_nodo('TotalCount',0);
			$resp->add_nodo('mensaje', $Custom->salida[1]);
			$resp->add_nodo('tiempo_resp', '200');
			$resp->add_nodo('codigo_temp',$codigo_temp);
			$resp->get_mensaje();
			exit;
		}

	}
	else
	{
		//Si uno de los parámetros está vacío no ejecuta la depreciación
		$resp = new cls_manejo_mensajes(true, "401");
		$resp->mensaje_error = 'MENSAJE ERROR = Parámetros insuficientes';
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = 'NIVEL = 1';
		$resp->get_mensaje();
		exit;
	}

}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 1';
	$resp->get_mensaje();
	exit;
}
?>