<?php

session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de creacion: 20/05/2013
 * Descripción: Reporte de Verificación Deptos x Usuario
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
   // $this-> AddFont('Arial','','arial.php');
 
    //Iniciación de variables
    }



function Header()
{       
   $this->Image('../../../../lib/images/logo_reporte.jpg',230,2,35,15);
  
    $this->Ln(5);
    $this->SetFont('Arial','B',16);
 	$this->Cell(0,6,'Asignacion de Departamentos a Usuarios ',0,1,'C');
 	$this->SetFont('Arial','B',10);
 
 	$this->SetX(15);
 	$this->Ln(1.5);

 	/*$v_setdetalle=$_SESSION['PDF_verificarDepUsuario'];
 	//$pdf->SetNombresPres($v_setdetalle[$i][0]);
 	$this->SetFillColor(220,220,220);
 	$this->SetFont('Arial','B',9);
 	$this->Cell(30,5,'Departamento:',0,0);
 	$this->SetFont('Arial','',9);
 	$this->Cell(150,5,$v_setdetalle[0][0],0,1,'L',1);
 	$this->Ln(1);
 	$this->SetFont('Arial','B',9);
 	/*$this->Cell(30,5,'Usuario:',0,0);
 	$this->SetFont('Arial','',9);
 	$this->Cell(150,5,$_SESSION["PDF_nombre_usuario"],0,1,'L',1);
 	$this->Ln(1);
   */
 
 
    
//	$this->Cell(7,4,'NOMBRE DEPARTAMENTO','LTR',0,'C');
	/*$this->Cell(60,4,'NOMBRE EMPLEADO','LTR',0,'C');
	$this->Cell(12,4,'ESTADO','TR',0,'C');
	$this->Cell(12,4,'CARGO','TR',1,'C');*/
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


	   $pdf->SetWidths(array(0,140,30,30));
       $pdf->SetAligns(array('L','L','L','L','L'));
       $pdf->SetVisibles(array(0,1,1,1));
       $pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial'));
       $pdf->SetFontsSizes(array(5,5,5,5,5));
       $pdf->SetSpaces(array(3,3,3,3,3));
       $pdf->SetFormatNumber(array(0,0,0,0,0));
        	//en $data llegara toda la información.
       $bandera_depto='';
	  $v_setdetalle=$_SESSION['PDF_verificarDepUsuario'];
       for ($i=0;$i<count($v_setdetalle);$i++){
       	 
       	   if ($i!=0){
       	   	 if ($bandera_depto!=$v_setdetalle[$i][0]){
       	   	 	$bandera_depto=$v_setdetalle[$i][0];
       	   	 	$pdf->SetFillColor(220,220,220);
       	   	 	$pdf->SetFont('Arial','B',9);
       	   	 	$pdf->Ln(1);
       	   	 	$pdf->Cell(30,4,'Departamento:',0,0);
       	   	 	$pdf->SetFont('Arial','',9);
       	   	 	$pdf->Cell(150,4,$bandera_depto,0,1,'L',1);
       	   	 	$pdf->Ln(1);
       	   	 	 
       	   	 	$pdf->SetFont('Arial','B',7);
       	   	 	$pdf->Cell(140,4,'NOMBRE EMPLEADO','LTR',0,'C');
       	   	 	$pdf->Cell(30,4,'ESTADO','TR',0,'C');
       	   	 	$pdf->Cell(30,4,'CARGO','TR',1,'C');
       	   	 
       	   	 	$pdf->MultiTabla($v_setdetalle[$i],1,3,3,5,1);
       	   	 }else {
       	   	 	$pdf->MultiTabla($v_setdetalle[$i],1,3,3,5,1);
       	   	 }
       	   }
       	
          
     
      }
   


$pdf->Output();


?>