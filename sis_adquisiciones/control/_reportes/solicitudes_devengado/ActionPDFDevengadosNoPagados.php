
<?php

session_start();
include_once('../../LibModeloAdquisiciones.php');
/**
 * Autor: Ana Maria VQ
 * Fecha de mod: 13/01/2012
 * Descripción: Detalle de Lista de Devengados
 * **/

$Custom = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFSolicitudTiemposEstados.php';

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

	if($dir == "") $sortdir  = 'asc';
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
	

   
   $criterio_filtro= " AND tipadq.tipo_adq=''".$tipo_adq."'' AND  plapag.fecha_devengado between ''".$txt_fecha_desde."'' and ''".$txt_fecha_hasta."'' ";
   
   $UOCabecera = array();
	$UOItem= array();
	
	/*echo 'gestion:'.$gestion.'fecha_ ini :'.$txt_fecha_desde.'fecha_fin'.$txt_fecha_hasta.'tipo'.$tipo_adq;
	exit;*/
	$_SESSION['PDF_gestion']=$gestion;
	//$_SESSION['PDF_estado']=$estado;
	$_SESSION['PDF_fecha_inicio']=$txt_fecha_desde;
	$_SESSION['PDF_fecha_fin']=$txt_fecha_hasta;
	$_SESSION['PDF_tipo_adq']=$tipo_adq;
    if ($_SESSION['PDF_tipo_adq']=='Bien')
    {
    	$_SESSION['PDF_titulo']='BIENES';
    }else {
    	$_SESSION['PDF_titulo']='SERVICIOS';
    }
	//$_SESSION['PDF_tipo_adq']='Servicio';
	$_SESSION['PDF_estado']=$estado;
	$i=0;
	//$SETDetalle = $Custom->ListarSolEstadosTiemposDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro." and tipadq.tipo_adq like ''$tipo_adq''",$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$txt_fecha_desde,$txt_fecha_hasta,$tipo_adq);
	$SETDetalle = $Custom->ListarDevengadosNoPagados($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	
	$_SESSION['PDF_SETDetalle']=$Custom->salida;
	

	 header("location: ../../../vista/_reportes/solicitudes_devengados/PDFDevengadosNoPagados.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>