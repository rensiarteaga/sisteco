<?php

session_start();

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
function SetNombreUO($nombre_uo)
{
    $this->nombre_uo=$nombre_uo;
}
/*function SetPrograma($nombre_programa)
{
    $this->nombre_programa=$nombre_programa;
}
function SetFinanciador($nombre_financiador)
{
    $this->nombre_financiador=$nombre_financiador;
}
function SetProyecto($nombre_proyecto)
{
    $this->nombre_proyecto=$nombre_proyecto;
}
function SetRegional($nombre_regional)
{
    $this->nombre_regional=$nombre_regional;
}
function SetActividad($nombre_actividad)
{
    $this->nombre_actividad=$nombre_actividad;
}
*/

function Header()
{    
    $this->Image('../../../../lib/images/logo_reporte.jpg',170,2,35,15);
    $this->Ln(5);
     $this->SetFont('Arial','B',16);
 $this->SetX(15);
$this->Cell(150,6,'ADQUISICIÓN DE '.$_SESSION['PDF_titulo'].'',0,1,'C');
$this->SetFont('Arial','B',10);
 $this->SetX(15);
$this->Cell(150,5,'Expresado en Bs',0,1,'C');
    $this->Ln(2);
//CABECERA
$this->SetFont('Arial','B',7); 
$this->Cell(50,3,'Gestion',0,0,'C'); 
$this->Cell(60,3,'Fecha Inicio',0,0,'C'); 
$this->Cell(50,3,'Fecha Fin',0,0,'C'); 
$this->Cell(50,3,'Estado',0,1,'C'); 
$this->SetFont('Arial','',7);
$this->Cell(50,3,$_SESSION['PDF_gestion'],0,0,'C'); 
$this->Cell(60,3,$_SESSION['PDF_fecha_inicio'],0,0,'C'); 
$this->Cell(50,3,$_SESSION['PDF_fecha_fin'],0,0,'C'); 
$this->Cell(50,3,$_SESSION['PDF_estado'],0,1,'C'); 


$this->Ln(2);
$unidad_orga=array();
 
 $unidad_orga[0][0]='UNIDAD ORGANIZACIONAL:';
 $unidad_orga[0][1]=$this->nombre_uo;
 $unidad_orga[0][2]='PROGRAMA:';
 $unidad_orga[0][3]=$this->nombre_programa;
 
 $unidad_orga[1][0]='FINANCIADOR:';
 $unidad_orga[1][1]=$this->nombre_financiador;
 $unidad_orga[1][2]='PROYECTO:';
 $unidad_orga[1][3]=$this->nombre_proyecto;
 
 $unidad_orga[2][0]='REGIONAL:';
 $unidad_orga[2][1]=$this->nombre_regional;
 $unidad_orga[2][2]='ACTIVIDAD:';
 $unidad_orga[2][3]=$this->nombre_actividad;




$this->SetFillColor(200,200,200);
$this->SetDrawColor(255,255,255);
$this->SetLineWidth(0.5);

$this->SetWidths(array(15,20,20,20,15,20,12,20,23,40));
$this->SetFills(array(0,1,0,1,0,1,0,1,0,1,0,1));
$this->SetAligns(array('L','L','L','L','L','L'));
$this->SetVisibles(array(1,1,1,1,1,1,1,1,1,1));
$this->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
$this->SetFontsSizes(array(7,7,7,7,7,7,7,7,7,7));
$this->SetFontsStyles(array('B','','B','','B','','B','','B',''));
$this->SetSpaces(array(3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5));
$this->setDecimales(array(0,0,0,0,0,0));
$this->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0));

//$this->MultiTabla($cabecera[0],1,3,3.5,8,1);

$this->SetWidths(array(35,75,20,75));
for ($o=0;$o<sizeof($unidad_orga);$o++){
  $this->MultiTabla($unidad_orga[$o],1,3,3.5,7);
   
 }
 $this->SetWidths(array(0,0,0,0,20,18,50,20,20,20,20,20,20,20,20));
        $this->SetFills(array(0,0,0,0,0,0,0,0,0));
         $this->SetAligns(array('L','L','L','L','L','L','R','R','R','R','R','R'));
         $this->SetVisibles(array(0,0,0,0,1,1,1,1,1,1,1,1,1,1));
         $this->SetFontsSizes(array(7,7,7,7,7,7,7,7,7,7,7,7,7,7,7));
         $this->SetFontsStyles(array('','','','','','','','',''));
         $this->SetDecimales(array(0,0,0,0,0,0,0,2,2,2,2,2,2));
         $this->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
