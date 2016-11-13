<?php
	
	session_start();
	require_once('../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php');
	//include_once("../LibModeloPresupuesto.php");
	
	$nombre_archivo='Ejecucion_Institucional.xls';
	$docexcel = new Spreadsheet_Excel_Writer();
	$nuevahoja =& $docexcel->addWorksheet("EJECUCIÓN INSTITUCIONAL");
	
	$fila=0;
	$columna=0;
	$valor_celda='prueba';
	$nuevahoja->setColumn(1,18,15);
	//
	IF($_SESSION['PDF_tipo_pres']>1)//PRESUPUESTOS DE GASTO E INVERSION
    {
     $nuevahoja->write(1,2,'EJECUCIÓN PRESUPUESTARIA DE GASTOS INSTITUCIONAL'); //dibuja una celda con contenido y orientacion  x, y     
    }
    else
    {
     $nuevahoja->write(1,2,'EJECUCIÓN PRESUPUESTARIA DE RECURSOS INSTITUCIONAL'); //dibuja una celda con contenido y orientacion  x, y     
    }	
	$nuevahoja->write(2,2,'Presupuesto de '.$_SESSION['PDF_desc_pres']." Gestión ".$_SESSION['PDF_gestion_pres']);
	$nuevahoja->write(3,2,'Del '.$_SESSION['PDF_fecha_ini']. ' Al '. $_SESSION['PDF_fecha_fin']);	
	$nuevahoja->write(4,2,'(Expresado en '.$_SESSION['PDF_desc_moneda'].')');
	//adicionando la estructura programtica
	
	$epe=" ";  	   
	    $nuevahoja->write(6,1,'ESTRUCTURA PROGRAMATICA: ');
	    		    
	    if($_SESSION['PDF_regional'])
	    {
	     	$epe=$epe."REGIONAL: ";	     	
	     	$nuevahoja->write(6,2,$epe);
	     	$nuevahoja->write(6,3,$_SESSION['PDF_regional']);
		}
	   	if($_SESSION['PDF_financiador'])
	   	{	   
	     		$epe="FINANCIADOR: ";
	     		$nuevahoja->write(7,2,$epe);
	     		$nuevahoja->write(7,3,$_SESSION['PDF_financiador']);
	 	}
	 			
		if($_SESSION['PDF_programa'])
		{
			$epe="PROGRAMA: ";
			$nuevahoja->write(8,2,$epe);
		    $nuevahoja->write(8,3,$_SESSION['PDF_programa']);		
		}
		if($_SESSION['PDF_proyecto'])
		{
			$epe="PROYECTO: ";	
			$nuevahoja->write(9,2,$epe);
		    $nuevahoja->write(9,3,$_SESSION['PDF_proyecto']);
		}
	 	if($_SESSION['PDF_actividad'])
	 	{
			$epe="ACTIVIDAD: ";	
		 	$nuevahoja->write(10,2,$epe);
		    $nuevahoja->write(10,3,$_SESSION['PDF_actividad']);
		}
		$nuevahoja->write(12,1,'UNIDAD ORGANIZACIONAL: ');
		$nuevahoja->write(12,2,$_SESSION['PDF_unidad_organizacional']);
		$nuevahoja->write(13,1,'FUENTE DE FINANCIAMIENTO: ');
		$nuevahoja->write(13,2,$_SESSION['PDF_Fuente_financiamiento']);
	 	
	if($epe==" ")
	{
		$epe="Todos";
		$nuevahoja->write(6,3,$epe);
		$nuevahoja->write(7,3,$epe);
		$nuevahoja->write(8,3,$epe);
		$nuevahoja->write(9,3,$epe);
		$nuevahoja->write(10,3,$epe);
		$nuevahoja->write(12,3,$epe);
		$nuevahoja->write(13,3,$epe);			
	} 
   
	 IF($_SESSION['PDF_tipo_pres']>1)//PRESUPUESTOS DE GASTO E INVERSION
	  {
		$nuevahoja->write(15,1,'CODIGO');
		$nuevahoja->write(15,2,'PARTIDA');	  
		$nuevahoja->write(15,3,'PRESUPUESTO APROBADO');	//PRESUPUESTADO
		$nuevahoja->write(15,4,'MODIFICACIONES');	//MODIFICACIONES
		$nuevahoja->write(15,5,'PRESUPUESTO VIGENTE');	//REFORMULACION
		$nuevahoja->write(15,6,'COMPROMISO');	//COMPROMISO
		$nuevahoja->write(15,7,'PRESUPUESTO COMPROMETER');		//PRESUPUESTO POR COMPREMETER
		$nuevahoja->write(15,8,'DEVENGADO');			//DEVENGADO
		$nuevahoja->write(15,9,'DEVENGADO ACUMULADO');		//DEVENGADO ACUMULADO
		$nuevahoja->write(15,10,'PRESUPUESTO POR DEVENGAR');		//PRESUPUESTO POR DEVENGAR
		$nuevahoja->write(15,11,'PAGADO');		//PAGADO
		$nuevahoja->write(15,12,'PAGADO ACUMULADO');		//PAGADO ACUMULADO 
		$nuevahoja->write(15,13,'SALDO POR PAGAR');		//SALDO POR PAGAR
	   }
	else   //PRESUPUESTOS DE RECURSOS
	{
	   	$nuevahoja->write(15,1,'RUBRO');		//CODIGO
        $nuevahoja->write(15,2,'DESCRIPCION');	//PARTIDA
    	$nuevahoja->write(15,3,'PRESUPUESTO APROBADO');	//PRESUPUESTADO
	    $nuevahoja->write(15,4,'MODIFICACIONES');	//MODIFICACIONES
	    $nuevahoja->write(15,5,'PRESUPUESTO VIGENTE');	//REFORMULACION
	    $nuevahoja->write(15,6,'DEVENGADO MES');	//PRESUPUESTO VIGENTE
	    $nuevahoja->write(15,7,'DEVENGADO ACUMULADO' );	//COMPROMISO
	    $nuevahoja->write(15,8,'SALDO POR DEVENGAR');		//PRESUPUESTO POR COMPREMETER
	    $nuevahoja->write(15,9,'PERCIBIDO MES');			//DEVENGADO
	    $nuevahoja->write(15,10,'PERCIBIDO ACUMULADO');		//DEVENGADO ACUMULADO
	    $nuevahoja->write(15,11,'SALDO POR PERCIBIR');	//PRESUPUESTO POR DEVENGAR		 
	}
	   
	$detalle_documentos=array();	
	$detalle_documentos=$_SESSION['PDF_det_ejecucion_institucional'];
	   
	$fila=17;
	IF($_SESSION['PDF_tipo_pres']>1)	//Presupuestos de gasto o inversion
	{	
		for($j=0;$j<sizeof($detalle_documentos);$j++)
			{
			$nuevahoja->write($fila,1,$detalle_documentos[$j][1]);		    
			$nuevahoja->write($fila,2,$detalle_documentos[$j][2]);			
			$nuevahoja->write($fila,3,$detalle_documentos[$j][4]);
			$nuevahoja->write($fila,4,$detalle_documentos[$j][5]);
			$nuevahoja->write($fila,5,$detalle_documentos[$j][6]);
			$nuevahoja->write($fila,6,$detalle_documentos[$j][7]);
			$nuevahoja->write($fila,7,$detalle_documentos[$j][8]);
			$nuevahoja->write($fila,8,$detalle_documentos[$j][9]);
			$nuevahoja->write($fila,9,$detalle_documentos[$j][10]);
			$nuevahoja->write($fila,10,$detalle_documentos[$j][11]);
			$nuevahoja->write($fila,11,$detalle_documentos[$j][12]);
			$nuevahoja->write($fila,12,$detalle_documentos[$j][13]);
			$nuevahoja->write($fila,13,$detalle_documentos[$j][14]);
			$fila++;		
		}		
	}//FIN DE IF SESSION	
	// Presupuestos de recursos 
	ELSE 
	{
	 for($j=0;$j<sizeof($detalle_documentos);$j++)
		{
			$nuevahoja->write($fila,1,$detalle_documentos[$j][1]);		    
			$nuevahoja->write($fila,2,$detalle_documentos[$j][2]);			
			$nuevahoja->write($fila,3,$detalle_documentos[$j][4]);
			$nuevahoja->write($fila,4,$detalle_documentos[$j][5]);
			$nuevahoja->write($fila,5,$detalle_documentos[$j][6]);			
			$nuevahoja->write($fila,6,$detalle_documentos[$j][9]);
			$nuevahoja->write($fila,7,$detalle_documentos[$j][10]);
			$nuevahoja->write($fila,8,$detalle_documentos[$j][6] - $detalle_documentos[$j][10]);
			$nuevahoja->write($fila,9,$detalle_documentos[$j][12]);
			$nuevahoja->write($fila,10,$detalle_documentos[$j][13]);
			$nuevahoja->write($fila,11,$detalle_documentos[$j][10] - $detalle_documentos[$j][13]);
			$fila++;
		}
  }
	$docexcel->send($nombre_archivo);
	$docexcel->close();
			
?>