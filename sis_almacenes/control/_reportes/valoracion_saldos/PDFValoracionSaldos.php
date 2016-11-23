<?php
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
include_once("../../LibModeloAlmacenes.php");
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{
	var $sep_decim='.';
	var $sep_mil=',';

	//Parámetros reporte
	var $id_financiador;
	var $id_regional;
	var $id_programa;
	var $id_proyecto;
	var $id_actividad;
	var $id_almacen_logico;
	var $id_almacen;
	var $id_parametro_almacen;
	var $id_ep;
	var $fecha;

	//Array con los datos
	var $data;

	//Array de las columnas
	var $cols;
	var $cols_width;

	function PDF($orientation='P',$unit='mm',$format='Letter')
	{
		//Llama al constructor de la clase padre
		$this->FPDF($orientation,$unit,$format);
		
	}

	function Header()
	{
		$this->SetLineWidth(.1);
		$this->SetDrawColor(190,190,190);
		$this->Image ( '../../../../lib/images/logo_reporte.jpg', 15, 11, 36, 13 );
		$this->SetY(10);
		$this->SetFont('Arial','B',8);
		
		$this->Cell(47,5,'','LRT',0,'C');
		$this->Cell(110,5,'','LRT',0,'C');
		$this->Cell(20,5,'Gestión: ','LT',0,'R');
		$this->Cell(20,5,$this->data[0]['gestion'],'RT',1,'L');
				
		$this->Cell(47,5,'','LR',0,'C');
		$this->SetFont('Arial','B',12);
		$this->Cell(110,5,'REPORTE DE EXISTENCIAS','LR',0,'C');
		$this->SetFont('Arial','B',8);
		$this->Cell(20,5,'Al: ','L',0,'R');
		$this->Cell(20,5,$this->data[0]['fecha_rep'],'R',1,'L');
				
		$this->Cell(47,5,'','LRB',0,'C');
		$this->Cell(110,5,'','LRB',0,'C');
		$this->Cell(20,5,'Página: ','LTB',0,'R');
		$this->Cell(20,5,''.$this->PageNo() .' de {nb}','RTB',1,'L');
				
		$this->SetFont('Arial','B',10);
		$this->Cell(47,5,'Almacén: ',0,0,'R');
		$this->SetFont('Arial','',10);
		$this->Cell(110,5,$this->data[0]['almacen'],0,1,'L');
		$this->SetFont('Arial','B',10);
		$this->Cell(47,5,'Almacén Lógico: ',0,0,'R');
		$this->SetFont('Arial','',10);
		$this->Cell(110,5,$this->data[0]['almacen_log'],0,1,'L');
		$this->Ln(5);

		//Títulos de Columas
		$this->SetFont('Arial','B',8);
		$this->SetLineWidth(.1);
		$this->SetDrawColor(190,190,190);
		for($i=0;$i<count($this->cols);$i++){
			$this->SetLineWidth(.1);
			$this->Cell($this->cols_width[$i],5,$this->cols[$i],'LRBT',0,'C');
		}
		$this->Ln();

	}
	//Pie de página
	function Footer()
	{
		$fecha=date("d-m-Y");
		$hora=date("h:i:s");
		$this->SetY(-12);
		$this->SetFont('Arial','',6);
		$this->Cell(197,0.2,'',1,1);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');
	}

	function LoadData(){
		$Custom=new cls_CustomDBAlmacenes();
		$Custom->ReporteValoracionSaldos('NULL','NULL','NULL','NULL','NULL',$this->id_financiador,$this->id_regional,$this->id_programa,$this->id_proyecto,$this->id_actividad,$this->id_parametro_almacen,$this->id_ep,$this->id_almacen,$this->id_almacen_logico,$this->fecha);
		$this->data=$Custom->salida;

		/*echo "<pre>";
		print_r($this->data);
		echo "</pre>";
		exit;*/
	}
/*
	function CalcularSaldos(){
		$id=0;
		$id_item='x';
		$saldo_fis=0;
		$saldo_eco=0;
		$val_sal=0;
		$costo_unitario=0;
		$primera_iteracion=1;
		$cont=0;
		$a_final=array();
		$sg=0;

		
		for($i=0;$i<count($this->data);$i++){
				
			$a_final[$i]=$this->data[$i];
			
			
			
		    
		   $a_final[$cont]['saldo_fis'] = $this->data[$i]['ingresos'] - $this->data[$i]['salidas'];
		}
		
		
		
		
		
		
		$this->data=$a_final;
		
	}*/

	//Tabla coloreada
	function crear_pdf()
	{
		//Contador hoja
		$prim_hoja=1;

		$this->SetFont('Arial','',10);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(190,190,190);
		//$this->SetLineWidth(.1);
		$this->SetFont('','',10);

		$this->SetFont('Arial','',8);
		$this->SetWidths(array(10,0,0,0,0,0,0,0,0,0,37,80,10,20,20,20));
		$this->SetVisibles(array(1,0,0,0,0,0,0,0,0,0,1,1,1,1,1,1));
		$this->SetAligns(array('C','L','L','L','L','L','R','R','R','R','L','L','C','R','R','R'));
		$this->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'),'Arial');
		$this->SetFontsStyles(array('','','','','','','','','','','','','','','',''));
		$this->SetFontsSizes(array(5,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6));
		$this->SetSpaces(array(3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5));
		$this->SetDecimales(array(0,0,0,0,0,0,0,0,0,0,0,0,0,2,6,6));

		$total=0;
		for ($i=0;$i<sizeof($this->data);$i++){
				
			$cont=$i+1;
			
			//$this->data[$i]['saldo_eco'] = $this->data[$i]['costo_ingreso'] - $this->data[$i]['costo_salida'];
			
			
			
			//$this->MultiTabla(array_merge( (array)$cont, (array)$this->data[$i]), 2,3,3.5,6);
			

			
			
			$saldo_fisico = $this->data[$i]['ingresos'] - $this->data[$i]['salidas'];
			$saldo_eco = $this->data[$i]['costo_ingreso'] - $this->data[$i]['costo_salida'];
			if($saldo_fisico!= 0){
				$costo_unitario = ($saldo_eco)/$saldo_fisico;			
			}
			else{
				$costo_unitario = 0;			
			}
			$total+=$saldo_eco;
			$a_final = Array
					(
					    0 => $i+1,
					  
					     1=> $i+1,
					    'id_item' => $i+1,
					    2 => '300.00',
					    'ingresos' => '300.00',
					    3 => '100.00',
					    'salidas' => '100.00',
					    4 => 6000.000000,
					    'costo_ingreso' => 6000.000000,
					    5 => 2000.00,
					    'costo_salida' => 2000.00,
					    6 => 'test',
					    'almacen' => 'test',
					    7 => 'test',
					    'almacen_log' => 'test',
					    8 => '29/11/2016',
					    'fecha_rep' => '29/11/2016',
					    9 => '2016',
					    'gestion' => '2016',
					    10 => $this->data[$i]['nombre_item'],
					    'nombre_item' => $this->data[$i]['nombre_item'],
					    11 => $this->data[$i]['desc_item'],
					    'desc_item' => $this->data[$i]['desc_item'],
					    12 =>$this->data[$i]['un_med_bas'],
					    'un_med_bas' => $this->data[$i]['un_med_bas'],
					    13 => $saldo_fisico,
					    'saldo_fisico' => $saldo_fisico,
					    14 => $costo_unitario,
					    'costo_unitario' => $costo_unitario,
					    15 => $saldo_eco,
					    'saldo_eco' => $saldo_eco
					);
														
			
			
			
			
			
			$this->MultiTabla($a_final, 2,3,3.5,6);
			
			
			
		}
		//$this->Ln();
		$this->SetFont('Arial','B',6);
		$this->Cell(140,5,'',0,0,'R');
		$this->Cell(10,5,'Total','B',0,'R');
		$this->Cell(47,5,number_format($total,6,'.',','),'B',1,'R');
		$this->Line(150,$this->GetY()+0.6,207,$this->GetY()+0.6);


	}




}

$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddFont('Tahoma','','tahoma.php');
$pdf->AddFont('Arial','','arial.php');
$pdf->SetMargins(10,10,10);
$pdf->SetAutoPageBreak(true,15);

//Cargado de parámetros del Reporte
$pdf->id_financiador = $id_financiador;
$pdf->id_regional = $id_regional;
$pdf->id_programa = $id_programa;
$pdf->id_proyecto = $id_proyecto;
$pdf->id_actividad = $id_actividad;
$pdf->id_almacen = $id_almacen;
$pdf->id_almacen_logico = $id_almacen_logico;
$pdf->id_parametro_almacen = $id_parametro_almacen;
$pdf->fecha = $fecha;

//Carga los datos
$pdf->LoadData();

//Procesar los datos para la impresion
//$pdf->CalcularSaldos();

//Títulos de las columnas
$pdf->cols=array('Nro.','Item','Descripción','Unidad','Cantidad','Precio Unit. Bs.','Importe Bs.');
$pdf->cols_width=array(10,37,80,10,20,20,20);

//Construye el pdf
$pdf->AddPage();
$pdf->crear_pdf();

//Despliega el Reporte
$pdf->Output ();

?>