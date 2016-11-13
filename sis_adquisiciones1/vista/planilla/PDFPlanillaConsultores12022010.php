<?php

session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de mod: 04/11/2009
 * Descripción: Se añadió la mayoría de los estados al criterio de filtro a partir del componente que recibe una lista de estados.
 * **/

require('../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{   
	function PDF($orientation='L',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    $this-> AddFont('Arial','','arial.php');
 
    //Iniciación de variables
    }



function Header()
{       
   $this->Image('../../../lib/images/logo_reporte.jpg',230,2,35,15);
  
    $this->Ln(5);
     $this->SetFont('Arial','B',16);
 //$this->SetX(15);
$this->Cell(0,6,'SOLICITUD DE PAGOS POR PLANILLA',0,1,'C');
$this->SetFont('Arial','B',10);
 $this->SetX(15);
 $this->Ln(1.5);


$this->Ln(2);

  $this->Ln(1);
   $this->SetFont('Arial','B',7);
$this->SetWidths(array(22,50,18,20,10,20,15,40,20,20,20,20));
 $this->SetFills(array(0,0,0,0,0,0,0));
 $this->SetAligns(array('L','L','L','L','R','R','L','L','R','R','R','R'));
 $this->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1));
 $this->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6,6,6));
 $this->SetFontsStyles(array('','','','','','',''));
 $this->SetDecimales(array(0,0,0,0,0,1,0,0,0,1,1,1));
 $this->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3));
 $this->SetFormatNumber(array(0,0,0,0,0,1,0,0,0,1,1,1));
 $this->SetFillColor(255,255,255);
 $this->SetDrawColor(0,0,0); 
 
 $this->SetLineWidth(0.2); 
$this->Cell(22,3,'Nº Proceso',1,0,'C');  
 //$this->Cell(12,3,'','TR',0,'C');  
 $this->Cell(50,3,'Consultor ',1,0,'C');  
 $this->Cell(18,3,'Orden Servicio ',1,0,'C');  
 $this->Cell(20,3,'Nº Contrato ',1,0,'C');  
 $this->Cell(10,3,'Nº Pago',1,0,'C');  
 $this->Cell(20,3,'Importe Pago',1,0,'C'); 
  $this->Cell(15,3,'Fecha Pago',1,0,'C');  
 $this->Cell(40,3,'Documento',1,0,'C');  
 $this->Cell(20,3,'Nº Documento',1,0,'C');  
 //$this->Cell(20,3,'Fecha de Factura','RB',0,'C');  
 $this->Cell(20,3,'% Adelanto',1,0,'C');  
 $this->Cell(20,3,'% Garantia',1,0,'C');  
 $this->Cell(20,3,'Multas',1,1,'C'); 
 $this->Ln(0.2);
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
		$this->Cell(100,3,'Sistema: ENDESIS -COMPRO',0,0,'L');
		$this->Cell(70,3,'',0,0,'C');
		$this->Cell(62,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
        
      }


}

	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,7);
    $pdf->SetMargins(1,1,1);
    $pdf->AddPage();


  
 $pdf->SetWidths(array(22,50,18,20,10,20,15,40,20,20,20,20));
 $pdf->SetFills(array(0,0,0,0,0,0,0));
 $pdf->SetAligns(array('L','L','L','L','R','R','L','L','R','R','R','R'));
 $pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1));
 $pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6,6,6));
 $pdf->SetFontsStyles(array('','','','','','',''));
 $pdf->SetDecimales(array(0,0,0,0,0,1,0,0,0,1,1,1));
 $pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3));
 $pdf->SetFormatNumber(array(0,0,0,0,0,1,0,0,0,1,1,1));
//print_r($_SESSION['PDF_array_consultores']);
//exit;
$v_setdetalle=$_SESSION['PDF_array_consultores'];
$v_setdetalle1= array();
for ($j=0;$j<sizeof($v_setdetalle);$j++){
	$v_setdetalle1[$j][0]=$v_setdetalle[$j][3];
	$v_setdetalle1[$j][1]=$v_setdetalle[$j][1];
	$v_setdetalle1[$j][2]=$v_setdetalle[$j][2];
	$v_setdetalle1[$j][3]=$v_setdetalle[$j][8];
	$v_setdetalle1[$j][4]=$v_setdetalle[$j][6];
	$v_setdetalle1[$j][5]=$v_setdetalle[$j][10];
	$v_setdetalle1[$j][6]=$v_setdetalle[$j][11];
	$v_setdetalle1[$j][7]=$v_setdetalle[$j][15];
	$v_setdetalle1[$j][8]=$v_setdetalle[$j][13];
	$v_setdetalle1[$j][9]=$v_setdetalle[$j][21];
	$v_setdetalle1[$j][10]=$v_setdetalle[$j][22];
	$v_setdetalle1[$j][11]=$v_setdetalle[$j][23];
}
 for ($i=0;$i<sizeof($v_setdetalle1);$i++){
 	 $pdf->SetLineWidth(0.05);
 	 $pdf->SetDrawColor(200,200,200);
	   $pdf->MultiTabla($v_setdetalle1[$i],0,3,3,6,1);
   }
	 $pdf->SetLineWidth(0.2); 
	  $pdf->SetDrawColor(255,255,255);
//////
$pdf->SetFont('Arial','',10); 	   
$y=$pdf->GetY();
$posy1=$y;

	$pdf->MultiCell(170,4,"\n\n\n\n____________________________"."\n"."Jefe División \nDe Servicios",'','C',0); 

$altura=$pdf->h;
$margen_inf=$pdf->lMargin;
$tope_inf=$altura-$margen_inf;

//print_r($tope_inf."****".$y);
//exit;
if(($tope_inf-$y)<$margen_inf){
	$pdf->SetXY(95,($altura-$y-25));
}else{
	$pdf->SetXY(95,$y);
}
//
$pdf->MultiCell(170,4,"\n\n\n\n____________________________"."\n"."Jefe Depto. \nDe Bienes y Servicios",'','C',0); 

	  
	  
$pdf->Output();


?>