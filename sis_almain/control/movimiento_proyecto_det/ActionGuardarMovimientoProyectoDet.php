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
$nombre_archivo = "ActionGuardarMovimientoProyectoDet.php";

if (! isset($_SESSION["autentificado"])) {
	$_SESSION["autentificado"] = "NO";
}
if ($_SESSION["autentificado"] == "SI") {
	// Verifica si los datos vienen por POST o GET
	if (sizeof($_GET) > 0) {
		$get = true;
		$cont = 1;
		// Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
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

	// Envia al Custom la bandera que indica si se decodificará o no
	$Custom->decodificar = $decodificar;

	// Realiza el bucle por todos los ids mandados
	for($j = 0; $j < $cont; $j ++) {
		if ($get) 
		{
			$id_mov_proy_det = $_GET["hidden_id_mov_proy_det_$j"];
			$id_mov_proy = $_GET["hidden_id_movimiento_proyecto_$j"];
			$id_item = $_GET["txt_id_item_$j"];
			$cantidad = $_GET["txt_cantidad_$j"]; 
			$unidad = $_GET["nombre_medida_$j"];
			$costo_unitario= $_GET["txt_costo_unitario_$j"];
			
			
		} 
		else 
		{
			$id_mov_proy_det = $_POST["hidden_id_mov_proy_det_$j"];
			$id_mov_proy = $_POST["hidden_id_movimiento_proyecto_$j"];
			$id_item = $_POST["txt_id_item_$j"];
			$cantidad = $_POST["txt_cantidad_$j"];
			$unidad = strtolower($_POST["nombre_medida_$j"]); 
			$costo_unitario= $_POST["txt_costo_unitario_$j"];
		} 
		
		if ($id_mov_proy_det == "undefined" || $id_mov_proy_det == "") {
			// //////////////////Inserción/////////////////////
			// Validación de datos (del lado del servidor)
			$res = $Custom->ValidarMovimientoProyectoDet("insert", $id_mov_proy_det, $id_mov_proy, $id_item, $cantidad, $unidad);
			
			if (! $res) {
				// Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit();
			}
			// Validación satisfactoria, se ejecuta la inserción en la tabla tal_almacen
			$res = $Custom->InsertarMovimientoProyectoDet($id_mov_proy, $id_item, $cantidad, $unidad,$costo_unitario);
			if (! $res) {
				// Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] . " (iteración $cont)";
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit();
			}
		} else { // /////////////////////Modificación////////////////////
		         
			// Validación de datos (del lado del servidor)
			$res = $Custom->ValidarMovimientoProyectoDet("update", $id_mov_proy_det, $id_mov_proy, $id_item, $cantidad, $unidad);
			if (! $res) {
				// Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit();
			}
			$res = $Custom->ModificarMovimientoProyectoDet($id_mov_proy_det, $id_mov_proy, $id_item, $cantidad, $unidad,$costo_unitario);
			
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
	  
	// Guarda el mensaje de éxito de la operación realizada
	if ($cont > 1)
		$mensaje_exito = "Se guardaron todos los datos.";
	else
		$mensaje_exito = $Custom->salida[1];
		
		// Obtiene el total de los registros. Parámetros del filtro
	if ($cant == "")
		$cant = 100;
	if ($puntero == "")
		$puntero = 0;
	if ($sortcol == "")
		$sortcol = "id_detalle_movimiento";
	if ($sortdir == "")
		$sortdir = "asc";precio_unitario;
	if (isset($m_id_movimiento_proyecto) && $criterio_filtro=="" )
		$criterio_filtro = "0=0 AND movdet.id_movimiento_proyecto = $m_id_movimiento_proyecto";
	else 
		$criterio_filtro = "0=0 AND movdet.id_movimiento_proyecto = $id_mov_proy";
	
	$res = $Custom->ContarMovimientoProyectoDet($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	if ($res)
		$total_registros = $Custom->salida;
		
	// Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", $total_registros);
	$resp->add_nodo("mensaje", $mensaje_exito);
	$resp->add_nodo("tiempo_resp", "200");
	echo $resp->get_mensaje();
	exit();
	} 
	else 
	{
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