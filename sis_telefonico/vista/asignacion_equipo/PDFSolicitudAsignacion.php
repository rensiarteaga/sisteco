<?php

session_start();

require('../../../lib/fpdf/fpdf.php');
include_once("../../control/LibModeloSistemaTelefonico.php");
define('FPDF_FONTPATH','font/');
class PDF extends FPDF
{   
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
	    //Llama al constructor de la clase padre
	    $this->FPDF($orientation,$unit,$format);
	    $this-> AddFont('Tahoma','','tahoma.php');
		$this-> AddFont('Arial','','arial.php');
 	}
 var $widths;
 var $aligns;
function Header()
{ 
    $this->Image('../../../lib/images/logo_reporte_corp.jpg',170,2,35,16);
 
    
//-----------------------Primera Solicitud

$this->SetFont('Tahoma','',10);
$this->SetLeftMargin(5);
$this->SetTopMargin(5);
 $this->SetAutoPageBreak(true,15);

$this->SetFillColor(240,244,250);
$this->SetDrawColor(255,255,255);
$this->SetLineWidth(0.5);
//numero de version  
$this->SetFont('Arial','',6);

  
  

$this->Cell(200,7,'ORIGINAL',0,1,'L'); 
$this->Ln(8);
$this->SetFont('Arial','B',12);

$this->Cell(203,5,'FORMULARIO DE ASIGNACIÓN DE EQUIPO MÓVIL ',0,1,'C');
$this->Ln(3);
$this->SetFont('Arial','B',14);
$this->Cell(203,5,''.$_SESSION['PDF_nro_asignacion'].'',0,1,'C');
$this->Ln(2);
$this->SetDrawColor(0,0,0);
$this->SetLineWidth(0);


$this->SetFont('Arial','B',8);
$this->Ln(1);
$this->Cell(203,2,'','T',1,'R');
$this->Ln(1);
$this->SetFont('Arial','B',9);
$this->Cell(30,6,'Número de Línea:',0,0);
$this->SetFont('Arial','',9);
$this->Cell(25,6,''.$_SESSION['PDF_numero_telefono'],0,1); 
$this->SetFont('Arial','B',9);
$this->Cell(30,6,'Fecha Asignación: ',0,0);
$this->SetFont('Arial','',9);
$fecha=date_format(date_create ($_SESSION['PDF_fecha_ini']),'d/m/Y');
$this->Cell(30,6,''.$fecha,0,0); 
$this->SetFont('Arial','B',9);
$this->Cell(80,6,'',0,0);
$this->Cell(23,6,'Autorización:',0,0);
$this->SetFont('Arial','',9); 
$this->Cell(30,6,''.$_SESSION['PDF_desc_correspondencia'],0,1);

$this->Ln(3);
$this->SetFont('Arial','B',9);
$this->Cell(203,6,'DETALLE DEL TELÉFONO MÓVIL','LRT',1,'C',1);
//$this->Cell(203,6,'','',1,'C',0);



$this->Cell(35,6,'CARACTERISTICA','LRT',0,'C',1);
$this->Cell(67,6,'DESCRIPCIÓN','TR',0,'C',1);
$this->Cell(35,6,'CARACTERISTICA','TR',0,'C',1);
$this->Cell(66,6,'DESCRIPCIÓN','TR',1,'C',1);

//$this->SetFillColor(246,250,255);
$this->SetFillColor(240,244,250);
$this->Cell(35,6,'Marca:','LRT',0,'L',0);
$this->SetFont('Arial','',9);
$this->Cell(67,6,''.$_SESSION['PDF_marca'],'TR',0);
$this->SetFont('Arial','B',9);
$this->Cell(35,6,'Imei:','TR',0,'',0);
$this->SetFont('Arial','',9);
$this->Cell(66,6,''.$_SESSION['PDF_imei'],'TR',1);

$this->SetFont('Arial','B',9);
$this->Cell(35,6,'Modelo:','LRT',0,'L',0);
$this->SetFont('Arial','',9);
$this->Cell(67,6,''.$_SESSION['PDF_modelo'],'TR',0);
$this->SetFont('Arial','B',9);
$this->Cell(35,6,'Sim Card:','TR',0,'L',0);
$this->SetFont('Arial','',9);
$this->Cell(66,6,''.$_SESSION['PDF_sim_card'],'TR',1);

$this->SetFont('Arial','B',9);
$this->Cell(203,6,'Accesorios:','LTR',1);
$this->SetFont('Arial','',9);
$this->MultiCell(203,6,''.$_SESSION['PDF_observaciones'],'LR',1); 
/*$this->Cell(35,6,'','LR',0); 
$this->Cell(168,6,'','R',1);
$this->Cell(35,6,'','LR',0); 
$this->Cell(168,6,'','BR',1);
*/
//$this->Ln(3);
$this->SetFont('Arial','B',9);
$this->Cell(203,6,'DETALLE DE PLAN DE LLAMADA','LRT',1,'C',1);

//$this->Cell(203,6,'','B',1,'C',0);
$this->SetFont('Arial','B',9);
$this->Cell(35,6,'CARACTERISTICA','TLR',0,'C',1);
$this->Cell(67,6,'DESCRIPCIÓN','TR',0,'C',1);
$this->Cell(35,6,'CARACTERISTICA','TR',0,'C',1);
$this->Cell(66,6,'DESCRIPCIÓN','TR',1,'C',1);



$this->Cell(35,6,'Plan Asignado:','LRT',0);
$this->SetFont('Arial','',9);
$this->Cell(67,6,''.$_SESSION['PDF_nombre'],'TR',0);
$this->SetFont('Arial','B',9);
$this->Cell(35,6,'Monto Llamadas:','TR',0);
$this->SetFont('Arial','',9);
$this->Cell(66,6,''.$_SESSION['PDF_monto_llamada'],'TR',1);

$this->SetFont('Arial','B',9);
$this->Cell(35,6,'Tipo Asignacion:','LRT',0);
$this->SetFont('Arial','',9);
$this->Cell(67,6,''.$_SESSION['PDF_tipo_asignacion'],'TR',0);
$this->SetFont('Arial','B',9);
$this->Cell(35,6,'Monto Datos:','TR',0);
$this->SetFont('Arial','',9);
$this->Cell(66,6,''.$_SESSION['PDF_monto_datos'],'TR',1);
$this->Cell(203,0.1,'','B',1);


}
//Pie de página
function Footer()
{
   
	$nombre_usuario=$_SESSION["ss_nombre_usuario"];
	
	
		/*$fecha=date_format(date_create ($_SESSION['PDF_fecha_reg']),'d-m-Y');
		$nombre_usuario=strtoupper($_SESSION["PDF_nom_usuario"]);
		list($hora1, $minut,$seg) = split('[:]', $_SESSION['PDF_hora_reg']); 
		$hora=date("H:i:s", mktime($hora1+1, $minut+32, $seg+27)); 
		*/  $this->SetFont('Arial','I',8);
			$this->SetY(-30);
			$this->MultiCell(203,4,"NOTA: A partir de la fecha de asignación, el receptor se hace único responsable del equipo y accesorios que se le entrega bajo este documento.",'','L',0);   
			$this->MultiCell(203,4,"En caso de pérdida del equipo, debe reportarse a danitza.helguero@ende.bo, para la reposición del equipo con otro de características similares o superiores. De igual forma en caso de daño al equipo o sus accesorios.",'','L',0);   
			$this->SetFont('Arial','',6);
		    $this->SetY(-10);
	   	   
   	        $this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
			$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
			$this->Cell(52,3,'',0,0,'L');
			/*$this->Cell(18,3,'Fecha Imp.: '.$fecha,0,0,'L');*/
			$this->ln(3);
			$this->Cell(70,3,'Sistema: ENDESIS - GESTEL',0,0,'L');
			$this->Cell(50,3,'',0,0,'C');
			$this->Cell(52,3,'',0,0,'L');
   	    
			/*$this->Cell(18,3,'Hora: '.$hora,0,0,'L');*/
			$this->ln(3);
			/*if($_SESSION['PDF_tipo_reporte']=='1'){
			
			if($_SESSION["ss_id_usuario"]==120){
				$this->Cell(70,3,'3798f5ca75b6787f94323bee5fdbedf3cfc76345150081242124434',0,0,'L'); //20sep11: a pedido de Erios en sol de serv. 1/101 de NValdez
			}else{
			
			
			$this->Cell(70,3,sha1($_SESSION['PDF_num_solicitud'].$_SESSION['PDF_nombre_financiador'].$_SESSION['PDF_nombre_regional'].$_SESSION['PDF_nombre_programa'].$_SESSION['PDF_nombre_proyecto'].$_SESSION['PDF_nombre_actividad'].gregoriantojd(date('m'),date('d'),date('Y')).$hora.$_SESSION['PDF_monto_total']).date('y').'0'.date('m').'1'.date('d').'2'.date('H').date('i').date('s'),0,0,'L');
			
			}
			}*/
}


