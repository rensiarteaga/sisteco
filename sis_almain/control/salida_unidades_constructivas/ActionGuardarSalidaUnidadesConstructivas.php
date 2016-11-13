<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?> 
<?php

/**
 * **********************************************************
 * Nombre de archivo: ActionGuardarSalidaUnidadesConstructivas.php
 * Prop�sito:				Permite insertar y modificar datos en la tal_salida_uniadades_constructivas
 * Tabla:					tal_salida_uniadades_constructivas
 * Par�metros:				$id_salida_uc
 * $id_almacen
 * $codigo
 * $descripcion
 * $observaciones
 * $estado
 *
 * Valores de Retorno: N�mero de registros guardados
 * Fecha de Creaci�n:		24-12-2014
 * Versi�n:					1.0.0
 * Autor:					UNKNOW
 * *********************************************************
 */
session_start();
include_once ("../LibModeloAlma.php");

$Custom = new cls_CustomDBAlma();
$nombre_archivo = "ActionGuardarSalidaUnidadesConstructivas.php";
if (! isset($_SESSION["autentificado"])) {
	$_SESSION["autentificado"] = "NO";
}
if ($_SESSION["autentificado"] == "SI") 
{
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
			$id_salida_uc = $_GET["hidden_id_salida_uc_$j"];
			$id_almacen = $_GET["hidden_id_almacen_$j"];
			$num_contrato = $_GET["txt_nro_contrato_$j"];
			$fecha_sal = $_GET["txt_fecha_sal_$j"];
			$concepto_sal = $_GET["txt_concepto_salida_$j"];
			$observaciones = $_GET["txt_observaciones_$j"];
			$origen_sal = $_GET["txt_origen_salida_$j"];
			$id_proveedor=$_GET["txt_id_proveedor_$j"];
			$id_contratista=$_GET["txt_id_contratista_$j"];
			$id_empleado=$_GET["txt_id_empleado_$j"];
			$id_institucion=$_GET["txt_id_institucion_$j"];
			$id_fase=$_GET["txt_id_fase_$j"];
			$id_tramo=$_GET["txt_id_tramo_$j"];
			$id_uc=$_GET["txt_id_uc_$j"];
			$supervisor=$_GET["txt_supervisor_$j"];
			$ci_supervisor=$_GET["txt_ci_supervisor_$j"];
			$receptor=$_GET["txt_receptor_$j"];
			$ci_receptor=$_GET["txt_ci_receptor_$j"];
			$solicitante=$_GET["txt_solicitante_$j"];
			$ci_solicitante=$_GET["txt_ci_solicitante_$j"];
			
			$accion=$_GET["accion_$j"];
			
		} else 
		{
			$id_salida_uc = $_POST["hidden_id_salida_uc_$j"];
			$id_almacen = $_POST["hidden_id_almacen_$j"];
			$num_contrato = $_POST["txt_nro_contrato_$j"];
			$fecha_sal = $_POST["txt_fecha_sal_$j"];
			$concepto_sal = $_POST["txt_concepto_salida_$j"];
			$observaciones = $_POST["txt_observaciones_$j"];
			$origen_sal = $_POST["txt_origen_salida_$j"];
			$id_proveedor=$_POST["txt_id_proveedor_$j"];
			$id_contratista=$_POST["txt_id_contratista_$j"];
			$id_empleado=$_POST["txt_id_empleado_$j"];
			$id_institucion=$_POST["txt_id_institucion_$j"];
			$id_fase=$_POST["txt_id_fase_$j"];
			$id_tramo=$_POST["txt_id_tramo_$j"];
			$id_uc=$_POST["txt_id_uc_$j"];
			$supervisor=$_POST["txt_supervisor_$j"];
			$ci_supervisor=$_POST["txt_ci_supervisor_$j"];
			$receptor=$_POST["txt_receptor_$j"];
			$ci_receptor=$_POST["txt_ci_receptor_$j"];
			$solicitante=$_POST["txt_solicitante_$j"];
			$ci_solicitante=$_POST["txt_ci_solicitante_$j"];
			
			$accion=$_POST["accion_$j"];
			
		}
	
		if ($id_salida_uc == "undefined" || $id_salida_uc == "") 
		{
			// //////////////////Inserci�n///////////////////// 
			
			// Validaci�n de datos (del lado del servidor)
			$res = $Custom->ValidarSalidaUC("insert", $id_salida_uc, $id_almacen, $num_contrato, $fecha_sal, $concepto_sal,$observaciones
							,$origen_sal,$id_proveedor,$id_contratista,$id_empleado,$id_institucion,$id_fase,$id_tramo,$id_uc,$supervisor
							,$ci_supervisor,$receptor,$ci_receptor,$solicitante,$ci_solicitante);
			
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
			$res = $Custom->InsertarSalidaUC($id_salida_uc, $id_almacen, $num_contrato, $fecha_sal, $concepto_sal, $observaciones,$origen_sal
							,$id_proveedor,$id_contratista,$id_empleado,$id_institucion,$id_fase,$id_tramo,$id_uc,$supervisor,$ci_supervisor,$receptor,$ci_receptor,$solicitante,$ci_solicitante);
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
			if(isset($accion) && ($accion!="" || $accion !="undefined" ))
			{
				$res = $Custom->ProcesarMovimientoSalidaProyecto($id_salida_uc,$accion);
					
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
					// /////////////////////Modificaci�n////////////////////
				     // Validaci�n de datos (del lado del servidor)
					$res = $Custom->ValidarSalidaUC("update", $id_salida_uc, $id_almacen, $num_contrato, $fecha_sal, $concepto_sal,$observaciones
									,$origen_sal,$id_proveedor,$id_contratista,$id_empleado,$id_institucion,$id_fase,$id_tramo,$id_uc,$supervisor
									,$ci_supervisor,$receptor,$ci_receptor,$solicitante,$ci_solicitante);
					
					if (! $res) {
		
						$resp = new cls_manejo_mensajes(true, "406");
						$resp->mensaje_error = $Custom->salida[1];
						$resp->origen = $Custom->salida[2];
						$resp->proc = $Custom->salida[3];
						$resp->nivel = $Custom->salida[4];
						echo $resp->get_mensaje();
						exit();
					}
					$res = $Custom->ModificarSalidaUC($id_salida_uc, $id_almacen, $num_contrato, $fecha_sal, $concepto_sal, $observaciones,$origen_sal
									,$id_proveedor,$id_contratista,$id_empleado,$id_institucion,$id_fase,$id_tramo,$id_uc,$supervisor,$ci_supervisor,$receptor,$ci_receptor,$solicitante,$ci_solicitante);
					
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
		$sortcol = "id_item";
	if ($sortdir == "")
		$sortdir = "asc";
	if ($criterio_filtro == "")
		$criterio_filtro =$criterio_filtro." 0=0 AND suc.id_almacen like (".$id_almacen.")";

	$res = $Custom->ContarSalidaUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
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