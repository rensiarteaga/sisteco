<?php
/*
**********************************************************
Nombre de archivo:	  	ActionGuardarActivoFijoComprobante.php 
Propósito:				Permite guardar el contenido de la tabla actif.taf_activo_fijo_comprobante
Tabla:					actif.taf_tipo_activo_comprobante
Parámetros:				$id_grupo_proceso_1	--> id del grupoProceso
						$cantidad_ids -> # ids
$descripcion			Guarda las cuentas asociadas segun tipo y ep en la tabla


Valores de Retorno:	   Número de registros
Fecha de Creación:	   01/02/2013	  	  	
Versión: 				1.1.1
Autor:					Elmer Velasquez
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");


$CustomActivos = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionGuardarActivoFijoComprobante.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	//Verifica si los datos vienen por post o get
	if (sizeof($_GET) >0)
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
	elseif(sizeof($_POST) >0)
	{
		$get=false;
		$cont =  $_POST['cantidad_ids'];

		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar";
		$resp->origen = "ORIGEN= $nombre_archivo";
		$resp->proc = "PROC =$nombre_archivo";
		$resp->nivel = 'NIVEL = 4';
		echo $resp->get_mensaje();
		exit;
	}

	//Envia al Custom la bandera que indica si se decodificará o no
	$CustomActivos->decodificar = $decodificar;

	//Realiza el bucle por todos los ids mandados
	for($j = 1;$j <= $cont; $j++)
	{ 
		if ($get)
		{ 
			$id_grupo_proceso = $_GET["id_grupo_proceso_$j"];
		}
		else
		{
			$id_grupo_proceso = $_POST["id_grupo_proceso_$j"];
		}

		if ($id_grupo_proceso != "undefined" || $id_grupo_proceso != "")
		{
			//v 1.1
			$res = $CustomActivos->InsertarActivoFijoComprobante($id_grupo_proceso);

			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $CustomActivos->salida[1];
				$resp->origen = $CustomActivos->salida[2];
				$resp->proc = $CustomActivos->salida[3];
				$resp->nivel = $CustomActivos->salida[4];
				$resp->query = $CustomActivos->query;
				echo $resp->get_mensaje();
				exit;
			}
		}
	}


	///Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = 'Se guardaron todos los datos.';
	else $mensaje_exito = $CustomActivos->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = '';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro='';
	//realiza el count de todos los elementos de la tabla actif.taf_activo_fijo_comprobante
	$res = $CustomActivos->CountActivoFijoComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
	if($res) $total_registros= $CustomActivos->salida; 

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo('TotalCount', $total_registros);
	$resp->add_nodo('mensaje', $mensaje_exito);
	$resp->add_nodo('tiempo_resp', '200');
	echo $resp->get_mensaje();
	exit;
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 1';
	echo $resp->get_mensaje();
	exit;
}
?>