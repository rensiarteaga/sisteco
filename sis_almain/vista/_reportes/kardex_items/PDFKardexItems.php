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

function mesLiteral($mes)
{
	switch ($mes)
	{
		case 1:$mes="Enero";break;
		case 2:$mes="Febrero";break;
		case 3:$mes="Marzo";break;
		case 4:$mes="Abril";break;
		case 5:$mes="Mayo";break;
		case 6:$mes="Junio";break;
		case 7:$mes="Julio";break;
		case 8:$mes="Agosto";break;
		case 9:$mes="Septiembre";break;
		case 10:$mes="Octubre";break;
		case 11:$mes="Noviembre";break;
		case 12:$mes="Diciembre";break;
	}
	return $mes;
}
$dia_ini = date("d", strtotime($f_ini));
$mes_ini = date("m", strtotime($f_ini));
$anio_ini = date("Y", strtotime($f_ini));

$dia_fin = date("d", strtotime($f_fin));
$mes_fin = date("m", strtotime($f_fin));
$anio_fin = date("Y", strtotime($f_fin));

$mes_ini_literal=mesLiteral($mes_ini);
$mes_fin_literal=mesLiteral($mes_fin);

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,7);
$pdf->SetMargins(10,5,10);

$pdf->SetFont('Arial','B',14);

//$pdf->SetX(1);
$pdf->Ln();
$pdf->SetFont('Arial','B',15);

$pdf->Cell(216,3,'KARDEX FISICO / VALORADO',0,1,'C');

$pdf->Ln(2);

$pdf->SetFont('Arial','B',6);
$pdf->Cell(80,3,'',0,0,'L');
$pdf->Cell(130,3,'ALMACEN :  '.utf8_decode($_SESSION["pdf_kardex_items"][0][0]),0,0,'L');
$pdf->Ln();

$pdf->Cell(216,3,'DESDE :  '.$dia_ini.' DE '.strtoupper($mes_ini_literal).' DE '.$anio_ini.'     AL : '.$dia_fin.' DE '.strtoupper($mes_fin_literal).' DE '.$anio_fin,0,0,'C');

$pdf->Ln(12);

