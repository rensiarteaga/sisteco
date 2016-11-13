<?php

session_start();
/* Autor: Ana Maria villegas
 * Fecha ultima de modificación: 03/06/2009
 */

require('../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
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
    $this->Image('../../../lib/images/logo_reporte.jpg',170,2,35,15);
    $this->Ln(10);
}
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
  $fecha=date("d-m-Y");
	$hora=date("h:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
   	   // $this->Cell(200,0.2,'',1,1);
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


}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,7);

$pdf-> AddFont('Arial','','arial.php');

$pdf->SetMargins(5,5,5);
$pdf->SetFont('Arial','B',16);

//Títulos de las columnas
$pdf->Cell(185,5,'LISTA DE COMPRAS',0,1,'C');
$pdf->Ln(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,5,'Cod Proceso:',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(75,5,''.$_SESSION['PDF_codigo_proceso'].'',0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,5,'Moneda:',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(75,5,''.$_SESSION['PDF_nombre_moneda'].'',0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,5,'Categoria:',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(75,5,''.$_SESSION['PDF_nombre'].'',0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,5,'Num Proceso:',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(75,5,''.$_SESSION['PDF_num_proceso'].'',0,1);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(50,5,'Num Convocatoria:',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(55,5,''.$_SESSION['PDF_num_convocatoria'].'',0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(30,5,'Gestion:',0,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(75,5,''.$_SESSION['PDF_gestion'].'',0,1);
$pdf->SetFont('Arial','B',10);
/*$pdf->Cell(50,5,'Num Convocatoria:',0,0);
$pdf->SetFont('Arial','',12);
$pdf->Cell(75,5,''.$_SESSION['PDF_num_convocatoria'].'',0,1);
*/
$pdf->Cell(210,0.3,'',1,1,'L',1);
$pdf->Ln(1);
$v_proceso_det=$_SESSION['PDF_proceso_det'];

for ($i=0;$i<sizeof($v_proceso_det);$i++){
 /*$y=$pdf->GetY();
 $pdf->Cell(12,3,"asdfasdf".$y,0,1);*/
$pdf->SetFont('Arial','B',8);
$pdf->Cell(25,3.5,''.$_SESSION['PDF_titulo1'].': ',0,0);
$pdf->SetFont('Arial','',8);

$pdf->MultiCell(185,3.5,$v_proceso_det[$i][4],0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(25,3.5,'Cantidad:',0,0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(57,3.5,number_format($v_proceso_det[$i][3],0),0,1);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(25,3.5,'Unidad',0,0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(57,3.5,$v_proceso_det[$i][5],0,1);

$pdf->SetFont('Arial','B',8);	
$pdf->SetWidths(array(5,15,65,65,20,20,20));
$pdf->SetAligns(array('R','R','L','L','R','R','R'));
$pdf->SetVisibles(array(1,1,1,1,1,1,1));
$pdf->SetFontsSizes(array(8,8,8,8,8,8,8));
$pdf->SetDecimales(array(0,0,0,0,0,2,2));
$pdf->SetSpaces(array(4,4,4,4,4,4,4));
/*$pdf->SetAligns(array('L','L','R','L','L'));*/

$data=$_SESSION['PDF_proceso_det_sol_'.$i];
$cdata=count($data);
$pdf->Cell(5,4,'Nro','LTR',0,'C'); 
$pdf->Cell(15,4,'Nro.','LTR',0,'C'); 
$pdf->Cell(65,4,'Unidad ','LTR',0,'C'); 
$pdf->Cell(65,4,'Solicitante','LTR',0,'C'); 
$pdf->Cell(20,4,'Cantidad ','LTR',0,'C');
$pdf->Cell(20,4,'Precio ','LTR',0,'C'); 
$pdf->Cell(20,4,'Monto ','LTR',1,'C');
$pdf->Cell(5,4,'','LBR',0,'C'); 
$pdf->Cell(15,4,'Solicitud','LBR',0,'C'); 
$pdf->Cell(65,4,'Organizacional','LBR',0,'C'); 
$pdf->Cell(65,4,'','LBR',0,'C'); 
$pdf->Cell(20,4,'Solicitada','LBR',0,'C'); 
$pdf->Cell(20,4,'Unitario','LBR',0,'C'); 
$pdf->Cell(20,4,'Aprobado','LBR',1,'C');
 
$pdf->SetFont('Arial','',8);

 for($j=0;$j<$cdata;$j++)
 {
 	$numero=$j+1;
    $pdf->MultiTabla((array_merge((array)$numero,(array)$data[$j])),1,1,4,8);
 }
$pdf->Cell(210,0.2,'',1,1);
$pdf->SetFont('Arial','',8);
$pdf->Ln(3);

}
$pdf->Output();
?>