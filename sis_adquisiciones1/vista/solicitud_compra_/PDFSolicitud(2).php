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
    $this->SetY(-15);
 
    $this->SetFont('Tahoma','',8);
    $this->Line(15,262,195,262);
    $this->Cell(0,5,'Pagina '.$this->PageNo().' de {nb}',0,0,'C');
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
 $pdf->SetAutoPageBreak(true,15);

$pdf->Cell(200,13,' ',0,1); 
$pdf->SetFont('Arial','B',8);
$pdf->Cell(180,5,'Original','T',1,'R');
$pdf->SetFont('Arial','BI',14);

$pdf->Cell(180,5,'SOLICITUD DE '.$_SESSION['PDF_titulo'],0,1,'C'); 
$pdf->Cell(200,2,' ',0,1); 
$pdf->SetFont('Arial','B',9);
$pdf->Cell(45,4,'Número',0,0); 
$pdf->Cell(45,4,'Localidad ',0,0); 
$pdf->Cell(45,4,'Fecha',0,0); 
$pdf->Cell(45,4,'Hora',0,1); 
$pdf->SetFont('Arial','',8);
/* cambiar el tipo de fecha */
$fecha1=date_create ($_SESSION['PDF_fecha_reg']); 
$fecha=date_format( $fecha1,'d/m/Y');
$pdf->Cell(45,4,''.$_SESSION['PDF_num_solicitud'].'',0,0); 
$pdf->Cell(45,4,''.$_SESSION['PDF_localidad'].'',0,0); 
$pdf->Cell(45,4,''.$fecha.'',0,0); 
$pdf->Cell(45,4,''.$_SESSION['PDF_hora_reg'].'',0,1); 
$tam_texto = $pdf->NbLines(60,$_SESSION['PDF_nombre_unidad'].'');
$h=3*$tam_texto;
//'TLR'
$y2=$pdf->GetY();
$pdf->Line(15,$y2,15,$y2+(10+$h));
$pdf->Line(75,$y2,75,$y2+(10+$h));
$pdf->Line(145,$y2,145,$y2+(10+$h));
$pdf->Line(195,$y2,195,$y2+(10+$h));
$pdf->Cell(60,10,'','TLR',0); 
$pdf->Cell(70,10,'','TLR',0); 
$pdf->Cell(50,10,'','TLR',1); 
$x=$pdf->GetX();
$y=$pdf->GetY();

//$pdf->MultiCell(60,5,''.$_SESSION['PDF_nombre_unidad'].'','LR','C'); 
$pdf->MultiCell(60,3,''.$_SESSION['PDF_nombre_unidad'].'','LR','C'); 
$y1=$pdf->GetY();
$pdf->SetXY($x+60,$y1-3);
//$pdf->SetY($y);
$pdf->MultiCell(70,3,''.$_SESSION['PDF_nombre_solicitante'].'','LR','C'); 
$pdf->SetXY($x+130,$y1-3);
$pdf->Cell(50,3,'____________________','LR',1,'C'); 
$pdf->SetFont('Arial','B',9);
$pdf->SetXY($x,(3*$tam_texto)+$y);
$pdf->Cell(60,4,'Unidad Organizacional','BLR',0,'C'); 
$pdf->Cell(70,4,'Solicitante','BLR',0,'C'); 
$pdf->Cell(50,4,'Firma Solicitante','BLR',1,'C'); 
$pdf->Cell(17,4,'Código',1,0); 
$pdf->Cell(122,4,'Descripción',1,0); 
$pdf->Cell(8,4,'Cant.',1,0); 
$pdf->Cell(13,4,'Unidad',1,0); 
$pdf->Cell(20,4,'Imputación C.',1,1);
$pdf->SetFont('Arial','',8); 
$pdf->SetWidths(array(17,122,8,13,20));
$pdf->SetVisibles(array(1,1,1,1,1));
$pdf->SetFontsSizes(array(6,8,8,8,6));
$pdf->SetAligns(array('L','L','R','L','L'));
//$pdf->SetSpaces(array(4,4,4,4,4));
//$pdf->SetFonts(array(10,10,10,10,10));

