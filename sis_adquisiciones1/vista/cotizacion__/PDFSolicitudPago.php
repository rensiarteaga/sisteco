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
 
function Header()
{  $this->Image('images/medio.jpg',35,0,170,35);
    $this->Image('images/izquierda.jpg',0,5,35,35);
    $this->Image('images/barra.jpg',32,0,1,300);
    $this->SetXY(52,27);
   	$this->Cell(55,5,''.$_SESSION['ss_nombre_lugar'].'',0,0,'L');
   	$this->Cell(18,5,' ',0,0,'L');
   	$this->Cell(28,5,date('d/m/Y'),0,0,'L');
   	$this->Cell(5,5,'',0,0,'L');
   	if($_SESSION['PDF_tipo_adq']=='Bien'){
   		$this->Cell(40,5,'CB-'.$_SESSION['PDF_num_proceso'].'-'.$_SESSION['PDF_gestion'],0,1,'R');
   	}else{
   		$this->Cell(40,5,'CS-'.$_SESSION['PDF_num_proceso'].'-'.$_SESSION['PDF_gestion'],0,1,'R');
   	}
   	
}
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-25);
    //Arial italic 8
    $this->SetFont('Arial','',7);
    //Número de página
    //$pdf->Ln(5);
    $this->SetFillColor(0,0,0);
		
}

//Cabecera de página

}




//-----------------------Definición de variables

$pdf=new PDF();
//$pdf->AddPage();
$pdf->AliasNbPages();
$pdf-> AddFont('Arial','','arial.php'); 	
$pdf->SetLeftMargin(35);
$pdf->SetTopMargin(38);
$pdf->SetAutoPageBreak(true,20.5);
$pdf->SetFont('Arial','B',12);
$pdf->AddPage();


$proveedor =$_SESSION['PDF_proveedor'];

$codigo_proceso=$_SESSION['PDF_codigo_proceso'];
$solicitante=$_SESSION['PDF_solicitante'];
$unidad_organizacional=$_SESSION['PDF_unidad_organizacional'];
$descripcion_sol=$_SESSION['PDF_descripcion_sol'];
$monto=$_SESSION['PDF_monto'];
$forma_pago=$_SESSION['PDF_forma_pago'];

$num_factura=$_SESSION['PDF_num_factura'];
$lugar_entrega=$_SESSION['PDF_lugar_entrega'];
$nivel_aprobacion=$_SESSION['PDF_nivel_aprobacion'];
$desc=$_SESSION['PDF_descrip'];
$lugar=$_SESSION['ss_nombre_lugar'];
$monto_literal =$_SESSION['PDF_monto_literal'];
$nro_cuota=$_SESSION['PDF_nro_cuota'];
$observaciones=$_SESSION['PDF_observaciones_pago'];


 	$pdf->SetFont('Arial','B',10);
 	    $pdf->Cell(15,10,'DE:',0,0);
 	    $pdf->Cell(5,10,'',0,0);
		$pdf->Cell(20,10,'LIC. '.$_SESSION['PDF_jefe_depto_bienes'].'-'.$_SESSION['PDF_cargo_depto_bienes'],0,1,'L');//,'LR',0,'C');
		$pdf->Cell(15,10,'A:',0,0);
		$pdf->Cell(5,10,'',0,0);
		$pdf->Cell(150,10,'LIC. '.$_SESSION['PDF_jefe_depto_contabilidad'].'-'.$_SESSION['PDF_cargo_depto_contabilidad'],0,1,'L');//,'LR',0,'C');
		$pdf->Cell(20,10,'ASUNTO: ',0,0);
		$pdf->SetFont('Arial','BU',10);
		$pdf->Cell(100,10,'SOLICITUD DE PAGO A '.$proveedor.','.$codigo_proceso.'',0,1,'L');
		$pdf->Ln(5);
		/*$pdf->SetFont('Arial','B',10);
		$pdf->Cell(120,10,'ANTECEDENTES',0,1,'L');
		*///$pdf->SetX(130);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(185,5,'Agracederemos proceder con la emisión de una Orden de Pago, de acuerdo con la siguiente información:',0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Solicitante:',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,$solicitante,0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Centro Solicitante:',0,0);
		$pdf->SetFont('Arial','B',10);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,$unidad_organizacional,0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Nºde Orden de '.$desc.':',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,$codigo_proceso,0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Descripción de '.$desc.':',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,$descripcion_sol,0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Proveedor:',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,$proveedor,0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Nº Cuota: ',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(45,5,"".$_SESSION['PDF_nro_cuota']." ",0,1);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Monto:',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,'Bs '.$monto.' ('.$monto_literal.')',0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Forma de Pago:',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,$forma_pago,0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Nº de Factura',0,0);
		$pdf->SetFont('Arial','',10);
		
		if($num_factura>0){
		  $pdf->MultiCell(120,5,$num_factura.' ',0);
		}else{
		  $pdf->MultiCell(120,5,'contra entrega',0);
		}
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Lugar de Entrega',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,$lugar_entrega,0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Nivel de Aprobación',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,$nivel_aprobacion,0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Imputación',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(100,5,$unidad_organizacional,0,0);
		$pdf->Cell(45,5,'Bs. '.$monto,0,1);
	    $pdf->Cell(185,10,'',0,1);
	    $pdf->Cell(45,5,'Atentamente,',0,1);
	    $pdf->Cell(185,15,'',0,1);
	    $pdf->Cell(185,6,'________________________',0,1,'C');
	    $pdf->Cell(185,5,'Lic. '.$_SESSION['PDF_jefe_depto_bienes'],0,1,'C');
	    $pdf->Cell(185,5,$_SESSION['PDF_cargo_depto_bienes'],0,1,'C');

	    $pdf->Ln(66); 
	    $pdf->SetFont('Arial','',7);
		$pdf->Cell(100,5,'Observaciones.-'.$observaciones,0,0);
		
	    
$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(0); 
$pdf->Output();
?>