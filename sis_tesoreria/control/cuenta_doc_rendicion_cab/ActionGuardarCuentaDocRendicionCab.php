<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCuentaDocRendicionCab.php
Propósito:				Permite insertar y modificar datos en la tabla tts_cuenta_doc
Tabla:					tts_tts_cuenta_doc
Parámetros:				$id_cuenta_doc
						$fecha_ini
						$fecha_fin
						$nro_documento
						$fk_id_cuenta_doc

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2009-10-27 19:06:46
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloTesoreria.php");

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = "ActionGuardarCuentaDocRendicionCab.php";

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
			$id_cuenta_doc= $_GET["id_cuenta_doc_$j"];
			$fecha_ini= $_GET["fecha_ini_$j"];
			$fecha_fin= $_GET["fecha_fin_$j"];
			$observaciones= $_GET["observaciones_$j"];
			$fecha_sol=$_GET["fecha_sol_$j"];
			$id_autorizacion=$_GET["id_autorizacion_$j"];
			$tipo_contrato=$_GET["tipo_contrato_$j"];
		}
		else
		{
			$id_cuenta_doc=$_POST["id_cuenta_doc_$j"];
			$fecha_ini=$_POST["fecha_ini_$j"];
			$fecha_fin=$_POST["fecha_fin_$j"];
			$observaciones= $_POST["observaciones_$j"];
			$fecha_sol=$_POST["fecha_sol_$j"];
			$id_autorizacion=$_POST["id_autorizacion_$j"];
			$tipo_contrato=$_POST["tipo_contrato_$j"];
		}
		
		if ($id_cuenta_doc == "undefined" || $id_cuenta_doc == "")
		{//if($_SESSION["ss_id_usuario"]==120){ echo "insert"; exit;}
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarCuentaDocRendicionCab("insert",$id_cuenta_doc, $fecha_ini,$fecha_fin,$nro_documento,$fk_id_cuenta_doc);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tts_cuenta_doc
			$tipo_cuenta_doc='rendicion_viatico';
			$res = $Custom -> InsertarCuentaDocRendicionCab($fecha_ini,$fecha_fin,$observaciones,$fk_id_cuenta_doc,$tipo_cuenta_doc,$fecha_sol,$tipo_contrato);

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
			//if($_SESSION["ss_id_usuario"]==120){ echo "update"; exit;}
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarCuentaDocRendicionCab("update",$id_cuenta_doc, $fecha_ini,$fecha_fin,$nro_documento,$fk_id_cuenta_doc);

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
			
			$res = $Custom->ModificarCuentaDocRendicionCab($id_cuenta_doc,$fecha_ini,$fecha_fin,$observaciones,$fk_id_cuenta_doc,$fecha_sol,$id_autorizacion,$tipo_contrato);

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
	if($sortcol == "") $sortcol = "id_cuenta_doc";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "CUDOC.id_cuenta_doc=''$fk_id_cuenta_doc''";

	$res = $Custom->ContarCuentaDocRendicionCab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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