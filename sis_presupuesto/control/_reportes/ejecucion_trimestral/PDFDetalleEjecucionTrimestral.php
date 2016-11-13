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
		$this->Cell(0,5,'EJECUCIÓN PRESUPUESTARIA TRIMESTRAL ',0,1,'C');
		$this->SetFont('Arial','I',8);
		$this->Cell(0,3,' Presupuesto de '.$_SESSION['PDF_desc_pres_r'].' Gestión '.$_SESSION['PDF_gestion_r'] ,0,1,'C');
		$this->SetFont('Arial','I',7);
		$this->Cell(0,3,'Trimestre: '.$_SESSION['PDF_trimestre'],0,1,'C');
		$this->Cell(0,3,'Filtrado por: '.$_SESSION['PDF_filtro'],0,1,'C');
		$this->Cell(0,3,'(Expresado en '.$_SESSION['PDF_desc_moneda_r'].')',0,1,'C');
	    $this->ln(3);
		
        $this->Image('../../../../lib/images/logo_reporte.jpg',240,5,35,14);
        //$this->SetFont('Arial','BI',8);        
        $this->SetFont('Arial','B',6);

		//Títulos de las columnas
		$this->Cell(40,3.5,'DESCRIPCIÓN','LTR',0,'C');	
		$this->Cell(18,3.5,'PRESUPUESTO','TR',0,'C');	
		$this->Cell(18,3.5,'PRESUPUESTO','TR',0,'C');
		
		if($_SESSION["PDF_trimestre"]=='Enero - Febrero - Marzo')
		{
			$this->Cell(42,3.5,'ENERO','TBR',0,'C');	
			$this->Cell(42,3.5,'FEBRERO','TBR',0,'C');	
			$this->Cell(42,3.5,'MARZO','TBR',0,'C');
		}
		if($_SESSION["PDF_trimestre"]=='Abril - Mayo - Junio')
		{
			$this->Cell(42,3.5,'ABRIL','TBR',0,'C');	
			$this->Cell(42,3.5,'MAYO','TBR',0,'C');	
			$this->Cell(42,3.5,'JUNIO','TBR',0,'C');
		}
		if($_SESSION["PDF_trimestre"]=='Julio - Agosto - Septiembre')
		{
			$this->Cell(42,3.5,'JULIO','TBR',0,'C');	
			$this->Cell(42,3.5,'AGOSTO','TBR',0,'C');	
			$this->Cell(42,3.5,'SEPTIEMBRE','TBR',0,'C');
		}
		if($_SESSION["PDF_trimestre"]=='Octubre - Noviembre - Diciembre')
		{
			$this->Cell(42,3.5,'OCTUBRE','TBR',0,'C');	
			$this->Cell(42,3.5,'NOVIEMBRE','TBR',0,'C');	
			$this->Cell(42,3.5,'DICIEMBRE','TBR',0,'C');
		}		
		$this->Cell(18,3.5,'TOTAL EJEC.','TR',0,'C');
		$this->Cell(18,3.5,'EJECUCIÓN','TR',0,'C');
		$this->Cell(18,3.5,'TOTAL EJEC.','TR',0,'C');		
		$this->Cell(13,3.5,'% TOTAL','TR',1,'C');	
		
		
		
		$this->Cell(40,3.5,'','LBR',0,'C');				
		$this->Cell(18,3.5,'INICIAL','BR',0,'C');				
		$this->Cell(18,3.5,'VIGENTE','BR',0,'C');			
		$this->Cell(16,3.5,'PRES. VIG.','BR',0,'C');				
		$this->Cell(16,3.5,'EJECUCIÓN','BR',0,'C');		
		$this->Cell(10,3.5,'% EJEC.','BR',0,'C');				
		$this->Cell(16,3.5,'PRES. VIG.','BR',0,'C');				
		$this->Cell(16,3.5,'EJECUCIÓN','BR',0,'C');			
		$this->Cell(10,3.5,'% EJEC.','BR',0,'C');
		$this->Cell(16,3.5,'PRES. VIG.','BR',0,'C');				
		$this->Cell(16,3.5,'EJECUCIÓN','BR',0,'C');			
		$this->Cell(10,3.5,'% EJEC.','BR',0,'C');
		$this->Cell(18,3.5,'TRIMESTRE','BR',0,'C');	
		$this->Cell(18,3.5,'ACUMULADA','BR',0,'C');		
		$this->Cell(18,3.5,'AL: '.date("d-m-Y"),'BR',0,'C');		
		$this->Cell(13,3.5,'EJEC.','BR',1,'C');	
	}
	
	//Pie de página
	function Footer()
	{ 	
		$this->SetY(-12);
		$this->pieHash('PRESTO','','H');
		/*$fecha=date("d-m-Y");
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
		$this->Cell(18,3,'Hora: '.$hora,0,1,'L');*/	
	}
}

	$pdf=new PDF();
	$pdf->AddPage();
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,12);
	$pdf->SetMargins(5,1,5);
	$pdf->SetFont('Arial','B',8);

	if($_SESSION["PDF_trimestre"]=='Enero - Febrero - Marzo')
	{
		$pdf->SetVisibles(array(1,1,0,1,   1,1,1, 1,1,1, 1,1,1,1,1,  0,0,0, 0,0,0, 0,0,0,0,0,    0,0,0, 0,0,0, 0,0,0,0,0,   0,0,0, 0,0,0, 0,0,0,0,0, 1,1));	
	}
	if($_SESSION["PDF_trimestre"]=='Abril - Mayo - Junio')
	{
		$pdf->SetVisibles(array(1,1,0,1,   0,0,0, 0,0,0, 0,0,0,0,0,  1,1,1, 1,1,1, 1,1,1,1,1,    0,0,0, 0,0,0, 0,0,0,0,0,   0,0,0, 0,0,0, 0,0,0,0,0, 1,1));
	}
	if($_SESSION["PDF_trimestre"]=='Julio - Agosto - Septiembre')
	{
		$pdf->SetVisibles(array(1,1,0,1,   0,0,0, 0,0,0, 0,0,0,0,0,  0,0,0, 0,0,0, 0,0,0,0,0,    1,1,1, 1,1,1, 1,1,1,1,1,   0,0,0, 0,0,0, 0,0,0,0,0, 1,1));
	}
	if($_SESSION["PDF_trimestre"]=='Octubre - Noviembre - Diciembre')
	{
		$pdf->SetVisibles(array(1,1,0,1,   0,0,0, 0,0,0, 0,0,0,0,0,  0,0,0, 0,0,0, 0,0,0,0,0,    0,0,0, 0,0,0, 0,0,0,0,0,   1,1,1, 1,1,1, 1,1,1,1,1, 1,1));
	}
	
		
    $pdf->SetFonts(array('Arial','Arial','Arial','Arial',     'Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial',    'Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial',     'Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial',     'Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial',      'Arial','Arial'));
	$pdf->SetFontsStyles(array('','','','B',     '','','B','','','B','','','B','','',     '','','B','','','B','','','B','','',     '','','B','','','B','','','B','','',     '','','B','','','B','','','B','','',     'B','B'));	
	$pdf->SetFontsSizes(array(6,6,6,6,   6,6,6,6,6,6,6,6,6,6,6,    6,6,6,6,6,6,6,6,6,6,6,    6,6,6,6,6,6,6,6,6,6,6,   6,6,6,6,6,6,6,6,6,6,6,   6,6));
	$pdf->SetSpaces(array(3,3,3,3,   3,3,3,3,3,3,3,3,3,3,3,   3,3,3,3,3,3,3,3,3,3,3,   3,3,3,3,3,3,3,3,3,3,3,   3,3,3,3,3,3,3,3,3,3,3,    3,3));
	$pdf->SetWidths(array(40,18,18,18, 16,16,10, 16,16,10, 16,16,10,18,18,     16,16,10, 16,16,10, 16,16,10,18,18,     16,16,10, 16,16,10, 16,16,10,18,18,    16,16,10, 16,16,10, 16,16,10,18,18,  18,13));
	$pdf->SetDecimales(array(0,2,2,2,    2,2,2,2,2,2,2,2,2,2,2,    2,2,2,2,2,2,2,2,2,2,2,    2,2,2,2,2,2,2,2,2,2,2,    2,2,2,2,2,2,2,2,2,2,2,   2,2));
	$pdf->SetFormatNumber(array(0,1,1,   1,1,0,1,1,0,1,1,0,1,1,    1,1,0,1,1,0,1,1,0,1,1,    1,1,0,1,1,0,1,1,0,1,1,    1,1,0,1,1,0,1,1,0,1,1,    1,0));
	$pdf->SetAligns(array('L','R','R','R',    'R','R','R',  'R','R','R',  'R','R','R','R','R',        'R','R','R',  'R','R','R',  'R','R','R','R','R',       'R','R','R',  'R','R','R',  'R','R','R','R','R',       'R','R','R',  'R','R','R',  'R','R','R','R','R',      'R','R'));
    $v_eje_pres_partida=$_SESSION['PDF_RPPDetalle'];
    
   
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
    
    
		for ($j=0;$j<sizeof($v_eje_pres_partida);$j++)
		{
			
			$pdf->SetLineWidth(0.02);    	
		
			$pdf->Multitabla($v_eje_pres_partida[$j],0,3,3,6,1);
			
			$sumaPreI=$sumaPreI+$v_eje_pres_partida[$j][1];//
			//$sumaModi=$sumaModi+$v_eje_pres_partida[$j][2];//
			$sumaPreV=$sumaPreV+$v_eje_pres_partida[$j][3];//
			
			$sumaEneP=$sumaEneP+$v_eje_pres_partida[$j][4];//
			$sumaEneE=$sumaEneE+$v_eje_pres_partida[$j][5];//			
			$sumaFebP=$sumaFebP+$v_eje_pres_partida[$j][7];//
			$sumaFebE=$sumaFebE+$v_eje_pres_partida[$j][8];//		 
			$sumaMarP=$sumaMarP+$v_eje_pres_partida[$j][10];//  
			$sumaMarE=$sumaMarE+$v_eje_pres_partida[$j][11];// 			  
			$sumaTrim1=$sumaTrim1+$v_eje_pres_partida[$j][13];// 
			$sumaAcum1=$sumaAcum1+$v_eje_pres_partida[$j][14];// 
			
			$sumaAbrP=$sumaAbrP+$v_eje_pres_partida[$j][15];// 
			$sumaAbrE=$sumaAbrE+$v_eje_pres_partida[$j][16];//			
			$sumaMayP=$sumaMayP+$v_eje_pres_partida[$j][18];//
			$sumaMayE=$sumaMayE+$v_eje_pres_partida[$j][19];//		 
			$sumaJunP=$sumaJunP+$v_eje_pres_partida[$j][21];//  
			$sumaJunE=$sumaJunE+$v_eje_pres_partida[$j][22];// 
			$sumaTrim2=$sumaTrim2+$v_eje_pres_partida[$j][24];// 
			$sumaAcum2=$sumaAcum2+$v_eje_pres_partida[$j][25];//	
					  
			$sumaJulP=$sumaJulP+$v_eje_pres_partida[$j][26];// 
			$sumaJulE=$sumaJulE+$v_eje_pres_partida[$j][27];//			
			$sumaAgoP=$sumaAgoP+$v_eje_pres_partida[$j][29];//
			$sumaAgoE=$sumaAgoE+$v_eje_pres_partida[$j][30];//			 
			$sumaSepP=$sumaSepP+$v_eje_pres_partida[$j][32];//  
			$sumaSepE=$sumaSepE+$v_eje_pres_partida[$j][33];//
			$sumaTrim3=$sumaTrim3+$v_eje_pres_partida[$j][35];// 
			$sumaAcum3=$sumaAcum3+$v_eje_pres_partida[$j][36];//
						  
			$sumaOctP=$sumaOctP+$v_eje_pres_partida[$j][37];// 
			$sumaOctE=$sumaOctE+$v_eje_pres_partida[$j][38];//			
			$sumaNovP=$sumaNovP+$v_eje_pres_partida[$j][40];//
			$sumaNovE=$sumaNovE+$v_eje_pres_partida[$j][41];//			 
			$sumaDicP=$sumaDicP+$v_eje_pres_partida[$j][43];//  
			$sumaDicE=$sumaDicE+$v_eje_pres_partida[$j][44];//
			$sumaTrim4=$sumaTrim4+$v_eje_pres_partida[$j][46];// 
			$sumaAcum4=$sumaAcum4+$v_eje_pres_partida[$j][47];//
			  			  
			$sumaTotE=$sumaTotE+$v_eje_pres_partida[$j][48];//
				
		}
		
	     $pdf->SetFont('Arial','B',6);
	     $pdf->Cell(40,5,'TOTALES:',1,0,'R');
	     $pdf->Cell(18,5,number_format($sumaPreI,2),1,0,'R');	//
	     $pdf->Cell(18,5,number_format($sumaPreV,2),1,0,'R');	//	     
	     
	     
	     if($_SESSION["PDF_trimestre"]=='Enero - Febrero - Marzo')
		{
			 $pdf->Cell(16,5,number_format($sumaEneP,2),1,0,'R');	//
		     $pdf->Cell(16,5,number_format($sumaEneE,2),1,0,'R');	//
		     $pdf->Cell(10,5,number_format($sumaEneE*100 / ($sumaEneP + 0.1) ,1).' %',1,0,'R');	//
		     $pdf->Cell(16,5,number_format($sumaFebP,2),1,0,'R');	//
		     $pdf->Cell(16,5,number_format($sumaFebE,2),1,0,'R');	//
		     $pdf->Cell(10,5,number_format($sumaFebE*100 / ($sumaFebP + 0.1) ,1).' %',1,0,'R');	//
		     $pdf->Cell(16,5,number_format($sumaMarP,2),1,0,'R');	//
		     $pdf->Cell(16,5,number_format($sumaMarE,2),1,0,'R');	//
		     $pdf->Cell(10,5,number_format($sumaMarE*100 / ($sumaMarP + 0.1) ,1).' %',1,0,'R');	//
		     $pdf->Cell(18,5,number_format($sumaTrim1,2),1,0,'R');	//
		     $pdf->Cell(18,5,number_format($sumaAcum1,2),1,0,'R');	//	
		}
		if($_SESSION["PDF_trimestre"]=='Abril - Mayo - Junio')
		{
			 $pdf->Cell(16,5,number_format($sumaAbrP,2),1,0,'R');	//
		     $pdf->Cell(16,5,number_format($sumaAbrE,2),1,0,'R');	//
		     $pdf->Cell(10,5,number_format($sumaAbrE*100 / ($sumaAbrP + 0.1) ,1).' %',1,0,'R');	//
		     $pdf->Cell(16,5,number_format($sumaMayP,2),1,0,'R');	//
		     $pdf->Cell(16,5,number_format($sumaMayE,2),1,0,'R');	//
		     $pdf->Cell(10,5,number_format($sumaMayE*100 / ($sumaMayP + 0.1) ,1).' %',1,0,'R');	//
		     $pdf->Cell(16,5,number_format($sumaJunP,2),1,0,'R');	//
		     $pdf->Cell(16,5,number_format($sumaJunE,2),1,0,'R');	//
		     $pdf->Cell(10,5,number_format($sumaJunE*100 / ($sumaJunP + 0.1) ,1).' %',1,0,'R');	//
		     $pdf->Cell(18,5,number_format($sumaTrim2,2),1,0,'R');	//
		     $pdf->Cell(18,5,number_format($sumaAcum2,2),1,0,'R');	//	
		}
		if($_SESSION["PDF_trimestre"]=='Julio - Agosto - Septiembre')
		{
			 $pdf->Cell(16,5,number_format($sumaJulP,2),1,0,'R');	//
		     $pdf->Cell(16,5,number_format($sumaJulE,2),1,0,'R');	//
		     $pdf->Cell(10,5,number_format($sumaJulE*100 / ($sumaJulP + 0.1) ,1).' %',1,0,'R');	//
		     $pdf->Cell(16,5,number_format($sumaAgoP,2),1,0,'R');	//
		     $pdf->Cell(16,5,number_format($sumaAgoE,2),1,0,'R');	//
		     $pdf->Cell(10,5,number_format($sumaAgoE*100 / ($sumaAgoP + 0.1) ,1).' %',1,0,'R');	//
		     $pdf->Cell(16,5,number_format($sumaSepP,2),1,0,'R');	//
		     $pdf->Cell(16,5,number_format($sumaSepE,2),1,0,'R');	//
		     $pdf->Cell(10,5,number_format($sumaSepE*100 / ($sumaSepP + 0.1) ,1).' %',1,0,'R');	//
		     $pdf->Cell(18,5,number_format($sumaTrim3,2),1,0,'R');	//
		     $pdf->Cell(18,5,number_format($sumaAcum3,2),1,0,'R');	//	
		}
		if($_SESSION["PDF_trimestre"]=='Octubre - Noviembre - Diciembre')
		{
			 $pdf->Cell(16,5,number_format($sumaOctP,2),1,0,'R');	//
		     $pdf->Cell(16,5,number_format($sumaOctE,2),1,0,'R');	//
		     $pdf->Cell(10,5,number_format($sumaOctE*100 / ($sumaOctP + 0.1) ,1).' %',1,0,'R');	//
		     $pdf->Cell(16,5,number_format($sumaNovP,2),1,0,'R');	//
		     $pdf->Cell(16,5,number_format($sumaNovE,2),1,0,'R');	//
		     $pdf->Cell(10,5,number_format($sumaNovE*100 / ($sumaNovP + 0.1) ,1).' %',1,0,'R');	//
		     $pdf->Cell(16,5,number_format($sumaDicP,2),1,0,'R');	//
		     $pdf->Cell(16,5,number_format($sumaDicE,2),1,0,'R');	//
		     $pdf->Cell(10,5,number_format($sumaDicE*100 / ($sumaDicP + 0.1) ,1).' %',1,0,'R');	//
		     $pdf->Cell(18,5,number_format($sumaTrim4,2),1,0,'R');	//
		     $pdf->Cell(18,5,number_format($sumaAcum4,2),1,0,'R');	//	
		}
	     
	     	     
	     $pdf->Cell(18,5,number_format($sumaTotE,2),1,0,'R');	//
	     $pdf->Cell(13,5,number_format($sumaTotE*100 / ($sumaPreV + 0.1) ,1).' %',1,1,'R');	//
	     	     
	   	     
	     $pdf->SetDrawColor(0,0,0);
		 $pdf->SetLineWidth(0.2);
	   

$pdf->Output();
?>

