<?php
ob_start('limpiar');
function limpiar($buffer) {return trim($buffer);}
?>

<?php
/**
 * **********************************************************
 * Nombre de archivo: 		ActionGuardarDetalleUnidadConstructiva.php
 * Propósito:				Permite insertar y modificar datos en alma.tal_detalle_unidad_constructiva
 * Tabla:					tal_detalle_unidad_constructiva
 * Parámetros:				$id_detalle_unidad_constructiva
 * $id_detalle_unidad_constructiva
 * $id_dunidad_constructiva
 * $id_item
 * $cantidad
 * Valores de Retorno: 		Número de registros guardados
 * Fecha de Creación:		14-08-2014
 * Versión:					1.0.0
 * Autor:					UNKNOW
 * *********************************************************
 */
session_start();
include_once ("../LibModeloAlma.php");

$Custom = new cls_CustomDBAlma();
$nombre_archivo = "ActionGuardarItem.php";
if (! isset($_SESSION["autentificado"])) {
	$_SESSION["autentificado"] = "NO";
}
if ($_SESSION["autentificado"] == "SI") {
	// Verifica si los datos vienen por POST o GET
	if (sizeof($_GET) > 0) {
		$get = true;
		$cont = 1;
		
		// Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
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
	// Envia al Custom la bandera que indica si se decodificará o no
	$Custom->decodificar = $decodificar;
	// Realiza el bucle por todos los ids mandados
	for($j = 0; $j < $cont; $j ++) {
		if ($get) 
		{
			$id_detalle_unidad_constructiva = $_GET["hidden_id_detalle_unidad_constructiva_$j"];
			$id_unidad_constructiva = $_GET["hidden_id_unidad_constructiva_$j"];
			$id_item = $_GET["txt_id_item_$j"];
			$cantidad = $_GET["txt_cantidad_$j"];
			$descripcion = $_GET["txt_descripcion_$j"];
			
			$orden_duc = $_GET["txt_orden_detuc_$j"];
		} else 
		{
			$id_detalle_unidad_constructiva = $_POST["hidden_id_detalle_unidad_constructiva_$j"];
			$id_unidad_constructiva = $_POST["hidden_id_unidad_constructiva_$j"];
			$id_item = $_POST["txt_id_item_$j"];
			$cantidad = $_POST["txt_cantidad_$j"];
			$descripcion = $_POST["txt_descripcion_$j"];
			
			$orden_duc = $_POST["txt_orden_detuc_$j"];
		}
		if ($id_detalle_unidad_constructiva == "undefined" || $id_detalle_unidad_constructiva == "") 
		{
			// //////////////////Inserción/////////////////////
			
			// Validación de datos (del lado del servidor)
			$res = $Custom->ValidarDestalleUnidadConstructiva("insert", $id_detalle_unidad_constructiva, $id_unidad_constructiva, $id_item, $cantidad, $descripcion);
			
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
			$res = $Custom->InsertarDetalleUnidadConstructiva($id_detalle_unidad_constructiva, $id_unidad_constructiva, $id_item
															  ,$cantidad, $descripcion,$orden_duc);
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
		} else
		{ // /////////////////////Modificación////////////////////
		         // Validación de datos (del lado del servidor)
			$res = $Custom->ValidarDestalleUnidadConstructiva("update", $id_detalle_unidad_constructiva, $id_unidad_constructiva, $id_item, $cantidad, $descripcion);
			
			if (! $res) {

				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit();
			}
			
			$res = $Custom->ModificarDetalleUnidadConstructiva($id_detalle_unidad_constructiva, $id_unidad_constructiva, $id_item
																, $cantidad, $descripcion,$orden_duc);
			
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
		$sortcol = "detunic.id_unidad_constructiva";
	if ($sortdir == "")
		$sortdir = "asc";
	if ($criterio_filtro == "")
		$criterio_filtro = '0=0';

	$res = $Custom->CountDetalleUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
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