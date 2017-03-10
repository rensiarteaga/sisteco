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
		$data=$this->LoadData();
		
		$this->SetLeftMargin(15);
		$fill=true;
		$funciones = new funciones();
		//Logo
		$this->SetLineWidth(.1);
		$this->SetDrawColor(190,190,190);
		$this->SetFont('Arial','B',9);
		
		$this->Cell(48,5,'','LRT',0,'C');
		$this->Cell(96,5,'','LRT',0,'C');
		$this->Cell(26,5,'Número: ','LTB',0,'R');
		$this->Cell(20,5,'' .$data[0]['correlativo_sal'],'RTB',0,'L');
		$this->Ln(5);
		
		$this->Image('../../../../lib/images/logo_reporte.jpg',20,16,36,13);
	
        $this->Cell(48,5,'','LR',0,'C');
		$this->Cell(96,5,'','LR',0,'C');
		$this->Cell(26,5,'Fecha: ','LTB',0,'R');
		$this->Cell(20,5,''.$data[0]['fecha'],'RTB',0,'L');
		$this->Ln(5);
		
		$this->Cell(48,5,'','LRB',0,'C');
		$this->Cell(96,5,'','LRB',0,'C');
		$this->Cell(26,5,'Página: ','LTB',0,'R');
		$this->Cell(20,5,''.$this->PageNo() .' de {nb}','RTB',0,'L');
		$this->Ln(5);
		
		//Imprime el título del detalle
			$this->SetFont('Arial','B',12);
			$this->SetY(13);
			$this->Cell(190,13,' VALE DE SALIDA DE MATERIALES',0,0,'C');
			$this->Ln(7);
			$this->Cell(190,10,$data[0]['desc_almacen'],0,0,'C');
			$this->Ln(12);
			$this->SetFont('Arial','',10);
            
			$this->Cell(40,5,'',0,0,'L');
			$this->Ln(4);
			
		
	}

	//Pie de página
	function Footer()
	{
		//Posición: a 1,5 cm del final
		$this->SetY(-40);
		//Arial italic 8
		$this->SetFont('Arial','',7);

		$this->Cell(64,6,'','LRT',0,'C',$fill);
		$this->Cell(62,6,'','LRT',0,'C',$fill);
		$this->Cell(64,6,'','LRT',0,'C',$fill);
		$this->Ln(6);
		$this->Cell(64,6,'','LR',0,'C',$fill);
		$this->Cell(62,6,'','LR',0,'C',$fill);
		$this->Cell(64,6,'','LR',0,'C',$fill);
		$this->Ln(6);

		$this->Cell(64,6,strtoupper($this->datos[0]['almacenero']),'LRB',0,'C',$fill);
		$this->Cell(62,6,'','LRB',0,'C',$fill);
		$this->Cell(64,6,strtoupper($this->datos[0]['receptor']),'LRB',0,'C',$fill);
		$this->Ln(6);

		
		$this->Cell(64,5,'CI: '.$this->datos[0]['almacenero_doc_id'],'LR',0,'C',$fill);
		$this->Cell(62,5,'','LR',0,'C',$fill);
		$this->Cell(64,5,'CI: '.$this->datos[0]['receptor_ci'],'LR',0,'C',$fill);
		$this->Ln(5);

	
		$this->Cell(64,6,'ENTREGUÉ CONFORME','LRB',0,'C',fill);
		$this->Cell(62,6,'','LRB',0,'C',$fill);
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
		$sortcol='ALMACE.nombre';
		$sortdir='asc';
		//$criterio_filtro="";
		$criterio_filtro=' SALIDA.id_salida = '.$_SESSION["rep_mat_id_salida"];
		//Leer las líneas del fichero
		$Custom=new cls_CustomDBAlmacenes();
		$Custom->PedidoMaterialesSimplificado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

		$resp=$Custom->salida;
		$this->datos=$resp;

		return $resp;
	}

	function Maestro($data,$titulo_copia,$header,$header_det)
	{
		$this->imprimir_footer=1;
		$this->SetFont('Arial','B',12);
		$this->FancyTable($data,$header,$header_det);
		
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
		$this->SetLineWidth(.1);
		$this->SetFont('','',10);
		
		//Cabecera
		
		$wdet=array(10,38,12,10,10,90,20);
		$rama=array();
		$rama_nombre=array();
		$fecha=date("d-m-Y");
		

		// Se imprime el detalle de cada pedido simplificado
		foreach($data as $row)
		{
			$imprimir_footer=0;
			$cont=1;
			$cant=100000;
			$puntero=0;
			$fill=true;
			$sortcol='SALDET.id_salida_detalle asc';
			$sortdir='asc';
			$criterio_filtro=' SALDET.id_salida = '.$_SESSION["rep_mat_id_salida"];
			
			$Det=new cls_CustomDBAlmacenes();
			$Det->PedidoMaterialesSimplificadoDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
			$detalle=$Det->salida;
			if($prim_hoja!=1)
			{
				
				$this->AddPage();
				$this->Ln(4);
			}

			
			$this->SetFont('Arial','',10);
            
			//$this->Cell(10,5,'',0,0,'L');
						
			$this->Cell(33,5,'Solicitante: ',0,0,'R');
						    
			$this->SetFont('Arial','B',10);
			$this->Cell(140,5,''.$data[0]['solicitante'],'LTRB',0,'L');
			$this->SetFont('Arial','',10);
			$this->Ln(6);
			
			$this->Cell(33,5,'Almacén Lógico:',0,0,'R');
			
			$this->SetFont('Arial','B',10);
			$this->Cell(96,5,''.$data[0]['almacen_log'],0,0,'L');
			$this->SetFont('Arial','',10);
			$this->Ln(4);
			
			$this->Cell(33,5,'Receptor autorizado:',0,0,'R');
			
			$this->SetFont('Arial','B',10);
			$this->Cell(96,5,''.$data[0]['receptor'],0,0,'L');
			$this->SetFont('Arial','',10);
			
			$this->Cell(26,5,'Imputación: ',0,0,'R');
			$this->SetFillColor(224,235,255);
			$this->Cell(30,5,''.$data[0]['codigo_proyecto'],'LRTB',0,'C',$fill);
			$this->SetFillColor(255,255,255);
			
			$this->Ln(4);
			
			$this->Cell(33,5,'Destino del Material:',0,0,'R');
			
			$this->SetFont('Arial','B',10);
			$this->Cell(96,5,''.$data[0]['tramo'],0,0,'L');
			$this->SetFont('Arial','',10);
			$this->Ln(4);
			
			$this->Cell(33,5,'Motivo de Salida:',0,0,'R');
			
			$this->SetFont('Arial','B',10);
			$this->Cell(96,5,''.$data[0]['motivo_sal'],0,0,'L');
			$this->SetFont('Arial','',10);
						
			$this->Cell(26,5,'Nro Contrato.:',0,0,'R');
            
			$this->SetFillColor(224,235,255);
			$this->Cell(30,5,''.$data[0]['num_contrato'],'LTRB',1,'C',$fill);
			$this->SetFillColor(255,255,255);
			$this->Ln(4);
			
			if(count($detalle)>1)
			{
				//$this->Ln(2);
				//$this->Cell(120,10,$detalle[0]['supergrupo'] ,0,1,'L');
			}
			//Imprime los rótulos del detalle
			$this->SetFont('Arial','B',6);
			
			for($i=0;$i<count($header_det);$i++)
			$this->Cell($wdet[$i],5,$header_det[$i],1,0,'C',1);
			$this->Ln();

			    $this->SetFont('Arial','',6);
			    $cant_total=0;
		        $peso_total=0;
			    $cont=0;
				//$wdet=array(10,38,15,15,92,20);
		        $this->SetFont('Arial','',6);
                $this->SetWidths(array(10,38,12,10,10,90,10,18,20));
                $this->SetVisibles(array(1,1,1,1,1,1,0,0,1));
                $this->SetAligns(array('C','L','R','C','C','L','R','R','R'));
                $this->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
                $this->SetFontsSizes(array(5,6,6,6,6,6,6,6,6));
                $this->SetSpaces(array(3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5));
                $this->SetDecimales(array(0,0,2,0,0,0,0,0,2));

		
		        for ($i=0;$i<sizeof($detalle);$i++){
 	            $cont=$i+1;
 	            $this->MultiTabla(array_merge((array)$cont,(array)$detalle[$i]),2,3,4,6);
          
                }
                
                foreach($detalle as $row)
		         {
			
			     //Actualiza los datos auxiliares
			     $cant_total+=$row['cant_entregada'];
			     $peso_total+=$row['peso_neto'];
			     //$cont=$cont+1;
			    // $this->fill++;
		         }
			
			
			//Define que no es la primera página
			$prim_hoja=0;


		}
		
		//Imprime el total de las cantidades
		$this->SetFont('Arial','B',7);
		$this->Cell($wdet[0],3.5,'','LB',0,'C');
		$this->Cell($wdet[1],3.5,'TOTALES ','B',0,'L');
		$this->Cell($wdet[2],3.5,number_format($cant_total,2,$this->sep_decim,$this->sep_mil),'B',0,'R');
		$this->Cell($wdet[3],3.5,'','B',0,'R');
		$this->Cell($wdet[4],3.5,'','B',0,'R');
		$this->Cell($wdet[5],3.5,'','B',0,'R');
		$this->Cell($wdet[6],3.5,number_format($peso_total,5,$this->sep_decim,$this->sep_mil),'BR',1,'R');
		
		//Imprime las observaciones si es que hubieran
		$this->SetFont('Arial','',6);
		$this->Cell(190,3.5,'Observaciones:','LRT',1,'L',$fill);
		$this->MultiCell(190,3.5,$data[0]['observaciones'],'LBR',1,'L',$fill);




	}


}

$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
//Títulos de las columnas
$header=array('Nro.','Unidad Constructiva','Componente','Cantidad');
//$header_det=array('Nro.','Código','Material','Descripción','Cant.x Comp.','Cant.Entregada');
$header_det=array('Nro.','Código Material','Cantidad','Unidad','Calidad','Descripción  del Material','Peso Neto (Kg)');

//Carga de datos
$tipo=$tipo;
$data=$pdf->LoadData();
//$detalle=$pdf->Detalle();
//echo json_encode($tipo_torre);
$pdf->SetFont('Arial','',10);
$pdf->SetAutoPageBreak(1,48);
$pdf->SetTopMargin(15);
$pdf->SetRightMargin(15);
$pdf->SetLeftMargin(15);
$pdf->AddPage();
$pdf->Maestro($data,'',$header,$header_det);
$pdf->Output();
?>