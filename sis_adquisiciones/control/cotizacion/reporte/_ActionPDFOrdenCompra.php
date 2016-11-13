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
	if($vista_orden_compra=='rep_orden_compra_np'){
  	$criterio_filtro1= $criterio_filtro ." AND TIPADQ.tipo_adq="."''$tipo_adquisicion''"." and PERIOD.id_periodo= $id_periodo AND COTIZA.num_orden_compra=$nro_orden_compra AND PROCOM.id_depto=$departamento ";
  	$Cotizacion = $Custom->GetIdCotOrdenCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro1,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	foreach($Custom->salida as $f)
	{
	    $m_id_cotizacion=$f["id_cotizacion"];	
	}
	/*echo "cotizacion"."$m_id_cotizacion";
	exit;*/
	 }
	 
	 if($m_id_cotizacion!=''){
	 
	 
	 
  	
 
 /* echo 'vista'.$vista_orden_compra;
  echo 'periodo'.$periodo;
  echo 'orden'.$nro_orden_compra;
  echo 'depto'.$departamento;
 
  echo 'id_gestion'.$id_parametro_adquisicion;
  echo 'tipo_adq'.$tipo_adquisicion;
  exit;*/
	$criterio_filtro= $criterio_filtro ." AND COTIZA.id_cotizacion=$m_id_cotizacion";
	//$criterio_filtro= $criterio_filtro ." AND PROCOM.id_proceso_compra=$m_id_proceso_compra";
	


	$Cotizacion = array();
	$Cotizacion_det = array();
		$Cotizacion = $Custom->ReporteOrdenCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		//$_SESSION['PDF_Cotizacion']=$Custom->salida;
		/*print_r($Custom->salida);
		exit;*/
			foreach ($Custom->salida as $f)
			{
				$_SESSION['PDF_id_cotizacion'] = $f["id_cotizacion"];
				$_SESSION['PDF_id_proceso_compra']=$f["id_proceso_compra"];
				$_SESSION['PDF_fecha_reg']=$f["fecha_reg"];
				$_SESSION['PDF_num_cotizacion']=$f["num_cotizacion"];
				$_SESSION['PDF_nombres']=$f["nombres"];
				$_SESSION['PDF_casilla']=$f["casilla"];
				$_SESSION['PDF_telefono1']=$f["telefono1"];
				$_SESSION['PDF_telefono2']=$f["telefono2"];
				$_SESSION['PDF_celular1']=$f["celular1"];
				$_SESSION['PDF_celular2']=$f["celular2"];
				$_SESSION['PDF_email1']=$f["email1"];
				$_SESSION['PDF_email2']=$f["email2"];
				$_SESSION['PDF_fax']=$f["fax"];
				$_SESSION['PDF_direccion']=$f["direccion"];
				$_SESSION['PDF_gestion']=$f["gestion"];
				$_SESSION['PDF_tipo_adq']=$f["tipo_adq"];
				$_SESSION['PDF_forma_pago']=$f["forma_pago"];
				$_SESSION['PDF_fecha_entrega']=$f["fecha_entrega"];
				$_SESSION['PDF_lugar_entrega']=$f["lugar_entrega"];
				$_SESSION['PDF_nombre_categoria']=$f["nombre"];
				$_SESSION['PDF_observaciones']=$f["observaciones"];
				$_SESSION['PDF_precio_total']=$f["precio_total"];
				$_SESSION['PDF_precio_total_literal']=$f["precio_total_literal"];
				//$_SESSION['PDF_imputacion_contable']=$f["imputacion_contable"];
				$_SESSION['PDF_dias']=$f["dias"];
				$_SESSION['PDF_simbolo']=$f["simbolo"];
				$_SESSION['PDF_codigo_depto']=$f["codigo_depto"];
				$_SESSION['PDF_tipo_entrega']=$f["tipo_entrega"];
				$_SESSION['PDF_nro_generacion_oc']=$f["nro_generacion_oc"];
				$tipo_adq=$f["tipo_adq"];
			}
		if($tipo_adq=='Bien'){
		$Cotizacion_det = $Custom-> RepOrdenCompraDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$_SESSION['PDF_cotizacion_det']=$Custom->salida;
		$_SESSION['PDF_titulo']='ITEM';
		}else{
			$Cotizacion_det_servicio = $Custom-> RepOrdenCompraDetServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$_SESSION['PDF_cotizacion_det']=$Custom->salida;
		$_SESSION['PDF_titulo']='SERVICIO';
		
		}
		
	$solicitudes = $Custom-> RepCabCuaComparativo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	$_SESSION['PDF_solicitudes']=$Custom->salida;
		
		function udate($format, $utimestamp = null)
         {
           if (is_null($utimestamp))
           $utimestamp = microtime(true);

           $timestamp = floor($utimestamp);
            $milliseconds = round(($utimestamp - $timestamp) * 1000000);

            return date(preg_replace('`(?<!\\\\)u`', $milliseconds, $format), $timestamp);
           }
           $hora_oc=udate("H:i:s.u");
		
		
		header("location: ../../../vista/orden_compra/PDFOrdenCompra.php?hora=".udate("H:i:s.u"));
		
		}else{
  	         echo "No existe la cotización ";
        }
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>