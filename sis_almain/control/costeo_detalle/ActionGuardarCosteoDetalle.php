<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?> 
<?php

/**
 * **********************************************************
 * Nombre de archivo: ActionGuardarCosteoDetalle.php
 * Propósito:				Permite insertar y modificar datos en la tal_costeo_detalle
 * Tabla:					tal_costeo_detalle
 * Parámetros:				
 
 * Valores de Retorno: Número de registros guardados
 * Fecha de Creación:		05-05-2015
 * Versión:					1.0.0
 * Autor:					UNKNOW
 * *********************************************************
 */
session_start();
include_once ("../LibModeloAlma.php");

$Custom = new cls_CustomDBAlma();
$nombre_archivo = "ActionGuardarCosteoDetalle.php";
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
	for($j = 0; $j < $cont; $j ++) {
		if ($get) 
		{
			$id_costeo_det = $_GET["h_id_costeo_det_$j"];
			$id_costeo = $_GET["h_id_costeo_$j"];
			$id_costo = $_GET["h_id_costo_$j"];
			$valor_costo = $_GET["txt_valor_costo_$j"];
			$estado = $_GET["txt_estado_$j"];
					
		} else 
		{
			$id_costeo_det = $_POST["h_id_costeo_det_$j"];
			$id_costeo = $_POST["h_id_costeo_$j"];
			$id_costo = $_POST["h_id_costo_$j"];
			$valor_costo = $_POST["txt_valor_costo_$j"];
			$estado = $_POST["txt_estado_$j"];
			
		}
		if ($id_costeo_det == "undefined" || $id_costeo_det == "") 
		{
			// //////////////////Inserción/////////////////////
			
			// Validación de datos (del lado del servidor)
			/*$res = $Custom->ValidarCosteo("insert", $id_fase, $id_almacen, $cod_fase, $desc_fase, $obs_fase);
			
			if (! $res) {
				// Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit();
			}*/
			
			// Validación satisfactoria, se ejecuta la inserción en la tabla tal_almacen
			$res = $Custom->InsertarCostoDetalle($id_costeo_det, $id_costeo, $id_costo, $valor_costo,$estado);
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
			/*$res = $Custom->ValidarFase("update",$id_fase, $id_almacen, $cod_fase, $desc_fase, $obs_fase);
			
			if (! $res) {

				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit();
			}
			*/
			$res = $Custom->ModificarCostoDetalle($id_costeo_det, $id_costeo, $id_costo, $valor_costo,$estado);
			
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
		$sortcol = "id_costeo";
	if ($sortdir == "")
		$sortdir = "desc";
	if ($criterio_filtro == "")
		$criterio_filtro =$criterio_filtro." 0=0 ";

	$res = $Custom->ContarCosto($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
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