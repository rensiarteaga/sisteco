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
//include_once("../../sis_tesoreria/control/LibModeloTesoreria.php");
require_once 'Excel/reader.php';    

$Custom = new cls_CustomDBPresupuesto();
//$CustomTesoro = new cls_CustomDBTesoro();
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


	//Realiza el bucle por todos los ids recuperados
	/***************************Excel Reader*********************/
	
	if ($tipo_registro=='subir_extracto'){
	
	$data = new Spreadsheet_Excel_Reader();
	
	$data->setOutputEncoding('CP1251');
	
	error_reporting(E_ALL ^ E_NOTICE);
	/* if(error_reporting(E_ALL ^ E_NOTICE)==6135)
	  {
	  	//Se produjo un error
	  		
	  	$resp = new cls_manejo_mensajes(true, "406");
	  	$resp->error = 'true' . "Error en el formato del archivo corrija el archivo Excel.";
	  	$resp->mensaje_error ='Error en el formato del archivo corrija el archivo Excel.';
	  	$resp->origen = "File";
		$resp->proc = "Migración";
		$resp->nivel = "0";
		$resp->query = "0";
	  	echo $resp->get_mensaje();
	  	exit;
	  }*/
	
	$id_cuenta_bancaria= $_POST["id_cuenta_bancaria"];
	$id_parametro= $_POST["id_parametro"];
	$id_periodo= $_POST["id_periodo"];
	$nro_cuenta_banco= $_POST["nro_cuenta_banco"];
	$periodo_lite= $_POST["periodo_lite"];
	$gestion= $_POST["gestion"];
	
	$nro_cuenta_banco=substr($nro_cuenta_banco,-4);
	//if (!file_exists('archivos/'.$periodo_lite.'CUT'.$gestion.'.xls'))
	
	if (!file_exists('archivos/'.$periodo_lite.$gestion.'.xls'))
	{
		
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->error = "Archivo no encontrado";
		$resp->mensaje_error ='Archivo no encontrado para el periodo'.$periodo_lite.'y la gestion'.$gestion;
		$resp->origen = "File";
		$resp->proc = "Migración";
		$resp->nivel = "0";
		$resp->query = "0";
		echo $resp->get_mensaje();
		exit;
		
	}
     //$res=false;
	if(!is_readable('archivos/'.$periodo_lite.$gestion.'.xls')) {
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->error = 'true' ."Archivo erroneo";
		$resp->mensaje_error ='El Archivo no se puede leer grave en el formato xls';
		$resp->origen = "File";
		$resp->proc = "Migración";
		$resp->nivel = "0";
		$resp->query = "0";
		echo $resp->get_mensaje();
		exit;
	}
	//$data->read('archivos/'.$periodo_lite.'CUT'.$gestion.'.xls');
	$data->read('archivos/'.$periodo_lite.$gestion.'.xls');	
	
	
		for ($h=0;$h<count($data->sheets);$h++){
			$x=$data->boundsheets[$h]['name'];
			if (($x==$nro_cuenta_banco))
			{
			for ($i = 1; $i <= $data->sheets[$h]['numRows']; $i++) {
				for ($j = 1; $j <= $data->sheets[$h]['numCols']; $j++) {
					$fecha_movimiento=$data->sheets[$h]['cells'][$i][1];
					$agencia=$data->sheets[$h]['cells'][$i][2];
					$descripcion=$data->sheets[$h]['cells'][$i][3];
					$nro_documento=$data->sheets[$h]['cells'][$i][4];
					$monto=$data->sheets[$h]['cells'][$i][5];
					if ($monto<0) {
						$tipo_importe='gasto';
					}else{
						$tipo_importe='recurso';
					}
					$monto= str_replace(",", "", $monto);
						
					$dia = substr($fecha_movimiento,0 , 2); // devuelve "d"
					$mes = substr($fecha_movimiento,3 , 2); // devuelve "d"
					$anio = substr($fecha_movimiento,6 , 4); // devuelve "d"
					$fecha_movimiento=$mes.'/'.$dia.'/'.$anio;
				}
				
				$res = $Custom -> InsertarExtractoBancario($id_extracto_bancario,$id_cuenta_bancaria,$fecha_movimiento,$agencia,$descripcion,$nro_documento,$monto,$tipo_importe,$sub_tipo_importe,$id_parametro,$id_periodo);
				if(!$res)
				{
					//Se produjo un error
					
					$resp = new cls_manejo_mensajes(true, "406");
					$resp->error = 'true' . "Error en el formato del archivo corrija el archivo Excel.";
					$resp->mensaje ='Error en el formato del archivo corrija el archivo Excel.';
					$resp->origen = $Custom->salida[2];
					$resp->proc = $Custom->salida[3];
					$resp->nivel = $Custom->salida[4];
					$resp->query = $Custom->query;
					echo $resp->get_mensaje();
					exit;
				}
			}
		}
	  }
	 
	}else {
	/***************************fin excel Reader**************************/
	$id_cuenta_bancaria= $_GET["id_cuenta_bancaria"];
	$id_parametro= $_GET["id_parametro"];
	$id_periodo= $_GET["id_periodo"];
	$nro_cuenta_banco= $_GET["nro_cuenta_banco"];
    //Validación satisfactoria, Se define las transferencias
	$res = $Custom -> DefinirTransferencias($id_cuenta_bancaria,$id_parametro,$id_periodo);
	if(!$res)
	  {
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->error = $Custom->salida[1] . " (iteración $cont)";
		$resp->mensaje ='Error en la inserción de Transferencias';
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;    
		echo $resp->get_mensaje();
		exit;
		}
	}   
  
	
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
   //  $mensaje_exito='Existe un error Consulte con el ADMINISTRADOR DEL SISTEMA';
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