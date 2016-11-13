<?php

session_start();
/**
 * Autor: Silvia Ximena Ortiz Fernández
 * Fecha de creacion: 09/02/2011
 * Descripción: Reporte de activo_fijo_depreciacion
 * **/

require('../../../lib/fpdf/fpdf.php');
include_once("../../control/LibModeloActivoFijo.php");
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

	function Header()
	{       
	 $this->Image('../../../lib/images/logo_reporte.jpg',230,2,35,15);
	 $this->Ln(5);
	 $this->SetFont('Arial','B',8);
	 $this->SetX(15);
	 $this->Ln(1.5);

	 $this->SetFont('Arial','B',16);
	 $this->Cell(0,6,'DETALLE DEPRECIACION DE ACTIVO FIJO',0,1,'C');
	 $this->Ln(8);
	 
	 $this->SetFont('Arial','B',8);
	 $this->Cell(30,4,'FECHA PROCESO',0,0);
	 $this->SetFont('Arial','',8);
	 $this->Cell(105,4,$_SESSION["PDF_fecha_contabilizacion"],0,1); 
	 $this->Cell(30,3,'',0,1);
	 
	 $this->SetFont('Arial','B',8);
	 $this->Cell(30,4,'DESCRIPCION',0,0);
	 $this->SetFont('Arial','',8);
	 $this->Cell(105,4,$_SESSION["PDF_descripcion"],0,1); 
	 $this->Cell(30,3,'',0,1);
	
	 $this->Ln(4);
	 $this->SetFont('Arial','B',8);
	 $this->Cell(20,3,'CODIGO','TRL',0,'C'); 
	 $this->Cell(15,3,'VIDA UTIL','TRL',0,'C'); 
	 $this->Cell(20,3,'VALOR','TRL',0,'C'); 
	 $this->Cell(25,3,'ACTUALIZACION ','TRL',0,'C'); 
	 $this->Cell(15,3,'VALOR','TRL',0,'C'); 
	 $this->Cell(30,3,'DEPRECIACION','TRL',0,'C');  
	 $this->Cell(30,3,'ACTUALIZACION','TRL',0,'C');  
	 $this->Cell(35,3,'DEPRECIACION ACUM','TRL',0,'C');
	 $this->Cell(30,3,'DEPRECIACION','TRL',0,'C');   
	 $this->Cell(28,3,'DEPRECIACION','TRL',0,'C');
	 $this->Cell(18,3,'VALOR','TRL',1,'C');
	
	 $this->Cell(20,3,'','BRL',0,'C');  
	 $this->Cell(15,3,'ACTUAL','BRL',0,'C');  
	 $this->Cell(20,3,'CONTABLE','BRL',0,'C');
	 $this->Cell(25,3,'','BRL',0,'C');  
	 $this->Cell(15,3,'TOTAL','BRL',0,'C');
	 $this->Cell(30,3,'ACUMULADA INICIAL','BRL',0,'C');
	 $this->Cell(30,3,'DEPRECIACION','BRL',0,'C');
	 $this->Cell(35,3,'ACTUALIZADA','BRL',0,'C');
	 $this->Cell(30,3,'PERIODO','BRL',0,'C');	
	 $this->Cell(28,3,'ACUMULADA','BRL',0,'C');  
	 $this->Cell(18,3,'NETO','BRL',1,'C'); 

	 $this->Ln(0.3);
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
			$this->Cell(100,3,'Sistema: ENDESIS -ACTIF',0,0,'L');
			$this->Cell(70,3,'',0,0,'C');
			$this->Cell(62,3,'',0,0,'L');
			$this->Cell(18,3,'Hora: '.$hora,0,0,'L');	 
	}
}

	$pdf=new PDF();
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,7);
    $pdf->SetMargins(5,5,5);
    $pdf->AddPage();

	 $pdf->SetWidths(array(20,15,20,25,15,30,30,35,30,28,18));
	 $pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0,0));
	 $pdf->SetAligns(array('L','L','R','R','R','R','R','R','R','R','R'));
	 $pdf->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1));
	 $pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6));
	 $pdf->SetFontsStyles(array('','','','','','','','','','','',''));
	 $pdf->SetDecimales(array(0,2,2,2,2,2,2,2,2,2,2,2));
	 $pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3,3,3));
	 $pdf->SetFormatNumber(array(0,0,1,1,1,1,1,1,1,1,1,1));
	 
		$cant=500;
		$puntero=0;
		$criterio_filtro=" 0=0 and afp.id_grupo_proceso=".$_SESSION["PDF_id_grupo_proceso"];
		$sortcol='id_activo_fijo_proceso';
		$sortdir='asc';
		
		$Custom = new cls_CustomDBActivoFijo();
		$res = $Custom->ContarActivoFijoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$total_registros= $Custom->salida;
		$suma=array();
		$suma[0]=0;
		$suma[1]=0;
		$suma[2]=0;
		$suma[3]=0;
		$suma[4]=0;
		$suma[5]=0;
		$suma[6]=0;
		$suma[7]=0;
		$suma[8]=0;
		
		
		while($puntero<$total_registros){
			$res = $Custom->ListarActivoFijoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
			$v_setdetalle=$Custom->salida;
			for ($i=0;$i<sizeof($v_setdetalle);$i++){
			 	$pdf->SetLineWidth(0.05);
			 	
			 	$pdf->MultiTabla($v_setdetalle[$i],0,3,3,6,1);
			 	$suma[0]+=$v_setdetalle[$i][2];
				$suma[1]+=$v_setdetalle[$i][3];
				$suma[2]+=$v_setdetalle[$i][4];
				$suma[3]+=$v_setdetalle[$i][5];
				$suma[4]+=$v_setdetalle[$i][6];
				$suma[5]+=$v_setdetalle[$i][7];
				$suma[6]+=$v_setdetalle[$i][8];
				$suma[7]+=$v_setdetalle[$i][9];
				$suma[8]+=$v_setdetalle[$i][10];
				
			 	
			 }
			 $puntero+=500;
		}
		$pdf->Cell(35,5,'TOTAL:  ',0);
	    $pdf->SetFont('Arial','',6);
		
	    for($i=2; $i<11;$i++)
	    {
	    	
			$pdf->Cell($pdf->widths[$i],3,number_format($suma[$i-2],2),1,0,'R');
			
	    }
		
	$pdf->SetFont('Arial','',10); 	   
	$y=$pdf->GetY();
	$posy1=$y;
	
	$altura=$pdf->h;
	$margen_inf=$pdf->lMargin;
	$tope_inf=$altura-$margen_inf;
	
	if(($tope_inf-$y)<$margen_inf){
		$pdf->SetXY(0,($altura-$y-25));
	}else{
		$pdf->SetXY(0,$y);
	}
	$pdf->Output();
?>