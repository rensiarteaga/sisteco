<?php
/* Autor: Ana Maria Villegas
 * Descripción: Reporte de Comprobantes 
 * Fecha Ultima Modificación vap: 29/07/2009
 * Fecha Ultima Modificación a: 20/08/2009
*/
session_start();
require('../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
class PDF extends FPDF
{   function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    $this-> AddFont('Arial','','arial.php');
    //Iniciación de variables
    }
 
function Header()
{	$this->SetMargins(5,5,5);
    $this->SetFont('Arial','B',16);
    $this->Image('../../../lib/images/logo_reporte.jpg',2,2,35,15);
    
//$this->SetXY(40,5);
$this->Cell(210,15,'LIBRO DIARIO',0,0,'C');
$x=$this->GetX();
$this->SetFont('Arial','B',8);
$this->SetXY($x-30,0);
$this->Cell(50,4,'Depto:'.$_SESSION['PDF_nombre_depto'],0,1); //
$this->SetX($x-30);
$this->Cell(50,4,'Pagina:'.$this->PageNo(),0,1); //
$fecha = time (); 
$fecha1=date( "d/m/Y" , $fecha ); 
$hora=date( "h:i:s" , $fecha ); 
$this->SetX($x-30);
$this->Cell(50,4,'Fecha:'.$fecha1,0,1);
$this->SetX($x-30);
$this->Cell(50,4,'Hora:'.$hora,0,1);
$this->SetFont('Arial','',8);
$this->Cell(210,4,'(Expresado en '.$_SESSION['PDF_simbolo'].')',0,1,'C');
$this->Cell(210,4,'Del:'.$this->cambioFecha($_SESSION['PDF_fecha_inicio']).'  Al '.$this->cambioFecha($_SESSION['PDF_fecha_fin']).'',0,1,'C');
 
if ($this->PageNo()!=1){
		$this->Cell(210,0.02	,'',1,1);	
			
		}



}
//Pie de página
function Footer()
{
  if ($this->PageNo()!='{nb}'){
		$this->Cell(210,0.02	,'',1,1);	
			
		}
  $fecha=date("d-m-Y");
	$hora=date("H:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
   	
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS -COMPRO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');			
  
}

function cambioFecha($fecha_completa){
$dia=substr($fecha_completa,0,2);
$mes=substr($fecha_completa,3,2);
$anio=substr($fecha_completa,6,4);
$fecha=$dia.'/'.$mes.'/'.$anio;	
return $fecha;
}
}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,7);

$pdf->SetFont('Arial','',8);

