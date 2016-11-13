<?php
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
include_once("../../LibModeloPresupuesto.php");

/// PRUEBA

class PDF extends FPDF
{
	//Cargar los datos
	//Cabecera de p�gina

	function Header(){
	global $title;
	$this->SetLeftMargin(15);
	$funciones = new funciones();
	//Logo
	$this->Image('../../../../lib/images/logo_reporte.jpg',165,5,36,12);
	//Arial bold 15
	$this->SetLineWidth(.1);
	$this->SetFont('Arial','B',10);
	//Movernos a la derecha
	$this->Cell(200,10,'DIRECCION GENERAL DE ASUNTOS ADMINISTRATIVOS',0,0,'C');
	$this->Ln(5);
	$this->Cell(200,10,'MEMORIAS DE CALCULO',0,0,'C');
	$this->Ln(5);
	$this->Cell(200,10,'ANTEPROYECTO PRESUPUESTO GESTION '.$_SESSION['rep_mem_cal_gestion_pres'],0,0,'C');
	$this->Ln(5);
	$this->Cell(200,10,'COSTOS ESTIMADOS POR PARTIDA DE GASTO',0,0,'C');
	$this->Ln(5);
	$this->Cell(200,10,'PARTIDA '.$_SESSION['rep_mem_cal_codigo_partida'].' "'.$_SESSION['rep_mem_cal_nombre_partida'].'"',0,0,'C');
	$this->Ln(10);
	$this->SetFont('Arial','B',7);
	if($_SESSION['filtro'] == 1)
	{
		$this->Cell(22,4,'REGIONAL','LTR',0,'L');
		$this->Cell(78,4,$_SESSION['rep_mem_cal_regional'],'TR',0,'L');
		$this->Cell(25,4,'',0,0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Ln(4);
		$this->Cell(22,4,'ORG. FINANC.','LTR',0,'L');
		$this->Cell(78,4,$_SESSION['rep_mem_cal_financiador'],'TR',0,'L');
		$this->Cell(25,4,'',0,0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Ln(4);
		$this->Cell(22,4,'PROGRAMA','LTR',0,'L');
		$this->Cell(78,4,$_SESSION['rep_mem_cal_programa'],'TR',0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Cell(45,4,$_SESSION['rep_mem_cal_cod_formulario_gasto'],'LTRB',0,'C');
		$this->Ln(4);
		$this->Cell(22,4,'SUBPROGRAMA','LTR',0,'L');
		$this->Cell(78,4,$_SESSION['rep_mem_cal_proyecto'],'TR',0,'L');
		$this->Cell(25,4,'',0,0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Ln(4);
		$this->Cell(22,4,'ACTIVIDAD','LTR',0,'L');
		$this->Cell(78,4,$_SESSION['rep_mem_cal_actividad'],'TR',0,'L');
		$this->Cell(25,4,'',0,0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Ln(4);
		$this->Cell(22,4,'FUENTE','LTR',0,'L');
		$this->Cell(78,4,$_SESSION['rep_mem_serv_fuente_financiamiento'],'TR',0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Cell(45,4,'GESTION:     '.$_SESSION['rep_mem_cal_gestion_pres'],'LTR',0,'L');
		$this->Ln(4);     
		$this->Cell(22,4,'UNIDAD ORG.','LTRB',0,'L');
		$this->Cell(78,4,$_SESSION['rep_mem_cal_unidad_organizacional'],'TRB',0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Cell(45,4,'FECHA ELAB.: '.$_SESSION['rep_mem_cal_fecha_elaboracion'],'LRB',0,'L');
	}
	else
	{			
		$this->Cell(44,4,'CODIGO PROGRAMA','LTR',0,'L');
		$this->Cell(56,4,$_SESSION['PDF_cod_prog'],'TR',0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Cell(45,4,$_SESSION['rep_mem_serv_cod_formulario_gasto'],'LTRB',0,'C');
		$this->Ln(4);
		$this->Cell(44,4,'CODIGO PROYECTO','LTR',0,'L');
		$this->Cell(56,4,$_SESSION['PDF_cod_proy'],'TR',0,'L');
		$this->Cell(25,4,'',0,0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Ln(4);
		$this->Cell(44,4,'CODIGO ACTIVIDAD','LTR',0,'L');
		$this->Cell(56,4,$_SESSION['PDF_cod_act'],'TR',0,'L');
		$this->Cell(25,4,'',0,0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Ln(4);
		$this->Cell(44,4,'COD. ORGANISMO FINANCIADOR','LTR',0,'L'); 
		$this->Cell(56,4,$_SESSION['PDF_cod_organismo'],'TR',0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Cell(45,4,'GESTION:     '.$_SESSION['rep_mem_serv_gestion_pres'],'LTR',0,'L');
		$this->Ln(4);     
		$this->Cell(44,4,'COD. FUENTE DE FINANCIAMIENTO','LTRB',0,'L');
		$this->Cell(56,4,$_SESSION['PDF_cod_fuente'],'TRB',0,'L');
		$this->Cell(45,4,'',0,0,'L');
		$this->Cell(45,4,'FECHA ELAB.: '.$_SESSION['rep_mem_serv_fecha_elaboracion'],'LRB',0,'L');
	}
	$this->Ln(8);
	$this->SetFont('Arial','B',6);
	$this->Cell(10,4,'','LTR',0,'L');
	$this->Cell(50,4,'','TR',0,'L');
	$this->Cell(20,4,'','TR',0,'L');
	$this->Cell(15,4,'','TR',0,'L');
	$this->Cell(19,4,'COSTO','TR',0,'C');
	$this->Cell(19,4,'COSTO','TR',0,'C');
	$this->Cell(17,4,'FECHA','TR',0,'C');
	$this->Cell(40,4,'','TR',0,'L');
	$this->Ln(4);
	$this->Cell(10,4,'Nro.','LR',0,'C');
	$this->Cell(50,4,'DESCRIPCION','R',0,'C');
	$this->Cell(20,4,'UNIDAD','R',0,'C');
	$this->Cell(15,4,'CANTIDAD','R',0,'C');
	$this->Cell(19,4,'UNITARIO','R',0,'C');
	$this->Cell(19,4,'ANUAL','R',0,'C');
	$this->Cell(17,4,'ADQUISIC.','R',0,'C');
	$this->Cell(40,4,'JUSTIFICACION','R',0,'C');
	$this->Ln(4);
	$this->SetFont('Arial','B',4);
	$this->Cell(10,3,'','LBR',0,'C');
	$this->Cell(50,3,'','BR',0,'C');
	$this->Cell(20,3,'','BR',0,'C');
	$this->Cell(15,3,'','BR',0,'C');
	$this->Cell(19,3,'('.$_SESSION['rep_mem_cal_simbolo'].')','BR',0,'C');
	$this->Cell(19,3,'('.$_SESSION['rep_mem_cal_simbolo'].')','BR',0,'C');
	$this->Cell(17,3,'(Estimada)','BR',0,'C');
	$this->Cell(40,3,'','BR',0,'C');
	$this->Ln(3);
	$this->Cell(10,4,'','LR',0,'L');
	$this->Cell(50,4,'','R',0,'L');
	$this->Cell(20,4,'','R',0,'L');
	$this->Cell(15,4,'','R',0,'L');
	$this->Cell(19,4,'','R',0,'C');
	$this->Cell(19,4,'','R',0,'C');
	$this->Cell(17,4,'','R',0,'C');
	$this->Cell(40,4,'','R',0,'L');
	$this->Ln(3);
	}
	//Pie de p�gina
	function Footer(){
		//$this->SetY(-35);
		//Arial italic 8
		$this->SetFont('Arial','',7);
		//fecha
		$fecha=date("d-m-Y");
		//hora
		$hora=date("H:i:s");
		$this->ln(0);
		$this->Cell(190,5,'','LRT',0,'C');
		$this->ln(4);
		$this->Cell(133,4,'','L',0,'C');
		$this->Cell(57,4,'FIRMA Y SELLO','R',0,'C');
		$this->ln(4);
		$this->Cell(133,3,'','LTR',0,'L');
		$this->Cell(57,3,'','LTR',0,'C');
		$this->ln(3);
		$this->Cell(20,5,'Elaborado Por: ','L',0,'L');
		$this->Cell(111,5,'','B',0,'L');
		$this->Cell(2,5,'','R',0,'L');
		$this->Cell(2,5,'','L',0,'L');
		$this->Cell(53,5,'','B',0,'L');
		$this->Cell(2,5,'','R',0,'L');
		$this->ln(5);
		$this->Cell(20,5,'Aprobado Por: ','L',0,'L');
		$this->Cell(111,5,'','B',0,'L');
		$this->Cell(2,5,'','R',0,'L');
		$this->Cell(2,5,'','L',0,'L');
		$this->Cell(53,5,'','B',0,'L');
		$this->Cell(2,5,'','R',0,'L');
		$this->ln(5);
		$this->Cell(133,3,'','LBR',0,'L');
		$this->Cell(57,3,'','LBR',0,'C');
		$this->ln(5);
		$this->SetFont('Arial','',6);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Pagina '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - PRESTO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');		
	}
	
	//Tabla coloreada
	function FancyTable($data,$id_partida_presupuesto,$id_presupuesto,$tipo_memoria,$id_partida,$id_moneda){
		//Colores, ancho de l�nea y fuente en negrita
	
		$this->SetLineWidth(.1);
	  	//Cabecera
		$w=array(10,50,20,15,19,17,40);
		//Restauraci�n de colores y fuentes
		
		$this->SetFont('Arial','',7);
		$numero_paginas=ceil($cantidad/36);
		if($numero_paginas==0){
			$numero_paginas=1;
		}
		$cantidad_estimada=$numero_paginas*36;
		$restante=$cantidad_estimada-$cantidad;
		//Datos		
		$numero=1;
       
	   for($i=1;$i<=$restante;$i++)
	   {
	     	$this->Cell($w[0],4,'','LR',0,'L');
			$this->Cell($w[1],4,'','R',0,'L');
			$this->Cell($w[2],4,'','R',0,'C');
			$this->Cell($w[3],4,'','R',0,'C');
			$this->Cell($w[4],4,'','R',0,'C');
			$this->Cell($w[4],4,'','R',0,'C');
			$this->Cell($w[5],4,'','R',0,'L');
			$this->Cell($w[6],4,'','R',0,'L');
			$this->Ln(4);
			$numero=$numero+1;
	   }
	   $this->Cell($w[0],4,'','LT',0,'L');
	   $this->Cell(104,4,'TOTAL PRESUPUESTO ANUAL','T',0,'L');
	   $this->Cell(19,4,'','LTRB',0,'R');
	   $this->Cell(57,4,'','TR',0,'L');
	   $this->Ln(4);
	   $this->Cell(190,3.3,'','LR',0,'L');   			
	}
}
$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
//Carga de datos
$pdf->SetFont('Arial','',14);
$pdf->SetAutoPageBreak(1,35);
$pdf->SetTopMargin(13);
$pdf->SetRightMargin(10);
$pdf->SetLeftMargin(15);
$pdf->AddPage();
$pdf->FancyTable($data,$id_partida_presupuesto,$id_presupuesto,$tipo_memoria,$id_partida,$id_moneda);
$pdf->Output();
?>