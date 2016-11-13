<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarDevengadoDetalle.php
Prop�sito:				Permite insertar y modificar datos en la tabla tts_devengado_detalle
Tabla:					tts_tts_devengado_detalle
Par�metros:				$id_devengado_detalle
						$id_devengado
						$id_fina_regi_prog_proy_acti
						$id_unidad_organizacional
						$porcentaje_devengado
						$importe_devengado

Valores de Retorno:    	N�mero de registros guardados
Fecha de Creaci�n:		2008-10-21 15:43:29
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloTesoreria.php");

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = "ActionGuardarDevengadoDetalle.php";

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
		{
			$id_devengado_detalle= $_GET["id_devengado_detalle_$j"];
			$id_devengado= $_GET["id_devengado_$j"];
			$id_fina_regi_prog_proy_acti= $_GET["id_fina_regi_prog_proy_acti_$j"];
			$id_unidad_organizacional= $_GET["id_unidad_organizacional_$j"];
			$porcentaje_devengado= $_GET["porcentaje_devengado_$j"];
			$importe_devengado= $_GET["importe_devengado_$j"];
			$id_financiador= $_GET["txt_id_financiador_$j"];
			$id_regional	= $_GET["txt_id_regional_$j"];
			$id_programa	= $_GET["txt_id_programa_$j"];
			$id_proyecto	= $_GET["txt_id_proyecto_$j"];
			$id_actividad	= $_GET["txt_id_actividad_$j"];
			$id_presupuesto	= $_GET["id_presupuesto_$j"];
			$porc_monto	= $_GET["porc_monto_$j"];
			$id_usuario	= $_GET["id_usuario_$j"];
		}
		else
		{
			$id_devengado_detalle=$_POST["id_devengado_detalle_$j"];
			$id_devengado=$_POST["id_devengado_$j"];
			$id_fina_regi_prog_proy_acti=$_POST["id_fina_regi_prog_proy_acti_$j"];
			$id_unidad_organizacional=$_POST["id_unidad_organizacional_$j"];
			$porcentaje_devengado=$_POST["porcentaje_devengado_$j"];
			$importe_devengado=$_POST["importe_devengado_$j"];
			$id_financiador= $_POST["txt_id_financiador_$j"];
			$id_regional	= $_POST["txt_id_regional_$j"];
			$id_programa	= $_POST["txt_id_programa_$j"];
			$id_proyecto	= $_POST["txt_id_proyecto_$j"];
			$id_actividad	= $_POST["txt_id_actividad_$j"];
			$id_presupuesto	= $_POST["id_presupuesto_$j"];
			$porc_monto	= $_POST["porc_monto_$j"];
			$id_usuario	= $_POST["id_usuario_$j"];
		}
		
		if($id_presupuesto){$id_financiador=$id_presupuesto;$id_regional=$id_presupuesto;$id_programa=$id_presupuesto; $id_actividad=$id_presupuesto;$id_proyecto=$id_presupuesto;$id_unidad_organizacional=$id_presupuesto;}
		
		if ($id_devengado_detalle == "undefined" || $id_devengado_detalle == "")
		{
			////////////////////Inserci�n/////////////////////

			//Validaci�n de datos (del lado del servidor)
			$res = $Custom->ValidarDevengadoDetalle("insert",$id_devengado_detalle, $id_devengado,$id_presupuesto,$id_unidad_organizacional,$porcentaje_devengado,$importe_devengado,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$porc_monto);

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

			//Validaci�n satisfactoria, se ejecuta la inserci�n en la tabla tts_devengado_detalle
			$res = $Custom -> InsertarDevengadoDetalle($id_devengado_detalle, $id_devengado,$id_presupuesto,$id_unidad_organizacional,$porcentaje_devengado,$importe_devengado,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_usuario);

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
			$res = $Custom->ValidarDevengadoDetalle("update",$id_devengado_detalle, $id_devengado,$id_presupuesto,$id_unidad_organizacional,$porcentaje_devengado,$importe_devengado,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$porc_monto);

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

			$res = $Custom->ModificarDevengadoDetalle($id_devengado_detalle, $id_devengado,$id_presupuesto,$id_unidad_organizacional,$porcentaje_devengado,$importe_devengado,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_usuario);

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
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Par�metros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_devengado_detalle";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "DEVENG.id_devengado=''$m_id_devengado''";

	$res = $Custom->ContarDevengadoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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