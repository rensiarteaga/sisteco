<?php

/*
 * Nombre:	        ActionPDFDetalleDepreciacion.php
 * Propósito:		Genera un listado para el reporte a detalle de depreciaciones
 * Autor:			Marcos A. Flores Valda 
 *
 */

session_start();

include_once("../../LibModeloActivoFijo.php");
$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionPDFDetalleDepreciacion.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}

if($_SESSION['autentificado']=="SI")
{	
	$id_financiador = $txt_id_finaciador;
	$id_regional = $txt_id_regional;
	$id_programa = $txt_id_programa;
	$id_proyecto = $txt_id_proyecto;
	$id_actividad = $txt_id_actividad;
	$id_tipo_activo = $txt_id_tipo_activo;
	$id_sub_tipo_activo = $txt_id_sub_tipo_activo;
	$id_activo_fijo = $txt_id_activo_fijo;
		
	$fecha_desde = $txt_fecha_desde;
	$fecha_hasta = $txt_fecha_hasta;	
	$tipo = $txt_tipo;
	$subtipo = $txt_subtipo;
	$descripcion = $txt_descripcion;	
	$codigo = $txt_codigo;
	$descripcion_larga =$txt_descripcion_larga;
	$monto_compra =$txt_monto_compra;	
	$vida_util_original =$txt_vida_util_original;
	$fecha_inidep =$txt_fecha_ini_dep;	
    
	$v_fechainidep = explode("-",$fecha_inidep); 
	$fecha_inidep = $v_fechainidep[2].'-'.$v_fechainidep[1].'-'.$v_fechainidep[0];
	
	$vfecha_desde = explode("-",$fecha_desde); 
	$fecha_desde = $vfecha_desde[1].'-'.$vfecha_desde[0].'-'.$vfecha_desde[2];
	
	$vfecha_hasta = explode("-",$fecha_hasta); 
	$fecha_hasta = $vfecha_hasta[1].'-'.$vfecha_hasta[0].'-'.$vfecha_hasta[2];
	
	//cambio de formato de fechas de dd-mm-YYYY a mm-dd-YYYY
	$fecha_desde=$vfecha_desde[0].'-'.$vfecha_desde[1].'-'.$vfecha_desde[2];
	$fecha_hasta = $vfecha_hasta[0].'-'.$vfecha_hasta[1].'-'.$vfecha_hasta[2];
	
	if($limit == '') $cant = 30000;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = '0=0';
	
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
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	$cabecera = array();
	$cuerpo = array();
	
	//CABECERA
	
	$cabecera = $Custom-> Cabecera_rep_det_dep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_activo_fijo,$fecha_desde,$fecha_hasta);
	
	$_SESSION['PDF_cabecera']=$Custom->salida;
	
	$i=0;
	
	foreach ($Custom->salida as $f)
	{ 
		$id_activo_fijo_det = $f["id_activo_fijo"];		
				
		//CUERPO
		
		$cuerpo = $Custom-> Cuerpo_rep_det_dep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_activo_fijo,$fecha_desde,$fecha_hasta);
		
//		echo var_dump($Custom);
//		exit;
			
		$_SESSION['PDF_cuerpo_'.$i]=$Custom->salida;
				
		$i= $i + 1;
	}
	
	$suma = $Custom-> SumaDatosDetDep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_activo_fijo,$fecha_desde,$fecha_hasta);
	
	$_SESSION['PDF_sumas']=$Custom->salida;
	
	$_SESSION['PDF_codigo'] = $f["codigo"];
	$_SESSION['PDF_descripcion'] = $f["descripcion"];
	$_SESSION['PDF_descripcion_larga']=$f["descripcion_larga"];				
	$_SESSION['PDF_monto_compra']=$f["monto_compra"].'';
	$_SESSION['PDF_vida_util_original']=$f["vida_util_original"];
	$_SESSION['PDF_fecha_inidep']=$f["fecha_inidep"];	
	$_SESSION['PDF_fecha_desde']=$fecha_desde;
	$_SESSION['PDF_fecha_hasta']=$fecha_hasta;
	$_SESSION['PDF_tipo']=$tipo;
	$_SESSION['PDF_subtipo']=$subtipo;		
		
	if(!$res)
	{		
		header("location: ../../../vista/_reportes/detalle_depreciacion/PDFDetalleDepreciacion.php");		
	}
}
else
{
	header("HTTP/1.0 401 No autorizado");
	header('Content-Type: text/plain; charset=iso-8859-1');
	echo "No tiene los permisos necesarios";
}
?>