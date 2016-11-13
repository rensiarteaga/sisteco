<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarParametroAdquisicion.php
Propósito:				Permite insertar y modificar datos en la tabla tad_parametro_adquisicion
Tabla:					tad_tad_parametro_adquisicion
Parámetros:				$id_parametro_adquisicion
						$gestion
						$estado
						$fecha
						$periodo
						$num_solicitud_item
						$num_proceso_item
						$num_cotizacion_item
						$num_orden_compra_item
						$num_solicitud_servicio
						$num_proceso_servicio
						$num_cotizacion_servicio
						$num_orden_compra_servicio

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-06-13 16:12:36
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarParametroAdquisicion.php";

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
			$id_parametro_adquisicion= $_GET["id_parametro_adquisicion_$j"];
			$estado= $_GET["estado_$j"];
			$fecha= $_GET["fecha_$j"];
			$id_gestion_subsistema= $_GET["id_gestion_subsistema_$j"];
			$id_gestion= $_GET["id_gestion_$j"];
			
			
		}
		else
		{
			$id_parametro_adquisicion=$_POST["id_parametro_adquisicion_$j"];
			$estado=$_POST["estado_$j"];
			$fecha=$_POST["fecha_$j"];
			$id_gestion_subsistema=$_POST["id_gestion_subsistema_$j"];
			$id_gestion= $_POST["id_gestion_$j"];
		}
		
        if ($id_parametro_adquisicion == "undefined" || $id_parametro_adquisicion == "")
		{
			////////////////////Inserción/////////////////////

						
			$res = $Custom -> InsertarParametroAdquisicion($_SESSION['ss_id_empresa']);
			
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
			
			
			
              
            $res = $Custom->ModificarParametroAdquisicionEstado($id_parametro_adquisicion, $estado,$fecha);
			}
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
				exit;			}
		

	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_parametro_adquisicion";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarParametroAdquisicion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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