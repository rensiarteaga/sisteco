<?php
session_start();
/*
 * Autor: Ana María Villegas Quispe
 * Fecha ultima de modificación:  22-05-2009 
 * Cambio de nombres de sessiones y es específico para Cotizaciones en Blanco.
 */
include_once('../../LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFCotizacion.php';



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
	
	$criterio_filtro= $criterio_filtro ." AND COTIZA.id_proceso_compra=$m_id_proceso_compra";
	

	$Cotizacion = array();
	$Cotizacion_det = array();
	$Solicitud=array();
	
	$Solicitud = $Custom-> RepCabCuaComparativo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	$_SESSION['PDF_solicitud']=$Custom->salida;
	
	
	
	$Cotizacion = $Custom-> ReporteCotizacionSC($cant,$puntero,$sortcol,$sortdir,' PROCOM.id_proceso_compra='.$m_id_proceso_compra,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	       
		    $_SESSION['PDF_eb_tipo_cotizado']='sc';
		    $i=0;
			foreach ($Custom->salida as $f)
			{
				$_SESSION['PDF_eb_fecha_reg_0']=$f["fecha_reg"];
				$_SESSION['PDF_eb_num_cotizacion_0']=$f["num_cotizacion"];
				$_SESSION['PDF_eb_gestion_0']=$f["gestion"];
				$_SESSION['PDF_eb_tipo_adq_0']=$f["tipo_adq"];
				
				$tipo_adq=$f["tipo_adq"];
			}
   
		if($tipo_adq=='Bien'){
		 
		$Cotizacion_det = $Custom-> RepCotizacionDet($cant,$puntero,' ITEM.id_item',$sortdir," prodet.id_proceso_compra=$m_id_proceso_compra",$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$_SESSION['PDF_cotizacion_det_eb']=$Custom->salida;
		$_SESSION['PDF_titulo']='ITEM';
		}else{
			$Cotizacion_det_servicio = $Custom-> RepCotizacionDetServicio($cant,$puntero,' SERVIC.id_servicio',$sortdir," PRODET.id_proceso_compra=$m_id_proceso_compra",$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$_SESSION['PDF_cotizacion_det_eb']=$Custom->salida;
		$_SESSION['PDF_titulo']='SERVICIO';
		
		}
		
		header("location: ../../../vista/cotizacion/PDFCotizacion_x_ProveedorBlanco.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>