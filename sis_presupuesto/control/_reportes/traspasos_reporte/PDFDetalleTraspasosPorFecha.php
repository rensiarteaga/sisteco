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
		$this->Cell(0,5,'DETALLE DE TRASPASOS PRESUPUESTARIOS POR RANGO DE FECHAS',0,1,'C');
		$this->SetFont('Arial','I',8);
		$this->Cell(0,3,' Presupuesto de '.$_SESSION['PDF_desc_pres_r'].' Gestión '.$_SESSION['PDF_gestion_r'] ,0,1,'C');
		$this->SetFont('Arial','I',7);
		$this->Cell(0,3,'Tipo de Modificación: '.$_SESSION['PDF_desc_tipo_traspaso'],0,1,'C');
		$this->Cell(0,3,'Del: '.$_SESSION['PDF_fecha_ini'].'   Al: '.$_SESSION['PDF_fecha_fin'] ,0,1,'C');
		$this->Cell(0,3,'Filtrado por: '.$_SESSION['PDF_filtro'],0,1,'C');
		$this->Cell(0,3,'(Expresado en '.$_SESSION['PDF_desc_moneda_r'].')',0,1,'C');
	    $this->ln(3);
		
        $this->Image('../../../../lib/images/logo_reporte.jpg',240,5,35,14);
        //$this->SetFont('Arial','BI',8);        
        $this->SetFont('Arial','B',6);

		//Títulos de las columnas
		$this->Cell(8,3.5,'ID','LTR',0,'C');
		$this->Cell(10,3.5,'TIPO','TR',0,'C');
		$this->Cell(50,3.5,'PRESUPUESTO','TR',0,'C');	
		$this->Cell(40,3.5,'PARTIDA','TR',0,'C');	
		$this->Cell(20,3.5,'IMPORTE','TR',0,'C');
		$this->Cell(50,3.5,'PRESUPUESTO','TR',0,'C');	
		$this->Cell(40,3.5,'PARTIDA','TR',0,'C');	
		$this->Cell(30,3.5,'JUSTIFICACIÓN','TR',0,'C');	
		$this->Cell(20,3.5,'FECHA','TR',1,'C');	
		
		$this->Cell(8,3.5,'','LBR',0,'C');
		$this->Cell(10,3.5,'MODIF.','BR',0,'C');
		$this->Cell(50,3.5,'ORIGEN','BR',0,'C');				
		$this->Cell(40,3.5,'ORIGEN','BR',0,'C');
		$this->Cell(20,3.5,'MODIFICACIÓN','BR',0,'C');
		$this->Cell(50,3.5,'DESTINO','BR',0,'C');
		$this->Cell(40,3.5,'DESTINO','BR',0,'C');					
		$this->Cell(30,3.5,'','BR',0,'C');						
		$this->Cell(20,3.5,'CONCLUSIÓN','BR',1,'C');
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
	
	$pdf->SetVisibles(array(1,1,1,1,1,   1,1,1, 1));
		
    $pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial',     'Arial','Arial','Arial','Arial'));
	$pdf->SetFontsStyles(array('','','','','B',     '','','',''));	
	$pdf->SetFontsSizes(array(6,6, 6,6,6,   6,6,6,6));
	$pdf->SetSpaces(array(3,3,3,3,3,   3,3,3,3,3 ));
	$pdf->SetWidths(array(8,10,50,40,20,  50,40,30, 20));
	$pdf->SetDecimales(array(0,0,0,2,2,    2,2,2,2));
	$pdf->SetFormatNumber(array(0,0,0,0,1,   0,0,0,0));
	$pdf->SetAligns(array('C','C','L','L','R',   'L','L','L',  'C'));
    $v_eje_pres_partida=$_SESSION['PDF_Detalle'];
  
    
    $sumaTotTraspaso=0;    
    
		for ($j=0;$j<sizeof($v_eje_pres_partida);$j++)
		{			
			$pdf->SetLineWidth(0.02);
			$pdf->Multitabla($v_eje_pres_partida[$j],0,3,3,6,1);
									
			$sumaTotTraspaso=$sumaTotTraspaso+$v_eje_pres_partida[$j][4];//
		}
		
	     $pdf->SetFont('Arial','B',6);
	     $pdf->Cell(68,5,'',0,0,'R');
	     $pdf->Cell(40,5,'TOTAL:',1,0,'R');	
	     $pdf->Cell(20,5,number_format($sumaTotTraspaso,2),1,1,'R');	
	         
	     $pdf->SetDrawColor(0,0,0);
		 $pdf->SetLineWidth(0.2);

$pdf->Output();
?>

