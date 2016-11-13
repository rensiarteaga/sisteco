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
 function SetPosX($a)
{
    //Tableau des alignements de colonnes
    $this->posx=$a;
   
}
function Header()
{
    $this->Image('../../../lib/images/logo_reporte.jpg',170,2,35,15);
    $this->Ln(10);
    $this->SetX($this->posx);
}
//Pie de página
function Footer()
{
	$fecha=date("d-m-Y");
	$hora=date("h:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - SCI',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
}


}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,7);
$pdf-> AddFont('Arial','','arial.php');

//$pdf->SetMargins(15,15,15);
$pdf->SetFont('Arial','B',16);
$pdf->Cell(210,10,'PLAN DE CUENTAS',0,1,'C'); 
$pdf->SetFont('Arial','B',12);
$pdf->Cell(210,5,'Gestion:'.$_SESSION["PDF_gestion"],0,1,'C'); 
$pdf->SetFont('Arial','B',8);	

//$pdf->SetAligns(array('R'));

$data=$_SESSION['PDF_cuentas'];
$cdata=count($data);

$pdf->SetVisibles(array(0,1,1,0,0,0));
$pdf->SetWidths(array(0,40,170,0,0,0));


//$posicion=20;
 for($i=0;$i<$cdata;$i++)
 {
 	$campo=$data[$i][1];
 	if($data[$i][3]==1)
 	{
 	  $pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial'));
 	  $pdf->SetFontsSizes(array(8,8,8,8,8,8));	
 	  $pdf->SetFontsStyles(array('I','I','I','I','I','I'));
 	  $pdf->SetSpaces(array(4,4,4,4,4,4));
 	}else{
 	$pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial'));
 	$pdf->SetFontsSizes(array(10,10,10,10,10,10));	
 	$pdf->SetFontsStyles(array('','','','','',''));
 	$pdf->SetSpaces(array(5,5,5,5,5,5));
 	}
 	
 	$tam=strlen($campo)*1.95;
 	//$pdf->Cell(30,5,$tam,0,1);
 	$pdf->SetX(($tam+20));
 	$pdf->SetPosX($pdf->GetX());
 	$pdf->SetWidths(array(0,$tam,170-$tam,0,0));
 	//$pdf->SetWidths(array(20,160-$tam,0,0));
 //	$tam1=$tam;
 
    $pdf->MultiTabla($data[$i],0,0,5,10);
    
    //aqui se muestra a los auxiliares
      $pdf->SetVisibles(array(0,1,1,0,0));
      //$pdf->SetWidths(array(0,20,150,0,0));
      $pdf->SetFonts(array('Arial','Arial','Arial','Arial'));
 	  $pdf->SetFontsSizes(array(6,6,6,6));	
 	  $pdf->SetFontsStyles(array('I','I','I','I'));
 	  $pdf->SetAligns(array('L','R','L','L'));
 	  $pdf->SetSpaces(array(3,3,3,3));
 	  $pdf->SetFormatNumber(array(1,0,0,0));
 	  $cuenta_auxiliar=$_SESSION['PDF_auxiliar_'.$i];
 	  $size_auxiliar=count($cuenta_auxiliar);
 	  if($size_auxiliar!=0){
 	   for($j=0;$j<$size_auxiliar;$j++){
 	    $pdf->SetX(($tam+30));
 	    $pdf->SetPosX($pdf->GetX());
 	    $pdf->SetWidths(array(0,($tam/1.8)*1.2,170-$tam,0));
 	    $pdf->MultiTabla($cuenta_auxiliar[$j],0,0,4,6,1);
       }
    }
    
  
 }

$pdf->SetFont('Arial','',8);
$pdf->Ln(5);
$pdf->Ln(5);
$pdf->SetLeftMargin(15);
$pdf->Output();
?>