<?php
session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de mod: 16/09/2009
 * Descripción: Reporte de Items con sus respectivos costos y proveedores
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
	$this->Image('../../../../lib/images/logo_reporte.jpg',220,0,35,15);
    $this->Ln(5);
    $this->SetFont('Arial','B',16);
 
$this->Cell(0,6,$_SESSION["PDF_titulo"].' COTIZADOS',0,1,'C');
$this->SetFont('Arial','B',10);
 $this->SetX(15);
 $this->Ln(1.5);
 
 $this->SetWidths(array(0,105,0,166));
 $this->SetFills(array(0,0,0,0,0,0,0));
 $this->SetAligns(array('R','L','R','L'));
 $this->SetVisibles(array(0,1,0,1,1));
 $this->SetFontsSizes(array(6,6,6,6,6,6));
 $this->SetFontsStyles(array('','','',''));
 $this->SetDecimales(array(0,0,0,0,0));
 $this->SetSpaces(array(3,3,3,3,3,3));
 $this->SetFillColor(255,255,255);
 $this->SetDrawColor(0,0,0); 
 $this->SetFont('Arial','B',7);
  $this->SetFormatNumber(array(0,0,1,0));
 
 $this->SetLineWidth(0.2); 
//$this->Cell(9,3,'Nº','LTR',0,'C');  
 $this->Cell(105,3,'Descripción Item','TRLB',0,'C');  
// $this->Cell(20,3,'Costo (Bs)','TRB',0,'C');
  //$pdf->SetWidths1(array(40,18,60,18,5,15));  
 $this->Cell(45,3,'Nombres','TB',0,'C');
 $this->Cell(18,3,'Telefono','TB',0,'C');
 $this->Cell(65,3,'Direccion','TB',0,'C');
 $this->Cell(23,3,'Costo Cot.','TB',0,'C');
 $this->Cell(15,3,'Fecha Ult.','TBR',1,'C');
               //              Costo Cotizado','TR',1,'C');  
 $this->Ln(0.2);
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
		$this->Cell(100,3,'Sistema: ENDESIS -COMPRO',0,0,'L');
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
 
 $pdf->SetFont('Arial','B',7);
 $pdf->SetWidths(array(0,105,0,166));
 $pdf->SetFills(array(0,0,0,0,0,0,0));
 $pdf->SetAligns(array('R','L','R','L'));
 $pdf->SetVisibles(array(0,1,0,1,1));
 $pdf->SetFontsSizes(array(6,6,6,6,6,6));
 $pdf->SetFontsStyles(array('','','',''));
 $pdf->SetDecimales(array(0,0,0,0,0));
 $pdf->SetSpaces(array(3,3,3,3,3,3));
 $pdf->SetFillColor(255,255,255);
 $pdf->SetDrawColor(0,0,0); 
 $pdf->SetFont('Arial','B',7);
  $pdf->SetFormatNumber(array(0,0,1,0));

$v_setdetalle=$_SESSION['ItemsCaracteristicasCostos'];


$proveedores=array();
 for ($i=0;$i<sizeof($v_setdetalle);$i++){
 	 $pdf->SetLineWidth(0.05);
 	// $pdf->SetDrawColor(100,100,100);
 	 $proveedores_muestra=array();
 	 $proveedores=$_SESSION['Proveedores_Item_'.$i];
 	 if (count($proveedores)==0){
 	 	 $pdf->SetWidths1(array(166));
 	 	 $pdf->SetFormatNumberST(array(0));
 	 	 $proveedores_muestra[0][0]='EL '.$_SESSION["PDF_titulo"].' NO HA SIDO COTIZADO';
 	     $pdf->MultiTabla1($v_setdetalle[$i],1,5,3,6,1,$proveedores_muestra,3);
 	 	
 	 }else{
 	 for($z=0;$z<count($proveedores);$z++){
 	 	
 	 	
      	$proveedores_muestra[$z][0]=$proveedores[$z][0];
      	$proveedores_muestra[$z][1]=$proveedores[$z][1];
      	$proveedores_muestra[$z][2]=$proveedores[$z][2];
      	$proveedores_muestra[$z][3]=$proveedores[$z][3];
      	$proveedores_muestra[$z][4]=$proveedores[$z][4];
      	$proveedores_muestra[$z][5]=$proveedores[$z][5];
    }
      
 	 $pdf->SetWidths1(array(45,18,65,18,5,15));
 	 $pdf->SetAlignsST(array('L','R','L','R','L'));
 	 $pdf->SetDecimalesST(array(0,0,0,2,0,0));
 	 $pdf->SetFormatNumberST(array(0,0,0,1,0,0));
 	 	
	   $pdf->MultiTabla1($v_setdetalle[$i],1,5,3,6,1,$proveedores_muestra,3);
 	 }
	   
   }
	 $pdf->SetLineWidth(0.2); 
	 $pdf->SetDrawColor(255,255,255);
$pdf->Output();


?>