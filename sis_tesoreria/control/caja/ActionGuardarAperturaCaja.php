<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarAperturaCaja.php
Propósito:				Permite insertar y modificar datos en la tabla tts_caja
Tabla:					tts_tts_caja
Parámetros:				$id_caja
						$fecha_inicio
						$importe_maximo
						$porcentaje_compra
						$nombre

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-10-21 08:22:08
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloTesoreria.php");

include_once("../../../sis_contabilidad/control/LibModeloContabilidad.php");

$Custom = new cls_CustomDBTesoreria();
 
$CustomSCI= new cls_CustomDBcontabilidadIntegracion();
 
$nombre_archivo = "ActionGuardarAperturaCaja.php";

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
			$id_caja= $_GET["id_caja_$j"];
			$fecha_inicio= $_GET["fecha_inicio_$j"];
			$importe_maximo= $_GET["importe_maximo_$j"];
			$porcentaje_compra= $_GET["porcentaje_compra_$j"];
			$porcentaje_rinde= $_GET["porcentaje_rinde_$j"];
			$nombre= $_GET["nombre_$j"];
			$nro_vale= $_GET["nro_vale_$j"];
			$nro_rinde= $_GET["nro_rinde_$j"];
			$nro_recibo= $_GET["nro_recibo_$j"];
			$sw_contabilizar= $_GET["sw_contabilizar_$j"];
		}else{
			$id_caja=$_POST["id_caja_$j"];
			$fecha_inicio=$_POST["fecha_inicio_$j"];
			$importe_maximo=$_POST["importe_maximo_$j"];
			$porcentaje_compra=$_POST["porcentaje_compra_$j"];
			$porcentaje_rinde= $_POST["porcentaje_rinde_$j"];
			$nombre=$_POST["nombre_$j"];
			$nro_vale= $_POST["nro_vale_$j"];
			$nro_rinde= $_POST["nro_rinde_$j"];
			$nro_recibo= $_POST["nro_recibo_$j"];
			$sw_contabilizar= $_POST["sw_contabilizar_$j"];
		}
		 
		if ($sw_contabilizar=='1')
		{ 		 
			$res = $CustomSCI->TTSIntegracionRendicionCaja($id_caja,'1','1');
				if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $CustomSCI->salida[1];
				$resp->origen = $CustomSCI->salida[2];
				$resp->proc = $CustomSCI->salida[3];
				$resp->nivel = $CustomSCI->salida[4];
				echo $resp->get_mensaje();
				exit;
			}
			break;
		}
		
		if ($id_caja == "undefined" || $id_caja == "")
		{
			////////////////////Inserción/////////////////////
	
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarAperturaCaja("insert",$id_caja,$fecha_inicio,$importe_maximo,$porcentaje_compra,$porcentaje_rinde,$nombre);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tts_caja
			$res = $Custom -> InsertarAperturaCaja($id_caja,$fecha_inicio,$importe_maximo,$porcentaje_compra,$porcentaje_rinde,$nombre);

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
				//echo "pasa que cagada"; exit();
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarAperturaCaja("update",$id_caja,$fecha_inicio,$importe_maximo,$porcentaje_compra,$porcentaje_rinde,$nombre);

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

			$res = $Custom->ModificarAperturaCaja($id_caja,$fecha_inicio,$importe_maximo,$porcentaje_compra,$porcentaje_rinde,$nombre,$nro_vale,$nro_rinde,$nro_recibo);

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
	if($sortcol == "") $sortcol = "id_caja";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarAperturaCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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