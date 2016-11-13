<?php

session_start();
/*include_once('../../LibModeloTesoreria.php');
$Custom = new cls_CustomDBTesoreria();

$nombre_archivo = 'ActionReporteRendicionViatico.php';



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

if($sort == '') $sortcol = 'VIA.id_empleado';
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
	//echo $id_viatico;exit;
	$criterio_filtro= $criterio_filtro ." AND via.id_viatico=$id_viatico";
	$_SESSION['PDF_id_viatico']=$id_viatico;
	$_SESSION['PDF_sw_cheque']=$sw_cheque;
	//echo $sw_cheque;exit;
	$solicitud = array();
	$solicitud_det = array();
		$solicitud = $Custom-> ListarReporteRendicionViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		
			foreach ($Custom->salida as $f)
			{ 
				$_SESSION['PDF_id_unidad_organizacional'] = $f["id_unidad_organizacional"];
				$_SESSION['PDF_id_destino']=$f["id_destino"];
				$_SESSION['PDF_id_moneda']=$f["id_moneda"];
				$_SESSION['PDF_id_empleado']=$f["id_empleado"];
				$_SESSION['PDF_fecha_inicio']=$f["fecha_inicio"];
				$_SESSION['PDF_fecha_final']=$f["fecha_final"].'';
				$_SESSION['PDF_nro_dias']=$f["nro_dias"];
				$_SESSION['PDF_nombre_unidad']=$f["nombre_unidad"];
				$_SESSION['PDF_destino']=$f["destino"];
				$_SESSION['PDF_moneda']=$f["moneda"];
				$_SESSION['PDF_empleado']=$f["empleado"];
				$_SESSION['PDF_origen']=$f["origen"];
				$_SESSION['PDF_fecha_rinde']=$f["fecha_rinde"];
				$_SESSION['PDF_num_solicitud']=$f["num_solicitud"];
				$_SESSION['PDF_total_hotel']=$f["total_hotel"];
				$_SESSION['PDF_total_otros']=$f["total_otros"];
				$_SESSION['PDF_total_viatico']=$f["total_viatico"];
				
				$_SESSION['PDF_nro_documento']=$f["nro_documento"];
				$_SESSION['PDF_importe_entregado']=$f["importe_entregado"];
				$_SESSION['PDF_nro_cheque']=$f["nro_cheque"];
				$_SESSION['PDF_entidad']=$f["entidad"];
				$_SESSION['PDF_importe_cheque']=$f["importe_cheque"];
			
			}
	$criterio_filtro=' 0=0 ';
	$criterio_filtro="$criterio_filtro AND id_unidad_organizacional=$id_unidad_organizacional";	
		
	$solicitud_det = $Custom-> ListarReporteViaticoEP($cant,$puntero,'nombre_unidad',$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
		
	$_SESSION['PDF_EP_rendicion']=$Custom->salida;
	
	$criterio_filtro=' 0=0 ';
	$criterio_filtro="$criterio_filtro AND uniorg.id_unidad_organizacional = $id_unidad_organizacional ";	
		//echo $criterio_filtro;exit;
	$solicitud_det = $Custom-> ListarNombreGerente($cant,$puntero,'uniorg.id_unidad_organizacional',$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
		
	foreach ($Custom->salida as $f)
			{ 
				$_SESSION['PDF_nombre_nivel']=$f["nombre_nivel"];
				$_SESSION['PDF_id_unidad_organizacional'] = $f["id_unidad_organizacional"];
				$_SESSION['PDF_nombre_cargo']=$f["nombre_cargo"];
				$_SESSION['PDF_nombre_geren']=$f["nombre"];
			}*/
	header("location: PDFRendicionViatico.php");
	//header("location: ../../../vista/agrupador_rendicion_viaticos/PDFRendicionViatico.php");
/*//header("location:  PDFSolicitudViatico.php");
}
else
{
	header("HTTP/1.0 401 No autorizado");
	header('Content-Type: text/plain; charset=iso-8859-1');
	echo "No tiene los permisos necesarios ";
}*/

?>