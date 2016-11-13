<?php

session_start();
include_once('../../LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFActaApertura.php';



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
	$_SESSION['PDF_descripcion']=$m_descripcion;
	
	$Acta= array();
    $Acta = $Custom-> RepActaApertura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		 
			foreach ($Custom->salida as $f)
			{   $_SESSION['PDF_observaciones'] = $f["observaciones"];
				$_SESSION['PDF_num_convocatoria'] = $f["num_convocatoria"];
				$_SESSION['PDF_nombre_unidad']=$f["nombre_unidad"];
				$_SESSION['PDF_precio_total']=$f["precio_total"];
				$_SESSION['PDF_literal_precio_total'] = $f["literal_precio_total"];
				$_SESSION['PDF_tipo_adq'] = $f["tipo_adq"];
				$_SESSION['PDF_observaciones_acta'] = $f["observaciones_acta"];
				
			}
			
	$Proveedores = $Custom-> RepProveedoresCotizacion($cant,$puntero,"COTIZA.id_proveedor",$sortdir, " COTIZA.id_proceso_compra=".$m_id_proceso_compra." and  COTIZA.estado_vigente!=''anulado''",$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	$_SESSION['PDF_proveedores_acta']=$Custom->salida;
    
	
			header("location: ../../../vista/cotizacion/PDFActaApertura.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>