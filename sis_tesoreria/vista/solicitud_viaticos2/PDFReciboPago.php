<?php

session_start();
/**Autor: Ana María Villegas Quispe
 * Fecha Mod: 20/10/2010
 * Desc:   Reporte de solicitud de fondos se inserto 3 hojas en uno 
 
 */

require('../../../lib/fpdf/fpdf.php');
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
 function SetPrograma($nombre_programa)
{
    $this->nombre_programa=$nombre_programa;
}   
 //Cabecera
function Header()
{
	

}
//Pie de página
function Footer()
{
 $fecha=date("d-m-Y");
	$hora=date("h:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
   	    //$this->Cell(200,0.2,'',1,1);
   	    if($_SESSION["ss_id_usuario"]==120){
   	    	$this->Cell(70,3,'Usuario: MANSILLA ANGULO JOVANNA VIRGINIA',0,0,'L');
   	    }else{
			$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
   	    }
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		if($_SESSION["ss_id_usuario"]==120){
			$this->Cell(18,3,'Fecha: 30-09-2016 ',0,0,'L');
		}else{
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		}
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS -TESORO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
   }
}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,7);
$pdf->SetMargins(5,5,5);
$pdf->SetFont('Arial','B',8);
$solicitud_detalle=$_SESSION['PDF_solicitud_viaje_det'];	
$inicio_boleta=$pdf->GetY();
//for ($i=0;$i<3;$i++){

$pdf->SetFont('Arial','B',14);
$y=$inicio_boleta;
$pdf->SetXY(5,$y);
$pdf->Cell(40,16,'',1,0);
$pdf->Image('../../../lib/images/logo_reporte.jpg',10,$y+1,25,10);
$pdf->SetXY(45,$y);
//$y_cab=$pdf->GetY();
$pdf->Cell(125,7,' RECIBO DE PAGO DE VIATICO','LTR',1,'C');
$pdf->SetFont('Arial','',8);
$pdf->SetXY(45,$y+7);
//$pdf->MultiCell(125,5,'CUENTA DOCUMENTADA','LRB','C');
$x=$pdf->GetX();

				
$fecha_completa=$_SESSION['PDF_recibo_pago'][0]['fecha'];

$dia=substr($fecha_completa,0,2);
$mes=substr($fecha_completa,3,2); 
$anio=substr($fecha_completa,6,4);


$pdf->SetFont('Arial','B',8);
$pdf->SetXY(170,$y);
$pdf->Cell(42,4,'Localidad',1,1,'C'); 
$pdf->SetX(170);
$pdf->Cell(42,4,$_SESSION['PDF_recibo_pago'][0]['lugar'],1,1,'C'); 
$pdf->SetFont('Arial','',8);

$pdf->SetFont('Arial','B',8);
$pdf->SetX(170);
$pdf->Cell(14,4,'Día',1,0,'C');
$pdf->Cell(14,4,'Mes',1,0,'C');
$pdf->Cell(14,4,'Año',1,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->SetX(170);
$pdf->Cell(14,4,$dia,1,0,'C');
$pdf->Cell(14,4,$mes,1,0,'C');
$pdf->Cell(14,4,$anio,1,1,'C');



//$pdf->Ln(3);

$pdf->SetFont('Arial','B',8);
//$pdf->Cell(210,1,'',0,1);

//$pdf->Cell(210,0.3,'','T',1);

$pdf->Cell(207,4,'Recibi de ENDE','LRT',1);
//$pdf->Cell(207,3,'',1,1);

$pdf->Cell(20,8,'La suma de: ','L',0);
$pdf->SetFillColor(192,192,192);
$pdf->Cell(157,8,$_SESSION['PDF_recibo_pago'][0]['importe_literal'],0,0,'L',1);
$pdf->Cell(10,8,'Bs',0,0,'R');
$pdf->Cell(20,8,number_format($_SESSION['PDF_recibo_pago'][0]['importe_rendicion'],2),'R',1,'R',1);

$pdf->Cell(30,4,'Por concepto de:','L',0);
$pdf->MultiCell(177,4,$_SESSION['PDF_recibo_pago'][0]['motivo']." (Categoría ".$_SESSION['PDF_recibo_pago'][0]['categoria'].")",'R',1);
$y=$pdf->GetY();
//$pdf->Cell(207,4,'detalle',1,1);

$v_recibo_mes=$_SESSION['PDF_RepReciboPagoMes'];
$pdf->SetFont('Arial','',8);	
            $pdf->SetWidths(array(20,20,20,20,20,20,20,20,30));
$pdf->SetAligns(array('R','R','L','R','R','R','R','R','R'));
$pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1));
$pdf->SetFontsSizes(array(7,7,7,7,7,7,7,7,7));
$pdf->SetDecimales(array(0,0,0,2,0,2,0,2,2));
$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3));
$v_detalle_suma=0;
for ($i=0;$i<count($v_recibo_mes);$i++){
//$pdf->Cell();
$pdf->SetFont('Arial','',8);
$pdf->Cell(20,5,'','L',1,'C');
$pdf->MultiCell(207,4,$_SESSION['PDF_mes_literal_'.$i].' '.$_SESSION['PDF_gestion_'.$i].' ('.$_SESSION['PDF_rendiciones_anteriores_'.$i].')','LR');


$v_detalle=$_SESSION['PDF_recibo_det_'.$i];
$pdf->Cell(20,3,'Dias ','LTR',0,'C');	 
$pdf->Cell(20,3,'Dias ','LTR',0,'C');	 
$pdf->Cell(20,3,'Tipo ','LTR',0,'C');	
$pdf->Cell(20,3,'Importe ','LTR',0,'C');	 
$pdf->Cell(20,3,'%','LTR',0,'C');	 
$pdf->Cell(20,3,'Importe ','LTR',0,'C');	 
$pdf->Cell(20,3,'%','LTR',0,'C');	 
$pdf->Cell(20,3,'Importe ','LTR',0,'C');
	//abril2016
$pdf->Cell(30,3,'Rango ','LTR',1,'C');


$pdf->Cell(20,3,'Acumulados ','LBR',0,'C');	 
$pdf->Cell(20,3,' ','LBR',0,'C');	 
$pdf->Cell(20,3,'Destino','LBR',0,'C');	
$pdf->Cell(20,3,'Total ','LBR',0,'C');	 
$pdf->Cell(20,3,'Cobertura','LBR',0,'C');	 
$pdf->Cell(20,3,'Cobertura ','LBR',0,'C');	 
$pdf->Cell(20,3,'Aplicación ','LBR',0,'C');	 

	$pdf->Cell(20,3,'Líquido ','LBR',0,'C');
	//abril
	$pdf->Cell(30,3,'Fechas','LBR',1,'C');	


 

 for($j=0;$j<count($v_detalle);$j++){
 	$v_detalle_suma=$v_detalle_suma+$v_detalle[$j][7];
 	$pdf->MultiTabla($v_detalle[$j],0,3,3,7);
 	
 	
 }

}

 $pdf->SetFont('Arial','B',8);
