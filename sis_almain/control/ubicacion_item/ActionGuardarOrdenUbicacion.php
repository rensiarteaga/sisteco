<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?>
<?php

/**
 * **********************************************************
 * Nombre de archivo: 		ActionGuardarOrdenUbicacion.php
 * Prop�sito:				Permite insertar y modificar datos 
 * Tabla:					tal_almacen
 * Par�metros:				$id_almacen,$id_item
 * $id_lugar
 * $id_depto
 * $codigo
 * $nombre
 * $direccion
 * $estado
 * $tipo_control
 *
 * Valores de Retorno: N�mero de registros guardados
 * Fecha de Creaci�n:	
 * Versi�n:			
 * Autor:				
 * *********************************************************
 */
session_start();
include_once ("../LibModeloAlma.php");

$Custom = new cls_CustomDBAlma();
$nombre_archivo = "ActionGuardarOrdenUbicacion.php";

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
	for($j = 0; $j < $cont; $j ++) 
	{
		if ($get) {

			$id_ubicacion_item = $_GET["h_id_ubicacion_item_$j"];
			$maxing=$_GET["txt_maxing_$j"];
			$maxsal=$_GET["txt_maxsal_$j"];
			$orden_actual = $_GET["txt_orden_$j"];
			$orden_anterior = $_GET["txt_orden_anterior_$j"];

		} else {

			$id_ubicacion_item = $_POST["h_id_ubicacion_item_$j"];
			$maxing=$_POST["txt_maxing_$j"];
			$maxsal=$_POST["txt_maxsal_$j"];
			$orden_actual = $_POST["txt_orden_$j"];
			$orden_anterior = $_POST["txt_orden_anterior_$j"];
			
		}
		
		if ($id_ubicacion_item != "undefined" || $id_ubicacion_item != "")
		{
		    settype($orden_actual,'integer');
		    settype($orden_anterior,'integer');
			
				
			$res = $Custom->EditarOrdenUbicacion($id_ubicacion_item,$h_id_almacen,$h_id_item,$maxing,$maxsal,$orden_actual,$orden_anterior);
			if (! $res) 
			{
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
		$sortcol = "ord.orden ASC";
	if ($sortdir == "")
		$sortdir = "asc";
	if ($criterio_filtro == "")
		$criterio_filtro = " ord.id_almacen like($h_id_almacen) AND ord.id_item like($h_id_item)";
	
	$res = $Custom->ContarOrdenUbicacionItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
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