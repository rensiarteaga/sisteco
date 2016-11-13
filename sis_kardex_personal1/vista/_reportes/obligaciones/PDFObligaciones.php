<?php
session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de creacion: 17/01/2011
 * Descripción: Reporte de Obligaciones por planilla
 * **/

require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
 
class PDF extends FPDF
{   
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    $this-> AddFont('Arial','','arial.php');
 
    //Iniciación de variables
    }



function Header()
{       
    
	$this->Image('../../../../lib/images/logo_reporte.jpg',190,2,25,10);
     $cabecera=$_SESSION['PDF_cab_obligacion_planilla'];
 
   // $this->Ln(5);
    $this->SetFont('Arial','B',7);
     $this->Cell(50,5,$cabecera[0]['nombre_depto'],0,1);
         $this->SetFont('Arial','B',13);
 	$this->Cell(0,10,'DETALLE DE OBLIGACIONES POR PLANILLA DE SUELDO ',0,1,'C');
 	$this->SetFont('Arial','',9);
 	$this->Cell(0,4,$cabecera[0]['periodo'].' de '.$cabecera[0]['gestion'],0,1,'C');
 	$this->SetFont('Arial','',7);
 	$this->Cell(100,3,'',0,0,'C');
	$this->Cell(50,3,'t/c:',0,0,'R');
	$this->Cell(50,3,$cabecera[0]['t_c'],0,1,'R');

 $this->SetLineWidth(0.2);
 
 $this->SetFont('Arial','B',7);
 $this->SetWidths(array(60,20,20,20,20,20,20,20));
 $this->SetFills(array(0,0,0,0,0,0,0));
 $this->SetAligns(array('L','R','R','L','L','L','R','R'));
 $this->SetVisibles(array(1,1,1,1,1,1,1,1));
 $this->SetFontsSizes(array(6,6,6,6,6,6,6,6));
 $this->SetFontsStyles(array('','','','','','','',''));
 $this->SetDecimales(array(0,2,2,0,0,0,2,2));
 $this->SetSpaces(array(3,3,3,3,3,3,3,3));
 $this->SetFormatNumber(array(0,1,1,0,0,0,1,1));
 
 //$this->Cell(30,4,'Desc. Devengado:',0,0);
 //$this->Cell(30,4,'',0,1);
 
 
 $this->Cell(60,3,'CONCEPTO','TRL',0,'C'); 
 $this->Cell(40,3,'PARCIALES','TRL',0,'C');
 $this->Cell(20,3,'CEN.','TL',0,'C');
 $this->Cell(20,3,'CTA. ','T',0,'C');  
 $this->Cell(20,3,'AUX.','T',0,'C');  
 $this->Cell(40,3,'TOTALES','TRL',1,'C');  
 
 
 $this->Cell(60,3,'','BRL',0,'C'); 
 $this->Cell(20,3,'BS.','B',0,'C');
 $this->Cell(20,3,'$US.','B',0,'C'); 
 $this->Cell(60,3,'','BRL',0,'C');  
 $this->Cell(20,3,'BS.','B',0,'C');  
 $this->Cell(20,3,'$US.','BR',1,'C');  
 
 
 
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
   	   // $this->Cell(200,0.2,'',1,1);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - KARDEX',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
        
      }

}

	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,7);
    $pdf->SetMargins(10,5,5);
    $pdf->AddPage();

 $pdf->SetWidths(array(60,20,20,20,20,20,20,20));
 $pdf->SetFills(array(0,0,0,0,0,0,0));
 $pdf->SetAligns(array('L','R','R','L','L','L','R','R'));
 $pdf->SetVisibles(array(1,1,1,1,1,1,1,1));
 $pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6));
 $pdf->SetFontsStyles(array('','','','','','','',''));
 $pdf->SetDecimales(array(0,2,2,0,0,0,2,2));
 $pdf->SetSpaces(array(3,3,3,3,3,3,3,3));
 $pdf->SetFormatNumber(array(0,1,1,0,0,0,1,1));
 //print_r($_SESSION['PDF_obligacion_det']); exit;
 
 
 $v_setdetalle=$_SESSION['PDF_obligacion_det'];
 

  $cabecera=$_SESSION['PDF_cab_obligacion_planilla'];
 $codigo='';
 $detalle=array();
 $l=0;
 $suma_total=0;
 $tipo_pago='externo';
 for ($i=0;$i<sizeof($v_setdetalle);$i++){
 	$pdf->SetLineWidth(0.05);
 	if($v_setdetalle[$i][8]!=$tipo_pago){
 	
 	$pdf->Cell(100,3.5,'','',1);
 	$pdf->Cell(200,0.1,'',1,1);
    $pdf->SetLineWidth(0.2);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(150,3.5,'TOTAL OBLIGACIONES '.$cabecera[0]['periodo'].'/'.$cabecera[0]['gestion'].'','LTB',0);
    $pdf->Cell(50,3.5,number_format($suma_total,2),'TBR',1,'R');
    $pdf->SetLineWidth(0.05);
 	$pdf->Cell(100,3.5,'','',1);
 	
 	}
 	$tipo_pago=$v_setdetalle[$i][8];
 	
 	   if ($v_setdetalle[$i][6]<>0)
 	   {
 	   	$pdf->SetFontsStyles(array('BI','BI','BI','BI','BI','BI','BI','BI'));
 	   

 	   }
 	   	$suma_total=$suma_total+$v_setdetalle[$i][6];
 	   $pdf->MultiTabla($v_setdetalle[$i],0,1,3,6,1);  
 	   $pdf->SetFontsStyles(array('','','','','','','',''));
   }
  // echo $suma_total; exit;
   $pdf->Cell(200,0.1,'',1,1);
   $pdf->SetLineWidth(0.2);
   $pdf->SetFont('Arial','B',6);
   $pdf->Cell(150,3.5,'TOTAL '.$cabecera[0]['periodo'].'/'.$cabecera[0]['gestion'].'','LTB',0);
   $pdf->Cell(50,3.5,number_format($suma_total,2),'TBR',1,'R');
   $pdf->SetLineWidth(0.05);
   $pdf->Cell(100,3.5,'','',0);
   $pdf->Cell(50,3.5,'TOTAL GENERAL PLANILLA','',0);
   $pdf->Cell(50,3.5,number_format($suma_total,2),'',1,'R');
$pdf->Output();
?>