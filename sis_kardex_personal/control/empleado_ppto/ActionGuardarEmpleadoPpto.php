<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarEmpleadoPpto.php
Propósito:				Permite insertar y modificar datos en la tabla tkp_empleado_ppto
Tabla:					tkp_tkp_empleado_ppto
Parámetros:				$id_empleado_ppto
						$id_empleado
						$id_planilla
						$id_usuario
						$fecha_reg

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2010-08-23 11:07:48
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = "ActionGuardarEmpleadoPpto.php";

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
			$id_empleado_ppto= $_GET["id_empleado_ppto_$j"];
			$id_empleado= $_GET["id_empleado_$j"];
			$id_presupuesto= $_GET["id_presupuesto_$j"];
			$id_gestion= $_GET["id_gestion_$j"];
			$porcentaje= $_GET["porcentaje_$j"];
			$estado_reg= $_GET["estado_reg_$j"];
			$fecha_ini= $_GET["fecha_ini_$j"];
			$fecha_fin= $_GET["fecha_fin_$j"];
		}
		else
		{
			$id_empleado_ppto= $_POST["id_empleado_ppto_$j"];
			$id_empleado= $_POST["id_empleado_$j"];
			$id_presupuesto= $_POST["id_presupuesto_$j"];
			$id_gestion= $_POST["id_gestion_$j"];
			$porcentaje= $_POST["porcentaje_$j"];
			$estado_reg= $_POST["estado_reg_$j"];
			$fecha_ini= $_POST["fecha_ini_$j"];
			$fecha_fin= $_POST["fecha_fin_$j"];
		}

		if ($id_empleado_ppto == "undefined" || $id_empleado_ppto == "")
		{


				//Validación satisfactoria, se ejecuta la inserción en la tabla tkp_empleado_ppto
				$res = $Custom -> InsertarEmpleadoPpto($id_empleado_ppto,$id_empleado,$id_presupuesto,$id_gestion,$porcentaje,$estado_reg,$fecha_ini,$fecha_fin);
	
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
			
			

			$res = $Custom->ModificarEmpleadoPpto($id_empleado_ppto,$id_empleado,$id_presupuesto,$id_gestion,$porcentaje,$estado_reg,$fecha_ini,$fecha_fin);

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
	if($sortcol == "") $sortcol = "id_empleado_ppto";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "EMPPTO.id_empleado=$id_empleado";

	$res = $Custom->ContarEmpleadoPpto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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