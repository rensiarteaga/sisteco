<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarSalidaDetalle.php
Propósito:				Permite insertar y modificar datos en la tabla tal_salida_detalle
Tabla:					tal_tal_salida_detalle
Parámetros:				$hidden_id_salida_detalle
						$txt_costo
						$txt_costo_unitario
						$txt_precio_unitario
						$txt_cant_solicitada
						$txt_cant_entregada
						$txt_cant_consolidada
						$txt_descripcion
						$txt_observaciones
						$txt_fecha_solicitada
						$txt_fecha_entregada
						$txt_fecha_consolidada
						$txt_fecha_reg
						$txt_id_item
						$txt_id_salida
						$txt_id_unidad_constructiva

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-10-25 10:40:51
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../fpc_LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = "ActionGuardarSalidaDetalleConsolidada.php";

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
			$hidden_id_salida_detalle= $_GET["hidden_id_salida_detalle_$j"];
			$txt_costo= $_GET["txt_costo_$j"];
			$txt_costo_unitario= $_GET["txt_costo_unitario_$j"];
			$txt_precio_unitario= $_GET["txt_precio_unitario_$j"];
			$txt_cant_solicitada= $_GET["txt_cant_solicitada_$j"];
			$txt_cant_entregada= $_GET["txt_cant_entregada_$j"];
			$txt_cant_consolidada= $_GET["txt_cant_consolidada_$j"];
			$txt_descripcion= $_GET["txt_descripcion_$j"];
			$txt_observaciones= $_GET["txt_observaciones_$j"];
			$txt_fecha_solicitada= $_GET["txt_fecha_solicitada_$j"];
			$txt_fecha_entregada= $_GET["txt_fecha_entregada_$j"];
			$txt_fecha_consolidada= $_GET["txt_fecha_consolidada_$j"];
			$txt_fecha_reg= $_GET["txt_fecha_reg_$j"];
			$txt_id_item= $_GET["txt_id_item_$j"];
			$txt_id_salida= $_GET["txt_id_salida_$j"];
			$txt_id_unidad_constructiva= $_GET["txt_id_unidad_constructiva_$j"];
			$txt_estado_item= $_GET["txt_estado_item_$j"];
		}
		else
		{
			$hidden_id_salida_detalle=$_POST["hidden_id_salida_detalle_$j"];
			$txt_costo=$_POST["txt_costo_$j"];
			$txt_costo_unitario=$_POST["txt_costo_unitario_$j"];
			$txt_precio_unitario=$_POST["txt_precio_unitario_$j"];
			$txt_cant_solicitada=$_POST["txt_cant_solicitada_$j"];
			$txt_cant_entregada=$_POST["txt_cant_entregada_$j"];
			$txt_cant_consolidada=$_POST["txt_cant_consolidada_$j"];
			$txt_descripcion=$_POST["txt_descripcion_$j"];
			$txt_observaciones=$_POST["txt_observaciones_$j"];
			$txt_fecha_solicitada=$_POST["txt_fecha_solicitada_$j"];
			$txt_fecha_entregada=$_POST["txt_fecha_entregada_$j"];
			$txt_fecha_consolidada=$_POST["txt_fecha_consolidada_$j"];
			$txt_fecha_reg=$_POST["txt_fecha_reg_$j"];
			$txt_id_item=$_POST["txt_id_item_$j"];
			$txt_id_salida=$_POST["txt_id_salida_$j"];
			$txt_id_unidad_constructiva=$_POST["txt_id_unidad_constructiva_$j"];
			$txt_estado_item= $_POST["txt_estado_item_$j"];

		}

		///////////////////////Modificación////////////////////

		$res = $Custom->ModificarSalidaDetalleConsolidada($hidden_id_salida_detalle, $txt_costo, $txt_costo_unitario, $txt_precio_unitario, $txt_cant_solicitada, $txt_cant_entregada, $txt_cant_consolidada, $txt_descripcion, $txt_observaciones, $txt_fecha_solicitada, $txt_fecha_entregada, $txt_fecha_consolidada, $txt_fecha_reg, $txt_id_item, $txt_id_salida, $txt_id_unidad_constructiva,$txt_estado_item);

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


	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_salida_detalle";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "SALIDA.id_salida=''$m_id_salida''";

	$res = $Custom->ContarSalidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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