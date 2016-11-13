<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarSolicitudViaticos2.php
Propósito:				Permite insertar y modificar datos en la tabla tts_cuenta_doc
Tabla:					tts_tts_cuenta_doc
Parámetros:				$id_depto
						$id_presupuesto
						$id_empleado
						$id_categoria
						$fecha_ini
						$fecha_fin
						$tipo_pago
						$tipo_contrato
						$id_usuario_reg
						$motivo
						$recorrido
						$observaciones

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2009-10-27 10:40:41
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloTesoreria.php");

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = "ActionGuardarSolicitudViaticos2.php";

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
		
			$id_cuenta_doc= $_POST["id_cuenta_doc_$j"];
			$id_depto=$_POST["id_depto_$j"];
			$id_presupuesto=$_POST["id_presupuesto_$j"];
			$id_empleado=$_POST["id_empleado_$j"];
			$id_categoria=$_POST["id_categoria_$j"];
			$fecha_ini=$_POST["fecha_ini_$j"];
			$fecha_fin=$_POST["fecha_fin_$j"];
			$tipo_pago=$_POST["tipo_pago_$j"];
			$tipo_contrato=$_POST["tipo_contrato_$j"];
			$id_usuario_rendicion=$_POST["id_usuario_rendicion_$j"];
			$motivo=$_POST["motivo_$j"];
			$recorrido=$_POST["recorrido_$j"];
			$observaciones=$_POST["observaciones_$j"];
			$id_moneda= $_POST["id_moneda_$j"];
			$fecha_sol= $_POST["fecha_sol_$j"];
			$fa_solicitud= $_POST["fa_solititud_$j"];
			$id_caja= $_POST["id_caja_$j"];
			$id_cajero= $_POST["id_cajero_$j"];
			$id_proveedor= $_POST["id_proveedor_$j"];
			$importe_entregado= $_POST["importe_entregado_$j"];
			$id_cuenta_bancaria= $_POST["id_cuenta_bancaria_$j"];
			$id_autorizacion= $_POST["id_autorizacion_$j"];
			$nombre_cheque= $_POST["nombre_cheque_$j"];
		
		
		if ($id_cuenta_doc == "undefined" || $id_cuenta_doc == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarSolicitudViaticos2("insert",$id_cuenta_doc,$id_depto,$id_presupuesto,$id_empleado,$id_categoria,$fecha_ini,$fecha_fin,$tipo_pago,$tipo_contrato,$id_usuario_rendicion,$motivo,$recorrido,$observaciones);

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
			
			//Validación satisfactoria, se ejecuta la inserción en la tabla tts_cuenta_doc
			$res = $Custom -> InsertarSolicitudViaticos2($id_depto,$id_presupuesto,$id_empleado,$id_categoria,$fecha_ini,$fecha_fin,$tipo_pago,$tipo_contrato,$id_usuario_rendicion,$motivo,$recorrido,$observaciones,$fk_id_cuenta_doc,$id_moneda,$fecha_sol,$fa_solicitud,$vista,$id_caja,$id_cajero,$id_proveedor,$id_autorizacion,$nombre_cheque);

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
			
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarSolicitudViaticos2("update",$id_cuenta_doc,$id_depto,$id_presupuesto,$id_empleado,$id_categoria,$fecha_ini,$fecha_fin,$tipo_pago,$tipo_contrato,$id_usuario_rendicion,$motivo,$recorrido,$observaciones);

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

			$res = $Custom->ModificarSolicitudViaticos2($id_cuenta_doc,$id_depto,$id_presupuesto,$id_empleado,$id_categoria,$fecha_ini,$fecha_fin,$tipo_pago,$tipo_contrato,$id_usuario_rendicion,$motivo,$recorrido,$observaciones,$fk_id_cuenta_doc,$id_moneda,$fecha_sol,$fa_solicitud,$vista,$id_caja,$id_cajero,$accion,$id_proveedor,$importe_entregado,$id_cuenta_bancaria,$id_autorizacion,$nombre_cheque);

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
	if($sortcol == "") $sortcol = "id_cuenta_doc";
	if($sortdir == "") $sortdir = "desc";
	
	if($criterio_filtro == "") 
	{
		if($fk_id_cuenta_doc!='0' && $fk_id_cuenta_doc!="")
			$criterio_filtro = "CUDOC.fk_id_cuenta_doc=$fk_id_cuenta_doc";
		else 
			$criterio_filtro = "0=0";
	}

	$res = $Custom->ContarSolicitudViaticos2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista,$estado);
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