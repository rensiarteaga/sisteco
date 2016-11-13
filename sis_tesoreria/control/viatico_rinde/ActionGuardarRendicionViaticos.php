<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarRendicionViaticos.php
Propósito:				Permite insertar y modificar datos en la tabla tts_viatico_rinde
Tabla:					tts_tts_viatico_rinde
Parámetros:				$id_viatico_rinde
						$id_viatico
						$importe_hotel
						$importe_otros
						$tipo_documento
						$nro_documento
						$fecha_documento
						$razon_social
						$nro_nit
						$nro_autorizacion
						$codigo_control

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-11-27 12:11:22
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloTesoreria.php");

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = "ActionGuardarRendicionViaticos.php";

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
			$id_viatico_rinde= $_GET["id_viatico_rinde_$j"];
			$id_viatico=$_GET["id_viatico"];
			$id_concepto_ingas= $_GET["id_concepto_ingas_$j"];
			$importe_rendicion= $_GET["importe_rendicion_$j"];
			$tipo_documento= $_GET["tipo_documento_$j"];
			$nro_documento= $_GET["nro_documento_$j"];
			$fecha_documento= $_GET["fecha_documento_$j"];
			$razon_social= $_GET["razon_social_$j"];
			$nro_nit= $_GET["nro_nit_$j"];
			$nro_autorizacion= $_GET["nro_autorizacion_$j"];
			$codigo_control= $_GET["codigo_control_$j"];
			$id_presupuesto=$_GET["id_presupuesto_$j"];
			
			$id_transaccion= $_GET["id_transaccion_$j"];
			$id_partida_ejecucion= $_GET["id_partida_ejecucion_$j"];
			$estado_rendicion=$_GET["estado_rendicion_$j"];
			$descripcion=$_GET["descripcion_$j"];
		}
		else
		{
			$id_viatico_rinde=$_POST["id_viatico_rinde_$j"];
			$id_viatico=$_POST["id_viatico"];
			$id_concepto_ingas=$_POST["id_concepto_ingas_$j"];
			$importe_rendicion=$_POST["importe_rendicion_$j"];
			$tipo_documento=$_POST["tipo_documento_$j"];
			$nro_documento=$_POST["nro_documento_$j"];
			$fecha_documento=$_POST["fecha_documento_$j"];
			$razon_social=$_POST["razon_social_$j"];
			$nro_nit=$_POST["nro_nit_$j"];
			$nro_autorizacion=$_POST["nro_autorizacion_$j"];
			$codigo_control=$_POST["codigo_control_$j"];
			$id_presupuesto=$_POST["id_presupuesto_$j"];
			
			$id_transaccion= $_POST["id_transaccion_$j"];
			$id_partida_ejecucion= $_POST["id_partida_ejecucion_$j"];
			$estado_rendicion=$_POST["estado_rendicion_$j"];
			$descripcion=$_POST["descripcion_$j"];
		}

		if ($id_viatico_rinde == "undefined" || $id_viatico_rinde == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarRendicionViaticos("insert",$id_viatico_rinde, $id_viatico,$id_concepto_ingas,$importe_rendicion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tts_viatico_rinde
			$res = $Custom -> InsertarRendicionViaticos($id_viatico_rinde, $id_viatico,$id_concepto_ingas,$importe_rendicion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$id_presupuesto,$id_transaccion,$id_partida_ejecucion,$estado_rendicion,$descripcion);

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
			$res = $Custom->ValidarRendicionViaticos("update",$id_viatico_rinde, $id_viatico,$id_concepto_ingas,$importe_rendicion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control);

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

			$res = $Custom->ModificarRendicionViaticos($id_viatico_rinde, $id_viatico,$id_concepto_ingas,$importe_rendicion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$id_presupuesto,$id_transaccion,$id_partida_ejecucion,$estado_rendicion,$descripcion);

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
	if($sortcol == "") $sortcol = "id_viatico_rinde";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "VIATIC.id_viatico=''$id_viatico''";

	$res = $Custom->ContarRendicionViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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