<?php

session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de creacion: 20/05/2013
 * Descripción: Reporte de Verificación Presupuestaria
 * Fecha de modificacion: 27/07/2010
 * **/

require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
 
class PDF extends FPDF
{   
	function PDF($orientation='L',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
   // $this-> AddFont('Arial','','arial.php');
 
    //Iniciación de variables
    }



function Header()
{       
   $this->Image('../../../../lib/images/logo_reporte.jpg',230,2,35,15);
  
    $this->Ln(5);
    $this->SetFont('Arial','B',16);
 	$this->Cell(0,6,'Asignacion de Estructuras Programáticas a Usuarios ',0,1,'C');
 	$this->SetFont('Arial','B',10);
 	$this->SetFont('Arial','B',10);
 	$this->SetX(15);
 	$this->Ln(1.5);

 
  $this->SetWidths(array(0,7,60,12,25,13,21,40,40,10,15,15,15));
   $this->SetAligns(array('R','L','L','L','L','L','L','L','L','R','R','R','R'));
       $this->SetVisibles(array(0,1,1,1,1,1,1,1,1,1,1,1,1));
       $this->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
       $this->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5,5,5,5));
       $this->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3));
       $this->setDecimales(array(0,0,0,0,0,0,0,0,0,0,2,2,2));
       $this->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,1,1,1,1));
     
 
 
    $this->SetFont('Arial','B',7);
	$this->Cell(7,4,'NOMBRE ESTRUCTURA','LTR',0,'C');
	$this->Cell(60,4,'ASIGNACION ESTRUCTURA','LTR',0,'C');
	$this->Cell(12,4,'ASIGNACION EMPLEADO','TR',1,'C');
	}
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
    $fecha=date("d-m-Y");
	$hora=date("H:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
   	    $this->Cell(100,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(70,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(62,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(100,3,'Sistema: ENDESIS - PRESTO',0,0,'L');
		$this->Cell(70,3,'',0,0,'C');
		$this->Cell(62,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
        
      }


}

	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,7);
    $pdf->SetMargins(5,5,5);
    $pdf->AddPage();

       $pdf->SetLineWidth(.1);


	   $pdf->SetWidths(array(100,100,100));
       $pdf->SetAligns(array('L','L','L'));
       $pdf->SetVisibles(array(1,1,1));
       $pdf->SetFonts(array('Arial','Arial','Arial'));
       $pdf->SetFontsSizes(array(5,5,5));
       $pdf->SetSpaces(array(3,3,3));
       $pdf->setDecimales(array(0,0,0));
        	//en $data llegara toda la información.
         
	  $v_setdetalle=$_SESSION['PDF_verificarPresUsuario']; 
       for ($i=0;$i<count($v_setdetalle);$i++){
       $pdf->MultiTabla($v_setdetalle[$i],1,3,3,5,1);
     
      }
   


$pdf->Output();


?>