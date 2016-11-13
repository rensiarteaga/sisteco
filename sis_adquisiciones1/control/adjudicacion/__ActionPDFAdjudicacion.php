<?php

session_start();
include_once('../LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFAdjudicacion.php';



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

if($sort == '') $sortcol = 'COTIZA.id_cotizacion';
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
	
	
	
	
	$Proceso = array();
	$proveedores=array();
	$Cotizacion_det = array();
	$id_cotizacion=array();
		$Proceso= $Custom-> RepAdjudicacionProceso($m_id_cotizacion,1);
		//$_SESSION['PDF_Cotizacion']=$Custom->salida;
		$_SESSION['PDF_proceso'] = $Custom->salida[0][0];
		$_SESSION['PDF_categoria']=$Custom->salida[0][1];
		$_SESSION['PDF_gestion']=$Custom->salida[0][2];
		$_SESSION['PDF_num_proceso']=$Custom->salida[0][3];
		$_SESSION['PDF_observaciones']=$Custom->salida[0][4];
		$Proveedores= $Custom-> RepAdjudicacionProveedores($m_id_cotizacion,2);
		$_SESSION['PDF_proveedores']=$Custom->salida;


		for($i=0;$i<count($Custom->salida);$i++){ 

		      $id_cotizacion[$i]=$Custom->salida[$i][0];
		      
		}
		
		 
	     
		 
		 
		 header("location: ../../vista/adjudicacion/PDFAdjudicacion.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>