<?php
session_start();
include_once('../LibModeloKardexPersonal.php');
//include_once("../../modelo/cls_CustomDBKardexPersonal.php");
$Custom = new cls_CustomDBKardexPersonal();

$nombre_archivo = 'ActionPDFPlanillaImpositivaAreas.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 30000;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_planilla';
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
	
    //echo $gestion;
    //exit;
    //listar la cabecera el reporte
    $puntero= $m_id_planilla;
    
	$res = $Custom->ListarRepPlanillaCab($cant,$puntero,$sortcol,$sortdir," planil.id_planilla=".$m_id_planilla,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		
	$_SESSION["PDF_cab_rep_planilla_areas"]=$Custom->salida;
	//print_r()
	//;
	$res_detalle = $Custom->ListaPlanillaImpositivaAreas($cant,$puntero,$sortcol,$sortdir,' emppla.id_planilla=47  ',$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$_SESSION["PDF_lista_planilla_impositiva_areas"]=$Custom->salida;
	if($res) $total_registros= $Custom->salida;
	 if($res)
	 {
		header("location:../../vista/_reportes/planilla/PDFPlanillaImpositivaAreas.php");
	 }
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true,'406');
		$resp->mensaje_error = $Custom->salida[1];
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;
		echo $resp->get_mensaje();
		exit;
	}
}
else
{
	    header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";

}
?>