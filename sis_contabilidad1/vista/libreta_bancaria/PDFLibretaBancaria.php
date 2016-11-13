<?php

session_start();

require('../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
$vcom_libreta_bancaria=$_SESSION['PDF_libreta_bancaria'];
$tam_libreta_bancaria=count($vcom_libreta_bancaria);



class PDF extends FPDF
{   
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    //Iniciación de variables
    }
	 //Cabecera
	 var $centro;
	 //var $aligns;
	 /*var $fill;
	 var $fill=0;*/
	 
	function SetCentro($centro)
	{
	    //Tableau des largeurs de colonnes
	    $this->centro=$centro;
	}
 
	function Header()
	{
		$this->SetMargins(10,5,5);
		$this->Image('../../../lib/images/logo_reporte.jpg',175,2,35,15);
		
		$this->SetFont('Arial','B',14);
		$this->Cell(0,5,'LIBRETA BANCARIA',0,1,'C');
		
		$this->SetFont('Arial','',7);
		$this->Cell(0,5,'Expresado en '.utf8_decode($_SESSION['PDF_desc_moneda']),0,1,'C');
		
		$this->SetFont('Arial','B',10);
		$this->Cell(15,4,'Cuenta:',0,0);
		
		$this->SetFont('Arial','',10);
		$this->MultiCell(175,4,$_SESSION['PDF_nombre_cuenta'],0);
		
		$this->SetFont('Arial','B',10);
		$this->Cell(10,4,'Del:',0,0);
		
		$fecha_inicio=$_SESSION['PDF_fecha_inicio'];
		$dia=substr($fecha_inicio,3,2);
		$mes=substr($fecha_inicio,0,2);
		$anio=substr($fecha_inicio,6,4);
		
		$fecha_inicial=$dia.'/'.$mes.'/'.$anio;
		
		$fecha_fin=$_SESSION['PDF_fecha_fin'];
		$dia_f=substr($fecha_fin,3,2);
		$mes_f=substr($fecha_fin,0,2);
		$anio_f=substr($fecha_fin,6,4);
		
		$fecha_final=$dia_f.'/'.$mes_f.'/'.$anio_f;
		
		
		
		
		
		
		$this->SetFont('Arial','',10);
		$this->Cell(25,4,$fecha_inicial,0,0);
		
		$this->SetFont('Arial','B',10);
		$this->Cell(10,4,'Al:',0,0);
		
		$this->SetFont('Arial','',10);
		$this->Cell(25,4,$fecha_final,0,1);
		
		$this->SetFont('Arial','B',7);
		$this->Cell(14,6,'Fecha','LTB',0);
		$this->Cell(15,6,'N° Cbte.','TB',0);
		$this->Cell(12,6,'N°Cheque','TB',0);
		$this->Cell(35,6,'   Beneficiario','TB',0);
		$this->Cell(60,6,' Concepto','TB',0);
		$this->Cell(20,6,' Deposito','TB',0);
		$this->Cell(20,6,' Cheque','TB',0);
		$this->Cell(25,6,' Saldo','TBR',1);
		
	}

	//Pie de página
	function Footer()
	{
		$fecha=date("d-m-Y");
		$hora=date("H:i:s");
	    $this->SetY(-10);
   	    $this->SetFont('Arial','',6);
   	    $this->Cell(201,0.1,'',1,1);
		$this->Cell(80,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		//$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(80,3,'Sistema: ENDESIS - CONIN',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		//$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
	}
}

$pdf=new PDF();
//esto es dependiendo si 
$pdf->SetAutoPageBreak(true,10);
$pdf->AliasNbPages();
$pdf->SetCentro($centro);
$pdf->AddPage();	

$pdf->SetWidths(array(0,14,15,12,35,60,20,20,0,25));
$pdf->SetAligns(array('L','L','L','L','L','L','R','R','R','R'));
$pdf->SetVisibles(array(0,1,1,1,1,1,1,1,0,1));
$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6));
$pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
$pdf->SetDecimales(array(0,0,0,0,0,0,2,2,2,2));
$pdf->SetFormatNumber(array(0,0,0,0,0,0,1,1,1,1));
$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3));

$vcom_transa=$_SESSION['PDF_libreta_bancaria'];
$tam_com_transa=count($vcom_transa);
$total_debe=0;
$total_haber=0;

for($j=0;$j<$tam_com_transa;$j++){
	$pdf->MultiTabla($vcom_transa[$j],0,1,3,6,1);
    $total_debe=$total_debe+$vcom_transa[$j][6];
    $total_haber=$total_haber+$vcom_transa[$j][7];	
}

$pdf->Cell(201,0.1,'',1,1);
$pdf->SetFont('Arial','',6);
$pdf->Cell(136,3,'TOTALES:',0,0,'R');
$pdf->Cell(20,3,number_format($total_debe,2),0,0,'R');
$pdf->Cell(20,3,number_format($total_haber,2),0,1,'R');
/*print_r ($vcom_transa[1]);
	exit;
*/if($mostrar_anulados=='true'){
	
$total_valor_anulado=0;
$pdf->Cell(136,5,'Cheques Anulados',0,1);
for($k=0;$k<$tam_com_transa;$k++){
	if ($vcom_transa[$k][11]!=0){
	$pdf->SetWidths(array(0,14,15,12,35,60,0,0,0,0,0,20));
	$pdf->SetAligns(array('L','L','L','L','L','L','R','R','R','R','R','R'));
	$pdf->SetVisibles(array(0,1,1,1,1,1,0,0,0,0,0,1));
	$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6));
	$pdf->MultiTabla($vcom_transa[$k],0,3,3,6,1);
	
    $total_valor_anulado=$total_valor_anulado+$vcom_transa[$k]['valor_anulado'];
	}
    
}
$pdf->SetFont('Arial','',6);
$pdf->Cell(136,3,'TOTALES ANULADOS:',0,0,'R');

$pdf->Cell(20,3,number_format($total_valor_anulado,2),0,1,'R');
$pdf->Cell(136,3,'TOTAL GENERAL:',0,0,'R');
$pdf->Cell(20,3,number_format($total_valor_anulado,2),0,1,'R');
}

$pdf->Output();

?>