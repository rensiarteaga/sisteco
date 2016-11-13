<?php
session_start();
/**
 * Autor:  unknow
 * Fecha de creacion: 08072014
 * Descripciï¿½n: reporte de existencias de almacen
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
		//Iniciaciï¿½n de variables
	}

	function Header()
	{
	}

	//Pie de pï¿½gina
	function Footer()
	{
		//Posicion: a 1,5 cm del final
		$fecha=date("d-m-Y");
		$hora=date("H:i:s");
		$this->SetLeftMargin(10);
		$this->SetY(-7);
		$this->SetFont('Arial','',5);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Pagina '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(65,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'R');
		$this->ln(3);
		$this->Cell(100,3,'Sistema: ENDESIS - ALMIN',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(35,3,'',0,0,'C');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'R');
	}
	
	
}

function mesLiteral($mes)
{
	switch ($mes)
	{
		case 1:$mes="Enero";break;
		case 2:$mes="Febrero";break;
		case 3:$mes="Marzo";break;
		case 4:$mes="Abril";break;
		case 5:$mes="Mayo";break;
		case 6:$mes="Junio";break;
		case 7:$mes="Julio";break;
		case 8:$mes="Agosto";break;
		case 9:$mes="Septiembre";break;
		case 10:$mes="Octubre";break;
		case 11:$mes="Noviembre";break;
		case 12:$mes="Diciembre";break;
	}
	return $mes;
}

$fecha = date("d").' DE '.mesLiteral(date("m")).' DEL '.date("Y");

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,7);
$pdf->SetMargins(20,5,10);

$pdf->SetFont('Arial','B',14);


	$pdf->SetX(1);
	$pdf->SetFont('Arial','B',15);
	$pdf->Cell(220,3,'INFORMACIÓN DE CONTROL DE EXISTENCIAS',0,1,'C');
	$pdf->Ln();
	
	$pdf->SetX(87);
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(55,3,$nombre_almacen,0,0,'C');
	$x=$pdf->getX();$y=$pdf->getY();
	$pdf->Ln();
	
	$pdf->Ln();
	$pdf->SetX(87);
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(55,3,'  AL : '.strtoupper($fecha),0,0,'C');
	
	$pdf->Ln(6);

		

	
	
	$pdf->SetLeftMargin(12);
	$pdf->Ln(6);
	
	
	$pdf->SetFont('Arial','B',6);
	
	$pdf->Cell(30,3,'','',0,'C');
	$pdf->Cell(29,3,'CODIGO','TRL',0,'C');//2
	$pdf->Cell(50,3,'DENOMINACION','TRL',0,'C');//3
	$pdf->Cell(15,3,'EXISTENCIAS','TRL',0,'C');//3
	$pdf->Cell(15,3,'UNIDAD','TRL',0,'C');//4
	$pdf->Cell(15,3,'PRECIO','TRL',0,'C');//4
	$pdf->Cell(18,3,'PRECIO','TRL',0,'C');//5

	
	$pdf->Ln();
	
	$pdf->Cell(30,3,'','',0,'C');
	$pdf->Cell(29,3,'MATERIAL','BRL',0,'C');//2
	$pdf->Cell(50,3,'','BRL',0,'C');//3
	$pdf->Cell(15,3,'','BRL',0,'C');//3
	$pdf->Cell(15,3,'MEDIDA','BRL',0,'C');//4
	$pdf->Cell(15,3,'UNITARIO Bs.','BRL',0,'C');//4
	$pdf->Cell(18,3,'TOTAL Bs.','BRL',0,'C');//5

	
	$pdf->Ln();
	
	$pdf->SetWidths(array(30,29,50,15,15,15,18));
	$pdf->SetFills(array(0,0,0,0,0,0,0,0,0));
	$pdf->SetVisibles(array(0,1,1,1,1,1,1));
	$pdf->SetFontsSizes(array(5,5,5,5,5,5,5,5));
	$pdf->SetAligns(array('L','L','L','C','R','R','R','R'));
	$pdf->SetFontsStyles(array('','','','','','','','','','',''));
	$pdf->SetDecimales(array(0,0,0,0,0,0,6,6));
	$pdf->SetSpaces(array(5,5,5,5,5,5,5,5));
	$pdf->SetFormatNumber(array(0,0,0,0,1,0,1,1));
	
	$detalle=$_SESSION['pdf_control_existencias'];
	$sum=0;
	$total_existencias = 0;
	
	for ($i=0; $i<count($detalle); $i++)
	{
		$total_existencias+= $detalle[$i]["existencias"];
		$total_precio += $detalle[$i]["precio_total"];
		//$pdf->MultiTabla($detalle[$i],2,1,3,6,1);	
		
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(30,3,'','',0,'C');
		$pdf->Cell(29,3,$detalle[$i]["codigo"],'RL',0,'L');//1
		$pdf->Cell(50,3,$detalle[$i]["nombre"],'RL',0,'L');//1
		$pdf->Cell(15,3,$detalle[$i]["existencias"],'RL',0,'R');//1
		$pdf->Cell(15,3,$detalle[$i]["unidad_medida"],'RL',0,'C');//1
		$pdf->Cell(15,3,$detalle[$i]["precio_unitario"],'RL',0,'R');//1
		$pdf->Cell(18,3,$detalle[$i]["precio_total"],'RL',0,'R');//1
		
		$pdf->Ln();
		
	}
	$pdf->Cell(30,3,'','',0,'C');
	$pdf->Cell(29,3,'','BLR',0,'C');
	$pdf->Cell(50,3,'','BLR',0,'C');
	$pdf->Cell(15,3,'','BLR',0,'C');
	$pdf->Cell(15,3,'','BLR',0,'C');
	$pdf->Cell(15,3,'','BLR',0,'C');
	$pdf->Cell(18,3,'','BLR',0,'C');
	$pdf->Ln();
	
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(59,3,'','',0,'C');
	$pdf->Cell(50,3,'TOTALES :','BRL',0,'R');
	$pdf->Cell(15,3,number_format($total_existencias,2),'BRL',0,'R');
	$pdf->Cell(15,3,'','B',0,'C');
	$pdf->Cell(15,3,'','B',0,'C');
	$pdf->Cell(18,3,number_format($total_precio,2),'BRL',0,'R');
	// $pdf->Cell(15,5,number_format($sum,6),'BRL',0,'R');



	if($pdf->GetY() >= 250)
	{
		$pdf->SetAutoPageBreak(true);
		$pdf->AddPage();
	}

	$pdf->Ln();
	

$pdf->Output();
?>
