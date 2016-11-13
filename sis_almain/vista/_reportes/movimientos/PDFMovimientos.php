<?php
session_start();
/**
 * Autor:  unknow
 * Fecha de creacion: 08072014
 * Descripciï¿½n: reporte de los movimientos del sistema
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
	    //Iniciaciï¿½n de variables
    }   
    
	function Header() 
	{
		
	} 

	//Pie de pï¿½gina
	function Footer()
	{
	     //Posicion: a 1,5 cm del final
	    $fecha=date("d-m-Y");
		$hora=date("H:i:s");
		$this->SetLeftMargin(10);
		$this->SetY(-7);
	   	$this->SetFont('Arial','',5);
	   	$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Pagina '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(65,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'R');
		$this->ln(3);
		$this->Cell(100,3,'Sistema: ENDESIS - ALMIN',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(35,3,'',0,0,'C');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'R');	        
     }
}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,7);
$pdf->SetMargins(15,5,10);
$pdf->SetFont('Arial','B',8);	
$inicio = $pdf->GetY();


//variables de las cabeceras
$nom_doc=$_SESSION["PDF_movimiento"][0][0];
$codigo_mov=$_SESSION["PDF_movimiento"][0][1];
$almacen = $_SESSION["PDF_movimiento"][0][2]; 
$dia=$_SESSION["PDF_movimiento"][0][3];
$mes=$_SESSION["PDF_movimiento"][0][4];
$anio=$_SESSION["PDF_movimiento"][0][5];
$descripcion=$_SESSION["PDF_movimiento"][0][6];



$pdf->SetFont('Arial','B',14);
$y=$inicio;
$pdf->SetXY(5,$y);
$pdf->SetX(15);
$pdf->Cell(45,15,'','LT',1);
$pdf->Image('../../../../lib/images/logo_reporte.jpg',18,$y+1,30,10);
$pdf->SetXY(45,$y);

if ($id_solicitud == null OR $id_solicitud=='' OR $id_solicitud=='undefined')
{
	$pdf->SetX(55);
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(120,7,strtoupper($nom_doc),'LT',1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(55,$y+7);
	$pdf->MultiCell(110,5,$almacen,'L','C');
	$x=$pdf->GetX();
}
else 
{
	$pdf->SetX(55);
	//$pdf->Cell(120,7,strtoupper($nom_doc),'LT',1,'C');
	$pdf->Cell(120,5,'ENTREGA DE MATERIAL','LT',1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->SetXY(55,$y+7);
	$pdf->MultiCell(120,5,$almacen,'L','C');
	$x=$pdf->GetX();
}

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(165,$y);
$pdf->Cell(42,4,$codigo_mov,1,1,'C');
$pdf->SetFont('Arial','',8);

$pdf->SetFont('Arial','B',8);
$pdf->SetX(165);
$pdf->Cell(14,4,'Dia',1,0,'C');
$pdf->Cell(14,4,'Mes',1,0,'C');
$pdf->Cell(14,4,'Año',1,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->SetX(165);
$pdf->Cell(14,4,$dia,1,0,'C');
$pdf->Cell(14,4,$mes,1,0,'C');
$pdf->Cell(14,4,$anio,1,0,'C');

$pdf->Ln(4);
 

if($movimiento == 'ingreso')
{
	$y_motivo=$pdf->GetY();
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(191.9,5,'MOTIVO  :','LTRB',1);
	
	$pdf->SetFont('Arial','',7);
	$pdf->SetY($y_motivo);
	$pdf->MultiCell(0,5,'                          '.$descripcion);
	$pdf->SetFont('Arial','B',8);
	
	
	$y_motivo=$pdf->GetY();
	$pdf->Cell(191.9,5,'NRO. DE O/C :','LR',1);
	$pdf->SetFont('Arial','',7);
	$pdf->SetY($y_motivo);
	$pdf->MultiCell(0,5,'                                 '.$pdf->preview_text($_SESSION["PDF_movimiento"][0][14],490,0),'');
	$pdf->SetFont('Arial','B',8);

}
else
{
	$y_motivo=$pdf->GetY();
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(191.9,5,'MOTIVO  :','LTRB',1);
	
	$pdf->SetFont('Arial','',7);
	$pdf->SetY($y_motivo);
	$pdf->MultiCell(191.9,5,'                          '.$pdf->preview_text($descripcion,490,0),'');
	$pdf->SetFont('Arial','B',8);
}


if ($id_solicitud != null OR $id_solicitud > 0 ) 
{ 
	
	$pdf->Cell(70,3,'ITEM','TRL',0,'C');//1
	$pdf->Cell(40,3,'UNIDAD','TRL',0,'C');//2
	$pdf->Cell(27.3,3,'CANTIDAD','TRL',0,'C');//3
	$pdf->Cell(27.3,3,'CANTIDAD','TRL',0,'C');//4
	$pdf->Cell(27.3,3,'TIPO','TRL',0,'C');//5
	
	$pdf->Ln();
	//SEGUNDA LINEA
	$pdf->Cell(70,3,'','BRL',0,'C');  //1
	$pdf->Cell(40,3,'MEDIDA','BRL',0,'C');  //2
	$pdf->Cell(27.3,3,'SOLICITADA','BRL',0,'C');//3
	$pdf->Cell(27.3,3,'ENTREGADA','BRL',0,'C');//4
	$pdf->Cell(27.3,3,'SALDO','BRL',0,'C');//5
	$pdf->Ln();
	
	
	$pdf->SetWidths(array(1,1,1,1,1,1,1,70,40,27.3,27.3,27.3));
	$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0));
	$pdf->SetVisibles(array(0,0,0,0,0,0,0,1,1,1,1,1));
	$pdf->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5,5,5));
	$pdf->SetAligns(array('','','','','','','','L','C','R','R','C'));
	$pdf->SetFontsStyles(array('','','','','','','','','','',''));
	$pdf->SetDecimales(array(0,0,0,0,0,0,0,0,0,2,6,6));
	$pdf->SetSpaces(array(0,0,0,0,0,0,0,5,5,5,5,5));
	$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0));
	
	$pdf->SetFont('Arial','B',8);
	$detalle=$_SESSION['PDF_movimiento'];
	
	for ($i=0; $i<count($detalle); $i++)
	{
		$pdf->MultiTabla($detalle[$i],2,3,4,6,1);
		//$pdf->MultiTabla($detalle[$i],2,3,6,4,2);
	}
	
	$observaciones=$_SESSION["PDF_movimiento"][0][13];
}
else 
{	
	$observaciones =  $_SESSION["PDF_movimiento"][0][13];
	
	$pdf->Cell(12,3,'ITEM','TRL',0,'C');//0
	$pdf->Cell(73,3,'CODIGO','TRL',0,'C');//1
	$pdf->Cell(34,3,'UNIDAD','TR',0,'C');//2
	$pdf->Cell(25,3,'CANTIDAD','TR',0,'C');//3
	
	if($movimiento == 'ingreso' || $movimiento == 'transpaso_ingreso' || $movimiento=='devolucion')
	{
		$pdf->Cell(24,3,'PRECIO','TRL',0,'C');//1.1
		$pdf->Cell(24,3,'PRECIO','TRL',0,'C');//1.2
	}
	elseif ($movimiento == 'salida' OR $movimiento =='transpaso_salida')
	{
		$pdf->Cell(24,3,'PRECIO','TRL',0,'C');//1.1
		$pdf->Cell(24,3,'PRECIO','TRL',0,'C');//1.2
	}
	$pdf->Ln();
	//SEGUNDA LINEA
	$pdf->Cell(12,3,'','BL',0,'C');//0
	$pdf->Cell(73,3,'MATERIAL','BL',0,'C');  //1
	$pdf->Cell(34,3,'MEDIDA','BRL',0,'C');  //2
	$pdf->Cell(25,3,'','BRL',0,'C');//3
	
	if($movimiento == 'ingreso' || $movimiento == 'transpaso_ingreso' || $movimiento=='devolucion')
	{
		$pdf->Cell(24,3,'UNITARIO','BRL',0,'C');//1.1
		$pdf->Cell(24,3,'TOTAL','BRL',0,'C');//1.2
	}
	elseif ($movimiento == 'salida' OR $movimiento =='transpaso_salida')
	{
		$pdf->Cell(24,3,'UNITARIO','BRL',0,'C');//1.1
		$pdf->Cell(24,3,'TOTAL','BRL',0,'C');//1.2
	}
	
	$pdf->Ln();
	
	if($movimiento =='salida' OR $movimiento =='transpaso_salida')
	{
		$pdf->SetWidths(array(1,1,1,1,1,1,1,12,73,34,25,24,1,1,1,24));
		$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
		$pdf->SetVisibles(array(0,0,0,0,0,0,0,1,1,1,1,1,0,0,0,1));
		$pdf->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5));
		$pdf->SetAligns(array('','','','','','','','C','L','C','R','R','R','','','R'));
		$pdf->SetFontsStyles(array('','','','','','','','','','','','','','',''));
		$pdf->SetDecimales(array(0,0,0,0,0,0,0,0,0,0,2,6,6,0,0,6));
		$pdf->SetSpaces(array(0,0,0,0,0,0,0,3,3,3,3,3,3,3,3,3));
		$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
	}
	else
	{
		$pdf->SetWidths(array(1,1,1,1,1,1,1,12,73,34,25,24,24));
		$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0,0));
		$pdf->SetVisibles(array(0,0,0,0,0,0,0,1,1,1,1,1,1));
		$pdf->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5,5,5,5));
		$pdf->SetAligns(array('','','','','','','','C','L','C','R','R','R'));
		$pdf->SetFontsStyles(array('','','','','','','','','','','',''));
		$pdf->SetDecimales(array(0,0,0,0,0,0,0,0,0,0,2,6,6));
		$pdf->SetSpaces(array(0,0,0,0,0,0,0,3,3,3,3,3,3));
		$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0,0));
	}
	
	$pdf->SetFont('Arial','B',8);
	$detalle=$_SESSION['PDF_movimiento'];
	
	$total = 0;
	
	for ($i=0; $i<count($detalle); $i++)
	{
		$pdf->MultiTabla($detalle[$i],2,3,4,4,2);
		
		if ($movimiento == 'salida' OR $movimiento =='transpaso_salida')
			$total += $detalle[$i][15];
		else
			$total += $detalle[$i][12];		
	}
	
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(168,3,'TOTAL :','',0,'R');
	$pdf->Cell(24,3,number_format($total,6),'BRL',0,'R');
}
$pdf->Ln();

if ($id_solicitud == null OR $id_solicitud=='' OR $id_solicitud=='undefined')
{
		$pdf->SetFont('Arial','B',8);
		$y_obs=$pdf->GetY();
		$pdf->Cell(191.9,4,'OBSERVACIONES	:','LRT',1);
		
		$pdf->SetFont('Arial','',7);
		$pdf->SetY($y_obs);
		$pdf->MultiCell(191.9,4,'                                           '.$pdf->preview_text($observaciones,490,0),'LBR');
		$pdf->SetFont('Arial','B',8);
		
		$pdf->SetFillColor(200, 200, 200);	//Plomo oscuro
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(65.6,5,'ENCARGADO ALMACEN','LTBR',0,'C',true);
		$pdf->Cell(65.6,5,'CONTROL DE CALIDAD','LTBR',0,'C',true);
		$pdf->Cell(60.7,5,'JEFE','LTBR',1,'C',true);
		$pdf->SetFont('Arial','B',8);
		
		
		$pdf->Cell(65.6,15,'','LTBR',0,'C');
		$pdf->Cell(65.6,15,'','LTBR',0,'C');
		$pdf->Cell(60.7,15,'','LTBR',1,'C');
		
		
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(65.6,3,$_SESSION["PDF_datos_almacenero"][0][0],'LTBR',0,'C',true);
		//$pdf->Cell(65.6,3,'ENCARGADO ALMACEN','LTBR',0,'C',true);
		$pdf->Cell(65.6,3,'PARAM. CONTROL DE CALIDAD','LTBR',0,'C',true);
		$pdf->Cell(60.7,3,'PARAM Vo.Bo. JEFE','LTBR',0,'C',true);
}	
else 
{
		$pdf->SetFillColor(200, 200, 200);	//Plomo oscuro
		$solicitante=$_SESSION["PDF_pie_movimiento"][0][0];
		$solicitante_cargo=$_SESSION["PDF_pie_movimiento"][0][1];
		$jefe=$_SESSION["PDF_pie_movimiento"][0][2];
		$jefe_cargo=$_SESSION["PDF_pie_movimiento"][0][3];
		
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(65.6,5,'ENCARGADO ALMACEN','LTBR',0,'C',true);
		$pdf->Cell(65.6,5,'SOLICITANTE','LTBR',0,'C',true);
		$pdf->Cell(60.7,5,'JEFE','LTBR',1,'C',true);
		$pdf->SetFont('Arial','B',8);
		
		$pdf->Cell(65.6,15,'','LTBR',0,'C');
		$pdf->Cell(65.6,15,'','LTBR',0,'C');
		$pdf->Cell(60.7,15,'','LTBR',1,'C');
		
		$pdf->SetFont('Arial','',5);
		$pdf->Cell(65.6,2,' ','LTBR',0,'C');
		$pdf->Cell(65.6,2,$solicitante,'LTBR',0,'C');
		$pdf->Cell(60.7,2,$jefe,'LTBR',1,'C');
		
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(65.6,3,'ENCARGADO ALMACEN','LTBR',0,'C',true);
		$pdf->Cell(65.6,3,$solicitante_cargo,'LTBR',0,'C',true);
		$pdf->Cell(60.7,3,$jefe_cargo,'LTBR',0,'C',true);
}
$pdf->Output();
?>