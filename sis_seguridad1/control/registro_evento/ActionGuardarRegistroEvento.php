<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarRegistroEvento.php
Prop�sito:				Permite insertar y modificar datos en la tabla tsg_registro_evento
Tabla:					tsg_tsg_registro_evento
Par�metros:				$hidden_id_registro_eventos
						$txt_id_usuario
						$txt_id_subsistema
						$txt_id_lugar
						$txt_fecha
						$txt_hora
						$txt_numero_error
						$txt_descripcion
						$txt_ip_origen
						$txt_log_error
						$txt_codigo_procedimiento
						$txt_proc_almacenado
						$txt_mac_maquina

Valores de Retorno:    	N�mero de registros guardados
Fecha de Creaci�n:		2007-10-26 16:05:03
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloSeguridad.php");

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = "ActionGuardarRegistroEvento.php";

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
			$hidden_id_registro_eventos= $_GET["hidden_id_registro_eventos_$j"];
			$txt_id_usuario= $_GET["txt_id_usuario_$j"];
			$txt_id_subsistema= $_GET["txt_id_subsistema_$j"];
			$txt_id_lugar= $_GET["txt_id_lugar_$j"];
			$txt_fecha= $_GET["txt_fecha_$j"];
			$txt_hora= $_GET["txt_hora_$j"];
			$txt_numero_error= $_GET["txt_numero_error_$j"];
			$txt_descripcion= $_GET["txt_descripcion_$j"];
			$txt_ip_origen= $_GET["txt_ip_origen_$j"];
			$txt_log_error= $_GET["txt_log_error_$j"];
			$txt_codigo_procedimiento= $_GET["txt_codigo_procedimiento_$j"];
			$txt_proc_almacenado= $_GET["txt_proc_almacenado_$j"];
			$txt_mac_maquina= $_GET["txt_mac_maquina_$j"];

		}
		else
		{
			$hidden_id_registro_eventos=$_POST["hidden_id_registro_eventos_$j"];
			$txt_id_usuario=$_POST["txt_id_usuario_$j"];
			$txt_id_subsistema=$_POST["txt_id_subsistema_$j"];
			$txt_id_lugar=$_POST["txt_id_lugar_$j"];
			$txt_fecha=$_POST["txt_fecha_$j"];
			$txt_hora=$_POST["txt_hora_$j"];
			$txt_numero_error=$_POST["txt_numero_error_$j"];
			$txt_descripcion=$_POST["txt_descripcion_$j"];
			$txt_ip_origen=$_POST["txt_ip_origen_$j"];
			$txt_log_error=$_POST["txt_log_error_$j"];
			$txt_codigo_procedimiento=$_POST["txt_codigo_procedimiento_$j"];
			$txt_proc_almacenado=$_POST["txt_proc_almacenado_$j"];
			$txt_mac_maquina=$_POST["txt_mac_maquina_$j"];

		}

		if ($hidden_id_registro_eventos == "undefined" || $hidden_id_registro_eventos == "")
		{
			////////////////////Inserci�n/////////////////////

			//Validaci�n de datos (del lado del servidor)
			$res = $Custom->ValidarRegistroEvento("insert",$hidden_id_registro_eventos, $txt_id_usuario,$txt_id_subsistema,$txt_id_lugar,$txt_fecha,$txt_hora,$txt_numero_error,$txt_descripcion,$txt_ip_origen,$txt_log_error,$txt_codigo_procedimiento,$txt_proc_almacenado,$txt_mac_maquina);

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

			//Validaci�n satisfactoria, se ejecuta la inserci�n en la tabla tsg_registro_evento
			$res = $Custom -> InsertarRegistroEvento($hidden_id_registro_eventos, $txt_id_usuario, $txt_id_subsistema, $txt_id_lugar, $txt_fecha, $txt_hora, $txt_numero_error, $txt_descripcion, $txt_ip_origen, $txt_log_error, $txt_codigo_procedimiento, $txt_proc_almacenado, $txt_mac_maquina);

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
			$res = $Custom->ValidarRegistroEvento("update",$hidden_id_registro_eventos, $txt_id_usuario, $txt_id_subsistema, $txt_id_lugar, $txt_fecha, $txt_hora, $txt_numero_error, $txt_descripcion, $txt_ip_origen, $txt_log_error, $txt_codigo_procedimiento, $txt_proc_almacenado, $txt_mac_maquina);

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

			$res = $Custom->ModificarRegistroEvento($hidden_id_registro_eventos, $txt_id_usuario, $txt_id_subsistema, $txt_id_lugar, $txt_fecha, $txt_hora, $txt_numero_error, $txt_descripcion, $txt_ip_origen, $txt_log_error, $txt_codigo_procedimiento, $txt_proc_almacenado, $txt_mac_maquina);

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
	if($sortcol == "") $sortcol = "id_registro_eventos";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarRegistroEvento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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