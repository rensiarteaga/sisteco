<?php
/**
 * Autor :              Ana Maria Villegas Quispe
 * Descripcion:         Reporte de Rendicion Recibo Provisional
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
 	function Header()
	{
    	$this->Image('../../../lib/images/logo_reporte.jpg',170,8,35,15);
     	$this->ln(20);
   
	}

	function Footer()
	{
   
		$fecha=date("d-m-Y");
		$hora=date("h:i:s");
	    $this->SetY(-15);
   	    $this->SetFont('Arial','',6);
   	    $this->ln(3);
   	    $this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - TESORO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
	}

}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,20);

$pdf->SetLeftMargin(15);
$pdf->SetFont('Arial','B',8);
$pdf->SetFont('Arial','BI',12);
$estado=$_SESSION['PDF_estado'];
$pdf->Cell(180,5,'RENDICIÓN DE RECIBO PROVISIONAL DE ENTREGA DE FONDOS EN EFECTIVO',0,1,'C'); 


	
if ($estado=='borrador' || $estado=='pagado'){
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(200,5,'(Vista Previa)',0,1,'C');
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
$pdf->Cell(30,12,'RESPONSABLE:','LB',0,'L');
$pdf->SetFont('Arial','',8); 
$pdf->Cell(160,12,$_SESSION['PDF_empleado'],'RB',1,'L'); 

$pdf->SetFont('Arial','B',8);
$pdf->Cell(25,6,'CONCEPTO:','LB',0,'L');
$pdf->SetFont('Arial','',8); 
//$pdf->Cell(165,6,$_SESSION['PDF_motivo'],'RB',1,'L'); 
$pdf->MultiCell(165,6,$_SESSION['PDF_motivo'],'RB','L'); 


$suma=0;
$pos_ini=0;


$detalle_documentos=$_SESSION['PDF_cuenta_doc_rendicion'];

$size_detdocume=count($detalle_documentos);

$pdf->SetFont('Arial','B',8);	
$pdf->Cell(15,4,'FECHA ','LT',0,'C');  
$pdf->Cell(40,4,'TIPO DOCUMENTO ','T',0,'C');  
$pdf->Cell(55,4,'DOCUMENTO ','T',0,'C');  
$pdf->Cell(20,4,'TOTAL','T',0,'C'); 
$pdf->Cell(20,4,'RETENCION','T',0,'C'); 
$pdf->Cell(20,4,'CARGO ','T',0,'C'); 
$pdf->Cell(20,4,'DESCARGO','TR',1,'C'); 

$pdf->SetFont('Arial','B',6);	
$pdf->Cell(15,4,$_SESSION['PDF_fecha_sol'],'L',0,'L');  
$pdf->Cell(40,4,'Recibo de ENDE ',0,0,'L');  
$pdf->Cell(55,4,$_SESSION['PDF_nro_documento'],0,0,'L');  
$pdf->Cell(20,4,'',0,0,'R'); 
$pdf->Cell(20,4,'',0,0,'R'); 
$pdf->Cell(20,4,$_SESSION['PDF_monto_entregado'],0,0,'R'); 
$pdf->Cell(20,4,'','R',1,'R'); 
$pos_ini=$pdf->GetY();
//echo ($pos_ini);


$total_cargo=0;

$pdf->SetFont('Arial','',8);
	/*****DOCUMENTO ***********/
	$pdf->SetWidths(array(0,15,40,55,20,20,20,20));
	$pdf->SetFills(array(0,0,0,0,0,0,0,0));
	$pdf->SetAligns(array('L','L','L','L','R','R','R','R'));
	$pdf->SetVisibles(array(0,1,1,1,1,1,1,1));
	$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6));
	$pdf->SetFontsStyles(array('B','B','B','B','B','B','B','B'));
	$pdf->SetDecimales(array(0,0,0,0,2,0,2,2));
	$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3));
	$pdf->SetFormatNumber(array(0,0,0,0,1,0,1,1));
