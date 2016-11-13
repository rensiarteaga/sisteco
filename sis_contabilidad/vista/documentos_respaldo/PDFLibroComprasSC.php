<?php

session_start();

require('../../../lib/fpdf/fpdf.php');
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
	
	//Cabecera
	function Header()
	{
		$this->SetMargins(5,5,5);
		$this->Image('../../../lib/images/logo_reporte.jpg',240,2,35,14);
		$this->SetFont('Arial','B',14);
		
		if ($_SESSION['PDF_vista']!='ventas'){
			$this->Cell(277,5,'LIBRO DE COMPRAS IVA ',0,1,'C');	
		}else{
			$this->Cell(277,5,'LIBRO DE VENTAS IVA ',0,1,'C');
		}
		
		$this->SetFont('Arial','B',12);
		//$this->Cell(277,5,'Expresado en '.$_SESSION['txt_desc_moneda'],0,1,'C');
		
		$this->SetFont('','B',8);
		$pos_cad=strpos($_SESSION['desc_periodo'],'-');
		$periodo_sub=substr($_SESSION['desc_periodo'], $pos_cad+1, 15);
		$cabecera=$_SESSION['PDF_cabecera_compras_ventas'];
	    $this->Cell(277,5,'PERIODO FISCAL: '.$periodo_sub.'/'.$_SESSION['txt_gestion'] ,0,1,'C');
        
        $this->Cell(257,4,'',0,0);
		$this->Cell(20,4,'FOLIO: '.$this->PageNo(),0,1);
		$this->Ln(4);
		
		/*$this->Cell(100,4,'EMPRESA NACIONAL DE ELECTRICIDAD',0,0);
		$this->Cell(100,4,'NIT: 1023187029',0,1);
		$this->Cell(100,4,'SUCURSAL N° 0',0,0);
		$this->Cell(157,4,'DIRECCIÓN: AV BALLIVIÁN ESQ. MÉJICO Nº503 PISO 8',0,1);
*/
		$this->Cell(100,4,$cabecera[0]['razon_social'],0,0);
		$this->Cell(100,4,'NIT: '.$cabecera[0]['nit'],0,1);
		$this->Cell(100,4,$cabecera[0]['nombre'],0,0);
		$this->Cell(157,4,$cabecera[0]['direccion'],0,1);

		$this->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
		$this->SetFontsStyles(array('','','','','','','','','','','','','','','',''));
		
		if ($_SESSION['PDF_vista']!='ventas'){
			$this->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,0,0));
			$this->SetWidths(array(15,20,60,26,26,24,20,20,20,20,20,0,0));
			$this->SetDecimales(array(0,0,0,0,0,0,2,2,2,2,2,0,0));
			$this->SetFormatNumber(array(0,0,0,0,0,0,1,1,1,1,1,0,0,0));
			$this->SetAligns(array('R','L','L','L','L','L','R','R','R','R','R','R','L'));
		}else{
			$this->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,0,1,0));
			$this->SetWidths(array(15,20,60,26,26,24,20,20,20,20,0,20,0));
			$this->SetDecimales(array(0,0,0,0,0,0,2,2,2,2,0,2,0));
			$this->SetFormatNumber(array(0,0,0,0,0,0,1,1,1,1,0,1,0,0));
			$this->SetAligns(array('R','L','L','L','L','L','R','R','R','R','R','R','L'));
		}
		
		$this->SetFontsSizes(array(7,7,7,7,7,7,7,7,7,7,7,7,7));
		$this->SetSpaces(array(3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5));
	
		$this->SetFont('Arial','B',7);
		$this->Cell(15,3.5,'FECHA','LT',0,'C');
		$this->Cell(20,3.5,'Nº NIT DEL ','LT',0,'C');
		$this->Cell(60,3.5,'NOMBRE O RAZÓN SOCIAL','LT',0,'C');
		$this->Cell(26,3.5,'Nº FACTURA','LT',0,'C');
		$this->Cell(26,3.5,'Nº DE ','LT',0,'C');
		$this->Cell(24,3.5,'CÓDIGO DE','LT',0,'C');
		$this->Cell(20,3.5,'TOTAL ','LT',0,'C');
		$this->Cell(20,3.5,'TOTAL ICE','LT',0,'C');
		$this->Cell(20,3.5,'IMPORTES ','LT',0,'C');
		$this->Cell(20,3.5,'IMPORTE NETO','LT',0,'C');
		
		if ($_SESSION['PDF_vista']!='ventas'){
			$this->Cell(20,3.5,'CRÉDITO','LTR',1,'C');
		}else{
			$this->Cell(20,3.5,'DÉBITO','LTR',1,'C');
		}
		
		//$this->Cell(15,3.5,'Nº','LTR',1,'C');
		$this->Cell(15,3.5,'','LB',0,'C');
		
		if ($_SESSION['PDF_vista']!='ventas'){
			$this->Cell(20,3.5,'PROVEEDOR','LB',0,'C');
			$this->Cell(60,3.5,'DEL PROVEEDOR','LB',0,'C');
		}else{
			$this->Cell(20,3.5,'CLIENTE','LB',0,'C');
			$this->Cell(60,3.5,'DEL CLIENTE','LB',0,'C');
		}
		
		$this->Cell(26,3.5,'','LB',0,'C');
		$this->Cell(26,3.5,'AUTORIZACIÓN','LB',0,'C');
		$this->Cell(24,3.5,'CONTROL','LB',0,'C');
		$this->Cell(20,3.5,'FACTURA (A)','LB',0,'C');
		$this->Cell(20,3.5,'(B)','LB',0,'C');
		$this->Cell(20,3.5,'EXCENTOS(C)','LB',0,'C');
		$this->Cell(20,3.5,'(A-B-C)','LB',0,'C');
		$this->Cell(20,3.5,'FISCAL IVA','LBR',1,'C');
		//$this->Cell(15,3.5,'CBTE.','LBR',1,'C');
	}

	//Pie de página
	function Footer()
	{    
		$fecha=date("d-m-Y");
	    $hora=date("H:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',7);
   	    $this->Cell(100,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(80,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(75,3,'',0,0,'L');
		$this->ln(3);
		$this->Cell(100,3,'Sistema: ENDESIS - CONIN',0,0,'L');
		$this->Cell(80,3,'',0,0,'C');
		$this->Cell(75,3,'',0,1,'L');
	}
}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,7);
$pdf->SetMargins(5,5,5);
$pdf->SetFont('Arial','B',8);

$vcomprobante=$_SESSION['PDF_libros_compra'];
	
//Títulos de las columnas
$detalle_documentos=$_SESSION['PDF_Detalle_compras'];
$nro_pagina=0;
$sp_total=0;
$sp_total_ice=0;
$sp_imp_ext=0;
$sp_imp_net=0;
$sp_credito=0;
$sp_debito=0;

$s_total=0;
$s_total_ice=0;
$s_imp_ext=0;
$s_imp_net=0;
$s_credito=0;
$s_debito=0;
$cont=25;
$cont_detalle_documentos=count($detalle_documentos);

for ($j=0;$j<$cont_detalle_documentos;$j++){
	$pdf->SetDrawColor(74,74,74);
	$pdf->SetLineWidth(0.02);
	$y=$pdf->GetY();
	$detalle_documentos[$j][2]=$pdf->preview_text($detalle_documentos[$j][2],31,0);
	$sp_total=$sp_total+$detalle_documentos[$j][6];
	$sp_total_ice=$sp_total_ice+$detalle_documentos[$j][7];
	$sp_imp_ext=$sp_imp_ext+$detalle_documentos[$j][8];
	$sp_imp_net=$sp_imp_net+$detalle_documentos[$j][9];
	$sp_credito=$sp_credito+$detalle_documentos[$j][10];
	$sp_debito=$sp_debito+$detalle_documentos[$j][11];
	
	
	$s_total=$s_total+$detalle_documentos[$j][6];
	$s_total_ice=$s_total_ice+$detalle_documentos[$j][7];
	$s_imp_ext=$s_imp_ext+$detalle_documentos[$j][8];
	$s_imp_net=$s_imp_net+$detalle_documentos[$j][9];
	$s_credito=$s_credito+$detalle_documentos[$j][10];
	$s_debito=$s_debito+$detalle_documentos[$j][11];
	
	$pdf->Cell(15,3.5,$detalle_documentos[$j][],0,0);
		$this->SetWidths(array(15,20,60,26,26,24,20,20,20,20,20,0,0));
		
	
	
	
	if($y>=200){
		$cont=$cont+25;
		$pdf->SetFont('Arial','B',7);
		$pdf->Cell(121,5,'','T',0);
		$pdf->Cell(50,5,'TOTALES PARCIALES',1,0);
		$pdf->Cell(20,5,number_format($sp_total,2),1,0,'R');
		$pdf->Cell(20,5,number_format($sp_total_ice,2),1,0,'R');
		$pdf->Cell(20,5,number_format($sp_imp_ext,2),1,0,'R');
		$pdf->Cell(20,5,number_format($sp_imp_net,2),1,0,'R');
		
		if ($_SESSION['PDF_vista']!='ventas'){
		    $pdf->Cell(20,5,number_format($sp_credito,2),1,1,'R');
		}else{
			$pdf->Cell(20,5,number_format($sp_debito,2),1,1,'R');
		}
		
		//$pdf->Cell(15,5,'','T',1);
		$sp_total=0;
		$sp_total_ice=0;
		$sp_imp_ext=0;
		$sp_imp_net=0;
		$sp_credito=0;
		$sp_debito=0;
	}
	$pdf->Multitabla($detalle_documentos[$j],0,3,3.5,7,1);
}

$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(0.2);

$pdf->SetFont('Arial','B',7);

$pdf->Cell(121,5,'',0);
$pdf->Cell(50,5,'TOTALES PARCIALES',1,0);
$pdf->Cell(20,5,number_format($sp_total,2),1,0,'R');
$pdf->Cell(20,5,number_format($sp_total_ice,2),1,0,'R');
$pdf->Cell(20,5,number_format($sp_imp_ext,2),1,0,'R');
$pdf->Cell(20,5,number_format($sp_imp_net,2),1,0,'R');

if ($_SESSION['PDF_vista']!='ventas'){
    $pdf->Cell(20,5,number_format($sp_credito,2),1,1,'R');
}else{
	$pdf->Cell(20,5,number_format($sp_debito,2),1,1,'R');
}

//$pdf->Cell(15,5,'','T',1);
$pdf->Cell(121,5,'',0);
$pdf->Cell(50,5,'TOTALES GENERALES',1,0);
$pdf->Cell(20,5,number_format($s_total,2),1,0,'R');
$pdf->Cell(20,5,number_format($s_total_ice,2),1,0,'R');
$pdf->Cell(20,5,number_format($s_imp_ext,2),1,0,'R');
$pdf->Cell(20,5,number_format($s_imp_net,2),1,0,'R');

if ($_SESSION['PDF_vista']!='ventas'){
    $pdf->Cell(20,5,number_format($s_credito,2),1,0,'R');
}else{
	$pdf->Cell(20,5,number_format($s_debito,2),1,0,'R');
}

$pdf->SetFont('Arial','B',8);
$pdf->Ln(20);
$pdf->SetX(100);
$pdf->Cell(100,5,'RESPONSABLE: Lic. '.utf8_decode($_SESSION['desc_usuario']),'T',1,'C');


$pdf->Output();
?>

