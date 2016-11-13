<?php

session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de mod: 22/04/2010 2
 * Descripción: Se añadió la mayoría de los estados al criterio de filtro a partir del componente que recibe una lista de estados.
 *              Se modificó la firma.
 *              Se añadio tres campos al reporte impuestos iUE IT y numero.
 * 
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
$this->Cell(0,6,'SOLICITUD DE PAGOS POR PLANILLA '.$_SESSION['periodo'].'/'.$_SESSION['gestion'],0,1,'C');
$this->SetFont('Arial','',10);
$this->Cell(0,4,''.utf8_decode($_SESSION['descripcion']).'',0,1,'C');
$this->SetFont('Arial','B',10);
 $this->SetX(15);
 $this->Ln(1.5);


$this->Ln(2);

 	$this->Ln(1);
 	$this->SetFont('Arial','B',7);
 	$this->SetWidths(array(5,21,35,20,12,6,13,12,25,11,13,13,13,13,13,13,13,26));
 	$this->SetFills(array(0,0,0,0,0,0,0));
 	$this->SetAligns(array('R','L','L','L','L','R','R','C','L','R','R','R','R','R','R','R','L','L'));
 	$this->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
 	$this->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5));
 	$this->SetFontsStyles(array('','','','','','','','','','','','','','','','','',''));
 	$this->SetDecimales(array(0,0,0,0,0,0,2,0,0,0,1,1,1,2,2,2,0,0));
 	$this->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
 	$this->SetFormatNumber(array(0,0,0,0,0,0,1,0,0,0,1,1,1,1,1,1,0,0));
	
 $this->SetFillColor(255,255,255);
 $this->SetDrawColor(0,0,0); 
 
 $this->SetLineWidth(0.2); 
 
 $this->Cell(5,3,'Nº','TRL',0,'C');  
 $this->Cell(21,3,'Nº','TRL',0,'C');  
 $this->Cell(35,3,'Consultor ','TRL',0,'C');  
 $this->Cell(20,3,'Orden','TRL',0,'C');  
 $this->Cell(12,3,'Nº','TRL',0,'C');  
 $this->Cell(6,3,'Nº','TRL',0,'C');  
 $this->Cell(13,3,'Importe','TRL',0,'C'); 
 $this->Cell(12,3,'Fecha','TRL',0,'C');  
 $this->Cell(25,3,'Documento','TRL',0,'C');  
 $this->Cell(11,3,'Nº','TRL',0,'C');  
 $this->Cell(13,3,'%','TRL',0,'C');  
 $this->Cell(13,3,'%','TRL',0,'C');  
 $this->Cell(13,3,'Descuen','TRL',0,'C'); 
 $this->Cell(13,3,'Importe','TRL',0,'C'); 
 $this->Cell(13,3,'Importe','TRL',0,'C'); 
 $this->Cell(13,3,'Liquido','TRL',0,'C');
 $this->Cell(13,3,'Cuenta','TRL',0,'C'); 
 $this->Cell(26,3,'Observaciones','TRL',1,'C'); 
 
 $this->Cell(5,3,'','BRL',0,'C');  
 $this->Cell(21,3,'Proceso','BRL',0,'C');  
 $this->Cell(35,3,'','BRL',0,'C');  
 $this->Cell(20,3,'Servicio ','BRL',0,'C');  
 $this->Cell(12,3,'Contrato ','BRL',0,'C');  
 $this->Cell(6,3,'Pago','BRL',0,'C');  
 $this->Cell(13,3,'Pago','BRL',0,'C'); 
 $this->Cell(12,3,'Pago','BRL',0,'C');  
 $this->Cell(25,3,'','BRL',0,'C');  
 $this->Cell(11,3,'Doc.','BRL',0,'C');  
 $this->Cell(13,3,'Adelanto','BRL',0,'C');  
 $this->Cell(13,3,'Garantia','BRL',0,'C');  
 $this->Cell(13,3,'tos','BRL',0,'C'); 
 $this->Cell(13,3,'IUE','BRL',0,'C'); 
 $this->Cell(13,3,'IT','BRL',0,'C'); 
 $this->Cell(13,3,'Pagable','BRL',0,'C'); 
 $this->Cell(13,3,'Bancaria','BRL',0,'C'); 
 $this->Cell(26,3,'','BRL',1,'C');  
 


 $this->Ln(0.4);
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
    $pdf->SetMargins(1,1,0);
    $pdf->AddPage();
    $pdf->SetWidths(array(5,21,35,20,12,6,13,12,25,11,13,13,13,13,13,13,13,26));
 	$pdf->SetFills(array(0,0,0,0,0,0,0));
 	$pdf->SetAligns(array('R','L','L','L','L','R','R','C','L','R','R','R','R','R','R','R','L','L'));
 	$pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
 	$pdf->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5));
 	$pdf->SetFontsStyles(array('','','','','','','','','','','','','','','','','',''));
 	$pdf->SetDecimales(array(0,0,0,0,0,0,2,0,0,0,1,1,1,2,2,2,0,0));
 	$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
 	$pdf->SetFormatNumber(array(0,0,0,0,0,0,1,0,0,0,1,1,1,1,1,1,0,0));
	$v_setdetalle=array();
	$v_setdetalle=$_SESSION['PDF_array_consultores'];
	$v_setdetalle1= array();
	$v_suma_importe_pago=0;
	$v_suma_liquido_pagable=0;
	$indice=0;
