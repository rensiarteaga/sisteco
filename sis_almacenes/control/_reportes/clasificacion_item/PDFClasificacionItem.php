<?php
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
include_once("../../LibModeloAlmacenes.php");

class PDF extends FPDF
{
	//Cargar los datos
	//Cabecera de página
	var $fil=10;//contador de las filas para controlar el corte de páginas (saltos de páginas)
	var $inicio_pag=false;//para definir si se requiere línea superior en los datos impresos
	
	var $sep_decim='.';
	var $sep_mil=',';


	function Header()
	{
		global $title;
		$data1=$this->LoadData();

		$imprimir_footer=1;
		$this->SetLeftMargin(15);
		$funciones = new funciones();
		$fecha=date("d-m-Y");
		//Logo
		$this->Image('../../../../lib/images/logo_reporte.jpg',173,2,36,13);
		//Arial bold 15
		$this->SetFont('Arial','B',16);
		$this->SetY(20);
		//Movernos a la derecha
		$this->Cell(185,13,'FORM. DE RECEPCIÓN DE MATERIALES',0,0,'C');
		//$this->Cell(185,13,'FORM. DE DEVOLUCIÓN DE MATERIALES',0,0,'C');
		/*$this->Ln(5);
		$this->SetFont('Arial','B',12);
		$this->Cell(185,13,$data1[0]['nombre_almacen'],0,0,'C');
		$this->SetY(18);
		$this->SetX(168);
		$this->Cell(60,13,'Nro.: ' .$data1[0][1],0,0,'L');
		$this->Ln(5);
		$this->SetX(168);
		//$this->Cell(60,13,'Fecha: '.$data1[0]['fecha_reg'],0,0,'L');
		$this->Cell(60,13,'Fecha: '.$data1[0]['fecha_finalizado_cancelado'],0,0,'L');
		$this->Ln(5);*/
		$this->SetX(168);
		$this->Cell(60,13,'Página: '.$this->PageNo(),0,0,'L');
		$this->Ln(15);
	}

