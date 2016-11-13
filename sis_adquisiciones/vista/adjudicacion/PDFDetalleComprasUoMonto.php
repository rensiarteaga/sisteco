<?php
session_start();

require('../../../lib/fpdf/fpdf.php');
include_once('../../../sis_adquisiciones/control/LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();
//require('../../../lib/fpdf/mc_table.php');

define('FPDF_FONTPATH','font/');
class PDF extends FPDF
{   
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    //Iniciación de variables
    }
 
function Header()
{
    $this->Image('../../../lib/images/logo_reporte.jpg',170,2,35,15);
    $this->Ln(10);
}
//Pie de página
function Footer()
{
   $fecha=date("d-m-Y");
	$hora=date("H:i:s");
	    $this->SetY(-13);
   	    $this->SetFont('Arial','',6);
		
		
		//$var_prov=$_SESSION['PDF_proveedores_0'];
		/*if($var_prov[0][5]>  '2013-10-29'){
			   $this->Cell(20,3,'Verificado propuesta por: ',0,0,'L');
			   $this->Cell(152,3,'',0,0,'L');
			   $this->ln(3);
		}*/
		
				$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
				
				$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
				$this->Cell(52,3,'',0,0,'L');
				;
				$this->ln(3);
				$this->Cell(70,3,'Sistema: ENDESIS - COMPRO',0,0,'L');
				$this->Cell(50,3,'',0,0,'C');
				$this->Cell(52,3,'',0,0,'L');
				
				$this->ln(3);
				$this->Cell(70,3,sha1(gregoriantojd(date('m'),date('d'),date('Y')).$hora),0,0,'L');
		
}

//Cabecera de página

}

$pdf=new PDF();
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf-> AddFont('Tahoma','','tahoma.php');
$pdf-> AddFont('Arial','','arial.php');
$pdf->SetAutoPageBreak(true,20);

//-----------------------Primera Factura
$pdf->SetFont('Tahoma','',10);
$pdf->SetLeftMargin(10);
$pdf->SetFont('Arial','B',14);

$pdf->SetFillColor(200,200,200);
$pdf->SetDrawColor(255,255,255);
$pdf->SetLineWidth(0.5);
/*Aqui declararemos todas las funciones obtenidas del control */

$Cotizacion_det=array();



$Adjudicaciones=$_SESSION['PDF_proveedores'];

$cant_adj=count($Adjudicaciones);

