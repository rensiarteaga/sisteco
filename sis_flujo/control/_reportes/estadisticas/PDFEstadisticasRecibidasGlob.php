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
	function PDF($orientation='P',$unit='mm',$format='Letter')
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
   $this->Cell(0,5,'ESTADÍSTICAS DE CORRESPONDENCIA RECIBIDA POR UNIDAD',0,1,'C');
   $this->SetFont('Arial','B',8);
   	$this->Cell(0,5,'Desde: '.$_SESSION['PDF_fecha_desde'],0,1,'C');
   	$this->Cell(0,5,'Hasta: '.$_SESSION['PDF_fecha_hasta'],0,1,'C');
   	
  
   $this->Ln(5);
   //Aqui mostrare la cabecera
    $this->SetFont('Arial','B',8);
    
    $this->Cell(106,3.5,'Unidad',1,0,'C');
    $this->Cell(25,3.5,'Total Recibido',1,0,'C');
    $this->Cell(25,3.5,'Sin Recepcionar',1,0,'C');
    $this->Cell(25,3.5,'Recepcionado',1,0,'C');
    $this->Cell(25,3.5,'Archivado',1,0,'C');
    $this->Cell(25,3.5,'Dias/Recepcion',1,0,'C');
    $this->Cell(25,3.5,'Dias/Archivo',1,1,'C');
    
     
  
   
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
 	
 	$total=array();
 	$total[0]='TOTAL';
	for($j=1;$j<7;$j++){
		$total[$j]="0";
	}
   
    	$pdf->SetSpaces(array(3,3,3,3,3,3,3));
 		$pdf->SetWidths(array(106,25,25,25,25,25,25));
 		$pdf->SetFills(array(0,0,0,0,0,0,0));
 	    $pdf->SetAligns(array('L','R','R','R','R','R','R'));
 	    $pdf->SetVisibles(array(1,1,1,1,1,1,1));	
     	$pdf->SetFontsSizes(array(8,8,8,8,8,8,8));
 	    $pdf->SetFontsStyles(array('','','','','','',''));
 	    $pdf->setDecimales(array(0,0,0,0,0,2,2));
        $pdf->SetFormatNumber(array(0,1,1,1,1,1,1));
 	
 	  		
 	 		$sum_total=0;
 	 		for ($i=0;$i<count($detalle);$i++){
 	 			$pdf->MultiTabla($detalle[$i],0,3,3,8,1);
 	 			for($j=1;$j<7;$j++){
 	 				$total[$j]=$total[$j]+$detalle[$i][$j];
 	 			}
 	 			
 	 		}

 	 		if(count($detalle)>0){
 	 			$total[5]=$total[5]/count($detalle);
 	 			$total[6]=$total[6]/count($detalle);
 	 		}
 	 		
 	 	    
 	 	     $pdf->setDecimales(array(0,0,0,0,0,2,2));
 	 		$pdf->SetFontsStyles(array('B','B','B','B','B','B','B'));			
            	$pdf->MultiTabla($total,0,3,7,8,1);	   
      
 	
 	
 
$pdf->Output();

?>