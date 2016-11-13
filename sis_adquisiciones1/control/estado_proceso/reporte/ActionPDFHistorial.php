<?php

session_start();
include_once('../../LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFHistorial.php';



if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    if($limit == "") $cant = 100;
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


	
	$criterio_filtro= $criterio_filtro ." SOL.id_solicitud_compra=$id_solicitud_compra";
	
	
	$solicitud = array();
	$solicitud_det = array();
	
		$solicitud = $Custom-> ListarHistorialReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		//$_SESSION['PDF_solicitud']=$Custom->salida;
			foreach ($Custom->salida as $f)
			{
				
				$_SESSION['PDF_id_solicitud_compra'] = $f["id_solicitud_compra"];
				$_SESSION['PDF_num_solicitud']=$f["num_solicitud"];
				$_SESSION['PDF_localidad']=$f["localidad"];
				$_SESSION['PDF_fecha_reg']=$f["fecha_reg"];
				$_SESSION['PDF_hora_reg']=$f["hora_reg"];
				$_SESSION['PDF_nombre_unidad']=$f["desc_unidad_organizacional"];
				$_SESSION['PDF_nombre_solicitante']=$f["solicitante"];
				$_SESSION['PDF_nombre_unidad']=$f["desc_unidad_organizacional"];
				$_SESSION['PDF_fecha_min']=$f["fecha_min"];
				$_SESSION['PDF_fecha_max']=$f["fecha_max"];
				$_SESSION['PDF_dias']=$f["dias"];
				$_SESSION['PDF_periodo']=$f["periodo"];
				$_SESSION['PDF_estado_vigente']=$f["estado_vigente"];
				$_SESSION['PDF_categoria']=$f["categoria"];
				$_SESSION['PDF_ep']=$f["ep"];
				$_SESSION['PDF_justificacion']=$f["justificacion"];
								
											
			}
		
		$criterio_filtro="tipo_proceso=''PROCESO'' AND SOL.id_solicitud_compra=$id_solicitud_compra";	
				
		$solicitud_grupo = $Custom-> ListarHistorialGrupo($cant,$puntero,'proceso',$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
				
		
		$_SESSION['PDF_grupo_adq']=$Custom->salida;
				
			
		
			
			header("location: ../../../vista/seguimiento_solicitud/PDFHistorial.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>