<?php
session_start();
include_once('../LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();
$CustomA = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFCertificacionPpto_x_proc';



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

if($sort == '') $sortcol = 'id_proceso_compra';
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
	
		
	if($m_id_proceso_compra){
		
	$Proceso = array();
	$partida_det=array();
	$proveedores=array();
	$Cotizacion_det = array();
	$id_cotizacion=array();
	$tipo;
	
		$j=0;
		$res_adj = $CustomA->ListarCotizacionAdjudicada($m_id_proceso_compra,$tipo);
		
		$_SESSION['adj']=$CustomA->salida;
		
		if($res_adj){
		
			foreach ($CustomA->salida as $f){
			
				$m_id_solicitud_compra=$f["id_cotizacion"];
				//print_r($CustomA->salida); exit;
				//$partida_det=$Custom->RepPartidaProceso($m_id_solicitud_compra,2);
//				echo $Custom->salida;
//				exit;
				
				$Proceso= $Custom->  RepSolicitudProceso($m_id_proceso_compra,$m_id_solicitud_compra,1);
				$_SESSION["PDF_solicitudes_$j"]=$Custom->salida;
				
				
				$_SESSION["id_solicitud_compra_$j"]=$f["id_solicitud_compra"];
//				$_SESSION["id_proceso_compra"]=$m_id_proceso_compra;
			
				
			
//				$_SESSION['PDF_proceso'] = $Custom->salida[0][0];
//				$_SESSION['PDF_categoria']=$Custom->salida[0][1];
//				$_SESSION['PDF_gestion']=$Custom->salida[0][2];
//				$_SESSION['PDF_num_proceso']=$Custom->salida[0][3];
//				$_SESSION['PDF_observaciones']=$Custom->salida[0][4];
//				$Proveedores= $Custom-> RepAdjudicacionProveedores($m_id_cotizacion,2);
//				$_SESSION["PDF_proveedores_$j"]=$Custom->salida;
//				$_SESSION["id_cotizacion_".$j]=$f["id_cotizacion"];
	
//				for($i=0;$i<count($Custom->salida);$i++){ 
//					$_SESSION["id_cotizacion_".$]=$Custom->salida[$i][0];
//
//				}
		
		 		$j=$j+1;
				
			}
			
			header("location: ../../vista/proceso_compra/PDFCertificacionPpto.php?hora=".date('H:i:s'));
			
		}
		
	
	}
}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>