	//Pie de página
	function Footer()
	{
		//Posición: a 1,5 cm del final
		$this->SetY(-40);
		//Arial italic 8
		$this->SetFont('Arial','',8);
		//ip
		$ip = captura_ip();

		//$data1=$this->LoadData();
		

		//$this->SetX(0);
		$this->Cell(64,6,'','LRT',0,'C',$fill);
		$this->Cell(64,6,'','LRT',0,'C',$fill);
		$this->Cell(64,6,'','LRT',0,'C',$fill);
		$this->Ln(6);
		$this->Cell(64,6,'','LR',0,'C',$fill);
		$this->Cell(64,6,'','LR',0,'C',$fill);
		$this->Cell(64,6,'','LR',0,'C',$fill);
		/*$this->Ln(6);
		$this->Cell(64,6,$data1[0]['almacenero'],'LRB',0,'C',$fill);
		//$this->Cell(64,6,$data1[0]['jefe_almacen'],'LRB',0,'C',$fill);
		$this->Cell(64,6,'','LRB',0,'C',$fill);
		$this->Cell(64,6,$data1[0]['jefe_almacen'],'LRB',0,'C',$fill);
		$this->Ln(6);
		
		$this->Cell(64,5,'C.I.:  '.$data1[0]['doc_almacenero'],'LR',0,'C',$fill);
		$this->Cell(64,5,'','LR',0,'C',$fill);
		$this->Cell(64,5,'C.I.:  '.$data1[0]['doc_jefe_almacen'],'LR',0,'C',$fill);
		$this->Ln(5);*/
		

		$this->Cell(64,6,'Encargado de Almacén','LRB',0,'C',$fill);
		//$this->Cell(64,6,'Jefe de Almacenes','LRB',0,'C',$fill);
		$this->Cell(64,6,'','LRB',0,'C',$fill);
		$this->Cell(64,6,'Jefe de Almacenes','LRB',0,'C',$fill);
		$this->Ln(6);

		
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
	function LoadData()
	{
		$cant=100000;
		$puntero=0;
		$sortcol='SUPGRUP.codigo_super';
		$sortdir='asc';
		$criterio_filtro=' SUPGRUP.id_supergrupo = '.$_SESSION["id_supergrupo"];
		/*echo "query: ".$sortcol;
		exit;
		*/
		/*echo "query: ".$criterio_filtro;
		exit;*/
		//Leer las líneas del fichero
		$Custom=new cls_CustomDBAlmacenes();
		//$Custom->ListarItemReporte($criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
        
		$Custom->ListarItemReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		
		$resp=$Custom->salida;

		return $resp;
	}

	function Maestro($data)
	{
		$this->AddPage();
		$this->SetFont('Arial','',10);
		//$this->Cell(120,10,'Proveedor:   '.$data[0]['origen'],0,0,'L');//,'LR',0,'C');
		//$this->Cell(120,10,'Contratista:   '.$data[0][5],0,0,'L');//,'LR',0,'C');
		$this->Ln(5);
		//$this->Cell(120,10,'Concepto:   '.$data[0]['descripcion'],0,0,'L');//,'LR',0,'C');
		$this->Ln(5);
		//$this->Cell(120,10,'Entregado por:   '.$data[0]['responsable'],0,0,'L');//,'LR',0,'C');
		$this->Ln(5);
		//$this->Cell(120,10,'Nro. Remisión:   '.$data[0]['num_factura'],0,0,'L');//,'LR',0,'C');
		//$this->Ln(5);
		$this->SetX(130);
		//$this->Cell(120,10,'Fecha Remisión:   '.$data[0]['fecha_factura'],0,0,'L');//,'LR',0,'C');
		$this->Ln(5);
		//$this->Cell(120,10,'Fecha de Ingreso Almacén:   '.$data[0]['fecha_finalizado_cancelado'],0,0,'L');//,'LR',0,'C');
		$this->Ln(10);
	}

	//Tabla coloreada
	function FancyTable($data,$header,$header_det)
	{
		//Contador
		$cont=1;
               
		$this->SetFont('Arial','',7);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(190,190,190);
		$this->SetLineWidth(.1);
		$this->SetFont('','',8);
		//Cabecera
		//$w=array(6,30,13,10,11,84,20,18);
		$w=array(6,30,13,10,11,100,22);
		//$w=array(25,20,20,40,60,30);
		//('Código','Cantidad','Unidad','Calidad','Descripción del Material','Peso Neto (kg)');
		$wi=array(35,60,60,30);
		$wdet=array(6,20,45,80,20,20);
		$rama=array();
		$rama_nombre=array();
		$fecha=date("d-m-Y");

		//print ('<pre>');
		//print_r($header);
		//print ('</pre>');
		//$this->SetY(30);

		//Imprime los rótulos de las columnasis
		$this->SetFont('Arial','B',7);
		for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],5,$header[$i],1,0,'C',1);
		$this->Ln();


		$cant=100000;
		$puntero=0;
		//$sortcol='ITEM.id_supergrupo asc, ITEM.nombre_item asc';
		//$sortdir='asc';
		//$criterio_filtro=' INGDET.id_ingreso = '.$_SESSION["rep_ing_id_ingreso"];
		/*echo "query: ".$criterio_filtro;
		exit;*/
		//Leer las líneas del fichero
		$Custom=new cls_CustomDBAlmacenes();
		$Custom->ListarIngresoDetalleReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

		$resp=$Custom->salida;

		$this->SetFont('Arial','',6);
		//Se imprime los datos del reporte
		$cant_total=0;
		$peso_total=0;
		$tot=count($resp);

