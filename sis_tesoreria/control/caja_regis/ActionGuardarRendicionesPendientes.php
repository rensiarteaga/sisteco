<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarRendiciones.php
Propósito:				Permite insertar y modificar datos en la tabla tts_caja_regis
Tabla:					tts_tts_caja_regis
Parámetros:				$id_caja_regis
						$id_cajero
						$id_fina_regi_prog_proy_acti
						$id_unidad_organizacional
						$id_concepto_ingas
						$importe_regis
						$tipo_documento
						$fecha_documento
						$nro_documento
						$razon_social
						$nro_nit
						$nro_autorizacion
						$codigo_control

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-11-06 19:01:08
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloTesoreria.php");

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = "ActionGuardarRendicionesPendientes.php";

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
			$id_cotizacion= $_GET["id_cotizacion_$j"];
			
			
			$fecha_documento= $_GET["fecha_documento_$j"];
			$nro_documento= $_GET["nro_documento_$j"];
			$razon_social= $_GET["razon_social_$j"];
			$nro_nit= $_GET["nro_nit_$j"];
			$nro_autorizacion= $_GET["nro_autorizacion_$j"];
			$codigo_control= $_GET["codigo_control_$j"];

		}
		else
		{
					
			$fecha_documento=$_POST["fecha_documento_$j"];
			$nro_documento=$_POST["nro_documento_$j"];
			$razon_social=$_POST["razon_social_$j"];
			$nro_nit=$_POST["nro_nit_$j"];
			$nro_autorizacion=$_POST["nro_autorizacion_$j"];
			$codigo_control=$_POST["codigo_control_$j"];
			$id_cotizacion = $_POST["id_cotizacion_$j"];
		}

		
		
			
			

			$res = $Custom->ModificarRendicionesPendientes($fecha_documento,$nro_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$id_cotizacion);

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
		

	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_cotizacion";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarRendiciones($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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