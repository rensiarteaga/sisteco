<?php
session_start();
/**
 * Autor: 				Elmer Velasquez	
 * Fecha de creacion: 	01/02/2013
 * Descripción: 	Detalla la forma en la que se asocian las cuentas de los activos de un proceso de alta o baja
 * **/

require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{    
	
	function PDF($orientation='L',$unit='mm',$format='Letter')
    {
    	//ANCHO DE PAGINA VERTICALMENTE 205
	    //Llama al constructor de la clase padre
	    $this->FPDF($orientation,$unit,$format);
	    $this-> AddFont('Arial','','arial.php');
	     
	    //Iniciación de variables    
    }   
    
	function Header()
	{
		$this->Image('../../../../lib/images/logo_reporte.jpg',240,2,25,10); //LOGO 
				
	   	// TITULO
	   
	    $this->Ln(2);
	    //$this->SetFillColor(0,33,91);
	   	$this->SetFont('Arial','B',10);
	 	$this->Cell(250,3,'DETALLE ASOCIACION TIPO - EP ACTIVOS FIJOS',0,1,'C');
	 	
	 	$this->Ln(4);
	 	$this->SetX(22);
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(30,3,'ID GRUPO PROCESO: ',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,utf8_decode($_SESSION["PDF_detalle_asociacion_tipo_ep"][0][11]),0,1,'L');
	 	
	 	$this->Ln(1);
	 	$this->SetX(22);
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(35,3,'DETALLE PROCESO: ',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,utf8_decode($_SESSION["PDF_detalle_asociacion_tipo_ep"][0][12]),0,1,'L');
	 	
	 	$this->Ln(1);
	 	$this->SetX(22);
	 	$this->SetFont('Arial','B',6);
	 	$this->Cell(35,3,'CANTIDAD ACTIVOS FIJOS: ',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,utf8_decode(count($_SESSION["PDF_detalle_asociacion_tipo_ep"])),0,1,'L');

		$this->SetFont('Arial','B',6);
	 	$this->Cell(35,3,'',0,0,'L');
	 	$this->SetFont('Arial','',6);
	 	$this->Cell(50,3,'',0,1,'L');
	 			
	 	
		
		$this->Ln(4);
	 	
	 	
	 	// FIN TITULO
				
		//ENCABEZADO DE TABLA
		 $this->SetFont('Arial','B',6);
		 
		
		 $this->SetWidths(array(7,25,30,30,30,15,18,15,15,13,13,15));
		 $this->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0));
		 $this->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1));
		 $this->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6));
		 $this->SetFontsStyles(array('','','','','','','','','','',''));
		 $this->SetDecimales(array(0,0,0,0,0,3,3,3,3,0,0,0));
		 $this->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3));
		 $this->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0));
		
	
			//primera linea 
			$this->SetX(15);
			 $this->Cell(7,3,'NUM','TRL',0,'C');  //1
			 $this->Cell(25,3,'ACTIVO FIJO','TRL',0,'C');  //1.1
			 $this->Cell(30,3,'TIPO','TRL',0,'C');  //2
			// $this->Cell(10,3,'ID TIPO','TRL',0,'C');  //2.1
			// $this->Cell(10,3,'ID EP','TRL',0,'C');  //3
			 $this->Cell(30,3,'ESTRUCTURA','TRL',0,'C');//4
			 $this->Cell(30,3,'CUENTA / AUXILIAR','TRL',0,'C');//5
			 // $this->Cell(18,3,'CODIGO','TRL',0,'C');//5.1   
			 $this->Cell(15,3,'MONTO','TRL',0,'C'); //6
			 $this->Cell(18,3,'MONTO','TRL',0,'C');//7
			 $this->Cell(15,3,'DEPREC.','TRL',0,'C');  //8
			 $this->Cell(15,3,'MONTO','TRL',0,'C');  //9
			 $this->Cell(13,3,'ESTADO','TRL',0,'C');   //10
			 $this->Cell(13,3,'PROYECTO','TRL',0,'C');  //11
			 $this->Cell(15,3,'TENSION','TRL',1,'C');  //12
			 //SEGUNDA LINEA
			 $this->SetX(15);
			 $this->Cell(7,3,'','BRL',0,'C');  //1
			 $this->Cell(25,3,'	','BRL',0,'C');  //1.1
			 $this->Cell(30,3,'ACTIVO FIJO','BRL',0,'C');//2  
			 //$this->Cell(10,3,'ACT.FIJO','BRL',0,'C');  //2.1
			 //$this->Cell(10,3,'ACT.FIJO','BRL',0,'C');  //3
			 $this->Cell(30,3,'PROGRAMATICA','BRL',0,'C');//4
			 $this->Cell(30,3,' ','BRL',0,'C');//5  
			 //$this->Cell(18,3,'AUXILIAR','BRL',0,'C');//5.1 
			 $this->Cell(15,3,'COMPRA','BRL',0,'C');//6 
			 $this->Cell(18,3,' ACTUALIZADO','BRL',0,'C');//7
			 $this->Cell(15,3,'ACUMULADA','BRL',0,'C');  //8
			 $this->Cell(15,3,'ACTUAL','BRL',0,'C');  //9
			 $this->Cell(13,3,'','BRL',0,'C');   //10
			 $this->Cell(13,3,'','BRL',0,'C'); //11
			 $this->Cell(15,3,'','BRL',1,'C'); //12
			 
		
	
		//FIN ENCABEZADO DE TABLA
	}

	//Pie de página
	function Footer()
	{	
		$this->SetX(15);
	    //Posición: a 1,5 cm del final
	    $fecha=date("d-m-Y");
		$hora=date("H:i:s");
		$this->SetY(-7);
	   	$this->SetFont('Arial','',5);
	   	$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(65,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'R');
		$this->ln(3);
		$this->Cell(100,3,'Sistema: ENDESIS - ACTIF',0,0,'L');
		$this->Cell(70,3,'',0,0,'C');
		$this->Cell(62,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	        
     }
}
$pdf=new PDF();
$pdf->SetX(15);
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,7);
$pdf->SetMargins(15,5,5);


