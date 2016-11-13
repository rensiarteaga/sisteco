<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarDetalleViatico.php
Prop�sito:				Permite insertar y modificar datos en la tabla tts_cuenta_doc_det
Tabla:					tts_tts_cuenta_doc_det
Par�metros:				$id_concepto_ingas
						$id_presupuesto
						$cantidad
						$tipo_transporte
						$importe
						$id_tipo_destino
						$id_cobertura

Valores de Retorno:    	N�mero de registros guardados
Fecha de Creaci�n:		2009-10-27 10:40:43
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloTesoreria.php");

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = "ActionGuardarDetalleViatico.php";

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
			$id_cuenta_doc_det=$_GET["id_cuenta_doc_det_$j"];
			$id_cuenta_doc=$_GET["id_cuenta_doc_$j"];
			$id_concepto_ingas= $_GET["id_concepto_ingas_$j"];
			$id_presupuesto= $_GET["id_presupuesto_$j"];
			$cantidad= $_GET["cantidad_$j"];
			$tipo_transporte= $_GET["tipo_transporte_$j"];
			$importe= $_GET["importe_$j"];
			$id_tipo_destino= $_GET["id_tipo_destino_$j"];
			$id_cobertura= $_GET["id_cobertura_$j"];
			$observaciones= $_GET["observaciones_$j"];
			$id_cuenta_doc_rendicion=$_GET["id_cuenta_doc_rendicion_$j"];
			$id_orden_trabajo=$_GET["id_orden_trabajo_$j"];
            $id_solicitud=$_GET["id_solicitud_$j"];
            $entrega_importe=$_GET["entrega_importe_$j"];
            $id_categoria=$_GET["id_categoria_$j"];
            $fecha_ini=$_GET["fecha_ini_$j"];
            $fecha_fin=$_GET["fecha_fin_$j"];
		}
		else
		{
			$id_cuenta_doc_det=$_POST["id_cuenta_doc_det_$j"];
			$id_cuenta_doc=$_POST["id_cuenta_doc_$j"];
			$id_concepto_ingas=$_POST["id_concepto_ingas_$j"];
			$id_presupuesto=$_POST["id_presupuesto_$j"];
			$cantidad=$_POST["cantidad_$j"];
			$tipo_transporte=$_POST["tipo_transporte_$j"];
			$importe=$_POST["importe_$j"];
			$id_tipo_destino=$_POST["id_tipo_destino_$j"];
			$id_cobertura=$_POST["id_cobertura_$j"];
			$observaciones= $_POST["observaciones_$j"];
			$id_cuenta_doc_rendicion=$_POST["id_cuenta_doc_rendicion_$j"];
			$id_orden_trabajo=$_POST["id_orden_trabajo_$j"];
            $id_solicitud=$_POST["id_solicitud_$j"];
            $entrega_importe=$_POST["entrega_importe_$j"];
            $id_categoria=$_POST["id_categoria_$j"];
            $fecha_ini=$_POST["fecha_ini_$j"];
            $fecha_fin=$_POST["fecha_fin_$j"];
		}
		
		if ($id_cuenta_doc_det == "undefined" || $id_cuenta_doc_det == "")
		{
			////////////////////Inserci�n/////////////////////

			//Validaci�n de datos (del lado del servidor)
			$res = $Custom->ValidarDetalleViatico("insert",$id_cuenta_doc_det,$id_cuenta_doc,$cantidad,$tipo_transporte,$importe,$id_tipo_destino,$id_cobertura,$id_concepto_ingas, $id_presupuesto);

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

			//Validaci�n satisfactoria, se ejecuta la inserci�n en la tabla tts_cuenta_doc_det
			$res = $Custom -> InsertarDetalleViatico($id_cuenta_doc,$cantidad,$tipo_transporte,$importe,$id_tipo_destino,$id_cobertura,$id_concepto_ingas, $id_presupuesto,$observaciones,$id_cuenta_doc_rendicion,$id_orden_trabajo,$id_solicitud,$entrega_importe,$id_categoria,$fecha_ini,$fecha_fin);

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
			$res = $Custom->ValidarDetalleViatico("update",$id_cuenta_doc_det,$id_cuenta_doc,$cantidad,$tipo_transporte,$importe,$id_tipo_destino,$id_cobertura,$id_concepto_ingas, $id_presupuesto);

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

			$res = $Custom->ModificarDetalleViatico($id_cuenta_doc_det,$id_cuenta_doc,$cantidad,$tipo_transporte,$importe,$id_tipo_destino,$id_cobertura,$id_concepto_ingas,$id_presupuesto,$observaciones,$id_cuenta_doc_rendicion,$id_orden_trabajo,$id_solicitud,$entrega_importe,$id_categoria,$fecha_ini,$fecha_fin);

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
	if($sortcol == "") $sortcol = "id_cuenta_doc_det";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "CUDOC.id_cuenta_doc=''$id_cuenta_doc''";
	if($m_id_cuenta_doc_rendicion!=''){
		$criterio_filtro = "CUEREN.id_cuenta_doc_rendicion=''$m_id_cuenta_doc_rendicion''";
	}

	$res = $Custom->ContarDetalleViatico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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