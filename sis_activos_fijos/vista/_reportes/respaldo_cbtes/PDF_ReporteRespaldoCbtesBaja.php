<?php
session_start();
/**
 * Autor:
 * Fecha de creacion:	
 * Descripción: reporte resaldo de los comprobantes de baja de activos fijos
 * **/

require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{    
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    	//ANCHO DE PAGINA VERTICALMENTE 205 
	    //Llama al constructor de la clase padre
	    $this->FPDF($orientation,$unit,$format);
	    $this-> AddFont('Arial','','arial.php');
	     
	    //Iniciación de variables    
    }   
    
	function Header() 
	{
		$array =  $_GET['cabecera'];
		
		$tmp = stripslashes($array);
	    $tmp = urldecode($tmp);
	    $tmp = unserialize($tmp);
	    	

		
		$this->Image('../../../../lib/images/logo_reporte.jpg',180,2,35,15);
		$this->Ln(5);
		
		$this->SetX(1);
	   	$this->SetFont('Arial','B',15);
	 	$this->Cell(220,3,'PROCESO DE BAJA DE ACTIVOS FIJOS',0,1,'C');
	 	$this->Ln(2);

	 	$this->Ln(6); $y_1= $this->GetY();
	 	$this->SetX(35);
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(30,3,'DEPARTAMENTO :',0,0,'L'); 
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,$tmp[1],0,1,'L');
	 	

	 	$this->SetX(35);  
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(30,3,'DETALLE PROCESO: ',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,$tmp[2],0,1,'L');
		
	 	
	 	$this->SetY($y_1);
	 	$this->SetX(120);
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(30,3,'FECHA PROCESO :',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,$tmp[0],0,1,'L');

	 	$this->Ln(6);
	 	$this->SetFont('Arial','B',6);
	 	
	 	
	 	$this->Ln(6);
	 	$this->SetX(20);
	 	
	 	
	 	/*
	 	//$this->Cell(15,3,'ID','TRL',0,'C');  //1
	 	$this->Cell(10,3,'NUM','TRL',0,'C');  //2
	 	$this->Cell(20,3,'DETALLE','TRL',0,'C');  //3
	 	$this->Cell(29,3,'DESCRIPCION','TRL',0,'C');  //4
	 	$this->Cell(34,3,' ESTRUCTURA ','TRL',0,'C');  //5
	 	$this->Cell(31,3,' CUENTA ','TRL',0,'C');  //6
	 	$this->Cell(17,3,' MONTO ','TRL',0,'C');  //7
	 	$this->Cell(20,3,'DEPRECIACION','TRL',0,'C');  //8
	 	$this->Cell(17,3,' MONTO ','TRL',0,'C');  //9
	 		 	
	 	$this->Ln(2);
	 	$this->SetX(20);
	 	//segunda linea
	 	$this->Cell(10,3,'','BRL',0,'C');  //2
	 	$this->Cell(20,3,'ACTIVO FIJO','BRL',0,'C');  //3
	 	$this->Cell(29,3,'ACTIVO FIJO','BRL',0,'C');  //4
	 	$this->Cell(34,3,'PROGRAMATICA','BRL',0,'C');  //5
	 	$this->Cell(31,3,'CONTABLE','BRL',0,'C');  //6
	 	$this->Cell(17,3,'ACTUALIZADO','BRL',0,'C');  //7
	 	$this->Cell(20,3,'ACUMULADA','BRL',0,'C');  //8
	 	$this->Cell(17,3,'ACTUAL','BRL',0,'C');  //9

	 	$this->Ln(3);
	 	$this->SetX(20);
	 	*/
	}

	//Pie de página
	function Footer()
	{
	    //Posición: a 1,5 cm del final
	    $fecha=date("d-m-Y");
		$hora=date("H:i:s");
		$this->SetY(-7);
	   	$this->SetFont('Arial','',5);
	   	$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(50,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'R');
		$this->ln(3);
		$this->Cell(100,3,'Sistema: ENDESIS - ACTIF',0,0,'L');
		$this->Cell(72,3,'',0,0,'C');
		//$this->Cell(62,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	        
     }
}

$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,7);
//$pdf->SetMargins(13,5,5);
	    
$pdf->AddPage(); 
	    
$pdf->SetFont('Arial','',5);

$pdf->SetWidths(array(40,0,0,0,21,21,21,0,0));
$pdf->SetFills(array(0,0,0,0,0,0,0,0,0));
$pdf->SetVisibles(array(1,0,0,0,1,1,1,0,0));
$pdf->SetFontsSizes(array(5,5,5,5,5,5,5,5,5));
$pdf->SetAligns(array('L','L','L','L','R','R','R','R','L'));
$pdf->SetFontsStyles(array('','','','','','','',''));
$pdf->SetDecimales(array(0,0,0,0,2,2,2,2,0));
$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3));
$pdf->SetFormatNumber(array(0,0,0,0,1,1,1,0,0));

$pdf->SetLeftMargin(20);
$detalle=$_SESSION['PDF_respaldo_cbteBaja'];

$filas=count($detalle);
$flag=true;

$cta_a=0;
$cta_s=0;

$s1=0;$s2=0;$s3=0;
$t1=0;$t2=0;$t3=0;


