<?php
	session_start();
	include_once('../../LibModeloControlAsistencia.php');
	$Custom = new cls_CustomDBControlAsistencia();
	$nombre_archivo = 'DetalleMarcas.php';

	//Se valida la autentificación
	if (!isset($_SESSION['autentificado'])){
		echo "El usuario no se encuentra autentificado";
	}
	if($_SESSION['autentificado']=='SI'){
		
		if($limit == '') $cant = 30000;
		else $cant = $limit;
		
		if($start == '') $puntero = 0;
		else $puntero = $start;
		
		if($sort == '') $sortcol = 'id_planilla';
		else $sortcol = $sort;
		
		if($dir == '') $sortdir = 'asc';
		else $sortdir = $dir;
		
		//Se valida el método de paso de variables del formulario
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$id_gestion=$_POST['id_gestion'];
			$id_periodo=$_POST['id_periodo'];
			$t_periodo=$_POST['t_periodo'];
			$t_gestion=$_POST['t_gestion'];
			$tipo_impresion=$_POST['tipo_impresion'];
		} else {
			$id_gestion=$_GET['id_gestion'];
			$id_periodo=$_GET['id_periodo'];
			$t_periodo=$_GET['t_periodo'];
			$t_gestion=$_GET['t_gestion'];
			$tipo_impresion=$_GET['tipo_impresion'];
  		}
  		
  		
  		if($tipo_impresion==0){  
  
  			//Clase necesaria para la generación de reporte 
	  		$res = $Custom->DetalleMarcasPeriodo($id_gestion,$id_periodo);
	  		
	  		$_SESSION["PDF_det_marcas"]=$Custom->salida;
	  		$_SESSION["PDF_datos_cabecera"][1]=$t_gestion;
	  		$_SESSION["PDF_datos_cabecera"][0]=$t_periodo;
  		    header("location: PDFDetalleMarcas.php");
  		}else{  
  			require_once('../../../../lib/lib_modelo/ReportDriver.php');
  			$reporte=new ReportDriver('repDetalleMarcasXLS.jasper','casis','xls');
  			$reporte->addParametro('imagen_ende','../../../../lib/images/logo_reporte_corp.jpg');
  			$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
  			$reporte->addParametro('id_usuario',$_SESSION['ss_id_usuario'],'Integer');
  			$reporte->addParametro('codigo_procedimiento','CA_MARMES_REP');
  			$reporte->addParametro('id_gestion',$id_gestion,'Integer');
  			$reporte->addParametro('id_periodo',$id_periodo,'Integer');
  			$reporte->addParametro('gestion',$t_gestion,'Integer');
  			$reporte->addParametro('periodo',$t_periodo);
  			
  			
  			$reporte->runReporte();
  		}
  		
  		}
  		else
  		{
  			header("HTTP/1.0 401 No autorizado");
  			header('Content-Type: text/plain; charset=iso-8859-1');
  			echo "No tiene los permisos necesarios ";
  		
  		}
	
?>
