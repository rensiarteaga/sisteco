<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarcotizacionOrdenCompra.php
Propósito:				Permite insertar y modificar datos en la tabla tad_cotizacion
Tabla:					tad_tad_cotizacion
Parámetros:				$id_cotizacion
						$fecha_venc
						$fecha_reg
						$estado_cotizacion
						$impuestos
						$garantia
						$lugar_entrega
						$forma_pago
						$fecha_validez_oferta
						$fecha_entrega
						$fecha_limite
						$tipo_entrega
						$observaciones
						$id_proceso_compra
						$id_moneda
						$id_proveedor
						$id_tipo_categoria_adq
						$precio_total
						$figura_acta
						$num_factura
						$num_orden_compra
						$estado_vigente
						$estado_reg
						$nombre_pago
						$siguiente_estado
						$periodo
						$gestion
						$num_orden_compra_sis
						$num_cotizacion

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-28 16:58:42
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarCotizacionOrdenCompra.php";

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
			$lugar_entrega= $_GET["lugar_entrega_$j"];
			$forma_pago= $_GET["forma_pago_$j"];
			$fecha_entrega= $_GET["fecha_entrega_$j"];
			$tipo_entrega= $_GET["tipo_entrega_$j"];
			$observaciones= $_GET["observaciones_$j"];
			$id_proceso_compra= $_GET["id_proceso_compra_$j"];
			$num_pagos=$_GET["num_pagos_$j"];
			$fecha_orden_compra=$_GET["fecha_orden_compra_$j"];
			
			$factura_total=$_GET["factura_total_$j"];
			$num_factura=$_GET["num_factura_$j"];
			$num_autoriza_factura=$_GET["num_autoriza_factura_$j"];
			$cod_control_factura=$_GET["cod_control_factura_$j"];
			$fecha_factura=$_GET["fecha_factura_$j"];
			$tipo_pago=$_GET["tipo_pago_$j"];
			$id_caja=$_GET["id_caja_$j"];
			$id_cajero=$_GET["id_cajero_$j"];
			$bandera_fin=$_GET["finalizado_$j"];
			$id_depto_tesoro=$_GET["id_depto_tesoro_$j"];
			$tipo_plantilla=$_GET["tipo_documento_$j"];
			$por_adelanto=$_GET["por_adelanto_$j"];
			$por_retgar=$_GET["por_retgar_$j"];
			$nro_contrato=$_GET["nro_contrato_$j"];
			$monto_adelanto_moneda_cotizada=$_GET["monto_adelanto_moneda_cotizada_$j"];
			
			$fecha_ini_ctto=$_GET["fecha_ini_ctto_$j"];
			$fecha_fin_ctto=$_GET["fecha_fin_ctto_$j"];
			$estado_vigente=$_GET["estado_vigente_$j"];
			
		}
		else
		{
			$id_cotizacion=$_POST["id_cotizacion_$j"];
			$lugar_entrega=$_POST["lugar_entrega_$j"];
			$forma_pago=$_POST["forma_pago_$j"];
			$fecha_entrega=$_POST["fecha_entrega_$j"];
			$tipo_entrega=$_POST["tipo_entrega_$j"];
			$observaciones=$_POST["observaciones_$j"];
			$id_proceso_compra=$_POST["id_proceso_compra_$j"];
			$num_pagos=$_POST["num_pagos_$j"];
			$fecha_orden_compra=$_POST["fecha_orden_compra_$j"];
			
			$factura_total=$_POST["factura_total_$j"];
			$num_factura=$_POST["num_factura_$j"];
			$num_autoriza_factura=$_POST["num_autoriza_factura_$j"];
			$cod_control_factura=$_POST["cod_control_factura_$j"];
			$fecha_factura=$_POST["fecha_factura_$j"];
			$tipo_pago=$_POST["tipo_pago_$j"];
			$id_caja=$_POST["id_caja_$j"];
			$id_cajero=$_POST["id_cajero_$j"];
			$bandera_fin=$_POST["finalizado_$j"];
			$id_depto_tesoro=$_POST["id_depto_tesoro_$j"];
			$tipo_plantilla=$_POST["tipo_documento_$j"];
			$por_adelanto=$_POST["por_adelanto_$j"];
			$por_retgar=$_POST["por_retgar_$j"];
			$nro_contrato=$_POST["nro_contrato_$j"];
			$monto_adelanto_moneda_cotizada=$_POST["monto_adelanto_moneda_cotizada_$j"];
			
			$fecha_ini_ctto=$_POST["fecha_ini_ctto_$j"];
			$fecha_fin_ctto=$_POST["fecha_fin_ctto_$j"];
			$estado_vigente=$_POST["estado_vigente_$j"];
			
		}
//if($id_cotizacion=5510){echo $por_adelanto; exit;}
		$id_empresa=$_SESSION["ss_id_empresa"];
			///////////////////////Modificación////////////////////
		
			if($bandera_fin>0){
			    //finalizar cotizacion
			    $res = $Custom->FinalizarCotizacion($id_cotizacion);
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
			    
			}else{
				if($estado_vigente=='formulacion_pp' || $estado_vigente=='en_pago'){
					
					$res = $Custom->ModificarDatosServ($id_cotizacion,$nro_contrato,$fecha_ini_ctto,$fecha_fin_ctto);
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
					
					
				}else{
				
			
				    $res = $Custom->ModificarCotizacionOrdenCompra($id_cotizacion, $lugar_entrega, $forma_pago, $fecha_entrega,
				     $tipo_entrega, $observaciones, $id_proceso_compra,$num_pagos,$fecha_orden_compra,
				     $id_empresa,$factura_total,$num_factura,$num_autoriza_factura,$cod_control_factura,
				     $fecha_factura,$tipo_pago,$id_caja,$id_cajero,$id_depto_tesoro,
				     $tipo_plantilla,$por_adelanto,$por_retgar,$nro_contrato,$monto_adelanto_moneda_cotizada,$fecha_ini_ctto,$fecha_fin_ctto);

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
			}
				
				
			
	
	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_cotizacion";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "COTIZA.id_proceso_compra=''$m_id_proceso_compra''";

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