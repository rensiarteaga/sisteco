<?php

session_start();
include_once('../../LibModeloContabilidad.php');
$Custom = new cls_CustomDBContabilidad();

$nombre_archivo = 'ActionPDFLibrosComprasA.php';

if (!isset($_SESSION['autentificado'])){
	$_SESSION['autentificado']="NO";
}

if($_SESSION['autentificado']=="SI"){
    if($limit == '') $cant = 1500;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'COM.desc_comprobante ';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> "si", "no"
	switch ($cod){
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

	$cant=10000000;
	$puntero=0;

	$sortdir='asc';
	$criterio_filtro="MON.id_moneda=''$id_moneda''";
	$criterio_filtro=$criterio_filtro." and COM.id_periodo_subsis= ''$m_periodo''";
	
    $id_moneda=  $id_moneda;
	
	$Comprobante = array();
	$SumDetalle = array();
	$DocumentosVal= array();
	$DocumentosValCab= array();
	
	$Prueba=split("/",$txt_fecha_inicio);
	$Prueba2=split("/",$txt_fecha_fin);
	
	$_SESSION['rep_sci_fecha_inicio']=$Prueba[1]."/".$Prueba[0]."/".$Prueba[2];
	$_SESSION['rep_sci_fecha_fin']=$Prueba2[1]."/".$Prueba2[0]."/".$Prueba2[2];;
	$_SESSION['txt_desc_moneda']=utf8_decode($_GET['txt_desc_moneda']);
	$_SESSION['desc_periodo']=utf8_decode($_GET['desc_periodo']);
	$_SESSION['desc_usuario']=utf8_decode($_GET['desc_usuario']);
	$_SESSION['txt_gestion']=utf8_decode($_GET['txt_gestion']);
	$_SESSION['PDF_vista']=$_GET['vista_reporte'];
	$_SESSION['PDF_por_comprobante']=$_GET['por_comprobante'];
	$_SESSION['PDF_doc_id']=$_GET['doc_id'];
	$_SESSION['PDF_desc_gestion']=$_GET['m_gestion']; 
	$_SESSION['PDF_toda_gestion']=$_GET['toda_gestion']; 
	
	$tipo_documento=$_GET['tipo_documento'];
	
	if($sw_debito_credito==1){
		if ($por_comprobante=='true'){
			$sortcol = 'COM.desc_comprobante,DOC.fecha_documento ';
		}else{
			$sortcol = 'DOC.fecha_documento ';
		}
	}
	if($sw_debito_credito==2){$sortcol ='DOC.fecha_documento, DOC.nro_documento '; }
    
	if($toda_gestion=='true'){
		$hidden_ep_id_actividad = $m_gestion;
	}
	//echo $m_gestion; exit;
	$DocumentosValCab=$Custom->ListarCabLibroCompraVenta($cant,$puntero,$sortcol,$sortdir,'0=0 AND id_usuario='.$id_usuario,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_periodo,$_GET['id_moneda'],$sw_debito_credito,$id_depto,$tipo_documento);
   	$_SESSION['PDF_cabecera_compras_ventas']=$Custom->salida;
  
	$DocumentosVal=$Custom->ListarDocumentoIva($cant,$puntero,$sortcol,$sortdir,'0=0',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_periodo,$_GET['id_moneda'],$sw_debito_credito,$id_depto,$tipo_documento);
    
	$_SESSION['PDF_Detalle_compras']=$Custom->salida;
	 if($por_comprobante=='true')
     	header("location: ../../../vista/documentos_respaldo/PDFLibroCompras.php");
     else {
     	header("location: ../../../vista/documentos_respaldo/PDFLibroComprasSC.php");
     }
}
else{
	header("HTTP/1.0 401 No autorizado");
	header('Content-Type: text/plain; charset=iso-8859-1');
	echo "No tiene los permisos necesarios ";
}
?>