$total_descargo=0;	
for($i=0;$i<$size_detdocume;$i++){

	
	
	//
	//$pdf->multitabla_borde_externo=1;
	$pdf->MultiTabla($detalle_documentos[$i],0,0,3,6.5,1); 
 	   
	//$pdf->Ln(3);
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(55,3,'CONCEPTO ',1,0,'C');  
	$pdf->Cell(55,3,'PRESUPUESTO ',1,0,'C');  
	$pdf->Cell(20,3,'TOTAL ',1,1,'C');  
	
	$pdf->SetWidths(array(0,55,55,20));
	$pdf->SetFills(array(0,0,0,0));
	$pdf->SetAligns(array('L','L','L','R'));
	$pdf->SetVisibles(array(0,1,1,1));
	$pdf->SetFontsSizes(array(6,6,6,6));
	$pdf->SetFontsStyles(array('','','',''));
	$pdf->SetDecimales(array(0,0,0,2));
	$pdf->SetSpaces(array(3,3,3,3));
	$pdf->SetFormatNumber(array(0,0,0,1));
	$solicitud_detalle=$_SESSION["PDF_recibo_provisional_det_$i"];
	
	for ($k=0;$k<sizeof($solicitud_detalle);$k++){
 		$pdf->MultiTabla($solicitud_detalle[$k],0,3,3,6,1);
	  
   	}
   	$pdf->SetWidths(array(0,15,40,55,20,20,20,20));
	$pdf->SetFills(array(0,0,0,0,0,0,0));
	$pdf->SetAligns(array('L','L','L','L','R','R','R','R'));
	$pdf->SetVisibles(array(0,1,1,1,1,1,1,1));
	$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6));
	$pdf->SetFontsStyles(array('B','B','B','B','B','B','B','B'));
	$pdf->SetDecimales(array(0,0,0,0,2,0,2,2));
	$pdf->SetSpaces(array(3,3,3,3,3,3,3,3));
	$pdf->SetFormatNumber(array(0,0,0,0,1,0,1,1));
   //	$pdf->Ln(2);
   		
	  	$total_descargo=$total_descargo+$detalle_documentos[$i][7];
  
 }
 $total_descargo1=number_format($total_descargo,2);
 $total_cargo=$_SESSION['PDF_monto_entregado'];
 $total_cargo1=number_format($_SESSION['PDF_monto_entregado'],2);
 
 $pos_fin=$pdf->GetY();
//echo $pos_fin;
//exit; 

 $tam_linea=($pos_fin-$pos_ini);
 $pdf->Line(15,$pos_ini,15,$pos_fin);
 $pdf->Line(205,$pos_ini,205,$pos_fin);
  	$saldo_empresa=0;
   	$saldo_funcionario=0;
   	$pdf->SetFont('Arial','',8); 
	$pdf->Cell(150,4,"Sumas  Parciales",'LT',0,'L');
	$pdf->Cell(20,4,$total_cargo,'T',0,'R');
	$pdf->Cell(20,4,$total_descargo1,'RT',1,'R');
	if($total_cargo>=$total_descargo){
		$saldo_empresa=number_format($total_cargo-$total_descargo,2);
		$pdf->Cell(150,4,"Saldo a Favor de la Empresa",'L',0,'L');  
		$pdf->Cell(20,4,'','',0,'R');
		$pdf->Cell(20,4,$saldo_empresa,'R',1,'R');
		if($total_cargo==$total_descargo){
			$data=array("APROBADO POR:\n\n\n\n\n\n",
			"CONFORME:\n\n\n__________________________\n".$_SESSION['PDF_cajero'],
			"CONFORME:\n\n\n__________________________\n".$_SESSION['PDF_empleado']); 
			
		}
		else
		{	$data=array("APROBADO POR:\n\n\n\n\n\n",
			"RECIBI CONFORME:\n\n\n__________________________\n".$_SESSION['PDF_cajero'],
			"ENTREGUE CONFORME:\n\n\n__________________________\n".$_SESSION['PDF_empleado']);  
		}
	}else{
		$saldo_funcionario=number_format($total_descargo-$total_cargo,2);
		$pdf->Cell(150,4,"Saldo a Favor del Funcionario",'L',0,'L');  
		$pdf->Cell(20,4,$saldo_funcionario,'',0,'R');
	    $pdf->Cell(20,4,'','R',1,'R');  
	    $data=array("APROBADO POR:\n\n\n\n\n\n",
			"RECIBI CONFORME:\n\n\n__________________________\n".$_SESSION['PDF_empleado'],
			"ENTREGUE CONFORME:\n\n\n__________________________\n".$_SESSION['PDF_cajero']);
	}
		$pdf->Cell(150,4,"Sumas Iguales",'LB',0,'L');
		$pdf->Cell(20,4,number_format($total_cargo+$saldo_funcionario,2),'B',0,'R');
		$pdf->Cell(20,4,number_format($total_descargo+$saldo_empresa,2),'BR',1,'R');  

$pdf->SetFont('Arial','',8); 


$pdf->SetFont('Arial','',8); 
$pdf->SetWidths(array(70,60,60));
$pdf->SetAligns(array('C','C','C'));
$pdf->SetVisibles(array(1,1,1));
$pdf->SetFontsSizes(array(8,8,8));
$pdf->SetSpaces(array(4,4,4));
$pdf->SetDecimales(array(0,0,0));
$pdf->MultiTabla($data,1,3,4,8);

$pdf->Output();
?>