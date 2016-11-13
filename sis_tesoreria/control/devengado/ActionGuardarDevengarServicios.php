<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarDevengarServicios.php
Prop�sito:				Permite insertar y modificar datos en la tabla tts_devengado
Tabla:					tts_tts_devengado
Par�metros:				$id_devengado
						$id_concepto_ingas
						$id_moneda
						$importe_devengado
						$estado_devengado
						$id_proveedor
						$tipo_devengado

Valores de Retorno:    	N�mero de registros guardados
Fecha de Creaci�n:		2008-10-21 15:43:27
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloTesoreria.php");
include_once("../../../sis_contabilidad/control/LibModeloContabilidad.php");

$Custom = new cls_CustomDBTesoreria();
$CustomSCI= new cls_CustomDBcontabilidadIntegracion();
$nombre_archivo = "ActionGuardarDevengarServicios.php";


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
			$id_devengado= $_GET["id_devengado_$j"];
			$id_concepto_ingas= $_GET["id_concepto_ingas_$j"];
			$id_moneda= $_GET["id_moneda_$j"];
			$importe_devengado= $_GET["importe_devengado_$j"];
			$estado_devengado= $_GET["estado_devengado_$j"];
			$id_proveedor= $_GET["id_proveedor_$j"];
			$tipo_devengado= $_GET["tipo_devengado_$j"];
			$observaciones= $_GET["observaciones_$j"];
			$id_depto= $_GET["id_depto_$j"];
			$sw_contabilizar= $_GET["sw_contabilizar_$j"];
			$fecha_devengado= $_GET["fecha_devengado_$j"];
			$tipo_desembolso= $_GET["tipo_desembolso_$j"];
			$id_cajero= $_GET["id_cajero_$j"];
			$id_emp_recep_caja= $_GET["id_emp_recep_caja_$j"];
			$id_periodo_subsistema= $_GET["id_periodo_subsistema_$j"];
			$tipo_plantilla= $_GET["tipo_plantilla_$j"];
			$tipo_pago= $_GET["tipo_pago_$j"];
			$id_caja= $_GET["id_caja_$j"];
		}
		else
		{
			$id_devengado=$_POST["id_devengado_$j"];
			$id_concepto_ingas=$_POST["id_concepto_ingas_$j"];
			$id_moneda=$_POST["id_moneda_$j"];
			$importe_devengado=$_POST["importe_devengado_$j"];
			$estado_devengado=$_POST["estado_devengado_$j"];
			$id_proveedor=$_POST["id_proveedor_$j"];
			$tipo_devengado=$_POST["tipo_devengado_$j"];
			$observaciones= $_POST["observaciones_$j"];
			$id_depto= $_POST["id_depto_$j"];
			$sw_contabilizar= $_POST["sw_contabilizar_$j"];
			$fecha_devengado= $_POST["fecha_devengado_$j"];
			$tipo_desembolso= $_POST["tipo_desembolso_$j"];
			$id_cajero= $_POST["id_cajero_$j"];
			$id_emp_recep_caja= $_POST["id_emp_recep_caja_$j"];
			$id_periodo_subsistema= $_POST["id_periodo_subsistema_$j"];
			$tipo_plantilla= $_POST["tipo_plantilla_$j"];
			$tipo_pago= $_POST["tipo_pago_$j"];
			$id_caja= $_POST["id_caja_$j"];
		}
		
		if ($id_devengado == "undefined" || $id_devengado == "")
		{
			////////////////////Inserci�n/////////////////////

			//Validaci�n de datos (del lado del servidor)
			$res = $Custom->ValidarDevengarServicios("insert",$id_devengado,$id_concepto_ingas,$id_moneda,$importe_devengado,$estado_devengado,$id_proveedor,$tipo_devengado);

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

			//Validaci�n satisfactoria, se ejecuta la inserci�n en la tabla tts_devengado
			$res = $Custom -> InsertarDevengarServicios($id_devengado,$id_concepto_ingas,$id_moneda,$importe_devengado,$estado_devengado,$id_proveedor,$tipo_devengado,$observaciones,$id_depto,$fecha_devengado,$tipo_desembolso,$id_cajero,$id_emp_recep_caja,$id_periodo_subsistema,$tipo_plantilla,$tipo_pago,$id_caja);

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
			$res = $Custom->ValidarDevengarServicios("update",$id_devengado,$id_concepto_ingas,$id_moneda,$importe_devengado,$estado_devengado,$id_proveedor,$tipo_devengado);

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

			$res = $Custom->ModificarDevengarServicios($id_devengado,$id_concepto_ingas,$id_moneda,$importe_devengado,$estado_devengado,$id_proveedor,$tipo_devengado,$observaciones,$id_depto,$fecha_devengado,$tipo_desembolso,$id_cajero,$id_emp_recep_caja,$id_periodo_subsistema,$tipo_plantilla,$tipo_pago,$id_caja);

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
	if($sortcol == "") $sortcol = "id_devengado";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarDevengarServicios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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