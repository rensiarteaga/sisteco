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
    //Logo
  
  //  $this->Image('../../../lib/images/logo_reporte.jpg',170,2,35,15);
   
}
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-25);
    //Arial italic 8
    $this->SetFont('Tahoma','',7);
    //Número de página
    $this->SetX(100);
    $this->Cell(50,3,'Av. Ballivián Nº 0503',0,1);
    $this->SetX(100);
    $this->Cell(50,3,'Edificio Colon 7mo Piso',0,1);
    $this->SetX(100);
    $this->Cell(50,3,'Telefono: 4520317 -4520321',0,1);
    $this->SetX(100);
    $this->Cell(50,3,'Fax: 4520318',0,1);
    $this->Cell(50,3,'Pagina '.$this->PageNo().' de {nb}',0,1,'L');
    $this->Cell(50,3,'Pedido Nº 515',0,1,'L');
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
$pdf->Cell(30,4,'NroCB-0045-2008',0,1);
//$pdf->SetX();
$pdf->Cell(30,4,'Localidad',0,1); 
//$pdf->SetX(170);
$pdf->Cell(30,4,'COCHABAMBA',0,1); 
//$pdf->SetX(170);
$pdf->Cell(10,4,'Día',1,0);
$pdf->Cell(10,4,'Mes',1,0);
$pdf->Cell(10,4,'Año',1,1);
//$pdf->SetX(170);
$pdf->Cell(10,4,'24',1,0);
$pdf->Cell(10,4,'3',1,0);
$pdf->Cell(10,4,'2008',1,0);
$pdf->SetFont('Arial','BI',14);
$pdf->SetXY(45,4);

$pdf->Cell(105,20,'ORDEN DE COMPRA LOCAL',0,0,'C'); 
//$pdf->SetX(170);
$pdf->Image('../../../lib/images/logo_reporte.jpg',170,2,35,15);
//$pdf->Cell(50,20,'',1,0); 

$pdf->SetFont('Arial','',10);



 


$pdf->SetY(20);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,3.5,'',0,1);
/*$pdf->SetFont('Arial','BI',14);
$pdf->Cell(180,5,'Solicitud de Materiales y Equipo ',0,1,'C'); */
$pdf->Cell(200,1.8,' ',0,1); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20,5,'Señores:',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(125,5,'CABLEBOL',0);
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(160,25);
$pdf->Cell(15,5,'Telf.:',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(25,5,'428678777',0,1);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(20,5,'Dirección ',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(125,5,'AV. AMERICA E-0955 asdfsdf adfksdf asdfjlsdkf alsdfjld asldfjsa dfjalsdkfj asldfjlsd fasdflkjsldf alsdkjflskd fasldfjlsdf alsdjflksadf laskdjflsakdjf ',0); 
$pdf->SetX(160);
$pdf->SetFont('Arial','B',10);
$pdf->SetXY(160,30);
$pdf->Cell(15,5,'Telf 2.:',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(25,5,'428678777',0,1);
$pdf->SetFont('Arial','B',10);
$pdf->SetX(160);
$pdf->Cell(15,5,'Celul:',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(25,5,'428678777',0,1);
$pdf->SetFont('Arial','B',10);

$pdf->Cell(20,5,'Ciudad',0,0);
$pdf->SetFont('Arial','',10); 
$pdf->Cell(125,5,'rosana_vq@hotmail.com',0,0); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(15,5,'Fax',0,0); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(25,5,'428678777',0,1);
$pdf->SetFont('Arial','B',10);

$pdf->Cell(20,5,'Email',0,0);
$pdf->SetFont('Arial','',10); 
$pdf->Cell(125,5,'rosana_vq@hotmail.com',0,1); 

$pdf->MultiCell(185,5,'Agradeceremos entregarnos de acuerdo a su cotización, lo siguiente',0,1); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(19,5,'Item',1,0); 
$pdf->Cell(19,5,'Cantidad',1,0); 
$pdf->Cell(19,5,'Unidad',1,0); 
$pdf->Cell(19,5,'Precio Unitario',1,0);
$pdf->Cell(70,5,'ARTICULO',1,0); 
$pdf->Cell(29,5,'Total (Bs. $us)',1,1);
$pdf->SetFont('Arial','',10); 
$pdf->SetWidths(array(19,19,19,70,29,29));
for($i=0;$i<2;$i++)
    $pdf->Row(array('','','','','',''));
$pdf->Cell(130,5,'SON: QUINIENTOS TREINTA Y NUEVE MIL 00/100 BOLIVIANOS','T',0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(55,5,'IMPORTE TOTAL:','T',1);
$pdf->Cell(35,5,'Plazo de Entrega',0,0);
$pdf->Cell(57,5,'',0,0);
$pdf->Cell(35,5,'Moneda:',0,0);
$pdf->Cell(57,5,'',0,1);
$pdf->Cell(35,5,'Validez de la Oferta',0,0);
$pdf->Cell(57,5,'',0,0);
$pdf->Cell(35,5,'Lugar de Entrega',0,0);
$pdf->Cell(57,5,'',0,1);
$pdf->Cell(35,5,'Forma de pago',0,0);
$pdf->Cell(57,5,'',0,0);
$pdf->Cell(35,5,'Garantía:',0,0);
$pdf->Cell(57,5,'',0,1);
$pdf->Cell(185,5,'p/Empresa Nacional de Electricidad S.A.',0,1,'C');

    
    
    
$pdf->Cell(92,5,'',0,0,'C');
$pdf->Cell(93,5,'',0,1,'C');
/*$pdf->Cell(45,5,'','TLR',0,'C');
$pdf->Cell(45,5,'','TLR',1,'C');
*/
$pdf->Cell(92,5,'___________________',0,0,'C'); 
$pdf->Cell(93,5,'___________________',0,1,'C'); 
/*$pdf->Cell(45,5,'___________________','LR',0,'C'); 
$pdf->Cell(45,5,'___________________','LR',1,'C'); 
*/$pdf->SetFont('Arial','',10);
$pdf->Cell(92,5,'Nicolas Valdez Gomez',0,0,'C'); 
$pdf->Cell(93,5,'Dulfredo Campos Ampuero',0,1,'C'); 
/*$pdf->Cell(45,5,'-------','LR',0,'C'); 
$pdf->Cell(45,5,'Mario Ayma Rodriguez','LR',1,'C'); 
*/
$pdf->SetFont('Arial','B',10);
//$pdf->Cell(45,5,'Receptor Centro','LBR',0,'C'); 
$pdf->Cell(92,5,'Firma Autorizada',0,0,'C'); 
$pdf->Cell(93,5,'Sello y Firma del Proveedor',0,0,'C'); 
//$pdf->Cell(45,5,'Receptor de Material','LBR',1,'C'); 

$pdf->Output();
?>