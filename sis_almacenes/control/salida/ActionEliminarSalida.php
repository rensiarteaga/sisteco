<?php
/**
**********************************************************
Nombre de archivo:	    ActionEliminarSalida.php
Propósito:				Permite eliminar registros de la tabla tal_salida
Tabla:					tal_tal_salida
Parámetros:				$hidden_id_salida


Valores de Retorno:    	Número de registros
Fecha de Creación:		2007-10-25 15:08:17
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();

include_once("../rac_LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = "ActionEliminarSalida.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}

if($_SESSION["autentificado"]=="SI")
{
	if (sizeof($_GET) >0)
	{
		$get=true;
		$cont=1;
	}
	elseif(sizeof($_POST) >0)
	{
		$get=false;
		$cont =  $_POST["cantidad_ids"];
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para Eliminar.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit;
	}

	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$hidden_id_salida = $_GET["hidden_id_salida_$j"];
		}
		else
		{
			$hidden_id_salida = $_POST["hidden_id_salida_$j"];				
		}

		if ($hidden_id_salida == "undefined" || $hidden_id_salida == "")
		{
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = "MENSAJE ERROR = No existe el registro especificado para eliminar.";
			$resp->origen = "ORIGEN = $nombre_archivo";
			$resp->proc = "PROC = $nombre_archivo";
			$resp->nivel = "NIVEL = 4";
			echo $resp->get_mensaje();
			exit;
		}
		else
		{	//Eliminación
			$res = $Custom-> EliminarSalida($hidden_id_salida);
			if(!$res)
			{
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] ;
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		}
	}//end for

	//Guarda el mensaje de éxito de la operación realizada
	if($cont>1) $mensaje_exito = "Se eliminaron los registros especificados.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_salida";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") {
		if($tipo!="" && $tipo!='General'){
			$criterio_filtro = "MOTSAL.tipo=''$tipo'' AND SALIDA.tipo_pedido=''$tipo_pedido''";
		}
		else {
				$criterio_filtro= "SALIDA.tipo_pedido=''$tipo_pedido''";
			}
	
	}
   
	$id_emp = $_SESSION["ss_id_empleado"];
	
	
	//si el rol es administrador no es necesario filtrar por empleado
	//$criterio_filtro = $cond -> obtener_criterio_filtro();
	//echo $id_emp;
	
     if(($id_emp!="null" && $id_emp!='') && $tipo=='Personal'){
    
	       $criterio_filtro= $criterio_filtro." AND SALIDA.id_empleado=$id_emp";
	}
	
   
	$res = $Custom->ContarSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", $total_registros);
	$resp->add_nodo("mensaje",$mensaje_exito);
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