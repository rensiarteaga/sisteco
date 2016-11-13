<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?> 
<?php

/**
 * **********************************************************
 * Nombre de archivo: ActionGuardarCosteo.php
 * Propósito:				Permite insertar y modificar datos en la tal_costeo
 * Tabla:					tal_costeo
 * Parámetros:				$id_costeo
 * $id_almacen
 * $codigo
 * $descripcion
 * $observaciones
 * $estado
 *
 * Valores de Retorno: Número de registros guardados
 * Fecha de Creación:		05-05-2015
 * Versión:					1.0.0
 * Autor:					UNKNOW
 * *********************************************************
 */
session_start();
include_once ("../LibModeloAlma.php");

$Custom = new cls_CustomDBAlma();
$nombre_archivo = "ActionGuardarCosteo.php";
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
			$id_costeo = $_GET["hidden_id_costeo_$j"];
			$descripcion = $_GET["txt_descripcion_$j"];
			$fecha_ingreso = $_GET["txt_fecha_ingreso_$j"];
			$fecha_salida = $_GET["txt_fecha_salida_$j"];	
			$id_almacen= $_GET["hidden_id_almacen_$j"];
			
			$id_mov_proy= $_GET["h_id_mov_proyecto_$j"];
			$tipo_costeo= $_GET["txt_tipo_costeo_$j"];
		} else 
		{
			$id_costeo = $_POST["hidden_id_costeo_$j"];
			$descripcion = $_POST["txt_descripcion_$j"];
			$fecha_ingreso = $_POST["txt_fecha_ingreso_$j"];
			$fecha_salida = $_POST["txt_fecha_salida_$j"];		
			$id_almacen= $_POST["hidden_id_almacen_$j"];
			
			$id_mov_proy= $_POST["h_id_mov_proyecto_$j"];
			$tipo_costeo= $_POST["txt_tipo_costeo_$j"];
		}
		if ($id_costeo == "undefined" || $id_costeo == "") 
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
			$res = $Custom->InsertarCosteo($id_costeo, $descripcion, $fecha_ingreso, $fecha_salida, $id_almacen,$id_mov_proy,$tipo_costeo);
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
				if(isset($accion_solicitud) && $accion_solicitud =='costear')
				{					
					$res = $Custom->CostearIngresos($id_costeo,$p_tipo_costeo);
				
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
				else if(isset($accion_solicitud) && $accion_solicitud == 'corregir_costeo')
				{	
					$res = $Custom->CorregirCosteo($id_costeo,$estado_costeo);
					
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
					$res = $Custom->ModificarCosteo($id_costeo, $descripcion, $fecha_ingreso, $fecha_salida, $id_almacen,$id_mov_proy,$tipo_costeo);
						
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
	if (isset($id_mov_proy))
		$criterio_filtro = "0=0 AND cos.id_movimiento_proyecto like(".$id_mov_proy.")";
	else if(isset($_POST['id_mov_proy']))
		$criterio_filtro =$criterio_filtro." 0=0 AND cos.id_movimiento_proyecto like (".$_POST['id_mov_proy'].")";
	
	$res = $Custom->ContarCosteo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
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