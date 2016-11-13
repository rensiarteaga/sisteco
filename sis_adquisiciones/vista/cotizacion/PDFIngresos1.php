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
{
    //Posición: a 1,5 cm del final
    $this->SetY(-25);
    //Arial italic 8
    $this->SetFont('Tahoma','',7);
   
}

//Cabecera de página

}




//-----------------------Primera Factura
$ingresos_array=$_SESSION['PDF_ingresos'];
$tam_ingresos=count($ingresos_array);


$pdf=new PDF();
//$pdf->AddPage();
$pdf->AliasNbPages();
$pdf-> AddFont('Tahoma','','tahoma.php');
$pdf-> AddFont('Arial','','arial.php'); 	
$pdf->SetFont('Tahoma','',10);
$pdf->SetLeftMargin(15);
$pdf->SetAutoPageBreak(true,20.5);
$pdf->SetFont('Arial','B',10);

for($i=0;$i<$tam_ingresos;$i++)
 {
    $pdf->AddPage();
    $pdf->SetX(170);
//$pdf->Cell(30,4,'Nro CB'.'-'.$_SESSION['PDF_num_cotizacion_'.$i].'-'.$_SESSION['PDF_gestion_'.$i],0,1);
$pdf->SetFont('Arial','',10);
$pdf->SetFont('Arial','B',8);
$pdf->SetX(170);
$pdf->Cell(30,4,'Codigo',0,1); 
$pdf->SetFont('Arial','',8);
$pdf->SetX(170);
$pdf->Cell(30,4,$_SESSION['PDF_correlativo_ing_'.$i],0,1); 
$pdf->SetFont('Arial','B',8);
$pdf->SetX(170);
$pdf->Cell(10,4,'Día',1,0);
$pdf->Cell(10,4,'Mes',1,0);
$pdf->Cell(10,4,'Año',1,1);

$fecha_completa=$_SESSION['PDF_fecha_'.$i];

$dia=substr($fecha_completa,8,2);
$mes=substr($fecha_completa,5,2);
$anio=substr($fecha_completa,0,4);
$pdf->SetFont('Arial','',8);
$pdf->SetX(170);
$pdf->Cell(10,4,$dia,1,0);
$pdf->Cell(10,4,$mes,1,0);
$pdf->Cell(10,4,$anio,1,1);
$pdf->SetX(170);
$pdf->Cell(60,5,'Página: '.$pdf->PageNo(),0,0,'L');
$pdf->SetFont('Arial','BI',16);
$pdf->SetXY(45,4);


	/*echo $_SESSION['PDF_fecha_'.$i];
	exit;*/
$fecha1=date_create($_SESSION['PDF_fecha_'.$i]); 

$fecha=date_format( $fecha1,'d/m/Y');
$pdf->Cell(105,20,'VALE DE INGRESO A ALMACÉN',0,0,'C'); 
$pdf->Image('../../../lib/images/logo_reporte.jpg',15,2,35,15);
$pdf->SetFont('Arial','',10);
$pdf->SetY(20);

 		$pdf->SetFont('Arial','B',10);
 		$pdf->Cell(30,5,'Proveedor:',0,0,'L');
 		$pdf->SetFont('Arial','',10);
 		$pdf->Cell(160,5,''.$_SESSION['PDF_proveedor_'.$i],0,1,'L');
 		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(30,5,'Concepto:  ',0,0,'L');//,'LR',0,'C');
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(160,5,$_SESSION['PDF_descripcion_'.$i],0);//,'LR',0,'C');
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(30,5,'Solicitado por :',0,0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(100,5,''.$_SESSION['PDF_origen_'.$i],0,1,'L');//,'LR',0,'C');
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(30,5,'Nro. Remisión:',0,0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(95,5,''.$_SESSION['PDF_proveedor_'.$i]."- ".$_SESSION['PDF_remision_'.$i],0,1,'L');//,'LR',0,'C');
		$pdf->SetFont('Arial','B',10);
		/*$pdf->Cell(30,5,'Fecha Remisión:',0,0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(30,5,$_SESSION['PDF_fecha_factura_'.$i],0,1);//,'LR',0,'C');*/
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(50,5,'Fecha de Ingreso Almacén:',0,0,'L');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(75,5,$fecha,0,0,'L');
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(33,5,'Nº Orden Compra:',0,0,'L');
		$pdf->SetFont('Arial','',10);
		$tipo;
		    $tipo='CB-'.$_SESSION['PDF_num_cotizacion_'.$i].'-'.$_SESSION['PDF_gestion_'.$i];
        $pdf->Cell(50,5,$tipo,0,1,'L');
		$pdf->Cell(50,5,"Nº Cotizacion:".$_SESSION['PDF_num_cotizacion_'.$i],0,0,'L');
		$pdf->Cell(50,5,"Nº Proceso:".$_SESSION['PDF_num_proceso_'.$i],0,0,'L');
		$num_solicitud=$_SESSION['PDF_num_solicitud_'.$i];
		$num_solicitud=substr($num_solicitud,0,strlen($num_solicitud)-1);
		$pdf->Cell(50,5,"Nº Solicitud:".$num_solicitud,0,1,'L');
		
		
$pdf->SetFont('Arial','B',6);	
$pdf->Cell(5,5,'Nro',1,0); 
$pdf->Cell(18,5,'Código',1,0); 
$pdf->Cell(10,5,'Cantidad',1,0); 
$pdf->Cell(8,5,'Unidad',1,0); 
$pdf->Cell(10,5,'Calidad',1,0); 
$pdf->Cell(100,5,'Descripción del Material',1,0); 
$pdf->Cell(15,5,'Peso Neto(kg)',1,0); 
$pdf->Cell(15,5,'Total Importe',1,1); 
$pdf->SetFont('Arial','',6);	
$pdf->SetWidths(array(5,18,10,8,10,100,15,15));
$pdf->SetAligns(array('R','L','R','L','R','L','R','R'));
$tipo_celda1=array(0,0,0,0,1,1,1);

$data=$_SESSION['PDF_det_ingreso_'.$i];

$cdata=count($data);

 for($j=0;$j<$cdata;$j++)
 {
 	$numero=$j+1;
   
    $pdf->Row(array_merge((array)$numero,(array)$data[$j]));
 }
 $sum_array=$_SESSION['PDF_IngresoDetSum_'.$i];

 $pdf->Cell(5,3.5,'','LBT',0,'C');
 $pdf->Cell(18,3.5,'Cantidad Total: ','TB',0,'R');
 $pdf->Cell(10,3.5,$sum_array[0][0],'TB',0,'R');
 $pdf->Cell(10,3.5,'','BRT',0,'R');
 $pdf->Cell(138,3.5,'','BRT',1,'R');
		
		//Imprime las observaciones si es que hubieran
		$pdf->Cell(181,3.5,'Observaciones:','LRT',1,'L');
		$pdf->Cell(181,3.5,''.$_SESSION['PDF_observaciones_'.$i].'','LBR',1,'L');
  }

$pdf->SetFillColor(0,0,0);
	$pdf->Cell(60,6,'','LRT',0,'C',$fill);
	$pdf->Cell(60,6,'','LRT',0,'C',$fill);
	$pdf->Cell(61,6,'','LRT',0,'C',$fill);
	$pdf->Ln(6);
	$pdf->Cell(60,6,'','LR',0,'C',$fill);
	$pdf->Cell(60,6,'','LR',0,'C',$fill);
	$pdf->Cell(61,6,'','LR',0,'C',$fill);
	$pdf->Ln(6);
	$pdf->Cell(60,6,$data1[0][8],'LRB',0,'C',$fill);
	$pdf->Cell(60,6,$data1[0][9],'LRB',0,'C',$fill);
	$pdf->Cell(61,6,'','LRB',0,'C',$fill);
	$pdf->Ln(6);
	$pdf->Cell(60,6,'Encargado de Almacén','LRB',0,'C',$fill);
	$pdf->Cell(60,6,'Jefe de Almacenes','LRB',0,'C',$fill);
	$pdf->Cell(61,6,'','LRB',0,'C',$fill);  
$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(0); 
$pdf->Output();
?>