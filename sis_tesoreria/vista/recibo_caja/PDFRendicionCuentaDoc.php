<?php
session_start();

require('../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
/* Autor Ana Maria Villegas Quispe
 * Fecha ultima de actualizacion: 18/08/2009
 * Descripción: Reporte de Rendición de cuentas para fondos de avance y viaticos
*/
class PDF extends FPDF
{   
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
     $this-> AddFont('Arial','','arial.php');
    //Iniciación de variables
    }
   
 //Cabecera
function Header()
{
	
$this->SetDrawColor(0,0,0);
$this->SetLineWidth(0.2);
	
$this->SetMargins(1,5,5);
$this->SetFont('Arial','B',14);
$this->Image('../../../lib/images/logo_reporte.jpg',10,2,35,14);
$this->SetXY(45,1);
$y_cab=$this->GetY();
$this->Cell(135,7,'RENDICION DE CUENTAS',0,1,'C');
$this->SetFont('Arial','B',10);
$this->SetXY(45,8);
$this->MultiCell(135,4,$_SESSION['PDF_subtitulo'],0,'C');
$x=$this->GetX();

$this->Line(1,16,215,16);
$this->Line(45,1,45,16);
$this->Line(180,1,180,16);
$this->SetFont('Arial','B',9);
$this->SetXY($x+180,$y_cab);
$this->Cell(50,5,'No.'.$_SESSION['PDF_nro_avance'],0,1);
$this->SetXY($x+180,$y_cab+5);

$fecha_completa=$_SESSION['PDF_fecha_cbte'];
$dia=substr($fecha_completa,8,2);
$mes=substr($fecha_completa,5,2);
$anio=substr($fecha_completa,0,4);
$fecha_cbte=$dia.'/'.$mes.'/'.$anio;
	
$this->Cell(50,5,'Fecha:'.$_SESSION['PDF_fecha_avance'],0,1);
$this->SetX($x+180);
$this->Cell(50,5,'Página:'.$this->PageNo(),0,1);

$this->Ln(3);

$this->Cell(75,4,'NOMBRE Y APELLIDO',1,0,'C');
$this->Cell(75,4,'CENTRO DE RESPONSABILIDAD',1,0,'C');
$this->Cell(64,4,'LOCALIDAD',1,1,'C');

$cabecera[0][0]= $_SESSION['PDF_nombre_completo'];
$cabecera[0][1]= $_SESSION['PDF_nombre_cargo'];
$cabecera[0][2]= $_SESSION['PDF_nombre_lugar'];

$this->SetWidths(array(75,75,64));
$this->SetVisibles(array(1,1,1,1));
$this->SetFonts(array('Arial','Arial','Arial'));
$this->SetFontsSizes(array(7,7,7));
$this->SetAligns(array('C','C','C'));
$this->SetFontsStyles(array('','',''));
$this->SetSpaces(array(3.5,3.5,3.5,3.5));
$this->MultiTabla($cabecera[0],1,3,3.5,7);
$y=$this->GetY();
$this->SetFont('Arial','B',8);
$this->MultiCell(150,3.5,'CONCEPTO:'.$_SESSION['PDF_concepto_avance'],'R','L');
$yfin_cab=$this->GetY();
$this->SetXY(151,$y);
$this->Cell(64,4,'PERIODO RENDICIÓN',1,1,'C');
$this->SetFont('Arial','',8);
$this->SetXY(151,$y+4);
$this->Cell(64,4,$_SESSION['PDF_fecha_ini_rendicion']. '--->' .$_SESSION['PDF_fecha_fin_rendicion'],1,1,'C');



$this->SetFont('Arial','B',8);

$this->SetFont('Arial','B',8);
if(($y+8)<=$yfin_cab){
	
$this->SetY($yfin_cab);	
}


$this->Cell(14,5,'FECHA',1,0,'C');
$this->Cell(98,5,'DESCRIPCIÓN',1,0,'C');
$this->Cell(8,5,'Nº',1,0,'C');
$this->Cell(40,5,'IMPUTACIÓN',1,0,'C');
$this->Cell(27,5,'CARGO',1,0,'C');
$this->Cell(27,5,'DESCARGO',1,1,'C');


//cabecera del detalle
$y=$this->GetY();
$this->Line(1,1,1,250);
$this->Line(1,1,215,1);
$this->Line(215,1,215,250);
$this->Line(15,$y,15,($y-7)+202.3);
$this->Line(113,$y,113,($y-7)+202.3);
$this->Line(121,$y,121,($y-7)+202.3);
$this->Line(161,$y,161,($y-7)+202.3);
$this->Line(188,$y,188,($y-7)+202.3);
$this->Line(215,$y,215,($y-7)+202.3);
//$this->Line(235,$y,235,($y-7)+202.3);   
   $this->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial')); 
$this->SetVisibles(array(1,1,1,1,1,1,1));
$this->SetFontsSizes(array(7,7,7,7,7,7,7));
$this->SetFontsStyles(array('','','','','','',''));
$this->SetSpaces(array(3.5,3.5,3.5,3.5,3.5,3.5,3.5));
$this->SetWidths(array(14,98,8,40,27,27));
$this->SetDecimales(array(0,0,0,0,2,2));
$this->SetAligns(array('L','L','R','L','R','R','R'));
}
//Pie de página
function Footer()
{
$this->SetY(-20);
$this->SetDrawColor(0,0,0);
$this->SetLineWidth(0.2);
$this->SetFont('Arial','BI',6);
$this->Cell(54,4,'Firma Interesado',1,0,'C');
$this->Cell(54,4,'Firma Autorizada',1,0,'C');
$this->Cell(53,4,'Contabilidad',1,0,'C');
$this->Cell(53,4,'Caja',1,1,'C');
$this->Cell(54,11,'',1,0,'C');
$this->Cell(54,11,'',1,0,'C');
$this->Cell(53,11,'',1,0,'C');
$this->Cell(53,11,'',1,1,'C');
$this->Cell(54,4,'Fecha',1,0);
$this->Cell(54,4,'Fecha',1,0);
$this->Cell(53,4,'Fecha',1,0);
$this->Cell(53,4,'Fecha',1,1);


//Estas lineas empezarán 
$this->Line(1,150,1,259.3);
$this->Line(15,150,15,259.3);
$this->Line(113,150,113,259.3);
$this->Line(121,150,121,259.3);
$this->Line(161,150,161,259.3);
$this->Line(188,150,188,259.3);
$this->Line(215,150,215,259.3);  

}


}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,20);
$pdf->SetMargins(1.2,5,5);
$pdf->SetFont('Arial','B',16);	


 $pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial')); 