if($id_item != '%')
{
	
	$pdf->SetFont('Arial','B',6);
	$pdf->SetX(10);
	$pdf->Cell(30,3,'ITEM     :  ','',0,'R');
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(67,3,utf8_decode($_SESSION["pdf_kardex_items"][0][14]),0,'L');
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(30,3,'CODIGO   :  ','',0,'R');
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(67,3,utf8_decode($_SESSION["pdf_kardex_items"][0][13]),'',0,'L');
	$pdf->Ln();
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(30,3,'UNIDAD MEDIDA :  ','',0,'R');
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(67,3,'         '.utf8_decode($_SESSION["pdf_kardex_items"][0][15]),'',0,'L');

	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(30,3,'SALDO INICIAL :  ','',0,'R');
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(67,3,'         '.utf8_decode($_SESSION["pdf_kardex_items"][0][17]),'',0,'L');
	
	$pdf->Ln(5);
	
	$pdf->SetFont('Arial','B',6);
	
	$pdf->Cell(42,5,'DETALLE MOVIMIENTO','TL',0,'C');//1
	$pdf->Cell(20,5,'FECHA','TL',0,'C');//2
	$pdf->Cell(56,5,'CANTIDADES','TRL',0,'C');//4
	$pdf->Cell(76,5,'PRECIOS BS.','TRL',0,'C');//5
	
	$pdf->Ln();
	
	$pdf->Cell(42,5,'','BRL',0,'C');//1
	$pdf->Cell(20,5,'','BRL',0,'C');//2
	$pdf->Cell(18,5,'INGRESO','TBRL',0,'C');//4
	$pdf->Cell(18,5,'SALIDA','TBRL',0,'C');//4
	$pdf->Cell(20,5,'SALDO','TBRL',0,'C');//4
	$pdf->Cell(19,5,'PPP BS.','TBRL',0,'C');//5
	$pdf->Cell(19,5,'INGRESO','TBRL',0,'C');//5
	$pdf->Cell(19,5,'SALIDA','TBRL',0,'C');//5
	$pdf->Cell(19,5,'SALDO','TBRL',0,'C');//5
	$pdf->Ln();
	
	$pdf->SetWidths(array(1,42,20,18,18,20,19,19,19,19));
	$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0));
	$pdf->SetVisibles(array(0,1,1,1,1,1,1,1,1,1));
	$pdf->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5));
	$pdf->SetAligns(array('L','L','C','R','R','R','R','R','R','R'));
	$pdf->SetFontsStyles(array('','','','','','','','','',''));
	$pdf->SetDecimales(array(0,0,0,0,0,0,2,0,0,0));
	$pdf->SetSpaces(array(5,5,5,5,5,5,5,5,5,5));
	$pdf->SetFormatNumber(array(0,0,0,1,1,1,0,0,0,0));
	
	$detalle=$_SESSION['pdf_kardex_items'];
	$sum=0;
	$saldos = $_SESSION["pdf_kardex_items"][0][17];
	$saldo_total = 0;
	$total_ingresos=0;$total_salidas=0;
	$saldo_total_ingresos=0;
	$saldo_total_salidas = 0;
	
	for ($i=0; $i<count($detalle); $i++)
	{
		$total_ingresos+=$detalle[$i]["cant_ingreso"];
		$total_salidas+=$detalle[$i]["cant_salida"];
		
		if($detalle[$i]["cant_ingreso"] > 0 && $detalle[$i]["cant_salida"] == 0)
			$saldos = $saldos + $detalle[$i]["cant_ingreso"];
		elseif($detalle[$i]["cant_salida"] > 0 && $detalle[$i]["cant_ingreso"] == 0)
			$saldos = $saldos - $detalle[$i]["cant_salida"];
		
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(42,3,$detalle[$i]["desc_tipo_movimiento"],'RL',0,'L');//1
		$pdf->Cell(20,3,date("d/m/Y",strtotime($detalle[$i]["fecha_finalizacion"])),'RL',0,'C');//2
		$pdf->Cell(18,3,number_format($detalle[$i]["cant_ingreso"],2),'RL',0,'R');//3
		$pdf->Cell(18,3,number_format($detalle[$i]["cant_salida"],2),'RL',0,'R');//4
		$pdf->Cell(20,3,number_format($saldos,2),'RL',0,'R');//5
		
		if($detalle[$i]["precio_ingreso"] >0 && $detalle[$i]["precio_salida"] == 0)
		{	
			//$pdf->Cell(19,3,number_format($detalle[$i]["precio_ingreso"],6),'RL',0,'R');//6
			$pdf->Cell(19,3,number_format($detalle[$i]["precio_prom_ponderado"],6),'RL',0,'R');//6
			$saldo_total_ingresos = $detalle[$i]["precio_ingreso"] * $detalle[$i]["cant_ingreso"];
			$saldo_total+=$saldo_total_ingresos;
			$saldo_total_salidas = 0;
		}
		else
		{ 
			//$pdf->Cell(19,3,number_format($detalle[$i]["precio_salida"],6),'RL',0,'R');//6
			$pdf->Cell(19,3,number_format($detalle[$i]["precio_prom_ponderado"],6),'RL',0,'R');//6
			$saldo_total_salidas = $detalle[$i]["precio_salida"] * $detalle[$i]["cant_salida"];
			$saldo_total-=$saldo_total_salidas;
			$saldo_total_ingresos=0;
		}
		 
		//$pdf->Cell(19,3,number_format($detalle[$i]["precio_ingreso"],6),'RL',0,'R');//7
		$pdf->Cell(19,3,number_format($saldo_total_ingresos,6),'RL',0,'R');//7
		
		$pdf->Cell(19,3,number_format($saldo_total_salidas,6),'RL',0,'R');//8
		
		$pdf->Cell(19,3,number_format($saldo_total,6),'RL',0,'R');//9
		
		$pdf->Ln();
		
		//$pdf->MultiTabla($detalle[$i],0,1,3,6,1);
		
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(9,3,'Código:','BL',0,'L');//1
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(33,3,$detalle[$i]["cod_movimiento"],'BR',0,'L');//1
		$pdf->Cell(20,3,'','BRL',0,'C');//2
		$pdf->Cell(18,3,'','BRL',0,'C');//4
		$pdf->Cell(18,3,'','BRL',0,'C');//4
		$pdf->Cell(20,3,'','BRL',0,'C');//4
		$pdf->Cell(19,3,'','BRL',0,'C');//5
		$pdf->Cell(19,3,'','BRL',0,'C');//5
		$pdf->Cell(19,3,'','BRL',0,'C');//5
		$pdf->Cell(19,3,'','BRL',0,'C');//5
		$pdf->Ln();
		
	}
	$pdf->Cell(42,3,'','',0,'R');//1
	$pdf->Cell(20,3,'TOTALES :','BRL',0,'R');//1
	$pdf->Cell(18,3,number_format($total_ingresos,2),'BRL',0,'R');//1
	$pdf->Cell(18,3,number_format($total_salidas,2),'BRL',0,'R');//5
	//$pdf->Cell(20,3,number_format(($total_ingresos-$total_salidas),2),'BRL',0,'R');//5
	$pdf->Cell(19,3,'','',0,'R');//5
	$pdf->Cell(19,3,'','',0,'R');//5
	$pdf->Cell(19,3,'','',0,'R');//5
	$pdf->Cell(19,3,'','',0,'R');//5
	$pdf->Ln();
	
	$pdf->Cell(19,3,'','',0,'R');//5
	$pdf->Ln();
}
else 
{
	$pdf->SetWidths(array(1,42,20,18,18,20,19,19,19,19));
	$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0));
	$pdf->SetVisibles(array(0,1,1,1,1,1,1,1,1,1));
	$pdf->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5));
	$pdf->SetAligns(array('L','L','C','R','R','R','R','R','R','R'));
	$pdf->SetFontsStyles(array('','','','','','','','','',''));
	$pdf->SetDecimales(array(0,0,0,0,0,0,2,0,0,0));
	$pdf->SetSpaces(array(5,5,5,5,5,5,5,5,5,5));
	$pdf->SetFormatNumber(array(0,0,0,1,1,1,0,0,0,0));
	
	$detalle=$_SESSION['pdf_kardex_items'];
	
	$actual_id=0;$sig_id=0;
	$flag=true;
	$saldos = $_SESSION["pdf_kardex_items"][0][17];
	$saldo_total = 0;
	$total_ingresos=0;$total_salidas=0;
	
	$saldo_total_ingresos=0;
	$saldo_total_salidas = 0;
	
	if($flag)
	{
		$pdf->SetFont('Arial','B',6);
		$pdf->SetX(10);
		$pdf->Cell(30,3,'ITEM     :  ','',0,'R');
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(67,3,utf8_decode($_SESSION["pdf_kardex_items"][0][14]),0,'L');
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(30,3,'CODIGO   :  ','',0,'R');
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(67,3,utf8_decode($_SESSION["pdf_kardex_items"][0][13]),'',0,'L');
		$pdf->Ln();

		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(30,3,'UNIDAD MEDIDA :  ','',0,'R');
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(67,3,'         '.utf8_decode($_SESSION["pdf_kardex_items"][0][15]),'',0,'L');
	
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(30,3,'SALDO INICIAL :  ','',0,'R');
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(67,3,'         '.utf8_decode($_SESSION["pdf_kardex_items"][0][17]),'',0,'L');
		
		
		$pdf->Ln(5);
		
		$pdf->SetFont('Arial','B',6);
		
		$pdf->Cell(42,5,'DETALLE MOVIMIENTO','TRL',0,'C');//1
		$pdf->Cell(20,5,'FECHA','TRL',0,'C');//2
		$pdf->Cell(56,5,'CANTIDADES','TRL',0,'C');//4
		$pdf->Cell(76,5,'PRECIOS BS.','TRL',0,'C');//5
		
		$pdf->Ln();
		
		$pdf->Cell(42,5,'','BRL',0,'C');//1
		$pdf->Cell(20,5,'','BRL',0,'C');//2
		$pdf->Cell(18,5,'INGRESO','TBRL',0,'C');//4
		$pdf->Cell(18,5,'SALIDA','TBRL',0,'C');//4
		$pdf->Cell(20,5,'SALDO','TBRL',0,'C');//4
		$pdf->Cell(19,5,'PPP BS.','TBRL',0,'C');//5
		$pdf->Cell(19,5,'INGRESO','TBRL',0,'C');//5
		$pdf->Cell(19,5,'SALIDA','TBRL',0,'C');//5
		$pdf->Cell(19,5,'SALDO','TBRL',0,'C');//5
		$pdf->Ln();
		
		
		/*$pdf->SetFont('Arial','',6);
		$pdf->Cell(42,3,$detalle[0]["desc_tipo_movimiento"],'RL',0,'L');//1
		$pdf->Cell(20,3,date("d/m/Y",strtotime($detalle[0]["fecha_finalizacion"])),'RL',0,'C');//2
		$pdf->Cell(18,3,number_format($detalle[0]["cant_ingreso"],2),'RL',0,'R');//3
		$pdf->Cell(18,3,number_format($detalle[0]["cant_salida"],2),'RL',0,'R');//4
		$pdf->Cell(20,3,number_format(($detalle[0]["cant_ingreso"]-$detalle[0]["cant_salida"]),2),'RL',0,'R');//5
		$pdf->Cell(19,3,number_format($detalle[0]["precio_prom_ponderado"],6),'RL',0,'R');//6
		$pdf->Cell(19,3,number_format($detalle[0]["precio_ingreso"],6),'RL',0,'R');//7
		$pdf->Cell(19,3,number_format($detalle[0]["precio_salida"],6),'RL',0,'R');//8
		$pdf->Cell(19,3,number_format(($detalle[0]["precio_ingreso"] * $detalle[0]["cant_ingreso"]),6),'RL',0,'R');//9
				
		$pdf->Ln();
		*/
		$flag=false;
	}
	for ($i=0; $i<count($detalle); $i++)
	{
		
		$total_ingresos+=$detalle[$i]["cant_ingreso"];
		$total_salidas+=$detalle[$i]["cant_salida"];
		
		if($detalle[$i]["cant_ingreso"] > 0 && $detalle[$i]["cant_salida"] == 0)
			$saldos = $saldos + $detalle[$i]["cant_ingreso"];
		elseif($detalle[$i]["cant_salida"] > 0 && $detalle[$i]["cant_ingreso"] == 0)
			$saldos = $saldos - $detalle[$i]["cant_salida"];
		
		$actual_id=$detalle[$i][12];
		$sig_id=$detalle[$i+1][12];
		
		//$pdf->MultiTabla($detalle[$i],0,1,3,6,1);
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(42,3,$detalle[$i]["desc_tipo_movimiento"],'RL',0,'L');//1
		$pdf->Cell(20,3,date("d/m/Y",strtotime($detalle[$i]["fecha_finalizacion"])),'RL',0,'C');//2
		$pdf->Cell(18,3,number_format($detalle[$i]["cant_ingreso"],2),'RL',0,'R');//3
		$pdf->Cell(18,3,number_format($detalle[$i]["cant_salida"],2),'RL',0,'R');//4
		$pdf->Cell(20,3,number_format($saldos,2),'RL',0,'R');//5
		
		if($detalle[$i]["precio_ingreso"] >0 && $detalle[$i]["precio_salida"] == 0)
		{
			//$pdf->Cell(19,3,number_format($detalle[$i]["precio_ingreso"],6),'RL',0,'R');//6
			$pdf->Cell(19,3,number_format($detalle[$i]["precio_prom_ponderado"],6),'RL',0,'R');//6
			$saldo_total_ingresos = $detalle[$i]["precio_ingreso"] * $detalle[$i]["cant_ingreso"];
			$saldo_total+=$saldo_total_ingresos;
			$saldo_total_salidas=0;
		}
		else
		{
			//$pdf->Cell(19,3,number_format($detalle[$i]["precio_salida"],6),'RL',0,'R');//6
			$pdf->Cell(19,3,number_format($detalle[$i]["precio_prom_ponderado"],6),'RL',0,'R');//6
			$saldo_total_salidas = $detalle[$i]["precio_salida"] * $detalle[$i]["cant_salida"];
			$saldo_total-=$saldo_total_salidas;
			$saldo_total_ingresos = 0;
		}
			
		$pdf->Cell(19,3,number_format($saldo_total_ingresos,6),'RL',0,'R');//7
		$pdf->Cell(19,3,number_format($saldo_total_salidas,6),'RL',0,'R');//8
		
		$pdf->Cell(19,3,number_format($saldo_total,6),'RL',0,'R');//9
		
		$pdf->Ln();
		
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(9,3,'Codigo:','L',0,'L');//1
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(33,3,$detalle[$i]["cod_movimiento"],'R',0,'L');//1
		$pdf->Cell(20,3,'','RL',0,'C');//2
		$pdf->Cell(18,3,'','RL',0,'C');//4
		$pdf->Cell(18,3,'','RL',0,'C');//4
		$pdf->Cell(20,3,'','RL',0,'C');//4
		$pdf->Cell(19,3,'','RL',0,'C');//5
		$pdf->Cell(19,3,'','RL',0,'C');//5
		$pdf->Cell(19,3,'','RL',0,'C');//5
		$pdf->Cell(19,3,'','RL',0,'C');//5
		$pdf->Ln();
		
		if($actual_id == $sig_id)
		{
			//aï¿½adir campos q se suman
		}
		else 
		{
			if($sig_id!="" || $sig_id >0 || $sig_id!=NULL)
			{
				$pdf->Cell(42,3,'','BRL',0,'C');//1
				$pdf->Cell(20,3,'','BRL',0,'C');//2
				$pdf->Cell(18,3,'','BRL',0,'C');//4
				$pdf->Cell(18,3,'','BRL',0,'C');//4
				$pdf->Cell(20,3,'','BRL',0,'C');//4
				$pdf->Cell(19,3,'','BRL',0,'C');//5
				$pdf->Cell(19,3,'','BRL',0,'C');//5
				$pdf->Cell(19,3,'','BRL',0,'C');//5
				$pdf->Cell(19,3,'','BRL',0,'C');//5
				$pdf->Ln();
					
				$pdf->Cell(42,3,'','',0,'R');//1
				$pdf->Cell(20,3,'TOTALES :','BRL',0,'R');//1
				$pdf->Cell(18,3,number_format($total_ingresos,2),'BRL',0,'R');//1
				$pdf->Cell(18,3,number_format($total_salidas,2),'BRL',0,'R');//5
				//$pdf->Cell(20,3,number_format(($total_ingresos-$total_salidas),2),'BRL',0,'R');//5
				$pdf->Cell(19,3,'','',0,'R');//5
				$pdf->Cell(19,3,'','',0,'R');//5
				$pdf->Cell(19,3,'','',0,'R');//5
				$pdf->Cell(19,3,'','',0,'R');//5
				$pdf->Ln();
				$pdf->Cell(19,3,'','',0,'R');//5
				$pdf->Ln();
				
				$pdf->SetFont('Arial','B',6);
				$pdf->SetX(10);
				$pdf->Cell(30,3,'ITEM     :  ','',0,'R');
				$pdf->SetFont('Arial','',6);
				$pdf->Cell(67,3,utf8_decode($_SESSION["pdf_kardex_items"][$i+1][14]),0,'L');
				$pdf->SetFont('Arial','B',6);
				$pdf->Cell(30,3,'CODIGO   :  ','',0,'R');
				$pdf->SetFont('Arial','',6);
				$pdf->Cell(67,3,utf8_decode($_SESSION["pdf_kardex_items"][$i+1][13]),'',0,'L');
				$pdf->Ln();
				$pdf->SetFont('Arial','B',6);
				$pdf->SetFont('Arial','B',6);
				$pdf->Cell(30,3,'UNIDAD MEDIDA :  ','',0,'R');
				$pdf->SetFont('Arial','',6);
				$pdf->Cell(67,3,'         '.utf8_decode($_SESSION["pdf_kardex_items"][$i+1][15]),'',0,'L');
			
				$pdf->SetFont('Arial','B',6);
				$pdf->Cell(30,3,'SALDO INICIAL :  ','',0,'R');
				$pdf->SetFont('Arial','',6);
				$pdf->Cell(67,3,'         '.utf8_decode($_SESSION["pdf_kardex_items"][$i+1][17]),'',0,'L');
				
				$pdf->Ln(5);
				
				$pdf->SetFont('Arial','B',6);
				$pdf->Cell(42,5,'DETALLE MOVIMIENTO','TRL',0,'C');//1
				$pdf->Cell(20,5,'FECHA','TRL',0,'C');//2
				$pdf->Cell(56,5,'CANTIDADES','TRL',0,'C');//4
				$pdf->Cell(76,5,'PRECIOS BS.','TRL',0,'C');//5
				
				$pdf->Ln();
				
				$pdf->Cell(42,5,'','BRL',0,'C');//1
				$pdf->Cell(20,5,'','BRL',0,'C');//2
				$pdf->Cell(18,5,'INGRESO','TBRL',0,'C');//4
				$pdf->Cell(18,5,'SALIDA','TBRL',0,'C');//4
				$pdf->Cell(20,5,'SALDO','TBRL',0,'C');//4
				$pdf->Cell(19,5,'PPP BS.','TBRL',0,'C');//5
				$pdf->Cell(19,5,'INGRESO','TBRL',0,'C');//5
				$pdf->Cell(19,5,'SALIDA','TBRL',0,'C');//5
				$pdf->Cell(19,5,'SALDO','TBRL',0,'C');//5
				$pdf->Ln();
				
				$saldos = $_SESSION["pdf_kardex_items"][$i+1][17];
				$total_ingresos=0;
				$total_salidas=0;
				$saldo_total=0;
				
				
			}
			else 
			{
				$pdf->Cell(42,3,'','BRL',0,'C');//1
				$pdf->Cell(20,3,'','BRL',0,'C');//2
				$pdf->Cell(18,3,'','BRL',0,'C');//4
				$pdf->Cell(18,3,'','BRL',0,'C');//4
				$pdf->Cell(20,3,'','BRL',0,'C');//4
				$pdf->Cell(19,3,'','BRL',0,'C');//5
				$pdf->Cell(19,3,'','BRL',0,'C');//5
				$pdf->Cell(19,3,'','BRL',0,'C');//5
				$pdf->Cell(19,3,'','BRL',0,'C');//5
				$pdf->Ln();
					
				$pdf->Cell(42,3,'','',0,'R');//1
				$pdf->Cell(20,3,'TOTALES :','BRL',0,'R');//1
				$pdf->Cell(18,3,number_format($total_ingresos,2),'BRL',0,'R');//1
				$pdf->Cell(18,3,number_format($total_salidas,2),'BRL',0,'R');//5
				//$pdf->Cell(20,3,number_format(($total_ingresos-$total_salidas),2),'BRL',0,'R');//5
				$pdf->Cell(19,3,'','',0,'R');//5
				$pdf->Cell(19,3,'','',0,'R');//5
				$pdf->Cell(19,3,'','',0,'R');//5
				$pdf->Cell(19,3,'','',0,'R');//5
				$pdf->Ln(2);
				$pdf->Cell(19,3,'','',0,'R');//5
				$pdf->Ln();
				$saldo_total=0;
			}
		}
	}
	
}

$pdf->Output();
?>