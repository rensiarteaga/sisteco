<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?>
<?php

/**
 * **********************************************************
 * Nombre de archivo: ActionGuardarSolicitudSalida.php
 * Propósito:				Permite insertar y modificar datos en la tal_item
 * Tabla:					tal_item
 * Parámetros:				$id_item
 * $id_clasificacion
 * $id_unidad_medida
 * $codigo
 * $nombre
 * $descripcion
 * $codigo_fabrica
 * $num_por_clasificacion
 * $bajo_responsabilidad
 * $estado
 *
 * Valores de Retorno: Número de registros guardados
 * Fecha de Creación:	27-08-2013 
 * Versión:				1.0.0
 * Autor:					
 * *********************************************************
 */
session_start();
include_once ("../LibModeloAlma.php");

$Custom = new cls_CustomDBAlma();
$nombre_archivo = "ActionGuardarSolicitudSalida.php";
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
		if ($get) {
			$id_solicitud_salida = $_GET["hidden_id_solicitud_salida_$j"];
			$id_almacen = $_GET["hidden_id_almacen_$j"];
			$id_unidad_organizacional = $_GET["hidden_id_unidad_organizacional_$j"];
			$id_empleado = $_GET["hidden_id_empleado_$j"];
			$id_aprobador = $_GET["hidden_id_aprobador_$j"];
			$fecha_solicitud = $_GET["txt_fecha_solicitud_$j"];
			$descripcion = $_GET["txt_descripcion_$j"];
			//accion a realizarse con el movimiento
			$accion_solicitud = $_GET["txt_accion_$j"];//['envar_borrador','finalizar_pendiente','corregir_pendiente',...]
			
		} else {
			$id_solicitud_salida = $_POST["hidden_id_solicitud_salida_$j"];
			$id_almacen = $_POST["hidden_id_almacen_$j"];
			$id_unidad_organizacional = $_POST["hidden_id_unidad_organizacional_$j"];
			$id_empleado = $_POST["hidden_id_empleado_$j"];
			$id_aprobador = $_POST["hidden_id_aprobador_$j"];
			$fecha_solicitud = $_POST["txt_fecha_solicitud_$j"];
			$descripcion = $_POST["txt_descripcion_$j"];
			//accion a realizarse con el movimiento 
			$accion_solicitud = $_POST["txt_accion_$j"];//['envar_borrador','finalizar_pendiente','corregir_pendiente',...]
		}
		
		if($_POST['reporte'] == 'si')
		{	$id_solicitud_salida=$_POST['id_solicitud_salida'];
			$accion_solicitud=$_POST['accion_solicitud'];
		}
				
		if ($id_solicitud_salida == "undefined" || $id_solicitud_salida == "") 
		{
			// //////////////////Inserción/////////////////////
			
			// Validación de datos (del lado del servidor)
			$res = $Custom->ValidarSolicitudSalida("insert", $id_solicitud_salida, $id_almacen, $id_unidad_organizacional, $id_empleado, $id_aprobador, $fecha_solicitud, $descripcion);
			
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
			$res = $Custom->InsertarSolicitudSalida($id_almacen, $id_unidad_organizacional, $id_empleado, $id_aprobador, $fecha_solicitud, $descripcion);
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
		{ 
			if ($accion_solicitud != '')
			{
				$res = $Custom->AccionesSolicitud($id_solicitud_salida,$accion_solicitud);
			 		if(!$res){
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
			else 
			{
					// /////////////////////Modificación////////////////////
				         // Validación de datos (del lado del servidor)
					$res = $Custom->ValidarSolicitudSalida("update", $id_solicitud_salida, $id_almacen, $id_unidad_organizacional, $id_empleado, $id_aprobador, $fecha_solicitud, $descripcion);
					
					if (! $res) {
		
						$resp = new cls_manejo_mensajes(true, "406");
						$resp->mensaje_error = $Custom->salida[1];
						$resp->origen = $Custom->salida[2];
						$resp->proc = $Custom->salida[3];
						$resp->nivel = $Custom->salida[4];
						echo $resp->get_mensaje();
						exit();
					}
					
					$res = $Custom->ModificarSolicitudSalida($id_solicitud_salida, $id_almacen, $id_unidad_organizacional, $id_empleado, $id_aprobador, $fecha_solicitud, $descripcion);
					
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
		}
	} // END FOR
	  
	// Guarda el mensaje de éxito de la operación realizada
	if ($cont > 1)
	{
		$mensaje_exito = "Se guardaron todos los datos.";
		
	}
	else
		$mensaje_exito = $Custom->salida[1];
		// Obtiene el total de los registros. Parámetros del filtro
	if ($cant == "")
		$cant = 100;
	if ($puntero == "")
		$puntero = 0;
	if ($sortcol == "")
		$sortcol = "id_solicitud_salida";
	if ($sortdir == "")
		$sortdir = "asc";
	if ($criterio_filtro == "")
	{
		$criterio_filtro = 'sol.id_almacen like('.$id_almacen.')';
	}
	
	$res = $Custom->ContarSolicitudSalida($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
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