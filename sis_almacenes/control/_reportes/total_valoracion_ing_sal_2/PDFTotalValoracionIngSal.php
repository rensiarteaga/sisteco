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
		//Iniciación de variables
	}

	function Header()
	{
		$this->Image ( '../../../../lib/images/logo_reporte.jpg', 165, 8, 36, 13 );
		$this->ln(10);
		$this->SetFont('Arial','B',12);
		$this->Cell(185,5,'VALORACIÓN INGRESOS Y SALIDAS',0,1,'C');
		$this->SetFont('Arial','B',10);
		$this->Cell(185,5,'Al: '.$this->data[0]['fecha_rep'],0,1,'C');
		$this->Ln(4);
		$this->SetFont('Arial','B',10);
		$this->Cell(30,5,'Gestión: ',0,0,'L');
		$this->SetFont('Arial','',10);
		$this->Cell(70,5,$this->data[0]['gestion'],0,1,'L');
		$this->SetFont('Arial','B',10);
		$this->Cell(30,5,'Almacén: ',0,0,'L');
		$this->SetFont('Arial','',10);
		$this->Cell(70,5,$this->data[0]['almacen'],0,1,'L');
		$this->SetFont('Arial','B',10);
		$this->Cell(30,5,'Almacén Lógico: ',0,0,'L');
		$this->SetFont('Arial','',10);
		$this->Cell(70,5,$this->data[0]['almacen_log'],0,1,'L');
		$this->Ln();
		//$this->SetLineWidth(.3);
		$this->Line($this->GetX(),$this->GetY(),200,$this->GetY());
		$this->Ln(5);

	}
	//Pie de página
	function Footer()
	{
		$fecha=date("d-m-Y");
		$hora=date("h:i:s");
		$this->SetY(-7);
		$this->SetFont('Arial','',6);
		//$this->Cell(205,0.2,'',1,1);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
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

	function CalcularSaldos(){
		$id=0;
		$id_item='x';
		$saldo_fis=0;
		$saldo_eco=0;
		$val_sal=0;
		$costo_unitario=0;
		$primera_iteracion=1;
		$cont=0;
		$cant_ingresos=0;
		$cant_salidas=0;
		$a_final=array();

		//echo "tamaño data: ".count($this->data);
		//exit;
		foreach ($this->data as $row){
			if($id_item!=$row['id_item']){
				if($primera_iteracion==0){
					//Actualiza el registro anterior como final
					$a_final[$cont]=$this->data[$id-1];
					$a_final[$cont]['final']='si';
					$a_final[$cont][4]='si';
					$a_final[$cont]['cant_ingresos']=$cant_ingresos;
					$a_final[$cont][15]=$cant_ingresos;
					$a_final[$cont]['cant_salidas']=$cant_salidas;
					$a_final[$cont][16]=$cant_salidas;
					$cont++;
				}
				else{
					//Entra sólo en la primera iteración
					$primera_iteracion=0;
				}
				$id_item=$row['id_item'];
				$saldo_fis=0;
				$saldo_eco=0;
				$val_sal=0;
				$costo_unitario=0;
				$cant_ingresos=0;
				$cant_salidas=0;
			}

			if($row['salidas'] > 0){
				if($saldo_fis!=0){
					$costo_unitario = $saldo_eco / $saldo_fis;
					$val_sal = $costo_unitario * $row['salidas'];
				}
				//Actualización del Saldo Económico cuando es Salida
				$saldo_eco = $saldo_eco - $val_sal;
				//Acumula las salidas
				$cant_salidas+=$row['salidas'];
			}
			else{
				//Actualización del Saldo Económico cuando es Ingreso
				$saldo_eco = $saldo_eco + $row['costo'];
				//Acumula los ingresos
				$cant_ingresos+=$row['ingresos'];
			}

			//Actualización del Saldo Físico
			$saldo_fis = $saldo_fis + $row['ingresos'] - $row['salidas'];

			//Actualización de tabla
			if($row['salidas']>0){
				//Salidas
				$this->data[$id]['saldo_fis']=$saldo_fis;
				$this->data[$id][12]=$saldo_fis;
				$this->data[$id]['costo']=$val_sal;
				$this->data[$id][13]=$val_sal;
				$this->data[$id]['saldo_eco']=$saldo_eco;
				$this->data[$id][14]=$saldo_eco;
			}
			else{
				//Ingresos
				$this->data[$id]['saldo_fis']=$saldo_fis;
				$this->data[$id][12]=$saldo_fis;
				$this->data[$id]['saldo_eco']=$saldo_eco;
				$this->data[$id][14]=$saldo_eco;
			}
			$id++;
		}

		/*echo "saldo fis:".$saldo_fis;
		echo " XXX saldo eco:".$saldo_eco;
		echo " XXX costo:".$val_sal;
		exit;*/

		/*echo"<pre>";
		print_r($a_final);
		echo"</pre>";
		exit;*/

		//$this->data=$a_final;
		
		/*echo"<pre>";
		print_r($this->data);
		echo"</pre>";
		exit;*/
	}

	//Tabla coloreada
	function crear_pdf()
	{
		//Contador hoja
		$prim_hoja=1;

		$this->SetFont('Arial','',10);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		//$this->SetDrawColor(190,190,190);
		//$this->SetLineWidth(.1);
		$this->SetFont('','',10);

		$this->SetFont('Arial','',8);
		$this->SetWidths(array(7,0,0,0,0,0,0,0,0,0,40,80,10,20,20,20));
		$this->SetVisibles(array(1,0,0,0,0,0,0,0,0,0,1,1,1,1,1,1));
		$this->SetAligns(array('C','L','L','L','L','L','R','R','R','R','L','L','C','R','R','R'));
		$this->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'),'Arial');
		$this->SetFontsStyles(array('','','','','','','','','','','','','','','',''));
		$this->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6));
		$this->SetSpaces(array(3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5));
		$this->SetDecimales(array(0,0,0,0,0,0,0,0,0,0,0,0,0,2,6,6));

		$total=0;
		$tot_ingresos=0;
		$tot_salidas=0;
		/*for ($i=0;$i<sizeof($this->data);$i++){
			$total+=$this->data[$i]['saldo_eco'];
			//$this->MultiTabla(array_merge((array)$cont,(array)$this->data[$i]),2,3,3.5,6);
			if($this->data[$i]['ingresos']<=0){
				$tot_salidas+=$this->data[$i]['costo'];	
			}
			else if($this->data[$i]['salidas']==0){
				$tot_ingresos+=$this->data[$i]['costo'];
			}
			
		}*/
		
		$tot_cant_ing=0;
		$tot_cant_sal=0;
		foreach ($this->data as $row){
			$total+=$row['saldo_eco'];
			//$this->MultiTabla(array_merge((array)$cont,(array)$this->data[$i]),2,3,3.5,6);
			if($row['ingresos']==0){
				$tot_salidas+=$row['costo'];
				$tot_cant_sal+=	$row['salidas'];
			}
			else if($row['salidas']==0){
				$tot_ingresos+=$row['costo'];
				$tot_cant_ing+=	$row['ingresos'];
			}
			
		}
		
		$this->Ln(15);
		$this->SetFont('Arial','B',10);
		$this->Cell(60,5,'',0,0,'L');
		$this->Cell(20,5,'INGRESOS',0,0,'R');
		$this->SetFont('Arial','',10);
		$this->Cell(50,5,number_format($tot_ingresos,6,'.',','),0,1,'R');
		$this->Cell(60,5,'',0,0,'L');
		$this->SetFont('Arial','B',10);
		$this->Cell(20,5,'SALIDAS',0,0,'R');
		$this->SetFont('Arial','',10);
		$this->Cell(50,5,number_format($tot_salidas,6,'.',','),0,1,'R');
		//$this->Line(70,$this->GetY(),140,$this->GetY());
		$this->Cell(60,5,'',0,0,'L');
		$this->SetFont('Arial','B',10);
		$this->Cell(20,5,'SALDO','TB',0,'R');
		$this->SetFont('Arial','',10);
		$this->Cell(50,5,number_format($tot_ingresos - $tot_salidas,6,'.',','),'TB',1,'R');
		$this->Line(70,$this->GetY()+0.6,140,$this->GetY()+0.6);
		$this->Ln(5);
		
		$this->Cell(50,5,'ingresos:'.$tot_cant_ing,0,1,'R');
		$this->Cell(50,5,'salidas:'.$tot_cant_sal,0,1,'R');

	}




}

$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddFont('Tahoma','','tahoma.php');
$pdf->AddFont('Arial','','arial.php');
$pdf->SetMargins(10,10,10);
$pdf->SetAutoPageBreak(true,10);

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
$pdf->CalcularSaldos();

//Títulos de las columnas
$pdf->cols=array('Nro.','Item','Descripción','Unidad','Cantidad','Precio Unit. Bs.','Importe Bs.');
$pdf->cols_width=array(7,40,80,10,20,20,20);

//Construye el pdf
$pdf->AddPage();
$pdf->crear_pdf();

//Despliega el Reporte
$pdf->Output ();

?>