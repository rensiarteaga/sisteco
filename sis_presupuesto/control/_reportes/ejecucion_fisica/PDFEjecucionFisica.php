<?php
require ('../../../../lib/fpdf/fpdf.php');
require ('../../../../lib/funciones.inc.php');
include_once ("../../../../lib/configuracion.log.php");
include_once ("../../LibModeloPresupuesto.php");

class PDF extends FPDF {
	var $sep_decim = '.';
	var $sep_mil = ',';
	var $id_devengado;
	var $data;
	var $posYinicial=0;

	function Header() {
		//if($this->PageNo()==1){ 
		$this->Image ( '../../../../lib/images/logo_reporte.jpg', 165, 8, 36, 13 );
		$this->ln(10);
		$this->SetFont('Arial','B',14);
		$this->Cell(200,5,'REPORTE DE EJECUCION FÍSICA Y FINANCIERA',0,1,'C');
		$this->SetFont('Arial','B',10);	
        $this->Ln(3);		
		$this->Cell(200,5,'Gestión: '.$this->data[0]['desc_parametro'].' - Periodo: '.$this->data[0]['periodo_pres'],'',1,'L');
		$this->Ln(4);
		
//----------------------

		//$this->Line($this->GetX(),$this->GetY(),$this->GetX(),250);
		//$this->Line($this->GetX()+200,$this->GetY(),$this->GetX()+200,250);
		
		$posYinicial=$this->GetY();
		
		//$this->SetFillColor(247, 187, 9);	//Naranja
		$this->SetFillColor(200, 200, 200);	//Plomo oscuro
		
		$this->SetFont('Arial','B',8);
		$this->Cell(200,5,'DATOS GENERALES DEL PROYECTO','LTBR',1,'C',true);
		
		$this->SetFont('Arial','',6);
		$this->Cell(200,4,'','LR',1);		
		
		//$this->SetFillColor(249 , 221, 113);	//Amarillo
		$this->SetFillColor(230 , 230, 230);	//Plomo claro
		
		$this->Cell(30,5,'NOMBRE DEL PROYECTO:  ','L',0,'R');
		$this->Cell(70,5,$this->data[0]['nombre_proyecto'],'LTBR',0,'L',true);
		$this->Cell(30,5,'CÓDIGO SISIN:  ','L',0,'R');
		$this->Cell(60,5,$this->data[0]['codigo_sisin'],'LTBR',0,'C',true);			
		$this->Cell(10,5,'','',1,'R');
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
		$this->Cell(30,5,'FASE:  ','L',0,'R');
		$this->Cell(70,5,$this->data[0]['fase_proyecto'],'LTBR',0,'L',true);
		$this->Cell(30,5,'TIPO DE ESTUDIO:  ','L',0,'R');
		$this->Cell(60,5,$this->data[0]['tipo_estudio'],'LTBR',0,'C',true);	
		$this->Cell(10,5,'','R',1,'R');
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
		$this->Cell(30,5,'UNIDAD ORGANIZACIONAL:  ','L',0,'R');
		$this->Cell(70,5,$this->data[0]['gerencia'],'LTBR',0,'L',true);
		$this->Cell(30,5,'','',0,'R');
		$this->Cell(60,5,'','',0,'C');		
		$this->Cell(10,5,'','',1,'R');
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas		
		
		$this->Cell(30,5,'RESPONSABLE:  ','L',0,'R');
		$this->Cell(70,5,$this->data[0]['desc_persona'],'LTBR',0,'L',true);
		$this->Cell(30,5,'CELULAR:  ','L',0,'R');
		$this->Cell(60,5,$this->data[0]['celular'],'LTBR',0,'C',true);		
		$this->Cell(10,5,'','R',1,'R');
		$this->Cell(200,5,'','LR',1);		//linea de espacio entre filas
		
//----------------------
		//$this->SetFillColor(247, 187, 9);	//Naranja
		$this->SetFillColor(200, 200, 200);	//Plomo oscuro
		$this->SetFont('Arial','B',8);
		$this->Cell(200,5,'INFORMACIÓN DE LA EJECUCIÓN FINANCIERA','LTBR',1,'C',true);
		
		$this->SetFont('Arial','',6);
		$this->Cell(200,4,'','LR',1);
				
		//$this->SetFillColor(249 , 221, 113);	//Amarillo		
		$this->SetFillColor(230 , 230, 230);	//Plomo claro
		
		$this->Cell(30,5,'PRESUPUESTO APROB.:  ','L',0,'R');
		$this->Cell(70,5,number_format($this->data[0]['presupuesto_aprobado'], 2, '.', ',') .' Bs','LTBR',0,'C',true);
		$this->Cell(30,5,'','',0,'R');
		$this->Cell(60,5,'','',0,'C');			
		$this->Cell(10,5,'','',1,'R');
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas		
		
		$this->Cell(30,5,'PRESUPUESTO VIGENTE:  ','L',0,'R');
		$this->Cell(70,5,number_format($this->data[0]['presupuesto_vigente'], 2, '.', ',') .' Bs','LTBR',0,'C',true);	
		$this->Cell(30,5,'','',0,'R');
		$this->Cell(60,5,'','',0,'C');			
		$this->Cell(10,5,'','',1,'R');
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
		$this->Cell(30,5,'EJECUTADO:  ','L',0,'R');
		$this->Cell(70,5,number_format($this->data[0]['ejecucion_financiera'], 2, '.', ',') .' Bs' ,'LTBR',0,'C',true);
		$this->Cell(30,5,'','',0,'R');
		$this->Cell(60,5,'','',0,'C');	
		$this->Cell(10,5,'','',1,'R');
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
		
		$this->Cell(30,5,'EJECUCIÓN FINANCIERA:  ','L',0,'R');
		$this->Cell(70,5,number_format( $this->data[0]['ejecucion_financiera'] * 100 / ($this->data[0]['presupuesto_vigente'] + 0.1) ,1).' %','LTBR',0,'C',true);	
		$this->Cell(30,5,'','',0,'R');
		$this->Cell(60,5,'','',0,'C');
		$this->Cell(10,5,'','',1,'R');
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
		$this->Cell(30,5,'JUSTIFICACIÓN:  ','L',0,'R');	 	
		$this->MultiCell(160,5,$this->data[0]['justificacion_financiera'],'LTBR','L',true);		
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
		$this->Cell(30,5,'ACCIONES:  ','L',0,'R');		
		$this->MultiCell(160,5,$this->data[0]['acciones_financiera'],'LTBR','L',true);		
		$this->Cell(200,5,'','LR',1);		//linea de espacio entre filas		
		
				
//----------------------		
		//$this->SetFillColor(247, 187, 9);	//Naranja
		$this->SetFillColor(200, 200, 200);	//Plomo oscuro
		
		$this->SetFont('Arial','B',8);
		$this->Cell(200,5,'INFORMACIÓN DE LA EJECUCIÓN FÍSICA','LTBR',1,'C',true);

		$this->SetFont('Arial','',6);
		$this->Cell(200,4,'','LR',1);		
		//$this->SetFillColor(249 , 221, 113);	//Amarillo
		$this->SetFillColor(230 , 230, 230);	//Plomo claro
		
		$this->Cell(30,5,'EJECUCIÓN FÍSICA:  ','L',0,'R');
		$this->Cell(70,5,$this->data[0]['porcentaje_ejecucion'],'LTBR',0,'C',true);	
		$this->Cell(10,5,'','0',1,'R');
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
		$this->Cell(30,5,'JUSTIFICACIÓN:  ','L',0,'R');		
		$this->MultiCell(160,5,$this->data[0]['justificacion_fisica'],'LTBR','L',true);		
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
		$this->Cell(30,5,'ACCIONES:  ','L',0,'R');		
		$this->MultiCell(160,5,$this->data[0]['acciones_fisica'],'LTBR','L',true);		
		$this->Cell(200,5,'','LBR',1);		//linea de espacio entre filas	
			
		$this->Line($this->GetX(),$posYinicial,$this->GetX(),$this->GetY());
		$this->Line($this->GetX()+200,$posYinicial,$this->GetX()+200,$this->GetY());	
		
		//----------------------
		//$this->SetFillColor(247, 187, 9);	//Naranja
		//$this->Cell(200,5,'','B',1,'C',false);
			
	}
	