for ($j=0;$j<sizeof($v_setdetalle);$j++){
	$v_setdetalle1[$j][0]=$indice + 1;
	$v_setdetalle1[$j][1]=$v_setdetalle[$j][3];
	$v_setdetalle1[$j][2]=$v_setdetalle[$j][1];
	$v_setdetalle1[$j][3]=$v_setdetalle[$j][2];
	$v_setdetalle1[$j][4]=$v_setdetalle[$j][8];
	$v_setdetalle1[$j][5]=$v_setdetalle[$j][6];
	$v_setdetalle1[$j][6]=$v_setdetalle[$j][10]; //importe_pago
	$v_setdetalle1[$j][7]=$v_setdetalle[$j][11];
	$v_setdetalle1[$j][8]=$v_setdetalle[$j][15];
	$v_setdetalle1[$j][9]=$v_setdetalle[$j][13];
	$v_setdetalle1[$j][10]=$v_setdetalle[$j][21];//%adelante
	$v_setdetalle1[$j][11]=$v_setdetalle[$j][22];//%garantia
	$v_setdetalle1[$j][12]=$v_setdetalle[$j][23];//%multas
	$adelanto=($v_setdetalle[$j][10]*$v_setdetalle[$j][21])/100;
	$garantia=($v_setdetalle[$j][10]*$v_setdetalle[$j][22])/100;
	//$adelanto=($v_setdetalle[$j][10]*$v_setdetalle[$j][23])/100;
	
	$v_setdetalle1[$j][13]=$v_setdetalle[$j]['importe_iue'];//%multas
	$v_setdetalle1[$j][14]=$v_setdetalle[$j]['importe_it'];//%multas
	$v_setdetalle1[$j][15]=$v_setdetalle[$j][10]-$adelanto-$garantia-$v_setdetalle[$j][23]-$v_setdetalle[$j]['importe_iue']-$v_setdetalle[$j]['importe_it'];
	$v_setdetalle1[$j][16]=$v_setdetalle[$j]['cuenta_bancaria'];//%multas
	$v_setdetalle1[$j][17]=$v_setdetalle[$j]['obs_descuentos'];//%multas
	//$v_setdetalle1[$j][13]='sdfasjdf';//%multas
	$v_suma_importe_pago=$v_suma_importe_pago+$v_setdetalle[$j][10];
	$v_suma_liquido_pagable=$v_suma_liquido_pagable+$v_setdetalle1[$j][15];
	$indice=$indice + 1;

}
 for ($i=0;$i<sizeof($v_setdetalle1);$i++){
 	 $pdf->SetLineWidth(0.05);
 	 $pdf->SetDrawColor(200,200,200);
	   $pdf->MultiTabla($v_setdetalle1[$i],0,3,3,5,1);
   }
   $pdf->SetFont('Arial','B',5);
   // $pdf->SetWidths(array(20,50,20,13,10,20,14,40,15,15,15,15,15,15));
   $pdf->Cell(99,3,'TOTALES:',0,'R',0);
   $pdf->Cell(13,3,number_format($v_suma_importe_pago,2),1,0,'R');
   $pdf->Cell(113,3,'',0,0,'R');
   $pdf->Cell(13,3,number_format($v_suma_liquido_pagable,2),1,1,'R');
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