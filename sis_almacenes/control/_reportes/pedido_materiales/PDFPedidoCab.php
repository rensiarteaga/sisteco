<?php
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
include_once("../../rac_LibModeloAlmacenes.php");

class PDF extends FPDF
{
	var $datos;
	
	function Header()
	{
		global $title;
		$imprimir_footer=1;
		$this->SetLeftMargin(15);
		$funciones = new funciones();
		$data1=$this->LoadData();
		$this->SetDrawColor(190,190,190);
		$this->SetLineWidth(.2);
		
		//Logo
		$this->Image('../../../../lib/images/logo_reporte.jpg',20,16,36,13);
		$this->Ln(5);
		
		$this->SetFont('Arial','B',9);
		
		$this->Cell(46,5,'','LRT',0,'C');
		$this->Cell(106,5,'','LRT',0,'C');
		$this->Cell(20,5,'Número: ','LTB',0,'R');
		$this->Cell(20,5,$data1[0]['correlativo_sal'],'RTB',0,'L');
		$this->Ln(5);
		
		
		
        $this->Cell(46,5,'','LR',0,'C');
		$this->Cell(106,5,'','LR',0,'C');
		$this->Cell(20,5,'Fecha: ','LTB',0,'R');
		$this->Cell(20,5,$data1[0]['fecha'],'RTB',0,'L');
		$this->Ln(5);
		
		$this->Cell(46,5,'','LRB',0,'C');
		$this->Cell(106,5,'','LRB',0,'C');
		$this->Cell(20,5,'Página: ','LTB',0,'R');
		$this->Cell(20,5,''.$this->PageNo() .' de {nb}','RTB',0,'L');
		$this->Ln(5);
						
		$this->SetFont('Arial','B',12);
		$this->SetY(13);
		$this->Cell(46,5,'',0,0,'C');
		$this->Cell(106,13,'SALIDA POR UNIDAD CONSTRUCTIVA',0,0,'C');
		$this->Ln(7);
		$this->Cell(46,5,'',0,0,'C');
		$this->Cell(106,10,$data1[0]['desc_almacen'],0,0,'C');//,'LR',0,'C');
		$this->Ln(6);
		
	}

	function Footer()
	{
		//Posición: a 1,5 cm del final
		$this->SetY(-35);
		//Arial italic 8
		$this->SetFont('Arial','',7);
		
		$this->Cell(48,15,'','LTR',0,'L');
		$this->Cell(48,15,'','LTR',0,'L');
		$this->Cell(48,15,'','LTR',0,'L');
		$this->Cell(48,15,'','LTR',1,'L');
		
		$this->Cell(48,3,strtoupper($this->datos[0]['almacenero']),'LTR',0,'C');
		//$this->Cell(48,3,strtoupper($this->datos[0]['jefe_almacen']),'LTR',0,'C');
		$this->Cell(48,3,'','LTR',0,'L');
		$this->Cell(48,3,'','LTR',0,'L');
		$this->Cell(48,3,strtoupper($this->datos[0]['jefe_almacen']),'LTR',1,'C');
		
		$this->Cell(48,3,'CI: '.$this->datos[0]['almacenero_doc_id'],'LR',0,'C');
		//$this->Cell(48,3,'CI: '.$this->datos[0]['doc_jefe_almacen'],'LR',0,'C');
		$this->Cell(48,3,' ','LR',0,'C');
		$this->Cell(48,3,' ','LR',0,'C');
		$this->Cell(48,3,'CI: '.$this->datos[0]['doc_jefe_almacen'],'LR',1,'C');
		
		$this->Cell(48,4,'Encargado de Registros Almacén','LRB',0,'C');
		//$this->Cell(48,4,'Gestor de Almacenes','LRB',0,'C');
		$this->Cell(48,4,'','LRB',0,'C');
		$this->Cell(48,4,'','LRB',0,'C');
		$this->Cell(48,4,'Encargado  de Almacén','LRB',0,'C');
		$this->ln(1);

		//Número de página
		$fecha=date("d-m-Y");
		//hora
		$hora=date("H:i:s");
		//$this->Cell(75,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L');
		//$this->Cell(40,10,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		//$this->Cell(47,10,'',0,0,'C');
		//$this->Cell(35,10,'Fecha: '.$fecha ,0,0,'L');
		$this->ln(3);
		$this->Cell(75,10,'',0,0,'L');
		$this->Cell(40,10,'',0,0,'C');
		$this->Cell(47,10,'',0,0,'C');
		//$this->Cell(35,10,'Hora: '.$hora ,0,0,'L');

	}

