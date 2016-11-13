<?php
session_start();
require('../../../lib/fpdf/fpdf.php');
include_once('../../../sis_adquisiciones/control/LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();

//define('FPDF_FONTPATH','font/');
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
    $this->Image('../../../lib/images/logo_reporte.jpg',175,2,25,10);
    $this->Ln(5);
    
    
}
//Pie de página
function Footer()
{
   $fecha=date("d-m-Y");
	$hora=date("h:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		//$this->Cell(18,3,'Fecha: 29-07-2009',0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - COMPRO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
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

//$this->SetLeftMargin(5);
//$this->SetTopMargin(5);
//$this->SetAutoPageBreak(true,15);
//
// $this->SetFillColor(200,200,200);
//$this->SetDrawColor(255,255,255);
//$this->SetLineWidth(0.5);



$partida_det=array();
$Adjudicaciones=$_SESSION['adj'];

$cant_adj=count($Adjudicaciones);


for($i=0;$i<$cant_adj;$i++){
	$solicitudes =$_SESSION['PDF_solicitudes_'.$i]; 
	 	$tabla_aimprimir= array();
	
		$cant_sol=count($solicitudes);
		$pdf->SetFont('Tahoma','',10);
		$pdf->SetLeftMargin(10);

	for($v=0;$v<count($solicitudes);$v++){
		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(175,10,'CERTIFICACION PRESUPUESTARIA '.$solicitudes[$v][24] .'('.$solicitudes[$v][25].')',0,1,'C');
		$pdf->Ln(10);
		$pdf->SetFont('Arial','B',8);
    	$pdf->Cell(25,4,'Número',0,0); 
		$pdf->Cell(45,4,'Localidad ',0,0); 
		$pdf->Cell(40,4,'Fecha y Hora',0,0); 
		$pdf->Cell(37,4,'Moneda',0,0);  
		$pdf->Cell(50,4,'Modalidad',0,1);  
		$pdf->SetFont('Arial','',8);

    	$fecha1=date_create ($solicitudes[$v][3]); 
		$fecha=date_format( $fecha1,'d/m/Y');
	 
	
		$pdf->Cell(25,4,$solicitudes[$v][21].'  '.$solicitudes[$v][1].'',0,0); 
		$pdf->Cell(45,4,''.$solicitudes[$v][2].'',0,0); 
		$pdf->Cell(40,4,''.$fecha.' '.$solicitudes[$v][4],0,0); 
		$pdf->Cell(37,4,''.$solicitudes[$v][20].'',0,0); 
		$pdf->Cell(50,4,''.$solicitudes[$v][22].'',0,1); 
		$pdf->Ln(3);
		
		$y=$pdf->GetY();
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(25,4,'Solicitante:',0,0);
		$pdf->SetFont('Arial','',6);
		$pdf->MultiCell(68,4,''.$solicitudes[$v][6].'',1,'L',1); 
		
		$pdf->SetXY(115,$y);
		 $pdf->SetFont('Arial','B',6);
		$pdf->Cell(25,4,'Cargo:',0,0); 
		$pdf->SetFont('Arial','',6);
		$pdf->MultiCell(68,4,''.$solicitudes[$v][9].'',1,'L',1);
		
		$y=$pdf->GetY();
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(25,4,'Unidad Organizacional:',0,0);
		$pdf->SetFont('Arial','',6);
		$pdf->MultiCell(68,4,''.$solicitudes[$v][5].'',1,'L',1); 
		
		$pdf->SetXY(115,$y);
//	
//	
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(25,4,'Programa:',0,0);
		$pdf->SetFont('Arial','',6);
		$pdf->MultiCell(68,4,''.$solicitudes[$v][13].'',1,'L',1);
		$y=$pdf->GetY();
	//	
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(25,4,'Regional:',0,0); 
		$pdf->SetFont('Arial','',6);
		$pdf->MultiCell(68,4,''.$solicitudes[$v][12].'',1,'L',1);
		$pdf->SetXY(115,$y);
		
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(25,4,'Sub-programa/Proyecto:',0,0);
		$pdf->SetFont('Arial','',6);
		$pdf->MultiCell(68,4,''.$solicitudes[$v][14].'',1,'L',1);
		
		$y=$pdf->GetY();
		
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(25,4,'Financiador:',0,0); 
		$pdf->SetFont('Arial','',6);
		$pdf->MultiCell(68,4,''.$solicitudes[$v][11].'',1,'L',1);
//		
//		
		$pdf->SetXY(115,$y);
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(25,4,'Actividad:',0,0);
		$pdf->SetFont('Arial','',6);
		$pdf->MultiCell(68,4,''.$solicitudes[$v][13].'',1,'L',1);
		
		
		$pdf->SetLineWidth(1); 
		$pdf->Ln(2);
	    
//		$this->SetDrawColor(0,0,0);
//$this->SetLineWidth(0); 
//$this->Ln(2);
		
 	//$pdf->Line(15,15,195,15);
	//$Cotizacion_det=$Custom-> RepAdjudicacionDet($_SESSION['id_cotizacion_'.$i],3);
	
	  $partida_det=$Custom->RepPartidaProceso($solicitudes[$v][26],$solicitudes[$v][0],2);
//	   
       $_SESSION['PDF_detalle']=$Custom->salida;   	
//       print_r($_SESSION['PDF_detalle']);
//       exit;
      $detalle_documentos=$_SESSION['PDF_detalle'];	  
//       
//       print_r($detalle_documentos);
//       exit;
//	   	$yy=$pdf->GetY();
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(72,4,'Pedido',0,0,'L');		
		$pdf->Cell(10,5,'Codigo-',0,0,'R');
		$pdf->Cell(50,5,'Nombre Partida',0,0,'L');
		//$pdf->Cell(20,5,'PROVEEDOR',0,0,'L');
		$pdf->Cell(37,5,'Importe Comp.'.$solicitudes[$v][20],0,0,'R');
		$pdf->Cell(20,4,'Fecha Comp.',0,0,'R');
		

	   	$limite=$pdf->PageBreakTrigger;
	   	$pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial'));
		$pdf->SetFontsStyles(array('','','','B',''));
		$pdf->SetVisibles(array(1,1,1,1,1));
		$pdf->SetFontsSizes(array(7,7,7,9,7));
		$pdf->SetSpaces(array(4,4,4,4,4));
		$pdf->SetWidths(array(70,10,50,35,20));
		$pdf->SetDecimales(array(0,0,0,2,0));
		$pdf->SetFormatNumber(array(0,0,0,1,0));
		$pdf->SetAligns(array('L','R','L','R','C'));
		$pdf->Ln(5);
	   	$pdf->SetX(10);
		for ($j=0;$j<sizeof($detalle_documentos);$j++){
			//$numero=$j+1;
			$pdf->Multitabla(array_merge((array)$detalle_documentos[$j]),3,3,4,8,1);
			
		}  	 


//
//
//
//
//	

$pdf->MultiCell(195,4,"\n\n\n\n____________________________"."\n".$solicitudes[$v][7]."\n".strtoupper($solicitudes[$v][10])."\nFirma Autorizada",'','C',0); 
	if($i+1<$cant_adj){
 		if(($pdf->GetY()/($v+1))>115){
		//echo $pdf->GetY();
		$pdf->AddPage();
	}else{
		$pdf->Ln(15);
	}
	}
	
}
//if(($pdf->GetY()/$i)>115){
//	//echo $pdf->GetY();
//	$pdf->AddPage();
//}else{
//	$pdf->Ln(10);
//}

}
//Pie de página
	




//Cabecera de página




   		
 

//$pdf->ln(40);

//
//



///////////////////////////////////fin de primera solicitud //////////////////////////////

$pdf->Output();
?>