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
    $this->Image('../../../lib/images/logo_reporte.jpg',170,8,35,15);
   
}

function Footer()
{
    //Posición: a 1,5 cm del final
$fecha="13-11-2009";
	$hora="11:16:03";
	    $this->SetY(-15);
   	    $this->SetFont('Arial','',6);
   	    //$this->Cell(70,3,sha1($_SESSION['PDF_num_solicitud'].$_SESSION['PDF_nombre_financiador'].$_SESSION['PDF_nombre_regional'].$_SESSION['PDF_nombre_programa'].$_SESSION['PDF_nombre_proyecto'].$_SESSION['PDF_nombre_actividad'].$_SESSION['PDF_fecha_juliana'].$_SESSION['PDF_monto_total']),0,0,'L');
		$this->ln(3);
   	    $this->Cell(70,3,'Usuario: LEMA BACARREZA PAULA ALEJANDRA',0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - TESORO',0,0,'L');
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
$pdf->Cell(200,24,' ',0,1); 
$pdf->SetFont('Arial','B',8);
//$pdf->Cell(15,3.5,'',0,1);
;
$pdf->SetFont('Arial','BI',12);

$pdf->Cell(180,5,'RECIBO PROVISIONAL DE ENTREGA',0,1,'C'); 
$pdf->Cell(180,5,'DE FONDOS EN EFECTIVO',0,1,'C'); 
$pdf->Cell(200,2,' ',0,1); 
$pdf->ln(10);
$pdf->SetFont('Arial','B',10);


/*$_SESSION['PDF_fecha'] = $f["fecha"];
				$_SESSION['PDF_hora']=$f["hora"];
				$_SESSION['PDF_numero']=$f["numero"];
				$_SESSION['PDF_caja']=$f["caja"];
				$_SESSION['PDF_cajero']=$f["cajero"];
				$_SESSION['PDF_unidad']=$f["unidad"].'';
				$_SESSION['PDF_empleado']=$f["empleado"];
				$_SESSION['PDF_importe_entregado']=$f["importe_entregado"];
				$_SESSION['PDF_concepto']=$f["concepto"];
				$_SESSION['PDF_importe_literal']=$f["importe_literal"];
				$_SESSION['PDF_nombre_completo']=$f["nombre_completo"];
				$_SESSION['PDF_lugar_sus']=$f["lugar_sus"];*/


$pdf->Cell(60,5,'LUGAR','TLR',0,'C'); 
$pdf->Cell(40,5,'FECHA ','TLR',0,'C');
$pdf->Cell(40,5,'HORA ','TLR',0,'C'); 
$pdf->Cell(40,5,'No','TLR',1,'C'); 

$pdf->SetFont('Arial','',10);



$pdf->Cell(60,5,$_SESSION['PDF_lugar_sus'],'BLR',0,'C'); 
$pdf->Cell(40,5,"13/11/2009",'BLR',0,'C'); 
$pdf->Cell(40,5,"11:16",'BLR',0,'C'); 
$pdf->Cell(40,5,$_SESSION['PDF_numero'],'BLR',1,'C');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'CAJA:','LB',0,'L'); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(155,6,$_SESSION['PDF_caja'],'RB',1,'L'); 

$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'CAJERO:','LB',0,'L');
$pdf->SetFont('Arial','',10); 
$pdf->Cell(155,6,$_SESSION['PDF_cajero'],'RB',1,'L'); 

$pdf->SetFont('Arial','B',10);
$pdf->Cell(50,10,'UNIDAD ORGANIZACIONAL:','LB',0,'L');
$pdf->SetFont('Arial','',10); 
$pdf->Cell(130,10,$_SESSION['PDF_unidad'],'RB',1,'L'); 


$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,12,'A FAVOR DE:','LB',0,'L');
$pdf->SetFont('Arial','',10); 
$pdf->Cell(150,12,$_SESSION['PDF_empleado'],'RB',1,'L'); 


$pdf->SetFont('Arial','B',10);
$pdf->Cell(140,12,'IMPORTE:','LB',0,'R');
$pdf->SetFont('Arial','',10); 
$pdf->Cell(40,12,$_SESSION['PDF_importe_entregado'].'....Bs','RB',1,'L'); 


$pdf->SetFont('Arial','B',10);
$pdf->Cell(180,12,'SON:','LR',1,'L');
$pdf->SetFont('Arial','',10); 
$pdf->MultiCell(180,12,'      '.$_SESSION['PDF_importe_literal'].'....Bolivianos','LRB',1,'L');


$pdf->SetFont('Arial','B',10);
$pdf->Cell(180,12,'CONCEPTO:','LR',1,'L');
$pdf->SetFont('Arial','',10); 
$pdf->MultiCell(180,12,'        '.$_SESSION['PDF_concepto'],'LRB',1,'L');

$pdf->SetFont('Arial','',8); 
$data=array("APROBADO POR:\n\n\n\n\n\n",
"RECIBI CONFORME:\n\n\n__________________________\n".$_SESSION['PDF_empleado'],
"ENTREGUE CONFORME:\n\n\n__________________________\n".$_SESSION['PDF_cajero']);

$pdf->SetFont('Arial','',8); 
	$pdf->SetWidths(array(60,60,60));
	$pdf->SetAligns(array('C','C','C'));
	$pdf->SetVisibles(array(1,1,1));
	$pdf->SetFontsSizes(array(8,8,8));
	$pdf->SetDecimales(array(0,0,0));

	 $pdf->MultiTabla($data,1,3);
 







//$pdf->Cell(45,5,'','TLR',0,'C');
//$pdf->Cell(95,5,'','TLR',0,'C');
//$pdf->Cell(45,5,'','TLR',0,'C');

//$pdf->SetFont('Arial','',10);
//$pdf->Cell(45,5,'___________________','LR',0,'C'); 
/*
$pdf->Cell(180,5,'________________________________','LR',1,'C'); 
//$pdf->Cell(85,5,'___________________','LR',1,'C'); 
//$pdf->Cell(45,5,'___________________','LR',1,'C'); 
//$pdf->Cell(45,5,'','LR',0,'C'); 
$pdf->Cell(180,5,''.$_SESSION['PDF_nombre_aprobacion'].'','LR',1,'C'); 
//$pdf->Cell(45,5,'-------','LR',0,'C'); 
//$pdf->Cell(85,5,''.$_SESSION['PDF_nombre_solicitante'].'','LR',1,'C'); 
$pdf->SetFont('Arial','B',10);
//$pdf->Cell(45,5,'Receptor Centro','LBR',0,'C'); 
$pdf->Cell(180,5,'Firma Autorizada','LBR',1,'C'); 
//$pdf->Cell(45,5,'Encargado de Almacenes','LBR',0,'C'); 
//$pdf->Cell(85,5,'Receptor de Material','LBR',1,'C'); 
*/
///////////////////////////////////fin de primera factura //////////////////////////////





$pdf->Output();
?>