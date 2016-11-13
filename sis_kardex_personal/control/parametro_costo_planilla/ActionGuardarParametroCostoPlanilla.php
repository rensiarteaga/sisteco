<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarParametroCostoPlanilla.php
Propósito:				Permite insertar y modificar datos en la tabla tkp_parametro_costo_planilla
Tabla:					tkp_tkp_parametro_costo_planilla
Parámetros:				$id_parametro_costo_planilla
						$id_gestion

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2010-10-01 09:27:55
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = "ActionGuardarParametroCostoPlanilla.php";

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
			$id_parametro_costo_planilla= $_GET["id_parametro_costo_planilla_$j"];
			$id_empleado_planilla=$_GET["id_empleado_planilla"];
			$id_gestion=$_GET["id_gestion"];
			$id_presupuesto=$_GET["id_presupuesto_$j"];
			$id_orden_trabajo=$_GET["id_orden_trabajo_$j"];
			$id_resumen_horario_mes=$_GET["id_resumen_horario_mes"];
			$horas_normales=$_GET["horas_normales_$j"];
			$horas_extra=$_GET["horas_extra_$j"];
			$horas_nocturnas=$_GET["horas_nocturnas_$j"];
			$horas_disp=$_GET["horas_disp_$j"];
		}
		else
		{
			$id_parametro_costo_planilla= $_POST["id_parametro_costo_planilla_$j"];
			$id_empleado_planilla=$_POST["id_empleado_planilla"];
			$id_gestion=$_POST["id_gestion"];
			$id_presupuesto=$_POST["id_presupuesto_$j"];
			$id_orden_trabajo=$_POST["id_orden_trabajo_$j"];
			$id_resumen_horario_mes=$_POST["id_resumen_horario_mes"];
			$horas_normales=$_POST["horas_normales_$j"];
			$horas_extra=$_POST["horas_extra_$j"];
			$horas_nocturnas=$_POST["horas_nocturnas_$j"];
			$horas_disp=$_POST["horas_disp_$j"];
		}
       // echo $id_parametro_costo_planilla."<br>".$id_empleado_planilla."<br>".$id_gestion."<br>".$id_presupuesto."<br>".$id_orden_trabajo."<br>".$id_cuenta."<br>".$id_auxiliar."<br>".$id_resumen_horario_mes."<br>".$horas_normales."<br>".$horas_extra."<br>".$horas_nocturnas."<br>".$horas_disp."<br>".$costo_horas_normales."<br>".$costo_horas_extra."<br>".$costo_horas_nocturnas."<br>".$costo_horas_disp;
        //exit;
		if ($id_parametro_costo_planilla == "undefined" || $id_parametro_costo_planilla == "")
		{
			////////////////////Inserción/////////////////////

			
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarParametroCostoPlanilla("insert",$id_parametro_costo_planilla,$id_empleado_planilla,$id_gestion,$id_presupuesto,$id_orden_trabajo,$id_resumen_horario_mes,$horas_normales);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tkp_parametro_costo_planilla
			$res = $Custom -> InsertarParametroCostoPlanilla($id_parametro_costo_planilla,$id_empleado_planilla,$id_gestion,$id_presupuesto,$id_orden_trabajo,$id_resumen_horario_mes,$horas_normales,$horas_extra,$horas_nocturnas,$horas_disp);

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
			$res = $Custom->ValidarParametroCostoPlanilla("update",$id_parametro_costo_planilla,$id_empleado_planilla,$id_gestion,$id_presupuesto,$id_orden_trabajo,$id_resumen_horario_mes,$horas_normales);

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

			$res = $Custom->ModificarParametroCostoPlanilla($id_parametro_costo_planilla,$id_empleado_planilla,$id_gestion,$id_presupuesto,$id_orden_trabajo,$id_resumen_horario_mes,$horas_normales,$horas_extra,$horas_nocturnas,$horas_disp);

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
	if($sortcol == "") $sortcol = "id_parametro_costo_planilla";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro="  PACOPLA.id_empleado_planilla=$id_empleado_planilla";

	$res = $Custom->ContarProrrateoHoras($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
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