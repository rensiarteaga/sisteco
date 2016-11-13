<?php






session_start();

require('../../../lib/fpdf/fpdf.php');
include_once('../../../sis_adquisiciones/control/LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();
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
    $this->Image('../../../lib/images/logo_reporte.jpg',170,2,35,15);
    $this->Ln(10);
}
//Pie de página
function Footer()
{
   $fecha=date("d-m-Y");
	$hora=date("H:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		//$this->Cell(70,3,'Usuario: MEJÍA SERRANO MIRIAM SUSANA',0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		//$this->Cell(18,3,'Fecha: 31-07-2009',0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - COMPRO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
		//$this->Cell(18,3,'Hora: :26:49',0,0,'L');	
}

//Cabecera de página

}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf-> AddFont('Tahoma','','tahoma.php');
$pdf-> AddFont('Arial','','arial.php');
$pdf->SetAutoPageBreak(true,20);

//-----------------------Primera Factura
$pdf->SetFont('Tahoma','',10);
$pdf->SetLeftMargin(10);
$pdf->SetFont('Arial','B',14);

$pdf->SetFillColor(200,200,200);
$pdf->SetDrawColor(255,255,255);
$pdf->SetLineWidth(0.5);
/*Aqui declararemos todas las funciones obtenidas del control */
$proveedores =$_SESSION['PDF_proveedores'];
$Cotizacion_det=array();



$tabla_aimprimir= array();
//print_r($cua_com_cab);
//$num_solicitud='';



$pdf->Cell(165,10,'NOTA DE ADJUDICACIÓN Nº '.$proveedores[0][6].'/'.$proveedores[0][4].'-'.$_SESSION['PDF_gestion'],0,1,'C');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(23,5,'Nº Proceso: ',0,0,'L'); 

$pdf->SetFont('Arial','',8);
$pdf->Cell(30,5,''.$_SESSION['PDF_num_proceso'].'',0,0,'L');
$pdf->Cell(50,5,' ',0,0,'L'); 

$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,'Categoria: ',0,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(70,5,''.$_SESSION['PDF_categoria'].'',0,1,'L');



$pdf->SetFont('Arial','B',8);
$pdf->Cell(23,5,'Código Proceso: ',0,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(35,5,''.$_SESSION['PDF_proceso'].'',0,0,'L');
$pdf->Cell(45,5,' ',0,0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(33,5,'Fecha de Adjudicación: ',0,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(60,5,''.$proveedores[0][5].'',0,1,'L');
$pdf->Cell(23,5,' ',0,0,'L');
$pdf->MultiCell(170,5,''.$_SESSION['PDF_observaciones'].'',0,'L',0);


$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$cant_proveedores=count($proveedores);
$pdf->SetX(10);
$pdf->Cell(7,5,'Nº',0,0,'L');
$pdf->Cell(12,5,'Nº SOL',0,0,'L');
$pdf->Cell(35,5,'PROVEEDOR',0,0,'L');
$pdf->Cell(90,5,'DETALLE',0,0,'L');
$pdf->Cell(10,4,'P.U.',0,0,'C');
$pdf->Cell(25,4,'CANTIDAD',0,0,'C');
$pdf->Cell(25,4,'TOTAL ADJUDICADO',0,1,'C');

$pdf->SetFont('Arial','',7);




for($v=0;$v<count($proveedores);$v++){
    
    $id_cotizacion=$proveedores[$v][0];
	$proveedor=$proveedores[$v][1];
	$total_proveedor=$proveedores[$v][2];
    $moneda=$proveedores[$v][3];
	$observaciones_adj=$proveedores[$v][9];  
		
	$pdf->SetX(10);
	$pdf->Cell(172,4,'                     ' .$proveedores[$v][1].'',0,0,'L',1); 
	$pdf->Cell(5,4,''.$proveedores[$v][3].'',0,0,'R',1); 
	$pdf->Cell(20,4,''.number_format($proveedores[$v][2],2).'',0,1,'R',1); 
	
	
	   $Cotizacion_det=$Custom->RepAdjudicacionDet($id_cotizacion,3);
	   
	   
       $_SESSION['PDF_detalle']=$Custom->salida;   	
       $detalle_documentos=$_SESSION['PDF_detalle'];	  
	   	$yy=$pdf->GetY();
	   	
	   	$limite=$pdf->PageBreakTrigger;
	   	$pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial'));
		$pdf->SetFontsStyles(array('','','','',''));
		$pdf->SetVisibles(array(1,1,1,1,1));
		$pdf->SetFontsSizes(array(7,7,7,7,7));
		$pdf->SetSpaces(array(5,5,5,5,5));
		$pdf->SetWidths(array(7,40,95,16,16));
		$pdf->SetDecimales(array(0,0,0,2,2));
		$pdf->SetFormatNumber(array(0,0,0,1,1));
		$pdf->SetAligns(array('L','L','L','R','R'));

	   		
		for ($j=0;$j<sizeof($detalle_documentos);$j++){
			$numero=$j+1;
			$pdf->Multitabla(array_merge((array)$numero,(array)$detalle_documentos[$j]),0,1,5,8,1);
		}
		
	     
		if(strlen($observaciones_adj)>0){
			$pdf->MultiCell(195,4,"\n".$observaciones_adj.'',0,'L',0); 
		}
//$pdf->MultiCell(190,5,''.$observaciones_adj.'',0,'L',0); 

$pdf->SetFont('Arial','B',10);
//$posy=$pdf->GetY();
if($pdf->GetY()>260){
	$pdf->AddPage();
}

if($pdf->GetY()>230){
	//echo $pdf->GetY();
	$pdf->MultiCell(195,4,"\n\n____________________________"."\n".$proveedores[0][7]."\nResp. Adjudicación",'','C',0); 
	
}else{
	//$pdf->SetX(50);
	$pdf->MultiCell(195,4,"\n\n\n\n\n____________________________"."\n".$proveedores[0][7]."\nResp. Adjudicación",'','C',0); 
}
//$pdf->MultiCell(120,5,"_______________________________\n".' '.$proveedores[0][7].''."\nResp. Adjudicación",'','C',0); 
//$pdf->Cell(100,5,'Resp. Area Solicitante',0,0,'C');
//$pdf->Cell(90,5,'Resp. Adjudicación ',0,0,'C');


}




$pdf->Output();
?>