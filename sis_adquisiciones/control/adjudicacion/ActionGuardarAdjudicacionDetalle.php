<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarAdjudicacion.php
Propósito:				Permite insertar y modificar datos en la tabla tad_cotizacion_det
Tabla:					tad_tad_cotizacion_det
Parámetros:				$id_cotizacion_det
						

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-28 17:32:13
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom =  new  cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarAdjudicacion.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{ 
	//Verifica si los datos vienen por POST o GET
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
	
	
	for($j = 0;$j < $cont; $j++)
	{
		if ($get){
			$id_cotizacion= $_GET["id_cotizacion_$j"];
			$id_item= $_GET["id_item_$j"];
			$id_servicio= $_GET["id_servicio_$j"];
			$id_item_cotizado= $_GET["id_item_cotizado_$j"];
			$id_servicio_cotizado= $_GET["id_servicio_cotizado_$j"];
		}
		else{
			$id_cotizacion= $_POST["id_cotizacion_$j"];
			$id_item= $_POST["id_item_$j"];
			$id_servicio= $_POST["id_servicio_$j"];
			$id_item_cotizado= $_POST["id_item_cotizado_$j"];
			$id_servicio_cotizado= $_POST["id_servicio_cotizado_$j"];
		}
	
	if($id_item_cotizado=='undefined'){
		$id_item_cotizado=NULL;
	}
	if($id_servicio_cotizado=='undefined'){
		$id_servicio_cotizado=NULL;
	}
	
	if($id_item=='undefined'){
		$id_item=NULL;
	}
	if($id_servicio=='undefined'){
		$id_servicio=NULL;
	}
		
     $res= $Custom -> AdjudicarDetalle($id_cotizacion,$id_item,$id_servicio,$id_item_cotizado,$id_servicio_cotizado);
				
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
		/*$mensaje_exito = $Custom->salida[1];
		echo "{success:true,agrupar:'NO',mensaje:'$mensaje_exito'}";
		exit;*/
		
	
		$mensaje_exito = $Custom -> salida[1];
		if($cont > 0){
			echo "{success:true,agrupar:'NO',mensaje:'$mensaje_exito'}";
			exit;
		}
		else{
			echo "{success:false,agrupar:'NO',mensaje:'$mensaje_exito'}";
			exit;
		}
	
	
	
		
		
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp-> get_mensaje();
	exit;
}
?>