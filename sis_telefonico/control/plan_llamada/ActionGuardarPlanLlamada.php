<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarPlanLlamada.php
Prop�sito:				Permite insertar y modificar datos en la tabla tst_plan_llamada
Tabla:					tst_tst_plan_llamada
Par�metros:				$hidden_id_plan_llamada
						$txt_empresa
						$txt_puerto_plan_llamada
						$txt_numero_telefono
						$txt_id_tipo_llamada

Valores de Retorno:    	N�mero de registros guardados
Fecha de Creaci�n:		2008-01-18 19:44:10
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloSistemaTelefonico.php");

$Custom = new cls_CustomDBSistemaTelefonico();
$nombre_archivo = "ActionGuardarPlanLlamada.php";

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
		
		//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
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
	
	//Envia al Custom la bandera que indica si se decodificar� o no
	$Custom->decodificar = $decodificar;

	//Realiza el bucle por todos los ids mandados
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{/*  
		
		 nombre,
                            PLALLAM.descripcion,
                            PLALLAM.monto_llamada,
                            PLALLAM.monto_datos,
                            PLALLAM.tarifa_win, 
                            PLALLAM.estado_reg,
                            PLALLAM.fecha_reg,
                            PLALLAM.usuario_reg
		 */
			$id_plan_llamada= $_GET["id_plan_llamada_$j"];
			$nombre=$_GET["nombre_$j"];
			$descripcion=$_GET["descripcion_$j"];
			$monto_llamada=$_GET["monto_llamada_$j"];
			$monto_datos=$_GET["monto_datos_$j"];
			$tarifa_win=$_GET["tarifa_win_$j"];
			$estado_reg=$_GET["estado_reg_$j"];
			$fecha_ini=$_GET["fecha_ini_$j"];
			$fecha_fin=$_GET["fecha_fin_$j"];

		}
		else
		{
			$id_plan_llamada= $_POST["id_plan_llamada_$j"];
			$nombre=$_POST["nombre_$j"];
			$descripcion=$_POST["descripcion_$j"];
			$monto_llamada=$_POST["monto_llamada_$j"];
			$monto_datos=$_POST["monto_datos_$j"];
			$tarifa_win=$_POST["tarifa_win_$j"];
			$estado_reg=$_POST["estado_reg_$j"];
			$fecha_ini=$_POST["fecha_ini_$j"];
			$fecha_fin=$_POST["fecha_fin_$j"];
		}

		if ($id_plan_llamada == "undefined" || $id_plan_llamada == "")
		{
			////////////////////Inserci�n/////////////////////

			//Validaci�n de datos (del lado del servidor)
			$res = $Custom->ValidarPlanLlamada("insert",$id_plan_llamada, $nombre,$descripcion,$monto_llamada,$monto_datos,$tarifa_win);

			if(!$res)
			{
				//Error de validaci�n
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			//Validaci�n satisfactoria, se ejecuta la inserci�n en la tabla tst_plan_llamada
			$res = $Custom -> InsertarPlanLlamada($id_plan_llamada, $nombre,$descripcion,$monto_llamada,$monto_datos,$tarifa_win, $fecha_ini,$fecha_fin);

			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] . " (iteraci�n $cont)";
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		}
		else
		{	///////////////////////Modificaci�n////////////////////
			
			//Validaci�n de datos (del lado del servidor)
			$res = $Custom->ValidarPlanLlamada("update",$id_plan_llamada, $nombre,$descripcion,$monto_llamada,$monto_datos,$tarifa_win);

			if(!$res)
			{
				//Error de validaci�n
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}
//echo 'modelo: '.$modelo.'marca: '.$marca.'obs:'.$observaciones; exit;
			$res = $Custom->ModificarPlanLlamada($id_plan_llamada, $nombre,$descripcion,$monto_llamada,$monto_datos,$tarifa_win, $estado_reg, $fecha_ini,$fecha_fin);

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

	//Guarda el mensaje de �xito de la operaci�n realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos de Plan Llamada.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Par�metros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_plan_llamada";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarPlanLlamada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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