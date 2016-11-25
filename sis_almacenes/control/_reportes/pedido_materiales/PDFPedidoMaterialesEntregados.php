<?php
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
include_once("../../rac_LibModeloAlmacenes.php");

class PDF extends FPDF
{
	var $datos;
	var $imp_cols;//1: imprimir, 0: no imprimir
	var $widths_det=array();
	var $header_det=array();

	function Header()
	{
		global $title;
		//$data=$this->LoadData();
		$this->SetFont('Arial','',10);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(190,190,190);
		$this->SetLineWidth(.2);
		$this->SetFont('','',10);

		$this->SetLeftMargin(15);
		$fill=true;
		$funciones = new funciones();
		//Logo
		$this->Image('../../../../lib/images/logo_reporte.jpg',20,11,36,13);
		$this->Ln(5);
		
		$this->SetFont('Arial','B',9);
		
		
		$this->Cell(46,5,'','LRT',0,'C');
		$this->Cell(106,5,'','LRT',0,'C');
		$this->Cell(20,5,'Número: ','LTB',0,'R');
		$this->Cell(20,5,$this->datos[0]['correlativo_sal'],'RTB',0,'L');
		$this->Ln(5);
		
        $this->Cell(46,5,'','LR',0,'C');
		$this->Cell(106,5,'','LR',0,'C');
		$this->Cell(20,5,'Fecha: ','LTB',0,'R');
		$this->Cell(20,5,$this->datos[0]['fecha'],'RTB',0,'L');
		$this->Ln(5);
		
		$this->Cell(46,5,'','LRB',0,'C');
		$this->Cell(106,5,'','LRB',0,'C');
		$this->Cell(20,5,'Página: ','LTB',0,'R');
		$this->Cell(20,5,''.$this->PageNo() .' de {nb}','RTB',0,'L');
		$this->Ln(5);
		
		//Imprime el título del detalle
			$this->SetFont('Arial','B',12);
			$this->SetY(9);
			$this->Cell(46,5,'',0,0,'C');
			$this->Cell(106,13,' VALE DE SALIDA DE MATERIALES',0,0,'C');
			$this->Ln(7);
			$this->Cell(46,5,'',0,0,'C');
			$this->Cell(106,10,$this->datos[0]['desc_almacen'],0,0,'C');
			$this->Ln(12);

		//Imprime las columnas si la bandera está encendida
		if($this->imp_cols==1){
			$this->SetFont('Arial','B',6);
			for($i=0;$i<count($this->header_det);$i++)
			$this->Cell($this->widths_det[$i],5,$this->header_det[$i],1,0,'C',1);
			$this->Ln();
		}
	}

	//Pie de página
	function Footer()
	{
		//Posición: a 1,5 cm del final
		$this->SetY(-35);
		//Arial italic 8
		$this->SetFont('Arial','',7);

		$this->Cell(64,6,'','LRT',0,'C',$fill);
		$this->Cell(64,6,'','LRT',0,'C',$fill);
		$this->Cell(64,6,'','LRT',0,'C',$fill);
		$this->Ln(6);
		$this->Cell(64,6,'','LR',0,'C',$fill);
		$this->Cell(64,6,'','LR',0,'C',$fill);
		$this->Cell(64,6,'','LR',0,'C',$fill);
		$this->Ln(6);

		$this->Cell(64,6,strtoupper($this->datos[0]['almacenero']),'LRB',0,'C',$fill);
		$this->Cell(64,6,'','LRB',0,'C',$fill);
		$this->Cell(64,6,strtoupper($this->datos[0]['receptor']),'LRB',0,'C',$fill);
		$this->Ln(6);


		$this->Cell(64,5,'CI: '.$this->datos[0]['almacenero_doc_id'],'LR',0,'C',$fill);
		$this->Cell(64,5,'','LR',0,'C',$fill);
		$this->Cell(64,5,'CI: '.$this->datos[0]['receptor_ci'],'LR',0,'C',$fill);
		$this->Ln(5);


		$this->Cell(64,6,'ENTREGUÉ CONFORME','LRB',0,'C',fill);
		$this->Cell(64,6,'','LRB',0,'C',$fill);
		$this->Cell(64,6,'RECIBÍ CONFORME','LRB',0,'C',fill);

		$this->Ln(6);

		//Número de página
		$fecha=date("d-m-Y");
		//hora
		$hora=date("H:i:s");
	}

