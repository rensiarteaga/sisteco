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
 
function Header()
{
	$this->SetLeftMargin(15);
   $this->SetX(182);
$this->SetFont('Arial','B',10);
if($_SESSION['PDF_titulo']=='SERVICIO'){
$this->Cell(30,4,'OS'.'-'.$_SESSION['PDF_num_cotizacion'].'-'.$_SESSION['PDF_gestion'],0,1);
}else{
$this->Cell(30,4,'OC'.'-'.$_SESSION['PDF_num_cotizacion'].'-'.$_SESSION['PDF_gestion'],0,1);	
}

$this->SetFont('Arial','B',8);
$this->SetX(182);
$this->Cell(30,4,'Localidad',0,1); 
$this->SetFont('Arial','B',7);
$this->SetX(182);
$this->Cell(30,4,$_SESSION['ss_nombre_lugar'],0,1); 
$this->SetFont('Arial','B',8);
$this->SetX(182);
$this->Cell(10,4,'Día',1,0);
$this->Cell(10,4,'Mes',1,0);
$this->Cell(10,4,'Año',1,1);

$fecha_completa=$_SESSION['PDF_fecha_reg'];
$dia=substr($fecha_completa,8,2);
$mes=substr($fecha_completa,5,2);
$anio=substr($fecha_completa,0,4);
$this->SetFont('Arial','B',7);
$this->SetX(182);
$this->Cell(10,4,$dia,1,0);
$this->Cell(10,4,$mes,1,0);
$this->Cell(10,4,$anio,1,0);
$this->SetFont('Arial','BI',18);
$this->SetXY(45,4);
if($_SESSION['PDF_titulo']=='SERVICIO'){
$this->Cell(115,20,'Orden de Servicio',0,0,'C'); 
}else{
$this->Cell(115,20,'Orden de Compra',0,0,'C'); 
}
   
$this->Image('../../../lib/images/logo_reporte.jpg',15,2,35,15);
//$this->Cell(50,20,'',1,0); 


$this->SetY(20);
$this->SetFont('Arial','B',8);
$this->Cell(15,3.5,'',0,1);
/*$this->SetFont('Arial','BI',14);
$this->Cell(180,5,'Solicitud de Materiales y Equipo ',0,1,'C'); */

$this->SetFillColor(200,200,200);
$this->SetDrawColor(255,255,255);
$this->SetLineWidth(0.5);
$this->Cell(200,1.8,' ',0,1); 
$this->SetFont('Arial','B',10);
$this->Cell(20,5,'Señores:',0,0); 
$this->SetFont('Arial','B',8);
$this->MultiCell(137,5,''.$_SESSION['PDF_nombres'].'',1,'L',1);
$this->SetFont('Arial','B',10);
$this->SetXY(172,25);
$this->Cell(15,5,'Telf.:',0,0); 
$this->SetFont('Arial','B',8);
$this->Cell(25,5,''.$_SESSION['PDF_telefono1'].'',1,1,'L',1);

$this->SetFont('Arial','B',10);
$this->Cell(20,5,'Dirección ',0,0); 
$this->SetFont('Arial','B',8);
$this->MultiCell(137,5,''.$_SESSION['PDF_direccion'].'',1,'L',1); 
$this->SetX(172);
$this->SetFont('Arial','B',10);
$this->SetXY(172,30);
$this->Cell(15,5,'Telf 2.:',0,0); 
$this->SetFont('Arial','B',8);
$this->Cell(25,5,''.$_SESSION['PDF_telefono2'].'',1,1,'L',1);
$this->SetFont('Arial','B',10);
$this->SetX(172);
$this->Cell(15,5,'Celul:',0,0); 
$this->SetFont('Arial','B',8);
$this->Cell(25,5,''.$_SESSION['PDF_celular1'].'',1,1,'L',1);
$this->SetFont('Arial','B',10);

$this->Cell(20,5,'Ciudad',0,0);
$this->SetFont('Arial','B',8); 
$this->Cell(137,5,''.$_SESSION['PDF_ciudad'].'',1,0,'L',1); 
$this->SetFont('Arial','B',10);

$this->Cell(15,5,'Fax',0,0); 
$this->SetFont('Arial','B',8);
$this->Cell(25,5,''.$_SESSION['PDF_fax'].'',1,1,'L',1);
$this->SetFont('Arial','B',10);
$this->Cell(20,5,'Email',0,0);
$this->SetFont('Arial','B',8); 
$this->Cell(137,5,''.$_SESSION['PDF_email1'].'',1,1,'L',1); 

   
}
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-11);
    //Arial italic 8
    $this->SetFont('Arial','',5);
    //Número de página
    $this->SetFillColor(0,0,0);
	$this->Cell(197,0.3,'',1,1,'L',1);
    
    $this->SetX(100);
    $this->Cell(50,2,'Av. Ballivián Nº 0503',0,1);
    $this->SetX(100);
    $this->Cell(50,2,'Edificio Colon 7mo Piso',0,1);
    $this->SetX(100);
    $this->Cell(50,2,'Telefono: 4520317 -4520321',0,1);
    $this->SetX(100);
    $this->Cell(50,2,'Fax: 4520318',0,1);
    $this->Cell(50,2,'Pagina '.$this->PageNo().' de {nb}',0,1,'L');
   
}

