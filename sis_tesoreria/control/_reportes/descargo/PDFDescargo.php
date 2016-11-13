<?php

session_start();
require ('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
include_once("../../LibModeloTesoreria.php");
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
	    $this->Image('../../../../lib/images/logo_reporte.jpg',170,8,35,15);
	   
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
	
	
	//Cabecera de página
	
	}
}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,20);
$pdf-> AddFont('Tahoma','','tahoma.php');
$pdf-> AddFont('Arial','','arial.php');
$Custom = new cls_CustomDBTesoreria();
//-----------------------Primera Factura

$pdf->SetFont('Tahoma','',10);
$pdf->SetLeftMargin(15);
$pdf->Cell(200,24,' ',0,1); 
$pdf->SetFont('Arial','B',8);
//$pdf->Cell(15,3.5,'',0,1);
//;
$pdf->SetFont('Arial','BI',12);
 
$pdf->Cell(180,5,'DESCARGO DE FONDOS EN AVANCE',0,1,'C'); 
$pdf->Cell(200,2,' ',0,1); 
$pdf->ln(10);
$pdf->SetFont('Arial','B',8);



$pdf->Cell(60,5,'LUGAR','TLR',0,'C'); 
$pdf->Cell(40,5,'FECHA ','TLR',0,'C');
$pdf->Cell(40,5,'HORA ','TLR',0,'C'); 
$pdf->Cell(50,5,'No','TLR',1,'C'); 

$pdf->SetFont('Arial','',8);



$pdf->Cell(60,5,$_SESSION['PDF_lugar_sus'],'BLR',0,'C'); 
$pdf->Cell(40,5,$_SESSION['PDF_fecha'],'BLR',0,'C'); 
$pdf->Cell(40,5,$_SESSION['PDF_hora'],'BLR',0,'C'); 
$pdf->Cell(50,5,$_SESSION['PDF_nro_avance'],'BLR',1,'C');


$pdf->SetFont('Arial','B',8);
$pdf->Cell(30,12,'A FAVOR DE:','LB',0,'L');
$pdf->SetFont('Arial','',8); 
$pdf->Cell(160,12,$_SESSION['PDF_empleado'],'RB',1,'L'); 
$suma=0;

$data=$_SESSION['PDF_EP_rendicion'];

