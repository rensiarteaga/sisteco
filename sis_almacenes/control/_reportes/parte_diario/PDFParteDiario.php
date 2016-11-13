<?php
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
include_once("../../LibModeloAlmacenes.php");

class PDF extends FPDF
{
	var $sep_decim='.';
	var $sep_mil=',';

	function Header()
	{
		global $title;
		$imprimir_footer=1;
		$this->SetLeftMargin(15);
		$funciones = new funciones();
		//Logo
		$this->Image('../../../../lib/images/logo_reporte.jpg',235,8,36,13);

		$this->SetFont('Arial','',8);
		$this->SetX(247);
		$this->Cell(60,13,'Página '.$this->PageNo().' de {nb}',0,1,'L');
		
		// establecemos el idioma de la página
		setlocale (LC_TIME,"spanish", "es_ES@euro", "es_ES", "es");
		//creamos la cadena con los especificadores necesarios
		$formato = "%d de %B de %Y";
		//$formato = "%A, %d de %B de %Y";
		
		$this->SetFont('Arial','B',12);
		//Movernos a la derecha
		$this->Cell(250,4,'MOVIMIENTO FÍSICO DE ALMACÉN',0,1,'C');
		$this->Cell(250,4,utf8_decode($_SESSION['part_dia_desc_almacen']),0,1,'C');

		$fechad=$_SESSION["part_dia_fecha_desde"];

		$mes = substr($fechad, 0, 2);
		$dia = substr($fechad, 3, 2);
		$anio = substr($fechad, -4);
		$fechad=$dia.'-'.$mes.'-'.$anio;
		//Mostramos la fecha, ahora sí en el idioma deseado.
		$fechad=strftime($formato, strtotime($fechad));

		$fechah=$_SESSION["part_dia_fecha_hasta"];

		$mes = substr($fechah, 0, 2);
		$dia = substr($fechah, 3, 2);
		$anio = substr($fechah, -4);
		$fechah=$dia.'-'.$mes.'-'.$anio;

		//Mostramos la fecha, ahora sí en el idioma deseado.
		$fechah=strftime($formato, strtotime($fechah));

		$this->SetFont('Arial','B',8);
		$this->Cell(250,6,'Del '.$fechad.' Al '.$fechah,0,0,'C');
		$this->Ln(10);

	}
	//Pie de página
	function Footer()
	{
		//Posición: a 1,5 cm del final

		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','',8);
		//ip
		$ip = captura_ip();
		//Número de página
		$fecha=date("d-m-Y");
		//hora
		$hora=date("H:i:s");
		$this->Cell(60,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L');
		//$this->Cell(165,10,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		//$this->Cell(165,10,'Fecha: '.$fecha ,0,0,'L');
		$this->ln(3);
		$this->Cell(60,10,'',0,0,'L');
		$this->Cell(165,10,'',0,0,'C');
		//$this->Cell(165,10,'Hora: '.$hora ,0,0,'L');
		//fecha
	}

	//Tabla coloreada
	function FancyTable($data,$header,$header_det)
	{
		$cant=100000;
		$puntero=0;
		$sortcol='ITEM.nombre';
		$sortdir='asc';
		$criterio_filtro="";
		//$criterio_filtro=" INGRES.fecha_finalizado_cancelado = ''".$_SESSION["part_dia_fecha_desde"]."''";
		$Custom=new cls_CustomDBAlmacenes();

		//Obtiene los Ingresos por Item
		//echo "desde:".$_SESSION['part_dia_fecha_desde'];
		//echo "----- hasta:".$_SESSION['part_dia_fecha_hasta'];
		
		$Custom->ListarParteDiario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$_SESSION['part_dia_id_financiador'],$_SESSION['part_dia_id_regional'],$_SESSION['part_dia_id_programa'],$_SESSION['part_dia_id_proyecto'],$_SESSION['part_dia_id_actividad'],$_SESSION['part_dia_id_parametro_almacen'],$_SESSION['part_dia_fecha_desde'],$_SESSION['part_dia_fecha_hasta'],$_SESSION['part_dia_id_almacen'],$_SESSION['part_dia_id_almacen_logico']);
		$resp_ing=$Custom->salida;

		/*$this->SetFont('Arial','B',12);
		//Movernos a la derecha
		$this->Cell(250,4,'PARTE DIARIO',0,1,'C');

		$fechad=$_SESSION["part_dia_fecha_desde"];

		$mes = substr($fechad, 0, 2);
		$dia = substr($fechad, 3, 2);
		$anio = substr($fechad, -4);
		$fechad=$dia.'-'.$mes.'-'.$anio;
		//Mostramos la fecha, ahora sí en el idioma deseado.
		$fechad=strftime($formato, strtotime($fechad));

		$fechah=$_SESSION["part_dia_fecha_hasta"];

		$mes = substr($fechah, 0, 2);
		$dia = substr($fechah, 3, 2);
		$anio = substr($fechah, -4);
		$fechah=$dia.'-'.$mes.'-'.$anio;

		//Mostramos la fecha, ahora sí en el idioma deseado.
		$fechah=strftime($formato, strtotime($fechah));

		$this->SetFont('Arial','B',8);
		$this->Cell(250,6,'Del '.$fechad.' Al '.$fechah,0,0,'C');
		$this->Ln(10);*/

		//Contador hoja
		$prim_hoja=1;

		$this->SetFont('Arial','',10);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(190,190,190);
		$this->SetLineWidth(.1);
		$this->SetFont('','',10);

		//Cabecera
		$w=array(5,20,80,14,14,17,15,14,14,17,14,14,14);
		$a=array('C','L','L','L','R','R','R','R','R','R','R','R','R','R',);
		//('Item','Descripción','Ingresos','Transferencias','Devoluciones','Parcial','Salidas','Transferencias','Demasía','Parcial','Saldo');
		$fecha=date("d-m-Y");

		$this->SetFont('Arial','',7);
		//Imprime los rótulos de las columnas

		$this->Cell(119,3,'',0,0,'C',1);
		$this->Cell(46,3,'INGRESOS','LTR',0,'C',1);
		$this->Cell(14,3,'','L',0,'C',1);
		$this->Cell(45,3,'SALIDAS','LTR',1,'C',1);

		for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],5,$header[$i],1,0,'C',1);
		$this->Ln();

		// Se imprime los datos de ingresos
		$this->SetFont('Arial','',6);
		$cont=1;
		$id_item='';
		$tot_item=0;
		
		//$this->ImprimirTabla($resp_ing,5,0.6,$header,$w,$a);

		foreach($resp_ing as $row)
		{
			//Coloca el Item y la descripción
			$this->Cell($w[0],4,$cont,'LTRB',0,'C',$fill);
			$this->Cell($w[1],4,$row['nombre'],'LTRB',0,'L',$fill);
			$this->Cell($w[2],4,$row['descripcion'],'LTRB',0,'L',$fill);
			
			//$this->MultiLinea($w[2],4,$row['descripcion'],1,'L');

			$this->Cell($w[3],4,number_format($row['cant_saldo_ant'],2,$this->sep_decim,$this->sep_mil),'LTRB',0,'R',$fill);
			$this->Cell($w[4],4,number_format($row['cant_ing'],2,$this->sep_decim,$this->sep_mil),'LTRB',0,'R',$fill);
			$this->Cell($w[5],4,number_format($row['cant_ing_transf'],2,$this->sep_decim,$this->sep_mil),'LTRB',0,'R',$fill);
			$this->Cell($w[6],4,number_format($row['cant_ing_dev'],2,$this->sep_decim,$this->sep_mil),'LTRB',0,'R',$fill);
			$this->Cell($w[7],4,number_format($row['cant_tot_ing'],2,$this->sep_decim,$this->sep_mil),'LTRB',0,'R',$fill);
			$this->Cell($w[8],4,number_format($row['cant_sal'],2,$this->sep_decim,$this->sep_mil),'LTRB',0,'R',$fill);
			$this->Cell($w[9],4,number_format($row['cant_sal_transf'],2,$this->sep_decim,$this->sep_mil),'LTRB',0,'R',$fill);
			$this->Cell($w[10],4,number_format($row['cant_sal_dem'],2,$this->sep_decim,$this->sep_mil),'LTRB',0,'R',$fill);
			$this->Cell($w[11],4,number_format($row['cant_tot_sal'],2,$this->sep_decim,$this->sep_mil),'LTRB',0,'R',$fill);
			$this->Cell($w[12],4,number_format($row['cant_saldo_tot'],2,$this->sep_decim,$this->sep_mil),'LTRB',1,'R',$fill);
			$cont++;
		}
	}




}

$pdf=new PDF('L','mm','Letter');
$pdf->AliasNbPages();
//Títulos de las columnas
$header=array('#','Item','Descripción','Saldo Ant.','Ingresos','Transferencias','Devoluciones','Parcial','Salidas','Transferencias','Demasía','Parcial','Saldo');


//Carga de datos
$tipo=$tipo;
//$data=$pdf->LoadData();
//echo json_encode($tipo_torre);
$pdf->SetFont('Arial','',10);
$pdf->SetAutoPageBreak(1,20);
$pdf->SetTopMargin(15);
$pdf->SetRightMargin(15);
$pdf->SetLeftMargin(15);
$pdf->AddPage();
//$pdf->Maestro($data,'Original',$header,$header_det);
$pdf->FancyTable('',$header,'');
$pdf->Output();
?>