//Cabecera de página

}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf-> AddFont('Arial','','arial.php');
$pdf->SetFont('Arial','',5);

$pdf->SetLeftMargin(15);
$pdf->SetAutoPageBreak(true,11);
/*$pdf->SetX(170);
$pdf->SetFont('Arial','B',10);
if($_SESSION['PDF_titulo']=='SERVICIO'){
$pdf->Cell(30,4,'CS'.'-'.$_SESSION['PDF_num_cotizacion'].'-'.$_SESSION['PDF_gestion'],0,1);
}else{
$pdf->Cell(30,4,'CB'.'-'.$_SESSION['PDF_num_cotizacion'].'-'.$_SESSION['PDF_gestion'],0,1);	
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

$fecha_completa=$_SESSION['PDF_fecha_reg'];
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
if($_SESSION['PDF_titulo']=='SERVICIO'){
$pdf->Cell(105,20,'Orden de Servicio',0,0,'C'); 
}else{
$pdf->Cell(105,20,'Orden de Compra',0,0,'C'); 
}
   
$pdf->Image('../../../lib/images/logo_reporte.jpg',15,2,35,15);
//$pdf->Cell(50,20,'',1,0); 

$pdf->SetFont('Arial','',10);


$pdf->SetY(20);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,3.5,'',0,1);
/*$pdf->SetFont('Arial','BI',14);
//$pdf->Cell(180,5,'Solicitud de Materiales y Equipo ',0,1,'C'); 

$pdf->SetFillColor(200,200,200);
$pdf->SetDrawColor(255,255,255);
$pdf->SetLineWidth(0.5);
$pdf->Cell(200,1.8,' ',0,1); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20,5,'Señores:',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(125,5,''.$_SESSION['PDF_nombres'].'',1,'L',1);
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(160,25);
$pdf->Cell(15,5,'Telf.:',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(25,5,''.$_SESSION['PDF_telefono1'].'',1,1,'L',1);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(20,5,'Dirección ',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(125,5,''.$_SESSION['PDF_direccion'].'',1,'L',1); 
$pdf->SetX(160);
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(160,30);
$pdf->Cell(15,5,'Telf 2.:',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(25,5,''.$_SESSION['PDF_telefono2'].'',1,1,'L',1);
$pdf->SetFont('Arial','B',10);
$pdf->SetX(160);
$pdf->Cell(15,5,'Celul:',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(25,5,''.$_SESSION['PDF_celular1'].'',1,1,'L',1);
$pdf->SetFont('Arial','B',10);

$pdf->Cell(20,5,'Ciudad',0,0);
$pdf->SetFont('Arial','',10); 
$pdf->Cell(125,5,''.$_SESSION['PDF_ciudad'].'',1,0,'L',1); 
$pdf->SetFont('Arial','B',10);

$pdf->Cell(15,5,'Fax',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(25,5,''.$_SESSION['PDF_fax'].'',1,1,'L',1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20,5,'Email',0,0);
$pdf->SetFont('Arial','',10); 
$pdf->Cell(125,5,''.$_SESSION['PDF_email1'].'',1,1,'L',1); 
*/
$pdf->SetFont('Arial','',10); 
if($_SESSION['PDF_titulo']=='SERVICIO'){
$pdf->Cell(185,1,'',0,1);
}else{
$pdf->MultiCell(185,5,'Agradeceremos entregarnos de acuerdo a su cotización, lo siguiente:',0,1); 
}

