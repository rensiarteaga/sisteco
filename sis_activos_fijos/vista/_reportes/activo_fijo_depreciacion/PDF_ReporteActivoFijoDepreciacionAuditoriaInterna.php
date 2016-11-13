<?php
session_start();
/**
 * Autor: 
 * Fecha de creacion: 
 * Descripción:
 * **/

require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{    
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    	
	    $this->FPDF($orientation,$unit,$format);
	    $this-> AddFont('Arial','','arial.php');
	     
	    
    }   
    
	function Header()
	{
		$fecha=date("d-m-Y");	
	 
	 
		 $this->Image('../../../../lib/images/logo_reporte.jpg',180,2,35,15);
		 $this->Ln(5);
		 $this->SetFont('Arial','B',5);
		 $this->SetX(15);
		 $this->Ln(1.5); 
		
		 
		 $this->SetFont('Arial','B',7);
		 $this->Cell(0,6,'REPORTE DEPRECIACION ACTIVOS FIJOS 2012' ,0,1,'C');
		 
		 
		 $this->SetFont('Arial','B',5);
		 
		 $this->SetX(10);
		 $this->SetFillColor(230 , 230, 230);
		
		 $this->Cell(16,2,'CODIGO ACTIVO','LTR',0,'C',true);
		 $this->Cell(15,2,'VIDA UTIL','LTR',0,'C',true);
		 $this->Cell(15,2,'VALOR','LTR',0,'C',true);
		 $this->Cell(21,2,'ACTUALIZACION','LTR',0,'C',true);
		 $this->Cell(12,2,'VALOR','LTR',0,'C',true);
		 $this->Cell(20,2,'DEPRECIACION','LTR',0,'C',true);
		 $this->Cell(20,2,'ACTUALIZACION','LTR',0,'C',true);
		 $this->Cell(20,2,'DEPRECIACION','LTR',0,'C',true);
		 $this->Cell(20,2,'DEPRECIACION','LTR',0,'C',true);
		 $this->Cell(20,2,'DEPRECIACION','LTR',0,'C',true);
		 $this->Cell(15,2,'VALOR','LTR',1,'C',true);
		 
		 
		 $this->SetX(10);
		 
		 $this->Cell(16,2,'FIJO','LBR',0,'C',true);
		 $this->Cell(15,2,'','LBR',0,'C',true);
		 $this->Cell(15,2,'CONTABLE','LBR',0,'C',true);
		 $this->Cell(21,2,'','LBR',0,'C',true);
		 $this->Cell(12,2,'TOTAL','LBR',0,'C',true);
		 $this->Cell(20,2,'ACUMULADA','LBR',0,'C',true);
		 $this->Cell(20,2,'DEPRECIACION','LBR',0,'C',true);
		 $this->Cell(20,2,'ACUMULADA ACT ','LBR',0,'C',true);
		 $this->Cell(20,2,'PERIODO','LBR',0,'C',true);
		 $this->Cell(20,2,'ACUMULADA','LBR',0,'C',true);
		 $this->Cell(15,2,'TOTAL','LBR',1,'C',true);
		 
		 
	}

	//Pie de página
	function Footer()
	{
	    //Posición: a 1,5 cm del final
	    $fecha=date("d-m-Y");
		$hora=date("H:i:s");
		$this->SetY(-7);
	   	$this->SetFont('Arial','',5);
	   	//$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
	   	$this->Cell(70,3,'Usuario: '."VELASCO ZARATE JAVIER LORENZO",0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(65,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'R');
		$this->ln(3);
		$this->Cell(100,3,'Sistema: ENDESIS - ACTIF',0,0,'L');
		$this->Cell(70,3,'',0,0,'C');
		$this->Cell(62,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	        
     }
}

$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,7);
$pdf->SetMargins(10,5,5);
	    
$pdf->AddPage(); 
	    
$pdf->SetFont('Arial','',5);
$pdf->SetWidths(array(0,0,0,16,15,15,21,12,20,20,20,20,20,15));
$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0));
$pdf->SetVisibles(array(0,0,0,1,1,1,1,1,1,1,1,1,1,1));
$pdf->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5,5,5,5,5));
$pdf->SetAligns(array('L','R','R','R','R','R','R','R','R','R','R','R','R','R'));
$pdf->SetFontsStyles(array('','','','','','','','','','','','','',''));
$pdf->SetDecimales(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0));
$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3));
$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0));

$det_af = $_SESSION["PDF_reporte_depreciacion_nuevo2"];

$cont = count($det_af);
$valor_contable=0;
$actualizacion=0;
$valor_total=0;
$dep_acum_ini=0;
$act_dep=0;
$dep_acum_act=0;
$dep_periodo=0;
$dep_acum=0;
$valor_neto=0;

for($j=0;$j<$cont;$j++)
 {
 	
 	$pdf->SetX(10);
 	
 	$valor_contable+=$det_af[$j][5];
 	$actualizacion+=$det_af[$j][6];
 	$valor_total+=$det_af[$j][7];
 	$dep_acum_ini+=$det_af[$j][8];
 	$act_dep+=$det_af[$j][9];
 	$dep_acum_act+=$det_af[$j][10];
 	$dep_periodo+=$det_af[$j][11];
 	$dep_acum+=$det_af[$j][12];
 	$valor_neto+=$det_af[$j][13];
 	
 	
    $pdf->MultiTabla($det_af[$j],0,3,3,6);
     
    if($pdf->GetY() >= 250 )
    {
    	 $pdf->SetFont('Arial','B',5);
    	 $pdf->Cell(16,4,'','LBT',0,'R',false);
		 $pdf->Cell(15,4,'','BRT',0,'R',false);
		 $pdf->Cell(15,4,$valor_contable,'LBRT',0,'R',false);
		 $pdf->Cell(21,4,$actualizacion,'LBRT',0,'R',false);
		 $pdf->Cell(12,4,$valor_total,'LBRT',0,'R',false);
		 $pdf->Cell(20,4,$dep_acum_ini,'LBRT',0,'R',false);
		 $pdf->Cell(20,4,$act_dep,'LBRT',0,'R',false);
		 $pdf->Cell(20,4,$dep_acum_act,'LBRT',0,'R',false);
		 $pdf->Cell(20,4,$dep_periodo,'LBRT',0,'R',false);
		 $pdf->Cell(20,4,$dep_acum,'LBRT',0,'R',false);
		 $pdf->Cell(15,4,$valor_neto,'LBRT',1,'R',false);
		 
		 $pdf->AddPage();
    } 

   
 }
 
 if($pdf->GetY() < 250){
	 $pdf->SetFont('Arial','B',5);
	 $pdf->Cell(16,4,'','LBT',0,'R',false);
	 $pdf->Cell(15,4,'','BRT',0,'R',false);
	 $pdf->Cell(15,4,$valor_contable,'LBRT',0,'R',false);
	 $pdf->Cell(21,4,$actualizacion,'LBRT',0,'R',false);
	 $pdf->Cell(12,4,$valor_total,'LBRT',0,'R',false);
	 $pdf->Cell(20,4,$dep_acum_ini,'LBRT',0,'R',false);
	 $pdf->Cell(20,4,$act_dep,'LBRT',0,'R',false);
	 $pdf->Cell(20,4,$dep_acum_act,'LBRT',0,'R',false);
	 $pdf->Cell(20,4,$dep_periodo,'LBRT',0,'R',false);
	 $pdf->Cell(20,4,$dep_acum,'LBRT',0,'R',false);
	 $pdf->Cell(15,4,$valor_neto,'LBRT',1,'R',false);
 }

$pdf->Output();
?>