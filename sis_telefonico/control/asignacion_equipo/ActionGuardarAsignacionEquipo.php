<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarPlanLlamada.php
Propósito:				Permite insertar y modificar datos en la tabla tst_plan_llamada
Tabla:					tst_tst_plan_llamada
Parámetros:				$hidden_id_plan_llamada
						$txt_empresa
						$txt_puerto_plan_llamada
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
		{/*  
		
		id_equipo,
                            ASIGEQ.id_plan_llamada,
                            ASIGEQ.id_empleado,
                            ASIGEQ.id_correspondencia,
                            ASIGEQ.estado_reg,
                            ASIGEQ.fecha_reg,
                            ASIGEQ.fecha_ini,
                            ASIGEQ.fecha_fin
                            ASIGEQ.usuario_reg,
                            ASIGEQ.nro_asignacion
		 */
			$id_asignacion_equipo= $_GET["id_asignacion_equipo_$j"];
			$id_equipo=$_GET["id_equipo_$j"];
			$id_plan_llamada=$_GET["id_plan_llamada_$j"];
			$id_empleado=$_GET["id_empleado_$j"];
			$id_correspondencia=$_GET["id_correspondencia_$j"];
			$estado_reg=$_GET["estado_reg_$j"];
			$fecha_reg=$_GET["fecha_reg_$j"];
			$fecha_ini=$_GET["fecha_ini_$j"];
			$fecha_fin=$_GET["fecha_fin_$j"];
			$usuario_reg=$_GET["usuario_reg_$j"];
			$nro_asignacion=$_GET["nro_asignacion_$j"];
			$id_componente=$_GET["id_componente_$j"];
			$id_linea=$_GET["id_linea_$j"];
			$tipo_asignacion=$_GET["tipo_asignacion_$j"];
		}
		else
		{
			$id_asignacion_equipo= $_POST["id_asignacion_equipo_$j"];
			$id_equipo=$_POST["id_equipo_$j"];
			$id_plan_llamada=$_POST["id_plan_llamada_$j"];
			$id_empleado=$_POST["id_empleado_$j"];
			$id_correspondencia=$_POST["id_correspondencia_$j"];
			$estado_reg=$_POST["estado_reg_$j"];
			$fecha_reg=$_POST["fecha_reg_$j"];
			$fecha_ini=$_POST["fecha_ini_$j"];
			$fecha_fin=$_POST["fecha_fin_$j"];
			$usuario_reg=$_POST["usuario_reg_$j"];
			$nro_asignacion=$_POST["nro_asignacion_$j"];
			$id_componente=$_POST["id_componente_$j"];
			$id_linea=$_POST["id_linea_$j"];
			$tipo_asignacion=$_POST["tipo_asignacion_$j"];
		}

		if ($id_asignacion_equipo == "undefined" || $id_asignacion_equipo == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarAsignacionEquipo("insert",$id_asignacion_equipo, $id_equipo,$id_plan_llamada,$id_empleado,$id_correspondencia,$estado_reg,$fecha_reg,$fecha_ini, $fecha_fin);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tst_plan_llamada
			$res = $Custom -> InsertarAsignacionEquipo($id_asignacion_equipo, $id_equipo,$id_plan_llamada,$id_empleado,$id_correspondencia,$estado_reg,$fecha_reg,$fecha_ini, $fecha_fin,$id_componente,$id_linea, $tipo_asignacion);

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
			$res = $Custom->ValidarAsignacionEquipo("update",$id_asignacion_equipo, $id_equipo,$id_plan_llamada,$id_empleado,$id_correspondencia,$estado_reg,$fecha_reg,$fecha_ini, $fecha_fin);

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

			$res = $Custom->ModificarAsignacionEquipo($id_asignacion_equipo, $id_equipo,$id_plan_llamada,$id_empleado,$id_correspondencia,$estado_reg,$fecha_reg,$fecha_ini, $fecha_fin,$id_componente,$id_linea,$tipo_asignacion);

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
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos de Plan Llamada.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
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