//$pdf->SetFillColor(200,200,200);
$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(6,5,'Nro',1,0); 
$pdf->Cell(9,5,'Cant.',1,0); 
$pdf->Cell(10,5,'Unidad',1,0); 
$pdf->Cell(132,5,''.$_SESSION['PDF_titulo'].'',1,0); 
$pdf->Cell(20,5,'Precio U.',1,0); 
$pdf->Cell(20,5,'Total '.$_SESSION["PDF_simbolo"],1,1);
$pdf->SetFont('Arial','',6); 
$pdf->SetWidths(array(6,9,10,132,20,20));
$pdf->SetAligns(array('R','R','L','L','R','R'));
$pdf->SetVisibles(array(1,1,1,1,1,1));
$pdf->SetFontsSizes(array(7,7,7,7,7,7));
$pdf->SetSpaces(array(3.5,3.5,3.5,3.5,3.5));
$pdf->setDecimales(array(0,0,0,0,2,2));

$data=$_SESSION['PDF_cotizacion_det'];
//$pdf->SetFont('Arial','',10); 

for($i=0;$i<count($data);$i++)
{
	$numero=$j+1;
	$pdf->MultiTabla(array_merge((array)$numero,(array)$data[$i]),1,1,3.5,7);
   // $pdf->Row(array_merge((array)$numero,(array)$data[$i]));
}
//$pdf->Line(14);
$pdf->Cell(177,5,'SON: '.$_SESSION['PDF_precio_total_literal'].'',1,0);
//$pdf->SetFillColor(0,0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,''.number_format($_SESSION['PDF_precio_total'],2).'',1,1,'R');
$pdf->SetFillColor(0,0,0);
$pdf->Cell(197,0.3,'',1,1,'L',1);
$pdf->Ln(0.5);
$pdf->SetFillColor(200,200,200);
$pdf->SetLineWidth(0.5);
$pdf->Cell(35,5,'Forma de Pago:',0,0);
$pdf->SetDrawColor(255,255,255);
$pdf->SetFont('Arial','',8); 
$pdf->MultiCell(67,5,''.$_SESSION['PDF_forma_pago'].'',1,'L',1);

$x=$pdf->GetX();
$y=$pdf->GetY();

$pdf->SetXY($x+102,$y-5);
$pdf->SetDrawColor(0,0,0);
$pdf->Cell(92,5,'p/ Empresa Nacional de  Electricidad ',0,1,'C');
//$pdf->Cell(57,5,'',0,1);
//$pdf->SetDrawColor(255,255,255);
$pdf->SetFont('Arial','B',8); 
$pdf->Cell(35,5,'Plazo de Entrega',0,0);
$pdf->SetDrawColor(255,255,255);
$pdf->SetFont('Arial','',8); 
$pdf->Cell(67,5,''.$_SESSION['PDF_plazo_entrega'].'',1,0,'L',1);
$pdf->SetDrawColor(0,0,0);
$pdf->SetFont('Arial','B',8); 
$pdf->Cell(35,5,'',0,0);
$pdf->Cell(67,5,'',0,1);

$pdf->Cell(35,5,'Lugar de Entrega',0,0);
$pdf->SetDrawColor(255,255,255);
$pdf->SetFont('Arial','',8); 
$pdf->MultiCell(67,5,''.$_SESSION['PDF_lugar_entrega'].'',1,'L',1);
$pdf->SetDrawColor(0,0,0);
$pdf->SetFont('Arial','B',8);
$x=$pdf->GetX();
$y=$pdf->GetY();
$pdf->SetXY($x+92,$y-5); 
$pdf->Cell(35,5,'',0,0);
$pdf->Cell(67,5,'',0,1);
$pdf->Cell(35,5,'Imputación:',0,0);
$pdf->SetDrawColor(255,255,255);
$pdf->SetFont('Arial','',8); 

$pdf->Cell(67,5,'',1,0,'L',1);
$pdf->SetDrawColor(0,0,0);
$pdf->SetFont('Arial','B',10); 
$pdf->Cell(46,5,'____________________',0,0,'C');
$pdf->Cell(46,5,'____________________',0,1,'C');

//$pdf->Cell(35,5,'',0,0);
$pdf->SetDrawColor(255,255,255);
$pdf->SetFont('Arial','',8); 
$pdf->Cell(102,5,'',1,0,'L',1);
$pdf->SetDrawColor(0,0,0);
$pdf->Cell(35,5,'Jefe División ',0,0,'C');
$pdf->Cell(57,5,'Jefe Dpto.  ',0,1,'C');