foreach ($data as $linea){

	//aqui va la ep y uo
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(35,6,'U. ORGANIZACIONAL:','LT',0,'L'); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(75,6,$linea[6],'T',0,'L'); 
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(20,6,'PROGRAMA:','T',0,'B');
	$pdf->SetFont('Arial','',8); 
	$pdf->Cell(60,6,$linea[3],'RT',1,'L');
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(25,6,'FINANCIADOR:','L',0,'L'); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(85,6,$linea[1],'',0,'L'); 
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(25,6,'SUBPROGRAMA: ','',0,'L');
	$pdf->SetFont('Arial','',8); 
	$pdf->Cell(55,6,$linea[4],'R',1,'L'); 
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(25,6,'REGIONAL:    ','LB',0,'L'); 
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(85,6,$linea[2],'B',0,'L'); 
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(20,6,'ACTIVIDAD:   ','B',0,'L');
	$pdf->SetFont('Arial','',8); 
	$pdf->Cell(60,6,$linea[5],'RB',1,'L'); 

	$pdf->Cell(15,5,'NRO.','LRTB',0,'C'); 
	$pdf->Cell(25,5,'FECHA','LRTB',0,'C');
	$pdf->Cell(100,5,'DESCRIPCIÓN','LRTB',0,'C');  
	$pdf->Cell(25,5,'CARGO','LRTB',0,'C'); 
	$pdf->Cell(25,5,'DESCARGO','LRTB',1,'C');
		
	
	$pdf->SetFont('Arial','',8); 
	$pdf->SetWidths(array(15,25,100,25,25));
	$pdf->SetAligns(array('R','C','L','R','R'));
	$pdf->SetVisibles(array(1,1,1,1,1));
	$pdf->SetFontsSizes(array(8,8,8,8,8));
	$pdf->SetDecimales(array(0,0,0,2,2));
	
	if($cont==0){
		$arreglo=array();
		
		$arreglo[0]='';
		$arreglo[1]=$_SESSION['PDF_fecha_avance'];
		$arreglo[2]='Fondo en Avance  '.$_SESSION['PDF_numero'];
		$arreglo[3]=$_SESSION['PDF_importe_entregado'];
		$arreglo[4]='';
		
		$pdf->MultiTabla($arreglo,1,1);
	}
	
	$criterio_filtro='0=0 AND AVANCE.fk_avance='.$_SESSION['PDF_id_avance'];
	//$criterio_filtro='0=0 AND AVANCE.fk_avance='.$_SESSION['PDF_id_avance'].' AND AVANCE.id_fina_regi_prog_proy_acti='.$linea[0]." AND AVANCE.id_unidad_organizacional=".$linea[7];
   	$res = $Custom->ListarReporteDescargo(500,0,'AVANCE.fecha_avance','asc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
   	
	$hijo=$Custom->salida;
	$cdata=count($hijo);
	
	//echo $cdata;
	//$pdf->Cell(60,6,'El valor de cdata es: '.$cdata,'RB',1,'L');
	 
	for($i=0;$i<=$cdata;$i++)
	 {	 
	 	//echo donde_estara;	
	   $pdf->MultiTabla($hijo[$i],1,1);
	   $suma=$suma+$hijo[$i][4];	   
	 }
	 
	 $pdf->Cell(180,0,'','T',1,'C');
	 $cont++;	 
}

	$pdf->Cell(140,5,'Sumas parciales','LT',0,'L');
	$pdf->Cell(25,5,$_SESSION['PDF_importe_entregado'],'T',0,'R');
	$pdf->Cell(25,5,miformato($suma),'RT',1,'R');  
	$pdf->Cell(140,5,"Saldo a favor (empresa - funcionario)",'L',0,'L');
	
	$resta=$_SESSION['PDF_importe_entregado']-$suma;
	$resta1=$suma-$_SESSION['PDF_importe_entregado'];
	
	if($resta<0)
	{
		$resta='';
	}
	
	if($resta1<0)
	{
		$resta1='';
	}
	
	$pdf->Cell(25,5,miformato($resta1,2),'',0,'R');
	$pdf->Cell(25,5,miformato($resta,2),'R',1,'R');  
	$pdf->Cell(140,5,'Sumas Iguales','LB',0,'L');
	$pdf->Cell(25,5,miformato($_SESSION['PDF_importe_entregado']+$resta1),'TB',0,'R');
	$pdf->Cell(25,5,miformato($suma+$resta),'RTB',1,'R');  
	 
	$pdf->SetFont('Arial','',8); 
	$data=array("APROBADO POR:\n\n".$_SESSION['PDF_nombre_completo']."\n\n\n\n",
	"RECIBI CONFORME:\n\n\n__________________________\n".$_SESSION['PDF_empleado'],
	"ENTREGUE CONFORME:\n\n\n__________________________\n".$_SESSION['PDF_cajero']);

	$pdf->SetFont('Arial','',8); 
	$pdf->SetWidths(array(70,60,60));
	$pdf->SetAligns(array('C','C','C'));
	$pdf->SetVisibles(array(1,1,1));
	$pdf->SetFontsSizes(array(8,8,8));
	$pdf->SetDecimales(array(0,0,0));

	 $pdf->MultiTabla($data,1,3);


///////////////////////////////////fin de primera factura //////////////////////////////

	function miformato($cadena)
	{
		if($cadena==''){
			return '';
		}
		else{
			return number_format($cadena,2);
		}
	}



$pdf->Output();
?>