<?php

session_start();

require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
define('FPDF_FONTPATH','font/');
class PDF extends FPDF
{   
	var $sep_decim='.';
	var $sep_mil=',';
	
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    //Iniciación de variables
    }
 
function Header()
{
	$this->SetDrawColor(190,190,190);
	$this->SetLineWidth(.1);
	$this->SetLeftMargin(10);
		
   if($this->PageNo()==1){
	$this->Image('../../../../lib/images/logo_reporte.jpg',15,14,35,13);
	$this->ln(10);
	$this->SetFont('Arial','',8);
	    $this->Cell(45,5,'','LRT',0,'L');
		$this->Cell(100,5,'','LRT',0,'L');
		$this->Cell(15,5,'Desde:','LT',0,'R');
		$this->SetFont('Arial','B',8);
		$this->Cell(35,5,$_SESSION['PDF_fecha_desde'],'RT',1,'C');
		
		$this->Cell(45,5,'','LR',0,'L');
		$this->SetFont('Arial','B',12);
		$this->Cell(100,5,'MATERIAL ENTREGADO POR SOLICITANTE','LR',0,'C');
		$this->SetFont('Arial','',8);
		$this->Cell(15,5,'Hasta:','L',0,'R');
		$this->SetFont('Arial','B',8);
		$this->Cell(35,5,$_SESSION['PDF_fecha_hasta'],'R',1,'C');
		
		$this->Cell(45,5,'','LRB',0,'L');
		$this->Cell(100,5,'','LRB',0,'L');
		$this->SetFont('Arial','',8);
		$this->Cell(15,5,'Página:','LB',0,'R');
		$this->SetFont('Arial','B',8);
		$this->Cell(35,5,$this->PageNo().' de {nb}','RB',1,'C');
		$this->ln(3);
    }else {
    $this->Image('../../../../lib/images/logo_reporte.jpg',15,14,35,13);
    $this->ln(10);
    $this->SetFont('Arial','',8);
	    $this->Cell(45,5,'','LRT',0,'L');
		$this->Cell(100,5,'','LRT',0,'L');
		$this->Cell(15,5,'Desde:','LT',0,'R');
		$this->SetFont('Arial','B',8);
		$this->Cell(35,5,$_SESSION['PDF_fecha_desde'],'RT',1,'C');
		
		$this->Cell(45,5,'','LR',0,'L');
		$this->SetFont('Arial','B',12);
		$this->Cell(100,5,'MATERIAL ENTREGADO POR SOLICITANTE','LR',0,'C');
		$this->SetFont('Arial','',8);
		$this->Cell(15,5,'Hasta:','L',0,'R');
		$this->SetFont('Arial','B',8);
		$this->Cell(35,5,$_SESSION['PDF_fecha_hasta'],'R',1,'C');
		
		$this->Cell(45,5,'','LRB',0,'L');
		$this->Cell(100,5,'','LRB',0,'L');
		$this->SetFont('Arial','',8);
		$this->Cell(15,5,'Página:','LB',0,'R');
		$this->SetFont('Arial','B',8);
		$this->Cell(35,5,$this->PageNo().' de {nb}','RB',1,'C');
    $this->Ln(5);
	
	$this->SetFont('Arial','B',8);
    $this->Cell(10,5,'Nº',1,0,'C');
   // $this->Cell(30,5,'CODIGO',1,0,'C');
    $this->Cell(35,5,'NOMBRE',1,0,'C');
    $this->Cell(95,5,'DESCRIPCIÓN',1,0,'C');
    $this->Cell(20,5,'PESO NETO',1,0,'C');
    $this->Cell(15,5,'UNIDAD',1,0,'C');
    $this->Cell(20,5,'CANTIDAD',1,1,'C');
	
    }
    	
}
//Pie de página
function Footer()
 {  
 	
 		
 	
  $fecha=date("d-m-Y");
	$hora=date("h:i:s");
	    $this->SetY(-10);
   	    $this->SetFont('Arial','',6);
   	    $this->Cell(195,0.2,'',1,1);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS -ALMIN',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
   
  }


}

//$pdf=new PDF();
$pdf=new PDF('P','mm','Letter');
$pdf->AddPage();
$pdf->AliasNbPages();
//$pdf-> AddFont('Tahoma','','tahoma.php');
//$pdf-> AddFont('Arial','','arial.php');

$pdf->SetMargins(10,10,10);
$pdf->SetDrawColor(190,190,190);
$pdf->SetLineWidth(.1);
$pdf->SetFont('Arial','B',14);
$pdf->SetAutoPageBreak(true,10);

//Títulos de las columnas
//$pdf->Cell(185,5,'MATERIAL ENTREGADO POR SOLICITANTE',0,1,'C');
//$pdf->Ln(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,5,'Gestión:',0,0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(72,5,''.$_SESSION['PDF_gestion'],0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(49,5,'Estruc. Programática:',0,0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(49,5,''.$_SESSION['PDF_codigo_ep'],0,1,'L');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,5,'Almacén:',0,0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(72,5,''.$_SESSION['PDF_desc_almacen'],0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(49,5,'Almacén Lógico:',0,0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(49,5,''.$_SESSION['PDF_desc_almacen_logico'],0,1,'L');


$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,5,'Solicitante:',0,0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(72,5,''.$_SESSION['PDF_solicitante'],0,0,'L');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(49,5,'Motivo Salida:',0,0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(49,5,''.$_SESSION['PDF_nombre_motivo_salida'],0,1,'L');
$pdf->Ln(5);

    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(10,5,'Nº',1,0,'C');
   // $pdf->Cell(30,5,'CODIGO',1,0,'C');
    $pdf->Cell(35,5,'NOMBRE',1,0,'C');
    $pdf->Cell(95,5,'DESCRIPCIÓN',1,0,'C');
    $pdf->Cell(20,5,'PESO NETO',1,0,'C');
    $pdf->Cell(15,5,'UNIDAD',1,0,'C');
    $pdf->Cell(20,5,'CANTIDAD',1,1,'C');
           
    
    
    
 $pdf->SetFont('Arial','',8);
$pdf->SetWidths(array(10,30,35,95,20,15,20));
$pdf->SetVisibles(array(1,0,1,1,1,1,1));
$pdf->SetAligns(array('C','L','L','L','R','C','R'));
$pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
$pdf->SetFontsSizes(array(5,6,6,6,6,6,6));
$pdf->SetSpaces(array(3.5,3.5,3.5,3.5,3.5,3.5,3.5));
$pdf->SetDecimales(array(0,0,0,0,5,0,2));

$v_mat_ent_det=$_SESSION['PDF_material_entregado_detalle'];
$sum_total=0;
for ($i=0;$i<sizeof($v_mat_ent_det);$i++){
 	$numero=$i+1;
  //  $pdf->filaCuaCom1(array_merge((array)$numero,(array)$v_proceso_det[$i]),1,'L');
  $pdf->MultiTabla(array_merge((array)$numero,(array)$v_mat_ent_det[$i]),2,3,3.5,6);
  $sum_total=$sum_total+$v_mat_ent_det[$i][3]; 
 }
$pdf->Cell(195,0.2,'',1,1);
$pdf->SetFont('Arial','',8);
$pdf->Ln(5);

$pdf->SetFont('Arial','B',6);
$pdf->Cell(105,5,'',0,0,'R');
$pdf->Cell(10,5,'Peso Total (Kg.)','B',0,'L');
$pdf->Cell(45,5,number_format($sum_total,6,'.',','),'B',1,'R');
$pdf->Line(115,$pdf->GetY()+0.6,170,$pdf->GetY()+0.6);

$pdf->Output();
?>