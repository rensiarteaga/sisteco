<?php

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
	$hora=date("h:i:s");
	    $this->SetY(-15);
   	    $this->SetFont('Arial','',6);
   	    //$this->Cell(70,3,sha1($_SESSION['PDF_num_solicitud'].$_SESSION['PDF_nombre_financiador'].$_SESSION['PDF_nombre_regional'].$_SESSION['PDF_nombre_programa'].$_SESSION['PDF_nombre_proyecto'].$_SESSION['PDF_nombre_actividad'].$_SESSION['PDF_fecha_juliana'].$_SESSION['PDF_monto_total']),0,0,'L');
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


//Cabecera de página

}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,20);
$pdf-> AddFont('Tahoma','','tahoma.php');
$pdf-> AddFont('Arial','','arial.php');
//$Custom = new cls_CustomDBTesoreria();
//-----------------------Primera Factura
$solicitud_detalle=$_SESSION['PDF_recibo_provisional_det'];
$pdf->SetFont('Tahoma','',10);
$pdf->SetLeftMargin(15);
$pdf->SetFont('Arial','B',8);
$pdf->SetFont('Arial','BI',12);

$pdf->Cell(180,5,'RECIBO DE PAGO',0,1,'C'); 
//$pdf->Cell(180,5,'DE FONDOS EN EFECTIVO',0,1,'C'); 
$pdf->Cell(200,2,' ',0,1); 
$pdf->ln(10);
$pdf->SetFont('Arial','B',8);



$pdf->Cell(60,5,'LUGAR','TLR',0,'C'); 
$pdf->Cell(35,5,'FECHA ','TLR',0,'C');
$pdf->Cell(35,5,'HORA ','TLR',0,'C'); 
$pdf->Cell(35,5,'MONEDA ','TLR',0,'C'); 
$pdf->Cell(25,5,'No','TLR',1,'C'); 

$pdf->SetFont('Arial','',8);



$pdf->Cell(60,5,$_SESSION['PDF_lugar_sus'],'BLR',0,'C'); 
$pdf->Cell(35,5,$_SESSION['PDF_fecha'],'BLR',0,'C'); 
$pdf->Cell(35,5,$_SESSION['PDF_hora'],'BLR',0,'C'); 
$pdf->Cell(35,5,$_SESSION['PDF_moneda'],'BLR',0,'C'); 
$pdf->Cell(25,5,$_SESSION['PDF_numero'],'BLR',1,'C');

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
$suma=0;
$pdf->SetFont('Arial','B',8);
$pdf->Cell(60,3,'Descripción ',1,0,'C');  
 $pdf->Cell(18,3,'Importe ',1,0,'C');  
 $pdf->Cell(74,3,'Presupuesto ',1,0,'C');  
 $pdf->Cell(38,3,'Observaciones',1,1,'C');  
$pdf->SetWidths(array(0,60,18,74,38));
		$pdf->SetFills(array(0,0,0,0,0));
 		$pdf->SetAligns(array('L','L','R','L','L'));
 		$pdf->SetVisibles(array(0,1,1,1,1));
 		$pdf->SetFontsSizes(array(6,6,6,6,6));
 		$pdf->SetFontsStyles(array('','','','',''));
 		$pdf->SetDecimales(array(0,0,2,0,0));
 		$pdf->SetSpaces(array(3,3,3,3,3));
 		$pdf->SetFormatNumber(array(0,0,1,0,0));
		$total_importe=0;
		for ($i=0;$i<sizeof($solicitud_detalle);$i++){
 	 		
	  		$pdf->MultiTabla($solicitud_detalle[$i],0,3,3,6,1);
	  		$total_importe=$total_importe+$solicitud_detalle[$i][2];
   		}
//$data=$_SESSION['PDF_EP_rendicion'];

