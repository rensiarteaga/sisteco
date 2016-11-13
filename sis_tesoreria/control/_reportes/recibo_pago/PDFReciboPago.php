<?php
require ('../../../../lib/fpdf/fpdf.php');
require ('../../../../lib/funciones.inc.php');
include_once ("../../../../lib/configuracion.log.php");
include_once ("../../LibModeloTesoreria.php");

class PDF extends FPDF {
	var $sep_decim = '.';
	var $sep_mil = ',';
	var $id_devengado;
	var $data;
	var $data_det;
	
	function Header() {
		$this->Image ( '../../../../lib/images/logo_reporte.jpg', 23, 11, 36, 13 ); //13,36
		//$this->ln(0);
		$this->SetFont('Arial','B',14);
		$this->Cell(40,5,'','LTR',0,'C');
		$this->Cell(110,5,'','LTR',0,'C');
		$this->SetFont('Arial','',10);
		$this->Cell(40,5,'LOCALIDAD',1,1,'C');
		$this->SetFont('Arial','B',14);
		$this->Cell(40,5,'','LR',0,'C');
		$this->Cell(110,5,'RECIBO DE PAGO',0,0,'C');
		$this->SetFont('Arial','',10);
		$this->Cell(40,5,$_SESSION["ss_nombre_lugar"],1,1,'C');
		$this->SetFont('Arial','',10);
		$this->Cell(40,5,'','LBR',0,'C');
		$this->Cell(110,5,'','LBR',0,'C');
		$this->Cell(40,5,$this->data[0]['fecha_pago'],1,1,'C');
		$this->ln(15);
	}

