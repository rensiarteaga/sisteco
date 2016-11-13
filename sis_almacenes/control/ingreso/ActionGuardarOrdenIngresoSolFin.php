<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarOrdenIngresoSol.php
Propósito:				Permite insertar y modificar datos en la tabla tal_ingreso
Tabla:					tal_tal_ingreso
Parámetros:				$hidden_id_ingreso
						$txt_correlativo_ord_ing
						$txt_correlativo_ing
						$txt_codigo
						$txt_descripcion
						$txt_observaciones
						$txt_costo_total
						$txt_contabilizar
						$txt_contabilizado
						$txt_estado_ingreso
						$txt_estado_registro
						$txt_cod_inf_tec
						$txt_resumen_inf_tec
						$txt_fecha_borrador
						$txt_fecha_pendiente
						$txt_fecha_aprobado_rechazado
						$txt_fecha_ing_fisico
						$txt_fecha_ing_valorado
						$txt_fecha_finalizado_cancelado
						$txt_fecha_reg
						$txt_id_responsable_almacen
						$txt_id_proveedor
						$txt_id_contratista
						$txt_id_empleado
						$txt_id_almacen_logico
						$txt_id_firma_autorizada
						$txt_id_institucion
						$txt_id_motivo_ingreso

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-10-18 20:49:02
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../rcm_LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = "ActionGuardarOrdenIngresoSolFin.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{
	//Verifica si los datos vienen por POST o GET
	if (sizeof($_GET) > 0)
	{
		$get=true;
		$cont=1;

		//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
		//valores permitidos de $cod -> "si", "no"
		switch ($cod)
		{
			case "si":
				$decodificar = true;
				break;
			case "no":
				$decodificar = false;
				break;
			default:
				$decodificar = true;
				break;
		}
	}
	elseif(sizeof($_POST) > 0)
	{
		$get = false;
		$cont =  $_POST["cantidad_ids"];

		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar.";
		$resp->origen = "ORIGEN = ";
		$resp->proc = "PROC = ";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit;
	}

	//Envia al Custom la bandera que indica si se decodificará o no
	$Custom->decodificar = $decodificar;

	//Realiza el bucle por todos los ids mandados
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$hidden_id_ingreso= $_GET["hidden_id_ingreso_$j"];
		}
		else
		{
			$hidden_id_ingreso=$_POST["hidden_id_ingreso_$j"];
		}

		if ($hidden_id_ingreso == "undefined" || $hidden_id_ingreso == "")
		{
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = "Solicitud de Orden de Ingreso inexistente";
			$resp->origen = $nombre_archivo;
			$resp->proc = "";
			$resp->nivel = "3";
			echo $resp->get_mensaje();
			exit;
		}
		else
		{
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarOrdenIngresoSol("fin",$tipo,$hidden_id_ingreso, $txt_correlativo_ord_ing, $txt_correlativo_ing, $txt_descripcion, $txt_costo_total, $txt_contabilizar, $txt_contabilizado, $txt_estado_ingreso, $txt_estado_registro, $txt_cod_inf_tec, $txt_resumen_inf_tec, $txt_fecha_borrador, $txt_fecha_pendiente, $txt_fecha_aprobado_rechazado, $txt_fecha_ing_fisico, $txt_fecha_ing_valorado, $txt_fecha_finalizado_cancelado, $txt_fecha_reg, $txt_id_responsable_almacen, $txt_id_proveedor, $txt_id_contratista, $txt_id_empleado, $txt_id_almacen_logico, $txt_id_firma_autorizada, $txt_id_institucion, $txt_id_motivo_ingreso_cuenta);

			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			$res = $Custom->FinalizarOrdenIngresoSol($hidden_id_ingreso, $txt_correlativo_ord_ing, $txt_correlativo_ing, $txt_descripcion, $txt_costo_total, $txt_contabilizar, $txt_contabilizado, $txt_estado_ingreso, $txt_estado_registro, $txt_cod_inf_tec, $txt_resumen_inf_tec, $txt_fecha_borrador, $txt_fecha_pendiente, $txt_fecha_aprobado_rechazado, $txt_fecha_ing_fisico, $txt_fecha_ing_valorado, $txt_fecha_finalizado_cancelado, $txt_fecha_reg, $txt_id_responsable_almacen, $txt_id_proveedor, $txt_id_contratista, $txt_id_empleado, $txt_id_almacen_logico, $txt_id_firma_autorizada, $txt_id_institucion, $txt_id_motivo_ingreso_cuenta);

			if(!$res)
			{
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

	}//END FOR

	//Obtiene el tipo de motivo ingreso y lo decodifica
	$tipo=utf8_decode($tipo);

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_ingreso";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarOrdenIngresoSol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", $total_registros);
	$resp->add_nodo("mensaje", $mensaje_exito);
	$resp->add_nodo("tiempo_resp", "200");
	echo $resp->get_mensaje();
	exit;
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp->get_mensaje();
	exit;
}
?>