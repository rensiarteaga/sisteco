<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCaja.php
Propósito:				Permite insertar y modificar datos en la tabla tts_caja
Tabla:					tts_tts_caja
Parámetros:				$id_caja
						$tipo_caja
						$id_unidad_organizacional
						$id_moneda
						$id_dosifica
						$fecha_inicio
						$fecha_cierre
						$sw_factura
						$importe_maximo
						$porcentaje_compra
						$nro_recibo
						$estado_caja

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-10-21 09:30:44
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloTesoreria.php");

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = "ActionGuardarCaja.php";

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
			$id_caja= $_GET["id_caja_$j"];
			$tipo_caja= $_GET["tipo_caja_$j"];
			$id_unidad_organizacional= $_GET["id_unidad_organizacional_$j"];
			$id_moneda= $_GET["id_moneda_$j"];
			$id_dosifica= $_GET["id_dosifica_$j"];
			$fecha_inicio= $_GET["fecha_inicio_$j"];
			$fecha_cierre= $_GET["fecha_cierre_$j"];
			$sw_factura= $_GET["sw_factura_$j"];
			$importe_maximo= $_GET["importe_maximo_$j"];
			$porcentaje_compra= $_GET["porcentaje_compra_$j"];
			$porcentaje_rinde= $_GET["porcentaje_rinde_$j"];
			$nro_recibo= $_GET["nro_recibo_$j"];
			$estado_caja= $_GET["estado_caja_$j"];
			$id_partida_cuenta= $_GET["id_partida_cuenta_$j"];
			$id_auxiliar= $_GET["id_auxiliar_$j"];
			$id_fina_regi_prog_proy_acti= $_GET["id_fina_regi_prog_proy_acti_$j"];
			$id_depto= $_GET["id_depto_$j"];
			$codigo_caja= $_GET["codigo_caja_$j"];
			$id_responsable_caja= $_GET["id_usuario_$j"];
		}else{
			$id_caja=$_POST["id_caja_$j"];
			$tipo_caja=$_POST["tipo_caja_$j"];
			$id_unidad_organizacional=$_POST["id_unidad_organizacional_$j"];
			$id_moneda=$_POST["id_moneda_$j"];
			$id_dosifica=$_POST["id_dosifica_$j"];
			$fecha_inicio=$_POST["fecha_inicio_$j"];
			$fecha_cierre=$_POST["fecha_cierre_$j"];
			$sw_factura=$_POST["sw_factura_$j"];
			$importe_maximo=$_POST["importe_maximo_$j"];
			$porcentaje_compra=$_POST["porcentaje_compra_$j"];
			$porcentaje_rinde= $_POST["porcentaje_rinde_$j"];
			$nro_recibo=$_POST["nro_recibo_$j"];
			$estado_caja=$_POST["estado_caja_$j"];
			$id_partida_cuenta= $_POST["id_partida_cuenta_$j"];
			$id_auxiliar= $_POST["id_auxiliar_$j"];
			$id_fina_regi_prog_proy_acti= $_POST["id_fina_regi_prog_proy_acti_$j"];
			$id_depto= $_POST["id_depto_$j"];
			$codigo_caja= $_POST["codigo_caja_$j"];
			$id_responsable_caja= $_POST["id_usuario_$j"];
		}

		if ($id_caja == "undefined" || $id_caja == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarCaja("insert",$id_caja,$tipo_caja,$id_unidad_organizacional,$id_moneda,$id_dosifica,$fecha_inicio,$fecha_cierre,$sw_factura,$importe_maximo,$porcentaje_compra,$porcentaje_rinde,$nro_recibo,$estado_caja,$id_partida_cuenta,$id_auxiliar,$id_fina_regi_prog_proy_acti);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tts_caja
			$res = $Custom -> InsertarCaja($id_caja,$tipo_caja,$id_unidad_organizacional,$id_moneda,$id_dosifica,$fecha_inicio,$fecha_cierre,$sw_factura,$importe_maximo,$porcentaje_compra,$porcentaje_rinde,$nro_recibo,$estado_caja,$id_partida_cuenta,$id_auxiliar,$id_fina_regi_prog_proy_acti,$codigo_caja,$id_depto,$id_responsable_caja);

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
			$res = $Custom->ValidarCaja("update",$id_caja,$tipo_caja,$id_unidad_organizacional,$id_moneda,$id_dosifica,$fecha_inicio,$fecha_cierre,$sw_factura,$importe_maximo,$porcentaje_compra,$porcentaje_rinde,$nro_recibo,$estado_caja,$id_partida_cuenta,$id_auxiliar,$id_fina_regi_prog_proy_acti);

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

			$res = $Custom->ModificarCaja($id_caja,$tipo_caja,$id_unidad_organizacional,$id_moneda,$id_dosifica,$fecha_inicio,$fecha_cierre,$sw_factura,$importe_maximo,$porcentaje_compra,$porcentaje_rinde,$nro_recibo,$estado_caja,$id_partida_cuenta,$id_auxiliar,$id_fina_regi_prog_proy_acti,$codigo_caja,$id_depto,$id_responsable_caja);

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
	if($sortcol == "") $sortcol = "id_caja";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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