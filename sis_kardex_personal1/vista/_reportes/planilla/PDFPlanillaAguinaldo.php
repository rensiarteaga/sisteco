<?php
session_start();
/**
 * Autor: Mercedes Zambrana Meneses
 * Fecha de creacion: 19/12/2012
 * Descripción: Reporte de Aguinaldos
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
   $this->Image('../../../../lib/images/logo_reporte.jpg',180,0,30,10);//ENDE-0001:04/09/2012: LOGO ENDE CORP.
   $cabecera=$_SESSION['PDF_cab_rep_planilla'];
   $this->SetFont('Arial','B',7);
   $this->Cell(30,3,'No. Patronal:511-2067',0,1);
   $this->Cell(30,3,'N.I.T.: 1023187029',0,1);
   $this->SetFont('Arial','BU',10);
   $this->Cell(0,5,''. $_SESSION['titulo'].'',0,1,'C');
   $this->SetFont('Arial','BU',10);
   $this->Cell(0,5,'CORRESPONDIENTE A LA GESTION:'.$cabecera[0]['gestion'],0,1,'C');
     
   
   
   //$this->Cell(0,5,$cabecera[0]['periodo'].'-'.$cabecera[0]['gestion'],0,1,'C');
   $this->Ln(2);
   //Aqui mostrare la cabecera
    $this->SetFont('Arial','B',6);
    
    if (''.$this->PageNo()!='{nb}'){
     $this->Cell(12,3.5,'CODIGO',1,0,'C');
     $this->Cell(20,3.5,'AP. PATERNO',1,0,'C');
     $this->Cell(20,3.5,'AP. MATERNO',1,0,'C');
     $this->Cell(30,3.5,'NOMBRES',1,0,'C');
  	 $this->Cell(45,3.5,'CARGO',1,0,'C');
     $this->Cell(15,3.5,'DIAS TRAB',1,0,'C');
  	 $this->Cell(15,3.5,'SUELDO SEPT',1,0,'C');
  	 $this->Cell(15,3.5,'SUELDO OCT',1,0,'C');
   	 $this->Cell(15,3.5,'SUELDO NOV',1,0,'C');
  	 $this->Cell(20,3.5,'AGUINALDO Bs',1,1,'C');
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
    $pdf->SetMargins(5,5,5);  
    $pdf->AddPage();
    $pdf->SetFont('Arial','',6);
	


    $detalle=array();
 	$cabecera=$_SESSION['PDF_cab_rep_planilla'];
 	$detalle=$_SESSION["PDF_lista_planilla_aguinaldo"];
   
    $pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3));
 	$pdf->SetWidths(array(12,20,20,30,45,15,15,15,15,20));
 	
	$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0));
 	$pdf->SetAligns(array('L','L','L','L','L','R','R','R','R','R'));
 	$pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1));	
 	
 	
 	
  	$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6));
 	$pdf->SetFontsStyles(array('','','','','','','','','',''));
 	//$pdf->SetSpaces(array(3.5,3.5,3.5,3.5,3.5,3.5));
 	$pdf->setDecimales(array(0,0,0,0,0,0,2,2,2,2));
    $pdf->SetFormatNumber(array(0,0,0,0,0,1,1,1,1,1));
 	
 	  		$desc_cb='';
 	 		$sum_parc=0;
 	 		$nom_lugar=''; 
 	 		$sw_cuenta='0';
 	 		$sum_parc_c_cheq=0;
 	 		$variable=0;
			$var_trinidad='';
 	 		
 	 		for ($i=0;$i<count($detalle);$i++){
 	 			
 	 			
                      
 	 			       $sum_total=$sum_total+$detalle[$i]['total'];
 	 			       $pdf->SetLineWidth(0.05);
                     	//$detalle[$i][3]='';
                     	$pdf->MultiTabla($detalle[$i],0,3,7,1,1);
                     //}
                     
 	 		
 	 			$pdf->SetLineWidth(0.1);
 	 			                  
 	 		}
 	 		$sum_detalle=$_SESSION["PDF_sum_planilla_aguinaldo"];
 	 		 $pdf->SetFont('Arial','BI',8);
 	 		 
 	 		 	 $pdf->Cell(172,3.5,'TOTAL ','RTB',0,'R');
                 $pdf->Cell(30,3.5,number_format($sum_total,2),'TB',1,'R');
 	 		 
           
 
 	
 	
 
$pdf->Output();

?>