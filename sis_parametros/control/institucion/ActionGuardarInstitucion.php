<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarInstitucion.php
Propósito:				Permite insertar y modificar datos en la tabla tpm_institucion
Tabla:					tpm_tpm_institucion
Parámetros:				$hidden_id_institucion
						$txt_doc_id
						$txt_nombre
						$txt_casilla
						$txt_telefono1
						$txt_telefono2
						$txt_celular1
						$txt_celular2
						$txt_fax
						$txt_email1
						$txt_email2
						$txt_pag_web
						$txt_observaciones
						$txt_fecha_registro
						$txt_hora_registro
						$txt_fecha_ultima_modificacion
						$txt_hora_ultima_modificacion
						$txt_estado_institucion
						$txt_id_persona
						$txt_direccion
						$txt_id_tipo_doc_institucion

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-11-06 21:04:29
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloParametros.php");

$Custom = new cls_CustomDBParametros();
$nombre_archivo = "ActionGuardarInstitucion.php";

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
			$hidden_id_institucion= $_GET["hidden_id_institucion_$j"];
			$txt_doc_id= $_GET["txt_doc_id_$j"];
			$txt_nombre= $_GET["txt_nombre_$j"];
			$txt_casilla= $_GET["txt_casilla_$j"];
			$txt_telefono1= $_GET["txt_telefono1_$j"];
			$txt_telefono2= $_GET["txt_telefono2_$j"];
			$txt_celular1= $_GET["txt_celular1_$j"];
			$txt_celular2= $_GET["txt_celular2_$j"];
			$txt_fax= $_GET["txt_fax_$j"];
			$txt_email1= $_GET["txt_email1_$j"];
			$txt_email2= $_GET["txt_email2_$j"];
			$txt_pag_web= $_GET["txt_pag_web_$j"];
			$txt_observaciones= $_GET["txt_observaciones_$j"];
			$txt_fecha_registro= $_GET["txt_fecha_registro_$j"];
			$txt_hora_registro= $_GET["txt_hora_registro_$j"];
			$txt_fecha_ultima_modificacion= $_GET["txt_fecha_ultima_modificacion_$j"];
			$txt_hora_ultima_modificacion= $_GET["txt_hora_ultima_modificacion_$j"];
			$txt_estado_institucion= $_GET["txt_estado_institucion_$j"];
			$txt_id_persona= $_GET["txt_id_persona_$j"];
			$txt_direccion= $_GET["txt_direccion_$j"];
			$txt_id_tipo_doc_institucion= $_GET["txt_id_tipo_doc_institucion_$j"];
			$txt_codigo= $_GET["txt_codigo_$j"];
		}
		else
		{
			$hidden_id_institucion=$_POST["hidden_id_institucion_$j"];
			$txt_doc_id=$_POST["txt_doc_id_$j"];
			$txt_nombre=$_POST["txt_nombre_$j"];
			$txt_casilla=$_POST["txt_casilla_$j"];
			$txt_telefono1=$_POST["txt_telefono1_$j"];
			$txt_telefono2=$_POST["txt_telefono2_$j"];
			$txt_celular1=$_POST["txt_celular1_$j"];
			$txt_celular2=$_POST["txt_celular2_$j"];
			$txt_fax=$_POST["txt_fax_$j"];
			$txt_email1=$_POST["txt_email1_$j"];
			$txt_email2=$_POST["txt_email2_$j"];
			$txt_pag_web=$_POST["txt_pag_web_$j"];
			$txt_observaciones=$_POST["txt_observaciones_$j"];
			$txt_fecha_registro=$_POST["txt_fecha_registro_$j"];
			$txt_hora_registro=$_POST["txt_hora_registro_$j"];
			$txt_fecha_ultima_modificacion=$_POST["txt_fecha_ultima_modificacion_$j"];
			$txt_hora_ultima_modificacion=$_POST["txt_hora_ultima_modificacion_$j"];
			$txt_estado_institucion=$_POST["txt_estado_institucion_$j"];
			$txt_id_persona=$_POST["txt_id_persona_$j"];
			$txt_direccion=$_POST["txt_direccion_$j"];
			$txt_id_tipo_doc_institucion=$_POST["txt_id_tipo_doc_institucion_$j"];
			$txt_codigo=$_POST["txt_codigo_$j"];
		}

		if ($hidden_id_institucion == "undefined" || $hidden_id_institucion == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarInstitucion("insert",$hidden_id_institucion, $txt_doc_id,$txt_nombre,$txt_casilla,$txt_telefono1,$txt_telefono2,$txt_celular1,$txt_celular2,$txt_fax,$txt_email1,$txt_email2,$txt_pag_web,$txt_observaciones,$txt_fecha_registro,$txt_hora_registro,$txt_fecha_ultima_modificacion,$txt_hora_ultima_modificacion,$txt_estado_institucion,$txt_id_persona,$txt_direccion,$txt_id_tipo_doc_institucion);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpm_institucion
			$res = $Custom -> InsertarInstitucion($hidden_id_institucion, $txt_doc_id, $txt_nombre, $txt_casilla, $txt_telefono1, $txt_telefono2, $txt_celular1, $txt_celular2, $txt_fax, $txt_email1, $txt_email2, $txt_pag_web, $txt_observaciones, $txt_fecha_registro, $txt_hora_registro, $txt_fecha_ultima_modificacion, $txt_hora_ultima_modificacion, $txt_estado_institucion, $txt_id_persona, $txt_direccion, $txt_id_tipo_doc_institucion,$txt_codigo);

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
			$res = $Custom->ValidarInstitucion("update",$hidden_id_institucion, $txt_doc_id, $txt_nombre, $txt_casilla, $txt_telefono1, $txt_telefono2, $txt_celular1, $txt_celular2, $txt_fax, $txt_email1, $txt_email2, $txt_pag_web, $txt_observaciones, $txt_fecha_registro, $txt_hora_registro, $txt_fecha_ultima_modificacion, $txt_hora_ultima_modificacion, $txt_estado_institucion, $txt_id_persona, $txt_direccion, $txt_id_tipo_doc_institucion);

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

			$res = $Custom->ModificarInstitucion($hidden_id_institucion, $txt_doc_id, $txt_nombre, $txt_casilla, $txt_telefono1, $txt_telefono2, $txt_celular1, $txt_celular2, $txt_fax, $txt_email1, $txt_email2, $txt_pag_web, $txt_observaciones, $txt_fecha_registro, $txt_hora_registro, $txt_fecha_ultima_modificacion, $txt_hora_ultima_modificacion, $txt_estado_institucion, $txt_id_persona, $txt_direccion, $txt_id_tipo_doc_institucion,$txt_codigo);

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
	if($sortcol == "") $sortcol = "id_institucion";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarInstitucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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