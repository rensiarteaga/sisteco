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
    
 
}
 
//Pie de página
function Footer()
{
    
	/*if ($this->PageNo()!='{nb}'){
		$this->Cell(207,0.05,'',1,1);
	}*/
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
	  $pdf->SetFillColor(81,169,215);
	  $pdf->SetTextColor(255,255,255);
    $pdf->SetDrawColor(81,169,215);
    $pdf->Cell(205,4,'DATOS EMPRESA',0,1,'L',1);
    
  
 	$detalle_cab=$_SESSION["PDF_datos_cabecera"];
 	
	$cab_show[0][0]='NOMBRE EMPRESA:';
	$cab_show[0][1]= $detalle_cab[0]['denominacion'];
	$cab_show[1][0]='NIT:';
	$cab_show[1][1]= $detalle_cab[0]['nro_nit'];
	$cab_show[2][0]='CANTIDAD VALOR SOLICITADO:';
	$cab_show[2][1]= $detalle_cab[0]['cantidad_valor_solicitado'];
	$cab_show[3][0]='FECHA ENVIO:';
	$cab_show[3][1]= $detalle_cab[0]['fecha_envio'];
	$cab_show[4][0]='NRO. ORDEN F-200:';
	$cab_show[4][1]= $detalle_cab[0]['numero_orden'];
	$cab_show[5][0]='CODIGO FORNULARIO:';
	$cab_show[5][1]= $detalle_cab[0]['codigo_form'];
	$cab_show[6][0]='MES:';
	$cab_show[6][1]= $detalle_cab[0]['mes_per_fiscal'];
	$cab_show[7][0]='AÑO:';
	$cab_show[7][1]= $detalle_cab[0]['anio_per_fiscal'];
	
	$pdf->SetWidths(array(45,160));
	$pdf->SetFills(array(0,0));
 	$pdf->SetAligns(array('L','L'));
 	$pdf->SetVisibles(array(1,1));
  	$pdf->SetFontsSizes(array(5,5));
 	$pdf->SetFontsStyles(array('B',''));
 	$pdf->SetSpaces(array(3,3));
 	$pdf->setDecimales(array(0,0));
    $pdf->SetFormatNumber(array(0,0));
    
    for ($i=0;$i<=count($cab_show);$i++){
    $pdf->Multitabla($cab_show[$i],1,0,3,5,1);	
    }
	
	$pdf->SetFont('Arial','B',6);
	 $pdf->SetFillColor(81,169,215);
	  $pdf->SetTextColor(255,255,255);
    $pdf->SetDrawColor(81,169,215);
	 $pdf->Cell(205,4,'DATOS FACTURA',0,1,'L',1);
	$cab_show1[0][0]='NRO. FACTURA:';
	$cab_show1[0][1]= $detalle_cab[0]['nro_factura'];
	$cab_show1[1][0]='NRO. AUTORIZACIÓN:';
	$cab_show1[1][1]= $detalle_cab[0]['nro_autoriza'];
	$cab_show1[2][0]='MONTO FACTURA:';
	$cab_show1[2][1]= $detalle_cab[0]['importe_factura'];
	$cab_show1[3][0]='FECHA EMISIÓN:';
	$cab_show1[3][1]= $detalle_cab[0]['fecha_emision'];
	$cab_show1[4][0]='CODIGO CONTROL:';
	$cab_show1[4][1]= $detalle_cab[0]['cod_control'];
	
	for ($j=0;$j<=count($cab_show1);$j++){
    $pdf->Multitabla($cab_show1[$j],1,0,3,5,1);	
    }
	$pdf->SetFont('Arial','B',6);
	 $pdf->SetFillColor(81,169,215);
	  $pdf->SetTextColor(255,255,255);
    $pdf->SetDrawColor(81,169,215);
	 $pdf->Cell(205,4,'DATOS BENEFICIARIOS',0,1,'L',1);
	 $pdf->Ln(5);
	$cabecera= array('SISTEMA','CANT. BENEF. DIRECTOS','CANT. BENEF. INDIRECTOS','CANTIDAD BENEFICIARIOS','IMPORTE DIRECTO','IMPORTE INDIRECTO', 'IMPORTE TOTAL');
	
	
	$pdf->SetWidths(array(60,20,20,20,20,20,20));
	$pdf->SetFills(array(0,0,0,0,0,0,0));
 	$pdf->SetAligns(array('L','C','C','C','C','C','C'));
 	$pdf->SetVisibles(array(1,1,1,1,1,1,1));
  	$pdf->SetFontsSizes(array(5,5,5,5,5,5,5));
 	$pdf->SetFontsStyles(array('B','B','B','B','B','B','B'));
 	$pdf->SetSpaces(array(3,3,3,3,3,3,3));
 	$pdf->setDecimales(array(0,0,0,0,0,0,0));
    $pdf->SetFormatNumber(array(0,0,0,0,0,0,0));
    
     $pdf->SetFillColor(236,247,251);
   
	$pdf->Multitabla($cabecera,1,3,3,5,1);
	
	$pdf->SetAligns(array('L','R','R','R','R','R','R'));
	$pdf->setDecimales(array(0,0,0,0,2,2,2));
    $pdf->SetFormatNumber(array(0,0,0,0,1,1,1));
    $pdf->SetFontsStyles(array('','','','','','',''));
 
	$detalle=$_SESSION['PDF_detalle_beneficiarios_reg'];
	$pdf->SetLineWidth(0.1);
	for ($k=0;$k<=count($detalle);$k++){
	if(($k % 2)==0){
    $pdf->SetFills(array(1,1,1,1,1,1,1));
	}else{
		  $pdf->SetFills(array(0,0,0,0,0,0,0));
	}
    $pdf->Multitabla($detalle[$k],1,3,3,5,1);	
    }
$pdf->Output();

?>