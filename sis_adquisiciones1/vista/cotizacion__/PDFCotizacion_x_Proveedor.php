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
 
function Header()
{
}
//Pie de página
function Footer()
{   $solicitud=$_SESSION['PDF_solicitud'];
    $num_solicitud='';
    for($v=0;$v<count($solicitud);$v++){
	//  $fecha_hoy=$solicitud[$v][1];
	   if($v==0){
	     $num_solicitud=$num_solicitud.$solicitud[$v][0];
	   }else{
	     $num_solicitud=$num_solicitud.','.$solicitud[$v][0];	
	   }
	
     }
    //Posición: a 1,5 cm del final
    $this->SetY(-25);
    //Arial italic 8
    $this->SetFont('Tahoma','',7);
    //Número de página
    $this->SetFillColor(0,0,0);
	$this->Cell(185,0.3,'',1,1,'L',1);
    $this->SetX(100);
    $this->Cell(50,3,'Av. Ballivián Nº 0503',0,1);
    $this->SetX(100);
    $this->Cell(50,3,'Edificio Colon 7mo Piso',0,1);
    $this->SetX(100);
    $this->Cell(50,3,'Telefono: 4520317 -4520321',0,1);
    $this->SetX(100);
    $this->Cell(50,3,'Fax: 4520318',0,1);
    $this->Cell(50,3,'Pagina '.$this->PageNo().' de {nb}',0,1,'L');
    $this->Cell(50,3,'Pedido Nº '.$num_solicitud,0,1,'L');
   }
}

if($_SESSION['PDF_tipo_cotizado']=='sc'){
	
$tam_cotizacion=0;	
}else{
$cotizacion_array=$_SESSION['PDF_cotizaciones'];
$tam_cotizacion=count($cotizacion_array);
	
}


/*$cotizacion_array=$_SESSION['PDF_cotizaciones'];
$tam_cotizacion=count($cotizacion_array);
*/
$pdf=new PDF();
//$pdf->AddPage();
$pdf->AliasNbPages();
$pdf-> AddFont('Tahoma','','tahoma.php');
$pdf-> AddFont('Arial','','arial.php'); 	
$pdf->SetFont('Tahoma','',10);
$pdf->SetLeftMargin(15);
$pdf->SetAutoPageBreak(true,20.5);
$pdf->SetFont('Arial','B',10);

