<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarRegistroDocumento.php
Propósito:				Permite insertar y modificar datos en la tabla tct_documento
Tabla:					tct_tct_documento
Parámetros:				$id_documento
						$id_transaccion
						$tipo_documento
						$nro_documento
						$fecha_documento
						$razon_social
						$nro_nit
						$nro_autorizacion
						$codigo_control
						$poliza_dui
						$formulario
						$tipo_retencion

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-09-16 17:57:13
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = "ActionGuardarRegistroDocumento.php";

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
			$id_transaccion= $_GET["id_transaccion_$j"];
			$tipo_documento= $_GET["tipo_documento_$j"];
			$nro_documento= $_GET["nro_documento_$j"];
			$fecha_documento= $_GET["fecha_documento_$j"];
			$razon_social= $_GET["razon_social_$j"];
			$nro_nit= $_GET["nro_nit_$j"];
			$nro_autorizacion= $_GET["nro_autorizacion_$j"];
			$codigo_control= $_GET["codigo_control_$j"];
			$poliza_dui= $_GET["poliza_dui_$j"];
			$formulario= $_GET["formulario_$j"];
			$tipo_retencion= $_GET["tipo_retencion_$j"];
			
			$id_moneda= $_GET["id_moneda_$j"];
			$importe_credito= $_GET["importe_credito_$j"];
			$importe_debito= $_GET["importe_debito_$j"];
			$importe_ice= $_GET["importe_ice_$j"];
			$importe_it= $_GET["importe_it_$j"];
			$importe_it= $_GET["importe_it_$j"];
			$importe_iue= $_GET["importe_iue_$j"];
			$importe_sujeto= $_GET["importe_sujeto_$j"];
			$importe_total= $_GET["importe_total_$j"];
			$importe_no_gravado= $_GET["importe_no_gravado_$j"];
			
			
			
			
			
			
			
			
		 
			
			
			if($m_sw_documento=="si"  )
			{
				$id_transaccion= $_GET["id_transaccion"];
				//$tipo_documento= $_GET["tipo_documento"];
			}
			
			

		}
		else
		{
			$id_documento=$_POST["id_documento_$j"];
			$id_transaccion=$_POST["id_transaccion_$j"];
			$tipo_documento=$_POST["tipo_documento_$j"];
			$nro_documento=$_POST["nro_documento_$j"];
			$fecha_documento=$_POST["fecha_documento_$j"];
			$razon_social=$_POST["razon_social_$j"];
			$nro_nit=$_POST["nro_nit_$j"];
			$nro_autorizacion=$_POST["nro_autorizacion_$j"];
			$codigo_control=$_POST["codigo_control_$j"];
			$poliza_dui=$_POST["poliza_dui_$j"];
			$formulario=$_POST["formulario_$j"];
			$tipo_retencion=$_POST["tipo_retencion_$j"];
			$id_moneda= $_POST["id_moneda_$j"];
			$importe_credito= $_POST["importe_credito_$j"];
			$importe_debito= $_POST["importe_debito_$j"];
			$importe_ice= $_POST["importe_ice_$j"];
			$importe_it= $_POST["importe_it_$j"];
			$importe_it= $_POST["importe_it_$j"];
			$importe_iue= $_POST["importe_iue_$j"];
			$importe_sujeto= $_POST["importe_sujeto_$j"];
			$importe_total= $_POST["importe_total_$j"];
			$importe_no_gravado= $_POST["importe_no_gravado_$j"];
			
			
			
			
			
			
			
			if($m_sw_documento=="si")
			{
				$id_transaccion= $_POST["id_transaccion"];
				//$tipo_documento= $_POST["tipo_documento"];
			}
		}
		if($id_documento==0){$id_documento="";}
		if ($id_documento == "undefined" || $id_documento == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarRegistroDocumento("insert",$id_documento, $id_transaccion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tct_documento
			$res = $Custom -> InsertarRegistroDocumento($id_documento,$id_transaccion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion,$id_moneda,$importe_credito,$importe_debito,$importe_ice,$importe_it,$importe_iue,$importe_sujeto,$importe_total,$importe_no_gravado);

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
			$res = $Custom->ValidarRegistroDocumento("update",$id_documento, $id_transaccion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion);

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

			$res = $Custom->ModificarRegistroDocumento($id_documento,$id_transaccion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion,$id_moneda,$importe_credito,$importe_debito,$importe_ice,$importe_it,$importe_iue,$importe_sujeto,$importe_total,$importe_no_gravado);

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
	if($criterio_filtro == "") $criterio_filtro = "TRANSC.id_transaccion=''$m_id_transaccion''";
if($m_sw_documento=="si")
			{
				$criterio_filtro ="TRANSC.id_transaccion=".$id_transaccion." ";
			}
	$res = $Custom->ContarRegistroDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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