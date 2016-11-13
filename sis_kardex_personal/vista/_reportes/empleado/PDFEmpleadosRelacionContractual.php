<?php
session_start();
/**
 * Autor: Ana Maria VQ
 * Fecha de creacion: 18/05/2011
 * Descripción: Reporte de Empleados  Relacion Contractual
 * Fecha de modificacion 19/05/2011
 * descripcion: El usuario solo necesita de las personas que estan activas ahora y su correspondiente cargo quitar las fechas.
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

function SetNombreLugar($nombre_lugar)
{
    $this->nombreLugar =$nombre_lugar;
}
function SetTipoContrato($tipo_contrato)
{
    $this->tipoContrato =$tipo_contrato;
}

function Header()
{       
   $this->Image('../../../../lib/images/logo_reporte.jpg',180,0,30,10);
   $cabecera=$_SESSION['PDF_cab_rep_planilla'];
   $this->SetFont('Arial','B',7);
	$this->Cell(30,3,'No. Patronal:511-2067',0,1);
	$this->Cell(30,3,'N.I.T.: 1023187029',0,1);
   $this->SetFont('Arial','BU',12);
   $this->Cell(0,5,'RELACION CONTRACTUAL DE FUNCIONARIOS ' ,0,1,'C');
    $this->SetFont('Arial','B',8);
   

$fecha=date_create ($_SESSION['PDF_ec_fecha_ini']); 
$fecha_ini=date_format( $fecha,'d/m/Y');

$fecha1=date_create ($_SESSION['PDF_ec_fecha_fin']); 
$fecha_fin=date_format( $fecha1,'d/m/Y');

  $this->Cell(0,5,'Hasta el '.$fecha_ini,0,1,'C');
   $this->Ln(2);
   //Aqui mostrare la cabecera
    $this->SetFont('Arial','B',9);
   // $this->nombreLugar.''.$this->tipo_contrato;
    //$this->Cell(5,3.5,'',0,0,'C');
    $this->Cell(25,3.5,''.$this->nombreLugar,0,1,'L');
        $this->SetFont('Arial','BI',7);
         $this->Cell(5,3.5,'',0,0,'C');
         $this->Cell(25,3.5,''.$this->tipoContrato,0,1,'L');
     
    $this->Cell(60,3,'GERENCIA',1,0,'C');
    $this->Cell(60,3,'UNIDAD',1,0,'C');
   $this->Cell(60,3,'NOMBRE FUNCIONARIO',1,0,'C');
   $this->Cell(60,3,'CARGO',1,0,'C');    
   $this->Cell(15,3,'INTERNO',1,0,'C');
   $this->Cell(15,3,'CEL. CORP.',1,1,'C');
   
}
 
//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
    $fecha=date("d-m-Y");
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
		$this->ln(3);
	
	
	  
   	  
     }

}
  	$pdf=new PDF();	
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,7);
    $pdf->SetMargins(5,5,5);  
    
    $pdf->SetFont('Arial','',6);
	
    

 
 	//$cabecera=$_SESSION['PDF_cab_rep_planilla'];
 	$detalle=$_SESSION["PDF_empleados_cargo_detalle"];
   $pdf->SetWidths(array(60,60,60,60,15,15));
	$pdf->SetFills(array(0,0,0,0,0,0));
 	$pdf->SetAligns(array('L','L','L','L','L','L'));
 	$pdf->SetVisibles(array(1,1,1,1,1,1));
  	$pdf->SetFontsSizes(array(6,6,6,6,6,6));
 	$pdf->SetFontsStyles(array('','','','','',''));
 	$pdf->SetSpaces(array(3,3,3,3,3,3));
 	$pdf->setDecimales(array(0,0,0,0,0,0));
    $pdf->SetFormatNumber(array(0,0,0,0,0,0));
    /*
 	$pdf->SetWidths(array(15,65,65,15,15,15,15));
	$pdf->SetFills(array(0,0,0));
 	$pdf->SetAligns(array('L','L','L','R','R','R','R'));
 	$pdf->SetVisibles(array(1,1,1,1,1,1,1));
  	$pdf->SetFontsSizes(array(5,6,6,6,6,6,6,6,6));
 	$pdf->SetFontsStyles(array('','',''));
 	$pdf->SetSpaces(array(4,4,4,4,4,4,4,4,4));
 	$pdf->setDecimales(array(0,0,0,0,0,0,0,0,0));
    $pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0));
 	*/
 	     /*  print_r($detalle);
 	       exit; */
 	    /*  print_r($tip_cont);
 	       exit;
 	       */
 	 	
 	 		$desc_lugar='';
 	 		$tip_cont='';
 	 		//$sum_parc=0;
 	 			 
 	 		for ($i=0;$i<count($detalle);$i++){
 	 			if($detalle[$i]["nombre_lugar"]<>$desc_lugar)
 	 			{   $pdf->SetNombreLugar($detalle[$i]["nombre_lugar"]);
 	 			    $pdf->SetTipoContrato($detalle[$i]["tipo_contrato"]);
 	 			    $pdf->AddPage();
 	 			    
 	 			
 	 				//Enviar a la cabecera para que muestre el nombre del banco
 	 			
 	 			$desc_lugar=$detalle[$i]["nombre_lugar"];
 	 			
 	 			}
 	 		
 	 			if ($i!=0){
 	 			    	if ($tip_cont<>$detalle[$i]["tipo_contrato"]){
 	 			    		$tip_cont=$detalle[$i]["tipo_contrato"];
 	 			    		$pdf->SetTipoContrato($detalle[$i]["tipo_contrato"]);
 	 			    		$pdf->AddPage();

 	 			    		
 	 			    	}
 	 			    }
 	 			    	$tip_cont=$detalle[$i]["tipo_contrato"];
 	 			 
 	 			$detalle[$i][0]=$detalle[$i]['gerencia'];
 	 			$detalle[$i][1]=$detalle[$i]['unidad'];
 	 			$detalle[$i][2]=$detalle[$i]['nombre_completo'];
 	 			$detalle[$i][3]=$detalle[$i]['cargo'];
 	 			$detalle[$i][4]=$detalle[$i]['nro_interno'];
 	 			$detalle[$i][5]=$detalle[$i]['nro_celular'];
 	 			
 	 			//$detalle[$i][2]='';
 	 			$pdf->SetLineWidth(0.05);
 	 			 $pdf->MultiTabla($detalle[$i],0,3,4,6,1);
 	 			$pdf->SetLineWidth(0.1);
 	 			                  
 	 		}
 	 		
 	
 
 	
 	
 
$pdf->Output();

?>