//$pdf->Cell(35,5,'',0,0);
$pdf->SetDrawColor(255,255,255);
$pdf->Cell(102,5,'',1,0,'L',1);
$pdf->SetDrawColor(0,0,0);
if($_SESSION['PDF_titulo']=='SERVICIO'){
   $pdf->Cell(35,5,'Servicios',0,0,'C');
   $pdf->Cell(57,5,'De Bienes y Servicios',0,1,'C');
}else{
   $pdf->Cell(35,5,'Bienes',0,0,'C');
   $pdf->Cell(57,5,'De Bienes y Servicios',0,1,'C');
}
$pdf->SetDrawColor(255,255,255);
$pdf->SetFont('Arial','B',8); 
$pdf->Cell(35,5,'Aprobación',0,0);
$pdf->SetFont('Arial','',8); 
$pdf->Cell(67,5,''.$_SESSION['PDF_nombre_categoria'].'',1,0,'L',1);
$pdf->SetDrawColor(0,0,0);
$pdf->Cell(35,5,'',0,0);
$pdf->Cell(67,5,'',0,1);

$pdf->SetLineWidth(0.1);
$pdf->SetFillColor(0,0,0);
$pdf->Cell(197,0.3,'',1,1,'L',1);
$pdf->Ln(2);
$pdf->SetFillColor(200,200,200);
$pdf->SetFont('Arial','B',8); 
$pdf->Cell(35,5,'Observaciones',0,0);
$pdf->SetFont('Arial','',5); 
//$pdf->SetDrawColor(255,255,255);
$pdf->MultiCell(150,5,''.$_SESSION['PDF_observaciones'].'',0);

$solicitud=$_SESSION['PDF_solicitudes'];
$num_solicitud='';
for($v=0;$v<count($solicitud);$v++){
	//$fecha_hoy=$cu[$v][1];
	if($v==0){
	$num_solicitud=$num_solicitud.$solicitud[$v][0];
	}else{
	$num_solicitud=$num_solicitud.','.$solicitud[$v][0];	
	}
}
if($_SESSION['PDF_titulo']=='SERVICIO'){
$pdf->Cell(35,5,'Nro de Servicio(s): '.$num_solicitud,0,1);
}else{
$pdf->Cell(35,5,'Nro de Pedido(s): '.$num_solicitud,0,1);
}
$pdf->SetFillColor(0,0,0);
$pdf->Cell(197,0.3,'',1,1,'L',1);
$pdf->Ln(5);
//$pdf->SetFillColor(200,200,200);
$pdf->SetFont('Arial','B',8);     
$pdf->Cell(15,5,'NOTA:',0,0);
$pdf->SetFont('Arial','',7); 
if($_SESSION['PDF_titulo']=='SERVICIO'){
$pdf->MultiCell(170,3,''.$_SESSION['PDF_nombres'].' se compromete a realizar los servicios de acuerdo a la  presente orden de servicio; a cuyo fin y en señal de conformidad suscribe al pie del presente',0);    
}else{
$pdf->MultiCell(170,3,''.$_SESSION['PDF_nombres'].' se compromete a entregar los bienes de acuerdo a la presente orden de compra; a cuyo fin y en señal de conformidad suscribe al pie del presente',0);    
}
    
$pdf->Cell(102,20,'',0,0,'C');
$pdf->Cell(93,20,'',0,1,'C');

$pdf->Cell(197,3,'Firma Proveedor o Sello',0,1,'R'); 

if($_SESSION['PDF_titulo']=='SERVICIO'){
	//$pdf->MultiCell(185,5,'',0);
	$nombre='Servicio';
}else{
	$nombre='Compra';
}
//$fechita=date_add($date, '18/09/2008');
$pdf->MultiCell(197,3,'La presente Orden de '.$nombre.' tiene calidad de contrato de suministro de acuerdo a los artículos 919 al 925 del Código de Comercio.',0);
$pdf->Ln(4);

$pdf->MultiCell(197,3,'El proveedor se compromete a entregar el suministro en el plazo de '.$_SESSION['PDF_plazo_entrega'].'  hábiles que seran computables a partir de la fecha de elaboracion de la presente orden de compra. El incumplimiento se sancionará con una multa del 0.5% del monto contratado por cada dia hábil de retraso, multa que no debe exceder el 20%',0);
    




$pdf->Output();
?>