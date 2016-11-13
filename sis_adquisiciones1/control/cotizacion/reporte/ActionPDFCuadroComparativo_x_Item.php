<?php

session_start();
include_once('../../LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFListaCompras.php';



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

if($sort == '') $sortcol = 'PROCOM.id_proceso_compra';
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
	
	$criterio_filtro= $criterio_filtro ." AND PROCOM.id_proceso_compra=".$m_id_proceso_compra;
	
	
	
	$Item = array();
	$Proveedores = array();
	$Proveedores_ofertas = array();
	$proveedores_detalle_propuesta=array();
	$i=0;
	/*echo "proceso".$m_id_proceso_compra;
	echo "tipo_adq".$m_tipo_adq;
	exit;*/
		if($tipo_vista=='procesos_finalizados'){
			$estado_cotiza=" "; 
		}else {
			$estado_cotiza=" and  COTIZA.estado_vigente!=''anulado''"; 
		}
	$Proveedores = $Custom-> ListarCCProveedoresDetalle($cant,$puntero," COTIZA.id_proveedor",$sortdir," COTIZA.id_proceso_compra=".$m_id_proceso_compra." $estado_cotiza",$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$_SESSION['PDF_Proveedores']=$Custom->salida;
	$CuaComCab = $Custom-> RepCabCuaComparativo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	$_SESSION['PDF_cuacomcab']=$Custom->salida;
	
	if($m_tipo_adq=='Bien'){
	$Item = $Custom-> ListarCCItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$_SESSION['PDF_Items']=$Custom->salida;
	$_SESSION['PDF_titulo']='Item';
	foreach ($Custom->salida as $f)
			{
             $id_proceso_compra_det=$f["id_proceso_compra_det"];
			$Proveedores = $Custom->ListarCCProveedores($cant,$puntero,$sortcol,$sortdir," cotdet.id_proceso_compra_det=$id_proceso_compra_det $estado_cotiza and COTIZA.estado_reg=''activo'' ",$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);	
              $_SESSION['PDF_proveedores_'.$i]=$Custom->salida;
              $j=0;
                 foreach ($Custom->salida as $f)
			      {
			       $id_cotizacion_det=$f["id_cotizacion_det"];
				   $Provedores_ofertas=$Custom->ListarCCProveedoresOfertas($cant,$puntero," cotdet.id_cotizacion_det",$sortdir," cotdet.id_cotizacion_det=$id_cotizacion_det ",$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
				   $_SESSION['PDF_proveedores_ofertas_'.$i.$j]=$Custom->salida;
				   $proveedores_detalle_propuesta=$Custom->ListarCCProveedoresDetallePropuesta($cant,$puntero," detpro.id_detalle_propuesta",$sortdir," detpro.id_cotizacion_det=$id_cotizacion_det",$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
				   $_SESSION['PDF_detalle_propuesta_'.$i.$j]=$Custom->salida;
			   
				   $j=$j+1;
			      }
              $i=$i+1;  
             }
	
	}else{
		$_SESSION['PDF_titulo']='Servicio';	
		$Servicios = $Custom-> ListarCCServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$_SESSION['PDF_Items']=$Custom->salida;
	
	foreach ($Custom->salida as $f)
			{
             $id_proceso_compra_det=$f["id_proceso_compra_det"];
			$Proveedores = $Custom->ListarCCProveedores($cant,$puntero,$sortcol,$sortdir," cotdet.id_proceso_compra_det=$id_proceso_compra_det",$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);	
              $_SESSION['PDF_proveedores_'.$i]=$Custom->salida;
              $j=0;
                 foreach ($Custom->salida as $f)
			      {
			       $id_cotizacion_det=$f["id_cotizacion_det"];
				   $Provedores_ofertas=$Custom->ListarCCProveedoresServicios($cant,$puntero," cotdet.id_cotizacion_det",$sortdir," cotdet.id_cotizacion_det=$id_cotizacion_det",$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
				   $_SESSION['PDF_proveedores_ofertas_'.$i.$j]=$Custom->salida;
				  
				   $j=$j+1;
			      }
              $i=$i+1;  
             }
	
	
	}
	
	
     	
    header("location: ../../../vista/cotizacion/PDFCuadroComparativo_x_Item.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>