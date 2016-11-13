<?php
session_start();
/**
 * Autor: Marcos A. Flores Valda
 * Fecha de creacion: 03/02/2011
 * Descripción: Reporte detalle de activos fijos
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
		$this->Image('../../../../lib/images/logo_reporte.jpg',180,2,25,10); //LOGO
				
	   	// TITULO
	   
	    $this->Ln(4);
	   	$this->SetFont('Arial','B',10);
	 	$this->Cell(200,3,'DETALLE DE ACTIVOS FIJOS',0,1,'C');
	 	
	 	$this->Ln(4);
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(30,3,'FINANCIADOR: ',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,utf8_decode($_SESSION["PDF_financiador"]),0,0,'L');
	 	
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(35,3,'REGIONAL: ',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,utf8_decode($_SESSION["PDF_regional"]),0,1,'L');
	 	
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(30,3,'PROGRAMA: ',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,utf8_decode($_SESSION["PDF_programa"]),0,0,'L');
	 	
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(35,3,'PROYECTO: ',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,utf8_decode($_SESSION["PDF_proyecto"]),0,1,'L');
	 	
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(30,3,'ACTIVIDAD: ',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,utf8_decode($_SESSION["PDF_actividad"]),0,0,'L');       

//	 	$this->SetFont('Arial','B',6);
//	 	$this->Cell(35,3,'UNIDAD ORGANIZACIONAL: ',0,0,'L');
//	 	$this->SetFont('Arial','',6);
//	 	$this->Cell(50,3,utf8_decode($_SESSION["PDF_uni_org"]),0,1,'L');

		$this->SetFont('Arial','B',6);
	 	$this->Cell(35,3,'',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,'',0,1,'L');
	 			
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(30,3,'TIPO ACTIVO: ',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,utf8_decode($_SESSION["PDF_tipo_activo"]),0,0,'L');
	 	
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(35,3,'SUBTIPO ACTIVO: ',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,utf8_decode($_SESSION["PDF_sub_tipo_activo"]),0,1,'L');
	 	
		$this->SetFont('Arial','B',6);
		$this->Cell(30,5,'Fecha Compra (inicio): ',0,0,'L');
		$this->SetFont('Arial','',6);
		$this->Cell(50,5,$_SESSION["PDF_fecha_compra1"],0,0,'L');
		
		$this->SetFont('Arial','B',6);
		$this->Cell(35,5,'Fecha Compra (fin): ',0,0,'L');
		$this->SetFont('Arial','',6);
		$this->Cell(50,5,$_SESSION["PDF_fecha_compra2"],0,1,'L');
		
		$this->Ln(2);
	 	
	 	
	 	// FIN TITULO
				
		//ENCABEZADO DE TABLA
		 $this->SetFont('Arial','B',6);
		 //$this->SetWidths(array(7,10,30,10,17,13,13,25,30,40));
		 $this->SetWidths(array(7,15,30,15,22,13,13,25,30,35));
		 $this->SetFills(array(0,0,0,0,0,0,0,0,0,0));
		 $this->SetVisibles(array(1,1,1,1,1,1,1,1,1,1));
		 $this->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6));
		 $this->SetFontsStyles(array('','','','','','','','','',''));
		 $this->SetDecimales(array(0,0,0,0,0,0,0,0,0,0));
		 $this->SetSpaces(array(3,3,3,3,3,3,3,3,3,3));
		 $this->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0));
		
		if($_SESSION["PDF_nombre_descripcion"] == 'Nombre')
		{
			//primera linea 
			 $this->Cell(7,3,'NUM','TRL',0,'C');  
			 $this->Cell(15,3,'CÓDIGO','TRL',0,'C');  
			 $this->Cell(30,3,'NOMBRE','TRL',0,'C');  
			 $this->Cell(15,3,'ESTADO','TRL',0,'C');  
			 $this->Cell(22,3,'ESTADO','TRL',0,'C'); 
			 $this->Cell(13,3,'FECHA','TRL',0,'C');  
			 $this->Cell(13,3,'MONTO','TRL',0,'C');  
			 $this->Cell(25,3,'UBICACIÓN','TRL',0,'C');   
			 $this->Cell(30,3,'RESPONSABLE','TRL',0,'C');  
			 $this->Cell(35,3,'UNIDAD','TRL',1,'C');  
		}
		else
		{
			//primera linea 
			 $this->Cell(7,3,'NUM','TRL',0,'C');  
			 $this->Cell(15,3,'CÓDIGO','TRL',0,'C');  
			 $this->Cell(30,3,'DESCRIPCIÓN','TRL',0,'C');  
			 $this->Cell(15,3,'ESTADO','TRL',0,'C');  
			 $this->Cell(22,3,'ESTADO','TRL',0,'C'); 
			 $this->Cell(13,3,'FECHA','TRL',0,'C');  
			 $this->Cell(13,3,'MONTO','TRL',0,'C');  
			 $this->Cell(25,3,'UBICACIÓN','TRL',0,'C');   
			 $this->Cell(30,3,'RESPONSABLE','TRL',0,'C');  
			 $this->Cell(35,3,'UNIDAD','TRL',1,'C');  
		}
		
		//segunda linea 
		 $this->Cell(7,3,'','BRL',0,'C');  
		 $this->Cell(15,3,'','BRL',0,'C');  
		 $this->Cell(30,3,'','BRL',0,'C');  
		 $this->Cell(15,3,'','BRL',0,'C');  
		 $this->Cell(22,3,'FUNCIONAL','BRL',0,'C'); 
		 $this->Cell(13,3,'COMPRA','BRL',0,'C');
		 $this->Cell(13,3,'','BRL',0,'C');  
		 $this->Cell(25,3,'','BRL',0,'C');   
		 $this->Cell(30,3,'','BRL',0,'C');  
		 $this->Cell(35,3,'','BRL',1,'C');    
			
		//FIN ENCABEZADO DE TABLA
	}

	//Pie de página
	function Footer()
	{
	    //Posición: a 1,5 cm del final
	    $fecha=date("d-m-Y");
		$hora=date("H:i:s");
		$this->SetY(-7);
	   	$this->SetFont('Arial','',5);
	   	$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
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
$pdf->SetMargins(5,5,5);
	    
$pdf->AddPage(); 
	    
$pdf->SetFont('Arial','B',6);
$pdf->SetWidths(array(7,15,30,15,22,13,13,25,30,35));
$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0));
$pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1));
$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6));
$pdf->SetFontsStyles(array('','','','','','','','','',''));
$pdf->SetDecimales(array(0,0,0,0,0,0,0,0,0,0));
$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3));
$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0));
		 
$det_af = $_SESSION["PDF_detalle_af"];

//echo $det_af[0]["fecha_compra"]; exit;

$cont = count($det_af);

for($j=0;$j<$cont;$j++)
 {
 	$numero=$j+1;
    $pdf->MultiTabla((array_merge((array)$numero,(array)$det_af[$j])),3,3,4,8);
 }

$pdf->Output();
?>