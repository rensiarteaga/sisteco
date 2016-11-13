<?php
session_start();
/**
 * Autor: Marcos A. Flores Valda
 * Fecha de creacion: 07/01/2011
 * Descripción: Reporte de Depreciaciones
 * **/

require('../../../lib/fpdf/fpdf.php');
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
   		$this->Image('../../../lib/images/logo_reporte.jpg',180,5,25,9);
  		$this->Ln(5); 		 		  
	}
	
	//Pie de página
	function Footer()
	{
	    //Posición: a 1,5 cm del final
	    $fecha=date("d-m-Y");
		$hora=date("H:i:s");
		$this->SetY(-10);
	    $this->SetFont('Arial','',6);
	    $this->Cell(80,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(40,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(62,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(80,3,'Sistema: ENDESIS - KARDEX',0,0,'L');
		$this->Cell(40,3,'',0,0,'C');
		$this->Cell(62,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');
	}
}

if($_SESSION['PDF_tipo_licencia'] == 'Vacaciones')
{
	$licencia = 'PROGRAMACIÓN DE VACACIÓN';
}
else 
{
	if($_SESSION['PDF_tipo_licencia'] == 'Compensaciones')
	{
		$licencia = 'PROGRAMACIÓN DE COMPENSACIÓN';
	}
}

$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true,7);
$pdf->SetMargins(7,5,5);

// ORIGINAL

//  TITULO
//$pdf->Image('../../../lib/images/logo_reporte.jpg',8,9,26,9);
//$pdf->SetFont('Arial','B',14); // celda de logo
//$pdf->SetX(152);
//$pdf->Cell(30,10,'',0,0,'C');
	    
$pdf->SetFont('Arial','B',14);
$pdf->Cell(205,10,$licencia,0,1,'C');

$pdf->SetFont('Arial','B',6);
$pdf->Cell(15,4,'EMPLEADO: ',0,0,'L');
$pdf->SetFont('Arial','',6);
$pdf->Cell(50,4,$_SESSION['PDF_nombre'],0,1,'L');
$pdf->SetFont('Arial','B',6);
$pdf->Cell(15,4,'CATEGORÍA: ',0,0,'L');
$pdf->SetFont('Arial','',6);
$pdf->Cell(30,4,$_SESSION['PDF_categoria'],0,1,'L');
$pdf->SetFont('Arial','B',6);
$pdf->Cell(15,4,'GESTIÓN: ',0,0,'L');
$pdf->SetFont('Arial','',6);
$pdf->Cell(30,4,$_SESSION['PDF_gestion'],0,1,'L');  
$pdf->Ln(2);
		 
//cabecera de la grilla
$pdf->SetFont('Arial','B',6);
$pdf->Cell(20,3,'TIPO LICENCIA',1,0,'C');  
$pdf->Cell(17,3,'FECHA INICIO',1,0,'C');  
$pdf->Cell(17,3,'FECHA FIN',1,0,'C');  
$pdf->Cell(17,3,'PERIODO',1,0,'C');  
$pdf->Cell(15,3,'TOTAL DÍAS',1,0,'C'); 
$pdf->Cell(65,3,'OBSERVACIONES',1,0,'C');  
$pdf->Cell(32,3,'ESTADO',1,0,'C');  
$pdf->Cell(20,3,'FECHA REGISTRO',1,1,'C');

$pdf->SetFont('Arial','',6);
$pdf->SetWidths(array(0,0,0,0,20,17,17,17,15,65,32,20));
$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0));
$pdf->SetAligns(array('','','','','C','C','C','C','R','L','C','C'));
$pdf->SetVisibles(array(0,0,0,0,1,1,1,1,1,1,1,1));
$pdf->SetFontsSizes(array(0,0,0,0,6,6,6,6,6,6,6,6));
$pdf->SetFontsStyles(array('','','','','','','','','','','',''));
$pdf->SetDecimales(array(0,0,0,0,0,0,0,0,0,0,0,0));
$pdf->SetSpaces(array(0,0,0,0,3,3,3,3,3,3,3,3));
$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0));

$rep = $_SESSION['PDF_reporte'];

//for ($i = 0; $i < sizeof($rep); $i++)
//{
//	if($rep[$i]['tipo_periodo'] == 'dia_completo')
//	{
//		$rep[$i]['tipo_periodo'] = 'Día completo';
//	}
//	else 
//	{
//		if($rep[$i]['tipo_periodo'] == 'manana')
//		{
//			$rep[$i]['tipo_periodo'] = 'Mañana';
//		}
//		else 
//		{
//			$rep[$i]['tipo_periodo'] = 'Tarde';
//		}
//	}
//}

for ($i = 0; $i < sizeof($rep); $i++)
{	
	$pdf->SetLineWidth(0.05);	
	$pdf->MultiTabla($rep[$i],0,3,3,6,1);
}

$pdf->Output();
?>

