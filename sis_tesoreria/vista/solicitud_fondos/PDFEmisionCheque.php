<?php

session_start();

require('../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
class PDF extends FPDF
{   
	function PDF($orientation='L',$unit='mm')
    {
	    //Llama al constructor de la clase padre
	    $this->FPDF($orientation,$unit,array(70,155));
	    //Iniciación de variables
    }
	var $widths;
	var $aligns;
	
	function Header(){ 
	}
	//Pie de página
	function Footer(){ 
	}
}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf-> AddFont('Arial','','arial.php');

//-----------------------Primera Solicitud
$importe=$_SESSION['PDF_importe_avance'];        
$pdf->SetLeftMargin(0);
$pdf->SetAutoPageBreak(true,7);
$pdf->SetFont('Arial','',8);
$pdf->SetXY   (60,10);
$pdf->Cell(50,5,$_SESSION['ss_nombre_lugar'].', '.$_SESSION['PDF_fecha_cheque_literal'],0,1);
$pdf->SetXY(120,12.5);
//$pdf->SetXY(115,12.5);

$pdf->Cell(30,4,number_format($_SESSION['PDF_importe_avance'],2),0,1,'R');

$pdf->Ln(3);
$pdf->SetX(21);
//$pdf->SetX(11);
$pdf->Cell(130,6.5,'           '.$_SESSION['PDF_nombre_cheque'] ,0,1);
$pdf->SetX(21);
//$pdf->SetX(11); 
//$pdf->MultiCell(150,6.8,'              '.$pdf->num2letras(number_format($importe,2,'.', '').'',false,true).'----------',0,'L');
$pdf->SetFont('Arial','',7);
$pdf->MultiCell(140,6,'              '.$_SESSION['PDF_importe_avance_literal'].'----------',0,'L');
$pdf->SetFont('Arial','',8);
 //$pdf->MultiCell(110,6.8,'Seiscientos noventa y cinco millones ochocientos noventa y tres mil cuatrocientos veinti cinco 00/100               ------',0,'L');
$pdf->Output();
?>