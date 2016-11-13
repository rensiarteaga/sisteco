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
    $this-> AddFont('Arial','','arial.php');
 
    //Iniciaci�n de variables
    }

	function Header()
	{      
		
	
	 $fecha=date("d-m-Y");	
	 
	 
	 $this->Image('../../../../lib/images/logo_reporte.jpg',180,2,35,15);
	 $this->Ln(5);
	 $this->SetFont('Arial','B',5);
	 $this->SetX(15);
	 $this->Ln(1.5); 
	 $this->SetY($this->GetY()+10);
	 
	 $this->SetFont('Arial','B',9);
	 $this->Cell(0,6,'DETALLE ACTIVOS FIJOS COSERELEC' ,0,1,'C');
	 
	 
	

	 
	}
	//Pie de p�gina
	function Footer()
	{
	    //Posici�n: a 1,5 cm del final
	    $fecha=date("d-m-Y");
		$hora=date("H:i:s");
		
			$this->SetY(-7);
	   	    $this->SetFont('Arial','',6);
	   	    $this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
			$this->Cell(55,3,'P�gina '.$this->PageNo().' de {nb}',0,0,'C');
			$this->Cell(50,3,'',0,0,'L');
			$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
			$this->ln(3);
			$this->Cell(70,3,'Sistema: ENDESIS - ACTIVOS FIJOS',0,0,'L');
			$this->Cell(50,3,'',0,0,'C');
			$this->Cell(55,3,'',0,0,'L');
			$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
		
	        
	}
}

	function mostrarCabecera(PDF $pdf){
		
		$pdf->SetFont('Arial','B',5);
		
		$pdf->SetFillColor(230, 230, 230);
		$pdf->Cell(9,2,'N�','LTR',0,'C',true);
		$pdf->Cell(30,2,'CODIGO ACTIVO FIJO','LTR',0,'C',true);
		//$pdf->Cell(30,2,'DENOMINACION','LTR',0,'C',true);
		$pdf->Cell(125,2,'DESCRIPCION','LTR',0,'C',true);
		$pdf->Cell(30,2,'MONTO DE COMPRA','LTR',0,'C',true);
		//$pdf->Cell(30,2,'PROYECTO','LTR',0,'C',true);
		$pdf->Ln();
		
		
	}

	$detalle = $_SESSION['PDF_Detalle_Activos_Por_Activo'] ;
	$activo = $_SESSION['PDF_Activos_Todos'];
	
	if($activo == null)
		$activo = $detalle[0][0];
		
	
	$fecha=date("d-m-Y");
	
    $pdf=new PDF();	
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,7);
    $pdf->SetMargins(10,5,12);  
	
	$pdf->AddPage();
	
	$pdf->SetFillColor(200, 200, 200);
	$pdf->SetFont('Arial','B',6);
	
	$pdf->SetY($pdf->GetY()+3);
	
	$pdf->Cell(0,3,'DATOS GENERALES',1,1,'C',true);
	$pdf->Ln(1);
	$pdf->SetFillColor(230, 230, 230);
	$pdf->Cell(40,3,'DEPARTAMENTO AF: ',0,0,'L');
	$pdf->Cell(40,3,'Departamento de Activos Fijos Central ',0,0,'L',true);
	$pdf->Cell(40,3,'',0,0,'C');
	$pdf->Cell(41,3,'ACTIVOS: ',0,0,'C');
	$pdf->Cell(33,3,'No Proyectos',0,1,'C',true);
	$pdf->Cell(40,3,'FECHA:',0,0,'L');
	$pdf->Cell(40,3,$fecha,0,1,'L',true);
	$pdf->Ln(1);
	$pdf->SetFillColor(200, 200, 200);
	$pdf->Cell(0,3,'',1,1,'C',true);
	$pdf->Ln(2);
	
	
	
	/*$pdf->Cell(24,3,'CUSTODIO: ',1,0,'L');
	$pdf->Cell(67,3,$custodio,1,1,'L',true);
	mostrarCabecera($pdf);*/
	
	mostrarCabecera($pdf);
	
    $pdf->SetWidths(array(9,30,125,30));
	$pdf->SetFills(array(0,0,0,0));
 	$pdf->SetAligns(array('R','L','L','L'));
 	$pdf->SetVisibles(array(1,1,1,1));
  	$pdf->SetFontsSizes(array(6,6,6,6));
 	$pdf->SetFontsStyles(array('','','',''));
 	$pdf->SetSpaces(array(3,3,3,3));
 	$pdf->setDecimales(array(0,0,0,0));
    $pdf->SetFormatNumber(array(0,0,0,0));

	$cont = 0;	
	
	
 	 		for ($i=0;$i<count($detalle);$i++){	 
 	 			
 	 			$pdf->SetLineWidth(0.05);

 	 			$pdf->SetFillColor(230, 230, 230);
 	 			$cont += 1; 
 	 			array_unshift($detalle[$i],$cont);
				
 	 			if($pdf->GetY() >= 250)	{
 	 				
 	 				$pdf->AddPage();
 	 				mostrarCabecera($pdf);
 	 			}
 	 			
 	 				$pdf->MultiTabla($detalle[$i],0,3,3,6);
 	 			
 	 		 	 		
 	 			$pdf->SetLineWidth(0.1);
 	 			                  
 	 		}

	$pdf->AliasNbPages();
	$pdf->Output();


?>