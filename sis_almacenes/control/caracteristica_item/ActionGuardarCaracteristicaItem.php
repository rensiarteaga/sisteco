<?php
/*
**********************************************************
Nombre de archivo:	    ActionGuardarCaracteristicaItem.php
Propósito:				Permite insertar y modificar tal_caracteristica_item
Tabla:					tal_caracteristica_item
Parámetros:				$hidden_id_caracteristica_item
$txt_descripcion
$txt_flag_comprobante
$txt_tipo_comprobante

Valores de Retorno:    	Número de registros
Fecha de Creación:		29-09-2007
Versión:				1.0.0
Autor:					Rodrigo Chumacero Moscoso
**********************************************************
*/
session_start();
include_once("../LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = 'ActionGuardarCaracteristicaItem.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
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
		$cont =  $_POST['cantidad_ids'];

		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = 'NIVEL = 4';
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
			$hidden_id_caracteristica_item = $_GET["hidden_id_caracteristica_item_$j"];
			//$txt_valor=$_GET["txt_valor_$j"];
			
			$txt_observaciones = $_GET["txt_observaciones_$j"];
			$txt_fecha_reg = $_GET["txt_fecha_reg_$j"];
			$txt_id_item = $_GET["txt_id_item_$j"];
			$txt_id_caracteristica = $_GET["txt_id_caracteristica_$j"];
			$txt_id_unidad_medida_base = $_GET["txt_id_unidad_medida_base_$j"];
			$txt_valor_integer=$_GET["txt_valor_integer_$j"];
			$txt_valor_decimal=$_GET["txt_valor_decimal_$j"];
			$txt_valor_varchar=$_GET["txt_valor_varchar_$j"];
			$txt_valor_date=$_GET["txt_valor_date_$j"];
			
			
			
		}
		else
		{
			$hidden_id_caracteristica_item = $_POST["hidden_id_caracteristica_item_$j"];
			//$txt_valor=$_POST["txt_valor_$j"];
			
			$txt_observaciones = $_POST["txt_observaciones_$j"];
			$txt_fecha_reg = $_POST["txt_fecha_reg_$j"];
			$txt_id_item = $_POST["txt_id_item_$j"];
			$txt_id_caracteristica = $_POST["txt_id_caracteristica_$j"];
			$txt_id_unidad_medida_base = $_POST["txt_id_unidad_medida_base_$j"];
			$txt_valor_integer=$_POST["txt_valor_integer_$j"];
			$txt_valor_decimal=$_POST["txt_valor_decimal_$j"];
			$txt_valor_varchar=$_POST["txt_valor_varchar_$j"];
			$txt_valor_date=$_POST["txt_valor_date_$j"];
			
			
			
		}
		
		if($txt_valor_date != "undefined" && $txt_valor_date !="" ){
			$txt_valor = $txt_valor_date;
		}else{
			if($txt_valor_integer != "undefined" && $txt_valor_integer!="" ){
				$txt_valor = $txt_valor_integer;
			}else{
				if($txt_valor_decimal != "undefined" && $txt_valor_decimal !="" ){
					$txt_valor = $txt_valor_decimal;
				}else{
					$txt_valor = $txt_valor_varchar;
				}	
			}
		}

		if ($hidden_id_caracteristica_item == "undefined" || $hidden_id_caracteristica_item == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarCaracteristicaItem("insert",$hidden_id_caracteristica_item,$txt_valor,$txt_observaciones,$txt_fecha_reg,$txt_id_item,$txt_id_caracteristica,$txt_id_unidad_medida_base);
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

			//Validación satisfactoria, se ejecuta la inserción del cambio de lectura
			$res = $Custom->InsertarCaracteristicaItem($hidden_id_caracteristica_item,$txt_valor,$txt_observaciones,$txt_fecha_reg,$txt_id_item,$txt_id_caracteristica,$txt_id_unidad_medida_base);
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
			$res = $Custom->ValidarCaracteristicaItem("update",$hidden_id_caracteristica_item,$txt_valor,$txt_observaciones,$txt_fecha_reg,$txt_id_item,$txt_id_caracteristica,$txt_id_unidad_medida_base);
			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel =$Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			$res = $Custom->ModificarCaracteristicaItem($hidden_id_caracteristica_item,$txt_valor,$txt_observaciones,$txt_fecha_reg,$txt_id_item,$txt_id_caracteristica,$txt_id_unidad_medida_base);
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
	if($cont > 1) $mensaje_exito = 'Se guardaron todos los datos.';
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'id_caracteristica_item';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro = '0=0';

	$res = $Custom->ContarCaracteristicaItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo('TotalCount', $total_registros);
	$resp->add_nodo('mensaje', $mensaje_exito);
	$resp->add_nodo('tiempo_resp', '200');
	echo $resp->get_mensaje();
	exit;
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 1';
	echo $resp->get_mensaje();
	exit;
}
?>