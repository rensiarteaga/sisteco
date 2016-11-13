<?php
session_start();
/**
 * Autor:  unknow
 * Fecha de creacion: 08072014
 * Descripcion: reporte de los movimientos del sistema
 **/

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

	//Pie de pagina
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

$codigo=$_SESSION["PDF_solicitud_salida"][0][0];
$almacen = $_SESSION["PDF_solicitud_salida"][0][1];
$dia= $_SESSION["PDF_solicitud_salida"][0][2];
$mes= $_SESSION["PDF_solicitud_salida"][0][3];
$anio= $_SESSION["PDF_solicitud_salida"][0][4];
$observaciones=$_SESSION["PDF_solicitud_salida"][0][8];
$persona=$_SESSION["PDF_solicitud_salida"][0][5];
$cargo=$_SESSION["PDF_solicitud_salida"][0][6];
$unidad_org=$_SESSION["PDF_solicitud_salida"][0][7];

$aprobador=$_SESSION["PDF_solicitud_salida"][0][12];
$cargo_aprobador=$_SESSION["PDF_solicitud_salida"][0][13];

$pdf->SetFont('Arial','B',14);
$y=$inicio;
$pdf->SetXY(5,$y);

$pdf->SetX(15);
$pdf->Cell(45,15,'','LT',1);
$pdf->Image('../../../../lib/images/logo_reporte.jpg',18,$y+1,30,10);
$pdf->SetXY(45,$y);

$pdf->SetX(55);
$pdf->Cell(120,7,'SOLICITUD DE MATERIAL','LT',1,'C');
$pdf->SetFont('Arial','',8);
$pdf->SetXY(55,$y+7);
$pdf->MultiCell(120,5,$almacen,'L','C');
$x=$pdf->GetX();

$pdf->SetFont('Arial','B',8);
$pdf->SetXY(165,$y);
$pdf->Cell(42,4,$codigo,1,1,'C');
$pdf->SetFont('Arial','',8);

$pdf->SetFont('Arial','B',8);
$pdf->SetX(165);
$pdf->Cell(14,4,'Dia','LB',0,'C');
$pdf->Cell(14,4,'Mes',1,0,'C');
$pdf->Cell(14,4,'Año',1,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->SetX(165);
$pdf->Cell(14,4,$dia,'L',0,'C');
$pdf->Cell(14,4,$mes,1,0,'C');
$pdf->Cell(14,4,$anio,1,0,'C');
$pdf->Ln(3);

$pdf->SetRightMargin(15);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(210,1,'',0,1);
$pdf->Cell(65.6,5,'Nombre y Apellido',1,0,'C');
$pdf->Cell(65.6,5,'Cargo',1,0,'C');
$pdf->Cell(60.7,5,'Unidad Organizacional',1,1,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(65.6,3,$persona,'LTBR',0,'C');
$pdf->Cell(65.6,3,$cargo,'LTBR',0,'C');
$pdf->Cell(60.7,3,$unidad_org,'LTBR',0,'C');

$pdf->Ln();

$pdf->SetFont('Arial','B',8);
$y_motivo=$pdf->GetY();
$pdf->Cell(191.9,5,'MOTIVO DE LA SOLICITUD :','LR',1);

$pdf->SetFont('Arial','',7);
$pdf->SetY($y_motivo);
$pdf->MultiCell(191.9,4,'                                                        '.$pdf->preview_text($observaciones,490,0),'LRB');
$pdf->SetFont('Arial','B',8);


	
	$pdf->Cell(65.6,3,'ITEM','TRL',0,'C');//1
	$pdf->Cell(65.6,3,'UNIDAD','TRL',0,'C');//2
	$pdf->Cell(60.7,3,'CANTIDAD','TRL',0,'C');//3
	
	$pdf->Ln();
	//SEGUNDA LINEA
	$pdf->Cell(65.6,3,'','RL',0,'C');  //1
	$pdf->Cell(65.6,3,'MEDIDA','RL',0,'C');  //2
	$pdf->Cell(60.7,3,'','RL',0,'C');//3
	$pdf->Ln();
	
	$pdf->SetWidths(array(1,1,1,1,1,1,1,1,1,65.6,65.6,60.7));
	$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0));
	$pdf->SetVisibles(array(0,0,0,0,0,0,0,0,0,1,1,1));
	$pdf->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5,5,5));
	$pdf->SetAligns(array('','','','','','','','','','L','C','R'));
	$pdf->SetFontsStyles(array('','','','','','','','','','','',''));
	$pdf->SetDecimales(array(0,0,0,0,0,0,0,0,0,0,0,2));
	$pdf->SetSpaces(array(0,0,0,0,0,0,0,3,3,3,3,3));
	$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0));
	
	$pdf->SetFont('Arial','B',8);
	$detalle=$_SESSION['PDF_solicitud_salida'];
	
	for ($i=0; $i<count($detalle); $i++)
	{
		$pdf->MultiTabla($detalle[$i],0,3,3,6,1);
	}
	

$pdf->Ln();
//$pdf->SetFont('Arial','B',8);
//$pdf->Cell(207,4,'OBSERVACIONES	:','LRT',1);

/*$pdf->SetFont('Arial','',7);
$pdf->MultiCell(207,4,$pdf->preview_text($observaciones,490,0),'LBR');
$pdf->SetFont('Arial','B',8);
*/
$pdf->SetFillColor(200, 200, 200);	//Plomo oscuro


//$data=array();
//$data=$_SESSION['PDF_solicitud_fondo']; falta llamada a la funcion para armar el pe de la tabla
$pdf->SetFont('Arial','B',6);
$pdf->Cell(65.6,5,'SOLICITUD','LTBR',0,'C',true);
$pdf->Cell(65.6,5,'AUTORIZACION','LTBR',0,'C',true);
$pdf->Cell(60.7,5,'ENCARGADO ALMACENES','LTBR',1,'C',true);
$pdf->SetFont('Arial','B',8);

	
$pdf->Cell(65.6,15,'','LTBR',0,'C');
$pdf->Cell(65.6,15,'','LTBR',0,'C');
$pdf->Cell(60.7,15,'','LTBR',1,'C');

$pdf->SetFont('Arial','',5);
$pdf->Cell(65.6,2,$persona,'LTBR',0,'C');
$pdf->Cell(65.6,2,$aprobador,'LTBR',0,'C');
$pdf->Cell(60.7,2,'','LTBR',1,'C');

$pdf->SetFont('Arial','B',6);
$pdf->Cell(65.6,3,'SOLICITANTE','LTBR',0,'C',true);
$pdf->Cell(65.6,3,$cargo_aprobador,'LTBR',0,'C',true);
$pdf->Cell(60.7,3,'PARAMETRIZAR','LTBR',0,'C',true);

$pdf->Output();
?>