//Cabecera de página

}

$pdf=new PDF();
 
$pdf->AddPage();
$poscab=0;
$poscab=$pdf->GetY();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,10);
//$pdf->SetDisplayMode(fullpage);
$Custom = new cls_CustomDBSistemaTelefonico();


$pdf->SetFont('Arial','B',9);
//$pdf->Cell(203,2,'','T',1,'C');


$pdf->SetFont('Arial','',10); 



$reformulados=array();
$contador=1;
$aux=array();
$pdf->ln(32);
$pdf->Cell(95,4,"____________________________",'',0,'C',0);
$pdf->Cell(20,4,"",'','C',0);
$pdf->Cell(90,4,"____________________________",'',1,'C',0);
$pdf->ln(0.5);
$pdf->Cell(95,4,"".$_SESSION['PDF_resp_asignacion'],'',0,'C',0);
$pdf->Cell(20,4,"",'','C',0);
$pdf->Cell(90,4,"".$_SESSION['PDF_empleado'],'',1,'C',0);

$pdf->Cell(95,4,"Responsable Asignación",'',0,'C',0);
$pdf->Cell(20,4,"",'','C',0);
$pdf->Cell(90,4,"Resp. Recepción Equipo Móvil",'',1,'C',0);

//$pdf->Cell(95,4,"____________________________"."\n".$_SESSION['PDF_empleado']."\nResp. Equipo Móvil",'','C',0);




//if($pdf->GetY()>80){
if($pdf->GetY()>230){
	//echo $pdf->GetY();
	$pdf->AddPage();
}
/*
if($_SESSION['PDF_tipo_reporte']=='1'){
	
	
	if($_SESSION['PDF_id_solicitud_compra']==18564){
		$pdf->MultiCell(195,4,"\n\n\n\n____________________________"."\n".$_SESSION['PDF_nombre_aprobacion']."\n JEFE UNIDAD JURIDICA INTERINO \nFirma Autorizada",'','C',0);
	}else{
		
	
	
	
			$pdf->MultiCell(195,4,"\n\n\n\n____________________________"."\n".$_SESSION['PDF_nombre_aprobacion']."\n".strtoupper($_SESSION['PDF_cargo_empleado_aprobador'])."\nFirma Autorizada",'','C',0); 
	}
}
*/
 


///////////////////////////////////fin de primera solicitud //////////////////////////////

$pdf->Output();
?>