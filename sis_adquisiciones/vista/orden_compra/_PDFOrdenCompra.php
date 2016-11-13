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
     $this-> AddFont('Arial','','arial.php');
    //Iniciación de variables
    }
 
function Header()
{
	$this->SetMargins(15,47,5);
   $this->SetXY(182,2.3);
$this->SetFont('Arial','B',10);
//$this->Cell(30,4,$_SESSION['PDF_codigo_depto'],0,1);
 $this->SetX(173);
if($_SESSION['PDF_titulo']=='SERVICIO'){
$this->Cell(30,3.5,$_SESSION['PDF_codigo_depto'].'-OS'.'-'.$_SESSION['PDF_num_cotizacion'].'-'.$_SESSION['PDF_gestion'],0,1);
}else{
$this->Cell(30,3.5,$_SESSION['PDF_codigo_depto'].'-OC'.'-'.$_SESSION['PDF_num_cotizacion'].'-'.$_SESSION['PDF_gestion'],0,1);	
}

$this->SetFont('Arial','B',8);
$this->SetX(182);
$this->Cell(30,4,'Localidad',0,1); 
$this->SetFont('Arial','',8);
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
$this->SetFont('Arial','',7);
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


$this->SetY(17);
$this->SetFont('Arial','B',8);
$this->Cell(15,3.5,$_SESSION['PDF_nro_generacion_oc'],0,1,'R');

$this->Ln(2);
$this->SetFillColor(200,200,200);
$this->SetDrawColor(255,255,255);
$this->SetLineWidth(1);
$cabecera=array();
$cabecera[0][0]='Señores';
$cabecera[0][1]=$_SESSION['PDF_nombres'];
$cabecera[0][2]='Telf.:';
$cabecera[0][3]=$_SESSION['PDF_telefono1'];

$cabecera[1][0]='Dirección:';
$cabecera[1][1]=$_SESSION['PDF_direccion'];
$cabecera[1][2]='Telf. 2:';
$cabecera[1][3]=$_SESSION['PDF_telefono2'];

$cabecera[2][0]='Ciudad:';
$cabecera[2][1]=$_SESSION['PDF_ciudad'];
$cabecera[2][2]='Celular:';
$cabecera[2][3]=$_SESSION['PDF_telefono2'];

$cabecera[3][0]='Email:';
$cabecera[3][1]=$_SESSION['PDF_email1'];
$cabecera[3][2]='Fax:';
$cabecera[3][3]=$_SESSION['PDF_fax'];

$this->SetWidths(array(20,137,15,25));
$this->SetFills(array(0,1,0,1));
$this->SetAligns(array('L','L','L','L'));
$this->SetVisibles(array(1,1,1,1));
$this->SetFonts(array('Arial','Arial','Arial','Arial'));
$this->SetFontsSizes(array(10,9,10,9));
$this->SetFontsStyles(array('B','','B',''));
$this->SetSpaces(array(5,5,5,5,5));
$this->setDecimales(array(0,0,0,0));
$this->SetFormatNumber(array(0,0,0,0));


for($i1=0;$i1<count($cabecera);$i1++)
{
	$this->MultiTabla($cabecera[$i1],1,3,5,7,1);
   
}
$this->SetFont('Arial','',6); 
$this->SetWidths(array(6,9,10,132,20,20));
$this->SetFills(array(0,0,0,0));
$this->SetAligns(array('R','R','L','L','R','R'));
$this->SetVisibles(array(1,1,1,1,1,1));
$this->SetFonts(array('Arial','Arial','Arial','Arial'));
$this->SetFontsStyles(array('','','',''));
$this->SetFontsSizes(array(7,7,7,7,7,7));
$this->SetSpaces(array(3.5,3.5,3.5,3.5,3.5));
$this->setDecimales(array(0,0,0,0,2,2));
$this->SetLineWidth(0);


   
}
//Pie de página
function Footer()
{
   	 $fecha=date("d-m-Y");
	$hora=date("h:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
   	   // $this->Cell(200,0.2,'',1,1);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		//$this->Cell(70,3,'Usuario: BADANI MENDEZ VIVIAN ELIZABETH',0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		//$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		//$this->Cell(18,3,'Fecha: 2-09-2009',0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS -COMPRO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		//$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
		//$this->Cell(18,3,'Hora: 20:57:08',0,0,'L');	
		
}

//Cabecera de página

}

