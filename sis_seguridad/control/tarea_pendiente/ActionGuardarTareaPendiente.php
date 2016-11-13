<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarTareaPendiente.php
Propósito:				Permite insertar y modificar datos en la tabla tsg_tarea_pendiente
Tabla:					tsg_tsg_tarea_pendiente
Parámetros:				$hidden_id_tarea_pendiente
						$txt_id_usuario
						$txt_id_subsistema
						$txt_tarea
						$txt_descripcion
						$txt_enlace
						$txt_estado
						$txt_fecha_concluido_anulado
						$txt_fecha_reg

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-10-30 11:27:01
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloSeguridad.php");

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = "ActionGuardarTareaPendiente.php";

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
			$hidden_id_tarea_pendiente= $_GET["hidden_id_tarea_pendiente_$j"];
			$txt_id_usuario= $_GET["txt_id_usuario_$j"];
			$txt_id_subsistema= $_GET["txt_id_subsistema_$j"];
			$txt_tarea= $_GET["txt_tarea_$j"];
			$txt_descripcion= $_GET["txt_descripcion_$j"];
			$txt_codigo_procedimiento= $_GET["txt_codigo_procedimiento_$j"];
			$txt_estado= $_GET["txt_estado_$j"];
			$txt_fecha_concluido_anulado= $_GET["txt_fecha_concluido_anulado_$j"];
			$txt_fecha_reg= $_GET["txt_fecha_reg_$j"];
			$txt_tipo= $_GET["txt_tipo_$j"];

		}
		else
		{
			$hidden_id_tarea_pendiente=$_POST["hidden_id_tarea_pendiente_$j"];
			$txt_id_usuario=$_POST["txt_id_usuario_$j"];
			$txt_id_subsistema=$_POST["txt_id_subsistema_$j"];
			$txt_tarea=$_POST["txt_tarea_$j"];
			$txt_descripcion=$_POST["txt_descripcion_$j"];
			$txt_codigo_procedimiento=$_POST["txt_codigo_procedimiento_$j"];
			$txt_estado=$_POST["txt_estado_$j"];
			$txt_fecha_concluido_anulado=$_POST["txt_fecha_concluido_anulado_$j"];
			$txt_fecha_reg=$_POST["txt_fecha_reg_$j"];
			$txt_tipo= $_POST["txt_tipo_$j"];

		}

		if ($hidden_id_tarea_pendiente == "undefined" || $hidden_id_tarea_pendiente == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarTareaPendiente("insert",$hidden_id_tarea_pendiente, $txt_id_usuario,$txt_id_subsistema,$txt_tarea,$txt_descripcion,$txt_codigo_procedimiento,$txt_estado,$txt_fecha_concluido_anulado,$txt_fecha_reg,$txt_tipo);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tsg_tarea_pendiente
			$res = $Custom -> InsertarTareaPendiente($hidden_id_tarea_pendiente, $txt_id_usuario, $txt_id_subsistema, $txt_tarea, $txt_descripcion, $txt_codigo_procedimiento, $txt_estado, $txt_fecha_concluido_anulado, $txt_fecha_reg,$txt_tipo);

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
			$res = $Custom->ValidarTareaPendiente("update",$hidden_id_tarea_pendiente, $txt_id_usuario, $txt_id_subsistema, $txt_tarea, $txt_descripcion, $txt_codigo_procedimiento, $txt_estado, $txt_fecha_concluido_anulado, $txt_fecha_reg,$txt_tipo);

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

			$res = $Custom->ModificarTareaPendiente($hidden_id_tarea_pendiente, $txt_id_usuario, $txt_id_subsistema, $txt_tarea, $txt_descripcion, $txt_codigo_procedimiento, $txt_estado, $txt_fecha_concluido_anulado, $txt_fecha_reg, $txt_tipo);

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
	if($sortcol == "") $sortcol = "id_tarea_pendiente";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarTareaPendiente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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