$pdf->SetVisibles(array(1,1,1,1,1,1,1));
$pdf->SetFontsSizes(array(7,7,7,7,7,7,7));
$pdf->SetFontsStyles(array('','','','','','',''));
$pdf->SetSpaces(array(3.5,3.5,3.5,3.5,3.5,3.5,3.5));
$pdf->SetWidths(array(14,98,8,40,27,27));
$pdf->SetDecimales(array(0,0,0,0,2,2));
$pdf->SetAligns(array('L','L','R','L','R','R','R'));
$array_detalle_rendicion_cuentas=$_SESSION['PDF_DetRendicionCuenta'];
$array_rc_impresion= Array();
$numeracion=0;
$suma_cargo=0;
$suma_descargo=0;
for ($j=0;$j<count($array_detalle_rendicion_cuentas);$j++){
	$array_rc_impresion[$j][0]=$array_detalle_rendicion_cuentas[$j][1];
	$array_rc_impresion[$j][1]=$array_detalle_rendicion_cuentas[$j][2];
	//$array_rc_impresion[$j][2]=$array_detalle_rendicion_cuentas[$j][3];
	if($array_detalle_rendicion_cuentas[$j][3]==0){
	$numeracion=$numeracion+1;
	$array_rc_impresion[$j][2]=$numeracion;
	}
	$array_rc_impresion[$j][3]=$array_detalle_rendicion_cuentas[$j][4];
	
	$array_rc_impresion[$j][4]=$array_detalle_rendicion_cuentas[$j][5];
	
	if ($array_detalle_rendicion_cuentas[$j][6]!='0.00'){
	$array_rc_impresion[$j][5]=$array_detalle_rendicion_cuentas[$j][6];
	}else{
	$array_rc_impresion[$j][5]='';
	}
	if ($array_detalle_rendicion_cuentas[$j][7]!='0.00'){
	$array_rc_impresion[$j][6]=$array_detalle_rendicion_cuentas[$j][7];
	}else{
	$array_rc_impresion[$j][6]='';
	}
	
	
	//$array_rc_impresion[$j][6]=$array_detalle_rendicion_cuentas[$j][7];
	
	$suma_cargo=$suma_cargo+$array_rc_impresion[$j][4];
	$suma_descargo=$suma_descargo+$array_rc_impresion[$j][5];
}
$pdf->Ln(0.1);
for ($i=0;$i<count($array_rc_impresion);$i++){
	 $pdf->SetLineWidth(0.05);
     $pdf->SetDrawColor(100,100,100);
     $pdf->SetX(1.2);
	$pdf->MultiTabla($array_rc_impresion[$i],1,3,3.5,7);
}
$pdf->SetFont('Arial','B',7);	
$pdf->Cell(154,2,'',0,0,'R');
$pdf->Cell(60,2,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - ',0,1,'R');
$pdf->Cell(112,3.5,'Sumas Parciales',0,0,'R');

$pdf->Cell(72,3.5,number_format($suma_cargo,2),0,0,'R');
$pdf->Cell(30,3.5,number_format($suma_descargo,2),0,1,'R');


if($suma_cargo>=$suma_descargo){
	$resto=$suma_cargo-$suma_descargo;
	$pdf->Cell(112,3.5,'Saldo a favor de la Empresa',0,0,'R');
	
	$pdf->Cell(72,3.5,'',0,0,'R');
$pdf->Cell(30,3.5,number_format($resto,2),0,1,'R');
$total=$suma_cargo;
}else{
	$pdf->Cell(112,3.5,'Saldo a favor del Empleado',0,0,'R');
	$resto=$suma_descargo-$suma_cargo;
	$pdf->Cell(72,3.5,number_format($resto,2),0,0,'R');
$pdf->Cell(30,3.5,'',0,1,'R');
$total=$suma_descargo;
}
$pdf->Cell(154,2,'',0,0,'R');
$pdf->Cell(60,2,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - ',0,1,'R');
$pdf->Cell(112,3.5,'Sumas Iguales',0,0,'R');
$pdf->Cell(72,3.5,number_format($total,2),0,0,'R');
$pdf->Cell(30,3.5,number_format($total,2),0,1,'R');
$pdf->Cell(154,2,'',0,0,'R');
$pdf->Cell(60,2,'=====================================',0,1,'R');

//PARA DEBITOS
$pdf->SetFont('Arial','BI',8);

$pdf->Output();
?>

