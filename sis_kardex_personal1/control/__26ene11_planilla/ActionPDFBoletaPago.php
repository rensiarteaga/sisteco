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
	if($id_planilla){$m_id_planilla=$id_planilla;} 
    $res = $Custom->ListarRepPlanillaCab($cant,$puntero,$sortcol,$sortdir,"  planil.id_planilla=".$m_id_planilla,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		
	$_SESSION["PDF_cab_rep_planilla"]=$Custom->salida;
	//print_r($Custom->salida);
	//exit;
	
	if($id_planilla){
		$j=0;
		$res_emp = $Custom->ListarEmpleadoPlanilla($cant,$puntero,$sortcol,$sortdir,' EMPPLA.id_planilla='.$id_planilla,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$_SESSION['adj']=$Custom->salida;
		//print_r($Custom->salida); exit;
			if($res_emp){
		
			foreach ($Custom->salida as $f){
			
				$m_id_empleado_planilla=$f["id_empleado_planilla"];
			//	$_SESSION["id_empleado_planilla".$j]=$f["id_empleado_planilla"];
		 		
			
		 			$res_detalle = $Custom->ListaPapeletaSueldo($cant,$puntero,$sortcol,$sortdir,' and emppla.id_empleado_planilla='.$m_id_empleado_planilla,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
					$_SESSION["PDF_lista_papeleta_sueldo_$j"]=$Custom->salida;
					//print_r($Custom->salida);
					//exit;
					//if($res) $total_registros= $Custom->salida;
	 			$j=$j+1;
			}
			 header("location: ../../vista/_reportes/planilla/PDFPapeletaSueldo.php");
			
		  }
		
	}
	else{
		
		$_SESSION['adj']=$m_id_empleado_planilla;
		
		$res_detalle = $Custom->ListaPapeletaSueldo($cant,$puntero,$sortcol,$sortdir,' AND emppla.id_empleado_planilla='.$m_id_empleado_planilla,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$_SESSION["PDF_lista_papeleta_sueldo_0"]=$Custom->salida;
	//print_r($Custom->salida);
	//exit;
	if($res) $total_registros= $Custom->salida;
	 if($res)
	 {
		header("location:../../vista/_reportes/planilla/PDFPapeletaSueldo.php");
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
}
else
{
	    header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";

}
?>