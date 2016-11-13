<?php
session_start();
include_once('../LibModeloKardexPersonal.php');
//include_once("../../modelo/cls_CustomDBKardexPersonal.php");
$Custom = new cls_CustomDBKardexPersonal();

$nombre_archivo = 'ActionPDFPlanillaEmpleadoCuentaB.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 30000;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_planilla';
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
	
    //echo $gestion;
    //exit;
    //listar la cabecera el reporte
   // $m_id_planilla=47;
	$res = $Custom->ListarRepPlanillaCab($cant,$puntero,$sortcol,$sortdir," planil.id_planilla=".$m_id_planilla,$id_financiador,$id_regional,$id_programa,$id_proyecto,$_GET['tipo']);
		
	$_SESSION["PDF_cab_rep_planilla"]=$Custom->salida;
	
	/*if ($_SESSION["ss_id_usuario"]==131){
	echo "reporte".$_GET['reporte'];
	exit;
	}*/
	 if ($_GET['reporte']=='global'){
	      $sortcol='nombre_completo,codigo_empleado,nombre_lugar';
		  $res_detalle = $Custom->ListarEmpleadoCuentasBancRep($cant,$m_id_planilla,$sortcol,$sortdir,'  emppla.id_planilla='.$m_id_planilla,$id_financiador,$id_regional,$id_programa,$id_proyecto,$_GET['tipo']);
	
	      $_SESSION["PDF_lista_planilla_empleado_cb"]=$Custom->salida;

	 }else{
	      $sortcol='nombre_lugar,nombre_completo,codigo_empleado';
		  $res_detalle = $Custom->ListarEmpleadoCuentasBancRep($cant,$m_id_planilla,$sortcol,$sortdir,'  emppla.id_planilla='.$m_id_planilla,$id_financiador,$id_regional,$id_programa,$id_proyecto,$_GET['tipo']);
	
	      $_SESSION["PDF_lista_planilla_empleado_cb"]=$Custom->salida;

	 }
	  /*echo $sortcol;
	  exit;*/
		$_SESSION["tipo_pago"]=$_GET['tipo'];
	$_SESSION["reporte"]=$_GET['reporte'];
	$_SESSION["desc_refrigerio"]=$_GET['desc'];
	if($res) $total_registros= $Custom->salida;
	
	 if($res)
	 { 
	 /*if($_SESSION["ss_id_usuario"]==131){
	      echo $_GET['reporte'];
		  echo $m_id_planilla;
		  echo $_GET['tipo'];
	    exit;
		     	
	    }*/ 
		if($reporte=='global'){
		header("location:../../vista/_reportes/planilla/PDFPlanillaEmpleadoCuentaBGlobal.php");
		}else{
		header("location:../../vista/_reportes/planilla/PDFPlanillaEmpleadoCuentaB.php");
		}
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