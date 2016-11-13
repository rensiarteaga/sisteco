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
    $this-> AddFont('Arial','','arial.php');
    //Iniciación de variables
    }
 
function Header()
{  $this->Image('../../../lib/images/logo_reporte.jpg',170,2,35,15);
	$this->SetFont('Arial','BI',14);
	$this->SetY(15);
	if($_SESSION['PDF_pago_integrado']=='dev'){
		$this->Cell(180,5,'SOLICITUD DE DEVENGADO POR EL TOTAL',0,0,'C'); 
	}
	elseif($_SESSION['PDF_pago_integrado']=='no'){
		$this->Cell(180,5,'SOLICITUD DE DEVENGADO',0,0,'C'); 
	}
	elseif ($_SESSION['PDF_pago_integrado']=='si'){
		$this->Cell(180,5,'SOLICITUD DE PAGO',0,0,'C'); 
	}
	elseif ($_SESSION['PDF_tipo_pago']=='adelantado'){
			$this->Cell(180,5,'SOLICITUD DE PAGO DE ANTICIPO',0,0,'C');
	}
	else{
		$this->Cell(180,5,'SOLICITUD DE DEVENGADO Y PAGO',0,0,'C'); 
	}
	
    $this->ln(3);
    $this->SetFont('Arial','',8);
   	$this->Cell(190,5,$_SESSION['PDF_codigo'].'-'.$_SESSION['PDF_gestion'],0,1,'R');
   	 	
   	
}
//Pie de página
function Footer()
{
    $fecha=date("d-m-Y");
	$hora=date("h:i:s");
	    $this->SetY(-15);
	    
   	    $this->SetFont('Arial','',6);
   	    $this->ln(3);
   	    
   	    if($_SESSION["ss_id_usuario"]==120){
   	    	$this->Cell(70,3,'Usuario:VERA GONZALES ROLANDO JAVIER',0,0,'L');
   	    }else{
   	    $this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');}
   	    //$this->Cell(70,3,'Usuario: MEJIA SERRANO MIRIAM SUSANA',0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		//$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		//$this->Cell(18,3,'Fecha: 170-',0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - COMPRO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		//$this->Cell(18,3,'Hora: '.$hora,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,sha1(gregoriantojd(date('m'),date('d'),date('Y')).$hora),0,0,'L');
		
}

//Cabecera de página

}




//-----------------------Definición de variables

$pdf=new PDF();
//$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetLeftMargin(20);
$pdf->SetTopMargin(38);
$pdf->SetAutoPageBreak(true,20.5);
$pdf->SetFont('Arial','B',12);
$pdf->AddPage();


$proveedor =$_SESSION['PDF_proveedor'];

$codigo_proceso=$_SESSION['PDF_codigo_proceso'];
$solicitante=$_SESSION['PDF_solicitante'];
$unidad_organizacional=$_SESSION['PDF_unidad_organizacional'];
$descripcion_sol=$_SESSION['PDF_descripcion_sol'];
$monto=$_SESSION['PDF_monto'];
$forma_pago=$_SESSION['PDF_forma_pago'];

