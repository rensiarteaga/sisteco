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
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    $this-> AddFont('Arial','','arial.php');
 
    //Iniciación de variables
    }



function Header()
{       
   $this->Image('../../../../lib/images/logo_reporte.jpg',180,0,30,10);
   $cabecera=$_SESSION['PDF_cab_rep_planilla'];
   $this->SetFont('Arial','B',7);
	
  // $this->Cell(0,5,'',0,1,'C');
     $this->SetFont('Arial','B',12);
   $this->Cell(0,5,'DETALLE DE MARCAS ',0,1,'C');
   $this->Cell(0,5,'CORRESPONDIENTE A : '.$_SESSION["PDF_datos_cabecera"][0].'-'.$_SESSION["PDF_datos_cabecera"][1],0,1,'C');
   
   //FALTA EL PERIODO  $this->Cell(0,5,'CORRESPONDIENTE '.$cabecera[0]['descripcion'],1,1);
  // $this->Cell(0,5,'(Expresado en  '.$cabecera[0]['nombre_moneda'].')',0,1,'C');
   $this->Cell(0,0.01,'',1,1);
   $this->Ln(2);
   //Aqui mostrare la cabecera
     $this->SetFont('Arial','',5);
    $fila_mod=0;
    $col=0;
    $detalle_col_mod=array();
  
 	$detalle_col=$_SESSION['PDF_planilla_col'];
 	$desc_incr_columna='';
 	
 	
    $this->SetWidths(array(1,35,13,11,11,11,11,13,11,11,11,11,13,11,11,11,11));
	$this->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
 	$this->SetAligns(array('L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L','L'));
 	$this->SetVisibles(array(0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
 	$this->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6));
 	$this->SetFontsStyles(array('','','','','','','','','','','','','','','','','',''));
 	$this->SetDecimales(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
 	$this->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
 	$this->SetFillColor(255,255,255);
 	$this->SetDrawColor(0,0,0);
 	$indice=0; 
 	
 	// }
 	 $desc='';
 	
 	
 		
 	 $this->SetLineWidth(1);
 	 $this->SetDrawColor(255,255,255);
 	
 	 $this->Ln(2);
 	$this->Cell(0,0.01,'',1,1);
 	
 
 	
 
}
 
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
     $this->SetY(-9);
   	$this->pieHash('CASIS');
 	
    
      }

}
  	$pdf=new PDF();	
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,9);
    $pdf->SetMargins(5,5,5);  
    
    $pdf->SetFont('Arial','',5);
	
    $pdf->AddPage();


 	
 	$detalle=$_SESSION['PDF_det_marcas'];
 	
 	$size_col=sizeof($detalle_col);
 	$id_empleado=0;
 	$fila_det=0;
 	$desc_incr_columna='';
 	

    
 	$indice=0;
 	$col_det=2;

 	 for ($i=0;$i<=sizeof($detalle);$i++)
 	 {
 	 	
 	      	 	
 	 	if ($id_empleado!=$detalle[$i]['id_empleado']){
 	 		
 	 		if($detalle[$i]['id_empleado']>0){
 	 		$col_det=2;
 	 		if($i>0){
 	 			
 	 				 			
 	 			$fila_det=$fila_det+3;
 	 			
 	 		}else{
 	 			
 	 			$fila_det=$fila_det;
 	 		}
 	 		$id_empleado=$detalle[$i]['id_empleado'];
 	 		$detalle_mod[$fila_det][0]=$detalle[$i]['id_empleado'];
 	 		$detalle_mod[$fila_det][1]=$detalle[$i]['nombre_completo'];
 	 		$detalle_mod[$fila_det+1][$col_det]=$detalle[$i]['fecha'];//$indice+1;//id_tipo_columna
 	 		$detalle_mod[$fila_det+1][$col_det+1]='E. AM';//$indice+1;//id_tipo_columna
 	 		$detalle_mod[$fila_det+1][$col_det+2]='S. AM';//$indice+1;//id_tipo_columna
 	 		$detalle_mod[$fila_det+1][$col_det+3]='E. PM';//$indice+1;//id_tipo_columna
 	 		$detalle_mod[$fila_det+1][$col_det+4]="S. PM";//$indice+1;//id_tipo_columna
 	 		
 	 		$detalle_mod[$fila_det+2][$col_det+1]=$detalle[$i]['entrada_am'];
 	 		$detalle_mod[$fila_det+2][$col_det+2]=$detalle[$i]['salida_am'];
 	 		$detalle_mod[$fila_det+2][$col_det+3]=$detalle[$i]['entrada_pm'];
 	 		$detalle_mod[$fila_det+2][$col_det+4]=$detalle[$i]['salida_pm'];
 	 		$col_det=$col_det+5;
 	 		}
 	 	}else{
 	 		if ($col_det<17){
 	 			
 	 			$detalle_mod[$fila_det+1][$col_det]=$detalle[$i]['fecha'];//$indice+1;//id_tipo_columna
 	 			$detalle_mod[$fila_det+1][$col_det+1]='E. AM';//$indice+1;//id_tipo_columna
 	 			$detalle_mod[$fila_det+1][$col_det+2]='S. AM';//$indice+1;//id_tipo_columna
 	 			$detalle_mod[$fila_det+1][$col_det+3]='E. PM';//$indice+1;//id_tipo_columna
 	 			$detalle_mod[$fila_det+1][$col_det+4]="S. PM";//$indice+1;//id_tipo_columna
 	 			$detalle_mod[$fila_det+1][$col_det+5]="XXX";//$indice+1;//id_tipo_columna
 	 			$detalle_mod[$fila_det+1][$col_det+6]="XXX";//$indice+1;//id_tipo_columna
 	 			$detalle_mod[$fila_det+2][$col_det]='';//$indice+1;//id_tipo_columna
 	 			$detalle_mod[$fila_det+2][$col_det+1]=$detalle[$i]['entrada_am'];
 	 			$detalle_mod[$fila_det+2][$col_det+2]=$detalle[$i]['salida_am'];
 	 			$detalle_mod[$fila_det+2][$col_det+3]=$detalle[$i]['entrada_pm'];
 	 			$detalle_mod[$fila_det+2][$col_det+4]=$detalle[$i]['salida_pm'];
 	 		$detalle_mod[$fila_det+2][$col_det+5]="XXX";//$indice+1;//id_tipo_columna
 	 		$detalle_mod[$fila_det+2][$col_det+6]="XXX";//$indice+1;//id_tipo_columna
 	 			$detalle_mod[$fila_det+2][$col_det+7]="XXX";//$indice+1;//id_tipo_columna
 	 			$col_det=$col_det+5;
 	 			
 	 			
 	 		}else{
 	 			$col_det=2;
 	 			$fila_det=$fila_det+2;
 	 			
 	 			$detalle_mod[$fila_det+1][$col_det]=$detalle[$i]['fecha'];//$indice+1;//id_tipo_columna
 	 			$detalle_mod[$fila_det+1][$col_det+1]='E. AM';//$indice+1;//id_tipo_columna
 	 			$detalle_mod[$fila_det+1][$col_det+2]='S. AM';//$indice+1;//id_tipo_columna
 	 			$detalle_mod[$fila_det+1][$col_det+3]='E. PM';//$indice+1;//id_tipo_columna
 	 			$detalle_mod[$fila_det+1][$col_det+4]="S. PM";//$indice+1;//id_tipo_columna
 	 			
 	 			
 	 			$detalle_mod[$fila_det+2][$col_det+1]= $detalle[$i]['entrada_am'];
 	 			$detalle_mod[$fila_det+2][$col_det+2]=$detalle[$i]['salida_am'];
 	 			$detalle_mod[$fila_det+2][$col_det+3]=$detalle[$i]['entrada_pm'];
 	 			$detalle_mod[$fila_det+2][$col_det+4]=$detalle[$i]['salida_pm'];
 	 			
 	 		    if($detalle[$i+1]['id_empleado']!=$id_empleado){
 	 				$detalle_mod[$fila_det+1][$col_det+5]="XXX";//$indice+1;//id_tipo_columna
 	 				$detalle_mod[$fila_det+1][$col_det+6]="XXX";//$indice+1;//id_tipo_columna
 	 				$detalle_mod[$fila_det+2][$col_det+5]="XXX";//$indice+1;//id_tipo_columna
 	 				$detalle_mod[$fila_det+2][$col_det+6]="XXX";//$indice+1;//id_tipo_columna
 	 				$detalle_mod[$fila_det+2][$col_det+7]="XXX";//$indice+1;//id_tipo_columna
 	 			}
 	 			
 	 			$col_det=$col_det+5;
 	 			
 	 			
 	 		}
 	 		
 	 		
 	 	}
 	 	
 	 	
 	 	
 	 	
 	 	
 	 	
 	 	
 	 /*	if(($id_empleado!=$detalle[$i]['id_empleado']) )
 	 	{
 	 	   $desc_incr_columna=$detalle[$i]['nombre_completo'];
 	 	   $id_empleado=$detalle[$i]['id_empleado'];
 	 	
 	 		if($i==0){
 	 			$fila_det=0;
 	 		}else{
 	 			if($detalle[$i-1]['total']=='si'){
 	 			$fila_det=$fila_det;	
 	 			}else{
 	 			$fila_det=$fila_det+1;
 	 			}
 	 		}
 	 		$col_det=2;
 	    	$indice=0;
 	    	$detalle_mod[$fila_det][0]=$detalle[$i]['id_empleado'];
 	 		$detalle_mod[$fila_det][1]=$detalle[$i]['nombre_completo'];
 	 		$detalle_mod[$fila_det][$col_det]=$detalle[$i]['fecha'];//$indice+1;//id_tipo_columna
 	 		$detalle_mod[$fila_det+1][$col_det]=$detalle[$i]['entrada_am'];
 	 		//$detalle_mod[$fila_det+1][$col_det+1]=$detalle[$i]['entrada_am'];
 	 	
 	 		
 	 		$col_det=$col_det+2;
 	 		$indice=$indice+1;
 	 	} else{
 	 	
		 	 	
		 	 	if($col_det < 14){
		 	 		$detalle_mod[$fila_det][0]=$detalle[$i]['id_empleado'];
		 	 		$detalle_mod[$fila_det][1]=$detalle[$i]['nombre_completo'];
		 	 		$detalle_mod[$fila_det][$col_det]=$indice+1;//id_tipo_columna
		 	 		$detalle_mod[$fila_det][$col_det+1]=$detalle[$i]['fecha'];
		 	 		//$detalle_mod[$fila_det+1][$col_det+1]=$detalle[$i]['entrada_am'];
		 	 		$detalle_mod[$fila_det+1][$col_det+1]='AAAAAA <14';
		 	 		
		 	 		$col_det=$col_det+2;
		 	 		$indice=$indice+1;
		 	    }else{
		 	    	$fila_det=$fila_det+1;
		 	    	$col_det=2;
		 	    	
		 	    	
		 	    	$detalle_mod[$fila_det][0]=$detalle[$i]['id_empleado'];
		 	 		$detalle_mod[$fila_det][1]=$detalle[$i]['nombre_completo'];
		 	 		
		 	    	$detalle_mod[$fila_det][$col_det]=$indice+1;//id_tipo_columna
		 	 		$detalle_mod[$fila_det][$col_det+1]=$detalle[$i]['fecha'];
		 	 		//$detalle_mod[$fila_det+1][$col_det+1]=$detalle[$i]['entrada_am'];
		 	 		$detalle_mod[$fila_det][$col_det+1]='BBBBB > 14';
		 	 		
		 	 		$indice=$indice+1;	
		 	 		$col_det=$col_det+2;
		 
		 	  	  }
		 		}*/
 	 	
 	 }
 	 
 	 
 	
  

 	$pdf->SetFillColor(255,255,255);
 	$nombre_empleado1='';
 	$desc='';
 	$nombre_descripcion='';
 	
 	
 
 	
 	
 	//$band_empleado=0;
 	$nombre_lugar='';
 	$id_lugar_anterior=0;
 	for ($j=0;$j<=sizeof($detalle_mod);$j++){
 		
 	        
 		if($nombre_empleado!=$detalle_mod[$j][0])
 	 			{
					if($pdf->GetY()>220){
						$pdf->AddPage();
					}
 	
 	
 	 			$nombre_empleado=$detalle_mod[$j][0];
 	 				
 	 			}
 	 		 $pdf->SetLineWidth(0.05);
 	 		 $pdf->SetDrawColor(200,200,200);
 	 		 $pdf->MultiTabla($detalle_mod[$j],0,3,3,6);
	 	 	 $pdf->SetDrawColor(0,0,0);
	 	 	
 	 			}
 		


 	
      $pdf->SetFont('Arial','BI',5);
  	 
 	
 	
 	
 //$pdf->AddPage();
 	

  $pdf->SetFont('Arial','',7);
    
  
 
  
 /************** fin procedimiento para volver un array *******************/
 

		
 	
$pdf->Output();

?>