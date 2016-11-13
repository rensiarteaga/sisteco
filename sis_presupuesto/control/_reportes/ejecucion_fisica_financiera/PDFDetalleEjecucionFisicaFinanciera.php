<?php

session_start();
include_once("../../LibModeloPresupuesto.php");
require('../../../../lib/fpdf/fpdf.php');
define('FPDF_FONTPATH','font/');


class PDF extends FPDF
{
	var  $relleno=true;	
	
	function PDF($orientation='L',$unit='mm',$format='Letter')
	{
		//Llama al constructor de la clase padre
		$this->FPDF($orientation,$unit,$format);
		$this-> AddFont('Arial','','arial.php');
		//Iniciación de variables
	}
	
	//Cabecera
	function Header()
	{
		$this->SetMargins(5,1,5);
		$this->SetFont('Arial','B',14);
		
		$this->SetY(8);
		$this->Cell(0,5,'MATRIZ DE EJECUCIÓN FÍSICA - FINANCIERA',0,1,'C');
		$this->SetFont('Arial','I',8);
		$this->Cell(0,3,' Presupuesto de '.$_SESSION['PDF_desc_pres_r'].' Gestión '.$_SESSION['PDF_gestion_r'] ,0,1,'C');
		$this->SetFont('Arial','I',7);
		//$this->Cell(0,3,'Trimestre: '.$_SESSION['PDF_trimestre'],0,1,'C');
		//$this->Cell(0,3,'Filtrado por: '.$_SESSION['PDF_filtro'],0,1,'C');
		$this->Cell(0,3,'(Expresado en '.$_SESSION['PDF_desc_moneda_r'].')',0,1,'C');
	    $this->ln(3);
		
        $this->Image('../../../../lib/images/logo_reporte.jpg',240,5,35,14);
        //$this->SetFont('Arial','BI',8);        
        $this->SetFont('Arial','B',5);

		//Títulos de las columnas
		$this->Cell(20,3.5,'PROYECTO','LTR',0,'C');
		$this->Cell(19,3.5,'EJECUCIÓN','TR',0,'C');		
		$this->Cell(30,3.5,'PRESUPUESTO ACUMULADO '.($_SESSION['PDF_gestion_r']-1),'TRB',0,'C');	
		$this->Cell(15,3.5,'PRESUPUESTO','TR',0,'C');			
		$this->Cell(15,3.5,'PRESUPUESTO','TR',0,'C');		
		
		$this->Cell(156,3.5,'EJECUCIÓN PRESUPUESTARIA '.$_SESSION['PDF_gestion_r'],'TBR',0,'C');
		$this->Cell(15,3.5,'TOTAL ACUM.','TR',1,'C');
		
		
		$this->Cell(20,3.5,'','LBR',0,'C');	
		$this->Cell(19,3.5,'','BR',0,'C');			
		$this->Cell(15,3.5,'APROBADO','BR',0,'C');
		$this->Cell(15,3.5,'EJECUTADO','BR',0,'C');			
		$this->Cell(15,3.5,'INICIAL '.$_SESSION['PDF_gestion_r'],'BR',0,'C');						
		$this->Cell(15,3.5,'VIGENTE '.$_SESSION['PDF_gestion_r'],'BR',0,'C');			
						
		$this->Cell(13,3.5,'ENERO','BTR',0,'C');	
		$this->Cell(13,3.5,'FEBRERO','BTR',0,'C');	
		$this->Cell(13,3.5,'MARZO','BTR',0,'C');	
		$this->Cell(13,3.5,'ABRIL','BTR',0,'C');	
		$this->Cell(13,3.5,'MAYO','BTR',0,'C');	
		$this->Cell(13,3.5,'JUNIO','BTR',0,'C');	
		$this->Cell(13,3.5,'JULIO','BTR',0,'C');	
		$this->Cell(13,3.5,'AGOSTO','BTR',0,'C');	
		$this->Cell(13,3.5,'SEPTIEMBRE','BTR',0,'C');	
		$this->Cell(13,3.5,'OCTUBRE','BTR',0,'C');	
		$this->Cell(13,3.5,'NOVIEMBRE','BTR',0,'C');	
		$this->Cell(13,3.5,'DICIEMBRE','BTR',0,'C');				
		$this->Cell(15,3.5,'AL: '.date("d-m-Y"),'BR',1,'C');		
		//$this->Cell(10,3.5,'EJEC.','BR',1,'C');	
	}
	
	//Pie de página
	function Footer()
	{ 	
		$this->SetY(-12);
		$this->pieHash('PRESTO','','H');	
	}
}

	$pdf=new PDF(); 
	$pdf->AddPage(); 
	$pdf->AliasNbPages();
	$pdf->SetAutoPageBreak(true,12);
	$pdf->SetMargins(5,1,5);
	$pdf->SetFont('Arial','B',8); 
	
	
	$pdf->SetVisibles(array(1,1,1,1,1,1,    1,1,1,1,1,1,1,1,1,1,1,1,   1));
		
    $pdf->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial',    'Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial',    'Arial'));
	$pdf->SetFontsStyles(array('','','','B','','B',    '','','','','','','','','','','','',   'B'));	
	$pdf->SetFontsSizes(array(5,5,5,5,5,5,    5,5,5,5,5,5,5,5,5,5,5,5,    5));
	$pdf->SetSpaces(array(3,3,3,3,3,3,    3,3,3,3,3,3,3,3,3,3,3,3,   3));
	$pdf->SetWidths(array(20,19,15,15,15,15,   13,13,13,13,13,13,13,13,13,13,13,13,    15));
	$pdf->SetDecimales(array(0,0,2,2,2,2,    2,2,2,2,2,2,2,2,2,2,2,2,   2));
	$pdf->SetFormatNumber(array(0,0,0,0,0,0,   0,0,0,0,0,0,0,0,0,0,0,0,   0));
	$pdf->SetAligns(array('L','L','R','R','R','R',     'R','R','R','R','R','R','R','R','R','R','R','R',  'R'));
    $v_detalle_proyectos=$_SESSION['PDF_Detalle_Proyectos'];    
    
   	//Recorremos y mostramos el listado de proyectos
	for ($i=0;$i<sizeof($v_detalle_proyectos);$i++)
	{			
		$pdf->SetLineWidth(0.02);
		$pdf->Multitabla($v_detalle_proyectos[$i],0,3,3,6,1);			
	}//fin del listado de proyectos	

$pdf->Output();
?>

