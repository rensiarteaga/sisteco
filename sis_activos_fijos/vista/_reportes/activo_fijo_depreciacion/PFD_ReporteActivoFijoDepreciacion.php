<?php
session_start();
/**
 * Autor: 
 * Fecha de creacion: 
 * Descripción:
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
		$fecha=date("d-m-Y");
		
		$this->Image('../../../../lib/images/logo_reporte.jpg',237,2,35,15); //LOGO
		$this->Ln(5);
		$this->SetFont('Arial','B',5);
		$this->SetX(15);
		$this->Ln(2.5);
	
	   	$this->SetFont('Arial','B',5);
	 	$this->Cell(0,4,'REPORTE DEPRECIACION ACTIVOS FIJOS 2012',0,1,'C');
	 	$this->SetFont('Arial','B',5);
		 
		 $this->SetX(10);
		 $this->SetFillColor(230 , 230, 230);
		 $this->Cell(16,2,'CODIGO ACTIVO','LTR',0,'C',true);
		 $this->Cell(15,2,'VIDA UTIL','LTR',0,'C',true);
		 $this->Cell(15,2,'VALOR','LTR',0,'C',true);
		 $this->Cell(21,2,'ACTUALIZACION','LTR',0,'C',true);
		 $this->Cell(15,2,'VALOR','LTR',0,'C',true);
		 $this->Cell(20,2,'DEPRECIACION','LTR',0,'C',true);
		 $this->Cell(20,2,'ACTUALIZACION','LTR',0,'C',true);
		 $this->Cell(20,2,'DEPRECIACION','LTR',0,'C',true);
		 $this->Cell(20,2,'DEPRECIACION','LTR',0,'C',true);
		 $this->Cell(20,2,'DEPRECIACION','LTR',0,'C',true);
		 $this->Cell(15,2,'VALOR','LTR',0,'C',true);
		 $this->Cell(15,2,'CODIGO','LTR',0,'C',true);
		 $this->Cell(12,2,'CODIGO','LTR',0,'C',true);
		 $this->Cell(12,2,'CODIGO','LTR',0,'C',true); 
		 $this->Cell(12,2,'CODIGO','LTR',0,'C',true);   
		 $this->Cell(12,2,'CODIGO','LTR',1,'C',true);
		 
		
			
			// $this->SetX(20);
			 $this->SetX(10);
			 
		 $this->Cell(16,2,'FIJO','LBR',0,'C',true);
		 $this->Cell(15,2,'','LBR',0,'C',true);
		 $this->Cell(15,2,'CONTABLE','LBR',0,'C',true);
		 $this->Cell(21,2,'','LBR',0,'C',true);
		 $this->Cell(15,2,'TOTAL','LBR',0,'C',true);
		 $this->Cell(20,2,'ACUMULADA','LBR',0,'C',true);
		 $this->Cell(20,2,'DEPRECIACION','LBR',0,'C',true);
		 $this->Cell(20,2,'ACUMULADA ACT ','LBR',0,'C',true);
		 $this->Cell(20,2,'PERIODO','LBR',0,'C',true);
		 $this->Cell(20,2,'ACUMULADA','LBR',0,'C',true);
		 $this->Cell(15,2,'NETO','LBR',0,'C',true);
		 $this->Cell(15,2,'FINANCIAM.','LBR',0,'C',true);
		 $this->Cell(12,2,'REGIONAL','LBR',0,'C',true); 
		 $this->Cell(12,2,'PROGRAMA','LBR',0,'C',true); 
		 $this->Cell(12,2,'PROYECTO','LBR',0,'C',true);
		 $this->Cell(12,2,'ACTIVIDAD','LBR',1,'C',true);  
	}

	//Pie de página
	function Footer()
	{
	    $fecha=date("d-m-Y");
		$hora=date("H:i:s");
		$this->SetLeftMargin(10);
		$this->SetY(-7);
		$this->SetFont('Arial','',5);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Pagina '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(65,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'R');
		$this->ln(3);
		$this->Cell(100,3,'Sistema: ENDESIS - ACTIF',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(35,3,'',0,0,'C');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'R');	        
     }
}

$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(true,7);
$pdf->SetMargins(10,5,5);
	    
$pdf->AddPage(); 
	    
//$pdf->SetFont('Arial','',5);
$pdf->SetWidths(array(0,0,0,16,15,15,21,15,20,20,20,20,20,15,15,12,12,12,12));
$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
$pdf->SetVisibles(array(0,0,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
$pdf->SetFontsSizes(array(5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5,5));
$pdf->SetAligns(array('L','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R','R'));
$pdf->SetFontsStyles(array('','','','','','','','','','','','','','','','','','',''));
$pdf->SetDecimales(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3,3));
$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0));
        
$det_af = $_SESSION["PDF_reporte_depreciacion_nuevo2"];

$cont = count($det_af);
//sumas parciales por tipo de activo fijo
$valor_contable=0;
$actualizacion=0;
$valor_total=0;
$dep_acum_ini=0;
$act_dep=0;
$dep_acum_act=0;
$dep_periodo=0;
$dep_acum=0;
$valor_neto=0;
//fin sumas parciales por tipode activo fijo
//sumas totales por regionales
$valor_contable_total=0;
$actualizacion_total=0;
$valor_total_total=0;
$dep_acum_ini_total=0;
$act_dep_total=0;
$dep_acum_act_total=0;
$dep_periodo_total=0;
$dep_acum_total=0;
$valor_neto_total=0;
//fin sumas totales por regionales
//SUMAS TOTALES
$total1=0;
$total2=0;
$total3=0;
$total4=0;
$total5=0;
$total6=0;
$total7=0;
$total8=0;
$total9=0;
//FIN SUMAS TOTALES
for($j=0;$j<$cont;$j++)
 {
 	$regional=$det_af[$j][15];
 	$id_tipo=$det_af[$j][0];
 	$id_tipo2=$det_af[$j+1][0];
 	$cod_regional=$det_af[$j][15];
 	$cod_regional2=$det_af[$j+1][15];
 	
 	$total1+=$det_af[$j][5];
 	$total2+=$det_af[$j][6];
 	$total3+=$det_af[$j][7];
 	$total4+=$det_af[$j][8];
 	$total5+=$det_af[$j][9];
 	$total6+=$det_af[$j][10];
 	$total7+=$det_af[$j][11];
 	$total8+=$det_af[$j][12];
 	$total9+=$det_af[$j][13];
 	
 	
 	$pdf->SetX(10);
 	//$numero=$j+1;
 	 //$pdf->MultiTabla($det_af[$j],3,3,2.5,8,1);
   $pdf->MultiTabla((array_merge((array)$det_af[$j])),0,3,3,6);
    //$pdf->MultiTabla($det_af[$j],0,3,3,6);
    //$pdf->SetLineWidth(0.1);
    
  if($id_tipo==$id_tipo2)
     {
     	//echo "dsagjdgasjh";
     	$valor_contable+=$det_af[$j][5];
     	$actualizacion+=$det_af[$j][6];
     	$valor_total+=$det_af[$j][7];
     	$dep_acum_ini+=$det_af[$j][8];
     	$act_dep+=$det_af[$j][9];
     	$dep_acum_act+=$det_af[$j][10];
     	$dep_periodo+=$det_af[$j][11];
     	$dep_acum+=$det_af[$j][12];
     	$valor_neto+=$det_af[$j][13]; 
     }
     else
     {
     	//agrega la ultima fila a la suma,con id_tipo_activo_fijo iguales
     		$valor_contable+=$det_af[$j][5];
     		$actualizacion+=$det_af[$j][6];
     		$valor_total+=$det_af[$j][7];
     		$dep_acum_ini+=$det_af[$j][8];
     		$act_dep+=$det_af[$j][9];
     		$dep_acum_act+=$det_af[$j][10];
     		$dep_periodo+=$det_af[$j][11];
     		$dep_acum+=$det_af[$j][12];
     		$valor_neto+=$det_af[$j][13];
     	//
     	 
     	//$pdf->Cell(25,3,'',0,0,'L');
     	$pdf->SetX(10);
     	$pdf->SetFont('Arial','B',5);
    	 $pdf->Cell(16,3,'','LBT',0,'R',false);
		 $pdf->Cell(15,3,'','BRT',0,'R',false);
		 $pdf->Cell(15,3,$valor_contable,'LBRT',0,'R',false);
		 $pdf->Cell(21,3,$actualizacion,'LBRT',0,'R',false);
		 $pdf->Cell(15,3,$valor_total,'LBRT',0,'R',false);
		 $pdf->Cell(20,3,$dep_acum_ini,'LBRT',0,'R',false);
		 $pdf->Cell(20,3,$act_dep,'LBRT',0,'R',false);
		 $pdf->Cell(20,3,$dep_acum_act,'LBRT',0,'R',false);
		 $pdf->Cell(20,3,$dep_periodo,'LBRT',0,'R',false);
		 $pdf->Cell(20,3,$dep_acum,'LBRT',0,'R',false);
		 $pdf->Cell(15,3,$valor_neto,'LBRT',1,'R',false);
		 
		
 	 	/*$pdf->Cell(15,5,$valor_contable,1,0,'C');
 	 	//$pdf->SetX(115);
 	 	$pdf->Cell(21,5,$actualizacion,1,0,'C');
 	 	//$pdf->SetX(127);
 	 	$pdf->Cell(15,5,$valor_total,1,0,'C');
 	 	$pdf->Cell(20,5,$dep_acum_ini,1,0,'C');
 	 	$pdf->Cell(20,5,$act_dep,1,0,'C');
 	 	$pdf->Cell(20,5,$dep_acum_act,1,0,'C');
 	 	$pdf->Cell(20,5,$dep_periodo,1,0,'C');
 	 	$pdf->Cell(20,5,$dep_acum,1,0,'C');
 	 	$pdf->Cell(15,5,$valor_neto,1,0,'C');
 	 	*/
 	 	
 	 	$pdf->SetY($pdf->GetY()+3);
 	 	$pdf->SetX(10);
 	 	$pdf->Cell(237,3,'',0,0,'C');
 	 	
 	 	//reinicializa las sumas
 	 	$valor_contable=0;
		$actualizacion=0;
		$valor_total=0;
		$dep_acum_ini=0;
		$act_dep=0;
		$dep_acum_act=0;
		$dep_periodo=0;
		$dep_acum=0;
		$valor_neto=0;	
     }
     	//$comparacion=$pdf->comparar($cod_regional,$cod_regional2);
 		if($cod_regional==$cod_regional2)
     	{
     		$valor_contable_total+=$det_af[$j][5];
			$actualizacion_total+=$det_af[$j][6];
			$valor_total_total+=$det_af[$j][7];
			$dep_acum_ini_total+=$det_af[$j][8];
			$act_dep_total+=$det_af[$j][9];
			$dep_acum_act_total+=$det_af[$j][10];
			$dep_periodo_total+=$det_af[$j][11];
			$dep_acum_total+=$det_af[$j][12];
			$valor_neto_total+=$det_af[$j][13];
     	}
     	else
     	{
     		$valor_contable_total+=$det_af[$j][5];
			$actualizacion_total+=$det_af[$j][6];
			$valor_total_total+=$det_af[$j][7]; 
			$dep_acum_ini_total+=$det_af[$j][8];
			$act_dep_total+=$det_af[$j][9];
			$dep_acum_act_total+=$det_af[$j][10];
			$dep_periodo_total+=$det_af[$j][11];
			$dep_acum_total+=$det_af[$j][12];
			$valor_neto_total+=$det_af[$j][13];
			
		
     	$pdf->SetX(10);
     	$pdf->SetFont('Arial','B',5);
     	$pdf->Cell(31,3,'Total Regional',1,0,'C');
     	$pdf->SetFont('Arial','B',5);
     	//$pdf->Cell(15,4,$valor_neto,'LBRT',1,'R',false);
		 
 	 	$pdf->Cell(15,3,$valor_contable_total,'LBRT',0,'R',false);
 	 	$pdf->Cell(21,3,$actualizacion_total,'LBRT',0,'R',false);
 	 	$pdf->Cell(15,3,$valor_total_total,'LBRT',0,'R',false);
 	 	$pdf->Cell(20,3,$dep_acum_ini_total,'LBRT',0,'R',false);
 	 	$pdf->Cell(20,3,$act_dep_total,'LBRT',0,'R',false);
 	 	$pdf->Cell(20,3,$dep_acum_act_total,'LBRT',0,'R',false);
 	 	$pdf->Cell(20,3,$dep_periodo_total,'LBRT',0,'R',false);
 	 	$pdf->Cell(20,3,$dep_acum_total,'LBRT',0,'R',false);
 	 	$pdf->Cell(15,3,$valor_neto_total,'LBRT',1,'R',false);
 	 	
 	 	
 	 	$pdf->SetY($pdf->GetY()+3);
 	 	$pdf->SetX(20);
 	 	$pdf->Cell(237,3,'',0,0,'L');
 	 	
 	 	//reinicializa las sumas
 	 	$valor_contable_total=0;
		$actualizacion_total=0;
		$valor_total_total=0;
		$dep_acum_ini_total=0;
		$act_dep_total=0;
		$dep_acum_act_total=0;
		$dep_periodo_total=0;
		$dep_acum_total=0;
		$valor_neto_total=0;
     	}
  if($cont-1==$j)
  {    
  		$pdf->SetFont('Arial','B',5);
  		$pdf->SetY($pdf->GetY()+5);
  		$pdf->SetX(10);
     	$pdf->Cell(31,3,'Total General',1,0,'C');
     	$pdf->SetFont('Arial','B',5);
 	 	$pdf->Cell(15,3,$total1,1,0,'C');
 	 	//$pdf->SetX(115);
 	 	$pdf->Cell(21,3,$total2,1,0,'C');
 	 	//$pdf->SetX(127);
 	 	$pdf->Cell(15,3,$total3,'LBRT',0,'R',false);
 	 	$pdf->Cell(20,3,$total4,'LBRT',0,'R',false);
 	 	$pdf->Cell(20,3,$total5,'LBRT',0,'R',false);
 	 	$pdf->Cell(20,3,$total6,'LBRT',0,'R',false);
 	 	$pdf->Cell(20,3,$total7,'LBRT',0,'R',false);
 	 	$pdf->Cell(20,3,$total8,'LBRT',0,'R',false);
 	 	$pdf->Cell(15,3,$total9,'LBRT',1,'R',false);
 	 	
  }
 }

$pdf->Output();
?>