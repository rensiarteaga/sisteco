<?php
session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de creacion: 13/03/2012
 * Descripción: Reporte de Empleados  con sus respectivos descuentos
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

/*function SetNombreLugar($nombre_lugar)
{
    $this->nombreLugar =$nombre_lugar;
}
function SetTipoContrato($tipo_contrato)
{
    $this->tipoContrato =$tipo_contrato;
}
*/
function Header()
{       
   $this->Image('../../../../lib/images/logo_reporte.jpg',180,0,30,10);
   $cabecera=$_SESSION['PDF_cab_rep_planilla'];
   $this->SetFont('Arial','B',7);
	$this->Cell(30,3,'No. Patronal:511-2067',0,1);
	$this->Cell(30,3,'N.I.T.: 1023187029',0,1);
   $this->SetFont('Arial','BU',12);
   $this->Cell(0,5,'LISTADO DE FUNCIONARIOS DESCUENTOS Y HORAS  ' ,0,1,'C');
    $this->SetFont('Arial','B',8);
   

/*$fecha=date_create ($_SESSION['PDF_ec_fecha_ini']); 
$fecha_ini=date_format( $fecha,'d/m/Y');

$fecha1=date_create ($_SESSION['PDF_ec_fecha_fin']); 
$fecha_fin=date_format( $fecha1,'d/m/Y');*/

   // $this->Cell(0,5,'Hasta el '.$fecha_ini,0,1,'C');
   $this->Ln(2);
   //Aqui mostrare la cabecera
    $this->SetFont('Arial','B',9);
   // $this->nombreLugar.''.$this->tipo_contrato;
    //$this->Cell(5,3.5,'',0,0,'C');
    $this->Cell(25,3.5,''.$this->nombreLugar,0,1,'L');
        $this->SetFont('Arial','BI',9);
         $this->Cell(5,3.5,'',0,0,'C');
         $this->Cell(25,3.5,''.$this->tipoContrato,0,1,'L');
   $this->Cell(15,3.5,'CODIGO',1,0,'C');
   $this->Cell(90,3.5,'NOMBRE FUNCIONARIO',1,0,'C');
   $this->Cell(45,3.5,'DESCUENTO',1,0,'C');
   $this->Cell(45,3.5,'HORAS NT',1,1,'C');
}
 
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
   
  $this->SetY(-9);
   	$this->pieHash('KARDEX');
	
	  	  
     }

}
  	$pdf=new PDF();	
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,7);
    $pdf->SetMargins(10,5,5);  
    
    $pdf->SetFont('Arial','',6);
	
     $pdf->AddPage();

 
 	//$cabecera=$_SESSION['PDF_cab_rep_planilla'];
 	$detalle=$_SESSION["PDF_empleados_descuentos_detalle"];
  
		
		
 	$pdf->SetWidths(array(15,90,45,45));
	$pdf->SetFills(array(0,0,0,0));
 	$pdf->SetAligns(array('L','L','R','R'));
 	$pdf->SetVisibles(array(1,1,1,1));
  	$pdf->SetFontsSizes(array(8,8,8,8));
 	$pdf->SetFontsStyles(array('','','',''));
 	$pdf->SetSpaces(array(5,5,5,5));
 	$pdf->setDecimales(array(0,0,0,0));
    $pdf->SetFormatNumber(array(0,0,0,0));
 	   
 	     /*  print_r($detalle);
 	       exit; */
 	    /*  print_r($tip_cont);
 	       exit;
 	       */
 	 	
 	 		$desc_lugar='';
 	 		$tip_cont='';
 	 		//$sum_parc=0;
 	 			 
 	 		for ($i=0;$i<count($detalle);$i++){
 	 			/*if($detalle[$i]["nombre_lugar"]<>$desc_lugar)
 	 			{   $pdf->SetNombreLugar($detalle[$i]["nombre_lugar"]);
 	 			    $pdf->SetTipoContrato($detalle[$i]["tipo_contrato"]);
 	 			    $pdf->AddPage();
 	 			    
 	 			
 	 				//Enviar a la cabecera para que muestre el nombre del banco
 	 			
 	 			$desc_lugar=$detalle[$i]["nombre_lugar"];
 	 			
 	 			}
 	 		
 	 			if ($i!=0){
 	 			    	if ($tip_cont<>$detalle[$i]["tipo_contrato"]){
 	 			    		$tip_cont=$detalle[$i]["tipo_contrato"];
 	 			    		$pdf->SetTipoContrato($detalle[$i]["tipo_contrato"]);
 	 			    		$pdf->AddPage();

 	 			    		
 	 			    	}
 	 			    }
 	 			    	$tip_cont=$detalle[$i]["tipo_contrato"];
 	 			 
 	 			$detalle[$i][0]=$detalle[$i]['codigo_empleado'];
 	 			$detalle[$i][1]=$detalle[$i]['nombre_completo'];
 	 			$detalle[$i][2]='';
				*/
 	 			$pdf->SetLineWidth(0.05);
 	 			 $pdf->MultiTabla($detalle[$i],0,3,5,8,1);
 	 			$pdf->SetLineWidth(0.1);
 	 			                  
 	 		}
 	 		
 	
 
 	
 	
 
$pdf->Output();

?>