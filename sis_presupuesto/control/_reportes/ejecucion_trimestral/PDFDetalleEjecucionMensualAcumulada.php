<?php

session_start();

require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{
	var  $relleno=true;	
	
	function PDF($orientation='L',$unit='mm',$format='Letter')
	{
		//Llama al constructor de la clase padre
		$this->FPDF($orientation,$unit,$format);
		$this-> AddFont('Arial','','arial.php');
		//Iniciación de variables
	}
	
	//Cabecera
	function Header()
	{
		$this->SetMargins(5,1,5);
		$this->SetFont('Arial','B',14);
		
		$this->SetY(8);
		$this->Cell(0,5,'EJECUCIÓN PRESUPUESTARIA ACUMULADA POR MESES',0,1,'C');
		$this->SetFont('Arial','I',8);
		$this->Cell(0,3,' Presupuesto de '.$_SESSION['PDF_desc_pres_r'].' Gestión '.$_SESSION['PDF_gestion_r'] ,0,1,'C');
		$this->SetFont('Arial','I',7);
		$this->Cell(0,3,'Acumulada hasta: '.$_SESSION['PDF_mes'],0,1,'C');
		$this->Cell(0,3,'Filtrado por: '.$_SESSION['PDF_filtro'],0,1,'C');
		$this->Cell(0,3,'(Expresado en '.$_SESSION['PDF_desc_moneda_r'].')',0,1,'C');
	    $this->ln(3);
		
        $this->Image('../../../../lib/images/logo_reporte.jpg',240,5,35,14);
        //$this->SetFont('Arial','BI',8);        
        $this->SetFont('Arial','B',6);

		//Títulos de las columnas
		$this->Cell(31,3.5,'DESCRIPCIÓN','LTR',0,'C');	
		$this->Cell(22,3.5,'PRESUPUESTO','TR',0,'C');	
		//$this->Cell(17,3.5,'MODIFICACIÓN','TR',0,'C');
		$this->Cell(22,3.5,'PRES. VIGENTE','TR',0,'C');		 
		
		$this->Cell(14,3.5,'ENERO','TR',0,'C');	
		$this->Cell(14,3.5,'FEBRERO','TR',0,'C');	
		$this->Cell(14,3.5,'MARZO','TR',0,'C');
	
		$this->Cell(14,3.5,'ABRIL','TR',0,'C');	
		$this->Cell(14,3.5,'MAYO','TR',0,'C');	
		$this->Cell(14,3.5,'JUNIO','TR',0,'C');
	
		$this->Cell(14,3.5,'JULIO','TR',0,'C');	
		$this->Cell(14,3.5,'AGOSTO','TR',0,'C');	
		$this->Cell(14,3.5,'SEPTIEMBRE','TR',0,'C');
	
		$this->Cell(14,3.5,'OCTUBRE','TR',0,'C');	
		$this->Cell(14,3.5,'NOVIEMBRE','TR',0,'C');	
		$this->Cell(14,3.5,'DICIEMBRE','TR',0,'C');
		
		$this->Cell(17,3.5,'TOTAL EJEC.','TR',0,'C');		
		$this->Cell(10,3.5,'% TOTAL','TR',1,'C');	
		
		$this->Cell(31,3.5,'','LBR',0,'C');				
		$this->Cell(22,3.5,'INICIAL','BR',0,'C');
		//$this->Cell(17,3.5,'PRESUP.','BR',0,'C');				
		$this->Cell(22,3.5,'A '.$_SESSION['PDF_mes'],'BR',0,'C');			
		//$this->Cell(16,3.5,'PRES. VIG.','BR',0,'C');				
		$this->Cell(14,3.5,'EJEC.','BR',0,'C');					
		$this->Cell(14,3.5,'EJEC.','BR',0,'C');						
		$this->Cell(14,3.5,'EJEC.','BR',0,'C');	
		$this->Cell(14,3.5,'EJEC.','BR',0,'C');					
		$this->Cell(14,3.5,'EJEC.','BR',0,'C');						
		$this->Cell(14,3.5,'EJEC.','BR',0,'C');
		$this->Cell(14,3.5,'EJEC.','BR',0,'C');					
		$this->Cell(14,3.5,'EJEC.','BR',0,'C');						
		$this->Cell(14,3.5,'EJEC.','BR',0,'C');
		$this->Cell(14,3.5,'EJEC.','BR',0,'C');					
		$this->Cell(14,3.5,'EJEC.','BR',0,'C');						
		$this->Cell(14,3.5,'EJEC.','BR',0,'C');		
				
		$this->Cell(17,3.5,'A '.$_SESSION['PDF_mes'],'BR',0,'C');		
		$this->Cell(10,3.5,'EJEC.','BR',1,'C');	
	}
	
	//Pie de página
	function Footer()
	{ 	
		$fecha=date("d-m-Y");
	    $hora=date("H:i:s");
	    $this->SetY(-12);
   	    $this->SetFont('Arial','',6);
   	    $this->Cell(100,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(80,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(70,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(100,3,'Sistema: ENDESIS - PRESTO',0,0,'L');
		$this->Cell(80,3,'',0,0,'C');
		$this->Cell(70,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,1,'L');	
	}
}

	$pdf=new PDF();
	$pdf->AddPage();
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,12);
	$pdf->SetMargins(5,1,5);
	$pdf->SetFont('Arial','B',8);

	switch ($_SESSION['PDF_mes']) 
	{
		case 'ENERO':
		$pdf->SetVisibles(array(1,1,  1,0,0,0,0,0,0,0,0,0,0,0,   1,1,1,1,1,1,1,1,1,1,1,1,   1,0,0,0,0,0,0,0,0,0,0,0,   1,0,0,0,0,0,0,0,0,0,0,0,));		
		break;
		case 'FEBRERO':
		$pdf->SetVisibles(array(1,1,  0,1,0,0,0,0,0,0,0,0,0,0,   1,1,1,1,1,1,1,1,1,1,1,1,   0,1,0,0,0,0,0,0,0,0,0,0,   0,1,0,0,0,0,0,0,0,0,0,0));
		break;
		case 'MARZO':
		$pdf->SetVisibles(array(1,1,  0,0,1,0,0,0,0,0,0,0,0,0,   1,1,1,1,1,1,1,1,1,1,1,1,   0,0,1,0,0,0,0,0,0,0,0,0,   0,0,1,0,0,0,0,0,0,0,0,0));
		break;	
		case 'ABRIL':
		$pdf->SetVisibles(array(1,1,  0,0,0,1,0,0,0,0,0,0,0,0,   1,1,1,1,1,1,1,1,1,1,1,1,   0,0,0,1,0,0,0,0,0,0,0,0,   0,0,0,1,0,0,0,0,0,0,0,0));
		break;
		case 'MAYO':
		$pdf->SetVisibles(array(1,1,  0,0,0,0,1,0,0,0,0,0,0,0,   1,1,1,1,1,1,1,1,1,1,1,1,   0,0,0,0,1,0,0,0,0,0,0,0,   0,0,0,0,1,0,0,0,0,0,0,0));
		break;
		case 'JUNIO':
		$pdf->SetVisibles(array(1,1,  0,0,0,0,0,1,0,0,0,0,0,0,   1,1,1,1,1,1,1,1,1,1,1,1,   0,0,0,0,0,1,0,0,0,0,0,0,   0,0,0,0,0,1,0,0,0,0,0,0));
		break;
		case 'JULIO':
		$pdf->SetVisibles(array(1,1,  0,0,0,0,0,0,1,0,0,0,0,0,   1,1,1,1,1,1,1,1,1,1,1,1,   0,0,0,0,0,0,1,0,0,0,0,0,   0,0,0,0,0,0,1,0,0,0,0,0));
		break;
		case 'AGOSTO':
		$pdf->SetVisibles(array(1,1,  0,0,0,0,0,0,0,1,0,0,0,0,   1,1,1,1,1,1,1,1,1,1,1,1,   0,0,0,0,0,0,0,1,0,0,0,0,   0,0,0,0,0,0,0,1,0,0,0,0));
		break;
		case 'SEPTIEMBRE':
		$pdf->SetVisibles(array(1,1,  0,0,0,0,0,0,0,0,1,0,0,0,   1,1,1,1,1,1,1,1,1,1,1,1,   0,0,0,0,0,0,0,0,1,0,0,0,   0,0,0,0,0,0,0,0,1,0,0,0));
		break;
		case 'OCTUBRE':
		$pdf->SetVisibles(array(1,1,  0,0,0,0,0,0,0,0,0,1,0,0,   1,1,1,1,1,1,1,1,1,1,1,1,   0,0,0,0,0,0,0,0,0,1,0,0,   0,0,0,0,0,0,0,0,0,1,0,0));
		break;
		case 'NOVIEMBRE':
		$pdf->SetVisibles(array(1,1,  0,0,0,0,0,0,0,0,0,0,1,0,   1,1,1,1,1,1,1,1,1,1,1,1,   0,0,0,0,0,0,0,0,0,0,1,0,   0,0,0,0,0,0,0,0,0,0,1,0));
		break;
		case 'DICIEMBRE':
		$pdf->SetVisibles(array(1,1,  0,0,0,0,0,0,0,0,0,0,0,1,   1,1,1,1,1,1,1,1,1,1,1,1,   0,0,0,0,0,0,0,0,0,0,0,1,   0,0,0,0,0,0,0,0,0,0,0,1));
		break;	
	}
	
	//$pdf->SetVisibles(array(1,1,1,1,   0,1,0, 0,1,0, 0,1,0,0,0,  0,1,0, 0,1,0, 0,1,0,0,0,    0,1,0, 0,1,0, 0,1,0,0,0,   0,1,0, 0,1,0, 0,1,0,0,0, 1,1));
		
    $pdf->SetFonts(array('Arial','Arial',     'Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial',    'Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial',     'Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial',     'Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial',      'Arial','Arial'));
	$pdf->SetFontsStyles(array('','B',     '','','','','','','','','','','','',     '','','','','','','','','','','','',     'B','B','B','B','B','B','B','B','B','B','B','B',     'B','B','B','B','B','B','B','B','B','B','B','B'));	
	$pdf->SetFontsSizes(array(6,6,   6,6,6,6,6,6,6,6,6,6,6,6,    6,6,6,6,6,6,6,6,6,6,6,6,    6,6,6,6,6,6,6,6,6,6,6,6,   6,6,6,6,6,6,6,6,6,6,6,6));
	$pdf->SetSpaces(array(3,3,   3,3,3,3,3,3,3,3,3,3,3,   3,3,3,3,3,3,3,3,3,3,3,   3,3,3,3,3,3,3,3,3,3,3,   3,3,3,3,3,3,3,3,3,3,3,    3,3));
	
	$pdf->SetWidths(array(31,22,   22,22,22,22,22,22,22,22,22,22,22,22,   14,14,14,14,14,14,14,14,14,14,14,14,    17,17,17,17,17,17,17,17,17,17,17,17,    10,10,10,10,10,10,10,10,10,10,10,10));
	$pdf->SetDecimales(array(0,2,    2,2,2,2,2,2,2,2,2,2,2,2,   2,2,2,2,2,2,2,2,2,2,2,2,   2,2,2,2,2,2,2,2,2,2,2,2,   2,2,2,2,2,2,2,2,2,2,2,2));
	$pdf->SetFormatNumber(array(0,1,    1,1,1,1,1,1,1,1,1,1,1,1,    1,1,1,1,1,1,1,1,1,1,1,1,    1,1,1,1,1,1,1,1,1,1,1,1,    0,0,0,0,0,0,0,0,0,0,0,0));
	$pdf->SetAligns(array('L','R',    'R','R','R','R','R','R','R','R','R','R','R',        'R','R','R','R','R','R','R','R','R','R','R','R',       'R','R','R','R','R','R','R','R','R','R','R','R',       'R','R','R','R','R','R','R','R','R','R','R','R'));
    $v_eje_pres_partida=$_SESSION['PDF_RPPDetalle'];
    
   
    $sumaPreI=0;
   		
    $sumaEnePV=0;
	$sumaFebPV=0;
	$sumaMarPV=0;
	$sumaAbrPV=0;
	$sumaMayPV=0;
	$sumaJunPV=0;
	$sumaJulPV=0;
	$sumaAgoPV=0;
	$sumaSepPV=0;
	$sumaOctPV=0;
	$sumaNovPV=0;	
	$sumaDicPV=0;
	
	
    $sumaEneE=0;
    $sumaFebE=0;
    $sumaMarE=0;
    $sumaAbrE=0;
    $sumaMayE=0; 
    $sumaJunE=0;
    $sumaJulE=0;
    $sumaAgoE=0;
    $sumaSepE=0;
    $sumaOctE=0;
	$sumaNovE=0;
    $sumaDicE=0;
    
    
    $sumaTotEneE=0;
    $sumaTotFebE=0;
    $sumaTotMarE=0;
    $sumaTotAbrE=0;
    $sumaTotMayE=0; 
    $sumaTotJunE=0;
    $sumaTotJulE=0;
    $sumaTotAgoE=0;
    $sumaTotSepE=0;
    $sumaTotOctE=0;
	$sumaTotNovE=0;
    $sumaTotDicE=0;
    
    
		for ($j=0;$j<sizeof($v_eje_pres_partida);$j++)
		{
			$pdf->SetLineWidth(0.02);
			$pdf->Multitabla($v_eje_pres_partida[$j],0,3,3,6,1);
			
			$sumaPreI=$sumaPreI+$v_eje_pres_partida[$j][1];//
			
			$sumaEnePV=$sumaEnePV+$v_eje_pres_partida[$j][2];//
			$sumaFebPV=$sumaFebPV+$v_eje_pres_partida[$j][3];//
			$sumaMarPV=$sumaMarPV+$v_eje_pres_partida[$j][4];//
			$sumaAbrPV=$sumaAbrPV+$v_eje_pres_partida[$j][5];//
			$sumaMayPV=$sumaMayPV+$v_eje_pres_partida[$j][6];//
			$sumaJunPV=$sumaJunPV+$v_eje_pres_partida[$j][7];//
			$sumaJulPV=$sumaJulPV+$v_eje_pres_partida[$j][8];//
			$sumaAgoPV=$sumaAgoPV+$v_eje_pres_partida[$j][9];//
			$sumaSepPV=$sumaSepPV+$v_eje_pres_partida[$j][10];//
			$sumaOctPV=$sumaOctPV+$v_eje_pres_partida[$j][11];//
			$sumaNovPV=$sumaNovPV+$v_eje_pres_partida[$j][12];//
			$sumaDicPV=$sumaDicPV+$v_eje_pres_partida[$j][13];//
			
			$sumaEneE=$sumaEneE+$v_eje_pres_partida[$j][14];//
			$sumaFebE=$sumaFebE+$v_eje_pres_partida[$j][15];//
			$sumaMarE=$sumaMarE+$v_eje_pres_partida[$j][16];//
			$sumaAbrE=$sumaAbrE+$v_eje_pres_partida[$j][17];//
			$sumaMayE=$sumaMayE+$v_eje_pres_partida[$j][18];//
			$sumaJunE=$sumaJunE+$v_eje_pres_partida[$j][19];//
			$sumaJulE=$sumaJulE+$v_eje_pres_partida[$j][20];//
			$sumaAgoE=$sumaAgoE+$v_eje_pres_partida[$j][21];//
			$sumaSepE=$sumaSepE+$v_eje_pres_partida[$j][22];//
			$sumaOctE=$sumaOctE+$v_eje_pres_partida[$j][23];//
			$sumaNovE=$sumaNovE+$v_eje_pres_partida[$j][24];//
			$sumaDicE=$sumaDicE+$v_eje_pres_partida[$j][25];//
			
			$sumaTotEneE=$sumaTotEneE+$v_eje_pres_partida[$j][26];//
			$sumaTotFebE=$sumaTotFebE+$v_eje_pres_partida[$j][27];//
			$sumaTotMarE=$sumaTotMarE+$v_eje_pres_partida[$j][28];//
			$sumaTotAbrE=$sumaTotAbrE+$v_eje_pres_partida[$j][29];//
			$sumaTotMayE=$sumaTotMayE+$v_eje_pres_partida[$j][30];//
			$sumaTotJunE=$sumaTotJunE+$v_eje_pres_partida[$j][31];//
			$sumaTotJulE=$sumaTotJulE+$v_eje_pres_partida[$j][32];//
			$sumaTotAgoE=$sumaTotAgoE+$v_eje_pres_partida[$j][33];//
			$sumaTotSepE=$sumaTotSepE+$v_eje_pres_partida[$j][34];//
			$sumaTotOctE=$sumaTotOctE+$v_eje_pres_partida[$j][35];//
			$sumaTotNovE=$sumaTotNovE+$v_eje_pres_partida[$j][36];//
			$sumaTotDicE=$sumaTotDicE+$v_eje_pres_partida[$j][37];//				
		}
		
	     $pdf->SetFont('Arial','B',6);
	     $pdf->Cell(31,5,'TOTALES:',1,0,'R');
	     $pdf->Cell(22,5,number_format($sumaPreI,2),1,0,'R');	
		 
		switch ($_SESSION['PDF_mes']) 
		{
			case 'ENERO':
			$pdf->Cell(22,5,number_format($sumaEnePV,2),1,0,'R');		
			break;
			case 'FEBRERO':
			$pdf->Cell(22,5,number_format($sumaFebPV,2),1,0,'R');		
			break;
			case 'MARZO':
			$pdf->Cell(22,5,number_format($sumaMarPV,2),1,0,'R');		
			break;
			case 'ABRIL':
			$pdf->Cell(22,5,number_format($sumaAbrPV,2),1,0,'R');		
			break;
			case 'MAYO':
			$pdf->Cell(22,5,number_format($sumaMayPV,2),1,0,'R');		
			break;
			case 'JUNIO':
			$pdf->Cell(22,5,number_format($sumaJunPV,2),1,0,'R');		
			break;
			case 'JULIO':
			$pdf->Cell(22,5,number_format($sumaJulPV,2),1,0,'R');		
			break;
			case 'AGOSTO':
			$pdf->Cell(22,5,number_format($sumaAgoPV,2),1,0,'R');		
			break;
			case 'SEPTIEMBRE':
			$pdf->Cell(22,5,number_format($sumaSepPV,2),1,0,'R');		
			break;
			case 'OCTUBRE':
			$pdf->Cell(22,5,number_format($sumaOctPV,2),1,0,'R');		
			break;
			case 'NOVIEMBRE':
			$pdf->Cell(22,5,number_format($sumaNovPV,2),1,0,'R');		
			break;
			case 'DICIEMBRE':
			$pdf->Cell(22,5,number_format($sumaDicPV,2),1,0,'R');		
			break;
		}
	    		 
	     $pdf->Cell(14,5,number_format($sumaEneE,2),1,0,'R');	
	     $pdf->Cell(14,5,number_format($sumaFebE,2),1,0,'R');
	     $pdf->Cell(14,5,number_format($sumaMarE,2),1,0,'R');
	     $pdf->Cell(14,5,number_format($sumaAbrE,2),1,0,'R');
	     $pdf->Cell(14,5,number_format($sumaMayE,2),1,0,'R');
	     $pdf->Cell(14,5,number_format($sumaJunE,2),1,0,'R');
	     $pdf->Cell(14,5,number_format($sumaJulE,2),1,0,'R');
	     $pdf->Cell(14,5,number_format($sumaAgoE,2),1,0,'R');
	     $pdf->Cell(14,5,number_format($sumaSepE,2),1,0,'R');
	     $pdf->Cell(14,5,number_format($sumaOctE,2),1,0,'R');
	     $pdf->Cell(14,5,number_format($sumaNovE,2),1,0,'R');
	     $pdf->Cell(14,5,number_format($sumaDicE,2),1,0,'R');
	       
	    switch ($_SESSION['PDF_mes']) 
		{
			case 'ENERO':			
			$pdf->Cell(17,5,number_format($sumaTotEneE,2),1,0,'R');	//
			$pdf->Cell(10,5,number_format($sumaTotEneE*100 / ($sumaEnePV + 0.1) ,1).' %',1,0,'R');	//			
			break;
			case 'FEBRERO':			
			$pdf->Cell(17,5,number_format($sumaTotFebE,2),1,0,'R');	//
			$pdf->Cell(10,5,number_format($sumaTotFebE*100 / ($sumaFebPV + 0.1) ,1).' %',1,0,'R');	//			
			break;
			case 'MARZO':			
			$pdf->Cell(17,5,number_format($sumaTotMarE,2),1,0,'R');	//
			$pdf->Cell(10,5,number_format($sumaTotMarE*100 / ($sumaMarPV + 0.1) ,1).' %',1,0,'R');	//			
			break;
			case 'ABRIL':			
			$pdf->Cell(17,5,number_format($sumaTotAbrE,2),1,0,'R');	//
			$pdf->Cell(10,5,number_format($sumaTotAbrE*100 / ($sumaAbrPV + 0.1) ,1).' %',1,0,'R');	//			
			break;
			case 'MAYO':			
			$pdf->Cell(17,5,number_format($sumaTotMayE,2),1,0,'R');	//
			$pdf->Cell(10,5,number_format($sumaTotMayE*100 / ($sumaMayPV + 0.1) ,1).' %',1,0,'R');	//			
			break;
			case 'JUNIO':			
			$pdf->Cell(17,5,number_format($sumaTotJunE,2),1,0,'R');	//
			$pdf->Cell(10,5,number_format($sumaTotJunE*100 / ($sumaJunPV + 0.1) ,1).' %',1,0,'R');	//			
			break;
			case 'JULIO':			
			$pdf->Cell(17,5,number_format($sumaTotJulE,2),1,0,'R');	//
			$pdf->Cell(10,5,number_format($sumaTotJulE*100 / ($sumaJulPV + 0.1) ,1).' %',1,0,'R');	//			
			break;
			case 'AGOSTO':			
			$pdf->Cell(17,5,number_format($sumaTotAgoE,2),1,0,'R');	//
			$pdf->Cell(10,5,number_format($sumaTotAgoE*100 / ($sumaAgoPV + 0.1) ,1).' %',1,0,'R');	//			
			break;
			case 'SEPTIEMBRE':			
			$pdf->Cell(17,5,number_format($sumaTotSepE,2),1,0,'R');	//
			$pdf->Cell(10,5,number_format($sumaTotSepE*100 / ($sumaSepPV + 0.1) ,1).' %',1,0,'R');	//			
			break;
			case 'OCTUBRE':			
			$pdf->Cell(17,5,number_format($sumaTotOctE,2),1,0,'R');	//
			$pdf->Cell(10,5,number_format($sumaTotOctE*100 / ($sumaOctPV + 0.1) ,1).' %',1,0,'R');	//			
			break;
			case 'NOVIEMBRE':			
			$pdf->Cell(17,5,number_format($sumaTotNovE,2),1,0,'R');	//
			$pdf->Cell(10,5,number_format($sumaTotNovE*100 / ($sumaNovPV + 0.1) ,1).' %',1,0,'R');	//			
			break;
			case 'DICIEMBRE':			
			$pdf->Cell(17,5,number_format($sumaTotDicE,2),1,0,'R');	//
			$pdf->Cell(10,5,number_format($sumaTotDicE*100 / ($sumaDicPV + 0.1) ,1).' %',1,0,'R');	//			
			break;
		}     
	   	     
	     $pdf->SetDrawColor(0,0,0);
		 $pdf->SetLineWidth(0.2);
	   

$pdf->Output();
?>

