<?php
session_start();
require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{   
	function PDF($orientation='L',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    //Iniciación de variables
    }
 
	function Header()
	{
		$this->Image('../../../../lib/images/logo_reporte.jpg',230,5,35,10);
	}
	//Pie de página
	function Footer()
	{ 
		 //Posición: a 1,5 cm del final
	    $this->SetY(-15);
	    //Arial italic 8
	    $this->SetFont('Arial','I',7);    
	   
		//Número de página
	    $fecha=date("d-m-Y");
		//hora
	    $hora=date("H:i:s");
		$this->Cell(130,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L'); 
	    $this->Cell(115,10,'Página '.$this->PageNo().' de {nb}',0,0,'L');     
	    $this->Cell(100,10,'Fecha: '.$fecha ,0,0,'L');
	    $this->ln(3);
	    $this->Cell(130,10,'Sistema: ENDESIS - SEGURIDAD',0,0,'L'); 
	    $this->Cell(115,10,'',0,0,'L');
	    $this->Cell(100,10,'Hora: '.$hora ,0,0,'L');
	    //fecha		
 	}
}

$pdf=new PDF();
$pdf->AliasNbPages();
//$pdf->AddFont('Arial','','arial.php'); 	
$pdf->AddPage();
$pdf->SetLeftMargin(8);
$pdf->SetTopMargin(20);
$pdf->SetAutoPageBreak(true,20.5);

$pdf->Ln(4);//salto de linea 

$pdf->SetFont('Arial','B',12);
$pdf->Cell(0,4,'CANTIDAD DE TRANSACCIONES POR SISTEMA',0,1,'C');

$pdf->SetFont('Arial','B',8);
$pdf->Ln();
$pdf->Cell(50,4,'Gestión: '.$_SESSION['PDF_gestion'],0,1,'L');
$pdf->Cell(50,4,'Usuario: '.$_SESSION['PDF_usuario'],0,1,'L');
$pdf->Ln();
$pdf->SetFont('Arial','B',6);

//$pdf->SetX(75);
$pdf->Cell(5,6,'Nº','LRTB',0,'C');
$pdf->Cell(55,6,'SUBSISTEMA','LRTB',0,'C');
$pdf->Cell(15,6,'ENERO','LRTB',0,'C');
$pdf->Cell(15,6,'FEBRERO','LRTB',0,'C');
$pdf->Cell(15,6,'MARZO','LRTB',0,'C');
$pdf->Cell(15,6,'ABRIL','LRTB',0,'C');
$pdf->Cell(15,6,'MAYO','LRTB',0,'C');
$pdf->Cell(15,6,'JUNIO','LRTB',0,'C');
$pdf->Cell(15,6,'JULIO','LRTB',0,'C');
$pdf->Cell(15,6,'AGOSTO','LRTB',0,'C');
$pdf->Cell(15,6,'SEPTIEMBRE','LRTB',0,'C');
$pdf->Cell(15,6,'OCTUBRE','LRTB',0,'C');
$pdf->Cell(15,6,'NOVIEMBRE','LRTB',0,'C');
$pdf->Cell(15,6,'DICIEMBRE','LRTB',0,'C');
$pdf->Cell(20,6,'TOTAL','LRTB',1,'C');

$v_estadisticas_sistema=array();
$v_estadisticas_sistema=$_SESSION['PDF_estadisticas_sistema'];

$pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial')); 
$pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1,1,1));
$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6,6,6));
$pdf->SetFontsStyles(array('','','','','','','','','','','','','',''));
$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
$pdf->SetWidths(array(55,15,15,15,15,15,15,15,15,15,15,15,15,20));
$pdf->SetDecimales(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0));
$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0));
$pdf->SetAligns(array('L','R','R','R','R','R','R','R','R','R','R','R','R','R'));


for($i=0;$i<count($v_estadisticas_sistema);$i++)
{
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(5,3,$i+1,1,0,'C');
	$pdf->MultiTabla($v_estadisticas_sistema[$i],0,3,3,6,1);
}

$pdf->Output();
?>