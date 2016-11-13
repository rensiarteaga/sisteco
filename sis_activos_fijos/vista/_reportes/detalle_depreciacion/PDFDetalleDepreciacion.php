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
    
    	$pdf->SetLeftMargin(12);
    	//  TITULO
	    
	    $pdf->SetFont('Arial','B',16);
	 	$pdf->Cell(0,6,'DETALLE DE DEPRECIACIÓN',0,1,'C');
	 	$pdf->SetFont('Arial','B',8);
	 	$pdf->Cell(0,5,'Del: '.$_SESSION['PDF_fecha_desde'].'    Al: '.$_SESSION['PDF_fecha_hasta'],0,1,'C');
	 	$pdf->SetFont('Arial','B',8);
	 	$pdf->Cell(0,5,'(Expresado en Bolivianos)',0,1,'C'); 	 	
	 	
	 	// FIN TITULO
	 		 	
	 	$pdf->SetFont('Arial','B',8);
	 	$pdf->Cell(35,5,'CÓDIGO ACTIVO FIJO:',0,0,'L');
	 	$pdf->SetFont('Arial','',8);
	 	$pdf->Cell(20,5,trim($_SESSION['PDF_codigo']),0,0,'L');
	 	
	 	$pdf->setX(150);
	 	$pdf->SetFont('Arial','B',8);
	 	$pdf->Cell(35,5,'DENOMINACIÓN:',0,0,'R');
	 	$pdf->SetFont('Arial','',8);
	 	$pdf->Cell(55,5,trim($_SESSION['PDF_descripcion']),0,1,'L');
	 	
	 	$pdf->SetFont('Arial','B',8);
	 	$pdf->Cell(35,5,'DESCRIPCIÓN:',0,0,'L');
	 	$pdf->SetFont('Arial','',8);
	 	$pdf->MultiCell(200,5,trim($_SESSION['PDF_descripcion_larga']),0);
	 	
	 	$pdf->SetFont('Arial','B',8);
	 	$pdf->Cell(35,5,'TIPO ACTIVO FIJO:',0,0,'L');
	 	$pdf->SetFont('Arial','',8);
	 	$pdf->Cell(50,5,trim($_SESSION['PDF_tipo']),0,1,'L');
	 	
	 	$pdf->SetFont('Arial','B',8);
	 	$pdf->Cell(35,5,'SUBTIPO ACTIVO FIJO:',0,0,'L');
	 	$pdf->SetFont('Arial','',8);
	 	$pdf->Cell(145,5,trim($_SESSION['PDF_subtipo']),0,0,'L');
	 	 	
	 	$pdf->setX(160);
	 	$pdf->SetFont('Arial','B',8);
	 	$pdf->Cell(33,5,'VIDA ÚTIL ORIGINAL:',0,0,'L');
	 	$pdf->SetFont('Arial','',8);
	 	$pdf->Cell(30,5,trim($_SESSION['PDF_vida_util_original']),0,1,'L');
	 	
	 	$pdf->SetFont('Arial','B',8);
	 	$pdf->Cell(35,5,'MONTO COMPRA: ',0,0,'L');
	 	$pdf->SetFont('Arial','',8);
	 	$pdf->Cell(145,5,trim($_SESSION['PDF_monto_compra']),0,0,'L');
	 	
	 	$pdf->setX(160);
	 	$pdf->SetFont('Arial','B',8);
	 	$pdf->Cell(33,5,'FECHA INICIO DEP: ',0,0,'L'); 	
	 	$pdf->SetFont('Arial','',8);
	 	$pdf->Cell(30,5,trim($_SESSION['PDF_fecha_inidep']),0,1,'L'); 
	 	
		 $pdf->SetLineWidth(0.2);
		 
		 $pdf->SetFont('Arial','B',7);
		 $pdf->SetWidths(array(15,20,23,15,23,23,25,20,23,15,13,20,20));
		 $pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0,0));
		 $pdf->SetAligns(array('C','R','R','R','R','R','R','R','R','R','R','R','R'));
		 $pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1,1));
		 $pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6,6,6));
		 $pdf->SetFontsStyles(array('','','','','','','','','','','','',''));
		 $pdf->SetDecimales(array(0,0,0,0,0,0,0,0,0,0,0,0,0));
		 $pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3));
		 $pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
		 $pdf->Ln(2);
		 
		//primera linea 
		 $pdf->Cell(15,3,'FECHA','TRL',0,'C');  //1
		 $pdf->Cell(20,3,'VALOR','TRL',0,'C');  //2
		 $pdf->Cell(23,3,'ACTUALIZACION','TRL',0,'C');  //3
		 $pdf->Cell(15,3,'VALOR','TRL',0,'C');  //4
		 $pdf->Cell(23,3,'DEPREC. ACUM','TRL',0,'C');//5 
		 $pdf->Cell(23,3,'ACTUALIZACION','TRL',0,'C');  //6
		 $pdf->Cell(25,3,'DEPREC. ACUM','TRL',0,'C');  //7
		 $pdf->Cell(20,3,'DEPRECIACION','TRL',0,'C');   //8
		 $pdf->Cell(23,3,'DEPRECIACION','TRL',0,'C');  //9
		 $pdf->Cell(15,3,'VALOR','TRL',0,'C');  //10
		 $pdf->Cell(13,3,'VIDA','TRL',0,'C'); //11
		 $pdf->Cell(20,3,'TIPO CAMBIO','TRL',0,'C'); //12 
		 $pdf->Cell(20,3,'TIPO CAMBIO','TRL',0,'C');  //13
		// $pdf->Cell(20,3,'FACTOR','TRL',1,'C');//14
		 $pdf->Ln(3);
		//segunda linea 
		 $pdf->Cell(15,3,'','BRL',0,'C');  //1
		 $pdf->Cell(20,3,'CONTABLE','BRL',0,'C');//2  
		 $pdf->Cell(23,3,'','BRL',0,'C');  //3
		 $pdf->Cell(15,3,'TOTAL','BRL',0,'C'); //4 
		 $pdf->Cell(23,3,'INICIAL','BRL',0,'C'); //5
		 $pdf->Cell(23,3,'DEPRECIACION','BRL',0,'C');  //6
		 $pdf->Cell(25,3,'ACTUALIZADA','BRL',0,'C');//7  
		 $pdf->Cell(20,3,'PERIODO','BRL',0,'C');   //8
		 $pdf->Cell(23,3,'ACUMULADA','BRL',0,'C');  //9
		 $pdf->Cell(15,3,'NETO','BRL',0,'C');  //10
		 $pdf->Cell(13,3,'ÚTIL','BRL',0,'C'); //11
		 $pdf->Cell(20,3,'INICIAL','BRL',0,'C');  //12
		 $pdf->Cell(20,3,'FINAL','BRL',0,'C');  //13
		// $pdf->Cell(20,3,'ACTUALIZ','BRL',1,'C');	//14
		 $pdf->Ln(3);
		 
		 $v_cabecera = $_SESSION['PDF_cabecera'];
		 
		 for ($i=0;$i<sizeof($v_cabecera);$i++)
		 {
		 	//$pdf->MultiTabla($v_cabecera[$i],0,3,3,6,1); 
		 	
		 	$pdf->SetWidths(array(15,20,23,15,23,23,25,20,23,15,13,20,20));
			$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0));
			$pdf->SetAligns(array('C','R','R','R','R','R','R','R','R','R','R','R','R'));
			$pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1,1));
			$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6,6));
			$pdf->SetFontsStyles(array('','','','','','','','','','','','',''));
			$pdf->SetDecimales(array(0,2,2,2,2,2,2,2,2,2,2,6,6));
			$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3));
			$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
			
			$v_cuerpo = $_SESSION['PDF_cuerpo_'.$i];
			
			for($j=0;$j<sizeof($v_cuerpo);$j++)
			 {
//			 	$numero=$j+1;
//			    $pdf->MultiTabla((array_merge((array)$numero,(array)$v_cuerpo[$j])),1,1,4,8);

				$pdf->MultiTabla($v_cuerpo[$j],0,3,3,6,1);
				
				//añadido sumatorias
				$sum_actualizacion=$sum_actualizacion + $v_cuerpo[$j]['2'];
				$sum_act_deprec=$sum_act_deprec + $v_cuerpo[$j]['5'];
				$sum_deprec_periodo=$sum_deprec_periodo + $v_cuerpo[$j]['7'];
			 }
		 }             	

	$pdf->SetFont('Arial','B',6);
  	$pdf->Cell(15,3,'TOTALES','BL',0,'C');  
 	$pdf->Cell(20,3,'','B',0,'C');  
	//$pdf->Cell(23,3,$_SESSION['PDF_sumas'][0]['suma_act_valor'],'B',0,'R');  $sum_actualizacion
 	$pdf->Cell(23,3,$sum_actualizacion,'B',0,'R');
	$pdf->Cell(15,3,'','B',0,'C');  
	$pdf->Cell(23,3,'','B',0,'C'); 
	//$pdf->Cell(23,3,$_SESSION['PDF_sumas'][0]['suma_act_dep'],'B',0,'R');  
	$pdf->Cell(23,3,$sum_act_deprec,'B',0,'R');
	$pdf->Cell(25,3,'','B',0,'C');  
	//$pdf->Cell(20,3,$_SESSION['PDF_sumas'][0]['suma_dep_mensual'],'B',0,'R');   
	$pdf->Cell(20,3,$sum_deprec_periodo,'B',0,'R');
	$pdf->Cell(20,3,'','B',0,'C');  
	$pdf->Cell(23,3,'','B',0,'C');  
	$pdf->Cell(15,3,'','B',0,'C'); 
	$pdf->Cell(13,3,'','B',0,'C');  
	$pdf->Cell(20,3,'','BR',1,'C');  
	//$pdf->Cell(20,3,'','BR',1,'C');		 
		 
	$pdf->Output();		
?>

