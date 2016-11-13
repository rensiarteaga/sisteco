<?php
/**
**********************************************************
Nombre de archivo:	    ActionDevPasajeSel.php
Propósito:				Permite modificar datos en la tabla tts_cuenta_doc_det
Tabla:					tts_tts_devengado_detalle
Parámetros:				$id_cuenta_doc_det
						$sw_select
						
Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-10-21 15:43:29
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloTesoreria.php");

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = "ActionDevPasajeSel.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{
	//Verifica si los datos vienen por POST o GET
	if(sizeof($_POST) > 0)
	{
		$get = false;
		$cont =  $_POST["cantidad_ids"];

		//Por Post siempre se decodifica
		$decodificar = true;
	}
	elseif (sizeof($_GET) > 0)
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
	for($j = 0;$j < $cont; $j++)
	{
		if ($get){
			$id_cuenta_doc_det = $_GET["id_cuenta_doc_det_$j"];
			$importe_nuevo = $_GET["importe_nuevo_$j"];
			$nota_debito = $_GET["nota_debito_$j"];
			$pasaje_utilizado = $_GET["no_utilizado_$j"];
			$pasaje_nro = $_GET["pasaje_nro_$j"];
			$pasaje_fecha = $_GET["pasaje_fecha_$j"];
			$id_presupuesto = $_GET["id_presupuesto_$j"];
			$observaciones = $_GET["observaciones_$j"];
			$pasaje_credito = $_GET["pasaje_credito_$j"];
			$pasaje_cobar = $_GET["pasaje_cobrar_$j"];
			$pasaje_orden = $_GET["pasaje_orden_$j"];
		}else{
			$id_cuenta_doc_det = $_POST["id_cuenta_doc_det_$j"];
			$importe_nuevo = $_POST["importe_nuevo_$j"];
			$nota_debito = $_POST["nota_debito_$j"];
			$pasaje_utilizado = $_POST["no_utilizado_$j"];
			$pasaje_nro = $_POST["pasaje_nro_$j"];
			$pasaje_fecha = $_POST["pasaje_fecha_$j"];
			$id_presupuesto = $_POST["id_presupuesto_$j"];
			$observaciones = $_POST["observaciones_$j"];
			$pasaje_credito = $_POST["pasaje_credito_$j"];
			$pasaje_cobar = $_POST["pasaje_cobrar_$j"];
			$pasaje_orden = $_POST["pasaje_orden_$j"];
		}
		
		if($pasaje_utilizado=='true'){
			$pasaje_utilizado = 'si';
		}else{
			$pasaje_utilizado = 'no';
		}
		
		$tipo = $_GET['tipo'];
		
		if($tipo != 'utilizado' && $id_presupuesto != ''){
			if($tipo != 'edita'){
				$tipo = 'presupuesto';
			}
		}
		
		if($tipo != 'utilizado' && $id_presupuesto == '0'){ 
			$tipo = 'cancela';
		}
		
		//oct2015: para finalizar los detalles de pasajes que pertenecen a una solicitud finalizada y q no tiene ninguna rendicion
		if($tipo != 'utilizado' && $id_presupuesto == '-1'){
			$tipo = 'finaliza';
		}
	
		if($tipo == 'utilizado'){
			$nota_debito = $observaciones;
		}
		
		if($tipo == 'utipasaje'){
			$nota_debito = $observaciones;
		}
		
		$res = $Custom->ModificarViaPasaje($id_cuenta_doc_det,$importe_nuevo,$nota_debito,$pasaje_utilizado,$pasaje_nro,$pasaje_fecha,$id_presupuesto,$tipo,$pasaje_credito,$pasaje_cobar,$pasaje_orden);
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
	if($cont > 1) $mensaje_exito = "Datos almacenados";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 30;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_cuenta_doc_det";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarViaPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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