<?php
	session_start();
	//Se valida la autentificación
	if (!isset($_SESSION['autentificado']))
	{
		echo "El usuario no se encuentra autentificado";
	}
	if($_SESSION['autentificado']=='SI')
	{
		//Se valida el método de paso de variables del formulario
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  			$tipo_adquisicion=$_POST['tipo_adquisicion'];
  			$gestion=$_POST['gestion'];
  			$codigo_proceso=$_POST['codigo_proceso'];
  			$id_depto=$_POST['id_depto'];
  			$departamento=$_POST['departamento'];
		} else {
  			$tipo_adquisicion=$_GET['tipo_adquisicion'];
  			$gestion=$_GET['gestion'];
  			$codigo_proceso=$_GET['codigo_proceso'];
  			$id_depto=$_GET['id_depto'];
  			$departamento=$_GET['departamento'];
		}
		
		
		//Clase necesaria para la generación de reporte  
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
		$tipo_adquisicion=='Todos'?$tipo_adquisicion='%':$tipo_adquisicion;
		
		//se crea unainstancia de la clase pasandole el nombre del archivo del reporte
		$reporte=new ReportDriver('listado_procesos.jasper','compro','rtf');
		
		//Se añade un parámetro con url para añadir el archivo de estilos
		$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
		
		//Se añade parametros necesarios para la generación del reporte
		$reporte->addParametro('gestion',$gestion,'Integer');
		$reporte->addParametro('codigo_proceso',$codigo_proceso);
		$reporte->addParametro('tipo_adquisicion',$tipo_adquisicion);
		$reporte->addParametro('id_depto',$id_depto);
		$reporte->addParametro('departamento',$departamento);
		
		//Se hace correr el reporte
		$reporte->runReporte();
	}

?>