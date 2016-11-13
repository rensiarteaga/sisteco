<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarServicioProveedor.php
Propósito:				Permite insertar y modificar datos en la tabla tad_servicio_proveedor
Tabla:					tad_tad_servicio_proveedor
Parámetros:				$hidden_id_servicio_proveedor
						$txt_precio_ult
						$txt_fecha_ult_mod
						$txt_fecha_reg
						$txt_id_servicio
						$txt_id_moneda
						$txt_id_servicio_propuesto
						$txt_id_proveedor
						$txt_observaciones

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-16 10:05:35
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarServicioProveedor.php";

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
			$hidden_id_servicio_proveedor= $_GET["hidden_id_servicio_proveedor_$j"];
			$txt_precio_ult= $_GET["txt_precio_ult_$j"];
			$txt_fecha_ult_mod= $_GET["txt_fecha_ult_mod_$j"];
			$txt_fecha_reg= $_GET["txt_fecha_reg_$j"];
			$txt_id_servicio= $_GET["id_servicio_$j"];
			$txt_id_moneda= $_GET["txt_id_moneda_$j"];
			$txt_id_servicio_propuesto= $_GET["txt_id_servicio_propuesto_$j"];
			$txt_id_proveedor= $_GET["txt_id_proveedor_$j"];
			$txt_observaciones= $_GET["txt_observaciones_$j"];

		}
		else
		{
			$hidden_id_servicio_proveedor=$_POST["hidden_id_servicio_proveedor_$j"];
			$txt_precio_ult=$_POST["txt_precio_ult_$j"];
			$txt_fecha_ult_mod=$_POST["txt_fecha_ult_mod_$j"];
			$txt_fecha_reg=$_POST["txt_fecha_reg_$j"];
			$txt_id_servicio=$_POST["id_servicio_$j"];
			$txt_id_moneda=$_POST["txt_id_moneda_$j"];
			$txt_id_servicio_propuesto=$_POST["txt_id_servicio_propuesto_$j"];
			$txt_id_proveedor=$_POST["txt_id_proveedor_$j"];
			$txt_observaciones=$_POST["txt_observaciones_$j"];

		}

		if ($hidden_id_servicio_proveedor == "undefined" || $hidden_id_servicio_proveedor == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarServicioProveedor("insert",$hidden_id_servicio_proveedor, $txt_precio_ult,$txt_fecha_ult_mod,$txt_fecha_reg,$txt_id_servicio,$txt_id_moneda,$txt_id_servicio_propuesto,$txt_id_proveedor,$txt_observaciones);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tad_servicio_proveedor
			$res = $Custom -> InsertarServicioProveedor($hidden_id_servicio_proveedor, $txt_precio_ult, $txt_fecha_ult_mod, $txt_fecha_reg, $txt_id_servicio, $txt_id_moneda, $txt_id_servicio_propuesto, $txt_id_proveedor, $txt_observaciones);

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
			$res = $Custom->ValidarServicioProveedor("update",$hidden_id_servicio_proveedor, $txt_precio_ult, $txt_fecha_ult_mod, $txt_fecha_reg, $txt_id_servicio, $txt_id_moneda, $txt_id_servicio_propuesto, $txt_id_proveedor, $txt_observaciones);

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

			$res = $Custom->ModificarServicioProveedor($hidden_id_servicio_proveedor, $txt_precio_ult, $txt_fecha_ult_mod, $txt_fecha_reg, $txt_id_servicio, $txt_id_moneda, $txt_id_servicio_propuesto, $txt_id_proveedor, $txt_observaciones);

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
	if($sortcol == "") $sortcol = "id_servicio_proveedor";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "PROVEE.id_proveedor=''$m_id_proveedor''";

	$res = $Custom->ContarServicioProveedor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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