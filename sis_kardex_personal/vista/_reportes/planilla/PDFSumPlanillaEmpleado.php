<?php
session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de creacion: 31/01/2010
 * Descripción: Reporte de Sumas Planillas por Empleado
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
   $this->Image('../../../../lib/images/logo_reporte.jpg',180,0,35,15);
   $cabecera=$_SESSION['PDF_cab_rep_planilla'];
   $this->SetFont('Arial','B',7);
	
	if ($_SESSION["id_planilla_sum"]<738){ //REQ29082016111704
		$this->Cell(30,3,'No. Patronal:511-2067',0,1);
		
	}
	$this->Cell(30,3,'N.I.T.: 1023187029',0,1);
  // $this->Cell(0,5,'',0,1,'C');
     $this->SetFont('Arial','B',12);
   $this->Cell(0,5,'RESUMEN PLANILLA DE SUELDOS Y SALARIOS ',0,1,'C');
   $this->Cell(0,5,'CORRESPONDIENTE A : '.$cabecera[0]['periodo'].'-'.$cabecera[0]['gestion'],0,1,'C');
   
   //FALTA EL PERIODO  $this->Cell(0,5,'CORRESPONDIENTE '.$cabecera[0]['descripcion'],1,1);
   $this->Cell(0,5,'(Expresado en  '.$cabecera[0]['nombre_moneda'].')',0,1,'C');
   $this->Cell(0,0.01,'',1,1);
   $this->Ln(2);
   //Aqui mostrare la cabecera
     $this->SetFont('Arial','',5);
    $fila_mod=0;
    $col=0;
    $detalle_col_mod=array();
  
 	$detalle_col=$_SESSION['PDF_planilla_col'];
 	$desc_incr_columna='';
 	
 	
    $this->SetWidths(array(4,27.5,0,4,27.5,0,4,27.5,0,4,27.5,0,4,27.5,0,4,27.5,0,4,15,0));
	$this->SetFills(array(0,0,0,0,0,0,0,0,0));
 	$this->SetAligns(array('R','L','R','R','L','R','R','L','R','R','L','R','R','L','R','R','L','R','R','L','R'));
 	$this->SetVisibles(array(1,1,0,1,1,0,1,1,0,1,1,0,1,1,0,1,1,0,1,1,0));
 	$this->SetFontsSizes(array(4,6,0,4,6,0,4,6,0,4,6,0,4,6,0,4,6,0,4,6,0,4,6));
 	$this->SetFontsStyles(array('','','','','','','',''));
 	$this->SetDecimales(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
 	$this->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
 	$this->SetFillColor(255,255,255);
 	$this->SetDrawColor(0,0,0);
 	$indice=0; 
 	 for ($i=0;$i<sizeof($detalle_col);$i++){
 	 	
 		if ($detalle_col[$i]['total']=='si'){
 	 	
 	 		$detalle_col_mod[$fila_mod][$col]="";//id_tipo_columna
 	 		$detalle_col_mod[$fila_mod][$col+1]="";
 	 		$detalle_col_mod[$fila_mod][$col+2]="";
 	 	
 	 		$h=$indice;
 	 		//while ($h%6!=0){
 	 		while ($col<18){
 	 			$col=$col+3;
 	 		$detalle_col_mod[$fila_mod][$col]="";//id_tipo_columna
 	 		$detalle_col_mod[$fila_mod][$col+1]="";
 	 		$detalle_col_mod[$fila_mod][$col+2]="";
 	 		$h++;
 	 		}
 	 		
 	 		$detalle_col_mod[$fila_mod][$col]=$indice+1;//id_tipo_columna
 	 		$detalle_col_mod[$fila_mod][$col+1]=$detalle_col[$i]['nombre'];
 	 		$detalle_col_mod[$fila_mod][$col+2]=$detalle_col[$i]['desc_incr_col'];
 	 		
 	 		$indice=$indice+1;
 	 		$col=0;
 	 		$fila_mod=$fila_mod+1;
 
 	 	}else {
 	 	
 	 	if(($desc_incr_columna!=$detalle_col[$i]['desc_incr_col']))
 	 	{
 	 	$desc_incr_columna=$detalle_col[$i]['desc_incr_col'];
 	 	
 	 		if($i==0){
 	 			$fila_mod=0;
 	 				
 	 		}else{
 	 		
 	 			$fila_mod=$fila_mod+1;
 	 		}
 	 		$indice=0;
 	    	$col=0;
 	    	$detalle_col_mod[$fila_mod][$col]=$indice+1;//id_tipo_columna
 	 		$detalle_col_mod[$fila_mod][$col+1]=$detalle_col[$i]['nombre'];
 	 		$detalle_col_mod[$fila_mod][$col+2]=$detalle_col[$i]['desc_incr_col'];
 	 		
 	 		$col=$col+3;
 	 		$indice=$indice+1;
 	 	} else{
 	 
 	// 	if(($indice % 6 )!=0){
 	 		if(($col < 18 )){
 	 		$detalle_col_mod[$fila_mod][$col]=$indice+1;//id_tipo_columna
 	 		$detalle_col_mod[$fila_mod][$col+1]=$detalle_col[$i]['nombre'];
 	 		$detalle_col_mod[$fila_mod][$col+2]=$detalle_col[$i]['desc_incr_col'];
 	 		
 	 		$col=$col+3;
 	 		$indice=$indice+1;
 	    }else{
 	    	$fila_mod=$fila_mod+1;
 	    	$col=0;
 	 		$detalle_col_mod[$fila_mod][$col]=$indice+1;//id_tipo_columna
 	 		$detalle_col_mod[$fila_mod][$col+1]=$detalle_col[$i]['nombre'];
 	 		$detalle_col_mod[$fila_mod][$col+2]=$detalle_col[$i]['desc_incr_col'];
 	 		$col=$col+3;
 	 		$indice=$indice+1;
 
 	 	   		}
 	 		}
 	 	}
 	 }
 	 $desc='';
 	
 	for ($j=0;$j<=sizeof($detalle_col_mod);$j++){
 		$this->SetLineWidth(0.05);
 	 	$this->SetDrawColor(200,200,200);
 
 	 	    $this->MultiTabla($detalle_col_mod[$j],0,3,3,6);
 		}
 		
 	 $this->SetLineWidth(1);
 	 $this->SetDrawColor(255,255,255);
 	
 	 $this->Ln(2);
 	$this->Cell(0,0.01,'',1,1);
 	 	$this->SetWidths(array(10,120,25,15,20,15));
		$this->SetVisibles(array(1,1,1,1,1,1,1));
	$this->SetFontsSizes(array(6,6,6,6,6,6));
	$this->SetSpaces(array(3,3,3,3,3,3));
 	$this->SetAligns(array('L','L','L','L','L','L'));
 	$this->SetDecimales(array(0,0,0,0,0,0,0));
 	
 	$this->SetWidths(array(10,160,15,15));
					 $this->SetVisibles(array(1,1,1,1));
					$this->SetFontsSizes(array(6,6,6,6));
					$this->SetSpaces(array(3,3,3,3));
 					$this->SetAligns(array('L','L','L','L'));
 					$this->SetFormatNumber(array(0,0,0,0,0,0));
 	/**** añadido por ana y tiene que ser borrado ****/
 	
 	   $this->SetWidths(array(30,20,4,27.5,4,27.5,4,27.5,4,27.5,4,27.5,4,27.5,4,15));
	$this->SetFills(array(0,0,0,0,0,0,0,0,0,0));
 	$this->SetAligns(array('R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R'));
 	//$pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
 	$this->SetVisibles(array(0,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
  	$this->SetFontsSizes(array(6,6,3,6,3,6,3,6,3,6,3,6,3,6,3,6,3,6,3,6,3,3,3,3,3,3,));
 	$this->SetFontsStyles(array('','','','','','','','',''));
 	$this->SetSpaces(array(2,3,2,3,2,3,2,3,2,3,2,3,2,3,2,3,2,3,2,3));
 	$this->SetDecimales(array(0,0,0,2,0,2,0,2,0,2,0,2,0,2,0,2,0));
 	
 /***** sdfasdf***/
 	
 	
 
}
 
//Pie de página
function Footer()
{
	 $this->SetY(-9);
   	$this->pieHash('KARDEX');
 	
    
	/* //Posición: a 1,5 cm del final
    $fecha=date("d-m-Y");
	$hora=date("H:i:s");
	    $this->SetY(-9);
	     $this->SetFont('Arial','',6);
   	//   $this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
   	   $this->Cell(70,3,'',0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,' ',0,0,'L');
		//$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		//$this->Cell(70,3,'Sistema: ENDESIS - KARDEX',0,0,'L');
		$this->Cell(70,3,'',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'',0,0,'L');	
		//$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
	
	*/
   
      }

}
  	$pdf=new PDF();	
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,9);
    $pdf->SetMargins(5,5,5);  
    
    $pdf->SetFont('Arial','',5);
	
    $pdf->AddPage();


 	$cabecera=$_SESSION['PDF_cab_rep_planilla'];
 	$detalle=$_SESSION['PDF_sum_det_rep_planilla'];
 	$detalle_col=$_SESSION['PDF_planilla_col'];
 	$detalle_sum_dist=$_SESSION["PDF_sum_empleados_distrito"];
 	$size_col=sizeof($detalle_col);
 	$id_uo=0;
 	$fila_det=0;
 	$desc_incr_columna='';
 	$desc_uo_base='';

    
 	$indice=0;
 	$col_det=2;
 	//aqui vuelve el vector en la forma que se quiere  mostrar la planilla ***/
   	
 	 for ($i=0;$i<=sizeof($detalle);$i++)
 	 {
 	 	
 	  		
 	 	/**
 	 	 * *********/
 	 	if ($detalle[$i]['total']=='si'){
 	 		$desc_uo_base=$detalle[$i]['desc_lugar'].'$'.$detalle[$i]['desc_uo'];
 	    	$detalle_mod[$fila_det][0]=$detalle[$i]['desc_lugar'].'$'.$detalle[$i]['desc_uo'];
 	 		$detalle_mod[$fila_det][1]=$detalle[$i]['desc_incr_col'];
 	    	$detalle_mod[$fila_det][$col_det]="";//id_tipo_columna
 	 		$detalle_mod[$fila_det][$col_det+1]="";
 	 		
 	 		$h=$indice;
 	 		while ($col_det<14){
 	 			$col_det=$col_det+2;
	 	 		$detalle_mod[$fila_det][0]=$detalle[$i]['desc_lugar'].'$'.$detalle[$i]['desc_uo'];
	 	 		$detalle_mod[$fila_det][1]=$detalle[$i]['desc_incr_col'];
	 	 		$detalle_mod[$fila_det][$col_det]="";//id_tipo_columna
	 	 		$detalle_mod[$fila_det][$col_det+1]="";
	 	 		$h++;
 	 		}
 	 	
 	 	    $detalle_mod[$fila_det][0]=$detalle[$i]['desc_lugar'].'$'.$detalle[$i]['desc_uo'];
 	 		$detalle_mod[$fila_det][1]=$detalle[$i]['desc_incr_col'];
 	    	$detalle_mod[$fila_det][$col_det]=$indice+1;//id_tipo_columna
 	 		$detalle_mod[$fila_det][$col_det+1]=$detalle[$i]['valor'];
 	 		$indice=$indice+1;	
 	 		
 	 		$col_det=2;
 	 		$fila_det=$fila_det+1;
 
 	 	}else {
 	 	 /* 
 	 	 */
 	 		if(($id_uo!=$detalle[$i]['id_uo']) || ($desc_incr_columna!=$detalle[$i]['desc_incr_col'])){
		 	 	$desc_incr_columna=$detalle[$i]['desc_incr_col'];
		 	 	$id_uo=$detalle[$i]['id_uo'];
		 	 	
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
		 	    	$detalle_mod[$fila_det][0]=$detalle[$i]['desc_lugar'].'$'.$detalle[$i]['desc_uo'];
		 	 		$detalle_mod[$fila_det][1]=$detalle[$i]['desc_incr_col'];
		 	 		$detalle_mod[$fila_det][$col_det]=$indice+1;//id_tipo_columna
		 	 		$detalle_mod[$fila_det][$col_det+1]=$detalle[$i]['valor'];
		 	 		
		 	 		$col_det=$col_det+2;
		 	 		$indice=$indice+1;
 	 	     } else{
 	 	
 	 			
			 	 	if($col_det <14){
			 	 		$detalle_mod[$fila_det][0]=$detalle[$i]['desc_lugar'].'$'.$detalle[$i]['desc_uo'];
			 	 		$detalle_mod[$fila_det][1]=$detalle[$i]['desc_incr_col'];
			 	 		$detalle_mod[$fila_det][$col_det]=$indice+1;//id_tipo_columna
			 	 		$detalle_mod[$fila_det][$col_det+1]=$detalle[$i]['valor'];
			 	 		
			 	 		$col_det=$col_det+2;
			 	 		$indice=$indice+1;
			 	    }else{
			 	    	
			 	    	$fila_det=$fila_det+1;
			 	    	$col_det=2;
			 	    	
			 	    	
			 	    	$detalle_mod[$fila_det][0]=$detalle[$i]['desc_lugar'].'$'.$detalle[$i]['desc_uo'];
			 	 		$detalle_mod[$fila_det][1]=$detalle[$i]['desc_incr_col'];
			 	 		
			 	    	$detalle_mod[$fila_det][$col_det]=$indice+1;//id_tipo_columna
			 	 		$detalle_mod[$fila_det][$col_det+1]=$detalle[$i]['valor'];
			 	 		
			 	 		$indice=$indice+1;	
			 	 		$col_det=$col_det+2;
			
			 	  	  }
 	 			}
 	 	}
 	 
 	 }
 	 
 	 
 	 
 	
   $pdf->SetWidths(array(30,20,4,27.5,4,27.5,4,27.5,4,27.5,4,27.5,4,27.5,4,15));
	$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0));
 	$pdf->SetAligns(array('R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R'));
 	//$pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
 	$pdf->SetVisibles(array(0,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
  	$pdf->SetFontsSizes(array(6,6,3,6,3,6,3,6,3,6,3,6,3,6,3,6,3,6,3,6,3,3,3,3,3,3,));
 	$pdf->SetFontsStyles(array('','','','','','','','',''));
 	$pdf->SetSpaces(array(2,3,2,3,2,3,2,3,2,3,2,3,2,3,2,3,2,3,2,3));
 	$pdf->SetDecimales(array(0,0,0,2,0,2,0,2,0,2,0,2,0,2,0,2,0));

 	$pdf->SetFillColor(255,255,255);
 	$desc_uo='';
 	$desc='';
 	$nombre_descripcion='';
 	$id_lugar_anterior='';
 	$sum_empleados=0;
/* print_r($detalle_mod);
 exit;*/
 for ($j=0;$j<=sizeof($detalle_mod);$j++){
 	$pos_primera_cadena=strpos($detalle_mod[$j][0],'$');
 	$primera_cadena=substr($detalle_mod[$j][0],0,$pos_primera_cadena);
 	$segunda_cadena=substr($detalle_mod[$j][0],$pos_primera_cadena+1);
 /*   echo $primera_cadena;
    echo $segunda_cadena;
    exit;*/
 	
 	if ($desc_uo!=$segunda_cadena){
 		
 		if($pdf->GetY()>220){
						$pdf->AddPage();
					}
 		
 		if ($j!=0){
 			if (($id_lugar_anterior!=$primera_cadena) ){
 				
 				$pdf->SetWidths(array(0,4,27.5,4,27.5,4,27.5,4,27.5,4,27.5,4,27.5,4,15));
				//$pdf->SetFills (array(0,0,0,0,0,0,0,0,0,0));
 				//$pdf->SetAligns(array('R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R'));
 				$pdf->SetVisibles(array(0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
  				$pdf->SetFontsSizes(array(0,3,6,3,6,3,6,3,6,3,6,3,6,3,6,3,6,3,6,3,3,3,3,3,3,));
 				//$pdf->SetFontsStyles(array('','','','','','','','',''));
 				$pdf->SetSpaces(array(0,2,3,2,3,2,3,2,3,2,3,2,3,2,3,2,3,2,3,2,3));
 				$pdf->SetDecimales(array(0,0,2,0,2,0,2,0,2,0,2,0,2,0,2,0));	
 				$pdf->SetFont('Arial','B',7);
 					$mostrar_ultimo=vector_planilla($detalle_sum_dist,$id_lugar_anterior);
 		        	$mostrar_cabecera=findDistrito($detalle_sum_dist,$id_lugar_anterior);
 		      
 			  	$pdf->Cell(140,5,'TOTAL DISTRITO - '.$mostrar_cabecera[0][0],0,1);	
 			    for($mu=0;$mu<=sizeof($mostrar_ultimo);$mu++){
 	                 $pdf->SetDrawColor(200,200,200);
 	     	         $pdf->MultiTabla($mostrar_ultimo[$mu],0,3,3,6);
  	                 $pdf->SetDrawColor(0,0,0);
  	            }
  	             $pdf->SetFont('Arial','BI',5);
  	            $pdf->Cell(140,3,'Nro. de empleados: '.$mostrar_cabecera[0][1],0,1);
  	              $pdf->Cell(208,0.1,'',1,1);	
  	             // $pdf->Ln(1);
  	            $sum_empleados=$sum_empleados+$mostrar_cabecera[0][1];
 			    $id_lugar_anterior=$primera_cadena;
 			    
 			    //valores de la tabla
 				$pdf->SetWidths(array(30,20,4,27.5,4,27.5,4,27.5,4,27.5,4,27.5,4,27.5,4,15));
				$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0));
 				$pdf->SetAligns(array('R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R'));
 				$pdf->SetVisibles(array(0,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
  				$pdf->SetFontsSizes(array(6,6,3,6,3,6,3,6,3,6,3,6,3,6,3,6,3,6,3,6,3,3,3,3,3,3,));
 				$pdf->SetFontsStyles(array('','','','','','','','',''));
 				$pdf->SetSpaces(array(2,3,2,3,2,3,2,3,2,3,2,3,2,3,2,3,2,3,2,3));
 				$pdf->SetDecimales(array(0,0,0,2,0,2,0,2,0,2,0,2,0,2,0,2,0));
     			}
 		   
 	     }else{
 	     	$id_lugar_anterior=$primera_cadena;
 	     }
 		$desc_uo=$segunda_cadena;
 		$pdf->SetFont('Arial','B',7);
 	    $pdf->Cell(150,3,$segunda_cadena,0,1);	
 	}
 	
 	  $pdf->SetLineWidth(0.05);
 	  $pdf->SetDrawColor(200,200,200);
 	 $pdf->MultiTabla($detalle_mod[$j],0,3,3,6);
 }

 	
 function vector_planilla($detalle_sum_dist,$id)
 {
 	$fila_det=0;
 	$desc_incr_columna='';
 	$indice=0;
 	$col_det=1;
 	$detalle=$detalle_sum_dist;
 for ($k=0;$k<=sizeof($detalle);$k++)
 	 {
 	 	
 	 	  if  ($id==$detalle[$k][0]){
 	 	  
 	 		if ($detalle[$k]['total']=='si'){
 	 	
 	    	$detalle_imp[$fila_det][0]=$detalle[$k]['desc_incr_col'];
 	    	$detalle_imp[$fila_det][$col_det]="";//id_tipo_columna
 	 		$detalle_imp[$fila_det][$col_det+1]="";
 	 		
 	 		
 	 		while ($col_det<13){
 	 		$col_det=$col_det+2;
 	 		$detalle_imp[$fila_det][0]=$detalle[$k]['desc_incr_col'];
 	 		$detalle_imp[$fila_det][$col_det]="";//id_tipo_columna
 	 		$detalle_imp[$fila_det][$col_det+1]="";
 	 
 	 		}
 	 	
 	 		$detalle_imp[$fila_det][0]=$detalle[$k]['desc_incr_col'];
 	    	$detalle_imp[$fila_det][$col_det]=$indice+1;//id_tipo_columna
 	 		$detalle_imp[$fila_det][$col_det+1]=$detalle[$k]['sum_valor'];
 	 		$indice=$indice+1;	
 	 		
 	 		$col_det=1;
 	 		$fila_det=$fila_det+1;
 
 	 	}else {
 	 	
 	 	if( ($desc_incr_columna!=$detalle[$k]['desc_incr_col']))
 	 	{
 	 	$desc_incr_columna=$detalle[$k]['desc_incr_col'];
 	 	//$id_empleado=$detalle[$k]['id_empleado'];
 	 	
 	 		if($k==0){
 	 			$fila_det=0;
 	 		}else{
 	 			if($detalle[$k-1]['total']=='si'){
 	 			$fila_det=$fila_det;	
 	 			}else{
 	 			$fila_det=$fila_det+1;
 	 			}
 	 		}
 	 		$col_det=1;
 	    	$indice=0;
 	    	$detalle_imp[$fila_det][0]=$detalle[$k]['desc_incr_col'];
 	 		$detalle_imp[$fila_det][$col_det]=$indice+1;//id_tipo_columna
 	 		$detalle_imp[$fila_det][$col_det+1]=$detalle[$k]['sum_valor'];
 	 		
 	 		$col_det=$col_det+2;
 	 		$indice=$indice+1;
 	 	} else{
 	 	
 	 	
 	 	if($col_det <13){
 	 		$detalle_imp[$fila_det][0]=$detalle[$k]['desc_incr_col'];
 	 		$detalle_imp[$fila_det][$col_det]=$indice+1;//id_tipo_columna
 	 		$detalle_imp[$fila_det][$col_det+1]=$detalle[$k]['sum_valor'];
 	 		
 	 		$col_det=$col_det+2;
 	 		$indice=$indice+1;
 	    }else{
 	    	
 	    	$fila_det=$fila_det+1;
 	    	$col_det=1;
 	    	
 	    	$detalle_imp[$fila_det][0]=$detalle[$k]['desc_incr_col'];
 	 		
 	    	$detalle_imp[$fila_det][$col_det]=$indice+1;//id_tipo_columna
 	 		$detalle_imp[$fila_det][$col_det+1]=$detalle[$k]['sum_valor'];
 	 		
 	 		$indice=$indice+1;	
 	 		$col_det=$col_det+2;
 
 	  	  }
 	 	 }
 	 	}
 	 }
 	
 	 }//fin while
 	 return $detalle_imp; 
 }
 /************** fin procedimiento para volver un array *******************/
 /* Esta función buscara el nombre del lugar y el total de e`mpleados dado el id_lugar  ***/
 function findDistrito($vector_distritos,$id_lugar){
 	
    $vector_cabecera_distrito;
    for ($l=0;$l<sizeof($vector_distritos);$l++){
       if ($vector_distritos[$l]['id_lugar_trabajo']==$id_lugar){
       	    $vector_cabecera_distrito[0][0]=$vector_distritos[$l]['nombre_trabajo'];
            $vector_cabecera_distrito[0][1]=$vector_distritos[$l]['total_emp_x_dist'];
            break;
       }
    }
  return $vector_cabecera_distrito;
 	
 }
		
 
 $detalle_sum=$_SESSION['PDF_planilla_sum'];

 /***********************   sumas totales **************/
    $fila_det_sum=0;
 	$desc_incr_columna='';
 	$indice=0;
 	$col_det_sum=1;
 
 for ($k=0;$k<=sizeof($detalle_sum);$k++)
 	 {
 	 		if ($detalle_sum[$k]['total']=='si'){
 	 	
 	    	$detalle_mod_sum[$fila_det_sum][0]=$detalle_sum[$k]['desc_incr_col'];
 	    	$detalle_mod_sum[$fila_det_sum][$col_det_sum]="";//id_tipo_columna
 	 		$detalle_mod_sum[$fila_det_sum][$col_det_sum+1]="";
 	 		
 	 		
 	 		while ($col_det_sum<13){
 	 			$col_det_sum=$col_det_sum+2;
 	 		$detalle_mod_sum[$fila_det_sum][0]=$detalle_sum[$k]['desc_incr_col'];
 	 		$detalle_mod_sum[$fila_det_sum][$col_det_sum]="";//id_tipo_columna
 	 		$detalle_mod_sum[$fila_det_sum][$col_det_sum+1]="";
 	 
 	 		}
 	 	
 	 		$detalle_mod_sum[$fila_det_sum][0]=$detalle_sum[$k]['desc_incr_col'];
 	    	$detalle_mod_sum[$fila_det_sum][$col_det_sum]=$indice+1;//id_tipo_columna
 	 		$detalle_mod_sum[$fila_det_sum][$col_det_sum+1]=$detalle_sum[$k]['sum_valor'];
 	 		$indice=$indice+1;	
 	 		
 	 		$col_det_sum=1;
 	 		$fila_det_sum=$fila_det_sum+1;
 
 	 	}else {
 	 	
 	 	if( ($desc_incr_columna!=$detalle_sum[$k]['desc_incr_col']))
 	 	{
 	 	$desc_incr_columna=$detalle_sum[$k]['desc_incr_col'];
 	 	//$id_empleado=$detalle[$k]['id_empleado'];
 	 	
 	 		if($k==0){
 	 			$fila_det_sum=0;
 	 		}else{
 	 			if($detalle_sum[$k-1]['total']=='si'){
 	 			$fila_det_sum=$fila_det_sum;	
 	 			}else{
 	 			$fila_det_sum=$fila_det_sum+1;
 	 			}
 	 		}
 	 		$col_det_sum=1;
 	    	$indice=0;
 	    	$detalle_mod_sum[$fila_det_sum][0]=$detalle_sum[$k]['desc_incr_col'];
 	 		$detalle_mod_sum[$fila_det_sum][$col_det_sum]=$indice+1;//id_tipo_columna
 	 		$detalle_mod_sum[$fila_det_sum][$col_det_sum+1]=$detalle_sum[$k]['sum_valor'];
 	 		
 	 		$col_det_sum=$col_det_sum+2;
 	 		$indice=$indice+1;
 	 	} else{
 	 	
 	 	
 	 	if($col_det_sum <13){
 	 		$detalle_mod_sum[$fila_det_sum][0]=$detalle_sum[$k]['desc_incr_col'];
 	 		$detalle_mod_sum[$fila_det_sum][$col_det_sum]=$indice+1;//id_tipo_columna
 	 		$detalle_mod_sum[$fila_det_sum][$col_det_sum+1]=$detalle_sum[$k]['sum_valor'];
 	 		
 	 		$col_det_sum=$col_det_sum+2;
 	 		$indice=$indice+1;
 	    }else{
 	    	$fila_det_sum=$fila_det_sum+1;
 	    	$col_det_sum=1;
 	    	
 	    	
 	    	$detalle_mod_sum[$fila_det_sum][0]=$detalle_sum[$k]['desc_incr_col'];
 	 		
 	    	$detalle_mod_sum[$fila_det_sum][$col_det_sum]=$indice+1;//id_tipo_columna
 	 		$detalle_mod_sum[$fila_det_sum][$col_det_sum+1]=$detalle_sum[$k]['sum_valor'];
 	 		
 	 		$indice=$indice+1;	
 	 		$col_det_sum=$col_det_sum+2;
 
 	  	  }
 	 	 }
 	 	}
 	 }
 /************** fin suma totales *******************/
 	
 
  
 // $pdf->AddPage();
 	 if ($pdf->GetY()>=250){
 	 	$pdf->Cell(150,15,'',0,1);
 	 }
  $pdf->SetWidths(array(0,4,27.5,4,27.5,4,27.5,4,27.5,4,27.5,4,27.5,4,15));
	$pdf->SetFills (array(0,0,0,0,0,0,0,0,0,0));
 	$pdf->SetAligns(array('R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R'));
 	$pdf->SetVisibles(array(0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
  	$pdf->SetFontsSizes(array(0,3,6,3,6,3,6,3,6,3,6,3,6,3,6,3,6,3,6,3,3,3,3,3,3,));
 	$pdf->SetFontsStyles(array('','','','','','','','',''));
 	$pdf->SetSpaces(array(0,2,3,2,3,2,3,2,3,2,3,2,3,2,3,2,3,2,3,2,3));
 	$pdf->SetDecimales(array(0,0,2,0,2,0,2,0,2,0,2,0,2,0,2,0));
   $pdf->SetFont('Arial','B',7);	
  
  $pdf->Cell(150,5,'TOTAL PLANILLA',0,1);
 
 
  $pdf->SetFont('Arial','',7);   
  /* print_r ($detalle_mod_sum);  
   exit;*/
 for($m=0;$m<=sizeof($detalle_mod_sum);$m++){
  $pdf->SetDrawColor(200,200,200);
 	 
 	
  	 $pdf->MultiTabla($detalle_mod_sum[$m],0,3,3,6);
  
 	
  	 $pdf->SetDrawColor(0,0,0);
 	
 }
  $pdf->SetFont('Arial','BI',5);
   $pdf->Cell(140,5,'TOTAL NUMERO DE EMPLEADOS: '.$sum_empleados,0,1);
 
 $pdf->SetSpaces(array(0,0,2,3,2,3,2,3,2,3,2,3,2,3,2,3,2,3,2,3));
 	
 	
$pdf->Output();

?>