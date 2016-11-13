<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCotizacionDir.php
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
$nombre_archivo = "ActionGuardarCotizacionDir.php";

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
			$impuestos= $_GET["impuestos_$j"];
			$forma_pago= $_GET["forma_pago_$j"];
			$observaciones= $_GET["observaciones_$j"];
			$id_proceso_compra= $_GET["id_proceso_compra_$j"];
			$id_moneda= $_GET["id_moneda_$j"];
			$id_proveedor= $_GET["id_proveedor_$j"];
			$id_tipo_categoria_adq= $_GET["id_tipo_categoria_adq_$j"];
			$precio_total= $_GET["precio_total_adjudicado_$j"];
			$num_factura= $_GET["num_factura_$j"];
			$nombre_pago= $_GET["nombre_pago_$j"];
			$periodo= $_GET["periodo_$j"];
			$gestion= $_GET["gestion_$j"];
			$num_cotizacion= $_GET["num_cotizacion_$j"];
			$num_autoriza_factura=$_GET["num_autoriza_factura_$j"];
			$cod_control_factura=$_GET["cod_control_factura_$j"];
			$fecha_factura=$_GET["fecha_factura_$j"];
			$tipo_documento=$_GET["tipo_documento_$j"];
			$id_caja=$_GET["id_caja_$j"];
			$id_cajero=$_GET["id_cajero_$j"];
			$fin=$_GET ["fin_$j"];
			
			$id_responsable_adjudicacion=$_GET["id_empleado_adjudicacion_$j"];
			$fecha_adjudicacion=$_GET["fecha_adjudicacion_$j"];
		}
		else
		{
			$id_cotizacion= $_POST["id_cotizacion_$j"];
			$impuestos= $_POST["impuestos_$j"];
			$forma_pago= $_POST["forma_pago_$j"];
			$observaciones= $_POST["observaciones_$j"];
			$id_proceso_compra= $_POST["id_proceso_compra_$j"];
			$id_moneda= $_POST["id_moneda_$j"];
			$id_proveedor= $_POST["id_proveedor_$j"];
			$id_tipo_categoria_adq= $_POST["id_tipo_categoria_adq_$j"];
			$precio_total= $_POST["precio_total_adjudicado_$j"];
			$num_factura= $_POST["num_factura_$j"];
			$nombre_pago= $_POST["nombre_pago_$j"];
			$periodo= $_POST["periodo_$j"];
			$gestion= $_POST["gestion_$j"];
			$num_cotizacion= $_POST["num_cotizacion_$j"];
			$num_autoriza_factura=$_POST["num_autoriza_factura_$j"];
			$cod_control_factura=$_POST["cod_control_factura_$j"];
			$fecha_factura=$_POST["fecha_factura_$j"];
			$tipo_documento=$_POST["tipo_documento_$j"];
			$id_caja=$_POST["id_caja_$j"];
			$id_cajero=$_POST["id_cajero_$j"];
			$fin=$_POST["fin_$j"];
			$id_responsable_adjudicacion=$_POST["id_empleado_adjudicacion_$j"];
			$fecha_adjudicacion=$_POST["fecha_adjudicacion_$j"];
		}
		$id_empresa=$_SESSION["ss_id_empresa"];
		$retencion==$_SESSION["ss_retencion"];
		
		
		if ($id_cotizacion == "undefined" || $id_cotizacion == "")
		{
			     //Validación satisfactoria, se ejecuta la inserción en la tabla tad_cotizacion
			     $res = $Custom -> InsertarCotizacionDir($id_cotizacion, $impuestos, $forma_pago,$observaciones, $id_proceso_compra, $id_moneda, $id_proveedor, $id_tipo_categoria_adq, 
			     $precio_total,$num_factura, $nombre_pago,$periodo, $gestion,$num_cotizacion,$num_autoriza_factura,$cod_control_factura,$fecha_factura,$id_empresa,$retencion,$tipo_documento,$id_caja,$id_cajero);

			        if(!$res){
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
			
		}else{
		    
		    if($fin>0){
			    
                 $res = $Custom -> FinalizarCotizacionDir($id_cotizacion,$retencion,$id_empresa,$num_factura,$fecha_factura,$id_caja,$id_cajero,$impuestos,$precio_total,$id_responsable_adjudicacion,$fecha_adjudicacion,$observaciones);
   			        if(!$res){
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
			}else{
		    
		    $res = $Custom -> ModificarCotizacionDir($id_cotizacion, $impuestos, $forma_pago,$observaciones, $id_proceso_compra, $id_moneda, $id_proveedor, $id_tipo_categoria_adq, 
			     $precio_total,$num_factura, $nombre_pago,$periodo, $gestion,$num_cotizacion,$num_autoriza_factura,$cod_control_factura,$fecha_factura,$id_empresa,$retencion,$tipo_documento,$id_caja,$id_cajero);

			        if(!$res){
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