	//Pie de pÃ¡gina
	function Footer() 
	{	
		$fecha=date("d-m-Y");
		$hora=date("h:i:s");
		$this->SetY(-16);
		$this->SetFont('Arial','',6);	
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - PRESTO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');  
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L'); 
	}
	
	function LoadData() 
	{
		$criterio_filtro = ' EJEFIS.id_ejecucion_fisica = ' . $this->id_ejecucion_fisica;
		$Custom = new cls_CustomDBPresupuesto();
		$Custom->ListarReporteEjecucionFisica( 'NULL', 'NULL', 'NULL', 'NULL', $criterio_filtro, $hidden_ep_id_financiador, $hidden_ep_id_regional, $hidden_ep_id_programa, $hidden_ep_id_proyecto, $hidden_ep_id_actividad );
		$resp = $Custom->salida;
		$this->data=$resp;

		/*echo"<pre>";
		print_r($this->data);
		echo"</pre>";*/
	}
	
}

//Instancia la clase PDF para generar el reporte
$pdf = new PDF ('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddFont('Tahoma','','tahoma.php');
$pdf->AddFont('Arial','','arial.php');
$pdf->SetMargins(5,5,5);
$pdf->SetAutoPageBreak(true,20);

//Obtiene los parÃ¡metros del Reporte
$pdf->id_ejecucion_fisica=$id_ejecucion_fisica;

//Obtiene los Datos del Reporte
$pdf->LoadData();

//Construye el pdf
$pdf->AddPage();

//Despliega el Reporte
$pdf->Output ();
?>