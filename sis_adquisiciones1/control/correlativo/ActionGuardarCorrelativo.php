<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCorrelativo.php
Propósito:				Permite insertar y modificar datos en la tabla tad_correlativo
Tabla:					tad_tad_correlativo
Parámetros:				$hidden_id_correlativo
						$txt_valor_actual
						$txt_valor_siguiente
						$txt_incremento
						$txt_id_parametro_adquisicion
						$txt_id_documento
						$txt_prefijo
						$txt_sufijo
						$txt_id_fina_regi_prog_proy_acti

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-09 10:34:38
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarCorrelativo.php";

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
			$hidden_id_correlativo= $_GET["hidden_id_correlativo_$j"];
			$txt_valor_actual= $_GET["txt_valor_actual_$j"];
			$txt_valor_siguiente= $_GET["txt_valor_siguiente_$j"];
			$txt_incremento= $_GET["txt_incremento_$j"];
			$txt_id_parametro_adquisicion= $_GET["txt_id_parametro_adquisicion_$j"];
			$txt_id_documento= $_GET["txt_id_documento_$j"];
			$txt_prefijo= $_GET["txt_prefijo_$j"];
			$txt_sufijo= $_GET["txt_sufijo_$j"];
$txt_id_financiador= $_GET["txt_id_financiador_$j"];
			$txt_id_regional	= $_GET["txt_id_regional_$j"];
			$txt_id_programa	= $_GET["txt_id_programa_$j"];
			$txt_id_proyecto	= $_GET["txt_id_proyecto_$j"];
			$txt_id_actividad	= $_GET["txt_id_actividad_$j"];
		}
		else
		{
			$hidden_id_correlativo=$_POST["hidden_id_correlativo_$j"];
			$txt_valor_actual=$_POST["txt_valor_actual_$j"];
			$txt_valor_siguiente=$_POST["txt_valor_siguiente_$j"];
			$txt_incremento=$_POST["txt_incremento_$j"];
			$txt_id_parametro_adquisicion=$_POST["txt_id_parametro_adquisicion_$j"];
			$txt_id_documento=$_POST["txt_id_documento_$j"];
			$txt_prefijo=$_POST["txt_prefijo_$j"];
			$txt_sufijo=$_POST["txt_sufijo_$j"];
$txt_id_financiador= $_POST["txt_id_financiador_$j"];
			$txt_id_regional	= $_POST["txt_id_regional_$j"];
			$txt_id_programa	= $_POST["txt_id_programa_$j"];
			$txt_id_proyecto	= $_POST["txt_id_proyecto_$j"];
			$txt_id_actividad	= $_POST["txt_id_actividad_$j"];
		}

		if ($hidden_id_correlativo == "undefined" || $hidden_id_correlativo == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarCorrelativo("insert",$hidden_id_correlativo, $txt_valor_actual,$txt_valor_siguiente,$txt_incremento,$txt_id_parametro_adquisicion,$txt_id_documento,$txt_prefijo,$txt_sufijo,$txt_id_financiador,$txt_id_regional,$txt_id_programa,$txt_id_proyecto,$txt_id_actividad);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tad_correlativo
			$res = $Custom -> InsertarCorrelativo($hidden_id_correlativo, $txt_valor_actual, $txt_valor_siguiente, $txt_incremento, $txt_id_parametro_adquisicion, $txt_id_documento, $txt_prefijo, $txt_sufijo, $txt_id_financiador,$txt_id_regional,$txt_id_programa,$txt_id_proyecto,$txt_id_actividad);

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
			$res = $Custom->ValidarCorrelativo("update",$hidden_id_correlativo, $txt_valor_actual, $txt_valor_siguiente, $txt_incremento, $txt_id_parametro_adquisicion, $txt_id_documento, $txt_prefijo, $txt_sufijo, $txt_id_financiador,$txt_id_regional,$txt_id_programa,$txt_id_proyecto,$txt_id_actividad);

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

			$res = $Custom->ModificarCorrelativo($hidden_id_correlativo, $txt_valor_actual, $txt_valor_siguiente, $txt_incremento, $txt_id_parametro_adquisicion, $txt_id_documento, $txt_prefijo, $txt_sufijo, $txt_id_financiador,$txt_id_regional,$txt_id_programa,$txt_id_proyecto,$txt_id_actividad);

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
	if($sortcol == "") $sortcol = "id_correlativo";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "PARADQ.id_parametro_adquisicion=''$m_id_parametro_adquisicion''";

	$res = $Custom->ContarCorrelativo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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