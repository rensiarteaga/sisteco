<?php
session_start();
/**
 * Autor: Jaime Rivera 
 * Fecha de creacion: 15/07/2011
 * Descripción: Reporte de Estadísticas de correspondencia externa
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
   $this->Image('../../../../lib/images/logo_reporte.jpg',230,0,30,10);
   
   $this->SetFont('Arial','B',7);
   $this->Ln(10);
   $this->SetFont('Arial','BU',12);
   $this->Cell(0,5,'DETALLE DE MANEJO DE CORRESPONDENCIA EXTERNA',0,1,'C');
   $this->SetFont('Arial','B',8);
   	$this->Cell(0,5,'Desde: '.$_SESSION['PDF_fecha_desde'],0,1,'C');
   	$this->Cell(0,5,'Hasta: '.$_SESSION['PDF_fecha_hasta'],0,1,'C');
   	   
  
   $this->Ln(5);
   //Aqui mostrare la cabecera
    $this->SetFont('Arial','B',8);
  //  $pdf->SetWidths(array(25,45,35,35,13,23,20,13,13,13,8,30));
    
    $this->Cell(25,3.5,'Número','LTR',0,'C');
    $this->Cell(45,3.5,'Referencia','LTR',0,'C');
    $this->Cell(35,3.5,'Origen','LTR',0,'C');
    $this->Cell(35,3.5,'Responsable','LTR',0,'C');
    $this->Cell(13,3.5,'Prioridad','LTR',0,'C');
    $this->Cell(23,3.5,'Registro','LTR',0,'C');
    $this->Cell(20,3.5,'Estado','LTR',0,'C');
    $this->Cell(13,3.5,'Recep.','LTR',0,'C');
    $this->Cell(13,3.5,'Fecha','LTR',0,'C');
    $this->Cell(13,3.5,'Fecha','LTR',0,'C');
    $this->Cell(8,3.5,'Días','LTR',0,'C');
    $this->Cell(30,3.5,'Respuestas','LTR',1,'C');
    
    $this->Cell(25,3.5,'','LBR',0,'C');
    $this->Cell(45,3.5,'','LBR',0,'C');
    $this->Cell(35,3.5,'','LBR',0,'C');
    $this->Cell(35,3.5,'','LBR',0,'C');
    $this->Cell(13,3.5,'','LBR',0,'C');
    $this->Cell(23,3.5,'','LBR',0,'C');
    $this->Cell(20,3.5,'','LBR',0,'C');
    $this->Cell(13,3.5,'','LBR',0,'C');
    $this->Cell(13,3.5,'Maxima.','LBR',0,'C');
    $this->Cell(13,3.5,'Fin','LBR',0,'C');
    $this->Cell(8,3.5,'Ret.','LBR',0,'C');
    $this->Cell(30,3.5,'','LBR',1,'C');
    
    
   
   
  
   
}
 
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
     $this->SetY(-7);
   	$this->pieHash('FLUJO','','L');
 		  
}

}
 	//var_dump($_SESSION['PDF_estadisticas']);
 
  	$pdf=new PDF('L');	
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,7);
    $pdf->SetMargins(5,5,5);  
    $pdf->AddPage();
    $pdf->SetFont('Arial','',6);
	
	$detalle=array();
 
 	$detalle=$_SESSION['PDF_estadisticas'];
   
    	$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3));
 		$pdf->SetWidths(array(25,45,35,35,13,23,20,13,13,13,8,30));
 		$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
 	    $pdf->SetAligns(array('L','L','L','L','L','L','L','L','L','L','R','L'));
 	    $pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1));	
     	$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6));
 	    $pdf->SetFontsStyles(array('','','','','','','','','','','',''));
 	    $pdf->setDecimales(array(0,0,0,0,0,0,0,0,0,0,0,0));
        $pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0));
 	
 	  		
 	 		$sum_total=0;
 	 		for ($i=0;$i<count($detalle);$i++){
 	 			$pdf->MultiTabla($detalle[$i],0,3,3,6,1);
 	 			
 	 		} 				   
      
 	
 	
 
$pdf->Output();

?>