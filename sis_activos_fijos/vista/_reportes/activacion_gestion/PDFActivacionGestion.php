<?php
session_start();
/**
 * Autor: Boris Claros Olivera
 * Fecha de creacion: 28/03/2011
 * Descripción: Reporte de Depreciaciones
 * **/

require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');

$_SESSION['PDF_descripcion_larga']=utf8_decode($_SESSION['PDF_descripcion_larga']);

class PDF extends FPDF
{   			
	function PDF($orientation='L',$unit='mm',$format='Letter')
    {
	    //Llama al constructor de la clase padre
	    $this->FPDF($orientation,$unit,$format);
	    $this-> AddFont('Arial','','arial.php');
	     
	    //Iniciación de variables    
    }
    
	function Header()
	{       
   		$this->Image('../../../../lib/images/logo_reporte.jpg',230,2,30,15);
  		$this->Ln(5); 		 		  
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
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(true,7);
    $pdf->SetMargins(5,5,5);
    
    	//  TITULO
	    
	    $pdf->SetFont('Arial','B',16);
	 	$pdf->Cell(0,6,'REPORTE DE ACTIVACION DE ACTIVOS FIJOS POR GESTION',0,1,'C');
	 	$pdf->SetFont('Arial','B',8);
	 	$pdf->Cell(0,5,'Gestion: '.$_SESSION['PDF_gestion'],0,1,'C');
	 	
	 	// FIN TITULO
	 		 	
	 	$pdf->SetFont('Arial','B',8);
	 	$pdf->Cell(35,5,'FINANCIADOR:',0,0,'L');
	 	$pdf->SetFont('Arial','',8);
	 	$pdf->Cell(55,5,trim($_SESSION['PDF_financiador']),0,0,'L');
	 	
	 	$pdf->SetFont('Arial','B',8);
	 	$pdf->Cell(35,5,'TIPO ACTIVO FIJO:',0,0,'L');
	 	$pdf->SetFont('Arial','',8);
	 	$pdf->Cell(50,5,trim($_SESSION['PDF_tipo']),0,1,'L');
	 	
	 	$pdf->SetFont('Arial','B',8);
	 	$pdf->Cell(35,5,'REGIONAL:',0,0,'L');
	 	$pdf->SetFont('Arial','',8);
	 	$pdf->Cell(55,5,trim($_SESSION['PDF_regional']),0,0,'L');
	 	
	 	$pdf->SetFont('Arial','B',8);
	 	$pdf->Cell(35,5,'SUBTIPO ACTIVO FIJO:',0,0,'L');
	 	$pdf->SetFont('Arial','',8);
	 	$pdf->Cell(145,5,trim($_SESSION['PDF_subtipo']),0,1,'L');
	 	
	 	$pdf->SetFont('Arial','B',8);
	 	$pdf->Cell(35,5,'PROGRAMA:',0,0,'L');
	 	$pdf->SetFont('Arial','',8);
	 	$pdf->Cell(55,5,trim($_SESSION['PDF_programa']),0,1,'L');
	 	
	 	$pdf->SetFont('Arial','B',8);
	 	$pdf->Cell(35,5,'PROYECTO:',0,0,'L');
	 	$pdf->SetFont('Arial','',8);
	 	$pdf->Cell(55,5,trim($_SESSION['PDF_actividad']),0,1,'L');
	 	
	 
	 	$pdf->Ln(3.0);
		 $pdf->SetLineWidth(0.2);
		 
		 $pdf->SetFont('Arial','B',7);
		 $pdf->SetWidths(array(15,15,20,20,20,20,20,20,20,20,20,15,15,20));
		 $pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0));
		 $pdf->SetAligns(array('C','C','C','C','R','R','R','R','R','R','R','R','R','R'));
		 $pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,0,0,0));
		 $pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6,6,6));
		 $pdf->SetFontsStyles(array('','','','','','','','','','','','','',''));
		 $pdf->SetDecimales(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0));
		 $pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3));
		 $pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
		 
		 $pdf->Ln(2);
		 
		//primera linea 
		 $pdf->Cell(15,3,'Nro.','TRL',0,'C');  
		 $pdf->Cell(15,3,'CODIGO','TRL',0,'C');  
		 $pdf->Cell(20,3,'DESCRIPCION','TRL',0,'C');  
		 $pdf->Cell(20,3,'FECHA DE','TRL',0,'C');  
		 $pdf->Cell(20,3,'FINANCIADOR','TRL',0,'C');  		 
		 $pdf->Cell(20,3,'REGIONAL','TRL',0,'C'); 
		 $pdf->Cell(20,3,'PROGRAMA','TRL',0,'C');  
		 $pdf->Cell(20,3,'PROYECTO','TRL',0,'C');  
		 $pdf->Cell(20,3,'ACTIVIDAD','TRL',0,'C');   
		 
		 $pdf->Cell(20,3,'TIPO','TRL',0,'C');  
		 $pdf->Cell(20,3,'SUB','TRL',1,'C');  
		 /*
		 $pdf->Cell(10,3,'VIDA','TRL',0,'C'); 
		 $pdf->Cell(15,3,'T CAMBIO','TRL',0,'C');  
		 $pdf->Cell(15,3,'T CAMBIO','TRL',0,'C');  
		 $pdf->Cell(20,3,'FACTOR','TRL',1,'C');
	*/
		//segunda linea 
		 $pdf->Cell(15,3,'','BRL',0,'C');  		//NRO
		 $pdf->Cell(15,3,'','BRL',0,'C');  		//CODIGO
		 $pdf->Cell(20,3,'','BRL',0,'C');  		//DESCRIPCION
		 $pdf->Cell(20,3,'ACTIVACION','BRL',0,'C');  //FECHA DE
		 $pdf->Cell(20,3,'','BRL',0,'C');   		//FINANCIADOR
		 $pdf->Cell(20,3,'','BRL',0,'C'); 	//REGIONAL
		 $pdf->Cell(20,3,'','BRL',0,'C');  			//PROGRAMA
		 $pdf->Cell(20,3,'','BRL',0,'C');  	//PROYECTO
		 $pdf->Cell(20,3,'','BRL',0,'C');    //ACTIVIDAD
		 $pdf->Cell(20,3,'','BRL',0,'C');     //TIPO
		 $pdf->Cell(20,3,'TIPO','BRL',1,'C');  //SUBTIPO
		 /*
		 $pdf->Cell(10,3,'ÚTIL','BRL',0,'C'); 
		 $pdf->Cell(15,3,'INICIAL','BRL',0,'C');  
		 $pdf->Cell(15,3,'FINAL','BRL',0,'C');  
		 $pdf->Cell(20,3,'ACTUALIZ','BRL',1,'C');	
		 */
		 $v_cabecera = $_SESSION['PDF_cabecera'];
		 
		// for ($i=0;$i<sizeof($v_cabecera);$i++)
		
		$pdf->SetWidths(array(15,15,20,20,20,20,20,20,20,20,20,20,20,20));
			$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0));
			$pdf->SetAligns(array('C','L','L','C','C','C','C','C','C','C','C','C','R','R'));
			$pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,0,0,0));
			$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6,6,6));
			$pdf->SetFontsStyles(array('','','','','','','','','','','','','',''));
			$pdf->SetDecimales(array(0,2,2,2,2,2,2,2,2,2,2,6,6,6));
			$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3));
			$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
			
			$v_cuerpo = $_SESSION['PDF_cuerpo'];
		 	
		 	 
			
			
			for($j=0;$j<sizeof($v_cuerpo);$j++)
			 {
			 	$numero=$j+1;
			    $pdf->MultiTabla((array_merge((array)$numero,(array)$v_cuerpo[$j])),1,1,3,6,1);
			 }
		             	

//	$pdf->SetFont('Arial','B',6);
//    $pdf->Cell(15,3,'TOTALES','BL',0,'C');  
 	$pdf->Cell(210,3,'','B',0,'C');  
//	$pdf->Cell(15,3,$_SESSION['PDF_sumas'][0]['suma_act_valor'],'B',0,'R');  
//	$pdf->Cell(15,3,'','B',0,'C');  
//	$pdf->Cell(15,3,'','B',0,'C'); 
//	$pdf->Cell(15,3,$_SESSION['PDF_sumas'][0]['suma_act_dep'],'B',0,'R');  
//	$pdf->Cell(20,3,'','B',0,'C');  
//	$pdf->Cell(15,3,$_SESSION['PDF_sumas'][0]['suma_dep_mensual'],'B',0,'R');   
//	$pdf->Cell(20,3,'','B',0,'C');  
//	$pdf->Cell(15,3,'','B',0,'C');  
//	$pdf->Cell(10,3,'','B',0,'C'); 
//	$pdf->Cell(15,3,'','B',0,'C');  
//	$pdf->Cell(15,3,'','B',0,'C');  
//	$pdf->Cell(20,3,'','BR',1,'C');		 
		 
	$pdf->Output();		
?>

