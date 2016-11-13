<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarEjecucionFisica.php
Propósito:				Permite insertar y modificar datos en la tabla tpr_ejecucion_fisica
Tabla:					tpr_tpr_ejecucion_fisica
Parámetros:				$id_ejecucion_fisica
						

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-07-04 08:54:27
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionGuardarEjecucionFisica.php";

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
			$id_ejecucion_fisica= $_GET["id_ejecucion_fisica_$j"];
			$id_parametro= $_GET["id_parametro_$j"];
			$id_proyecto= $_GET["id_proyecto_$j"];
			$periodo_pres= $_GET["periodo_pres_$j"];
			$porcentaje_ejecucion= $_GET["porcentaje_ejecucion_$j"];
			$estado= $_GET["estado_$j"];		
			$justificacion_fisica= $_GET["justificacion_fisica_$j"];	
			$justificacion_financiera= $_GET["justificacion_financiera_$j"];	
			$acciones_fisica= $_GET["acciones_fisica_$j"];	
			$acciones_financiera= $_GET["acciones_financiera_$j"];
			$problemas_fisica= $_GET["problemas_fisica_$j"];	
			$tiempo_solucion= $_GET["tiempo_solucion_$j"];	
		}
		else
		{
			$id_ejecucion_fisica=$_POST["id_ejecucion_fisica_$j"];
			$id_parametro=$_POST["id_parametro_$j"];
			$id_proyecto=$_POST["id_proyecto_$j"];
			$periodo_pres= $_POST["periodo_pres_$j"];
			$porcentaje_ejecucion= $_POST["porcentaje_ejecucion_$j"];
			$estado= $_POST["estado_$j"];
			$justificacion_fisica= $_POST["justificacion_fisica_$j"];	
			$justificacion_financiera= $_POST["justificacion_financiera_$j"];	
			$acciones_fisica= $_POST["acciones_fisica_$j"];	
			$acciones_financiera= $_POST["acciones_financiera_$j"];
			$problemas_fisica= $_POST["problemas_fisica_$j"];	
			$tiempo_solucion= $_POST["tiempo_solucion_$j"];
		}

		if ($id_ejecucion_fisica == "undefined" || $id_ejecucion_fisica == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarEjecucionFisica("insert",$id_ejecucion_fisica,$id_parametro,$id_proyecto,$periodo_pres,$porcentaje_ejecucion,$estado);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_ejecucion_fisica
			$res = $Custom -> InsertarEjecucionFisica($id_ejecucion_fisica,$id_parametro,$id_proyecto,$periodo_pres,$porcentaje_ejecucion,$estado,$justificacion_fisica,$justificacion_financiera,$acciones_fisica,$acciones_financiera,$problemas_fisica,$tiempo_solucion);

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
			$res = $Custom->ValidarEjecucionFisica("update",$id_ejecucion_fisica,$id_parametro,$id_proyecto,$periodo_pres,$porcentaje_ejecucion,$estado);

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

			$res = $Custom->ModificarEjecucionFisica($id_ejecucion_fisica,$id_parametro,$id_proyecto,$periodo_pres,$porcentaje_ejecucion,$estado,$justificacion_fisica,$justificacion_financiera,$acciones_fisica,$acciones_financiera,$problemas_fisica,$tiempo_solucion);

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
	if($sortcol == "") $sortcol = "id_ejecucion_fisica";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarEjecucionFisica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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