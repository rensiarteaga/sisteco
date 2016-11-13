<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarExtractoBancario.php
Propósito:				Permite insertar y modificar datos en la tabla tts_extracto_bancario
Tabla:					tts_extracto_bancario
Parámetros:				$id_extracto_bancario
						

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		01/11/2015
Versión:				1.0.0
Autor:					avq
**********************************************************
*/
session_start();
include_once("../LibModeloPresupuesto.php");
require_once 'Excel/reader.php';    

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionGuardarExtractoBancario.php";

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
		$cont =  $_GET["cantidad_ids"];
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

	
	//$id_cuenta_bancaria=1;
	
	
	
	//$agencia='';
	//Realiza el bucle por todos los ids mandados
	/***************************Excel Reader*********************/
	
	//Realiza el bucle por todos los ids mandados
	for($j = 0;$j < $cont; $j++)
	{  
		
		if ($get)
		{
			$id_cuenta_bancaria= $_GET["hidden_id_cuenta_bancaria_".$j];
			$id_extracto_bancario= $_GET["hidden_id_extracto_bancario_".$j];
			$sub_tipo_importe= $_GET["sub_tipo_importe_".$j];
			$observaciones= $_GET["observaciones_".$j];
            $id_cbte= $_GET["id_cbte_".$j];
            $monto= $_GET["monto_".$j];
             $fecha_movimiento= $_GET["fecha_movimiento_".$j];
             $agencia= $_GET["agencia_".$j];
             $descripcion= $_GET["descripcion_".$j];
             $nro_documento= $_GET["nro_documento_".$j];
             $tipo_importe= $_GET["tipo_importe_".$j];
             $id_parametro= $_GET["id_parametro_".$j];
             $id_periodo= $_GET["id_periodo_".$j];       
			
		}
		else
		{
			$id_cuenta_bancaria= $_POST["hidden_id_cuenta_bancaria_".$j];
			$id_extracto_bancario= $_POST["hidden_id_extracto_bancario_".$j];
			$sub_tipo_importe= $_POST["sub_tipo_importe_".$j];
			$observaciones= $_POST["observaciones_".$j];
			$id_cbte= $_POST["id_cbte_".$j];
			$monto= $_POST["monto_".$j];
			$fecha_movimiento= $_POST["fecha_movimiento_".$j];
			$agencia=$_POST["agencia_".$j];
			$descripcion= $_POST["descripcion_".$j];
			$nro_documento= $_POST["nro_documento_".$j];
			$tipo_importe= $_POST["tipo_importe_".$j];
			$id_parametro= $_POST["id_parametro_".$j];
			$id_periodo= $_POST["id_periodo_".$j];
		} 
			////////////////////Inserción/////////////////////
		
		if ($id_extracto_bancario == "undefined" || $id_extracto_bancario == "")
		{
			
           
			//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_categoria
			
			$res = $Custom -> InsertarExtractoBancario($id_extracto_bancario,$id_cuenta_bancaria,$fecha_movimiento,$agencia,$descripcion,$nro_documento,$monto,$tipo_importe,$sub_tipo_importe,$id_parametro,$id_periodo);
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
	else
	{	///////////////////////Modificación////////////////////
		/* $monto= str_replace(".", "", $monto);
		 $monto= str_replace(",", ".", $monto);*/
		
			$res = $Custom->ModificarExtractoBancario($id_extracto_bancario,$sub_tipo_importe,$observaciones,$id_cbte,$monto);
			
			if(!$res)
			{
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
		}
			
			

	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_extracto_bancario";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarExtractoBancario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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