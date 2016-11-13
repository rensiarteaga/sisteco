<?php
session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de creacion: 23/03/2011
 * Descripción: Reporte de Empleados y Cuentas Bancarias 
 *
 *
 ***/
require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
 
class PDF extends FPDF
{   
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    $this-> AddFont('Arial','','arial.php');
 
    //Iniciación de variables
    }

function SetCuentaBancaria($cuentaBancaria)
{
    $this->cuentaBancaria =$cuentaBancaria;
}
function SetNombreLugar($nombreLugar)
{
    $this->nombreLugar =$nombreLugar;
}

function Header()
{       
   $this->Image('../../../../lib/images/logo_reporte.jpg',180,0,30,10);//ENDE-0001:04/09/2012: LOGO ENDE CORP.
   $cabecera=$_SESSION['PDF_cab_rep_planilla'];
   $this->SetFont('Arial','B',8);
	$this->Cell(30,3,'No. Patronal:511-2067',0,1);
	$this->Cell(30,3,'N.I.T.: 1023187029',0,1);
   $this->SetFont('Arial','BU',12);
   $this->Cell(0,5,'ABONOS A CUENTA '. $this->cuentaBancaria.'',0,1,'C');
    $this->SetFont('Arial','B',10);
    
    
    $tipo_reporte=$_SESSION["tipo_pago"]; 
    $detalle='';
    
    if ($tipo_reporte=='BONMES'){
    	$detalle='Bono de Te y Transporte';
    }else{
    	if ($tipo_reporte=='BONO_TRA'){
    		$detalle='Bono de Transporte';
    	}else{
    		if ($tipo_reporte=='REFRIGERIO'){
    			$detalle='Reposicion de Refrigerio '. $cabecera[0]['numero'].' : ';
    		}else{
    			if ($tipo_reporte=='BONO_TE'){
    				$detalle='Bono de Té';
    			}
    		}
    	}
    }
    /********************** mod ana solucitud susan  *********************/
  //$this->Cell(0,5,$detalle.' '.$cabecera[0]['periodo'].'-'.$cabecera[0]['gestion'],0,1,'C');
	if($tipo_reporte=='PRIMA' ){
    		$this->Cell(0,5,$detalle,0,1,'C');
    	}else{
    		
    		if($tipo_reporte=='REFRIGERIO'){
    			$this->Cell(0,3,$detalle,0,1,'C');
    		}else{  
    			if($tipo_reporte=='BONMES'|| $tipo_reporte=='BONO_TRA' || $tipo_reporte=='BONO_TE'){
    				$this->Cell(0,5,$detalle.' '.$cabecera[0]['periodo_anterior'].'-'.$cabecera[0]['gestion'],0,1,'C');
    			}else{
    			
    				$this->Cell(0,5,$detalle.' '.$cabecera[0]['periodo'].'-'.$cabecera[0]['gestion'],0,1,'C');
    			}
    		}
    	}
    
   $this->Ln(2);
   //Aqui mostrare la cabecera
    $this->SetFont('Arial','B',7);
      $this->Cell(15,3.5,''.$this->nombreLugar,0,1);
      
     $this->Cell(15,3.5,'CODIGO',1,0,'C');
	  if($_SESSION["reporte"]=='firma'){
    	 $x=90;
		 $saltoc=0;
	   }else{
	   	 $x=130;
		 $saltoc=1;
	   }
	 
   $this->Cell($x,3.5,'NOMBRE FUNCIONARIO',1,0,'C');
   $this->Cell(30,3.5,'Nº DE CUENTA',1,0,'C');
   if($_SESSION["tipo_pago"]=='LIQPAG'){
   	$this->Cell(20,3.5,'LIQ. PAGABLE',1,$saltoc,'C');
   }else{
	   	if($_SESSION["tipo_pago"]=='REFRIGERIO'|| $_SESSION["tipo_pago"]=='BONMES'|| $_SESSION["tipo_pago"]=='BONO_TRA'|| $_SESSION["tipo_pago"]=='BONO_TE'){
	   		 
	   		$this->Cell(20,3.5,'IMPORTE BONO',1,$saltoc,'C');
	   	}else{
	   		$this->Cell(20,3.5,'ANTICIPO',1,$saltoc,'C');
	   	}
   }
  if($_SESSION["reporte"]=='firma'){
          
   	$this->Cell(40,3.5,'FIRMA',1,1,'C');
	
   }

}
 
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
     $this->SetY(-7);
   	$this->pieHash('KARDEX');
 	
    /*$fecha=date("d-m-Y");
	$hora=date("H:i:s");
	  $this->SetY(-7);
	  $this->SetFont('Arial','',8);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - KARDEX',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
		$this->ln(3);*/
	
	
	  
   	  
     }

}
  	$pdf=new PDF();	
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,7);
    $pdf->SetMargins(5,5,5);  
    
    $pdf->SetFont('Arial','',8);
	
    
  
 
 	$cabecera=$_SESSION['PDF_cab_rep_planilla'];
 	$detalle=$_SESSION['PDF_lista_planilla_empleado_cb'];
	
	
 if($_SESSION["reporte"]=='firma'){
    	$x=90;
		//$detalle[$i][4]='';
		$y=40;
		$bandera=true;
		$visible=1;
	    }else{
		 $x=130;
	     $y=0;
		 $visible=0;
		 $bandera=false;
	   }
	   
	   $tamano_monto=20;
	  
	   
 	$pdf->SetWidths(array(15,$x,30,$tamano_monto,$y));
	$pdf->SetFills(array(0,0,0,0));
 	$pdf->SetAligns(array('L','L','R','R'));
 	$pdf->SetVisibles(array(1,1,1,1,$visible));
  	$pdf->SetFontsSizes(array(8,8,8,8,8));
 	$pdf->SetFontsStyles(array('','','',''));
 	$pdf->SetSpaces(array(4.5,4.5,4.5,4.5,4.5));
 	$pdf->setDecimales(array(0,0,0,2,0));
    $pdf->SetFormatNumber(array(0,0,0,1,0));
 	
 	        
 	      
 	 	
 	 		$desc_cb='';
 	 		$sum_parc=0;
 	 		$desc_lugar='';
 	 		$sum_parc_lugar=0;
 	 		$salto='no';
 	 			 
 	 		for ($i=0;$i<count($detalle);$i++){
 	 			/*if($_SESSION["reporte"]=='firma'){
    	     		$detalle[$i][4]='';
	             }
				 */
 	 			if($detalle[$i]["nombre_lugar"]<>$desc_lugar){
 	 			
 	 				if ($i!=0){
                     	
 	 				    $pdf->SetFont('Arial','BI',8);
						if ($bandera){
						    $pdf->Cell(135,4.5,'TOTAL','RTB',0,'R');
						}else{
                     	    $pdf->Cell(175,4.5,'TOTAL','RTB',0,'R');
						}
                     	$pdf->Cell($tamano_monto,4.5,number_format($sum_parc,2),'TB',1,'R');
                     	//$pdf->AddPage();
                     	  
                     }
 	 				 $pdf->SetCuentaBancaria($detalle[$i]["nombre_banco"]);
 	 				 $pdf->SetNombreLugar($detalle[$i]["nombre_lugar"]);
 	 				
 	 				 $desc_lugar=$detalle[$i]["nombre_lugar"];
					 //$desc_cb=$detalle[$i]["nombre_banco"];
 	 				 //$desc_cb=$detalle[$i]["nombre_banco"];
 	 				 if($i!=0){
 	 					$salto='si';
 	 				    $pdf->AddPage();
 	 				 }
 	 				 $sum_parc=0;
 	 			     $sum_parc_lugar=0;
 	 			
 	 			}
				//if ($detalle[$i]["nombre_banco"]=='PAGO_CON CHEQUE'){
					  //  echo "nombre entra a pago con cheque".$detalle[$i]["nombre_banco"];
						//exit;
					//}
 	 			  if($detalle[$i]["nombre_banco"]<>$desc_cb )
 	 			  {   
 	 				$pdf->SetNombreLugar($detalle[$i]["nombre_lugar"]);
 	 				$pdf->SetCuentaBancaria($detalle[$i]["nombre_banco"]);
 	 				 if ($i!=0){
                     	if($salto=='si'){
 	 				         $pdf->SetFont('Arial','BI',8);
						     if ($bandera){
                     	   		$pdf->Cell(135,4.5,'TOTAL','RTB',0,'R');
                     		}else{
								$pdf->Cell(175,4.5,'TOTAL','RTB',0,'R');
							}
							$pdf->Cell($tamano_monto,4.5,number_format($sum_parc,2),'TB',1,'R');
                     	}
                     	$pdf->AddPage();
                     	
                     }
 	 				
 	 				//if($desc_lugar!=$detalle[$i]["nombre_lugar"]){
 	 				if($salto=='no'){
 	 					$pdf->AddPage();
 	 				}
 	 				//}
 	 				
 	 				//Enviar a la cabecera para que muestre el nombre del banco
 	 			
 	 				$desc_cb=$detalle[$i]["nombre_banco"];
 	 				//$sum_parc=$sum_parc+$detalle[$i]['valor'];
 	 				$sum_parc=0;
 	 				$sum_parc_lugar=0;
 	 				
 	 			  }
 	 			
 	 			
 	 			//} 
 	 			$sum_parc=$sum_parc+$detalle[$i]['valor'];
 	 			$sum_parc_lugar=$sum_parc_lugar+$detalle[$i]['valor'];
 	 			$pdf->SetLineWidth(0.05);
				//$firma=array();
				$firma='';
				if ($bandera){
					$detalle[$i][4]='';
				}
 	 			$pdf->MultiTabla($detalle[$i],0,3,4.5,8,1);
 	 			$pdf->SetLineWidth(0.1);
 	 			             
 	 			     
 	 		}
			
			  
 	 		 $pdf->SetFont('Arial','BI',8);
			 if ($bandera){
 	 			$pdf->Cell(135,4.5,'TOTAL','RTB',0,'R');
                $pdf->Cell($tamano_monto,4.5,number_format($sum_parc,2),'TB',1,'R');
             }else{
			    $pdf->Cell(175,4.5,'TOTAL','RTB',0,'R');
                $pdf->Cell($tamano_monto,4.5,number_format($sum_parc,2),'TB',1,'R');
             }
 	
 
 	
 	
 
$pdf->Output();

?>