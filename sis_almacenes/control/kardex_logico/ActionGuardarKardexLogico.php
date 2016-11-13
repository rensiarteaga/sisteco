<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarKardexLogico.php
Prop�sito:				Permite insertar y modificar datos en la tabla tal_kardex_logico
Tabla:					tal_tal_kardex_logico
Par�metros:				$hidden_id_kardex_logico
						$txt_estado_item
						$txt_stock_minimo
						$txt_cantidad
						$txt_costo_unitario
						$txt_costo_total
						$txt_stock
						$txt_fecha_reg
						$txt_id_item
						$txt_id_almacen_logico
						$txt_reservado

Valores de Retorno:    	N�mero de registros guardados
Fecha de Creaci�n:		2007-10-26 15:20:22
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = "ActionGuardarKardexLogico.php";

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
		
		//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
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
	
	//Envia al Custom la bandera que indica si se decodificar� o no
	$Custom->decodificar = $decodificar;

	//Realiza el bucle por todos los ids mandados
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$hidden_id_kardex_logico= $_GET["hidden_id_kardex_logico_$j"];
			$txt_estado_item= $_GET["txt_estado_item_$j"];
			$txt_stock_minimo= $_GET["txt_stock_minimo_$j"];
			$txt_cantidad= $_GET["txt_cantidad_$j"];
			$txt_costo_unitario= $_GET["txt_costo_unitario_$j"];
			$txt_costo_total= $_GET["txt_costo_total_$j"];
			$txt_fecha_reg= $_GET["txt_fecha_reg_$j"];
			$txt_id_item= $_GET["txt_id_item_$j"];
			$txt_id_almacen_logico= $_GET["txt_id_almacen_logico_$j"];
			$txt_reservado= $_GET["txt_reservado_$j"];

		}
		else
		{
			$hidden_id_kardex_logico=$_POST["hidden_id_kardex_logico_$j"];
			$txt_estado_item=$_POST["txt_estado_item_$j"];
			$txt_stock_minimo=$_POST["txt_stock_minimo_$j"];
			$txt_cantidad=$_POST["txt_cantidad_$j"];
			$txt_costo_unitario=$_POST["txt_costo_unitario_$j"];
			$txt_costo_total=$_POST["txt_costo_total_$j"];
			$txt_fecha_reg=$_POST["txt_fecha_reg_$j"];
			$txt_id_item=$_POST["txt_id_item_$j"];
			$txt_id_almacen_logico=$_POST["txt_id_almacen_logico_$j"];
			$txt_reservado=$_POST["txt_reservado_$j"];

		}

		if ($hidden_id_kardex_logico == "undefined" || $hidden_id_kardex_logico == "")
		{
			////////////////////Inserci�n/////////////////////

			//Validaci�n de datos (del lado del servidor)
			$res = $Custom->ValidarKardexLogico("insert",$hidden_id_kardex_logico, $txt_estado_item,$txt_stock_minimo,$txt_cantidad,$txt_costo_unitario,$txt_costo_total,$txt_fecha_reg,$txt_id_item,$txt_id_almacen_logico,$txt_reservado);

			if(!$res)
			{
				//Error de validaci�n
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			//Validaci�n satisfactoria, se ejecuta la inserci�n en la tabla tal_kardex_logico
			$res = $Custom -> InsertarKardexLogico($hidden_id_kardex_logico, $txt_estado_item, $txt_stock_minimo, $txt_cantidad, $txt_costo_unitario, $txt_costo_total, $txt_fecha_reg, $txt_id_item, $txt_id_almacen_logico, $txt_reservado);

			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] . " (iteraci�n $cont)";
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		}
		else
		{	///////////////////////Modificaci�n////////////////////
			
			//Validaci�n de datos (del lado del servidor)
			$res = $Custom->ValidarKardexLogico("update",$hidden_id_kardex_logico, $txt_estado_item, $txt_stock_minimo, $txt_cantidad, $txt_costo_unitario, $txt_costo_total, $txt_fecha_reg, $txt_id_item, $txt_id_almacen_logico, $txt_reservado);

			if(!$res)
			{
				//Error de validaci�n
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			$res = $Custom->ModificarKardexLogico($hidden_id_kardex_logico, $txt_estado_item, $txt_stock_minimo, $txt_cantidad, $txt_costo_unitario, $txt_costo_total, $txt_fecha_reg, $txt_id_item, $txt_id_almacen_logico, $txt_reservado);

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

	//Guarda el mensaje de �xito de la operaci�n realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Par�metros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_kardex_logico";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "ALMLOG.id_almacen_logico=''$m_id_almacen_logico''";

	$res = $Custom->ContarKardexLogico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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