	function Footer() {
		//Posición: a 1,5 cm del final
		$fecha=date("d-m-Y");
		$hora=date("h:i:s");
	    $this->SetY(-15);
   	    $this->SetFont('Arial','',6);
   	    //$this->Cell(70,3,sha1($_SESSION['PDF_num_solicitud'].$_SESSION['PDF_nombre_financiador'].$_SESSION['PDF_nombre_regional'].$_SESSION['PDF_nombre_programa'].$_SESSION['PDF_nombre_proyecto'].$_SESSION['PDF_nombre_actividad'].$_SESSION['PDF_fecha_juliana'].$_SESSION['PDF_monto_total']),0,0,'L');
		$this->ln(3);
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

	



	function LoadData() {
		$criterio_filtro = 'DEVENG.id_devengado = ' . $this->id_devengado;
		$Custom = new cls_CustomDBTesoreria();
		
		//Datos del Recibo
		$Custom->ReciboPago('NULL', 'NULL', 'NULL', 'NULL', $criterio_filtro, $hidden_ep_id_financiador, $hidden_ep_id_regional, $hidden_ep_id_programa, $hidden_ep_id_proyecto, $hidden_ep_id_actividad );
		$resp = $Custom->salida;
		//echo $Custom->query;
		//exit;
		$this->data=$resp;
		
		//Detalle de los descuentos por recibo
		$Custom->ReciboPagoDetalleDescuentos('NULL', 'NULL', 'NULL', 'NULL', $criterio_filtro, $hidden_ep_id_financiador, $hidden_ep_id_regional, $hidden_ep_id_programa, $hidden_ep_id_proyecto, $hidden_ep_id_actividad );
		$resp = $Custom->salida;
		//echo $Custom->query;
		//exit;
		$this->data_det=$resp;

		/*echo"<pre>";
		print_r($this->data);
		echo"</pre>";*/
	}

	function crear_pdf(){
		$this->Cell(15,5,'',0,0,'L');
		$this->Cell(40,5,'Recibí de la Empresa Nacional de Electricidad',0,1,'L');
		$this->ln(5);
		$this->Cell(25,5,'',0,0,'L');
		$this->Cell(25,5,'La suma de:',0,0,'L');
		$this->Cell(100,5,$this->data[0]['moneda'].'.'.number_format($this->data[0]['monto_original'],2).'.-',0,0,'L');
		$this->ln(5);
		$this->Cell(25,5,'',0,0,'L');
		$this->Cell(25,5,'Son:',0,0,'L');   
		$this->Cell(25,5,ucfirst($this->data[0]['literal']).''.$this->data[0]['desc_moneda'],0,1,'L');
		$this->ln(5);
		$this->Cell(15,5,'',0,0,'L');
		$this->Cell(40,5,'Por concepto de: ',0,1,'L');
		$this->ln(5);
		$this->Cell(25,5,'',0,0,'L');
		$this->MultiCell(160,5,$this->data[0]['concepto'],0,1,'L');
		$this->ln(5);
		$this->Cell(15,5,'',0,0,'L');
		$this->Cell(40,5,'Detalle del Pago:',0,1,'L');
		$this->SetFont('Arial','',10);
		$this->ln(5);
		$this->Cell(25,5,'',0,0,'L');
		$this->Cell(50,5,'Importe total :',0,0,'L');
		$this->Cell(5,5,$this->data[0]['moneda'].'.',0,0,'R');
		$this->Cell(35,5,number_format($this->data[0]['monto_original'],2),0,1,'R');
		
		
		//Se despliega los descuentos por multas, garantías, etc.
		//multas
		$this->SetFont('Arial','I',10);
		if($this->data[0]['multas']>0){
			$this->Cell(25,5,'',0,0,'L');
			$this->Cell(50,5,'Multa:',0,0,'L');
			$this->Cell(5,5,$this->data[0]['moneda'].'.',0,0,'R');
			$this->Cell(35,5,'('.number_format($this->data[0]['multas'],2),0,0,'R');
			$this->Cell(35,5,')',0,1,'L');
		}
		//descuento garantía
		if($this->data[0]['descuento_garantia']>0){
			$this->Cell(25,5,'',0,0,'L');
			$this->Cell(50,5,'Descuento por garantía ('.$this->data[0]['por_retgar'].'%)',0,0,'L');
			$this->Cell(5,5,$this->data[0]['moneda'].'.',0,0,'R');
			$this->Cell(35,5,'('.number_format($this->data[0]['descuento_garantia'],2),0,0,'R');
			$this->Cell(35,5,')',0,1,'L');
		}
		//descuento anticipo
		if($this->data[0]['descuento_anticipo']>0){
			$this->Cell(25,5,'',0,0,'L');
			$this->Cell(50,5,'Descuento anticipo:',0,0,'L');
			$this->Cell(5,5,$this->data[0]['moneda'].'.',0,0,'R');
			$this->Cell(35,5,'('.number_format($this->data[0]['descuento_anticipo'],2),0,0,'R');
			$this->Cell(35,5,')',0,1,'L');
		}
		
		//Depliega el detalle de los decuentos por tipos de documentos
		$cont=0;
		foreach ($this->data_det as $row){
			$this->Cell(25,5,'',0,0,'L');
			$this->Cell(50,5,$row['tipo_descuento'].':',0,0,'L');
			$this->Cell(5,5,$this->data[0]['moneda'].'.',0,0,'R');
			$this->Cell(35,5,'('.number_format($row['descuento'],2),0,0,'R');
			$this->Cell(35,5,')',0,1,'L');
			//$this->ln(1);
			$cont+=1;
		}
		
		
		//if($cont>0){
			$this->Cell(25,5,'',0,0,'L');
			$this->Cell(50,5,'',0,0,'L');
			$this->Cell(5,5,'',0,0,'R');
			$this->Cell(35,5,'','T',1,'R');
		//}
		
		$this->Cell(25,5,'',0,0,'L');
		$this->SetFont('Arial','B',10);
		$this->Cell(50,5,'Líquido Pagable:',0,0,'L');
		$this->Cell(5,5,$this->data[0]['moneda'].'.',0,0,'R');
		$this->Cell(35,5,number_format($this->data[0]['importe_a_pagar'],2),0,1,'R');
		$this->ln(35);
		$this->SetFont('Arial','',10);
		$this->Cell(180,5,'FIRMA INTERESADO',0,1,'C');
		$this->Cell(180,5,$this->data[0]['nombre_pago'],0,1,'C');

	}
}

//Instancia la clase PDF para generar el reporte
$pdf = new PDF ('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddFont('Tahoma','','tahoma.php');
$pdf->AddFont('Arial','','arial.php');
$pdf->SetMargins(20,10,10);
$pdf->SetAutoPageBreak(true,25);

//Obtiene los parámetros del Reporte
$pdf->id_devengado=$id_devengado;

//Obtiene los Datos del Reporte
$pdf->LoadData();

//Construye el pdf
$pdf->AddPage();
$pdf->crear_pdf();

//Despliega el Reporte
$pdf->Output ();

?>