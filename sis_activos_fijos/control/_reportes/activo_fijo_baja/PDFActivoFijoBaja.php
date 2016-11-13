<?php
session_start();
require('../../../../lib/fpdf/fpdf.php');
include_once("../../../control/LibModeloActivoFijo.php");
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
		 $this->Image('../../../../lib/images/logo_reporte.jpg',230,2,35,15);
		 $this->Ln(5);
		 $this->SetFont('Arial','B',8);
		 $this->SetX(15);
		 $this->Ln(1.5);

		$this->SetX(1);
		$this->SetFont('Arial','B',15);
		$this->Cell(220,3,'BAJA DE ACTIVOS FIJOS',0,1,'C');
		$this->Ln(2);
		$this->SetFont('Arial','B',8);
		$this->Cell(204,3,'DESDE :  '.$_SESSION['rep_af_baja_proceso1'].'  HASTA :  '.$_SESSION['rep_af_baja_proceso2'],0,1,'C');
		$this->Ln(5);
		
		 
		//primera linea
		$this->SetX(35);
	}

	//Pie de página
	function Footer()
	{
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
		$this->Cell(100,3,'Sistema: ENDESIS - ACTIF',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(35,3,'',0,0,'C');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'R');
	}
}
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,10);
$pdf->SetMargins(10,5,15);
 
$pdf->AddPage();

$pdf->SetFont('Arial','',5);
$pdf->SetWidths(array(60,20,40,20,60,20,40,20,20,25,25,20,25,20));
$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0));
$pdf->SetVisibles(array(0,0,0,0,1,1,1,1,1,1,1,1,1,0));
$pdf->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5,5,5,5,5));
$pdf->SetAligns(array('C','C','C','C','L','C','L','C','R','R','R','R','R','R'));
$pdf->SetFontsStyles(array('','','','','','','','','','','','','',''));
$pdf->SetDecimales(array(0,0,0,0,0,2,2,2,2,2,2,2,2,2));
$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3));
$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0));
$pdf->Ln(2);

$Custom = new cls_CustomDBActivoFijo();
$cant=20;
$puntero=0;
$sortcol='gruproc.fecha_contabilizacion ';
$sortdir='ASC';
$criterio_filtro="subtip.id_sub_tipo_activo like ''$id_sub_tipo_activo''";
$criterio_filtro=$criterio_filtro." and tipo.id_tipo_activo like ''$id_tipo_activo''";
$criterio_filtro=$criterio_filtro." and gruproc.fecha_contabilizacion between ''$fecha_proceso1'' and ''$fecha_proceso2''";

//añadido 29/04/2014
$criterio_filtro=$criterio_filtro." and af.proyecto like ''$proyecto''"." and af.estado=''baja''";
switch ($proyecto)
{
	case 'si': {$criterio_filtro=$criterio_filtro." and proc.codigo=''BAJPROY''";break;}
	case 'no': {$criterio_filtro=$criterio_filtro." and proc.codigo=''BAJA''";break;}
	case '%': {$criterio_filtro=$criterio_filtro." and proc.codigo in (''BAJPROY'',''BAJA'')";break;}
}

$res = $Custom->ListarActivoBaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);

$registros = $Custom->salida;


for($i=0;$i<sizeof($registros);$i++)
{
	
	$pdf->SetFont('Arial','B',5);
	$ant_y = $pdf->GetY();
	$pdf->Cell(15,5,'Activo Fijo :     '.$registros[$i][0],'',1,'L');
	$pdf->SetXY(150, $ant_y);
	$pdf->Cell(25,5,'Estructura Programática :     '.$registros[$i][3],'',1,'L');
	
	$y2 = $pdf->GetY();
	$pdf->Cell(15,5,'Tipo / Subtipo :     '.$registros[$i][1].'  /  '.$registros[$i][2],'',1,'L');
	$pdf->SetXY(150, $y2);
	$pdf->Cell(15,5,'Proyecto :     '.$registros[$i][13],'',1,'L');
	
	$pdf->Ln();
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(60,5,'DESCRIPCIÓN','TRL',0,'C',false);
	$pdf->Cell(20,5,'FECHA','TRL',0,'C',false);
	$pdf->Cell(40,5,'UBICACIÓN','TRL',0,'C',false);
	$pdf->Cell(20,5,'FECHA','TRL',0,'C',false);
	$pdf->Cell(20,5,'MONTO','TRL',0,'C',false);
	$pdf->Cell(25,5,'MONTO','TRL',0,'C',false);
	$pdf->Cell(25,5,'DEPRECIACIÓN','TRL',0,'C',false);
	$pdf->Cell(20,5,'VALOR','TRL',0,'C',false);
	$pdf->Cell(25,5,'VIDA UTIL','TRL',0,'C',false);
	
	$pdf->Ln();
	
	$pdf->Cell(60,5,'PROCESO','RL',0,'C',false);
	$pdf->Cell(20,5,'PROCESO','RL',0,'C',false);
	$pdf->Cell(40,5,'ACTIVO FIJO','RL',0,'C',false);
	$pdf->Cell(20,5,'COMPRA','RL',0,'C',false);
	$pdf->Cell(20,5,'COMPRA','RL',0,'C',false);
	$pdf->Cell(25,5,'ACTUALIZADO','RL',0,'C',false);
	$pdf->Cell(25,5,'ACUMULADA','RL',0,'C',false);
	$pdf->Cell(20,5,'NETO','RL',0,'C',false);
	$pdf->Cell(25,5,'RESTANTE','RL',0,'C',false);
	
	$pdf->Ln(4);
	
	$pdf->MultiTabla($registros[$i],0,3,3,6);
	
	if($pdf->GetY()>=130)
	{
		$pdf->SetFont('Arial','B',5);
		$pdf->SetMargins(10,5,15);
		
		$pdf->AddPage();
	}
	
	$pdf->Ln();
}

$pdf->Output();
?>