	function LoadData()
	{
		$cant=100000;
		$puntero=0;
		//$sortcol='TIPOUC.nombre';
		$sortcol='TIPOUC.observaciones,TIPOUC.nombre';
		$sortdir='asc';
		$criterio_filtro=' OSUCDE.id_salida = '.$_SESSION["rep_cab_id_salida"];
		//Leer las líneas del fichero
		$Custom=new cls_CustomDBAlmacenes();
		$Custom->PedidoMaterialesUC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

		$resp=$Custom->salida;
		$this->datos=$Custom->salida;

		return $resp;
	}

	function Maestro($data,$titulo_copia,$header,$header_det)
	{
		$this->imprimir_footer=1;
		$this->SetFont('Arial','B',12);
		//Movernos a la derecha
		
		
		$this->Cell(185,10,$titulo_copia,0,0,'C');//,'LR',0,'C');
		$this->Ln(5);
		if(sizeof($data>0))
		{
			$this->SetFont('Arial','BI',9);
			$this->Cell(35,9,'Solicitante:',0,0,'R');
			$this->SetFont('Arial','',9);
			$this->Cell(65,9,''.$data[0]['solicitante'],0,0,'L');
			$this->Ln(4);

			$this->SetFont('Arial','BI',9);
			$this->Cell(35,9,'Almacén Lógico:',0,0,'R');
			$this->SetFont('Arial','',9);
			$this->Cell(65,9,''.$data[0]['almacen_log'],0,0,'L');		
						
			$this->Cell(39,9,'Imputación:',0,0,'R');
			
			$this->SetFont('Arial','B',9);
			$this->Cell(13,9,''.$data[0]['codigo_proyecto'],0,0,'C');
			$this->SetFont('Arial','',9);
			$this->Ln(4);
			
			$this->SetFont('Arial','BI',9);
			$this->Cell(35,9,'Receptor Autorizado:',0,0,'R');
			$this->SetFont('Arial','',9);
			$this->Cell(65,9,$data[0]['receptor'],0,0,'L');
			$this->Ln(4);
			
            $this->SetFont('Arial','BI',9);
			$this->Cell(35,9,'Tramo:',0,0,'R');
			$this->SetFont('Arial','',9);
			$this->Cell(65,9,$data[0]['tramo'],0,0,'L');
			
			$this->Cell(39,9,'Número Contrato:',0,0,'R');
			
			$this->SetFont('Arial','B',9);
			$this->Cell(13,9,$data[0]['num_contrato'],0,0,'C');
			$this->SetFont('Arial','',9);
			$this->Ln(4);
			
			$this->SetFont('Arial','BI',9);
			$this->Cell(35,9,'Motivo Salida:',0,0,'R');
			$this->SetFont('Arial','',9);
			$this->Cell(65,9,$data[0]['motivo_sal'],0,0,'L');
			
			$this->Ln(16);
			
			$this->FancyTable($data,$header,$header_det);
		}


	}

	//Tabla coloreada
	function FancyTable($data,$header,$header_det)
	{
		//Colores, ancho de línea y fuente en negrita
		$cont=1;

		$this->SetFont('Arial','',10);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(190,190,190);
		$this->SetLineWidth(.1);

		//Cabecera
		$w=array(10,70,72,40);
		$fecha=date("d-m-Y");

		//Imprime los rótulos de las columnas
		for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],5,$header[$i],1,0,'C',1);
		$this->Ln();

		$this->SetFont('Arial','',8);
		//Se imprime los datos del reporte
		foreach($data as $row)
		{
			$this->Cell($w[0],5,$cont,'LTRB',0,'C',$fill);
			$this->Cell($w[1],5,$row[5],'LTRB',0,'L',$fill);
			$this->Cell($w[2],5,$row[4],'LTRB',0,'L',$fill);
			$this->Cell($w[3],5,''.round($row[3] * 100)/100,'LTRB',1,'R',$fill);
			
			$cont=$cont+1;
		}
		
		
		
		//Imprime las observaciones si es que hubieran
		$this->SetFont('Arial','',6);
		$this->Cell(192,3.5,'Observaciones:','LR',1,'L',$fill);
		$this->MultiCell(192,3.5,$data[0]['observaciones'],'LBR',1,'L',$fill);
		//$this->MultiCell(180,3.5,'','LBR',1,'L',$fill);

		
	}

}

$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
//Títulos de las columnas
$header=array('Nro.','Unidad Constructiva','Componente','Cantidad');
$header_det=array('Nro.','Código','Cant.x Comp.','Peso Unitario','Unidad','Calidad','Descripción  del Material','Peso Total','Cantidad Total');

//Carga de datos
$tipo=$tipo;
$data=$pdf->LoadData();
$pdf->SetFont('Arial','',10);
$pdf->SetAutoPageBreak(1,35);
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(15);
$pdf->SetLeftMargin(15);
$pdf->AddPage();
//$pdf->Maestro($data,'Original',$header,$header_det);
$pdf->Maestro($data,'',$header,$header_det);
$pdf->Output();
?>