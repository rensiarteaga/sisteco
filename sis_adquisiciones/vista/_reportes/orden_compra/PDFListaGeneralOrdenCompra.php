<?php

session_start();
/**
 * Autor: 
 * Fecha de creacion: 03/11/2011
 * Descripción: Reporte de Listado General de Ordenes de compra
 
 * **/

require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');
 
class PDF extends FPDF
{   
	function PDF($orientation='L',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
   // $this-> AddFont('Arial','','arial.php');
 
    //Iniciación de variables
    }



function Header()
{       
   $this->Image('../../../../lib/images/logo_reporte.jpg',230,2,35,15);
  
    $this->Ln(5);
    $this->SetFont('Arial','B',16);
 	$this->Cell(0,6,'DETALLE DE ORDENES DE COMPRA '.$_SESSION['PDF_gestion'],0,1,'C');
 	$this->SetFont('Arial','B',10);
 	
 	$cadena_tipo='';
 	if($_SESSION['PDF_tipo_adq']=='Bien'){
 		$cadena_tipo='BIENES';
 	}elseif($_SESSION['PDF_tipo_adq']=='Servicio'){
 		$cadena_tipo='SERVICIOS';
 	}else{
 		$cadena_tipo='BIENES Y SERVICIOS';
 	}
 	
 	
 	
 	
 	if($_SESSION["PDF_filtro"]=='mayores'){
 		$this->Cell(0,4,$cadena_tipo.' MAYORES A '.$_SESSION["PDF_importe"].' Bs.',0,1,'C');
 	}elseif ($_SESSION["PDF_filtro"]=='menores'){
 		$this->Cell(0,4,$cadena_tipo.' MENORES A '.$_SESSION["PDF_importe"].' Bs.',0,1,'C');
 	}else{
 		$this->Cell(0,4,$cadena_tipo,0,1,'C');
 	}
	
	
	$this->SetFont('Arial','B',10);
 	$this->SetX(15);
 	$this->Ln(1.5);


	$this->Ln(2);

 $this->Ln(1);
 $this->SetFont('Arial','B',7);
 $this->SetLineWidth(0.2);
 
 $this->Cell(35,4,'Estructura Prográmatica: ',0,0);
 $this->SetFont('Arial','',7);
 $this->Cell(120,4,utf8_decode($_SESSION['PDF_desc_ep']),0,0);
 $this->SetFont('Arial','B',7);
 $this->Cell(25,4,'Departamento: ',0,0);
 $this->SetFont('Arial','',7);
 $this->Cell(90,4,utf8_decode($_SESSION['PDF_departamento']),0,1);
 $this->SetFont('Arial','B',7);
 $this->Cell(35,4,'Unidad Organizacional: ',0,0);
 $this->SetFont('Arial','',7);
 $this->Cell(120,4,utf8_decode($_SESSION['PDF_unidad_organizacional']),0,0);
 $this->SetFont('Arial','B',7);
 $this->Cell(25,4,'Proveedor: ',0,0);
 $this->SetFont('Arial','',7);
 $this->Cell(90,4,utf8_decode($_SESSION['PDF_nombre_proveedor']),0,1);
 
 if($_SESSION['PDF_tipo_adq']=='Bien'){
 	$this->SetWidths(array(0,6,0,0,0,0,0,0,40,    45,9,18,11,12,28,27,6,12,12,12,9,9,10,10));
 	$this->SetVisibles(array(0,1,0,0,0,0,0,0,    1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
 }else{
       $this->SetWidths(array(0,6,0,0,0,8,8,7,15,    45,9,18,11,12,28,27,6,12,12,12,9,9,10,10));
  	   
  	   $this->SetVisibles(array(0,1,0,0,0,1,1,1,    1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
 }
	   $this->SetAligns(array('R','L','L','L','L','L','L','L',    'L','L','L','L','L','L','L','L','R','R','R','R','L','L','R','R'));
  	   $this->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
	   $this->SetFontsSizes(array(4,4,4,4,4,4,4,    4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4));
	   $this->SetSpaces(array(3,3,3,3,3,3,3,3,    3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
	   $this->setDecimales(array(0,0,0,0,0,0,0,0,           0,0,0,0,0,0,0,0,0,2,2,2,0,0,2,2));
	   $this->SetFormatNumber(array(0,0,0,0,0,0,0,0,         0,0,0,0,0,0,0,0,1,1,1,1,0,0,1,1));
 
       $this->SetFont('Arial','B',6);
       
        $this->Cell(6,4,'Nº OC','LTR',0,'C');
		if($_SESSION['PDF_tipo_adq']!='Bien'){
		   $this->Cell(8,4,'INICIO','LTR',0,'C');
		   $this->Cell(8,4,'FIN','LTR',0,'C');
		   $this->Cell(7,4,'TIEMP','LTR',0,'C');
		   $this->Cell(15,4,'PARTIDA','LTR',0,'C');
		}else{
			$this->Cell(40,4,'PARTIDA','LTR',0,'C');
		}
	   
	   
	   
		$this->Cell(45,4,'DESCRIPCIÓN','LTR',0,'C');
		$this->Cell(9,4,'FECHA','TR',0,'C');
		$this->Cell(18,4,'CATEGORIA','TR',0,'C');
		$this->Cell(11,4,'ESTADO','TR',0,'C');
		$this->Cell(12,4,'CODIGO','TR',0,'C');
		$this->Cell(28,4,'PROVEEDOR','TR',0,'C');
		$this->Cell(27,4,'OBSERVACIONES','TR',0,'C');
		$this->Cell(6,4,'CANT.','TR',0,'C');
		$this->Cell(12,4,'IMPORTE','TR',0,'C');
		$this->Cell(12,4,'IMPORTE','TR',0,'C');
		$this->Cell(12,4,'SALDO POR','TR',0,'C');
		$this->Cell(9,4,'CBTE','TR',0,'C');
		$this->Cell(9,4,'CBTE','TR',0,'C');
		$this->Cell(10,4,'TOT.DEV.','TR',0,'C');
		$this->Cell(10,4,'TOT.PAG.','TR',1,'C');
		
		$this->Cell(6,4,'','LRB',0,'C');
	    if($_SESSION['PDF_tipo_adq']!='Bien'){
	   
	    	$this->Cell(8,4,'SERV.','LRB',0,'C');
		    $this->Cell(8,4,'SERV.','LRB',0,'C');
		    $this->Cell(7,4,'SERV.','LRB',0,'C');
		    $this->Cell(15,4,'PRESUP.','LRB',0,'C');
	    }else{
	    	$this->Cell(40,4,'PRESUP.','LRB',0,'C');
	    }
	    
	   
	    $this->Cell(45,4,'','RB',0,'C');
		$this->Cell(9,4,'OC','RB',0,'C');
		$this->Cell(18,4,'COMPRA','RB',0,'C');
		$this->Cell(11,4,'PROCESO','RB',0,'C');
		$this->Cell(12,4,'PROCESO','RB',0,'C');
		$this->Cell(28,4,'','RB',0,'C');
		$this->Cell(27,4,'','RB',0,'C');
		$this->Cell(6,4,'','RB',0,'C');
		$this->Cell(12,4,'UNITARIO','RB',0,'C');
		$this->Cell(12,4,'TOT. Bs','RB',0,'C');
		$this->Cell(12,4,'PAGAR Bs','RB',0,'C');
 $this->Cell(9,4,'DIARIO','RB',0,'C');
 $this->Cell(9,4,'PAGO','RB',0,'C');
 $this->Cell(10,4,'Bs.','RB',0,'C');
 $this->Cell(10,4,'Bs.','RB',1,'C');
 
 //$this->Ln(0.3);
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
    $pdf->SetMargins(3,5,5);
    $pdf->AddPage();

$pdf->SetLineWidth(.1);
		if($_SESSION['PDF_tipo_adq']=='Bien'){
			 $pdf->SetWidths(array(0,6,0,0,0,0,0,0,40,45,9,18,11,12,28,27,6,12,12,12,9,9,10,10));
			 $pdf->SetVisibles(array(0,1,0,0,0,0,0,0,          1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
		}else{
			$pdf->SetWidths(array(0,6,0,0,0,8,8,7,15,45,9,18,11,12,28,27,6,12,12,12,9,9,10,10));
			 $pdf->SetVisibles(array(0,1,0,0,0,1,1,1,          1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
		}

	   
       $pdf->SetAligns(array('R','','','','','','','',   'L','L','L','L','L','L','L','L','R','R','R','R','L','L','R','R'));
      
       $pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
       $pdf->SetFontsSizes(array(4,4,4,4,4,4,4,    4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4));
       $pdf->SetSpaces(array(3,3,3,3,3,3,3,3,            3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
       $pdf->setDecimales(array(0,0,0,0,0,0,0,0,    0,0,0,0,0,0,0,0,0,2,2,2,0,0,2,2));
        	//en $data llegara toda la información.
       //en $data llegara toda la información.
       $total_devv=0; $total_pagg=0;
	$v_setdetalle=$_SESSION['PDF_ordenes_compra_general']; //print_r($v_setdetalle); exit;
       for ($i=0;$i<count($v_setdetalle);$i++){
       $pdf->MultiTabla($v_setdetalle[$i],1,3,3,5,1);
          $total_devv=$total_devv+$v_setdetalle[$i][18];
          $total_pagg=$total_pagg+$v_setdetalle[$i][19];
      }
      $pdf->Cell(254,4,'','LRB',0,'C');
      $pdf->SetFont('Arial','B',4);
      $pdf->Cell(10,4,is_numeric($total_devv)?number_format($total_devv,2):$total_devv,1,0,'R',0);
      $pdf->Cell(10,4,is_numeric($total_pagg)?number_format($total_pagg,2):$total_pagg,1,2,'R',0);

$pdf->Output();


?>