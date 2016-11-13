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
	 $this->Image('../cotizacion/images/medio.jpg',35,0,170,35);
    $this->Image('../cotizacion/images/izquierda.jpg',0,5,35,35);
    $this->Image('../cotizacion/images/barra.jpg',32,0,1,300);
	//$this->Image('../../../lib/images/logo_reporte.jpg',15,2,35,15);
  $this->SetXY(52,27);
   	$this->Cell(55,5,''.$_SESSION['ss_nombre_lugar'].'',0,0,'L');
   	$this->Cell(18,5,' ',0,0,'L');
   	$this->Cell(28,5,date('d/m/Y'),0,0,'L');
   	$this->Cell(5,5,'',0,0,'L');
   	if($_SESSION['PDF_tipo_adq']=='Bien'){
   		$this->Cell(40,5,'CB-'.$_SESSION['PDF_num_proceso'].'-'.$_SESSION['PDF_gestion'],0,1,'R');
   	}else{
   		$this->Cell(40,5,'CS-'.$_SESSION['PDF_num_proceso'].'-'.$_SESSION['PDF_gestion'],0,1,'R');
   	}
   	

}
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-25);
    //Arial italic 8
    $this->SetFont('Arial','',7);
    //Número de página
    //$pdf->Ln(5);
    $this->SetFillColor(0,0,0);
		
}

//Cabecera de página

}




$pdf=new PDF();
//$pdf->AddPage();
$pdf->AliasNbPages();
$pdf-> AddFont('Arial','','arial.php'); 	
$pdf->SetLeftMargin(35);
$pdf->SetTopMargin(38);
$pdf->SetAutoPageBreak(true,20.5);
$pdf->SetFont('Arial','B',12);
$pdf->AddPage();


$proveedor_adj=$_SESSION['PDF_proveedor_adj'];
$proveedor=$_SESSION['PDF_prov'];
$c=count($proveedor);
$c1=count($proveedor_adj);

$codigo=$_SESSION['PDF_codigo_proceso'];
$num_convocatoria=$_SESSION['PDF_num_convocatoria'];
$fecha=$_SESSION['PDF_fecha_literal'];
$descripcion=$_SESSION['PDF_descripcion'];




 	$pdf->SetFont('Arial','B',10);
		$pdf->Cell(15,10,'DE:',0,0,'L');//,'LR',0,'C');
		$pdf->Cell(5,10,'',0,0,'L');//,'LR',0,'C');
		$pdf->Cell(20,10,'COMISION DE CALIFICACION ',0,1,'L');//,'LR',0,'C');
		$pdf->Cell(15,10,'A: ',0,0,'L');//,'LR',0,'C');
		$pdf->Cell(5,10,'',0,0,'L');//,'LR',0,'C');
		$pdf->Cell(20,10,'RESPONSABLE DE COMPRAS MENORES',0,1,'L');//,'LR',0,'C');
		$pdf->Cell(20,10,'ASUNTO: ',0,0);
		$pdf->SetFont('Arial','BU',10);
		$pdf->Cell(100,10,'EVALUACIÓN DE PROPUESTAS- CONVOCATORIA Nº'.$num_convocatoria.'-'.$codigo,0,1,'L');
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(120,10,'ANTECEDENTES',0,1,'L');
		//$pdf->SetX(130);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(170,5,'De acuerdo a la Convocatoria Publica Nº '.$num_convocatoria.'- '.$codigo.', correspondiente a  '.$descripcion .', en fecha '.$fecha.', se procedió con la apertura de los sobres presentados por los siguientes proveedores:',0);
		$pdf->SetX(50);
		      
		 for($i=0;$i<$c;$i++){
		     $pdf->Row2($proveedor[$i],0,'L',60);
        }
		$pdf->Ln(5);
		$pdf->MultiCell(170,5,'La evaluación de las ofertas presentadas se realizó conforme a lo establecido en el Requerimiento de Propuestas y la normativa vigente, procediendose además con el análisis de los aspectos técnicos de las propuestas presentadas de parte del representante del Area Técnica',0);
		
		$pdf->Ln(5);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(120,10,'RECOMENDACIÓN:   ',0,1,'L');//,'LR',0,'C');
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(170,5,'Del análisis técnico efectuado y por antecedentes mencionados precedentemente, nos cumple solicitar a la Autoridad Responsable de compras Menores ADJUDICAR la Convocatoria '.$num_convocatoria.'-'.$codigo.', al/los proponente(s)',0); 
		$x=$pdf->GetX();
		$y=$pdf->GetY();
	
		$pdf->SetWidths(array(60,100));
		$pdf->Ln(5);	
		$pdf->Cell(160,0,'',1,1,'',0);
        
			
		for($j=0;$j<$c1;$j++){
		    
		    
		    $pdf->Row($proveedor_adj[$j]);
		}
		$pdf->Cell(160,0,'',1,1,'',0);
		
		$pdf->Ln(5);
		
		/*esto es para la comisión de calificación */
		
		$pdf->Cell(120,10,'Por la comisión de Calificación:   ',0,1,'L');

    $pdf->SetFillColor(0,0,0);
	$pdf->Cell(60,6,'',0,0,'C');
	$pdf->Cell(60,6,'',0,0,'C');
	$pdf->Cell(72,6,'',0,0,'C');
	$pdf->Ln(10);
	$pdf->setX(50);
	/*$pdf->Cell(60,6,'___________________',0,0,'C',$fill);
	$pdf->Cell(25,6,'',0,0,'C',$fill);
	$pdf->Cell(60,6,'___________________',0,0,'C',$fill);*/
	
	$pdf->Ln(6); 
$pdf->SetDrawColor(0,0,0);
$pdf->SetLineWidth(0); 
$pdf->Output();
?>