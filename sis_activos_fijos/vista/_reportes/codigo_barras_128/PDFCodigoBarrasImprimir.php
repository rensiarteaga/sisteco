<?php

session_start();
/**
 * Autor: Silvia Ximena Ortiz Fernández
 * Fecha de creacion: 07/02/2011
 * Descripción: Reporte de codigo_barras_imprimir
**/

require('../../../../lib/fpdf/fpdf.php');
require('Code128.php');
require('../../../../lib/funciones.inc.php');

include_once("../../../../lib/configuracion.log.php");
include_once("../../../control/LibModeloActivoFijo.php");

define('FPDF_FONTPATH','font/');
 
class PDF extends FPDF
{   

}
			$pdf=new PDF_Code128('L','cm',array(2.85,4.5));
			
			$pdf->SetAutoPageBreak(0.2);//para habilitar salto automatico de hoja 1 habiltado, el margen de abajo 
			$pdf->SetTopMargin(0,2);//margen superior
			$pdf->SetRightMargin(0,1);//margen derecho
			$pdf->SetLeftMargin(0.1);//margen izquierdo
			
			$v_setdetalle=$_SESSION['PDF_codigo'];
			$v_setdetalle1=$_SESSION['PDF_descripcion'];
			
			//echo 'código:'. $_SESSION['PDF_codigo']; exit;
			
			$code='Code 128';

			$pdf->AddPage('L','cm',array(2.85,4.5));

			$pdf->SetFont('Arial','B',9);
			
			//RCM 14/10/2011: se comenta para que no imprimia ENDE para codigo de barras de coserelec
			//$pdf->Cell(0.5,0.6,'ENDE',0,1);
			$pdf->Cell(0.5,0.6,'',0,1);
			//FIN RCM
			
			$pdf->Code128(0.7,0.6,$v_setdetalle,3.5,1);

			$pdf->SetXY(1.5,1.8);
			$pdf->SetFont('Arial','B',9);
			$pdf->Write(0,$v_setdetalle);

			$pdf->SetXY(0.1,2);
			$pdf->SetFont('Arial','',6);
			$pdf->Write($pdf->GetStringWidth(30),$v_setdetalle1);
			$pdf->Ln(1);
		
			$pdf->Output();	
?>