<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?>
<?php

/**
 * **********************************************************
 * Nombre de archivo: ActionGuardarMovimientoProyecto.php
 * Prop�sito:				Permite insertar y modificar datos en la tal_movimiento
 * Tabla:					tal_movimiento
 * Par�metros:				$id_movimiento_proyecto
 * $id_lugar
 * $id_depto
 * $codigo
 * $nombre
 * $direccion
 * $tipo_control
 *
 * Valores de Retorno: N�mero de registros guardados
 * Fecha de Creaci�n:		27-10-2014
 * Versi�n:					1.0.0
 * Autor:					UNKNOW
 * *********************************************************
 */
session_start();
include_once ("../LibModeloAlma.php");
$Custom = new cls_CustomDBAlma();
$nombre_archivo = "ActionGuardarMovimientoProyecto.php";

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
			$id_movimiento_proyecto = $_GET["hidden_id_mov_proy_$j"];
			$almacen = $_GET["hidden_id_almacen_$j"];
			$tipo_mov = $_GET["hidden_id_tipo_movimiento_$j"];
			$concepto_ingreso = $_GET["txt_concepto_ingreso_$j"];
			$fecha_ingreso = $_GET["txt_fecha_reg_$j"];
			$origen_ingreso = $_GET["txt_origen_ingreso_$j"];
			$proveedor = $_GET["txt_id_proveedor_$j"];
			$contratista = $_GET["txt_id_contratista_$j"];
			$empleado = $_GET["txt_id_empleado_$j"];
			$institucion = $_GET["txt_id_institucion_$j"];
			$observaciones = $_GET["txt_observaciones_$j"];
			//a�adido 07-01-2014
			$entregado_por = $_GET["txt_entregado_por_$j"];
			$nota_remision = $_GET["txt_nota_remision_$j"];
			$nro_contrato = $_GET["txt_nro_contrato_$j"];
			//a�adido 12-05-2015
			$peso_neto=$_GET["txt_peso_neto_$j"];			
		} 
		else 
		{ 
			$id_movimiento_proyecto = $_POST["hidden_id_mov_proy_$j"];
			$almacen = $_POST["hidden_id_almacen_$j"];
			$tipo_mov = $_POST["hidden_id_tipo_movimiento_$j"];
			$concepto_ingreso = $_POST["txt_concepto_ingreso_$j"];
			$fecha_ingreso = $_POST["txt_fecha_reg_$j"];
			$origen_ingreso = $_POST["txt_origen_ingreso_$j"];
			$proveedor = $_POST["txt_id_proveedor_$j"];
			$contratista = $_POST["txt_id_contratista_$j"];
			$empleado = $_POST["txt_id_empleado_$j"];
			$institucion = $_POST["txt_id_institucion_$j"];
			$observaciones = $_POST["txt_observaciones_$j"];
			//a�adido 07-01-2014
			$entregado_por = $_POST["txt_entregado_por_$j"];
			$nota_remision = $_POST["txt_nota_remision_$j"];
			$nro_contrato = $_POST["txt_nro_contrato_$j"];
			//a�adido 12-05-2015
			$peso_neto=$_POST["txt_peso_neto_$j"];
		}
		
		if ($id_movimiento_proyecto == "undefined" || $id_movimiento_proyecto == "") 
		{ 	
			// //////////////////Inserci�n/////////////////////
			// Validaci�n de datos (del lado del servidor)
			$res = $Custom->ValidarMovimientoProyecto("insert", $id_movimiento_proyecto, $almacen,$fecha_ingreso, $concepto_ingreso, $origen_ingreso, $proveedor, $contratista,$empleado,$institucion,$observaciones);
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
			$res = $Custom->InsertarMovimientoProyecto($id_movimiento_proyecto, $almacen,$tipo_mov , $concepto_ingreso, $fecha_ingreso, $origen_ingreso, $proveedor, $contratista,$empleado,$institucion,$observaciones,$entregado_por,$nota_remision,$nro_contrato,$peso_neto);
			if (! $res) {
				// Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] . " (iteracion $cont)";
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit();
			}
		} else
		 { 	 			
				if(isset($accion) && $accion == 'corregir_movfin')
				{
					
					$res = $Custom->CorregirMovimientoProyectoIngreso($id_movimiento_proyecto);
					
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
				else
				{	
					// Validaci�n de datos (del lado del servidor)
					$res = $Custom->ValidarMovimientoProyecto("update", $id_movimiento_proyecto, $almacen,$fecha_ingreso, $concepto_ingreso, $origen_ingreso, $proveedor, $contratista,$empleado,$institucion,$observaciones);
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
					
					$res = $Custom->ModificarMovimientoProyecto($id_movimiento_proyecto, $almacen,$tipo_mov , $concepto_ingreso, $fecha_ingreso, $origen_ingreso, $proveedor, $contratista,$empleado,$institucion,$observaciones,$entregado_por,$nota_remision,$nro_contrato);
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
		$sortcol = "id_movimiento_proyecto";
	if ($sortdir == "")
		$sortdir = "asc";
	if ($criterio_filtro == "")
		$criterio_filtro = "0=0";

	$res =  $Custom->ContarMovimientoProyecto($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad); 
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