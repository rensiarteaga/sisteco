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
   
    $this->Image('../cotizacion/images/medio.jpg',35,0,170,35);
    $this->Image('../cotizacion/images/izquierda.jpg',0,5,35,35);
    $this->Image('../cotizacion/images/barra.jpg',32,0,1,300);
    
    $this->SetXY(52,27);
   	$this->Cell(55,5,''.$_SESSION['ss_nombre_lugar'].'',0,0,'L');
   	$this->Cell(18,5,' ',0,0,'L');
   	$this->Cell(28,5,date('d/m/Y'),0,0,'L');
   	$this->Cell(5,5,'',0,0,'L');
   if($_SESSION['PDF_tipo_adq']=='Bien'){
   		$this->Cell(40,5,'CB-'.$_SESSION['PDF_num_proceso'].'-'.$_SESSION['PDF_gestion'],0,1,'R');
   	}else{
   		$this->Cell(40,5,'CS-'.$_SESSION['PDF_num_proceso'].'-'.$_SESSION['PDF_gestion'],0,1,'R');
   	}
    //$this->Image('images/ende.jpg',170,2,35,15);
	//$this->Image('../../../lib/images/logo_reporte.jpg',15,2,35,15);

}
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-25);
    //Arial italic 8
    $this->SetFont('Arial','',7);
    //Número de página
    //$pdf->Ln(5);
    $this->SetFillColor(0,0,0);
		
}

//Cabecera de página

}



//-----------------------Definición de variables

$pdf=new PDF();
//$pdf->AddPage();
$pdf->AliasNbPages();
$pdf-> AddFont('Arial','','arial.php'); 	
$pdf->SetLeftMargin(35);
$pdf->SetTopMargin(38);
$pdf->SetAutoPageBreak(true,20.5);
$pdf->SetFont('Arial','B',12);
$pdf->AddPage();


$codigo =$_SESSION['PDF_codigo'];

$num_convocatoria_sig=$_SESSION['PDF_num_convocatoria_sig'];
$num_convocatoria=$_SESSION['PDF_num_convocatoria'];
$observaciones=$_SESSION['PDF_observaciones'];

//$pdf->Cell(50,20,'',1,0); 
 //	$pdf->Cell(185,13,'MEMORÁNDUM',0,1,'C');
 	$pdf->SetFont('Arial','B',10);
 	    $pdf->Cell(15,10,'DE:',0,0);
 	    $pdf->Cell(5,10,'',0,0);
		$pdf->Cell(20,10,'COMISION DE CALIFICACION ',0,1,'L');//,'LR',0,'C');
		$pdf->Cell(15,10,'A:',0,0);
		$pdf->Cell(5,10,'',0,0);
		$pdf->Cell(150,10,'RESPONSABLE DE COMPRAS MENORES',0,1,'L');//,'LR',0,'C');
		$pdf->Cell(20,10,'ASUNTO: ',0,0);
		$pdf->SetFont('Arial','BU',10);
		$pdf->Cell(100,10,'INFORME CONVOCATORIA Nº '.$num_convocatoria.':  '.$codigo,0,1,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','BU',10);
		$pdf->Cell(120,10,'ANTECEDENTES',0,1,'L');
		
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(165,5,$observaciones,0);
		$pdf->SetFont('Arial','BU',10);
		
		
		$pdf->Cell(120,10,'RECOMENDACION',0,1,'L');
		$pdf->SetFont('Arial','',10);
		
		$pdf->MultiCell(185,5,'Por lo expuesto, la comisión de Calificación, recomienda se de inicio con la convocatoria Nº '.$num_convocatoria_sig,0);
	
	$pdf->Cell(185,10,'',0,1);
	$pdf->Cell(45,5,'Por la Comisión de Calificación:',0,1);
	$pdf->Cell(185,15,'',0,1);
	$pdf->Cell(15,6,'',0,0);
	/*$pdf->Cell(60,6,'___________________',0,0);
	$pdf->Cell(40,6,'',0,0);
	$pdf->Cell(60,6,'___________________',0,0);*/
	$pdf->Ln(6); 
$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(0); 
$pdf->Output();
?>