<?php

session_start();
/**
 * Autor:             Ana Maria Villegas Quispe
 * Descripción:       Reporte de Varios Cheques para el Banco Union
 * Fecha de Creación: 29/09/2009
*/

require('../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
class PDF extends FPDF
{   
	function PDF($orientation='L',$unit='mm')
    {
    //Llama al constructor de la clase padre
    //Definimos el tamaño de la hoja en este caso es un caso especial el cheque tiene un tamaño fijo
    $this->FPDF($orientation,$unit,array(70,150));
    
    }
 	

}

$pdf=new PDF();
$pdf->AliasNbPages();
//Iniciación de variables para la hoja como ser tamaño y tipo de letra  salto de pagina
$pdf->AddFont('Arial','','arial.php');
$pdf->SetTopMargin(25);
$pdf->SetAutoPageBreak(true,7);
$pdf->SetFont('Arial','',8);
 //llega en un array los cheques  y se los desglosa de esta forma.
//$id_cuenta_bancaria=$_SESSION['PDF_id_cuenta_bancaria'];
$id_cuenta_bancaria=$_GET['numero'];

$cheques=$_SESSION['PDF_cheques_BU_'.$id_cuenta_bancaria];
for($i=0;$i<count($cheques);$i++)
{   $pdf->AddPage();
	$pdf->SetXY(40,7.5);
 	$pdf->Cell(50,5,$_SESSION['ss_nombre_lugar'].', '.$cheques[$i][0],0,1);
 	$pdf->SetXY(100,9.5);
 	$pdf->Cell(50,4,number_format($cheques[$i][2],2),0,1,'R');
 	$pdf->Cell(0,5,'',0,1);
 	$pdf->Cell(130,6.5,'           '.$cheques[$i][1],0,1);
 	$pdf->SetX(0.5);
 	$pdf->MultiCell(150,6.8,'              '.$cheques[$i][3].'----------',0,'L');
 	 
}
	$pdf->Output();
	/* session_unset ( );*/
?>