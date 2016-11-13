<?php
	function mes($numero){
		if ($numero==1){
			return 'ENERO';
		}
		if ($numero==1){
			return 'FEBRERO';
		}
		if ($numero==2){
			return 'FEBRERO';
		}
		if ($numero==3){
			return 'MARZO';
		}
		if ($numero==4){
			return 'ABRIL';
		}
		if ($numero==5){
			return 'MAYO';
		}
		if ($numero==6){
			return 'JUNIO';
		}
		if ($numero==7){
			return 'JULIO';
		}
		if ($numero==8){
			return 'AGOSTO';
		}
		if ($numero==9){
			return 'SEPTIEMBRE';
		}
		if ($numero==10){
			return 'OCTUBRE';
		}
		if ($numero==11){
			return 'NOVIEMBRE';
		}
		if ($numero==12){
			return 'DICIEMBRE';
		}
	}

	session_start();
	require_once('../../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php');
	

	$docexcel = new Spreadsheet_Excel_Writer();
	$nuevahoja =& $docexcel->addWorksheet("Cierre Contable");
	
	$fila=0;
	$columna=0;
	$valor_celda='prueba';
	$nuevahoja->setColumn(1,18,15);
	$nuevahoja->write(0,3,'CIERRE CONTABLE'); //dibuja una celad con contenido y orientacion  x, y 
	$nuevahoja->write(1,3,'DEL '.$_SESSION['PDF_fecha_ini_vcc'].'   AL  '.$_SESSION['PDF_fecha_fin_vcc']);
	
	
	$nuevahoja->write(2,3,' ');
	
    $nuevahoja->write(4,0,' ');
    $nuevahoja->write(4,1,'ID');
    $nuevahoja->write(4,2,'ID');
    $nuevahoja->write(4,3,'ID');
    $nuevahoja->write(4,4,'IMPORTE');
    $nuevahoja->write(4,5,'IMPORTE');
    $nuevahoja->write(4,6,'DIFERENCIA');
    
   
    $nuevahoja->write(5,1,'COMPROBANTE');
    $nuevahoja->write(5,2,'PRESUPUESTO');
    $nuevahoja->write(5,3,'PARTIDA');
    $nuevahoja->write(5,4,'PRESUPUESTO');
    $nuevahoja->write(5,5,'CONTABILIDAD');
    $nuevahoja->write(5,6,' ');
   
     $nuevahoja->write(6,1,' ');
    $nuevahoja->write(6,2,' ');
    $nuevahoja->write(6,3,' ');
    $nuevahoja->write(6,4,' ');
    $nuevahoja->write(6,5,' ');
    $nuevahoja->write(6,6,' ');
   
   
	 $fila=8;
	 $total_ener_vendida=0;
     $total_importe_energia=0;
     $total_importe_potencia=0;
     $total_conex=0;
     $total_cred_dev=0;
     
	 
	 if($_SESSION['PDF_cierre_contable'])
	{
		$data=$_SESSION['PDF_cierre_contable'];
		foreach($data as $row)
		{	
			 $nuevahoja->write($fila,0,' ');
			 $nuevahoja->write($fila,1,$row[0]);
			 $nuevahoja->write($fila,2,$row[1]);
			 $nuevahoja->write($fila,3,$row[2]);
			 $nuevahoja->write($fila,4,$row[3]);
			 $nuevahoja->write($fila,5,$row[4]);
			 $nuevahoja->write($fila,6,$row[5]);
			
			
    	   
    	    $fila++;
	    }
	}
	$borde_superior = &$docexcel->addFormat();
	$borde_superior->setTop(2);
	$borde_izquierdo = &$docexcel->addFormat();
	$borde_izquierdo->setLeft(2);
	$borde_superior_izquierdo = &$docexcel->addFormat();
	$borde_superior_izquierdo->setLeft(2);
	$borde_superior_izquierdo->setTop(2);
	
	$nuevahoja->write($fila,1,'',$borde_superior);//formato de numero 
    $nuevahoja->write($fila,2,'',$borde_superior);
    $nuevahoja->write($fila,3,'',$borde_superior);
    $nuevahoja->write($fila,4,'',$borde_superior);
    $nuevahoja->write($fila,5,'',$borde_superior);
    $nuevahoja->write($fila,6,'',$borde_superior);
    
	
	 

	
	$docexcel->send($nombre_archivo);
	$docexcel->close();	
	
?>