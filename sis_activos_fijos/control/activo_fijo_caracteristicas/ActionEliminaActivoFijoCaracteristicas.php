<?php
/**
/*
**********************************************************
Nombre de archivo:	    ActionEliminaActivoFijoCaracteristicas.php
Propósito:				Permite eliminar registros de la tabla de ActivoFijoCaracteristicas
Tabla:					taf_activo_fijo_comp_caract
Parámetros:				$hidden_id_activo_fijo_caracteristicas	--> id del ActivoFijoCaracteristicas
					

Valores de Retorno:    	Número de registros
Fecha de Creación:		05- 06 - 07
Versión:				1.0.0
Autor:					Rodrigo Chumacero Moscoso
**********************************************************
*/
session_start();

include_once("../LibModeloActivoFijo.php");

$CustomActivos = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionEliminaActivoFijoCaracteristicas.php';


if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
		if (sizeof($_GET) >0)
		{
			$get=true;
			$cont=1;
		}
		elseif(sizeof($_POST) >0)
		{
			$get=false;
			$cont =  $_POST['cantidad_ids'];
			
		}
		else
		{
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = "No existen datos para Eliminar.";
			$resp->origen = $nombre_archivo;
			$resp->proc = $nombre_archivo;
			$resp->nivel = '4';
			echo $resp->get_mensaje();
			exit;
		}


		for($j = 0;$j < $cont; $j++)
		{
			if ($get)
			{
				$hidden_id_activo_fijo_caracteristicas = $_GET["hidden_id_activo_fijo_caracteristicas_$j"];
				
			}
			else
			{
				$hidden_id_activo_fijo_caracteristicas = $_POST["hidden_id_activo_fijo_caracteristicas_$j"];
						
			}

			if ($hidden_id_activo_fijo_caracteristicas == "undefined" || $hidden_id_activo_fijo_caracteristicas==" ")
			{
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = "MENSAJE ERROR = No existe el ActivoFijoCaract especificado para eliminar.";
				$resp->origen = "ORIGEN = $nombre_archivo";
				$resp->proc = "PROC = $nombre_archivo";
				$resp->nivel = "NIVEL = 4";
				echo $resp->get_mensaje();
				exit;
			}
			else
			{	//Eliminación
				
			
				$res = $CustomActivos ->EliminarActivoFijoCaracteristicas($hidden_id_activo_fijo_caracteristicas);
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
		}//end for

		//Guarda el mensaje de éxito de la operación realizada
		
	if($cont>1) $mensaje_exito = 'Se eliminaron los registros especificados.';
	else $mensaje_exito = $CustomActivos->salida[1];
	
    //Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'nombres';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro = '0=0';
	//if($criterio_filtro == "") $criterio_filtro = "afc.id_activo_fijo_caracteristicas = $hidden_id_activo_fijo_caracteristicas";
  
	
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
	$resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp->get_mensaje();
	exit;
}
?>



