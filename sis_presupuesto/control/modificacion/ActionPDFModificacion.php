<?php

/*
 * Nombre:	        ActionPDFActivacionGestion.php
 * Propósito:		Genera un listado para el reporte de modificacion presupuestaria
 * Autor:			Boris Claros Olivera
 *
 */

session_start();

include_once('../LibModeloPresupuesto.php');
//include_once('../../../../lib/lib_control/GestionarExcel.php');
$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionPDFModificacion .php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}

if($_SESSION['autentificado']=="SI")
{	
	//$CustomActivoFijo = new cls_CustomDBActivoFijo();
	$id_modificacion=$id_modificacion;
	
	
	//Parámetros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_modificacion';
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
	/*$cond->add_criterio_extra("PARMOD.id_modificacion",$id_modificacion);
	$cond->add_criterio_extra("PARMOD.tipo_modificacion",$tipo_modificacion);
	*/
	
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	if($id_modificacion)
	{
	    $criterio_filtro2=$criterio_filtro." AND MODIFI.id_modificacion=".$id_modificacion;	
	}
	/*if($m_id_gestion)
	{
	    $criterio_filtro=$criterio_filtro." AND PARAMP.id_gestion=".$m_id_gestion;	
	}
	else 
	{
	    $criterio_filtro=$criterio_filtro." AND PARAMP.gestion_pres=(select max(PARAMP.gestion_pres) from presto.tpr_parametro PARAMP) ";	
	}*/
	
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Modificacion');
	$sortcol = $crit_sort->get_criterio_sort();
	

	if($reporte==0){
	$cabecera = array();
	$cuerpo = array();
	
	//CABECERA
	
	$cabecera = $Custom->ListarModificacion($cant,$puntero,$sortcol,$sortdir,"modifi.id_modificacion = ".$_GET["id_modificacion"],$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	//echo var_dump($Custom); exit;
	
	$_SESSION['PDF_cabecera']=$Custom->salida;
	$cabecera==$Custom->salida;
	//var_dump($cabecera);
	//var_dump($Custom);
	

		
	
	
	
	$i=0;

			
		//$cuerpo = $Custom->ListarPartidaModificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro2,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

		//$_SESSION['PDF_cuerpo']=$Custom->salida;
	
		
	if(!$res)
	{	
		$_SESSION['tipo_modificacion'] = $_GET['tipo_modificacion'];
		$_SESSION['id_modificacion'] = $_GET['id_modificacion'];
		header("location: ../modificacion/PDFModificacion.php");		
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