$this->SetFillColor(255,255,255);
$this->SetDrawColor(0,0,0);
}
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
   
    $fecha=date("d-m-Y");
	$hora=date("H:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
   	   // $this->Cell(200,0.2,'',1,1);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS -COMPRO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');
        
      }


}

	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,7);
    $pdf->SetMargins(5,5,5);
  
 $pdf->SetNombreUO($v_procesos_detalle[0][1]);
   	$v_procesos_detalle=$_SESSION['PDF_procesos_detalle'];
   /*	print_r($v_procesos_detalle);
   	exit*/
    $pdf->SetFont('Arial','B',7);
    
  
   	 $pdf->SetWidths(array(0,0,0,0,20,18,50,20,20,20,20,20,20,20,20));
        $pdf->SetFills(array(0,0,0,0,0,0,0,0,0));
         $pdf->SetAligns(array('L','L','L','L','L','L','R','R','R','R','R','R'));
         $pdf->SetVisibles(array(0,0,0,0,1,1,1,1,1,1,1,1,1,1));
         $pdf->SetFontsSizes(array(7,7,7,7,7,7,7,7,7,7,7,7,7,7,7));
         $pdf->SetFontsStyles(array('','','','','','','','',''));
         $pdf->SetDecimales(array(0,0,0,0,0,0,0,2,2,2,2,2,2));
         $pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
     $bandera_partida='';  
     $bandera_presupuesto='';  
     $bandera_gestion='';
   	for ($i=0;$i<count($v_procesos_detalle);$i++)
   	{   
   		if($bandera_presupuesto!=$v_procesos_detalle[$i][0]){
   			 
   			$bandera_presupuesto=$v_procesos_detalle[$i][1];
   			 $pdf->AddPage();
   			 $pdf->SetNombreUO($v_procesos_detalle[$i][1]);
 	/* $pdf->SetPrograma($_SESSION['PDF_nombre_programa_'.$i]);
 	 $pdf->SetFinanciador($_SESSION['PDF_nombre_financiador_'.$i]);
 	 $pdf->SetProyecto($_SESSION['PDF_nombre_proyecto_'.$i]);
 	 $pdf->SetRegional($_SESSION['PDF_nombre_regional_'.$i]);
 	 $pdf->SetActividad($_SESSION['PDF_nombre_actividad_'.$i]);
 	 */
   		}
   		if($bandera_partida!=$v_procesos_detalle[$i][2]){
   			//if($bandera_partida!=$v_procesos_detalle[$i][2]);
   			
   			       $bandera_partida=$v_procesos_detalle[$i][2];
   			 $pdf->Cell(18,3,'Partida: '.$v_procesos_detalle[$i][2],0,1,'C'); 
   			 	}
   			 	if($bandera_gestion!=$v_procesos_detalle[$i][3]){ 
   			 		$bandera_gestion=$v_procesos_detalle[$i][3];
   			 		  $pdf->Cell(18,3,'Gestion: '.$v_procesos_detalle[$i][3],0,1,'C'); 
   			  $pdf->Cell(20,3,'Codigo','LTR',0,'C'); 
		$pdf->Cell(18,3,'Fecha','TR',0,'C'); 
		$pdf->Cell(50,3,'Concepto','TR',0,'C'); 
		$pdf->Cell(20,3,'Comprometido','TR',0,'C'); 
		$pdf->Cell(20,3,'Adjudicado','TR',0,'C'); 
		$pdf->Cell(20,3,'Saldo Por','TR',0,'C'); 
		$pdf->Cell(20,3,'Devengado','TR',0,'C'); 
		$pdf->Cell(20,3,'Pagados','TR',0,'C'); 
		$pdf->Cell(20,3,'Saldo Por','TR',0,'C'); 
		$pdf->Cell(20,3,'Saldo Por','TR',1,'C'); 
		
		$pdf->Cell(20,3,'Proceso','LBR',0,'C'); 
		$pdf->Cell(18,3,'Doc.','BR',0,'C'); 
		$pdf->Cell(50,3,'','BR',0,'C'); 
		$pdf->Cell(20,3,'','BR',0,'C'); 
		$pdf->Cell(20,3,'','BR',0,'C'); 
		$pdf->Cell(20,3,'Revertir','BR',0,'C'); 
		$pdf->Cell(20,3,'','BR',0,'C'); 
		$pdf->Cell(20,3,'','BR',0,'C'); 
		$pdf->Cell(20,3,'Devengar','BR',0,'C'); 
		$pdf->Cell(20,3,'Pagar','BR',1,'C');     
   			
   			 	}
   		
   		
   		  $pdf->MultiTabla($v_procesos_detalle[$i],0,3,3,7);
   	}
   	
   	
   	/*
$v_uocabeceras=$_SESSION['PDF_UOCabecera'];
 for ($i=0;$i<sizeof($v_uocabeceras);$i++){
 	
 	 $pdf->SetNombreUO($_SESSION['PDF_nombre_uo_'.$i]);
 	 $pdf->SetPrograma($_SESSION['PDF_nombre_programa_'.$i]);
 	 $pdf->SetFinanciador($_SESSION['PDF_nombre_financiador_'.$i]);
 	 $pdf->SetProyecto($_SESSION['PDF_nombre_proyecto_'.$i]);
 	 $pdf->SetRegional($_SESSION['PDF_nombre_regional_'.$i]);
 	 $pdf->SetActividad($_SESSION['PDF_nombre_actividad_'.$i]);
 	 
     $pdf->AddPage();
     
 //Títulos de las columnas

 
$pdf->SetDrawColor(0,0,0);
//DETALLE DE SERVICIOS E ITEMS 
    $pdf->SetLineWidth(0.2);
    ///////// Detalle de Items

   //	$pdf->Cell(185,5,'Items ',0,1,'C');
   	$suma_total=0;
   	$suma_total_servicios=0;
	$suma_total_servicios_adjudicada=0;
 //if($_SESSION['PDF_tipo_adq']=='Bien'){
   	$v_partidas_items=$_SESSION['PDF_procesos_detalle'];
   /* for($j=0;$j<sizeof($v_partidas_items);$j++){
    	
    
    $v_items=$_SESSION['PDF_procesos_detalle'];
  
	   $pdf->SetFont('Arial','',7);
	  
	
		$pdf->SetFont('Arial','B',7);
		$pdf->Cell(100,5,'Nombre Partida:'.$v_partidas_items[$j][1],0,1);
		
		$pdf->Cell(10,3,'Nº Sol.','LTR',0,'C'); 
		$pdf->Cell(85,3,'Descripción','TR',0,'C'); 
		$pdf->Cell(10,3,'Unidad','TR',0,'C'); 
		$pdf->Cell(10,3,'Cant.','TR',0,'C'); 
		$pdf->Cell(20,3,'Precio U.','TR',0,'C'); 
		$pdf->Cell(20,3,'Importe T.','TR',0,'C'); 
		$pdf->Cell(10,3,'Cant.','TR',0,'C'); 
		$pdf->Cell(20,3,'Precio U.','TR',0,'C'); 
		$pdf->Cell(20,3,'Importe T.','TR',1,'C'); 
		
		$pdf->Cell(10,3,'','LBR',0,'C'); 
		$pdf->Cell(85,3,'','BR',0,'C'); 
		$pdf->Cell(10,3,'','BR',0,'C'); 
		$pdf->Cell(10,3,'Pres.','BR',0,'C'); 
		$pdf->Cell(20,3,'Presupuestado','BR',0,'C'); 
		$pdf->Cell(20,3,'Presupuestado','BR',0,'C'); 
		$pdf->Cell(10,3,'Adj.','BR',0,'C'); 
		$pdf->Cell(20,3,'Adjudicado','BR',0,'C'); 
		$pdf->Cell(20,3,'Adjudicado','BR',1,'C'); 
 		
 		
		 $pdf->SetFont('Arial','',8);	
        $pdf->SetWidths(array(10,85,10,10,20,20,10,20,20));
        $pdf->SetFills(array(0,0,0,0,0,0,0,0,0));
         $pdf->SetAligns(array('R','L','L','R','R','R','R','R','R'));
         $pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1));
         $pdf->SetFontsSizes(array(7,7,7,7,7,7,7,7,7));
         $pdf->SetFontsStyles(array('','','','','','','','',''));
         $pdf->SetDecimales(array(0,0,2,2,2,2,2,4,2));
         $pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3));
         
         $suma_total_parcial=0;
         $suma_total_adjudicada_parcial=0;
   		for($k=0;$k<sizeof($v_items);$k++)
		 {
		  
             $pdf->SetLineWidth(0.05);
             $pdf->SetDrawColor(200,200,200);
            
             $pdf->MultiTabla($v_items[$k],0,3,3,7);
             $pdf->SetLineWidth(0.2);
             $suma_total_parcial=$suma_total_parcial+$v_items[$k][5];
             $suma_total_adjudicada_parcial=$suma_total_adjudicada_parcial+ $v_items[$k][8];
		 }
		  
	
		   $pdf->SetFont('Arial','',7);
		   $pdf->Cell(135,3,'SubTotal ',0,0,'R');
		   $pdf->Cell(20,3,number_format($suma_total_parcial,2),1,0,'R');
		   $pdf->Cell(30,3,'SubTotal',0,0,'R');
		   $pdf->Cell(20,3,number_format($suma_total_adjudicada_parcial,2),1,1,'R');
		    $suma_total=$suma_total+$suma_total_parcial;
		    $suma_total_adjudicada=$suma_total_adjudicada+$suma_total_adjudicada_parcial;
		
		 
    }
        $pdf->Ln(3);
     $pdf->SetFont('Arial','B',8);
           $pdf->Cell(135,3,'Total',0,0,'R');
		   $pdf->Cell(20,3,number_format($suma_total,2),1,0,'R');
		   $pdf->Cell(30,3,'Total',0,0,'R');
		   $pdf->Cell(20,3,number_format($suma_total_adjudicada,2),1,1,'R');
		//Detalle de Servicios
	 
	
/*}else{
	/*echo "asdfsdf";
	exit;
	*/
