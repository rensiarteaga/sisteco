<?php
/**
 * Autor :              Ana Maria Villegas Quispe
 * Descripcion:         Reporte de Recibo Provisional
 * Ultima Modificacion: 25/11/2009
 */
session_start();
require('../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
include_once("../../control/LibModeloTesoreria.php");
class PDF extends FPDF
{   
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    	//Llama al constructor de la clase padre
    	$this->FPDF($orientation,$unit,$format);
    	$this-> AddFont('Arial','','arial.php');
    	//Iniciación de variables
    }
	var $widths;
 	var $aligns;
	
 	function Header()
	{
    	$this->Image('../../../lib/images/logo_reporte.jpg',170,8,35,15);
    	$this->ln(20);
	}
	
	function Footer()
	{
   		//Posición: a 1,5 cm del final
		$fecha=date("d-m-Y");
		$hora=date("H:i:s");
	    $this->SetY(-15);
   	    $this->SetFont('Arial','',6);
   	    $this->ln(3);
   	    $this->Cell(70,3,'Usuario: BEJARANO ARTEAGA VIVIAN CLARETH ',0,0,'L');
		//$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: 24-11-2014',0,0,'L');
		//$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - TESORO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		//$this->Cell(18,3,'Hora: '.$hora,0,0,'L');
		$this->Cell(18,3,'Hora: 09:30:14',0,0,'L');	
	}
}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,20);

$pdf->SetLeftMargin(15);
$pdf->SetFont('Arial','BI',12);
$estado=$_SESSION['PDF_estado'];
$pdf->Cell(180,5,'RECIBO PROVISIONAL DE ENTREGA ',0,1,'C'); 
$pdf->Cell(180,5,'DE FONDOS EN EFECTIVO',0,1,'C'); 
	if ($estado=='borrador')
	{
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(180,5,'(Vista Previa)',0,1,'C');
	}
$pdf->Cell(200,2,' ',0,1); 
$pdf->ln(10);
$pdf->SetFont('Arial','B',8);

$pdf->Cell(50,5,'LUGAR','TLR',0,'C'); 
$pdf->Cell(30,5,'FECHA ','TLR',0,'C');
$pdf->Cell(30,5,'MONEDA ','TLR',0,'C'); 
$pdf->Cell(80,5,'No','TLR',1,'C'); 

$pdf->SetFont('Arial','',8);

$pdf->Cell(50,5,$_SESSION['PDF_nombre_lugar'],'BLR',0,'C'); 
$pdf->Cell(30,5,$_SESSION['PDF_fecha'],'BLR',0,'C'); 
$pdf->Cell(30,5,$_SESSION['PDF_nombre_moneda'],'BLR',0,'C'); 
$pdf->Cell(80,5,$_SESSION['PDF_nro_documento'],'BLR',1,'C');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(25,6,'CAJA:','LB',0,'L'); 
$pdf->SetFont('Arial','',8);
$pdf->Cell(165,6,$_SESSION['PDF_caja'],'RB',1,'L'); 

$pdf->SetFont('Arial','B',8);
$pdf->Cell(25,6,'CAJERO:','LB',0,'L');
$pdf->SetFont('Arial','',8); 
$pdf->Cell(165,6,$_SESSION['PDF_cajero'],'RB',1,'L'); 

$pdf->SetFont('Arial','B',8);
$pdf->Cell(30,12,'A FAVOR DE:','LB',0,'L');
$pdf->SetFont('Arial','',8); 
$pdf->Cell(160,12,$_SESSION['PDF_empleado'],'RB',1,'L'); 

$pdf->SetFont('Arial','B',8);
$pdf->Cell(190,5,'CONCEPTO:','TRL',1);
$pdf->SetFont('Arial','',8);	
$pdf->MultiCell(190,5,'                '.$_SESSION['PDF_motivo'],'LRB'); 	



$suma=0;
$pdf->SetFont('Arial','B',8);
$solicitud_detalle=$_SESSION["PDF_recibo_provisional_det"];

