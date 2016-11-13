<?php

session_start();

require('../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{
	function PDF($orientation='L',$unit='mm',$format='Letter')
	{
		//Llama al constructor de la clase padre
		$this->FPDF($orientation,$unit,$format);
		$this-> AddFont('Arial','','arial.php');
		//Iniciación de variables
	}
	function SetPrograma($nombre_programa)
	{
		$this->nombre_programa=$nombre_programa;
	}
	//Cabecera
	function Header ()
	{


		$this->SetMargins(1,5,5);
		$this->SetFont('Arial','B',14);
		
		$this->SetXY(1,1);
		$this->Cell(277,15,'DOCUMENTOS DE RESPALDO '.$_SESSION['desc_clases'],0,1,'C');
        $this->Image('../../../lib/images/logo_reporte.jpg',240,2,35,14);
		
		$cabecera[0][0]='Acreedor';
		$cabecera[0][1]=$_SESSION['PDF_acreedor'];
		$cabecera[0][2]='Pedido';
		$cabecera[0][3]=$_SESSION['PDF_pedido'];

		$cabecera[1][0]='Operacion';
		$cabecera[1][1]=$_SESSION['PDF_concepto_cbte'];
		$cabecera[1][2]='Conformidad:';
		$cabecera[1][3]=$_SESSION['PDF_conformidad'];

		$cabecera[2][0]='Aprobación:';
		$cabecera[2][1]=$_SESSION['PDF_aprobacion'];
		$cabecera[2][2]='Expresado en:';
		$cabecera[2][3]=$_SESSION['PDF_simbolo_moneda'];
		$this->SetWidths(array(18,165,20,74));
		$this->SetVisibles(array(1,1,1,1));
		$this->SetFonts(array('Arial','Arial','Arial','Arial'));
		$this->SetFontsSizes(array(7,7,7,7));
		$this->SetFontsStyles(array('B','','B',''));
		$this->SetSpaces(array(3.5,3.5,3.5,3.5));
		$this->SetAligns(array('L','L','L','L'));

		for ($o=0;$o<sizeof($cabecera);$o++){
			$this->MultiTabla($cabecera[$o],1,0,3.5,7);

		}
		
	$this->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial'));
	$this->SetFontsStyles(array('','','','','','','','','','','','','','','',''));
	$this->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
	$this->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6));
	$this->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
	$this->SetWidths(array(8,30,35,15,15,20,18,18,13,15,15,15,15,15,15,15,15));
	$this->SetDecimales(array(0,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2));
	$this->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,1,1,1,1,1,1,1,1));
	$this->SetAligns(array('R','L','L','L','L','L','L','L','L','R','R','R','R','R','R','R','R'));

		$this->SetFont('Arial','B',8);
		//cabecera del detalle
		$this->Cell(8,3.5,'Nº','LT',0,'C');
		$this->Cell(30,3.5,'TIPO ','LT',0,'C');
		$this->Cell(35,3.5,'RAZÓN','LT',0,'C');
		$this->Cell(15,3.5,'NIT','LT',0,'C');
		$this->Cell(15,3.5,'Nº','LT',0,'C');
		$this->Cell(20,3.5,'CODIGO','LT',0,'C');
		$this->Cell(18,3.5,'POLIZA','LT',0,'C');
		$this->Cell(18,3.5,'FORM.','LT',0,'C');
		$this->Cell(13,3.5,'FECHA ','LT',0,'C');
		$this->Cell(15,3.5,'TOTAL','LT',0,'C');
		$this->Cell(15,3.5,'ICE','LT',0,'C');
		$this->Cell(15,3.5,'NO','LT',0,'C');
		$this->Cell(15,3.5,'SUJETO','LT',0,'C');
		$this->Cell(15,3.5,'CRÉDITO','LT',0,'C');
		$this->Cell(15,3.5,'IUE','LT',0,'C');
		$this->Cell(15,3.5,'IT','LTR',1,'C');
		
		
		$this->Cell(8,3.5,'DOC','LB',0,'C');
		$this->Cell(30,3.5,'','LB',0,'C');
		$this->Cell(35,3.5,'','LB',0,'C');
		$this->Cell(15,3.5,'','LB',0,'C');
		$this->Cell(15,3.5,'AUT.','LB',0,'C');
		$this->Cell(20,3.5,'CONTROL','LB',0,'C');
		$this->Cell(18,3.5,'DUI','LB',0,'C');
		$this->Cell(18,3.5,'','LB',0,'C');
		$this->Cell(13,3.5,'','LB',0,'C');
		$this->Cell(15,3.5,'','LB',0,'C');
		$this->Cell(15,3.5,'','LB',0,'C');
		$this->Cell(15,3.5,'GRAVADO','LB',0,'C');
		$this->Cell(15,3.5,'','LB',0,'C');
		$this->Cell(15,3.5,'','LB',0,'C');
		$this->Cell(15,3.5,'','LB',0,'C');
		$this->Cell(15,3.5,'','LBR',1,'C');
		
		

	}
	//Pie de página
	function Footer()
	{    
		if ($this->PageNo()!='{nb}'){
		$this->Cell(277,0.02	,'',1,1);	
			
		}
		 $fecha=date("d-m-Y");
	    $hora=date("H:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
   	    $this->Cell(100,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(80,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(75,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(100,3,'Sistema: ENDESIS -SCI',0,0,'L');
		$this->Cell(80,3,'',0,0,'C');
		$this->Cell(75,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
	}


}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,7);
$pdf->SetMargins(1,5,5);
$pdf->SetFont('Arial','B',16);

//Títulos de las columnas

	$pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial'));
	$pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
	$pdf->SetFontsStyles(array('','','','','','','','','','','','','','','',''));
	$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6));
	$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
	$pdf->SetWidths(array(8,30,35,15,15,20,18,18,13,15,15,15,15,15,15,15,15));
	$pdf->SetDecimales(array(0,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2));
	$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,1,1,1,1,1,1,1,1));
	$pdf->SetAligns(array('R','L','L','L','L','L','L','L','L','R','R','R','R','R','R','R','R'));

    $detalle_documentos=$_SESSION['PDF_DetalleRepDocumentos'];
	for ($i=0;$i<sizeof($detalle_documentos);$i++){
		$pdf->Multitabla($detalle_documentos[$i],0,1,3,6,1);
	}
	$pdf->Cell(277,0.02	,'',1,1);
	$sum_detalle_doc=$_SESSION['PDF_SumDetalleDocumentos'];
	
		$suma_detalle[0][0]="TOTALES";
		$suma_detalle[0][1]=$sum_detalle_doc[0][0];
		$suma_detalle[0][2]=$sum_detalle_doc[0][1];
		$suma_detalle[0][3]=$sum_detalle_doc[0][2];
		$suma_detalle[0][4]=$sum_detalle_doc[0][3];
		$suma_detalle[0][5]=$sum_detalle_doc[0][4];
		$suma_detalle[0][6]=$sum_detalle_doc[0][5];
		$suma_detalle[0][7]=$sum_detalle_doc[0][6];
		
		
	
	$pdf->SetWidths(array(172,15,15,15,15,15,15,15,15));
	$pdf->SetFormatNumber(array(0,1,1,1,1,1,1,1,1));
	$pdf->SetAligns(array('R','R','R','R','R','R','R','R','R'));
	$pdf->Multitabla($suma_detalle[0],0,3,3,6,1);
	

$pdf->Output();
?>

?> 