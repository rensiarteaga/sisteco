<?php

session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de creacion: 16/03/2010
 * Descripción: Reporte de Listado de Procesos
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
 
    //Iniciación de variables
    }



function Header()
{       
   $this->Image('../../../../lib/images/logo_reporte.jpg',230,2,35,15);
   $tipo_adq='';
	switch ($_SESSION['PDF_tipo_adq']) 
	{
		case 'Bien':
			$tipo_adq=' - Bienes';
		break;
		case 'Servicio':
			$tipo_adq=' - Servicios';
		break;
		default:$tipo_adq='';
	}
    $this->Ln(5);
    $this->SetFont('Arial','B',16);
 	$this->Cell(0,6,'LISTADO DE PROCESOS '.strtoupper($_SESSION['PDF_codigo_proceso'].''.$tipo_adq),0,1,'C');
 	$this->SetFont('Arial','',10);
 	//$this->Cell(0,3,$tipo_adq ,0,1,'C');
 	$this->Cell(0,3,'Gestion: '.$_SESSION['PDF_gestion'] ,0,1,'C');
 	
 	$this->SetX(15);
 	$this->Ln(1.5);

	$this->Ln(1);
	$this->SetFont('Arial','B',8); 
	$this->Cell(25,4,'DEPARTAMENTO:',0,0); 
	$this->SetFont('Arial','',8); 
	$this->MultiCell(245,4,$_SESSION['PDF_desc_depto'],0);

	$this->Ln(1);
 	$this->SetFont('Arial','B',7);
 	$this->SetLineWidth(0.2);
 
 	$this->SetWidths(array(10,25,85,35,15,20,60,20));
 	$this->SetFills(array(0,0,0,0,0,0,0));
 	$this->SetAligns(array('L','L','L','L','R','R','L','L'));
 	$this->SetVisibles(array(1,1,1,1,1,1,1,1));	
 	$this->SetFontsSizes(array(6,6,6,6,6,6,6,6));
 	$this->SetFontsStyles(array('','','','','','','',''));
 	$this->SetDecimales(array(0,0,0,0,0,2,0,0));
 	$this->SetSpaces(array(3,3,3,3,3,3,3,3));
 	$this->SetFormatNumber(array(0,0,0,0,0,1,0,0));
 
 	$this->Cell(10,3,'TIPO ','TRL',0,'C');  
 	$this->Cell(25,3,'CODIGO','TRL',0,'C');  
 	$this->Cell(85,3,'OBSERVACIONES','TRL',0,'C');  
 	$this->Cell(35,3,'TIEMPO','TRL',0,'C'); 
 	$this->Cell(15,3,'MONEDA','TRL',0,'C');  
 	$this->Cell(20,3,'IMPORTE	','TRL',0,'C');  
 	$this->Cell(60,3,'PROVEEDOR','TRL',0,'C');  
 	$this->Cell(20,3,'ESTADO','TRL',1,'C'); 
 
 	$this->Cell(10,3,'ADQ.','BRL',0,'C');  
 	$this->Cell(25,3,'PROCESO','BRL',0,'C');  
 	$this->Cell(85,3,'','BRL',0,'C');  
 	$this->Cell(35,3,'ENTREGA','BRL',0,'C'); 
 	$this->Cell(15,3,'','BRL',0,'C');  
 	$this->Cell(20,3,'','BRL',0,'C');  
 	$this->Cell(60,3,'','BRL',0,'C');  
 	$this->Cell(20,3,'VIGENTE','BRL',1,'C');  
 
 	$this->Ln(0.3);
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
		$this->Cell(100,3,'Sistema: ENDESIS - COMPRO',0,0,'L');
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


 	$pdf->SetWidths(array(10,25,85,35,15,20,60,20));
 	$pdf->SetFills(array(0,0,0,0,0,0,0));
 	$pdf->SetAligns(array('L','L','L','L','R','R','L','L'));
 	$pdf->SetVisibles(array(1,1,1,1,1,1,1,1));
 	$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6));
 	$pdf->SetFontsStyles(array('','','','','','','',''));
 	$pdf->SetDecimales(array(0,0,0,0,0,2,0,0));
 	$pdf->SetSpaces(array(3,3,3,3,3,3,3,3));
 	$pdf->SetFormatNumber(array(0,0,0,0,0,1,0,0));
 
 
	$v_setdetalle=$_SESSION['PDF_listado_procesos'];

 	for ($i=0;$i<sizeof($v_setdetalle);$i++){
	 	$pdf->SetLineWidth(0.05);
 		$pdf->MultiTabla($v_setdetalle[$i],0,3,3,6,1);
 	  
    }
 
	$pdf->Output();


?>