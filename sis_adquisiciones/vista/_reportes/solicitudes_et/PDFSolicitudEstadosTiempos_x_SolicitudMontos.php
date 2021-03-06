<?php
session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de mod: 03/08/2009
 * Descripci�n: Se a�adi� la mayor�a de los estados al criterio de filtro a partir del componente que recibe una lista de estados.
 * **/
require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
class PDF extends FPDF
{   
	function PDF($orientation='L',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    $this-> AddFont('Arial','','arial.php');
    //Iniciaci�n de variables
    }
/*function SetNombreUO($nombre_uo)
{
    $this->nombre_uo=$nombre_uo;
}
function SetPrograma($nombre_programa)
{
    $this->nombre_programa=$nombre_programa;
}
function SetFinanciador($nombre_financiador)
{
    $this->nombre_financiador=$nombre_financiador;
}
function SetProyecto($nombre_proyecto)
{
    $this->nombre_proyecto=$nombre_proyecto;
}
function SetRegional($nombre_regional)
{
    $this->nombre_regional=$nombre_regional;
}
function SetActividad($nombre_actividad)
{
    $this->nombre_actividad=$nombre_actividad;
}

*/
function Header()
{    
    $this->Image('../../../../lib/images/logo_reporte.jpg',240,0,35,15);
    $this->Ln(5);
     $this->SetFont('Arial','B',16);
 //$this->SetX(15);
$this->Cell(0,6,'COMPRAS EN PROCESO DE '.$_SESSION['PDF_titulo'].'',0,1,'C');
$this->SetFont('Arial','B',10);
 $this->SetX(15);
//$this->Cell(150,5,'Expresado en Bs',0,1,'C');
    $this->Ln(1.5);
//CABECERA
$this->SetFont('Arial','B',7); 
$this->Cell(20,3,'Gestion',0,0,'C'); 
$this->Cell(20,3,'Fecha Inicio',0,0,'C'); 
$this->Cell(20,3,'Fecha Fin',0,0,'C'); 
$this->Cell(150,3,'Estado',0,1,'C'); 
$this->SetFont('Arial','',7);
$this->Cell(20,3,$_SESSION['PDF_gestion'],0,0,'C'); 
$this->Cell(20,3,$_SESSION['PDF_fecha_inicio'],0,0,'C'); 
$this->Cell(20,3,$_SESSION['PDF_fecha_fin'],0,0,'C'); 
$this->MultiCell(150,3,$_SESSION['PDF_estado'],0,'C'); 


$this->Ln(2);

 $this->Ln(1);
 $this->SetFont('Arial','B',7);
 $this->SetWidths(array(20,12,100,35,10,30,30,10,20));
 $this->SetFills(array(0,0,0,0,0,0,0));
 $this->SetAligns(array('R','L','L','L','L','L','L','R','R'));
 $this->SetVisibles(array(1,1,1,1,1,1,1,1,1));
 $this->SetFontsSizes(array(6,6,6,6,6,6,6,6,6));
 $this->SetFontsStyles(array('','','','','','',''));
 $this->SetDecimales(array(0,0,0,0,0,0,0,0,2));
 $this->SetSpaces(array(3,3,3,3,3,3,3,3,3));
 $this->SetFillColor(255,255,255);
 $this->SetDrawColor(0,0,0);  
 
 
 $this->SetLineWidth(0.2); 
 
// $cabecera = array('N�','Fecha','Descripci�n ',)
 
 
$this->Cell(20,3,'N�','LTR',0,'C');  
 $this->Cell(12,3,'Fecha','TR',0,'C');  
 $this->Cell(100,3,'Descripci�n ','TR',0,'C');  
 $this->Cell(35,3,'Proyecto ','TR',0,'C');  
 $this->Cell(10,3,'U.O. ','TR',0,'C');  
 $this->Cell(30,3,'Estado Solicitud','TR',0,'C');  
 $this->Cell(30,3,'Estado Solicitud ','TR',0,'C');  
 $this->Cell(10,3,'Dias','TR',0,'C'); 
 $this->Cell(20,3,'Monto','TR',1,'C'); 
 
  $this->Cell(20,3,'Sol.','LRB',0,'C');  
 $this->Cell(12,3,'Solicitud','RB',0,'C');  
 $this->Cell(100,3,'Solicitud Detalle','RB',0,'C');  
 $this->Cell(35,3,'Actividad','RB',0,'C');  
 $this->Cell(10,3,'','RB',0,'C');  
 $this->Cell(30,3,'','RB',0,'C');  
 $this->Cell(30,3,'Detalle','RB',0,'C');  
 $this->Cell(10,3,'Estado','RB',0,'C'); 
  $this->Cell(20,3,'Solicitud','RB',1,'C'); 
 $this->Ln(0.2);
}
//Pie de p�gina
function Footer()
{
    //Posici�n: a 1,5 cm del final
    $fecha=date("d-m-Y");
	$hora=date("H:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
   	   // $this->Cell(200,0.2,'',1,1);
		$this->Cell(100,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(70,3,'P�gina '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(72,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(100,3,'Sistema: ENDESIS - COMPRO',0,0,'L');
		$this->Cell(70,3,'',0,0,'C');
		$this->Cell(72,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');
      }
}

	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,7);
    $pdf->SetMargins(5,1,1);
    $pdf->AddPage();
    
 $pdf->SetWidths(array(20,12,100,35,10,30,30,10,20));
 $pdf->SetFills(array(0,0,0,0,0,0,0));
  $pdf->SetAligns(array('R','L','L','L','L','L','L','R','R'));
$pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1));
 $pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6));
 $pdf->SetFontsStyles(array('','','','','','',''));
 $pdf->SetDecimales(array(0,0,0,0,0,0,0,0,2));
 $pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3));
 $pdf->SetFillColor(255,255,255);
 $pdf->SetDrawColor(0,0,0);  
 $pdf->SetFont('Arial','B',7);
 

$v_setdetalle=$_SESSION['PDF_SETDetalle'];
 for ($i=0;$i<sizeof($v_setdetalle);$i++){
 	 $pdf->SetLineWidth(0.05);
 	 $pdf->SetDrawColor(200,200,200);
	   $pdf->MultiTabla($v_setdetalle[$i],0,3,3,6);
   }
	 $pdf->SetLineWidth(0.2); 
	  $pdf->SetDrawColor(255,255,255);
$pdf->Output();


?>