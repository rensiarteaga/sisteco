<?php ob_start('limpiar');function limpiar($buffer) {	return trim($buffer);}?>
<?php

/**
 * **********************************************************
 * Nombre de archivo: ActionGuardarMovimiento.php
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
 * Autor:					
 * *********************************************************
 */
session_start();
include_once ("../LibModeloAlma.php");
$Custom = new cls_CustomDBAlma();
$nombre_archivo = "ActionGuardarMovimiento.php";

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
			$id_movimiento = $_GET["hidden_id_movimiento_$j"];
			$id_tipo_movimiento = $_GET["hidden_id_tipo_movimiento_$j"];
			$id_almacen = $_GET["hidden_id_almacen_$j"];
			$id_solicitud_salida = $_GET["hidden_id_solicitud_salida_$j"];
			$codigo = $_GET["txt_codigo_$j"];
			$fecha_movimiento = $_GET["txt_fecha_movimiento_$j"];
			$descripcion = $_GET["txt_descripcion_$j"];
			$observaciones = $_GET["txt_observaciones_$j"];
			//variables de control del flujo de un movimiento
			$aprobacion= $_GET["txt_aprobacion_$j"]; //['si','no']
			$tipo_movimiento = $_GET["txt_tipo_movimiento_$j"];//['ingreso','salida']
			$accion_movimiento = $_GET["txt_accion_$j"];
			//variables para transpaso
			$almacen_destino = $_GET["txt_id_almacen_destino_$j"];
			$movimiento_origen = $_GET["id_movimiento_fk_$j"];
			
			$nro_compra = $_GET["txt_nro_compra_$j"];
		
		} else { 
			$id_movimiento = $_POST["hidden_id_movimiento_$j"];
			$id_tipo_movimiento = $_POST["hidden_id_tipo_movimiento_$j"];
			$id_almacen = $_POST["hidden_id_almacen_$j"];
			$id_solicitud_salida = $_POST["hidden_id_solicitud_salida_$j"];
			$codigo = $_POST["txt_codigo_$j"];
			$fecha_movimiento = $_POST["txt_fecha_movimiento_$j"];
			$descripcion = $_POST["txt_descripcion_$j"];
			$observaciones = $_POST["txt_observaciones_$j"];
			//variables de control del flujo de un movimiento
			$aprobacion= $_POST["txt_aprobacion_$j"]; //['si','no']
			$tipo_movimiento = $_POST["txt_tipo_movimiento_$j"];//['ingreso','salida']
			$accion_movimiento = $_POST["txt_accion_$j"];//['aprobar_borrador','finalizar_borrador','aprobar_pendiente','corregir_pendiente']
			//variables para transpaso
			$almacen_destino = $_POST["txt_id_almacen_destino_$j"];
			$movimiento_origen = $_POST["id_movimiento_fk_$j"];
			
			$nro_compra = $_POST["txt_nro_compra_$j"];
		}
		//condicion extra
		if($_POST['reporte'] == 'si')
		{
			$id_movimiento =$_POST['id_movimiento'];
			$tipo_movimiento=$_POST['tipo_movimiento'];
			$aprobacion=$_POST['aprobacion'];
			$accion_movimiento =$_POST['accion_solicitud']; 
		}
		elseif ($_POST['accion_solicitud'] == 'valorizar_movimiento')
		{
			$id_movimiento =$_POST['id_movimiento'];
			$accion_movimiento =$_POST['accion_solicitud'];
		}
		elseif ($_POST['accion_solicitud'] == 'corregir_movimiento')
		{
			$id_movimiento =$_POST['id_movimiento'];
			$accion_movimiento =$_POST['accion_solicitud'];
		} 		
		if ($id_movimiento == "undefined" || $id_movimiento == "") {
			// //////////////////Inserci�n/////////////////////
			// Validaci�n de datos (del lado del servidor)
			$res = $Custom->ValidarMovimiento("insert", $id_movimiento, $id_tipo_movimiento, $id_almacen, $id_solicitud_salida, $codigo, $fecha_movimiento, $descripcion, $observaciones);
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
			$res = $Custom->InsertarMovimiento($id_tipo_movimiento, $id_almacen, $id_solicitud_salida, $codigo, $fecha_movimiento, $descripcion, $observaciones,$almacen_destino,$movimiento_origen,$nro_compra);
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
		} else
		 { 
		 	if ($accion_movimiento != '') 
		 	{
		 		$res = $Custom->AccionesMovimiento($id_movimiento,$tipo_movimiento,$aprobacion,$accion_movimiento);
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
				// /////////////////////Modificaci�n////////////////////
			         // Validaci�n de datos (del lado del servidor)
				$res = $Custom->ValidarMovimiento("update", $id_movimiento, $id_tipo_movimiento, $id_almacen, $id_solicitud_salida, $codigo, $fecha_movimiento, $descripcion, $observaciones);
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
				$res = $Custom->ModificarMovimiento($id_movimiento, $id_tipo_movimiento, $id_almacen, $id_solicitud_salida, $codigo, $fecha_movimiento, $descripcion, $observaciones,$almacen_destino,$movimiento_origen,$nro_compra);
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
		$sortcol = "id_movimiento";
	if ($sortdir == "")
		$sortdir = "asc";
	if ($criterio_filtro == "")
	{
		if(isset($estado))
		{
			$criterio_filtro = " 0=0 AND  al.id_almacen=$id_almacen AND al.estado=''".$estado."''";
		}
		else {
			$criterio_filtro = "0=0";
		}
	}
	else {
		$criterio_filtro = "0=0";
	}	

	
	$res = $Custom->ContarMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	
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