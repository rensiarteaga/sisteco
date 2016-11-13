<?php

session_start();
include_once('../../LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFSolicitud.php';



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

if($sort == '') $sortcol = 'SOLCOM.id_solicitud_compra';
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
	
	$criterio_filtro= $criterio_filtro ." AND SOLCOM.id_solicitud_compra=$m_id_solicitud_compra";
	
	/*echo "mmm no se que sera no entra a nada".$m_id_solicitud_compra;
	exit;
	*/
	$solicitud = array();
	$solicitud_det = array();
		$solicitud = $Custom-> ListarRepSolicitudCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		//$_SESSION['PDF_solicitud']=$Custom->salida;
			foreach ($Custom->salida as $f)
			{ 
				$_SESSION['PDF_id_solicitud_compra'] = $f["id_solicitud_compra"];
				$_SESSION['PDF_num_solicitud']=$f["num_solicitud"];
				$_SESSION['PDF_localidad']=$f["localidad"];
				$_SESSION['PDF_fecha_reg']=$f["fecha_reg"];
				$_SESSION['PDF_hora_reg']=$f["hora_reg"];
				$_SESSION['PDF_nombre_unidad']=$f["nombre_unidad"].'';
				$_SESSION['PDF_nombre_solicitante']=$f["nombre_solicitante"];
				$_SESSION['PDF_nombre_aprobacion']=$f["nombre_aprobacion"];
				$_SESSION['PDF_cargo_empleado_solicitante']=$f["cargo_empleado_solicitante"];
				$_SESSION['PDF_cargo_empleado_aprobador']=$f["cargo_empleado_aprobador"];
				$_SESSION['PDF_nombre_financiador']=$f["nombre_financiador"];
				$_SESSION['PDF_nombre_regional']=$f["nombre_regional"];
				$_SESSION['PDF_nombre_programa']=$f["nombre_programa"];
				$_SESSION['PDF_nombre_proyecto']=$f["nombre_proyecto"];
				$_SESSION['PDF_nombre_actividad']=$f["nombre_actividad"];
				$tipo_adq=$f["tipo_adq"];
				
			}
		if($tipo_adq=='Bien'){
				
		$solicitud_det = $Custom-> ReporteSolicitudCompraDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$_SESSION['PDF_titulo']='BIENES';
		$_SESSION['PDF_solicitud_det']=$Custom->salida;
				
			}else {
			$solicitud_det = $Custom-> ReporteSolicitudCompraDetServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$_SESSION['PDF_titulo']='SERVICIOS';
		$_SESSION['PDF_solicitud_det']=$Custom->salida;
		}
		
	
		/******************/

		
		
		
		
		/******************/
		
		
			
			header("location: ../../../vista/solicitud_compra/PDFSolicitud.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>