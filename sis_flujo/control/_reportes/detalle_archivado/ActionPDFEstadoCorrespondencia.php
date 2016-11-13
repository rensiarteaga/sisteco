<?php
session_start();

include_once('../../LibModeloFlujo.php');
$Custom = new cls_CustomDBFlujo();

$nombre_archivo = 'ActionPDFEstadoCorrespondencia.php';

//Se valida la autentificación
if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=='SI')
{
	if($limit == "") $cant = 15;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'uo.nombre_unidad';
	else $sortcol = $sort;

	if($dir == "") $sortdir = 'asc';
	else $sortdir = $dir;
	
	//Se valida el método de paso de variables del formulario
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$fecha_inicio=$_POST['fecha_inicio']; 
		$fecha_fin=$_POST['fecha_fin'];
		$tipo_reporte=$_POST['tipo_reporte'];
		$id_unidad_organizacional=$_POST['id_unidad_organizacional'];
		
	} 
	else 
	{
		$fecha_inicio=$_GET['fecha_inicio'];
		$fecha_fin=$_GET['fecha_fin'];
		$tipo_reporte=$_GET['tipo_reporte'];
		$id_unidad_organizacional=$_GET['id_unidad_organizacional'];
	}
  			
	//echo $id_unidad_organizacional; exit;

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
	
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	
	$criterio_filtro= $criterio_filtro." corr.id_uo like ''$id_unidad_organizacional'' and corr.fecha_reg >= ''$fecha_inicio'' and corr.fecha_reg <= ''$fecha_fin'' ";
	
	$res = $Custom-> ListarEstadoCorrespondencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);

	//echo var_dump($Custom); exit;
	
	$_SESSION['id_uo'] = $id_unidad_organizacional;
	$_SESSION['desde'] = $fecha_inicio;
	$_SESSION['hasta'] = $fecha_fin;
	$_SESSION['datos'] = $Custom->salida;	

	if($tipo_reporte == 0)
	{
		header("location: ../../../control/_reportes/estado_correspondencia/PDFEstadoCorrespondencia.php");
	}
	else 
	{
		header("location: ../../../control/_reportes/estado_correspondencia/XLSEstadoCorrespondencia.php");
	}
}
else
{
	header("HTTP/1.0 401 No autorizado");
	header('Content-Type: text/plain; charset=iso-8859-1');
	echo "No tiene los permisos necesarios ";
}
?>
