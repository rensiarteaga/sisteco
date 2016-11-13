<?php
session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de creacion: 25/05/2012
 * Descripción: Reporte de empleados areas
 *
 *
 ***/
require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
 
class PDF extends FPDF
{   
	function PDF($orientation='L',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    $this-> AddFont('Arial','','arial.php');
 
    //Iniciación de variables
    }



function Header()
{       
   $this->Image('../../../../lib/images/logo_reporte.jpg',240,0,30,10);
   $cabecera=$_SESSION['PDF_cab_rep_planilla_areas'];
   $this->SetFont('Arial','B',7);
	$this->Cell(30,3,'No. Patronal:511-2067',0,1);
	$this->Cell(30,3,'N.I.T.: 1023187029',0,1);
   $this->SetFont('Arial','BU',12);
   $this->Cell(0,5,'DETALLE PERSONAL DE PLANTA EMPRESA NACIONAL DE ELECTRICIDAD E.N.D.E  '.$cabecera[0]['periodo'].'-'.$cabecera[0]['gestion'],0,1,'C');
  
   $this->Ln(2);
   //Aqui mostrare la cabecera
   
    $this->SetFont('Arial','B',6);
   $this->Cell(8,3.5,'Nº GRAL','LTR',0,'C');
   $this->Cell(8,3.5,'Nº ESP','LTR',0,'C');
   $this->Cell(9,3.5,'CODIGO','LTR',0,'C');
   $this->Cell(50,3.5,'APELLIDOS','LTR',0,'C');
   //$this->Cell(14,3.5,'NOMBRES','LTR',0,'C');
   $this->Cell(14,3.5,'C.I.','LTR',0,'C');
   $this->Cell(14,3.5,'EXP','LTR',0,'C');
   $this->Cell(14,3.5,'F. DE NACIM.','LTR',0,'C');
   $this->Cell(40,3.5,'CARGO','LTR',0,'C');		
   
   $this->Cell(10,3.5,'DEP','LTR',0,'C');
   $this->Cell(14,3.5,'GER.','LTR',0,'C');
   $this->Cell(14,3.5,'DISTRITO','LTR',0,'C');
   $this->Cell(14,3.5,'PISO','LTR',0,'C');
   $this->Cell(14,3.5,'OFICINA','LTR',0,'C');
   $this->Cell(14,3.5,'JERARQUIA','LTR',0,'C');
   $this->Cell(14,3.5,'INICIO','LTR',0,'C');
   $this->Cell(14,3.5,'CONCLUSION','LTR',0,'C');
   $this->Cell(14,3.5,'REMUN. MES ','LTR',1,'C');
   
}
 
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
     $this->SetY(-10);
   	$this->pieHash('KARDEX','','L');
     }

}
  	$pdf=new PDF();	
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,10);
    $pdf->SetMargins(5,5,5);  
    
    $pdf->SetFont('Arial','',5);
	
    $pdf->AddPage();


 	$cabecera=$_SESSION['PDF_cab_rep_planilla_areas'];
 	$detalle=$_SESSION['PDF_datos_empleados'];

 	$pdf->SetWidths(array(0,0,8,8,9,50,14,14,14,40,10,14,14,14));
	$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0));
 	$pdf->SetAligns(array('R','R','R','R','R','L','R','R','R','L','R','R','R','R'));
 	$pdf->SetVisibles(array(0,0,1,1,1,1,1,1,1,1,1,1,1,1));
  	$pdf->SetFontsSizes(array(0,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6));
 	$pdf->SetFontsStyles(array('','','','','','','','',''));
 	$pdf->SetSpaces(array(0,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
 	$pdf->setDecimales(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0));
    $pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0));
 	
 	$indice_col=0;
 	$detalle_show=array();
 	$tam=sizeof($detalle);
 	        
 	       
 	for($i=0;$i<$tam;$i++){
	             $detalle[$i][2]=$i+1;     
				 $detalle[$i][3]=$i+1;
	 			 $pdf->MultiTabla($detalle[$i],0,3,3,6,1);
 	 		 	// $pdf->MultiTabla($detalle[$h],0,3,3,6,1);
 	 		}
 	 		 
$pdf->Output();

?>