for ($i=0; $i<count($detalle); $i++)
{	
	$t1+=$detalle[$i][4];
	$t2+=$detalle[$i][5];
	$t3+=$detalle[$i][6];
	
	if($flag)
	{	
		
		$pdf->Ln(6); $y_1= $pdf->GetY();
		$pdf->SetX(25);
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(30,3,'TIPO ACTIVO FIJO :',0,0,'L');
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(50,3,$detalle[$i][1],0,1,'L');
				
		$pdf->SetX(25);
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(30,3,'CUENTA CONTABLE: ',0,0,'L');
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(50,3,$detalle[$i][3],0,1,'L');
		
		$pdf->SetY($y_1);
		$pdf->SetX(120);
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(30,3,'ESTRUCTURA PROGRAMÁTICA:',0,0,'L');
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(50,3,'        '.$detalle[$i][2],0,1,'L');
		
		$pdf->Ln(6);
		$pdf->SetFont('Arial','B',6);
		$pdf->SetX(55);
		//$pdf->Cell(15,3,'NUMERO','TRL',0,'C');
		$pdf->Cell(40,3,'ACTIVO','TRL',0,'C');
		$pdf->Cell(21,3,'MONTO','TRL',0,'C');
		$pdf->Cell(21,3,'DEPRECIACION','TRL',0,'C');
		$pdf->Cell(21,3,'MONTO','TRL',0,'C');
		$pdf->Ln();
		$pdf->SetX(55);
		//$pdf->Cell(15,3,'','BRL',0,'C');
		$pdf->Cell(40,3,'FIJO','BRL',0,'C');
		$pdf->Cell(21,3,'ACTUALIZADO','BRL',0,'C');
		$pdf->Cell(21,3,'ACUMULADA','BRL',0,'C');
		$pdf->Cell(21,3,'ACTUAL','BRL',0,'C');

		$pdf->Ln();
					
		$flag=false;
	}

	
	$cta_a=$detalle[$i][8];
	$cta_s=$detalle[$i+1][8];
	
	$pdf->SetX(55);
	$pdf->SetFont('Arial','',5);
	$pdf->MultiTabla($detalle[$i],0,3,4,6);
	
	if($cta_a == $cta_s)
	{
		//seguir sumando totales
		$s1 += $detalle[$i][4];
		$s2 += $detalle[$i][5];
		$s3 += $detalle[$i][6];
	}
	else 
	{
		$s1 += $detalle[$i][4];
		$s2 += $detalle[$i][5];
		$s3 += $detalle[$i][6]; 
		
		$pdf->SetX(95);
		$pdf->SetFont('Arial','B',5);
		$pdf->Cell(21,3,number_format($s1,2),'LBRT',0,'R',false);
		$pdf->Cell(21,3,number_format($s2,2),'LBRT',0,'R',false);
		$pdf->Cell(21,3,number_format($s3,2),'LBRT',0,'R',false);
		$pdf->Ln(5);
		
		$s1=0;
		$s2=0;
		$s3=0;

		if ($i < $filas -1)
		{
			$pdf->Ln(6); 
			$y_1= $pdf->GetY();
			$pdf->SetX(25);
			$pdf->SetFont('Arial','B',6);
			$pdf->Cell(30,3,'TIPO ACTIVO FIJO :',0,0,'L');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(50,3,$detalle[$i+1][1],0,1,'L');
			
			$pdf->SetX(25);
			$pdf->SetFont('Arial','B',6);
			$pdf->Cell(30,3,'CUENTA CONTABLE: ',0,0,'L');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(50,3,$detalle[$i+1][3],0,1,'L');
			
			$pdf->SetY($y_1);
			$pdf->SetX(120);
			$pdf->SetFont('Arial','B',6);
			$pdf->Cell(30,3,'ESTRUCTURA PROGRAMÁTICA:',0,0,'L');
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(50,3,'        '.$detalle[$i+1][2],0,1,'L');
			
			$pdf->Ln(6);
			$pdf->SetFont('Arial','B',6);
			$pdf->SetX(55);
	
			$pdf->Cell(40,3,'ACTIVO','TRL',0,'C');
			$pdf->Cell(21,3,'MONTO','TRL',0,'C');
			$pdf->Cell(21,3,'DEPRECIACION','TRL',0,'C');
			$pdf->Cell(21,3,'MONTO','TRL',0,'C');
			$pdf->Ln();
			$pdf->SetX(55);
			$pdf->Cell(40,3,'FIJO','BRL',0,'C');
			$pdf->Cell(21,3,'ACTUALIZADO','BRL',0,'C');
			$pdf->Cell(21,3,'ACUMULADA','BRL',0,'C');
			$pdf->Cell(21,3,'ACTUAL','BRL',0,'C');
			
			$pdf->Ln();
		}
		
	}
	if($pdf->GetY() >= 250)
	{
		$pdf->SetAutoPageBreak(true);
		$pdf->AddPage();
	}
}
$pdf->SetX(75);
$pdf->SetFont('Arial','B',5);
$pdf->Cell(20,3,'TOTALES :','LBRT',0,'R',false);
$pdf->Cell(21,3,number_format($t1,2),'LBRT',0,'R',false);
$pdf->Cell(21,3,number_format($t2,2),'LBRT',0,'R',false);
$pdf->Cell(21,3,number_format($t3,2),'LBRT',0,'R',false);

$pdf->Output();
?>