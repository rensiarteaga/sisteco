<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarPeriodo.php
Propósito:				Permite insertar y modificar datos en la tabla tct_periodo
Tabla:					tct_tct_periodo
Parámetros:				$id_periodo
						$id_gestion
						$periodo
						$fecha_inicio
						$fecha_final
						$estado_peri_gral

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-12-01 14:49:33
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = "ActionGuardarPeriodo.php";

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
		if($cont==''){
			$cont=1;
		}
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
			$id_periodo= $_GET["id_periodo_$j"];
			$id_gestion=$_GET["id_gestion"];
			$periodo= $_GET["periodo_$j"];
			$fecha_inicio= $_GET["fecha_inicio_$j"];
			$fecha_final= $_GET["fecha_final_$j"];
			$estado_peri_gral= $_GET["estado_peri_gral_$j"];
			$accion= $_GET["accion"];

		}
		else
		{
			$id_periodo=$_POST["id_periodo_$j"];
			$id_gestion=$_POST["id_gestion"];
			$periodo=$_POST["periodo_$j"];
			$fecha_inicio=$_POST["fecha_inicio_$j"];
			$fecha_final=$_POST["fecha_final_$j"];
			$accion=$_POST["accion"];

		}

		if($accion==1){
			
			//Validación satisfactoria, se ejecuta la inserción en la tabla tct_periodo
			$res = $Custom -> AbrirPeriodo($id_gestion);
			
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
		elseif($accion==2){
			
			//Validación satisfactoria, se ejecuta la inserción en la tabla tct_periodo
			$res = $Custom -> CerrarPeriodo($id_gestion);
			
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
		
		

	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", 13);
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