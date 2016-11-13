<?php

/*
 * Nombre:	        ActionPDFActivacionGestion.php
 * Propósito:		Genera un listado para el reporte de Activacion de Activos fijos por gestion
 * Autor:			Boris Claros Olivera
 *
 */

session_start();

include_once("../../LibModeloActivoFijo.php");
//include_once('../../../../lib/lib_control/GestionarExcel.php');
$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionPDFActivacionGestion.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}

if($_SESSION['autentificado']=="SI")
{	$CustomActivoFijo = new cls_CustomDBActivoFijo();
	
	$id_financiador = $txt_id_finaciador;
	$id_regional = $txt_id_regional;
	$id_programa = $txt_id_programa;
	$id_proyecto = $txt_id_proyecto;
	$id_actividad = $txt_id_actividad;
	$id_tipo_activo = $txt_id_tipo_activo;
	$id_sub_tipo_activo = $txt_id_sub_tipo_activo;
	$id_gestion=$txt_id_gestion;
	$reporte=$txt_tipo_reporte;
	$id_activo_fijo = $txt_id_activo;	
	
	$financiador=$txt_financiador;
	$regional=$txt_regional;	
	$programa=$txt_programa;
	$proyecto=$txt_proyecto;
	$actividad=$txt_actividad;
	
	$tipo = $txt_tipo;
	$subtipo = $txt_subtipo;
	$descripcion = $txt_descripcion;	
	$codigo = $txt_codigo;
	$descripcion_larga =$txt_descripcion_larga;
	$monto_compra =$txt_monto_compra;	
	$vida_util_original =$txt_vida_util_original;
	$fecha_inidep =$txt_fecha_ini_dep;
	$gestion=$txt_gestion;
	//echo $gestion;	exit;
  
	$gestion = (String)$gestion;  
  	$id_tipo_activo = (String)$id_tipo_activo;
  	$id_sub_tipo_activo = (String)$id_sub_tipo_activo;
	
	//echo gettype($gestion); exit;
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
	
	
	if($reporte==0){
	$cabecera = array();
	$cuerpo = array();
	
	//CABECERA
	
	$cabecera = $Custom-> Cabecera_rep_act_gestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_activo_fijo,$gestion, $id_tipo_activo, $id_sub_tipo_activo);	
	$_SESSION['PDF_cabecera']=$Custom->salida;
	
	$i=0;

			
		$cuerpo = $Custom-> Cuerpo_rep_act_gestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_activo_fijo,$gestion, $id_tipo_activo, $id_sub_tipo_activo);

		$_SESSION['PDF_cuerpo']=$Custom->salida;
	
	$_SESSION['PDF_financiador'] = $financiador;
	$_SESSION['PDF_regional'] = $regional;
	$_SESSION['PDF_programa'] = $programa;
	$_SESSION['PDF_proyecto'] = $proyecto;
	$_SESSION['PDF_gestion'] = $gestion;
	$_SESSION['PDF_actividad'] = $actividad;
	$_SESSION['PDF_tipo']=$tipo;
	$_SESSION['PDF_subtipo']=$subtipo;		
	$_SESSION['PDF_gestion']=$gestion;
	
		
	if(!$res)
	{		
		header("location: ../../../vista/_reportes/activacion_gestion/PDFActivacionGestion.php");		
	}
	}
	else {  ////inicio el excel
		echo 'LO SIENTO ESTAMOS TRABAJANDO';  
		/*
		$titulo_reporte_excel='ReporteExcel.xls';
		//--jgl inicio
	$cond = new cls_criterio_filtro($decodificar);
		if (sizeof($_GET) > 0){
	 
		$CantFiltros=$_GET["CantFiltros"];
		$nro_columnas=$_GET["nro_columnas"];		
		$titulo_reporte_excel=$_GET["titulo_reporte_excel"];		
		$get=true;
	}
	if (sizeof($_POST) > 0){
		$CantFiltros=$_POST["CantFiltros"];
		$nro_columnas=$_POST["nro_columnas"];	
		$titulo_reporte_excel=$_POST["titulo_reporte_excel"];		
		$get=false;
	}
	
	for($i=0;$i<$CantFiltros;$i++){ 		
		$cond->add_condicion_filtro($_GET["filterCol_$i"], $_GET["filterValue_$i"], $_GET["filterAvanzado_$i"]);
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	//--jgl fin
	
	//--jgl inicio
 if ($reporte_excel=='si')
	{	//recupera los valores de las columnas
		for($i=0;$i<$nro_columnas;$i++){
			$datosCabecera['valor'][$i]=$financiador;
			$datosCabecera['columna'][$i]=$_GET["columna_$i"];
			$datosCabecera['align'][$i]=$_GET["align_$i"];
			$datosCabecera['width'][$i]=$_GET["width_$i"];		
		}	
		$Excel = new GestionarExcel();
		$Excel->SetNombreReporte($titulo_reporte_excel);
		
		$Excel->SetHoja("Hoja 1 Datos");
		$Excel->SetFila(3);
		$cant=100000000;
		$puntero=0;
		 
		$Excel->SetTitulo($titulo_reporte_excel,0,3,$nro_columnas); //Colocamos el titulo al reporte
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
		//$_GET['id_partida'],$_GET['id_moneda'],$_GET['fecha_inicio_b'],$_GET['id_presupuesto']
	//	echo $_GET["id_partida"]." m=".$_GET["id_moneda"]." f=".$fecha_inicio_b." p=".$id_presupuesto."get=".$_GET['fecha_inicio_b'];exit;
//		$res = $Custom->LibroMayorPartidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$_GET['id_partida'],$_GET['id_moneda'],$_GET['fecha_inicio_b'],$_GET['id_presupuesto']); 
		$res = $Custom->Cuerpo_rep_act_gestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_activo_fijo,$gestion, $id_tipo_activo, $id_sub_tipo_activo);
	 
		$Excel->setDetalle($Custom->salida);
		$Excel->setFin();		
		}
	*/
		
	}
}
///
else
{
	header("HTTP/1.0 401 No autorizado");
	header('Content-Type: text/plain; charset=iso-8859-1');
	echo "No tiene los permisos necesarios";
}
?>