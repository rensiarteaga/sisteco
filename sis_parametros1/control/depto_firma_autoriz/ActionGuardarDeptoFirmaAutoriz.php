<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarDeptoFirmaAutoriz.php
Prop�sito:				Permite insertar y modificar datos en la tabla tpm_depto_usuario
Tabla:					tpm_tpm_depto_usuario
Par�metros:				$id_depto_usuario
						$id_depto
						$id_usuario
						$estado

Valores de Retorno:    	N�mero de registros guardados
Fecha de Creaci�n:		2009-01-23 10:58:14
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloParametros.php");

$Custom = new cls_CustomDBParametros();
$nombre_archivo = "ActionGuardarDeptoFirmaAutoriz.php";

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
			$id_depto_firma_autoriz= $_GET["id_depto_firma_autoriz_$j"];
			$importe_min= $_GET["importe_min_$j"];
			$importe_max= $_GET["importe_max_$j"];
			$prioridad= $_GET["prioridad_$j"];
			$id_depto=$_GET["id_depto_$j"];
			$id_documento=$_GET["id_documento_$j"];
			$id_empleado=$_GET["id_empleado_$j"];
			$id_moneda=$_GET["id_moneda_$j"];
			$estado_reg= $_GET["estado_reg_$j"];
			$fecha_reg=$_GET["fecha_reg_$j"];
			$sw_obliga=$_GET["sw_obliga_$j"];
			$desc_firma=$_GET["desc_firma_$j"];
			
			
		}
		else
		{
			$id_depto_firma_autoriz= $_POST["id_depto_firma_autoriz_$j"];
			$importe_min= $_POST["importe_min_$j"];
			$importe_max= $_POST["importe_max_$j"];
			$prioridad= $_POST["prioridad_$j"];
			$id_depto=$_POST["id_depto_$j"];
			$id_documento=$_POST["id_documento_$j"];
			$id_empleado=$_POST["id_empleado_$j"];
			$id_moneda=$_POST["id_moneda_$j"];
			$estado_reg= $_POST["estado_reg_$j"];
			$fecha_reg=$_POST["fecha_reg_$j"];
			$sw_obliga=$_POST["sw_obliga_$j"];
			$desc_firma=$_POST["desc_firma_$j"];

		}
	if ($id_depto_firma_autoriz == "undefined" || $id_depto_firma_autoriz == "")
		{
			////////////////////Inserci�n/////////////////////
			//Validaci�n satisfactoria, se ejecuta la inserci�n en la tabla tpm_depto_usuario
			$res = $Custom -> InsertarDeptoFirmaAutoriz($importe_min,$importe_max,$prioridad,$id_depto,$id_documento,$id_empleado,$id_moneda,$estado_reg,$sw_obliga,$desc_firma,$fecha_reg);

			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] . " (iteracion $cont)";
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
			
			$res = $Custom->ModificarDeptoFirmaAutoriz($id_depto_firma_autoriz,$importe_min,$importe_max,$prioridad, $id_depto,$id_documento,$id_empleado,$id_moneda,$estado_reg,$sw_obliga,$desc_firma,$fecha_reg);

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
	if($sortcol == "") $sortcol = "id_depto_firma_autoriz";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "DEPTO.id_depto=''$id_depto''";

	$res = $Custom->ContarDeptoFirmaAutoriz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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