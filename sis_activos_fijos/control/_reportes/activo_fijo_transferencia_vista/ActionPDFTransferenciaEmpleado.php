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
  			$id_transferencia=$_POST['id_transferencia'];
  			$origen=$_POST['origen'];
  			$destino=$_POST['destino'];
  			
  			
		} else {
  			$id_transferencia=$_GET['id_transferencia'];
  			$origen=$_GET['origen'];
  			$destino=$_GET['destino'];
  		}
		$criterio_filtro='AFE.id_transferencia='.$id_transferencia;
  		
		//Clase necesaria para la generación de reporte  
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
		
		$reporte=new ReportDriver('tranferencia_activos.jasper','actif','pdf');
       
		$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
		$reporte->addParametro('criterio_filtro',$criterio_filtro);
		$reporte->addParametro('origen',$origen);
		$reporte->addParametro('destino',$destino);
		$reporte->runReporte();
	}
?>
