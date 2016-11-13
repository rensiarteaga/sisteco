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
   $this->Image('../../../../lib/images/logo_reporte.jpg',240,0,30,10);
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
    $this->SetFont('Arial','B',7);
     $this->Cell(15,3.5,'CODIGO',1,0,'C');
   $this->Cell(130,3.5,'NOMBRE FUNCIONARIO',1,0,'C');
   $this->Cell(30,3.5,'VALOR ASIGNADO',1,1,'C');
  
  
   
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
 	$detalle=$_SESSION["PDF_lista_planilla_empleado_bonos"];

 	$pdf->SetWidths(array(15,130,30));
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
 	 		$nom_lugar=''; 
 	 		for ($i=0;$i<count($detalle);$i++){
 	 			if($detalle[$i]['nombre_lugar']!=$nom_lugar){
 	 				
                     if ($i!=0){
                     	
 	 				      $pdf->SetFont('Arial','BI',6);
                     	$pdf->Cell(145,3.5,'TOTAL PARCIAL','RTB',0,'R');
                     	$pdf->Cell(30,3.5,number_format($sum_parc,2),'TB',1,'R');
                     }
 	 				
 	 				$pdf->SetFont('Arial','BUI',6);
	                 $pdf->Ln(2);
 	 				$nom_lugar=$detalle[$i]['nombre_lugar'];
 	 				$pdf->Cell(80,4,''.$nom_lugar,0,1);
 	 				
                     $pdf->SetFont('Arial','',6);
	
 	 				$sum_parc=0;
 	 			}
 	 			$sum_parc=$sum_parc+$detalle[$i]['valor'];
 	 			$sum_total=$sum_total+$detalle[$i]['valor'];
 	 			$pdf->SetLineWidth(0.05);
 	 			 $pdf->MultiTabla($detalle[$i],0,3,3.5,6,1);
 	 			$pdf->SetLineWidth(0.1);
 	 			                  
 	 		}
 	 		 $pdf->SetFont('Arial','BI',6);
 	 			$pdf->Cell(145,3.5,'TOTAL PARCIAL','RTB',0,'R');
                $pdf->Cell(30,3.5,number_format($sum_parc,2),'TB',1,'R');
                
                $pdf->Cell(145,3.5,'TOTAL ','RTB',0,'R');
                 $pdf->Cell(30,3.5,number_format($sum_total,2),'TB',1,'R');
 	 		
 	
 
 	
 	
 
$pdf->Output();

?>