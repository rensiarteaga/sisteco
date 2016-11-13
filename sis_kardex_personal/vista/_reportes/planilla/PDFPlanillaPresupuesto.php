<?php
session_start();
/**
 * Autor: 
 * Fecha de creacion: 06/04/2011
 * Descripción: Reporte de Presupuestos por planilla
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
   $this->Image('../../../../lib/images/logo_reporte.jpg',240,0,30,10);
   $cabecera=$_SESSION['PDF_cab_rep_planilla'];
   $this->SetFont('Arial','B',7);
	$this->Cell(30,3,'No. Patronal:511-2067',0,1);
	$this->Cell(30,3,'N.I.T.: 1023187029',0,1);
   $this->SetFont('Arial','BU',12);
   $this->Cell(0,5,' DETALLE DE EJECUCION PRESUPUESTARIA '. '',0,1,'C');
   
   $this->Cell(0,5,$cabecera[0]['descripcion'].' - '.$cabecera[0]['numero'].'',0,1,'C');
    $this->SetFont('Arial','B',8);
    $this->Cell(0,5,$cabecera[0]['periodo'].'-'.$cabecera[0]['gestion'],0,1,'C');
   $this->Ln(2);
   
  
  
   
}
 
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
    $fecha=date("d-m-Y");
	$hora=date("H:i:s");
	  $this->SetY(-7);
	  $this->SetFont('Arial','',6);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - KARDEX',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
		$this->ln(3);
	
	
	  
   	  
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
 	$detalle=$_SESSION["PDF_lista_planilla_presupuesto"];

 	
 	
   /*$this->Cell(0,5,''.$_SESSION["PDF_lista_planilla_presupuesto"][0]['desc_presupuesto'].'',0,1,'L');
   $this->Ln(2);
   //Aqui mostrare la cabecera
   $this->SetFont('Arial','B',7);
   $this->Cell(80,3.5,'PARTIDA',1,0,'C');
   $this->Cell(80,3.5,'CONCEPTO',1,0,'C');
   $this->Cell(40,3.5,'IMPORTE',1,1,'C');*/
  
 	
 	
 	
 	$pdf->SetWidths(array(80,80,40));
	$pdf->SetFills(array(0,0,0));
 	$pdf->SetAligns(array('L','L','R'));
 	$pdf->SetVisibles(array(1,1,1));
  	$pdf->SetFontsSizes(array(6,6,6));
 	$pdf->SetFontsStyles(array('','',''));
 	$pdf->SetSpaces(array(3.5,3.5,3.5));
 	$pdf->setDecimales(array(0,0,2));
    $pdf->SetFormatNumber(array(0,0,1));
 	
 	  		$desc_cb='';
 	 		$sum_parc=0;
 	 		$tipo_aporte=''; 
 	 		$ppto_actual='';
 	 		
 	 		$pdf->SetFont('Arial','B',8);
		    $pdf->Cell(0,5,''.$_SESSION["PDF_lista_planilla_presupuesto"][0]['desc_presupuesto'].'',0,1,'L');
		 	$pdf->SetFont('Arial','B',5);
			$pdf->Cell(80,3.5,'PARTIDA',1,0,'C');
    		$pdf->Cell(80,3.5,'CONCEPTO',1,0,'C');
    		$pdf->Cell(40,3.5,'IMPORTE',1,1,'C');
			$ppto_actual=$_SESSION["PDF_lista_planilla_presupuesto"][0]['desc_presupuesto'];
 	 		$inicio=0;
 	 		for ($i=0;$i<count($detalle);$i++){
 	 			
 	 			/*if($detalle[$i]['tipo_aporte']!=$tipo_aporte){
 	 				
                        if ($i!=0){
                     	
 	 				      $pdf->SetFont('Arial','BI',6);
                     	  $pdf->Cell(160,3.5,'TOTAL PARCIAL','RTB',0,'R');
                     	  $pdf->Cell(30,3.5,number_format($sum_parc,2),'TB',1,'R');
                        }
 	 				
 	 				$pdf->SetFont('Arial','BUI',6);
	                $pdf->Ln(2);
 	 				$tipo_aporte=$detalle[$i]['tipo_aporte'];
 	 				$pdf->Cell(80,4,''.$tipo_aporte,0,1);
 	 				
                     $pdf->SetFont('Arial','',6);
	
 	 				$sum_parc=0;
 	 			
 	 			}*/
 	 			
 	 			if($detalle[$i]['desc_presupuesto']!=$ppto_actual){
 	 				
 	 				
 	 				if ($i!=0){
                     	
 	 				      $pdf->SetFont('Arial','BI',6);
                     	  $pdf->Cell(160,3.5,'TOTAL PARCIAL','RTB',0,'R');
                     	  $pdf->Cell(30,3.5,number_format($sum_parc,2),'TB',1,'R');
                     }
 	 				
 	 				$pdf->Ln(5);
 	 				$pdf->SetFont('Arial','B',8);
 	 			    $pdf->Cell(0,5,''.$_SESSION["PDF_lista_planilla_presupuesto"][$i]['desc_presupuesto'].'',0,1,'L');
 	 			 	$pdf->SetFont('Arial','B',5);
   					$pdf->Cell(80,3.5,'PARTIDA',1,0,'C');
				    $pdf->Cell(80,3.5,'CONCEPTO',1,0,'C');
				    $pdf->Cell(40,3.5,'IMPORTE',1,1,'C');
				    
				    $ppto_actual=$_SESSION["PDF_lista_planilla_presupuesto"][$i]['desc_presupuesto'];
				    $sum_parc=0;
				}
 	 			 	 			
 	 			$sum_parc=$sum_parc+$detalle[$i]['valor'];
 	 			$sum_total=$sum_total+$detalle[$i]['valor'];
 	 			$pdf->SetLineWidth(0.05);
 	 			$pdf->MultiTabla($detalle[$i],0,3,3.5,6,1);
 	 			$pdf->SetLineWidth(0.1);
 	 			
 	 			                  
 	 		}
 	 		    $pdf->SetFont('Arial','BI',6);
 	 			$pdf->Cell(160,3.5,'TOTAL PARCIAL','RTB',0,'R');
                $pdf->Cell(30,3.5,number_format($sum_parc,2),'TB',1,'R');
               
                $pdf->Cell(160,3.5,'TOTAL ','RTB',0,'R');
                 $pdf->Cell(30,3.5,number_format($sum_total,2),'TB',1,'R');
 	 		
 	
 
 	
 	
 
$pdf->Output();

?>