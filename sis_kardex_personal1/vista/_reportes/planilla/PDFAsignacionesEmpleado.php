<?php
session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de creacion: 01/02/2011
 * Descripción: Reporte de Planillas Impositivas por areas
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
   $cabecera=$_SESSION['PDF_cab_rep_planilla_areas'];
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


 	$cabecera=$_SESSION['PDF_cab_rep_planilla_areas'];
 	$detalle=$_SESSION['PDF_lista_planilla_impositiva_areas'];

 	$pdf->SetWidths(array(0,0,12,38,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14,14));
	$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
 	$pdf->SetAligns(array('R','R','L','L','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R'));
 	$pdf->SetVisibles(array(0,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
  	$pdf->SetFontsSizes(array(0,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6));
 	$pdf->SetFontsStyles(array('','','','','','','','',''));
 	$pdf->SetSpaces(array(0,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
 	$pdf->setDecimales(array(0,0,0,0,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2));
    $pdf->SetFormatNumber(array(0,0,0,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
 	//print_r($detalle);
 	//exit; 
 	$indice_col=0;
 	$detalle_show=array();
 	$tam=sizeof($detalle)/16;
 	        
 	       
 	 		for($i=0;$i<$tam;$i++){
 	 		 	 $col=4;
 	 		 	/* echo $indice_col;
 	 		 	 exit;*/
   		     for ($j=$indice_col;$j<($indice_col+16);$j++){
   		     	
   		     	$detalle_show[$i][0]=$detalle[$j]['area'];
   		     	$detalle_show[$i][1]=$detalle[$j]['desc_uo'];
   		   		$detalle_show[$i][2]=$detalle[$j]['codigo_empleado'];
   		   		$detalle_show[$i][3]=$detalle[$j]['nombre_completo'];
   		   		
   		   		/*********Añadido ultimo ***/
   		switch ($detalle[$j]['codigo']) {
    			case 'TOTGANADO':
    		        $detalle_show[$i][4]=$detalle[$j]['valor'];
            
      			break;
      	         // case 'S_NETOGEN':
      	          case 'SUEL_NETO':
      	           	$detalle_show[$i][5]=$detalle[$j]['valor'];
      	                break;
                   case 'MINNOIMP':
                   	$detalle_show[$i][6]=$detalle[$j]['valor'];
                   	 	break;
                   case 'IMPSUJIMP':
                   	$detalle_show[$i][7]=$detalle[$j]['valor'];
                   	 	break;
                   case 'RC_IVA':
                   	$detalle_show[$i][8]=$detalle[$j]['valor'];
                   	 	break;
                   case 'IMPNOTFIS':
                   	$detalle_show[$i][9]=$detalle[$j]['valor'];
                   	 	break;
                   case 'PORCNOIMP':
                   	$detalle_show[$i][10]=$detalle[$j]['valor'];
                   	 	break;
                   case 'SALDO_FIS':
                   	$detalle_show[$i][11]=$detalle[$j]['valor'];
                   	 	break;
                   case 'SALDO_DEP':
                   	$detalle_show[$i][12]=$detalle[$j]['valor'];
                   	 	break;
                   case 'SALD_DEP1':
                   	$detalle_show[$i][13]=$detalle[$j]['valor'];
                   	 	break;
                   case 'FACTOR_UFV':
                   	$detalle_show[$i][14]=$detalle[$j]['valor'];
                   	 	break;
                   case 'TOTSALDEP1':
                   	$detalle_show[$i][15]=$detalle[$j]['valor'];
                   	 	break;
                   case 'SALTOTDEP':
                   	$detalle_show[$i][16]=$detalle[$j]['valor'];
                   	 	break;
                   case 'SALD_UTILI':
                   	$detalle_show[$i][17]=$detalle[$j]['valor'];
                   	 	break;
                   case 'IMP_RETEN':
                   	$detalle_show[$i][18]=$detalle[$j]['valor'];
                   	 	break;
                   case 'SAL_MESIG':
                   	$detalle_show[$i][19]=$detalle[$j]['valor'];
                   	 	break;
      	 	 }
   		   		
   		   		$col=$col+1;
 		     }
   		      $indice_col=$indice_col+16;
   		   
 	 		}
 	 		
 	 		/*print_r($detalle_show);
 	 		exit;*/
 	 		
 	 		$desc_uo='';
 	 		 $sum_parc1=0;
 	 		 $sum_parc2=0;
 	 		 $sum_parc3=0;
 	 		 $sum_parc4=0;
 	 			     $sum_parc5=0;
 	 			      $sum_parc6=0;
 	 			       $sum_parc7=0;
 	 			        $sum_parc8=0;
 	 			         $sum_parc9=0;
 	 			          $sum_parc10=0;
 	 			           $sum_parc11=0;
 	 			            $sum_parc12=0;
 	 			             $sum_parc13=0;
 	 			              $sum_parc14=0;
 	 			               $sum_parc15=0;
 	 			                $sum_parc16=0;
 	 			                
 	 			                
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
 	 			 $sum_total11=0;
 	 			 $sum_total12=0;
 	 			 $sum_total13=0;
 	 			 $sum_total14=0;
 	 			 $sum_total15=0;
 	 			 $sum_total16=0;
 	 			 
 	 		for ($h=0;$h<count($detalle_show);$h++){
 	 			/* if ($h==0){
 	 			 	$pdf->SetFont('Arial','B',7);
 	 				$pdf->Cell(205,5,$detalle_show[0][1],0,1);
 	 			   $pdf->SetFont('Arial','',6);
 	 			 }*/
 	 			if ($detalle_show[$h][0]=='si'){
 	 				 $pdf->SetFont('Arial','B',6);
 	 				 if ($h!=0){
 	 				
 	 			 $pdf->Cell(50,3,'SUB-TOTAL:','RBT',0,'R');
 	 			  $pdf->Cell(14,3,number_format($sum_parc1,2),1,0,'R');
 	 			   $pdf->Cell(14,3,number_format($sum_parc2,2),1,0,'R');
 	 			    $pdf->Cell(14,3,number_format($sum_parc3,2),1,0,'R');
 	 			     $pdf->Cell(14,3,number_format($sum_parc4,2),1,0,'R');
 	 			      $pdf->Cell(14,3,number_format($sum_parc5,2),1,0,'R');
 	 			       $pdf->Cell(14,3,number_format($sum_parc6,2),1,0,'R');
 	 			        $pdf->Cell(14,3,number_format($sum_parc7,2),1,0,'R');
 	 			         $pdf->Cell(14,3,number_format($sum_parc8,2),1,0,'R');
 	 			          $pdf->Cell(14,3,number_format($sum_parc9,2),1,0,'R');
 	 			           $pdf->Cell(14,3,number_format($sum_parc10,2),1,0,'R');
 	 			            $pdf->Cell(14,3,number_format($sum_parc11,2),1,0,'R');
 	 			             $pdf->Cell(14,3,number_format($sum_parc12,2),1,0,'R');
 	 			              $pdf->Cell(14,3,number_format($sum_parc13,2),1,0,'R');
 	 			               $pdf->Cell(14,3,number_format($sum_parc14,2),1,0,'R');
 	 			                $pdf->Cell(14,3,number_format($sum_parc15,2),1,0,'R');
 	 			                 $pdf->Cell(14,3,number_format($sum_parc16,2),1,1,'R');
 	 			                  	$pdf->Ln(2);
 	 			}
 	 				  //$desc_uo=$detalle_show[$h][2];
 	 			  $pdf->SetFont('Arial','B',7);
 	 				  $pdf->Cell(205,5,$detalle_show[$h][1],0,1);
 	 			   $pdf->SetFont('Arial','',6);
 	 			   $sum_parc1=0;
 	 			  $sum_parc2=0;
 	 			   $sum_parc3=0;
 	 			    $sum_parc4=0;
 	 			     $sum_parc5=0;
 	 			      $sum_parc6=0;
 	 			       $sum_parc7=0;
 	 			        $sum_parc8=0;
 	 			         $sum_parc9=0;
 	 			          $sum_parc10=0;
 	 			           $sum_parc11=0;
 	 			            $sum_parc12=0;
 	 			             $sum_parc13=0;
 	 			              $sum_parc14=0;
 	 			               $sum_parc15=0;
 	 			                $sum_parc16=0;
 	 			  //$id_lugar=$detalle_show[$h][0];
 	 			}
 	 			 $sum_parc1=$sum_parc1+$detalle_show[$h][4];
 	 			 $sum_parc2=$sum_parc2+$detalle_show[$h][5];
 	 			 $sum_parc3=$sum_parc3+$detalle_show[$h][6];
 	 			 $sum_parc4=$sum_parc4+$detalle_show[$h][7];
 	 			 $sum_parc5=$sum_parc5+$detalle_show[$h][8];
 	 			 $sum_parc6=$sum_parc6+$detalle_show[$h][9];
 	 			 $sum_parc7=$sum_parc7+$detalle_show[$h][10];
 	 			 $sum_parc8=$sum_parc8+$detalle_show[$h][11];
 	 			 $sum_parc9=$sum_parc9+$detalle_show[$h][12];
 	 			 $sum_parc10=$sum_parc10+$detalle_show[$h][13];
 	 			 $sum_parc11=$sum_parc11+$detalle_show[$h][14];
 	 			 $sum_parc12=$sum_parc12+$detalle_show[$h][15];
 	 			 $sum_parc13=$sum_parc13+$detalle_show[$h][16];
 	 			 $sum_parc14=$sum_parc14+$detalle_show[$h][17];
 	 			 $sum_parc15=$sum_parc15+$detalle_show[$h][18];
 	 			 $sum_parc16=$sum_parc16+$detalle_show[$h][19];
 	 			 
 	 			 /* para lo total *///
 	 			 $sum_total1=$sum_total1+$detalle_show[$h][4];
 	 			 $sum_total2=$sum_total2+$detalle_show[$h][5];
 	 			 $sum_total3=$sum_total3+$detalle_show[$h][6];
 	 			 $sum_total4=$sum_total4+$detalle_show[$h][7];
 	 			 $sum_total5=$sum_total5+$detalle_show[$h][8];
 	 			 $sum_total6=$sum_total6+$detalle_show[$h][9];
 	 			 $sum_total7=$sum_total7+$detalle_show[$h][10];
 	 			 $sum_total8=$sum_total8+$detalle_show[$h][11];
 	 			 $sum_total9=$sum_total9+$detalle_show[$h][12];
 	 			 $sum_total10=$sum_total10+$detalle_show[$h][13];
 	 			 $sum_total11=$sum_total11+$detalle_show[$h][14];
 	 			 $sum_total12=$sum_total12+$detalle_show[$h][15];
 	 			 $sum_total13=$sum_total13+$detalle_show[$h][16];
 	 			 $sum_total14=$sum_total14+$detalle_show[$h][17];
 	 			 $sum_total15=$sum_total15+$detalle_show[$h][18];
 	 			 $sum_total16=$sum_total16+$detalle_show[$h][19];
 	 			 
 	 			 $pdf->MultiTabla($detalle_show[$h],0,3,3,6,1);
 	 		}
 	 		 $pdf->SetFont('Arial','B',6);
 	 		$pdf->Cell(50,3,'SUB-TOTAL:','RBT',0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_parc1,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_parc2,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_parc3,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_parc4,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_parc5,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_parc6,2),1,0,'R');
 	 	    $pdf->Cell(14,3,number_format($sum_parc7,2),1,0,'R');
 	 	    $pdf->Cell(14,3,number_format($sum_parc8,2),1,0,'R');
 	 	    $pdf->Cell(14,3,number_format($sum_parc9,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_parc10,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_parc11,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_parc12,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_parc13,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_parc14,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_parc15,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_parc16,2),1,1,'R');
 	 		
 	 		//Para los totales
 	 		
 	$pdf->Cell(50,3,'TOTAL:','RBT',0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_total1,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_total2,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_total3,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_total4,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_total5,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_total6,2),1,0,'R');
 	 	    $pdf->Cell(14,3,number_format($sum_total7,2),1,0,'R');
 	 	    $pdf->Cell(14,3,number_format($sum_total8,2),1,0,'R');
 	 	    $pdf->Cell(14,3,number_format($sum_total9,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_total10,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_total11,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_total12,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_total13,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_total14,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_total15,2),1,0,'R');
 	 		$pdf->Cell(14,3,number_format($sum_total16,2),1,1,'R');
 
 	
 	
 
$pdf->Output();

?>