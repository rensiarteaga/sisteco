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
		$this->Cell(0,5,'RESUMEN ANUAL DE TRASPASOS PRESUPUESTARIOS',0,1,'C');
		$this->SetFont('Arial','I',8);
		$this->Cell(0,3,' Presupuesto de '.$_SESSION['PDF_desc_pres_r'].' Gestión '.$_SESSION['PDF_gestion_r'] ,0,1,'C');
		$this->SetFont('Arial','I',7);
		$this->Cell(0,3,'Tipo de Modificación: '.$_SESSION['PDF_desc_tipo_traspaso'],0,1,'C');
		$this->Cell(0,3,'Filtrado por: '.$_SESSION['PDF_filtro'],0,1,'C');
		$this->Cell(0,3,'(Expresado en '.$_SESSION['PDF_desc_moneda_r'].')',0,1,'C');
	    $this->ln(3);
		
        $this->Image('../../../../lib/images/logo_reporte.jpg',240,5,35,14);
        //$this->SetFont('Arial','BI',8);        
        $this->SetFont('Arial','B',6);

		//Títulos de las columnas
		$this->Cell(41,3.5,'DESCRIPCIÓN','LTR',0,'C');	
		$this->Cell(17,3.5,'PRESUPUESTO','TR',0,'C');	
		//$this->Cell(17,3.5,'MODIFICACIÓN','TR',0,'C');
		$this->Cell(17,3.5,'PRESUPUESTO','TR',0,'C');		
		
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
		
		$this->Cell(17,3.5,'TOTAL MODIF.','TR',0,'C');		
		$this->Cell(10,3.5,'% TOTAL','TR',1,'C');	
		
		
		
		$this->Cell(41,3.5,'','LBR',0,'C');				
		$this->Cell(17,3.5,'INICIAL','BR',0,'C');
		//$this->Cell(17,3.5,'PRESUP.','BR',0,'C');				
		$this->Cell(17,3.5,'VIGENTE','BR',0,'C');			
		//$this->Cell(16,3.5,'PRES. VIG.','BR',0,'C');				
		$this->Cell(14,3.5,'MODIF.','BR',0,'C');					
		$this->Cell(14,3.5,'MODIF.','BR',0,'C');						
		$this->Cell(14,3.5,'MODIF.','BR',0,'C');	
		$this->Cell(14,3.5,'MODIF.','BR',0,'C');					
		$this->Cell(14,3.5,'MODIF.','BR',0,'C');						
		$this->Cell(14,3.5,'MODIF.','BR',0,'C');
		$this->Cell(14,3.5,'MODIF.','BR',0,'C');					
		$this->Cell(14,3.5,'MODIF.','BR',0,'C');						
		$this->Cell(14,3.5,'MODIF.','BR',0,'C');
		$this->Cell(14,3.5,'MODIF.','BR',0,'C');					
		$this->Cell(14,3.5,'MODIF.','BR',0,'C');						
		$this->Cell(14,3.5,'MODIF.','BR',0,'C');		
				
		$this->Cell(17,3.5,'AL: '.date("d-m-Y"),'BR',0,'C');		
		$this->Cell(10,3.5,'MODIF.','BR',1,'C');	
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

	
	
	$pdf->SetVisibles(array(1,1,1,   1,1,1,1,1,1,1,1,1,1,1,1,  1,1));
		
    $pdf->SetFonts(array('Arial','Arial','Arial',     'Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial',   'Arial','Arial'));
	$pdf->SetFontsStyles(array('','','B',     '','','','','','','','','','','','',   'B','B'));	
	$pdf->SetFontsSizes(array(6,6,6,   6,6,6,6,6,6,6,6,6,6,6,6,   6,6));
	$pdf->SetSpaces(array(3,3,3,   3,3,3,3,3,3,3,3,3,3,3,3,  3,3 ));
	$pdf->SetWidths(array(41,17,17, 14,14,14, 14,14,14, 14,14,14,14,14,14,  17,10));
	$pdf->SetDecimales(array(0,2,2,    2,2,2,2,2,2,2,2,2,2,2,2,   2,2));
	$pdf->SetFormatNumber(array(0,1,1,   1,1,1,1,1,1,1,1,1,1,1,1,    1,0));
	$pdf->SetAligns(array('L','R','R',    'R','R','R',  'R','R','R',  'R','R','R','R','R', 'R',      'R','R'));
    $v_eje_pres_partida=$_SESSION['PDF_Resumen'];
    
   
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
    
    $sumaTotE=0;    
    
		for ($j=0;$j<sizeof($v_eje_pres_partida);$j++)
		{			
			$pdf->SetLineWidth(0.02);
			$pdf->Multitabla($v_eje_pres_partida[$j],0,3,3,6,1);
			
			$sumaPreI=$sumaPreI+$v_eje_pres_partida[$j][1];//
			$sumaPreV=$sumaPreV+$v_eje_pres_partida[$j][2];//
			
			$sumaEneE=$sumaEneE+$v_eje_pres_partida[$j][3];//			
			$sumaFebE=$sumaFebE+$v_eje_pres_partida[$j][4];//
			$sumaMarE=$sumaMarE+$v_eje_pres_partida[$j][5];// 
			$sumaAbrE=$sumaAbrE+$v_eje_pres_partida[$j][6];//
			$sumaMayE=$sumaMayE+$v_eje_pres_partida[$j][7];//
			$sumaJunE=$sumaJunE+$v_eje_pres_partida[$j][8];// 
			$sumaJulE=$sumaJulE+$v_eje_pres_partida[$j][9];//	
			$sumaAgoE=$sumaAgoE+$v_eje_pres_partida[$j][10];//
			$sumaSepE=$sumaSepE+$v_eje_pres_partida[$j][11];//			
			$sumaOctE=$sumaOctE+$v_eje_pres_partida[$j][12];//	
			$sumaNovE=$sumaNovE+$v_eje_pres_partida[$j][13];//
			$sumaDicE=$sumaDicE+$v_eje_pres_partida[$j][14];//
						
			$sumaTotE=$sumaTotE+$v_eje_pres_partida[$j][15];//
		}
		
	     $pdf->SetFont('Arial','B',6);
	     $pdf->Cell(41,5,'TOTALES:',1,0,'R');
	     $pdf->Cell(17,5,number_format($sumaPreI,2),1,0,'R');	
	     $pdf->Cell(17,5,number_format($sumaPreV,2),1,0,'R');		         
	     
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
	     	     
	     $pdf->Cell(17,5,number_format($sumaTotE,2),1,0,'R');	//
	     $pdf->Cell(10,5,number_format($sumaTotE*100 / ($sumaPreV + 0.1) ,1).' %',1,0,'R');	//
	     	     
	   	     
	     $pdf->SetDrawColor(0,0,0);
		 $pdf->SetLineWidth(0.2);
	   

$pdf->Output();
?>