//$pdf->Cell(33,5,' ',0,0,'C');
$pdf->SetFont('Arial','',8);
//$pdf->Cell(90,5,$_SESSION["detalle"],0,1,'C');
//$pdf->Cell(23,5,' ',0,0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->MultiCell(170,5,''.$_SESSION["detalle"].'',0,'C',0);
$pdf->MultiCell(170,5,''.$_SESSION["detalle_fechas"].'',0,'C',0);
for($i=0;$i<$cant_adj;$i++){
 

  $proveedores =$_SESSION['PDF_proveedores'];
  //print_r($_SESSION['PDF_proveedores_'.$i]); exit;
  $tabla_aimprimir= array();
  $pdf->SetFont('Arial','B',8);






$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
//$cant_proveedores=count($proveedores);

$pdf->SetX(10);
$pdf->Cell(7,5,'Nº',0,0,'L');
$pdf->Cell(28,5,'Nº SOL',0,0,'L');
//$pdf->Cell(20,5,'PROVEEDOR',0,0,'L');
$pdf->Cell(72,5,'DETALLE',0,0,'L');
$pdf->Cell(44,4,'PARTIDA PRESUPUESTARIA',0,0,'L');
$pdf->Cell(13,4,'P.U.',0,0,'C');
$pdf->Cell(13,4,'CANT.',0,0,'C');
$pdf->Cell(30,4,'TOTAL ADJ.',0,1,'C');

$pdf->SetFont('Arial','',7);




//for($v=0;$v<count($proveedores);$v++){
   // echo $proveedores[0][0]; exit;
    $id_cotizacion=$proveedores[$i][0];
	$proveedor=$proveedores[$i][1];
	$total_proveedor=$proveedores[$i][2];
    $moneda=$proveedores[$i][3];
	//$observaciones_adj=$proveedores[$i][8];  
		
	$pdf->SetX(10);
	$pdf->Cell(180,4,'PROVEEDOR:                     ' .$proveedores[$i][1].'',0,0,'L',1); 
	$pdf->Cell(7,4,''.$proveedores[$i][3].'',0,0,'R',1); 
	$pdf->Cell(16,4,''.number_format($proveedores[$i][2],2).'',0,1,'R',1); 
	
	
	   $Cotizacion_det=$Custom->RepAdjudicacionDetCompra($proveedores[$i][0],'2');
	   
	        $_SESSION['PDF_detalle']=$Custom->salida;   	
	        $detalle_documentos=$_SESSION['PDF_detalle'];	  
		    $yy=$pdf->GetY();
	   	
		   	$limite=$pdf->PageBreakTrigger;
		   	$pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial'));
			$pdf->SetFontsStyles(array('','','','',''));
			$pdf->SetVisibles(array(1,1,1,1,1,1));
			$pdf->SetFontsSizes(array(7,7,7,7,7,7));
			$pdf->SetSpaces(array(4,4,4,4,4,4));
			$pdf->SetWidths(array(7,13,85,43,16,16));
			$pdf->SetDecimales(array(0,0,0,0,2,2));
			$pdf->SetFormatNumber(array(0,0,0,0,1,1));
			$pdf->SetAligns(array('L','L','L','L','R','R'));

	   		
			for ($j=0;$j<sizeof($detalle_documentos);$j++){
				$numero=$j+1;
				$pdf->Multitabla(array_merge((array)$numero,(array)$detalle_documentos[$j]),0,1,4,7,1);
				
			}
		
			$pdf->ln(5);
		


			$pdf->SetFont('Arial','B',10);
			$posy=$pdf->GetY();
			
			$pdf->Ln(6);

			
			/*if ($proveedores[$v][2]<=50000  ){
    
				if ($proveedores[0][5]> '2013-10-29'){
						$pdf->Ln(18);
						
						
						$pdf->SetFont('Arial','B',14);
						$pdf->MultiCell(180,3,"RESOLUCIÓN DE AUTORIZACIÓN N° ". $_SESSION['PDF_num_proceso'].' '.$_SESSION['PDF_uo_adjudicado'],'','C',0);
						
						$pdf->Ln(5);

						$pdf->Ln(5);
						$pdf->SetFont('Arial','B',7);
						$cant_proveedores=count($proveedores);
						
						$pdf->SetX(10);
						$pdf->Cell(7,5,'Nº',0,0,'L');
						$pdf->Cell(28,5,'Nº SOL',0,0,'L');
						//$pdf->Cell(20,5,'PROVEEDOR',0,0,'L');
						$pdf->Cell(72,5,'DETALLE',0,0,'L');
						$pdf->Cell(44,4,'PARTIDA PRESUPUESTARIA',0,0,'L');
						$pdf->Cell(13,4,'P.U.',0,0,'C');
						$pdf->Cell(13,4,'CANTIDAD',0,0,'C');
						$pdf->Cell(30,4,'TOTAL ADJUDICADO',0,1,'C');
						$pdf->SetX(10);
						$pdf->Cell(180,4,'PROVEEDOR:                     ' .$proveedores[$v][1].'',0,0,'L',1);
						$pdf->Cell(7,4,''.$proveedores[$v][3].'',0,0,'R',1);
						$pdf->Cell(16,4,''.number_format($proveedores[$v][2],2).'',0,1,'R',1);
						$pdf->SetFont('Arial','',7);
						$pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial'));
						$pdf->SetFontsStyles(array('','','','',''));
						$pdf->SetVisibles(array(1,1,1,1,1,1));
						$pdf->SetFontsSizes(array(7,7,7,7,7,7));
						$pdf->SetSpaces(array(4,4,4,4,4,4));
						$pdf->SetWidths(array(7,13,85,43,16,16));
						$pdf->SetDecimales(array(0,0,0,0,2,2));
						$pdf->SetFormatNumber(array(0,0,0,0,1,1));
						$pdf->SetAligns(array('L','L','L','L','R','R'));
						
						for ($j=0;$j<sizeof($detalle_documentos);$j++){
							$numero=$j+1;
							$pdf->Multitabla(array_merge((array)$numero,(array)$detalle_documentos[$j]),0,1,4,7,1);
						
						}
						
						
						$pdf->Ln(8);
						$pdf->SetX(35);
						$pdf->SetFont('Arial','',10);
						$pdf->MultiCell(180,3,"POR TANTO: "."\n\nEn virtud a lo establecido en los Arts. 22 y 33 del RE-SABS-EPNE, Autoriza la contratación",'','L',0); 
						
				
					}
					$pdf->SetFont('Arial','B',10);
					$pdf->Ln(15);
					$pdf->MultiCell(180,5,"_______________________________\n".' '. ''.''."\nRPCD",'','C',0); //11/11/13: se cambia RPCDM por RPCD en atencion a correo de Adolfo Perez (Jefe Depto Adm) autorizado por Americo Fiorilo (jefe UTI), tras puesta en vigencia de nuevo RE-SABS
			}*/

//}

/*if($i+1<$cant_adj){
 $pdf->AddPage();
}*/
}




$pdf->Output();
?>