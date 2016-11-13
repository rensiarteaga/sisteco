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
    $this-> AddFont('Arial','','arial.php');
    //Iniciación de variables
    }
 
function Header()
{  $this->Image('../../../../lib/images/logo_reporte.jpg',170,2,35,15);
	$this->SetFont('Arial','BI',14);
	$this->SetY(15);
		$this->Cell(180,5,'SOLICITUD DE PAGO DE OBLIGACIONES',0,0,'C'); 
		
    $this->ln(3);
    $this->SetFont('Arial','',8);
   //	$this->Cell(190,5,$_SESSION['PDF_codigo'].'-'.$_SESSION['PDF_gestion'],0,1,'R');
   	 	
   	
}
//Pie de página
function Footer()
{
   /* $fecha=date("d-m-Y");
	$hora=date("h:i:s");
	
	*/ 
$this->SetLeftMargin(10);
   $this->SetY(-9);
   	$this->pieHash('KARDEX');
	    
   	   /* $this->SetFont('Arial','',6);
   	    $this->ln(3);
   	    $this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
     	$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - KARDEX',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,sha1(gregoriantojd(date('m'),date('d'),date('Y')).$hora),0,0,'L');*/
		
     }

//Cabecera de página

}




//-----------------------Definición de variables

$pdf=new PDF();
//$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetLeftMargin(20);
$pdf->SetTopMargin(38);
$pdf->SetAutoPageBreak(true,20.5);
$pdf->SetFont('Arial','B',12);
$pdf->AddPage();
 
$v_cabecera=$_SESSION['PDF_sol_pago_obligaciones'];
 
	

$cab_obs_obliga=$v_cabecera[0]['observaciones'];
$cab_concepto=$v_cabecera[0]['obs_planilla'];
$cab_fecha_pago=$v_cabecera[0]['fecha_pago'];
$cab_tipo_pago=$v_cabecera[0]['tipo_pago'];
$cab_obs_pago=$v_cabecera[0]['obs_pago'];
$cab_monto=$v_cabecera[0]['monto'];
$cab_moneda=$v_cabecera[0]['moneda'];
$cab_acreedor=$v_cabecera[0]['acreedor'];
		$pdf->SetFont('Arial','',10);
		$pdf->Ln(5);
		$pdf->MultiCell(185,5,'Agracederemos proceder con la emisión de una Orden de Pago, de acuerdo con la siguiente información:',0);
		
		$pdf->ln(5);
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Descripción :',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,$cab_obs_obliga,0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Concepto:',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,$cab_concepto,0);
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Acreedor: ',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,$cab_acreedor,0);
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Fecha de Pago: ',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,$cab_fecha_pago,0);
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Forma de Pago:',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,$cab_tipo_pago,0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Observaciones de Pago',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,$cab_obs_pago,0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(130,5,'Importe ('.$cab_moneda.'):   ',0,0,'R');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(45,5,number_format($cab_monto,2),0,1,'R');
		
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(130,5,'Líquido Pagable ('.$cab_moneda.'):   ',0,0,'R');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(45,5,number_format($cab_monto,2),0,1,'R');
		
		$pdf->ln(10);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(180,5,'DETALLE DE APROPIACIÓN',0,1,'C'); 
		
		$detalle=array();
		$detalle=$_SESSION['PDF_EP_solicitud_pago_obligacion'];
		
		 $pdf->SetFillColor(200,200,200);
		$pdf->SetDrawColor(255,255,255);
		$pdf->SetLineWidth(0.5);

		
		$detalle= $_SESSION['PDF_detalle_pago_ep'];
		
foreach ($detalle as $linea){
	$pdf->ln(5);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetLineWidth(0.2);
	$pdf->Cell(190,0,'','T',1,'C');
	$pdf->SetDrawColor(255,255,255);
	$pdf->ln(5);
	
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(25,4,'Unidad Organizacional:',0,0);
	$pdf->SetFont('Arial','',6);
	$y=$pdf->GetY();
	$pdf->MultiCell(70,4,''.$linea['nombre_unidad'].'',1,'L',1); 
	
	$pdf->SetXY(115,$y);
	
	
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(25,4,'Programa:',0,0);
	$pdf->SetFont('Arial','',6);
	$pdf->MultiCell(70,4,''.$linea['nombre_programa'].'',1,'L',1);
	
	
	
	
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(25,4,'Regional:',0,0); 
	$pdf->SetFont('Arial','',6);
	$y=$pdf->GetY();
	$pdf->MultiCell(70,4,''.$linea['nombre_regional'].'',1,'L',1);
	$pdf->SetXY(115,$y);
	
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(25,4,'Sub-programa/Proyecto:',0,0);
	$pdf->SetFont('Arial','',6);
	$pdf->MultiCell(70,4,''.$linea['nombre_proyecto'].'',1,'L',1);
	
	
	
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(25,4,'Financiador:',0,0); 
	$pdf->SetFont('Arial','',6);
	$y=$pdf->GetY();
	$pdf->MultiCell(70,4,''.$linea['nombre_financiador'].'',1,'L',1);
	
	
	$pdf->SetXY(115,$y);
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(25,4,'Actividad:',0,0);
	$pdf->SetFont('Arial','',6);
	$pdf->MultiCell(70,4,''.$linea['nombre_actividad'].'',1,'L',1); 
	
	
	
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(25,4,'',0,0); 
	$pdf->SetFont('Arial','',6);
	$y=$pdf->GetY();
	$pdf->MultiCell(70,4,'',1,'L',1);
	
	
	$pdf->SetXY(115,$y);
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(25,4,'Importe:',0,0);
	$pdf->SetFont('Arial','',6);
	$pdf->MultiCell(70,4,''.number_format($cab_monto,2),1,'L',1); 
	
}
$pdf->SetFont('Arial','',10); 	   
/*$y=$pdf->GetY();
$posy1=$y;
*/
$firma=array("\n\n\n\n____________________________"."\n"."Jefe Departamento Recursos Humanos");
$data[0][0]=$firma;
$pdf->SetFont('Arial','',8); 
$pdf->SetWidths(array(195));
$pdf->SetAligns(array('C'));
$pdf->SetVisibles(array(1));
$pdf->SetFontsSizes(array(10));
$pdf->SetSpaces(array(4));
$pdf->SetDecimales(array(0));
$pdf->MultiTabla($data[0][0],1,0,4,10);
$pdf->Output();

?>