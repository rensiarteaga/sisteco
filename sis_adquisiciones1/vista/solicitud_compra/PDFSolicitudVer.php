<?php

session_start();

require('../../../lib/fpdf/fpdf.php');
//require('../../../lib/fpdf/mc_table.php');
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
   
}
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Tahoma','',8);
    //Número de página
    $this->Cell(0,5,'Pagina '.$this->PageNo().' de {nb}',0,0,'C');
}


//Cabecera de página

}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf-> AddFont('Tahoma','','tahoma.php');
$pdf-> AddFont('Arial','','arial.php');

//-----------------------Primera Factura

$pdf->SetFont('Tahoma','',10);
$pdf->SetLeftMargin(15);
$pdf->Cell(200,12,' ',0,1); 
$pdf->SetFont('Arial','B',8);
//$pdf->Cell(15,3.5,'',0,1);
$texto='Original';
if($_SESSION['PDF_copia']!=''){
    $texto='Copia';
}


$pdf->Cell(180,5,''.$texto,'T',1,'R');
$pdf->SetFont('Arial','BI',14);

$pdf->Cell(180,5,'VERIFICACIÓN PRESUPUESTARIA',0,1,'C'); 
$pdf->Cell(200,2,' ',0,1); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,5,'Número de Solicitud',0,0); 
$pdf->Cell(40,5,'Localidad ',0,0);
$pdf->Cell(30,5,'Moneda ',0,0); 
$pdf->Cell(35,5,'Fecha',0,0); 
$pdf->Cell(35,5,'Hora',0,1); 
$pdf->SetFont('Arial','',10);
$fecha1=date_create ($_SESSION['PDF_fecha_entrega']); 
$fecha=date_format( $fecha1,'d/m/Y');
$pdf->Cell(40,5,''.$_SESSION['PDF_num_solicitud'].'',0,0); 
$pdf->Cell(40,5,''.$_SESSION['PDF_localidad'].'',0,0); 
$pdf->Cell(30,5,$_SESSION['PDF_moneda'].' ',0,0); 
$pdf->Cell(35,5,''.$fecha.'',0,0); 
$pdf->Cell(35,5,''.$_SESSION['PDF_hora_reg'].'',0,1); 

$pdf->Cell(60,5,''.$_SESSION['PDF_nombre_unidad'].'','TLR',0,'C'); 
$pdf->Cell(120,5,''.$_SESSION['PDF_nombre_solicitante'].'','TLR',1,'C'); 

$pdf->SetFont('Arial','B',10);
$pdf->Cell(60,5,'Unidad Organizacional','BLR',0,'C'); 
$pdf->Cell(120,5,'Solicitante','BLR',1,'C'); 
$pdf->SetFont('Arial','B',8); 

$pdf->Cell(15,5,'Código','LRT',0); 
$pdf->Cell(75,5,'Descripción','LRT',0);
$pdf->Cell(15,5,'Cantidad','LRT',0);  
$pdf->Cell(25,5,'Precio','LRT',0); 
$pdf->Cell(25,5,'Precio','LRT',0);
$pdf->Cell(25,5,'Monto','LRT',1); 

$pdf->Cell(15,5,'','LRB',0); 
$pdf->Cell(75,5,'','LRB',0); 
$pdf->Cell(15,5,'','LRB',0);  
$pdf->Cell(25,5,'Unitario','LRB',0);
$pdf->Cell(25,5,'Total','LRB',0);
$pdf->Cell(25,5,'Aprobado','LRB',1); 

$pdf->SetFont('Arial','',8); 
$pdf->SetWidths(array(15,75,15,25,25,25));
$pdf->SetAligns(array('L','L','R','R','R','R'));

$data=$_SESSION['PDF_solicitud_det'];

$cdata=count($data);

 for($i=0;$i<$cdata;$i++)
 {
   $pdf->Row($data[$i]);
 }
$pdf->Cell(180,10,'','TLR',1,'C');
$pdf->SetFont('Arial','',10);


