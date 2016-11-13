<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarReposicionCaja.php
Propósito:				Permite insertar y modificar datos en la tabla tts_caja_regis
Tabla:					tts_tts_caja_regis
Parámetros:				$id_caja_regis
						$id_caja
						$id_cajero
						$fecha_regis
						$importe_regis

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-10-21 15:53:15
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloTesoreria.php");

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = "ActionGuardarReposicionCaja.php";

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
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$id_caja_regis= $_GET["id_caja_regis_$j"];
			$id_caja= $_GET["id_caja_$j"];
			$id_cajero= $_GET["id_cajero_$j"];
			$fecha_regis= $_GET["fecha_regis_$j"];
			$importe_regis= $_GET["importe_regis_$j"];
			$tipo_regis= $_GET["tipo_registro_$j"];
			$id_cuenta_bancaria= $_GET["id_cuenta_bancaria_$j"];
			$estado_regis= $_GET["estado_regis_$j"];
			$codigo_repo= $_GET["codigo_repo_$j"];
			$fecha_ini= $_GET["fecha_ini_$j"];
			$fecha_fin= $_GET["fecha_fin_$j"];
		}
		else
		{
			$id_caja_regis=$_POST["id_caja_regis_$j"];
			$id_caja=$_POST["id_caja_$j"];
			$id_cajero=$_POST["id_cajero_$j"];
			$fecha_regis=$_POST["fecha_regis_$j"];
			$importe_regis=$_POST["importe_regis_$j"];
			$tipo_regis=$_POST["tipo_registro_$j"];			
			$id_cuenta_bancaria= $_POST["id_cuenta_bancaria_$j"];
			$estado_regis=$_POST["estado_regis_$j"];
			$codigo_repo= $_POST["codigo_repo_$j"];
			$fecha_ini= $_POST["fecha_ini_$j"];
			$fecha_fin= $_POST["fecha_fin_$j"];
		}
 //echo $id_caja_regis;exit;

		if ($id_caja_regis == "undefined" || $id_caja_regis == "")
		{
			////////////////////Inserción/////////////////////
 
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarReposicionCaja("insert",$id_caja_regis,$id_caja,$id_cajero,$fecha_regis,$importe_regis);

			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}
//echo "InsertarReposicionCaja";exit();
			//Validación satisfactoria, se ejecuta la inserción en la tabla tts_caja_regis
			
			$res = $Custom -> InsertarReposicionCaja($id_caja_regis,$id_caja,$id_cajero,$fecha_regis,$importe_regis,$nro_documento ,$fecha_ini,$fecha_fin,$codigo_repo);

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
			 
			if ($id_cuenta_bancaria != 'NULL'){
				//echo $id_cuenta_bancaria."  nulllll ";exit;
				//echo 'id cuanta bancaria if:'.$id_caja_regis;exit;
				//Validación de datos (del lado del servidor)
				$res = $Custom->ValidarReposicionCaja("update",$id_caja_regis,$id_caja,$id_cajero,$fecha_regis,$importe_regis);
	
				if(!$res)
				{
					//Error de validación
					$resp = new cls_manejo_mensajes(true, "406");
					$resp->mensaje_error = $Custom->salida[1];
					$resp->origen = $Custom->salida[2];
					$resp->proc = $Custom->salida[3];
					$resp->nivel = $Custom->salida[4];
					echo $resp->get_mensaje();
					exit;
				}
				
				$id_cheque = $id_cuenta_bancaria;
				//$importe_regis = '0.01';
				
				$res = $Custom->ModificarReposicionCaja($id_caja_regis,$id_caja,$id_cajero,$tipo_regis,$fecha_regis,$importe_regis,$id_cheque,$estado_regis,$nro_documento ,$fecha_ini,$fecha_fin,$codigo_repo);
	
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
			else{
			 	//echo 'id cuanta bancaria else:'.$id_caja;exit;
				//Validación de datos (del lado del servidor)
				$res = $Custom->ValidarReposicionCaja("update",$id_caja_regis,$id_caja,$id_cajero,$fecha_regis,$importe_regis);
	
				if(!$res)
				{
					//Error de validación
					$resp = new cls_manejo_mensajes(true, "406");
					$resp->mensaje_error = $Custom->salida[1];
					$resp->origen = $Custom->salida[2];
					$resp->proc = $Custom->salida[3];
					$resp->nivel = $Custom->salida[4];
					echo $resp->get_mensaje();
					exit;
				}
				
				$res = $Custom->ModificarReposicionCaja($id_caja_regis,$id_caja,$id_cajero,$tipo_regis,$fecha_regis,$importe_regis,$id_cheque,$estado_regis);
	
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
		}//end else modificacion

	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_caja_regis";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarReposicionCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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