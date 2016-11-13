<?php
session_start();
/**
 * Autor: Marcos A. Flores Valda
 * Fecha de creacion: 07/01/2011
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
  
	   	//  TITULO
	    $this->Ln(5);
	    $this->SetFont('Arial','B',16);
	 	$this->Cell(0,6,'DETALLE DE DEPRECIACIÓN',0,1,'C');
	 	$this->SetFont('Arial','B',8);
	 	$this->Cell(0,5,'Del: '.$_SESSION['PDF_fecha_desde'].'    Al: '.$_SESSION['PDF_fecha_hasta'],0,1,'C');
	 	$this->SetFont('Arial','B',8);
	 	$this->Cell(0,5,'(Expresado en Bolivianos)',0,1,'C'); 	 	
	 	
	 	// FIN TITULO
	 		 	
	 	$this->SetFont('Arial','B',8);
	 	$this->Cell(35,5,'CÓDIGO ACTIVO FIJO:',0,0,'L');
	 	$this->SetFont('Arial','',8); 	
	 	$this->Cell(20,5,trim($_SESSION['PDF_codigo']),0,0,'L');
	 	
	 	$this->SetFont('Arial','B',8);
	 	$this->Cell(35,5,'DENOMINACIÓN:',0,0,'R');
	 	$this->SetFont('Arial','',8);
	 	$this->Cell(55,5,trim($_SESSION['PDF_descripcion']),0,1,'L');
	 	
	 	$this->SetFont('Arial','B',8);
	 	$this->Cell(35,5,'DESCRIPCIÓN:',0,0,'L');
	 	$this->SetFont('Arial','',8);
	 	$this->MultiCell(200,5,trim($_SESSION['PDF_descripcion_larga']),0);
	 	
	 	$this->SetFont('Arial','B',8);
	 	$this->Cell(35,5,'TIPO ACTIVO FIJO:',0,0,'L');
	 	$this->SetFont('Arial','',8);
	 	$this->Cell(50,5,trim($_SESSION['PDF_tipo']),0,1,'L');
	 	
	 	$this->SetFont('Arial','B',8);
	 	$this->Cell(35,5,'SUBTIPO ACTIVO FIJO:',0,0,'L');
	 	$this->SetFont('Arial','',8);
	 	$this->Cell(145,5,trim($_SESSION['PDF_subtipo']),0,0,'L');
	 	 	
	 	$this->SetFont('Arial','B',8);
	 	$this->Cell(33,5,'VIDA ÚTIL ORIGINAL:',0,0,'L');
	 	$this->SetFont('Arial','',8);
	 	$this->Cell(30,5,trim($_SESSION['PDF_vida_util_original']),0,1,'L');
	 	
	 	$this->SetFont('Arial','B',8);
	 	$this->Cell(35,5,'MONTO COMPRA: ',0,0,'L');
	 	$this->SetFont('Arial','',8);
	 	$this->Cell(145,5,trim($_SESSION['PDF_monto_compra']),0,0,'L');
	 	
	 	$this->SetFont('Arial','B',8);
	 	$this->Cell(33,5,'FECHA INICIO DEP: ',0,0,'L'); 	
	 	$this->SetFont('Arial','',8);
	 	$this->Cell(30,5,trim($_SESSION['PDF_fecha_ini_dep']),0,1,'L'); 
	 	
		 $this->SetLineWidth(0.2);
		 
		 $this->SetFont('Arial','B',7);
		 $this->SetWidths(array(15,20,15,15,15,15,20,15,20,15,10,15,15,20));
		 $this->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0));
		 $this->SetAligns(array('C','R','R','R','R','R','R','R','R','R','R','R','R','R'));
		 $this->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1,1,1));
		 $this->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6,6,6));
		 $this->SetFontsStyles(array('','','','','','','','','','','','','',''));
		 $this->SetDecimales(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0));
		 $this->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3));
		 $this->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
		 $this->Ln(2);
		 
		//primera linea 
		 $this->Cell(15,3,'FECHA','TRL',0,'C');  
		 $this->Cell(20,3,'VALOR','TRL',0,'C');  
		 $this->Cell(15,3,'ACTUALIZ','TRL',0,'C');  
		 $this->Cell(15,3,'VALOR','TRL',0,'C');  
		 $this->Cell(15,3,'DEP ACUM','TRL',0,'C'); 
		 $this->Cell(15,3,'ACTUALIZ','TRL',0,'C');  
		 $this->Cell(20,3,'DEP ACUM','TRL',0,'C');  
		 $this->Cell(15,3,'DEP','TRL',0,'C');   
		 $this->Cell(20,3,'DEP','TRL',0,'C');  
		 $this->Cell(15,3,'VALOR','TRL',0,'C');  
		 $this->Cell(10,3,'VIDA','TRL',0,'C'); 
		 $this->Cell(15,3,'T CAMBIO','TRL',0,'C');  
		 $this->Cell(15,3,'T CAMBIO','TRL',0,'C');  
		 $this->Cell(20,3,'FACTOR','TRL',1,'C');
	
		//segunda linea 
		 $this->Cell(15,3,'','BRL',0,'C');  
		 $this->Cell(20,3,'CONTABLE','BRL',0,'C');  
		 $this->Cell(15,3,'','BRL',0,'C');  
		 $this->Cell(15,3,'TOTAL','BRL',0,'C');  
		 $this->Cell(15,3,'INICIAL','BRL',0,'C'); 
		 $this->Cell(15,3,'','BRL',0,'C');  
		 $this->Cell(20,3,'ACTUALIZ','BRL',0,'C');  
		 $this->Cell(15,3,'MENSUAL','BRL',0,'C');   
		 $this->Cell(20,3,'ACUMULADA','BRL',0,'C');  
		 $this->Cell(15,3,'NETO','BRL',0,'C');  
		 $this->Cell(10,3,'ÚTIL','BRL',0,'C'); 
		 $this->Cell(15,3,'INICIAL','BRL',0,'C');  
		 $this->Cell(15,3,'FINAL','BRL',0,'C');  
		 $this->Cell(20,3,'ACTUALIZ','BRL',1,'C');	 		  
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
       
    $pdf->fecha_desde=$fecha_desde;	    
    $pdf->fecha_hasta=$fecha_hasta;
    $pdf->financiador=$financiador;
	$pdf->regional=$regional;
	$pdf->programa=$programa;
	$pdf->proyecto=$proyecto;
	$pdf->actividad=$actividad;
	$pdf->tipo=$tipo;
	$pdf->subtipo=$subtipo;
	$pdf->descripcion=$descripcion;
	$pdf->codigo=$codigo;
	$pdf->descripcion_larga=$descripcion_larga;
	$pdf->monto_compra=$monto_compra;
	$pdf->vida_util_original=$vida_util_original;
	$pdf->fecha_ini_dep=$fecha_ini_dep;
	    
	$pdf->AddPage();

	$pdf->SetWidths(array(15,20,15,15,15,15,20,15,20,15,10,15,15,20));
	$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0));
	$pdf->SetAligns(array('C','R','R','R','R','R','R','R','R','R','R','R','R','R'));
	$pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1,1,1));
	$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6,6,6));
	$pdf->SetFontsStyles(array('','','','','','','','','','','','','',''));
	$pdf->SetDecimales(array(0,2,2,2,2,2,2,2,2,2,2,6,6,6));
	$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3));
	$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));

	$depre=$_SESSION['PDF_detalledep'];
	
	for ($i=0;$i<sizeof($depre);$i++)   	$pdf->MultiTabla($depre[$i],0,3,3,6,1); 	

	$pdf->SetFont('Arial','B',6);
    $pdf->Cell(15,3,'TOTALES','BL',0,'C');  
 	$pdf->Cell(20,3,'','B',0,'C');  
	$pdf->Cell(15,3,$_SESSION['PDF_sumas'][0]['suma_act_valor'],'B',0,'R');  
	$pdf->Cell(15,3,'','B',0,'C');  
	$pdf->Cell(15,3,'','B',0,'C'); 
	$pdf->Cell(15,3,$_SESSION['PDF_sumas'][0]['suma_act_dep'],'B',0,'R');  
	$pdf->Cell(20,3,'','B',0,'C');  
	$pdf->Cell(15,3,$_SESSION['PDF_sumas'][0]['suma_dep_mensual'],'B',0,'R');   
	$pdf->Cell(20,3,'','B',0,'C');  
	$pdf->Cell(15,3,'','B',0,'C');  
	$pdf->Cell(10,3,'','B',0,'C'); 
	$pdf->Cell(15,3,'','B',0,'C');  
	$pdf->Cell(15,3,'','B',0,'C');  
	$pdf->Cell(20,3,'','BR',1,'C');		 
		 
	$pdf->Output();		
?>