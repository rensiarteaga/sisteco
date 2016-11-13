<?php

session_start();
/**Autor: Ana María Villegas Quispe
 * Fecha Mod: 19/08/2009
 * Desc:   Reporte de solicitud de fondos se inserto 3 hojas en uno 
 
 */

require('../../../lib/fpdf/fpdf.php');
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
 function SetPrograma($nombre_programa)
{
    $this->nombre_programa=$nombre_programa;
}   
 //Cabecera
function Header()
{
	

}
//Pie de página
function Footer()
{
 $fecha=date("d-m-Y");
	$hora=date("h:i:s");
	    $this->SetY(-7);
   	    $this->SetFont('Arial','',6);
   	    //$this->Cell(200,0.2,'',1,1);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS -TESORO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	
   }
}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,7);
$pdf->SetMargins(5,5,5);
$pdf->SetFont('Arial','B',8);
$solicitud_detalle=$_SESSION['PDF_solicitud_viaje_det'];	
$inicio_boleta=$pdf->GetY();
//for ($i=0;$i<3;$i++){

$pdf->SetFont('Arial','B',14);
$y=$inicio_boleta;
$pdf->SetXY(5,$y);
$pdf->Cell(40,12,'',1,0);
$pdf->Image('../../../lib/images/logo_reporte.jpg',10,$y+2,30,10);
$pdf->SetXY(45,$y);
//$y_cab=$pdf->GetY();
$pdf->Cell(125,7,'SOLICITUD FONDOS','LTR',1,'C');
$pdf->SetFont('Arial','',8);
$pdf->SetXY(45,$y+7);
$pdf->MultiCell(125,5,'CUENTA DOCUMENTADA','LRB','C');
$x=$pdf->GetX();

				
$fecha_completa=$_SESSION['PDF_fecha_solicitud'];
$dia=substr($fecha_completa,0,2);
$mes=substr($fecha_completa,3,2); 
$anio=substr($fecha_completa,6,4);


$pdf->SetFont('Arial','B',8);
$pdf->SetXY(170,$y);
$pdf->Cell(42,4,$_SESSION['PDF_nro_sol'],1,1,'C'); 
$pdf->SetFont('Arial','',8);

$pdf->SetFont('Arial','B',8);
$pdf->SetX(170);
$pdf->Cell(14,4,'Día',1,0,'C');
$pdf->Cell(14,4,'Mes',1,0,'C');
$pdf->Cell(14,4,'Año',1,1,'C');

$pdf->SetFont('Arial','',8);
$pdf->SetX(170);
$pdf->Cell(14,4,$dia,1,0,'C');
$pdf->Cell(14,4,$mes,1,0,'C');
$pdf->Cell(14,4,$anio,1,0,'C');

$pdf->Ln(3);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(210,1,'',0,1);
$pdf->Cell(69,5,'Nombre y Apellido',1,0,'C');
$pdf->Cell(69,5,'Cargo',1,0,'C');
$pdf->Cell(69,5,'Centro de Responsabilidad',1,1,'C');
 
$nombres=array();

$pdf->SetWidths(array(69,69,69));
$pdf->SetVisibles(array(1,1,1));
$pdf->SetSpaces(array(4,4,4));
$pdf->SetFontsSizes(array(7,7,7));


$nombres [0][0]=$_SESSION['PDF_nombre_empleado'];
$nombres [0][1]=$_SESSION['PDF_cargo'];
$nombres [0][2]=$_SESSION['PDF_centro_responsabilidad'];
$pdf->SetFont('Arial','',7);	
$pdf->Multitabla($nombres[0],0,3,4,7);

$y_motivo=$pdf->GetY();
$pdf->SetFont('Arial','B',8);	
$pdf->Cell(207,5,'MOTIVO DE LA SOLICITUD','LRT',1);
$pdf->SetFont('Arial','',7);
$pdf->SetY($y_motivo);	
$pdf->MultiCell(207,4,'                                                           : '.$pdf->preview_text($_SESSION['PDF_motivo'],490,0),'LBR');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(30,10,'COMISIÓN',1,0,'C');
$pdf->Cell(132,5,'Lugar',1,0,'C');
$pdf->Cell(45,5,'Fecha Iniciación',1,1,'C');
//$pdf->Cell(30,5,'Fecha Conclusión',1,0,'C');
$pdf->SetX(35);
$pdf->SetFont('Arial','',8);
//$y=$pdf->GetY();

