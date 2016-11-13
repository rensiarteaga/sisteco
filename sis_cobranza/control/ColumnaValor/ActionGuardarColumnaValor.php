<?php
/*
**********************************************************
Nombre de archivo:	    ActionGuardarCuenta.php
Propósito:				Permite insertar y modificar 
Tabla:					tct_cuenta
Parámetros:				$hidden_id_cuenta
$txt_descripcion
$txt_flag_comprobante
$txt_tipo_comprobante

Valores de Retorno:    	Número de registros
Fecha de Creación:		03-10-2007
Versión:				1.0.0
Autor:					José A. Mita Huanca
**********************************************************
*/
session_start();
include_once("../LibModeloCobranza.php");

$Custom = new cls_CustomDBcobranza();
$nombre_archivo = "ActionGuardarConceptoFactura.php";

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
			$id_columna_valor= $_GET["id_columna_valor_$j"];
			$id_concepto_factura= $_GET["id_concepto_factura_$j"];
			$id_tipo_facturacion_cobranza= $_GET["id_tipo_facturacion_cobranza_$j"];
			$id_cuenta= $_GET["id_cuenta_$j"];
			$id_partida= $_GET["id_partida_$j"];
			$id_auxiliar= $_GET["id_auxiliar_$j"];
			$id_presupuesto= $_GET["id_presupuesto_$j"];
			$sw_presto= $_GET["sw_presto_$j"];
			$sw_fecha_separativa= $_GET["sw_fecha_separativa_$j"];
			$sw_estado= $_GET["sw_estado_$j"];
			$id_usuario= $_GET["id_usuario_$j"];
			$fecha_reg= $_GET["fecha_reg_$j"];
			$nombre_columna= $_GET["nombre_columna_$j"];
			$calculo_conta= $_GET["calculo_conta_$j"];
			$calculo_presto= $_GET["calculo_presto_$j"];
			$sw_debe_haber= $_GET["sw_debe_haber_$j"];

		 
		 }
		else
		{ 
			$id_columna_valor= $_POST["id_columna_valor_$j"];
			$id_concepto_factura= $_POST["id_concepto_factura_$j"];
			$id_tipo_facturacion_cobranza= $_POST["id_tipo_facturacion_cobranza_$j"];
			$id_cuenta= $_POST["id_cuenta_$j"];
			$id_partida= $_POST["id_partida_$j"];
			$id_auxiliar= $_POST["id_auxiliar_$j"];
			$id_presupuesto= $_POST["id_presupuesto_$j"];
			$sw_presto= $_POST["sw_presto_$j"];
			$sw_fecha_separativa= $_POST["sw_fecha_separativa_$j"];
			$sw_estado= $_POST["sw_estado_$j"];
			$id_usuario= $_POST["id_usuario_$j"];
			$fecha_reg= $_POST["fecha_reg_$j"];
			$nombre_columna= $_POST["nombre_columna_$j"];
			$calculo_conta= $_POST["calculo_conta_$j"];
			$calculo_presto= $_POST["calculo_presto_$j"];
			$sw_debe_haber= $_POST["sw_debe_haber_$j"];

		}
		
		if ($id_columna_valor == "undefined" || $id_columna_valor == "")
		{ 
			//Validación satisfactoria, se ejecuta la inserción en la tabla tct_cuenta
			$res = $Custom -> InsertarColumnaValor($id_columna_valor, $id_concepto_factura, $id_tipo_facturacion_cobranza, $id_cuenta, $id_partida, $id_auxiliar, $id_presupuesto, $sw_presto, $sw_fecha_separativa, $sw_estado, $id_usuario, $fecha_reg, $nombre_columna, $calculo_conta, $calculo_presto, $sw_debe_haber);

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
			$res = $Custom->ModificarColumnaValor($id_columna_valor, $id_concepto_factura, $id_tipo_facturacion_cobranza, $id_cuenta, $id_partida, $id_auxiliar, $id_presupuesto, $sw_presto, $sw_fecha_separativa, $sw_estado, $id_usuario, $fecha_reg, $nombre_columna, $calculo_conta, $calculo_presto, $sw_debe_haber);

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
	if($sortcol == "") $sortcol = "id_columna_valor";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarColumnaValor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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