$vcomprobante=$_SESSION['PDF_comprobante'];
$tam_compbte=count($vcomprobante);
$pdf->SetFont('Arial','B',6);
for($i=0;$i<$tam_compbte;$i++){
	
	$fecha_completa=$_SESSION['PDF_fecha_cbte_'.$i];
$dia=substr($fecha_completa,8,2);
$mes=substr($fecha_completa,5,2);
$anio=substr($fecha_completa,0,4);
$fecha=$dia.'/'.$mes.'/'.$anio;

$pdf->Ln(3);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(15,3.5,'Fecha Cbte:',0,0);
$pdf->SetFont('Arial','',6);
$pdf->Cell(15,3.5,$fecha,0,0);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(10,3.5,'Nro Cbte:',0,0);
$pdf->SetFont('Arial','',6);
$pdf->Cell(15,3.5,$_SESSION['PDF_nro_cbte_'.$i],0,0);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(10,3.5,'Prefijo:',0,0);
$pdf->SetFont('Arial','',6);
$pdf->Cell(20,3.5,$_SESSION['PDF_prefijo_'.$i],0,0);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(10,3.5,'T/C',0,0);
$pdf->SetFont('Arial','',6);


if($_SESSION['PDF_cheque_'.$i]!=''){
$pdf->Cell(20,3.5,$_SESSION['PDF_max_tc_'.$i],0,0);
$pdf->SetFont('Arial','B',6);	
$pdf->Cell(15,3.5,'Nro Cheque:',0,0);
$pdf->SetFont('Arial','',6);	
$pdf->Cell(20,3.5,$_SESSION['PDF_cheque_'.$i],0,1);	
}else{
$pdf->Cell(20,3.5,$_SESSION['PDF_max_tc_'.$i],0,1);	
}
$pdf->SetFont('Arial','B',6);

$cabecera =array();
$cabecera[0][0]='Acreedor:';
$cabecera[0][1]=$_SESSION['PDF_nombre_acreedor_'.$i];
$cabecera[0][2]='Pedido:';
$cabecera[0][3]=$_SESSION['PDF_pedido_'.$i];

$cabecera[1][0]='Operación:';
$cabecera[1][1]=$_SESSION['PDF_concepto_cbte_'.$i];
$cabecera[1][2]='Aprobación:';
$cabecera[1][3]=$_SESSION['PDF_aprobacion_'.$i];



$pdf->SetWidths(array(15,100,15,80));

$pdf->SetVisibles(array(1,1,1,1));
$pdf->SetFonts(array('Arial','Arial','Arial','Arial'));
$pdf->SetFontsSizes(array(6,6,6,6));
$pdf->SetFontsStyles(array('B','','B',''));
$pdf->SetSpaces(array(3.5,3.5,3.5,3.5));
$pdf->SetAligns(array('L','L','L','L'));


for ($o=0;$o<sizeof($cabecera);$o++){
  $pdf->MultiTabla($cabecera[$o],1,0,3.5,6);
 }

//aqui  empiezanlos datos  de transacciones
$vtransacciones=$_SESSION['PDF_transaccion_'.$i];				       
$tam_transaccion=count($vtransacciones);
/*echo $vtransacciones[0][5];
exit;*/
$pdf->SetFont('Arial','B',8);
//cabecera del detalle
$pdf->Cell(105,7,'DETALLE','LTB',0,'C');
$x=$pdf->GetX();
$y=$pdf->GetY();
$pdf->Cell(25,3.5,$_SESSION['PDF_simbolo'],'TBL',1,'C');
$pdf->SetX($x);
$pdf->Cell(25,3.5,'Ejecución','TBL',0,'C');
 $vdebe=$_SESSION['PDF_transaccion_debe'];
 $pdf->SetXY($x+25,$y);
$x=$pdf->GetX();
$y=$pdf->GetY();
$pdf->Cell(40,3.5,$vtransacciones[0][5],1,1,'C');
$pdf->SetX($x);
$pdf->Cell(20,3.5,'Debe',1,0,'C');
$pdf->Cell(20,3.5,'Haber',1,1,'C');
$pdf->SetXY($x+40,$y);
$x=$pdf->GetX();
$y=$pdf->GetY();
$pdf->Cell(40,3.5,$_SESSION['PDF_simbolo'],1,1,'C');
$pdf->SetX($x);
$pdf->Cell(20,3.5,'Debe',1,0,'C');
$pdf->Cell(20,3.5,'Haber',1,1,'C');

$pdf->SetFont('Arial','',6);
$suma_total_debe=0;
$suma_total_haber=0;
$suma_total_debe_cs=0;
$suma_total_haber_cs=0;
for($j=0;$j<$tam_transaccion;$j++){
//$pdf->ln(1);
$pdf->SetLineWidth(0.05);
    //$pdf->SetDrawColor(200,200,200);
             
$pdf->Cell(105,1,'','RL',0);
$pdf->Cell(25,1,'','RL',0);
$pdf->Cell(20,1,'','RL',0);
$pdf->Cell(20,1,'','RL',0);
$pdf->Cell(20,1,'','RL',0);
$pdf->Cell(20,1,'','RL',1);



$detalle_trans=array();
$detalle_trans[0][0]=$vtransacciones[$j][1];
$detalle_trans[0][1]='';
$detalle_trans[0][2]='';
$detalle_trans[0][3]='';
$detalle_trans[0][4]='';
$detalle_trans[0][5]='';

if(($vtransacciones[$j][3])==''){
$detalle_trans[1][0]= $vtransacciones[$j][2];
$detalle_trans[1][1]= '';
$detalle_trans[1][2]= '';
$detalle_trans[1][3]= '';
$detalle_trans[1][4]= '';
$detalle_trans[1][5]= '';

$detalle_trans[2][0]= $vtransacciones[$j][11];
$detalle_trans[2][1]= $vtransacciones[$j][4];
$detalle_trans[2][2]= $vtransacciones[$j][7];
$detalle_trans[2][3]= $vtransacciones[$j][6];
$detalle_trans[2][4]= $vtransacciones[$j][9];
$detalle_trans[2][5]= $vtransacciones[$j][10];


}else{
$detalle_trans[1][0]= $vtransacciones[$j][2];
$detalle_trans[1][1]= '';
$detalle_trans[1][2]= '';
$detalle_trans[1][3]= '';
$detalle_trans[1][4]= '';
$detalle_trans[1][5]= '';
	
$detalle_trans[2][0]= $vtransacciones[$j][3];
$detalle_trans[2][1]= '';
$detalle_trans[2][2]= '';
$detalle_trans[2][3]= '';
$detalle_trans[2][4]= '';
$detalle_trans[2][5]= '';

$detalle_trans[3][0]= $vtransacciones[$j][11];
$detalle_trans[3][1]= $vtransacciones[$j][4];
$detalle_trans[3][2]= $vtransacciones[$j][7];
$detalle_trans[3][3]= $vtransacciones[$j][6];
$detalle_trans[3][4]= $vtransacciones[$j][9];
$detalle_trans[3][5]= $vtransacciones[$j][10];
}


//fin de la cabecera del detalle

$pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial')); 
$pdf->SetVisibles(array(1,1,1,1,1,1));
$pdf->SetFontsSizes(array(6,6,6,6,6,6));
$pdf->SetSpaces(array(3,3,3,3,3,3));
$pdf->SetWidths(array(105,25,20,20,20,20));
$pdf->SetDecimales(array(0,2,2,2,2,2));
$pdf->SetAligns(array('L','R','R','R','R','R'));
$pdf->SetFontsStyles(array('','','','','',''));

for ($a=0;$a<sizeof($detalle_trans);$a++){
	
	$pdf->Multitabla($detalle_trans[$a],0,1,3,6);
}
$suma_total_debe=$suma_total_debe+$vtransacciones[$j][9];
$suma_total_haber=$suma_total_haber+$vtransacciones[$j][10];
$suma_total_debe_cs=$suma_total_debe_cs+$vtransacciones[$j][7];
$suma_total_haber_cs=$suma_total_haber_cs+$vtransacciones[$j][6];
}
$pdf->SetFont('Arial','',6);
//$pdf->SetX(135);
$pdf->Cell(105,2,'','RL',0,'R');
$pdf->Cell(25,2,'','RL',0,'R');
$pdf->Cell(20,2,'- - - - - - - - - - -','RL',0,'R');
$pdf->Cell(20,2,'- - - - - - - - - - -','RL',0,'R');
$pdf->Cell(20,2,'- - - - - - - - - - -','RL',0,'R');
$pdf->Cell(20,2,'- - - - - - - - - - -','RL',1,'R');
$pdf->SetFont('Arial','BI',6);
//$pdf->SetX(110);
$pdf->Cell(105,4,'TOTAL:','RL',0,'R');
$pdf->Cell(25,4,'','RL',0,'R');
$pdf->Cell(20,4,number_format($suma_total_debe_cs,2),'RL',0,'R');
$pdf->Cell(20,4,number_format($suma_total_haber_cs,2),0,'RL',0,'R');
$pdf->Cell(20,4,number_format($suma_total_debe,2),'RL',0,'R');
$pdf->Cell(20,4,number_format($suma_total_haber,2),'RL',1,'R');
$pdf->Cell(210,0.15,'',1,1);

//$pdf->Cell(210,0.5,'- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - ',0,1);
   $pdf->SetDrawColor(0,0,0);
$pdf->SetFont('Arial','',6);
		       
 
}

$pdf->Output();
?>