<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarProyecto.php
Propósito:				Permite insertar y modificar datos en la tabla tpm_proyecto
Tabla:					tpm_tpm_proyecto
Parámetros:				$hidden_id_proyecto
						$txt_codigo_proyecto
						$txt_nombre_proyecto
						$txt_descripcion_proyecto
						$txt_fecha_registro
						$txt_hora_registro
						$txt_fecha_ultima_modificacion
						$txt_hora_ultima_modificacion

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-11-06 15:33:00
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloParametros.php");

$Custom = new cls_CustomDBParametros();
$nombre_archivo = "ActionGuardarProyecto.php";

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
			$hidden_id_proyecto= $_GET["hidden_id_proyecto_$j"];
			$txt_codigo_proyecto= $_GET["txt_codigo_proyecto_$j"];
			$txt_nombre_proyecto= $_GET["txt_nombre_proyecto_$j"];
			$txt_descripcion_proyecto= $_GET["txt_descripcion_proyecto_$j"];
			$txt_fecha_registro= $_GET["txt_fecha_registro_$j"];
			$txt_hora_registro= $_GET["txt_hora_registro_$j"];
			$txt_fecha_ultima_modificacion= $_GET["txt_fecha_ultima_modificacion_$j"];
			$txt_hora_ultima_modificacion= $_GET["txt_hora_ultima_modificacion_$j"];
			$txt_nombre_corto= $_GET["txt_nombre_corto_$j"];
			$txt_codigo_sisin= $_GET["txt_codigo_sisin_$j"];
			$txt_fase_proyecto= $_GET["fase_proyecto_$j"];
			$txt_tipo_estudio= $_GET["tipo_estudio_$j"];
			$txt_id_persona= $_GET["txt_id_persona_$j"];
			$txt_id_proyecto_cat_prog= $_GET["txt_id_proyecto_cat_prog_$j"];

		}
		else
		{
			$hidden_id_proyecto=$_POST["hidden_id_proyecto_$j"];
			$txt_codigo_proyecto=$_POST["txt_codigo_proyecto_$j"];
			$txt_nombre_proyecto=$_POST["txt_nombre_proyecto_$j"];
			$txt_descripcion_proyecto=$_POST["txt_descripcion_proyecto_$j"];
			$txt_fecha_registro=$_POST["txt_fecha_registro_$j"];
			$txt_hora_registro=$_POST["txt_hora_registro_$j"];
			$txt_fecha_ultima_modificacion=$_POST["txt_fecha_ultima_modificacion_$j"];
			$txt_hora_ultima_modificacion=$_POST["txt_hora_ultima_modificacion_$j"];
			$txt_nombre_corto= $_POST["txt_nombre_corto_$j"];
			$txt_codigo_sisin= $_POST["txt_codigo_sisin_$j"];
			$txt_fase_proyecto= $_POST["fase_proyecto_$j"];
			$txt_tipo_estudio= $_POST["tipo_estudio_$j"];
			$txt_id_persona= $_POST["txt_id_persona_$j"];
			$txt_id_proyecto_cat_prog= $_POST["txt_id_proyecto_cat_prog_$j"];

		}

		if ($hidden_id_proyecto == "undefined" || $hidden_id_proyecto == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarProyecto("insert",$hidden_id_proyecto, $txt_codigo_proyecto,$txt_nombre_proyecto,$txt_descripcion_proyecto,$txt_fecha_registro,$txt_hora_registro,$txt_fecha_ultima_modificacion,$txt_hora_ultima_modificacion);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpm_proyecto
			$res = $Custom -> InsertarProyecto($hidden_id_proyecto, $txt_codigo_proyecto, $txt_nombre_proyecto, $txt_descripcion_proyecto, $txt_fecha_registro, $txt_hora_registro, $txt_fecha_ultima_modificacion, $txt_hora_ultima_modificacion,$txt_nombre_corto,$txt_codigo_sisin,$txt_fase_proyecto,$txt_tipo_estudio,$txt_id_persona,$txt_id_proyecto_cat_prog);

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
			$res = $Custom->ValidarProyecto("update",$hidden_id_proyecto, $txt_codigo_proyecto, $txt_nombre_proyecto, $txt_descripcion_proyecto, $txt_fecha_registro, $txt_hora_registro, $txt_fecha_ultima_modificacion, $txt_hora_ultima_modificacion);

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

			$res = $Custom->ModificarProyecto($hidden_id_proyecto, $txt_codigo_proyecto, $txt_nombre_proyecto, $txt_descripcion_proyecto, $txt_fecha_registro, $txt_hora_registro, $txt_fecha_ultima_modificacion, $txt_hora_ultima_modificacion,$txt_nombre_corto,$txt_codigo_sisin,$txt_fase_proyecto,$txt_tipo_estudio,$txt_id_persona,$txt_id_proyecto_cat_prog);

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
	if($sortcol == "") $sortcol = "id_proyecto";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarProyecto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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