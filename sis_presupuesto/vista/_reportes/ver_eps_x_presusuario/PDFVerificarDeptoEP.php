<?php

session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de creacion: 20/05/2013
 * Descripción: Reporte de Verificación Presupuestaria
 * Fecha de modificacion: 27/07/2010
 * **/

require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
 
class PDF extends FPDF
{   
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
   // $this-> AddFont('Arial','','arial.php');
 
    //Iniciación de variables
    }

  

function Header()
{       
   $this->Image('../../../../lib/images/logo_reporte.jpg',180,2,35,15);
  
    $this->Ln(5);
    $this->SetFont('Arial','B',16);
 	$this->Cell(0,6,'Asignacion de Estructuras Programáticas',0,1,'C');
 	$this->Cell(0,6,' a Departamentos ',0,1,'C');
 	$this->SetFont('Arial','B',10);
 	$this->SetFont('Arial','B',10);
 	$this->SetX(15);
 	$this->Ln(1.5);

 	
    $this->SetFont('Arial','B',7);
	/*$this->Cell(100,4,'NOMBRE DEPARTAMENTO','LTR',0,'C');
	$this->Cell(60,4,'ESTADO','LTR',0,'C');
	$this->Cell(80,4,'DESCRIPCIÓN EP','TR',0,'C');
	$this->Cell(80,4,'FINANCIADOR','TR',0,'C');
	$this->Cell(80,4,'REGIONAL','TR',0,'C');
	$this->Cell(80,4,'PROGRAMA','TR',0,'C');
	$this->Cell(80,4,'PROYECTO','TR',0,'C');
	$this->Cell(80,4,'ACTIVIDAD','TR',0,'C');*/
	}
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
    $fecha=date("d-m-Y");
	$hora=date("H:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
   	    $this->Cell(100,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(70,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(62,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(100,3,'Sistema: ENDESIS - PRESTO',0,0,'L');
		$this->Cell(70,3,'',0,0,'C');
		$this->Cell(62,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
        
      }


}

	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,7);
    $pdf->SetMargins(5,5,5);
    $pdf->AddPage();

       $pdf->SetLineWidth(.1);


	   $pdf->SetWidths(array(0,0,0,0,0,0,0,170,30));
       $pdf->SetAligns(array('L','L','L','L','L','L','L','L','L'));
       $pdf->SetVisibles(array(0,0,0,0,0,0,0,1,1));
       $pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
       $pdf->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5));
       $pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3));
       $pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0));

        	//en $data llegara toda la información.
         
	  $v_setdetalle=$_SESSION['PDF_verificarDepEP']; 
	  if (count($v_setdetalle)==0){
	  	$pdf->Cell(200,5,'No existe Departamentos asignados consulte con Contabilidad para la parametrización de Departamentos y EPs',0,1);
	  	$pdf->Cell(200,5,''.$_SESSION['PDF_desc_presupuesto'],0,1);
	  }
	  $bandera_depto='';

	  for ($i=0;$i<count($v_setdetalle);$i++){
	  	 
	  	if ($i!=0){
	  		if ($bandera_depto!=$v_setdetalle[$i][0]){
	  			$bandera_depto=$v_setdetalle[$i][0];
	  			$pdf->SetFillColor(220,220,220);
	  			$pdf->SetFont('Arial','B',9);
	  			$pdf->Ln(1);
	  			$pdf->Cell(30,4,'Presupuesto:',0,0);
	  			$pdf->SetFont('Arial','',9);
	  			$pdf->Cell(150,4,$bandera_depto,0,1,'L',1);
	  			$pdf->Ln(1);
	  				
	  			$pdf->SetFont('Arial','B',7);
	  			$pdf->SetWidths(array(20,80,20,80));
	  			$pdf->SetAligns(array('L','L','L','L'));
	  			$pdf->SetVisibles(array(1,1,1,1));
	  			$pdf->SetFonts(array('Arial','Arial','Arial','Arial'));
	  			$pdf->SetFontsSizes(array(5,5,5,5));
	  			$pdf->SetSpaces(array(3,3,3,3));
	  			$pdf->SetFormatNumber(array(0,0,0,0));
	  			$pdf->SetFills(array(0,1,0,1,0,1,0,1,0,1));
	  			$pdf->SetDrawColor(255,255,255);
	  			$pdf->SetFontsStyles(array('B','','B',''));
	  			
	  			$v_detcab [0][0]='DESC EP';
	  			$v_detcab [0][1]=$v_setdetalle[$i][1];
	  			$v_detcab [0][2]='Financiador';
	  			$v_detcab [0][3]=$v_setdetalle[$i][2];
	  			
	  			$v_detcab [1][0]='Regional';
	  			$v_detcab [1][1]=$v_setdetalle[$i][3];
	  			$v_detcab [1][2]='Programa';
	  			$v_detcab [1][3]=$v_setdetalle[$i][4];
	  			$v_detcab [2][0]='Proyecto';
	  			$v_detcab [2][1]=$v_setdetalle[$i][5];
	  			$v_detcab [2][2]='Actividad';
	  			$v_detcab [2][3]=$v_setdetalle[$i][6];
	  			
	  			//$v_detcab [3][1]=$v_setdetalle[$i][7];
	  			
	  			for($j=0;$j<count($v_detcab);$j++){
	  				$pdf->Ln(0.4);
	  				$pdf->MultiTabla($v_detcab[$j],1,3,3,5,1);
	  			}
	  			$pdf->Ln(1);
	  			$pdf->Cell(200,5,'Departamentos Asignados',0,1);
	  			$pdf->SetWidths(array(0,0,0,0,0,0,0,170,30));
	  			$pdf->SetAligns(array('L','L','L','L','L','L','L','L','L'));
	  			$pdf->SetVisibles(array(0,0,0,0,0,0,0,1,1));
	  			$pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
	  			$pdf->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5));
	  			$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3));
	  			$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0));
	  			$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0));
	  			$pdf->SetDrawColor(0,0,0);
	  			$pdf->MultiTabla($v_setdetalle[$i],s1,3,3,5,1);
	  		}else {
	  			$pdf->MultiTabla($v_setdetalle[$i],1,3,3,5,1);
	  		}
	  	}
	  }
	  
	  
      /* for ($i=0;$i<count($v_setdetalle);$i++){
       $pdf->MultiTabla($v_setdetalle[$i],1,3,3,5,1);
     
      }*/
   


$pdf->Output();


?>