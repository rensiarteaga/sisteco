<?php
/*
**********************************************************
Nombre de archivo:	    ActionGuardarCuenta.php
Propósito:				Permite insertar y modificar 
Tabla:					tct_cuenta
Parámetros:				$hidden_id_cuenta
$txt_descripcion
$txt_flag_comprobante
$txt_tipo_comprobante

Valores de Retorno:    	Número de registros
Fecha de Creación:		03-10-2007
Versión:				1.0.0
Autor:					José A. Mita Huanca
**********************************************************
*/
session_start();
include_once("../LibModeloCobranza.php");

$Custom = new cls_CustomDBcobranza();
$nombre_archivo = "ActionGuardarConceptoFactura.php";

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
			$id_concepto_factura= $_GET["id_concepto_factura_$j"];
			$nombre_concepto= $_GET["nombre_concepto_$j"];
			$tipo_concepto= $_GET["tipo_concepto_$j"];
			$id_lugar= $_GET["id_lugar_$j"];
			$nombre_lugar= $_GET["nombre_lugar_$j"];
			$id_categoria_cliente= $_GET["id_categoria_cliente_$j"];
			$nombre_categoria_cliente= $_GET["nombre_categoria_cliente_$j"];
			$id_sistema_distribucione= $_GET["id_sistema_distribucion_$j"];
		 
		 }
		else
		{ 
			$id_concepto_factura= $_POST["id_concepto_factura_$j"];
			$nombre_concepto= $_POST["nombre_concepto_$j"];
			$tipo_concepto= $_POST["tipo_concepto_$j"];
			$id_lugar= $_POST["id_lugar_$j"];
			$nombre_lugar= $_POST["nombre_lugar_$j"];
			$id_categoria_cliente= $_POST["id_categoria_cliente_$j"];
			$nombre_categoria_cliente= $_POST["nombre_categoria_cliente_$j"];
			$id_sistema_distribucione= $_POST["id_sistema_distribucion_$j"];
		}
		
		if ($id_concepto_factura == "undefined" || $id_concepto_factura == "")
		{ 
			//Validación satisfactoria, se ejecuta la inserción en la tabla tct_cuenta
			$res = $Custom -> InsertarConceptoFactura($id_concepto_factura,$nombre_concepto,$tipo_concepto,$id_lugar,$nombre_lugar,$id_categoria_cliente,$nombre_categoria_cliente,$id_sistema_distribucione);

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
			$res = $Custom->ModificarConceptoFactura($id_concepto_factura,$nombre_concepto,$tipo_concepto,$id_lugar,$nombre_lugar,$id_categoria_cliente,$nombre_categoria_cliente,$id_sistema_distribucione);

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
	if($sortcol == "") $sortcol = "id_actualizacion";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarConceptoFactura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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