$num_factura=$_SESSION['PDF_num_factura'];
$lugar_entrega=$_SESSION['PDF_lugar_entrega'];
$nivel_aprobacion=$_SESSION['PDF_nivel_aprobacion'];
$desc=$_SESSION['PDF_descrip'];
$lugar=$_SESSION['ss_nombre_lugar'];
$monto_literal =$_SESSION['PDF_monto_literal'];
$nro_cuota=$_SESSION['PDF_nro_cuota'];
$observaciones=$_SESSION['PDF_observaciones_pago'];
$multas=$_SESSION['PDF_multas'];
$descuentos=$_SESSION['PDF_descuentos'];
$monto_no_pagado=$_SESSION['PDF_monto_no_pagado'];
//$monto_no_pagado=0;
//echo $_SESSION['PDF_impuestos'];


 	
		/*$pdf->SetFont('Arial','B',10);
		$pdf->Cell(120,10,'ANTECEDENTES',0,1,'L');
		*///$pdf->SetX(130);
		$pdf->SetFont('Arial','',10);
		if($_SESSION['PDF_tipo_pago']=='adelantado'){
			$pdf->MultiCell(185,5,'Agracederemos proceder con la emisión de una Orden de Pago de Anticipo, de acuerdo con la siguiente información:',0);
		}else{
		
			$pdf->MultiCell(185,5,'Agracederemos proceder con la emisión de una Orden de Pago, de acuerdo con la siguiente información:',0);
		}
		$pdf->ln(5);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Nºde Orden de '.$desc.':',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,$codigo_proceso,0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Descripción de '.$desc.':',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,$descripcion_sol,0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Proveedor:',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,$proveedor,0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Nº Cuota: ',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(45,5,"".$_SESSION['PDF_nro_cuota']." ",0,1);
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Fecha de Devengado: ',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,$_SESSION['PDF_fecha_devengado'],0);
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Fecha de Pago: ',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,$_SESSION['PDF_fecha'],0);
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Forma de Pago:',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,$forma_pago,0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Impuesto:',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,$_SESSION['PDF_impuestos'],0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Nº de Factura',0,0);
		$pdf->SetFont('Arial','',10);
		
		if($num_factura>0){
		  $pdf->MultiCell(120,5,$num_factura.' ',0);
		}else{
		  $pdf->MultiCell(120,5,'contra entrega',0);
		}
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Observaciones de Pago',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,$observaciones,0);
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(45,5,'Modalidad',0,0);
		$pdf->SetFont('Arial','',10);
		$pdf->MultiCell(120,5,$nivel_aprobacion,0);
		$pdf->SetFont('Arial','B',10);
		
	if($_SESSION['PDF_anticipo_con_ejecucion']=='no'){
		
		$pdf->Cell(130,5,'Importe ('.$_SESSION['PDF_moneda'].'):   ',0,0,'R');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(45,5,number_format($_SESSION['PDF_monto_sin_ret'],2,'.',','),0,1,'R');}
	else{	
		$pdf->Cell(130,5,'Importe ('.$_SESSION['PDF_moneda'].'):   ',0,0,'R');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(45,5,number_format($monto,2,'.',','),0,1,'R');
	}
		
		
	if($_SESSION['PDF_tipo_pago']=='normal'){
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(130,5,'Monto no Pagado ('.$_SESSION['PDF_moneda'].'):   ',0,0,'R');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(45,5,number_format($monto_no_pagado,2,'.',','),0,1,'R');
		
		if($_SESSION['PDF_anticipo_con_ejecucion']=='no'){
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(130,5,'Retención ('.$_SESSION['PDF_moneda'].'):   ',0,0,'R');
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(45,5,number_format($_SESSION['PDF_monto_sin_ret']-$monto-$monto_no_pagado,2,'.',','),0,1,'R');
		}else{
			$pdf->SetFont('Arial','B',10);
			$pdf->Cell(130,5,'Retención ('.$_SESSION['PDF_moneda'].'):   ',0,0,'R');
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(45,5,number_format(0.00,2,'.',','),0,1,'R');
		}
		
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(130,5,'Multas ('.$_SESSION['PDF_moneda'].'):   ',0,0,'R');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(45,5,number_format($_SESSION['PDF_multas'],2,'.',','),0,1,'R');
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(130,5,'Retencion p/anticipo ('.$_SESSION['PDF_moneda'].'):   ',0,0,'R');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(45,5,number_format($_SESSION['PDF_desc_anticipo'],2,'.',','),0,1,'R');
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(130,5,'Retencion p/garantia ('.$_SESSION['PDF_moneda'].'):   ',0,0,'R');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(45,5,number_format($_SESSION['PDF_desc_garantia'],2,'.',','),0,1,'R');
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(130,5,'Descuentos ('.$_SESSION['PDF_moneda'].'):   ',0,0,'R');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(45,5,number_format($_SESSION['PDF_descuentos'],2,'.',','),0,1,'R');
	}else{
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(130,5,'% Anticipo :   ',0,0,'R');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(45,5,number_format($_SESSION['PDF_porcentaje_anticipo'],2,'.',','),0,1,'R');
	}	
		
		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(130,5,'Líquido Pagable ('.$_SESSION['PDF_moneda'].'):   ',0,0,'R');
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(45,5,number_format($monto-$multas-$_SESSION['PDF_desc_garantia']-$_SESSION['PDF_desc_anticipo']-$_SESSION['PDF_descuentos'],2,'.',','),0,1,'R');
		
		$pdf->ln(10);
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(180,5,'DETALLE DE APROPIACIÓN',0,1,'C'); 
		
		$data=array();
		$data=$_SESSION['PDF_EP_solicitud'];
		
		 $pdf->SetFillColor(200,200,200);
		$pdf->SetDrawColor(255,255,255);
		$pdf->SetLineWidth(0.5);

