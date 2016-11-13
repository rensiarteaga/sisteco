<?php
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
include_once("../../LibModeloPresupuesto.php");

class PDF extends FPDF
{
	//Cargar los datos
	//Cabecera de página

	function Header(){
	global $title;
	$this->SetLeftMargin(20);
	$funciones = new funciones();
	//Logo
	$this->SetY(20);
	$this->Image('../../../../lib/images/logo_reporte.jpg',160,5,36,10);
	//Arial bold 15
	$this->SetLineWidth(.1);
	$this->SetFont('Arial','B',10);
	//Movernos a la derecha
	$this->Cell(180,10,'REFORMULACIÓN PRESUPUESTARIA',0,0,'C');
	$this->Ln(5);	
	$this->Cell(180,10,'GESTIÓN: '.$_SESSION['rep_desc_parametro'],0,0,'C');
	$this->Ln(5);
	//$this->Cell(180,10,'FECHA REGISTRO: '.$_SESSION['rep_fecha_traspaso'],0,0,'C');
	$this->Cell(180,10,'Fecha Reformulación: '.$_SESSION['rep_fecha_conclusion'],0,0,'C');
	$this->Ln(10);
	$this->SetFont('Arial','B',7);

//Parte 1
	$this->SetX(30);
	$this->Cell(200,10,'DATOS GENERALES:',0,0,'L');
	$this->Ln(10);
	$this->SetX(30);
	$this->Cell(60,4,'IMPORTE','LTR',0,'L');
	$this->Cell(90,4,$_SESSION['rep_importe_traspaso'],'TR',0,'L');	
		
	$this->Ln(4);
	$this->SetX(30);
	$this->Cell(60,4,'MONEDA','LTR',0,'L');
	$this->Cell(90,4,$_SESSION['rep_desc_moneda'],'TR',0,'L');	
	
	$this->Ln(4);
	$this->SetX(30);
	$this->Cell(60,4,'PRESUPUESTO DE','LTBR',0,'L');	
	$this->Cell(90,4,$_SESSION['rep_desc_tipo_pres'],'TBR',0,'L');

	$this->Ln(4);
	$this->SetX(30);
	$this->Cell(60,4,'JUSTIFICACIÓN','LTBR',0,'L');
	$this->MultiCell(90,4,$_SESSION['rep_justificacion'],'LTBR','L');	
	
	
	
	$this->Ln(10);

//Parte 2	
	$this->SetX(30);
	$this->Cell(200,10,'REFORMULACIÓN DE:',0,0,'L');
	$this->Ln(10);
	$this->SetX(30);
	$this->Cell(60,4,'UNIDAD ORGANIZACIONAL','LTRB',0,'L');
	$this->Cell(90,4,$_SESSION['rep_desc_uo_origen'],'TRB',0,'L');	
	
	$this->Ln(4);
	$this->SetX(30);
	$this->Cell(60,4,'FUENTE DE FINANCIAMIENTO','LTR',0,'L');
	$this->Cell(90,4,$_SESSION['rep_desc_fuente_fin_origen'],'TR',0,'L');	

	$this->Ln(4);
	$this->SetX(30);  
	$this->Cell(60,4,'REGIONAL','LTR',0,'L');
	$this->Cell(90,4,$_SESSION['rep_desc_regional_origen'],'TR',0,'L');	

	$this->Ln(4);
	$this->SetX(30);
	$this->Cell(60,4,'ORGANISMO FINANCIADOR','LTR',0,'L');
	$this->Cell(90,4,$_SESSION['rep_desc_financiador_origen'],'TR',0,'L');	

	$this->Ln(4);
	$this->SetX(30);
	$this->Cell(60,4,'PROGRAMA','LTR',0,'L');
	$this->Cell(90,4,$_SESSION['rep_desc_programa_origen'],'TR',0,'L');	
		
	$this->Ln(4);
	$this->SetX(30);
	$this->Cell(60,4,'SUB PROGRAMA','LTR',0,'L');
	$this->Cell(90,4,$_SESSION['rep_desc_proyecto_origen'],'TR',0,'L');	
	
	$this->Ln(4);
	$this->SetX(30);
	$this->Cell(60,4,'ACTIVIDAD','LTBR',0,'L');
	$this->Cell(90,4,$_SESSION['rep_desc_actividad_origen'],'TBR',0,'L');	
	
	$this->Ln(4);
	$this->SetX(30);
	$this->Cell(60,4,'PARTIDA','LTBR',0,'L');	
	//$this->Cell(90,4,$_SESSION['rep_desc_partida_origen'],'TBR',0,'L');
	$this->MultiCell(90,4,$_SESSION['rep_desc_partida_origen'],'LTBR','L');
	
	$this->Ln(10);
	
//Parte 3	
	$this->SetX(30);
	$this->Cell(200,10,'REFORMULACIÓN A:',0,0,'L');
	$this->Ln(10);
	$this->SetX(30);
	$this->Cell(60,4,'UNIDAD ORGANIZACIONAL','LTRB',0,'L');	
	$this->Cell(90,4,$_SESSION['rep_desc_uo_destino'],'TRB',0,'L');
		
	$this->Ln(4);
	$this->SetX(30);
	$this->Cell(60,4,'FUENTE DE FINANCIAMIENTO','LTR',0,'L');	
	$this->Cell(90,4,$_SESSION['rep_desc_fuente_fin_destino'],'TR',0,'L');
	
	$this->Ln(4); 
	$this->SetX(30); 
	$this->Cell(60,4,'REGIONAL','LTR',0,'L');	
	$this->Cell(90,4,$_SESSION['rep_desc_regional_destino'],'TR',0,'L');

	$this->Ln(4);
	$this->SetX(30);
	$this->Cell(60,4,'ORGANISMO FINANCIADOR','LTR',0,'L');	
	$this->Cell(90,4,$_SESSION['rep_desc_financiador_destino'],'TR',0,'L');
	
	$this->Ln(4);
	$this->SetX(30);
	$this->Cell(60,4,'PROGRAMA','LTR',0,'L');	
	$this->Cell(90,4,$_SESSION['rep_desc_programa_destino'],'TR',0,'L');
		
	$this->Ln(4);
	$this->SetX(30);
	$this->Cell(60,4,'SUB PROGRAMA','LTR',0,'L');	
	$this->Cell(90,4,$_SESSION['rep_desc_proyecto_destino'],'TR',0,'L');
	
	$this->Ln(4);
	$this->SetX(30);
	$this->Cell(60,4,'ACTIVIDAD','LTBR',0,'L');	
	$this->Cell(90,4,$_SESSION['rep_desc_actividad_destino'],'TBR',0,'L');
	
	$this->Ln(4);
	$this->SetX(30);
	$this->Cell(60,4,'PARTIDA','LTBR',0,'L');	
	//$this->Cell(90,4,$_SESSION['rep_desc_partida_destino'],'TBR',0,'L');
	$this->MultiCell(90,4,$_SESSION['rep_desc_partida_destino'],'LTBR','L');
	
	$this->Ln(10);  	
	
//FIRMAS	
	
	if ($_SESSION['rep_desc_usuario_origen'] == $_SESSION['rep_desc_usuario_destino'])
	{
	
		$this->Ln(30);
		$this->SetX(30);
		$this->Cell(75,4,$_SESSION['rep_desc_usuario_registro'],0,0,'C');
		$this->Cell(75,4,$_SESSION['rep_desc_usuario_origen'],0,0,'C');
		
		$this->Ln(4);
		$this->SetX(30);
		$this->Cell(75,4,'RESPONSABLE REGISTRO',0,0,'C');
		$this->Cell(75,4,'RESPONSABLE APROBACION',0,0,'C');
			
		
		$this->Ln(30);
	}
	else 
	{
		$this->Ln(30);
		$this->SetX(30);
		$this->Cell(50,4,$_SESSION['rep_desc_usuario_registro'],0,0,'C');
		$this->Cell(50,4,$_SESSION['rep_desc_usuario_origen'],0,0,'C');
		$this->Cell(50,4,$_SESSION['rep_desc_usuario_destino'],0,0,'C');
		$this->Ln(4);
		$this->SetX(30);
		$this->Cell(50,4,'RESPONSABLE REGISTRO',0,0,'C');
		$this->Cell(50,4,'RESPONSABLE ORIGEN',0,0,'C');
		$this->Cell(50,4,'RESPONSABLE DESTINO',0,0,'C');	
		
		$this->Ln(30);
	}	
	
	
	}
	
	//Pie de página
	function Footer()
	{
		//$this->SetY(-35);
		//Arial italic 8
		$this->SetFont('Arial','',7);
		//fecha
		$fecha=date("d-m-Y");
		//hora
		$hora=date("H:i:s");			
		$this->ln(5);
		$this->SetFont('Arial','',6);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(40,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - PRESTO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(40,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');		
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
$pdf->Output();
?>