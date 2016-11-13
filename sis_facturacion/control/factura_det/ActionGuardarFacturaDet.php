<?php
/*
**********************************************************
Nombre de archivo:	    ActionGuardarFacturaDet.php
Propósito:				Permite insertar y modificar a factura
Tabla:					tfv_factura_det
Fecha de Creación:		2014.05
Versión:				1.0.0
Autor:					MTSL
**********************************************************
*/
session_start();
include_once("../LibModeloFactur.php");

$Custom = new cls_CustomDBFactur();
$nombre_archivo = 'ActionGuardarFacturaDet.php';

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
		if ($get){
			$id_factura_det	 = $_GET["id_factura_det_$j"];
			$id_factura		 = $_GET["id_factura_$j"]; 
            $id_presupuesto	 = $_GET["id_presupuesto_$j"];
            $id_ppto_gasto	 = $_GET["id_ppto_gasto_$j"];
			$id_concepto_ingas	 = $_GET["id_concepto_ingas_$j"];
			$fac_importe	 = $_GET["fac_importe_$j"];
			$fac_descuento	 = $_GET["fac_descuento_$j"];
			$fac_obsdesc	 = $_GET["fac_obsdesc_$j"];
		}
		else{
			$id_factura_det = $_POST["id_factura_det_$j"];
			$id_factura	 = $_POST["id_factura_$j"]; 
            $id_presupuesto	 = $_POST["id_presupuesto_$j"];
            $id_ppto_gasto	 = $_POST["id_ppto_gasto_$j"];
			$id_concepto_ingas	 = $_POST["id_concepto_ingas_$j"];
			$fac_importe	 = $_POST["fac_importe_$j"];
			$fac_descuento	 = $_POST["fac_descuento_$j"];
			$fac_obsdesc	 = $_POST["fac_obsdesc_$j"];			
		}

		if ($id_factura_det == "undefined" || $id_factura_det == "")
		{
			////////////////////Inserción/////////////////////
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarFacturaDet("insert", $id_factura_det,$id_factura, $id_presupuesto, $id_ppto_gasto, $id_concepto_ingas, $fac_importe, $fac_descuento, $fac_obsdesc);
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

			//Validación satisfactoria, se ejecuta la inserción del cambio de lectura
			$res = $Custom -> InsertarFacturaDet($id_factura_det, $id_factura, $id_presupuesto, $id_ppto_gasto, $id_concepto_ingas, $fac_importe, $fac_descuento, $fac_obsdesc);
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
			//echo $txt_clave_activa;
			
			$res = $Custom->ValidarFacturaDet("update", $id_factura_det, $id_factura, $id_presupuesto, $id_ppto_gasto, $id_concepto_ingas, $fac_importe, $fac_descuento, $fac_obsdesc);
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

			$res = $Custom->ModificarFacturaDet($id_factura_det, $id_factura, $id_presupuesto, $id_ppto_gasto, $id_concepto_ingas, $fac_importe, $fac_descuento, $fac_obsdesc);
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
	if($sortcol == "") $sortcol = 'DET.id_factura_det';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro = '0=0';

	$res = $Custom->ContarFacturaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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