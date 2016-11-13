<?php
/*
 * Autor: Ana María Villegas Quispe
 * Fecha ultima de modificación:  30/07/2009
 * Cambio de nombres de sessiones y es específico para Cotizaciones en Blanco.
 * Se cambió la función de multitabla a  TablaDatosExtensos
 */
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
	$this->SetX(182);
if($_SESSION['PDF_titulo']=='SERVICIO'){
$this->Cell(30,4,'CS'.'-'.$_SESSION['PDF_eb_num_cotizacion_0'].'-'.$_SESSION['PDF_eb_gestion_0'],0,1);
}else{
$this->Cell(30,4,'CB'.'-'.$_SESSION['PDF_eb_num_cotizacion_0'].'-'.$_SESSION['PDF_eb_gestion_0'],0,1);	
}
$this->SetFont('Arial','',10);
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

$fecha_completa=$_SESSION['PDF_eb_fecha_reg_0'];
$dia=substr($fecha_completa,8,2);
$mes=substr($fecha_completa,5,2);
$anio=substr($fecha_completa,0,4);
$this->SetFont('Arial','',8);
$this->SetX(182);
$this->Cell(10,4,$dia,1,0);
$this->Cell(10,4,$mes,1,0);
$this->Cell(10,4,$anio,1,1);
$this->SetFont('Arial','BI',18);
$this->SetXY(45,4);

$this->Cell(105,20,'Solicitud de Cotización',0,0,'C'); 
$this->Image('../../../lib/images/logo_reporte.jpg',15,2,35,15);
  
$this->Ln(2);
$this->SetFillColor(220,220,220);
$this->SetDrawColor(255,255,255);
$this->SetLineWidth(1);
$cabecera=array();
$cabecera[0][0]='Señores';
$cabecera[0][1]='';
$cabecera[0][2]='Telf.:';
$cabecera[0][3]='';

$cabecera[1][0]='Dirección:';
$cabecera[1][1]='';
$cabecera[1][2]='Telf. 2:';
$cabecera[1][3]='';

$cabecera[2][0]='Ciudad:';
$cabecera[2][1]='';
$cabecera[2][2]='Celular:';
$cabecera[2][3]='';

$cabecera[3][0]='Email:';
$cabecera[3][1]='';
$cabecera[3][2]='Fax:';
$cabecera[3][3]= '';

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

$this->SetY(25);
for($i1=0;$i1<count($cabecera);$i1++)
{
	$this->MultiTabla($cabecera[$i1],1,3,5,7,1);
   
}


$this->SetFont('Arial','',7); 
$this->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial')); 
$this->SetFills(array(0,0,0,0,0,0));
$this->SetVisibles(array(1,1,1,1,1,1));
$this->SetFontsSizes(array(7,7,7,7,7,7));
$this->SetSpaces(array(3.5,3.5,3.5,3.5,3.5,3.5));
$this->SetWidths(array(7,16,13,109,26,26));
$this->SetAligns(array('R','R','L','L','R','R'));
$this->SetFontsStyles(array('','','',''));
$this->SetFillColor(255,255,255);
$this->SetDrawColor(0,0,0);
$this->SetLineWidth(0.01);
if ($this->PageNo()!=1){
		$this->Cell(197,0.01,'',1,1);	
			
		}
$this->SetLineWidth(1);		

}
//Pie de página
function Footer()
{  
	$fecha=date("d-m-Y");
	$hora=date("h:i:s");
	    $this->SetY(-10);
	     
   	    $this->SetFont('Arial','',6);
   	   // $this->Cell(200,0.2,'',1,1);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - COMPRO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
		$this->ln(3);
		$this->Cell(70,3,sha1(gregoriantojd(date('m'),date('d'),date('Y')).$hora),0,1,'L');
   }
}


$pdf=new PDF();

$pdf->AliasNbPages();
$pdf-> AddFont('Arial','','arial.php'); 	
$pdf->SetLeftMargin(15);
$pdf->SetAutoPageBreak(true,10);
$pdf->SetFont('Arial','B',10);

