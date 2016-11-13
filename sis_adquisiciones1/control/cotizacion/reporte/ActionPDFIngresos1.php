<?php

session_start();

/*include_once("../../../../sis_almacenes/control/rcm_LibModeloAlmacenes.php");
$nombre_archivo = 'ActionPDFIngresos1.php';
$Custom = new cls_CustomDBAlmacenes();*/

/*<?php
*/
session_start();
include_once('../../LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFIngresos1.php';



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

if($sort == '') $sortcol = 'INGRES.id_cotizacion';
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
	
	$criterio_filtro= $criterio_filtro ." AND INGRES.id_cotizacion=".$m_id_cotizacion;
	/*echo $criterio_filtro;
	exit;*/
	//aqui sacare todo lo referente a los ingresos bueno ira a la misma consulta solo que sacara todos los ingresos de cotización.
	$ingresos=array();
	$ingresos= $Custom->ReporteIngresoAlmacen($cant,$puntero,$sortcol,$sortdir,'INGRES.id_cotizacion='.$m_id_cotizacion,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		//print_r($Custom->salida);
	
	$i=0;
	$_SESSION['PDF_ingresos']=$Custom->salida;
	foreach ($Custom->salida as $f)
			{   $id_ingreso=$f["id_ingreso"];
				$_SESSION['PDF_nombre_almacen_'.$i] = $f["nombre_almacen"];
				$_SESSION['PDF_correlativo_ing_'.$i]=$f["correlativo_ing"];
				$_SESSION['PDF_num_factura_'.$i]=$f["num_factura"];
				$_SESSION['PDF_fecha_factura_'.$i]=$f["fecha_factura"];
				$_SESSION['PDF_fecha_finalizado_cancelado_'.$i]=$f["fecha_finalizado_cancelado"];
				$_SESSION['PDF_origen_'.$i]=$f["origen"];
				$_SESSION['PDF_descripcion_'.$i] = $f["descripcion"];
				$_SESSION['PDF_responsable_'.$i]=$f["responsable"];
				$_SESSION['PDF_almacenero_'.$i]=$f["almacenero"];
				$_SESSION['PDF_jefe_almacen_'.$i]=$f["jefe_almacen"];
				$_SESSION['PDF_fecha_reg_'.$i]=$f["fecha_reg"];
				$_SESSION['PDF_observaciones_'.$i]=$f["observaciones"];
				$_SESSION['PDF_proveedor_'.$i]=$f["proveedor"];
				$_SESSION['PDF_fecha_'.$i]=$f["fecha"];
				
				$_SESSION['PDF_remision_'.$i]=$f["remision"];
				
				$_SESSION['PDF_num_cotizacion_'.$i]=$f["num_cotizacion"];
				$_SESSION['PDF_num_proceso_'.$i]=$f["num_proceso"];
				$_SESSION['PDF_num_solicitud_'.$i]=$f["num_solicitud"];
				/*$_SESSION['PDF_gestion_'.$i]=$f["gestion"];
				$_SESSION['PDF_tipo_adq_'.$i]=$f["tipo_adq"];
		      */
		        $sum_total=array();
	                $sum_total= $Custom->IngresoDetSum($cant,$puntero,$sortcol,$sortdir,'INGDET.id_ingreso='.$id_ingreso,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	$_SESSION['PDF_IngresoDetSum_'.$i]=$Custom->salida;
		        
		        
				$Custom->ReporteIngresoDetalle($cant,$puntero,'INGDET.id_ingreso',$sortdir,'INGDET.id_ingreso ='.$id_ingreso,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
				$_SESSION['PDF_det_ingreso_'.$i]=$Custom->salida;
				
					
		//echo "generaaaaaaaa".$Custom->salida;
		//exit;
				
				$i=$i+1;

			}
	
	
	
    
	
			header("location: ../../../vista/cotizacion/PDFIngresos1.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>