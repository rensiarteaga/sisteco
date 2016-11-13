<?php
session_start();
/**
 * Autor: Daniel Sanchez Torrico
 * Fecha de creacion: 17/04/2013
 * Descripción: Reporte detalle de activos fijos
 * **/

require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{    
	function PDF($orientation='L',$unit='mm',$format='Letter')
    {
    	//ANCHO DE PAGINA VERTICALMENTE 205
	    //Llama al constructor de la clase padre
	    $this->FPDF($orientation,$unit,$format);
	    $this-> AddFont('Arial','','arial.php');
	     
	    //Iniciación de variables    
    }   
    
	function Header()
	{
		$this->Image('../../../../lib/images/logo_reporte.jpg',243,2,35,15); //LOGO
				
	   	// TITULO
	   
	    $this->Ln(4);
	   	$this->SetFont('Arial','B',10);
	 	$this->Cell(0,3,'DETALLE DE ACTIVOS FIJOS',0,1,'C');
	 	
	 	if($_SESSION['PDF_ep'] == 'true'){
	 		$this->Ln(4);
	 		$this->SetFont('Arial','B',6);
	 		$this->Cell(30,3,'FINANCIADOR: ',0,0,'L');
	 		$this->SetFont('Arial','',6);
	 		$this->Cell(50,3,utf8_decode($_SESSION["PDF_financiador"]),0,0,'L');
	 		 
	 		$this->SetFont('Arial','B',6);
	 		$this->Cell(30,3,'REGIONAL: ',0,0,'L');
	 		$this->SetFont('Arial','',6);
	 		$this->Cell(50,3,utf8_decode($_SESSION["PDF_regional"]),0,1,'L');
	 		 
	 		$this->SetFont('Arial','B',6);
	 		$this->Cell(30,3,'PROGRAMA: ',0,0,'L');
	 		$this->SetFont('Arial','',6);
	 		$this->Cell(50,3,utf8_decode($_SESSION["PDF_programa"]),0,0,'L');
	 		 
	 		$this->SetFont('Arial','B',6);
	 		$this->Cell(30,3,'PROYECTO: ',0,0,'L');
	 		$this->SetFont('Arial','',6);
	 		$this->Cell(50,3,utf8_decode($_SESSION["PDF_proyecto"]),0,1,'L');
	 		 
	 		$this->SetFont('Arial','B',6);
	 		$this->Cell(30,3,'ACTIVIDAD: ',0,0,'L');
	 		$this->SetFont('Arial','',6);
	 		$this->Cell(50,3,utf8_decode($_SESSION["PDF_actividad"]),0,0,'L');
	 	}
	 	

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
	 	$this->Cell(30,3,'SUBTIPO ACTIVO: ',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,utf8_decode($_SESSION["PDF_sub_tipo_activo"]),0,0,'L');
	 	
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(30,3,'ESTADO FUNCIONAL: ',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,utf8_decode($_SESSION["PDF_estado_funcional"]),0,1,'L');
	 	
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(30,3,'ESTADO: ',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,utf8_decode($_SESSION["PDF_estado_af"]),0,0,'L');
	 	
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(30,3,'PROYECTO: ',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,utf8_decode($_SESSION["PDF_proyecto_af"]),0,0,'L');
	 	 
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(30,3,'ACTIVO - BIEN BR: ',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,utf8_decode($_SESSION["PDF_activo_bbr"]),0,1,'L');
	 	 
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(30,3,'UNIDAD AF: ',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,utf8_decode($_SESSION["PDF_unidad_af"]),0,1,'L');
	 	
	 	
	 	
	 	if($_SESSION['PDF_fecha_compra'] == 'true'){
			$this->SetFont('Arial','B',6);
			$this->Cell(30,5,'Fecha Compra (inicio): ',0,0,'L');
			$this->SetFont('Arial','',6);
			$this->Cell(50,5,$_SESSION["PDF_fecha_compra1"],0,0,'L');
			
			$this->SetFont('Arial','B',6);
			$this->Cell(30,5,'Fecha Compra (fin): ',0,0,'L');
			$this->SetFont('Arial','',6);
			$this->Cell(50,5,$_SESSION["PDF_fecha_compra2"],0,1,'L');
	 	}	
	    if($_SESSION['PDF_fecha_deprec'] == 'true'){
			$this->SetFont('Arial','B',6);
			$this->Cell(30,5,'Fecha Ini Depr (inicio): ',0,0,'L');
			$this->SetFont('Arial','',6);
			$this->Cell(50,5,$_SESSION["PDF_fecha_deprec1"],0,0,'L');
			
			$this->SetFont('Arial','B',6);
			$this->Cell(30,5,'Fecha Ini Depr (fin): ',0,0,'L');
			$this->SetFont('Arial','',6);
			$this->Cell(50,5,$_SESSION["PDF_fecha_deprec2"],0,1,'L');
	    }
		$this->Ln(2);
	 	
	 	
	 	// FIN TITULO
				
		//ENCABEZADO DE TABLA
		 $this->SetFont('Arial','B',6);
		 
		 $nombre_descripcion = $_SESSION['nombre_descripcion'];
		 
		 
			//primera linea 
			 $this->Cell(12,3,'NUM','TRL',0,'C');
			 $this->Cell(15,3,'CÓDIGO','TRL',0,'C');
			 
			 if($nombre_descripcion == 0){				 
				 $this->Cell(30,3,'NOMBRE','TRL',0,'C');
				 $this->Cell(50,3,'DESCRIPCIÓN','TRL',0,'C');
				 $this->Cell(15,3,'ESTADO','TRL',0,'C');
				 $this->Cell(22,3,'ESTADO','TRL',0,'C');
				 $this->Cell(13,3,'FECHA','TRL',0,'C');
				 $this->Cell(13,3,'FECHA','TRL',0,'C');
				 $this->Cell(13,3,'MONTO','TRL',0,'C');
				 $this->Cell(25,3,'UBICACIÓN','TRL',0,'C');
				 $this->Cell(30,3,'RESPONSABLE','TRL',0,'C');
				 $this->Cell(35,3,'UNIDAD','TRL',1,'C');
				 	
				 
			 }else if($nombre_descripcion == 1){			 	
			 	 $this->Cell(30,3,'NOMBRE','TRL',0,'C');
			 	 $this->Cell(15,3,'ESTADO','TRL',0,'C');
			 	 $this->Cell(22,3,'ESTADO','TRL',0,'C');
			 	 $this->Cell(13,3,'FECHA','TRL',0,'C');
			 	 $this->Cell(13,3,'FECHA','TRL',0,'C');
			 	 $this->Cell(13,3,'MONTO','TRL',0,'C');
			 	 $this->Cell(45,3,'UBICACIÓN','TRL',0,'C');
			 	 $this->Cell(45,3,'RESPONSABLE','TRL',0,'C');
			 	 $this->Cell(50,3,'UNIDAD','TRL',1,'C');
			 	 
			 	 
			 	 
		     }else if ($nombre_descripcion == 2){
		     	 $this->Cell(80,3,'DESCRIPCIÓN','TRL',0,'C');
		     	 $this->Cell(15,3,'ESTADO','TRL',0,'C');
		     	 $this->Cell(22,3,'ESTADO','TRL',0,'C');
		     	 $this->Cell(13,3,'FECHA','TRL',0,'C');
		     	 $this->Cell(13,3,'FECHA','TRL',0,'C');
		     	 $this->Cell(13,3,'MONTO','TRL',0,'C');
		     	 $this->Cell(25,3,'UBICACIÓN','TRL',0,'C');
		     	 $this->Cell(30,3,'RESPONSABLE','TRL',0,'C');
		     	 $this->Cell(35,3,'UNIDAD','TRL',1,'C');
		     	  
		     	 
		     	 
		     }	 	 
			 
			//segunda linea 
			 $this->Cell(12,3,'','BRL',0,'C'); 
			 $this->Cell(15,3,'','BRL',0,'C'); 
			  
			 if($nombre_descripcion == 0){
			 	$this->Cell(30,3,'','BRL',0,'C'); 
			    $this->Cell(50,3,'','BRL',0,'C'); 
			    $this->Cell(15,3,'','BRL',0,'C');
			    $this->Cell(22,3,'FUNCIONAL','BRL',0,'C');
			    $this->Cell(13,3,'COMPRA','BRL',0,'C');
			    $this->Cell(13,3,'INI DEP','BRL',0,'C');
			    $this->Cell(13,3,'','BRL',0,'C');
			    $this->Cell(25,3,'','BRL',0,'C');
			    $this->Cell(30,3,'','BRL',0,'C');
			    $this->Cell(35,3,'','BRL',1,'C');
			 }else if($nombre_descripcion == 1){
			 	$this->Cell(30,3,'','BRL',0,'C');
			 	$this->Cell(15,3,'','BRL',0,'C');
			 	$this->Cell(22,3,'FUNCIONAL','BRL',0,'C');
			 	$this->Cell(13,3,'COMPRA','BRL',0,'C');
			 	$this->Cell(13,3,'INI DEP','BRL',0,'C');
			 	$this->Cell(13,3,'','BRL',0,'C');
			 	$this->Cell(45,3,'','BRL',0,'C');
			 	$this->Cell(45,3,'','BRL',0,'C');
			 	$this->Cell(50,3,'','BRL',1,'C');
			 }else if ($nombre_descripcion == 2){
			 	$this->Cell(80,3,'','BRL',0,'C');
			 	$this->Cell(15,3,'','BRL',0,'C');
			 	$this->Cell(22,3,'FUNCIONAL','BRL',0,'C');
			 	$this->Cell(13,3,'COMPRA','BRL',0,'C');
			 	$this->Cell(13,3,'INI DEP','BRL',0,'C');
			 	$this->Cell(13,3,'','BRL',0,'C');
			 	$this->Cell(25,3,'','BRL',0,'C');
			 	$this->Cell(30,3,'','BRL',0,'C');
			 	$this->Cell(35,3,'','BRL',1,'C');
			 }

		 
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
		$this->Cell(100,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(55,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(100,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - FACTURACION',0,0,'L');
		$this->Cell(120,3,'',0,0,'C');
		$this->Cell(65,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');
		
	    /*$fecha=date("d-m-Y");
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
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	  */      
     }
}

$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,7);
$pdf->SetMargins(3,5,3);
	    
$pdf->AddPage(); 
	    
$pdf->SetFont('Arial','B',6);


if($nombre_descripcion == 0){
	$pdf->SetWidths(array(12,15,30,50,15,22,13,13,13,25,30,35));
    $pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1));
}else if($nombre_descripcion == 1){
	$pdf->SetWidths(array(12,15,30,0,15,22,13,13,13,45,45,50));
    $pdf->SetVisibles(array(1,1,1,0,1,1,1,1,1,1,1,1));
}else if ($nombre_descripcion == 2){
	$pdf->SetWidths(array(12,15,0,80,15,22,13,13,13,25,30,35));
    $pdf->SetVisibles(array(1,1,0,1,1,1,1,1,1,1,1,1));
}


/*$pdf->SetWidths(array(7,15,30,50,15,22,13,13,13,25,30,35));
$pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1));*/

$pdf->SetAligns(array('R','L','L','L','L','L','L','L','L','L','L','L'));
$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0));
$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6));
$pdf->SetFontsStyles(array('','','','','','','','','','','',''));
$pdf->SetDecimales(array(0,0,0,0,0,0,0,0,0,0,0,0));
$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3));
$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0));




$detalle = $_SESSION["PDF_Detalle_Activos"];

$cont = 0;

for ($i=0; $i<count($detalle); $i++){

	$cont += 1;
	$pdf->SetLineWidth(0.05);	
	array_unshift($detalle[$i],$cont);
	$pdf->MultiTabla($detalle[$i],0,3,3,6);
	$pdf->SetLineWidth(0.1);

}

$pdf->Output();
?>











