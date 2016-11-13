<?php

session_start();
/**
 * Autor:             Ana Maria Villegas Quispe
 * Descripción:       Reporte de Varios Cheques para el Banco de Crédito
 * Fecha de Creación: 29/09/2009
*/
require('../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
class PDF extends FPDF
{   
	function PDF($orientation='L',$unit='mm')
    {
    	//Definimos el tamaño de la hoja en este caso es un caso especial el cheque tiene un tamaño fijo
    	$this->FPDF($orientation,$unit,array(70,152));
    	$this->AddFont('Arial','','arial.php');
    }
    function Header()
{
   
}
//Pie de página
function Footer()
{
   
}



}

$pdf=new PDF();

$pdf->AliasNbPages();


//Iniciación de variables Atributos de la pagina
$pdf->SetLeftMargin(0);
$pdf->SetTopMargin(25);
$pdf->SetAutoPageBreak(true,7);
$id_cuenta_bancaria=$_SESSION['PDF_id_cuenta_bancaria'];
/*echo $id_cuenta_bancaria;
exit;*/
$id_cuenta_bancaria=$_GET['numero'];

$cheques=$_SESSION['PDF_cheques_BC_'.$id_cuenta_bancaria];

for($i=0;$i<count($cheques);$i++)
{
	$pdf->AddPage();
	
	$pdf->SetFont('Arial','',8);
	
	$pdf->SetXY(45,9);	
 		$fecha_completa=$cheques[$i][4];
		$dia=substr($fecha_completa,8,2);
		$mes=substr($fecha_completa,5,2);
		$anio=substr($fecha_completa,0,4);
 	$pdf->Cell(40,5,$_SESSION['ss_nombre_lugar'],0,0);
 	$pdf->Cell(6,5,$dia,0,0);
 	$pdf->Cell(6,5,$mes,0,0);
 	$pdf->Cell(10,5,$anio,0,1);
  	$pdf->SetXY(100,9);
  	$pdf->Cell(50,4,number_format($cheques[$i][2],2),0,1,'R');
  	$pdf->Ln(7);
  	$pdf->Cell(130,12,'                        '.$cheques[$i][1],0,1);
  	$pdf->SetX(0.01);
  	$pdf->SetFont('Arial','',6.5);
  	$pdf->MultiCell(150,5,$cheques[$i][3].'----------');
}
	$pdf->Output();
	 /*session_unset ( );*/
?>