$pdf->Cell(180,5,'________________________________','LR',1,'C'); 
$pdf->Cell(180,5,''.$_SESSION['PDF_nombre_aprobacion'].'','LR',1,'C'); 

$pdf->SetFont('Arial','B',10);

$pdf->Cell(180,5,'Responsable de Presupuestos','LBR',1,'C'); 

///////////////////////////////////fin de primera factura //////////////////////////////

$posicion=$pdf->GetY();
if ($posicion>50){
$pdf->AddPage();
}
$pdf->SetFont('Tahoma','',10);
$pdf->SetLeftMargin(15);
$pdf->Cell(200,12,' ',0,1); 
$pdf->SetFont('Arial','B',8);
//$pdf->Cell(15,3.5,'',0,1);
$pdf->Cell(180,5,'Copia: Adquisiciones','T',1,'R');
$pdf->SetFont('Arial','BI',14);

$pdf->Cell(180,5,'VERIFICACIÓN PRESUPUESTARIA',0,1,'C'); 
$pdf->Cell(200,2,' ',0,1); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,5,'Número de Solicitud',0,0); 
$pdf->Cell(40,5,'Localidad ',0,0);
$pdf->Cell(30,5,'Moneda ',0,0); 
$pdf->Cell(35,5,'Fecha',0,0); 
$pdf->Cell(35,5,'Hora',0,1); 
$pdf->SetFont('Arial','',10);
$fecha1=date_create ($_SESSION['PDF_fecha_entrega']); 
$fecha=date_format( $fecha1,'d/m/Y');
$pdf->Cell(40,5,''.$_SESSION['PDF_num_solicitud'].'',0,0); 
$pdf->Cell(40,5,''.$_SESSION['PDF_localidad'].'',0,0); 
$pdf->Cell(30,5,$_SESSION['PDF_moneda'].' ',0,0); 
$pdf->Cell(35,5,''.$fecha.'',0,0); 
$pdf->Cell(35,5,''.$_SESSION['PDF_hora_reg'].'',0,1); 

$pdf->Cell(60,5,''.$_SESSION['PDF_nombre_unidad'].'','TLR',0,'C'); 
$pdf->Cell(120,5,''.$_SESSION['PDF_nombre_solicitante'].'','TLR',1,'C'); 

$pdf->SetFont('Arial','B',10);
$pdf->Cell(60,5,'Unidad Organizacional','BLR',0,'C'); 
$pdf->Cell(120,5,'Solicitante','BLR',1,'C'); 
$pdf->SetFont('Arial','B',8); 

$pdf->Cell(15,5,'Código','LRT',0); 
$pdf->Cell(75,5,'Descripción','LRT',0);
$pdf->Cell(15,5,'Cantidad','LRT',0);  
$pdf->Cell(25,5,'Precio','LRT',0); 
$pdf->Cell(25,5,'Precio','LRT',0);
$pdf->Cell(25,5,'Monto','LRT',1); 

$pdf->Cell(15,5,'','LRB',0); 
$pdf->Cell(75,5,'','LRB',0); 
$pdf->Cell(15,5,'','LRB',0);  
$pdf->Cell(25,5,'Unitario','LRB',0);
$pdf->Cell(25,5,'Total','LRB',0);
$pdf->Cell(25,5,'Aprobado','LRB',1); 

$pdf->SetFont('Arial','',8); 
$pdf->SetWidths(array(15,75,15,25,25,25));
$pdf->SetAligns(array('L','L','R','R','R','R'));

$data=$_SESSION['PDF_solicitud_det'];

$cdata=count($data);

 for($i=0;$i<$cdata;$i++)
 {
   $pdf->Row($data[$i]);
 }
$pdf->Cell(180,10,'','TLR',1,'C');
$pdf->SetFont('Arial','',10);


$pdf->Cell(180,5,'________________________________','LR',1,'C'); 
$pdf->Cell(180,5,''.$_SESSION['PDF_nombre_aprobacion'].'','LR',1,'C'); 

$pdf->SetFont('Arial','B',10);

$pdf->Cell(180,5,'Responsable de Presupuestos','LBR',1,'C'); 


$pdf->Output();
?>