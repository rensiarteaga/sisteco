<?php
/**
**********************************************************
Nombre de archivo:	    ActionSaveActivoFijoEmpleado.php
Prop�sito:				Permite insertar y modificar Activo_fijo_empleado
Tabla:					taf_activo_fijo_empleado
Par�metros:				$hidden_id_activo_fijo_empleado	--> id de activo_fijo_empleado
$txt_fecha_reg
$txt_estado
$txt_id_activo_fijo
$txt_id_empleado

Valores de Retorno:    	N�mero de registros
Fecha de Creaci�n:		06 - 06 - 07
Versi�n:				1.0.0
Autor:					Rodrigo Chumacero M.
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionSaveActivoFijoEmpleado.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	//Verifica si los datos vienen por POST o GET
	if (sizeof($_GET) > 0)
	{
		$get = true;
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
		$cont =  $_POST['cantidad_ids'];
		
		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "No existen datos para almacenar.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = 'NIVEL = 4';
		echo $resp->get_mensaje();
		exit;
	}

	//Envia al Custom la bandera que indica si se decodificar� o no
	$Custom->decodificar = $decodificar;
	
	//Realiza el bucle por todos los ids mandados
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$hidden_id_activo_fijo_empleado = $_GET["hidden_id_activo_fijo_empleado_$j"];
			$txt_fecha_reg = $_GET["txt_fecha_reg_$j"];
			$txt_estado = $_GET["txt_estado_$j"];
			$hidden_id_activo_fijo = $_GET["hidden_id_activo_fijo_$j"];
			$hidden_id_empleado = $_GET["hidden_id_empleado_$j"];
			$txt_fecha_asig = $_GET["txt_fecha_asig_$j"];
			

			
		}
		else
		{
			
			$hidden_id_activo_fijo_empleado = $_POST["hidden_id_activo_fijo_empleado_$j"];
			$txt_fecha_reg = $_POST["txt_fecha_reg_$j"];
			$txt_estado = $_POST["txt_estado_$j"];
			$hidden_id_activo_fijo = $_POST["hidden_id_activo_fijo_$j"];
			$hidden_id_empleado = $_POST["hidden_id_empleado_$j"];
			$txt_fecha_asig = $_POST["txt_fecha_asig_$j"];
			
			
			
			
		}

		if ($hidden_id_activo_fijo_empleado == "undefined" || $hidden_id_activo_fijo_empleado == "")
		{
			////////////////////Inserci�n/////////////////////
			
			//Validaci�n de datos (del lado del servidor)
			$res = $Custom->ValidarActivoFijoEmpleado("insert", $hidden_id_activo_fijo_empleado, $txt_fecha_reg, $txt_estado, $hidden_id_activo_fijo, $hidden_id_empleado, $txt_fecha_asig);
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

			//Validaci�n satisfactoria, se ejecuta la inserci�n de la unidad constructiva
			$res = $Custom -> CrearActivoFijoEmpleado($hidden_id_activo_fijo_empleado, $txt_fecha_reg, $txt_estado, $hidden_id_activo_fijo, $hidden_id_empleado, $txt_fecha_asig);
		
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
			$res = $Custom->ValidarActivoFijoEmpleado("update", $hidden_id_activo_fijo_empleado, $txt_fecha_reg, $txt_estado, $hidden_id_activo_fijo, $hidden_id_empleado, $txt_fecha_asig);
			if(!$res)
			{
				//Error de validaci�n
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel =$Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			$res = $Custom -> ModificarActivoFijoEmpleado($hidden_id_activo_fijo_empleado, $txt_fecha_reg, $txt_estado, $hidden_id_activo_fijo, $hidden_id_empleado, $txt_fecha_asig);
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
	if($cont > 1) $mensaje_exito = 'Se guardaron todos los datos.';
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Par�metros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'estados';
	if($sortdir == "") $sortdir = 'asc';
	//if($criterio_filtro == "") $criterio_filtro = '0=0';
	if($criterio_filtro == "") $criterio_filtro = "af.id_activo_fijo = $hidden_id_activo_fijo";

	$res = $Custom->ContarListaActivoFijoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo('TotalCount', $total_registros);
	$resp->add_nodo('mensaje', $mensaje_exito);
	$resp->add_nodo('tiempo_resp', '200');
	echo $resp->get_mensaje();
	exit;
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 1';
	echo $resp->get_mensaje();
	exit;
}
?>