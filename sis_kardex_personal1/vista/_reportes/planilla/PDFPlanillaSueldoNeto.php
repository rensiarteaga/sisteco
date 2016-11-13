<?php
session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de creacion: 01/09/2010
 * Descripción: Reporte de Planillas por Empleado
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
   $this->Cell(0,5,'PLANILLA DETALLE SUELDO NETO CORRESPONDIENTE AL MES DE  '.$cabecera[0]['periodo'].'-'.$cabecera[0]['gestion'],0,1,'C');
  
   $this->Ln(2);
   //Aqui mostrare la cabecera
    $this->SetFont('Arial','B',8);
   $this->Cell(20,3.5,'CODIGO','LTR',0,'C');
   $this->Cell(70,3.5,'NOMBRES Y APELLIDOS','LTR',0,'C');
   $this->Cell(18,3.5,'TOTAL','LTR',0,'C');
   $this->Cell(54,3.5,'DESCUENTOS','LTR',0,'C');
   $this->Cell(18,3.5,'BONO DEL','LTR',0,'C');
   $this->Cell(18,3.5,'LIBER','LTR',0,'C');
   $this->Cell(18,3.5,'VIAT.','LTR',0,'C');
   $this->Cell(18,3.5,'REINT','LTR',0,'C');
   $this->Cell(18,3.5,'BONO','LTR',0,'C');
   
   $this->Cell(18,3.5,'SUELDO','LTR',1,'C');
   
   $this->Cell(20,3.5,' ','LBR',0,'C');
   $this->Cell(70,3.5,'','LBR',0,'C');
   $this->Cell(18,3.5,'GANADO','LBR',0,'C');
   
   $this->Cell(18,3.5,'Capit. Ind',1,0,'C');
   $this->Cell(18,3.5,'Rie. Com.',1,0,'C');
   $this->Cell(18,3.5,'Co. Adm',1,0,'C');
   $this->Cell(18,3.5,'MES','LBR',0,'C');
   $this->Cell(18,3.5,'LUZ','LBR',0,'C');
   $this->Cell(18,3.5,'','LBR',0,'C');
   $this->Cell(18,3.5,'','LBR',0,'C');
   $this->Cell(18,3.5,'PROD.','LBR',0,'C');
   $this->Cell(18,3.5,'NETO','LBR',1,'C');
   
   
}
 
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
     $this->SetY(-7);
   	$this->pieHash('KARDEX','','L');
    /*$fecha=date("d-m-Y");
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
	$pdf->SetAutoPageBreak(true,7);
    $pdf->SetMargins(5,5,5);  
    
    $pdf->SetFont('Arial','',5);
	
    $pdf->AddPage();


 	$cabecera=$_SESSION['PDF_cab_rep_planilla'];
 	$detalle=$_SESSION['PDF_lista_planilla_sueldo_neto'];
// print_r($detalle);
 //	 		exit;
 	$pdf->SetWidths(array(20,70,18,18,18,18,18,18,18,18,18,18));
	$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0));
 	$pdf->SetAligns(array('L','L','R','R','R','R','R','R','R','R','R','R'));
 	$pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
  	$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,));
 	$pdf->SetFontsStyles(array('','','','','','','','',''));
 	$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,2,3));
 	$pdf->setDecimales(array(0,0,2,2,2,2,2,2,2,2,2,2));
    $pdf->SetFormatNumber(array(0,0,1,1,1,1,1,1,1,1,1,1));
 	//print_r($detalle);
 	//exit; 
 	$indice_col=0;
 	$detalle_show=array();
 	        $tam=sizeof($detalle)/10;
 	        //echo $tam
 	        //exit;
 	     /*   print_r($detalle);
 	        exit;
 	        for($i=0;$i<(count($detalle))/10;$i++){
 	 		 	 $col=2;
   		    for ($j=$indice_col;$j<($indice_col+10);$j++){
   		   		$detalle_show[$i][0]=$detalle[$j]['codigo_empleado'];
   		   		$detalle_show[$i][1]=$detalle[$j]['nombre_completo'];
   		    	switch ($detalle[$j]['codigo']) {
  						case 'TOTGANADO':
      					  $detalle_show[$i][2]=$detalle[$j]['valor'];
       					break;
   						case 'AFP_SSO':
      					  $detalle_show[$i][3]=$detalle[$j]['valor'];
    				    break;
  						case 'AFP_RCOM':
      					  $detalle_show[$i][4]=$detalle[$j]['valor'];
       					break;
       					case 'AFP_CADM':
      					  $detalle_show[$i][5]=$detalle[$j]['valor'];
       					break;
       					case 'BONMES':
      					  $detalle_show[$i][6]=$detalle[$j]['valor'];
       					break;
       					case 'LIBENER':
      					  $detalle_show[$i][7]=$detalle[$j]['valor'];
       					break;
       					case 'VIATICO':
      					  $detalle_show[$i][8]=$detalle[$j]['valor'];
       					break;	
       					case 'BONPROD':
      					  $detalle_show[$i][10]=$detalle[$j]['valor'];
       					break;	
       					case 'SUEL_NETO':
      					  $detalle_show[$i][11]=$detalle[$j]['valor'];
       					break;
       					default:
       					  $detalle_show[$i][9]=0; 
       					
                   }
   		   		//$detalle_show[$i][$col]=$detalle[$j]['valor'];
   		   		
   		     	//$col=$col+1;
 		     }
   		     $indice_col=$indice_col+10;
   		   
 	 		}*/
 	 		
 	 	for($i=0;$i<(count($detalle))/10;$i++){
 	 		 	 $col=2;
   		     for ($j=$indice_col;$j<($indice_col+10);$j++){
   		   		$detalle_show[$i][0]=$detalle[$j]['codigo_empleado'];
   		   		$detalle_show[$i][1]=$detalle[$j]['nombre_completo'];
   		   		$detalle_show[$i][$col]=$detalle[$j]['valor'];
   		   		
   		     	$col=$col+1;
 		     }
   		      $indice_col=$indice_col+10;
   		   
 	 		}
 	 	 $sum_total1=0;
 	 			 $sum_total2=0;
 	 			 $sum_total3=0;
 	 			 $sum_total4=0;
 	 			 $sum_total5=0;
 	 			 $sum_total6=0;
 	 			 $sum_total7=0;
 	 			 $sum_total8=0;
 	 			 $sum_total9=0;
 	 			 $sum_total10=0;
 	 			 
 	 		for ($h=0;$h<count($detalle_show);$h++){
 	 			
 	 			 $pdf->MultiTabla($detalle_show[$h],0,3,3,6,1);
 	 			 
 	 			 $sum_total1=$sum_total1+$detalle_show[$h][2];
 	 			 $sum_total2=$sum_total2+$detalle_show[$h][3];
 	 			 $sum_total3=$sum_total3+$detalle_show[$h][4];
 	 			 $sum_total4=$sum_total4+$detalle_show[$h][5];
 	 			 $sum_total5=$sum_total5+$detalle_show[$h][6];
 	 			 $sum_total6=$sum_total6+$detalle_show[$h][7];
 	 			 $sum_total7=$sum_total7+$detalle_show[$h][8];
 	 			 $sum_total8=$sum_total8+$detalle_show[$h][9];
 	 			 $sum_total9=$sum_total9+$detalle_show[$h][10];
 	 			 $sum_total10=$sum_total10+$detalle_show[$h][11];
 	 			
 	 			 
 	 		}
 	 		
 	 		  

 	 		 $pdf->SetFont('Arial','B',6);
 			$pdf->Cell(90,3,'TOTAL PLANILLA:','RBT',0,'R');
 	 		$pdf->Cell(18,3,number_format($sum_total1,2),1,0,'R');
 	 		$pdf->Cell(18,3,number_format($sum_total2,2),1,0,'R');
 	 		$pdf->Cell(18,3,number_format($sum_total3,2),1,0,'R');
 	 		$pdf->Cell(18,3,number_format($sum_total4,2),1,0,'R');
 	 		$pdf->Cell(18,3,number_format($sum_total5,2),1,0,'R');
 	 		$pdf->Cell(18,3,number_format($sum_total6,2),1,0,'R');
 	 	    $pdf->Cell(18,3,number_format($sum_total7,2),1,0,'R');
 	 	    $pdf->Cell(18,3,number_format($sum_total8,2),1,0,'R');
 	 	    $pdf->Cell(18,3,number_format($sum_total9,2),1,0,'R');
 	 	    $pdf->Cell(18,3,number_format($sum_total10,2),1,1,'R');
 
 
$pdf->Output();

?>