$pdf->Cell(132,5,$_SESSION['PDF_lugar'],1,0,'C');
$pdf->Cell(45,5,$_SESSION['PDF_fecha_ini'],1,1,'C');
//$pdf->Cell(30,5,'',1,0,'C');
//$pdf->MultiCell(87,15,number_format($_SESSION['PDF_monto'],2),1,'C');
$pdf->SetFont('Arial','B',8);
 $pdf->Cell(60,3,'Descripción ',1,0,'C');  
 $pdf->Cell(18,3,'Importe ',1,0,'C');  
 $pdf->Cell(84,3,'Presupuesto ',1,0,'C');  
 $pdf->Cell(45,3,'Observaciones',1,1,'C');  
$pdf->SetWidths(array(0,60,18,84,45));
		$pdf->SetFills(array(0,0,0,0,0));
 		$pdf->SetAligns(array('L','L','R','L','L'));
 		$pdf->SetVisibles(array(0,1,1,1,1));
 		$pdf->SetFontsSizes(array(6,6,6,6,6));
 		$pdf->SetFontsStyles(array('','','','',''));
 		$pdf->SetDecimales(array(0,0,2,0,0));
 		$pdf->SetSpaces(array(3,3,3,3,3));
 		$pdf->SetFormatNumber(array(0,0,1,0,0));
		$total_importe=0;
		for ($i=0;$i<sizeof($solicitud_detalle);$i++){
 	 		
	  		$pdf->MultiTabla($solicitud_detalle[$i],0,3,3,6,1);
	  		$total_importe=$total_importe+$solicitud_detalle[$i][2];
   		}


$pdf->SetFont('Arial','B',8);
//$pdf->SetY($y+5);
$pdf->Cell(162,5,'MONTO: (Literal)','LRT',0);
$pdf->Cell(45,5,'Monto ('.$_SESSION['PDF_simbolo'].')',1,1,'C');
$y1=$pdf->GetY();

$pdf->SetFont('Arial','',8);
$pdf->MultiCell(162,5,'Son: '.$pdf->num2letras($total_importe,false).' '.$_SESSION['PDF_simbolo'],'LR');
$y_obs=$pdf->GetY();
$pdf->SetXY(167,$y1);
$pdf->Cell(45,5,''.number_format($total_importe,2),1,1,'C');
// aqui el total y el detalle


$pdf->SetFont('Arial','B',8);
$pdf->SetY($y_obs);
$pdf->Cell(207,4,'OBSERVACIONES','LRT',1);

$pdf->SetFont('Arial','',7);
$pdf->MultiCell(207,3.5,'                                      : '.$pdf->preview_text($_SESSION['PDF_observaciones'],510,0),'LRB',1);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(52,5,'SOLICITUD',1,0,'C');
$pdf->Cell(52,5,'APROBACIÓN',1,0,'C');
$pdf->Cell(52,5,'AUTORIZACIÓN',1,0,'C');
$pdf->Cell(51,5,'Vo Bo',1,1,'C');
$pdf->Cell(52,15,'',1,0,'C');
$pdf->Cell(52,15,'',1,0,'C');
$pdf->Cell(52,15,'',1,0,'C');
$pdf->Cell(51,15,'',1,1,'C');
/*if($i!=2){
$fecha=date("d-m-Y");
	$hora=date("h:i:s");
	  
   	    $pdf->SetFont('Arial','',6);
   	   
		$pdf->Cell(120,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		
		$pdf->Cell(34,3,'',0,0,'L');
		$pdf->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$pdf->Cell(18,3,'  Hora: '.$hora,0,1,'L');	
		$pdf->Ln(3);}
$inicio_boleta=$inicio_boleta + 90;	*/
//}
$pdf->Output();
?>


 