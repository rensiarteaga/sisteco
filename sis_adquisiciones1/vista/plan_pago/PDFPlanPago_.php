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
    $this->Image('../../../lib/images/logo_reporte.jpg',170,2,35,15);
    $this->Ln(10);
}
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-25);
    //Arial italic 8
    $this->SetFont('Arial','',7);
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
   //$this->Cell(50,3,'Pedido Nº 515',0,1,'L');
}

//Cabecera de página
function FancyTable($header,$data)
{
    //Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(234,243,244);
    $this->SetTextColor(0);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    //Cabecera
    $w=array(20,20,30,30,30);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',1);
    $this->Ln();
    //Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    //Datos
    $fill=0;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'R',$fill);
        $this->Cell($w[1],6,number_format($row[1],2),'LR',0,'R',$fill);
        $this->Cell($w[2],6,$row[2],'LR',0,'R',$fill);
        $this->Cell($w[3],6,$row[3],'LR',0,'R',$fill);
        $this->Cell($w[4],6,$row[4],'LR',0,'L',$fill);
        $this->Ln();
        $fill=!$fill;
    }
    $this->Cell(array_sum($w),0,'','T');
}
/// hasta 

}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf-> AddFont('Tahoma','','tahoma.php');
$pdf-> AddFont('Arial','','arial.php');

//-----------------------Primera Factura
//$pdf->SetFont('Tahoma','',10);
$pdf->SetMargins(15,15,15);
$pdf->SetFont('Arial','B',14);

//Títulos de las columnas
$pdf->Cell(185,5,'Plan de Pagos',0,1,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(37,5,'Nro Cotización:',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(27,5,''.$_SESSION['PDF_num_cotizacion'].'',0,0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(37,5,'Tipo de Entrega:',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(87,5,''.$_SESSION['PDF_tipo_entrega'].'',0,1);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(37,5,'Precio Total:',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(27,5,''.number_format($_SESSION['PDF_precio_total'],2).'',0,0);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(37,5,'Fecha Entrega:',0,0);
$pdf->SetFont('Arial','',12);
$fecha1=date_create ($_SESSION['PDF_fecha_entrega']); 
$fecha=date_format( $fecha1,'d/m/Y');

$pdf->Cell(87,5,''.$fecha.'',0,1);

$header=array('NRO. CUOTA','MONTO','FECHA TENTATIVA','FECHA DE PAGO', 'ESTADO');

$data=$_SESSION['PDF_plan_pago'];

$pdf->SetFont('Arial','',8);

$pdf->Ln(5);
$pdf->FancyTable($header,$data);
$pdf->Ln(15);

$pdf->Output();
?>