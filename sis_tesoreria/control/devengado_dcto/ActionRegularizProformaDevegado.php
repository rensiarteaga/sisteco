<?php
/**
**********************************************************
Nombre de archivo:	    ActionRegularizProformaDevegado.php
Propósito:				Permite insertar y modificar datos en la tabla tts_devengado_detalle
Tabla:					tts_tts_devengado_detalle
Parámetros:				$id_devengado_detalle
						$id_devengado
						$id_fina_regi_prog_proy_acti
						$id_unidad_organizacional
						$porcentaje_devengado
						$importe_devengado

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-10-21 15:43:29
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloTesoreria.php");

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = "ActionRegularizProformaDevegado.php";

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

	if ($get)
	{
		$id_devengado_dcto= $_GET["id_devengado_dcto"];
		$tipo_documento= $_GET["tipo_documento"];
		$nro_documento= $_GET["nro_documento"];
		$fecha_documento= $_GET["fecha_documento"];
		$razon_social	= $_GET["razon_social"];
		$nro_nit	= $_GET["nro_nit"];
		$nro_autorizacion	= $_GET["nro_autorizacion"];
		$codigo_control	= $_GET["codigo_control"];
		$importe= $_GET["importe_avance"];
		$id_moneda= $_GET["id_moneda"];
	}
	else
	{
		$id_devengado_dcto= $_POST["id_devengado_dcto"];
		$tipo_documento= $_POST["tipo_documento"];
		$nro_documento= $_POST["nro_documento"];
		$fecha_documento= $_POST["fecha_documento"];
		$razon_social	= $_POST["razon_social"];
		$nro_nit	= $_POST["nro_nit"];
		$nro_autorizacion	= $_POST["nro_autorizacion"];
		$codigo_control	= $_POST["codigo_control"];
		$importe= $_POST["importe_avance"];
		$id_moneda= $_POST["id_moneda"];
	}


	if ($id_devengado_dcto == "undefined" || $id_devengado_dcto == "")
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para la regularización.";
		$resp->origen = "ORIGEN = ";
		$resp->proc = "PROC = ";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit;
	}
	else
	{	///////////////////////Modificación////////////////////



		$res = $Custom->RegularizarProformasDevengado($id_devengado_dcto,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$importe,$id_moneda);

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


	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_devengado_detalle";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "DEVENG.id_devengado=1";//$m_id_devengado''";

	$res = $Custom->ContarDevengadoDcto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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