$pdf=new PDF();
$pdf->AddPage();
$poscab=0;
$poscab=$pdf->GetY();
$pdf->AliasNbPages();
//$pdf-> AddFont('Arial','','arial.php');
$pdf->SetFont('Arial','',5);

$pdf->SetLeftMargin(15);
$pdf->SetAutoPageBreak(true,10);

$pdf->SetFont('Arial','',10); 
if($_SESSION['PDF_titulo']=='SERVICIO'){
$pdf->Cell(185,1,'',0,1);
}else{
$pdf->MultiCell(185,5,'Agradeceremos entregarnos de acuerdo a su cotización, lo siguiente:',0,1); 
}

//$pdf->SetFillColor(200,200,200);
$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(0);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(6,5,'Nro',1,0); 
$pdf->Cell(9,5,'Cant.',1,0); 
$pdf->Cell(10,5,'Unidad',1,0); 
$pdf->Cell(132,5,''.$_SESSION['PDF_titulo'].'',1,0); 
$pdf->Cell(20,5,'Precio U.',1,0); 
$pdf->Cell(20,5,'Total '.$_SESSION["PDF_simbolo"],1,1);
$pdf->SetFont('Arial','',6); 
$pdf->SetWidths(array(6,9,10,132,20,20));
$pdf->SetFills(array(0,0,0,0));
$pdf->SetAligns(array('R','R','L','L','R','R'));
$pdf->SetVisibles(array(1,1,1,1,1,1));
$pdf->SetFonts(array('Arial','Arial','Arial','Arial'));
$pdf->SetFontsStyles(array('','','',''));
$pdf->SetFontsSizes(array(7,7,7,7,7,7));
$pdf->SetSpaces(array(3.5,3.5,3.5,3.5,3.5));
$pdf->setDecimales(array(0,0,0,0,2,2));

$data=$_SESSION['PDF_cotizacion_det'];
//$pdf->SetFont('Arial','',10); 

/*for($i=0;$i<count($data);$i++)
{
	$numero=$i+1;
	$pdf->MultiTabla(array_merge((array)$numero,(array)$data[$i]),1,1,3.5,7);
   
}
*/
 $arreglo=array();
for($i=0;$i<count($data);$i++)
{   
	$numero=$i+1;
	$arreglo[$i][0]=$numero;
	$arreglo[$i][1]=$data[$i][0];
	$arreglo[$i][2]=$data[$i][1];
	$arreglo[$i][3]=$data[$i][2];
	$arreglo[$i][4]=$data[$i][3];
	$arreglo[$i][5]=$data[$i][4];
}
//print_r($arreglo);
//exit;
$pdf->tablaDatosExtensos($arreglo,3.5,15,$poscab);
//$pdf->morepagestable($arreglo,3.5,15);*/
//$pdf->Ln();
 
$pdf->Cell(177,5,'SON: '.$_SESSION['PDF_precio_total_literal'].'',1,0);
//$pdf->SetFillColor(0,0,0);
$pdf->SetFont('Arial','B',7);
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
$pdf->Cell(67,5,''.$_SESSION['PDF_tipo_entrega'].'',1,0,'L',1);
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
$pdf->SetFont('Arial','B',8); 
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
$pdf->SetFont('Arial','',7); 
//$pdf->SetDrawColor(255,255,255);
$pdf->MultiCell(155,4,''.$_SESSION['PDF_observaciones'].'',0);
$pdf->SetFont('Arial','',5); 
$solicitud=$_SESSION['PDF_solicitudes'];
$num_solicitud='';
for($v=0;$v<count($solicitud);$v++){
	//$fecha_hoy=$cu[$v][1];
	//print_r($solicitud[$v][0]);
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

$pdf->MultiCell(197,3,'El proveedor se compromete a entregar el suministro en el plazo de '.$_SESSION['PDF_dias'].' dias calendario que seran computables a partir de la fecha de elaboracion de la presente orden de compra. El incumplimiento se sancionará con una multa del 0.5% del monto contratado por cada dia calendario de retraso, multa que no debe exceder el 20%',0);
    




$pdf->Output();
?>