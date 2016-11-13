<?php

session_start();
/**
 * Autor: Silvia Ximena Ortiz Fernández
 * Fecha de creacion: 06/01/2011
 * Descripción: Reporte de activo_fijo_detalle_empleado
 * **/

require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
 
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
	/*echo $_SESSION['PDF_id_deposito'];
	exit;*/
	 $this->Image('../../../../lib/images/logo_reporte.jpg',230,2,35,15);
	 $this->Ln(5);
	 $this->SetFont('Arial','B',8);
	 $this->SetX(15);
	 $this->Ln(1.5);
	 
	/*echo $_SESSION['PDF_sw_activo_clasificacion];
	exit;*/ 
	
	
	
	
	
	 	if($_SESSION['PDF_sw_activo_clasificacion']==0||$_SESSION['PDF_sw_activo_clasificacion']==3)
		{ 		 if ($_SESSION['PDF_sw_activo_clasificacion']==3){
					$this->SetFont('Arial','B',16);
	 			$this->Cell(0,6,'DETALLE DE ACTIVO FIJO POR CUSTODIO',0,1,'C');
		 		$this->SetFont('Arial','B',8);
		 		$this->Cell(30,4,'CUSTODIO',0,0);
		 		$this->SetFont('Arial','',8);
		 		$this->Cell(105,4,$_SESSION['PDF_desc_per'],0,1);
	
				}else{
			        $this->SetFont('Arial','B',16);
	 		   	$this->Cell(0,6,'DETALLE DE ACTIVO FIJO POR EMPLEADO',0,1,'C');
		 		$this->SetFont('Arial','B',8);
		 		$this->Cell(30,4,'EMPLEADO',0,0);
		 		$this->SetFont('Arial','',8);
		 		$this->Cell(105,4,$_SESSION['PDF_desc_empleado'],0,1);
	
				}
					}
		else
		{
				$this->SetFont('Arial','B',16);
	 			$this->Cell(0,6,'DETALLE DE ACTIVO FIJO EN DEPOSITO',0,1,'C');
		 		$this->SetFont('Arial','B',8);
		 		$this->Cell(30,4,'DEPOSITO',0,0);
		 		$this->SetFont('Arial','',8);
		 		$this->Cell(105,4,$_SESSION['PDF_desc_deposito'],0,1);
		}
	 
	 
	 
	 $this->Cell(30,3,'',0,1);
	 
	
	 $this->Cell(15,3,'CODIGO','TRL',0,'C'); 
	 $this->Cell(30,3,'SUBTIPO','TRL',0,'C'); 
	 $this->Cell(35,3,'DENOMINACIÓN ','TRL',0,'C'); 
	 $this->Cell(80,3,'DESCRIPCIÓN ','TRL',0,'C'); 
	 $this->Cell(15,3,'ESTADO','TRL',0,'C'); 
	 $this->Cell(20,3,'PRESTAMO','TRL',0,'C');  
	 $this->Cell(20,3,'FECHA MAX','TRL',0,'C');  
	 $this->Cell(50,3,'OBSERVACIONES','TRL',1,'C');   
	
	 //265
	 
	 $this->Cell(15,3,'','BRL',0,'C');  
	 $this->Cell(30,3,'','BRL',0,'C');  
	 $this->Cell(35,3,'','BRL',0,'C');
	 $this->Cell(80,3,'','BRL',0,'C');
	 $this->Cell(15,3,'','BRL',0,'C');
	 $this->Cell(20,3,'','BRL',0,'C');	
	 $this->Cell(20,3,'DEVOLUCION','BRL',0,'C');  
	 $this->Cell(50,3,'','BRL',1,'C'); 
	 
	 
	 
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
    $pdf->AddPage();
    
    
 $pdf->SetWidths(array(0,0,15,30,35,80,15,20,20,50));
 $pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0));
 $pdf->SetAligns(array('L','L','L','L','L','L','L','L','L'));
 $pdf->SetVisibles(array(0,0,1,1,1,1,1,1,1,1));
 $pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6));
 $pdf->SetFontsStyles(array('','','','','','','','','','',''));
 $pdf->SetDecimales(array(0,0,0,0,0,0,0,0,0,0,0));
 $pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3));
 $pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0));
 
$v_setdetalle=$_SESSION['PDF_activo_fijo_empleado_detalle'];


 for ($i=0;$i<sizeof($v_setdetalle);$i++){
 	$pdf->SetLineWidth(0.05);
 	
 	  $pdf->MultiTabla($v_setdetalle[$i],0,3,3,6,1);
 	  
  }
 
$pdf->SetFont('Arial','',10); 	   
$y=$pdf->GetY();
$posy1=$y;

	
$altura=$pdf->h;
$margen_inf=$pdf->lMargin;
$tope_inf=$altura-$margen_inf;

if(($tope_inf-$y)<$margen_inf){
	$pdf->SetXY(0,($altura-$y-25));
}else{
	$pdf->SetXY(0,$y);
}
//
//$pdf->MultiCell(0,4,"\n\n\n\n____________________________"."\n"."Responsable de Planilla",'','C',0); 

	  
	  
$pdf->Output();


?>