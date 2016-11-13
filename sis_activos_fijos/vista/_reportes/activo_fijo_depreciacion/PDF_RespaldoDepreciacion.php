<?php
session_start();
/**
 * Autor:  Elmer Velasquez	
 * Fecha de creacion: 19/03/2014	
 * Descripci�n: reporte resaldo de los comprobantes de depreciacion de activos fijos
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
	     
	    //Iniciaci�n de variables    
    }   
    
	function Header() 
	{
		$fecha=date("d-m-Y");
		
		$this->Image('../../../../lib/images/logo_reporte.jpg',237,2,35,15); //LOGO
		$this->Ln(5);
		
		$this->SetX(1);
	   	$this->SetFont('Arial','B',15);
	 	$this->Cell(220,3,'DEPRECIACION DE ACTIVOS FIJOS',0,1,'C');
	 	$this->Ln(2);
	 	
	 	$cad= '  PERIODO :  '.$_SESSION['datos_respaldo'][0];
	 	$this->SetX(90);
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(6,3,'  GESTION :  '.$_SESSION['datos_respaldo'][1].'     '.$cad,0,0,'L');
	 	$this->SetFont('Arial','',6);
	 
	 	$this->Ln(2);
	 	
	 	$this->SetX(95);
	 	$this->Cell(30,3,'(Expresado en Bolivianos)',0,0,'C');
	 	
	 	
	 	$this->Ln(6); $y_1= $this->GetY();
	 	$this->SetX(35);
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(30,3,'Grupo Depreciacion:',0,0,'L'); 
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,utf8_decode($_SESSION['datos_respaldo'][6]),0,1,'L');
	 	

	 	$this->SetX(35);  
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(30,3,'Regional: ',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	if($_SESSION['datos_respaldo'][9] == 'TRA')
	 		$this->Cell(50,3,'TRA - TRANSMISI�N',0,1,'L');
	 	else	
	 		$this->Cell(50,3,utf8_decode($_SESSION["PDF_reporte_respaldo_depreciacion"][0][14]),0,1,'L');
	 	

	 	$this->SetX(35);
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(30,3,'Departamento:',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,utf8_decode($_SESSION['datos_respaldo'][2]),0,1,'L');
	 	

	 	$this->SetY($y_1);
	 	$this->SetX(120);
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(30,3,'Usuario:',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,utf8_decode($_SESSION['datos_respaldo'][3]),0,1,'L');
	 	
	 	$this->SetX(120);
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(30,3,'Proyecto:',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,utf8_decode($_SESSION['datos_respaldo'][5]),0,1,'L');
	 	
	 	
	 	$this->Ln(6);
	 	$this->SetFont('Arial','B',6);
	 	
	 	$this->SetWidths(array(15,50,25,25,25,20,25,25,25));
	 	$this->SetFills(array(0,0,0,0,0,0,0,0,0));
	 	$this->SetVisibles(array(1,1,1,1,1,0,0,0,0));
	 	$this->SetFontsSizes(array(5,5,5,5,5,5,5,5,5));
	 	$this->SetAligns(array('C','C','C','C','C','R','R','R','R'));
	 	$this->SetFontsStyles(array('','','','','','','','',''));
	 	$this->SetDecimales(array(0,0,2,2,2,2,2,2,2));
	 	$this->SetSpaces(array(3,3,3,3,3,3,3,3,3));
	 	$this->SetFormatNumber(array(0,0,1,1,1,0,0,0,0));
	 	
	 	//primera linea
	 	$this->SetX(35);
	
	}

	//Pie de p�gina
	function Footer()
	{
	    $fecha=date("d-m-Y");
		$hora=date("H:i:s");
		$this->SetLeftMargin(10);
		$this->SetY(-7);
		$this->SetFont('Arial','',5);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Pagina '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(65,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'R');
		$this->ln(3);
		$this->Cell(100,3,'Sistema: ENDESIS - ACTIF',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(35,3,'',0,0,'C');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'R');        
     }
}

$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,7);
$pdf->SetMargins(10,5,5);
	    
$pdf->AddPage(); 
	    
$pdf->SetFont('Arial','',5);
$pdf->SetWidths(array(15,50,25,25,25,20,25,25,25));
$pdf->SetFills(array(0,0,0,0,0,0,0,0,0));
$pdf->SetVisibles(array(1,1,1,1,1,0,0,0,0));
$pdf->SetFontsSizes(array(5,5,5,5,5,5,5,5,5));
$pdf->SetAligns(array('C','C','C','C','C','R','R','R','R'));
$pdf->SetFontsStyles(array('','','','','','','','',''));
$pdf->SetDecimales(array(0,0,2,2,2,2,2,2,2));
$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3));
$pdf->SetFormatNumber(array(0,0,1,1,1,0,0,0,0));
        
$detalle = $_SESSION["PDF_reporte_respaldo_depreciacion"];

$filas=count($detalle);

$total_act_af=0;$total_act_dep=0;$total_dep=0;
//totales generales
$total_1;$total_2;$total_3;

$flag=true;
$pdf->SetLeftMargin(35);

for ($i=0; $i<count($detalle); $i++)
{
	$total_1=$total_1 + $detalle[$i][2];
	$total_2=$total_2 +  $detalle[$i][3];
	$total_3=$total_3 +  $detalle[$i][4];
	
	if($flag)
	{
		/*
		 * cabecera para cada agrupacion
		*
		*/
		$pdf->SetX(35);
		$pdf->SetFont('Arial','B',5);
		$pdf->Cell(37,1,'Tipo de Activo :','',0,'L');
		$pdf->SetFont('Arial','',4);
		$pdf->Cell(50,3,$detalle[$i][13],0,1,'');
		$pdf->Ln(1);
		
		//$pdf->SetX(15);
		$pdf->SetFont('Arial','B',5);
		$pdf->Cell(37,1,'Cuenta Activo Fijo :','',0,'L');
		$pdf->SetFont('Arial','',4);
		$pdf->Cell(50,3,$detalle[$i][17],0,1,'');
		$pdf->Ln(1);
		
		//$pdf->SetX(15);
		$pdf->SetFont('Arial','B',5);
		$pdf->Cell(37,1,'Cuenta Depreciacion Acumulada :','',0,'L');
		$pdf->SetFont('Arial','',4);
		$pdf->Cell(50,3,$detalle[$i][18],0,1,'');
		$pdf->Ln(1);
		
		//$pdf->SetX(15);
		$pdf->SetFont('Arial','B',5);
		$pdf->Cell(37,1,'Cuenta Gasto :','',0,'L');
		$pdf->SetFont('Arial','',4);
		$pdf->Cell(50,3,$detalle[$i][19],0,1,''); 
		
		$pdf->Ln(3);
		$pdf->SetFont('Arial','B',5);
	 	$pdf->Cell(15,3,'CODIGO','TRL',0,'C');  //2
	 	$pdf->Cell(50,3,'DESCRIPCION','TRL',0,'C');  //3
	 	$pdf->Cell(25,3,'ACTUALIZACION','TRL',0,'C');  //4
	 	$pdf->Cell(25,3,'ACTUALIZACION','TRL',0,'C');  //5
	 	$pdf->Cell(25,3,'DEPRECIACION','TRL',0,'C');  //6
	 	
	 	$pdf->Ln(3);
	 	$pdf->Cell(15,3,'ACTIVO FIJO','RL',0,'C');  //2
	 	$pdf->Cell(50,3,'ACTIVO FIJO','RL',0,'C');//3
	 	$pdf->Cell(25,3,'ACTIVO FIJO','RL',0,'C');//4
	 	$pdf->Cell(25,3,'DEPRECIACION','L',0,'C');//5
	 	$pdf->Cell(25,3,'ACTIVO FIJO','RL',0,'C');//6
	 	
	 	$pdf->Ln(3);
	 	$pdf->Cell(15,3,'','BRL',0,'C');  //2
	 	$pdf->Cell(50,3,'','BRL',0,'C');//3
	 	$pdf->Cell(25,3,'','BRL',0,'C');//4
	 	$pdf->Cell(25,3,'ACUMULADA','BRL',0,'C');//5
	 	$pdf->Cell(25,3,'','BRL',0,'C');//6
	 	
		$pdf->Ln();
		//fin
		$flag=false;
	}
	
	
	/*$tipo_af=$detalle[$i][14];
	$programa=$detalle[$i][11];
	
	$tipo_af2=$detalle[$i+1][14];
	$programa2=$detalle[$i+1][11];*/
	
	$id_plan = $detalle[$i][15];
	$id_plan2 = $detalle[$i+1][15];
	
	if($pdf->GetY() >= 250)
	{
		$pdf->SetAutoPageBreak(true);
		$pdf->AddPage();
		//$pdf->Ln(5);
	}
	$pdf->SetX(35); 
	//array_unshift($detalle[$i],$cont);
	$pdf->MultiTabla($detalle[$i],0,3,3,6);
	
	if($id_plan == $id_plan2)
	{
		$total_act_af+=$detalle[$i][2];
		$total_act_dep+=$detalle[$i][3];
		$total_dep+=$detalle[$i][4];
		
		/*$total_1=$total_1 + $total_act_af;
		$total_2=$total_2 + $total_act_dep;
		$total_3=$total_3 + $total_dep;*/
	}
	else 
	{
		$total_act_af+=$detalle[$i][2];
		$total_act_dep+=$detalle[$i][3];
		$total_dep+=$detalle[$i][4];
		
		/*$total_1=$total_1 + $total_act_af;
		$total_2=$total_2 + $total_act_dep;
		$total_3=$total_3 + $total_dep;*/
		
		$pdf->SetX(100);
		$pdf->SetFont('Arial','B',5);
		$pdf->Cell(25,3,number_format($total_act_af,2),'LBRT',0,'R',false);
		$pdf->Cell(25,3,number_format($total_act_dep,2),'LBRT',0,'R',false);
		$pdf->Cell(25,3,number_format($total_dep,2),'LBRT',0,'R',false);
		$pdf->Ln(5);
		
		if ($i < $filas -1)
		{		
			if($pdf->GetY() >= 250)
			{
				$pdf->SetAutoPageBreak(true);
				$pdf->AddPage();
			}
				
			//$pdf->SetX(15);
				
			/*
			 * cabecera para cada agrupacion
			*
			*/
			$pdf->SetX(15);
			$pdf->SetX(35);
			$pdf->SetLeftMargin(35);
			$pdf->SetFont ( 'Arial', 'B', 5 );
			$pdf->Cell ( 37, 2, 'Tipo de Activo :', '', 0, 'L' );
			$pdf->SetFont ( 'Arial', '', 4 );
			$pdf->Cell ( 50, 3, $detalle [$i + 1] [13], 0, 1, '' );
			$pdf->Ln ( 1 );
			
			// $pdf->SetX(15);
			$pdf->SetFont ( 'Arial', 'B', 5 );
			$pdf->Cell ( 37, 2, 'Cuenta Activo Fijo :', '', 0, 'L' );
			$pdf->SetFont ( 'Arial', '', 4 );
			$pdf->Cell ( 50, 3, $detalle [$i + 1] [17], 0, 1, '' );
			$pdf->Ln ( 1 );
			
			// $pdf->SetX(15);
			$pdf->SetFont ( 'Arial', 'B', 5 );
			$pdf->Cell ( 37, 2, 'Cuenta Depreciacion Acumulada :', '', 0, 'L' );
			$pdf->SetFont ( 'Arial', '', 4 );
			$pdf->Cell ( 50, 3, $detalle [$i + 1] [18], 0, 1, '' );
			$pdf->Ln ( 1 );
			
			// $pdf->SetX(15);
			$pdf->SetFont ( 'Arial', 'B', 5 );
			$pdf->Cell ( 37, 2, 'Cuenta Gasto :', '', 0, 'L' );
			$pdf->SetFont ( 'Arial', '', 4 );
			$pdf->Cell ( 50, 2, $detalle [$i + 1] [19], 0, 1, '' );
			$pdf->Ln ( 1 );
			
			$pdf->SetFont ( 'Arial', 'B', 5 );
			$pdf->Cell ( 15, 3, 'CODIGO', 'TRL', 0, 'C' ); // 2
			$pdf->Cell ( 50, 3, 'DESCRIPCION', 'TRL', 0, 'C' ); // 3
			$pdf->Cell ( 25, 3, 'ACTUALIZACION', 'TRL', 0, 'C' ); // 4
			$pdf->Cell ( 25, 3, 'ACTUALIZACION', 'TRL', 0, 'C' ); // 5
			$pdf->Cell ( 25, 3, 'DEPRECIACION', 'TRL', 0, 'C' ); // 6
			
			$pdf->Ln ( 3 );
			$pdf->Cell ( 15, 3, 'ACTIVO FIJO', 'RL', 0, 'C' ); // 2
			$pdf->Cell ( 50, 3, 'ACTIVO FIJO', 'RL', 0, 'C' ); // 3
			$pdf->Cell ( 25, 3, 'ACTIVO FIJO', 'RL', 0, 'C' ); // 4
			$pdf->Cell ( 25, 3, 'DEPRECIACION', 'L', 0, 'C' ); // 5
			$pdf->Cell ( 25, 3, 'ACTIVO FIJO', 'RL', 0, 'C' ); // 6
			
			$pdf->Ln ( 3 );
			$pdf->Cell ( 15, 3, '', 'BRL', 0, 'C' ); // 2
			$pdf->Cell ( 50, 3, '', 'BRL', 0, 'C' ); // 3
			$pdf->Cell ( 25, 3, '', 'BRL', 0, 'C' ); // 4
			$pdf->Cell ( 25, 3, 'ACUMULADA', 'BRL', 0, 'C' ); // 5
			$pdf->Cell ( 25, 3, '', 'BRL', 0, 'C' ); // 6
			
			$pdf->Ln ();
			//fin

			$total_act_af = 0;
			$total_act_dep = 0;
			$total_dep = 0;
			$pdf->SetLeftMargin ( 35 );
				
				
		}
		else
		{
		
			$pdf->SetX ( 85 );
			$pdf->Cell ( 15, 3, 'TOTALES :', 'TBRL', 0, 'C' ); // 2
			
			$pdf->Cell ( 25, 3, number_format ( $total_1, 2 ), 'TBRL', 0, 'R' ); // 3
			$pdf->Cell ( 25, 3, number_format ( $total_2, 2 ), 'TBRL', 0, 'R' ); // 3
			$pdf->Cell ( 25, 3, number_format ( $total_3, 2 ), 'TBRL', 0, 'R' ); // 3
			
			if ($pdf->GetY () >= 250) {
				$pdf->SetAutoPageBreak ( true );
				$pdf->AddPage ();
				// $pdf->Ln(5);
			}
			$pdf->Line ( 80, 245, 140, 245 );
			// $pdf->SetX(220);
			// $pdf->SetY(247);
			$pdf->SetFont ( 'Arial', 'B', 5 );
			// $pdf->Cell(40,3,$_SESSION['datos_respaldo'][3],'',0,'C');
			$pdf->Text ( 95, 247, $_SESSION ['datos_respaldo'] [3] );
		}
		
	}
			
}

$pdf->Output();
?>