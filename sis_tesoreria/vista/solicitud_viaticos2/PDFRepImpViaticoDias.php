<?php

session_start();
/**Autor: Ana María Villegas Quispe
 * Fecha Mod: 25/07/2014
 * Desc:   Reporte deFondos Rotatorios
 
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
 
 //Cabecera
function Header()
{
	$this->Image('../../../lib/images/logo_reporte.jpg',180,5,36,10);  //horizontal
	$this->SetFont('Arial','B',12);//tifo de fuente
	$this->Ln(3);//salto de linea
	$this->Cell(0,7,'ESTADO DE CUENTAS DE EMPLEADOS Y VIATICOS',0,1,'C'); //dibuja una celad con contenido y orientacion  x, y
	
	$this->SetFont('Arial','B',6);
	$this->Cell(20,7,'Fecha Inicio:',0,0,'L');
	$this->Cell(20,7,$_SESSION["fecha_inicio"],0,0,'L');
	$this->Cell(20,7,'Fecha Fin:',0,0,'L');
	$this->Cell(20,7,$_SESSION["fecha_fin"],0,1,'L');
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
$v_detalle= $_SESSION['PDF_detImpViaticoDias'];	

$pdf->SetFont('Arial','',8);	
$pdf->SetWidths(array(15,15,15,15,20,0,110,15));
 $pdf->SetAligns(array('L','L','R','R','L','R','L','R','R'));
 $pdf->SetVisibles(array(1,1,1,1,1,0,1,1));
 $pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6));
$pdf->SetDecimales(array(0,0,0,0,0,0,2,2));
 $pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3));
$nombre='';
 $suma_viatico_emp=0;
 $suma_viatico_emp_tot=0;
 $suma_viatico_dias_ant=0;
 $suma_viatico_dias_act=0;
 for($j=0;$j<count($v_detalle);$j++){
 	//$v_detalle_suma=$v_detalle_suma+$v_detalle[$j][7];
 	 
 	if ($nombre!=$v_detalle[$j]["nombre_completo"])
 	{  
 		if ($j!=0){
 			$pdf->SetFont('Arial','B',6);
 			$pdf->Cell(30,3,'Total Dias',1,0,'R');
 			$pdf->Cell(15,3,$suma_viatico_dias_ant,1,0,'R');
 			$pdf->Cell(15,3,$suma_viatico_dias_act,1,0,'R');
 			$pdf->Cell(130,3,'Total Importe',1,0,'R');
 			$pdf->Cell(15,3,number_format($suma_viatico_emp,2),1,1,'R');
 		}
 		$pdf->SetFont('Arial','B',5);
 		$pdf->Cell(0,4,'Empleado: '.$v_detalle[$j]["nombre_completo"],0,1,'L');
 		
 		$pdf->Cell(15,2,'Fecha','LTR',0,'C');
 		$pdf->Cell(15,2,'Fecha','LTR',0,'C');
 		$pdf->Cell(15,2,'Dias','LTR',0,'C');
 		$pdf->Cell(15,2,'Dias','LTR',0,'C');
 		$pdf->Cell(20,2,'Nro.','LTR',0,'C');
 		$pdf->Cell(110,2,'Concepto','LTR',0,'C');
 		$pdf->Cell(15,2,'Imp.','LTR',1,'C');
 		
 		$pdf->Cell(15,2,'Inicio','LBR',0,'C');
 		$pdf->Cell(15,2,'Fin','LBR',0,'C');
 		$pdf->Cell(15,2,'Periodo Ant.','LBR',0,'C');
 		$pdf->Cell(15,2,'Periodo Act.','LBR',0,'C');
 		$pdf->Cell(20,2,'Viatico','LBR',0,'C');
 		$pdf->Cell(110,2,'','LBR',0,'C');
 		$pdf->Cell(15,2,'Viatico','LBR',1,'C');
 		
 		$nombre=$v_detalle[$j]["nombre_completo"];
 		$suma_viatico_emp=0;
 		$suma_viatico_dias_ant=0;
 		$suma_viatico_dias_act=0;
 	}
 	$suma_viatico_emp=$suma_viatico_emp+ $v_detalle[$j]["importe_viatico"];
 	$suma_viatico_dias_ant=$suma_viatico_dias_ant+$v_detalle[$j]["cant_dias_periodo_ant"];
 	$suma_viatico_dias_act=$suma_viatico_dias_act+$v_detalle[$j]["cant_dias_periodo_act"];
 	$suma_viatico_emp_tot=$suma_viatico_emp_tot+ $v_detalle[$j]["importe_viatico"];
 	$pdf->MultiTabla($v_detalle[$j],0,3,3,6);
 
 }
 $pdf->SetFont('Arial','B',6);
 $pdf->Cell(190,3,'Total',1,0,'R');
 $pdf->Cell(15,3,number_format($suma_viatico_emp,2),1,1,'R');
 
 $pdf->Cell(190,3,'Total General',1,0,'R');
 $pdf->Cell(15,3,number_format($suma_viatico_emp_tot,2),1,1,'R');
$pdf->Output();
?>


 