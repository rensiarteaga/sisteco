<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarSolicitudFondos.php
Propósito:				Permite insertar y modificar datos en la tabla tts_avance
Tabla:					tts_tts_avance
Parámetros:				$id_avance
						$id_unidad_organizacional
						$id_fina_regi_prog_proy_acti
						$id_empleado
						$id_concepto_ingas
						$tipo_avance
						$fecha_avance
						$importe_avance
						$estado_avance
						$id_moneda
						$id_cheque
						$id_documento
						$id_comprobante
						$fk_avance

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-10-17 10:39:24
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloTesoreria.php");
include_once("../../../sis_contabilidad/control/LibModeloContabilidad.php");

$Custom = new cls_CustomDBTesoreria();
$CustomSCI= new cls_CustomDBcontabilidadIntegracion();

$nombre_archivo = "ActionGuardarSolicitudFondos.php";

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
			$id_avance= $_GET["id_avance_$j"];
			$id_unidad_organizacional= $_GET["id_unidad_organizacional_$j"];
			$id_empleado= $_GET["id_empleado_$j"];
			$tipo_avance= $_GET["tipo_avance_$j"];
			$fecha_avance= $_GET["fecha_avance_$j"];
			$importe_avance= $_GET["importe_avance_$j"];
			$estado_avance= $_GET["estado_avance_$j"];
			$id_moneda= $_GET["id_moneda_$j"];
			$id_cheque= $_GET["id_cheque_$j"];
			$id_documento= $_GET["id_documento_$j"];
			$id_comprobante= $_GET["id_comprobante_$j"];
			$fk_avance= $_GET["fk_avance_$j"];
            $id_financiador= $_GET["txt_id_financiador_$j"];
			$id_regional	= $_GET["txt_id_regional_$j"];
			$id_programa	= $_GET["txt_id_programa_$j"];
			$id_proyecto	= $_GET["txt_id_proyecto_$j"];
			$id_actividad	= $_GET["txt_id_actividad_$j"];
			$sw_contabilizar= $_GET["sw_contabilizar_$j"];
			$id_presupuesto=$_GET["id_presupuesto_$j"];
			$id_depto=$_GET["id_depto_$j"];
			$id_caja=$_GET["id_caja_$j"];
			$avance_solicitud=$_GET["avance_solicitud_$j"];
			$id_cajero=$_GET["id_cajero_$j"];
			$id_usuario_aprueba=$_GET["id_usuario_aprueba_$j"];
			}
		else
		{
			$id_avance=$_POST["id_avance_$j"];
			$id_unidad_organizacional=$_POST["id_unidad_organizacional_$j"];
			$id_empleado=$_POST["id_empleado_$j"];
			$tipo_avance=$_POST["tipo_avance_$j"];
			$fecha_avance=$_POST["fecha_avance_$j"];
			$importe_avance=$_POST["importe_avance_$j"];
			$estado_avance=$_POST["estado_avance_$j"];
			$id_moneda=$_POST["id_moneda_$j"];
			$id_cheque=$_POST["id_cheque_$j"];
			$id_documento=$_POST["id_documento_$j"];
			$id_comprobante=$_POST["id_comprobante_$j"];
			$fk_avance=$_POST["fk_avance_$j"];
            $id_financiador= $_POST["txt_id_financiador_$j"];
			$id_regional	= $_POST["txt_id_regional_$j"];
			$id_programa	= $_POST["txt_id_programa_$j"];
			$id_proyecto	= $_POST["txt_id_proyecto_$j"];
			$id_actividad	= $_POST["txt_id_actividad_$j"];
			$sw_contabilizar= $_POST["sw_contabilizar_$j"];
			$id_presupuesto=$_POST["id_presupuesto_$j"];
			$id_depto=$_POST["id_depto_$j"];
			$id_caja=$_POST["id_caja_$j"];
			$avance_solicitud=$_POST["avance_solicitud_$j"];
			$id_cajero=$_POST["id_cajero_$j"];
			$id_usuario_aprueba=$_POST["id_usuario_aprueba_$j"];
			}
		
		if ($sw_contabilizar=='1')
		{ 		 
			$res = $CustomSCI->TTSIntegracionSolicitudFondos($id_avance,'1','1');
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

		
			$res = $Custom->ModificarDescargoDetalle($id_avance,$id_usuario_aprueba);
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
	if($sortcol == "") $sortcol = "AVANCE.id_avance";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "AVANPA.id_avance=".$fk_avance;

	$res = $Custom->ContarDescargoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", $total_registros);
	$resp->add_nodo("mensaje", $mensaje_exito);
	$resp->add_nodo("tiempo_resp","200");
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