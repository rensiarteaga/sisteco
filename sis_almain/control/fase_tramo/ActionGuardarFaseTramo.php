<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?> 
<?php

/**
 * **********************************************************
 * Nombre de archivo: ActionGuardarFaseTramo.php
 * Propósito:				Permite insertar y modificar datos en la tal_fase_tramo
 * Tabla:					tal_fase_tramo
 * Parámetros:				$id_fase_tramo
 * $codigo
 * $descripcion
 * $observaciones
 * $estado
 *
 * Valores de Retorno: Número de registros guardados
 * Fecha de Creación:		09-12-2014
 * Versión:					1.0.0
 * Autor:					UNKNOW
 * *********************************************************
 */
session_start();
include_once ("../LibModeloAlma.php");

$Custom = new cls_CustomDBAlma();
$nombre_archivo = "ActionGuardarFaseTramo.php";
if (! isset($_SESSION["autentificado"])) {
	$_SESSION["autentificado"] = "NO";
}
if ($_SESSION["autentificado"] == "SI") 
{
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
	for($j = 0; $j < $cont; $j ++) 
	{
		if ($get) {
			$id_fase_tramo = $_GET["hidden_id_fase_tramo_$j"];
			$id_fase = $_GET["hidden_id_fase_$j"];
			$id_tramo = $_GET["hidden_id_tramo_$j"];
			$estado = $_GET["txt_estado_$j"];
			
		
			
		} else 
		{
			$id_fase_tramo = $_POST["hidden_id_fase_tramo_$j"];
			$id_fase = $_POST["hidden_id_fase_$j"];
			$id_tramo = $_POST["hidden_id_tramo_$j"];
			$estado = $_POST["txt_estado_$j"];
		}
		if ($id_fase_tramo == "undefined" || $id_fase_tramo == "") 
		{
			// //////////////////Inserción/////////////////////
			
			// Validación de datos (del lado del servidor)
			$res = $Custom->ValidarFaseTramo("insert",$id_fase_tramo,$id_fase, $id_tramo, $estado);
			
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
			$res = $Custom->InsertarFaseTramo($id_fase_tramo, $id_fase, $id_tramo, $estado);
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
		}
		else 
		{ // /////////////////////Modificación////////////////////
		         // Validación de datos (del lado del servidor)
			$res = $Custom->ValidarFaseTramo("update",$id_fase_tramo, $id_fase, $id_tramo, $estado);
			
			if (! $res) {

				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit();
			}
			
			$res = $Custom->ModificarFaseTramo($id_fase_tramo, $id_fase, $id_tramo, $estado);
			
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
		$sortcol = "id_item";
	if ($sortdir == "")
		$sortdir = "asc";
	if ($criterio_filtro == "")
		$criterio_filtro =$criterio_filtro." 0=0 AND fatram.id_fase like (".$id_fase.")";

	$res = $Custom->ContarFaseTramo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
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