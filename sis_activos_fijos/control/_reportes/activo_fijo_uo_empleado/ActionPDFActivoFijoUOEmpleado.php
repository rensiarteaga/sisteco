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
  			$id_gestion=$_POST['id_gestion'];
  			$estado=$_POST['estado'];
  			$id_unidad_organizacional=$_POST['id_unidad_organizacional'];
  			$gestion=$_POST['gestion'];
  			$fecha_desde=$_POST['txt_fecha_desde'];
  			$fecha_hasta=$_POST['txt_fecha_hasta'];
  			$desc_uo=$_POST['nombre_unidad'];
  			
		} else {
  			$id_gestion=$_GET['id_gestion'];
  			$estado=$_GET['estado'];
  			$id_unidad_organizacional=$_GET['id_unidad_organizacional'];
  			$gestion=$_GET['gestion'];
  			$fecha_desde=$_GET['txt_fecha_desde'];
  			$fecha_hasta=$_GET['txt_fecha_hasta'];
  			$desc_uo=$_GET['nombre_unidad'];
		}
		
		  $fecha_desde=date_create ($fecha_desde); 
          $fecha_desde=date_format( $fecha_desde,'m/d/Y');
           $fecha_hasta=date_create ($fecha_hasta); 
          $fecha_hasta=date_format( $fecha_hasta,'m/d/Y');
		//Clase necesaria para la generación de reporte  
		require_once('../../../../lib/lib_modelo/ReportDriver.php');
		//$tipo_adquisicion=='Todos'?$tipo_adquisicion='%':$tipo_adquisicion;
		
		//se crea unainstancia de la clase pasandole el nombre del archivo del reporte
		$reporte=new ReportDriver('activo_fijo_uo_empleado.jasper','actif','pdf');
		
		//Se añade un parámetro con url para añadir el archivo de estilos
		
		$reporte->addParametroURL('style_reports','../../../../lib/styles_reporte/style_first.jrtx');
		
		/*$reporte->addParametroURL('sub_reporte_1','sub_reporte_1.jasper');
		$reporte->addParametroURL('sub_reporte_2','sub_reporte_2.jasper');
		*/
		
	/*	echo "id_gestion".$id_gestion;
		echo "estado".$estado;
		echo "id_unidad_organizacional".$id_unidad_organizacional;
		echo "gesti_desde".$fecha_desde;
		echo "fecha_hasta".$fecha_hasta;
		echo "estado_cons".$estado_cons;*/
	//echo "desc_uo".$desc_uo;
		//
	/*	$id_fina_regi_prog_proy_acti=329;
		$id_unidad_organizacional=4;
		$estado='activo';
		$gestion=2010;
		$fecha_desde='01/01/2010';
		$fecha_hasta='12/01/2010';
		*///$tipo_adq='Servicio';
		
		//Se añade parametros necesarios para la generación del reporte
		$reporte->addParametro('desc_uo',$desc_uo);
		$reporte->addParametro('id_unidad_organizacional',$id_unidad_organizacional,'Integer');
		$reporte->addParametro('estado',$estado);
		$reporte->addParametro('gestion',$gestion);
		$reporte->addParametro('fecha_inicial',$fecha_desde,'Date','MM/dd/yyyy');
		$reporte->addParametro('fecha_final',$fecha_hasta,'Date','MM/dd/yyyy');
		//$reporte->addParametro('id_gestion',$id_gestion);
				//Se hace correr el 
		$reporte->runReporte();
	}

?>