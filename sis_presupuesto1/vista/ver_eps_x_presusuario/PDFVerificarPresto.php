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
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    }


    function SetNombresPres($nombres_pres)
    {
    	$this->nombres_pres=$nombres_pres;
    }
function Header()
{       
   $this->Image('../../../../lib/images/logo_reporte.jpg',230,2,35,15);
  
    $this->Ln(5);
    $this->SetFont('Arial','B',16);
 	$this->Cell(0,6,'Asignacion de Estructuras Programáticas a Usuarios ',0,1,'C');
 	$this->SetFont('Arial','B',9);
 	
 	$this->SetX(15);
 	$this->Ln(1.5);
 	$v_setdetalle=$_SESSION['PDF_verificarPresUsuario'];
 	//$pdf->SetNombresPres($v_setdetalle[$i][0]);
 	$this->SetFillColor(220,220,220);
 	$this->SetFont('Arial','B',9);
       $this->Cell(30,5,'Presupuesto:',0,0);
       $this->SetFont('Arial','',9);
       $this->Cell(150,5,$v_setdetalle[0][0],0,1,'L',1);
       $this->Ln(1);
       $this->SetFont('Arial','B',9);
       $this->Cell(30,5,'Usuario:',0,0);
       $this->SetFont('Arial','',9);
       $this->Cell(150,5,$_SESSION["PDF_nombre_usuario"],0,1,'L',1);
       $this->Ln(1);
    $this->SetFont('Arial','B',7);
	$this->Cell(100,4,'NOMBRE ESTRUCTURA','LTR',0,'C');
	$this->Cell(30,4,'ASIGNACION','LTR',0,'C');
	$this->Cell(30,4,'ASIGNACION','TR',1,'C');
	$this->Cell(100,4,'','LBR',0,'C');
	$this->Cell(30,4,'ESTRUCTURA','LBR',0,'C');
	$this->Cell(30,4,'EMPLEADO','BR',1,'C');
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
    $v_setdetalle=$_SESSION['PDF_verificarPresUsuario'];
       $pdf->SetLineWidth(.1);
       
       
       $pdf->SetWidths(array(0,0,100,30,30));
       $pdf->SetAligns(array('L','L','L','L','L'));
       $pdf->SetVisibles(array(0,0,1,1,1));
       $pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial'));
       $pdf->SetFontsSizes(array(5,5,5,5,5));
       $pdf->SetSpaces(array(3,3,3,3,3));
       $pdf->SetFormatNumber(array(0,0,0,0,0));
       //$pdf->setDecimales(array(0,0,0));
        	//en $data llegara toda la información.
             
	 
       for ($i=0;$i<count($v_setdetalle);$i++){
       $pdf->MultiTabla($v_setdetalle[$i],1,3,3,5,1);
     
      }
      $pdf->SetFont('Arial','B',4);
     $pdf->Cell(200,2,'Asignación de estructuras que contiene el Presupuesto',0,1);
     $pdf->MultiCell(200,2,'* Para realizar una Solicitud de viáticos, Fondos en Avance y Efectivo del sistema TESORO deberia  estar asignado en por lo menos una Asignación de Usuario',0);
     $pdf->MultiCell(200,2,'* Para realizar una Solicitud de Compra del sistema COMPRO deberia  estar asignado en por lo menos una Asignación de Empleado',0);
$pdf->Output();


?>