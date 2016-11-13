<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarDocumento.php
Propósito:				Permite insertar y modificar datos en la tabla tpm_documento
Tabla:					tpm_tpm_documento
Parámetros:				$id_documento
						$codigo
						$descripcion
						$documento
						$prefijo
						$sufijo
						$estado
						$id_subsistema

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-07-29 09:44:13
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloParametros.php");

$Custom = new cls_CustomDBParametros();
$nombre_archivo = "ActionGuardarDocumento.php";

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
			$id_documento= $_GET["id_documento_$j"];
			$codigo= $_GET["codigo_$j"];
			$descripcion= $_GET["descripcion_$j"];
			$documento= $_GET["documento_$j"];
			$prefijo= $_GET["prefijo_$j"];
			$sufijo= $_GET["sufijo_$j"];
			$estado= $_GET["estado_$j"];
			$id_subsistema= $_GET["id_subsistema_$j"];
			$num_firma= $_GET["num_firma_$j"];
			//MODIFICACION 23:03:2011 aayaviri
			$tipo_numeracion=$_GET["tipo_numeracion_$j"];//adicionado en fecha 31-12-2010 15:03
			$id_tipo_proceso=$_GET["id_tipo_proceso_$j"];//
			$tipo=$_GET["tipo_$j"];
			//--------------------------------
		}
		else
		{
			$id_documento=$_POST["id_documento_$j"];
			$codigo=$_POST["codigo_$j"];
			$descripcion=$_POST["descripcion_$j"];
			$documento=$_POST["documento_$j"];
			$prefijo=$_POST["prefijo_$j"];
			$sufijo=$_POST["sufijo_$j"];
			$estado=$_POST["estado_$j"];
			$id_subsistema=$_POST["id_subsistema_$j"];
			$num_firma= $_POST["num_firma_$j"];
			//MODIFICACION 23:03:2011 aayaviri
			$tipo_numeracion=$_POST["tipo_numeracion_$j"];//adicionado en fecha 31-12-2010 15:03
			$id_tipo_proceso=$_POST["id_tipo_proceso_$j"];//
			$tipo=$_POST["tipo_$j"];
			//-------------------------------
		}

		if ($id_documento == "undefined" || $id_documento == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarDocumento("insert",$id_documento,$codigo,$descripcion,$documento,$prefijo,$sufijo,$estado,$id_subsistema, $num_firma);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpm_documento
			$res = $Custom -> InsertarDocumento($id_documento,$codigo,$descripcion,$documento,$prefijo,$sufijo,$estado,$id_subsistema,$num_firma,$tipo_numeracion,$id_tipo_proceso,$tipo);

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
			$res = $Custom->ValidarDocumento("update",$id_documento,$codigo,$descripcion,$documento,$prefijo,$sufijo,$estado,$id_subsistema,$num_firma);

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

			$res = $Custom->ModificarDocumento($id_documento,$codigo,$descripcion,$documento,$prefijo,$sufijo,$estado,$id_subsistema,$num_firma,$tipo_numeracion,$id_tipo_proceso,$tipo);

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
	if($sortcol == "") $sortcol = "id_documento";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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