$pdf->AddPage();
$poscab=0;
$poscab=$pdf->GetY();

$pdf->MultiCell(185,5,'Agradeceremos a Ud.(s) cotizar el siguiente material con IMPUESTOS INCLUIDOS, indicando plazo de entrega y validez de su oferta hasta el ',0,1);
$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(0); 
$pdf->SetFont('Arial','B',8);
$pdf->Cell(7,5,'Nº',1,0); 
$pdf->Cell(16,5,'CANTIDAD',1,0); 
$pdf->Cell(13,5,'UNIDAD',1,0); 
$pdf->Cell(109,5,''.$_SESSION['PDF_titulo'].'',1,0); 
$pdf->Cell(26,5,'PRECIO UNITARIO',1,0); 
$pdf->Cell(26,5,'TOTAL (Bs.)',1,1);

$pdf->SetFont('Arial','',7); 
$pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial')); 
$pdf->SetVisibles(array(1,1,1,1,1,1));
$pdf->SetFontsSizes(array(7,7,7,7,7,7));
$pdf->SetSpaces(array(3.5,3.5,3.5,3.5,3.5,3.5));
//$pdf->SetSpaces(array(,2,2,2,2,2));
$pdf->SetWidths(array(7,16,13,109,26,26));
//$pdf->SetWidths1(array(7,16,13,109,26,26));
$pdf->SetAligns(array('R','R','L','L','R','R'));



$data=$_SESSION['PDF_cotizacion_det_eb'];
$cdata=count($data);
$numero=array();
 /*for($j=0;$j<$cdata;$j++)
 { 
   $numero=$j+1;
   $pdf->MultiTabla(array_merge((array)$numero,(array)$data[$j]),1,3,3.5,7);
   
 }
 */
 $cotizacion_detalle=array();
 for($j=0;$j<$cdata;$j++)
 { 
   $cotizacion_detalle[$j][0]=$j+1;
   $cotizacion_detalle[$j][1]=$data[$j][0];
   $cotizacion_detalle[$j][2]=$data[$j][1];
   $cotizacion_detalle[$j][3]=$data[$j][2];
   $cotizacion_detalle[$j][4]=$data[$j][3];
   $cotizacion_detalle[$j][5]=$data[$j][4];
   $cotizacion_detalle[$j][6]=$data[$j][5];
 }
  $pdf->tablaDatosExtensos($cotizacion_detalle,3.5,15,$poscab);
  // $pdf->MultiTabla(array_merge((array)$numero,(array)$data[$j]),1,3,3.5,7);
 
 

$pdf->Cell(130,5,'','T',0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(55,5,'IMPORTE TOTAL:','T',1);
$pdf->SetFillColor(0,0,0);
$pdf->Cell(197,0.3,'',1,1,'L',1);
$pdf->Ln(5);
$pdf->SetFillColor(220,220,220);
$pdf->SetDrawColor(255,255,255);
$pdf->SetLineWidth(0.5);

$pdf->Cell(35,5,'Plazo de Entrega:',0,0);
$pdf->Cell(63,5,'',1,0,'L',1);
$pdf->Cell(35,5,'Moneda:',0,0);
$pdf->Cell(63,5,'',1,1,'L',1);
$pdf->Cell(35,5,'Validez de la Oferta:',0,0);
$pdf->Cell(63,5,'',1,0,'L',1);
$pdf->Cell(35,5,'Lugar de Entrega:',0,0);
$pdf->MultiCell(63,5,'',1,'L',1);
$pdf->Cell(35,5,'Forma de pago:',0,0);
$pdf->Cell(63,5,'',1,0,'L',1);
$pdf->Cell(35,5,'Garantía:',0,0);
$pdf->Cell(63,5,'',1,1,'L',1);
$pdf->SetFillColor(0,0,0);
$pdf->Ln(5);
$pdf->Cell(197,0.3,'',1,1,'L',1);
$pdf->SetFont('Arial','',10);
$pdf->Cell(197,5,'p/Empresa Nacional de Electricidad',0,1,'C');
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
 

$pdf->Output();
?>