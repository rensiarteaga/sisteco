<?php
session_start();
/**
 * Autor:  unknow
 * Fecha de creacion: 08072014
 * Descripci�n: reporte de los movimientos del sistema
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
		//Iniciaci�n de variables
	}

	function Header()
	{
	}

	//Pie de p�gina
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
		$this->SetLeftMargin(15);
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

$dia_ini = date("d", strtotime($f_ini));
$mes_ini = date("m", strtotime($f_ini));
$anio_ini = date("Y", strtotime($f_ini));

$dia_fin = date("d", strtotime($f_fin));
$mes_fin = date("m", strtotime($f_fin));
$anio_fin = date("Y", strtotime($f_fin));


$mes_ini_literal=mesLiteral($mes_ini);
$mes_fin_literal=mesLiteral($mes_fin);


$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,7);
$pdf->SetMargins(15,5,10);

$pdf->SetFont('Arial','B',14);

$pdf->SetX(1);
$pdf->SetFont('Arial','B',15);
$pdf->Cell(220,3,'DETALLE DE SALIDAS',0,1,'C');
$pdf->Ln(2);

$pdf->SetX(95);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(6,3,'  DESDE :  '.$dia_ini.' DE '.strtoupper($mes_ini_literal).' DE '.$anio_ini,0,0,'L');
$pdf->Ln();
$pdf->SetX(95);
$pdf->Cell(6,3,'  AL :  '.$dia_fin.' DE '.strtoupper($mes_fin_literal).' DE '.$anio_fin,0,0,'L');

$pdf->SetLeftMargin(20);

$pdf->Ln(6);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(30,3,'ALMACEN : ',0,0,'L'); 

$auxY=$pdf->getY();$auxX=$pdf->getX();

$pdf->SetFont('Arial','',6);
$pdf->Cell(50,3,'      '.utf8_decode(strtoupper($_SESSION['pdf_salida_general'][0][0])),0,1,'L');



$pdf->setXY($auxX+90,$auxY);

$pdf->SetFont('Arial','B',6);
$pdf->Cell(30,3,'MOVIMIENTO : ',0,0,'L'); 
$pdf->SetFont('Arial','',6);
$pdf->Cell(50,3,'      EGRESOS',0,1,'L');
$pdf->SetLeftMargin(15);
$pdf->Ln(6);


$pdf->SetFont('Arial','B',6);
$pdf->Cell(92,3,'DESCRIPCION','TRL',0,'C');//2
$pdf->Cell(22,3,'UNIDAD','TRL',0,'C');//3
$pdf->Cell(18,3,'FECHA','TRL',0,'C');//4
$pdf->Cell(18,3,'CANTIDAD','TRL',0,'C');//4
$pdf->Cell(18,3,'PRECIO','TRL',0,'C');//5
$pdf->Cell(18,3,'PRECIO','TRL',0,'C');//4

$pdf->Ln();

//$pdf->Cell(21,3,'','BRL',0,'C');//1
$pdf->Cell(92,3,'','BRL',0,'C');//2
$pdf->Cell(22,3,'MEDIDA','BRL',0,'C');//3
$pdf->Cell(18,3,'','BRL',0,'C');//4
$pdf->Cell(18,3,'','BRL',0,'C');//4
$pdf->Cell(18,3,'PROMEDIO','BRL',0,'C');//5
$pdf->Cell(18,3,'TOTAL','BRL',0,'C');//4

$pdf->Ln();

$pdf->SetWidths(array(1,92,22,18,18,18,18,1,1));
$pdf->SetFills(array(0,0,0,0,0,0,0,0,0));
$pdf->SetVisibles(array(0,1,1,1,1,1,1,0,0));
$pdf->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5,5,5));
$pdf->SetAligns(array('L','L','C','C','R','R','R','','',));
$pdf->SetFontsStyles(array('','','','','','','',''));
$pdf->SetDecimales(array(0,0,0,0,2,2,2,0,0));
$pdf->SetSpaces(array(5,5,5,5,5,5,5,5,5));
$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0));

$detalle=$_SESSION['pdf_salida_general'];
$sum=0;
$i_next=0;$i_back=0;
$t_next='';$t_back='';
$sum_parcial=0;

for ($j=0; $j<count($detalle); $j++)
{
	$sum+=$detalle[$j][6];
	$pdf->MultiTabla($detalle[$j],2,1,5,5,0);

	
	$i_back=$detalle[$j][10];
	$i_next=$detalle[$j+1][10];
	
	if($i_back == $i_next)
	{
		$t_back=$detalle[$j][10];
		$t_next=$detalle[$j+1][10];
		
		if($t_back == $t_next)
		{
			$sum_parcial +=$detalle[$j][6];
		}
		else 
		{
			$sum_parcial +=$detalle[$j][6];
			

			$pdf->SetFont('Arial','',6);
			$pdf->Cell(168,3,'MOVIMIENTO :     '.$detalle[$j][9].' - '. $detalle[$j][8],'TBRL',0,'L');
			$pdf->Cell(18,3,number_format($sum_parcial,2),'TBRL',0,'R');
			
			$sum_parcial=0;
			$pdf->Ln();
			$pdf->Cell(186,3,'    ','B',0,'L');
			$pdf->Ln();
		}
	}
	else 
	{
		$sum_parcial +=$detalle[$j][6];
		
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(168,3,'MOVIMIENTO :     '.$detalle[$j][9].' - '. $detalle[$j][8],'TBRL',0,'L');
		$pdf->Cell(18,3,number_format($sum_parcial,2),'TBRL',0,'R');
		
		$sum_parcial=0;
		$pdf->Ln();
		$pdf->Cell(186,3,'    ','B',0,'L');
		$pdf->Ln();
	}
		
}

$pdf->Ln();

$pdf->Output();

?>
