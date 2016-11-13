<?php

session_start();
include_once('../LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();
$CustomA = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFAdjudicacion.php';



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
	
		
	if($m_id_proceso_compra){
		
	$Proceso = array();
	$proveedores=array();
	$Cotizacion_det = array();
	$id_cotizacion=array();
	$tipo;
	
		$j=0;
		$res_adj = $CustomA->ListarCotizacionAdjudicada($m_id_proceso_compra,$tipo);
		
		$_SESSION['adj']=$CustomA->salida;
	
		if($res_adj){
		
			foreach ($CustomA->salida as $f){
			
				$m_id_cotizacion=$f["id_cotizacion"];
				$Proceso= $Custom-> RepAdjudicacionProceso($m_id_cotizacion,1);
				$_SESSION['PDF_proceso'] = $Custom->salida[0][0];
				$_SESSION['PDF_categoria']=$Custom->salida[0][1];
				$_SESSION['PDF_gestion']=$Custom->salida[0][2];
				$_SESSION['PDF_num_proceso']=$Custom->salida[0][3];
				$_SESSION['PDF_observaciones']=$Custom->salida[0][4];
				if($m_id_cotizacion==19701){ //oct2015: en atencion a ENDE-CI-DOSE-10/2-15
					$_SESSION['PDF_uo_adjudicado']='DOSE';
				}else{
					$_SESSION['PDF_uo_adjudicado']=$Custom->salida[0][5];
				}
				
				$minimo=1;
                $maximo=20000;
        //$Custom->salida[0][2] =30000;
                if ($Custom->salida[0][2] > $maximo){
                       //$Custom->salida[0][7]=" ";
                       //$Custom->salida[0]['encargado_adj']=" ";
					  $_SESSION['PDF_RPCDM']=' Lic. Francisco Adolfo Pérez Aramayo';
                }
 
				$Proveedores= $Custom-> RepAdjudicacionProveedores($m_id_cotizacion,2);
				$_SESSION["PDF_proveedores_$j"]=$Custom->salida;
				$_SESSION["id_cotizacion_".$j]=$f["id_cotizacion"];
//	
//				for($i=0;$i<count($Custom->salida);$i++){ 
//					$_SESSION["id_cotizacion_".$]=$Custom->salida[$i][0];
//
//				}
		
		 		$j=$j+1;
				
			}
			 header("location: ../../vista/adjudicacion/PDFAdjudicacion.php");
			
		}
		
	
	}else{
		$_SESSION['adj']=$m_id_cotizacion;
		$j=0;
		$Proceso = array();
		$proveedores=array();
		$Cotizacion_det = array();
		$id_cotizacion=array();
		$Proceso= $Custom-> RepAdjudicacionProceso($m_id_cotizacion,1);
		//$_SESSION['PDF_Cotizacion']=$Custom->salida;
		$_SESSION['PDF_proceso'] = $Custom->salida[0][0];
		$_SESSION['PDF_categoria']=$Custom->salida[0][1];
		$_SESSION['PDF_gestion']=$Custom->salida[0][2];
		$_SESSION['PDF_num_proceso']=$Custom->salida[0][3];
		$_SESSION['PDF_observaciones']=$Custom->salida[0][4];
		if($m_id_cotizacion==19701){ //oct2015: en atencion a ENDE-CI-DOSE-10/2-15
			$_SESSION['PDF_uo_adjudicado']='DOSE';
		}else{
			$_SESSION['PDF_uo_adjudicado']=$Custom->salida[0][5];
		}
		
		$Proveedores= $Custom-> RepAdjudicacionProveedores($m_id_cotizacion,2);
		$_SESSION['PDF_proveedores_0']=$Custom->salida;
		$_SESSION["id_cotizacion_0"]=$m_id_cotizacion;

//		for($i=0;$i<count($Custom->salida);$i++){ 
//
//		      $id_cotizacion[$i]=$Custom->salida[$i][0];
//		      
//		}
		
		 
	     
		 
		 
		 header("location: ../../vista/adjudicacion/PDFAdjudicacion.php");
	}
}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>