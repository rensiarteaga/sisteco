<?php
session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de creacion: 04/09/2013
 * Descripción: Reporte de Estados de Cuentas Efectivos
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

function SetCaja($caja)
{
    $this->caja =$caja;
}
/*
function SetNombreLugar($nombreLugar)
{
    $this->nombreLugar =$nombreLugar;
}*/

function Header()
{       
   $this->Image('../../../../lib/images/logo_reporte.jpg',180,0,30,10);//ENDE-0001:04/09/2012: logo ende corporacion
   //$cabecera=$_SESSION['PDF_cab_rep_planilla'];
   $this->SetFont('Arial','B',10);
	
   $this->Cell(0,3.5,'ESTADOS DE SOLICITUDES EFECTIVO',0,1,'C');
   $this->Cell(10,3,'Caja:',0,0,'C');
   $this->Cell(150,3,$this->caja,0,1,'C');
   $this->SetFont('Arial','B',7);
   $this->Cell(18,3,'Nro.','TLR',0,'C');
   $this->Cell(37,3,'Nro.','TLR',0,'C');
   $this->Cell(50,3,'Empleado','TLR',0,'C');
   $this->Cell(55,3,'Motivo','TLR',0,'C');
   $this->Cell(20,3,'Estado','TLR',0,'C');
   $this->Cell(15,3,'Importe','TLR',0,'C');
   $this->Cell(15,3,'Importe','TLR',1,'C');
   
   $this->Cell(18,3,'Cont','BLR',0,'C');
   $this->Cell(37,3,'Documento','BLR',0,'C');
   $this->Cell(50,3,'','BLR',0,'C');
   $this->Cell(55,3,'','BLR',0,'C');
   $this->Cell(20,3,'','BLR',0,'C');
   $this->Cell(15,3,'Solicitado','BLR',0,'C');
   $this->Cell(15,3,'Rendido','BLR',1,'C');
   /*if($_SESSION["tipo_pago"]=='LIQPAG'){
   	$this->Cell(20,3.5,'LIQ. PAGABLE',1,$salto,'C');
   }else{
   	$this->Cell(20,3.5,'ANTICIPO',1,$salto,'C');
   }
  if($_SESSION["reporte"]=='firma'){
          
   	$this->Cell(40,3.5,'FIRMA',1,1,'C');
	
   }*/

}
 
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
     $this->SetY(-7);
   	$this->pieHash('TESORO');
 	
    
     }

}
  	$pdf=new PDF();	
  //	$pdf->AddPage();
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,7);
     $pdf->SetFont('Arial','',8);

 	$detalle=$_SESSION['PDF_estado_cuenta_efectivo'];
	
	/*print_r($detalle);
	exit;*/
 	$pdf->SetWidths(array(0,0,0,18,37,50,55,20,15,15));
	$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0,0));
 	$pdf->SetAligns(array('L','L','L','L','L','L','L','L','R','R'));
 	$pdf->SetVisibles(array(0,0,0,1,1,1,1,1,1,1,1,1,1));
  	$pdf->SetFontsSizes(array(6.5,6.5,6.5,6.5,6.5,6.5,6.5,6.5,6.5,6.5,6.5,6.5));
 	$pdf->SetFontsStyles(array('','','','','','','','','','','',''));
 	$pdf->SetSpaces(array(2.8,2.8,2.8,2.8,2.8,2.8,2.8,2.8,2.8,2.8));
 	$pdf->setDecimales(array(0,0,0,0,0,0,0,0,0,2,2));
    $pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,1,1));
 	$id_caja=0;
 	/* 		$desc_cb='';
 	 		$sum_parc=0;
 	 		$desc_lugar='';
 	 		$sum_parc_lugar=0;
 	 		$salto='no';
 	 		*/
 	 		for ($i=0;$i<count($detalle);$i++){
 	 			if($detalle[$i][0]!=$id_caja){
 	 				$pdf->SetCaja($detalle[$i][1]);
 	 				$pdf->AddPage();
 	 				$id_caja=$detalle[$i][0];
 	 				
 	 			}
 	 			
 	 			if ($detalle[$i][2]<0){
 	 				$pdf->SetFontsColors(array(array(255,0,0),array(255,0,0),array(255,0,0),array(255,0,0),array(255,0,0),array(255,0,0),array(255,0,0),array(255,0,0),array(255,0,0),array(255,0,0),array(255,0,0),array(255,0,0)));
 	 			}elseif ($detalle[$i][2]==0){
 	 				$pdf->SetFontsColors(array(array(56,40,134),array(56,40,134),array(56,40,134),array(56,40,134),array(56,40,134),array(56,40,134),array(56,40,134),array(56,40,134),array(56,40,134),array(56,40,134),array(56,40,134),array(56,40,134)));
 	 				}else{
					$pdf->SetFontsColors(array(array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0)));
				}
 				$pdf->MultiTabla($detalle[$i],0,3,2.8,6.5,0);
 				 // $pdf->Cell(175,4.5,'TOTAL'.$detalle[$i][2],'RTB',0,'R');
 	 			$pdf->SetLineWidth(0.1);
 	 			             
 	 			     
 	 		}/*
 	 		$pdf->SetFont('Arial','BI',8);
 	 	    $pdf->Cell(175,4.5,'TOTAL','RTB',0,'R');
 	 		$pdf->Cell(20,4.5,number_format($sum_parc,2),'TB',1,'R');
			
 
 	*/
 	
 
$pdf->Output();

?>