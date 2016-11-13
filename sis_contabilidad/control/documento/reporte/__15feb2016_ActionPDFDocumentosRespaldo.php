<?php

session_start();
include_once('../../LibModeloContabilidad.php');
$Custom = new cls_CustomDBContabilidad();

$nombre_archivo = 'ActionPDFDocumentosRespaldo.php';

if (!isset($_SESSION['autentificado'])){
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI"){
    if($limit == '') $cant = 1500;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = ' docval.fecha_documento ';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
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
	for($i=0;$i<$CantFiltros;$i++){
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}

	$criterio_filtro = $cond->obtener_criterio_filtro();
	 
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'DocumentoValor');
	$sortcol = $crit_sort->get_criterio_sort();
	
	$m_id_moneda=$_GET["id_moneda"];
	$id_comprobante=$_GET["id_comprobante"];
	
	$Comprobante = array();
	$SumDetalle = array();
	$DocumentosVal= array();
	
	$Comprobante = $Custom-> ReporteComprobante($cant,$puntero,'',$sortdir,$criterio_filtro ." AND COMPROB.id_comprobante=$id_comprobante",$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	//echo $id_comprobante;exit;
	$_SESSION['PDF_comprobante']=$Custom->salida;
	$i=0;
	$_SESSION['PDF_simbolo_moneda']=$_GET["desc_moneda"];
	$_SESSION['id_moneda']=$m_id_moneda;

	foreach ($Custom->salida as $f){
		$id_comprobante=$f["id_comprobante"];
					    
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
		$_SESSION['PDF_fecha']=$f["fecha"]; 
		$_SESSION['desc_clases']=$m_desc_clases;
		$_SESSION['PDF_simbolo']=$m_simbolo;
		                        
		$DocumentosVal=$Custom->ListarRepDocumentosDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_comprobante,$m_id_moneda);
		$_SESSION['PDF_DetalleRepDocumentos']=$Custom->salida;
		                
		$SumDetalle=$Custom->SumDocumentosDet($cant,$puntero,"",$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_comprobante,$m_id_moneda);
		$_SESSION['PDF_SumDetalleDocumentos']=$Custom->salida;
	}
    header("location: ../../../vista/registro_comprobante/PDFDocumentosRespaldo.php");
}else{
	header("HTTP/1.0 401 No autorizado");
	header('Content-Type: text/plain; charset=iso-8859-1');
	echo "No tiene los permisos necesarios ";
}
?>