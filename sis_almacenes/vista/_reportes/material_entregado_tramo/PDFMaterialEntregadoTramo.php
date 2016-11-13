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
    //Iniciación de variables
    }
 
function Header()
{
   if($this->PageNo()==1){
	$this->Image('../../../../lib/images/logo_reporte.jpg',170,2,35,15);
	$this->SetFont('Arial','B',10);
    $this->Ln(10);
    }else {
    $this->Image('../../../../lib/images/logo_reporte.jpg',170,2,35,15);
    $this->Ln(5);
	$this->SetFont('Arial','B',10);
     $this->Cell(10,5,'Nº',1,0,'C');
    $this->Cell(25,5,'CODIGO',1,0,'C');
    $this->Cell(40,5,'NOMBRE',1,0,'C');
    $this->Cell(105,5,'DESCRIPCIÓN',1,0,'C');
    $this->Cell(20,5,'CANTIDAD',1,1,'C');
    }
    	
}
//Pie de página
function Footer()
 {  
 	
 		
 	
  $fecha=date("d-m-Y");
	$hora=date("h:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
   	    $this->Cell(200,0.2,'',1,1);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS -ALMIN',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
   
  }


}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf-> AddFont('Tahoma','','tahoma.php');
$pdf-> AddFont('Arial','','arial.php');

$pdf->SetMargins(10,10,10);
$pdf->SetFont('Arial','B',14);
$pdf->SetAutoPageBreak(true,7);

//Títulos de las columnas
$pdf->Cell(185,5,'MATERIAL ENTREGADO POR SOLICITANTE',0,1,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,5,'Gestión:',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(100,5,''.$_SESSION['PDF_gestion'],0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,5,'Fecha Desde:',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(100,5,''.$_SESSION['PDF_fecha_desde'],0,1,'L');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,5,'EP:',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(100,5,''.$_SESSION['PDF_codigo_ep'],0,0,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,5,'Fecha Hasta:',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(100,5,''.$_SESSION['PDF_fecha_hasta'],0,1,'L');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,5,'Almacén:',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(100,5,''.$_SESSION['PDF_desc_almacen'],0,1,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,5,'Almacén Lógico:',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(100,5,''.$_SESSION['PDF_desc_almacen_logico'],0,1,'L');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(35,5,'Tramo:',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(100,5,''.$_SESSION['PDF_desc_tramo'],0,1,'L');
$pdf->Ln(5);

    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(10,5,'Nº',1,0,'C');
    $pdf->Cell(25,5,'CODIGO',1,0,'C');
    $pdf->Cell(40,5,'NOMBRE',1,0,'C');
    $pdf->Cell(105,5,'DESCRIPCIÓN',1,0,'C');
    $pdf->Cell(20,5,'CANTIDAD',1,1,'C');
           
    
    
    
 $pdf->SetFont('Arial','',8);
$pdf->SetWidths(array(10,25,40,105,20));
$pdf->SetVisibles(array(1,1,1,1,1));
$pdf->SetAligns(array('R','L','L','L','R'));
$pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial'));
$pdf->SetFontsSizes(array(5,6,6,6,6));
$pdf->SetSpaces(array(3.5,3.5,3.5,3.5,3.5));
$pdf->SetDecimales(array(0,0,0,0,2));

$v_mat_ent_det=$_SESSION['PDF_material_entregado_detalle'];
$sum_total=0;
for ($i=0;$i<sizeof($v_mat_ent_det);$i++){
 	$numero=$i+1;
  //  $pdf->filaCuaCom1(array_merge((array)$numero,(array)$v_proceso_det[$i]),1,'L');
  $pdf->MultiTabla(array_merge((array)$numero,(array)$v_mat_ent_det[$i]),2,1,3.5,6);
  $sum_total=$sum_total+$v_mat_ent_det[$i][3]; 
 }
$pdf->Cell(200,0.2,'',1,1);
$pdf->SetFont('Arial','',8);
$pdf->Ln(5);

$pdf->Output();
?>