for($i=0;$i<$tam_cotizacion;$i++)
 {

$pdf->AddPage();
$pdf->SetX(170);
if($_SESSION['PDF_titulo']=='SERVICIO'){
$pdf->Cell(30,4,'CS'.'-'.$_SESSION['PDF_num_cotizacion_'.$i].'-'.$_SESSION['PDF_gestion_'.$i],0,1);
}else{
$pdf->Cell(30,4,'CB'.'-'.$_SESSION['PDF_num_cotizacion_'.$i].'-'.$_SESSION['PDF_gestion_'.$i],0,1);	
}
$pdf->SetFont('Arial','',10);
$pdf->SetFont('Arial','B',8);
$pdf->SetX(170);
$pdf->Cell(30,4,'Localidad',0,1); 
$pdf->SetFont('Arial','',8);
$pdf->SetX(170);
$pdf->Cell(30,4,$_SESSION['ss_nombre_lugar'],0,1); 
$pdf->SetFont('Arial','B',8);
$pdf->SetX(170);
$pdf->Cell(10,4,'Día',1,0);
$pdf->Cell(10,4,'Mes',1,0);
$pdf->Cell(10,4,'Año',1,1);

$fecha_completa=$_SESSION['PDF_fecha_reg_'.$i];
$dia=substr($fecha_completa,8,2);
$mes=substr($fecha_completa,5,2);
$anio=substr($fecha_completa,0,4);
$pdf->SetFont('Arial','',8);
$pdf->SetX(170);
$pdf->Cell(10,4,$dia,1,0);
$pdf->Cell(10,4,$mes,1,0);
$pdf->Cell(10,4,$anio,1,0);
$pdf->SetFont('Arial','BI',18);
$pdf->SetXY(45,4);

$pdf->Cell(105,20,'Solicitud de Cotización',0,0,'C'); 
$pdf->Image('../../../lib/images/logo_reporte.jpg',15,2,35,15);
$pdf->SetFont('Arial','',10);
$pdf->SetY(20);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,3.5,'',0,1);
$pdf->SetFillColor(200,200,200);
$pdf->SetDrawColor(255,255,255);
$pdf->SetLineWidth(0.5);
$pdf->Cell(200,1.8,' ',0,1); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20,5,'Señores:',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->SetFillColor(200,200,200);
$pdf->MultiCell(125,5,''.$_SESSION['PDF_nombres_'.$i].'',1,'L',1);
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(160,25);
$pdf->Cell(15,5,'Telf.:',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(25,5,''.$_SESSION['PDF_telefono1_'.$i].'',1,1,'L',1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20,5,'Dirección ',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(125,5,''.$_SESSION['PDF_direccion_'.$i].' ',1,'L',1); 
$pdf->SetX(160);
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(160,30);
$pdf->Cell(15,5,'Telf 2.:',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(25,5,''.$_SESSION['PDF_telefono2_'.$i].'',1,1,'L',1);
$pdf->SetFont('Arial','B',10);
$pdf->SetX(160);
$pdf->Cell(15,5,'Celul:',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(25,5,''.$_SESSION['PDF_celular1_'.$i].'',1,1,'L',1);
$pdf->SetFont('Arial','B',10);

$pdf->Cell(20,5,'Email',0,0);
$pdf->SetFont('Arial','',10); 
$pdf->Cell(125,5,''.$_SESSION['PDF_email1_'.$i].'',1,0,'L',1); 
$pdf->SetFont('Arial','B',10);

$pdf->Cell(15,5,'Fax',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(25,5,''.$_SESSION['PDF_fax_'.$i].'',1,1,'L',1);
/*echo "muestra algo?".isset($_SESSION['PDF_fecha_entrega_'.$i]);
exit;*/


if (!isset($_SESSION['PDF_fecha_entrega_'.$i])){
  $fecha=$fecha_completa;	
}else{
$fecha1=date_create ($_SESSION['PDF_fecha_entrega_'.$i]); 
$fecha=date_format( $fecha1,'d/m/Y');
}

$pdf->MultiCell(185,5,'Agradeceremos a Ud.(s) cotizar el siguiente material con IMPUESTOS INCLUIDOS, indicando plazo de entrega y validez de su oferta hasta el '.$fecha,0,1);
$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(0); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(7,5,'Nro',1,0); 
$pdf->Cell(16,5,'Cantidad',1,0); 
$pdf->Cell(13,5,'Unidad',1,0); 
$pdf->Cell(97,5,''.$_SESSION['PDF_titulo'].'',1,0); 
$pdf->Cell(26,5,'Precio Unitario',1,0); 
$pdf->Cell(26,5,'Total (Bs.)',1,1);

$pdf->SetFont('Arial','',10); 
$pdf->SetWidths(array(7,16,13,97,26,26));
$pdf->SetAligns(array('R','R','L','L','R','R'));

$data=$_SESSION['PDF_cotizacion_det'];
/*print_r($data);
exit;*/
$cdata=count($data);
$numero=array();
 for($j=0;$j<$cdata;$j++)
 { 
   $numero=$j+1;
   $pdf->Row(array_merge((array)$numero,(array)$data[$j]));
 }

$pdf->Cell(130,5,'','T',0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(55,5,'IMPORTE TOTAL:','T',1);
$pdf->SetFillColor(0,0,0);
$pdf->Cell(185,0.3,'',1,1,'L',1);
$pdf->Ln(5);
$pdf->SetFillColor(200,200,200);
$pdf->SetDrawColor(255,255,255);
$pdf->SetLineWidth(0.5);

$pdf->Cell(35,5,'Plazo de Entrega:',0,0);
$pdf->Cell(57,5,'',1,0,'L',1);
$pdf->Cell(35,5,'Moneda:',0,0);
$pdf->Cell(57,5,'',1,1,'L',1);
$pdf->Cell(35,5,'Validez de la Oferta:',0,0);
$pdf->Cell(57,5,'',1,0,'L',1);
$pdf->Cell(35,5,'Lugar de Entrega:',0,0);
$pdf->MultiCell(57,5,'',1,'L',1);
$pdf->Cell(35,5,'Forma de pago:',0,0);
$pdf->Cell(57,5,'',1,0,'L',1);
$pdf->Cell(35,5,'Garantía:',0,0);
$pdf->Cell(57,5,'',1,1,'L',1);
$pdf->SetFillColor(0,0,0);
$pdf->Ln(5);
$pdf->Cell(185,0.3,'',1,1,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->Cell(185,5,'p/Empresa Nacional de Electricidad',0,1,'C');
 $pdf->SetFont('Arial','B',10);   
$pdf->Cell(92,15,'',0,0,'C');
$pdf->Cell(93,15,'',0,1,'C');
$pdf->Cell(92,5,'___________________',0,0,'C'); 
$pdf->Cell(93,5,'___________________',0,1,'C'); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(92,5,'Firma Autorizada',0,0,'C'); 
$pdf->Cell(93,5,'Sello y Firma del Proveedor',0,0,'C');
$pdf->SetDrawColor(0,0,0); 
$pdf->SetFillColor(0,0,0);
$pdf->SetLineWidth(0);
 }
/*$pdf->AddPage();
$pdf->SetX(170);
$pdf->Cell(30,4,'Nro CB'.'-'.$_SESSION['PDF_num_cotizacion_0'].'-'.$_SESSION['PDF_gestion_0'],0,1);
$pdf->SetFont('Arial','',10);
$pdf->SetFont('Arial','B',8);
$pdf->SetX(170);
$pdf->Cell(30,4,'Localidad',0,1); 
$pdf->SetFont('Arial','',8);
$pdf->SetX(170);
$pdf->Cell(30,4,$_SESSION['ss_nombre_lugar'],0,1); 
$pdf->SetFont('Arial','B',8);
$pdf->SetX(170);
$pdf->Cell(10,4,'Día',1,0);
$pdf->Cell(10,4,'Mes',1,0);
$pdf->Cell(10,4,'Año',1,1);
$fecha_completa=$_SESSION['PDF_fecha_reg_0'];
$dia=substr($fecha_completa,8,2);
$mes=substr($fecha_completa,5,2);
$anio=substr($fecha_completa,0,4);
$pdf->SetX(170);
$pdf->SetFont('Arial','',8);
$pdf->Cell(10,4,$dia,1,0);
$pdf->Cell(10,4,$mes,1,0);
$pdf->Cell(10,4,$anio,1,0);
$pdf->SetFont('Arial','BI',18);
$pdf->SetXY(45,4);

$pdf->Cell(105,20,'Solicitud de Cotización',0,0,'C'); 
$pdf->Image('../../../lib/images/logo_reporte.jpg',15,2,35,15);

$pdf->SetFont('Arial','',10);
$pdf->SetY(20);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,3.5,'',0,1);
$pdf->SetFillColor(200,200,200);
$pdf->SetDrawColor(255,255,255);
$pdf->SetLineWidth(0.5);
$pdf->Cell(200,1.8,' ',0,1); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20,5,'Señores:',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->SetFillColor(200,200,200);
$pdf->MultiCell(125,5,'',1,'L',1);
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(160,25);
$pdf->Cell(15,5,'Telf.:',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(25,5,'',1,1,'L',1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20,5,'Dirección ',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(125,5,'',1,'L',1); 
$pdf->SetX(160);
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(160,30);
$pdf->Cell(15,5,'Telf 2.:',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(25,5,'',1,1,'L',1);
$pdf->SetFont('Arial','B',10);
$pdf->SetX(160);
$pdf->Cell(15,5,'Celul:',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(25,5,'',1,1,'L',1);
$pdf->SetFont('Arial','B',10);

$pdf->Cell(20,5,'Email',0,0);
$pdf->SetFont('Arial','',10); 
$pdf->Cell(125,5,'',1,0,'L',1); 
$pdf->SetFont('Arial','B',10);

$pdf->Cell(15,5,'Fax',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(25,5,'',1,1,'L',1);

$pdf->MultiCell(185,5,'Agradeceremos a Ud.(s) cotizar el siguiente material con IMPUESTOS INCLUIDOS, indicando plazo de entrega y validez de su oferta',0,1);
$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(0); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(7,5,'Nro',1,0); 
$pdf->Cell(16,5,'Cantidad',1,0); 
$pdf->Cell(13,5,'Unidad',1,0); 
$pdf->Cell(97,5,''.$_SESSION['PDF_titulo'].'',1,0); 
$pdf->Cell(26,5,'Precio Unitario',1,0); 
$pdf->Cell(26,5,'Total (Bs. $us)',1,1);

$pdf->SetFont('Arial','',10); 
$pdf->SetWidths(array(7,16,13,97,26,26));
$pdf->SetAligns(array('R','R','L','L','R','R'));
$data1=$_SESSION['PDF_cotizacion_det'];
$cdata1=count($data1);

$numero=array();
 for($k=0;$k<$cdata1;$k++)
 { 
   $numero=$k+1;
   $pdf->Row(array_merge((array)$numero,(array)$data1[$k]));
 }
$pdf->Cell(130,5,'','T',0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(55,5,'IMPORTE TOTAL:','T',1);
$pdf->SetFillColor(0,0,0);
$pdf->Cell(185,0.3,'',1,1,'L',1);
$pdf->Ln(5);
$pdf->SetFillColor(200,200,200);
$pdf->SetDrawColor(255,255,255);
$pdf->SetLineWidth(0.5);
$pdf->Cell(35,5,'Plazo de Entrega:',0,0);
$fecha1=date_create($_SESSION['PDF_fecha_entrega_0']); 
$fecha=date_format($fecha1,'d/m/Y');

$pdf->Cell(57,5,''.$fecha,1,0,'L',1);
$pdf->Cell(35,5,'Moneda:',0,0);
$pdf->Cell(57,5,'',1,1,'L',1);
$pdf->Cell(35,5,'Validez de la Oferta:',0,0);
$pdf->Cell(57,5,'',1,0,'L',1);
$pdf->Cell(35,5,'Lugar de Entrega:',0,0);
$pdf->MultiCell(57,5,''.$_SESSION['PDF_lugar_entrega_0'].'',1,'L',1);
$pdf->Cell(35,5,'Forma de pago:',0,0);
$pdf->Cell(57,5,'',1,0,'L',1);
$pdf->Cell(35,5,'Garantía:',0,0);
$pdf->Cell(57,5,'',1,1,'L',1);
$pdf->SetFillColor(0,0,0);
$pdf->Ln(5);
$pdf->Cell(185,0.3,'',1,1,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->Cell(185,5,'p/ Empresa Nacional de Electricidad S.A.',0,1,'C');
$pdf->SetFont('Arial','B',10);   
$pdf->Cell(92,15,'',0,0,'C');
$pdf->Cell(93,15,'',0,1,'C');
$pdf->Cell(92,5,'___________________',0,0,'C'); 
$pdf->Cell(93,5,'___________________',0,1,'C'); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(92,5,'Firma Autorizada',0,0,'C'); 
$pdf->Cell(93,5,'Sello y Firma del Proveedor',0,1,'C'); 
$pdf->SetFont('Arial','',6);
  $pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(0); */
$pdf->Output();
?>