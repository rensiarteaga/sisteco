<?php
session_start();
/**
 * Autor:  Elmer Velasquez	
 * Fecha de creacion: 15/04/2014	
 * Descripción: reporte resaldo de los comprobantes de depreciacion de activos fijos
 * **/

require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{    
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    	//ANCHO DE PAGINA VERTICALMENTE 205 
	    //Llama al constructor de la clase padre
	    $this->FPDF($orientation,$unit,$format);
	    $this-> AddFont('Arial','','arial.php');
	     
	    //Iniciación de variables    
    }   
    
	function Header() 
	{
		$fecha=date("d-m-Y");
		
		$this->Image('../../../../lib/images/logo_reporte.jpg',180,2,35,15);
		$this->Ln(5);
		
		$this->SetX(1);
	   	$this->SetFont('Arial','B',15);
	 	$this->Cell(220,3,'HISTORICO DEPRECIACION DE ACTIVOS FIJOS',0,1,'C');
	 	$this->Ln(2);

	 	$this->Ln(6); $y_1= $this->GetY();
	 	$this->SetX(35);
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(30,3,'Tipo de Activo:',0,0,'L'); 
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,$_SESSION['PDF_detalle_depreciacion_activo'][0][16],0,1,'L');
	 	

	 	$this->SetX(35);  
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(30,3,'Codigo Activo Fijo: ',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,utf8_decode($_SESSION["PDF_detalle_depreciacion_activo"][0][13]),0,1,'L');

	 	$this->SetY($y_1);
	 	$this->SetX(120);
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(30,3,'Proyecto:',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,utf8_decode($_SESSION['PDF_detalle_depreciacion_activo'][0][15]),0,1,'L');
	 
	 	$this->Ln();
	 	$this->SetX(35);
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(30,3,'Descripcion Activo Fijo:',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,$_SESSION['PDF_detalle_depreciacion_activo'][0][14],0,1,'L');
	 	

	 	$this->Ln(6);
	 	$this->SetFont('Arial','B',6);
	 	
	 	$this->SetWidths(array(12,12,13,17,15,17,17,17,17,13,15,15,15));
	 	$this->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0,0));
	 	$this->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1,1));
	 	$this->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5,5,5,5));
	 	$this->SetAligns(array('C','C','R','R','R','R','R','R','R','R','R','R','R'));
	 	$this->SetFontsStyles(array('','','','','','','','','','','','',''));
	 	$this->SetDecimales(array(0,0,2,2,2,2,2,2,2,2,2,2,2));
	 	$this->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3));
	 	$this->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0,0));
	 	
	 	//primera linea
	 	$this->SetX(13);
	 	//$this->Cell(15,3,'ID','TRL',0,'C');  //1
	 	$this->Cell(12,3,'FECHA','TRL',0,'C');  //2
	 	$this->Cell(12,3,'FECHA','TRL',0,'C');  //3
	 	$this->Cell(13,3,'VIDA','TRL',0,'C');  //4
	 	$this->Cell(17,3,'MONTO','TRL',0,'C');  //5
	 	$this->Cell(13,3,'MONTO','TRL',0,'C');  //6
	 	$this->Cell(17,3,'DEPRECIACION','TRL',0,'C');  //7
	 	$this->Cell(17,3,'DEPRECIACION','TRL',0,'C');  //8
	 	$this->Cell(17,3,'DEPRECIACION','TRL',0,'C');  //9
	 	$this->Cell(17,3,'DEPRECIACION','TRL',0,'C');  //10
	 	$this->Cell(13,3,'MONTO','TRL',0,'C');  //12
	 	$this->Cell(15,3,'MONTO','TRL',0,'C');  //13
	 	$this->Cell(15,3,'TIPO CAMBIO','TRL',0,'C');  //14
	 	$this->Cell(15,3,'TIPO CAMBIO','TRL',0,'C');  //15
	 	
	 	$this->Ln(2);
	 	$this->SetX(13);
	 	//segunda linea
	 	$this->Cell(12,3,'DESDE','RL',0,'C');  //2
	 	$this->Cell(12,3,'HASTA','RL',0,'C');//3
	 	$this->Cell(13,3,'UTIL','RL',0,'C');//4
	 	$this->Cell(17,3,'ACTUALIZADO','L',0,'C');//5
	 	$this->Cell(13,3,'ACTUAL','RL',0,'C');//6
	 	$this->Cell(17,3,'ACUMULADA','RL',0,'C');//7
	 	$this->Cell(17,3,'ACUMULADA','RL',0,'C');//8
	 	$this->Cell(17,3,'','RL',0,'C');//9
	 	$this->Cell(17,3,'ACUMULADA','RL',0,'C');//10
	 	$this->Cell(13,3,'ANTERIOR','RL',0,'C');//12
	 	$this->Cell(15,3,'VIGENTE','RL',0,'C');//13
	 	$this->Cell(15,3,'INICIAL','RL',0,'C');//14
	 	$this->Cell(15,3,'FINAL','RL',0,'C');//15
	 	
	 	
	 	
	 	//tercera linea
	 	$this->Ln(2);
	 	$this->SetX(13);
	 	//$this->Cell(15,3,'ACTIVO FIJO','BRL',0,'C');  //1
	 	$this->Cell(12,3,'','RL',0,'C');  //2
	 	$this->Cell(12,3,'','RL',0,'C');//3
	 	$this->Cell(13,3,'RESTANTE','RL',0,'C');//4
	 	$this->Cell(17,3,'ANTERIOR','L',0,'C');//5
	 	$this->Cell(13,3,'','RL',0,'C');//6
	 	$this->Cell(17,3,'','RL',0,'C');//7
	 	$this->Cell(17,3,'ACTUALIZADA','RL',0,'C');//8
	 	$this->Cell(17,3,'','RL',0,'C');//9
	 	$this->Cell(17,3,'','RL',0,'C');//10
	 	$this->Cell(13,3,'','RL',0,'C');//12
	 	$this->Cell(15,3,'','RL',0,'C');//13
	 	$this->Cell(15,3,'','RL',0,'C');//14
	 	$this->Cell(15,3,'','RL',0,'C');//15
	 	
	 	
	 	$this->Ln(3);
	 	$this->SetX(13);
	}

	//Pie de página
	function Footer()
	{
	   $fecha=date("d-m-Y");
		$hora=date("H:i:s");
		$this->SetLeftMargin(10);
		$this->SetY(-7);
		$this->SetFont('Arial','',5);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Pagina '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(65,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'R');
		$this->ln(3);
		$this->Cell(100,3,'Sistema: ENDESIS - ACTIF',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(35,3,'',0,0,'C');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'R');        
     }
}

$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,7);
$pdf->SetMargins(13,5,5);
	    
$pdf->AddPage(); 
	    
$pdf->SetFont('Arial','',5);

$pdf->SetWidths(array(12,12,13,17,13,17,17,17,17,13,15,15,15));
$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0,0));
$pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1,1));
$pdf->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5,5,5,5));
$pdf->SetAligns(array('C','C','R','R','R','R','R','R','R','R','R','R','R'));
$pdf->SetFontsStyles(array('','','','','','','','','','','','',''));
$pdf->SetDecimales(array(0,0,2,2,2,2,2,2,2,2,2,0,0));
$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3));
$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0,0));

$pdf->SetLeftMargin(13);
$detalle=$_SESSION['PDF_detalle_depreciacion_activo'];

for ($i=0; $i<count($detalle); $i++)
{
	$pdf->MultiTabla($detalle[$i],0,3,3,6,1);
}

$pdf->Output();
?>