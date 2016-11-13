<?php

session_start();
/**
 * Autor: Silvia Ximena Ortiz Fernández
 * Fecha de creacion: 02/02/2011
 * Descripción: Reporte de codigo_barras_128
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
	$v_setdetalle=$_SESSION['PDF_codigo'];
	
			$pdf=new PDF_Code128('P','cm',array(3.8,2.7));
			$pdf->SetAutoPageBreak(0.1);//para habilitar salto automatico de hoja 1 habiltado, el margen de abajo 
			$pdf->SetTopMargin(0,1);//margen superior
			$pdf->SetRightMargin(0,1);//margen derecho
			$pdf->SetLeftMargin(0.1);//margen izquierdo
			//B set
			$code='Code 128';
			$pdf->AddPage('P','cm',array(3.8,2.7));//añade la primera pagina
			$pdf->SetFont('Arial','',4);
			$pdf->Code128(0.4,0.3,$v_setdetalle,3,1);
			$pdf->SetXY(1.5,0.1);
			$pdf->Write(2.6,$v_setdetalle);
			$pdf->Output();
			
?>