	function LoadData()
	{
		$cant=100000;
		$puntero=0;
		//$sortcol='TIPOUC.nombre';
		$sortcol='TIPOUC.observaciones,TIPOUC.nombre';
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

	function LoadDetalle()
	{      // $cont=1;
		$cant=100000;
		$puntero=0;
		$fill=true;
		$sortcol='i.id_supergrupo, i.nombre asc';
		$sortdir='asc';
		$criterio_filtro=' sd.id_salida = '.$_SESSION["rep_mat_id_salida"].' ';

		$Det=new cls_CustomDBAlmacenes();
		$Det->PedidoMaterialesUCDetEntregados($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$detalle=$Det->salida;

		//echo $this->detalle;
		//exit;
		return $detalle;
	}


	function Maestro($data,$titulo_copia,$header,$header_det)
	{
		//$this->imprimir_footer=1;

		$this->SetFont('Arial','B',12);

		$this->FancyTable($data,$header,$header_det);

	}

	function Datos_Cab($padre,$hijo)
	{
		$this->imp_cols=0;
		$fill=true;
		$this->SetFont('Arial','',10);

		$this->Cell(46,5,'',0,0,'L');


		$this->Cell(25,5,'Solicitante:',0,0,'R');

		$this->SetFont('Arial','B',9);
		$this->Cell(81,4,''.$padre[7],'LTRB',0,'C');
		$this->SetFont('Arial','',9);
		$this->Ln(4);
		
		$this->Cell(46,5,'Almacén Lógico:',0,0,'R');

		$this->SetFont('Arial','B',9);
		$this->Cell(55,5,''.$padre[21],0,0,'L');// falta la consulta
		$this->SetFont('Arial','',9);
		$this->Ln(4);

		$this->Cell(46,5,'Receptor Autorizado:',0,0,'R');

		$this->SetFont('Arial','B',9);
		$this->Cell(55,5,''.$padre[1],0,0,'L');
		$this->SetFont('Arial','',9);
		
		$this->Cell(25,5,'Imputación:',0,0,'R');

		$this->SetFont('Arial','B',9);
		$this->Cell(13,4,''.$padre[23],'LTBR',0,'C');
		$this->SetFont('Arial','',9);
		
		$this->Ln(4);
		
		$this->Cell(46,5,'Destino del Material:',0,0,'R');


		$this->SetFont('Arial','B',9);
		$this->Cell(55,5,''.$padre[15],0,0,'L');
		$this->SetFont('Arial','',9);
		
		$this->Ln(4);
		
		$this->Cell(46,5,'Motivo Salida:',0,0,'R');

		$this->SetFont('Arial','B',9);
		$this->Cell(55,5,''.$padre[22],0,0,'L');
		$this->SetFont('Arial','',9);
		
		$this->Cell(25,5,'Nro. Contrato:',0,0,'R');

		$this->SetFont('Arial','B',9);
		$this->Cell(13,4,''.$padre[14],'LTBR',0,'C');
		$this->SetFont('Arial','',9);
		
		$this->Ln(4);

		$this->Cell(46,5,'Unidad Constructiva:',0,0,'R');


		$this->SetFont('Arial','B',9);
		$this->Cell(55,5,''.$hijo['desc_uc_padre'],0,0,'L');
		$this->SetFont('Arial','',9);
		
		$this->Cell(38,5,'',0,0,'R');
		$this->Cell(33,5,'Cantidad Solicitada:',0,0,'R');

		$this->SetFillColor(224,235,255);
		$this->Cell(20,4,''.round($hijo['cantidad_uc'] * 100)/100,'LTRB',0,'C',$fill);//,'LR',0,'C'); round(valor_float * 100) / 100
		$this->SetFillColor(255,255,255);
		$this->Ln(2);

		$this->Ln(4);
		$this->Cell(46,5,'Componente:',0,0,'R');

		$this->SetFont('Arial','B',9);
		$this->Cell(55,5,''.$hijo['desc_uc'],0,0,'L');
		$this->SetFont('Arial','',9);

		$this->Cell(38,5,'',0,0,'R');
		$this->Cell(33,5,'Estructura Nro.:',0,0,'R');

		$this->SetFillColor(224,235,255);
		$this->Cell(20,4,''.$padre['uc'],'LTRB',1,'C',$fill);
		$this->SetFillColor(255,255,255);
		$this->imp_cols=1;
	}

	//Tabla coloreada
	function FancyTable($data,$header,$header_det)
	{
		$prim_hoja=1;

		//Colores, ancho de línea y fuente en negrita
		//$this->SetY(-40);
		$this->SetFont('Arial','',10);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(190,190,190);
		$this->SetLineWidth(.2);
		$this->SetFont('','',10);

		//Cabecera

		$wdet=array(6,25,15,15,10,10,58,13,10,10,20);

		$fecha=date("d-m-Y");
		
		$detalle = $this->LoadDetalle();

		// Se imprime el detalle de cada UC solicitada
		if($prim_hoja!=1)
		{
				$this->imp_cols=0;
			$this->AddPage();
		}
		// datos de la cabecera
		$this->Datos_Cab($data[0], $detalle[0]);

		if(count($detalle)>1)
		{

			//$this->Ln(2);
			$this->Cell(120,10,$detalle[0]['supergrupo'] ,0,1,'L');
		}
		//Imprime los rótulos del detalle
		$this->SetFont('Arial','B',6);

		for($i=0;$i<count($header_det);$i++)
		$this->Cell($wdet[$i],5,$header_det[$i],1,0,'C',1);
		$this->Ln();

		$this->SetFont('Arial','',6);
		$id_supergrupo=0;
		$peso=0;

		foreach($detalle as $row1)
		{
			if($cont==1){
				$id_supergrupo=$row1['id_supergrupo'];

			}
			if($id_supergrupo!=$row1['id_supergrupo']&&$cont>1){
				//Imprime el total del peso
				$this->SetFont('Arial','B',6);
				$this->Cell(139,5,'',0,0,'R');
				$this->Cell(13,4,number_format($peso,5,$this->sep_decim,$this->sep_mil),'',0,'R');
				$this->Cell(13,4,' Kg.','',1,'L');
				$peso=0;

				//Para separar por páginas los materiales por supergrupo
				$this->imp_cols=0;
				$this->AddPage();

				$id_supergrupo=$row1['id_supergrupo'];
				$cont=1;

				//datos de la cabecera
				$this->Datos_Cab($row,$row1);

				$this->Cell(120,10,$row1['supergrupo'] ,0,1,'L');
				//Imprime los encabezados
				$this->SetFont('Arial','B',6);
				for($i=0;$i<count($header_det);$i++)
				$this->Cell($wdet[$i],5,$header_det[$i],1,0,'C',1);
				$this->Ln();
			}

			$this->SetFont('Arial','',6);

			//Forma el array para mandar al multitabla
			$fila=array();
			$fila[0]=$cont;
			$fila[1]=$row1['nombre'];
			$fila[2]=round($row1['cant_unit_uc']*100)/100;
			$fila[3]=round($row1['peso_kg'],5);
			$fila[4]=$row1['unidad_medida'];
			$fila[5]=$row1['calidad'];
			$fila[6]=$row1['descripcion'];
			//$fila[7]=round($row1['peso_total']*100)/100;
			$fila[7]=round($row1['peso_total'],5);
			$fila[8]=round($row1['cantidad_total'],2);
			$fila[9]=round($row1['cant_demasia'],2);
			$fila[10]=round($row1['cantidad_total_dem'],2);

			/*echo"<pre>";
			print_r($fila);
			echo"</pre>";*/


			//$wdet=array(6,23,15,15,10,10,58,13,10,10,20);
			$this->SetFont('Arial','',6);
			$this->SetWidths(array(6,25,15,15,10,10,58,13,10,10,20));
			$this->SetVisibles(array(1,1,1,1,1,1,1,1,1,1,1));
			$this->SetAligns(array('C','L','R','R','C','C','L','R','R','R','R'));
			$this->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
			$this->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6));
			$this->SetFontsStyles(array('','','','','','','','','','',''));
			$this->SetSpaces(array(4,4,4,4,4,4,4,4,4,4,4));
			$this->SetDecimales(array(0,0,0,3,0,0,0,3,2,2,2));

			$this->MultiTabla($fila,2,3,4,6);
			$peso+=$row1['peso_total'];
			$cont++;

		}
		//Imprime el total del último grupo
		//Imprime el total del peso
		$this->SetFont('Arial','B',6);
		$this->Cell(139,5,'',0,0,'R');
		$this->Cell(13,4,number_format($peso,3,$this->sep_decim,$this->sep_mil),'',0,'R');
		$this->Cell(13,4,' Kg.','',1,'L');

		//Define que no es la primera página
		$prim_hoja=0;
		

	}


}

$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',10);
$pdf->SetAutoPageBreak(1,35);
$pdf->SetTopMargin(5);
$pdf->SetRightMargin(15);
$pdf->SetLeftMargin(15);

//Títulos de las columnas
$header=array('Nro.','Unidad Constructiva','Componente','Cantidad');
$header_det=array('Nro.','Material','Cant.x Comp.','Peso Unitario','Unidad','Calidad','Descripción  del Material','Peso Total','Cantidad','Demasía','Cant. Entregada');

$pdf->widths_det=array(6,25,15,15,10,10,58,13,10,10,20);;
$pdf->header_det=$header_det;

//Carga los datos
$pdf->LoadData();
$pdf->imp_cols=0;

//COnstruye el pdf
$pdf->AddPage();
$pdf->Maestro($pdf->datos,'',$header,$header_det);

//Despliega el pdf
$pdf->Output();
?>