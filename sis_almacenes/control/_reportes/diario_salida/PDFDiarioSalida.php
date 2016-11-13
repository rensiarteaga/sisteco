<?php
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
include_once("../../rcm_LibModeloAlmacenes.php");

class PDF extends FPDF
{
	var $data; //Contiene los datos de la consulta del reporte
	var $fecha_desde;
	var $id_supergrupo;
	var $id_almacen;

	function Header()
	{
		global $title;
		$this->SetLeftMargin(15);
		$funciones = new funciones();
		$fecha=date("d-m-Y");
		//Logo
		$this->Image('../../../../lib/images/logo_reporte.jpg',150,4);
		//Arial bold 15
		$this->SetFont('Arial','B',12);
		$this->SetY(20);
		//Movernos a la derecha
		$this->Cell(185,5,'RESUMEN DIARIO DE SALIDAS',0,1,'C');
		$this->Cell(185,5,'(' .$this->data[0]['supergrupo'].')',0,0,'C');
		$this->Ln(5);
		$this->SetFont('Arial','',8);
		
	}
	//Pie de página
	function Footer()
	{
		//Posición: a 1,5 cm del final

		$this->SetY(-50);
		//Arial italic 8
		$this->SetFont('Arial','',8);
		$this->Cell(60,6,'','LRT',0,'C',$fill);
		$this->Cell(60,6,'','LRT',0,'C',$fill);
		$this->Cell(68,6,'','LRT',0,'C',$fill);
		$this->Ln(6);
		$this->Cell(60,6,'','LR',0,'C',$fill);
		$this->Cell(60,6,'','LR',0,'C',$fill);
		$this->Cell(68,6,'','LR',0,'C',$fill);
		$this->Ln(6);
		$this->Cell(60,6,$this->data[0]['jefe_almacenes'],'LRB',0,'C',$fill);
		$this->Cell(60,6,$this->data[0]['almacenero'],'LRB',0,'C',$fill);
		$this->Cell(68,6,'','LRB',0,'C',$fill);
		$this->Ln(6);

		$this->Cell(60,6,'Encargado de Almacén','LRB',0,'C',$fill);
		$this->Cell(60,6,'Jefe de Almacenes','LRB',0,'C',$fill);
		$this->Cell(68,6,'','LRB',0,'C',$fill);
		$this->Ln(6);
	}
	function LoadData()
	{
		$cant=100000;
		$puntero=0;
		$sortcol='SALIDA.correlativo_sal';
		$sortdir='asc';
		$Custom=new cls_CustomDBAlmacenes();

		if($this->id_almacen='%')
		{
			//General
			$criterio_filtro=" SALIDA.fecha_borrador = ''".$this->fecha_desde."'' AND SALIDA.estado_salida = ''Borrador'' AND ITEM.id_supergrupo = ".$this->id_supergrupo;
			$Custom->DiarioSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		}
		else
		{
			//Por almacén
			$criterio_filtro=" SALIDA.fecha_borrador = ''".$this->fecha_desde."'' AND SALIDA.estado_salida = ''Borrador'' AND ITEM.id_supergrupo = ".$this->id_supergrupo. " AND ALMACE.id_almacen LIKE ''".$this->id_almacen."''";
			$Custom->DiarioSalidaAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		}

		/*echo "query: ".$criterio_filtro;
		exit;*/

		//Carga los datos en variable local
		$this->data=$Custom->salida;

		/*print ('<pre>');
		print_r($this->data);
		print ('</pre>');
		exit;*/

	}

	function FancyTable()
	{
		//Títulos de las columnas
		$header=array('#','No. Salida','Tramo','Importe Bs.');
		$w=array(10,20,85,30);

		$this->SetFont('Arial','',7);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(0,33,91);
		$this->SetLineWidth(.3);
		$this->SetFont('','',10);

		$this->SetFont('','',6);
		//Se imprime los datos del reporte
		$total=0;
		$sol='';
		$prim_hoja=1;
		//Contador
		$cont=1;

		/*print ('<pre>');
		print_r($this->data);
		print ('</pre>');
		exit;*/

		foreach($this->data as $row)
		{
			if($sol!=$row['solicitante'])
			{
				if($prim_hoja==0)
				{
					//Imprime el total del anterior
					$this->Cell($w[0],4,'','LB',0,'R',$fill);
					$this->Cell($w[1],4,'','B',0,'R',$fill);
					$this->Cell($w[2],4,'TOTAL','RB',0,'R',$fill);
					$this->Cell($w[3],4,$total,'RB',1,'R',$fill);
					//No es primera hoja
					$this->AddPage();
					//$this->SetY();
				}
				//Imprime el Contratista y las columnas
				$this->SetFont('Arial','',8);
				//$this->SetY(10);
				$this->Cell(50,4,'Fecha: '.$this->fecha_desde,0,1,'L');
				$this->Cell(60,4,'Contratista: '.$row['solicitante'],'',1,'L',$fill);

				$this->SetFont('Arial','',6);
				for($i=0;$i<count($header);$i++)
				$this->Cell($w[$i],4,$header[$i],1,0,'C',1);
				$this->Ln();
				//Inicializa el total
				$sol=$row['solicitante'];
				$total=0;
				$prim_hoja=0;
				$cont=1;
			}

			$this->Cell($w[0],4,$cont,'LTRB',0,'C',$fill);
			$this->Cell($w[1],4,$row['correlativo_sal'],'LTRB',0,'C',$fill);
			$this->Cell($w[2],4,$row['tramo'],'LTRB',0,'L',$fill);
			$this->Cell($w[3],4,$row['importe'],'LTRB',1,'R',$fill);
			$total+=$row['importe'];
			$cont++;
		}

		//Imprime el total del último registro
		if(count($this->data)>0)
		{
			//Imprime el total del anterior
			$this->Cell($w[3],4,'TOTAL: '.$total,'LTRB',1,'R',$fill);
		}
	}

}

$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();

$pdf->fecha_desde=$_SESSION['rep_dia_sal_fecha_desde'];
$pdf->id_almacen=$_SESSION['rep_dia_sal_id_almacen'];
$pdf->id_supergrupo=$_SESSION['rep_dia_sal_id_supergrupo'];

/*echo "fecha_desde: ".$pdf->fecha_desde.'<br>';
echo "id_almacen: ".$pdf->id_almacen.'<br>';
echo "id_supergrupo: ".$pdf->id_supergrupo.'<br>';*/

//Carga de datos
$pdf->SetFont('Arial','',10);
$pdf->SetAutoPageBreak(1,35);
$pdf->SetTopMargin(15);
$pdf->SetRightMargin(15);
$pdf->SetLeftMargin(15);
$pdf->LoadData();
$pdf->AddPage();
$pdf->FancyTable();
$pdf->Output();
?>