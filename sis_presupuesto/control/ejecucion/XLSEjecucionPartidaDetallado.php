<?php
	
	session_start();
	
	require_once('../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php');
	//include_once("../LibModeloPresupuesto.php");
	
	$nombre_archivo='EjecParDetalle.xls';
	$docexcel = new Spreadsheet_Excel_Writer();
	$nuevahoja =& $docexcel->addWorksheet("EJEC PART DETALLADO");
	$negrita =& $docexcel->addFormat();//adicionando negrita a los totales
	$negrita->setBold();
	
	$fila=0;
	$columna=0;
	$valor_celda='prueba';
	$nuevahoja->setColumn(1,3,15);
	$nuevahoja->write(1,3,'DETALLE DE EJECUCION'); //dibuja una celad con contenido y orientacion  x, y 
	$nuevahoja->write(2,3,'Presupuesto de '.$_SESSION['PDF_desc_pres']." Gestión ".$_SESSION['PDF_gestion_pres']);
	$nuevahoja->write(3,3,'Del '.$_SESSION['PDF_fecha_desde']. ' Al '. $_SESSION['PDF_fecha_hasta']);	
	$nuevahoja->write(4,3,'(Expresado en '.$_SESSION['PDF_desc_moneda'].')');
	//adicionando la estructura programtica
	
	$epe=" ";   
	    $bandera=false;
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
	 		 
		if($_SESSION['PDF_proyecto']){
		$epe="PROYECTO: ";	
		$nuevahoja->write(9,2,$epe);
	    $nuevahoja->write(9,3,$_SESSION['PDF_proyecto']);
		}
	 	if($_SESSION['PDF_actividad']){
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
	//ADICIONANDO LA PARTIDA
	$nuevahoja->write(15,1,'PARTIDA:');
	$nuevahoja->write(15,2,$_SESSION['PDF_desc_partida']);
	//comprometido
	$comprometidoT=$_SESSION['PDF_comprometidoT'];
	$comprometido2T=$_SESSION['PDF_comprometido2T'];
	$comprometido3T=$_SESSION['PDF_comprometido3T'];
	$comprometido4T=$_SESSION['PDF_comprometido4T'];
	$comprometido5T=$_SESSION['PDF_comprometido5T'];
	$comprometido6T=$_SESSION['PDF_comprometido6T'];
	//devengado
	$devengado=$_SESSION['PDF_devengado'];
	$devengado2=$_SESSION['PDF_devengado2'];
	$devengado3=$_SESSION['PDF_devengado3'];
	$devengado4=$_SESSION['PDF_devengado4'];
	$devengado5=$_SESSION['PDF_devengado5'];
	$devengado6=$_SESSION['PDF_devengado6'];
	//pagado
	$pagado=$_SESSION['PDF_pagado'];
	$pagado2=$_SESSION['PDF_pagado2'];
	$pagado3=$_SESSION['PDF_pagado3'];
	$pagado4=$_SESSION['PDF_pagado4'];
	$pagado5=$_SESSION['PDF_pagado5'];
	$pagado6=$_SESSION['PDF_pagado6'];
	
//------------------------------- DETALLE DE CONCEPTOS COMPROMETIDOS  ---------------------------------	
//-------------------------Solicitudes de viáticos y fondos en avance------------------------------------------
    $nuevahoja->write(17,3,'DETALLE DE CONCEPTOS COMPROMETIDOS');
    $nuevahoja->write(19,1,'SISTEMA ');  
 	$nuevahoja->write(19,2,'NRO DOCUMENTO'); 
 	$nuevahoja->write(19,3,'FECHA DOC ');  
 	$nuevahoja->write(19,4,'SOLICITANTE ');  
 	$nuevahoja->write(19,5,'CONCEPTO ');  
	$nuevahoja->write(19,6,'FECHA EJE'); 
 	$nuevahoja->write(19,7,'IMPORTE  ');
 	 
	$total_importe_comprometidoT=0;
	$total_comprometidoT=0;
	$total_comprometido2T=0;
	$total_comprometido3T=0;
	$total_comprometido4T=0;
	$total_comprometido5T=0;
	$total_comprometido6T=0;
	$nuevahoja->write(20,1,'Solicitudes de viáticos y fondos en avance',$negrita);
$fila=22;
	for ($i=0;$i<sizeof($comprometidoT);$i++)
	{  	 	
		$nuevahoja->write($fila,1,$comprometidoT[$i][0]);
		$nuevahoja->write($fila,2,$comprometidoT[$i][1]);
		$nuevahoja->write($fila,3,$comprometidoT[$i][2]);
		$nuevahoja->write($fila,4,$comprometidoT[$i][3]);
		$nuevahoja->write($fila,5,$comprometidoT[$i][4]);
		$nuevahoja->write($fila,6,$comprometidoT[$i][5]);
		$nuevahoja->write($fila,7,$comprometidoT[$i][6]); 		
		$nuevahoja->write($fila,8,$comprometidoT[$i][7]);
		
  		$total_importe_comprometidoT=$total_importe_comprometidoT+$comprometidoT[$i][6];
  		$total_comprometidoT=$total_comprometidoT+$comprometidoT[$i][6];
  		$fila++;
   	}
   	$fila++;
   	$nuevahoja->write($fila,6,'Sub total comprometido solicitudes',$negrita); 
   	$nuevahoja->write($fila,7,number_format($total_comprometidoT,2),$negrita);	
     
//---------   Comprobantes contables manuales  ------//
$fila++;
$nuevahoja->write($fila,1,'Comprobantes contables manuales',$negrita);
$fila++;
for ($i=0;$i<sizeof($comprometido3T);$i++)
	{  	 	
		$nuevahoja->write($fila,1,$comprometido3T[$i][0]);
		$nuevahoja->write($fila,2,$comprometido3T[$i][1]);
		$nuevahoja->write($fila,3,$comprometido3T[$i][2]);
		$nuevahoja->write($fila,4,$comprometido3T[$i][3]);
		$nuevahoja->write($fila,5,$comprometido3T[$i][4]);
		$nuevahoja->write($fila,6,$comprometido3T[$i][5]);
		$nuevahoja->write($fila,7,$comprometido3T[$i][6]); 		
		$nuevahoja->write($fila,8,$comprometido3T[$i][7]);		
	
		$total_importe_comprometidoT=$total_importe_comprometidoT+$comprometido3T[$i][6];
	  	$total_comprometido3T=$total_comprometido3T+$comprometido3T[$i][6];
  		$fila++;
   	}
 $fila++;  	
   	$nuevahoja->write($fila,6,'Sub total comprometido comprobantes:  ',$negrita); 
   	$nuevahoja->write($fila,7,number_format($total_comprometido3T,2),$negrita);
   	
 //-------- Adquisiciones gestión actual ----------------//
 $fila++;
$nuevahoja->write($fila,1,'Adquisiciones gestión actual',$negrita);
$fila++;
for ($i=0;$i<sizeof($comprometido4T);$i++)
	{  	 	
		$nuevahoja->write($fila,1,$comprometido4T[$i][0]);
		$nuevahoja->write($fila,2,$comprometido4T[$i][1]);
		$nuevahoja->write($fila,3,$comprometido4T[$i][2]);
		$nuevahoja->write($fila,4,$comprometido4T[$i][3]);
		$nuevahoja->write($fila,5,$comprometido4T[$i][4]);
		$nuevahoja->write($fila,6,$comprometido4T[$i][5]);
		$nuevahoja->write($fila,7,$comprometido4T[$i][6]); 		
		$nuevahoja->write($fila,8,$comprometido4T[$i][7]);		
	
		$total_importe_comprometidoT=$total_importe_comprometidoT+$comprometido4T[$i][6];
	  	$total_comprometido4T=$total_comprometido4T+$comprometido4T[$i][6];
  		$fila++;
   	}
 $fila++;  	
   	$nuevahoja->write($fila,6,'Sub total comprometido adquisiciones:  ',$negrita); 
   	$nuevahoja->write($fila,7,number_format($total_comprometido4T,2),$negrita); 
 //-------- Adquisiciones gestión anterior----------------//   	
  $fila++;
$nuevahoja->write($fila,1,'Adquisiciones gestión anterior',$negrita);
$fila++;
for ($i=0;$i<sizeof($comprometido5T);$i++)
	{  	 	
		$nuevahoja->write($fila,1,$comprometido5T[$i][0]);
		$nuevahoja->write($fila,2,$comprometido5T[$i][1]);
		$nuevahoja->write($fila,3,$comprometido5T[$i][2]);
		$nuevahoja->write($fila,4,$comprometido5T[$i][3]);
		$nuevahoja->write($fila,5,$comprometido5T[$i][4]);
		$nuevahoja->write($fila,6,$comprometido5T[$i][5]);
		$nuevahoja->write($fila,7,$comprometido5T[$i][6]); 		
		$nuevahoja->write($fila,8,$comprometido5T[$i][7]);		
	
		$total_importe_comprometidoT=$total_importe_comprometidoT+$comprometido5T[$i][6];
	  	$total_comprometido5T=$total_comprometido5T+$comprometido5T[$i][6];
  		$fila++;
   	}
 $fila++;  	
   	$nuevahoja->write($fila,6,'Sub total comprometido adquisiciones 2:  ',$negrita); 
   	$nuevahoja->write($fila,7,number_format($total_comprometido5T,2),$negrita); 
 //-------- pagos devengados----------------//
$fila++;
$nuevahoja->write($fila,1,'Pagos Devengados',$negrita);
$fila++;
for ($i=0;$i<sizeof($comprometido6T);$i++)
	{  	 	
		$nuevahoja->write($fila,1,$comprometido6T[$i][0]);
		$nuevahoja->write($fila,2,$comprometido6T[$i][1]);
		$nuevahoja->write($fila,3,$comprometido6T[$i][2]);
		$nuevahoja->write($fila,4,$comprometido6T[$i][3]);
		$nuevahoja->write($fila,5,$comprometido6T[$i][4]);
		$nuevahoja->write($fila,6,$comprometido6T[$i][5]);
		$nuevahoja->write($fila,7,$comprometido6T[$i][6]); 		
		$nuevahoja->write($fila,8,$comprometido6T[$i][7]);		
	
		$total_importe_comprometidoT=$total_importe_comprometidoT+$comprometido6T[$i][6];
	  	$total_comprometido6T=$total_comprometido6T+$comprometido6T[$i][6];
  		$fila++;
   	}
 $fila++;  	
   	$nuevahoja->write($fila,6,'Sub total comprometido pagos devengados:  ',$negrita); 
   	$nuevahoja->write($fila,7,number_format($total_comprometido6T,2),$negrita);  

   	/// TOTAL COMPROMETIDO:    	  	
   	$fila++;  	
   	$nuevahoja->write($fila,6,'TOTAL COMPROMETIDO: ',$negrita); 
   	$nuevahoja->write($fila,7,number_format($total_importe_comprometidoT,2),$negrita);  
   	
 // ---------------- DETALLE DE CONCEPTOS DEVENGADOS --------------- //   	
 // -------------------------Solicitudes de viáticos y fondos en avance------------------------------------------
$fila=$fila+2;
   	$nuevahoja->write($fila,3,'DETALLE DE CONCEPTOS DEVENGADOS');
$fila++;   	
    $nuevahoja->write($fila,1,'SISTEMA ');  
 	$nuevahoja->write($fila,2,'NRO DOCUMENTO'); 
 	$nuevahoja->write($fila,3,'FECHA DOC '); 
 	$nuevahoja->write($fila,4,'SOLICITANTE '); 
 	$nuevahoja->write($fila,5,'CONCEPTO ');  
	$nuevahoja->write($fila,6,'FECHA EJE'); 
 	$nuevahoja->write($fila,7,'IMPORTE  ');
 	 
	$total_importe_devengado=0;
	$total_devengado=0;
	$total_devengado2=0;
	$total_devengado3=0;
	$total_devengado4=0;
	$total_devengado5=0;
$fila++;			
	$nuevahoja->write($fila,1,'Solicitudes de viáticos y fondos en avance',$negrita);
$fila++;
	for ($i=0;$i<sizeof($devengado);$i++)
	{  	 	
		$nuevahoja->write($fila,1,$devengado[$i][0]);
		$nuevahoja->write($fila,2,$devengado[$i][1]);
		$nuevahoja->write($fila,3,$devengado[$i][2]);
		$nuevahoja->write($fila,4,$devengado[$i][3]);
		$nuevahoja->write($fila,5,$devengado[$i][4]);
		$nuevahoja->write($fila,6,$devengado[$i][5]);
		$nuevahoja->write($fila,7,$devengado[$i][6]); 		
		$nuevahoja->write($fila,8,$devengado[$i][7]);
		
  		$total_importe_devengado=$total_importe_devengado+$devengado[$i][6];
	  	$total_devengado=$total_devengado+$devengado[$i][6];
  		$fila++;
   	}
   	$fila++;
   	$nuevahoja->write($fila,6,'Sub total devengado solicitudes:  ',$negrita); 
   	$nuevahoja->write($fila,7,number_format($total_devengado,2),$negrita);	
  
//---------   Rendiciones de cuenta  ------//
$fila++;
	$nuevahoja->write($fila,1,'Rendiciones de cuenta',$negrita);
$fila++;
for ($i=0;$i<sizeof($devengado2);$i++)
	{  	 	
		$nuevahoja->write($fila,1,$devengado2[$i][0]);
		$nuevahoja->write($fila,2,$devengado2[$i][1]);
		$nuevahoja->write($fila,3,$devengado2[$i][2]);
		$nuevahoja->write($fila,4,$devengado2[$i][3]);
		$nuevahoja->write($fila,5,$devengado2[$i][4]);
		$nuevahoja->write($fila,6,$devengado2[$i][5]);
		$nuevahoja->write($fila,7,$devengado2[$i][6]); 		
		$nuevahoja->write($fila,8,$devengado2[$i][7]);		
	
		$total_importe_devengado=$total_importe_devengado+$devengado2[$i][6];
	  	$total_devengado2=$total_devengado2+$devengado2[$i][6];
  		$fila++;
   	}
 $fila++;  	
   	$nuevahoja->write($fila,6,'Sub total devengado rendiciones:  ',$negrita); 
   	$nuevahoja->write($fila,7,number_format($total_devengado2,2),$negrita);
   	
 //-------- Comprobantes contables manuales ----------------//
 $fila++;
$nuevahoja->write($fila,1,'Comprobantes contables manuales',$negrita);
$fila++;
for ($i=0;$i<sizeof($devengado3);$i++)
	{  	 	
		$nuevahoja->write($fila,1,$devengado3[$i][0]);
		$nuevahoja->write($fila,2,$devengado3[$i][1]);
		$nuevahoja->write($fila,3,$devengado3[$i][2]);
		$nuevahoja->write($fila,4,$devengado3[$i][3]);
		$nuevahoja->write($fila,5,$devengado3[$i][4]);
		$nuevahoja->write($fila,6,$devengado3[$i][5]);
		$nuevahoja->write($fila,7,$devengado3[$i][6]); 		
		$nuevahoja->write($fila,8,$devengado3[$i][7]);		
	
		$total_importe_devengado=$total_importe_devengado+$devengado3[$i][6];
		$total_devengado3=$total_devengado3+$devengado3[$i][6];
  		$fila++;
   	}
 $fila++;  	
   	$nuevahoja->write($fila,6,'Sub total devengado comprobantes:  ',$negrita); 
   	$nuevahoja->write($fila,7,number_format($total_devengado3,2),$negrita); 
 //-------- Adquisiciones gestión actual----------------//   	
  $fila++;
$nuevahoja->write($fila,1,'Adquisiciones gestión actual',$negrita);
$fila++;
for ($i=0;$i<sizeof($devengado4);$i++)
	{  	 	
		$nuevahoja->write($fila,1,$devengado4[$i][0]);
		$nuevahoja->write($fila,2,$devengado4[$i][1]);
		$nuevahoja->write($fila,3,$devengado4[$i][2]);
		$nuevahoja->write($fila,4,$devengado4[$i][3]);
		$nuevahoja->write($fila,5,$devengado4[$i][4]);
		$nuevahoja->write($fila,6,$devengado4[$i][5]);
		$nuevahoja->write($fila,7,$devengado4[$i][6]); 		
		$nuevahoja->write($fila,8,$devengado4[$i][7]);		
	
		$total_importe_devengado=$total_importe_devengado+$devengado4[$i][6];
	  	$total_devengado4=$total_devengado4+$devengado4[$i][6];
  		$fila++;
   	}
 $fila++;  	
   	$nuevahoja->write($fila,6,'Sub total comprometido adquisiciones ',$negrita); 
   	$nuevahoja->write($fila,7,number_format($total_devengado4,2),$negrita); 
 //-------- Adquisiciones gestión anterior----------------//
   $fila++;
$nuevahoja->write($fila,1,'Adquisiciones gestión anterior',$negrita);
$fila++;
for ($i=0;$i<sizeof($devengado5);$i++)
	{  	 	
		$nuevahoja->write($fila,1,$devengado5[$i][0]);
		$nuevahoja->write($fila,2,$devengado5[$i][1]);
		$nuevahoja->write($fila,3,$devengado5[$i][2]);
		$nuevahoja->write($fila,4,$devengado5[$i][3]);
		$nuevahoja->write($fila,5,$devengado5[$i][4]);
		$nuevahoja->write($fila,6,$devengado5[$i][5]);
		$nuevahoja->write($fila,7,$devengado5[$i][6]); 		
		$nuevahoja->write($fila,8,$devengado5[$i][7]);		
	
  		$total_importe_devengado=$total_importe_devengado+$devengado5[$i][6];
  		$total_devengado5=$total_devengado5+$devengado5[$i][6];
  		$fila++;
   	}
 $fila++;  	
   	$nuevahoja->write($fila,6,'Sub total devengado adquisiciones 2:  ',$negrita); 
   	$nuevahoja->write($fila,7,number_format($total_devengado5,2),$negrita);  
 //-------- Pagos Devengados----------------//
$fila++;
$nuevahoja->write($fila,1,'Pagos Devengados',$negrita);
$fila++;
for ($i=0;$i<sizeof($devengado6);$i++)
	{  	 	
		$nuevahoja->write($fila,1,$devengado6[$i][0]);
		$nuevahoja->write($fila,2,$devengado6[$i][1]);
		$nuevahoja->write($fila,3,$devengado6[$i][2]);
		$nuevahoja->write($fila,4,$devengado6[$i][3]);
		$nuevahoja->write($fila,5,$devengado6[$i][4]);
		$nuevahoja->write($fila,6,$devengado6[$i][5]);
		$nuevahoja->write($fila,7,$devengado6[$i][6]); 		
		$nuevahoja->write($fila,8,$devengado6[$i][7]);		
	
  		$total_importe_devengado=$total_importe_devengado+$devengado6[$i][6];
	  	$total_devengado6=$total_devengado6+$devengado6[$i][6];
  		$fila++;
   	}
 $fila++;  	
   	$nuevahoja->write($fila,6,'Sub total devengado pagos devengados:  ',$negrita); 
   	$nuevahoja->write($fila,7,number_format($total_devengado6,2),$negrita); 
   	/// TOTAL COMPROMETIDO:    	  	
   	$fila++;  	
   	$nuevahoja->write($fila,6,'TOTAL DEVENGADO: ',$negrita); 
   	$nuevahoja->write($fila,7,number_format($total_importe_devengado,2),$negrita); 
   	
//----------- fin devengado ----------//  	
   	
   	
 //------------------   DETALLE DE CONCEPTOS PAGADOS   -------------------------------
 //-------------------------SSolicitudes de viáticos y fondos en avance------------------------------------------
$fila=$fila+2;
   	$nuevahoja->write($fila,3,'DETALLE DE CONCEPTOS PAGADOS');
$fila++;   	
    $nuevahoja->write($fila,1,'SISTEMA ');  
 	$nuevahoja->write($fila,2,'NRO DOCUMENTO'); 
 	$nuevahoja->write($fila,3,'FECHA DOC '); 
 	$nuevahoja->write($fila,4,'SOLICITANTE '); 
 	$nuevahoja->write($fila,5,'CONCEPTO ');  
	$nuevahoja->write($fila,6,'FECHA EJE'); 
 	$nuevahoja->write($fila,7,'IMPORTE  ');
 	 
	$total_importe_pagado=0;
	$total_pagado=0;
	$total_pagado2=0;
	$total_pagado3=0;
	$total_pagado4=0;
	$total_pagado5=0;
$fila++;			
	$nuevahoja->write($fila,1,'Solicitudes de viáticos y fondos en avance',$negrita);
$fila++;
	for ($i=0;$i<sizeof($pagado);$i++)
	{  	 	
		$nuevahoja->write($fila,1,$pagado[$i][0]);
		$nuevahoja->write($fila,2,$pagado[$i][1]);
		$nuevahoja->write($fila,3,$pagado[$i][2]);
		$nuevahoja->write($fila,4,$pagado[$i][3]);
		$nuevahoja->write($fila,5,$pagado[$i][4]);
		$nuevahoja->write($fila,6,$pagado[$i][5]);
		$nuevahoja->write($fila,7,$pagado[$i][6]); 		
		$nuevahoja->write($fila,8,$pagado[$i][7]);
		
  		$total_importe_pagado=$total_importe_pagado+$pagado[$i][6];
  		$total_pagado=$total_pagado+$pagado[$i][6];
  		$fila++;
   	}
   	$fila++;
   	$nuevahoja->write($fila,6,'Sub total pagado solicitudes:  ',$negrita); 
   	$nuevahoja->write($fila,7,number_format($total_pagado,2),$negrita);	
  
//---------   Rendiciones de cuenta  ------//
$fila++;
	$nuevahoja->write($fila,1,'Rendiciones de cuenta',$negrita);
$fila++;
for ($i=0;$i<sizeof($pagado2);$i++)
	{  	 	
		$nuevahoja->write($fila,1,$pagado2[$i][0]);
		$nuevahoja->write($fila,2,$pagado2[$i][1]);
		$nuevahoja->write($fila,3,$pagado2[$i][2]);
		$nuevahoja->write($fila,4,$pagado2[$i][3]);
		$nuevahoja->write($fila,5,$pagado2[$i][4]);
		$nuevahoja->write($fila,6,$pagado2[$i][5]);
		$nuevahoja->write($fila,7,$pagado2[$i][6]); 		
		$nuevahoja->write($fila,8,$pagado2[$i][7]);		
	
		$total_importe_pagado=$total_importe_pagado+$pagado2[$i][6];
	  	$total_pagado2=$total_pagado2+$pagado2[$i][6];
  		$fila++;
   	}
 $fila++;  	
   	$nuevahoja->write($fila,6,'Sub total pagado rendiciones:  ',$negrita); 
   	$nuevahoja->write($fila,7,number_format($total_pagado2,2),$negrita);
   	
 //-------- Comprobantes contables manuales ----------------//
 $fila++;
$nuevahoja->write($fila,1,'Comprobantes contables manuales',$negrita);
$fila++;
for ($i=0;$i<sizeof($pagado3);$i++)
	{  	 	
		$nuevahoja->write($fila,1,$pagado3[$i][0]);
		$nuevahoja->write($fila,2,$pagado3[$i][1]);
		$nuevahoja->write($fila,3,$pagado3[$i][2]);
		$nuevahoja->write($fila,4,$pagado3[$i][3]);
		$nuevahoja->write($fila,5,$pagado3[$i][4]);
		$nuevahoja->write($fila,6,$pagado3[$i][5]);
		$nuevahoja->write($fila,7,$pagado3[$i][6]); 		
		$nuevahoja->write($fila,8,$pagado3[$i][7]);		
	
		$total_importe_pagado=$total_importe_pagado+$pagado3[$i][6];
	  	$total_pagado3=$total_pagado3+$pagado3[$i][6];
  		$fila++;
   	}
 $fila++;  	
   	$nuevahoja->write($fila,6,'Sub total pagado comprobantes:  ',$negrita); 
   	$nuevahoja->write($fila,7,number_format($total_pagado3,2),$negrita); 
 //-------- Adquisiciones gestión actual----------------//   	
  $fila++;
$nuevahoja->write($fila,1,'Adquisiciones gestión actual',$negrita);
$fila++;
for ($i=0;$i<sizeof($pagado4);$i++)
	{  	 	
		$nuevahoja->write($fila,1,$pagado4[$i][0]);
		$nuevahoja->write($fila,2,$devengado4[$i][1]);
		$nuevahoja->write($fila,3,$pagado4[$i][2]);
		$nuevahoja->write($fila,4,$pagado4[$i][3]);
		$nuevahoja->write($fila,5,$pagado4[$i][4]);
		$nuevahoja->write($fila,6,$pagado4[$i][5]);
		$nuevahoja->write($fila,7,$pagado4[$i][6]); 		
		$nuevahoja->write($fila,8,$pagado4[$i][7]);		
	
		$total_importe_pagado=$total_importe_pagado+$pagado4[$i][6];
	  		$total_pagado4=$total_pagado4+$pagado4[$i][6];
  		$fila++;
   	}
 $fila++;  	
   	$nuevahoja->write($fila,6,'Sub total pagado adquisiciones ',$negrita); 
   	$nuevahoja->write($fila,7,number_format($total_pagado4,2),$negrita); 
 //-------- Adquisiciones gestión anterior----------------//
   $fila++;
$nuevahoja->write($fila,1,'Adquisiciones gestión anterior',$negrita);
$fila++;
for ($i=0;$i<sizeof($pagado5);$i++)
	{  	 	
		$nuevahoja->write($fila,1,$pagado5[$i][0]);
		$nuevahoja->write($fila,2,$pagado5[$i][1]);
		$nuevahoja->write($fila,3,$pagado5[$i][2]);
		$nuevahoja->write($fila,4,$pagado5[$i][3]);
		$nuevahoja->write($fila,5,$pagado5[$i][4]);
		$nuevahoja->write($fila,6,$pagado5[$i][5]);
		$nuevahoja->write($fila,7,$pagado5[$i][6]); 		
		$nuevahoja->write($fila,8,$pagado5[$i][7]);		
	
  		$total_importe_pagado=$total_importe_pagado+$pagado5[$i][6];
	  	$total_pagado5=$total_pagado5+$pagado5[$i][6];
  		$fila++;
   	}
 $fila++;  	
   	$nuevahoja->write($fila,6,'Sub total pagado adquisiciones 2:  ',$negrita); 
   	$nuevahoja->write($fila,7,number_format($total_pagado5,2),$negrita);  
 //-------------------------PAGADO------------------------------------------
   $fila++;
$nuevahoja->write($fila,1,'Pagos Devengados',$negrita);
$fila++;
for ($i=0;$i<sizeof($pagado6);$i++)
	{  	 	
		$nuevahoja->write($fila,1,$pagado6[$i][0]);
		$nuevahoja->write($fila,2,$pagado6[$i][1]);
		$nuevahoja->write($fila,3,$pagado6[$i][2]);
		$nuevahoja->write($fila,4,$pagado6[$i][3]);
		$nuevahoja->write($fila,5,$pagado6[$i][4]);
		$nuevahoja->write($fila,6,$pagado6[$i][5]);
		$nuevahoja->write($fila,7,$pagado6[$i][6]); 		
		$nuevahoja->write($fila,8,$pagado6[$i][7]);		
	
  		$total_importe_pagado=$total_importe_pagado+$pagado6[$i][6];
	  	$total_pagado6=$total_pagado6+$pagado6[$i][6];
  		$fila++;
   	}
 $fila++;  	
   	$nuevahoja->write($fila,6,'Sub total pagado pagos devengados:  ',$negrita); 
   	$nuevahoja->write($fila,7,number_format($total_pagado6,2),$negrita); 
   	/// TOTAL COMPROMETIDO:    	  	
   	$fila++;  	
   	$nuevahoja->write($fila,6,'TOTAL DEVENGADO: ',$negrita); 
   	$nuevahoja->write($fila,7,number_format($total_importe_devengado,2),$negrita);    	

// ----------------------   RESUMEN DE IMPORTES OBTENIDOS   -----------------
 //---------------------    RESUMEN DE IMPORTES OBTENIDOS ------------------------------------------
$fila=$fila+2;
   	$nuevahoja->write($fila,3,'RESUMEN DE IMPORTES OBTENIDOS');
$fila++;   	
    $nuevahoja->write($fila,1,'DESCRIPCIÓN ');  
 	$nuevahoja->write($fila,2,'SOLICITUDES '); 
 	$nuevahoja->write($fila,3,'RENDICIONES '); 
 	$nuevahoja->write($fila,4,'COMPROBANTES '); 
 	$nuevahoja->write($fila,5,'ADQUISICIONES ');  
	$nuevahoja->write($fila,6,'ADQUISICIONES 2'); 
 	$nuevahoja->write($fila,7,'P. DEVENGADOS ');
 	$nuevahoja->write($fila,8,'TOTALES '); 	 

$fila++;			
	$nuevahoja->write($fila,1,'TOTAL COMPROMETIDO',$negrita);	
	$nuevahoja->write($fila,2,number_format($total_comprometidoT,2));
	$nuevahoja->write($fila,3,number_format($total_comprometido2T,2));
	$nuevahoja->write($fila,4,number_format($total_comprometido3T,2));
	$nuevahoja->write($fila,5,number_format($total_comprometido4T,2));
	$nuevahoja->write($fila,6,number_format($total_comprometido5T,2));
	$nuevahoja->write($fila,7,number_format($total_comprometido6T,2)); 		
	$nuevahoja->write($fila,8,number_format($total_importe_comprometidoT,2));
	
$fila++;
     	 	
	$nuevahoja->write($fila,1,'TOTAL DEVENGADO',$negrita);
	$nuevahoja->write($fila,2,number_format($total_devengado,2));
	$nuevahoja->write($fila,3,number_format($total_devengado2,2));
	$nuevahoja->write($fila,4,number_format($total_devengado3,2));
	$nuevahoja->write($fila,5,number_format($total_devengado4,2));
	$nuevahoja->write($fila,6,number_format($total_devengado5,2));
	$nuevahoja->write($fila,7,number_format($total_devengado6,2)); 		
	$nuevahoja->write($fila,8,number_format($total_importe_devengado,2));		
$fila++;
     	 	
	$nuevahoja->write($fila,1,'TOTAL PAGADO',$negrita);
	$nuevahoja->write($fila,2,number_format($total_pagado,2));
	$nuevahoja->write($fila,3,number_format($total_pagado2,2));
	$nuevahoja->write($fila,4,number_format($total_pagado3,2));
	$nuevahoja->write($fila,5,number_format($total_pagado4,2));
	$nuevahoja->write($fila,6,number_format($total_pagado5,2));
	$nuevahoja->write($fila,7,number_format($total_pagado6,2)); 		
	$nuevahoja->write($fila,8,number_format($total_importe_pagado,2));	  	
   	
// ----------fin de resumen------------  	
	
	$docexcel->send($nombre_archivo);
	$docexcel->close();
		
?>