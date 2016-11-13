<?php
/**
 * Autor :              Ana Maria Villegas Quispe
 * Descripcion:         Reporte de Rendicion de Pago de Cajas
 * Ultima Modificacion: 25/11/2009
 */
session_start();

require('../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
include_once("../../control/LibModeloTesoreria.php");
/**
 * 
 */
class PDF extends FPDF
{   
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    $this-> AddFont('Arial','','arial.php');
    //Iniciación de variables
    }
 var $widths;
 var $aligns;
function Header()
{
    $this->Image('../../../lib/images/logo_reporte.jpg',170,8,35,15);
     $this->ln(20);
   
}

function Footer()
{
   //Posición: a 1,5 cm del final
$fecha=date("d-m-Y");
	$hora=date("h:i:s");
	    $this->SetY(-15);
   	    $this->SetFont('Arial','',6);
   	    $this->ln(3);
   	    $this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
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
$pdf->SetLeftMargin(15);
$pdf->SetFont('Arial','BI',12);

$estado=$_SESSION['PDF_estado'];
$pdf->Cell(0,5,'RECIBO DE PAGO ',0,1,'C'); 
if ($estado=='borrador' || $estado=='pagado'){
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(0,5,'(Vista Previa)',0,1,'C');
}
$pdf->Cell(200,2,' ',0,1); 
$pdf->ln(10);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(50,5,'LUGAR','TLR',0,'C'); 
$pdf->Cell(30,5,'FECHA ','TLR',0,'C');
$pdf->Cell(30,5,'MONEDA ','TLR',0,'C'); 
$pdf->Cell(80,5,'No','TLR',1,'C'); 

$pdf->SetFont('Arial','',8);

$pdf->Cell(50,5,$_SESSION['PDF_nombre_lugar'],'BLR',0,'C'); 
$pdf->Cell(30,5,$_SESSION['PDF_fecha'],'BLR',0,'C'); 
$pdf->Cell(30,5,$_SESSION['PDF_nombre_moneda'],'BLR',0,'C'); 
$pdf->Cell(80,5,$_SESSION['PDF_nro_documento'],'BLR',1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(25,6,'CAJA:','LB',0,'L'); 
$pdf->SetFont('Arial','',8);
$pdf->Cell(165,6,$_SESSION['PDF_caja'],'RB',1,'L'); 

$pdf->SetFont('Arial','B',8);
$pdf->Cell(25,6,'CAJERO:','LB',0,'L');
$pdf->SetFont('Arial','',8); 
$pdf->Cell(165,6,$_SESSION['PDF_cajero'],'RB',1,'L'); 

$pdf->SetFont('Arial','B',8);
$pdf->Cell(30,12,'CONTRATISTA:','LB',0,'L');
$pdf->SetFont('Arial','',8); 
$pdf->Cell(160,12,$_SESSION['PDF_empleado'],'RB',1,'L'); 


$pdf->SetFont('Arial','B',8);
$pdf->Cell(25,6,'CONCEPTO:','LB',0,'L');
$pdf->SetFont('Arial','',8); 
$pdf->Cell(165,6,$_SESSION['PDF_motivo'],'RB',1,'L'); 


$suma=0;
$pdf->SetFont('Arial','B',8);
$solicitud_detalle=$_SESSION["PDF_recibo_pago_det"];
$pdf->SetFont('Arial','B',7);
$pdf->Cell(80,3,'CONCEPTO ',1,0,'C');  
$pdf->Cell(85,3,'PRESUPUESTO ',1,0,'C');  
$pdf->Cell(25,3,'TOTAL ',1,1,'C');  
/*$pdf->Cell(25,3,'RETENCION ',1,0,'C');  
$pdf->Cell(25,3,'LIQUIDO',1,1,'C');  
/* configuracion de la tabla */ 
$pdf->SetWidths(array(0,80,85,25));
$pdf->SetFills(array(0,0,0,0));
$pdf->SetAligns(array('L','L','L','R'));
$pdf->SetVisibles(array(0,1,1,1));
$pdf->SetFontsSizes(array(6,6,6,6));
$pdf->SetFontsStyles(array('','','',''));
$pdf->SetDecimales(array(0,0,0,2));
$pdf->SetSpaces(array(3,3,3,3));
$pdf->SetFormatNumber(array(0,0,0,1));
//$total_importe_solicitado=0;
$total_importe_entregado=0;
for ($i=0;$i<sizeof($solicitud_detalle);$i++){
	$pdf->MultiTabla($solicitud_detalle[$i],0,3,3,6,1);
	//$total_importe_solicitado=$total_importe_solicitado+$solicitud_detalle[$i][3];
	$total_importe_entregado=$total_importe_entregado+$solicitud_detalle[$i][5];
   	}
 /*$pdf->SetFont('Arial','',6);
 $pdf->Cell(165,5,'TOTAL','RLB',0,'R');
 //$pdf->Cell(20,5,number_format($total_importe_solicitado,2),1,0,'R');
 $pdf->Cell(25,5,number_format($total_importe_entregado,2),1,1,'R');*/
 //$pdf->Cell(105,5,'','RLB',1,'R');
 /*$_SESSION['PDF_retencion'] = $f["retencion"];
				$_SESSION['PDF_importe_total'] = $f["importe_total"];
				$_SESSION['PDF_importe_rendicion'] = $f["importe_rendicion"];*/
$pdf->SetFont('Arial','B',7);
$pdf->Cell(165,3,"TOTAL:",'L',0,'R');
$pdf->Cell(25,3,$_SESSION['PDF_importe_total'],'R',1,'R');  
$pdf->Cell(165,3,"RETENCION:",'L',0,'R');
$pos_y=$pdf->GetY();

$pdf->MultiCell(25,3, $_SESSION['PDF_retencion'],'R','R');  

$pdf->Cell(165,3,"LIQUIDO:",'L',0,'R');
$pdf->Line(15,$pos_y,15,$pdf->GetY());
$pdf->Cell(25,3,$_SESSION['PDF_importe_rendicion'],'R',1,'R');  
$pdf->SetFont('Arial','',8); 


$pdf->SetFont('Arial','B',8); 
$pdf->Cell(190,5,"SON:",'LTR',1,'L');
$pdf->SetFont('Arial','',8); 
$pdf->Cell(5,5,'','LB',0);
//$pdf->Cell(185,5$_SESSION['PDF_importe_literal'],$pdf->num2letras($_SESSION['PDF_importe_rendicion'],false).' '.$_SESSION['PDF_nombre_moneda'],'RB',1,'L');  
$pdf->Cell(185,5,$_SESSION['PDF_importe_literal'].' '.$_SESSION['PDF_nombre_moneda'],'RB',1,'L');  
/* firmas */
$pdf->SetFont('Arial','',8); 
$data=array("APROBADO POR:\n\n\n__________________________\n".$_SESSION['PDF_aprobador'],
			"RECIBI CONFORME:\n\n\n__________________________\n".$_SESSION['PDF_empleado'],
			"ENTREGUE CONFORME:\n\n\n__________________________\n".$_SESSION['PDF_cajero']);
$pdf->SetFont('Arial','',8); 
$pdf->SetWidths(array(70,60,60));
$pdf->SetAligns(array('C','C','C'));
$pdf->SetVisibles(array(1,1,1));
$pdf->SetFontsSizes(array(8,8,8));
$pdf->SetSpaces(array(4,4,4));
$pdf->SetDecimales(array(0,0,0));
	 $pdf->MultiTabla($data,1,3,4,8);


$pdf->Output();
?>