		foreach($resp as $row)
		{
			//Verifica si es el último registro para dibujar la línea inferior
			/*if($cont==$tot){
				//Por ser último registro, se pone como 51 la variable fil para que dibuje la línea inferior
				$this->fil=51;
			}

			//Verifica si es la última línea de la página
			if($this->fil>50){
				//Imprime la línea inferior
				$this->Cell($w[0],3.5,$cont,'LBR',0,'C',$fill);//LTRB
				$this->Cell($w[1],3.5,$row[0],'LBR',0,'L',$fill);
				$this->Cell($w[2],3.5,$row[3],'LBR',0,'R',$fill);
				$this->Cell($w[3],3.5,$row[5],'LBR',0,'C',$fill);
				$this->Cell($w[4],3.5,$row[7],'LBR',0,'C',$fill);
				$this->Cell($w[5],3.5,$row[8],'LBR',0,'L',$fill);
				$this->Cell($w[6],3.5,$row[4],'LBR',0,'R',$fill);
				$this->Cell($w[7],3.5,$row[9],'LBR',1,'R',$fill);
				//Inicializa el contador de filas
				$this->fil=1;
				//Notifica que es una página nueva
				$this->inicio_pag=true;
			}
			else {
				if($this->inicio_pag){
					//Por ser inicio de página imprime los rótulos de las columnas
					$this->SetFont('','',8);
					for($i=0;$i<count($header);$i++)
					$this->Cell($w[$i],5,$header[$i],1,0,'C',1);
					$this->Ln();
					$this->inicio_pag=false;
					$this->SetFont('','',6);
				}*/
				//Imprime los datos solo con líneas de la izquierda y derecha
				$this->Cell($w[0],3.5,$cont,'LTBR',0,'C',$fill);
				$this->Cell($w[1],3.5,$row[0],'LTBR',0,'L',$fill);
				//$this->Cell($w[2],3.5,$row[3],'LTBR',0,'R',$fill);
				$this->Cell($w[2],3.5,number_format($row[3],2,$this->sep_decim,$this->sep_mil),'LTBR',0,'R',$fill);
				$this->Cell($w[3],3.5,$row[5],'LTBR',0,'C',$fill);
				$this->Cell($w[4],3.5,$row[7],'LTBR',0,'C',$fill);
				$this->Cell($w[5],3.5,$row[8],'LTBR',0,'L',$fill);
				//$this->Cell($w[6],3.5,$row[4],'LTBR',1,'R',$fill);
				$this->Cell($w[6],3.5,number_format($row[4],5,$this->sep_decim,$this->sep_mil),'LTBR',1,'R',$fill);
				//$this->Cell($w[7],3.5,$row[9],'LTBR',1,'R',$fill);
			//}
			//Actualiza los datos auxiliares
			$cant_total+=$row[3];
			$peso_total+=$row[4];
			$cont=$cont+1;
			$this->fill++;
		}

		//Imprime el total de las cantidades
		$this->SetFont('Arial','B',7);
		$this->Cell($w[0],3.5,'','LB',0,'C',$fill);
		$this->Cell($w[1],3.5,'TOTALES ','B',0,'L',$fill);
		$this->Cell($w[2],3.5,number_format($cant_total,2,$this->sep_decim,$this->sep_mil),'B',0,'R',$fill);
		$this->Cell($w[3],3.5,'','B',0,'R',$fill);
		$this->Cell($w[4],3.5,'','B',0,'R',$fill);
		$this->Cell($w[5],3.5,'','B',0,'R',$fill);
		$this->Cell($w[6],3.5,number_format($peso_total,5,$this->sep_decim,$this->sep_mil),'BR',1,'R',$fill);
		
		
		//Imprime las observaciones si es que hubieran
		$this->SetFont('Arial','',6);
		$this->Cell(192,3.5,'Observaciones:','LR',1,'L',$fill);
		$this->MultiCell(192,3.5,$data[0]['observaciones'],'LBR',1,'L',$fill);

		// Se imprime el detalle de cada UC solicitada
		


	}

	/*function AcceptPageBreak()
	{
	if($this->col>41)
	{

	}
	}*/

}

$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
//Títulos de las columnas
$header=array('Nro.','Código','Cantidad','Unidad','Calidad','Descripción del Material','Peso Neto (kg)');//,'Total Importe');
//$header=array('Código','Cantidad','Unidad','Nombre','Descripción','Peso Neto (kg)');
$header_det=array('Nro.','Código','Material','Descripción','Cant.x Comp.','Cant.Entregada');

//Carga de datos
$tipo=$tipo;
//$data=$pdf->LoadData();
//echo json_encode($tipo_torre);
$pdf->SetFont('Arial','',10);
$pdf->SetAutoPageBreak(1,48);
$pdf->SetTopMargin(15);
$pdf->SetRightMargin(15);
$pdf->SetLeftMargin(15);
//$data=$pdf->LoadData();

//$pdf->AddPage();
//$pdf->Maestro($data);
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