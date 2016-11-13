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
		if ($get)
		{
			$id_cotizacion_det= $_GET["id_cotizacion_det_$j"];
			$cantidad_adjudicada= $_GET["cantidad_adjudicada_$j"];
			$id_item= $_GET["id_item_$j"];
			$id_servicio= $_GET["id_servicio_$j"];
			$id_item_cotizado= $_GET["id_item_cotizado_$j"];
			$id_servicio_cotizado= $_GET["id_servicio_cotizado_$j"];
			$id_proceso_compra_det= $_GET["id_proceso_compra_det_$j"];
			$id_solicitud_compra_det=$_GET["id_solicitud_compra_det_$j"];
			$cantidad_solicitada=$_GET["cantidad_solicitada_$j"];
			$monto_aprobado=$_GET["monto_aprobado_$j"];
			$reformular=$_GET["reformular_$j"];
			$bandera=$_GET["bandera_$j"];
			$id_adjudicacion=$_GET["id_adjudicacion_$j"];
			$precio_cotizado=$_GET["precio_cotizado_$j"];
			$motivo_ref=$_GET["motivo_ref_$j"];

		}
		else
		{
			
			$id_cotizacion_det= $_POST["id_cotizacion_det_$j"];
			$cantidad_adjudicada= $_POST["cantidad_adjudicada_$j"];
			$id_item= $_POST["id_item_$j"];
			$id_servicio= $_POST["id_servicio_$j"];
			$id_item_cotizado= $_POST["id_item_cotizado_$j"];
			$id_servicio_cotizado= $_POST["id_servicio_cotizado_$j"];
			$id_proceso_compra_det= $_POST["id_proceso_compra_det_$j"];
			$id_solicitud_compra_det=$_POST["id_solicitud_compra_det_$j"];
			$cantidad_solicitada=$_POST["cantidad_solicitada_$j"];
			$monto_aprobado=$_POST["monto_aprobado_$j"];
			$reformular=$_POST["reformular_$j"];
			$bandera=$_POST["bandera_$j"];
			$id_adjudicacion=$_POST["id_adjudicacion_$j"];
			$precio_cotizado=$_POST["precio_cotizado_$j"];
			$motivo_ref=$_POST["motivo_ref_$j"];
		}
		
		
		
//	echo "id_cotizacion_det->".$id_cotizacion_det."cantidad_adjudicada->".$cantidad_adjudicada."id_item->".$id_item."id_proceso_compra_det->".$id_proceso_compra_det."id_solicitud_compra_det->".$id_solicitud_compra_det."cantidad_solicitada->".$cantidad_solicitada."monto_aprobado->".$monto_aprobado."precio_cotizado->".$precio_cotizado;
//	exit;
	if($id_item_cotizado=='undefined'){
		$id_item_cotizado=NULL;
	}
	if($id_servicio_cotizado=='undefined'){
		$id_servicio_cotizado=NULL;
	}
		$retencion=$_SESSION["ss_retencion"];
		
		if($precio_cotizado<0){//ENDE-0001: 10/09/2012: antes la condicion era 0.1, se cambia a 0 para permitir registrar precio=0 y poder cambiar la cotizacion_det a pendiente para eliminacion de cotizacion
		  $precio_cotizado=$monto_aprobado;	
		}
     $res= $Custom -> InsertarReforAdj($id_cotizacion_det,$cantidad_adjudicada,$id_item,$id_servicio,$id_item_cotizado,$id_servicio_cotizado,$id_proceso_compra_det,$id_solicitud_compra_det,$cantidad_solicitada,$monto_aprobado,$reformular,$bandera,$id_adjudicacion,$precio_cotizado,$retencion,$motivo_ref);
				
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