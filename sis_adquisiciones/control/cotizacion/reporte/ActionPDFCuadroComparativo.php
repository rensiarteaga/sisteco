<?php

session_start();
include_once('../../LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();


$nombre_archivo = 'ActionPDFCotizacion.php';



if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    if($limit == "") $cant = 1000;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

if($sort == '') $sortcol = 'COTIZA.id_proveedor';
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
	if($tipo_vista=='procesos_finalizados'){
      $criterio_filtro= $criterio_filtro ." AND COTIZA.id_proceso_compra=".$m_id_proceso_compra;		
	}else {
		$criterio_filtro= $criterio_filtro ." AND COTIZA.id_proceso_compra=".$m_id_proceso_compra." and  COTIZA.estado_vigente!=''anulado''";
	}
	
//$criterio_filtro= $criterio_filtro ." AND COTIZA.id_proceso_compra=".$m_id_proceso_compra." ";
	
//$_SESSION['PDF_Cotizacion']=$Custom->salida;
		/*print_r($Custom->salida);
		exit;*/
			/*foreach ($Custom->salida as $f)
			{
				$_SESSION['PDF_id_proveedor'] = $f["id_proveedor"];
				$_SESSION['PDF_id_cotizacion']=$f["id_cotizacion"];
				$_SESSION['PDF_item']=$f["item"];
				$_SESSION['PDF_precio']=$f["precio"];
				$_SESSION['PDF_cantidad']=$f["cantidad"];
				$_SESSION['PDF_precio_total']=$f["precio_total"];
			}*/
		
		//$Cotizacion_det = $Custom-> RepCotizacionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	$CuaComCab=array();
	$Cotizacion = array();
	$Cotizacion_det = array();
	
	$CuaComCab = $Custom-> RepCabCuaComparativo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	$_SESSION['PDF_cuacomcab']=$Custom->salida;
	foreach ($Custom->salida as $f)
			{   $tipo_adq=$f["tipo_adq"];
				}
	/*$a=(2 <3);
    echo "que muestre algo".$a;
    exit;		
    */
	$_SESSION['tipo_adq']=$tipo_adq;
	
	if($tipo_adq=='Bien'){
    $_SESSION['PDF_titulo']='ARTICULO';    	
    $Cotizacion_det = $Custom-> ReporteCotizacion1($cant,$puntero,'COTDET.id_proceso_compra_det',$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
   
    $_SESSION['PDF_cuacom_det']=$Custom->salida;
    }else{
    //aqui tengo que llamar si es servicio de acuerdo al id_proceso el cual ya me fijare jeje
    $_SESSION['PDF_titulo']='SERVICIO';
	$Cotizacion_det_serv = $Custom-> RepCuaComServicio($cant,$puntero,'COTDET.id_proceso_compra_det',$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	$_SESSION['PDF_cuacom_det']=$Custom->salida;
	
	
    }
	//$_SESSION['PDF_cuacom_det']=$Custom->salida;
	$Proveedores=array();
	$Items = array ();
	$Total = array();
	$Plazo = array();
	$Lugar = array();
	$FormaPago = array();
	$TiemVal = array();
	$Garantia = array();
	$Observaciones = array(); 
	$Proveedores = $Custom-> RepProveedoresCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	$m_porcentaje=$Custom->salida[0][5];
	$_SESSION['m_porcentaje']=$m_porcentaje;

	$_SESSION['PDF_proveedores']=$Custom->salida;
	$size_proveedor=count($Custom->salida);
	for($i=0;$i<ceil($size_proveedor/3);$i++)
	{
	foreach ($Custom->salida as $f)
			{   $id_proveedor=$f["id_proveedor"];
			    $cadena_.$i=$id_proveedor.','.$cadena;
			}
//			echo $cadena_.$i;
//			exit;
			
	}				
    $Items = $Custom-> RepItemCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);	
    $_SESSION['PDF_items']=$Custom->salida;
    $Total = $Custom-> RepTotalItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
    $_SESSION['PDF_totales']=$Custom->salida;
    $Plazo = $Custom-> RepPlazoCot($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);    
    $_SESSION['PDF_plazos']=$Custom->salida;
    $Lugar = $Custom-> RepLugarEnt($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
    $_SESSION['PDF_lugares_entrega']=$Custom->salida;
    $FormaPago = $Custom-> RepFormaPago($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
    $_SESSION['PDF_forma_pago']=$Custom->salida;
    $TiemVal = $Custom-> RepTiemVal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
    $_SESSION['PDF_tiempo_validez']=$Custom->salida;
    $Garantia = $Custom-> RepGarantia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
    $_SESSION['PDF_garantia']=$Custom->salida;
    $Observaciones = $Custom-> RepObservaciones($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
    $_SESSION['PDF_observaciones']=$Custom->salida;
    
	
			header("location: ../../../vista/cotizacion/PDFCuadroComparativo.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>