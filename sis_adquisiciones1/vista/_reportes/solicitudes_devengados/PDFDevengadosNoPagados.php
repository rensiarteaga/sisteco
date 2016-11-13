<?php
session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de mod: 13/01/2012
 * Descripción: Se añadió la mayoría de los estados al criterio de filtro a partir del componente que recibe una lista de estados.
 * **/
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

function Header()
{    
    $this->Image('../../../../lib/images/logo_reporte.jpg',170,0,35,15);
    $this->Ln(5);
     $this->SetFont('Arial','B',16);
 $this->Cell(213,6,'LISTA DE DEVENGADOS DE '.$_SESSION['PDF_titulo'].'',0,1,'C');
$this->SetFont('Arial','B',10);
 $this->SetX(15);
//$this->Cell(150,5,'Expresado en Bs',0,1,'C');
    $this->Ln(1.5);
//CABECERA
/** Codigo de Proceso
    * Proveedor
    * Nº contrato
    * Nº Orden de Compra
    * fecha solicitud de devengado
    * Descripción de compra*/
         
 


$this->SetFont('Arial','B',7); 
$this->Cell(20,3,'Fecha Inicio',0,0,'C'); 
$this->Cell(20,3,''.$_SESSION['PDF_fecha_inicio'],0,0,'C'); 
$this->Cell(20,3,'Fecha Fin',0,0,'C'); 
$this->Cell(20,3,$_SESSION['PDF_fecha_fin'],0,1,'C'); 
/*$this->Cell(20,3,'Nº Orden Compra',0,0,'C'); 
$this->Cell(20,3,'Fecha Devengado',0,0,'C'); 
$this->Cell(20,3,'Descripción de Compra',0,1,'C'); */
/*
$this->SetFont('Arial','',7);
$this->Cell(20,3,$_SESSION['PDF_gestion'],0,0,'C'); 
$this->Cell(20,3,$_SESSION['PDF_fecha_inicio'],0,0,'C'); 
$this->Cell(20,3,$_SESSION['PDF_fecha_fin'],0,0,'C'); 
$this->MultiCell(150,3,$_SESSION['PDF_estado'],0,'C'); 


$this->Ln(2);

  $this->Ln(1);
   $this->SetFont('Arial','B',7);
 $this->SetWidths(array(9,12,78,35,40,30,10));
 $this->SetFills(array(0,0,0,0,0,0,0));
 $this->SetAligns(array('R','L','L','L','L','L','R'));
 $this->SetVisibles(array(1,1,1,1,1,1,1));
 $this->SetFontsSizes(array(6,6,6,6,6,6,6));
 $this->SetFontsStyles(array('','','','','','',''));
 $this->SetDecimales(array(0,0,0,0,0,0,0));
 $this->SetSpaces(array(3,3,3,3,3,3,3));
 $this->SetFillColor(255,255,255);
 $this->SetDrawColor(0,0,0); 
 */
 

 $this->SetLineWidth(0.2); 
$this->Cell(25,3,'Código','LTR',0,'C');  
 $this->Cell(60,3,'Proveedor','TR',0,'C');  
 $this->Cell(25,3,'Nº','TR',0,'C');  
 $this->Cell(25,3,'Nº','TR',0,'C');  
 $this->Cell(15,3,'Fecha ','TR',0,'C');  
 $this->Cell(60,3,'Descripción','TR',1,'C');  
 
 
  $this->Cell(25,3,'Proceso','LRB',0,'C');  
 $this->Cell(60,3,'','RB',0,'C');  
 $this->Cell(25,3,'Contrato','RB',0,'C');  
 $this->Cell(25,3,'Orden Compra','RB',0,'C');  
 $this->Cell(15,3,'Devengado','RB',0,'C');  
 $this->Cell(60,3,'de Compra','RB',1,'C');  
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
   	   // $this->Cell(200,0.2,'',1,1);
		/*$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - COMPRO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');
        */
		$this->SetY(-10);
   	    $this->pieHash('COMPRO',gregoriantojd(date('m'),date('d'),date('Y')).$hora);
 	
      }


}

	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,7);
    $pdf->SetMargins(1,1,1);
    $pdf->AddPage();
    
 $pdf->SetWidths(array(0,25,60,25,25,15,60));
 $pdf->SetFills(array(0,0,0,0,0,0,0));
 $pdf->SetAligns(array('R','L','L','L','L','L','R'));
 $pdf->SetVisibles(array(0,1,1,1,1,1,1));
 $pdf->SetFontsSizes(array(6,6,6,6,6,6,6));
 $pdf->SetFontsStyles(array('','','','','','',''));
 $pdf->SetDecimales(array(0,0,0,0,0,0,0));
 $pdf->SetSpaces(array(3,3,3,3,3,3,3));
 $pdf->SetFillColor(255,255,255);
 $pdf->SetDrawColor(0,0,0);  
 $pdf->SetFont('Arial','B',7);
 

$v_setdetalle=$_SESSION['PDF_SETDetalle'];
 for ($i=0;$i<sizeof($v_setdetalle);$i++){
 	 $pdf->SetLineWidth(0.05);
 	 $pdf->SetDrawColor(200,200,200);
	   $pdf->MultiTabla($v_setdetalle[$i],0,3,3,6);
   }
	 $pdf->SetLineWidth(0.2); 
	  $pdf->SetDrawColor(255,255,255);
$pdf->Output();


?>