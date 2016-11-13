<?php
/* Autor: Ana Maria V.Q
 * Fecha de creación: 19/06/2009
 * Descripción: Reporte de Balances y Saldos
*/
session_start();

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
 
 //Cabecera
function Header()
{
	
$this->SetMargins(1,5,5);
$this->SetFont('Arial','B',14);
$this->Image('../../../lib/images/logo_reporte.jpg',170,2,35,15);
$this->SetXY(45,1);
$y_cab=$this->GetY();
$this->Cell(135,7,$_SESSION['desc_clases'],0,1,'C');
$this->SetFont('Arial','B',10);
//$this->SetXY(45,8);
$this->MultiCell(213,4,'BALANCE DE SUMAS Y SALDOS',0,'C');
$this->Cell (213,4,'Expresado en '.$_SESSION['PDF_desc_moneda_bss'],0,1,'C');

$this->Ln(2);
 
$cabecera[0][0]='Departamento:';
$cabecera[0][1]=$_SESSION['PDF_desc_dpto_conta_bss'];
$cabecera[0][2]='Gestion:';
$cabecera[0][3]=$_SESSION['PDF_gestion_bss'];

$cabecera[1][0]='Nivel:';
$cabecera[1][1]=$_SESSION['PDF_nivel_bss'];
$cabecera[1][2]='Fecha Fin:';
$cabecera[1][3]=$_SESSION['PDF_fecha_bss'];

/*$cabecera[2][0]='Moneda:';
$cabecera[2][1]=$_SESSION['PDF_desc_moneda_bss'];
$cabecera[2][2]='';
$cabecera[2][3]='';
*/


$this->SetWidths(array(18,135,20,41));

$this->SetVisibles(array(1,1,1,1));
$this->SetFonts(array('Arial','Arial','Arial','Arial'));
$this->SetFontsSizes(array(7,7,7,7));
$this->SetFontsStyles(array('B','','B',''));
$this->SetDecimales(array(0,0,0,0));
$this->SetFormatNumber(array(0,0,0,0));
$this->SetSpaces(array(3.5,3.5,3.5,3.5));



for ($o=0;$o<sizeof($cabecera);$o++){
  $this->MultiTabla($cabecera[$o],1,0,3.5,7,1);
 }
$this->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial')); 
$this->SetVisibles(array(1,1,1,1,1));
$this->SetFontsSizes(array(6,6,6,6,6,6));
$this->SetFontsStyles(array('','','','','',''));
$this->SetSpaces(array(3,3,3,3,3,3));
$this->SetWidths(array(30,93,30,30,30));
$this->SetDecimales(array(0,0,2,2,2));
$this->SetAligns(array('R','L','R','R','R'));

$this->SetFont('Arial','B',8);
//cabecera del detalle
$this->Cell(30,5,'NRO CUENTA','LTB',0,'C');
$this->Cell(93,5,'NOMBRE CUENTA',1,0,'C');
$this->Cell(30,5,'SUMA DEBE','TBL',0,'C');
$this->Cell(30,5,'SUMA HABER',1,0,'C');
$this->Cell(30,5,'SALDO',1,1,'C');
 

}
//Pie de página
function Footer()
{
$this->SetY(-7);
$fecha=date("d-m-Y");
	$hora=date("h:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - SCI',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
}


}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,7);
$pdf->SetMargins(1,5,5);

$balance_detalle_ss=$_SESSION['PDF_BalanceSSDetalle'];

for ($a=0;$a<sizeof($balance_detalle_ss);$a++){
	if($balance_detalle_ss[$a][5]==2){
		$pdf->SetFontsSizes(array(6,6,6,6,6));
       $pdf->SetFontsStyles(array('I','I','I','I','I'));
	}else{
		 $pdf->SetFontsStyles(array('','','','',''));
	}
	$pdf->Multitabla($balance_detalle_ss[$a],0,1,3,6);
	
}
$pdf->Cell(213,.05,'',1,1);

$pdf->Output();
?>

?> 