<?php

session_start();

require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
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
	    $this->SetDrawColor(190,190,190);
		$this->SetLineWidth(.1);
		$this->SetLeftMargin(10);
		
	// establecemos el idioma de la página
		setlocale (LC_TIME,"spanish", "es_ES@euro", "es_ES", "es");
		//creamos la cadena con los especificadores necesarios
		$formato = "%d de %B de %Y";
		//$formato = "%A, %d de %B de %Y";
		
		$fechad=$_SESSION["PDF_fecha_desde"];

		$mes = substr($fechad, 0, 2);
		$dia = substr($fechad, 3, 2);
		$anio = substr($fechad, -4);
		$fechad=$dia.'-'.$mes.'-'.$anio;
		//Mostramos la fecha, ahora sí en el idioma deseado.
		$fechad=strftime($formato, strtotime($fechad));

		$fechah=$_SESSION["PDF_fecha_hasta"];

		$mes = substr($fechah, 0, 2);
		$dia = substr($fechah, 3, 2);
		$anio = substr($fechah, -4);
		$fechah=$dia.'-'.$mes.'-'.$anio;

		//Mostramos la fecha, ahora sí en el idioma deseado.
		$fechah=strftime($formato, strtotime($fechah));
		
	
	
	if($this->PageNo()==1){
	$this->Image('../../../../lib/images/logo_reporte.jpg',15,14,35,13);
	$this->ln(10);
		$this->SetFont('Arial','',8);
		$this->Cell(45,5,'','LRT',0,'L');
		$this->Cell(100,5,'','LRT',0,'L');
		$this->Cell(15,5,'Desde:','LT',0,'R');
		$this->SetFont('Arial','B',8);
		$this->Cell(35,5,$fechad,'RT',1,'C');
		
		$this->Cell(45,5,'','LR',0,'L');
		$this->SetFont('Arial','B',12);
		$this->Cell(100,5,'ENTREGA DE UNIDADES CONSTRUCTIVAS','LR',0,'C');
		$this->SetFont('Arial','',8);
		$this->Cell(15,5,'Hasta:','L',0,'R');
		$this->SetFont('Arial','B',8);
		$this->Cell(35,5,$fechah,'R',1,'C');
		
		$this->Cell(45,5,'','LRB',0,'L');
		$this->Cell(100,5,'','LRB',0,'L');
		$this->SetFont('Arial','',8);
		$this->Cell(15,5,'Página:','LB',0,'R');
		$this->SetFont('Arial','B',8);
		$this->Cell(35,5,$this->PageNo().' de {nb}','RB',1,'C');
		$this->ln(3);	
	
    }else {
    $this->Image('../../../../lib/images/logo_reporte.jpg',15,14,35,13);
    $this->SetFont('Arial','',8);
    $this->ln(10);
		$this->Cell(45,5,'','LRT',0,'L');
		$this->Cell(100,5,'','LRT',0,'L');
		$this->Cell(15,5,'Desde:','LT',0,'R');
		$this->SetFont('Arial','B',8);
		$this->Cell(35,5,$fechad,'RT',1,'C');
		
		$this->Cell(45,5,'','LR',0,'L');
		$this->SetFont('Arial','B',12);
		$this->Cell(100,5,'ENTREGA DE UNIDADES CONSTRUCTIVAS','LR',0,'C');
		$this->SetFont('Arial','',8);
		$this->Cell(15,5,'Hasta:','L',0,'R');
		$this->SetFont('Arial','B',8);
		$this->Cell(35,5,$fechah,'R',1,'C');
		
		$this->Cell(45,5,'','LRB',0,'L');
		$this->Cell(100,5,'','LRB',0,'L');
		$this->SetFont('Arial','',8);
		$this->Cell(15,5,'Página:','LB',0,'R');
		$this->SetFont('Arial','B',8);
		$this->Cell(35,5,$this->PageNo().' de {nb}','RB',1,'C');
    $this->Ln(5);
    
    
    
	$this->SetFont('Arial','B',10);
    $this->Cell(10,5,'Nº',1,0,'C');
    $this->Cell(25,5,'CODIGO',1,0,'C');
    $this->Cell(50,5,'NOMBRE',1,0,'C');
    $this->Cell(90,5,'DESCRIPCIÓN',1,0,'C');
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
		$this->Cell(55,3,'',0,0,'L');
		$this->Cell(20,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - ALMIN',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(55,3,'',0,0,'L');
		$this->Cell(20,3,'Hora: '.$hora,0,0,'L');	
   
}


}

//$pdf=new PDF();
$pdf=new PDF('P','mm','Letter');
$pdf->AddPage();
$pdf->AliasNbPages();
//$pdf-> AddFont('Arial','','arial.php');
$pdf->SetTopMargin(15);

$pdf->SetDrawColor(190,190,190);
$pdf->SetLineWidth(.1);

//$pdf->SetMargins(10,10,10);
$pdf->SetFont('Arial','B',14);
$pdf->SetAutoPageBreak(true,15); 


$pdf->SetFont('Arial','B',10);
$pdf->Cell(45,5,'Estruc.Programática:',0,0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(150,5,''.$_SESSION['PDF_codigo_ep'],0,1,'L');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(45,5,'Almacén Físico:',0,0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(150,5,''.$_SESSION['PDF_desc_almacen'],0,1,'L');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(45,5,'Almacén Lógico:',0,0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(150,5,''.$_SESSION['PDF_desc_almacen_logico'],0,1,'L');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(45,5,'Solicitante:',0,0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(150,5,''.$_SESSION['PDF_solicitante'],0,1,'L');
$pdf->Ln(5);

    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(10,5,'Nº',1,0,'C');
    $pdf->Cell(25,5,'CODIGO',1,0,'C');
    $pdf->Cell(50,5,'NOMBRE',1,0,'C');
    $pdf->Cell(90,5,'DESCRIPCIÓN',1,0,'C');
    $pdf->Cell(20,5,'CANTIDAD',1,1,'C');
           
    
    
    
 $pdf->SetFont('Arial','',8);
$pdf->SetWidths(array(10,25,50,90,20));
$pdf->SetVisibles(array(1,1,1,1,1));
$pdf->SetAligns(array('C','L','L','L','R'));
$pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial'));
$pdf->SetFontsSizes(array(5,6,6,6,6));
$pdf->SetSpaces(array(3.5,3.5,3.5,3.5,3.5));
$pdf->SetDecimales(array(0,0,0,0,0));

$v_mat_ent_det=$_SESSION['PDF_material_entregado_detalle'];
$sum_total=0;
for ($i=0;$i<sizeof($v_mat_ent_det);$i++){
 	$numero=$i+1;
   $pdf->MultiTabla(array_merge((array)$numero,(array)$v_mat_ent_det[$i]),2,3,3.5,6);
  $sum_total=$sum_total+$v_mat_ent_det[$i][3]; 
 }
$pdf->Cell(195,0.2,'',1,1);
$pdf->SetFont('Arial','',8);
$pdf->Ln(5);

$pdf->Output();
?>