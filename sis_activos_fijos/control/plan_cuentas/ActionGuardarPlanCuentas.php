<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarPlanCuentas.php
Prop�sito:				Permite insertar y modificar datos
						para las cuentas contables
Tabla:					tal_plan_cuentas

Fecha de Creaci�n:		12-05-2015
Versi�n:				1.0.0
Autor:					UNKNOW
**********************************************************
*/
session_start();
include_once('../LibModeloActivoFijo.php');

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = "ActionGuardarPlanCuentas.php";

if (! isset($_SESSION["autentificado"])) {
	$_SESSION["autentificado"] = "NO";
}
if ($_SESSION["autentificado"] == "SI")
{
	
	$datosDecodificado = stripslashes($_REQUEST['datos']);
	$proceso = stripslashes($_REQUEST['proc']);
	
	$nodo = json_decode($datosDecodificado, true);
	
	$tipo_bien = trim($nodo["txt_tipo_bien_adt"].$nodo["txt_tipo_bien_gen"]);

	if ($proc === 'add') 
	{ 
		$res = $Custom->InsertarPlanCuentas($nodo["h_id_plan_cuentas"], $nodo["h_id_plan_cuentas_fk"], $nodo["txt_codigo"], $nodo["txt_descripcion"],$nodo["txt_estado"],
											$nodo["h_id_tipo_activo"],$nodo["h_id_activo"],$nodo["h_aux_activo"],$nodo["h_id_depacum"],$nodo["h_aux_depacum"],
											$nodo["h_id_gasto"],$nodo["h_aux_gasto"],$nodo["h_id_gestion"],$nodo["h_nivel"],
											$nodo["txt_programa"],$nodo["txt_tension"],$tipo_bien);
		if (! $res)
		{
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = $Custom->salida[1];
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3]; 
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje();
			exit();
		}
		$tmp['id'] = $nodo["id_p"];
		echo json_encode($tmp);
		exit();
	} 
	elseif ($proc === 'upd')
	{
		$res = $Custom->ModificarPlanCuentas($nodo["h_id_plan_cuentas"],$nodo["h_id_plan_cuentas_fk"],$nodo["txt_codigo"],$nodo["txt_descripcion"],$nodo["txt_estado"],
											$nodo["h_id_tipo_activo"],$nodo["h_id_activo"],$nodo["h_aux_activo"],$nodo["h_id_depacum"],$nodo["h_aux_depacum"],
											$nodo["h_id_gasto"],$nodo["h_aux_gasto"],$nodo["h_id_gestion"],$nodo["h_nivel"],
											$nodo["txt_programa"],$nodo["txt_tension"],$tipo_bien);
		if (! $res) {
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = $Custom->salida[1];
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje();
			exit();
		}
		echo 'update';exit;
		$tmp['id'] = $nodo["h_id_plan_cuentas"];
		echo json_encode($tmp);
		exit();
	} 
	elseif ($proc === 'del') 
	{
		$idPlanCuentasArray = explode("-", $nodo['id']);
		$id_plan_cuentas = $idPlanCuentasArray[1];
		
		$res = $Custom->EliminarPlanCuentas($id_plan_cuentas);
		if (! $res) {
			$resp = new cls_manejo_mensajes(true, "406"); 
			$resp->mensaje_error = $Custom->salida[1];
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje();
			exit();
		}
		$tmp['id'] = $nodo["id_p"];
		echo json_encode($tmp);
		exit();
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "401");
		$resp->mensaje_error = "MENSAJE ERROR = Proceso no identificado";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = "NIVEL = 1";
		echo $resp->get_mensaje();
		exit();
	}
} else {
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp->get_mensaje();
	exit();
}
?>