<?php
session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de creacion: 15/08/2011
 * Descripción: Reporte de DetalleBeneficiarios
 * 
 *
 ***/
require('../../../lib/fpdf/fpdf.php');
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

function setTitulo($titulo){
	$this->titulo=$titulo;
	
}

function Header()
{       
  $this->Image('../../../lib/images/logo_reporte.jpg',185,2,25,10);
  $this->SetFont('Arial','B',6);  
  $this->Cell(0,3,'REPORTE CLIENTES BENEFICIARIOS LEY 1886 PARA EL T.G.N.',0,1,'C');
    $this->Cell(0,3,'CORRESPONDIENTE A '.	$_SESSION['PDF_mes_periodo'].'/'.$_SESSION['PDF_anio_periodo'],0,1,'C');
    $this->Cell(0,3,'EXPRESADO EN BOLIVIANOS',0,1,'C');
    if($_SESSION['PDF_tipo_reporte']!='contabilidad'){
             $this->Cell(0,3,'SISTEMA COBIJA',0,1,'C');
   	
    }
    
 
 	//$detalle=$_SESSION["this_detalle_beneficiarios"];
 	if ($this->titulo=='EMPLEADOS INACTIVOS'){
	  $this->Cell(140,3,$this->titulo,0,1);
 	}
 	$this->SetWidths(array(5,12,15,50,10,15,15,15,15,15,15,25));
	$this->SetFills(array(0,0,0,0,0,0,0,0));
 	$this->SetAligns(array('L','C','C','C','C','C','C','C','C','C','C','C','C'));
 	$this->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1));
  	$this->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5,5,5,5));
 	$this->SetFontsStyles(array('B','B','B','B','B','B','B','B','B','B','B','B'));
 	$this->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3));
 	$this->setDecimales(array(0,0,0,0,0,0,0,0,2,2,2,0));
    $this->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0));
    $cabecera=array('Nro.','Nro FACTURA','Nº AUTORIZACIÓN','NOMBRE DE BENEFICIARIO','TIPO IDENT','Nº IDENTIFI','FECHA NACIMIENTO','CONSUMO kwh','IMPORTE DIRECTO','IMPORTE INDIRECTO','IMPORTE FACTURADO','CODIGO CONTROL');

 	
 	$this->Multitabla($cabecera,1,3,3,5,1);
 	
  $this->SetFontsStyles(array('','',''));
 	$this->SetAligns(array('R','L','L','L','L','R','R','R','R','R','R','L'));
    $this->SetFormatNumber(array(0,0,0,0,0,0,0,0,1,1,1,0));
}
 
//Pie de página
function Footer()
{
    
	if ($this->PageNo()!='{nb}'){
		$this->Cell(207,0.05,'',1,1);
	}
	$this->SetY(-7);
   	$this->pieHash('FACTUR');
 	  
}

}
  	$pdf=new PDF();	
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,7);
    $pdf->SetMargins(5,5,5);  
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',6);
	
  
 	$detalle=$_SESSION["PDF_detalle_beneficiarios"];
	
 	$pdf->SetWidths(array(5,12,15,50,10,15,15,15,15,15,15,25));
	$pdf->SetFills(array(0,0,0,0,0,0,0,0));
 	//$pdf->SetAligns(array('L','C','C','C','C','C','C','C','C','C','C','C','C'));
 	$pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1));
  	$pdf->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5,5,5,5));
 	$pdf->SetFontsStyles(array('B','B','B','B','B','B','B','B','B','B','B','B'));
 	$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3));
 	$pdf->setDecimales(array(0,0,0,0,0,0,0,0,2,2,2,0));
    $pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0));
 	
 	$pdf->SetFontsStyles(array('','',''));
 	$pdf->SetAligns(array('R','L','L','L','L','R','R','R','R','R','R','L'));
    $pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,1,1,1,0));
 	$estado='';
 	$indice=0;
 	for ($i=0;$i<count($detalle);$i++){
 		
 		if ($i!=0){
 			if ($detalle[$i]['estado']!=$estado){
 				    $pdf->SetWidths(array(137,15,15,15,25));
 	                $sumas_totales=array('TOTALES',number_format($suma_directo,2),number_format($suma_indirecto,2),number_format($suma_importe_facturado,2),'');
                    $pdf->SetAligns(array('R','R','R','R','L'));
 	                $pdf->Multitabla($sumas_totales,1,3,3,5,1);
                 $pdf->setTitulo('EMPLEADOS INACTIVOS');
 				$pdf->AddPage();
 			 $suma_directo=0;
		     $suma_indirecto=0;
		     $suma_importe_facturado=0;
		     
		    $indice=0;
		
 			 $pdf->SetWidths(array(5,12,15,50,10,15,15,15,15,15,15,25));
 			$pdf->SetAligns(array('R','L','L','L','L','R','R','R','R','R','R','L'));
 		     }
 			
 		}
 		$indice=$indice+1;
 		$estado=$detalle[$i]['estado'];
		$suma_directo=$detalle[$i]['importe_des_direc']+ $suma_directo;
		$suma_indirecto=$detalle[$i]['importe_des_indirec']+$suma_indirecto;
		$suma_importe_facturado=$detalle[$i]['importe_facturado']+$suma_importe_facturado;
		
 		$pdf->Multitabla(array_merge(array($indice),$detalle[$i]),1,1,3,5,1);
 	}
 	 $pdf->SetWidths(array(137,15,15,15,25));
 	  $sumas_totales=array('TOTALES',number_format($suma_directo,2),number_format($suma_indirecto,2),number_format($suma_importe_facturado,2),'');
                    $pdf->SetAligns(array('R','R','R','R','L'));
 	                $pdf->Multitabla($sumas_totales,1,3,3,5,1);
$pdf->Output();

?>