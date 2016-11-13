<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarSolicitudViaticos.php
Propósito:				Permite insertar y modificar datos en la tabla tts_viatico
Tabla:					tts_tts_viatico
Parámetros:				$id_viatico
						$id_fina_regi_prog_proy_acti
						$id_unidad_organizacional
						$id_empleado
						$id_categoria
						$id_destino
						$nro_dias
						$id_cobertura
						$id_moneda
						$importe_pasaje
						$importe_viatico
						$importe_hotel
						$importe_otros
						$id_concepto_pasaje
						$id_concepto_viatico

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-11-12 11:42:20
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloTesoreria.php");
include_once("../../../sis_contabilidad/control/LibModeloContabilidad.php");

$Custom = new cls_CustomDBTesoreria();
$CustomSCI= new cls_CustomDBcontabilidadIntegracion();

$nombre_archivo = "ActionGuardarSolicitudViaticos.php";

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
			$id_viatico= $_GET["id_viatico_$j"];
			
			$id_unidad_organizacional= $_GET["id_unidad_organizacional_$j"];
			$id_empleado= $_GET["id_empleado_$j"];
			$id_categoria= $_GET["id_categoria_$j"];			
			$id_moneda= $_GET["id_moneda_$j"];				
			
			$id_cuenta_bancaria= $_GET["id_cuenta_bancaria_$j"];
			$nombre_cheque= $_GET["nombre_cheque_$j"];			
			$estado_viatico	= $_GET["estado_viatico_$j"];	
			
			$fecha_solicitud= $_GET["fecha_solicitud_$j"];			
			$num_solicitud= $_GET["num_solicitud_$j"];
			
			$detalle_viaticos= $_GET["detalle_viaticos_$j"];
			$motivo_viaje= $_GET["motivo_viaje_$j"];			
			$detalle_otros= $_GET["detalle_otros_$j"];
			$sw_retencion= $_GET["sw_retencion_$j"];
			$tipo_pago= $_GET["tipo_pago_$j"];
			
			$id_caja = $_GET["id_caja_$j"];
			$id_cajero = $_GET["id_cajero_$j"];
			$importe_regis = $_GET["importe_regis_$j"];
			
			$id_empleado_vale = $_GET["id_empleado_vale_$j"];
			$concepto_regis = $_GET["concepto_regis_$j"];			
			$sw_contabilizar= $_GET["sw_contabilizar_$j"];
			$tipo_actualizacion= $_GET["tipo_actualizacion_$j"];
			
			$tipo_viatico= $_GET["tipo_viatico_$j"];			
			$fk_viatico= $_GET["fk_viatico_$j"];
			$observacion= $_GET["observacion_$j"];
			
			$fecha_inicio= $_GET["fecha_inicio_$j"];
			$fecha_fin= $_GET["fecha_fin_$j"];
			$numero_deposito= $_GET["numero_deposito_$j"];
			$id_depto = $_GET["id_depto_$j"];
			$obs_viatico = $_GET["obs_viatico_$j"];
			$id_presupuesto = $_GET["id_presupuesto_$j"];
			
			$id_responsable_rendicion = $_GET["id_responsable_rendicion_$j"];
			$id_autorizacion = $_GET["id_autorizacion_$j"];
			$id_aprobacion = $_GET["id_aprobacion_$j"];
		}
		else
		{
			$id_viatico=$_POST["id_viatico_$j"];
			
			$id_unidad_organizacional=$_POST["id_unidad_organizacional_$j"];
			$id_empleado=$_POST["id_empleado_$j"];
			$id_categoria=$_POST["id_categoria_$j"];			
			$id_moneda=$_POST["id_moneda_$j"];			
			
			$id_cuenta_bancaria=$_POST["id_cuenta_bancaria_$j"];
			$nombre_cheque=$_POST["nombre_cheque_$j"];			
			$estado_viatico	= $_POST["estado_viatico_$j"];
						
			$fecha_solicitud= $_POST["fecha_solicitud_$j"];			
			$num_solicitud= $_POST["num_solicitud_$j"];
			
			$detalle_viaticos= $_POST["detalle_viaticos_$j"];
			$motivo_viaje= $_POST["motivo_viaje_$j"];			
			$detalle_otros= $_POST["detalle_otros_$j"];
			$sw_retencion= $_POST["sw_retencion_$j"];
			$tipo_pago= $_POST["tipo_pago_$j"];
			
			$id_caja = $_POST["id_caja_$j"];
			$id_cajero = $_POST["id_cajero_$j"];
			$importe_regis = $_POST["importe_regis_$j"];
			
			$id_empleado_vale = $_POST["id_empleado_vale_$j"];
			$concepto_regis = $_POST["concepto_regis_$j"];			
			$sw_contabilizar= $_POST["sw_contabilizar_$j"];
			$tipo_actualizacion= $_POST["tipo_actualizacion_$j"];			
			
			$tipo_viatico= $_POST["tipo_viatico_$j"];			
			$fk_viatico= $_POST["fk_viatico_$j"];
			$observacion= $_POST["observacion_$j"];
			
			$fecha_inicio = $_POST["fecha_inicio_$j"];
			$fecha_fin = $_POST["fecha_fin_$j"];
			$numero_deposito = $_POST["numero_deposito_$j"];
			$id_depto = $_POST["id_depto_$j"];
			$obs_viatico = $_POST["obs_viatico_$j"];
			$id_presupuesto = $_POST["id_presupuesto_$j"];
			
			$id_responsable_rendicion = $_POST["id_responsable_rendicion_$j"];
			$id_autorizacion = $_POST["id_autorizacion_$j"];
			$id_aprobacion = $_POST["id_aprobacion_$j"];
		}
		
		if ($sw_contabilizar=='1')
		{ 		 
			$res = $CustomSCI->TTSIntegracionViatico($id_viatico,'1','1');
				if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $CustomSCI->salida[1];
				$resp->origen = $CustomSCI->salida[2];
				$resp->proc = $CustomSCI->salida[3];
				$resp->nivel = $CustomSCI->salida[4];
				echo $resp->get_mensaje();
				exit;
			}
			break;
		}
		
		if ($sw_contabilizar=='2')
		{ 		 
			//echo 'llega a la condicion 2';
			
			$res = $CustomSCI->TTSIntegracionViaticoRendicion($id_viatico,'1','1');
				if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $CustomSCI->salida[1];
				$resp->origen = $CustomSCI->salida[2];
				$resp->proc = $CustomSCI->salida[3];
				$resp->nivel = $CustomSCI->salida[4];
				echo $resp->get_mensaje();
				exit;
			}
			break;
		}
		
		if ($sw_contabilizar=='3')
		{ 		 
			//echo 'llega a la condicion 2';
			
			$res = $CustomSCI->TTSIntegracionViaticoFinalizacion($id_viatico,'1','1');
				if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $CustomSCI->salida[1];
				$resp->origen = $CustomSCI->salida[2];
				$resp->proc = $CustomSCI->salida[3];
				$resp->nivel = $CustomSCI->salida[4];
				echo $resp->get_mensaje();
				exit;
			}
			break;
		}
		

		if ($id_viatico == "undefined" || $id_viatico == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarSolicitudViaticos("insert",$id_viatico,$id_unidad_organizacional,$id_empleado,$id_categoria,$id_moneda,$id_cuenta_bancaria,$nombre_cheque);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tts_viatico
			$res = $Custom -> InsertarSolicitudViaticos($id_viatico,$id_unidad_organizacional,$id_empleado,$id_categoria,$id_moneda,
												$id_cuenta_bancaria,$nombre_cheque,												
												$estado_viatico,$fecha_solicitud,$num_solicitud,$detalle_viaticos,$motivo_viaje,
												$detalle_otros,$sw_retencion,$tipo_pago,$id_caja, $id_cajero, $importe_regis,$tipo_actualizacion,
												$tipo_viatico,$fk_viatico,$observacion,$fecha_inicio,$fecha_fin,
												$numero_deposito,$id_depto,$obs_viatico,$id_presupuesto,
												$id_responsable_rendicion,$id_autorizacion,$id_aprobacion);

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
			$res = $Custom->ValidarSolicitudViaticos("update",$id_viatico,$id_unidad_organizacional,$id_empleado,$id_categoria,$id_moneda,$id_cuenta_bancaria,$nombre_cheque);

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

			$res = $Custom->ModificarSolicitudViaticos($id_viatico,$id_unidad_organizacional,$id_empleado,$id_categoria,$id_moneda,
												$id_cuenta_bancaria,$nombre_cheque,												
												$estado_viatico,$fecha_solicitud,$num_solicitud,$detalle_viaticos,$motivo_viaje,
												$detalle_otros,$sw_retencion,$tipo_pago,$id_caja, $id_cajero, $importe_regis,$tipo_actualizacion,
												$tipo_viatico,$fk_viatico,$observacion,$fecha_inicio,$fecha_fin,
												$numero_deposito,$id_depto,$obs_viatico,$id_presupuesto,
												$id_responsable_rendicion,$id_autorizacion,$id_aprobacion);

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
	if($sortcol == "") $sortcol = "id_viatico";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarSolicitudViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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