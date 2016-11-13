<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCbteClase.php
Propósito:				Permite insertar y modificar datos en la tabla tct_cbte_clase
Tabla:					tct_tct_cbte_clase
Parámetros:				$id_clase_cbte
						$desc_clase
						$estado_clase
						$id_documento

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-09-18 09:21:11
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = "ActionGuardarChequeRegTra.php";

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
				$id_cheque = $_GET["id_cheque_$j"];
				$id_transaccion = $_GET["id_transaccion_$j"];
				$id_moneda = $_GET["id_moneda_$j"];
				$importe_cheque = $_GET["importe_cheque_$j"];
				$nro_cheque = $_GET["nro_cheque_$j"];
				$nro_deposito = $_GET["nro_deposito_$j"];
				$nro_transaccion = $_GET["nro_transaccion_$j"];
				$fecha_cheque = $_GET["fecha_cheque_$j"];
				$nombre_cheque = $_GET["nombre_cheque_$j"];
				$id_cuenta_bancaria = $_GET["id_cuenta_bancaria_$j"];
				$tipo_cheque = $_GET["tipo_cheque_$j"];
				$tipo_cambio = $_GET["tipo_cambio_$j"];
				$estado_cheque = $_GET["estado_cheque_$j"];
				


		}
		else
		{
				$id_cheque = $_POST["id_cheque_$j"];
				$id_transaccion = $_POST["id_transaccion_$j"];
				$id_moneda = $_POST["id_moneda_$j"];
				$importe_cheque = $_POST["importe_cheque_$j"];
				$nro_cheque = $_POST["nro_cheque_$j"];
				$nro_deposito = $_POST["nro_deposito_$j"];
				$nro_transaccion = $_POST["nro_transaccion_$j"];
				$fecha_cheque = $_POST["fecha_cheque_$j"];
				$nombre_cheque = $_POST["nombre_cheque_$j"];
				$id_cuenta_bancaria = $_POST["id_cuenta_bancaria_$j"];
				$tipo_cheque = $_POST["tipo_cheque_$j"];
				$tipo_cambio = $_POST["tipo_cambio_$j"];
				$estado_cheque = $_POST["estado_cheque_$j"];
				

	
		}

		if ($id_cheque == "undefined" || $id_cheque == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarChequeRegTra("insert",$id_cheque,$id_transaccion,$nro_cheque,$nro_deposito,$fecha_cheque,$nombre_cheque,$id_cuenta_bancaria);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tct_cbte_clase
			$res = $Custom -> InsertarChequeRegTra(	$id_cheque,$id_transaccion,$nro_cheque,$nro_deposito,$fecha_cheque,$nombre_cheque,$id_cuenta_bancaria,$tipo_cheque,$id_moneda,$importe_cheque,$tipo_cambio,$nro_transaccion);

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
			$res = $Custom->ValidarChequeRegTra("update",$id_cheque,$id_transaccion,$nro_cheque,$nro_deposito,$fecha_cheque,$nombre_cheque,$id_cuenta_bancaria);

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

			$res = $Custom->ModificarChequeRegTra($id_cheque,$id_transaccion,$nro_cheque,$nro_deposito,$fecha_cheque,$nombre_cheque,$id_cuenta_bancaria,$tipo_cheque,$id_moneda,$importe_cheque,$tipo_cambio,$nro_transaccion,$estado_cheque);

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
	if($sortcol == "") $sortcol = "id_cheque";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarCheque($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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