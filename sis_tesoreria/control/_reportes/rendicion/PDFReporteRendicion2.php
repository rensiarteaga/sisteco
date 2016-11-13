<?php

session_start();

require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
include_once("../../../control/LibModeloTesoreria.php");
class PDF extends FPDF
{   
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    //Iniciación de variables
    }
 //Cabecera
function Header()
{
	
$this-> AddFont('Arial','','arial.php');
$this->SetMargins(15,5,5);
$this->SetFont('Arial','B',16);
$this->Image('../../../../lib/images/logo_reporte.jpg',10,2,35,15);
$this->SetXY(60,5);
//$this->Cell(50,15,'',0,0,'L');
$this->Cell(42,15,'RENDICIÓN DE ',0,0,'L');
if ($_SESSION['PDF_tipo_caja']==1) {$this->Cell(80,15,' CAJA',0,0,'L');} 
if ($_SESSION['PDF_tipo_caja']==2) {$this->Cell(80,15,' CAJA CHICA',0,0,'L');} 
if ($_SESSION['PDF_tipo_caja']==3) {$this->Cell(80,15,' FONDO ROTATORIO',0,0,'L');} 
$x=$this->GetX();
$this->SetFont('Arial','B',10);
$this->SetXY(40,17);
$this->Cell(140,5,'Expresado en '.$_SESSION['PDF_nombre_moneda'],0,1,'C');
$this->SetX(40);
$this->Cell(140,5,'Del: '.cambiarFormatoFecha2($_SESSION['PDF_fecha_regis']).'  Al: '.cambiarFormatoFecha2($_SESSION['PDF_fecha_actual']),0,1,'C');
$this->Ln(5);
$this->SetFont('Arial','B',10);
$this->Cell(17,5,'Cajero: ',0,0);
$this->SetFont('Arial','',8);
$this->Cell(0,5,$_SESSION['PDF_nombre_completo'],0,1);
$this->SetFont('Arial','B',10);
$this->Cell(40,5,'Unidad Organizacional: ',0,0);
$this->SetFont('Arial','',8);
$this->Cell(30,5,$_SESSION['PDF_nombre_unidad'],0,1);
$this->SetFont('Arial','B',8);
//cabecera del detalle
$this->Cell(10,7,'Nro.','1',0);
$this->Cell(20,7,'FECHA','1',0);
$this->Cell(110,7,'DETALLE','1',0);
$this->Cell(25,7,'Debe','1',0,'C');
$this->Cell(25,7,'Haber','1',1,'C');
$this->SetFont('Arial','',8);
$this->Cell(10,7,'0','LTR',0,'R');
$this->Cell(20,7,$_SESSION['PDF_fecha_regis'],'LTR',0,'C');
$this->Cell(110,7,'Reposición de ','LTR',0);
$this->Cell(25,7,number_format($_SESSION['PDF_importe_regis'],2),'LTR',0,'C');
$this->Cell(25,7,' ','LTR',1,'C');
$y=$this->GetY();
}
//Pie de página
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
}
function cambiarFormatoFecha2($fecha){
    list($anio,$mes,$dia)=explode("-",$fecha);
    return $dia."/".$mes."/".$anio;
} 
function cambiarFormatoFecha($fecha){
    list($anio,$mes,$dia)=explode("-",$fecha);
    return $mes."/".$dia."/".$anio;
}  
$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,43);
$pdf->SetMargins(15,5,5);
//$pdf-> AddFont('Arial','','arial.php');
//$pdf-> AddFont('Tahoma','','tahoma.php');
//$pdf-> AddFont('Helvetica','','helvetica.php');
$Custom = new cls_CustomDBTesoreria();
$pdf->SetFont('Arial','B',8);	
//cabecera del detalle
$suma=0;
$data=$_SESSION['PDF_rendicion_reposicion'];

foreach ($data as $linea){	
$pdf->SetFont('Arial','',8); 
$pdf->SetWidths(array(10,20,110,25,25));
$pdf->SetAligns(array('R','C','L','R','R'));
$pdf->SetVisibles(array(1,1,1,1,1));
$pdf->SetFontsSizes(array(8,8,8,8,8));
$pdf->SetDecimales(array(0,0,0,0,2));
$sortcol='fecha_documento';
$sortdir='asc';
$cant='100';
$puntero='0';
$fecha_regis=cambiarFormatoFecha($_SESSION['PDF_fecha_regis']);
$id_caja=$_SESSION['PDF_id_caja'];



//$criterio_filtro= " CAJA.id_caja=$id_caja AND CAJREG.fecha_regis between ''$fecha_regis'' AND CURRENT_DATE";	
$criterio_filtro= "( CAJREG.tipo_regis=3 and CAJREG.fk_id_caja_regis in 
		( select CAJR.id_caja_regis from tesoro.tts_caja_regis CAJR where CAJR.tipo_regis=2 and
		CAJR.estado_regis=4 and CAJR.fk_id_caja_regis is null and  CAJA.id_caja=$id_caja )) or ( CAJREG.tipo_regis=4 and CAJREG.estado_regis=4 and  CAJA.id_caja=$id_caja ) ";	

$rendicion_det = $Custom-> ListarReporteRendicionReposicion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	$hijo=$Custom->salida;
	$cdata=count($hijo);
	//echo $cdata;exit;
	 for($i=0;$i<$cdata;$i++)
	 {
	   $pdf->MultiTabla($hijo[$i],1,1);
	   $suma=$suma+$hijo[$i][4];
	 }
	 $pdf->Cell(180,0,'','1',1,'C');

}

$total_entregado =$_SESSION['PDF_importe_regis'];
$pdf->Cell(130,5,'Sumas parciales','LT',0,'L');
$pdf->Cell(30,5,miformato($total_entregado),'T',0,'R');
$pdf->Cell(30,5,miformato($suma),'RT',1,'R');  
$pdf->Cell(130,5,"Saldo a favor (empresa - funcionario)",'L',0,'L');

$resta=$total_entregado-$suma;
$resta1=$suma-$total_entregado;
if($resta<0){
	$resta='';
}
if($resta1<0){
	$resta1='';
}
$pdf->Cell(30,5,miformato($resta1,2),'',0,'R');
$pdf->Cell(30,5,miformato($resta,2),'R',1,'R');  
$pdf->Cell(130,5,'Sumas Iguales','LB',0,'L');
$pdf->Cell(30,5,miformato($total_entregado+$resta1),'TB',0,'R');
$pdf->Cell(30,5,miformato($suma+$resta),'RTB',1,'R');
function miformato($cadena){
	if($cadena==''){
		return '';
	}
	else{
		return number_format($cadena,2);
	}
}
$pdf->SetFont('Arial','',8); 
$data=array(
"Firma Interesado:\n\n\n\n__________________________\n".$_SESSION['PDF_nombre_completo']."\n".$_SESSION['PDF_nombre_unidad'],
"Firma Autorizada:\n\n\n\n__________________________\n".$_SESSION['PDF_nombre_geren']."\n".$_SESSION['PDF_nombre_cargo'],
"Contador:\n\n"."\n\n___________________________\n\n",
"Auxiliar Contable:\n\n"."\n\n_________________________\n\n");

$pdf->SetFont('Arial','',8); 
$pdf->SetWidths(array(47.5,47.5,47.5,47.5));
$pdf->SetAligns(array('C','C','C','C'));
$pdf->SetVisibles(array(1,1,1,1));
$pdf->SetFontsSizes(array(8,8,8,8));
$pdf->SetDecimales(array(0,0,0,0));
$pdf->MultiTabla($data,1,3);

$pdf->Output();
?>