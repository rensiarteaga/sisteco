<?php

session_start();

require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{
	//var  $relleno=true;	
	
	function PDF($orientation='P',$unit='mm',$format='Letter')
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
		$this->Cell(0,5,'EJECUCIÓN PRESUPUESTARIA MENSUAL ACUMULADA',0,1,'C');
		$this->SetFont('Arial','I',8);
		$this->Cell(0,3,' Presupuesto de '.$_SESSION['PDF_desc_pres_r'].' Gestión '.$_SESSION['PDF_gestion_r'] ,0,1,'C');
		$this->SetFont('Arial','I',7);
		$this->Cell(0,3,'Mes: '.$_SESSION['PDF_mes'],0,1,'C');
		$this->Cell(0,3,'Filtrado por: '.$_SESSION['PDF_filtro'],0,1,'C');
		$this->Cell(0,3,'(Expresado en '.$_SESSION['PDF_desc_moneda_r'].')',0,1,'C');
	    $this->ln(3);
		
        $this->Image('../../../../lib/images/logo_reporte.jpg',180,5,35,14);
        //$this->SetFont('Arial','BI',8);        
        $this->SetFont('Arial','B',6);

		//Títulos de las columnas
		$this->Cell(75,3.5,'DESCRIPCIÓN','LTR',0,'C');	
		$this->Cell(25,3.5,'PRESUPUESTO','TR',0,'C');	
		$this->Cell(25,3.5,'PRESUPUESTO','TR',0,'C');		
		$this->Cell(25,3.5,'EJECUCIÓN ACUM.','TR',0,'C');		
		$this->Cell(25,3.5,'% DE','TR',1,'C');	
		
		
		
		$this->Cell(75,3.5,'','LBR',0,'C');				
		$this->Cell(25,3.5,'INICIAL ANUAL','BR',0,'C');				
		$this->Cell(25,3.5,'VIGENTE ANUAL','BR',0,'C');
		$this->Cell(25,3.5,'A: '.$_SESSION['PDF_mes'],'BR',0,'C');		
		$this->Cell(25,3.5,'EJECUCIÓN','BR',1,'C');	
	}
	
	//Pie de página
	function Footer()
	{ 	
		$this->SetY(-12);
		$this->pieHash('PRESTO','','V');
		/*$fecha=date("d-m-Y");
	    $hora=date("H:i:s");
	    $this->SetY(-12);
   	    $this->SetFont('Arial','',6);
   	    $this->Cell(75,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(55,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(50,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(75,3,'Sistema: ENDESIS - PRESTO',0,0,'L');
		$this->Cell(55,3,'',0,0,'C');
		$this->Cell(50,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,1,'L');*/	
	}
}

	$pdf=new PDF();
	$pdf->AddPage();
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,12);
	$pdf->SetMargins(5,1,5);
	$pdf->SetFont('Arial','B',8);
	
	//if ($_SESSION['PDF_mes']=='Enero')
	switch ($_SESSION['PDF_mes']) 
	{
		case 'Enero':
		$pdf->SetVisibles(array(1,1,0,1,   1,1,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0));		
		break;
		case 'Febrero':
		$pdf->SetVisibles(array(1,1,0,1,   0,0,  1,1,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0));
		break;
		case 'Marzo':
		$pdf->SetVisibles(array(1,1,0,1,   0,0,  0,0,  1,1,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0));
		break;	
		case 'Abril':
		$pdf->SetVisibles(array(1,1,0,1,   0,0,  0,0,  0,0,  1,1,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0));
		break;
		case 'Mayo':
		$pdf->SetVisibles(array(1,1,0,1,   0,0,  0,0,  0,0,  0,0,  1,1,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0));
		break;
		case 'Junio':
		$pdf->SetVisibles(array(1,1,0,1,   0,0,  0,0,  0,0,  0,0,  0,0,  1,1,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0));
		break;
		case 'Julio':
		$pdf->SetVisibles(array(1,1,0,1,   0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  1,1,  0,0,  0,0,  0,0,  0,0,  0,0));
		break;
		case 'Agosto':
		$pdf->SetVisibles(array(1,1,0,1,   0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  1,1,  0,0,  0,0,  0,0,  0,0));
		break;
		case 'Septiembre':
		$pdf->SetVisibles(array(1,1,0,1,   0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  1,1,  0,0,  0,0,  0,0));
		break;
		case 'Octubre':
		$pdf->SetVisibles(array(1,1,0,1,   0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  1,1,  0,0,  0,0));
		break;
		case 'Noviembre':
		$pdf->SetVisibles(array(1,1,0,1,   0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  1,1,  0,0));
		break;
		case 'Diciembre':
		$pdf->SetVisibles(array(1,1,0,1,   0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  0,0,  1,1,));
		break;	
	}
	
	
	
	
	//$pdf->SetVisibles(array(1,1,0,1,   0,0,0, 0,0,0, 0,0,0,0,0,  0,0,0, 0,0,0, 0,0,0,0,0,    0,0,0, 0,0,0, 0,0,0,0,0,   0,0,0, 0,0,0, 0,0,0,0,0, 0,0));
		
    $pdf->SetFonts(array('Arial','Arial','Arial','Arial',     'Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial',    'Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial',     'Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial',     'Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial',      'Arial','Arial'));
	$pdf->SetFontsStyles(array('','','','',     'B','',  'B','',  'B','',   'B','',  'B','',   'B','',   'B','',   'B','',   'B','',   'B','',   'B','',   'B',''));	
	$pdf->SetFontsSizes(array(6,6,6,6,   6,6,6,6,6,6,6,6,6,6,6,    6,6,6,6,6,6,6,6,6,6,6,    6,6,6,6,6,6,6,6,6,6,6,   6,6,6,6,6,6,6,6,6,6,6,   6,6));
	$pdf->SetSpaces(array(3,3,3,3,   3,3,3,3,3,3,3,3,3,3,3,   3,3,3,3,3,3,3,3,3,3,3,   3,3,3,3,3,3,3,3,3,3,3,   3,3,3,3,3,3,3,3,3,3,3,    3,3));
	$pdf->SetWidths(array(75,25,25,25,  25,25,  25,25,  25,25,  25,25,  25,25,  25,25,  25,25,  25,25,  25,25,  25,25,  25,25,  25,25));
	$pdf->SetDecimales(array(0,2,2,2,    2,2,2,2,2,2,2,2,2,2,2,    2,2,2,2,2,2,2,2,2,2,2,    2,2,2,2,2,2,2,2,2,2,2,    2,2,2,2,2,2,2,2,2,2,2,   2,2));
	$pdf->SetFormatNumber(array(0,1,1,1,   1,0,  1,0,  1,0,  1,0,  1,0,  1,0,  1,0,  1,0,  1,0,  1,0,  1,0,    1,0));
	$pdf->SetAligns(array('L','R','R','R',    'R','R','R',  'R','R','R',  'R','R','R','R','R',        'R','R','R',  'R','R','R',  'R','R','R','R','R',       'R','R','R',  'R','R','R',  'R','R','R','R','R',       'R','R','R',  'R','R','R',  'R','R','R','R','R',      'R','R'));
    $v_eje_pres_partida=$_SESSION['PDF_RPPDetalle'];
    
   
    $sumaPreI=0;
    $sumaPreV=0;
        
    
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
    
    
		for ($j=0;$j<sizeof($v_eje_pres_partida);$j++)
		{			
			$pdf->SetLineWidth(0.02);    	
		
			$pdf->Multitabla($v_eje_pres_partida[$j],0,3,3,6,1);
			
						
			
			$sumaPreI=$sumaPreI+$v_eje_pres_partida[$j][1];//
			//$sumaModi=$sumaModi+$v_eje_pres_partida[$j][2];//
			$sumaPreV=$sumaPreV+$v_eje_pres_partida[$j][3];//
			
			$sumaEneE=$sumaEneE+$v_eje_pres_partida[$j][4];//
			$sumaFebE=$sumaFebE+$v_eje_pres_partida[$j][6];//
			$sumaMarE=$sumaMarE+$v_eje_pres_partida[$j][8];// 	
			
			$sumaAbrE=$sumaAbrE+$v_eje_pres_partida[$j][10];//	
			$sumaMayE=$sumaMayE+$v_eje_pres_partida[$j][12];//
			$sumaJunE=$sumaJunE+$v_eje_pres_partida[$j][14];//
			
			$sumaJulE=$sumaJulE+$v_eje_pres_partida[$j][16];//
			$sumaAgoE=$sumaAgoE+$v_eje_pres_partida[$j][18];//
			$sumaSepE=$sumaSepE+$v_eje_pres_partida[$j][20];//
			
			$sumaOctE=$sumaOctE+$v_eje_pres_partida[$j][22];//	
			$sumaNovE=$sumaNovE+$v_eje_pres_partida[$j][24];//
			$sumaDicE=$sumaDicE+$v_eje_pres_partida[$j][26];//			
		}
		
	     $pdf->SetFont('Arial','B',6);
	     $pdf->Cell(75,5,'TOTALES:',1,0,'R');
	     $pdf->Cell(25,5,number_format($sumaPreI,2),1,0,'R');	//
	     $pdf->Cell(25,5,number_format($sumaPreV,2),1,0,'R');	//	

	switch ($_SESSION['PDF_mes']) 
	{
		case 'Enero':
			$pdf->Cell(25,5,number_format($sumaEneE,2),1,0,'R');	//
	    	$pdf->Cell(25,5,number_format($sumaEneE*100 / ($sumaPreV + 0.1) ,1).' %',1,0,'R');	// 
		break;
		case 'Febrero':
			$pdf->Cell(25,5,number_format($sumaFebE,2),1,0,'R');	//
	     	$pdf->Cell(25,5,number_format($sumaFebE*100 / ($sumaPreV + 0.1) ,1).' %',1,0,'R');	// 
		break;
		case 'Marzo':
			$pdf->Cell(25,5,number_format($sumaMarE,2),1,0,'R');	//
	     	$pdf->Cell(25,5,number_format($sumaMarE*100 / ($sumaPreV + 0.1) ,1).' %',1,0,'R');	// 
		break;	
		case 'Abril':
			$pdf->Cell(25,5,number_format($sumaAbrE,2),1,0,'R');	//
	     	$pdf->Cell(25,5,number_format($sumaAbrE*100 / ($sumaPreV + 0.1) ,1).' %',1,0,'R');	// 
		break;
		case 'Mayo':
			$pdf->Cell(25,5,number_format($sumaMayE,2),1,0,'R');	//
	     	$pdf->Cell(25,5,number_format($sumaMayE*100 / ($sumaPreV + 0.1) ,1).' %',1,0,'R');	// 
		break;
		case 'Junio':
			$pdf->Cell(25,5,number_format($sumaJunE,2),1,0,'R');	//
	     	$pdf->Cell(25,5,number_format($sumaJunE*100 / ($sumaPreV + 0.1) ,1).' %',1,0,'R');	// 
		break;
		case 'Julio':
			$pdf->Cell(25,5,number_format($sumaJulE,2),1,0,'R');	//
	     	$pdf->Cell(25,5,number_format($sumaJulE*100 / ($sumaPreV + 0.1) ,1).' %',1,0,'R');	// 
		break;
		case 'Agosto':
			$pdf->Cell(25,5,number_format($sumaAgoE,2),1,0,'R');	//
	     	$pdf->Cell(25,5,number_format($sumaAgoE*100 / ($sumaPreV + 0.1) ,1).' %',1,0,'R');	// 
		break;
		case 'Septiembre':
			$pdf->Cell(25,5,number_format($sumaSepE,2),1,0,'R');	//
	     	$pdf->Cell(25,5,number_format($sumaSepE*100 / ($sumaPreV + 0.1) ,1).' %',1,0,'R');	// 
		break;
		case 'Octubre':
			$pdf->Cell(25,5,number_format($sumaOctE,2),1,0,'R');	//
	     	$pdf->Cell(25,5,number_format($sumaOctE*100 / ($sumaPreV + 0.1) ,1).' %',1,0,'R');	// 
		break;
		case 'Noviembre':
			$pdf->Cell(25,5,number_format($sumaNovE,2),1,0,'R');	//
	     	$pdf->Cell(25,5,number_format($sumaNovE*100 / ($sumaPreV + 0.1) ,1).' %',1,0,'R');	// 
		break;
		case 'Diciembre':
			$pdf->Cell(25,5,number_format($sumaDicE,2),1,0,'R');	//
	     	$pdf->Cell(25,5,number_format($sumaDicE*100 / ($sumaPreV + 0.1) ,1).' %',1,1,'R');	// 
		break;	
	}
	  	     
	   	     
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetLineWidth(0.2);
	   

$pdf->Output();
?>

