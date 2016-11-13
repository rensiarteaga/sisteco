<?php

session_start();

require('../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
class PDF extends FPDF
{   
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    //Iniciación de variables
    }
 var $widths;
 var $aligns;
function Header()
{
    $this->Image('../../../lib/images/logo_reporte.jpg',170,2,35,15);
   
}

function Footer()
{
   	
  $fecha=date("d-m-Y");
	$hora=date("h:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
   	    //$this->Cell(200,0.2,'',1,1);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS -TESORO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	

}
//Cabecera de página

}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,20);
$pdf-> AddFont('Tahoma','','tahoma.php');
$pdf-> AddFont('Arial','','arial.php');

//-----------------------Primera Factura

$pdf->SetFont('Tahoma','',10);
$pdf->SetLeftMargin(15);
$pdf->Cell(200,14,' ',0,1); 
$pdf->SetFont('Arial','B',8);
//$pdf->Cell(15,3.5,'',0,1);
;
$pdf->SetFont('Arial','BI',12);

$pdf->Cell(180,5,'RECIBO DE ENTREGA',0,1,'C'); 
$pdf->Cell(180,5,'DE FONDOS EN AVANCE',0,1,'C'); 
$pdf->Cell(200,2,' ',0,1); 
$pdf->ln(10);
$pdf->SetFont('Arial','B',10);

$pdf->Cell(60,5,'LUGAR','TLR',0,'C'); 
$pdf->Cell(60,5,'FECHA ','TLR',0,'C');
$pdf->Cell(60,5,'No','TLR',1,'C'); 

$pdf->SetFont('Arial','',10);
$pdf->Cell(60,5,$_SESSION['ss_nombre_lugar'],'BLR',0,'C'); 
$pdf->Cell(60,5,$_SESSION['PDF_fecha_avance'] ,'BLR',0,'C'); 
$pdf->Cell(60,5,$_SESSION['PDF_nro_avance'],'BLR',1,'C');
$y=$pdf->GetY();
$pdf->Line(15,$y,15,$y+25);
$pdf->Line(195,$y,195,$y+25); 
$unidad_orga=array();
 
 $unidad_orga[0][0]='UNIDAD ORGANIZACIONAL:';
 $unidad_orga[0][1]=$_SESSION['PDF_nombre_unidad'];
 $unidad_orga[0][2]='PROGRAMA:';
 $unidad_orga[0][3]=$_SESSION['PDF_nombre_programa'];
 
 $unidad_orga[1][0]='FINANCIADOR:';
 $unidad_orga[1][1]=$_SESSION['PDF_nombre_financiador'];
 $unidad_orga[1][2]='PROYECTO:';
 $unidad_orga[1][3]=$_SESSION['PDF_nombre_proyecto'];
 
 $unidad_orga[2][0]='REGIONAL:';
 $unidad_orga[2][1]=$_SESSION['PDF_nombre_regional'];
 $unidad_orga[2][2]='ACTIVIDAD:';
 $unidad_orga[2][3]=$_SESSION['PDF_nombre_actividad'];
 
     
 $pdf->SetFont('Arial','',10);
$pdf->SetWidths(array(35,55,25,65));
$pdf->SetVisibles(array(1,1,1,1));
$pdf->SetAligns(array('L','L','L','L'));
$pdf->SetFonts(array('Arial','Arial','Arial','Arial'));
$pdf->SetFontsStyles(array('B','','B',''));
$pdf->SetFontsSizes(array(10,10,10,10,10));
$pdf->SetSpaces(array(5,5,5,5,5));
//$pdf->SetDecimales(array(0,0,0,0,2));

for ($i=0;$i<sizeof($unidad_orga);$i++){
  $pdf->MultiTabla($unidad_orga[$i],1,0,5,10);
 }
 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'A FAVOR DE:','LBT',0,'L'); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(155,6,$_SESSION['PDF_nomb_empleado'],'RBT',1,'L'); 


$pdf->SetFont('Arial','B',10);
$pdf->Cell(140,10,'IMPORTE:','LB',0,'R');
$pdf->SetFont('Arial','',10); 
$pdf->Cell(40,10,number_format($_SESSION['PDF_importe_avance1'],2).'Bs','RB',1,'L'); 


$pdf->SetFont('Arial','B',10);
$pdf->Cell(180,5,'SON:','LR',1,'L');
$pdf->SetFont('Arial','',10); 
$pdf->MultiCell(180,5,'      '.$_SESSION['PDF_importe_avance_literal1'].'....Bolivianos','LRB',1,'L');


$pdf->SetFont('Arial','B',10);
$pdf->Cell(45,12,'ENTIDAD FINANCIERA:','L',0,'L');
$pdf->SetFont('Arial','',10); 
$pdf->Cell(45,12,$_SESSION['PDF_nombre_institucion'],0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(45,12,'NRO.CHEQUE',0,0,'L');
$pdf->SetFont('Arial','',10); 
$pdf->Cell(45,12,$_SESSION['PDF_nro_cheque'],'R',1,'L');

$pdf->Cell(60,5,'APROBADO POR:','TLR',0,'L'); 
$pdf->Cell(60,5,'RECIBI CONFORME:','TLR',0,'L');
$pdf->Cell(60,5,'ENTREGUE CONFORME:','TLR',1,'L'); 

$pdf->Cell(60,15,$_SESSION['PDF_nombre_completo'],'LR',0,'C'); 
$pdf->Cell(60,15,'','LR',0,'C');
$pdf->Cell(60,15,'','LR',1,'C');

$pdf->Cell(60,5,'','LR',0,'C'); 
$pdf->Cell(60,5,'__________________________','LR',0,'C');
$pdf->Cell(60,5,'__________________________','LR',1,'C');


$pdf->Cell(60,5,'','LRB',0,'C'); 
$pdf->Cell(60,5,$_SESSION['PDF_nomb_empleado'],'LRB',0,'C');
$pdf->Cell(60,5,$_SESSION['ss_nombre_usuario'],'LRB',1,'C');
 

$pdf->Output();
?>