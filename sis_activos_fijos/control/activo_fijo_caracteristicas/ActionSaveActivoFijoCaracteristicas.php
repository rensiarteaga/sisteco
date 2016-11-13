<?php
/**
**********************************************************
Nombre de archivo:	    ActionSaveActivoFijoCaracteristicas.php
Propósito:				Permite insertar y modificarActivoFijoaract
Tabla:					taf_activo_fijo__caract
Parámetros:				$hidden_id_activo_fijo_caract	--> id del ActivoFijoCaract
						$descripcion
						

Valores de Retorno:    	Número de registros
Fecha de Creación:		
Versión:				
Autor:					Rodrigo Chumacero Moscoso
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");


$CustomActivos = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionSaveActivoFijoCaracteristicas.php';



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
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$hidden_id_activo_fijo_caracteristicas = $_GET["hidden_id_activo_fijo_fijo_caracteristicas_$j"];
			$txt_descripcion = $_GET["txt_descripcion_$j"];
			$hidden_id_caracteristica = $_GET["hidden_id_caracteristica_$j"];
			$hidden_id_activo_fijo = $_GET["hidden_id_activo_fijo_$j"];
			
		}
		else
		{
			$hidden_id_activo_fijo_caracteristicas = $_POST["hidden_id_activo_fijo_caracteristicas_$j"];
			$txt_descripcion = $_POST["txt_descripcion_$j"];
			$hidden_id_caracteristica = $_POST["hidden_id_caracteristica_$j"];
			$hidden_id_activo_fijo = $_POST["hidden_id_activo_fijo_$j"];
			
		}


		if ($hidden_id_activo_fijo_caracteristicas == "undefined" || $hidden_id_activo_fijo_caracteristicas =="")
		{
				
		
//			$res = $CustomActivos->ValidarActivoFijoCaracteristicas("insert",$hidden_id_activo_fijo_caracteristicas, $txt_descripcion, $hidden_id_caracteristica, $hidden_id_activo_fijo);
//			
//			if(!$res)
//			{
//				//Error de validación
//				$resp = new cls_manejo_mensajes(true, "406");
//				$resp->mensaje_error = $CustomActivos->salida[1];
//				$resp->origen = $CustomActivos->salida[2];
//				$resp->proc = $CustomActivos->salida[3];
//				$resp->nivel = $CustomActivos->salida[4];
//				echo $resp->get_mensaje();
//				exit;
//			}

			$res = $CustomActivos ->CrearActivoFijoCaracteristicas($hidden_id_activo_fijo_caracteristicas, $txt_descripcion, $hidden_id_caracteristica, $hidden_id_activo_fijo);
			
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
		else
		{	//Modificación
			
			//Validación de datos (del lado del servidor)
//			$res = $CustomActivos->ValidarActivoFijoCaracteristicas("update",$hidden_id_activo_fijo_caracteristicas, $txt_descripcion, $hidden_id_caracteristica, $hidden_id_activo_fijo);
//			
//			if(!$res)
//			{
//				//Error de validación
//				$resp = new cls_manejo_mensajes(true, "406");
//				$resp->mensaje_error = $CustomActivos->salida[1];
//				$resp->origen = $CustomActivos->salida[2];
//				$resp->proc = $CustomActivos->salida[3];
//				$resp->nivel = $CustomActivos->salida[4];
//				echo $resp->get_mensaje();
//				exit;
//			
//			}	
			$res = $CustomActivos->ModificarActivoFijoCaracteristicas($hidden_id_activo_fijo_caracteristicas, $txt_descripcion, $hidden_id_caracteristica, $hidden_id_activo_fijo);
			
			
			if(!$res)
			{
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

	}//END FOR

	/***************no entra aqui cuando es $_GET*************/
	///Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = 'Se guardaron todos los datos.';
	else $mensaje_exito = $CustomActivos->salida[1];
	
	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'nombres';
	if($sortdir == "") $sortdir = 'asc';
	//if($criterio_filtro == "") $criterio_filtro = '0=0';
	if($criterio_filtro == "") $criterio_filtro = "taf.id_activo_fijo = $hidden_id_activo_fijo";

	$res = $CustomActivos->ContarListaActivoFijoCaracteristicas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $CustomActivos->salida[0][0];

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