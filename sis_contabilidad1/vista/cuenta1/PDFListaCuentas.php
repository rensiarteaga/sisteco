<?php

session_start();

require('../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
class PDF extends FPDF
{   
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    //Iniciación de variables
    }
 
function Header()
{
    $this->Image('../../../lib/images/logo_reporte.jpg',170,2,35,15);
    $this->Ln(10);
}
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
 /*   $this->SetY(-25);
    $this->SetFont('Arial','',7);
    $this->SetFillColor(0,0,0);
	$this->Cell(185,0.3,'',1,1,'L',1);
    
    $this->SetX(100);
    $this->Cell(50,3,'Av. Ballivián Nº 0503',0,1);
    $this->SetX(100);
    $this->Cell(50,3,'Edificio Colon 7mo Piso',0,1);
    $this->SetX(100);
    $this->Cell(50,3,'Telefono: 4520317 -4520321',0,1);
    $this->SetX(100);
    $this->Cell(50,3,'Fax: 4520318',0,1);
    $this->Cell(50,3,'Pagina '.$this->PageNo().' de {nb}',0,1,'L');
   */
}


}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf-> AddFont('Tahoma','','tahoma.php');
$pdf-> AddFont('Arial','','arial.php');

$pdf->SetMargins(15,15,15);
$pdf->SetFont('Arial','B',16);
$pdf->Cell(80,10,'Cuentas',0,1,'C'); 
$pdf->SetFont('Arial','B',8);	

//$pdf->SetAligns(array('R'));

$data=$_SESSION['PDF_cuentas'];
$cdata=count($data);
/*print_r($data);
exit;*/
/*for($j=0;$j<$cdata;$j++){
	$tablita[$j][0]=$data[$j][2];
	$tablita[$j][1]=$data[$j][1];
	
}*/
/*print_r($tablita);
exit;*/
/*$data= array();
$data [0][0]=34.2323;
$data [0][1]="asdfsdf";
$data [0][2]="asldfjlsdf";
$data [1][0]=35.32323;
$data [1][1]="dfdfsdf";
$data [1][2]="asldfjlsdf";
*/
//$cdata=count($data);

//$pdf->SetWidths(array(20,20,20));
/*
$pdf->SetFonts(array('Arial','Arial','Arial'));
$pdf->SetFontsSizes(array(12,15,8));
$pdf->SetFontsStyles(array('B','I','U'));
$pdf->SetFills(array(0,1,0));
$pdf->SetFontsColors(array(array(245,1,45),array(165,27,154),array(0,1,0)));*/

/*$pdf->SetVisibles(array(0,1,0,0,0));
$pdf->SetWidths(array(0,150,0,0,0));
*/
$pdf->SetVisibles(array(1,1,0));
$pdf->SetWidths(array(50,130,0));

//$posicion=20;
 for($i=0;$i<$cdata;$i++)
 {
 	//$numero=$j+1;
 	$campo=$data[$i][0];
 	if($data[$i][2]==1)
 	{
 	  $pdf->SetFonts(array('Arial','Arial','Arial'));
 	  $pdf->SetFontsSizes(array(10,10,10));	
 	  $pdf->SetFontsStyles(array('I','I','I'));
 	}else{
 	$pdf->SetFonts(array('Arial','Arial','Arial'));
 	$pdf->SetFontsSizes(array(12,12,12));	
 	$pdf->SetFontsStyles(array('','',''));
 	}
 	$tam=strlen($campo);
 //	$pdf->SetX(20 + ($tam+10));
 	$pdf->SetWidths(array(50+tam,150-$tam,0));
 	//$pdf->SetWidths(array(60,130,0));
    $pdf->MultiTabla($data[$i],0,0);
     //el 
    //    $pdf->t
   // $pdf->tabladatos($data[$j],0,5);
  
 }

$pdf->SetFont('Arial','',8);
$pdf->Ln(5);
$pdf->Ln(5);

$pdf->Output();
?>