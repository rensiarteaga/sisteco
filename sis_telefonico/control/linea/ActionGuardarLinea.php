<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarLinea.php
Propósito:				Permite insertar y modificar datos en la tabla tst_linea
Tabla:					tst_tst_linea
Parámetros:				$hidden_id_linea
						$txt_empresa
						$txt_puerto_linea
						$txt_numero_telefono
						$txt_id_tipo_llamada

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-01-18 19:44:10
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloSistemaTelefonico.php");

$Custom = new cls_CustomDBSistemaTelefonico();
$nombre_archivo = "ActionGuardarLinea.php";

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
			$hidden_id_linea= $_GET["hidden_id_linea_$j"];
			$txt_empresa= $_GET["txt_empresa_$j"];
			$txt_puerto_linea= $_GET["txt_puerto_linea_$j"];
			$txt_numero_telefono= $_GET["txt_numero_telefono_$j"];
			$txt_id_tipo_llamada= $_GET["txt_id_tipo_llamada_$j"];
			$txt_costo_segundo= $_GET["txt_costo_segundo_$j"];
			$txt_tiempo_espera= $_GET["txt_tiempo_espera_$j"];
			$txt_observaciones= $_GET["txt_observaciones_$j"];
			$estado_reg	=$_GET["estado_reg_$j"];
			$fecha_ini=$_GET["fecha_ini_$j"];
			$fecha_fin=$_GET["fecha_fin_$j"];
			
			$sim_card=$_GET["sim_card_$j"];
		}
		else
		{
			$hidden_id_linea=$_POST["hidden_id_linea_$j"];
			$txt_empresa=$_POST["txt_empresa_$j"];
			$txt_puerto_linea=$_POST["txt_puerto_linea_$j"];
			$txt_numero_telefono=$_POST["txt_numero_telefono_$j"];
			$txt_id_tipo_llamada=$_POST["txt_id_tipo_llamada_$j"];
            $txt_costo_segundo= $_POST["txt_costo_segundo_$j"];
            $txt_tiempo_espera= $_POST["txt_tiempo_espera_$j"];
			$txt_observaciones= $_POST["txt_observaciones_$j"];
			$estado_reg	=$_POST["estado_reg_$j"];
			$fecha_ini=$_POST["fecha_ini_$j"];
			$fecha_fin=$_POST["fecha_fin_$j"];
			
			$sim_card=$_POST["sim_card_$j"];
		}

		if($txt_id_tipo_llamada =='undefined'|| $txt_id_tipo_llamada == ""){
			$txt_id_tipo_llamada=2;
		}
		
		if ($hidden_id_linea == "undefined" || $hidden_id_linea == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarLinea("insert",$hidden_id_linea, $txt_empresa,$txt_puerto_linea,$txt_numero_telefono,$txt_id_tipo_llamada,$txt_costo_segundo,$txt_tiempo_espera,$txt_observaciones);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tst_linea
			$res = $Custom -> InsertarLinea($hidden_id_linea, $txt_empresa, $txt_puerto_linea, $txt_numero_telefono, $txt_id_tipo_llamada,$txt_costo_segundo,$txt_tiempo_espera,$txt_observaciones,$estado_reg,$fecha_ini,$fecha_fin
					,$sim_card
					);

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
			
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarLinea("update",$hidden_id_linea, $txt_empresa, $txt_puerto_linea, $txt_numero_telefono, $txt_id_tipo_llamada,$txt_costo_segundo,$txt_tiempo_espera,$txt_observaciones);

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

			$res = $Custom->ModificarLinea($hidden_id_linea, $txt_empresa, $txt_puerto_linea, $txt_numero_telefono, $txt_id_tipo_llamada,$txt_costo_segundo,$txt_tiempo_espera,$txt_observaciones,$estado_reg,$fecha_ini,$fecha_fin
					,$sim_card
					);

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
	if($sortcol == "") $sortcol = "id_linea";
	if($sortdir == "") $sortdir = "asc";
	
	if(isset($txt_id_tipo_llamada) && $txt_id_tipo_llamada>0){ 
		if($criterio_filtro == "") $criterio_filtro = "TIPLLA.id_tipo_llamada=''$txt_id_tipo_llamada''";
	}
	$res = $Custom->ContarLinea($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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