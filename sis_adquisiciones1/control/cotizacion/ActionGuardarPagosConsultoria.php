<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarPagosConsultoria.php
Propósito:				Permite insertar en tabla aun no definida los ids de los proveedores para los que se hará la transferencia
Tabla:					tad_tad_cotizacion
Parámetros:				$id_cotizacion,
						$num_pago

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2009-07-10 12:12:42
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarPagosConsultoria.php";

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
			$id_cotizacion= $_GET["id_cotizacion_$j"];
			$num_pago= $_GET["prox_pago_$j"];
			$check_pagar= $_GET["check_pagar_$j"];
			
		}
		else
		{
			$id_cotizacion=$_POST["id_cotizacion_$j"];
			$num_pago=$_POST["prox_pago_$j"];
			$check_pagar=$_POST["check_pagar_$j"];
			
		}
		$id_empresa=$_SESSION["ss_id_empresa"];
		$retencion==$_SESSION["ss_retencion"];
		
		

/*		    $res = $Custom->ModificarCotizacion($id_cotizacion, $fecha_venc, $fecha_reg,  $impuestos, $garantia, $lugar_entrega, $forma_pago, $tiempo_validez_oferta, $fecha_entrega, $tipo_entrega, $observaciones, $id_proceso_compra, $id_moneda, $id_proveedor, $id_tipo_categoria_adq, $precio_total, $figura_acta, $num_factura, $num_orden_compra, $estado_vigente, $estado_reg, $nombre_pago, $siguiente_estado, $periodo, $gestion, $num_orden_compra_sis, $num_cotizacion,$fecha_orden_compra,$id_empresa,$fecha_cotizacion,$retencion);
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
//					}*/
//	        if($j==0){
//	        	$mm=$id_cotizacion."--".$num_pago."--".$check_pagar;
//	        }else{
//			    $mm=$mm."***".$id_cotizacion."--".$num_pago."--".$check_pagar;
//	        }
	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	
	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_cotizacion";
	if($sortdir == "") $sortdir = "asc";
	
	if($criterio_filtro == "") if($m_id_proceso_compra!=''){$criterio_filtro = "PROCOM.id_proceso_compra=''$m_id_proceso_compra''";}else{
		$criterio_filtro = "PROCOM.id_proceso_compra=''$id_proceso_compra''";
	}
	

	$res = $Custom->ContarCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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