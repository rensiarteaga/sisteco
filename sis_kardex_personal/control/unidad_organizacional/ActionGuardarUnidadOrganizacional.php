<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarUnidadOrganizacional.php
Propósito:				Permite insertar y modificar datos en la tabla tkp_unidad_organizacional
Tabla:					tkp_tkp_unidad_organizacional
Parámetros:				$hidden_id_unidad_organizacional
						$txt_nombre_unidad
						$txt_nombre_cargo
						$txt_centro
						$txt_cargo_individual
						$txt_descripcion
						$txt_fecha_reg
						$txt_id_nivel_organizacional
						$txt_estado_reg

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-12 09:24:17
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloKardex_personal.php");

$Custom = new cls_CustomDBKardex_personal();
$nombre_archivo = "ActionGuardarUnidadOrganizacional.php";

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
			$hidden_id_unidad_organizacional= $_GET["hidden_id_unidad_organizacional_$j"];
			$txt_nombre_unidad= $_GET["txt_nombre_unidad_$j"];
			$txt_nombre_cargo= $_GET["txt_nombre_cargo_$j"];
			$txt_centro= $_GET["txt_centro_$j"];
			$txt_cargo_individual= $_GET["txt_cargo_individual_$j"];
			$txt_descripcion= $_GET["txt_descripcion_$j"];
			$txt_fecha_reg= $_GET["txt_fecha_reg_$j"];
			$txt_id_nivel_organizacional= $_GET["txt_id_nivel_organizacional_$j"];
			$txt_estado_reg= $_GET["txt_estado_reg_$j"];

		}
		else
		{
			$hidden_id_unidad_organizacional=$_POST["hidden_id_unidad_organizacional_$j"];
			$txt_nombre_unidad=$_POST["txt_nombre_unidad_$j"];
			$txt_nombre_cargo=$_POST["txt_nombre_cargo_$j"];
			$txt_centro=$_POST["txt_centro_$j"];
			$txt_cargo_individual=$_POST["txt_cargo_individual_$j"];
			$txt_descripcion=$_POST["txt_descripcion_$j"];
			$txt_fecha_reg=$_POST["txt_fecha_reg_$j"];
			$txt_id_nivel_organizacional=$_POST["txt_id_nivel_organizacional_$j"];
			$txt_estado_reg=$_POST["txt_estado_reg_$j"];

		}

		if ($hidden_id_unidad_organizacional == "undefined" || $hidden_id_unidad_organizacional == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarUnidadOrganizacional("insert",$hidden_id_unidad_organizacional, $txt_nombre_unidad,$txt_nombre_cargo,$txt_centro,$txt_cargo_individual,$txt_descripcion,$txt_fecha_reg,$txt_id_nivel_organizacional,$txt_estado_reg);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tkp_unidad_organizacional
			$res = $Custom -> InsertarUnidadOrganizacional($hidden_id_unidad_organizacional, $txt_nombre_unidad, $txt_nombre_cargo, $txt_centro, $txt_cargo_individual, $txt_descripcion, $txt_fecha_reg, $txt_id_nivel_organizacional, $txt_estado_reg);

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
			$res = $Custom->ValidarUnidadOrganizacional("update",$hidden_id_unidad_organizacional, $txt_nombre_unidad, $txt_nombre_cargo, $txt_centro, $txt_cargo_individual, $txt_descripcion, $txt_fecha_reg, $txt_id_nivel_organizacional, $txt_estado_reg);

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

			$res = $Custom->ModificarUnidadOrganizacional($hidden_id_unidad_organizacional, $txt_nombre_unidad, $txt_nombre_cargo, $txt_centro, $txt_cargo_individual, $txt_descripcion, $txt_fecha_reg, $txt_id_nivel_organizacional, $txt_estado_reg);

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
	if($sortcol == "") $sortcol = "id_unidad_organizacional";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarUnidadOrganizacional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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