<?php
session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de creacion: 09/11/2010
 * Descripción: Reporte de Planillas Impositivas
 *
 *
 ***/
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
   $this->Image('../../../../lib/images/logo_reporte.jpg',240,0,30,10);
   $cabecera=$_SESSION['PDF_cab_rep_planilla'];
   $this->SetFont('Arial','B',7);
	$this->Cell(30,3,'No. Patronal:511-2067',0,1);
	$this->Cell(30,3,'N.I.T.: 1023187029',0,1);
   $this->SetFont('Arial','BU',12);
   $this->Cell(0,5,'PLANILLA IMPOSITIVA CORRESPONDIENTE AL MES DE  '.$cabecera[0]['periodo'].'-'.$cabecera[0]['gestion'],0,1,'C');
  
   $this->Ln(2);
   //Aqui mostrare la cabecera
    $this->SetFont('Arial','B',7);
   $this->Cell(12,3.5,'CODIGO','LTR',0,'C');
   $this->Cell(38,3.5,'NOMBRES Y APELLIDOS','LTR',0,'C');
   $this->Cell(14,3.5,'TOTAL','LTR',0,'C');
   $this->Cell(14,3.5,'SUELDO','LTR',0,'C');
   $this->Cell(14,3.5,'MINIMO','LTR',0,'C');
   $this->Cell(14,3.5,'DIFEREN.','LTR',0,'C');
   $this->Cell(14,3.5,'IMPUESTO','LTR',0,'C');
   $this->Cell(14,3.5,'COMPUTO','LTR',0,'C');
   $this->Cell(14,3.5,'13%','LTR',0,'C');
   
   $this->Cell(28,3.5,'SALDO A FAVOR','LTR',0,'C');
   $this->Cell(42,3.5,'SALDO ANTE. A FAVOR DEPED.','LTR',0,'C');
   $this->Cell(14,3.5,'SALDO TOT.','LTR',0,'C');
   $this->Cell(14,3.5,'SALDO ','LTR',0,'C');
   $this->Cell(14,3.5,'IMPUESTO','LTR',0,'C');
   $this->Cell(14,3.5,'SALDO ','LTR',1,'C');
   

   $this->Cell(12,3.5,' ','LR',0,'C');
   $this->Cell(38,3.5,'','LR',0,'C');
   $this->Cell(14,3.5,'GANADO','LR',0,'C');
   $this->Cell(14,3.5,'NET0','LR',0,'C');
   $this->Cell(14,3.5,'NO','LR',0,'C');
   $this->Cell(14,3.5,'SUJETA.','LR',0,'C');
   $this->Cell(14,3.5,'RC-IVA','LR',0,'C');
   $this->Cell(14,3.5,'FORM','LR',0,'C');
   $this->Cell(14,3.5,'S/DOS','LR',0,'C');
   $this->Cell(14,3.5,'FISCO','LTR',0,'C');
   $this->Cell(14,3.5,'DEPEND.','LTR',0,'C');
   $this->Cell(14,3.5,'MES','LTR',0,'C');
   $this->Cell(14,3.5,'MANTEN','TLR',0,'C');
   $this->Cell(14,3.5,'TOTAL','TLR',0,'C');
   $this->Cell(14,3.5,'A FAVOR','LR',0,'C');
   $this->Cell(14,3.5,'UTILIZ.','LR',0,'C');
   $this->Cell(14,3.5,'RETENIDO','LR',0,'C');
   $this->Cell(14,3.5,'MES','LR',1,'C');
   
   $this->Cell(12,3.5,' ','LBR',0,'C');
   $this->Cell(38,3.5,'','LBR',0,'C');
   $this->Cell(14,3.5,'','LBR',0,'C');
   $this->Cell(14,3.5,'IMPONIB','LBR',0,'C');
   $this->Cell(14,3.5,'IMPONIB','LBR',0,'C');
   $this->Cell(14,3.5,'IMPUEST.','LBR',0,'C');
   $this->Cell(14,3.5,'13%','LBR',0,'C');
   $this->Cell(14,3.5,'87','LBR',0,'C');
   $this->Cell(14,3.5,'S.M.N','LBR',0,'C');
   $this->Cell(14,3.5,'','LBR',0,'C');
   $this->Cell(14,3.5,'','LBR',0,'C');
   $this->Cell(14,3.5,'ANTER','LBR',0,'C');
   $this->Cell(14,3.5,'VALOR','LBR',0,'C');
   $this->Cell(14,3.5,'','LBR',0,'C');
   $this->Cell(14,3.5,'DEPEND.','LBR',0,'C');
   $this->Cell(14,3.5,'','LBR',0,'C');
   $this->Cell(14,3.5,'','LBR',0,'C');
   $this->Cell(14,3.5,'SGTE','LBR',1,'C');
   
   
   
}
 
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
     $this->SetY(-9);
   	$this->pieHash('KARDEX','','L');
 	
   /* $fecha=date("d-m-Y");
	$hora=date("H:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
   	    $this->Cell(100,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(70,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(62,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(100,3,'Sistema: ENDESIS - KARDEX',0,0,'L');
		$this->Cell(70,3,'',0,0,'C');
		$this->Cell(62,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	*/
     }

}
  	$pdf=new PDF();	
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,5);
    $pdf->SetMargins(5,5,5);  
    
    $pdf->SetFont('Arial','',5);
	
    $pdf->AddPage();


 	$cabecera=$_SESSION['PDF_cab_rep_planilla'];
 	$detalle=$_SESSION['PDF_lista_planilla_impositiva'];

 	$pdf->SetWidths(array(0,12,38,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14));
	$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
 	$pdf->SetAligns(array('R','L','L','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R'));
 	$pdf->SetVisibles(array(0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
  	$pdf->SetFontsSizes(array(0,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6));
 	$pdf->SetFontsStyles(array('','','','','','','','',''));
 	$pdf->SetSpaces(array(0,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
 	$pdf->setDecimales(array(0,0,0,2,2,2,2,2,2,2,2,2,2));
    $pdf->SetFormatNumber(array(0,0,0,1,1,1,1,1,1,1,1,1,1));
 	//print_r($detalle);
 	//exit; 
 	$indice_col=0;
 	$detalle_show=array();
 	$tam=sizeof($detalle)/16;
 	        
 	       
 	 		for($i=0;$i<(count($detalle))/16;$i++){
 	 		 	 $col=3;
   		     for ($j=$indice_col;$j<($indice_col+16);$j++){
   		     	$detalle_show[$i][0]=$detalle[$j]['nombre'];
   		   		$detalle_show[$i][1]=$detalle[$j]['codigo_empleado'];
   		   		$detalle_show[$i][2]=$detalle[$j]['nombre_completo'];
   		   		$detalle_show[$i][$col]=$detalle[$j]['valor'];
   		   		
   		     	$col=$col+1;
 		     }
   		      $indice_col=$indice_col+16;
   		   
 	 		}
 	 		$id_lugar='';
 	 		for ($h=0;$h<count($detalle_show);$h++){
 	 			if ($id_lugar!=$detalle_show[$h][0]){
 	 				  $id_lugar=$detalle_show[$h][0];
 	 			  $pdf->Cell(205,5,$id_lugar,0,1);
 	 			  //$id_lugar=$detalle_show[$h][0];
 	 			}
 	 			 $pdf->MultiTabla($detalle_show[$h],0,3,3,6,1);
 	 		}
 	 		
 	
 
 	
 	
 
$pdf->Output();

?>