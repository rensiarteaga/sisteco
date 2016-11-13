<?php

session_start();

require('../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
class PDF extends FPDF
{   
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    //Iniciación de variables
    }
 var $widths;
 var $aligns;
function Header()
{
    //Logo
 
    $this->Image('../../../lib/images/logo_reporte.jpg',170,2,35,15);
   // $this->Line(15,15,195,15);
   
}
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
$fecha=date("d-m-Y");
	$hora=date("h:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - COMPRO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
}


//Cabecera de página

}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf-> AddFont('Tahoma','','tahoma.php');
$pdf-> AddFont('Arial','','arial.php');

//-----------------------Primera Solicitud

$pdf->SetFont('Tahoma','',10);
$pdf->SetLeftMargin(15);
$pdf->SetTopMargin(15);
 $pdf->SetAutoPageBreak(true,7);

 $pdf->SetFillColor(200,200,200);
$pdf->SetDrawColor(255,255,255);
$pdf->SetLineWidth(0.5);
$pdf->Cell(200,13,' ',0,1); 
$pdf->SetFont('Arial','B',8);
$pdf->Cell(180,5,'Original','T',1,'R');
$pdf->SetFont('Arial','BI',14);

$pdf->Cell(180,5,'SOLICITUD DE '.$_SESSION['PDF_titulo'],0,1,'C'); 
$pdf->Cell(200,3,' ',0,1);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(45,4,'Número',0,0); 
$pdf->Cell(45,4,'Localidad ',0,0); 
$pdf->Cell(45,4,'Fecha Solicitud',0,0); 
$pdf->Cell(45,4,'Hora Solicitud',0,1); 
$pdf->SetFont('Arial','',8);
/* cambiar el tipo de fecha */
$fecha1=date_create ($_SESSION['PDF_fecha_reg']); 
$fecha=date_format( $fecha1,'d/m/Y');
$pdf->Cell(45,4,''.$_SESSION['PDF_num_solicitud'].'',0,0); 
$pdf->Cell(45,4,''.$_SESSION['PDF_localidad'].'',0,0); 
$pdf->Cell(45,4,''.$fecha.'',0,0); 
$pdf->Cell(45,4,''.$_SESSION['PDF_hora_reg'].'',0,1); 
$pdf->Ln(3);
/*$tam_texto = $pdf->NbLines(60,$_SESSION['PDF_nombre_unidad'].'');
$h=3*$tam_texto;
*/
$y=$pdf->GetY();
$pdf->SetFont('Arial','B',6);
$pdf->Cell(25,4,'Unidad Organizacional:',0,0);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(75,4,''.$_SESSION['PDF_nombre_unidad'].'',1,'L',1); 

$pdf->SetXY(115,$y);
 $pdf->SetFont('Arial','B',6);
$pdf->Cell(15,4,'Financiador:',0,0); 
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(80,4,''.$_SESSION['PDF_nombre_financiador'].'',1,'L',1);

$y=$pdf->GetY();
$pdf->SetFont('Arial','B',6);
$pdf->Cell(25,4,'Regional:',0,0); 
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(75,4,''.$_SESSION['PDF_nombre_regional'].'',1,'L',1);
$pdf->SetXY(115,$y);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(15,4,'Programa:',0,0);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(80,4,''.$_SESSION['PDF_nombre_programa'].'',1,'L',1);

$y=$pdf->GetY();
$pdf->SetFont('Arial','B',6);
$pdf->Cell(25,4,'Proyecto:',0,0);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(75,4,''.$_SESSION['PDF_nombre_proyecto'].'',1,'L',1);
$pdf->SetXY(115,$y);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(15,4,'Actividad:',0,0);
$pdf->SetFont('Arial','',6);
$pdf->MultiCell(80,4,''.$_SESSION['PDF_nombre_actividad'].'',1,'L',1);

$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(0); 
$pdf->Ln(2);

$pdf->SetFont('Arial','B',9);

$pdf->Cell(17,4,'Código',1,0); 
$pdf->Cell(132,4,'Descripción',1,0); 
$pdf->Cell(8,4,'Cant.',1,0); 
$pdf->Cell(13,4,'Unidad',1,0); 
$pdf->Cell(25,4,'Imputación C.',1,1);
$pdf->SetFont('Arial','',8); 
$pdf->SetWidths(array(17,132,8,13,25));
$pdf->SetVisibles(array(1,1,1,1,1));
$pdf->SetFontsSizes(array(5,7,7,7,6));
$pdf->SetAligns(array('L','L','R','L','L'));
$pdf->SetSpaces(array(3.5,3.5,3.5,3.5,3.5));
//$pdf->SetFonts(array(10,10,10,10,10));

$data=$_SESSION['PDF_solicitud_det'];

$cdata=count($data);
$tipo_celda1=array(0,0,1,0,0,0);

$align1=array('L','L','R','L','L','L');
 for($i=0;$i<$cdata;$i++)
 {
  $pdf->MultiTabla($data[$i],0,1,3.5,7);
 }
 /*aqui las */
$pdf->Cell(195,10,'','T',1,'C');
$pdf->SetFont('Arial','',10);

$pdf->Cell(90,4,'____________________________',0,0,'C'); 
$pdf->Cell(90,4,'____________________________',0,1,'C'); 
$pdf->Cell(90,4,''.$_SESSION['PDF_nombre_aprobacion'].'',0,0,'C'); 
$pdf->Cell(90,4,''.$_SESSION['PDF_nombre_solicitante'].'',0,1,'C'); 
$pdf->SetFont('Arial','B',8);
$pdf->Cell(90,4,''.strtoupper($_SESSION['PDF_cargo_empleado_aprobador']).'',0,0,'C'); 
$pdf->Cell(90,4,''.strtoupper($_SESSION['PDF_cargo_empleado_solicitante']),0,1,'C'); 
$pdf->Cell(90,4,'Firma Autorizada',0,0,'C'); 
$pdf->Cell(90,4,'Solicitante' ,0,1,'C'); 


///////////////////////////////////fin de primera solicitud //////////////////////////////

$pdf->Output();
?>