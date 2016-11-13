<?php

session_start();

require('../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
$vcom_libro_mayor=$_SESSION['PDF_libro_mayor'];
$tam_libro_mayor=count($vcom_libro_mayor);



class PDF extends FPDF
{   
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    //Iniciación de variables
    }
 //Cabecera
 var $centro;
 //var $aligns;
 /*var $fill;
 var $fill=0;*/
function SetCentro($centro)
{
    //Tableau des largeurs de colonnes
    $this->centro=$centro;
}
 
function Header()
{
	
	//$this-> AddFont('Arial','','arial.php');
$this->SetMargins(5,5,5);
$this->SetFont('Arial','B',16);
    $this->Image('../../../lib/images/logo_reporte.jpg',10,2,35,15);
    
$this->SetXY(40,4);
$this->Cell(140,10,'LIBRO MAYOR',0,0,'C');
$x=$this->GetX();
$this->SetFont('Arial','B',10);
$this->Cell(50,4,'Pagina:'.$this->PageNo(),0,1); //
$fecha = time (); 
$fecha1=date( "d/m/Y" , $fecha ); 
$hora=date( "h:i:s" , $fecha ); 
$this->SetX($x);
$this->Cell(50,4,'Fecha:'.$fecha1,0,1);
$this->SetX($x);
$this->Cell(50,4,'Hora:'.$hora,0,1);
$this->Ln(5);
//$this->SetFont('Arial','B',10);
$this->Cell(25,4,'Centro',0,0);
$this->SetFont('Arial','',10);
$this->Cell(175,4,$this->centro,0,1);
$this->SetFont('Arial','B',10);
$this->Cell(25,4,'Cuenta',0,0);
$this->SetFont('Arial','',10);

$this->MultiCell(175,4,$_SESSION['PDF_nombre_cuenta'].' '.$_SESSION['PDF_desc_cuenta'],0);
$this->SetFont('Arial','B',10);
$this->Cell(25,4,'Auxiliar',0,0);
$this->SetFont('Arial','',10);
$this->Cell(25,4,$_SESSION['PDF_nombre_auxiliar'],0,0);
$this->SetFont('Arial','B',10);
$this->Cell(25,4,'Del',0,0);
$this->SetFont('Arial','',10);
$this->Cell(25,4,$_SESSION['PDF_fecha_inicio'],0,0);
$this->SetFont('Arial','B',10);
$this->Cell(25,4,'Al',0,0);
$this->SetFont('Arial','',10);
$this->Cell(25,4,$_SESSION['PDF_fecha_fin'],0,1);
$this->SetFont('Arial','B',8);
$this->Cell(13,6,'Fecha','LTB',0);
$this->Cell(13,6,'Tipo','TB',0);
$this->Cell(13,6,'Nro','TB',0);
$this->Cell(95,6,'Descripcion','TB',0);
$this->Cell(10,6,'T/C','TB',0);
$this->Cell(20,6,'Debe','TB',0);
$this->Cell(20,6,'Haber','TB',0);
$this->Cell(20,6,'Saldo','TBR',1);
}
//Pie de página
function Footer()
  {
 $fecha=date("d-m-Y");
	$hora=date("h:i:s");
	    $this->SetY(-15);
   	    $this->SetFont('Arial','',6);
   	    $this->Cell(204,0.2,'',1,1);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - SCI',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
  }


}

$pdf=new PDF();
//esto es dependiendo si 
$pdf->SetAutoPageBreak(true,15);
//for($k=0;$k<3;$k++){

$pdf->AliasNbPages();
$centro="espero que salga esto mas el i:".$k;
$pdf->SetCentro($centro);
$pdf->AddPage();	

	

$pdf->SetWidths(array(13,13,13,95,10,20,20,20));
$pdf->SetAligns(array('L','L','L','L','R','R','R','R'));
$pdf->SetVisibles(array(1,1,1,1,1,1,1,1));
$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6));
$pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
$pdf->SetDecimales(array(0,0,0,0,2,2,2,2));
$pdf->SetSpaces(array(3,3,3,3,3,3,3,3));


$vcom_transa=$_SESSION['PDF_transaccion'];
$tam_com_transa=count($vcom_transa);
$total_debe=0;
$total_haber=0;

for($j=0;$j<$tam_com_transa;$j++){
	$pdf->MultiTabla($vcom_transa[$j],0,1,3,6);
    $total_debe=$total_debe+$vcom_transa[$j][5];
    $total_haber=$total_haber+$vcom_transa[$j][6];	
}
$pdf->Cell(204,0.2,'',1,1);
$pdf->SetFont('Arial','',7);
$pdf->Cell(144,3,'Totales:',0,0,'R');
$pdf->Cell(20,3,$total_debe,0,0,'R');
$pdf->Cell(20,3,$total_haber,0,1,'R');


//}

$pdf->Output();

?>