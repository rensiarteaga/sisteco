<?php
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
//include_once("../../rcm_LibModeloAlmacenes.php");
include_once("../../LibModeloActivoFijo.php");
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{    //Cargar los datos
	//Cabecera de página

	function Header()
	{	global $title;
	$this->SetLeftMargin(15);
	$funciones = new funciones();
	//Logo
	$this->Image('../../../../lib/images/logo_reporte.jpg',230,2,36,13);
	}

	function Footer()
	{	//Posición: a 1,5 cm del final
		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','I',6);
		//Número de página
		$fecha=date("d-m-Y");
		//hora
		$hora=date("H:i:s");
		$this->Cell(120,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L');
		$this->Cell(110,10,'Página '.$this->PageNo().' de {nb}',0,0,'L');
		$this->Cell(100,10,'Fecha: '.$fecha ,0,0,'L');
		$this->ln(3);
		$this->Cell(100,10,'',0,0,'L');
		$this->Cell(130,10,'',0,0,'L');
		$this->Cell(200,10,'Hora: '.$hora ,0,0,'L');

	}

	/////////////////////////////////////////////////////////////////////////////
	function LoadData($codigo,$descripcion_larga,$desc_empleado_anterior,$id_empleado,$fecha_asig)
	{     $cant=1;
	$puntero=0;
	//$sortcol='actif.codigo';
	$sortcol='actif.estado';
	$sortdir='asc';
	//$criterio_filtro="afe.estado = ''".$estado."'' ";
	//$criterio_filtro=$criterio_filtro." and actif.estado = ''".$estado."'' ";
	$criterio_filtro=" afe.id_empleado= ".$id_empleado." ";
	if($desc_empleado_anterior=="NULL" || $desc_empleado_anterior==" "){
		$criterio_filtro=$criterio_filtro." and afe.id_empleado_anterior IS NULL  ";
	}
	else{
		$criterio_filtro=$criterio_filtro." and afe.id_empleado_anterior=".$desc_empleado_anterior."  ";
	}


	//Leer las líneas del fichero

	$Custom=new cls_CustomDBActivoFijo();
	$Custom->ListarActivoTransferenciaVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$var1=$Custom->salida;

	return $var1;
	}

	//Tabla coloreada
	function FancyTable($header,$data)
	{   $this->SetDrawColor(190,190,190);
	$this->SetLineWidth(.1);

	$this->SetFont('Arial','B',12);
	$this->Cell(250,10,'FORMULARIO DE TRANSFERENCIA DE ACTIVOS FIJOS',0,0,'C');
	$this->Ln(13);
	$this->SetFont('Arial','B',7);
	$this->Cell(250,10,'Fecha Asignación :  '.$_SESSION['rep_af_trans_fecha_asig'],0,0,'R');
	$this->Ln(8);
	//Colores, ancho de línea y fuente en negrita
	$this->SetLineWidth(.1);//grosor de la linea
	//obtener el total de registros

	//Cabecera
	$w=array(20,175,30,25);
	$this->SetFont('Arial','',6);
	//Datos

	for($i=0;$i<count($header);$i++)
	$this->Cell($w[$i],7,$header[$i],1,0,'C');
	$this->Ln();



	foreach($data as $row){

		$array[0]=$_SESSION['rep_af_trans_codigo'];
		$array[1]=$_SESSION['rep_af_trans_descripcion_larga'];
		$array[2]=$row[0];
		$array[3]=$row[1];

		$this->SetFont('Arial','',8);
		$this->SetWidths($w);
		$this->SetAligns(array('L','L','L','C'));
		$this->SetFonts(array('Arial','Arial','Arial','Arial'));
		$this->SetFontsSizes(array(6,6,6,6));
		$this->SetSpaces(array(3.5,3.5,3.5,3.5));
		$this->SetDecimales(array(0,0,0,0));
		$this->SetVisibles(array(1,1,1,1));
		
		/*echo "<pre>";
		print_r($array);
		echo "</pre>";
		exit;*/


		$this->MultiTabla($array,2,3,3.5,6);

		$this->SetFont('Arial','',6);
		//$this->Cell($w[0],8,$_SESSION['rep_af_trans_codigo'],'LRTB',0,'L');//codigo
		////$aux_y=$this->GetY();
		//$this->MultiCell($w[1],8,$_SESSION['rep_af_trans_descripcion_larga'],'LRTB',0,'L');//descripcion larga
		////$this->SetXY($w[0]+$w[1]+15,$aux_y);
		//$this->Cell($w[2],8,$row[0],'LRTB',0,'L');//estado funcional
		//$this->Cell($w[3],8,$row[1],'LRTB',0,'C');//fecha compra

		//$this->Ln(6);
		$this->Cell(250,4,'','LR',0,'L');// ESPACIO DE..
		$this->Ln(4);
		//$this->Cell(125,4,'De :  '.$row[2],'L',0,'L');//de empleado anterior
		$this->Cell(125,4,'De :  '.$row[4],'L',0,'L');//de empleado anterior
		$this->Cell(125,4,'Unidad Organizacional :  '.$row[5],'R',1,'L');//uni org empleado anterior
		//$this->Ln(5);
		//$this->Cell(125,4,'A    :  '.$row[4],'L',0,'L');// a empleado actual
		$this->Cell(125,4,'A    :  '.$row[2],'L',0,'L');// a empleado actual
		$this->Cell(125,4,'Unidad Organizacional :  '.$row[3],'R',0,'L');//uni orga empleado actual
		$this->Ln(4);
		$this->Cell(250,4,'','LR',0,'L');// ESPACIO AA..
		$this->Ln(2);
		$this->Cell(250,10,'OBSERVACIONES :','LRT',0,'L');//uni orga empleado actual
		$this->Ln(5);
		$this->Cell(250,16,'','LRB',0,'L');//vacia despues de observaciones
		$this->Ln(18);
		$this->Cell(60,4,'RESPONSABLE ANTERIOR','LRTB',0,'L');// titulo
		$this->Cell(70,4,'FIRMA AUTORIZADA','LRTB',0,'L');// titulo
		$this->Cell(60,4,'ENCARGADO UNIDAD ACTIVOS FIJOS','LRTB',0,'L');// titulo
		$this->Cell(60,4,'RESPONSABLE ACTUAL','LRTB',0,'L');//titulo
		$this->Ln(4);
		$this->Cell(60,13,'','LRT',0,'L');
		$this->Cell(70,13,'','LRT',0,'L');
		$this->Cell(60,13,'','LRT',0,'L');
		$this->Cell(60,13,'','LRT',0,'L');
		$this->Ln(13);
		//$this->Cell(60,4,$row[2],'LRB',0,'L');// monbre resp anterior
		$this->Cell(60,4,$row[4],'LRB',0,'L');// monbre resp anterior
		$this->Cell(70,4,'','LRB',0,'L');//nombre firma autorizada
		$this->Cell(60,4,$row[6],'LRB',0,'L');//monbre encargado activos fijos
		//$this->Cell(60,4,$row[4],'LRB',0,'L');//nombre responsable actual
		$this->Cell(60,4,$row[2],'LRB',0,'L');//nombre responsable actual
		$this->Ln(4);
		$this->Cell(60,6,'FECHA :','LRTB',0,'L');// FECHA
		$this->Cell(70,6,'FECHA :','LRTB',0,'L');// FECHA
		$this->Cell(60,6,'FECHA :','LRTB',0,'L');// FECHA
		$this->Cell(60,6,'FECHA :','LRTB',0,'L');//FECHA
		$this->Ln(4);


	}

	}

}

$pdf=new PDF('L','mm','Letter');
$pdf->AliasNbPages();
//Títulos de las columnas
$header=array('CÓDIGO','DESCRIPCIÓN','ESTADO FUNCIONAL','FECHA COMPRA');//toodo lo que quiero mostrar en mis columnas

$data=$pdf->LoadData($codigo,$descripcion_larga,$desc_empleado_anterior,$id_empleado,$fecha_asig);



$pdf->SetFont('Arial','',12);
$pdf->SetAutoPageBreak(1,35);
$pdf->SetTopMargin(15);
$pdf->SetRightMargin(10);
$pdf->SetLeftMargin(10);
$pdf->AddPage();
$pdf->FancyTable($header,$data);
$pdf->Output();
?>