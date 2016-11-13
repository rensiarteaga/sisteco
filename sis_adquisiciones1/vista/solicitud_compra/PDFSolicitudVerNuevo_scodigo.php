<?php

session_start();

require('../../../lib/fpdf/fpdf.php');
include_once("../../control/LibModeloAdquisiciones.php");
define('FPDF_FONTPATH','font/');
class PDF extends FPDF
{   
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    $this-> AddFont('Tahoma','','tahoma.php');
$this-> AddFont('Arial','','arial.php');

    
    //Iniciación de variables
    }
 var $widths;
 var $aligns;
function Header()
{
    //Logo
 
    $this->Image('../../../lib/images/logo_reporte.jpg',170,2,35,15);
    
//-----------------------Primera Solicitud

$this->SetFont('Tahoma','',10);
$this->SetLeftMargin(5);
$this->SetTopMargin(5);
 $this->SetAutoPageBreak(true,15);

 $this->SetFillColor(200,200,200);
$this->SetDrawColor(255,255,255);
$this->SetLineWidth(0.5);
$this->Cell(200,7,'ORIGINAL',0,1,'L'); 

$this->SetFont('Arial','BI',14);

$this->Cell(180,5,'SOLICITUD DE '.$_SESSION['PDF_titulo'],0,1,'C');

if($_SESSION['PDF_titulo2']!=''){
	$this->SetFont('Arial','B',11);
	$this->Cell(180,5,'(Reformulada)',0,1,'C'); 
}
$this->SetFont('Arial','B',8);
$this->Cell(185,5,'','T',1,'R');
$this->Cell(200,1,' ',0,1);

$this->SetFont('Arial','B',9);
$this->Cell(25,4,'Número',0,0); 
$this->Cell(45,4,'Localidad ',0,0); 
$this->Cell(40,4,'Fecha y Hora',0,0); 
$this->Cell(37,4,'Moneda',0,0);  
$this->Cell(50,4,'Modalidad',0,1);  
$this->SetFont('Arial','',8);
/* cambiar el tipo de fecha */
$fecha1=date_create ($_SESSION['PDF_fecha_reg']); 
$fecha=date_format( $fecha1,'d/m/Y');


$this->Cell(25,4,$_SESSION['PDF_codigo_depto'].'  '.$_SESSION['PDF_num_solicitud'].'',0,0); 
$this->Cell(45,4,''.$_SESSION['PDF_localidad'].'',0,0); 
$this->Cell(40,4,''.$fecha.' '.$_SESSION['PDF_hora_reg'],0,0); 
$this->Cell(37,4,''.$_SESSION['PDF_moneda'].'',0,0); 
$this->Cell(50,4,''.$_SESSION['PDF_modalidad'].'',0,1); 
$this->Ln(3);
/*$tam_texto = $this->NbLines(60,$_SESSION['PDF_nombre_unidad'].'');
$h=3*$tam_texto;
*/
$y=$this->GetY();
$this->SetFont('Arial','B',6);
$this->Cell(25,4,'Solicitante:',0,0);
$this->SetFont('Arial','',6);
$this->MultiCell(68,4,''.$_SESSION['PDF_nombre_solicitante'].'',1,'L',1); 

$this->SetXY(115,$y);
 $this->SetFont('Arial','B',6);
$this->Cell(25,4,'Cargo:',0,0); 
$this->SetFont('Arial','',6);
$this->MultiCell(68,4,''.$_SESSION['PDF_cargo_empleado_solicitante'].'',1,'L',1);


$y=$this->GetY();
$this->SetFont('Arial','B',6);
$this->Cell(25,4,'Unidad Organizacional:',0,0);
$this->SetFont('Arial','',6);
$this->MultiCell(68,4,''.$_SESSION['PDF_nombre_unidad'].'',1,'L',1); 

$this->SetXY(115,$y);


$this->SetFont('Arial','B',6);
$this->Cell(25,4,'Programa:',0,0);
$this->SetFont('Arial','',6);
$this->MultiCell(68,4,''.$_SESSION['PDF_nombre_programa'].'',1,'L',1);




$y=$this->GetY();

$this->SetFont('Arial','B',6);
$this->Cell(25,4,'Regional:',0,0); 
$this->SetFont('Arial','',6);
$this->MultiCell(68,4,''.$_SESSION['PDF_nombre_regional'].'',1,'L',1);
$this->SetXY(115,$y);

$this->SetFont('Arial','B',6);
$this->Cell(25,4,'Sub-programa/Proyecto:',0,0);
$this->SetFont('Arial','',6);
$this->MultiCell(68,4,''.$_SESSION['PDF_nombre_proyecto'].'',1,'L',1);

$y=$this->GetY();

$this->SetFont('Arial','B',6);
$this->Cell(25,4,'Financiador:',0,0); 
$this->SetFont('Arial','',6);
$this->MultiCell(68,4,''.$_SESSION['PDF_nombre_financiador'].'',1,'L',1);


$this->SetXY(115,$y);
$this->SetFont('Arial','B',6);
$this->Cell(25,4,'Actividad:',0,0);
$this->SetFont('Arial','',6);
$this->MultiCell(68,4,''.$_SESSION['PDF_nombre_actividad'].'',1,'L',1);

$this->SetDrawColor(0,0,0);
$this->SetLineWidth(0); 
$this->Ln(2);
    
   // $this->Line(15,15,195,15);
   
}
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
$fecha=date("d-m-Y");
	$hora=date("H:i:s");
	    $this->SetY(-10);
   	    $this->SetFont('Arial','',6);
   	    
   	    $this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - COMPRO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,sha1($_SESSION['PDF_num_solicitud'].$_SESSION['PDF_nombre_financiador'].$_SESSION['PDF_nombre_regional'].$_SESSION['PDF_nombre_programa'].$_SESSION['PDF_nombre_proyecto'].$_SESSION['PDF_nombre_actividad'].gregoriantojd(date('m'),date('d'),date('Y')).$hora.$_SESSION['PDF_monto_total']),0,0,'L');
			
}