/*$v_partidas_servicios=$_SESSION['PDF_UOPartidas_Servicios'];	
	for($l=0;$l<sizeof($v_partidas_servicios);$l++){
		
	$v_servicios=$_SESSION['PDF_UOServicios_'.$i.$l];
	
	
	 	$pdf->SetFont('Arial','B',7);
		$pdf->Cell(100,5,'Nombre Partida:'.$v_partidas_servicios[$l][1],0,1);
		
	
		$pdf->Cell(10,3,'Nº Sol.','LTR',0,'C'); 
		$pdf->Cell(85,3,'Descripción','TR',0,'C'); 
		$pdf->Cell(10,3,'Unidad','TR',0,'C'); 
		$pdf->Cell(10,3,'Cant.','TR',0,'C'); 
		$pdf->Cell(20,3,'Precio U.','TR',0,'C'); 
		$pdf->Cell(20,3,'Importe T.','TR',0,'C'); 
		$pdf->Cell(10,3,'Cant.','TR',0,'C'); 
		$pdf->Cell(20,3,'Precio U.','TR',0,'C'); 
		$pdf->Cell(20,3,'Importe T.','TR',1,'C'); 
		
		$pdf->Cell(10,3,'','LBR',0,'C'); 
		$pdf->Cell(85,3,'','BR',0,'C'); 
		$pdf->Cell(10,3,'','BR',0,'C'); 
		$pdf->Cell(10,3,'Pres.','BR',0,'C'); 
		$pdf->Cell(20,3,'Presupuestado','BR',0,'C'); 
		$pdf->Cell(20,3,'Presupuestado','BR',0,'C'); 
		$pdf->Cell(10,3,'Adj.','BR',0,'C'); 
		$pdf->Cell(20,3,'Adjudicado','BR',0,'C'); 
		$pdf->Cell(20,3,'Adjudicado','BR',1,'C'); 
 	
		 $pdf->SetFont('Arial','',8);	
        $pdf->SetWidths(array(10,85,10,10,20,20,10,20,20));
        $pdf->SetFills(array(0,0,0,0,0,0,0,0,0));
         $pdf->SetAligns(array('R','L','L','R','R','R','R','R','R'));
         $pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1));
         $pdf->SetFontsSizes(array(7,7,7,7,7,7,7,7,7));
         $pdf->SetFontsStyles(array('','','','','','','','',''));
         $pdf->SetDecimales(array(0,0,2,2,2,2,2,4,2));
         $pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3));
         
        $suma_total_parcial_servicios=0;
        $suma_total_parcial_adjudicada=0;
        
		for($m=0;$m<sizeof($v_servicios);$m++)
		 {
		  	
             $pdf->SetLineWidth(0.05);
             $pdf->SetDrawColor(200,200,200);
             $pdf->MultiTabla($v_servicios[$m],0,3,3,7);
             $pdf->SetLineWidth(0.2);
             $suma_total_parcial_servicios=$suma_total_parcial_servicios + $v_servicios[$m][5];
             $suma_total_parcial_adjudicada=$suma_total_parcial_adjudicada + $v_servicios[$m][8];
             
          }	
          
           $pdf->SetFont('Arial','',7);
		   $pdf->Cell(135,3,'SubTotal',0,0,'R');
		   $pdf->Cell(20,3,number_format($suma_total_parcial_servicios,2),1,0,'R');
		   $pdf->Cell(30,3,'SubTotal',0,0,'R');
		   $pdf->Cell(20,3,number_format($suma_total_parcial_adjudicada,2),1,1,'R');
		    $suma_total_servicios=$suma_total_servicios+$suma_total_parcial_servicios;
          $suma_total_servicios_adjudicada=$suma_total_servicios_adjudicada+$suma_total_parcial_adjudicada;
         
		   
	  
		}
		 $pdf->Ln(3);
		 $pdf->SetFont('Arial','B',8);
		 $pdf->Cell(135,3,'Total',0,0,'R');
		 $pdf->Cell(20,3,number_format($suma_total_servicios,2),1,0,'R');
	     $pdf->Cell(30,3,'Total',0,0,'R');
		 $pdf->Cell(20,3,number_format($suma_total_servicios_adjudicada,2),1,1,'R');
     
		
	}*/
// }
	
$pdf->Output();


?>