if (($_SESSION['PDF_fk_id_cuenta_doc']!='') || !is_null($_SESSION['PDF_fk_id_cuenta_doc']) || ($_SESSION['PDF_id_subsistema']==4)){		
	
	
 	
	$pdf->Cell(170,5,"IMPORTE:",'L',0,'R');
	$pdf->SetFont('Arial','',8); 
	$pdf->Cell(20,5,number_format($_SESSION['PDF_monto_entregado'],2),'TR',1,'R');  
	$pdf->SetFont('Arial','B',8); 
	$pdf->Cell(190,5,"SON:",'LR',1,'L');
	$pdf->SetFont('Arial','',8); 
	$pdf->Cell(5,5,'','LB',0);
	$pdf->Cell(185,5,$pdf->num2letras($_SESSION['PDF_monto_entregado'],false).' '.$_SESSION['PDF_nombre_moneda'],'RB',1,'L');  

 } else {
 	
 	
 	
	$pdf->Cell(55,3,'DESCRIPCIÓN ',1,0,'C');  
 	$pdf->Cell(55,3,'PRESUPUESTO ',1,0,'C');  
 	$pdf->Cell(40,3,'OBSERVACIONES',1,0,'C');  
 	$pdf->Cell(20,3,'DISPONIBLE',1,0,'C'); 
 	$pdf->Cell(20,3,'IMPORTE ',1,1,'C');  
 
	$pdf->SetWidths(array(0,55,55,40,20,20));
	$pdf->SetFills(array(0,0,0,0,0,0,0,0));
	$pdf->SetAligns(array('L','L','L','L','L','R'));
	$pdf->SetVisibles(array(0,1,1,1,1,1));
	$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6));
	$pdf->SetFontsStyles(array('','','','','','','',''));
	$pdf->SetDecimales(array(0,0,0,0,0,2));
	$pdf->SetSpaces(array(3,3,3,3,3,3,3,3));
	$pdf->SetFormatNumber(array(0,0,0,0,0,1));
	$total_importe_solicitado=0;
	$total_importe_entregado=0;
	for ($i=0;$i<sizeof($solicitud_detalle);$i++){
 		if($solicitud_detalle[$i][4]=='NO DISPONIBLE'){
 	 		$pdf->SetFontsColors(array(array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(237,10,3)));
 	 	}
	  	$pdf->MultiTabla($solicitud_detalle[$i],0,3,3,6,1);
	  	$pdf->SetFontsColors(array(array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0)));
	  	$total_importe_entregado=$total_importe_entregado+$solicitud_detalle[$i][5];
   	}
   	$pdf->SetFont('Arial','',6);
   	$pdf->Cell(170,5,'TOTAL SOLICITADO','RLB',0,'R');
   	$pdf->Cell(20,5,number_format($total_importe_entregado,2),1,1,'R');
   	$pdf->SetFont('Arial','B',8); 
	$pdf->Cell(170,5,"IMPORTE ENTREGADO:",'L',0,'R');
	$pdf->SetFont('Arial','',8);
	if(is_null($_SESSION['PDF_monto_entregado'])|| $_SESSION['PDF_monto_entregado']==''){
		$pdf->Cell(20,5,'','TR',1,'R');  
	}else 
	{
		$pdf->Cell(20,5,number_format($_SESSION['PDF_monto_entregado'],2),'TR',1,'R');  
	}
	
	if(is_null($_SESSION['PDF_monto_entregado'])|| $_SESSION['PDF_monto_entregado']==''){
        $pdf->Cell(185,0,'','RB',1,'L');  		
	}else{
		$pdf->SetFont('Arial','B',8); 
		$pdf->Cell(190,5,"SON:",'LTR',1,'L');
		$pdf->SetFont('Arial','',8); 
		$pdf->Cell(5,5,'','LB',0);
		$pdf->Cell(185,5,$pdf->num2letras($_SESSION['PDF_monto_entregado'],false).' '.$_SESSION['PDF_nombre_moneda'],'RB',1,'L');  
	}
	

  }

 
$pdf->SetFont('Arial','',8); 
$pdf->SetFont('Arial','',8); 
$pdf->SetWidths(array(70,60,60));
$pdf->SetAligns(array('C','C','C'));
$pdf->SetVisibles(array(1,1,1));
$pdf->SetFontsSizes(array(8,8,8));
$pdf->SetSpaces(array(4,4,4));
$pdf->SetDecimales(array(0,0,0));
if (($_SESSION['PDF_fk_id_cuenta_doc']!='') || !is_null($_SESSION['PDF_fk_id_cuenta_doc']) || ($_SESSION['PDF_id_subsistema']==4))		
	{ 
		$pdf->SetWidths(array(100,90));
		$data=array(
					"RECIBI CONFORME:\n\n\n__________________________\n".$_SESSION['PDF_empleado'],
					"ENTREGUE CONFORME:\n\n\n__________________________\n".$_SESSION['PDF_cajero']);
}else{
		$pdf->SetWidths(array(70,60,60));
		$data=array("APROBADO POR:\n\n\n__________________________\n".$_SESSION['PDF_aprobador'],
					"RECIBI CONFORME:\n\n\n__________________________\n".$_SESSION['PDF_empleado']."\n Me comprometo a Rendir este Fondo en el plazo de 48 horas hábiles.",
					"ENTREGUE CONFORME:\n\n\n__________________________\n".$_SESSION['PDF_cajero']);
	}
$pdf->MultiTabla($data,1,3,4,8);

$pdf->SetFont('Arial','',6); 
//$pdf->Cell(180,5,' * Esta solicitud debe rendirse máximo dentro de 48 horas, a partir de la fecha de entrega del efectivo.',0,1);
$pdf->Cell(180,5,' * Es de total responsabilidad del solicitante la rendición en el plazo establecido.',0,1);

$pdf->Output();
?>
