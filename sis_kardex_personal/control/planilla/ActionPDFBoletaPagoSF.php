<?php
session_start();
include_once('../LibModeloKardexPersonal.php');
//include_once("../../modelo/cls_CustomDBKardexPersonal.php");
$Custom = new cls_CustomDBKardexPersonal();

$nombre_archivo = 'ActionPDFBoletaPago.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Par�metros del filtro
	if($limit == '') $cant = 30000;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_planilla';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
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
	
	//if($id_planilla){$m_id_planilla=$id_planilla;} //echo $m_id_planilla; exit;
	 
    $res = $Custom->ListarRepPlanillaCab($cant,$puntero,$sortcol,$sortdir,"  planil.id_planilla=".$id_planilla,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		
	$_SESSION["PDF_cab_rep_planilla"]=$Custom->salida;
	//print_r($Custom->salida);
	//exit;
	 $puntero=$id_planilla;
	// $puntero=79;
		 		  if ( is_null($m_id_empleado_planilla)){
		 		  		$criterio_filtro= ' and emppla.id_planilla='.$id_planilla;
		 		 	
		 		  }else{
	 		  	 	$criterio_filtro= ' and emppla.id_empleado_planilla='.$m_id_empleado_planilla;
		 		  	 
		 		  	 	
		 		  }
			//if($_SESSION['ss_id_usuario']==120){echo $criterio_filtro; exit;}
		 			$res_detalle = $Custom->ListaPapeletaSueldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
					$_SESSION["PDF_lista_papeleta_sueldo"]=$Custom->salida;
			
			// header("location: ../../vista/_reportes/planilla/PDFPapeletaSueldo.php");
			 header("location: ../../vista/_reportes/planilla/PDFPapeletaSueldoSF.php");
	
}
else
{
	    header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";

}
?>