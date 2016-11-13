<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarPlanillaDet.php
Propósito:				Permite insertar y modificar datos en la tabla tad_planilla
Tabla:					tad_planilla
Parámetros:				$id_planilla
						
Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-28 17:32:19
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = "ActionGuardarPlanillaDet.php";

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
	for($j = 0;$j < $cont; $j++){
		if ($get){	 
			$id_plan_pago= $_GET["id_plan_pago_$j"];
			$id_cuenta_bancaria= $_GET["id_cuenta_bancaria_$j"];
			$tipo_cheque= $_GET["tipo_cheque_$j"];
			$tipo_plantilla= $_GET["tipo_plantilla_$j"];
			$fecha_factura= $_GET["fecha_factura_$j"];
			$num_factura= $_GET["num_factura_$j"];
			$por_anticipo= $_GET["por_anticipo_$j"];
			$por_retgar= $_GET["por_retgar_$j"];
			$multas= $_GET["multas_$j"];

		}else{
			$id_plan_pago= $_POST["id_plan_pago_$j"];
			$id_cuenta_bancaria= $_POST["id_cuenta_bancaria_$j"];
			$tipo_cheque= $_POST["tipo_cheque_$j"];
			$tipo_plantilla= $_POST["tipo_plantilla_$j"];
			$fecha_factura= $_POST["fecha_factura_$j"];
			$num_factura= $_POST["num_factura_$j"];
			$por_anticipo= $_POST["por_anticipo_$j"];
			$por_retgar= $_POST["por_retgar_$j"];
			$multas= $_POST["multas_$j"];
		}

		$res = $Custom->InsertarPlanillaDet($id_plan_pago,$id_cuenta_bancaria,$tipo_cheque,$tipo_plantilla,$fecha_factura,$num_factura,$por_anticipo,$por_retgar,$multas);
		  if(!$res){
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
	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_cotizacion";
	if($sortdir == "") $sortdir = "desc";
	
	
	if($criterio_filtro == "") $criterio_filtro = "0=0";
	$en_planilla="  PLA.id_planilla=".$m_id_planilla." and ";
	
	$res = $Custom->ContarConsultores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$en_planilla);
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