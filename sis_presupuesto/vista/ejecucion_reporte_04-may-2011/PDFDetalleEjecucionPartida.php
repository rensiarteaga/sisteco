<?php

session_start();

require('../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{
	function PDF($orientation='L',$unit='mm',$format='Letter')
	{
		//Llama al constructor de la clase padre
		$this->FPDF($orientation,$unit,$format);
		$this-> AddFont('Arial','','arial.php');
		//Iniciación de variables
	}
	
	//Cabecera
	function Header()
	{


		$this->SetMargins(5,1,5);
		$this->SetFont('Arial','B',14);
		
		$this->SetY(8);
		$this->Cell(0,5,'EJECUCIÓN PRESUPUESTARIA POR PARTIDA ',0,1,'C');
		$this->SetFont('Arial','I',8);
		$this->Cell(0,3,' Presupuesto de '.$_SESSION['PDF_desc_pres_r'].' Gestión '.$_SESSION['PDF_gestion_r'] ,0,1,'C');
		$this->SetFont('Arial','I',7);
		$this->Cell(0,3,' AL  '.$_SESSION['PDF_fecha_fin_pdf_r'] ,0,1,'C');
		$this->Cell(0,3,'(Expresado en '.$_SESSION['PDF_desc_moneda_r'].')',0,1,'C');
		
	    
        $this->Image('../../../lib/images/logo_reporte.jpg',240,5,35,14);
        $this->SetFont('Arial','BI',8);
		$this->Cell(20,4,'PARTIDA:',0,0);
        $this->MultiCell(250,4,''.$_SESSION['PDF_desc_partida_r'],0);
        
        
        $this->SetFont('Arial','B',6);
				

		//Títulos de las columnas
		$this->Cell(55,3.5,'DESCRIPCIÓN','LT',0,'C');	//DESCRIPCIÓN
		$this->Cell(20,3.5,'PRESUPUESTADO ','T',0,'C');	//PRESUPUESTADO
		$this->Cell(20,3.5,'TRASPASO','T',0,'C');		//TRASPASO
		$this->Cell(20,3.5,'REFORMULACION','T',0,'C');	//REFORMULACION
		$this->Cell(20,3.5,'PRESUPUESTO','T',0,'C');	//PRESUPUESTO VIGENTE
		$this->Cell(20,3.5,'COMPROMETIDO','T',0,'C');	//COMPROMETIDO
		$this->Cell(20,3.5,'DEVENGADO','T',0,'C');		//DEVENGADO
		$this->Cell(20,3.5,'PAGADO','T',0,'C');			//PAGADO
		$this->Cell(20,3.5,'SALDO POR','T',0,'C');		//SALDO POR COMPROMETER
		$this->Cell(20,3.5,'SALDO POR','T',0,'C');		//SALDO POR DEVENGAR
		$this->Cell(20,3.5,'SALDO POR','T',0,'C');		//SALDO POR PAGAR
		$this->Cell(15,3.5,'EJECUCIÓN','TR',1,'C');		//PORCENTAJE DE EJECUCIÓN
		
		$this->Cell(55,3.5,'','LB',0,'C');				//DESCRIPCIÓN
		$this->Cell(20,3.5,'','B',0,'C');				//PRESUPUESTADO
		$this->Cell(20,3.5,'','B',0,'C');				//TRASPASO
		$this->Cell(20,3.5,'','B',0,'C');				//REFORMULACION
		$this->Cell(20,3.5,'VIGENTE','B',0,'C');		//PRESUPUESTO VIGENTE
		$this->Cell(20,3.5,'','B',0,'C');				//COMPROMETIDO
		$this->Cell(20,3.5,'','B',0,'C');				//DEVENGADO
		$this->Cell(20,3.5,'','B',0,'C');				//PAGADO
		$this->Cell(20,3.5,'COMPROMETER','B',0,'C');	//SALDO POR COMPROMETER
		$this->Cell(20,3.5,'DEVENGAR','B',0,'C');		//SALDO POR DEVENGAR
		$this->Cell(20,3.5,'PAGAR','B',0,'C');			//SALDO POR PAGAR
		$this->Cell(15,3.5,'(%)','BR',1,'C');			//PORCENTAJE DE EJECUCIÓN
        
        
		//$this->Ln(4);
	}
	//Pie de página
	function Footer()
	{    
		/*if ($this->PageNo()!='{nb}'){
		$this->Cell(277,0.02	,'',1,1);	
			
		}*/
		 $fecha=date("d-m-Y");
	    $hora=date("H:i:s");
	    $this->SetY(-12);
   	    $this->SetFont('Arial','',6);
   	    $this->Cell(100,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(80,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(70,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(100,3,'Sistema: ENDESIS - PRESTO',0,0,'L');
		$this->Cell(80,3,'',0,0,'C');
		$this->Cell(70,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,1,'L');	
	}
}

	$pdf=new PDF();
	$pdf->AddPage();
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,12);
	$pdf->SetMargins(5,1,5);
	$pdf->SetFont('Arial','B',8);

		
    $pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
	$pdf->SetFontsStyles(array('','','','','','','','','','','',''));
	$pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1));
	$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6));
	$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3));
	$pdf->SetWidths(array(55,20,20,20,20,20,20,20,20,20,20,15));
	$pdf->SetDecimales(array(0,2,2,2,2,2,2,2,2,2,2,2));
	$pdf->SetFormatNumber(array(0,1,1,1,1,1,1,1,1,1,1,1));
	$pdf->SetAligns(array('L','R','R','R','R','R','R','R','R','R','R','R'));
    $v_eje_pres_partida=$_SESSION['PDF_RPPDetalle'];
    
   
    $suma1=0;
    $suma2=0;
    $suma3=0;
    $suma4=0;
    $suma5=0;
    $suma6=0;
    $suma7=0;
    $suma8=0;
    $suma9=0;
    $suma10=0;
    //$suma11=0;
    
		for ($j=0;$j<sizeof($v_eje_pres_partida);$j++)
		{
			$pdf->SetDrawColor(74,74,74);
			$pdf->SetLineWidth(0.02);
		
			$pdf->Multitabla($v_eje_pres_partida[$j],0,3,3,6,1);
			$suma1=$suma1+$v_eje_pres_partida[$j][1];//PRESUPUESTADO
			$suma2=$suma2+$v_eje_pres_partida[$j][2];//TRASPASO
			$suma3=$suma3+$v_eje_pres_partida[$j][3];//REFORMULACION
			$suma4=$suma4+$v_eje_pres_partida[$j][4];//PRESUPUESTO VIGENTE
			$suma5=$suma5+$v_eje_pres_partida[$j][5];//COMPROMETIDO
			$suma6=$suma6+$v_eje_pres_partida[$j][6];//DEVENGADO
			$suma7=$suma7+$v_eje_pres_partida[$j][7];//PAGADO
			$suma8=$suma8+$v_eje_pres_partida[$j][8];//SALDO POR COMPROMETER
			$suma9=$suma9+$v_eje_pres_partida[$j][9];//SALDO POR DEVENGAR
			$suma10=$suma10+$v_eje_pres_partida[$j][10];//SALDO POR PAGAR
			//$suma11=$suma11+$v_eje_pres_partida[$j][11];//PORCENTAJE DE EJECUCION			
		}
		
	     $pdf->SetFont('Arial','B',6);
	     $pdf->Cell(55,5,'TOTALES:',1,0,'R');
	     $pdf->Cell(20,5,number_format($suma1,2),1,0,'R');	//PRESUPUESTADO
	     $pdf->Cell(20,5,number_format($suma2,2),1,0,'R');	//TRASPASO
	     $pdf->Cell(20,5,number_format($suma3,2),1,0,'R');	//REFORMULACION
	     $pdf->Cell(20,5,number_format($suma4,2),1,0,'R');	//PRESUPUESTO VIGENTE
	     $pdf->Cell(20,5,number_format($suma5,2),1,0,'R');	//COMPROMETIDO
	     $pdf->Cell(20,5,number_format($suma6,2),1,0,'R');	//DEVENGADO
	     $pdf->Cell(20,5,number_format($suma7,2),1,0,'R');	//PAGADO
	     $pdf->Cell(20,5,number_format($suma8,2),1,0,'R');	//SALDO POR COMPROMETER
	     $pdf->Cell(20,5,number_format($suma9,2),1,0,'R');	//SALDO POR DEVENGAR
	     $pdf->Cell(20,5,number_format($suma10,2),1,0,'R');	//SALDO POR PAGAR
	     //$pdf->Cell(15,5,number_format($suma11,2),1,0,'R');	//PORCENTAJE DE EJECUCION
	     $pdf->Cell(15,5,number_format( ( 100-( ( $suma8 *100) / $suma4 ) ),2),1,0,'R');	//PORCENTAJE EJECUCION
	     $pdf->SetDrawColor(0,0,0);
		 $pdf->SetLineWidth(0.2);
	   

$pdf->Output();
?>

