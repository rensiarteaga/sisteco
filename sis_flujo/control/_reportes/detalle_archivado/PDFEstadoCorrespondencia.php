<?php
session_start();
/**
 * Autor: Marcos A. Flores Valda
 * Fecha de creacion: 07/01/2011
 * Descripción: Reporte de Depreciaciones
 * **/

require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');


class PDF extends FPDF
{   			
	function PDF($orientation='P',$unit='mm',$format='Letter') //265 en horizontal
    {
	    //Llama al constructor de la clase padre
	    $this->FPDF($orientation,$unit,$format);
	    $this-> AddFont('Arial','','arial.php');
	     
	    //Iniciación de variables    
    }
    
	function Header()
	{       
   		$this->Image('../../../../lib/images/logo_reporte.jpg',185,4,25,9);
  		$this->Ln(10); 		 		  
	}
	
	//Pie de página
	function Footer()
	{
	    //Posición: a 1,5 cm del final
	    $fecha=date("d-m-Y");
		$hora=date("H:i:s");
		$this->SetY(-8);
	    $this->SetFont('Arial','',6);
	    $this->Cell(80,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(40,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(62,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(80,3,'Sistema: ENDESIS - FLUJO',0,0,'L');
		$this->Cell(40,3,'',0,0,'C');
		$this->Cell(62,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');
	}
}

$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true,7);
$pdf->SetMargins(7,5,5);

//  TITULO
	    
$pdf->SetFont('Arial','B',10);
$pdf->Cell(217,5,'ESTADO DE CORRESPONDENCIA',0,1,'C');

$pdf->SetFont('Arial','B',6);
$pdf->Cell(90,4,'Del: ',0,0,'R');
$pdf->Cell(20,4,$_SESSION['desde'],0,0,'L');

$pdf->Cell(5,4,'	Al: ',0,0,'L');
$pdf->Cell(10,4,$_SESSION['hasta'],0,1,'L');
 
$pdf->Ln(1);
		 
//cabecera de la grilla - PRIMERA FILA
$pdf->SetFont('Arial','B',5.5);
$pdf->Cell(26,3,'NUMERO',1,0,'C');  
$pdf->Cell(25,3,'ESTADO',1,0,'C');  
$pdf->Cell(10,3,'DIGITAL',1,0,'C');  
$pdf->Cell(40,3,'REFERENCIA',1,0,'C');  
$pdf->Cell(35,3,'EMPLEADO REMITENTE',1,0,'C'); 
$pdf->Cell(35,3,'UNIDAD ORG.',1,0,'C'); 
$pdf->Cell(30,3,'RESP. REGISTRO',1,1,'C');

$pdf->SetFont('Arial','',5.5);
$pdf->SetWidths(array(26,25,10,40,35,35,30));
$pdf->SetFills(array(0,0,0,0,0,0,0));
$pdf->SetAligns(array('L','L','C','L','L','L','L'));
$pdf->SetVisibles(array(1,1,1,1,1,1,1));
$pdf->SetFontsSizes(array(5.5,5.5,5.5,5.5,5.5,5.5,5.5));
$pdf->SetFontsStyles(array('','','','','','',''));
$pdf->SetDecimales(array(0,0,0,0,0,0,0));
$pdf->SetSpaces(array(3,3,3,3,3,3,3));
$pdf->SetFormatNumber(array(0,0,0,0,0,0,0));

$rep = $_SESSION['datos'];

for ($i = 0; $i < sizeof($rep); $i++)
{	
	$pdf->SetLineWidth(0.05);		
		
	$pdf->MultiTabla($rep[$i],0,3,3,6,1);					
}

$pdf->Output();
?>

