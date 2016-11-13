<?php
/* Autor: Ana Maria Villegas
 * Descripción: Reporte de Comprobantes 
 * Fecha Ultima Modificación : 14/07/2009
*/
session_start();

require('../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{   
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $tabla=array();
    $this->FPDF($orientation,$unit,$format);
     $this-> AddFont('Arial','','arial.php');
     
    // $this->Multitabla($tabla);
    //Iniciación de variables
    }
 function SetPrograma($nombre_programa)
{
    $this->nombre_programa=$nombre_programa;
}   
 //Cabecera
function Header()
{
	

$this->SetMargins(1,5,5);
$this->SetFont('Arial','B',14);
$this->Image('../../../lib/images/logo_reporte.jpg',10,2,35,14);
$this->SetXY(45,1);
$y_cab=$this->GetY();
$this->Cell(135,7,$_SESSION['desc_clases'],0,1,'C');
$this->SetFont('Arial','',8);
$this->SetXY(45,8);
$this->MultiCell(135,4,'MOMENTO PRESUPUESTARIO:'.$_SESSION['momento_cbte'],0,'C');
$x=$this->GetX();

$this->Line(1,16,215,16);
$this->Line(45,1,45,16);
$this->Line(180,1,180,16);
$this->SetFont('Arial','B',8);
$this->SetXY($x+180,$y_cab);
//$this->SetFont('Arial','B');
$this->Cell(50,3.7,'Depto.:'. $_SESSION['PDF_cod_depto'],0,1);
$this->SetXY($x+180,$y_cab+3.7);
$this->Cell(50,3.7,'No.'.$_SESSION['PDF_nro_cbte'],0,1);
$this->SetXY($x+180,$y_cab+7.4);

$fecha_completa=$_SESSION['PDF_fecha_cbte'];
$dia=substr($fecha_completa,8,2);
$mes=substr($fecha_completa,5,2); 
$anio=substr($fecha_completa,0,4);
$fecha_cbte=$dia.'/'.$mes.'/'.$anio;
$this->Cell(50,3.7,'Fecha:'.$fecha_cbte,0,1);
$this->SetX($x+180);
$this->Cell(50,3.7,'Pagina:'.$this->PageNo(),0,1);

$this->Ln(2);

$cabecera[0][0]='Acreedor:';
$cabecera[0][1]=$_SESSION['PDF_acreedor'];
$cabecera[0][2]='Pedido:';
$cabecera[0][3]=$_SESSION['PDF_pedido'];

$cabecera[1][0]='Operación:';
$cabecera[1][1]=$_SESSION['PDF_concepto_cbte'];
$cabecera[1][2]='Conformidad:';
$cabecera[1][3]=$_SESSION['PDF_conformidad'];

$cabecera[2][0]='Aprobación:';
$cabecera[2][1]=$_SESSION['PDF_aprobacion'];
$cabecera[2][2]='T/C:';
$cabecera[2][3]=number_format($_SESSION['PDF_max_tc'],2)." ";

$cabecera[3][0]='';
$cabecera[3][1]='';
$cabecera[3][2]='Nro Cheque:';
$cabecera[3][3]=$_SESSION['PDF_cheque'];

$this->SetWidths(array(18,135,20,41));

$this->SetVisibles(array(1,1,1,1));
$this->SetFonts(array('Arial','Arial','Arial','Arial'));
$this->SetFontsSizes(array(7,7,7,7));
$this->SetFontsStyles(array('B','','B',''));
$this->SetSpaces(array(3.5,3.5,3.5,3.5));
$this->SetAligns(array('L','L','L','L'));


for ($o=0;$o<sizeof($cabecera);$o++){
  $this->MultiTabla($cabecera[$o],1,0,3.5,7);
 }
$this->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial')); 
$this->SetVisibles(array(1,1,1,1,1,1));
$this->SetFontsSizes(array(6,6,6,6,6,6));
$this->SetFontsStyles(array('','','','','',''));
$this->SetSpaces(array(3,3,3,3,3,3));
$this->SetWidths(array(109,25,20,20,20,20));
$this->SetDecimales(array(0,2,2,2,2,2));
$this->SetAligns(array('L','R','R','R','R','R'));

$this->SetFont('Arial','B',8);
//cabecera del detalle
$this->Cell(109,7,'DETALLE','LTB',0,'C');
$x=$this->GetX();
$y=$this->GetY();
$this->Cell(25,3.5,$_SESSION['PDF_simbolo'],'TBL',1,'C');
$this->SetX($x);
$this->Cell(25,3.5,'Ejecución','TBL',0,'C');
 $vdebe=$_SESSION['PDF_transaccion_debe'];
 $this->SetXY($x+25,$y);
$x=$this->GetX();
$y=$this->GetY();
$this->Cell(40,3.5,$vdebe[0][5],1,1,'C');
$this->SetX($x);
$this->Cell(20,3.5,'Debe',1,0,'C');
$this->Cell(20,3.5,'Haber',1,1,'C');
$this->SetXY($x+40,$y);
if($_SESSION['id_moneda']==1){
	$simbolo_moneda='$us.';
}else{
	$simbolo_moneda='Bs.';
}
$x=$this->GetX();
$y=$this->GetY();
$this->Cell(40,3.5,$_SESSION['PDF_simbolo'],1,1,'C');
$this->SetX($x);
$this->Cell(20,3.5,'Debe',1,0,'C');
$this->Cell(20,3.5,'Haber',1,1,'C');

$y=$this->GetY();
$this->Line(1,1,1,250);
$this->Line(1,1,215,1);
$this->Line(215,1,215,250);
$this->Line(110,$y,110,($y-7)+202.3);
$this->Line(135,$y,135,($y-7)+202.3);
//$this-> Line(125,$y-7,125,($y-7)+194.5);
$this->Line(155,$y,155,($y-7)+202.3);
$this->Line(175,$y,175,($y-7)+202.3);
$this->Line(195,$y,195,($y-7)+202.3);
$this->Line(215,$y,215,($y-7)+202.3);   
  
}
//Pie de página
function Footer()
{
$this->SetY(-35);
$this->SetFont('Arial','BI',6);
 $this->Cell(10,5,'Obs:','LT',0,1);
 $this->Cell(204,5,$_SESSION['PDF_glosa'],'RT',1);
 $vdebe=$_SESSION['PDF_transaccion_debe'];
 $vhaber=$_SESSION['PDF_transaccion_haber'];
        $suma_total_debe=0;
        $suma_total_haber=0;
    for($k1=0;$k1<sizeof($vdebe);$k1++){
    	$suma_total_debe=$suma_total_debe+$vdebe[$k1][9];
    	
    }
    
    for($l1=0;$l1<sizeof($vhaber);$l1++){
    	$suma_total_haber=$suma_total_haber+$vhaber[$l1][10];
    }
       /*echo "sd".$suma_total_debe;
       echo "sh".$suma_total_haber;
       exit;
      */ if(("$suma_total_debe")==("$suma_total_haber")){
       $this->MultiCell(214,5,'               Son: '.$this->num2letras($suma_total_debe,false,true).' '.$vdebe[0][8],'LRB');

    }else{
    	 $this->MultiCell(214,5,'          Los montos de débitos y créditos no son iguales','LRB');

    }
    
/* $this->SetFont('Arial','BI',6);
$this->Cell(59,4,'Preparado por:'.$_SESSION["ss_nombre_usuario"],1,0);
$this->Cell(55,4,'Centro Responsable',1,0,'C');
$this->Cell(50,4,'Aprobado',1,0,'C');
$this->Cell(50,4,'Aprobado',1,1,'C');
$this->Cell(59,10,'',1,0,'C');
$this->Cell(55,10,'',1,0,'C');
$this->Cell(50,10,'',1,0,'C');
$this->Cell(50,10,'',1,1,'C');
$fecha_completa=$_SESSION['PDF_fecha'];
$dia=substr($fecha_completa,8,2);
$mes=substr($fecha_completa,5,2);
$anio=substr($fecha_completa,0,4);
$fecha=$dia.'/'.$mes.'/'.$anio;
*/

$this->SetFonts(array('Arial','Arial','Arial','Arial')); 
$this->SetVisibles(array(1,1,1,1));
$this->SetFontsSizes(array(6,6,6,6));
$this->SetSpaces(array(3,3,3,3));
$this->SetWidths(array(59,55,50,50));
$this->SetDecimales(array(0,0,0,0));
$this->SetAligns(array('C','C','C','C'));




$firmas_obtenidas=$_SESSION["PDF_firmas"];
$firmas=array();
for($i=0;$i<=3;$i++)
{
$firmas[$i][0]=$firmas_obtenidas[0][$i];
$firmas[$i][1]=$firmas_obtenidas[1][$i];
$firmas[$i][2]=$firmas_obtenidas[2][$i];
$firmas[$i][3]=$firmas_obtenidas[3][$i];

}

//$pdf->Multitabla($detalle_debe[$a],0,0,3,6);

$this->MultiTabla($firmas[0],0,3,4,6);

$this->Cell(59,10,'',1,0,'C');
$this->Cell(55,10,'',1,0,'C');
$this->Cell(50,10,'',1,0,'C');
$this->Cell(50,10,'',1,1,'C');
$this->MultiTabla($firmas[1],0,3,4,6);
$this->MultiTabla($firmas[2],0,3,4,6);

/*$this->Cell(59,10,$fecha,1,0,'C');/// me falta esa fecha no se de que es
$this->Cell(55,10,'JEFE DEPTO DE CONTABILIDAD',1,0,'C');
$this->Cell(50,10,'GERENCIA FINANCIERA',1,0,'C');
$this->Cell(50,10,'GERENCIA GENERAL',1,1,'C');*/
//Estas lineas empezarán */
$this->Line(110,150,110,244.3);
$this->Line(135,150,135,244.3);
$this->Line(155,150,155,244.3);
$this->Line(175,150,175,244.3);
$this->Line(195,150,195,244.3);
$this->Line(215,150,215,244.3);  

}


}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,2);
$pdf->SetMargins(1,5,5);
//$pdf-> AddFont('Arial','','arial.php');
$pdf->SetFont('Arial','B',16);	

