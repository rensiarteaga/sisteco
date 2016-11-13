<?php

session_start();

require('../../../../lib/fpdf/fpdf.php');
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
		if($this->PageNo()==1){
			$this->Image('../../../../lib/images/logo_reporte.jpg',20,10,35,13);
			$this->SetFont('Arial','B',10);
			$this->Ln(10);
		}else {
			$this->Image('../../../../lib/images/logo_reporte.jpg',20,10,35,13);
			$this->Ln(10);
			$this->SetY(10);

			//Títulos de las columnas
			$this->SetFont('Arial','B',9);
			$this->Cell(47,5,'','TLR',0,'C');
			$this->Cell(98,5,'','TLR',0,'C');
			$this->Cell(25,5,'Fecha Desde:','TL',0,'R');
			$this->Cell(22,5,''.$_SESSION['PDF_fecha_desde'],'TR',1,'L');

			$this->SetFont('Arial','B',12);
			$this->Cell(47,5,'','LR',0,'C');
			$this->Cell(98,5,'KARDEX FÍSICO VALORADO','LR',0,'C');
			$this->SetFont('Arial','B',9);
			$this->Cell(25,5,'Fecha Hasta:','L',0,'R');
			$this->Cell(22,5,''.$_SESSION['PDF_fecha_hasta'],'R',1,'L');

			$this->Cell(47,5,'','LRB',0,'C');
			$this->Cell(98,5,'Item: '.$_SESSION['PDF_nombre_item'],'LRB',0,'C');
			$this->SetFont('Arial','B',9);
			$this->Cell(25,5,'Página:','LB',0,'R');
			$this->Cell(22,5,''.$this->PageNo().' de {nb}','RB',1,'L');
			$this->Ln(5);
			
			$this->SetFont('Arial','B',8);
			$this->Cell(85,5,'',0,0,'C',0);
			$this->Cell(45,5,'FÍSICO','LTR',0,'C',0);
			$this->Cell(15,5,'','L',0,'C',0);
			$this->Cell(47,5,'VALORADO','LTR',1,'C',0);


			$this->Cell(15,5,'FECHA',1,0,'C');
			$this->Cell(15,5,'NUMERO',1,0,'C');
			$this->Cell(55,5,'DESCRIPCIÓN',1,0,'C');
			$this->Cell(15,5,'ENTRADA',1,0,'C');
			$this->Cell(15,5,'SALIDA',1,0,'C');
			$this->Cell(15,5,'SALDO',1,0,'C');
			$this->Cell(15,5,'P.U. Bs',1,0,'C');
			$this->Cell(15,5,'DEBE',1,0,'C');
			$this->Cell(15,5,'HABER',1,0,'C');
			$this->Cell(17,5,'SALDO',1,1,'C');
		}

	}
	//Pie de página
	function Footer()
	{



		$fecha=date("d-m-Y");
		$hora=date("h:i:s");
		$this->SetY(-11);
		$this->SetFont('Arial','',6);
		$this->Cell(192,0.2,'',1,1);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');

	}


}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf-> AddFont('Tahoma','','tahoma.php');
$pdf-> AddFont('Arial','','arial.php');

$pdf->SetMargins(15,10,10);
$pdf->SetFont('Arial','B',14);
$pdf->SetAutoPageBreak(true,12);
$pdf->SetLineWidth(.1);
$pdf->SetFillColor(255,255,255);
$fill=true;
$pdf->SetDrawColor(190,190,190);
$pdf->SetY(10);

//Títulos de las columnas
$pdf->SetFont('Arial','B',9);
$pdf->Cell(47,5,'','TLR',0,'C');
$pdf->Cell(98,5,'','TLR',0,'C');
$pdf->Cell(25,5,'Fecha Desde:','TL',0,'R');
$pdf->Cell(22,5,''.$_SESSION['PDF_fecha_desde'],'TR',1,'L');

