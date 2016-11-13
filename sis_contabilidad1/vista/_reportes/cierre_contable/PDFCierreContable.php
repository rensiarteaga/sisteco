<?php

session_start();

require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
$vcom_libro_mayor=$_SESSION['PDF_libro_mayor'];
$tam_libro_mayor=count($vcom_libro_mayor);

class PDF extends FPDF
{   
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    //Iniciación de variables
    }
	 //Cabecera
	function Header()
	{
		$this->SetMargins(15,5,2);
		$this->SetFont('Arial','B',16);
		$this->Image('../../../../lib/images/logo_reporte.jpg',180,2,35,15);
		$this->Cell(0,5,'CIERRE CONTABLE',0,1,'C');
		$this->SetFont('Arial','',8);
		$this->Cell(0,4,' '.$_SESSION['PDF_nombre_moneda_vmb'],0,1,'C');
		$this->SetFont('Arial','',8);
		$this->Cell(0,4,'DEL '.$_SESSION['PDF_fecha_ini_vcc'].'   AL  '.$_SESSION['PDF_fecha_fin_vcc'],0,1,'C');
		$this->SetFont('Arial','B',8);	
		$this->Cell(25,4,' ',0,0);
		$this->SetFont('Arial','',6);
		$this->Cell(180,4,$_SESSION['PDF_nombre_departamento_vmb'],0,1);
	
		$this->SetFont('Arial','B',6);
		$this->Cell(20,3,'ID','LTR',0,'C');
		$this->Cell(20,3,'ID','LTR',0,'C');
		$this->Cell(20,3,'ID','LTR',0,'C');
		$this->Cell(32,3,'IMPORTE','LTR',0,'C');
		$this->Cell(32,3,'IMPORTE','LTR',0,'C');
		$this->Cell(50,3,'DIFERENCIA','LTR',1,'C');	
		//$this->Cell(40,3,'','LBR',1,'C');
	
		$this->Cell(20,3,'COMPROBANTE','LBR',0,'C');
		$this->Cell(20,3,'PRESUPUESTO','LBR',0,'C');
		$this->Cell(20,3,'PARTIDA','LBR',0,'C');
		$this->Cell(32,3,'PRESUPUESTO','LBR',0,'C');
		$this->Cell(32,3,'CONTABILIDAD','LBR',0,'C');
		$this->Cell(50,3,' ','LBR',1,'C');		
		//$this->Cell(40,3,'','LBR',1,'C');
	}
	
	//Pie de página
	function Footer()
	{
	 	$fecha=date("d-m-Y");
		$hora=date("H:i:s");
		 $this->Cell(174,0.05,'',1,1);
	    $this->SetY(-15);
   	    $this->SetFont('Arial','',6);
   	   
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(20,3,'',0,0,'L');
		$this->Cell(20,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(50,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - CONIN',0,0,'L');
		$this->Cell(20,3,'',0,0,'L');
		$this->Cell(20,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
	  }
}

	$pdf=new PDF();
	$pdf->SetAutoPageBreak(true,7);
	$pdf->AliasNbPages();
	$pdf->AddPage();
		
	$pdf->SetWidths(array(20,20,20,32,32,50));
	$pdf->SetAligns(array('C','C','C','C','C','C'));
	$pdf->SetVisibles(array(1,1,1,1,1,1));
	$pdf->SetFontsSizes(array(6,6,6,6,6,6));
	$pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial'));
	$pdf->SetDecimales(array(0,0,0,0,0));
	$pdf->SetSpaces(array(3,3,3,3,3,3));
	$pdf->SetFormatNumber(array(0,0,0,0,0,0));
	

	$vcom_transa=$_SESSION['PDF_cierre_contable'];
	
	$tam_com_transa=count($vcom_transa);
	//for($j)
	for ($i=0;$i<$tam_com_transa;$i++){
		
	$pdf->MultiTabla($vcom_transa[$i],0,1,3,6,1);
	
	}
	//$pdf->Cell(210,0.025,'',1,1);

$pdf->Output();

?>