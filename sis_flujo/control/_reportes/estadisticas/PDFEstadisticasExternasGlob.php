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
   $this->Cell(0,5,'ESTADÍSTICAS DE MANEJO DE CORRESPONDENCIA EXTERNA',0,1,'C');
   $this->SetFont('Arial','B',8);
   	$this->Cell(0,5,'Desde: '.$_SESSION['PDF_fecha_desde'],0,1,'C');
   	$this->Cell(0,5,'Hasta: '.$_SESSION['PDF_fecha_hasta'],0,1,'C');
   	
  
   $this->Ln(5);
   //Aqui mostrare la cabecera
    $this->SetFont('Arial','B',8);
    
    $this->Cell(45,3.5,'','TLR',0,'C');
    $this->Cell(15,3.5,'','TLR',0,'C');
    $this->Cell(15,3.5,'','TLR',0,'C');
    $this->Cell(115,3.5,'Notas Respondidas','TLR',0,'C');
    $this->Cell(60,3.5,'Notas No Respondidas','TLR',0,'C');
    $this->Cell(15,3.5,'Indice','TLR',1,'C');
    
    $this->Cell(45,3.5,'Unidad','LR',0,'C');
    $this->Cell(15,3.5,'Total','LR',0,'C');
    $this->Cell(15,3.5,'Total','LR',0,'C');
    $this->Cell(15,3.5,'Total','TLR',0,'C');
    $this->Cell(25,3.5,'Respaldo','BTLR',0,'C');
    $this->Cell(30,3.5,'Plazo','BTLR',0,'C');
    $this->Cell(30,3.5,'Importancia','BTLR',0,'C');
    $this->Cell(15,3.5,'Indice','TLR',0,'C');
    $this->Cell(15,3.5,'Total No','TLR',0,'C');
    $this->Cell(30,3.5,'Importancia','BTLR',0,'C');
    $this->Cell(15,3.5,'Indice','TLR',0,'C');
    $this->Cell(15,3.5,'Retraso','LR',1,'C');
    
    $this->Cell(45,3.5,'Organizacional','LR',0,'C');
    $this->Cell(15,3.5,'Recibidas','LR',0,'C');
    $this->Cell(15,3.5,'Recep','LR',0,'C');
    $this->Cell(15,3.5,'Respondid.','LR',0,'C');
    $this->Cell(12.5,3.5,'Sin','TLR',0,'C');
    $this->Cell(12.5,3.5,'Con','TLR',0,'C');
    $this->Cell(15,3.5,'En','TLR',0,'C');
    $this->Cell(15,3.5,'Fuera De','TLR',0,'C');
    $this->Cell(10,3.5,'Alta','TLR',0,'C');
    $this->Cell(10,3.5,'Media','TLR',0,'C');
    $this->Cell(10,3.5,'Baja','TLR',0,'C');
    $this->Cell(15,3.5,'Retraso','LR',0,'C');
    $this->Cell(15,3.5,'Respondid.','LR',0,'C');
    $this->Cell(10,3.5,'Alta','TLR',0,'C');
    $this->Cell(10,3.5,'Media','TLR',0,'C');
    $this->Cell(10,3.5,'Baja','TLR',0,'C');
    $this->Cell(15,3.5,'Retraso','LR',0,'C');
    $this->Cell(15,3.5,'Total','LR',1,'C');
    
    $this->Cell(45,3.5,'','BLR',0,'C');
    $this->Cell(15,3.5,'','BLR',0,'C');
    $this->Cell(15,3.5,'','BLR',0,'C');
    $this->Cell(15,3.5,'','BLR',0,'C');
    $this->Cell(12.5,3.5,'Resp.','BLR',0,'C');
    $this->Cell(12.5,3.5,'Resp.','BLR',0,'C');
    $this->Cell(15,3.5,'Plazo','BLR',0,'C');
    $this->Cell(15,3.5,'Plazo','BLR',0,'C');
    $this->Cell(10,3.5,'','BLR',0,'C');
    $this->Cell(10,3.5,'','BLR',0,'C');
    $this->Cell(10,3.5,'','BLR',0,'C');
    $this->Cell(15,3.5,'','BLR',0,'C');
    $this->Cell(15,3.5,'','BLR',0,'C');
    $this->Cell(10,3.5,'','BLR',0,'C');
    $this->Cell(10,3.5,'','BLR',0,'C');
    $this->Cell(10,3.5,'','BLR',0,'C');
    $this->Cell(15,3.5,'','BLR',0,'C');
    $this->Cell(15,3.5,'','BLR',1,'C');
    
    
    
   
   
  
   
}
 
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
     $this->SetY(-7);
   	$this->pieHash('FLUJO','','L');
 		  
}

}
  	$pdf=new PDF('L');	
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,7);
    $pdf->SetMargins(5,5,5);  
    $pdf->AddPage();
    $pdf->SetFont('Arial','',6);
	
	$total=array();
	$total[0]='TOTAL';
	for($j=1;$j<19;$j++){
		$total[$j]="0";
	}
	

    $detalle=array();
 	
 	$detalle=$_SESSION['PDF_estadisticas'];
   
    	$pdf->SetSpaces(array(5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5));
 		$pdf->SetWidths(array(45,15,15,15,12.5,12.5,15,15,10,10,10,15,15,10,10,10,15,15,15));
 		$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
 	    $pdf->SetAligns(array('L','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R'));
 	    $pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));	
     	$pdf->SetFontsSizes(array(8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8));
 	    $pdf->SetFontsStyles(array('','','','','','','','','','','','','','','','','',''));
 	    $pdf->setDecimales(array(0,0,0,0,0,0,0,0,0,0,0,2,0,0,0,0,2,2));
        $pdf->SetFormatNumber(array(0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
 	
 	  		
 	 		
 	 		for ($i=0;$i<count($detalle);$i++){
 	 			
 	 			$pdf->MultiTabla($detalle[$i],0,3,5,8,1);
 	 			/*Se suman los totales en un arreglo*/
 	 			for($j=1;$j<19;$j++){
 	 				$total[$j]=$total[$j]+$detalle[$i][$j];
 	 			}
 	 		}
 	 		if(count($detalle)>0){
 	 			$total[11]=$total[11]/count($detalle);
 	 			$total[16]=$total[16]/count($detalle);
 	 			$total[17]=$total[17]/count($detalle);
 	 			 
 	 		}
 	 		
 	 	    $pdf->SetFontsStyles(array('B','B','B','B','B','B','B','B','B','B','B','B','B','B','B','B','B','B'));			
            	$pdf->MultiTabla($total,0,3,7,8,1); 	
 	 				   
      
 	
 	
 
$pdf->Output();

?>