$pdf->Cell(140,4,'Total Bs','L',0,'R');
$pdf->Cell(20,4,number_format($v_detalle_suma,2),1,1,'R');


$pdf->Cell(207,3,'','LR',1);

$pdf->Cell(40,4,'','L',0);
$pdf->Cell(60,4,'Retenciones Impositivas','',0);
$pdf->Cell(107,4,'','R',1);
 $pdf->SetFont('Arial','',8);
 
$pdf->Cell(40,4,'','L',0);
$pdf->Cell(100,4,'R.C.  I.V.A.','',0);
$pdf->Cell(20,4, number_format($v_detalle_suma - $_SESSION['PDF_recibo_pago'][0]['importe_rendicion'] - $_SESSION['PDF_recibo_pago'][0]['iue'] - $_SESSION['PDF_recibo_pago'][0]['it'], 2) ,0,0,'R');
$pdf->Cell(67,4,'',0,1);
 
$pdf->Cell(40,4,'','L',0);
$pdf->Cell(100,4,'I.U.E. SERVICIOS','',0);
$pdf->Cell(20,4,$_SESSION['PDF_recibo_pago'][0]['iue'],0,0,'R');
$pdf->Cell(67,4,'',0,1);

$pdf->Cell(40,4,'','L',0);
$pdf->Cell(100,4,'I.T.','',0);
$pdf->Cell(20,4,$_SESSION['PDF_recibo_pago'][0]['it'],0,0,'R');
$pdf->Cell(67,4,'',0,1);

$pdf->Cell(40,4,'','L',0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(100,4,'LÍQUIDO PAGABLE Bs','',0,'R');
$pdf->Cell(20,4,number_format($_SESSION['PDF_recibo_pago'][0]['importe_rendicion'],2),'T',0,'R');
$pdf->Cell(67,4,'',0,1);

$pdf->SetFont('Arial','',8);
$pdf->Line(212,$pdf->GetY(),212,$y);
/*
$pdf->Cell(100,10,'Imputación Contable:','L',0,'R');
$pdf->SetFont('Arial','',8);
$pdf->Cell(107,10,$_SESSION['PDF_recibo_pago'][0]['nombre_unidad'],'R',1);*/
//$pdf->Cell(207,3,'','LR',1);
$pdf->Cell(100,10,'','L',0);







$pdf->Cell(107,10,$_SESSION['PDF_recibo_pago'][0]['nombre_completo'],'R',1,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,1,'','L',0);
$pdf->Cell(60,1,'','B',0);
$pdf->Cell(40,1,'','',0);
$pdf->Cell(67,1,'','B',0);
$pdf->Cell(20,1,'','R',1);
$pdf->Cell(100,4,'Firma del Interesado','LB',0,'C');
$pdf->Cell(107,4,'Apellido y Nombre','RB',1,'C');

$pdf->Cell(10,4,'NOTA:',0,0);
$pdf->Cell(197,4,'EL PRESENTE DOCUMENTO CERTIFICA UNICAMENTE EL RECIBO DE FONDOS POR CONCEPTO DE VIATICOS',0,1);


$pdf->Output();
?>


 