<?php

session_start();
/**
 * Autor:  unknow
 * Fecha de creacion: 31072015
 * Descripción: reporte de los movimientos del sistema
 **/

require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{   
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
	    //Llama al constructor de la clase padre
	    $this->FPDF($orientation,$unit,$format);
	     $this-> AddFont('Arial','','arial.php');
	    //Iniciaciï¿½n de variables
    }  
	function Header()
	{
	    $this->Image('../../../../lib/images/logo_reporte.jpg',170,2,35,15);
	    $this->Ln(10);
	    $this->SetX($this->posx);
	}
    
    //Pie de pï¿½gina
    function Footer()
    {
    	//Posicion: a 1,5 cm del final
    	$fecha=date("d-m-Y");
    	$hora=date("H:i:s");
    	$this->SetLeftMargin(10);
    	$this->SetY(-7);
    	$this->SetFont('Arial','',5);
    	$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
    	$this->Cell(50,3,'Pagina '.$this->PageNo().' de {nb}',0,0,'C');
    	$this->Cell(65,3,'',0,0,'L');
    	$this->Cell(18,3,'Fecha: '.$fecha,0,0,'R');
    	$this->ln(3);
    	$this->Cell(100,3,'Sistema: ENDESIS - ALMIN',0,0,'L');
    	$this->Cell(50,3,'',0,0,'C');
    	$this->Cell(35,3,'',0,0,'C');
    	$this->Cell(18,3,'Hora: '.$hora,0,0,'R');
    }
    
}
	
	$pdf=new PDF();
	$pdf->AddPage();
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,7);
	$pdf->SetMargins(35,5,10);
	$pdf->SetFont('Arial','B',8);	
	$inicio = $pdf->GetY();
        
    
    $pdf->SetX(55);
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(120,7,'CLASIFICACION DE ITEMS','',1,'C');
    $pdf->Ln(12);
    
    
    $pdf->SetWidths(array(1,1,1,1,1,1,1,140));
    $pdf->SetFills(array(0,0,0,0,0,0,0));
    $pdf->SetVisibles(array(0,0,0,0,0,0,0,1));
    $pdf->SetFontsSizes(array(5,5,5,5,5,5,5,5));
    $pdf->SetAligns(array('','','','','','','',''));
    $pdf->SetFontsStyles(array('','','','','','','',''));
    $pdf->SetDecimales(array(0,0,0,0,0,0,0,0));
    $pdf->SetSpaces(array(0,0,0,0,0,0,0,3));
    $pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0));
	
    $pdf->SetFont('Arial','B',8);
 	$detalle=$_SESSION['PDF_clasificacion_it'];
 	
 	
 	for($i=0;$i<count($detalle);$i++)
 	{
 		if($detalle[$i][6] == 0)
 		{
 			$pdf->SetFontsSizes(array(5,5,5,5,5,5,5,10));
 			$pdf->MultiTabla($detalle[$i],0,0,5,10);
 		}
 		else 
 		{
 			$pdf->SetFontsSizes(array(5,5,5,5,5,5,5,7));
 			$pdf->MultiTabla($detalle[$i],0,0,5,10);
 		}
	}
	$pdf->Output();		
?>