$pdf->AddPage(); 
	    
$pdf->SetFont('Arial','B',6);
$pdf->SetWidths(array(7,25,30,30,30,15,18,15,15,13,13,15));
$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0));
$pdf->SetAligns(array('C','C','C','C','C','C','C','R','R','C','C','C'));
$pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1,1));
$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6));
$pdf->SetFontsStyles(array('','','','','','','','','','','',''));
$pdf->SetDecimales(array(0,0,0,0,0,3,3,3,3,0,0,0));
$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3));
$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0));
		 

$det_af = $_SESSION["PDF_detalle_asociacion_tipo_ep"];
//echo $det_af[0]["fecha_compra"]; 
$cont = count($det_af);
$total_asociados=0;
$total_monto_compra=0; $total_monto_act=0; $total_deprec=0; $total_monto_actualizado=0;
$control_tipo=(int)0;$control_ep=(int)0;$control_tension='';

for($j=0;$j<$cont;$j++)
 {
 	$numero=$j+1;
 	$ant_tipo=$det_af[$j]['id_tipo_activo'];
 	$ant_ep=$det_af[$j]['ep'];
 	$ant_tension=$det_af[$j]['tension'];
 	if($j+1<=$cont)
 	{
 		$next_tipo=$det_af[$j+1]['id_tipo_activo'];$next_ep=$det_af[$j+1]['ep'];
 		$next_tension=$det_af[$j+1]['tension'];
 		if($ant_tipo==$next_tipo and $ant_ep==$next_ep and $ant_tension==$next_tension)
 		{
 			 $total_asociados++;
			 $control_tipo=$ant_tipo; $control_ep=$ant_ep;
			 $pdf->SetX(15);
 			 $pdf->MultiTabla((array_merge((array)$numero,(array)$det_af[$j])),3,3,4,8);
   			 $pdf->SetLineWidth(0.05);
   			 
   			 $total_monto_compra=$total_monto_compra + $det_af[$j]['monto_compra_mon_orig']; 
   			 $total_monto_act=$total_monto_act + $det_af[$j]['monto_actualiz']; 
   			 $total_deprec= $total_deprec + $det_af[$j]['depreciacion_acum']; 
   			 $total_monto_actualizado=$total_monto_actualizado + $det_af[$j]['monto_actual'];
 		}
 		else
 		{
 			 if($control_tipo==$ant_tipo and $control_ep==$ant_ep)
 			 {
 			 	$total_monto_compra=$total_monto_compra+$det_af[$j]['monto_compra_mon_orig']; 
   			 	$total_monto_act=$total_monto_act+$det_af[$j]['monto_actualiz']; 
   			 	$total_deprec=$total_deprec+$det_af[$j]['depreciacion_acum']; 
   			 	$total_monto_actualizado=$total_monto_actualizado+$det_af[$j]['monto_actual'];
 			 	
 			 	$pdf->SetX(15);
 			 	$pdf->MultiTabla((array_merge((array)$numero,(array)$det_af[$j])),3,3,4,8);
 			 	
 			 	$pdf->SetX(137);
 			 	$aux=$pdf->GetY();
 			 	$pdf->SetFont('Arial','B',6);
 			 	//$pdf->Cell(15,5,$total_monto_compra,1,1,'R');
 			 	$pdf->Cell(15,5,$total_monto_compra,'LBRT',1,'R',false);
 			 	
 			 	$pdf->SetY($aux);$pdf->SetX(152);
 			 	//$pdf->Cell(18,5,$total_monto_act,1,1,'R');
 			 	$pdf->Cell(18,5,$total_monto_act,'LBRT',1,'R',false);
 			 	
 			 	$pdf->SetY($aux);$pdf->SetX(170);
 			 	//$pdf->Cell(15,5,$total_deprec,1,1,'R');
 			 	$pdf->Cell(15,5,$total_deprec,'LBRT',1,'R',false);
 			 	
 			 	$pdf->SetY($aux);$pdf->SetX(185);
 			 	//$pdf->Cell(15,5,$total_monto_actualizado,1,1,'R');
 			 	$pdf->Cell(15,5,$total_monto_actualizado,'LBRT',1,'R',false);
 			 
   			 	$pdf->SetLineWidth(0.05);
   			 	$pdf->Ln(2);
   			 	
 			 }
 			 else
 			 {
 			 	$pdf->SetX(15);
 			 	$pdf->MultiTabla((array_merge((array)$numero,(array)$det_af[$j])),3,3,4,8);
   			 	$pdf->SetLineWidth(0.05);
   			 	$pdf->Ln(2);
   			 	$total_monto_compra=0; 
   			 	$total_monto_act=0; 
   			 	$total_deprec=0; 
   			 	$total_monto_actualizado=0;
 			 }
 
 		}
 	}		
   			// $pdf->Cell(70,3,'Total Asociados Tipo EP: '.$total_asociados,0,0,'L');	
   			 //$pdf->Ln(2);
 		   
 }
 
$pdf->SetY(-12);
$pdf->SetFont('Arial','',5);
$pdf->Cell(70,3,'Total Activos Fijos Asociados : '.$total_asociados,0,0,'L');	
$pdf->Output();
?>