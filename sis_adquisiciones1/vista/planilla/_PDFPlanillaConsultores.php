<?php

session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de mod: 17/02/2010
 * Descripción: Se añadió la mayoría de los estados al criterio de filtro a partir del componente que recibe una lista de estados.
 *              Se modificó la firma.
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
 $this->SetWidths(array(22,50,18,20,10,20,15,40,20,15,15,15,15));
 $this->SetFills(array(0,0,0,0,0,0,0));
 $this->SetAligns(array('L','L','L','L','R','R','L','L','R','R','R','R','R'));
 $this->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1,1));
 $this->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6,6,6));
 $this->SetFontsStyles(array('','','','','','','','','','','','','','',''));
 $this->SetDecimales(array(0,0,0,0,0,2,0,0,0,1,1,1,2));
 $this->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
 $this->SetFormatNumber(array(0,0,0,0,0,1,0,0,0,1,1,1,1));

 $this->SetFillColor(255,255,255);
 $this->SetDrawColor(0,0,0); 
 
 $this->SetLineWidth(0.2); 
 
 $this->Cell(22,3,'Nº','TRL',0,'C');  
 $this->Cell(50,3,'Consultor ','TRL',0,'C');  
 $this->Cell(18,3,'Orden','TRL',0,'C');  
 $this->Cell(20,3,'Nº','TRL',0,'C');  
 $this->Cell(10,3,'Nº','TRL',0,'C');  
 $this->Cell(20,3,'Importe','TRL',0,'C'); 
 $this->Cell(15,3,'Fecha','TRL',0,'C');  
 $this->Cell(40,3,'Documento','TRL',0,'C');  
 $this->Cell(20,3,'Nº','TRL',0,'C');  
 $this->Cell(15,3,'%','TRL',0,'C');  
 $this->Cell(15,3,'%','TRL',0,'C');  
 $this->Cell(15,3,'Multas','TRL',0,'C'); 
 $this->Cell(15,3,'Liquido','TRL',1,'C'); 
 
 $this->Cell(22,3,'Proceso','BRL',0,'C');  
 $this->Cell(50,3,'','BRL',0,'C');  
 $this->Cell(18,3,'Servicio ','BRL',0,'C');  
 $this->Cell(20,3,'Contrato ','BRL',0,'C');  
 $this->Cell(10,3,'Pago','BRL',0,'C');  
 $this->Cell(20,3,'Pago','BRL',0,'C'); 
 $this->Cell(15,3,'Pago','BRL',0,'C');  
 $this->Cell(40,3,'','BRL',0,'C');  
 $this->Cell(20,3,'Documento','BRL',0,'C');  
 $this->Cell(15,3,'Adelanto','BRL',0,'C');  
 $this->Cell(15,3,'Garantia','BRL',0,'C');  
 $this->Cell(15,3,'','BRL',0,'C'); 
 $this->Cell(15,3,'Pagable','BRL',1,'C'); 
 
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


  
 $pdf->SetWidths(array(22,50,18,20,10,20,15,40,20,15,15,15,15));
 $pdf->SetFills(array(0,0,0,0,0,0,0));
 $pdf->SetAligns(array('L','L','L','L','R','R','C','L','R','R','R','R','R'));
 $pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1,1));
 $pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6,6,6));
 $pdf->SetFontsStyles(array('','','','','','','','','','','','','','',''));
 $pdf->SetDecimales(array(0,0,0,0,0,2,0,0,0,1,1,1,2));
 $pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
 $pdf->SetFormatNumber(array(0,0,0,0,0,1,0,0,0,1,1,1,1));

$v_setdetalle=$_SESSION['PDF_array_consultores'];
$v_setdetalle1= array();
$v_suma_importe_pago=0;
$v_suma_liquido_pagable=0;
for ($j=0;$j<sizeof($v_setdetalle);$j++){
	$v_setdetalle1[$j][0]=$v_setdetalle[$j][3];
	$v_setdetalle1[$j][1]=$v_setdetalle[$j][1];
	$v_setdetalle1[$j][2]=$v_setdetalle[$j][2];
	$v_setdetalle1[$j][3]=$v_setdetalle[$j][8];
	$v_setdetalle1[$j][4]=$v_setdetalle[$j][6];
	$v_setdetalle1[$j][5]=$v_setdetalle[$j][10]; //importe_pago
	$v_setdetalle1[$j][6]=$v_setdetalle[$j][11];
	$v_setdetalle1[$j][7]=$v_setdetalle[$j][15];
	$v_setdetalle1[$j][8]=$v_setdetalle[$j][13];
	$v_setdetalle1[$j][9]=$v_setdetalle[$j][21];//%adelante
	$v_setdetalle1[$j][10]=$v_setdetalle[$j][22];//%garantia
	$v_setdetalle1[$j][11]=$v_setdetalle[$j][23];//%multas
	$adelanto=($v_setdetalle[$j][10]*$v_setdetalle[$j][21])/100;
	$garantia=($v_setdetalle[$j][10]*$v_setdetalle[$j][22])/100;
	//$adelanto=($v_setdetalle[$j][10]*$v_setdetalle[$j][23])/100;
	
	$v_setdetalle1[$j][12]=$v_setdetalle[$j][10]-$adelanto-$garantia-$v_setdetalle[$j][23];
	
	$v_suma_importe_pago=$v_suma_importe_pago+$v_setdetalle[$j][10];
	$v_suma_liquido_pagable=$v_suma_liquido_pagable+$v_setdetalle1[$j][12];

}
 for ($i=0;$i<sizeof($v_setdetalle1);$i++){
 	 $pdf->SetLineWidth(0.05);
 	 $pdf->SetDrawColor(200,200,200);
	   $pdf->MultiTabla($v_setdetalle1[$i],0,3,3,6,1);
   }
   $pdf->SetFont('Arial','B',6);
   $pdf->Cell(120,3,'TOTALES:',1,'R',0);
   $pdf->Cell(20,3,number_format($v_suma_importe_pago,2),1,0,'R');
   $pdf->Cell(120,3,'',1,0,'R');
   $pdf->Cell(15,3,number_format($v_suma_liquido_pagable,2),1,1,'R');
	 $pdf->SetLineWidth(0.2); 
	  $pdf->SetDrawColor(255,255,255);
//////
$pdf->SetFont('Arial','',10); 	   
$y=$pdf->GetY();
$posy1=$y;

	
$altura=$pdf->h;
$margen_inf=$pdf->lMargin;
$tope_inf=$altura-$margen_inf;

if(($tope_inf-$y)<$margen_inf){
	$pdf->SetXY(0,($altura-$y-25));
}else{
	$pdf->SetXY(0,$y);
}
//
$pdf->MultiCell(0,4,"\n\n\n\n____________________________"."\n"."Responsable de Planilla",'','C',0); 

	  
	  
$pdf->Output();


?>