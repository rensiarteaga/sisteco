<?php ob_start('limpiar');function limpiar($buffer) {	return trim($buffer);}?>
<?php

/**
 * **********************************************************
 * Nombre de archivo: ActionGuardarTipoMaterial.php
 * Prop�sito:				Permite insertar y modificar datos en la tal_movimiento
 * Tabla:					tal_movimiento
 * Par�metros:				$id_movimiento
 * $id_lugar
 * $id_depto
 * $codigo
 * $nombre
 * $direccion
 * $tipo_control
 *
 * Valores de Retorno: N�mero de registros guardados
 * Fecha de Creaci�n:		06-09-2013 12:24:45
 * Versi�n:					1.0.0
 * Autor:					Ruddy Lujan Bravo
 * *********************************************************
 */
session_start();
include_once ("../LibModeloAlma.php");
$Custom = new cls_CustomDBAlma();
$nombre_archivo = "ActionGuardarTipoMaterial.php";

if (! isset($_SESSION["autentificado"])) {
	$_SESSION["autentificado"] = "NO";
}
if ($_SESSION["autentificado"] == "SI") {
	// Verifica si los datos vienen por POST o GET
	if (sizeof($_GET) > 0) {
		$get = true;
		$cont = 1;
		
		// Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
		// valores permitidos de $cod -> "si", "no"
		switch ($cod) {
			case "si" :
				$decodificar = true;
				break;
			case "no" :
				$decodificar = false;
				break;
			default :
				$decodificar = true;
				break;
		}
	} elseif (sizeof($_POST) > 0) {
		$get = false;
		$cont = $_POST["cantidad_ids"];
		
		// Por Post siempre se decodifica
		$decodificar = true;
	} else {
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar.";
		$resp->origen = "ORIGEN = ";
		$resp->proc = "PROC = ";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit();
	}
	// Envia al Custom la bandera que indica si se decodificar� o no
	$Custom->decodificar = $decodificar;
	
	// Realiza el bucle por todos los ids mandados
	for($j = 0; $j < $cont; $j ++) {
		if ($get) {
			$id_tipo_material = $_GET["h_id_tipo_material_$j"];
			$codigo = $_GET["txt_codigo_tipo_$j"];
			$desc_tipo = $_GET["txt_desc_tipo_$j"];
			$nombre_tipo = $_GET["txt_nombre_tipo_$j"];	
		} else 
		{ 
			$id_tipo_material = $_POST["h_id_tipo_material_$j"];
			$codigo = $_POST["txt_codigo_tipo_$j"];
			$desc_tipo = $_POST["txt_desc_tipo_$j"];
			$nombre_tipo = $_POST["txt_nombre_tipo_$j"];
		}

		
		if ($id_tipo_material == "undefined" || $id_tipo_material == "") 
		{

			// Validaci�n satisfactoria, se ejecuta la inserci�n en la tabla tal_almacen
			$res = $Custom->InsertarTipoMaterial($id_tipo_material, $codigo, $desc_tipo, $nombre_tipo);
			if (! $res) {
				// Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] . " (iteraci�n $cont)";
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit();
			}
		} 
		else
		{ 
			$res = $Custom->ModificarTipoMaterial($id_tipo_material, $codigo, $desc_tipo, $nombre_tipo);
			if (! $res) 
			{
				// Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit();
			}
		}
	} // END FOR
	  
	// Guarda el mensaje de �xito de la operaci�n realizada
	if ($cont > 1)
		$mensaje_exito = "Se guardaron todos los datos.";
	else
		$mensaje_exito = $Custom->salida[1];
		
		// Obtiene el total de los registros. Par�metros del filtro
	if ($cant == "")
		$cant = 100;
	if ($puntero == "")
		$puntero = 0;
	if ($sortcol == "")
		$sortcol = "id_tipo_material";
	if ($sortdir == "")
		$sortdir = "asc";
	if ($criterio_filtro == "")
		$criterio_filtro = "0=0";
	
	$res = $Custom->ContarTipoMaterial($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	if ($res)
		$total_registros = $Custom->salida;
		
		// Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", $total_registros);
	$resp->add_nodo("mensaje", $mensaje_exito);
	$resp->add_nodo("tiempo_resp", "200");
	echo $resp->get_mensaje();
	exit();
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
<?php ob_end_flush();?>