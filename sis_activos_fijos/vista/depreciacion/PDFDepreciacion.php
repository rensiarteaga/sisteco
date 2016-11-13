<?php

session_start();
/**
 * Autor: Marcos A. Flores Valda
 * Fecha de creacion: 07/01/2011
 * Descripción: Reporte de Depreciaciones
 * **/

require('../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{   
	var $ano_fin;
	var $mes_fin;
	var $mes;
	var $depart;	
		
	function PDF($orientation='L',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    $this-> AddFont('Arial','','arial.php');
     
    //Iniciación de variables    
    }
    
	function Header()
	{       
	   $this->Image('../../../lib/images/logo_reporte.jpg',230,2,30,15);
	  
	    $this->Ln(5);
	    $this->SetFont('Arial','B',16);
	 	$this->Cell(0,6,'DETALLE DE DEPRECIACION',0,1,'C');
	 	$this->SetFont('Arial','B',8);
	 	$this->Cell(0,6,'DEPRECIACION HASTA: '.$this->mes_fin.'/'.$this->ano_fin,0,1,'C');
	 	$this->SetFont('Arial','B',8);
	 	$this->Cell(0,5,$this->depart,0,1,'C');
	 	$this->SetFont('Arial','',10);
	 	$this->Ln(5);
	 	
	 $this->SetLineWidth(0.2);
	 
	 $this->SetFont('Arial','B',7);
	 $this->SetWidths(array(15,15,15,15,15,15,15,20,15,15,20,20,15,15,15,15));
	 $this->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
	 $this->SetAligns(array('L','L','L','R','R','R','R','R','R','R','R','R','R','R','R','R'));
	 $this->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
	 $this->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6));
	 $this->SetFontsStyles(array('','','','','','','','','','','','','','','',''));
	 $this->SetDecimales(array(0,0,0,2,2,0,2,2,2,2,2,0,0,2,0,0));
	 $this->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
	 $this->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
	 
	 //primera linea 
	 $this->Cell(15,3,'Activo','TRL',0,'C');  
	 $this->Cell(15,3,'Fecha','TRL',0,'C');  
	 $this->Cell(15,3,'Fecha','TRL',0,'C');  
	 $this->Cell(15,3,'Vida rest','TRL',0,'C');  
	 $this->Cell(15,3,'Monto act','TRL',0,'C'); 
	 $this->Cell(15,3,'Monto','TRL',0,'C');  
	 $this->Cell(15,3,'Monto act','TRL',0,'C');  
	 $this->Cell(20,3,'Depreciación','TRL',0,'C');   
	 $this->Cell(15,3,'Dep acum','TRL',0,'C');  
	 $this->Cell(15,3,'Vida','TRL',0,'C');  
	 $this->Cell(20,3,'Depreciación','TRL',0,'C'); 
	 $this->Cell(20,3,'Depreciación','TRL',0,'C');  
	 $this->Cell(15,3,'Monto','TRL',0,'C');  
	 $this->Cell(15,3,'Monto','TRL',0,'C');  
	 $this->Cell(15,3,'Tipo cambio','TRL',0,'C');  
	 $this->Cell(15,3,'Tipo cambio','TRL',1,'C');
	
	 //segunda linea
	 $this->Cell(15,3,'','BRL',0,'C');  
	 $this->Cell(15,3,'Desde','BRL',0,'C');  
	 $this->Cell(15,3,'Hasta','BRL',0,'C');  
	 $this->Cell(15,3,'Útil','BRL',0,'C');  
	 $this->Cell(15,3,'Anterior','BRL',0,'C'); 
	 $this->Cell(15,3,'Actual','BRL',0,'C');  
	 $this->Cell(15,3,'Depreciado','BRL',0,'C');  
	 $this->Cell(20,3,'Acumulada','BRL',0,'C');   
	 $this->Cell(15,3,'Actual','BRL',0,'C');  
	 $this->Cell(15,3,'Útil','BRL',0,'C');  
	 $this->Cell(20,3,'','BRL',0,'C'); 
	 $this->Cell(20,3,'Acumulada','BRL',0,'C');  
	 $this->Cell(15,3,'Anterior','BRL',0,'C');  
	 $this->Cell(15,3,'Vigente','BRL',0,'C');  
	 $this->Cell(15,3,'Inicial','BRL',0,'C');  
	 $this->Cell(15,3,'Final','BRL',1,'C');
	 
	 $this->Ln(0.3);
	}
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
    $fecha=date("d-m-Y");
	$hora=date("H:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
   	    $this->Cell(100,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(70,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(62,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
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
    $pdf->SetMargins(5,5,5);
    $pdf->ano_fin=$ano_fin;
    $pdf->mes_fin=$mes_fin;
    $pdf->depart=$depart;
    $pdf->AddPage();


	$pdf->SetWidths(array(15,15,15,15,15,15,15,20,15,15,20,20,15,15,15,15));

  	//$pdf->SetWidths(array(12,45,15,45,25,15,25,18,15,15,22,20));
	 $pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
	 $pdf->SetAligns(array('L','L','L','R','R','R','R','R','R','R','R','R','R','R','R','R'));
	 $pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
	 $pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6));
	 $pdf->SetFontsStyles(array('','','','','','','','','','','','','','','',''));
	 $pdf->SetDecimales(array(0,0,0,2,2,0,2,2,2,2,2,0,0,2,0,0));
	 $pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
	 $pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
 
	$depre=$_SESSION['PDF_depreciacion'];
	for ($i=0;$i<sizeof($depre);$i++)
 	{
 		$pdf->SetLineWidth(0.05); 	
 	   	$pdf->MultiTabla($depre[$i],0,3,3,6,1);
 	} 
 	
$pdf->Output();
?>