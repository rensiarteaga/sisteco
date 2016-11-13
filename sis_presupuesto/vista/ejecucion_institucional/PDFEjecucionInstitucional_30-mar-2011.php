<?php
session_start();
/** Autor:   Ana Maria Villegas Quispe
 *  Fecha Modificación: 11/02/2010
 *  Desc Mod:           Se quitó la columna tipo
 */
require('../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{
	function PDF($orientation='L',$unit='mm',$format='Letter')
	{
		//Llama al constructor de la clase padre
		$this->FPDF($orientation,$unit,$format);
		$this-> AddFont('Arial','','arial.php');
		//Iniciación de variables
	}
	function SetPrograma($nombre_programa)
	{
		$this->nombre_programa=$nombre_programa;
	}
	//Cabecera
	function Header()
	{
		
		$this->SetLeftMargin(5);//margen izquierdo
		//$funciones = new funciones();
	    //Logo
	    	$this->Image('../../../lib/images/logo_reporte.jpg',240,5,36,10);
	     $this->SetFont('Arial','B',12);//tifo de fuente
	    //Movernos a la derecha
		$this->Ln(3);//salto de linea 
	    //$this->Cell(100);//celda de dibujo
	    IF($_SESSION['PDF_tipo_pres']>1)//PRESUPUESTOS DE GASTO E INVERSION
	    {
	    	$this->Cell(0,5,'EJECUCIÓN PRESUPUESTARIA DE GASTOS INSTITUCIONAL',0,1,'C'); //dibuja una celda con contenido y orientacion  x, y 
	    
	    }else{
	    	$this->Cell(0,5,'EJECUCIÓN PRESUPUESTARIA DE RECURSOS INSTITUCIONAL',0,1,'C'); //dibuja una celda con contenido y orientacion  x, y 
	     
	    }
	    $this->SetFont('Arial','I',10);
	   
	    $this->Cell(0,4,'Presupuesto de '.$_SESSION['PDF_desc_pres']." Gestión ".$_SESSION['PDF_gestion_pres'],0,1,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    $this->SetFont('Arial','I',7);
	   // $this->Ln();
	    $this->Cell(0,4,'Del '.$_SESSION['PDF_fecha_ini'].' Al '.$_SESSION['PDF_fecha_fin']." ",0,1,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    //$this->Ln(3);
	    $this->Cell(0,4,'(Expresado en '.$_SESSION['PDF_desc_moneda'].")",0,1,'C'); //dibuja una celad con contenido y orientacion  x, y 
	    
	    
	    //$this->Ln(8);//10
	    $this->SetFont('Arial','I',7);
	    	
	    $epe=" ";   
	    $bandera=false;
		    
	    if($_SESSION['PDF_regional'])
	    {
	     	$epe=$epe."REGIONAL: ".$_SESSION['PDF_regional'];$bandera=true;
		}
	   	if($_SESSION['PDF_financiador'])
	   	{
	     	if($bandera)
	     	{
	     		$epe=$epe." \n "."FINANCIADOR: ".$_SESSION['PDF_financiador'];	
	     	}
	     	else
	     	{
	     		$epe=$epe."FINANCIADOR: ".$_SESSION['PDF_financiador'];
	     	}
	 	}
	 	 
		if($_SESSION['PDF_programa']){
	 	if($bandera){$epe= $epe." \n "."PROGRAMA: ".$_SESSION['PDF_programa'];	
	 	}else{$epe=$epe."PROGRAMA: ".$_SESSION['PDF_programa'];}
	 	}	 
		if($_SESSION['PDF_proyecto']){
	 	if($bandera){$epe=$epe." \n "."SUBPROGRAMA: ".$_SESSION['PDF_proyecto'];	
	 	}else{$epe=$epe."SUBPROGRAMA: ".$_SESSION['PDF_proyecto'];}
	 	}	
	 	if($_SESSION['PDF_actividad']){
	 	if($bandera){$epe=$epe." \n "."ACTIVIDAD: ".$_SESSION['PDF_actividad'];	
	 	}else{$epe=$epe."ACTIVIDAD: ".$_SESSION['PDF_actividad'];}
	 	}
		  	 
	 	if($epe==" "){$epe="Todos";};
	 	
	 	if ($_SESSION['PDF_desc_presupuesto']==''){
	 		$this->Cell(45,2,'ESTRUCTURA PROGRAMATICA: ',0,1,'L',0);	
		$this->SetX(45);	
		$this->MultiCell(200,3.5,$epe);
		  	$this->Cell(45,2,'UNIDAD ORGANIZACIONAL:',0,1,'L',0);
	   	$this->SetX(45);	
	    $this->MultiCell(200,3.5,$_SESSION['PDF_unidad_organizacional'] );
	   	$this->Cell(45,2,'FUENTE DE FINANCIAMIENTO:',0,1,'L',0);
		$this->SetX(45);	
	    $this->MultiCell(200,3.5,$_SESSION['PDF_Fuente_financiamiento']);
	 	}else {
	 		
	 		$this->Cell(45,2,'DESCRIPCIÓN PRESUPUESTO: ',0,0,'L',0);	
			$this->MultiCell(200,3.5,$_SESSION['PDF_desc_presupuesto']);
		}
		
	    $this->Ln(2);
	  
	    $this->SetFont('Arial','B',5);
	  $this->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
	$this->SetFontsStyles(array('','','','','','','','','','','','','',''));
	$this->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5,5,5,5,5));
	$this->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
	$this->SetDecimales(array(0,0,2,2,2,2,2,2,2,2,2,2,2,2));
	$this->SetFormatNumber(array(0,0,1,1,1,1,1,1,1,1,1,1,1,1));
	$this->SetAligns(array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R'));
    $this->SetFillColor(168,199,255);//color de fondo las celdas 
	$this->SetFills(array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
	
	IF($_SESSION['PDF_tipo_pres']>1)//PRESUPUESTOS DE GASTO E INVERSION
	    {
	    $this->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1,1));
	    $this->SetWidths(array(7,65,18,18,18,18,18,18,18,18,18,18,18,18));
		
	    }ELSE{
	    	 $this->SetVisibles(array(1,1,1,1,1,0,0,1,1,1,1,1,1,1));
	   // $this->SetVisibles(array(1,1,1,1,1,1,0,0,1,1,1,1,1,1));
	    $this->SetWidths(array(10,74,20,20,20,20,0,0,20,20,20,20,20,20));
		
	    }
	
	    IF($_SESSION['PDF_tipo_pres']>1)//PRESUPUESTOS DE GASTO E INVERSION
	    {	
	    	$this->Cell(7,3,'CÓDIGO','T',0,'C',0);		//CODIGO
	    	$this->Cell(65,3,'PARTIDA','T',0,'C',0);	//PARTIDA
	    	$this->Cell(18,3,'PRESUPUESTO','T',0,'C');	//PRESUPUESTADO
		    $this->Cell(18,3,'MODIFICACIONES','T',0,'C');	//MODIFICACIONES
		    $this->Cell(18,3,'PRESUPUESTO ','T',0,'C');	//REFORMULACION
		    $this->Cell(18,3,'COMPROMISO','T',0,'C');	//COMPROMISO
		    $this->Cell(18,3,'PRESUPUESTO','T',0,'C');		//PRESUPUESTO POR COMPREMETER
		    $this->Cell(18,3,'DEVENGADO','T',0,'C');			//DEVENGADO
		    $this->Cell(18,3,'DEVENGADO','T',0,'C');		//DEVENGADO ACUMULADO
		    $this->Cell(18,3,'PRESUPUESTO POR','T',0,'C');		//PRESUPUESTO POR DEVENGAR
		    $this->Cell(18,3,'PAGADO','T',0,'C');		//PAGADO
		    $this->Cell(18,3,'PAGADO','T',0,'C');		//PAGADO ACUMULADO 
		    $this->Cell(18,3,'SALDO POR','T',1,'C');		//SALDO POR PAGAR
		    
		    $this->Cell(7,3,'','B',0,'C',0);		//CODIGO
	        $this->Cell(65,3,'','B',0,'C',0);	//PARTIDA
		    $this->Cell(18,3,'APROBADO','B',0,'C');	//PRESUPUESTADO
		    $this->Cell(18,3,'','B',0,'C');	//MODIFICACIONES
		    $this->Cell(18,3,'VIGENTE','B',0,'C');	//REFORMULACION
		    $this->Cell(18,3,'','B',0,'C');	//COMPROMISO
		    $this->Cell(18,3,'COMPROMETER','B',0,'C');		//PRESUPUESTO POR COMPROMETER
		    $this->Cell(18,3,'','B',0,'C');			//DEVENGADO
		    $this->Cell(18,3,'ACUMULADO','B',0,'C');		//DEVENGADO ACUMULADO
		    $this->Cell(18,3,'DEVENGAR','B',0,'C');		//PRESUPUESTO POR DEVENGAR
		    $this->Cell(18,3,'','B',0,'C');		//PAGADO
		    $this->Cell(18,3,'ACUMULADO','B',0,'C');		//PAGADO ACUMULADO 
		    $this->Cell(18,3,'PAGAR','B',1,'C');		//SALDO POR PAGAR ÓN
	
		}
		else //PRESUPUESTOS DE RECURSOS
	    {
	        $this->Cell(10,3,'RUBRO','T',0,'C',0);		//CODIGO
	        $this->Cell(74,3,'DESCRIPCION','T',0,'C',0);	//PARTIDA
	    	$this->Cell(20,3,'PRESUPUESTO','T',0,'C');	//PRESUPUESTADO
		    $this->Cell(20,3,'MODIFICACIONES','T',0,'C');	//MODIFICACIONES
		    $this->Cell(20,3,'PRESUPUESTO ','T',0,'C');	//REFORMULACION
		    $this->Cell(20,3,'DEVENGADO','T',0,'C');	//PRESUPUESTO VIGENTE
		    $this->Cell(20,3,'DEVENGADO','T',0,'C');	//COMPROMISO
		    $this->Cell(20,3,'SALDO POR','T',0,'C');		//PRESUPUESTO POR COMPREMETER
		    $this->Cell(20,3,'PERCIBIDO','T',0,'C');			//DEVENGADO
		    $this->Cell(20,3,'PERCIBIDO','T',0,'C');		//DEVENGADO ACUMULADO
		    $this->Cell(20,3,'SALDO POR','T',1,'C');		//PRESUPUESTO POR DEVENGAR
		    
		    $this->Cell(10,3,'','B',0,'C',0);		//CODIGO
	        $this->Cell(74,3,'','B',0,'C',0);	//PARTIDA
		    $this->Cell(20,3,'APROBADO','B',0,'C');	//PRESUPUESTADO
		    $this->Cell(20,3,'','B',0,'C');	//MODIFICACIONES
		    $this->Cell(20,3,'VIGENTE','B',0,'C');	//REFORMULACION
		    $this->Cell(20,3,'MES','B',0,'C');	//PRESUPUESTO VIGENTE
		    $this->Cell(20,3,'ACUMULADO','B',0,'C');	//COMPROMISO
		    $this->Cell(20,3,'DEVENGAR','B',0,'C');		//PRESUPUESTO POR COMPROMETER
		    $this->Cell(20,3,'MES','B',0,'C');			//DEVENGADO
		    $this->Cell(20,3,'ACUMULADO','B',0,'C');		//DEVENGADO ACUMULADO
		    $this->Cell(20,3,'PERCIBIR','B',1,'C');		//PRESUPUESTO POR DEVENGAR
		 
  }
	   $this->Ln(0.2);
	    $this->SetFont('Arial','B',6);
	
	   
	 	
	
	 
	}
	//Pie de página
	function Footer()
	{    
		if ($this->PageNo()!='{nb}'){
		$this->Cell(264,0.02	,'',1,1);	
			
		}
		 $fecha=date("d-m-Y");
	    $hora=date("H:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
   	    $this->Cell(100,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(80,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(55,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(100,3,'Sistema: ENDESIS -SCI',0,0,'L');
		$this->Cell(80,3,'',0,0,'C');
		$this->Cell(55,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
	}


}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,7);
$pdf->SetMargins(5,5,5);
$pdf->SetFont('Arial','B',16);
	
//Títulos de las columnas
	$pdf->Ln(0.2);
	$pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
	
	$pdf->SetFontsStyles(array('','','','','','','','','','','','','',''));
	$pdf->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5,5,5,5,5));
	$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3));
	$pdf->SetDecimales(array(0,0,2,2,2,2,2,2,2,2,2,2,2,2));
	$pdf->SetFormatNumber(array(0,0,1,1,1,1,1,1,1,1,1,1,1,1,1));
	$pdf->SetAligns(array('L','L','R','R','R','R','R','R','R','R','R','R','R','R','R'));
    
	
	IF($_SESSION['PDF_tipo_pres']>1)//PRESUPUESTOS DE GASTO E INVERSION
	    {
	    $pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1,1));
	    $pdf->SetWidths(array(7,65,18,18,18,18,18,18,18,18,18,18,18,18));
	    $pdf->SetFills(array(1,1,1,1,1,1,1,1,1,1,1,1,1,1));
		
	    }ELSE{
	    //$pdf->SetVisibles(array(1,1,1,1,1,1,0,0,1,1,1,1,1,1));
	    $pdf->SetVisibles(array(1,1,1,1,1,0,0,1,1,1,1,1,1,1));
	    $pdf->SetWidths(array(10,74,20,20,20,20,0,0,20,20,20,20,20,20));
	    $pdf->SetFills(array(1,1,1,1,1,1,1,1,1,1,1,1,1));
		
	    }
		
	
    
    $detalle_documentos=array();
    $detalle_documentos1=array();
    $detalle_documentos=$_SESSION['PDF_det_ejecucion_institucional'];
      
		$pdf->SetFont('Arial','B',5);
	for($j=0;$j<sizeof($detalle_documentos);$j++){
		$detalle_documentos1[$j][0]=$detalle_documentos[$j][1];
		    
		$detalle_documentos1[$j][1]=$detalle_documentos[$j][2];			
		$detalle_documentos1[$j][2]=$detalle_documentos[$j][4];
		$detalle_documentos1[$j][3]=$detalle_documentos[$j][5];
		$detalle_documentos1[$j][4]=$detalle_documentos[$j][6];
		$detalle_documentos1[$j][5]=$detalle_documentos[$j][7];
		$detalle_documentos1[$j][6]=$detalle_documentos[$j][8];
		$detalle_documentos1[$j][7]=$detalle_documentos[$j][9];
		$detalle_documentos1[$j][8]=$detalle_documentos[$j][10];
		$detalle_documentos1[$j][9]=$detalle_documentos[$j][11];
		$detalle_documentos1[$j][10]=$detalle_documentos[$j][12];
		$detalle_documentos1[$j][11]=$detalle_documentos[$j][13];
		$detalle_documentos1[$j][12]=$detalle_documentos[$j][14];
		
	}
    // print_r( $detalle_documentos1);
		//exit;
    for ($i=0;$i<sizeof($detalle_documentos1);$i++){
		if(($i % 2)==0){
			$pdf->SetFillColor(224,235,255);//color de fondo las celdas 
			//$pdf->SetFillColor(168,199,255);//color de fondo las celdas 
		}else{
			$pdf->SetFillColor(255,255,255);//color de fondo las celdas 
		}
		if($detalle_documentos[$i][3]!=1){
			$pdf->SetFontsStyles(array('BU','B','BU','BU','BU','BU','BU','BU','BU','BU','BU','BU','BU','BU'));
		}
		
			
		$pdf->Multitabla($detalle_documentos1[$i],0,5,3,5,1);
		$pdf->SetFontsStyles(array('','','','','','','','','','','','','','',''));
		
	}
	
	$pdf->Cell(264,0.02	,'',1,1);
	
		
	$pdf->SetFillColor(255,255,255);//color de fondo las celdas 
	
	

$pdf->Output();
?>