/*foreach ($data as $linea){

	$data2=array();
	
	array_push($data2,array('U. ORGANIZACIONAL: '.$linea[6],
	"PROGRAMA: ".$linea[3]));
	
	array_push($data2,array('FINANCIADOR: '.$linea[1],
	"SUB-PROGRAMA: ".$linea[4]));
	
	array_push($data2,array('REGIONAL: '.$linea[2],
	"ACTIVIDAD: ".$linea[5]));

	$pdf->SetFont('Arial','',8); 
	$pdf->SetWidths(array(110,80));
	$pdf->SetAligns(array('L','L'));
	$pdf->SetVisibles(array(1,1));
	$pdf->SetFontsSizes(array(8,8));
	$pdf->SetDecimales(array(0,0));

	 $pdf->MultiTabla($data2[0],1,3);
	 $pdf->MultiTabla($data2[1],1,3);
	 $pdf->MultiTabla($data2[2],1,3);
	
	//$pdf->Cell(25,15,'prueba','LRTB',1); 	
	
	
	
	
	$pdf->SetWidths(array(10,120,20,20,20));
	$pdf->SetAligns(array('R','L','R','R','R'));
	$pdf->SetVisibles(array(1,1,1,1,1));
	$pdf->SetFontsSizes(array(8,8,8,8,8));
	$pdf->SetDecimales(array(0,0,2,2,2));
	$pdf->SetFont('Arial','B',8); 
	$pdf->Cell(10,5,'NRO.','LRTB',0); 
	$pdf->Cell(120,5,'CONCEPTO','LRTB',0);
	$pdf->Cell(20,5,'TOTAL','LRTB',0);
	$pdf->Cell(20,5,'RETENCIÓN','LRTB',0);    
	$pdf->Cell(20,5,'LIQUIDO','LRTB',1); 
	
	$pdf->SetFont('Arial','',8); 
	
	
	$criterio_filtro='0=0 AND CAJREG.fk_id_caja_regis='.$_SESSION['PDF_id_Caja_regis'].' AND CAJREG.id_fina_regi_prog_proy_acti='.$linea[0]." AND CAJREG.id_unidad_organizacional=".$linea[7];
   	$res = $Custom->ListarReporteRendicionServicio(500,0,'CAJREG.fecha_regis','asc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
   	
	$hijo=$Custom->salida;
	$cdata=count($hijo);
	 for($i=0;$i<$cdata;$i++)
	 {
	 
	   $pdf->MultiTabla($hijo[$i],1,1);
	   $suma=$suma+$hijo[$i][4];
	   
	 }
	 $pdf->Cell(180,0,'','T',1,'C');
	 $cont++;
	 
}
*/
$pdf->SetFont('Arial','',8); 
$pdf->Cell(140,5,"Total Importe",'L',0,'L');
$pdf->Cell(25,5,'','',0,'R');
$pdf->Cell(25,5,number_format($total_importe,2),'TR',1,'R');  

 
$pdf->SetFont('Arial','',8); 
$data=array("APROBADO POR:\n\n".$_SESSION['PDF_nombre_completo']."\n\n\n\n",
"RECIBI CONFORME:\n\n\n__________________________\n".$_SESSION['PDF_empleado'],
"ENTREGUE CONFORME:\n\n\n__________________________\n".$_SESSION['PDF_cajero']);

$pdf->SetFont('Arial','',8); 
	$pdf->SetWidths(array(70,60,60));
	$pdf->SetAligns(array('C','C','C'));
	$pdf->SetVisibles(array(1,1,1));
	$pdf->SetFontsSizes(array(8,8,8));
	$pdf->SetSpaces(array(4,4,4));
	$pdf->SetDecimales(array(0,0,0));

	 $pdf->MultiTabla($data,1,3,4,8);


///////////////////////////////////fin de primera factura //////////////////////////////

function miformato($cadena){
	if($cadena==''){
		return '';
	}
	else{
		return number_format($cadena,2);
	}
}



$pdf->Output();
?>