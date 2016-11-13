<?php
session_start();
/**
 * 
 * Descripción: Reporte de Empleados y Cuentas Bancarias 
 *
 *
 ***/
require('../../../lib/fpdf/fpdf.php');
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
   $this->Image('../../../lib/images/logo_reporte.jpg',180,0,30,10);//ENDE-0001:04/09/2012: logo ende corporacion
   $cabecera=$_SESSION['PDF_cab_rep_planilla_cons'];
   $this->SetFont('Arial','B',8);
   $this->Cell(30,3,'No. Patronal:511-2067',0,1);
   $this->Cell(30,3,'N.I.T.: 1023187029',0,1);
   $this->SetFont('Arial','BU',12);
   $this->Cell(0,5,'ABONOS A CUENTA ',0,1,'C');
   $this->SetFont('Arial','B',10);
    
    $detalle= $_SESSION["PDF_desc_planilla_cons"];
  
   
 
    
  $this->Cell(0,5,$detalle,0,1,'C');
  $this->Cell(0,5,$_SESSION["PDF_periodo_planilla_cons"].'-'.$_SESSION["PDF_gestion_planilla_cons"],0,1,'C');
   $this->Ln(2);
   //Aqui mostrare la cabecera
    $this->SetFont('Arial','B',7);
      $this->Cell(15,3.5,''.$this->nombreLugar,0,1);
      
     $this->Cell(20,3.5,'CODIGO',1,0,'C');
	 $x=120;
	 $salto=1;
	 
   $this->Cell($x,3.5,'NOMBRE FUNCIONARIO',1,0,'C');
   $this->Cell(30,3.5,'Nº DE CUENTA',1,0,'C');
  	
  $this->Cell(30,3.5,'LIQ. PAGABLE',1,$salto,'C');
   	   
  if($_SESSION["reporte"]=='firma'){
          
   	$this->Cell(40,3.5,'FIRMA',1,1,'C');
	
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
  	$pdf->AddPage();
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,7);
 
    $pdf->SetFont('Arial','',8);
	
   	$detalle=$_SESSION['PDF_cab_rep_planilla_cons'];
	$tamano_monto=30;
 	
 	 	
 	$pdf->SetWidths(array(20,120,30,$tamano_monto,0));
	$pdf->SetFills(array(0,0,0,0));
 	$pdf->SetAligns(array('L','L','R','R'));
 	$pdf->SetVisibles(array(1,1,1,1,0));
  	$pdf->SetFontsSizes(array(8,8,8,8,8));
 	$pdf->SetFontsStyles(array('','','',''));
 	$pdf->SetSpaces(array(4.5,4.5,4.5,4.5,4.5));
 	$pdf->setDecimales(array(0,0,0,2,0));
    $pdf->SetFormatNumber(array(0,0,0,1,0));
 	
 	 		$desc_cb='';
 	 		$sum_parc=0;
 	 		$desc_lugar='';
 	 		$sum_parc_lugar=0;
 	 		$salto='no';
 	 		//	 $pdf->SetCuentaBancaria($detalle[0]["nombre_banco"]);
 	 		for ($i=0;$i<count($detalle);$i++){
 	 			
				
 	 			
 	 				$desc_cb=$detalle[$i]["nombre_banco"];
 	 				
 	 				
 	 			
 	 			
 	 			//$pdf->SetCuentaBancaria($detalle[$i]["nombre_banco"]);
 	 				
 	 			$sum_parc=$sum_parc+$detalle[$i]['valor'];
 	 			$sum_parc_lugar=$sum_parc_lugar+$detalle[$i]['valor'];
 	 			$pdf->SetLineWidth(0.05);
				
				$firma='';
			
 	 			$pdf->MultiTabla($detalle[$i],0,3,4.5,8,1);
 	 			$pdf->SetLineWidth(0.1);
 	 			             
 	 			     
 	 		}
 	 		$pdf->SetFont('Arial','BI',8);
 	 		
 	 		 $pdf->Cell(170,4.5,'TOTAL','RTB',0,'R');
 	 		
 	 		$pdf->Cell($tamano_monto,4.5,number_format($sum_parc,2),'TB',1,'R');
			
			
 
 	
 	
 
$pdf->Output();

?>