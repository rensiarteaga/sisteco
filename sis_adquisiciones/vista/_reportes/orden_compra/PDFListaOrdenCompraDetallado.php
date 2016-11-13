<?php

session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de creacion: 08/03/2010
 * Descripción: Reporte de Listado Ordenes de compra a detalle
 * Fecha de modificacion: 27/07/2010
 * **/

require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
 
class PDF extends FPDF
{   
	function PDF($orientation='L',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
   // $this-> AddFont('Arial','','arial.php');
 
    //Iniciación de variables
    }



function Header()
{       
   $this->Image('../../../../lib/images/logo_reporte.jpg',230,2,35,15);
  
    $this->Ln(5);
    $this->SetFont('Arial','B',16);
 	$this->Cell(0,6,'LISTADO DE ORDENES DE COMPRA A DETALLE ',0,1,'C');
 	$this->SetFont('Arial','B',10);
 	if($_SESSION['PDF_tipo_adq']=='Bien'){
 		$this->Cell(0,4,'BIENES',0,1,'C');
 	}elseif($_SESSION['PDF_tipo_adq']=='Servicio'){
 		$this->Cell(0,4,'SERVICIOS',0,1,'C');
 	}else{
 		$this->Cell(0,4,'BIENES Y SERVICIOS',0,1,'C');
 	}
	
	$this->SetFont('Arial','',10);
	$this->Cell(0,4,'DEL '.$_SESSION['PDF_rep_fecha_inicio'].' AL '.$_SESSION['PDF_rep_fecha_fin'],0,1,'C');
	$this->SetFont('Arial','B',10);
 	$this->SetX(15);
 	$this->Ln(1.5);


	$this->Ln(2);

 $this->Ln(1);
 $this->SetFont('Arial','B',7);
 $this->SetLineWidth(0.2);
 
 $this->Cell(35,4,'Estructura Prográmatica: ',0,0);
 $this->SetFont('Arial','',7);
 $this->Cell(120,4,utf8_decode($_SESSION['PDF_desc_ep']),0,0);
 $this->SetFont('Arial','B',7);
 $this->Cell(25,4,'Departamento: ',0,0);
 $this->SetFont('Arial','',7);
 $this->Cell(90,4,utf8_decode($_SESSION['PDF_departamento']),0,1);
 $this->SetFont('Arial','B',7);
 $this->Cell(35,4,'Unidad Organizacional: ',0,0);
 $this->SetFont('Arial','',7);
 $this->Cell(120,4,utf8_decode($_SESSION['PDF_unidad_organizacional']),0,0);
 $this->SetFont('Arial','B',7);
 $this->Cell(25,4,'Proveedor: ',0,0);
 $this->SetFont('Arial','',7);
 $this->Cell(90,4,utf8_decode($_SESSION['PDF_nombre_proveedor']),0,1);
 
  $this->SetWidths(array(0,7,50,12,25,13,21,40,40,10,15,15,0,0,12,12));
   $this->SetAligns(array('R','L','L','L','L','L','L','L','L','R','R','R','R','R','R'));
       $this->SetVisibles(array(0,1,1,1,1,1,1,1,1,1,1,1,0,0,1,1));
       $this->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
       $this->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5));
       $this->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
       $this->setDecimales(array(0,0,0,0,0,0,0,0,0,0,2,2,2,2,2,2));
       $this->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,1,1,1,1,1,1,1,1));
     
 
 
    $this->SetFont('Arial','B',7);
	$this->Cell(7,4,'Nº OC','LTR',0,'C');
	$this->Cell(50,4,'DESCRIPCIÓN','LTR',0,'C');
	$this->Cell(12,4,'FECHA','TR',0,'C');
	$this->Cell(25,4,'CATEGORIA','TR',0,'C');
	$this->Cell(13,4,'ESTADO','TR',0,'C');
	$this->Cell(21,4,'CODIGO','TR',0,'C');
	$this->Cell(40,4,'PROVEEDOR','TR',0,'C');
	$this->Cell(40,4,'OBSERVACIONES','TR',0,'C');
	$this->Cell(10,4,'CANT.','TR',0,'C');
	$this->Cell(15,4,'IMPORTE','TR',0,'C');
	$this->Cell(15,4,'IMPORTE','TR',0,'C');
	$this->Cell(12,4,'TOTAL','TR',0,'C');
	$this->Cell(12,4,'TOTAL','TR',1,'C');
	
	
    $this->Cell(7,4,'','LRB',0,'C');
    $this->Cell(50,4,'','RB',0,'C');
	$this->Cell(12,4,'','RB',0,'C');
	$this->Cell(25,4,'COMPRA','RB',0,'C');
	$this->Cell(13,4,'PROCESO','RB',0,'C');
	$this->Cell(21,4,'PROCESO','RB',0,'C');
	$this->Cell(40,4,'','RB',0,'C');
	$this->Cell(40,4,'','RB',0,'C');
	$this->Cell(10,4,'','RB',0,'C');
	$this->Cell(15,4,'UNITARIO','RB',0,'C');
	$this->Cell(15,4,'TOT. Bs','RB',0,'C');
	$this->Cell(12,4,'DEV Bs','RB',0,'C');
	$this->Cell(12,4,'PAG Bs.','RB',1,'C');
 
 //$this->Ln(0.3);
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
		$this->Cell(100,3,'Sistema: ENDESIS -COMPRO',0,0,'L');
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

$pdf->SetLineWidth(.1);


	   $pdf->SetWidths(array(0,7,50,12,25,13,21,40,40,10,15,15,0,0,12,12));
       $pdf->SetAligns(array('R','L','L','L','L','L','L','L','L','R','R','R','R','R','R','R'));
       $pdf->SetVisibles(array(0,1,1,1,1,1,1,1,1,1,1,1,0,0,1,1));
       $pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
       $pdf->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5));
       $pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
       $pdf->setDecimales(array(0,0,0,0,0,0,0,0,0,0,2,2,2,2,2,2,2,2,2));
        	//en $data llegara toda la información.
         $total_dev=0; $total_pag=0;
	   $v_setdetalle=$_SESSION['PDF_ordenes_compra']; //print_r($v_setdetalle); exit;
       for ($i=0;$i<count($v_setdetalle);$i++){
	       $pdf->MultiTabla($v_setdetalle[$i],1,3,3,5,1);
	       $total_dev=$total_dev+$v_setdetalle[$i][14];
	       $total_pag=$total_pag+$v_setdetalle[$i][15];
      }
   
      $pdf->Cell(248,4,'','LRB',0,'C');
      $pdf->SetFont('Arial','B',5);
    //  $pdf->setDecimales(2,2);
     // $pdf->SetFormatNumber(1);
     // $pdf->MultiCell(12,4,is_numeric($total_dev)?number_format($total_dev,2):$total_dev,1,'R',0);
      
      $pdf->Cell(12,4,is_numeric($total_dev)?number_format($total_dev,2):$total_dev,1,0,'R',0);
      $pdf->Cell(12,4,is_numeric($total_pag)?number_format($total_pag,2):$total_pag,1,2,'R',0);
     // $pdf->MultiCell(12,4,is_numeric($total_pag)?number_format($total_pag,2):$total_pag,1,'R',0);

      
     // $pdf->Cell(12,4,''.$total_dev.'','LRB',0,'C');
      //$pdf->Cell(12,4,''.$total_pag.'','LRB',0,'C');

$pdf->Output();


?>