foreach ($data as $linea){
	$pdf->ln(5);
	$pdf->SetDrawColor(0,0,0);
	$pdf->SetLineWidth(0.2);
	$pdf->Cell(190,0,'','T',1,'C');
	$pdf->SetDrawColor(255,255,255);
	$pdf->ln(5);
	
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(25,4,'Unidad Organizacional:',0,0);
	$pdf->SetFont('Arial','',6);
	$y=$pdf->GetY();
	$pdf->MultiCell(70,4,''.$linea['nombre_unidad'].'',1,'L',1); 
	
	$pdf->SetXY(115,$y);
	
	
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(25,4,'Programa:',0,0);
	$pdf->SetFont('Arial','',6);
	$pdf->MultiCell(70,4,''.$linea['nombre_programa'].'',1,'L',1);
	
	
	
	
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(25,4,'Regional:',0,0); 
	$pdf->SetFont('Arial','',6);
	$y=$pdf->GetY();
	$pdf->MultiCell(70,4,''.$linea['nombre_regional'].'',1,'L',1);
	$pdf->SetXY(115,$y);
	
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(25,4,'Sub-programa/Proyecto:',0,0);
	$pdf->SetFont('Arial','',6);
	$pdf->MultiCell(70,4,''.$linea['nombre_proyecto'].'',1,'L',1);
	
	
	
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(25,4,'Financiador:',0,0); 
	$pdf->SetFont('Arial','',6);
	$y=$pdf->GetY();
	$pdf->MultiCell(70,4,''.$linea['nombre_financiador'].'',1,'L',1);
	
	
	$pdf->SetXY(115,$y);
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(25,4,'Actividad:',0,0);
	$pdf->SetFont('Arial','',6);
	$pdf->MultiCell(70,4,''.$linea['nombre_actividad'].'',1,'L',1); 
	
	
	
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(25,4,'Partida Presupuestaria:',0,0); 
	$pdf->SetFont('Arial','',6);
	$y=$pdf->GetY();
	$pdf->MultiCell(70,4,''.$linea['nombre_partida'].'',1,'L',1);
	
	
	$pdf->SetXY(115,$y);
	$pdf->SetFont('Arial','B',6);
	$pdf->Cell(25,4,'Importe:',0,0);
	$pdf->SetFont('Arial','',6);
	$pdf->MultiCell(70,4,''.number_format($linea['monto_moneda_cotizada'],2).'',1,'L',1); 
	
}
$pdf->SetFont('Arial','',10); 	 
/*$y=$pdf->GetY();
$posy1=$y;
if($_SESSION['PDF_tipo_adq']=='Bien'){
$data=array("\n\n\n\n____________________________"."\n"."Jefe División \nDe Bienes",
			"\n\n\n\n____________________________"."\n"."Jefe Depto. \nDe Bienes y Servicios"
			);
}else {
	$data=array("\n\n\n\n____________________________"."\n"."Jefe División \nDe Servicios",
			"\n\n\n\n____________________________"."\n"."Jefe Depto. \nDe Bienes y Servicios"
			);
}

$pdf->SetFont('Arial','',8); 
$pdf->SetWidths(array(95,100,));
$pdf->SetAligns(array('C','C','C'));
$pdf->SetVisibles(array(1,1,1));
$pdf->SetFontsSizes(array(10,10,10));
$pdf->SetSpaces(array(4,4,4));
$pdf->SetDecimales(array(0,0,0));
$pdf->MultiTabla($data,1,0,4,10);

*/

$y=$pdf->GetY();
$posy1=$y;
if($_SESSION['PDF_tipo_adq']=='Bien'){
$data=array("\n\n\n\n____________________________"."\n"."",
			"\n\n\n\n____________________________"."\n".""
			);
}else {
	$data=array("\n\n\n\n____________________________"."\n"."",
			"\n\n\n\n____________________________"."\n".""
			);
}

$pdf->SetFont('Arial','',8); 
$pdf->SetWidths(array(95,100,));
$pdf->SetAligns(array('C','C','C'));
$pdf->SetVisibles(array(1,1,1));
$pdf->SetFontsSizes(array(10,10,10));
$pdf->SetSpaces(array(4,4,4));
$pdf->SetDecimales(array(0,0,0));
$pdf->MultiTabla($data,1,0,4,10);



/*



if($_SESSION['PDF_tipo_adq']=='Bien'){
	$pdf->MultiCell(95,4,"\n\n\n\n____________________________"."\n"."Jefe División \nDe Bienes",'','C',0);
}
else
{
	$pdf->MultiCell(95,4,"\n\n\n\n____________________________"."\n"."Jefe División \nDe Servicios",'','C',0); 
}

//echo $y."dddd".$pdf->bMargin();
//exit;
//$pdf->Ln(25);
$altura=$pdf->h;
$margen_inf=$pdf->lMargin;
$tope_inf=$altura-$margen_inf;

//print_r($tope_inf."****".$y);
//exit;
if(($tope_inf-$y)<$margen_inf){
	$pdf->SetXY(95,($altura-$y-25));
}else{
	$pdf->SetXY(95,$y);
}
//
$pdf->MultiCell(100,4,"\n\n\n\n____________________________"."\n"."Jefe Depto. \nDe Bienes y Servicios",'','C',0); 

*/
	    
$pdf->Output();
?>