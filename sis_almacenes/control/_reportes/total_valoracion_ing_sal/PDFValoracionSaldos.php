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
	var $data_fin;

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
		$this->Cell(185,5,'REPORTE DE EXISTENCIAS - INGRESOS SALIDAS',0,1,'C');
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
		$this->Ln(5);

		//Títulos de Columas
		$this->SetFont('Arial','B',8);
		$this->SetLineWidth(.1);
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
		$a_final=array();
		$cant_ingresos=0;
		$cant_salidas=0;
		$costo_ingresos=0;
		$costo_salidas=0;

		//echo "tamaño data: ".count($this->data);
		//exit;
		/*print_r($this->data);
		    exit;*/
		foreach ($this->data as $row){
			//echo "item:".$row['id_item']."<br>";
			if($id_item!=$row['id_item']){
				//echo "entra ddd";
				if($primera_iteracion==0){
					//Actualiza el registro anterior como final
					//echo "XXXXXX: ".$id;
					$a_final[$cont]=$this->data[$id-1];
					$a_final[$cont]['final']='si';
					$a_final[$cont][4]='si';
					if($a_final[$cont]['saldo_fis']==0){
						$a_final[$cont]['costo']=0;
						$a_final[$cont][13]=0;
					}
					else{
						$a_final[$cont]['costo']=$a_final[$cont]['saldo_eco']/$a_final[$cont]['saldo_fis'];
						$a_final[$cont][13]=$a_final[$cont]['saldo_eco']/$a_final[$cont]['saldo_fis'];
					}
					//Se cambia el orden para la impresión
					$a_final[$cont][15]=$cant_ingresos;
					$a_final[$cont]['cant_ingresos']=$cant_ingresos;
					$a_final[$cont][16]=$cant_salidas;
					$a_final[$cont]['cant_salidas']=$cant_salidas;
					$a_final[$cont][17]=$costo_ingresos;
					$a_final[$cont]['costo_ingresos']=$costo_ingresos;
					$a_final[$cont][18]=$costo_salidas;
					$a_final[$cont]['costo_salidas']=$costo_salidas;
					$a_final[$cont][19]=$a_final[$cont]['saldo_eco']-($costo_ingresos-$costo_salidas);
					$a_final[$cont]['diferencia']=$a_final[$cont]['saldo_eco']-($costo_ingresos-$costo_salidas);
					
					
					

					/*echo"<pre>";
					print_r($this->data[$id-1]);
					echo"</pre>";
					exit;*/


					$cont++;

				}
				else{
					//Entra sólo en la primera iteración
					$primera_iteracion=0;
				}


				/*echo " XXX saldo fis:".$saldo_fis;
				echo " XXX saldo eco:".$saldo_eco;
				echo " XXX costo:".$val_sal;*/
				$id_item=$row['id_item'];
				$saldo_fis=0;
				$saldo_eco=0;
				$val_sal=0;
				$costo_unitario=0;
				$cant_ingresos=0;
				$cant_salidas=0;
				$costo_ingresos=0;
				$costo_salidas=0;
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
				//Acumula el costo de las salidas
				$costo_salidas+=$this->data[$id]['costo'];
			}
			else{
				//Ingresos
				$this->data[$id]['saldo_fis']=$saldo_fis;
				$this->data[$id][12]=$saldo_fis;
				$this->data[$id]['saldo_eco']=$saldo_eco;
				$this->data[$id][14]=$saldo_eco;
				
				//Acumula el costo de las salidas
				$costo_ingresos+=$this->data[$id]['costo'];

				//echo " variab saldo fis:".$saldo_fis;
				//echo " array saldo fis:".$this->data[$id]['saldo_fis'];
			}
			$id++;
			
		}
        
		/*echo "saldo fis:".$saldo_fis;
		echo " XXX saldo eco:".$saldo_eco;
		echo " XXX costo:".$val_sal;
		exit;*/

		/*echo"<pre>A_FINAL";
		print_r($a_final);
		echo"</pre>";
		exit;
        */
		$_SESSION['valoracion items']=$a_final;
		$this->data_fin=$a_final;
		
		/*echo"<pre>DATA";
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
		$this->SetDrawColor(190,190,190);
		//$this->SetLineWidth(.1);
		$this->SetFont('','',10);

		$this->SetFont('Arial','',8);
		$this->SetWidths(array(7,0,0,0,0,0,0,0,0,0,30,62,10,20,16,20,0,0,20,20,20));
		$this->SetVisibles(array(1,0,0,0,0,0,0,0,0,0,1,1,1,1,1,1,0,0,1,1,0));
		$this->SetAligns(array('C','L','L','L','L','L','R','R','R','R','L','L','C','R','R','R','L','L','R','R','R'));
		$this->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'),'Arial');
		$this->SetFontsStyles(array('','','','','','','','','','','','','','','',''));
		$this->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6));
		$this->SetSpaces(array(3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5));
		$this->SetDecimales(array(0,0,0,0,0,0,0,0,0,0,0,0,0,2,6,6,0,0,6,6,6));

		$total=0;
		$tot_ing_val=0;
		$tot_sal_val=0;
		//$total_ingresos
		
		for ($i=0;$i<sizeof($this->data_fin);$i++){
			$cont=$i+1;
			$total+=$this->data_fin[$i]['saldo_eco'];
			$tot_ing_val+=$this->data_fin[$i]['costo_ingresos'];
			$tot_sal_val+=$this->data_fin[$i]['costo_salidas'];
			$this->MultiTabla(array_merge((array)$cont,(array)$this->data_fin[$i]),2,3,3.5,6);
		}
		//$this->Ln();
		$this->SetFont('Arial','B',6);
		$this->Cell(140,5,'',0,0,'R');
		$this->Cell(10,5,'Total','B',0,'R');
		$this->Cell(47,5,number_format($total,6,'.',','),'B',1,'R');
		$this->Line(150,$this->GetY()+0.6,207,$this->GetY()+0.6);
		
		
		/*foreach($this->data as $row){
			if($row['ingresos']>0){
				$tot_ing_val+=$row['costo'];
			}
			else{
				$tot_sal_val+=$row['costo'];
			}
		}*/
		$this->Ln(3);
		$this->Cell(140,5,'',0);
		$this->Cell(10,5,'Ingresos:   '.number_format($tot_ing_val,6,'.',','),'',1,'R');
		$this->Cell(140,5,'',0);
		$this->Cell(10,5,'Salidas:   '.number_format($tot_sal_val,6,'.',','),'',1,'R');


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
$pdf->cols=array('Nro.','Item','Descripción','Unidad','Cantidad','P.Unit. Bs.','Importe Bs.','costo ing','costo_sal');
$pdf->cols_width=array(7,30,62,10,20,16,20,20,20,20);

//Construye el pdf
$pdf->AddPage();
$pdf->crear_pdf();

//Despliega el Reporte
$pdf->Output ();

?>