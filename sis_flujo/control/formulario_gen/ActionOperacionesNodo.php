<?php
/*
 **********************************************************
 Nombre de archivo:	    ActionGuardarValores.php
 Propósito:				Permite guardar registros en la tabla tfl_atributo
 Tabla:					tfl_atributo, tfl_formulario, tfl_proceso
 Parámetros:

 Valores de Retorno:
 Fecha de Creación:		2011-02-03
 Versión:				1.0.0
 Autor:					Ariel Ayaviri Omonte
 **********************************************************
*/
session_start();
include_once("../LibModeloFlujo.php");

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = "ActionGuardarValor.php";

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
		$operacion =  $_POST["operacion"];
		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No se puede procesar la operacion.";
		$resp->origen = "ORIGEN = ";
		$resp->proc = "PROC = ";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit;
	}
	
	//Envia al Custom la bandera que indica si se decodificará o no
	$Custom->decodificar = $decodificar;
	
	// SE CREA UN NUEVO NODO CON LOS DATOS DEL EMPELADO DESTINO Y EL PROCESO QUE SE ESTÁ ENVIANDO.
	if($nombreOperacion == "EnviarProceso"){
		// SE OBTIENE EL ID DEL NODO ACTUAL
		$criterio_filtro = " NODO.id_empleado = $id_empleado and NODO.estado = ''borrador''";
		$res = $Custom->ListarNodo(1,0,'NODO.id_nodo asc','asc',$criterio_filtro);
		if($res){
			foreach($Custom->salida as $f){
				$id_nodo_actual = $f['id_nodo'];
			}
		}
		
		//SE CAMBIA EL ESTADO DEL NODO ACTUAL A FINALIZADO
		$res = $Custom->ModificarNodo($id_nodo_actual,$id_empleado,$id_tipo_nodo,$id_proceso, "NULL","finalizado","NULL");
		if(!$res){
			//Error de validación
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = $Custom->salida[1];
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			echo $resp->get_mensaje();
			exit;
		}
		
		//SE CREA EL NUEVO NODO SIGUIENTE CON LOS DATOS SELECCIONADOS POR EL USUARIO
		$res = $Custom->InsertarNodo($id_empleado_siguiente, $id_tipo_nodo_siguiente, $id_proceso,"NULL","borrador","NULL");
		if($res){
			//ide del nodo que se creó recientemente
			$id_nodo_next = $Custom->salida[2];
		}
		else{
			//Error de validación
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = $Custom->salida[1];
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			echo $resp->get_mensaje();
			exit;
		}
		
		$res = $Custom ->InsertarCircuito($id_nodo_actual, $id_nodo_next, "NULL");
		if(!res){
			//Error de validación
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = $Custom->salida[1];
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			echo $resp->get_mensaje();
			exit;
		}
	}
	
	if($nombreOperacion == "CorregirProceso"){
		var_dump("corregir proces");
		// FALTA IMPLEMENTAR ESTA FUNCIÓN
	}
	
	//Guarda el mensaje de éxito de la operación realizada
	$mensaje_exito = $Custom->salida[1];
	$total_registros = 1;
	
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