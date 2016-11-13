<?php
session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de creacion: 06/04/2011
 * Descripción: Reporte de Empleados y Bonos
 *
 *
 ***/
require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
 
class PDF extends FPDF
{   
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    $this-> AddFont('Arial','','arial.php');
 
    //Iniciación de variables
    }


function Header()
{       
   $this->Image('../../../../lib/images/logo_reporte.jpg',180,0,30,10);
   $cabecera=$_SESSION['PDF_cab_rep_planilla'];
   $this->SetFont('Arial','B',7);
   $this->Cell(30,3,'No. Patronal:511-2067',0,1);
   $this->Cell(30,3,'N.I.T.: 1023187029',0,1);
   $this->SetFont('Arial','BU',12);
   $this->Cell(0,5,' DETALLE DE '. $_SESSION['titulo'].'',0,1,'C');
   $this->SetFont('Arial','B',8);
   	$this->Cell(0,5,$cabecera[0]['periodo'].'-'.$cabecera[0]['gestion'],0,1,'C');
  
   $this->Ln(2);
   //Aqui mostrare la cabecera
    $this->SetFont('Arial','B',8);
    
    if (''.$this->PageNo()!='{nb}'){
     $this->Cell(15,3.5,'CODIGO',1,0,'C');
     $this->Cell(110,3.5,'NOMBRE FUNCIONARIO',1,0,'C');
     $this->Cell(30,3.5,'VALOR ASIGNADO',1,1,'C');
   
    }
  
   
}
 
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
     $this->SetY(-7);
   	$this->pieHash('KARDEX');
 		  
     }

}
  	$pdf=new PDF();	
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,7);
    $pdf->SetMargins(15,5,5);  
    $pdf->AddPage();
    $pdf->SetFont('Arial','',6);
	


    $detalle=array();
 	$cabecera=$_SESSION['PDF_cab_rep_planilla'];
 	$detalle=$_SESSION["PDF_lista_planilla_empleado_bonos"];
   
    	$pdf->SetSpaces(array(7,7,7));
 		$pdf->SetWidths(array(15,110,30));
 		$pdf->SetFills(array(0,0,0));
 	    $pdf->SetAligns(array('L','L','R'));
 	    $pdf->SetVisibles(array(1,1,1));	
     	$pdf->SetFontsSizes(array(8,8,8));
 	    $pdf->SetFontsStyles(array('','',''));
 	    $pdf->setDecimales(array(0,0,2));
        $pdf->SetFormatNumber(array(0,0,1));
 	
 	  		
 	 		$sum_total=0;
 	 		for ($i=0;$i<count($detalle);$i++){
 	 			 $detalle[$i][1]=substr($detalle[$i]['nombre_completo' ],1);
 	 			 $sum_total=$sum_total+$detalle[$i]['valor'];
 	 			$pdf->MultiTabla($detalle[$i],0,3,7,8,1);
 	 		}
 	 				
            $pdf->Cell(125,7,'TOTAL:',0,0,'R');        
            $pdf->Cell(30,7,number_format($sum_total,2),0,1,'R');         	
 	 				   
      
 	
 	
 
$pdf->Output();

?>