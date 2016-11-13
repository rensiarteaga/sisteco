<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarTipoNodoEmpleado.php
Propósito:				Permite insertar y modificar datos en la tabla tfl_tipo_nodo_empleado
Tabla:					tfl_tipo_nodo_empleado
Parámetros:				$id_tipo_nodo_empleado
						$id_tipo_nodo
						$id_empleado
					    $criterio_condicion
						$prioridad
						$seguimiento
						

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2011-01-05 10:00:40
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloFlujo.php");

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = "ActionGuardarTipoNodoEmpleao.php";

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
			$id_tipo_nodo_empleado=$_GET["id_tipo_nodo_empleado_$j"];
			$id_tipo_nodo=$_GET["id_tipo_nodo_$j"];
			$id_empleado= $_GET["id_empleado_$j"];
			$criterio_condicion=$_GET["criterio_condicion_$j"];
			$prioridad = $_GET["prioridad_$j"];
			$seguimiento= $_GET["seguimiento_$j"];
			$id_usuario_reg_reg= $_GET["id_usuario_reg_$j"];
			$fecha_reg= $_GET["fecha_reg_$j"];
			$estado_reg= $_GET["estado_reg_$j"];
		}
		else
		{
			$id_tipo_nodo_empleado=$_POST["id_tipo_nodo_empleado_$j"];
			$id_tipo_nodo=$_POST["id_tipo_nodo_$j"];
			$id_empleado= $_POST["id_empleado_$j"];
			$criterio_condicion=$_POST["criterio_condicion_$j"];
			$prioridad = $_POST["prioridad_$j"];
			$seguimiento= $_POST["seguimiento_$j"];
			$id_usuario_reg_reg= $_POST["id_usuario_reg_$j"];
			$fecha_reg= $_POST["fecha_reg_$j"];
			$estado_reg= $_POST["estado_reg_$j"];
		}
		
		
		
		
		if ($id_tipo_nodo_empleado == "undefined" || $id_tipo_nodo_empleado == "")
		{
			////////////////////Inserción/////////////////////
             
			//Validación de datos (del lado del servidor)
			//$res = $Custom->ValidarTipoProceso("insert",$id_tipo_proceso,$codigo,$nombre_proceso,$fecha_reg,$estado_reg);
			$res = $Custom->ValidarTipoNodoEmpleado("insert",$id_tipo_nodo_empleado,$id_tipo_nodo,$id_empleado,$criterio_condicion,$seguimiento,$prioridad);
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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tfl_tipo_nodo_empleado
			$res = $Custom -> InsertarTipoNodoEmpleado($id_tipo_nodo,$id_empleado,$criterio_condicion,$seguimiento,$prioridad);

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
			
			$res = $Custom->ValidarTipoNodoEmpleado("update",$id_tipo_nodo_empleado,$id_tipo_nodo,$id_empleado,$criterio_condicion,$seguimiento,$prioridad);
			

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

			$res = $Custom->ModificarTipoNodoEmpleado($id_tipo_nodo_empleado,$id_tipo_nodo,$id_empleado,$criterio_condicion,$seguimiento,$prioridad);
			
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
	if($sortcol == "") $sortcol = "id_tipo_nodo_empleado";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarTipoNodoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
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