<?php
/** Autor: Ana Maria Villegas
 * Descripción: Reporte de Comprobantes 
 * Fecha Ultima Modificación : 01/03/2010
 * 
 */
session_start();
include_once('../../LibModeloContabilidad.php');
$Custom = new cls_CustomDBContabilidad();

$nombre_archivo = 'ActionPDFComprobante.php';



if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    if($limit == '') $cant = 1500;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'traval.importe_debe desc , traval.importe_haber ';
	//if($sort == '') $sortcol = 'traval.id_transaccion';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'desc';
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
	
	//echo "id_comprobnate ".$m_id_comprobante." moneda".$m_id_moneda;	exit();
    
    $criterio_filtro= $criterio_filtro ." AND COMPROB.id_comprobante=$m_id_comprobante";
	if($m_vista=='plan_pagos'){
		$InforComprobante = $Custom->ListarDatosComprobante($cant,$puntero,$sortcol,$sortdir," compro.id_comprobante=$m_id_comprobante",$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);		
		 foreach ($Custom->salida as $m){
		 	$m_momento_cbte=$m['momento_cbte'];
		 	$m_id_moneda=$m['id_moneda'];
		 	$m_desc_clases=$m['titulo_cbte'];
		 	$m_simbolo=$m['simbolo'];
		 }
	}
	
	//$Proceso = array();
	$Comprobante = array();
	$Transaccion = array();
	/*if ($_SESSION["ss_id_usuario"]==131){
	echo $m_momento_cbte;
	exit;
	}*/
	switch ($m_momento_cbte){
		case 0:$momento_cbte="CONTABLE";
             break;
		case 1:$momento_cbte="DEVENGADO";
             break;
		case 2:$momento_cbte="RECURSOS PERCIBIDOS";
             break;
		case 3:$momento_cbte="DEVENGADO DE GASTOS O INVERSIÓN";
             break;
		case 4:$momento_cbte="PAGADO O PERCIBIDO";
             break;
		case 5:$momento_cbte="REVERSIÓN DEVENGADO";
             break;
		case 6:$momento_cbte="REVERSIÓN PAGADO O PERCIBIDO";
             break;
		case 7:$momento_cbte="AJUSTAR DEVENGADO";
             break;
		case 8:$momento_cbte="AJUSTAR PAGADO O PERCIBIDO";
             break;
    }
	
	$Comprobante = $Custom-> ReporteComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	$_SESSION['PDF_comprobante']=$Custom->salida;
	$i=0;
	$_SESSION['id_moneda']=$m_id_moneda;
    if($m_id_moneda=='' || $m_id_moneda=="undefined"){       
	    $m_id_moneda=1;
     }
	                   
	foreach ($Custom->salida as $f)
	{ 
		
		$_SESSION['PDF_nro_cbte']=$f["nro_cbte"];
		$_SESSION['PDF_fecha_cbte']=$f["fecha_cbte"];				       
		$_SESSION['PDF_acreedor']=$f["acreedor"];
		$_SESSION['PDF_concepto_cbte']=$f["concepto_cbte"];				       
		$_SESSION['PDF_glosa']=$f["glosa"];				       
		$_SESSION['PDF_aprobacion']=$f["aprobacion"];		
		$_SESSION['PDF_pedido']=$f["pedido"];		
		$_SESSION['PDF_conformidad']=$f["conformidad"];	
		$_SESSION['PDF_nombre_clase_cbte']=$f["nombre_clase_cbte"];	
		$_SESSION['PDF_sum_total_literal']=$f["sum_total_literal"];//para mostrar el nombre del titulo
		$_SESSION['PDF_nombre_encargado']=$f["nombre_encargado"]; 
		$_SESSION['PDF_cod_depto']=$f["cod_depto"]; 
		$_SESSION['PDF_fecha']=$f["fecha"]; 
		$_SESSION['PDF_cheque']=$f["cheque"];  
		$_SESSION['desc_clases']=$m_desc_clases;
		$_SESSION['momento_cbte']=$momento_cbte;
		$_SESSION['PDF_max_tc']=$f["t_c"];
		$_SESSION['PDF_facturas']=$f["facturas"];
		$_SESSION['PDF_simbolo']=$m_simbolo;
		
		$TransaccionHaber=$Custom->ListarRepComprobanteTransaccion($cant,$puntero,$sortcol,$sortdir," importe_haber_s!=0 or tra.importe_haber_cs!=0",$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_id_comprobante,$m_id_moneda);
		$_SESSION['PDF_transaccion_haber']=$Custom->salida;
		
		$TransaccionDebe = $Custom->ListarRepComprobanteTransaccion($cant,$puntero,$sortcol,$sortdir," importe_debe_s!=0 or tra.importe_debe_cs!=0",$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_id_comprobante,$m_id_moneda);
		$_SESSION['PDF_transaccion_debe']=$Custom->salida;
		
	}
	
	$firmas=$Custom->GetFirmasComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_comprobante);
	$_SESSION["PDF_firmas"]=$Custom->salida;
	
	$_SESSION['id_comprobante']=$m_id_comprobante;
    
	if($id_comprobante!='' or $m_id_moneda!='' or $m_id_moneda!='undefined'){      

		if($_SESSION["ss_id_usuario"]==131){
			header("location: ../../../vista/registro_comprobante/PDFComprobante.php");
		}else{
		header("location: ../../../vista/registro_comprobante/PDFComprobante.php");}  
	}else{
		echo "No existe el id_comprobante";
	}
}else{
	header("HTTP/1.0 401 No autorizado");
	header('Content-Type: text/plain; charset=iso-8859-1');
	echo "No tiene los permisos necesarios ";
}

?>