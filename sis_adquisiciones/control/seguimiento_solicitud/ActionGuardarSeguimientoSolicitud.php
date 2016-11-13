<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarSeguimientoSolicitud.php
Propósito:				Permite insertar y modificar datos en la tabla tad_solicitud_compra
Tabla:					tad_tad_solicitud_compra
Parámetros:				$id_solicitud_compra
						$observaciones
						$localidad
						$estado_vigente_solicitud
						$tipo_adjudicacion
						$id_tipo_categoria_adq
						$id_empleado_frppa_solicitante
						$id_moneda
						$id_rpa
						$id_cuenta
						$id_unidad_organizacional
						$id_fina_regi_prog_proy_acti

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-15 19:39:24
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarSeguimientoSolicitud.php";

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
			$id_solicitud_compra= $_GET["id_solicitud_compra_".$j];
			$operacion=$_GET["operacion_".$j];
			$observaciones=$_GET["observaciones_".$j];
		}
		else
		{
			$id_solicitud_compra=$_POST["id_solicitud_compra_".$j];
			$operacion=$_POST["operacion_".$j];
			$observaciones=$_POST["observaciones_".$j];
				
		}	
if (($_POST["operacion"])=='correccion'||($_GET["operacion"])=='correccion'||($_GET["operacion"])=='aprobar_presupuesto'){
	
	
	
	if ($get)
	{
		$id_solicitud_compra= $_GET["id_solicitud_compra"];
		$operacion=$_GET["operacion"];
		$observaciones=$_GET["observaciones"];
	}
	else
	{
		$id_solicitud_compra=$_POST["id_solicitud_compra"];
		$operacion=$_POST["operacion"];
		$observaciones=$_POST["observaciones"];
			
	}
	
}
		
	/*	echo 'ss'.$operacion;
		exit;*/
			

			$res = $Custom->ModificarSeguimientoSolicitud($id_solicitud_compra, $operacion,$observaciones);

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
	if($sortcol == "") $sortcol = "id_solicitud_compra";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";
	if($filtro){
		$criterio_filtro=$criterio_filtro." AND ".$filtro;
	}
	$res = $Custom->ContarSeguimientoSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista);
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