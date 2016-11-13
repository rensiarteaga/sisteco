<?php
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
include_once("../../rac_LibModeloAlmacenes.php");

class PDF extends FPDF
{
	//Cargar los datos
	//Cabecera de página


	function Header()
	{
		global $title;
		$imprimir_footer=1;
		$this->SetLeftMargin(15);
		$funciones = new funciones();
		//Logo
		//$this->Image('../../../../lib/images/logo_reporte.jpg',140,2);
		$this->Image('../../../../lib/images/logo_reporte.jpg',170,8,36,13);
		//Arial bold 15
		/*$this->SetFont('Arial','B',12);
		//Movernos a la derecha
		$this->Cell(185,13,'PEDIDO DE MATERIALES',0,0,'C');
		$this->Ln(16);*/
		$this->Ln(5);
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
		$this->Cell(100,10,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(100,10,'Fecha: '.$fecha ,0,0,'L');
		$this->ln(3);
		$this->Cell(60,10,'',0,0,'L');
		$this->Cell(100,10,'',0,0,'C');
		$this->Cell(100,10,'Hora: '.$hora ,0,0,'L');
		//fecha
	}
	function LoadData()
	{
		$cant=100000;
		$puntero=0;
		$sortcol='TIPOUC.nombre';
		$sortdir='asc';
		$criterio_filtro=' OSUCDE.id_salida = '.$_SESSION["rep_list_mat_id_salida"];
		//Leer las líneas del fichero
		$Custom=new cls_CustomDBAlmacenes();
		$Custom->PedidoMaterialesUC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

		$resp=$Custom->salida;

		return $resp;
	}

	function Maestro($data,$titulo_copia,$header,$header_det)
	{
		$this->imprimir_footer=1;
		$this->SetFont('Arial','B',12);
		//Movernos a la derecha
		/*$this->Cell(185,13,'PEDIDO DE MATERIALES',0,0,'C');
		$this->Ln(6);
		$this->Cell(185,10,$data[0][0],0,0,'C');//,'LR',0,'C');
		$this->Ln(6);
		$this->Cell(185,10,$titulo_copia,0,0,'C');//,'LR',0,'C');
		$this->Ln(16);
		if(sizeof($data>0))
		{
		$this->SetFont('Arial','',10);
		$this->Cell(120,10,'Solicitante: '.$data[0][7],0,0,'L');//,'LR',0,'C');
		$this->Cell(140,10,'Imputación: ',0,0,'L');
		$this->Ln(4);
		$this->Cell(120,10,'Receptor autorizado: '.$data[0][1],0,0,'L');//,'LR',0,'C');
		$this->Cell(140,10,'Fecha: '.$data[0][2],0,0,'L');//,'LR',0,'C');
		$this->Ln(12);*/
		$this->FancyTable($data,$header,$header_det);
		//}


	}

	//Tabla coloreada
	function FancyTable($data,$header,$header_det)
	{
		//Colores, ancho de línea y fuente en negrita
		$prim_hoja=1;

		$imprimir_footer=1;
		$this->SetFont('Arial','',10);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(190,190,190);
		$this->SetLineWidth(.1);
		$this->SetFont('','',10);

		//Cabecera
		$w=array(10,70,70,30);
		$wi=array(35,60,60,30);
		//$wdet=array(6,20,45,80,20,20);
		$wdet=array(6,23,15,15,10,10,58,13,13,13,13);
		//('Nro.','Código','Cant.x Comp.','Peso Unitario','Unidad','Calidad','Descripción  del Material','Peso Total','Cantidad Total');
		$rama=array();
		$rama_nombre=array();
		$fecha=date("d-m-Y");

		//Imprime los rótulos de las columnas
		/*for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],5,$header[$i],1,0,'C',1);
		$this->Ln();*/

		/*print "<pre>";
		print_r($header);
		print "</pre>";
		exit;*/

		//Se imprime los datos del reporte
		/*foreach($data as $row)
		{
		$this->Cell($w[0],5,$cont,'LTRB',0,'C',$fill);
		$this->Cell($w[1],5,$row[5],'LTRB',0,'L',$fill);
		$this->Cell($w[2],5,$row[4],'LTRB',0,'L',$fill);
		$this->Cell($w[3],5,$row[3],'LTRB',1,'R',$fill);
		$cont=$cont+1;
		}*/

		// Se imprime el detalle de cada UC solicitada
		foreach($data as $row)
		{
			$imprimir_footer=0;
			//Obtiene el detalle
			$cont=1;
			$cant=100000;
			$puntero=0;
			//$sortcol='OSUCDE.id_tipo_unidad_constructiva';
			//$sortcol='ITEM.codigo asc';
			$sortcol='ITEM.id_supergrupo,COMPON.orden,ITEM.nombre asc';
			$sortdir='asc';
			$criterio_filtro=' OSUCDE.id_salida = '.$_SESSION["rep_list_mat_id_salida"].' AND OSUCDE.id_tipo_unidad_constructiva = '.$row[6];
			$Det=new cls_CustomDBAlmacenes();
			$Det->PedidoMaterialesUCDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
			$detalle=$Det->salida;
			if($prim_hoja!=1)
			{
				$this->AddPage();
			}
			//Imprime el título del detalle
			$this->SetFont('Arial','B',12);
			$this->Cell(185,13,'LISTADO DE MATERIALES',0,0,'C');
			$this->Ln(6);
			$this->Cell(185,10,$data[0][0],0,0,'C');//,'LR',0,'C');
			$this->Ln(6);
			$this->SetFont('Arial','',10);

			$this->Cell(120,10,'Solicitante: '.$data[0][7],0,0,'L');//,'LR',0,'C');
			$this->Ln(4);
			$this->Cell(120,10,'Receptor autorizado: '.$data[0][1],0,0,'L');//,'LR',0,'C');
			$this->Cell(140,10,'Fecha: '.$data[0][2],0,0,'L');//,'LR',0,'C');
			$this->Ln(4);
			$this->Cell(120,10,'Unidad Constructiva:    '.$detalle[0][8],0,0,'L');//,'LR',0,'C');
			$this->Ln(4);
			$this->Cell(120,10,'Componente:    '.$detalle[0][1],0,0,'L');//,'LR',0,'C');
			$this->Ln(4);
			$this->Cell(120,10,'Cantidad:    '.round($detalle[0][2] * 100)/100,0,1,'L');//,'LR',0,'C'); round(valor_float * 100) / 100

			
			if(count($detalle)>1)
			{
				//$this->Ln(2);
				$this->Cell(120,10,$detalle[0]['supergrupo'] ,0,1,'L');
			}
			
			//Imprime los rótulos del detalle
			$this->SetFont('Arial','',6);
			for($i=0;$i<count($header_det);$i++)
			$this->Cell($wdet[$i],5,$header_det[$i],1,0,'C',1);
			$this->Ln();

			$this->SetFont('Arial','',6);
			$id_supergrupo=0;
			foreach($detalle as $row)
			{
				if($cont==1)
				{
					$id_supergrupo=$row['id_supergrupo'];
				}
				if($id_supergrupo!=$row['id_supergrupo']&&$cont>1)
				{
					//Para separar por páginas los materiales por supergrupo
					$this->AddPage();
					$id_supergrupo=$row['id_supergrupo'];
					$cont=1;

					$this->SetY(27);
					//Imprime el título del supergrupo
					$this->SetFont('Arial','',10);
					$this->Cell(120,10,$row['supergrupo'] ,0,1,'L');
					//Imprime los encabezados
					$this->SetFont('Arial','',6);
					for($i=0;$i<count($header_det);$i++)
					$this->Cell($wdet[$i],5,$header_det[$i],1,0,'C',1);
					$this->Ln();
				}
				$this->Cell($wdet[0],4,$cont,'LTRB',0,'C',$fill);
				$this->Cell($wdet[1],4,$row[4],'LTRB',0,'L',$fill);
				$this->Cell($wdet[2],4,round($row[6]*100)/100,'LTRB',0,'R',$fill);
				$this->Cell($wdet[3],4,$row['peso_kg'],'LTRB',0,'R',$fill);
				$this->Cell($wdet[4],4,$row[12],'LTRB',0,'C',$fill);
				$this->Cell($wdet[5],4,$row['calidad'],'LTRB',0,'C',$fill);
				//$this->Cell($wdet[6],4,$row[5],'LTRB',0,'L',$fill);
				$x=$this->GetX();
				$y=$this->GetY();
				$this->MultiCell($wdet[6],4,$row[5],'LTRB','L');
				$this->SetXY($x+$wdet[6],$y);
				$this->Cell($wdet[7],4,round($row['peso_total']*100)/100,'LTRB',0,'R',$fill);
				$this->Cell($wdet[8],4,round($row[7]*100)/100,'LTRB',0,'R',$fill);
				$this->Cell($wdet[9],4,$row['cant_demasia'],'LTRB',0,'R',$fill);
				$this->Cell($wdet[10],4,round($row['cantidad_total_dem']*100)/100,'LTRB',1,'R',$fill);
				$cont=$cont+1;
			}
			//Define que no es la primera página
			$prim_hoja=0;
		}
	}
}

$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
//Títulos de las columnas
$header=array('Nro.','Unidad Constructiva','Componente','Cantidad');
$header_det=array('Nro.','Código','Cant.x Comp.','Peso Unitario','Unidad','Calidad','Descripción  del Material','Peso Total','Cantidad','Demasía','Cantidad Tot.');

//Carga de datos
$tipo=$tipo;
$data=$pdf->LoadData();
//echo json_encode($tipo_torre);
$pdf->SetFont('Arial','',10);
$pdf->SetAutoPageBreak(1,35);
$pdf->SetTopMargin(15);
$pdf->SetRightMargin(15);
$pdf->SetLeftMargin(15);
$pdf->AddPage();
$pdf->Maestro($data,'Original',$header,$header_det);
$pdf->Output();
?>