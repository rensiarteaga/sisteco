<?php
/*
**********************************************************
Nombre de archivo:	    ActionGuardarCuenta.php
Propósito:				Permite insertar y modificar 
Tabla:					tct_cuenta
Parámetros:				$hidden_id_cuenta
$txt_descripcion
$txt_flag_comprobante
$txt_tipo_comprobante

Valores de Retorno:    	Número de registros
Fecha de Creación:		03-10-2007
Versión:				1.0.0
Autor:					José A. Mita Huanca
**********************************************************
*/
session_start();
include_once("../LibModeloCobranza.php");

$Custom = new cls_CustomDBcobranza();
$nombre_archivo = "ActionGuardarAuxiliar.php";

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
			$id_sistema= $_GET["id_sistema_$j"];
			$id_sistema_distribucion= $_GET["id_sistema_distribucion_$j"];
			$fecha_separacion= $_GET["fecha_separacion_$j"];
			$id_depto= $_GET["id_depto_$j"];
			$conexion= $_GET["conexion_$j"];
			$nombre_sistema_distribucion= $_GET["nombre_sistema_distribucion_$j"];
			$id_gestion= $_GET["id_gestion_$j"];
		 }
		else
		{
			$id_sistema= $_POST["id_sistema_$j"];
			$id_sistema_distribucion= $_POST["id_sistema_distribucion_$j"];
			$fecha_separacion= $_POST["fecha_separacion_$j"];
			$id_depto= $_POST["id_depto_$j"];
			$conexion= $_POST["conexion_$j"];
			$nombre_sistema_distribucion= $_POST["nombre_sistema_distribucion_$j"];
			$id_gestion= $_POST["id_gestion_$j"];
		}
		
		if ($id_sistema == "undefined" || $id_sistema == "")
		{ 
			//Validación satisfactoria, se ejecuta la inserción en la tabla tct_cuenta
			$res = $Custom -> InsertarSistemadistribucion($id_sistema,$id_sistema_distribucion,$fecha_separacion ,$id_depto,$conexion,$nombre_sistema_distribucion,$id_gestion);

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
			
		 	 
			$res = $Custom->ModificarSistemadistribucion($id_sistema,$id_sistema_distribucion,$fecha_separacion ,$id_depto,$conexion,$nombre_sistema_distribucion,$id_gestion);

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
	if($sortcol == "") $sortcol = "id_actualizacion";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarSistemaDistribucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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