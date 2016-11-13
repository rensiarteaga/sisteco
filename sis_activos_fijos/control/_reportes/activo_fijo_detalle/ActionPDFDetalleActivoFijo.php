<?php
/*
 * Nombre:	        ActionPDFDetalleDepreciacion.php
 * Prop�sito:		Genera un listado para el reporte a detalle de depreciaciones
 * Autor:			Marcos A. Flores Valda 
 *
 */

session_start();
//include_once("../../rcm_LibModeloAlmacenes.php");
include_once("../../LibModeloActivoFijo.php");
$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionPDFDetalleActivoFijo.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$id_financiador        		=  $txt_id_financiador;
	$id_regional           		=  $txt_id_regional;
	$id_programa           		=  $txt_id_programa;
	$id_proyecto           		=  $txt_id_proyecto;
	$id_actividad          		=  $txt_id_actividad;		
	$id_tipo_activo				=  $txt_id_tipo_activo;
	$id_sub_tipo_activo			=  $txt_id_sub_tipo_activo;
	$id_unidad_organizacional	=  $txt_id_unidad_organizacional;	
	$id_estado_funcional		=  $txt_id_estado_funcional;	
	$estado             		=  $txt_estado;
	$fecha_compra1      		=  $txt_fecha_compra1;
	$fecha_compra2      		=  $txt_fecha_compra2;	
	$ubicacion_fisica			=  $txt_ubicacion_fisica;
	$nombre_descripcion			=  $txt_nombre_descripcion;		
				
	$_SESSION["PDF_financiador"] = $txt_financiador;
	$_SESSION["PDF_regional"] = $txt_regional;
	$_SESSION["PDF_programa"] = $txt_programa;
	$_SESSION["PDF_proyecto"] = $txt_proyecto;
	$_SESSION["PDF_actividad"] = $txt_actividad;
	$_SESSION["PDF_tipo_activo"] = $txt_tipo;
	$_SESSION["PDF_sub_tipo_activo"] = $txt_subtipo;
	$_SESSION["PDF_uni_org"] = $txt_uni_org;
	
	$fc1 = explode("-",$fecha_compra1);
	$_SESSION["PDF_fecha_compra1"] = $fc1[1].'-'.$fc1[0].'-'.$fc1[2];
	
	$fc2 = explode("-",$fecha_compra2);
	$_SESSION["PDF_fecha_compra2"] = $fc2[1].'-'.$fc2[0].'-'.$fc2[2];
	
	if($id_regional == '%')
		$_SESSION["PDF_regional"] = 'Todas las Regionales';
	
	if($id_programa == '%')
		$_SESSION["PDF_programa"] = 'Todos los Programas';
		
	if($id_proyecto == '%')
		$_SESSION["PDF_proyecto"] = 'Todos los Proyectos';
	
	if($id_actividad == '%')
		$_SESSION["PDF_actividad"] = 'Todas las Actividades';
	
	if($id_sub_tipo_activo == '%')
		$_SESSION["PDF_sub_tipo_activo"] = 'Todos los Subtipos de Activos';
		
	if($limit == '') $cant = 10000;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'ACTIVO.codigo';	
	
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;
	
	//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET) valores permitidos de $cod -> 'si', 'no'
	
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
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
		
	$criterio_filtro = $cond -> obtener_criterio_filtro();	
	
	$criterio_filtro = $criterio_filtro." and frppa.id_financiador like ''".$id_financiador."''";
	$criterio_filtro = $criterio_filtro." and frppa.id_regional like ''".$id_regional."''";
	$criterio_filtro = $criterio_filtro." and frppa.id_programa like ''".$id_programa."''";
	$criterio_filtro = $criterio_filtro." and frppa.id_proyecto like ''".$id_proyecto."''";
	$criterio_filtro = $criterio_filtro." and frppa.id_actividad like ''".$id_actividad."''";
	$criterio_filtro = $criterio_filtro." and tipo.id_tipo_activo like ''".$id_tipo_activo."''";
	$criterio_filtro = $criterio_filtro." and sub.id_sub_tipo_activo like ''".$id_sub_tipo_activo."''";
	if($id_unidad_organizacional!=''){
		$criterio_filtro = $criterio_filtro." and uniorg.id_unidad_organizacional like ''".$id_unidad_organizacional."''";	
	}
	$criterio_filtro = $criterio_filtro." and ef.id_estado_funcional like ''".$id_estado_funcional."''";
	$criterio_filtro = $criterio_filtro." and activo.estado like ''".$estado."''";
	$criterio_filtro = $criterio_filtro." and ACTIVO.fecha_compra >= ''$fecha_compra1'' and ACTIVO.fecha_compra <= ''$fecha_compra2''"; 
	//$criterio_filtro = $criterio_filtro." and HISASI.estado = ''activo''";
	
	if($ubicacion_fisica!='')
		$criterio_filtro=$criterio_filtro." and lower(activo.ubicacion_fisica) LIKE  lower(''%$ubicacion_fisica%'')";
		
	//criterio_estado		
	if($nombre_descripcion == 'Nombre')
		$res = $Custom-> ReporteDetalleAFNom($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		
	if($nombre_descripcion == 'Descripcion')
		$res = $Custom-> ReporteDetalleAFDesc($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
			
	//echo var_dump($Custom);	exit;
			
//	$fcompra = explode("-",$Custom->salida[0]["fecha_compra"]); 
//	
//	$Custom->salida[0]["fecha_compra"] = $fcompra[2].'-'.$fcompra[1].'-'.$fcompra[0];
	
	$_SESSION["PDF_detalle_af"] = $Custom->salida;
				
	if($res)
		$total_registros= $Custom->salida;			
		
	if($res)
	{		
		header("location: ../../../vista/_reportes/activo_fijo_detalle/PDFDetalleActivoFijo.php");		
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