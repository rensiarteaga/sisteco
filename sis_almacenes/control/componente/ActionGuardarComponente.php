<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarComponente.php
Propósito:				Permite insertar y modificar datos en la tabla tal_componente
Tabla:					tal_tal_componente
Parámetros:				$hidden_id_componente
						$txt_cantidad
						$txt_estado_registro
						$txt_cosiderar_repeticion
						$txt_fecha_reg
						$txt_descripcion
						$txt_id_item
						$txt_id_tipo_unidad_constructiva

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-11-07 16:22:55
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../arv_LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = "ActionGuardarComponente.php";

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
			$hidden_id_componente= $_GET["hidden_id_componente_$j"];
			$txt_cantidad= $_GET["txt_cantidad_$j"];
			$txt_estado_registro= $_GET["txt_estado_registro_$j"];
			$txt_cosiderar_repeticion= $_GET["txt_cosiderar_repeticion_$j"];
			$txt_fecha_reg= $_GET["txt_fecha_reg_$j"];
			$txt_descripcion= $_GET["txt_descripcion_$j"];
			$txt_id_item= $_GET["txt_id_item_$j"];
			$txt_id_tipo_unidad_constructiva= $_GET["txt_id_tipo_unidad_constructiva_$j"];

		}
		else
		{
			$hidden_id_componente=$_POST["hidden_id_componente_$j"];
			$txt_cantidad=$_POST["txt_cantidad_$j"];
			$txt_estado_registro=$_POST["txt_estado_registro_$j"];
			$txt_cosiderar_repeticion=$_POST["txt_cosiderar_repeticion_$j"];
			$txt_fecha_reg=$_POST["txt_fecha_reg_$j"];
			$txt_descripcion=$_POST["txt_descripcion_$j"];
			$txt_id_item=$_POST["txt_id_item_$j"];
			$txt_id_tipo_unidad_constructiva=$_POST["txt_id_tipo_unidad_constructiva_$j"];

		}

		if ($hidden_id_componente == "undefined" || $hidden_id_componente == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarComponente("insert",$hidden_id_componente, $txt_cantidad,$txt_estado_registro,$txt_cosiderar_repeticion,$txt_fecha_reg,$txt_descripcion,$txt_id_item,$txt_id_tipo_unidad_constructiva);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tal_componente
			$res = $Custom -> InsertarComponente($hidden_id_componente, $txt_cantidad, $txt_estado_registro, $txt_cosiderar_repeticion, $txt_fecha_reg, $txt_descripcion, $txt_id_item, $txt_id_tipo_unidad_constructiva);

			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] . " (iteración $cont)";
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		}
		else
		{	///////////////////////Modificación////////////////////
			
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarComponente("update",$hidden_id_componente, $txt_cantidad, $txt_estado_registro, $txt_cosiderar_repeticion, $txt_fecha_reg, $txt_descripcion, $txt_id_item, $txt_id_tipo_unidad_constructiva);

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

			$res = $Custom->ModificarComponente($hidden_id_componente, $txt_cantidad, $txt_estado_registro, $txt_cosiderar_repeticion, $txt_fecha_reg, $txt_descripcion, $txt_id_item, $txt_id_tipo_unidad_constructiva);

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

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_componente";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = '0=0';

	$res = $Custom->ContarComponente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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