//Cabecera de página

}

$pdf=new PDF();
 
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,10);
$pdf->SetDisplayMode(fullpage);
$Custom = new cls_CustomDBAdquisiciones();


$pdf->SetFont('Arial','B',9);
$pdf->Cell(203,2,'','T',1,'C');
$data_maestro=$_SESSION['PDF_partida'];

$pdf->SetFont('Arial','',10); 


$tam_data=count($data_maestro);
$reformulados=array();
$contador=1;
$aux=array();

for($j=0;$j<$tam_data;$j++)
 {
 	$pdf->Cell(30,5,'Código Partida',0,0,'L'); 
	$pdf->Cell(100,5,'Nombre Partida',0,0,'L'); 
	$pdf->Cell(30,5,'Total Referencial',0,0,'R'); 
	$pdf->Cell(30,5,'   Disponibilidad',0,1,'L'); 
	
 	$pdf->SetWidths(array(30,65,30,30,25));
 	
    if($data_maestro[$j][3]=='NO DISPONIBLE'){
       	$pdf->SetTextColor(237,10,3);
    
    }
     $y=$pdf->GetY();
    $x=$pdf->GetX();
    $pdf->Cell(30,5,$data_maestro[$j][0],0,0);
    $pdf->MultiCell(100,5,$data_maestro[$j][1],0);
    $y1=$pdf->GetY();
    $pdf->SetXY($x+130,$y);
    $pdf->Cell(30,5,number_format($data_maestro[$j][2],2),0,0,'R');
    $pdf->Cell(30,5,'   '.$data_maestro[$j][3],0,1);
    
    
    $pdf->SetXY($x,$y1);
 	//$pdf->MultiTabla($data_maestro[$j],0,0);
   $pdf->SetTextColor(0,0,0);
   $criterio_filtro='0=0 AND SOLCOM.id_solicitud_compra='.$_SESSION['PDF_id_solicitud_compra']." AND codigo_partida like ''".$data_maestro[$j][0]."''";
   if($_SESSION['PDF_titulo']=='BIENES'){
   		$res = $Custom->ReporteVerificacionBien(100,0,'ITEM.codigo','asc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
   }
   else{
   		$res = $Custom->ReporteVerificacionServicio(100,0,'SERVIC.codigo','asc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
   }
$pdf->SetFont('Arial','B',8); 
$data=$Custom->salida;

$pdf->Cell(15,5,'No','LRT',0); 



	$pdf->Cell(113,5,'Descripción','LRT',0);
	$pdf->Cell(10,5,'Unidad','LRT',0);



$pdf->Cell(15,5,'Cantidad','LRT',0);  
$pdf->Cell(25,5,'Precio','LRT',0); 
$pdf->Cell(25,5,'Precio','LRT',1);
$pdf->Cell(15,5,'','LRB',0); 


	$pdf->Cell(113,5,'','LRB',0);
	$pdf->Cell(10,5,'Medida','LRB',0); 

$pdf->Cell(15,5,'','LRB',0);  
$pdf->Cell(25,5,'Unitario','LRB',0);
$pdf->Cell(25,5,'Total','LRB',1);



	$pdf->SetWidths(array(15,25,113,10,15,25,25));
	$pdf->SetAligns(array('R','L','L','L','R','R','R'));
	$pdf->SetVisibles(array(1,0,1,1,1,1,1,0,0));
	$pdf->SetFontsSizes(array(7,7,7,7,7,7,7,7));
	$pdf->SetDecimales(array(0,0,0,0,0,2,2));
	$pdf->SetSpaces(array(3.5,3.5,3.5,3.5,3.5));


$pdf->SetFont('Arial','',8); 



$cdata=count($data);

 for($i=0;$i<$cdata;$i++)
 {
 	
 	if($data[$i]['reformular']=='si'){
 		//echo $data[$i]['refo_item'];
 		array_push($reformulados,array($contador,$data[$i]['id_solicitud_compra_det']));
 		if($data[$i]['refo_item']=='si_item' && $data[$i]['refo_monto']=='si_monto'){
 			$pdf->SetFontsStyles(array('','U','U','','','U','U'));
 		}
 		elseif ($data[$i]['refo_item']=='si_item'){
 			
 			$pdf->SetFontsStyles(array('','U','U','','','',''));
 		}
 		else{
 			$pdf->SetFontsStyles(array('','','','','','U','U'));
 		}
 		
 	}
 	else{
 		$pdf->SetFontsStyles(array('','','','','','',''));
 	}
 	$aux=$data[$i];
 	array_unshift($aux,$contador);
 	
 	
 	
   	$pdf->MultiTabla($aux,0,1,3.5,7);
   	$contador=$contador+1;
 }
 $pdf->Cell(203,0,'','T',1,'C');
 }

//$pdf->ln(40);

$pdf->SetFont('Arial','',8);
$pdf->Ln(5);
$pdf->Cell(36,5,'Justificación:','',0);
$pdf->MultiCell(167,4,''.$_SESSION['PDF_observaciones'].'',0,'L',0);
$pdf->Ln(2);
$pdf->Cell(36,5,'Comité de Evaluación:','',0);
$pdf->MultiCell(167,4,''.$_SESSION['PDF_comite_calificacion'].'',0,'L',0);
$pdf->Ln(2);
$pdf->Cell(36,5,'Posibles Proveedores:','',0);
$pdf->MultiCell(167,4,''.$_SESSION['PDF_proveedores_propuestos'].'',0,'L',0);
//$pdf->ln(10);

if($_SESSION['PDF_titulo2']!=''){
	$pdf->SetFont('Arial','B',10); 
	$pdf->Cell(180,5,'REFORMULACIONES',0,1,'C');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(15,5,'No','LRT',0);  
	

	
		$pdf->Cell(113,5,'Descripción','LRT',0);
		$pdf->Cell(10,5,'Unidad','LRT',0);
	
	
	$pdf->Cell(15,5,'Cantidad','LRT',0);  
	$pdf->Cell(25,5,'Precio','LRT',0); 
	$pdf->Cell(25,5,'Precio','LRT',1);
	$pdf->Cell(15,5,'','LRB',0); 
	
	
		$pdf->Cell(113,5,'','LRB',0);
		$pdf->Cell(10,5,'Medida','LRB',0);
	
	$pdf->Cell(15,5,'','LRB',0);  
	$pdf->Cell(25,5,'Unitario','LRB',0);
	$pdf->Cell(25,5,'Total','LRB',1);
	
	
	
	$pdf->SetWidths(array(15,25,113,10,15,25,25));
	$pdf->SetAligns(array('R','L','L','L','R','R','R'));
	$pdf->SetVisibles(array(1,0,1,1,1,1,1,0,0));
	$pdf->SetFontsSizes(array(8,6,8,8,8,8,8,8));
	$pdf->SetFontsStyles(array('','','','','','',''));
	$pdf->SetDecimales(array(0,0,0,0,0,2,2));
	
	$cdata=count($reformulados);
	$refo=array();
	for($i=0;$i<$cdata;$i++)
 	{
 		$criterio_filtro='0=0 AND SOLDET.id_solicitud_compra_det='.$reformulados[$i][1].' ';
   if($_SESSION['PDF_titulo']=='BIENES'){
   		$res = $Custom->ReporteVerificacionBien(100,0,'SOLDET.id_solicitud_compra_det','asc',$criterio_filtro,1,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
   }
   else{
   		$res = $Custom->ReporteVerificacionServicio(100,0,'SOLDET.id_solicitud_compra_det','asc',$criterio_filtro,1,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
   }
   
   $refo=$Custom->salida;
   $aux=$refo[0];
   
 	array_unshift($aux,$reformulados[$i][0]);
 		$pdf->Cell(203,0,'','T',1,'C');
 		$pdf->MultiTabla($aux,1,1);
 		$pdf->MultiCell(203,4,'MOTIVO REFORMULACIÓN: '.$aux[12],'LRBT');
 		$pdf->ln(4);
   		
 	}
 
	
	 
}

$criterio_filtro='0=0 AND SOLCOM.id_solicitud_compra='.$_SESSION['PDF_id_solicitud_compra']." AND codigo_partida like ''".$data_maestro[$j][0]."''";
   if($_SESSION['PDF_titulo']=='BIENES'){
   		$res = $Custom->ReporteVerificacionBien(100,0,'ITEM.codigo','asc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
   }
   else{
   		$res = $Custom->ReporteVerificacionServicio(100,0,'SERVIC.codigo','asc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
   }


if($pdf->GetY()>230){
	//echo $pdf->GetY();
	$pdf->AddPage();
}
$pdf->MultiCell(195,4,"\n\n\n\n____________________________"."\n".$_SESSION['PDF_nombre_aprobacion']."\n".strtoupper($_SESSION['PDF_cargo_empleado_aprobador'])."\nFirma Autorizada",'','C',0); 


 


///////////////////////////////////fin de primera solicitud //////////////////////////////

$pdf->Output();
?>