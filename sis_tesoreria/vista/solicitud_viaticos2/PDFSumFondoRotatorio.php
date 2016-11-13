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
	$this->Cell(0,7,'ESTADO DE CUENTAS DE FONDOS ROTATORIOS',0,1,'C'); //dibuja una celad con contenido y orientacion  x, y
	$this->SetFont('Arial','I',10);
	$this->Cell(10,7,'CAJA:',0,0,'L'); 
	$this->Cell(100,7,$_SESSION["caja"],0,0,'L');
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
//$pdf->SetMargins(5,5,5);
$pdf->SetFont('Arial','B',8);
$v_detalle= $_SESSION['PDF_detFondoRotatorio'];	

$pdf->Cell(50,7,'Nro Recibo:',1,0,'L'); 
$pdf->Cell(25,7,'Fecha',1,0,'L');
$pdf->Cell(25,7,'Imp. Recibido',1,0,'L');
$pdf->Cell(25,7,'Imp. Rendido',1,0,'L');
$pdf->Cell(25,7,'Imp. Reposicion',1,0,'L');
$pdf->Cell(25,7,'Imp. Impuesto',1,1,'L');
$pdf->SetFont('Arial','',8);	
$pdf->SetWidths(array(0,50,25,25,25,25,25));
 $pdf->SetAligns(array('R','L','L','R','R','R','R','R'));
 $pdf->SetVisibles(array(0,1,1,1,1,1,1));
 $pdf->SetFontsSizes(array(7,7,7,7,7,7,7,7));
$pdf->SetDecimales(array(0,0,0,2,2,2,2,2));
 $pdf->SetSpaces(array(3,3,3,3,3,3,3,3));

 

 for($j=0;$j<count($v_detalle);$j++){
 	//$v_detalle_suma=$v_detalle_suma+$v_detalle[$j][7];
 	$pdf->MultiTabla($v_detalle[$j],0,3,3,7);
 	
 	
 }

$pdf->Output();
?>


 