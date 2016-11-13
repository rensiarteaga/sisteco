<?php

session_start();

require('../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
class PDF extends FPDF
{   
	function PDF($orientation='L',$unit='mm')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,array(70,152));
    //Iniciación de variables
    }
 var $widths;
 var $aligns;
function Header()
{
    //Logo
 
    //this->Image('../../../lib/images/logo_reporte.jpg',170,2,35,15);
   // $this->Line(15,15,195,15);
   
}
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
/*$fecha=date("d-m-Y");
	$hora=date("h:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - COMPRO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	*/
}


//Cabecera de página

}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf-> AddFont('Arial','','arial.php');

//-----------------------Primera Solicitud

$pdf->SetLeftMargin(0);
$pdf->SetTopMargin(25);
 $pdf->SetAutoPageBreak(true,7);
$pdf->SetFont('Arial','',8);
 $pdf->SetXY(45,9);
 $data=$_SESSION['PDF_cheque'];
 /*
 $pdf->Cell(50,10,$data[0][0],0,1);
 $pdf->Cell(130,10,$data[0][1] ,0,0);
 $pdf->Cell(50,10,number_format($data[0][2],2) ,0,1);
 
 $pdf->Cell(180,10,$data[0][3],0);*/
 $fecha_completa=$_SESSION['PDF_fecha_cheque'];
$dia=substr($fecha_completa,8,2);
$mes=substr($fecha_completa,5,2);
$anio=substr($fecha_completa,0,4);
 $pdf->Cell(40,5,$_SESSION['ss_nombre_lugar'],0,0);
 $pdf->Cell(6,5,$dia,0,0);
 $pdf->Cell(6,5,$mes,0,0);
 $pdf->Cell(10,5,$anio,0,1);
  $pdf->SetXY(100,9);
  $pdf->Cell(50,4,number_format($_SESSION['PDF_importe_avance'],2),0,1,'R');
  $pdf->Ln(7);
  $pdf->Cell(130,12,'                        '.$_SESSION['PDF_nombre_cheque'] ,0,1);
  $pdf->SetX(0.01);
  $pdf->SetFont('Arial','',6.5);
  $pdf->MultiCell(150,5,$_SESSION['PDF_importe_avance_literal'].'----------');
  $pdf->Output();
?>