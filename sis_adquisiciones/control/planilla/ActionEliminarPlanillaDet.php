<?php
/**
**********************************************************
Nombre de archivo:	    ActionEliminarPlanillaDet.php
Propósito:				Permite eliminar registros de la tabla tad_planilla
Tabla:					tad_tad_plan_pago
Parámetros:				$id_plan_pago


Valores de Retorno:    	Número de registros
Fecha de Creación:		2008-05-28 17:32:19
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();

include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionEliminarPlanillaDet.php";

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
			$id_cotizacion=$_GET["id_cotizacion_$j"];
			$id_plan_pago= $_GET["id_plan_pago_$j"];
		}
		else
		{
			$id_cotizacion=$_POST["id_cotizacion_$j"];
			$id_plan_pago= $_POST["id_plan_pago_$j"];
		}

		
			$res = $Custom-> EliminarPlanillaDet($m_id_planilla,$id_plan_pago);
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
	}//end for

	//Guarda el mensaje de éxito de la operación realizada
	if($cont>1) $mensaje_exito = "Se eliminaron los registros especificados.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_cotizacion";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";
	$en_planilla=" inner join compro.tad_plan_pago PP on PP.id_cotizacion=c.id_cotizacion
                   inner join sci.tct_plantilla PLANT on PLANT.tipo_plantilla=PLA.tipo_plantilla	
                   inner join compro.tad_planilla PLANIL on PLANIL.id_planilla=PP.id_planilla and PLANIL.id_planilla=$m_id_planilla";

	$res = $Custom->ContarConsultores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$en_planilla);
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