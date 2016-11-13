<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarPersona.php
Propósito:				Permite insertar y modificar datos en la tabla tsg_persona
Tabla:					tsg_tsg_persona
Parámetros:				$hidden_id_persona
						

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-10-25 17:19:23
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloSeguridad.php");

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = "ActionGuardarNivelSeguridad.php";

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
			$id_nivel_seguridad= $_GET["id_nivel_seguridad_".$j];
			$codigo= $_GET["codigo_".$j];
			$nombre_nivel= $_GET["nombre_nivel_".$j];
			$prioridad= $_GET["prioridad_".$j];
			
		}
		else
		{	
			$id_nivel_seguridad= $_POST["id_nivel_seguridad_".$j];
			$codigo= $_POST["codigo_".$j];
			$nombre_nivel= $_POST["nombre_nivel_".$j];
			$prioridad= $_POST["prioridad_".$j];
		
		}
		
         //echo 'nivel'.$id_nivel_seguridad.'codigo'.$codigo.'nombre'.$nombre_nivel; exit();     
		if ($id_nivel_seguridad == "undefined" || $id_nivel_seguridad == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			//$res = $Custom->ValidarPersona("insert",$hidden_id_persona, $txt_apellido_paterno,$txt_apellido_materno,$txt_nombre,$txt_fecha_nacimiento,$txt_foto_persona,$txt_doc_id,$txt_genero,$txt_casilla,$txt_telefono1,$txt_telefono2,$txt_celular1,$txt_celular2,$txt_pag_web,$txt_email1,$txt_email2,$txt_email3,$txt_fecha_registro,$txt_hora_registro,$txt_fecha_ultima_modificacion,$txt_hora_ultima_modificacion,$txt_observaciones,$txt_id_tipo_doc_identificacion);
/*
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
*/
			//Validación satisfactoria, se ejecuta la inserción en la tabla tsg_persona
			$res = $Custom -> InsertarNivelSeguridad($codigo,$nombre_nivel,$prioridad);

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
	/*		
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarPersona("update",$hidden_id_persona, $txt_apellido_paterno, $txt_apellido_materno, $txt_nombre, $txt_fecha_nacimiento, $txt_foto_persona, $txt_doc_id, $txt_genero, $txt_casilla, $txt_telefono1, $txt_telefono2, $txt_celular1, $txt_celular2, $txt_pag_web, $txt_email1, $txt_email2, $txt_email3, $txt_fecha_registro, $txt_hora_registro, $txt_fecha_ultima_modificacion, $txt_hora_ultima_modificacion, $txt_observaciones, $txt_id_tipo_doc_identificacion);

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
*/
			$res = $Custom->ModificarNivelSeguridad($id_nivel_seguridad,$codigo,$nombre_nivel,$prioridad);

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
	if($sortcol == "") $sortcol = "id_nivel_seguridad";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarNivelSeguridad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
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