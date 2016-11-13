<?php

session_start();
include_once('../../LibModeloContabilidad.php');
$Custom = new cls_CustomDBContabilidad();

$nombre_archivo = 'ActionPDFLibrosComprasA.php';



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
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}

	$criterio_filtro = $cond->obtener_criterio_filtro();
	/*echo $criterio_filtro;
	exit;*/
	/*$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'DocumentoValor');
	$sortcol = $crit_sort->get_criterio_sort();
	*/
	$cant=10000000;
	$puntero=0;
	$sortcol='DOC.fecha_documento';
	$sortdir='asc';
	$criterio_filtro="MON.id_moneda=''$id_moneda''";
	$criterio_filtro=$criterio_filtro." and COM.fecha_cbte >= ''$fecha_inicio''";
	$criterio_filtro=$criterio_filtro." and COM.fecha_cbte <= ''$fecha_fin''";
    $id_moneda                =  $id_moneda;
	//$m_id_moneda=$_GET["id_moneda"];
	$Comprobante = array();
	$SumDetalle = array();
	$DocumentosVal= array();
	
	/*$Comprobante = $Custom-> ReporteComprobante($cant,$puntero,'',$sortdir,$criterio_filtro ." AND COMPROB.id_comprobante=$id_comprobante",$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	$_SESSION['PDF_comprobante']=$Custom->salida;
	$i=0;
	$_SESSION['PDF_simbolo_moneda']=$_GET["desc_moneda"];
	$_SESSION['id_moneda']=$m_id_moneda;

foreach ($Custom->salida as $f)
			{   $id_comprobante=$f["id_comprobante"];
			    
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
             
                           
     */         
     /* echo 'moneda'.$_GET['id_moneda'];
      exit;*/
	$Prueba=split("/",$txt_fecha_inicio);
	$Prueba2=split("/",$txt_fecha_fin);
	
	$_SESSION['rep_sci_fecha_inicio']=$Prueba[1]."/".$Prueba[0]."/".$Prueba[2];
	$_SESSION['rep_sci_fecha_fin']=$Prueba2[1]."/".$Prueba2[0]."/".$Prueba2[2];;
	$_SESSION['txt_desc_moneda']=utf8_decode($_GET['txt_desc_moneda']);
 
	$DocumentosVal=$Custom->ActionListarDocumentoIva($cant,$puntero,'DOC.fecha_documento',$sortdir,'0=0',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$txt_fecha_inicio,$txt_fecha_fin,$_GET['id_moneda'],$sw_debito_credito,$id_depto);
                $_SESSION['PDF_Detalle_compras']=$Custom->salida;
                
            
      
        
    header("location: ../../../vista/documentos_respaldo/PDFLibroCompras.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>