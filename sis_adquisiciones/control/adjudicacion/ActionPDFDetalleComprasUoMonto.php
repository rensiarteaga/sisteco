<?php
session_start();
include_once('../LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();
$CustomA = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFDetalleComprasUoMonto.php';



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

	//$criterio_filtro = $cond->obtener_criterio_filtro();
	

	if($tipo_reporte==1){
		
		$criterio_filtro="cotiza.fecha_orden_compra>= ''$fecha_ini''";
		$criterio_filtro=$criterio_filtro."  AND cotiza.fecha_orden_compra<= ''$fecha_fin''";
		
		
		if($tipo_adquisicion=='Bien'){
			$criterio_filtro=$criterio_filtro."  AND cotdet.id_item_aprobado IS NOT NULL ";
			// echo "bien"; exit;
			
		} elseif ($tipo_adquisicion=='Servicio'){
	    		$criterio_filtro=$criterio_filtro."  AND cotdet.id_servicio IS NOT NULL ";
	    		
	    	//echo "servicio"; exit;	
	    		
	    	}
		
		if($id_proveedor!='%' && $id_proveedor!='' ){
			$criterio_filtro=$criterio_filtro.'  AND cotiza.id_proveedor='.$id_proveedor;
		}
		
		if(isset($id_parti) && $id_parti!=''){
			if($id_parti!='%'){
				$criterio_filtro=$criterio_filtro.'  AND partid.id_partida='.$id_parti;
			}
		}
		 
		$_SESSION["PDF_id_partida"]=$id_parti;
		
		if($rango_monto=='mayores'){
			$criterio_filtro=$criterio_filtro. ' AND cotiza.precio_total >='. $importe;
		}
		elseif ($rango_monto=='menores'){
				$criterio_filtro=$criterio_filtro. ' AND cotiza.precio_total <'. $importe;
		}
		
		$_SESSION["PDF_filtro"]=$rango_monto;
		$_SESSION["PDF_importe"]=$importe;
		
		if($id_unidad_organizacional != '' && $id_unidad_organizacional!='%'){
			$criterio_filtro=$criterio_filtro.'  and s.id_unidad_organizacional='.$id_unidad_organizacional;
		}
		
		//echo 'criterio:'.$criterio_filtro; exit;
	}
	
	
	
	$_SESSION['detalle']='DETALLE DE COMPRAS -  '.$_GET["unidad_organizacional"];
	$_SESSION['detalle_fechas']= $tipo_adquisicion.' '. $rango_monto.' a '.$importe.' ('. $fecha_ini.' al '. $fecha_fin.')';
	//if($m_id_proceso_compra){
		
	$Proceso = array();
	$proveedores=array();
	$Cotizacion_det = array();
	$id_cotizacion=array();
	$tipo;
	
		$j=0;
		$res_adj = $CustomA->ListarDetalleComprasUoMonto($criterio_filtro,$tipo_reporte);
		
		
		
		$_SESSION['PDF_proveedores']=$CustomA->salida;
		
		
		if($res_adj){
		
			foreach ($CustomA->salida as $f){
			
				$m_id_cotizacion=$f["id_cotizacion"];
				
				
				//$Proveedores= $Custom-> ListarDetalleComprasUoMonto($criterio_filtro,$tipo_reporte);
				//$_SESSION["PDF_proveedores_".$j]=$Custom->salida;
				//$_SESSION["id_cotizacion_".$j]=$f["id_cotizacion"];

				
		 		$j=$j+1;
		 		header("location: ../../vista/adjudicacion/PDFDetalleComprasUoMonto.php");
			}
			
			
		}
		
	
	//}
}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>