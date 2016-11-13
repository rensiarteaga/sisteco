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
	function SetAuxiliar($auxiliar)
	{
	    //Tableau des largeurs de colonnes
	    $this->auxiliar=$auxiliar;
	}
 
	function Header()
	{	
		
	
		$this->Image('../../../lib/images/logo_reporte.jpg',170,0,35,13);
		$this->SetMargins(10,5,5);
		$this->SetFont('Arial','B',16);
		$this->SetX(0);
		$this->Cell(0,5,'LIBRO MAYOR',0,1,'C');
		
		$this->SetFont('Arial','',8);
		$this->SetX(0);
		$this->Cell(0,4,'Expresado en '.$_SESSION[PDF_moneda],0,1,'C');
		
		$this->SetFont('Arial','B',10);
		$this->Cell(25,4,'Departamento: ',0,0);
		
		$this->SetFont('Arial','',10);
		$this->MultiCell(175,4,$_SESSION['PDF_nombre_depto'],0,1);
		

		//$this->Ln(2);
	    $this->SetFont('Arial','B',10);
		$this->Cell(25,4,'Auxiliar:',0,0);
		
		$this->SetFont('Arial','',10);
		$this->Cell(100,4,$this->auxiliar,0,0);
		
		$this->SetFont('Arial','B',10);
		$this->Cell(10,4,'Del:',0,0);
		$this->SetFont('Arial','',10);
		$this->Cell(25,4,$_SESSION['PDF_fecha_inicio'],0,0);
		
		$this->SetFont('Arial','B',10);
		$this->Cell(10,4,'Al:',0,0);
		$this->SetFont('Arial','',10);
		$this->Cell(25,4,$_SESSION['PDF_fecha_fin'],0,1);
		
		/*$this->SetFont('Arial','B',8);
		$this->Cell(15,6,'Fecha','LTB',0);
		$this->Cell(15,6,'N° Cbte.','TB',0);
		$this->Cell(1,6,'','TB',0);
		$this->Cell(95,6,'Descripción','TB',0);
		$this->Cell(1,6,'','TB',0);
		$this->Cell(20,6,'Debe','TB',0);
		$this->Cell(20,6,'Haber','TB',0);
		$this->Cell(20,6,'Saldo','TBR',1);*/
	}

	//Pie de página
	function Footer()
	{
	 	$fecha=date("d-m-Y");
		$hora=date("h:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
   	    $this->Cell(190,0.1,'',1,1);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - CONIN',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
	  }
}

$pdf=new PDF();

$pdf->SetAutoPageBreak(true,7);
$vcom_cabecera=$_SESSION['PDF_libro_mayor'];
$tam_com_cabecera=count($vcom_cabecera);

for($k=0;$k<$tam_com_cabecera;$k++){
	$pdf->AliasNbPages();
	//$centro="espero que salga esto mas el i:".$k;
	$pdf->SetAuxiliar($vcom_cabecera[$k][2]);
	
	$pdf->AddPage();	
$pdf->SetWidths(array(15,15,0,110,0,20,20,20));
	//$pdf->SetWidths(array(15,15,1,95,1,20,20,20));
	$pdf->SetAligns(array('L','L','L','L','R','R','R','R'));
	$pdf->SetVisibles(array(1,1,0,1,0,1,1,1));
	$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6));
	$pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
	$pdf->SetDecimales(array(0,0,0,0,2,2,2,2));
	$pdf->SetSpaces(array(3,3,3,3,3,3,3,3));
		
	$vcom_transa=$_SESSION['PDF_transaccion_'.$k];
	$tam_com_transa=count($vcom_transa);
	$total_debe=0;
$total_haber=0;
$bandera_grupal='';

for ($i=0;$i<$tam_com_transa;$i++){
	if ($vcom_transa[$i]['prefijo']=='-'){
	//if ($bandera_grupal!=$vcom_transa[$i][9]){
		if($i!=0){
		$pdf->Cell(200,0.2,'',1,1);
        $pdf->SetFont('Arial','B',6);
        $pdf->Cell(140,3,'Totales:',0,0,'R');
         $pdf->Cell(20,3,number_format($suma_parcial_debe,2),0,0,'R');
		$pdf->Cell(20,3,number_format($suma_parcial_haber,2),0,1,'R');
		$suma_parcial_debe=0;
		$suma_parcial_haber=0;
		}
		
		//$pdf->Ln();
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(12,4,'Cuenta:',0,0);
		$pdf->SetFont('Arial','',8);
		$pdf->MultiCell(160,4,$vcom_transa[$i]['desc_cuenta'],0);
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(15,6,'Fecha','LTB',0);
		$pdf->Cell(15,6,'N° Cbte.','TB',0);
		$pdf->Cell(110,6,'Descripción','TB',0);
		$pdf->Cell(20,6,'Debe','TB',0);
		$pdf->Cell(20,6,'Haber','TB',0);
		$pdf->Cell(20,6,'Saldo','TBR',1);
		
		$pdf->MultiTabla($vcom_transa[$i],0,1,3,6);
		$bandera_grupal=$vcom_transa[$i][9];
		$suma_parcial_debe=$suma_parcial_debe+$vcom_transa[$i][5];
		$suma_parcial_haber=$suma_parcial_haber+$vcom_transa[$i][6];
	}else{
		$pdf->MultiTabla($vcom_transa[$i],0,1,3,6);
		$suma_parcial_debe=$suma_parcial_debe+$vcom_transa[$i][5];
		$suma_parcial_haber=$suma_parcial_haber+$vcom_transa[$i][6];
	}
	
	
}



$pdf->Cell(200,0.2,'',1,1);
        $pdf->SetFont('Arial','B',6);
        $pdf->Cell(140,3,'Totales:',0,0,'R');
        $pdf->Cell(20,3,number_format($suma_parcial_debe,2),0,0,'R');
		$pdf->Cell(20,3,number_format($suma_parcial_haber,2),0,1,'R');
		$suma_parcial_debe=0;
		$suma_parcial_haber=0;

	
	
	
	/*$total_debe=0;
	$total_haber=0;
	
	for($j=0;$j<$tam_com_transa;$j++){
		$pdf->MultiTabla($vcom_transa[$j],0,1,3,6);
	    $total_debe=$total_debe+$vcom_transa[$j][5];
	    $total_haber=$total_haber+$vcom_transa[$j][6];	
	}
	$pdf->Cell(185,0.1,'',1,1);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(124,3,'Totales:',0,0,'R');
	$pdf->Cell(20,3,$total_debe,0,0,'R');
	$pdf->Cell(20,3,$total_haber,0,1,'R');*/
}

$pdf->Output();

?>