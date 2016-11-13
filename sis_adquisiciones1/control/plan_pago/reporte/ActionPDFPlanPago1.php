<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarPlanPago.php
Propósito:				Permite realizar el listado en tad_plan_pago
Tabla:					t_tad_plan_pago
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-28 17:32:19
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../../LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionListarPlanPago .php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'nro_cuota';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> 'si', 'no'
	
	switch ($cod)
	{
		case 'si':
			$decodificar = true;
			break;
		case 'no':
			$decodificar = false;
			break;
		default:
			$decodificar = true;
			break;
	}

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	//$cond->add_criterio_extra("cotiza.id_cotizacion",$m_id_cotizacion);
	$cond->add_criterio_extra("cotiza.id_cotizacion",$m_id_cotizacion);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'PlanPago');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	/*$res = $Custom -> ContarPlanPago($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_id_cotizacion);

	if($res) $total_registros= $Custom->salida;*/
	//lista la cabecera del plan de pago
     $plan_pago= $Custom->RepPlanPagoCab($cant,$puntero,'num_cotizacion',$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_id_cotizacion);
     $_SESSION['PDF_cabecera_plan_pago']=$Custom->salida;
     foreach ($Custom->salida as $f){
				$_SESSION['PDF_num_cotizacion']=$f["num_cotizacion"];
				$_SESSION['PDF_tipo_entrega']=$f["tipo_entrega"];
				$_SESSION['PDF_fecha_entrega']=$f["fecha_entrega"];
				$_SESSION['PDF_precio_total'.$i]=$f["precio_total"];
				$_SESSION['PDF_precio_total_moneda_cotizada']=$f["precio_total_moneda_cotizada"];
				
			}
	//Obtiene el conjunto de datos de la consulta
	$plan_pago_det= $Custom->ListarPlanPagoRep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_id_cotizacion);
	
	$_SESSION['PDF_plan_pago']=$Custom->salida;
		      header("location: ../../../vista/plan_pago/PDFPlanPago.php");
}
else{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}
?>