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
		//Logo
		$this->Image('../../../../lib/images/logo_reporte.jpg',140,2);
	}
	//Pie de página
	function Footer1()
	{
		//echo "FFFFF";
		//exit;
		//Posición: a 1,5 cm del final

		$this->SetY(-50);
		//Arial italic 8
		$this->SetFont('Arial','',8);
		//ip
		$ip = captura_ip();
		$this->Cell(25,6,' ','',0,'C',$fill);
		//$this->Cell(47,6,'Entregué conforme','LTR',0,'C',$fill);
		//$this->Cell(47,6,'Recibí conforme','LTR',0,'C',$fill);
		$this->Cell(47,6,'','',1,'C',$fill);
		$this->Cell(47,6,'','',0,'C',$fill);
		$this->Cell(47,6,'','LTR',0,'C',$fill);
		$this->Cell(47,6,'','LTR',0,'C',$fill);
		$this->Cell(47,6,'','',1,'C',$fill);

		$this->Cell(47,6,'','',0,'C',$fill);
		$this->Cell(47,6,'....................................','LR',0,'C',$fill);
		$this->Cell(47,6,'....................................','LR',0,'C',$fill);
		$this->Cell(47,6,'','',0,'C',$fill);
		$this->Ln(3);

		$this->Cell(47,6,'','',0,'C',$fill);
		$this->Cell(47,6,'Entregué conforme','LRB',0,'C',$fill);
		$this->Cell(47,6,'Recibí conforme','LRB',0,'C',$fill);
		$this->Cell(47,6,'','',0,'C',$fill);
		$this->Ln(6);

		$this->Cell(47,6,'','',0,'',$fill);
		$this->Cell(47,6,'Aclaración:','',0,'L',$fill);
		$this->Cell(47,6,'Aclaración:','',0,'L',$fill);
		$this->Cell(47,6,'','',0,'',$fill);
		$this->Ln(3);

		$this->Cell(47,6,'','',0,'',$fill);
		$this->Cell(47,6,'CI:','',0,'L',$fill);
		$this->Cell(47,6,'CI:','',0,'L',$fill);
		$this->Cell(47,6,':','',0,'',$fill);
		$this->Ln(3);

		$this->Cell(47,6,'','',0,'',$fill);
		$this->Cell(47,6,'Fecha:','',0,'L',$fill);
		$this->Cell(47,6,'Fecha:','',0,'L',$fill);
		$this->Cell(47,6,'','',1,'',$fill);

		//$this->SetFont('Arial','',6);

		//Número de página
		/*$fecha=date("d-m-Y");
		//hora
		$hora=date("H:i:s");
		$this->Cell(60,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L');
		$this->Cell(100,10,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(100,10,'Fecha: '.$fecha ,0,0,'L');
		$this->ln(3);
		$this->Cell(60,10,'',0,0,'L');
		$this->Cell(100,10,'',0,0,'C');
		$this->Cell(100,10,'Hora: '.$hora ,0,0,'L');*/
		//fecha
	}

	//Pie de página
	function Footer()
	{
		//Posición: a 1,5 cm del final
		$this->SetY(-35);
		//Arial italic 8
		$this->SetFont('Arial','',7);

		$this->Cell(90,15,'','LTR',0,'L');
		$this->Cell(90,15,'','LTR',1,'L');

		$this->Cell(90,3,strtoupper($this->datos[0]['almacenero']),'LTR',0,'C');
		$this->Cell(90,3,strtoupper($this->datos[0]['receptor']),'LTR',1,'C');

		$this->Cell(90,3,'CI:'.$this->datos[0]['doc_almacenero'],'LR',0,'C');
		$this->Cell(90,3,'CI:'.$this->datos[0]['receptor_ci'],'LR',1,'C');

		$this->Cell(90,4,'Entregado por','LRB',0,'C');
		$this->Cell(90,4,'Recibi conforme','LRB',0,'C');
		$this->ln(1);

		//Número de página
		$fecha=date("d-m-Y");
		//hora
		$hora=date("H:i:s");
		$this->Cell(75,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L');
		$this->Cell(40,10,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(47,10,'',0,0,'C');
		$this->Cell(35,10,'Fecha: '.$fecha ,0,0,'L');
		$this->ln(3);
		$this->Cell(75,10,'',0,0,'L');
		$this->Cell(40,10,'',0,0,'C');
		$this->Cell(47,10,'',0,0,'C');
		$this->Cell(35,10,'Hora: '.$hora ,0,0,'L');
	}



	function LoadData()
	{
		$cant=100000;
		$puntero=0;
		$sortcol='TIPOUC.nombre';
		$sortdir='asc';
		$criterio_filtro=' OSUCDE.id_salida = '.$_SESSION["rep_mat_id_salida"];
		/*echo "query: ".$criterio_filtro;
		exit;*/
		//Leer las líneas del fichero
		$Custom=new cls_CustomDBAlmacenes();
		$Custom->PedidoMaterialesUC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

		$resp=$Custom->salida;
		$this->datos=$resp;

		return $resp;
	}

	function Maestro($data,$titulo_copia,$header,$header_det)
	{
		$this->imprimir_footer=1;
		$this->SetFont('Arial','B',12);
		//Movernos a la derecha
		$this->Cell(185,13,'PEDIDO DE MATERIALES',0,0,'C');
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
			$this->Ln(12);
			$this->FancyTable($data,$header,$header_det);
		}


	}

	//Tabla coloreada
	function FancyTable($data,$header,$header_det)
	{
		//Colores, ancho de línea y fuente en negrita
		$cont=1;

		$imprimir_footer=1;
		$this->SetFont('Arial','',10);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(0,33,91);
		$this->SetLineWidth(.3);
		$this->SetFont('','',10);
		//Cabecera
		$w=array(10,70,70,30);
		$wi=array(35,60,60,30);
		$wdet=array(6,20,45,80,20,20);
		$rama=array();
		$rama_nombre=array();
		$fecha=date("d-m-Y");

		//Imprime los rótulos de las columnas
		for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],5,$header[$i],1,0,'C',1);
		$this->Ln();

		/*print "<pre>";
		print_r($header);
		print "</pre>";
		exit;*/

		//Se imprime los datos del reporte
		foreach($data as $row)
		{
			$this->Cell($w[0],5,$cont,'LTRB',0,'C',$fill);
			$this->Cell($w[1],5,$row[5],'LTRB',0,'L',$fill);
			$this->Cell($w[2],5,$row[4],'LTRB',0,'L',$fill);
			$this->Cell($w[3],5,$row[3],'LTRB',1,'R',$fill);
			$cont=$cont+1;
		}

		// Se imprime el detalle de cada UC solicitada
		foreach($data as $row)
		{
			$imprimir_footer=0;
			//Obtiene el detalle
			$cont=1;
			$cant=100000;
			$puntero=0;
			//$sortcol='OSUCDE.id_tipo_unidad_constructiva';
			$sortcol='ITEM.codigo asc';
			$sortdir='asc';
			$criterio_filtro=' OSUCDE.id_salida = '.$_SESSION["rep_mat_id_salida"].' AND OSUCDE.id_tipo_unidad_constructiva = '.$row[6];
			$Det=new cls_CustomDBAlmacenes();
			$Det->PedidoMaterialesUCDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
			$detalle=$Det->salida;
			$this->AddPage();

			/*print "<pre>";
			print_r($detalle);
			print "</pre>";*/

			//Imprime el título del detalle
			$this->SetFont('Arial','B',12);
			$this->Cell(185,13,'SALIDA DE MATERIALES',0,0,'C');
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

			//Imprime los rótulos del detalle
			$this->SetFont('Arial','',8);
			for($i=0;$i<count($header_det);$i++)
			$this->Cell($wdet[$i],7,$header_det[$i],1,0,'C',1);
			$this->Ln();

			$this->SetFont('Arial','',7);
			foreach($detalle as $row)
			{
				$this->Cell($wdet[0],4,$cont,'LTRB',0,'C',$fill);
				$this->Cell($wdet[1],4,$row[3],'LTRB',0,'L',$fill);
				$this->Cell($wdet[2],4,$row[4],'LTRB',0,'L',$fill);
				$this->Cell($wdet[3],4,$row[5],'LTRB',0,'L',$fill);
				$this->Cell($wdet[4],4,round($row[6]*100)/100,'LTRB',0,'R',$fill);
				$this->Cell($wdet[5],4,round($row[7]*100)/100,'LTRB',1,'R',$fill);
				$cont=$cont+1;
			}


		}


		/*if($tipo=="raiz"){
		for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,$header[$i],1,0,'C',1);
		$this->Ln();
		//Restauración de colores y fuentes
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('Arial','',8);
		//Datos
		$fill=0;
		//$CustomCantidad= new rcm_cls_CustomDBAlmacenes();

		foreach($data as $row)
		{
		if($row["tipo"]=="item"){

		$this->Cell($w[0],6,$row[3],'LTRB',0,'L',$fill);
		$this->Cell($w[1],6,$row[4],'LTRB',0,'L',$fill);
		$this->Cell($w[2],6,$fecha,'LTRB',0,'L',$fill);
		}
		else{

		$this->Cell($w[0],6,$row[1],'LTRB',0,'L',$fill);
		$this->Cell($w[1],6,$row[2],'LTRB',0,'L',$fill);
		$this->Cell($w[2],6,$fecha,'LTRB',0,'L',$fill);
		$rama[]=$row["id_tipo_unidad_constructiva"];
		$rama_nombre[]=$row["nombre"];
		$composicion=$row["id_composicion_tuc"];
		$filtro="TUCREEM.id_composicion_tuc=$composicion";
		$sort="TIPOUC.codigo";
		$dir="ASC";
		$CustomReemp=new cls_CustomDBAlmacenes();
		$CustomReemp->ListarTipoUnidadConsReemplazo(15,0,$sort,$dir,$filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$nodes_reemp=$CustomReemp->salida;
		if(sizeof($nodes_reemp!=0)){

		foreach ($nodes_reemp as $reemp){
		$rama[]=$reemp["id_tipo_unidad_constructiva"];
		$rama_nombre[]=$reemp["desc_nombre"];
		$this->Ln();
		$this->Cell($w[0],6,$reemp["desc_tipo_unidad_constructiva"],'LTRB',0,'L',!$fill);
		$this->Cell($w[1],6,$reemp["desc_nombre"],'LTRB',0,'L',!$fill);
		$this->Cell($w[2],6,$fecha,'LTRB',0,'L',!$fill);
		$fill=!$fill;

		}

		}

		}
		$this->Ln();
		$fill=!$fill;



		}
		//////////////////////////////////////////////////
		//////////////////////////////////////////////////

		if(sizeof($rama)!=0){
		$header_item=array('Código','Material','Descripción','Cantidad');
		$i=0;
		foreach ($rama as $id){
		$datos=$this->LoadData($id,"rama");
		$_SESSION['nombre_cabecera']=$rama_nombre[$i];
		$this->AddPage();
		$_SESSION['nombre_pie']=$rama_nombre[$i];
		$this->FancyTable($header_item,$datos,"rama");
		$i=$i+1;

		}

		}

		}
		else{
		for($i=0;$i<count($header);$i++)
		$this->Cell($wi[$i],7,$header[$i],1,0,'C',1);
		$this->Ln();
		//Restauración de colores y fuentes
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('Arial','',8);
		//Datos
		$fill=0;
		foreach($data as $row)
		{
		$this->Cell($wi[0],6,$row[3],'LTRB',0,'L',$fill);
		$this->Cell($wi[1],6,$row[4],'LTRB',0,'L',$fill);
		$this->Cell($wi[2],6,$row[6],'LTRB',0,'L',$fill);
		$this->Cell($wi[3],6,$row[8],'LTRB',0,'R',$fill);
		//$this->Cell($wi[4],6,$row[8]*$row[11],'LTRB',0,'R',$fill);
		$this->Ln();
		$fill=!$fill;
		}
		}*/


	}

}

$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
//Títulos de las columnas
$header=array('Nro.','Unidad Constructiva','Componente','Cantidad');
$header_det=array('Nro.','Código','Material','Descripción','Cant.x Comp.','Cant.Entregada');

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
//$pdf->FancyTable($data,$header,$header_det);


//$pdf->AddPage();
//$pdf->Maestro($data,'Copia Almacén');
//$pdf->FancyTable($data,$header,$header_det);
//$pdf->AddPage();
//$pdf->Maestro($data,'Copia Interesado');
//$pdf->FancyTable($data,$header,$header_det);
//$pdf->AddPage();
//$pdf->Maestro($data,'Copia Supervisor');
//$pdf->FancyTable($data,$header,$header_det);
$pdf->Output();
?>