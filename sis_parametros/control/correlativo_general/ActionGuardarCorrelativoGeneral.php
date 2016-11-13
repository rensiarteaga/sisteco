<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCorrelativoGeneral.php
Propósito:				Permite insertar y modificar datos en la tabla tpm_correlativo_general
Tabla:					tpm_tpm_correlativo_general
Parámetros:				$id_correlativo_general
						$nro_doc_siguiente
						$nro_doc_actual
						$id_documento
						$id_empresa
						$id_periodo

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-09-08 09:53:41
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloParametros.php");

$Custom = new cls_CustomDBParametros();
$nombre_archivo = "ActionGuardarCorrelativoGeneral.php";

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
			$id_correlativo_general= $_GET["id_correlativo_general_$j"];
			$nro_doc_siguiente= $_GET["nro_doc_siguiente_$j"];
			$nro_doc_actual= $_GET["nro_doc_actual_$j"];
			$id_documento= $_GET["id_documento_$j"];
			$id_empresa= $_GET["id_empresa_$j"];
			$id_periodo= $_GET["id_periodo_$j"];

		}
		else
		{
			$id_correlativo_general=$_POST["id_correlativo_general_$j"];
			$nro_doc_siguiente=$_POST["nro_doc_siguiente_$j"];
			$nro_doc_actual=$_POST["nro_doc_actual_$j"];
			$id_documento=$_POST["id_documento_$j"];
			$id_empresa=$_POST["id_empresa_$j"];
			$id_periodo=$_POST["id_periodo_$j"];

		}

		if ($id_correlativo_general == "undefined" || $id_correlativo_general == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarCorrelativoGeneral("insert",$id_correlativo_general, $nro_doc_siguiente,$nro_doc_actual,$id_documento,$id_empresa,$id_periodo);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpm_correlativo_general
			$res = $Custom -> InsertarCorrelativoGeneral($id_correlativo_general, $nro_doc_siguiente,$nro_doc_actual,$id_documento,$id_empresa,$id_periodo);

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
			$res = $Custom->ValidarCorrelativoGeneral("update",$id_correlativo_general, $nro_doc_siguiente,$nro_doc_actual,$id_documento,$id_empresa,$id_periodo);

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

			$res = $Custom->ModificarCorrelativoGeneral($id_correlativo_general, $nro_doc_siguiente,$nro_doc_actual,$id_documento,$id_empresa,$id_periodo);

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
	if($sortcol == "") $sortcol = "id_correlativo_general";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "DOCUME.id_documento=''$m_id_documento''";

	$res = $Custom->ContarCorrelativoGeneral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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