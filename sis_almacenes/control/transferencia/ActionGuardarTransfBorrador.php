<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarTransferencia.php
Prop�sito:				Permite insertar y modificar datos en la tabla tal_transferencia
Tabla:					tal_tal_transferencia
Par�metros:				$hidden_id_transferencia
						$txt_prestamo
						$txt_estado_transferencia
						$txt_motivo
						$txt_descripcion
						$txt_observaciones
						$txt_fecha_pendiente_sal
						$txt_fecha_pendiente_ing
						$txt_fecha_cancelado_finalizado
						$txt_id_empleado
						$txt_id_empleado_autorizador
						$txt_id_almacen_logico
						$txt_id_almacen_logico_destino
						$txt_id_tipo_transferencia

Valores de Retorno:    	N�mero de registros guardados
Fecha de Creaci�n:		2007-11-21 08:59:18
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = "ActionGuardarTransferencia.php";

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
			$hidden_id_transferencia= $_GET["hidden_id_transferencia_$j"];
			$txt_prestamo= $_GET["txt_prestamo_$j"];
			$txt_motivo= $_GET["txt_motivo_$j"];
			$txt_descripcion= $_GET["txt_descripcion_$j"];
			$txt_observaciones= $_GET["txt_observaciones_$j"];
			$txt_id_empleado= $_GET["txt_id_empleado_$j"];
			$txt_id_almacen_logico= $_GET["txt_id_almacen_logico_$j"];
			$txt_id_almacen_logico_destino= $_GET["txt_id_almacen_logico_destino_$j"];
			$txt_id_motivo_ingreso_cuenta= $_GET["txt_id_motivo_ingreso_cuenta_$j"];
			$txt_id_tipo_material= $_GET["txt_id_tipo_material_$j"];
			$txt_id_motivo_salida_cuenta= $_GET["txt_id_motivo_salida_cuenta_$j"];
		}
		else
		{
			$hidden_id_transferencia=$_POST["hidden_id_transferencia_$j"];
			$txt_prestamo=$_POST["txt_prestamo_$j"];
			$txt_motivo=$_POST["txt_motivo_$j"];
			$txt_descripcion=$_POST["txt_descripcion_$j"];
			$txt_observaciones=$_POST["txt_observaciones_$j"];
			$txt_id_empleado=$_POST["txt_id_empleado_$j"];
			$txt_id_almacen_logico=$_POST["txt_id_almacen_logico_$j"];
			$txt_id_almacen_logico_destino=$_POST["txt_id_almacen_logico_destino_$j"];
			$txt_id_motivo_ingreso_cuenta= $_POST["txt_id_motivo_ingreso_cuenta_$j"];
			$txt_id_tipo_material= $_POST["txt_id_tipo_material_$j"];
			$txt_id_motivo_salida_cuenta= $_POST["txt_id_motivo_salida_cuenta_$j"];
		}

		if ($hidden_id_transferencia == "undefined" || $hidden_id_transferencia == "")
		{
			////////////////////Inserci�n/////////////////////

			//Validaci�n de datos (del lado del servidor)
			$res = $Custom->ValidarTransferencia("insert",$hidden_id_transferencia, $txt_prestamo,$txt_motivo,$txt_descripcion,$txt_observaciones,$txt_id_empleado,$txt_id_almacen_logico,$txt_id_almacen_logico_destino,$txt_id_motivo_ingreso_cuenta,$txt_id_tipo_material,$txt_id_motivo_salida_cuenta);

			if(!$res)
			{
				//Error de validaci�n
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			//Validaci�n satisfactoria, se ejecuta la inserci�n en la tabla tal_transferencia
			$res = $Custom -> InsertarTransfBorrador($hidden_id_transferencia, $txt_prestamo,$txt_motivo,$txt_descripcion,$txt_observaciones,$txt_id_empleado,$txt_id_almacen_logico,$txt_id_almacen_logico_destino,$txt_id_motivo_ingreso_cuenta,$txt_id_tipo_material,$txt_id_motivo_salida_cuenta);

			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] . " (iteraci�n $cont)";
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
			
			//Validaci�n de datos (del lado del servidor)
			$res = $Custom->ValidarTransferencia("update",$hidden_id_transferencia, $txt_prestamo,$txt_motivo,$txt_descripcion,$txt_observaciones,$txt_id_empleado,$txt_id_almacen_logico,$txt_id_almacen_logico_destino,$txt_id_motivo_ingreso_cuenta,$txt_id_tipo_material,$txt_id_motivo_salida_cuenta);

			if(!$res)
			{
				//Error de validaci�n
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			$res = $Custom->ModificarTransfBorrador($hidden_id_transferencia, $txt_prestamo,$txt_motivo,$txt_descripcion,$txt_observaciones,$txt_id_empleado,$txt_id_almacen_logico,$txt_id_almacen_logico_destino,$txt_id_motivo_ingreso_cuenta,$txt_id_tipo_material,$txt_id_motivo_salida_cuenta);

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
	if($sortcol == "") $sortcol = "id_transferencia";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarTransfBorrador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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