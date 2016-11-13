<?php
	
	session_start();
	require_once('../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php');
	//include_once("../LibModeloPresupuesto.php");
	
	$nombre_archivo='Ejec_Presto_Partida.xls';
	$docexcel = new Spreadsheet_Excel_Writer(); 
	$nuevahoja =& $docexcel->addWorksheet("EJEC_PRESTO_PARTIDA");
	
	$fila=0;
	$columna=0;
	$valor_celda='prueba';
	$nuevahoja->setColumn(1,18,15);
	
	
	$nuevahoja->write(1,3,'EJECUCIÓN PRESUPUESTARIA POR PARTIDA '); //dibuja una celad con contenido y orientacion  x, y 
	$nuevahoja->write(2,3,'Presupuesto de '.$_SESSION['PDF_desc_pres_r']." Gestión ".$_SESSION['PDF_gestion_r']);
	$nuevahoja->write(3,3,'Del '.$_SESSION['PDF_fecha_ini_pdf_r']. ' Al '. $_SESSION['PDF_fecha_fin_pdf_r']);	
	$nuevahoja->write(4,3,'(Expresado en '.$_SESSION['PDF_desc_moneda_r'].')');
	//adicionando la estructura programtica
	
	$epe=" ";   
    $bandera=false;
    $nuevahoja->write(6,1,'PARTIDA');
    $nuevahoja->write(6,2,$_SESSION['PDF_desc_partida_r']);	
   //Títulos de las columnas
  	if($_SESSION['PDF_desc_pres_r']=='Recurso')
  	{
  		$nuevahoja->write(8,1,'DESCRIPCIÓN');	//DESCRIPCIÓN
		$nuevahoja->write(8,2,'PRESUPUESTADO');	//PRESUPUESTADO
		$nuevahoja->write(8,3,'TRASPASO');		//TRASPASO
		$nuevahoja->write(8,4,'REFORMULACION');	//REFORMULACION
		$nuevahoja->write(8,5,'PRESUPUESTO VIGENTE');	//PRESUPUESTO VIGENTE		
		$nuevahoja->write(8,6,'DEVENGADO');		//DEVENGADO
		$nuevahoja->write(8,7,'PAGADO');			//PAGADO		
		$nuevahoja->write(8,8,'SALDO POR DEVENGAR');		//SALDO POR DEVENGAR
		$nuevahoja->write(8,9,'SALDO POR PAGAR');		//SALDO POR PAGAR
		$nuevahoja->write(8,10,'EJECUCIÓN (%)');
  	}
	else
	 {
	 	$nuevahoja->write(8,1,'DESCRIPCIÓN');	//DESCRIPCIÓN
		$nuevahoja->write(8,2,'PRESUPUESTADO');	//PRESUPUESTADO
		$nuevahoja->write(8,3,'TRASPASO');		//TRASPASO
		$nuevahoja->write(8,4,'REFORMULACION');	//REFORMULACION
		$nuevahoja->write(8,5,'PRESUPUESTO VIGENTE');	//PRESUPUESTO VIGENTE
		$nuevahoja->write(8,6,'COMPROMETIDO'); //COMPROMETIDO
		$nuevahoja->write(8,7,'DEVENGADO');		//DEVENGADO
		$nuevahoja->write(8,8,'PAGADO');			//PAGADO
		$nuevahoja->write(8,9,'SALDO POR COMPROMETER'); //SALDO POR COMPROMETER
		$nuevahoja->write(8,10,'SALDO POR DEVENGAR');		//SALDO POR DEVENGAR		  
		$nuevahoja->write(8,11,'SALDO POR PAGAR');		//SALDO POR PAGAR
		$nuevahoja->write(8,12,'EJECUCIÓN (%)');		
	    }	
		
	$detalle_documentos=$_SESSION['PDF_RPPDetalle'];  
    $suma1=0;
    $suma2=0;
    $suma3=0;
    $suma4=0;
    $suma5=0;
    $suma6=0;
    $suma7=0;
    $suma8=0;
    $suma9=0;
    $suma10=0;
    
   $fila=10;
    for($j=0;$j<sizeof($detalle_documentos);$j++)
	{   
		if($_SESSION['PDF_desc_pres_r']=='Recurso')
		{
		$nuevahoja->setColumn($fila,1,50); // definimos el ancho de la fila y columna a 50 px	   
		$nuevahoja->write($fila,1,$detalle_documentos[$j][0]);		    
		$nuevahoja->write($fila,2,$detalle_documentos[$j][1]);			
		$nuevahoja->write($fila,3,$detalle_documentos[$j][2]);
		$nuevahoja->write($fila,4,$detalle_documentos[$j][3]);
		$nuevahoja->write($fila,5,$detalle_documentos[$j][4]);
		$nuevahoja->write($fila,6,$detalle_documentos[$j][6]);
		$nuevahoja->write($fila,7,$detalle_documentos[$j][7]);
		$nuevahoja->write($fila,8,$detalle_documentos[$j][9]);
		$nuevahoja->write($fila,9,$detalle_documentos[$j][10]);
		$suma1=$suma1+$detalle_documentos[$j][1];
	    $suma2=$suma2+$detalle_documentos[$j][2];
	    $suma3=$suma3+$detalle_documentos[$j][3];
	    $suma4=$suma4+$detalle_documentos[$j][4];	    
	    $suma6=$suma6+$detalle_documentos[$j][6];
	    $suma7=$suma7+$detalle_documentos[$j][7];
	    $suma9=$suma9+$detalle_documentos[$j][9];	    
	    $suma10=$suma10+$detalle_documentos[$j][10];
		}	
	else 
	{
		$nuevahoja->setColumn($fila,1,50); // definimos el ancho de la fila y columna a 50 px	   
		$nuevahoja->write($fila,1,$detalle_documentos[$j][0]);		    
		$nuevahoja->write($fila,2,$detalle_documentos[$j][1]);			
		$nuevahoja->write($fila,3,$detalle_documentos[$j][2]);
		$nuevahoja->write($fila,4,$detalle_documentos[$j][3]);
		$nuevahoja->write($fila,5,$detalle_documentos[$j][4]);
		$nuevahoja->write($fila,6,$detalle_documentos[$j][5]); //COMPROMETIDO
		$nuevahoja->write($fila,7,$detalle_documentos[$j][6]);
		$nuevahoja->write($fila,8,$detalle_documentos[$j][7]);
		$nuevahoja->write($fila,9,$detalle_documentos[$j][8]); //SALDO POR COMPROMETER
		$nuevahoja->write($fila,10,$detalle_documentos[$j][9]);
		$nuevahoja->write($fila,11,$detalle_documentos[$j][10]);
		$suma1=$suma1+$detalle_documentos[$j][1];
	    $suma2=$suma2+$detalle_documentos[$j][2];
	    $suma3=$suma3+$detalle_documentos[$j][3];
	    $suma4=$suma4+$detalle_documentos[$j][4];	
	    $suma5=$suma5+$detalle_documentos[$j][5];
	    $suma6=$suma6+$detalle_documentos[$j][6];    
	    $suma7=$suma7+$detalle_documentos[$j][7];
	    $suma8=$suma8+$detalle_documentos[$j][8];
	    $suma9=$suma9+$detalle_documentos[$j][9];
	    $suma10=$suma10+$detalle_documentos[$j][10];
	   }	    
		if($detalle_documentos[$j][6]==0 || $detalle_documentos[$j][4]==0 )
		 {
		 	$dato=number_format(0.0001,1)." %" ;
		 }
		 else
		 { 
		 	//$porcentaje = ( 100-( ( $suma8 *100) / $suma4 ) );
		 	//$dato=round(($detalle_documentos[$j][6]*100 / $detalle_documentos[$j][4] ) * 100) / 100;
		 	$dato=number_format($detalle_documentos[$j][6]*100 / $detalle_documentos[$j][4],1)." %";
		 }
		 if($_SESSION['PDF_desc_pres_r']=='Recurso')
		{$nuevahoja->write($fila,10,$dato);}
		else{$nuevahoja->write($fila,12,$dato);}
		$fila++;
	}	
	 //ADICIONANDO LOS TOTALES
	  $fila++;
	  $negrita =& $docexcel->addFormat();//adicionando negrita a los totales
	  $negrita->setBold();
	  if($_SESSION['PDF_desc_pres_r']=='Recurso')
	  {
	  	$nuevahoja->write($fila,1,'TOTALES',$negrita);		    
		$nuevahoja->write($fila,2,$suma1,$negrita);			
		$nuevahoja->write($fila,3,$suma2,$negrita);
		$nuevahoja->write($fila,4,$suma3,$negrita);
		$nuevahoja->write($fila,5,$suma4,$negrita);		
		$nuevahoja->write($fila,6,$suma6,$negrita);
		$nuevahoja->write($fila,7,$suma7,$negrita);		
		$nuevahoja->write($fila,8,$suma9,$negrita);
		$nuevahoja->write($fila,9,$suma10,$negrita);
	  }
	  else
	   {
	 	$nuevahoja->write($fila,1,'TOTALES',$negrita);		    
		$nuevahoja->write($fila,2,$suma1,$negrita);			
		$nuevahoja->write($fila,3,$suma2,$negrita);
		$nuevahoja->write($fila,4,$suma3,$negrita);
		$nuevahoja->write($fila,5,$suma4,$negrita);		
	    $nuevahoja->write($fila,6,$suma5,$negrita); //COMPROMETIDO
		$nuevahoja->write($fila,7,$suma6,$negrita);
		$nuevahoja->write($fila,8,$suma7,$negrita);
		$nuevahoja->write($fila,9,$suma8,$negrita); //SALDO POR COMPROMETER		
		$nuevahoja->write($fila,10,$suma9,$negrita);
		$nuevahoja->write($fila,11,$suma10,$negrita);
	   }
		if($suma6==0 || $suma4==0 )
		 {
		 	$dato=number_format(0.0001,1);
		 }
		 else
		 { 
		  	$dato=number_format(($suma6*100 / $suma4 ),1);
		 }
		 if($_SESSION['PDF_desc_pres_r']=='Recurso')
	  {
		$nuevahoja->write($fila,10,$dato.' %',$negrita);
	  }
	  else
	   {
	  	$nuevahoja->write($fila,12,$dato.' %',$negrita);
	  }
	//
	
	$docexcel->send($nombre_archivo);
	$docexcel->close();
			
?>