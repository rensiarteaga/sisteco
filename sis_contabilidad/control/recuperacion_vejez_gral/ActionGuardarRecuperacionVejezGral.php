<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarRecuperacionVejezGral.php
Propósito:				Permite insertar y modificar datos en la tabla tfv_archivo_control
Tabla:					tfv_tfv_archivo_control

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2011-05-23 11:23
Versión:				1.0.0
Autor:					José Mita
**********************************************************
*/
session_start();
include_once("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = "ActionGuardarRecuperacionVejezGral.php";

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
			$id_archivo_control= $_GET["id_archivo_control_$j"];
			$anio_per_fiscal= $_GET["anio_per_fiscal_$j"];
			$cantidad_valor_solicitado= $_GET["cantidad_valor_solicitado_$j"];
			$codigo_form= $_GET["codigo_form_$j"];
			$fecha_envio= $_GET["fecha_envio_$j"];
			$mes_per_fiscal= $_GET["mes_per_fiscal_$j"];
			$numero_orden= $_GET["numero_orden_$j"];
			$nro_factura=$_GET["nro_factura_$j"];
			$nro_autoriza=$_GET["nro_autoriza_$j"];
			$cod_control=$_GET["cod_control_$j"];
			$fecha_emision=$_GET["fecha_emision_$j"];
		}
		else
		{
			
			$id_archivo_control= $_POST["id_archivo_control_$j"];
			$anio_per_fiscal= $_POST["anio_per_fiscal_$j"];
			$cantidad_valor_solicitado= $_POST["cantidad_valor_solicitado_$j"];
			$codigo_form= $_POST["codigo_form_$j"];
			$fecha_envio= $_POST["fecha_envio_$j"];
			$mes_per_fiscal= $_POST["mes_per_fiscal_$j"];
			$numero_orden= $_POST["numero_orden_$j"];
			$nro_factura=$_POST["nro_factura_$j"];
			$nro_autoriza=$_POST["nro_autoriza_$j"];
			$cod_control=$_POST["cod_control_$j"];
			$fecha_emision=$_POST["fecha_emision_$j"];
		}

		if ($id_archivo_control == "undefined" || $id_archivo_control == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarRecuperacionVejez("insert",$id_archivo_control,$anio_per_fiscal,$cantidad_valor_solicitado,$codigo_form,$fecha_envio,$mes_per_fiscal,$numero_orden,$nro_factura,$nro_autoriza,$cod_control,$fecha_emision);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tfv_reclamo
			$res = $Custom -> InsertarRecuperacionVejez($id_archivo_control,$anio_per_fiscal,$cantidad_valor_solicitado,$codigo_form,$fecha_envio,$mes_per_fiscal,$numero_orden,$nro_factura,$nro_autoriza,$cod_control,$fecha_emision);

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
			$res = $Custom->ValidarRecuperacionVejez("update",$id_archivo_control,$anio_per_fiscal,$cantidad_valor_solicitado,$codigo_form,$fecha_envio,$mes_per_fiscal,$numero_orden,$nro_factura,$nro_autoriza,$cod_control,$fecha_emision);

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

			$res = $Custom->ModificarRecuperacionVejez($id_archivo_control,$anio_per_fiscal,$cantidad_valor_solicitado,$codigo_form,$fecha_envio,$mes_per_fiscal,$numero_orden,$nro_factura,$nro_autoriza,$cod_control,$fecha_emision);

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
	if($sortcol == "") $sortcol = "id_archivo_control";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarRecuperacionVejez($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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