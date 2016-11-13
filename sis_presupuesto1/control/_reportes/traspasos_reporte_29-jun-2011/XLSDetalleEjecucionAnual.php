<?php
	
	session_start();
	require_once('../../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php');
	//include_once("../LibModeloPresupuesto.php");
	
	$nombre_archivo='Ejecucion_Trimestral.xls';
	$docexcel = new Spreadsheet_Excel_Writer(); 
	$nuevahoja =& $docexcel->addWorksheet("EJECUCION_TRIMESTRAL");
	
	$fila=0;
	$columna=0;
	$valor_celda='prueba';
	$nuevahoja->setColumn(1,18,15);
	  $negrita =& $docexcel->addFormat();//adicionando negrita a los totales
	  $negrita->setBold();
	
	$nuevahoja->write(1,3,'EJECUCIÓN PRESUPUESTARIA TRIMESTRAL ',$negrita); //dibuja una celad con contenido y orientacion  x, y 
	$nuevahoja->write(2,3,'Presupuesto de '.$_SESSION['PDF_desc_pres_r']." Gestión ".$_SESSION['PDF_gestion_r']);
	$nuevahoja->write(3,3,'Trimestre: '.$_SESSION['PDF_trimestre']);	
	$nuevahoja->write(4,3,'Filtrado por: '.$_SESSION['PDF_filtro']);
	$nuevahoja->write(5,3,'(Expresado en '.$_SESSION['PDF_desc_moneda_r'].')');
	//adicionando la estructura programtica
	
	$epe=" ";   
    $bandera=false;
    	
    //Títulos de las columnas
  			
		$nuevahoja->write(8,1,'DESCRIPCIÓN',$negrita);
		$nuevahoja->write(8,2,'PRESUPUESTO',$negrita);
		$nuevahoja->write(8,3,'PRESUPUESTO',$negrita);
		
		if($_SESSION["PDF_trimestre"]=='Enero - Febrero - Marzo')
		{			
			$nuevahoja->write(8,4,'ENERO',$negrita);
			$nuevahoja->write(8,7,'FEBRERO',$negrita);
			$nuevahoja->write(8,10,'MARZO',$negrita);
		}
		if($_SESSION["PDF_trimestre"]=='Abril - Mayo - Junio')
		{						
			$nuevahoja->write(8,4,'ABRIL',$negrita);
			$nuevahoja->write(8,7,'MAYO',$negrita);
			$nuevahoja->write(8,10,'JUNIO',$negrita);
		}
		if($_SESSION["PDF_trimestre"]=='Julio - Agosto - Septiembre')
		{	
			$nuevahoja->write(8,4,'JULIO',$negrita);
			$nuevahoja->write(8,7,'AGOSTO',$negrita);
			$nuevahoja->write(8,10,'SEPTIEMBRE',$negrita);
		}
		if($_SESSION["PDF_trimestre"]=='Octubre - Noviembre - Diciembre')
		{			
			$nuevahoja->write(8,4,'OCTUBRE',$negrita);
			$nuevahoja->write(8,7,'NOVIEMBRE',$negrita);
			$nuevahoja->write(8,10,'DICIEMBRE',$negrita);
		}	
		$nuevahoja->write(8,13,'TOTAL EJEC.',$negrita);
		$nuevahoja->write(8,14,'EJECUCIÓN',$negrita);
		$nuevahoja->write(8,15,'EJECUCIÓN',$negrita);
		$nuevahoja->write(8,16,'% TOTAL DE',$negrita);
		
		

		$nuevahoja->write(9,1,'',$negrita);
		$nuevahoja->write(9,2,'INICIAL',$negrita);
		$nuevahoja->write(9,3,'VIGENTE',$negrita);
		$nuevahoja->write(9,4,'PRES. VIG.',$negrita);
		$nuevahoja->write(9,5,'EJECUCIÓN',$negrita);
		$nuevahoja->write(9,6,'% EJECUCIÓN',$negrita);
		$nuevahoja->write(9,7,'PRES. VIG.',$negrita);
		$nuevahoja->write(9,8,'EJECUCIÓN',$negrita);
		$nuevahoja->write(9,9,'% EJECUCIÓN',$negrita);
		$nuevahoja->write(9,10,'PRES. VIG.',$negrita);
		$nuevahoja->write(9,11,'EJECUCIÓN',$negrita);
		$nuevahoja->write(9,12,'% EJECUCIÓN',$negrita);
		$nuevahoja->write(9,13,'TRIMESTRE',$negrita);
		$nuevahoja->write(9,14,'ACUMULADA',$negrita);
		$nuevahoja->write(9,15,'AL: '.date("d-m-Y"),$negrita);
		$nuevahoja->write(9,16,'EJECUCIÓN',$negrita);
	
	
		
	$detalle_documentos=$_SESSION['PDF_RPPDetalle'];  
    $sumaPreI=0;
    $sumaPreV=0;
        
    $sumaEneP=0;
    $sumaEneE=0;
    $sumaFebP=0;
    $sumaFebE=0;
    $sumaMarP=0;
    $sumaMarE=0;
    $sumaTrim1=0;
    $sumaAcum1=0;    
    
    $sumaAbrP=0;
    $sumaAbrE=0;
    $sumaMayP=0;
    $sumaMayE=0;    
    $sumaJunP=0;
    $sumaJunE=0;
    $sumaTrim2=0;
    $sumaAcum2=0; 
    
    $sumaJulP=0;
    $sumaJulE=0;
    $sumaAgoP=0;
    $sumaAgoE=0;
    $sumaSepP=0;
    $sumaSepE=0;
    $sumaTrim3=0;
    $sumaAcum3=0; 
    
    $sumaOctP=0;
    $sumaOctE=0;
    $sumaNovP=0;
    $sumaNovE=0;
    $sumaDicP=0;    
    $sumaDicE=0;
    $sumaTrim4=0;
    $sumaAcum4=0; 
    
    $sumaTotE=0;
    
   $fila=11;
    for($j=0;$j<sizeof($detalle_documentos);$j++)
	{  		
		$nuevahoja->setColumn($fila,1,50); // definimos el ancho de la fila y columna a 50 px	   
		$nuevahoja->write($fila,1,$detalle_documentos[$j][0]);		    
		$nuevahoja->write($fila,2,$detalle_documentos[$j][1]);					
		$nuevahoja->write($fila,3,$detalle_documentos[$j][2],$negrita);

		if($_SESSION["PDF_trimestre"]=='Enero - Febrero - Marzo')
		{	
			$nuevahoja->write($fila,4,$detalle_documentos[$j][3]);
			$nuevahoja->write($fila,5,$detalle_documentos[$j][4]);		
			$nuevahoja->write($fila,6,$detalle_documentos[$j][5],$negrita);
					
			$nuevahoja->write($fila,7,$detalle_documentos[$j][6]);
			$nuevahoja->write($fila,8,$detalle_documentos[$j][7]);		
			$nuevahoja->write($fila,9,$detalle_documentos[$j][8],$negrita);
					
			$nuevahoja->write($fila,10,$detalle_documentos[$j][9]);
			$nuevahoja->write($fila,11,$detalle_documentos[$j][10]);				
			$nuevahoja->write($fila,12,$detalle_documentos[$j][11],$negrita);
			$nuevahoja->write($fila,13,$detalle_documentos[$j][12]);				
			$nuevahoja->write($fila,14,$detalle_documentos[$j][13]);
		}
		if($_SESSION["PDF_trimestre"]=='Abril - Mayo - Junio')
		{		
			$nuevahoja->write($fila,4,$detalle_documentos[$j][14]);
			$nuevahoja->write($fila,5,$detalle_documentos[$j][15]);		
			$nuevahoja->write($fila,6,$detalle_documentos[$j][16],$negrita);
					
			$nuevahoja->write($fila,7,$detalle_documentos[$j][17]);
			$nuevahoja->write($fila,8,$detalle_documentos[$j][18]);		
			$nuevahoja->write($fila,9,$detalle_documentos[$j][19],$negrita);
					
			$nuevahoja->write($fila,10,$detalle_documentos[$j][20]);
			$nuevahoja->write($fila,11,$detalle_documentos[$j][21]);		
			$nuevahoja->write($fila,12,$detalle_documentos[$j][22],$negrita);
			$nuevahoja->write($fila,13,$detalle_documentos[$j][23]);				
			$nuevahoja->write($fila,14,$detalle_documentos[$j][24]);
		}
		if($_SESSION["PDF_trimestre"]=='Julio - Agosto - Septiembre')
		{		
			$nuevahoja->write($fila,4,$detalle_documentos[$j][25]);
			$nuevahoja->write($fila,5,$detalle_documentos[$j][26]);				
			$nuevahoja->write($fila,6,$detalle_documentos[$j][27],$negrita);		
			
			$nuevahoja->write($fila,7,$detalle_documentos[$j][28]);
			$nuevahoja->write($fila,8,$detalle_documentos[$j][29]);			
			$nuevahoja->write($fila,9,$detalle_documentos[$j][30],$negrita);	
				
			$nuevahoja->write($fila,10,$detalle_documentos[$j][31]);
			$nuevahoja->write($fila,11,$detalle_documentos[$j][32]);		
			$nuevahoja->write($fila,12,$detalle_documentos[$j][33],$negrita);
			$nuevahoja->write($fila,13,$detalle_documentos[$j][34]);				
			$nuevahoja->write($fila,14,$detalle_documentos[$j][35]);
		}
		if($_SESSION["PDF_trimestre"]=='Octubre - Noviembre - Diciembre')
		{		
			$nuevahoja->write($fila,4,$detalle_documentos[$j][36]);
			$nuevahoja->write($fila,5,$detalle_documentos[$j][37]);		
			$nuevahoja->write($fila,6,$detalle_documentos[$j][38],$negrita);
					
			$nuevahoja->write($fila,7,$detalle_documentos[$j][39]);
			$nuevahoja->write($fila,8,$detalle_documentos[$j][40]);		
			$nuevahoja->write($fila,9,$detalle_documentos[$j][41],$negrita);
					
			$nuevahoja->write($fila,10,$detalle_documentos[$j][42]);
			$nuevahoja->write($fila,11,$detalle_documentos[$j][43]);	
			$nuevahoja->write($fila,12,$detalle_documentos[$j][44],$negrita);
			$nuevahoja->write($fila,13,$detalle_documentos[$j][45]);				
			$nuevahoja->write($fila,14,$detalle_documentos[$j][46]);
		}		
		$nuevahoja->write($fila,15,$detalle_documentos[$j][47],$negrita);
		$nuevahoja->write($fila,16,$detalle_documentos[$j][48],$negrita);
	    
    	$sumaPreI=$sumaPreI+$detalle_documentos[$j][1];//
		$sumaPreV=$sumaPreV+$detalle_documentos[$j][2];//
		
		$sumaEneP=$sumaEneP+$detalle_documentos[$j][3];//
		$sumaEneE=$sumaEneE+$detalle_documentos[$j][4];//			
		$sumaFebP=$sumaFebP+$detalle_documentos[$j][6];//
		$sumaFebE=$sumaFebE+$detalle_documentos[$j][7];//		 
		$sumaMarP=$sumaMarP+$detalle_documentos[$j][9];//  
		$sumaMarE=$sumaMarE+$detalle_documentos[$j][10];// 			  
		$sumaTrim1=$sumaTrim1+$detalle_documentos[$j][12];// 
		$sumaAcum1=$sumaAcum1+$detalle_documentos[$j][13];// 
		
		$sumaAbrP=$sumaAbrP+$detalle_documentos[$j][14];// 
		$sumaAbrE=$sumaAbrE+$detalle_documentos[$j][15];//			
		$sumaMayP=$sumaMayP+$detalle_documentos[$j][17];//
		$sumaMayE=$sumaMayE+$detalle_documentos[$j][18];//		 
		$sumaJunP=$sumaJunP+$detalle_documentos[$j][20];//  
		$sumaJunE=$sumaJunE+$detalle_documentos[$j][21];// 
		$sumaTrim2=$sumaTrim2+$detalle_documentos[$j][23];// 
		$sumaAcum2=$sumaAcum2+$detalle_documentos[$j][24];//	
				  
		$sumaJulP=$sumaJulP+$detalle_documentos[$j][25];// 
		$sumaJulE=$sumaJulE+$detalle_documentos[$j][26];//			
		$sumaAgoP=$sumaAgoP+$detalle_documentos[$j][28];//
		$sumaAgoE=$sumaAgoE+$detalle_documentos[$j][29];//			 
		$sumaSepP=$sumaSepP+$detalle_documentos[$j][31];//  
		$sumaSepE=$sumaSepE+$detalle_documentos[$j][32];//
		$sumaTrim3=$sumaTrim3+$detalle_documentos[$j][34];// 
		$sumaAcum3=$sumaAcum3+$detalle_documentos[$j][35];//
					  
		$sumaOctP=$sumaOctP+$detalle_documentos[$j][36];// 
		$sumaOctE=$sumaOctE+$detalle_documentos[$j][37];//			
		$sumaNovP=$sumaNovP+$detalle_documentos[$j][39];//
		$sumaNovE=$sumaNovE+$detalle_documentos[$j][40];//			 
		$sumaDicP=$sumaDicP+$detalle_documentos[$j][42];//  
		$sumaDicE=$sumaDicE+$detalle_documentos[$j][43];//
		$sumaTrim4=$sumaTrim4+$detalle_documentos[$j][45];// 
		$sumaAcum4=$sumaAcum4+$detalle_documentos[$j][46];//
		  			  
		$sumaTotE=$sumaTotE+$detalle_documentos[$j][47];//
	    	 
		$fila++;
	}	
	 //ADICIONANDO LOS TOTALES
	  $fila++;
	 
	 
	  	
	 	$nuevahoja->write($fila,1,'TOTALES',$negrita);		    
		$nuevahoja->write($fila,2,$sumaPreI,$negrita);			
		$nuevahoja->write($fila,3,$sumaPreV,$negrita);
		
		if($_SESSION["PDF_trimestre"]=='Enero - Febrero - Marzo')
		{
			$nuevahoja->write($fila,4,$sumaEneP,$negrita);
			$nuevahoja->write($fila,5,$sumaEneE,$negrita);	
			$nuevahoja->write($fila,6,number_format($sumaEneE*100 / ($sumaEneP + 0.1) ,1).' %',$negrita); //
			
			$nuevahoja->write($fila,7,$sumaFebP,$negrita);
			$nuevahoja->write($fila,8,$sumaFebE,$negrita);
			$nuevahoja->write($fila,9,number_format($sumaFebE*100 / ($sumaFebP + 0.1) ,1).' %',$negrita); //
			
			$nuevahoja->write($fila,10,$sumaMarP,$negrita);
			$nuevahoja->write($fila,11,$sumaMarE,$negrita);
			$nuevahoja->write($fila,12,number_format($sumaMarE*100 / ($sumaMarP + 0.1) ,1).' %',$negrita);
			$nuevahoja->write($fila,13,$sumaTrim1,$negrita);
			$nuevahoja->write($fila,14,$sumaAcum1,$negrita);	
		}
		if($_SESSION["PDF_trimestre"]=='Abril - Mayo - Junio')
		{
			$nuevahoja->write($fila,4,$sumaAbrP,$negrita);
			$nuevahoja->write($fila,5,$sumaAbrE,$negrita);	
			$nuevahoja->write($fila,6,number_format($sumaAbrE*100 / ($sumaAbrP + 0.1) ,1).' %',$negrita); //
			
			$nuevahoja->write($fila,7,$sumaMayP,$negrita);
			$nuevahoja->write($fila,8,$sumaMayE,$negrita);
			$nuevahoja->write($fila,9,number_format($sumaMayE*100 / ($sumaMayP + 0.1) ,1).' %',$negrita); //
			
			$nuevahoja->write($fila,10,$sumaJunP,$negrita);
			$nuevahoja->write($fila,11,$sumaJunE,$negrita);
			$nuevahoja->write($fila,12,number_format($sumaJunE*100 / ($sumaJunP + 0.1) ,1).' %',$negrita);
			$nuevahoja->write($fila,13,$sumaTrim2,$negrita);
			$nuevahoja->write($fila,14,$sumaAcum2,$negrita);
		}
		if($_SESSION["PDF_trimestre"]=='Julio - Agosto - Septiembre')
		{
			$nuevahoja->write($fila,4,$sumaJulP,$negrita);
			$nuevahoja->write($fila,5,$sumaJulE,$negrita);	
			$nuevahoja->write($fila,6,number_format($sumaJulE*100 / ($sumaJulP + 0.1) ,1).' %',$negrita); //
			
			$nuevahoja->write($fila,7,$sumaAgoP,$negrita);
			$nuevahoja->write($fila,8,$sumaAgoE,$negrita);
			$nuevahoja->write($fila,9,number_format($sumaAbrE*100 / ($sumaAbrP + 0.1) ,1).' %',$negrita); //
			
			$nuevahoja->write($fila,10,$sumaSepP,$negrita);
			$nuevahoja->write($fila,11,$sumaSepE,$negrita);
			$nuevahoja->write($fila,12,number_format($sumaSepE*100 / ($sumaSepP + 0.1) ,1).' %',$negrita);
			$nuevahoja->write($fila,13,$sumaTrim3,$negrita);
			$nuevahoja->write($fila,14,$sumaAcum3,$negrita);
		}
		if($_SESSION["PDF_trimestre"]=='Octubre - Noviembre - Diciembre')
		{
			$nuevahoja->write($fila,4,$sumaOctP,$negrita);
			$nuevahoja->write($fila,5,$sumaOctE,$negrita);	
			$nuevahoja->write($fila,6,number_format($sumaOctE*100 / ($sumaOctP+ 0.1) ,1).' %',$negrita); //
			
			$nuevahoja->write($fila,7,$sumaNovP,$negrita);
			$nuevahoja->write($fila,8,$sumaNovE,$negrita);
			$nuevahoja->write($fila,9,number_format($sumaNovE*100 / ($sumaOctP + 0.1) ,1).' %',$negrita); //
			
			$nuevahoja->write($fila,10,$sumaDicP,$negrita);
			$nuevahoja->write($fila,11,$sumaDicE,$negrita);
			$nuevahoja->write($fila,12,number_format($sumaDicE*100 / ($sumaDicP + 0.1) ,1).' %',$negrita);
			$nuevahoja->write($fila,13,$sumaTrim4,$negrita);
			$nuevahoja->write($fila,14,$sumaAcum4,$negrita);
		}
		
		$nuevahoja->write($fila,15,$sumaTotE,$negrita);
		$nuevahoja->write($fila,16,number_format($sumaTotE*100 / ($sumaPreV + 0.1) ,1).' %',$negrita);
	   
	
	$docexcel->send($nombre_archivo);
	$docexcel->close();
			
?>