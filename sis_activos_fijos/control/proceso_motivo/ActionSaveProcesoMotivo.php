<?php
/*
**********************************************************
Nombre de archivo:	    ActionSaveProcesoMotivo.php
Propósito:				Permite insertar y modificarProcesoMotivo
Tabla:					taf_proceso_motivo
Parámetros:				$hidden_id_motivo	--> id del ProcesoMotivo
						$descripcion
						

Valores de Retorno:    	Número de registros
Fecha de Creación:		05-06-2007
Versión:				
Autor:					Mercedes Zambrana Meneses
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");


$CustomActivos = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionSaveProcesoMotivo.php';

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
			$hidden_id_motivo = $_GET["hidden_id_motivo_$j"];
			$txt_descripcion = $_GET["txt_descripcion_$j"];
			$hidden_id_proceso = $_GET["hidden_id_proceso_$j"];
		
		}
		else
		{
			
		
			$hidden_id_motivo = $_POST["hidden_id_motivo_$j"];
			$txt_descripcion = $_POST["txt_descripcion_$j"];
			$hidden_id_proceso = $_POST["hidden_id_proceso_$j"];
		
		}


		if ($hidden_id_motivo == "undefined" || $hidden_id_motivo =="")
		{
			///////////////////Inserción
			//Validación de datos (del lado del servidor)
		
					
			$res = $CustomActivos->ValidarProcesoMotivo("insert",$hidden_id_motivo,$txt_descripcion,$hidden_id_proceso);
			
			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $CustomActivos->salida[1];
				$resp->origen = $CustomActivos->salida[2];
				$resp->proc = $CustomActivos->salida[3];
				$resp->nivel = $CustomActivos->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			$res = $CustomActivos ->CrearProcesoMotivo($hidden_id_motivo,$txt_descripcion,$hidden_id_proceso);
			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $CustomActivos->salida[1]. " (iteración $cont)";
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
			$res = $CustomActivos->ValidarProcesoMotivo("update",$hidden_id_motivo,$txt_descripcion,$hidden_id_proceso);
			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $CustomActivos->salida[1];
				$resp->origen = $CustomActivos->salida[2];
				$resp->proc = $CustomActivos->salida[3];
				$resp->nivel = $CustomActivos->salida[4];
				echo $resp->get_mensaje();
				exit;
			}
					
			$res = $CustomActivos->ModificarProcesoMotivo($hidden_id_motivo,$txt_descripcion,$hidden_id_proceso);
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
	if($criterio_filtro== "") $criterio_filtro ="proc.id_proceso = $hidden_id_proceso";

	$res = $CustomActivos->ContarListaProcesoMotivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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