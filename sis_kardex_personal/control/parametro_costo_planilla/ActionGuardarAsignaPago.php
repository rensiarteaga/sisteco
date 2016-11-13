<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarAsignaPago.php
Propósito:				Permite insertar y modificar datos en la tabla tkp_empleado_horario
Tabla:					tkp_tkp_empleado_horario
Parámetros:				$hidden_id_nivel_organizacional
						$txt_nombre_nivel
						$txt_numero_nivel
						
Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-12 09:24:17
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = "ActionGuardarAsignaPago.php";

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
			$hidden_id_parametro_costo_planilla= $_GET["hidden_id_parametro_costo_planilla_$j"];
			$hidden_id_empleado= $_GET["hidden_id_empleado_$j"];
			$hidden_id_gestion= $_GET["hidden_id_gestion_$j"];
			$hidden_id_presupuesto= $_GET["hidden_id_presupuesto_$j"];
			$hidden_id_orden_trabajo= $_GET["hidden_id_orden_trabajo_$j"];
			$txt_valor= $_GET["txt_valor_$j"];
			$txt_estado_reg= $_GET["txt_estado_reg_$j"];
		}
		else
		{
			$hidden_id_parametro_costo_planilla= $_POST["hidden_id_parametro_costo_planilla_$j"];
			$hidden_id_empleado= $_POST["hidden_id_empleado_$j"];
			$hidden_id_gestion= $_POST["hidden_id_gestion_$j"];
			$hidden_id_presupuesto= $_POST["hidden_id_presupuesto_$j"];
			$hidden_id_orden_trabajo= $_POST["hidden_id_orden_trabajo_$j"];
			$txt_valor= $_POST["txt_valor_$j"];
			$txt_estado_reg= $_POST["txt_estado_reg_$j"];
		}

		if ($hidden_id_parametro_costo_planilla == "undefined" || $hidden_id_parametro_costo_planilla == "")
		{
			////////////////////Inserción/////////////////////
		//Validación satisfactoria, se ejecuta la inserción en la tabla tkp_nivel_organizacional
			$res = $Custom -> InsertarAsignaPago($hidden_id_parametro_costo_planilla, $hidden_id_empleado,$hidden_id_gestion,$hidden_id_presupuesto,$txt_valor,$txt_estado_reg,$hidden_id_orden_trabajo);

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
			$res = $Custom->ModificarAsignaPago($hidden_id_parametro_costo_planilla, $hidden_id_empleado,$hidden_id_gestion,$hidden_id_presupuesto,$txt_valor,$txt_estado_reg,$hidden_id_orden_trabajo);

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
	if($sortcol == "") $sortcol = "PACOPLA.fecha_reg";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "PACOPLA.id_empleado=''$m_id_empleado''";

	$res = $Custom->ContarListaAsignaPago($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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