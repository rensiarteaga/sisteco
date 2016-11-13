<?php
session_start();
include_once('../../LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFSolicitudPago.php';



if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    if($limit == "") $cant = 15;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

if($sort == '') $sortcol = 'COTIZA.id_cotizacion';
	else $sortcol = $sort;

	if($dir == "") $sortdir = 'asc';
	else $sortdir = $dir;

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

//Verifica si se manda la cantidad de filtros
	if($CantFiltros=="") $CantFiltros = 0;


//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}

	$criterio_filtro = $cond->obtener_criterio_filtro();
//	echo $m_id_plan_pago;
//	exit;
	$criterio_filtro=$criterio_filtro." AND COTIZA.id_cotizacion=(select id_cotizacion from compro.tad_plan_pago where id_plan_pago=$m_id_plan_pago)";
	
	$Pago= array();
    $Pago = $Custom-> RepSolicitudPago($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_id_plan_pago);
		 
			foreach ($Custom->salida as $f)
			{  
			    $_SESSION['PDF_proveedor'] = $f["proveedor"];
				$_SESSION['PDF_codigo_proceso'] = $f["codigo_proceso"];
				$_SESSION['PDF_solicitante']=$f["solicitante"];
				$_SESSION['PDF_unidad_organizacional']=$f["unidad_organizacional"];
				$_SESSION['PDF_descripcion_sol']=$f["descripcion_sol"];
				$_SESSION['PDF_monto']=$f["monto"];
				$_SESSION['PDF_monto_no_pagado']=$f["monto_no_pagado"];
				$_SESSION['PDF_forma_pago']=$f["forma_pago"];
				$_SESSION['PDF_num_factura']=$f["num_factura"];
				$_SESSION['PDF_lugar_entrega']=$f["lugar_entrega"];
				$_SESSION['PDF_nivel_aprobacion']=$f['nivel_aprobacion'];
				$_SESSION['PDF_descrip']=$f['descrip'];
				$_SESSION['PDF_monto_literal']=$f['monto_literal'];
				$_SESSION['PDF_num_proceso']=$f["num_proceso"];
				$_SESSION['PDF_tipo_adq']=$f["tipo_adq"];
				$_SESSION['PDF_gestion']=$f["gestion"];
				
				$_SESSION['PDF_jefe_depto_bienes']=$f["jefe_depto_bienes"];
				$_SESSION['PDF_cargo_depto_bienes']=$f["cargo_depto_bienes"];
				$_SESSION['PDF_jefe_depto_contabilidad']=$f["jefe_depto_contabilidad"];
				$_SESSION['PDF_cargo_depto_contabilidad']=$f["cargo_depto_contabilidad"];
				$_SESSION['PDF_nro_cuota']=$f["nro_cuota"];
				$_SESSION['PDF_observaciones_pago']=$f["observaciones_pago"];
				$_SESSION['PDF_moneda']=$f["moneda"];
				$_SESSION['PDF_monto_sin_ret']=$f["monto_sin_ret"];
				$_SESSION['PDF_impuestos']=$f["impuestos"];
				$_SESSION['PDF_codigo']=$f['codigo_depto']."  ".$f["periodo"]."/".$f["nro_sol"];
				$_SESSION['PDF_fecha']=$f['fecha'];
				$_SESSION['PDF_multas']=$f['multas'];
				$_SESSION['PDF_nro_contrato']=$f['nro_contrato'];
				$_SESSION['PDF_desc_anticipo']=$f['desc_anticipo'];
				$_SESSION['PDF_desc_garantia']=$f['desc_garantia'];
				$_SESSION['PDF_fecha_devengado']=$f['fecha_devengado'];
				$_SESSION['PDF_pago_integrado']=$f['pago_integrado'];
				$_SESSION['PDF_descuentos']=$f['descuentos'];
				
			
			
			}
			
			$criterio_filtro='';
			
			$Pago_detalle = $Custom-> RepSolicitudPagoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_id_plan_pago);
			$_SESSION['PDF_EP_solicitud']=$Custom->salida;
			header("location: ../../../vista/cotizacion/PDFSolicitudPago.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>