$data=$_SESSION['PDF_solicitud_det'];

$cdata=count($data);
$tipo_celda1=array(0,0,1,0,0,0);

$align1=array('L','L','R','L','L','L');
 for($i=0;$i<$cdata;$i++)
 {
  $pdf->MultiTabla($data[$i],0,1);
 }
 /*aqui las */
$pdf->Cell(180,10,'','T',1,'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(180,5,'____________________________',0,1,'C'); 
$pdf->Cell(180,5,''.$_SESSION['PDF_nombre_aprobacion'].'',0,1,'C'); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(180,5,'Firma Autorizada',0,1,'C'); 
$pdf->Ln(50);

/*$pdf->Cell(65,5,'___________________','LR',0,'C'); 
$pdf->Cell(65,5,'___________________','LR',0,'C'); 
$pdf->Cell(50,5,'___________________','LR',1,'C'); 
$pdf->Cell(65,5,''.$_SESSION['PDF_nombre_aprobacion'].'','LR',0,'C'); 
$pdf->Cell(65,5,''.$_SESSION['PDF_nombre_solicitante'].'','LR',0,'C'); 
$pdf->Cell(50,5,'','LR',1,'C'); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(65,5,'Firma Autorizada','LBR',0,'C'); 
$pdf->Cell(65,5,'Receptor ','LBR',0,'C'); 
$pdf->Cell(50,5,'Resp. Centro','LBR',1,'C'); 
*/
//$pdf->Cell(175,5,'___________________','LR',1,'C'); 

///////////////////////////////////fin de primera solicitud //////////////////////////////


//-----------------------Segunda Factura
$posicion=$pdf->GetY();
if ($posicion>250){
$pdf->AddPage();
}
$pdf->SetFont('Tahoma','',10);
$pdf->SetLeftMargin(15);
$pdf->Cell(200,2,' ',0,1); 
$pdf->SetFont('Arial','B',8);
$pdf->Cell(180,5,'Copia: Contabilidad','T',1,'R');
$pdf->SetFont('Arial','BI',14);
$pdf->Cell(180,5,'SOLICITUD DE '.$_SESSION['PDF_titulo'],0,1,'C'); 
$pdf->Cell(200,2,' ',0,1); 
$pdf->SetFont('Arial','B',9);
$pdf->Cell(45,4,'Número',0,0); 
$pdf->Cell(45,4,'Localidad ',0,0); 
$pdf->Cell(45,4,'Fecha',0,0); 
$pdf->Cell(45,4,'Hora',0,1); 
$pdf->SetFont('Arial','',8);
/* cambiar el tipo de fecha */
$fecha1=date_create ($_SESSION['PDF_fecha_reg']); 
$fecha=date_format( $fecha1,'d/m/Y');
$pdf->Cell(45,4,''.$_SESSION['PDF_num_solicitud'].'',0,0); 
$pdf->Cell(45,4,''.$_SESSION['PDF_localidad'].'',0,0); 
$pdf->Cell(45,4,''.$fecha.'',0,0); 
$pdf->Cell(45,4,''.$_SESSION['PDF_hora_reg'].'',0,1); 
$tam_texto = $pdf->NbLines(60,$_SESSION['PDF_nombre_unidad'].'');
$h=3*$tam_texto;
//'TLR'
$y2=$pdf->GetY();
$pdf->Line(15,$y2,15,$y2+(10+$h));
$pdf->Line(75,$y2,75,$y2+(10+$h));
$pdf->Line(145,$y2,145,$y2+(10+$h));
$pdf->Line(195,$y2,195,$y2+(10+$h));
$pdf->Cell(60,10,'','TLR',0); 
$pdf->Cell(70,10,'','TLR',0); 
$pdf->Cell(50,10,'','TLR',1); 
$x=$pdf->GetX();
$y=$pdf->GetY();

//$pdf->MultiCell(60,5,''.$_SESSION['PDF_nombre_unidad'].'','LR','C'); 
$pdf->MultiCell(60,3,''.$_SESSION['PDF_nombre_unidad'].'','LR','C'); 
$y1=$pdf->GetY();
$pdf->SetXY($x+60,$y1-3);
//$pdf->SetY($y);
$pdf->MultiCell(70,3,''.$_SESSION['PDF_nombre_solicitante'].'','LR','C'); 
$pdf->SetXY($x+130,$y1-3);
$pdf->Cell(50,3,'____________________','LR',1,'C'); 
$pdf->SetFont('Arial','B',9);
$pdf->SetXY($x,(3*$tam_texto)+$y);
$pdf->Cell(60,4,'Unidad Organizacional','BLR',0,'C'); 
$pdf->Cell(70,4,'Solicitante','BLR',0,'C'); 
$pdf->Cell(50,4,'Firma Solicitante','BLR',1,'C'); 
$pdf->Cell(17,4,'Código',1,0); 
$pdf->Cell(122,4,'Descripción',1,0); 
$pdf->Cell(8,4,'Cant.',1,0); 
$pdf->Cell(13,4,'Unidad',1,0); 
$pdf->Cell(20,4,'Imputación C.',1,1);
$pdf->SetFont('Arial','',8); 
$pdf->SetWidths(array(17,122,8,13,20));
$pdf->SetVisibles(array(1,1,1,1,1));
$pdf->SetFontsSizes(array(6,8,8,8,6));
$pdf->SetAligns(array('L','L','R','L','L'));
//$pdf->SetFonts(array(10,10,10,10,10));

$data=$_SESSION['PDF_solicitud_det'];

$cdata=count($data);
$tipo_celda1=array(0,0,1,0,0,0);

$align1=array('L','L','R','L','L','L');
 for($i=0;$i<$cdata;$i++)
 {
  $pdf->MultiTabla($data[$i],0,1);
 }
 /*aqui las */
$pdf->Cell(180,10,'','T',1,'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(180,5,'_____________________________',0,1,'C'); 
$pdf->Cell(180,5,''.$_SESSION['PDF_nombre_aprobacion'].'',0,1,'C'); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(180,5,'Firma Autorizada',0,1,'C'); 
$pdf->Ln(50);


///////////////////////////////////fin de segunda solicitud //////////////////////////////

//-----------------------Tercera solicitud
$posicion=$pdf->GetY();
if ($posicion>200){
$pdf->AddPage();
}

$pdf->SetFont('Tahoma','',10);
$pdf->SetLeftMargin(15);
$pdf->Cell(200,2,' ',0,1); 
$pdf->SetFont('Arial','B',8);
$pdf->Cell(180,5,'Copia: Adquisiciones','T',1,'R');
$pdf->SetFont('Arial','BI',14);
$pdf->Cell(180,5,'SOLICITUD DE '.$_SESSION['PDF_titulo'],0,1,'C'); 
$pdf->Cell(200,2,' ',0,1); 
$pdf->SetFont('Arial','B',9);
$pdf->Cell(45,4,'Número',0,0); 
$pdf->Cell(45,4,'Localidad ',0,0); 
$pdf->Cell(45,4,'Fecha',0,0); 
$pdf->Cell(45,4,'Hora',0,1); 
$pdf->SetFont('Arial','',8);
/* cambiar el tipo de fecha */
$fecha1=date_create ($_SESSION['PDF_fecha_reg']); 
$fecha=date_format( $fecha1,'d/m/Y');
$pdf->Cell(45,4,''.$_SESSION['PDF_num_solicitud'].'',0,0); 
$pdf->Cell(45,4,''.$_SESSION['PDF_localidad'].'',0,0); 
$pdf->Cell(45,4,''.$fecha.'',0,0); 
$pdf->Cell(45,4,''.$_SESSION['PDF_hora_reg'].'',0,1); 
$tam_texto = $pdf->NbLines(60,$_SESSION['PDF_nombre_unidad'].'');
$h=3*$tam_texto;
//'TLR'
$y2=$pdf->GetY();
$pdf->Line(15,$y2,15,$y2+(10+$h));
$pdf->Line(75,$y2,75,$y2+(10+$h));
$pdf->Line(145,$y2,145,$y2+(10+$h));
$pdf->Line(195,$y2,195,$y2+(10+$h));
$pdf->Cell(60,10,'','TLR',0); 
$pdf->Cell(70,10,'','TLR',0); 
$pdf->Cell(50,10,'','TLR',1); 
$x=$pdf->GetX();
$y=$pdf->GetY();

//$pdf->MultiCell(60,5,''.$_SESSION['PDF_nombre_unidad'].'','LR','C'); 
$pdf->MultiCell(60,3,''.$_SESSION['PDF_nombre_unidad'].'','LR','C'); 
$y1=$pdf->GetY();
$pdf->SetXY($x+60,$y1-3);
//$pdf->SetY($y);
$pdf->MultiCell(70,3,''.$_SESSION['PDF_nombre_solicitante'].'','LR','C'); 
$pdf->SetXY($x+130,$y1-3);
$pdf->Cell(50,3,'____________________','LR',1,'C'); 
$pdf->SetFont('Arial','B',9);
$pdf->SetXY($x,(3*$tam_texto)+$y);
$pdf->Cell(60,4,'Unidad Organizacional','BLR',0,'C'); 
$pdf->Cell(70,4,'Solicitante','BLR',0,'C'); 
$pdf->Cell(50,4,'Firma Solicitante','BLR',1,'C'); 
$pdf->Cell(17,4,'Código',1,0); 
$pdf->Cell(122,4,'Descripción',1,0); 
$pdf->Cell(8,4,'Cant.',1,0); 
$pdf->Cell(13,4,'Unidad',1,0); 
$pdf->Cell(20,4,'Imputación C.',1,1);
$pdf->SetFont('Arial','',8); 
$pdf->SetWidths(array(17,122,8,13,20));
$pdf->SetVisibles(array(1,1,1,1,1));
$pdf->SetFontsSizes(array(6,8,8,8,6));
$pdf->SetAligns(array('L','L','R','L','L'));
//$pdf->SetFonts(array(10,10,10,10,10));

$data=$_SESSION['PDF_solicitud_det'];

$cdata=count($data);
$tipo_celda1=array(0,0,1,0,0,0);

$align1=array('L','L','R','L','L','L');
 for($i=0;$i<$cdata;$i++)
 {
  $pdf->MultiTabla($data[$i],0,1);
 }
 /*aqui las */
$pdf->Cell(180,10,'','T',1,'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(180,5,'____________________________',0,1,'C'); 
$pdf->Cell(180,5,''.$_SESSION['PDF_nombre_aprobacion'].'',0,1,'C'); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(180,5,'Firma Autorizada',0,1,'C'); 
$pdf->Ln(50);


///////////////////////////////////fin de tercera solicitud //////////////////////////////

//-----------------------cuarta solicitud
$posicion=$pdf->GetY();
if ($posicion>200){
$pdf->AddPage();
}
$pdf->SetFont('Tahoma','',10);
$pdf->SetLeftMargin(15);
$pdf->Cell(200,2,' ',0,1); 
$pdf->SetFont('Arial','B',8);
$pdf->Cell(180,5,'Copia: Solicitante','T',1,'R');
$pdf->SetFont('Arial','BI',14);
$pdf->Cell(180,5,'SOLICITUD DE '.$_SESSION['PDF_titulo'],0,1,'C'); 
$pdf->Cell(200,2,' ',0,1); 
$pdf->SetFont('Arial','B',9);
$pdf->Cell(45,4,'Número',0,0); 
$pdf->Cell(45,4,'Localidad ',0,0); 
$pdf->Cell(45,4,'Fecha',0,0); 
$pdf->Cell(45,4,'Hora',0,1); 
$pdf->SetFont('Arial','',8);
/* cambiar el tipo de fecha */
$fecha1=date_create ($_SESSION['PDF_fecha_reg']); 
$fecha=date_format( $fecha1,'d/m/Y');
$pdf->Cell(45,4,''.$_SESSION['PDF_num_solicitud'].'',0,0); 
$pdf->Cell(45,4,''.$_SESSION['PDF_localidad'].'',0,0); 
$pdf->Cell(45,4,''.$fecha.'',0,0); 
$pdf->Cell(45,4,''.$_SESSION['PDF_hora_reg'].'',0,1); 
$tam_texto = $pdf->NbLines(60,$_SESSION['PDF_nombre_unidad'].'');
$h=3*$tam_texto;
//'TLR'
$y2=$pdf->GetY();
$pdf->Line(15,$y2,15,$y2+(10+$h));
$pdf->Line(75,$y2,75,$y2+(10+$h));
$pdf->Line(145,$y2,145,$y2+(10+$h));
$pdf->Line(195,$y2,195,$y2+(10+$h));
$pdf->Cell(60,10,'','TLR',0); 
$pdf->Cell(70,10,'','TLR',0); 
$pdf->Cell(50,10,'','TLR',1); 
$x=$pdf->GetX();
$y=$pdf->GetY();

//$pdf->MultiCell(60,5,''.$_SESSION['PDF_nombre_unidad'].'','LR','C'); 
$pdf->MultiCell(60,3,''.$_SESSION['PDF_nombre_unidad'].'','LR','C'); 
$y1=$pdf->GetY();
$pdf->SetXY($x+60,$y1-3);
//$pdf->SetY($y);
$pdf->MultiCell(70,3,''.$_SESSION['PDF_nombre_solicitante'].'','LR','C'); 
$pdf->SetXY($x+130,$y1-3);
$pdf->Cell(50,3,'___________________','LR',1,'C'); 
$pdf->SetFont('Arial','B',9);
$pdf->SetXY($x,(3*$tam_texto)+$y);
$pdf->Cell(60,4,'Unidad Organizacional','BLR',0,'C'); 
$pdf->Cell(70,4,'Solicitante','BLR',0,'C'); 
$pdf->Cell(50,4,'Firma Solicitante','BLR',1,'C'); 
$pdf->Cell(17,4,'Código',1,0); 
$pdf->Cell(122,4,'Descripción',1,0); 
$pdf->Cell(8,4,'Cant.',1,0); 
$pdf->Cell(13,4,'Unidad',1,0); 
$pdf->Cell(20,4,'Imputación C.',1,1);
$pdf->SetFont('Arial','',8); 
$pdf->SetWidths(array(17,122,8,13,20));
$pdf->SetVisibles(array(1,1,1,1,1));
$pdf->SetFontsSizes(array(6,8,8,8,6));
$pdf->SetAligns(array('L','L','R','L','L'));

//$pdf->SetFonts(array(10,10,10,10,10));

$data=$_SESSION['PDF_solicitud_det'];

$cdata=count($data);
$tipo_celda1=array(0,0,1,0,0,0);

$align1=array('L','L','R','L','L','L');
 for($i=0;$i<$cdata;$i++)
 {
  $pdf->MultiTabla($data[$i],0,1);
 }
 /*aqui las */
$pdf->Cell(180,10,'','T',1,'C');
$pdf->SetFont('Arial','',10);
$pdf->Cell(180,5,'_____________________________',0,1,'C'); 
$pdf->Cell(180,5,''.$_SESSION['PDF_nombre_aprobacion'].'',0,1,'C'); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(180,5,'Firma Autorizada',0,1,'C'); 



///////////////////////////////////fin de cuarta solicitud //////////////////////////////

$pdf->Output();
?>