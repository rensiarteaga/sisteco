<?php
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
include_once("../../rcm_LibModeloAlmacenes.php");

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
		$this->SetDrawColor(190,190,190);
		$this->SetLineWidth(.2);

		$imprimir_footer=1;
		$this->SetLeftMargin(15);
		$funciones = new funciones();
		$fecha=date("d-m-Y");
		$wr=array(7,32,13,10,10,98,22);
		$rotulo=array('Nro.','Código','Cantidad','Unidad','Calidad','Descripción del Material','Peso Neto (kg)');//,'Total Importe');
		//Logo
		if($this->PageNo()==1){
					
		$this->SetFont('Arial','B',9);
		$this->Cell(39,5,'','LRT',0,'C');
		$this->Cell(123,5,'','LRT',0,'C');
		$this->Cell(30,5,'Número: '.$data1[0]['correlativo_ing'],'LRTB',0,'L');
		$this->Ln(5);
		
		$this->Image('../../../../lib/images/logo_reporte.jpg',16,11,36,13);
	
		
		$this->Cell(39,5,'','LR',0,'C');
		$this->Cell(123,5,'','LR',0,'C');
		$this->Cell(30,5,'Fecha: '.$data1[0]['fecha_reg'],'LRTB',0,'L');
		$this->Ln(5);
		
		$this->Cell(39,5,'','LRB',0,'C');
		$this->Cell(123,5,'','LRB',0,'C');
		$this->Cell(30,5,'Página: '.$this->PageNo() .' de {nb}','LRTB',0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','B',12);
		$this->SetY(8);
		//Movernos a la derecha
		$this->Cell(39,13,'',0,0,'C');
		$this->Cell(123,13,'FORMULARIO DE INGRESO DE MATERIALES',0,0,'C');
		$this->Ln(6);
		$this->Cell(39,13,'',0,0,'C');
		$this->Cell(123,13,$data1[0]['nombre_almacen'],0,0,'C');
		
		$this->Ln(13);
		}else{
					
		$this->SetFont('Arial','B',9);
		$this->Cell(39,5,'','LRT',0,'C');
		$this->Cell(123,5,'','LRT',0,'C');
		$this->Cell(30,5,'Número: '.$data1[0]['correlativo_ing'],'LRTB',0,'L');
		$this->Ln(5);
		
		$this->Image('../../../../lib/images/logo_reporte.jpg',16,11,36,13);
	
		
		$this->Cell(39,5,'','LR',0,'C');
		$this->Cell(123,5,'','LR',0,'C');
		$this->Cell(30,5,'Fecha: '.$data1[0]['fecha_reg'],'LRTB',0,'L');
		$this->Ln(5);
		
		$this->Cell(39,5,'','LRB',0,'C');
		$this->Cell(123,5,'','LRB',0,'C');
		$this->Cell(30,5,'Página: '.$this->PageNo() .' de {nb}','LRTB',0,'L');
		$this->Ln(5);
		
		$this->SetFont('Arial','B',12);
		$this->SetY(8);
		//Movernos a la derecha
		$this->Cell(39,13,'',0,0,'C');
		$this->Cell(123,13,'FORMULARIO DE INGRESO DE MATERIALES',0,0,'C');
		$this->Ln(6);
		$this->Cell(39,13,'',0,0,'C');
		$this->Cell(123,13,$data1[0]['nombre_almacen'],0,0,'C');
		
		$this->Ln(13);
		//Imprime los rótulos de las columnasis
		$this->SetFont('Arial','B',6);
		for($i=0;$i<count($rotulo);$i++)
		$this->Cell($wr[$i],5,$rotulo[$i],1,0,'C',1);
		$this->Ln();
		
		}
		
		
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

		$data1=$this->LoadData();
		

		//$this->SetX(0);
		$this->Cell(64,6,'','LRT',0,'C',$fill);
		$this->Cell(64,6,'','LRT',0,'C',$fill);
		$this->Cell(64,6,'','LRT',0,'C',$fill);
		$this->Ln(6);
		$this->Cell(64,6,'','LR',0,'C',$fill);
		$this->Cell(64,6,'','LR',0,'C',$fill);
		$this->Cell(64,6,'','LR',0,'C',$fill);
		$this->Ln(6);
		$this->Cell(64,6,$data1[0]['almacenero'],'LRB',0,'C',$fill);
		//$this->Cell(64,6,$data1[0]['jefe_almacen'],'LRB',0,'C',$fill);
		$this->Cell(64,6,'','LRB',0,'C',$fill);
		$this->Cell(64,6,$data1[0]['jefe_almacen'],'LRB',0,'C',$fill);
		//$this->Cell(64,6,'WILDO PAREDES','LRB',0,'C',$fill);
		$this->Ln(6);
		
		$this->Cell(64,5,'C.I.:  '.$data1[0]['doc_almacenero'],'LR',0,'C',$fill);
		$this->Cell(64,5,'','LR',0,'C',$fill);
		$this->Cell(64,5,'C.I.:  '.$data1[0]['doc_jefe_almacen'],'LR',0,'C',$fill);
		//$this->Cell(64,5,'C.I.:              ','LR',0,'C',$fill);
		$this->Ln(5);
		

		$this->Cell(64,6,'Encargado de Registros Almacén','LRB',0,'C',$fill);
		//$this->Cell(64,6,'Jefe de Almacenes','LRB',0,'C',$fill);
		$this->Cell(64,6,'','LRB',0,'C',$fill);
		$this->Cell(64,6,'Encargado  de Almacén','LRB',0,'C',$fill);
		//$this->Cell(64,6,'Contratista','LRB',0,'C',$fill);
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
		$sortcol='TIPOUC.nombre';
		$sortdir='asc';
		$criterio_filtro=' INGRES.id_ingreso = '.$_SESSION["rep_ing_id_ingreso"];
		/*echo "query: ".$criterio_filtro;
		exit;*/
		//Leer las líneas del fichero
		$Custom=new cls_CustomDBAlmacenes();
		$Custom->NotaIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

		$resp=$Custom->salida;

		return $resp;
	}

	function Maestro($data)
	{
		$this->AddPage();
		$fill=true;
		$this->SetFillColor(224,235,255);
		$this->SetFont('Arial','',10);
		$this->SetDrawColor(190,190,190);  
		$this->SetLineWidth(.2);
		//$this->Cell(120,10,'Origen Ingreso:   '.$data[0]['origen'],0,0,'L');//,'LR',0,'C');
		
		$this->Cell(38,6,'Origen Ingreso: ',0,0,'R');						
		
		$this->SetFont('Arial','B',10);
		$this->Cell(132,6,''.$data[0]['origen'],0,0,'L');
		
		$this->SetFont('Arial','',10);
		$this->Ln(4);
		$this->Cell(38,10,'Almacén Lógico: ',0,0,'R');						
		
		$this->SetFont('Arial','B',10);
		$this->Cell(70,10,''.$data[0]['almacen_log'],0,0,'L');
		
		$this->SetFont('Arial','I',8);
		$this->Cell(53,4,'# Pedido de  Compra: ',0,0,'R');
		
		$this->SetFont('Arial','B',8);
		$this->Cell(30,4,''.$data[0]['nro_pedido_compra'],'BTLR',0,'C');
		
		
		
		
		$this->SetFont('Arial','',10);
		
		$this->Ln(4);
			
		$this->Cell(38,10,'Motivo Ingreso: ',0,0,'R');						
		$this->SetFont('Arial','B',10);
		$this->Cell(70,10,''.$data[0]['motivo_ing'],0,0,'L');
		
		//---------------------
		
		$this->SetFont('Arial','I',8);
		$this->Cell(53,4,'# Contrato/Ord. Compra: ',0,0,'R');
		
		$this->SetFont('Arial','B',8);
		$this->Cell(30,4,''.$data[0]['orden_compra'],'BTLR',0,'C');
		
		
		
		
		//--------------------------
		$this->SetFont('Arial','',10);
		
				
		
		$this->Ln(8);
		
		$this->Cell(38,10,'Concepto: ',0,0,'R');
		//$this->SetY(10);			
		$this->SetFont('Arial','IB',8);
		//$this->Cell(132,10,''.$data[0]['descripcion'],0,0,'C');
		$this->MultiCell(132,5,$data[0]['descripcion'],0,1,'L',$fill);
		$this->SetFont('Arial','',10);
		//$this->Ln(4);	
		
		$this->Cell(38,10,'Entregado por: ',0,0,'R');
						
		$this->SetFont('Arial','B',10);
		$this->Cell(132,10,''.$data[0]['responsable'],0,0,'L');
		$this->SetFont('Arial','',10);
		
		
		$this->Ln(4);
		
		$this->Cell(38,10,'Nro. Remisión: ',0,0,'R');
						
		$this->SetFont('Arial','B',10);
		$this->Cell(67,10,''.$data[0]['num_factura'],0,0,'L');
		$this->SetFont('Arial','',10);
		$this->Cell(65,10,'Fecha Remisión: ',0,0,'R');
		$this->SetFont('Arial','B',10);
		$this->Cell(22,10,''.$data[0]['fecha_factura'],0,0,'L');
		$this->SetFont('Arial','',10);
		$this->Ln(4);
		
		
		
		$this->Cell(38,10,'',0,0,'R');
						
		$this->SetFont('Arial','B',10);
		$this->Cell(67,10,'',0,0,'L');
		$this->SetFont('Arial','',10);
		$this->Cell(65,10,'Fecha de Ingreso: ',0,0,'R');
		$this->SetFont('Arial','B',10);
		$this->Cell(22,10,''.$data[0]['fecha_finalizado_cancelado'],0,0,'L');
		$this->SetFont('Arial','',10);
		//$this->Ln(4);
		
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
		$this->SetLineWidth(.2);
		$this->SetFont('','',8);
		//Cabecera
		//$w=array(6,30,13,10,11,84,20,18);
		$w=array(7,32,13,10,10,98,22);
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
		$this->SetFont('Arial','B',6);
		for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],5,$header[$i],1,0,'C',1);
		$this->Ln();
		


		$cant=100000;
		$puntero=0;
		//$sortcol='ITEM.id_supergrupo asc, ITEM.nombre asc';
		$sortcol='ITEM.id_supergrupo asc,INGDET.id_ingreso_detalle asc';
		//$sortcol='ITEM.nombre desc';
		$sortdir='asc';
		$criterio_filtro=' INGDET.id_ingreso = '.$_SESSION["rep_ing_id_ingreso"];
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
		
			//$this->ImprimirTabla($resp_ing,5,0.6,$header,$w,$a);
		 $this->SetFont('Arial','',6);
		 $w=array(7,32,13,10,10,98,22);
         $this->SetWidths(array(7,32,13,10,10,98,22,15,15,15,15,15));
         $this->SetVisibles(array(1,1,1,1,1,1,1,0,0,0,0,0,0));
         $this->SetAligns(array('C','L','R','C','C','L','R','R','R','R','R','R'));
         $this->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
         $this->SetFontsSizes(array(5,6,6,6,6,6,6,6,6,6,6,6,6));
         $this->SetSpaces(array(3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5));
         $this->SetDecimales(array(0,0,2,0,2,2,2,6,2,2,4,2,2));
         
         /*echo"<pre>";
         print_r($resp);
         echo"</pre>";*/
  			
		
		for ($i=0;$i<sizeof($resp);$i++){
 	        $cont=$i+1;
 	        $this->MultiTabla(array_merge((array)$cont,(array)$resp[$i]),2,3,3.5,6);
            
 	       
          }
          
         

		foreach($resp as $row)
		{
			//Actualiza los datos auxiliares
			$cant_total+=$row['cantidad'];
			$peso_total+=$row['peso_neto'];
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
$pdf->SetAutoPageBreak(1,40);
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(15);
$pdf->SetLeftMargin(15);
$data=$pdf->LoadData();

//$pdf->AddPage();
$pdf->Maestro($data);
$pdf->FancyTable($data,$header,$header_det);

$pdf->Output();
?>