$pdf->SetFont('Arial','B',12);
$pdf->Cell(47,5,'','LR',0,'C');
$pdf->Cell(98,5,'KARDEX FÍSICO VALORADO DE ITEM','LR',0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(25,5,'Fecha Hasta:','L',0,'R');
$pdf->Cell(22,5,''.$_SESSION['PDF_fecha_hasta'],'R',1,'L');

$pdf->Cell(47,5,'','LRB',0,'C');
$pdf->Cell(98,5,'','LRB',0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(25,5,'Página:','LB',0,'R');
$pdf->Cell(22,5,''.$pdf->PageNo().' de {nb}','RB',1,'L');
$pdf->Ln(5);


$pdf->SetFont('Arial','B',10);
$pdf->Cell(47,5,'Estructura Programática:',0,0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(98,5,''.$_SESSION['PDF_codigo_ep'],0,0,'L');
$pdf->Ln(5);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(47,5,'Almacén Físico:',0,0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(98,5,$_SESSION['PDF_desc_almacen'],0,1,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(47,5,'Almacén Lógico:',0,0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(98,5,$_SESSION['PDF_desc_almacen_logico'],0,1,'L');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(47,5,'Nombre Item:',0,0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(98,5,$_SESSION['PDF_nombre_item'],0,1,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(47,5,'Descripción Item:',0,0,'R');
$pdf->SetFont('Arial','I',8);
$pdf->MultiCell(145,5,$_SESSION['PDF_descripcion'],0,1,'L',$fill);
//$pdf->Cell(145,5,''.$_SESSION['PDF_descripcion'],0,1,'L');

$pdf->Ln(3);



$pdf->SetFont('Arial','B',8);
$pdf->Cell(85,5,'',0,0,'C',0);
$pdf->Cell(45,5,'FÍSICO','LTR',0,'C',0);
$pdf->Cell(15,5,'','L',0,'C',0);
$pdf->Cell(47,5,'VALORADO','LTR',1,'C',0);

$pdf->Cell(15,5,'FECHA',1,0,'C');
$pdf->Cell(15,5,'NÚMERO',1,0,'C');
$pdf->Cell(55,5,'DESCRIPCIÓN',1,0,'C');
$pdf->Cell(15,5,'ENTRADA',1,0,'C');
$pdf->Cell(15,5,'SALIDA',1,0,'C');
$pdf->Cell(15,5,'SALDO',1,0,'C');
$pdf->Cell(15,5,'P.U. Bs',1,0,'C');
$pdf->Cell(15,5,'DEBE',1,0,'C');
$pdf->Cell(15,5,'HABER',1,0,'C');
$pdf->Cell(17,5,'SALDO',1,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->SetWidths(array(15,15,55,15,15,15,15,15,15,17));
$pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1));
$pdf->SetAligns(array('C','L','L','R','R','R','R','R','R','R'));
$pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
$pdf->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5));
$pdf->SetSpaces(array(3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5));
//$pdf->SetDecimales(array(0,0,0,2,2,2,2,2,2,2));
$pdf->SetDecimales(array(0,0,0,2,2,2,6,6,6,6));

$v_mat_ent_det=$_SESSION['PDF_kardex_item_detalle'];
$sum_total=0;
$tot_debe=0;
$tot_haber=0;
for ($i=0;$i<sizeof($v_mat_ent_det);$i++){
	$numero=$i+1;
	$pdf->MultiTabla($v_mat_ent_det[$i],2,3,3.5,6);
	$sum_total=$sum_total+$v_mat_ent_det[$i][3];
	$tot_debe+=$v_mat_ent_det[$i]['costo_debe'];
	$tot_haber+=$v_mat_ent_det[$i]['costo_haber'];
}
//$pdf->Cell(205,0.2,'',1,1);
$pdf->SetFont('Arial','',5);
//$pdf->Ln();
$pdf->Cell(15,3.5,'',0,0,'C');
$pdf->Cell(15,3.5,'',0,0,'C');
$pdf->Cell(55,3.5,'',0,0,'C');
$pdf->Cell(15,3.5,'',0,0,'C');
$pdf->Cell(15,3.5,'',0,0,'C');
$pdf->Cell(15,3.5,'',0,0,'C');
$pdf->Cell(15,3.5,'',0,0,'C');
$pdf->Cell(15,3.5,number_format($tot_debe,6,'.',','),0,0,'R');
$pdf->Cell(17,3.5,number_format($tot_haber,6,'.',','),0,0,'R');

$pdf->SetFont('Arial','',8);
$pdf->Ln(5);

$pdf->Output();
?>