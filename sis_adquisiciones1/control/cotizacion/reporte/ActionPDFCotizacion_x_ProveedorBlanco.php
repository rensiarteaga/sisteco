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

if($sort == '') $sortcol = ' COTIZA.id_cotizacion';
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
	/*echo $m_id_proceso_compra."asdfsd";
	exit;
	*/$criterio_filtro= $criterio_filtro ." AND cotiza.id_cotizacion=$m_id_cotizacion ";
	//PROCOM.id_proceso_compra
		//$criterio_filtro= $criterio_filtro ." AND COTIZA.id_proceso_compra=$m_id_proceso_compra";
	/*echo "mmm no se que sera no entra a nada".$m_id_Cotizacion_compra;
	exit;
	*/

/*   echo $m_id_cotizacion;
   exit;
*/
	$Cotizacion = array();
	$Cotizacion_det = array();
	$Solicitud=array();
	
	$Solicitud = $Custom-> RepCabCuaComparativo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	$_SESSION['PDF_solicitud']=$Custom->salida;
	
	
	$Cotizacion = $Custom-> ReporteCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		//$_SESSION['PDF_Cotizacion']=$Custom->salida;
		/*print_r($Custom->salida);
		exit;*/
		    
		    $_SESSION['PDF_cotizaciones']=$Custom->salida;
		    $i=0;
			foreach ($Custom->salida as $f)
			{   $id_proceso_compra=$f["id_proceso_compra"];
				$_SESSION['PDF_id_cotizacion_'.$i] = $f["id_cotizacion"];
				$_SESSION['PDF_id_proceso_compra_'.$i]=$f["id_proceso_compra"];
				$_SESSION['PDF_fecha_reg_'.$i]=$f["fecha_reg"];
				$_SESSION['PDF_num_cotizacion_'.$i]=$f["num_cotizacion"];
				$_SESSION['PDF_nombres_'.$i]=$f["nombres"];
				$_SESSION['PDF_casilla_'.$i]=$f["casilla"];
				$_SESSION['PDF_telefono1_'.$i]=$f["telefono1"];
				$_SESSION['PDF_telefono2_'.$i]=$f["telefono2"];
				$_SESSION['PDF_celular1_'.$i]=$f["celular1"];
				$_SESSION['PDF_celular2_'.$i]=$f["celular2"];
				$_SESSION['PDF_email1_'.$i]=$f["email1"];
				$_SESSION['PDF_email2_'.$i]=$f["email2"];
				$_SESSION['PDF_fax_'.$i]=$f["fax"];
				$_SESSION['PDF_direccion_'.$i]=$f["direccion"];
				$_SESSION['PDF_gestion_'.$i]=$f["gestion"];
				$_SESSION['PDF_tipo_adq_'.$i]=$f["tipo_adq"];
				$_SESSION['PDF_fecha_entrega_'.$i]=$f["fecha_venc"];
				$_SESSION['PDF_lugar_entrega_'.$i]=$f["lugar_entrega"];
				
				$tipo_adq=$f["tipo_adq"];
				$i=$i+1;
			}
      //   if($tipo_adq==''){
         	/*echo "entra aqui?";
         	exit;*/
	/*$Cotizacion = $Custom-> ReporteCotizacionSC($cant,$puntero,$sortcol,$sortdir,' PROCOM.id_proceso_compra='.$m_id_proceso_compra,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
		    $_SESSION['PDF_tipo_cotizado']='sc';
		    $_SESSION['PDF_cotizaciones']=$Custom->salida;
		    $i=0;
			foreach ($Custom->salida as $f)
			{
				$_SESSION['PDF_fecha_reg_0']=$f["fecha_reg"];
				$_SESSION['PDF_num_cotizacion_0']=$f["num_cotizacion"];
				$_SESSION['PDF_gestion_0']=$f["gestion"];
				$_SESSION['PDF_tipo_adq_0']=$f["tipo_adq"];
				$tipo_adq=$f["tipo_adq"];
				}
         }*/
         
		if($tipo_adq=='Bien'){
		 
		$Cotizacion_det = $Custom-> RepCotizacionDet($cant,$puntero,' ITEM.id_item',$sortdir," procom.id_proceso_compra=$id_proceso_compra",$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$_SESSION['PDF_cotizacion_det']=$Custom->salida;
		$_SESSION['PDF_titulo']='ITEM';
		}else{
			$Cotizacion_det_servicio = $Custom-> RepCotizacionDetServicio($cant,$puntero,' SERVIC.id_servicio',$sortdir," PRODET.id_proceso_compra=$id_proceso_compra",$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$_SESSION['PDF_cotizacion_det']=$Custom->salida;
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