<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarEstadoCompra.php
Propósito:				Permite insertar y modificar datos en la tabla tad_estado_compra
Tabla:					tad_tad_estado_compra
Parámetros:				$hidden_id_estado_compra
						$txt_descripcion
						$txt_proceso_sistema
						$txt_cronometrable
						$txt_nombre
						$txt_tiempo_estimado

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-09 18:25:28
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarEstadoCompra.php";

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
			$hidden_id_estado_compra= $_GET["hidden_id_estado_compra_$j"];
			$txt_descripcion= $_GET["txt_descripcion_$j"];
			$txt_proceso_sistema= $_GET["txt_proceso_sistema_$j"];
			$txt_cronometrable= $_GET["txt_cronometrable_$j"];
			$txt_nombre= $_GET["txt_nombre_$j"];
			$txt_tiempo_estimado= $_GET["txt_tiempo_estimado_$j"];

		}
		else
		{
			$hidden_id_estado_compra=$_POST["hidden_id_estado_compra_$j"];
			$txt_descripcion=$_POST["txt_descripcion_$j"];
			$txt_proceso_sistema=$_POST["txt_proceso_sistema_$j"];
			$txt_cronometrable=$_POST["txt_cronometrable_$j"];
			$txt_nombre=$_POST["txt_nombre_$j"];
			$txt_tiempo_estimado=$_POST["txt_tiempo_estimado_$j"];

		}

		if ($hidden_id_estado_compra == "undefined" || $hidden_id_estado_compra == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarEstadoCompra("insert",$hidden_id_estado_compra, $txt_descripcion,$txt_proceso_sistema,$txt_cronometrable,$txt_nombre,$txt_tiempo_estimado);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tad_estado_compra
			$res = $Custom -> InsertarEstadoCompra($hidden_id_estado_compra, $txt_descripcion, $txt_proceso_sistema, $txt_cronometrable, $txt_nombre, $txt_tiempo_estimado);

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
			$res = $Custom->ValidarEstadoCompra("update",$hidden_id_estado_compra, $txt_descripcion, $txt_proceso_sistema, $txt_cronometrable, $txt_nombre, $txt_tiempo_estimado);

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

			$res = $Custom->ModificarEstadoCompra($hidden_id_estado_compra, $txt_descripcion, $txt_proceso_sistema, $txt_cronometrable, $txt_nombre, $txt_tiempo_estimado);

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
	if($sortcol == "") $sortcol = "id_estado_compra";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarEstadoCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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