//Títulos de las columnas

//PARA DEBITOS
$pdf->SetFont('Arial','BI',8);
$pdf->Cell(50,5,'DEBITOS',0,1);
$vtransaccion_debe=$_SESSION['PDF_transaccion_debe'];
$tam_transaccion_debe=count($vtransaccion_debe);
$pdf->SetFont('Arial','',6);
for($j=0;$j<$tam_transaccion_debe;$j++){
$pdf->ln(1);

$detalle_debe=array();
$detalle_debe[0][0]=$vtransaccion_debe[$j][1];
$detalle_debe[0][1]='';
$detalle_debe[0][2]='';
$detalle_debe[0][3]='';
$detalle_debe[0][4]='';
$detalle_debe[0][5]='';
//$detalle_debe[1][0]= $vtransaccion_debe[$j][4];
$detalle_debe[1][0]= $vtransaccion_debe[$j][2];

if(($vtransaccion_debe[$j][3])==''){
$detalle_debe[1][0]= $vtransaccion_debe[$j][2];

$detalle_debe[1][1]= $vtransaccion_debe[$j][4];

$detalle_debe[1][2]= $vtransaccion_debe[$j][6];
$detalle_debe[1][3]= '';
$detalle_debe[1][4]= $vtransaccion_debe[$j][9];
$detalle_debe[1][5]= '';
	
}else{
$detalle_debe[1][0]= $vtransaccion_debe[$j][2];
$detalle_debe[1][1]= '';
$detalle_debe[1][2]= '';
$detalle_debe[1][3]= '';
$detalle_debe[1][4]= '';
$detalle_debe[1][5]= '';
	
$detalle_debe[2][0]= $vtransaccion_debe[$j][3];
$detalle_debe[2][1]= $vtransaccion_debe[$j][4];
$detalle_debe[2][2]= $vtransaccion_debe[$j][6];
$detalle_debe[2][3]= '';
$detalle_debe[2][4]= $vtransaccion_debe[$j][9];
$detalle_debe[2][5]= '';
}

$pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial')); 
$pdf->SetVisibles(array(1,1,1,1,1,1));
$pdf->SetFontsSizes(array(6,6,6,6,6,6));
$pdf->SetSpaces(array(3,3,3,3,3,3));
$pdf->SetWidths(array(109,25,20,20,20,20));
$pdf->SetDecimales(array(0,2,2,2,2,2));
$pdf->SetAligns(array('L','R','R','R','R','R'));


//MultiTabla($data,$nro_decimales=0,$borde=0,$stg=5,$tl=10,$fn=0)
for ($a=0;$a<sizeof($detalle_debe);$a++){
	if($pdf->GetY()>=240)
	{
		$pdf->AddPage();
	}
	$pdf->Multitabla($detalle_debe[$a],0,0,3,6);
}
$suma_total_debe=$suma_total_debe+$vtransaccion_debe[$j][9];
$suma_total_debe_cs=$suma_total_debe_cs+$vtransaccion_debe[$j][6];
}
$pdf->SetFont('Arial','',6);
$pdf->SetX(135);
$pdf->Cell(20,2,'- - - - - - - - - - - ',0,0,'R');
$pdf->Cell(20,2,'',0,0,'R');
$pdf->Cell(20,2,'- - - - - - - - - - - ',0,1,'R');
$pdf->SetFont('Arial','BI',6);
$pdf->SetX(110);
$pdf->Cell(25,4,'TOTAL DEBITOS:',0,0,'R');
$pdf->Cell(20,4,number_format($suma_total_debe_cs,2),0,0,'R');
$pdf->Cell(20,4,'',0,0,'R');
$pdf->Cell(20,4,number_format($suma_total_debe,2),0,1,'R');
$pdf->SetX(135);
$pdf->Cell(20,2,'=========== ',0,0,'R');
$pdf->Cell(20,2,'',0,0,'R');
$pdf->Cell(20,2,'=========== ',0,1,'R');
$pdf->SetFont('Arial','',6);

