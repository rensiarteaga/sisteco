<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?>
<?php

session_start();
include_once ("../LibModeloAlma.php");

$Custom = new cls_CustomDBAlma();
$nombre_archivo = "ActionGuardarDetalleMovimiento.php";

if (! isset($_SESSION["autentificado"])) {
	$_SESSION["autentificado"] = "NO";
}
if ($_SESSION["autentificado"] == "SI") {
	// Verifica si los datos vienen por POST o GET
	if (sizeof($_GET) > 0) {
		$get = true;
		$cont = 1;
		// Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
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
			$id_detalle_movimiento = $_GET["hidden_id_detalle_movimiento_$j"];
			$id_movimiento = $_GET["hidden_id_movimiento_$j"];
			$id_item = $_GET["txt_id_item_$j"];
			$cantidad = $_GET["txt_cantidad_$j"];
			$cantidad_solicitada = $_GET["txt_cantidad_solicitada_$j"];
			$tipo_saldo = $_GET["txt_tipo_saldo_$j"];
			//a�adido 17072014
			$costo_unitario=$_GET["txt_costo_unitario_$j"];
			$costo_total=$_GET["txt_costo_total_$j"];
			//a�adido 19082015
			$item_valoriz = $_GET["txt_id_item_val_$j"];
		} else {
			$id_detalle_movimiento = $_POST["hidden_id_detalle_movimiento_$j"];
			$id_movimiento = $_POST["hidden_id_movimiento_$j"];
			$id_item = $_POST["txt_id_item_$j"];
			$cantidad = $_POST["txt_cantidad_$j"];
			$cantidad_solicitada = $_POST["txt_cantidad_solicitada_$j"];
			$tipo_saldo = $_POST["txt_tipo_saldo_$j"];
			//a�adido 17072014
			$costo_unitario=$_POST["txt_costo_unitario_$j"];
			$costo_total=$_POST["txt_costo_total_$j"];
			//a�adido 19082015
			$item_valoriz = $_POST["txt_id_item_val_$j"];
		}
		//a�adido 19082015
		if($item_valoriz > 0 && ($id_item == "undefined" || $id_item =="null" || $id_item =="") )
			$id_item = $item_valoriz;

		
		if ($id_detalle_movimiento == "undefined" || $id_detalle_movimiento == "") {
			// //////////////////Inserci�n/////////////////////
			// Validaci�n de datos (del lado del servidor)
			$res = $Custom->ValidarDetalleMovimiento("insert", $id_detalle_movimiento, $id_movimiento, $id_item, $cantidad, $cantidad_solicitada, $tipo_saldo);
			
			if (! $res) {
				// Error de validaci�n
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit();
			}
			
			// Validaci�n satisfactoria, se ejecuta la inserci�n en la tabla tal_almacen
			$res = $Custom->InsertarDetalleMovimiento($id_movimiento, $id_item, $cantidad, $cantidad_solicitada, $tipo_saldo,$costo_unitario,$costo_total);
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
		} else { // /////////////////////Modificaci�n////////////////////
		         
			// Validaci�n de datos (del lado del servidor)
			$res = $Custom->ValidarDetalleMovimiento("update", $id_detalle_movimiento, $id_movimiento, $id_item, $cantidad, $cantidad_solicitada, $tipo_saldo);
			if (! $res) {
				// Error de validaci�n
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit();
			}
			
			$res = $Custom->ModificarDetalleMovimiento($id_detalle_movimiento, $id_movimiento, $id_item, $cantidad, $cantidad_solicitada, $tipo_saldo,$costo_unitario,$costo_total);
			
			if (! $res) {
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
		$sortcol = "id_detalle_movimiento";
	if ($sortdir == "")
		$sortdir = "asc";
	if ($criterio_filtro == "")
		$criterio_filtro = " 0=0 AND dem.id_movimiento = $id_movimiento";
	else
		$criterio_filtro = "0=0";
	
	$res = $Custom->ContarDetalleMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
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