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

	
	//$id_cuenta_bancaria=1;
	
	
	
	//$agencia='';
	//Realiza el bucle por todos los ids mandados
	/***************************Excel Reader*********************/
	
	if ($tipo_registro=='subir_extracto'){
	
	$data = new Spreadsheet_Excel_Reader();
	
	$data->setOutputEncoding('CP1251');
	
	error_reporting(E_ALL ^ E_NOTICE);
	
	/*$id_cuenta_bancaria= $_GET["id_cuenta_bancaria"];
	$id_parametro= $_GET["id_parametro"];
	$id_periodo= $_GET["id_periodo"];
	$nro_cuenta_banco= $_GET["nro_cuenta_banco"];
	$periodo_lite= $_GET["periodo_lite"];
	$gestion= $_GET["gestion"];*/
	
	/*$id_cuenta_bancaria= $_POST["codigo_caif"];
	$id_parametro= $_POST["nombre_caif"];
	$id_periodo= $_POST["sw_transaccional"];
	$nro_cuenta_banco= $_POST["nro_cuenta_banco"];
	$periodo_lite= $_POST["periodo_lite"];
	*/$gestion= $_POST["gestion"];
	
	//$nro_cadena=strlen($nro_cuenta_banco);
	$nro_cuenta_banco=substr($nro_cuenta_banco,-4);
	//echo $nro_cuenta_banco;
	//echo $nro_cadena;
	//exit;
//if ($nro_cuenta_banco)
	if (!file_exists('archivos/caif.xls'))
	//if (!file_exists('archivos/relacionador_gastos.xls'))
	{
		
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "Archivo no encontrado";
		$resp->origen = "File";
		$resp->proc = "Migración";
		$resp->nivel = "0";
		$resp->query = "0";
		echo $resp->get_mensaje();
		exit;
		//die("There's no Excel file to read from");
		//exit;
	}
	$data->read('archivos/caif.xls');
	
//tratar de leer las pestañas
	
	
/*foreach($data->sheets as $x=>$y){
	$x=$data->boundsheets[$x]['name'];
	//echo $x.'-'.$nro_cuenta_banco;
	*/
/*for ($h=0;$h<count($data->sheets);$h++){
	$x=$data->boundsheets[$h]['name'];
	if (($x==$nro_cuenta_banco))
	{/*
		//echo $x.'-'.$nro_cuenta_banco;
		
		/*$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "Hoja no encontrada";
		$resp->origen = "Hoja Excel";
		$resp->proc = "Migración";
		$resp->nivel = "0";
		$resp->query = "0";
		echo $resp->get_mensaje();
		exit;*/
		
		//$data->sheets[$x]['numRows'];
		
	
	for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {
	
		for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
			$codigo_caif=$data->sheets[0]['cells'][$i][1];
			$nombre_caif=$data->sheets[0]['cells'][$i][2];
			$sw_transaccional=$data->sheets[0]['cells'][$i][3];
			$nivel_caif=$data->sheets[0]['cells'][$i][4];
			$codigo_caif_ant=$data->sheets[0]['cells'][$i][5];
			$tipo_caif=$data->sheets[0]['cells'][$i][6];
			$id_parametro=$data->sheets[0]['cells'][$i][7];
			$codigo_caif_ant = substr ($codigo_caif, 0, strlen($codigo_caif) - 1);
		}
	     $codigo_caif=trim($codigo_caif,'0');
	     $nombre_caif=trim($nombre_caif,'0');
		//DefinirCaif($codigo_caif,$nombre_caif,$sw_transaccional,$tipo_caif,$id_parametro)
		$res = $Custom -> DefinirCaif($codigo_caif,utf8_encode($nombre_caif),$sw_transaccional,$nivel_caif,$codigo_caif_ant,$tipo_caif,$id_parametro);
		if(!$res)
		{
			//Se produjo un error
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = $Custom->salida[1] . "Error en el formato del archivo corrija el archivo Excel.";
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje();
			exit;
		}
	
		//echo $codigo_caif_ant;
			
	}
	

	/*}
	
	
}


}else {
	/***************************fin excel Reader**************************/
	
	//Realiza el bucle por todos los ids mandados
	/*for($j = 0;$j < $cont; $j++)
	{  
		
		if ($get)
		{
			$id_cuenta_bancaria= $_GET["hidden_id_cuenta_bancaria_".$j];
			$id_extracto_bancario= $_GET["hidden_id_extracto_bancario_".$j];
			$sub_tipo_importe= $_GET["sub_tipo_importe_".$j];
			echo "raastreosafasdfdf".$id_extracto_bancario;
			exit;
		}
		else
		{
			$id_cuenta_bancaria= $_POST["hidden_id_cuenta_bancaria_".$j];
			$id_extracto_bancario= $_POST["hidden_id_extracto_bancario_".$j];
			$sub_tipo_importe= $_POST["sub_tipo_importe_".$j];
		}
		echo "ingresa aqui?.$id_cuenta_bancaria";
		exit;
			////////////////////Inserción/////////////////////

		if ($id_extracto_bancario == "undefined" || $id_extracto_bancario == "")
		{
		*//*	$id_cuenta_bancaria= $_GET["id_cuenta_bancaria"];
	$id_parametro= $_GET["id_parametro"];
	$id_periodo= $_GET["id_periodo"];
	$nro_cuenta_banco= $_GET["nro_cuenta_banco"];
           
			//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_categoria
			
			$res = $Custom -> DefinirTransferencias($id_cuenta_bancaria,$id_parametro,$id_periodo);
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
	/*	}
	else
	{	///////////////////////Modificación////////////////////
				
			echo $id_cuenta_bancaria;
			exit;
			
			$res = $Custom->ModificarExtractoBancario($id_extracto_bancario,$sub_tipo_importe);
			
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
			
			

	}//END FOR*/
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