//PARA CREDITOS
$vtransaccion_haber=$_SESSION['PDF_transaccion_haber'];
$tam_transaccion_haber=count($vtransaccion_haber);
$suma_total_debe=0;
$suma_total_haber=0;
$suma_total_debe_cs=0;
$suma_total_haber_cs=0;
$pdf->SetFont('Arial','BI',8);
$pdf->Cell(50,5,'CREDITOS',0,1);
$pdf->SetFont('Arial','',6);
for($i=0;$i<$tam_transaccion_haber;$i++){
$pdf->ln(1);	




$detalle_haber=array();
$detalle_haber[0][0]=$vtransaccion_haber[$i][1];
$detalle_haber[0][1]='';
$detalle_haber[0][2]='';
$detalle_haber[0][3]='';
$detalle_haber[0][4]='';
$detalle_haber[0][5]='';
$detalle_haber[1][0]= $vtransaccion_haber[$i][3];
if(($vtransaccion_haber[$i][3])==''){
$detalle_haber[1][0]= $vtransaccion_haber[$i][2];
$detalle_haber[1][1]= $vtransaccion_haber[$i][4];;
$detalle_haber[1][2]= '';
$detalle_haber[1][3]= $vtransaccion_haber[$i][7];
$detalle_haber[1][4]= '';
$detalle_haber[1][5]= $vtransaccion_haber[$i][10];
	
}else{
$detalle_haber[1][0]= $vtransaccion_haber[$i][2];
$detalle_haber[1][1]= '';
$detalle_haber[1][2]= '';
$detalle_haber[1][3]= '';
$detalle_haber[1][4]= '';
$detalle_haber[1][5]= '';
	
$detalle_haber[2][0]= $vtransaccion_haber[$i][3];
$detalle_haber[2][1]= $vtransaccion_haber[$i][4]; 
$detalle_haber[2][2]= '';
$detalle_haber[2][3]= $vtransaccion_haber[$i][7];
$detalle_haber[2][4]= '';
$detalle_haber[2][5]= $vtransaccion_haber[$i][10];
}

$pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial')); 
$pdf->SetVisibles(array(1,1,1,1,1,1));
$pdf->SetFontsSizes(array(6,6,6,6,6,6));

$pdf->SetSpaces(array(3,3,3,3,3,3));
$pdf->SetWidths(array(109,25,20,20,20,20));
$pdf->SetDecimales(array(0,2,2,2,2,2));
$pdf->SetAligns(array('L','R','R','R','R','R'));



//MultiTabla($data,$nro_decimales=0,$borde=0,$stg=5,$tl=10,$fn=0)
for ($b=0;$b<sizeof($detalle_haber);$b++){
	if($pdf->GetY()>=240)
	{
		$pdf->AddPage();
	}
	$pdf->Multitabla($detalle_haber[$b],0,0,3,6);
}


$suma_total_haber=$suma_total_haber+$vtransaccion_haber[$i][10];
$suma_total_haber_cs=$suma_total_haber_cs+$vtransaccion_haber[$i][7];
}

$pdf->SetX(155);
$pdf->SetFont('Arial','',6);
$pdf->Cell(20,2,'- - - - - - - - - - - ',0,0,'R');
$pdf->Cell(20,2,'',0,0,'R');
$pdf->Cell(20,2,'- - - - - - - - - - - ',0,1,'R');
$pdf->SetFont('Arial','BI',6);
$pdf->SetX(115);

$pdf->Cell(20,4,'TOTAL CREDITOS:',0,0,'R');
$pdf->Cell(20,4,'',0,0,'R');
$pdf->Cell(20,4,number_format($suma_total_haber_cs,2),0,0,'R');	

$pdf->Cell(20,4,'',0,0,'R');
$pdf->Cell(20,4,number_format($suma_total_haber,2),0,1,'R');	
$pdf->SetX(155); 
$pdf->Cell(20,2,'=========== ',0,0,'R');
$pdf->Cell(20,2,'',0,0);
$pdf->Cell(20,2,'=========== ',0,1,'R');



$pdf->Output();
?>

 