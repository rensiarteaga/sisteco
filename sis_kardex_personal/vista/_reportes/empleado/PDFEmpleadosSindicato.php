<?php
session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de creacion: 14/03/2013
 * Descripción: Reporte de Empleados Sindicato
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

function SetNombreSindicato($nombre_sindicato)
{
    $this->nombre_sindicato =$nombre_sindicato;
}
   

function Header()
{          
   $this->Image('../../../../lib/images/logo_reporte.jpg',180,0,30,10);
   //$cabecera=$_SESSION['PDF_cab_rep_planilla'];
   $this->SetFont('Arial','B',7);
	$this->Cell(30,3,'No. Patronal:511-2067',0,1);
	$this->Cell(30,3,'N.I.T.: 1023187029',0,1);
   $this->SetFont('Arial','BU',12);
   $this->Cell(0,5,'EMPLEADOS PERTENECIENTES AL SINDICATO '.$this->nombre_sindicato,0,1,'C');
   /* $this->Cell(0,5,''.$this->nombre_afp ,0,1,'C');
   $this->Cell(0,5,'Contribuciones al Sistema Integral de Pensiones' ,0,1,'C');*/
   $this->Cell(0,5,'PERIODO PERTENECIENTE.: AÑO '.$cabecera[0]['gestion'].' MES '.$cabecera[0]['periodo'] ,0,1,'C');
    $this->SetFont('Arial','B',8);
   

   $this->Cell(30,3.5,'Lugar Trabajo',1,0,'C');
   $this->Cell(60,3.5,'Empleado',1,0,'C');
   $this->Cell(30,3.5,'Valor',1,1,'C');
    
}
 
//Pie de página
function Footer()
{
    
	  $this->SetY(-7);
   	$this->pieHash('KARDEX');
	
	  
   	  
}

}
  	$pdf=new PDF();	
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,7);
    $pdf->SetMargins(10,5,5);  
    
    $pdf->SetFont('Arial','',6);
	
    

 
 	//$cabecera=$_SESSION['PDF_cab_rep_planilla'];
 	$detalle=$_SESSION["PDF_detalle_emp_sindicato"];
	$vsindicatos=$_SESSION["PDF_detalle_sindicatos"];
	
 	$pdf->SetWidths(array(30,60,30));
	$pdf->SetFills(array(0,0,0));
 	$pdf->SetAligns(array('L','L','L'));   
 	$pdf->SetVisibles(array(1,1,1));
  	$pdf->SetFontsSizes(array(6,6,6));
 	$pdf->SetFontsStyles(array('','',''));
 	$pdf->SetSpaces(array(4,4,4));
 	$pdf->setDecimales(array(0,0,2));
    $pdf->SetFormatNumber(array(0,0,1));
 	$codigo_sindicato='';
 	//$id_afp=0;
 	
 	
 	for ($i=0;$i<count($detalle);$i++){
 	 	if($detalle[$i]["codigo_sindicato"]<>$codigo_sindicato)
 	 			{    
 	 				if ($i !=0){
 	 			  	 $pdf->SetNombreSindicato($detalle[$i]["nombre_sindicato"]);
 	 				 $pdf->AddPage();
 	 			     $codigo_sindicato=$detalle[$i]["codigo_sindicato"];
 	 			     $num_empleados=0;
 	 			     $total_aporte=0;
 	 			     
 	 			}
 	 			
 	 			$pdf->SetLineWidth(0.05);
 	 			$num_empleados=$num_empleados+1;
				$total_aporte=$total_aporte+$detalle[$i]["valor"];
							
 	 			 $pdf->MultiTabla($detalle[$i],0,3,4,6,1);
 	 			$pdf->SetLineWidth(0.1);
 	 			
 	 			                  
 	 		}
 	 } 	
 	 
 	 
 	

$pdf->Output();

?>
