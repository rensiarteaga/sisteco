<?php

session_start();
include_once('../../LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFListaPlanilla.php';
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
	if($en_planilla=='no'){
		$num_sol="  AND PLA.id_plan_pago not in (select id_plan_pago from compro.tad_plan_pago pp inner join compro.tad_planilla pl on pp.id_planilla=pl.id_planilla
                                                        where (pl.estado_reg=''borrador'' or pl.estado_reg=''pendiente'')) and PLA.estado=''pendiente''
                           ";
	}else{
		if($en_planilla=='si'){
			$num_sol=" inner join compro.tad_plan_pago PP on PP.id_cotizacion=c.id_cotizacion
		           inner join sci.tct_plantilla PLANT on PLANT.tipo_plantilla=PLA.tipo_plantilla
                   inner join compro.tad_planilla PLANIL on PLANIL.id_planilla=PP.id_planilla and PP.id_planilla=$m_id_planilla AND PLA.id_planilla=PLANIL.id_planilla";
		}else{
			
			    
			$num_sol=" AND c.id_depto_tesoro=$m_id_depto_tesoro AND c.id_cotizacion not in (select id_cotizacion from compro.tad_plan_pago pp inner join compro.tad_planilla pl on pp.id_planilla=pl.id_planilla where pp.id_planilla>0 and (pl.estado_reg=''borrador'' or pl.estado_reg=''pendiente'')) and PLA.estado=''pendiente'' ";
		}
	}

	
	$criterio_filtro = $cond -> obtener_criterio_filtro();

	
	//Obtiene el criterio de orden de columnas
	if($sortcol=='numeracion_periodo'){
		$sortcol='num_cotizacion';
	}
	elseif($sortcol=='numeracion_oc'){
		$sortcol='num_orden_compra';
	}else{
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Cotizacion');
	$sortcol = $crit_sort->get_criterio_sort();
	}
	/*echo 'llega $_POST[m_descripcion]'.$_POST['m_descripcion'];
	echo 'llega $_GET[m_descripcion]'.$_GET['m_descripcion'];
	echo 'llega $m_descripcion'.$m_descripcion;
	exit;*/
	$_SESSION['descripcion']=$m_descripcion;
	$_SESSION['gestion']=$m_gestion;
	$_SESSION['periodo']=$m_periodo;
		
	$res = $Custom->ListarConsultores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$num_sol);
	$_SESSION["PDF_array_consultores"]=$Custom->salida;

	header("location: ../../../vista/planilla/PDFPlanillaConsultores.php");
		
		
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>