<?php

session_start();
include_once('../../LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFReporteUOSol.php';



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
	
	$criterio_filtro= $criterio_filtro ."  AND uniorg.id_unidad_organizacional like ''%'' and solcom.id_fina_regi_prog_proy_acti like ''%''
    										and solcom.gestion=2009 
    										and (solcom.fecha_reg>=''01/06/2009''AND solcom.fecha_reg<=''01/14/2009'')
    										and tipadq.tipo_adq like ''%'' and solcom.siguiente_estado like ''%'' and  (select count(soldet.id_solicitud_compra) as total
 from compro.tad_solicitud_compra_det   soldet
 inner join compro.tad_solicitud_compra solcom1 on(solcom1.id_solicitud_compra=soldet.id_solicitud_compra)
 INNER JOIN almin.tal_item item on (item.id_item=soldet.id_item)
 INNER JOIN param.tpm_unidad_medida_base  UNMEBA ON (UNMEBA.id_unidad_medida_base=ITEM.id_unidad_medida_base)
 where  solcom1.id_solicitud_compra= solcom.id_solicitud_compra)<>0";
	
	$UOCabecera = array();
	$UOItem= array();
	
	$i=0;
	$UOCabecera = $Custom-> ListarUOCab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$_SESSION['PDF_UOCabecera']=$Custom->salida;
	$_SESSION['PDF_gestion']=$m_gestion;
	$_SESSION['PDF_fecha_inicio']=$m_fecha_inicio;
	$_SESSION['PDF_fecha_fin']=$m_fecha_fin;
	$_SESSION['PDF_tipo_adq']=$m_tipo_adq;
	$_SESSION['PDF_estado']=$m_estado;
	$_SESSION['PDF_nombre_uo']=$m_nombre_uo;
	$_SESSION['PDF_nombre_ep']=$m_nombre_ep;
	
	foreach ($Custom->salida as $f)
	{
	   $id_unidad_organizacional = $f["id_unidad_organizacional"];
	   $UOItem = $Custom-> ListarUOItems($cant,$puntero,$sortcol,$sortdir,' uniorg.id_unidad_organizacional='.$id_unidad_organizacional,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	   $_SESSION['PDF_UOItems_'.$i]=$Custom->salida;
	   
	   
	   $UOServicio = $Custom-> ListarUOServicios($cant,$puntero,$sortcol,$sortdir,' uniorg.id_unidad_organizacional='.$id_unidad_organizacional,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	   $_SESSION['PDF_UOServicios_'.$i]=$Custom->salida;
	   $i=$i+1;
    }
	 header("location: ../../../vista/_reportes/solicitudes_uo/PDFReporteUOSol.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>