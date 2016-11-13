<?php
/**
**********************************************************
Nombre de archivo:	ActionGuardarUbicacion.php
Proposito:			Permite insertar y modificar datos en la tabla taf_ubicacion
Tabla:				taf_ubicacion
Parametros:			$id_lugar
					$codigo
					$ubicacion
					$estado
					$fecha_reg
Valores de Retorno:    	Numero de registros guardados
Fecha de Creaci�n:	05/08/2013
Version:				1.0.0
Autor:					unknow
**********************************************************
*/
session_start();

include_once('../LibModeloActivoFijo.php');

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = "ActionGuardarUbicacion.php";

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
		
		
		//Verifica si se harao no la decodificacion(solo pregunta en caso del GET)
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
			$id_ubicacion= $_GET["id_ubicacion_$j"];
			$codigo= $_GET["txt_codigo_$j"];
			$estado= $_GET["txt_estado_$j"];
			$fecha_reg= $_GET["txt_fecha_reg_$j"];
			$id_lugar=$_GET["txt_id_lugar_$j"];
			$ubicacion=$_GET["txt_ubicacion_$j"];			
		}
		else
		{
			$id_ubicacion= $_POST["id_ubicacion_$j"];
			$codigo= $_POST["txt_codigo_$j"];
			$estado= $_POST["txt_estado_$j"];
			$fecha_reg= $_POST["txt_fecha_reg_$j"];
			$id_lugar=$_POST["txt_id_lugar_$j"];
			$ubicacion=$_POST["txt_ubicacion_$j"];		

		}

		if ($id_ubicacion == "undefined" || $id_ubicacion == "")
		{
			////////////////////Insercion/////////////////////
			//Validacion de datos (del lado del servidor)
			$res = $Custom->ValidarUbicacion("insert",$id_ubicacion,$codigo,$estado,$fecha_reg,$id_lugar, $ubicacion);
			
			if(!$res)
			{	
				
				//Error de validacion
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}
			//Validacion satisfactoria, se ejecuta la insercion en taf_ubicacion
			$res = $Custom -> CrearUbicacion($id_ubicacion,$codigo,$estado,$fecha_reg,$id_lugar,$ubicacion);
			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] . " (iteracion $cont)";
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		}
		else
		{	///////////////////////Modificacion////////////////////
			
			//Validacion de datos (del lado del servidor)
			$res = $Custom->ValidarUbicacion("update",$id_ubicacion,$codigo,$estado,$fecha_reg,$id_lugar, $ubicacion);

			if(!$res)
			{
				//Error de validacion
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			$res = $Custom->ModificarUbicacion($id_ubicacion,$codigo,$estado,$fecha_reg,$id_lugar, $ubicacion);

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
	//Guarda el mensaje de exito de la operacion realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parametros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "UBI.id_ubicacion";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";
	
	$res = $Custom->ContarListaUbicacionFisica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
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