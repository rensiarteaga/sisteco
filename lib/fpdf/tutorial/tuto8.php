<?php
define('FPDF_FONTPATH','./');
require('../fpdf.php');

$pdf=new FPDF();
$pdf->AddFont('Tahoma','','tahoma.php');
$pdf->AddPage();
$pdf->SetFont('Tahoma','',35);
$pdf->Cell(0,10,'Enjoy new fonts with FPDF!');
$pdf->Output();
?>
