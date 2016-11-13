<?php
/**
 * Nombre del archivo:	ActionSaveReparacion.php
 * Propósito:			Permite insertar y modificar las Reparaciones de los Activos Fijos
 * Tabla:				taf_reparacion
 * Parámetros:			
 * Valores de Retorno:	
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creación:		08-06-2007
 */
session_start();
include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionSaveReparacion.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
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
		$cont =  $_POST['cantidad_ids'];
		
		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = 'NIVEL = 4';
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
			$hidden_id_reparacion = $_GET["id_reparacion_$j"];
			$txt_fecha_desde = $_GET["txt_fecha_desde_$j"];
			$txt_fecha_hasta = $_GET["txt_fecha_hasta_$j"];
			$txt_problema = $_GET["txt_problema_$j"];
			$txt_fecha_reg = $_GET["txt_fecha_reg_$j"];
			$txt_observaciones = $_GET["txt_observaciones_$j"];
			$txt_estado = $_GET["txt_estado_$j"];
			$hidden_id_activo_fijo = $_GET["id_activo_fijo_$j"];
			$hidden_id_persona = $_GET["hidden_id_persona_$j"];
			$hidden_id_institucion = $_GET["hidden_id_institucion_$j"];

		}
		else
		{
			$hidden_id_reparacion = $_POST["id_reparacion_$j"];
			$txt_fecha_desde = $_POST["txt_fecha_desde_$j"];
			$txt_fecha_hasta = $_POST["txt_fecha_hasta_$j"];
			$txt_problema = $_POST["txt_problema_$j"];
			$txt_fecha_reg = $_POST["txt_fecha_reg_$j"];
			$txt_observaciones = $_POST["txt_observaciones_$j"];
			$txt_estado = $_POST["txt_estado_$j"];
			$hidden_id_activo_fijo = $_POST["id_activo_fijo_$j"];
			$hidden_id_persona = $_POST["hidden_id_persona_$j"];
			$hidden_id_institucion = $_POST["hidden_id_institucion_$j"];

		
		
		}

		if ($hidden_id_reparacion == "undefined" || $hidden_id_reparacion == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			
		$res = $Custom->ValidarReparacion("insert", $hidden_id_reparacion, $txt_fecha_desde, $txt_fecha_hasta, $txt_problema, $txt_fecha_reg, $txt_observaciones, $txt_estado, $hidden_id_activo_fijo, $hidden_id_persona, $hidden_id_institucion);
		    
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
			
			
		    echo "dfsdjfksldfj ".$res;
		    exit;
			//echo $Custom->salida;
			//exit;
			//Validación satisfactoria, se ejecuta la inserción 
			$res = $Custom -> CrearReparacion($hidden_id_reparacion, $txt_fecha_desde, $txt_fecha_hasta, $txt_problema, $txt_fecha_reg, $txt_observaciones, $txt_estado, $hidden_id_activo_fijo, $hidden_id_persona, $hidden_id_institucion);

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
		{	
			
			///////////////////////Modificación////////////////////
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarReparacion("update", $hidden_id_reparacion, $txt_fecha_desde, $txt_fecha_hasta, $txt_problema, $txt_fecha_reg, $txt_observaciones, $txt_estado, $hidden_id_activo_fijo, $hidden_id_persona, $hidden_id_institucion);
			echo $res;
			exit;
			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel =$Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			$res = $Custom -> ModificarReparacion($hidden_id_reparacion, $txt_fecha_desde, $txt_fecha_hasta, $txt_problema, $txt_fecha_reg, $txt_observaciones, $txt_estado, $hidden_id_activo_fijo,$hidden_id_persona, $hidden_id_institucion);
			
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
	if($cont > 1) $mensaje_exito = 'Se guardaron todos los datos.';
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'nombres';
	if($sortdir == "") $sortdir = 'asc';
	//if($criterio_filtro == "") $criterio_filtro = '0=0';
	if($criterio_filtro == "") $criterio_filtro = "acti.id_activo_fijo = $hidden_id_activo_fijo";

	$res = $Custom->ContarListaReparacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo('TotalCount', $total_registros);
	$resp->add_nodo('mensaje', $mensaje_exito);
	$resp->add_nodo('tiempo_resp', '200');
	echo $resp->get_mensaje();
	exit;
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 1';
	echo $resp->get_mensaje();
	exit;
}
?>