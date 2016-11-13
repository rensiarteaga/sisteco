<?php
session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de creacion: 06/04/2011
 * Descripción: Reporte de Empleados y Bonos
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


function Header()
{       
   $this->Image('../../../../lib/images/logo_reporte.jpg',180,0,30,10);//ENDE-0001:04/09/2012: LOGO ENDE CORP.
   $cabecera=$_SESSION['PDF_cab_rep_planilla'];
   $this->SetFont('Arial','B',7);
   $this->Cell(30,3,'No. Patronal:511-2067',0,1);
   $this->Cell(30,3,'N.I.T.: 1023187029',0,1);
   $this->SetFont('Arial','BU',12);
   $this->Cell(0,5,' DETALLE DE '. $_SESSION['titulo'].'',0,1,'C');
   $this->SetFont('Arial','B',8);
   
   if($_SESSION["tipo_reporte"]=='BONO_ROPA'){
   		$this->Cell(0,5,$cabecera[0]['grupo_periodo'].'-'.$cabecera[0]['gestion'],0,1,'C');
   }
   else{
      if($_SESSION["tipo_reporte"]=='BONO_TE' || $_SESSION["tipo_reporte"]=='BONO_TRA'){
        $this->Cell(0,5,$cabecera[0]['periodo_anterior'].'-'.$cabecera[0]['gestion'],0,1,'C');
      }else{
      	$this->Cell(0,5,$cabecera[0]['periodo'].'-'.$cabecera[0]['gestion'],0,1,'C');
      }
   }
   
   
   //$this->Cell(0,5,$cabecera[0]['periodo'].'-'.$cabecera[0]['gestion'],0,1,'C');
   $this->Ln(2);
   //Aqui mostrare la cabecera
    $this->SetFont('Arial','B',8);
    
    if (''.$this->PageNo()!='{nb}'){
     $this->Cell(15,3.5,'CODIGO',1,0,'C');
   $this->Cell(110,3.5,'NOMBRE FUNCIONARIO',1,0,'C');
  
   
   if($_SESSION["tipo_reporte"]=='DESQUIN' ||$_SESSION["tipo_reporte"]=='PAGOAGUINTODOS'   ||$_SESSION["tipo_reporte"]=='PAGOAGUINTODOSCONS' ){
     $this->Cell(40,3.5,'CUENTA',1,0,'C');	
     $this->Cell(40,3.5,'VALOR ASIGNADO',1,1,'C');
   }else{
     $this->Cell(30,3.5,'VALOR ASIGNADO',1,0,'C');
     $this->Cell(50,3.5,'FIRMA',1,1,'C');
   }
   
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
	  $this->SetFont('Arial','',6);
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
    $pdf->AddPage();
    $pdf->SetFont('Arial','',6);
	


    $detalle=array();
 	$cabecera=$_SESSION['PDF_cab_rep_planilla'];
 	$detalle=$_SESSION["PDF_lista_planilla_empleado_bonos"];
 	/*print_r($detalle);
 	exit;*/
    if($_SESSION["tipo_reporte"]=='DESQUIN' ||$_SESSION["tipo_reporte"]=='PAGOAGUINTODOS'  ||$_SESSION["tipo_reporte"]=='PAGOAGUINTODOSCONS' ){
 	   $pdf->SetWidths(array(15,110,40,40));
 	   	$pdf->SetSpaces(array(3.5,3.5,3.5,3.5,3.5,3.5));
    }else{
    	$pdf->SetSpaces(array(7,7,7,7,7,7));
 		$pdf->SetWidths(array(15,110,30,50));
 	}
	$pdf->SetFills(array(0,0,0,0));
 	$pdf->SetAligns(array('L','L','R','R'));
 	$pdf->SetVisibles(array(1,1,1,1));	
 	
 	
 	
  	$pdf->SetFontsSizes(array(8,8,8,8,8,8));
 	$pdf->SetFontsStyles(array('','','','','',''));
 	//$pdf->SetSpaces(array(3.5,3.5,3.5,3.5,3.5,3.5));
 	$pdf->setDecimales(array(0,0,2,0,0,0));
    $pdf->SetFormatNumber(array(0,0,1,0,0,0));
 	
 	  		$desc_cb='';
 	 		$sum_parc=0;
 	 		$nom_lugar=''; 
 	 		$sw_cuenta='0';
 	 		$sum_parc_c_cheq=0;
 	 		$variable=0;
			$var_trinidad='';
 	 		
 	 		for ($i=0;$i<count($detalle);$i++){
 	 			if (($detalle[$i][0])!='19516'){
 	 		/*echo $detalle[$i][0];
 	 		exit;*/
 	 			/*if ($nom_lugar=='TR -  TRINIDAD')
					{
					  $nom_lugar=(substr($detalle[$i]['prioridad'], 0, 3));
					  
					}
				if ($detalle[$i]['nombre_lugar']!='TR -  TRINIDAD')
				{
				  $cadena_preg=$detalle[$i]['nombre_lugar']; ;  
				}else
				*/
 	 		//	if(($detalle[$i]['nombre_lugar']!=$nom_lugar)){
 	 				/*if ($detalle[$i]['nombre_lugar']=='TR -  TRINIDAD')
				{
				  $cadena_preg=(substr($detalle[$i]['prioridad'], 0, 3));  
				}*/
				/*else{
				   $cadena_preg=$detalle[$i]['nombre_lugar']; 
				}*/
				
                  /*modana   if ($i!=0){
                     	
 	 				    $pdf->SetFont('Arial','BI',7);
 	 				     if($_SESSION["tipo_reporte"]=='DESQUIN' ||$_SESSION["tipo_reporte"]=='PAGOAGUIN'){
 	 				     	 if(is_null($detalle[$i-1]['nro_cuenta'])){
 	 				     	   $pdf->Cell(165,3.5,'TOTAL PARCIAL','RTB',0,'R');
                     	       $pdf->Cell(40,3.5,number_format($sum_parc_c_cheq,2),'TB',1,'R');
 	 				     	 }else {
 	 				     	 	$pdf->Cell(165,3.5,'TOTAL PARCIAL','RTB',0,'R');
                     	        $pdf->Cell(40,3.5,number_format($sum_parc,2),'TB',1,'R');
 	 				     	 }
                    
 	 				     }else{
 	 				     	$pdf->Cell(165,3.5,'TOTAL PARCIAL','RTB',0,'R');
                     	    $pdf->Cell(40,3.5,number_format($sum_parc,2),'TB',1,'R');
                    
 	 				     }
                     	$pdf->AddPage();
                     }
                 	$pdf->SetFont('Arial','BUI',8);
	                $pdf->Ln(2); fin ana**/
					/*if ($detalle[$i]['nombre_lugar']=='TR -  TRINIDAD')
					{
					  $nom_lugar=(substr($detalle[$i]['prioridad'], 0, 3));
					}else{*/
 	 				/*modana $nom_lugar=$detalle[$i]['nombre_lugar'];*/
					/*}*/
					/*echo (substr($detalle[$i]['nombre_lugar'], 0, 3));
					exit;*/
					/*if((substr($detalle[$i]['prioridad'], 0, 3))=='BT2'){
					$nombre_lugar="TRINIDAD TRANSMISION";
                   
					}
					else if ((substr($detalle[$i]['prioridad'], 0, 3))=='BT1'){
					$nombre_lugar="TRINIDAD GENERACIÓN";
					}
					if ($detalle[$i]['nombre_lugar']=='TR -  TRINIDAD'){
					   $pdf->Cell(80,4,''.$nombre_lugar,0,1);
					}else{*/
 	 				/*$pdf->Cell(80,4,''.$nom_lugar,0,1);
 	 				/*}*/
                    /*mod ana$pdf->SetFont('Arial','',8);
	
 	 				$sum_parc=0;***/ 
 	 			
 	 			 //para el total parcial de anticipos 
                     
                    // if(is_null($detalle[$i]['nro_cuenta']) && $_SESSION["tipo_reporte"]=='DESQUIN'){
                  /*   if(is_null($detalle[$i]['nro_cuenta']) && $_SESSION["tipo_reporte"]=='DESQUIN'){
                     	  $pdf->SetFont('Arial','BI',7);
                     	$pdf->Cell(165,3.5,'TOTAL PARCIAL','RTB',0,'R');
                     	$pdf->Cell(40,3.5,number_format($sum_parc,2),'TB',1,'R');
                     }*/
                     //fin total parcia de anticipos
                   
 	 			
 	 			   //para el reporte de anticipos
                //    if(($_SESSION["tipo_reporte"]=='DESQUIN' ) && is_null($detalle[$i]['nro_cuenta'])){

                    	if(($_SESSION["tipo_reporte"]=='DESQUIN' ||$_SESSION["tipo_reporte"]=='PAGOAGUINTODOS'  ||$_SESSION["tipo_reporte"]=='PAGOAGUINTODOSCONS') ){
                     	$pdf->setDecimales(array(0,0,0,2,0,0));
                       $pdf->SetFormatNumber(array(0,0,0,1,0,0));
                        $detalle[$i][1]=substr($detalle[$i]['nombre_completo' ],1);
                       $detalle[$i][2]=$detalle[$i]['nro_cuenta'];
 		               $detalle[$i][3]=$detalle[$i]['valor'];
                    	if(is_null($detalle[$i]['nro_cuenta'])){
                    		$sum_parc_c_cheq=$sum_parc_c_cheq+$detalle[$i]['valor'];
 	 			           // $sum_total=$sum_total+$detalle[$i]['valor'];
 	 			            $pdf->SetLineWidth(0.05);
                     		$sw_cuenta=$detalle[$i]['nro_cuenta'];
                     		/*if(($i-1)!=$variable){
                     				  $pdf->SetFont('Arial','BI',7);
                     	$pdf->Cell(165,3.5,'TOTAL PARCIAL','RTB',0,'R');
                     	$pdf->Cell(40,3.5,number_format($sum_parc,2),'TB',1,'R');
                     		$pdf->AddPage();	
                     		$variable=$i;
                     		$pdf->Cell(165,3.5,$detalle[$i]['nombre_lugar'].' (PAGO CON CHEQUE)',0,1,'L');
                     		}*/
                     		
                     		
                     		
                     		
 		               		
                     	}
                     	  //$detalle[$i][1]=substr($detalle[$i]['nombre_completo' ],0,1);
                     	  $sum_parc=$sum_parc+$detalle[$i]['valor'];
 	 			          $sum_total=$sum_total+$detalle[$i]['valor'];
                     	 $pdf->MultiTabla($detalle[$i],0,3,3.5,8,1);
                     }else {
                     	  $detalle[$i][1]=substr($detalle[$i]['nombre_completo' ],1);
                     	$sum_parc=$sum_parc+$detalle[$i]['valor'];
 	 			       $sum_total=$sum_total+$detalle[$i]['valor'];
 	 			       $pdf->SetLineWidth(0.05);
                     	$detalle[$i][3]='';
                     	$pdf->MultiTabla($detalle[$i],0,3,7,8,1);
                     }
                     //para el reporte de anticipos
 	 		
 	 			$pdf->SetLineWidth(0.1);
 	 			                  
 	 		}
 	 		}
 	 		$sum_detalle=$_SESSION["PDF_sum_planilla_empleado_bonos"];
 	 		 $pdf->SetFont('Arial','BI',8);
 	 		 if($_SESSION["tipo_reporte"]=='DESQUIN' ||$_SESSION["tipo_reporte"]=='PAGOAGUINTODOS'  ||$_SESSION["tipo_reporte"]=='PAGOAGUINTODOSCONS'){
 	 			/*ana $pdf->Cell(165,3.5,'TOTAL PARCIAL','RTB',0,'R');
 	 			//$pdf->Cell(40,3.5,'','RTB',0,'R');
                $pdf->Cell(40,3.5,number_format($sum_parc,2),'TB',1,'R');
                $pdf->AddPage();
                $pdf->Ln(2);
             	$pdf->Cell(65,3.5,'DISTRITO ','1',0,'C');*/
 	 			/*$pdf->Cell(65,3.5,'TOTAL ','1',1,'C');
 	 			$sum_total=0;
 	 			 $pdf->SetWidths(array(65,65));
 	 			 $pdf->SetVisibles(array(1,1));
 	 			 $pdf->setDecimales(array(0,2));
                 $pdf->SetFormatNumber(array(0,1));
                 $pdf->SetAligns(array('L','R'));
 	 		    for ($si=0;$si<count($sum_detalle);$si++){
 	 			$sum_total=$sum_total+$sum_detalle[$si]['valor'];
                $pdf->MultiTabla($sum_detalle[$si],0,3,3.5,8,1);
                
 	 		    }*/
 	 		     /* $pdf->SetFont('Arial','BI',8);
 	 		     $pdf->Cell(65,3.5,'TOTAL ','RTB',0,'R');
 	 		     $pdf->Cell(65,3.5,number_format($sum_total,2),'TB',1,'R');*/
               /*
 	 		 }else 
 	 		 {
 	 		 	/*$pdf->Cell(125,3.5,'TOTAL PARCIAL','RTB',0,'R');
                $pdf->Cell(30,3.5,number_format($sum_parc,2),'TB',1,'R');
                */
 	 		 	
                $pdf->Cell(125,3.5,'TOTAL ','RTB',0,'R');
                 $pdf->Cell(80,3.5,number_format($sum_total,2),'TB',1,'R');
 	 		 /*}
            
            /** Detalle de sumas en otra hoja */
            
 	/*$sum_detalle=$_SESSION["PDF_sum_planilla_empleado_bonos"];
 	
 	$pdf->MultiTabla($detalle[$i],0,3,3.5,8,1);*/
 	 		 }
 	
 	
 
$pdf->Output();

?>