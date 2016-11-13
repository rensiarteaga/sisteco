<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCompensacion.php
Propósito:				Permite insertar y modificar datos en la tabla tkp_compensacion
Tabla:					tkp_compensacion
Parámetros:				$tkp_id_compensacion, fecha_ini,fecha_fin,compensado,id_empleado,total_dias, fecha_reg
						

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2011-05-11
Versión:				1.0.0
Autor:					Fernando Prudencio Cardona
**********************************************************
*/
session_start();
include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = "ActionGuardarCompensacion.php";

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
			$id_compensacion=$_GET["id_compensacion_$j"];
			$fecha_inicio=$_GET["fecha_inicio_$j"];
			$fecha_fin=$_GET["fecha_fin_$j"];
			$compensado= $_GET["compensado_$j"];
			$id_empleado= $_GET["id_empleado_$j"];
			$total_dias=$_GET["total_dias_$j"];
				
		}
		else
		{
			$id_compensacion=$_POST["id_compensacion_$j"];
			$fecha_inicio=$_POST["fecha_inicio_$j"];
			$fecha_fin=$_POST["fecha_fin_$j"];
			$compensado= $_POST["compensado_$j"];
			$id_empleado= $_POST["id_empleado_$j"];
			$total_dias=$_POST["total_dias_$j"];
			
		}
	   
               
		if ($id_compensacion == "undefined" || $id_compensacion== "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarCompensacion("insert",$id_compensacion,$fecha_inicio,$fecha_fin,$compensado,$id_empleado,$total_dias);

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
			
			//Validación satisfactoria, se ejecuta la inserción en la tabla tsg_persona y tkp_relacion_familiar
			$res = $Custom -> InsertarCompensacion($id_compensacion,$fecha_inicio,$fecha_fin,$compensado,$id_empleado,$total_dias);
			
				if(!$res){
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
			$res = $Custom->ValidarCompensacion("update",$id_compensacion,$fecha_inicio,$fecha_fin,$compensado,$id_empleado,$total_dias);

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

			$res = $Custom->ModificarCompensacion($id_compensacion,$fecha_inicio,$fecha_fin,$compensado,$id_empleado,$total_dias);

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
	if($sortcol == "") $sortcol = "COMPEN.fecha_inicio";
	if($sortdir == "") $sortdir = "desc";
	if($criterio_filtro == "") $criterio_filtro = "EMPLEA.id_empleado=$m_id_empleado";

	$res = $Custom->ContarCompensacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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