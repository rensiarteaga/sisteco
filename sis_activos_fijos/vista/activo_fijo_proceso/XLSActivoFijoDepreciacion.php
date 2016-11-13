<?php

	session_start();
	require_once('../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php');
	include_once("../../control/LibModeloActivoFijo.php");
	
	$nombre_archivo='activo_fijo_depreciacion.xls';
	$docexcel = new Spreadsheet_Excel_Writer();
	$nuevahoja =& $docexcel->addWorksheet("Activo Fijo Depreciacion");
	
	$fila=0;
	$columna=0;
	$valor_celda='prueba';
	$nuevahoja->setColumn(0,2,15);
	$nuevahoja->setColumn(3,4,15);
	$nuevahoja->setColumn(4,12,20);

	$Ajustar = &$docexcel->addFormat();
    $Ajustar->setTextWrap(2);
    $Ajustar1 = &$docexcel->addFormat();
    $Ajustar1->setBold(1);
    $Ajustar2 = &$docexcel->addFormat();
    $Ajustar2->setTop(2);
   
    
     $Ajustar3 = &$docexcel->addFormat();
    $Ajustar3->setBold(1);
     $Ajustar3->setTop(2);
    
    
	$nuevahoja->write(1,5,'ACTIVO FIJO DEPRECIACION',$Ajustar1); //dibuja una celad con contenido y orientacion  x, y 
    
	$nuevahoja->write(4,0,'FECHA PROCESO: ',$Ajustar1);
	$nuevahoja->write(4,2,''.$_SESSION["PDF_fecha_contabilizacion"]);
	$nuevahoja->write(5,0,'DESCRIPCION: ',$Ajustar1);
	$nuevahoja->write(5,2,''.$_SESSION["PDF_descripcion"]);
	
    $nuevahoja->write(8,0,'CODIGO',$Ajustar);
    $nuevahoja->write(8,1,'VIDA UTIL ACTUAL',$Ajustar);
    $nuevahoja->write(8,2,'VALOR CONTABLE',$Ajustar);
    $nuevahoja->write(8,3,'ACTUALIZACION',$Ajustar);
    $nuevahoja->write(8,4,'VALOR TOTAL',$Ajustar);
    $nuevahoja->write(8,5,'DEPRECIACION ACUMULADA INICIAL',$Ajustar);
    $nuevahoja->write(8,6,'ACTUALIZACION DEPRECIACION',$Ajustar);
    $nuevahoja->write(8,7,'DEPRECIACION ACUM ACTUALIZADA',$Ajustar);
    $nuevahoja->write(8,8,'DEPRECIACION PERIODO',$Ajustar);
    $nuevahoja->write(8,9,'DEPRECIACION ACUMULADA',$Ajustar);
    $nuevahoja->write(8,10,'VALOR NETO',$Ajustar); 
    $nuevahoja->write(8,11,'REVALORIZACION',$Ajustar); 
 	
    	$cant=500;
		$puntero=0;
		$criterio_filtro=" 0=0 and afp.id_grupo_proceso=".$_SESSION["PDF_id_grupo_proceso"];
		$sortcol='id_activo_fijo_proceso';
		$sortdir='asc';
		
		$Custom = new cls_CustomDBActivoFijo();
		$res = $Custom->ContarActivoFijoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$total_registros= $Custom->salida;
		$fila=9;	
		
		$suma=array();
		$suma[0]=0;
		$suma[1]=0;
		$suma[2]=0;
		$suma[3]=0;
		$suma[4]=0;
		$suma[5]=0;
		$suma[6]=0;
		$suma[7]=0;
		$suma[8]=0;
		
		
		while($puntero<$total_registros){
			
			$res = $Custom->ListarActivoFijoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
			$v_setdetalle=$Custom->salida;
		
			
	   		foreach($v_setdetalle as $data)
	   		{
		    	$nuevahoja->write($fila,0,$data[0]);
		    	$nuevahoja->write($fila,1,$data[1]);
		    	$nuevahoja->write($fila,2,$data[2]);
		    	$nuevahoja->write($fila,3,$data[3]);
		    	$nuevahoja->write($fila,4,$data[4]);
		    	$nuevahoja->write($fila,5,$data[5]);
		    	$nuevahoja->write($fila,6,$data[6]);
		    	$nuevahoja->write($fila,7,$data[7]);
		    	$nuevahoja->write($fila,8,$data[8]);
		    	$nuevahoja->write($fila,9,$data[9]);
		    	$nuevahoja->write($fila,10,$data[10]);
		    	$nuevahoja->write($fila,11,$data[11]);
		    	
		    	$suma[0]+=$data[2];
				$suma[1]+=$data[3];
				$suma[2]+=$data[4];
				$suma[3]+=$data[5];
				$suma[4]+=$data[6];
				$suma[5]+=$data[7];
				$suma[6]+=$data[8];
				$suma[7]+=$data[9];
				$suma[8]+=$data[10];
		    	$fila++;
		    	
	   		}
	   		$puntero+=500;
		}
		
		$nuevahoja->write($fila,1,'TOTAL:',$Ajustar1);
		
		
	    for($i=2; $i<11;$i++)
	    {
	    	
			$nuevahoja->write($fila,$i,$suma[$i-2],$Ajustar3);
			
	    }
    
	$docexcel->send($nombre_archivo);
	$docexcel->close();	
	
?>