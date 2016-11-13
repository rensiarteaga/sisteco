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
		$this->Image('../../../../lib/images/logo_reporte.jpg',173,8,36,13);
		$this->Ln(5);

		$this->SetFont('Arial','',10);
		$this->SetY(15);
		$this->SetX(175);
		$this->Cell(60,13,'Número: ' .$data[0]['correlativo_sal'],0,0,'L');
		$this->Ln(4);
		$this->SetX(175);
		$this->Cell(60,13,'Fecha: '.$data[0]['fecha'],0,0,'L');
		$this->Ln(4);
		$this->SetX(175);
		$this->Cell(60,13,'Página: '.$this->PageNo() .' de {nb}',0,0,'L');
		$this->Ln(15);
		
		//Imprime el título del detalle
			$this->SetFont('Arial','B',12);
			$this->SetY(10);
			$this->Cell(185,13,' VALE DE SALIDA DE MATERIALES',0,0,'C');
			$this->Ln(6);
			$this->Cell(185,10,$data[0]['desc_almacen'],0,0,'C');//,'LR',0,'C');
			$this->Ln(12);
			$this->SetFont('Arial','',10);
            
			/*$this->Cell(40,5,'',0,0,'L');//,'LR',0,'C');
			$this->Ln(4);
			
			$this->SetFont('Arial','',10);
            
			$this->Cell(40,5,'',0,0,'L');//,'LR',0,'C');
			
			
			$this->Cell(60,5,'Solicitante: ',0,0,'R');//,'LR',0,'C');
			
			$this->SetFont('Arial','B',10);
			$this->Cell(50,5,''.$data[0]['solicitante'],'LTRB',0,'C');//,'LR',0,'C');
			$this->SetFont('Arial','',10);
			$this->Ln(4);
			
			$this->Cell(40,5,'Receptor autorizado: ',0,0,'L');//,'LR',0,'C');
						
			$this->SetFont('Arial','B',10);
			$this->Cell(60,5,''.$data[0]['receptor'],0,0,'L');//,'LR',0,'C');
			$this->SetFont('Arial','',10);
			$this->Ln(4);
			
			$this->Cell(40,5,'Unidad Constructiva:',0,0,'L');//,'LR',0,'C');
			
			
			$this->SetFont('Arial','B',10);
			$this->Cell(60,5,''.$data[0]['desc_uc_padre'],0,0,'L');//,'LR',0,'C');
			$this->SetFont('Arial','',10);
						
			$this->Cell(70,5,'Cantidad Solicitada:',0,0,'R');//,'LR',0,'C'); round(valor_float * 100) / 100
						
			$this->SetFillColor(224,235,255);
			$this->Cell(20,5,''.round($data[0]['cantidad'] * 100)/100,'LTRB',0,'C',$fill);//,'LR',0,'C'); round(valor_float * 100) / 100
			$this->SetFillColor(255,255,255);
			
			$this->Ln(4);
			$this->Cell(40,5,'Componente:',0,0,'L');//,'LR',0,'C');
			
			
			//$this->SetFillColor(224,235,255);
			$this->SetFont('Arial','B',10);
			$this->Cell(60,5,''.$data[0]['desc_uc'],0,0,'L');//,'LR',0,'C');
			//$this->SetFillColor(255,255,255);
			$this->SetFont('Arial','',10);
						
			$this->Cell(70,5,'Torre Nro.:',0,0,'R');//,'LR',0,'C'); round(valor_float * 100) / 100
            
			$this->SetFillColor(224,235,255);
			$this->Cell(20,5,''.$data[0]['uc'],'LTRB',1,'C',$fill);
			$this->SetFillColor(255,255,255);*/
			
	}

	//Pie de página
	function Footer()
	{
		//Posición: a 1,5 cm del final
		$this->SetY(-40);
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
		//$this->Cell(75,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L');
		//$this->Cell(40,10,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		//$this->Cell(47,10,'',0,0,'C');
		//$this->Cell(35,10,'Fecha: '.$fecha ,0,0,'L');
		//$this->ln(3);
		//$this->Cell(75,10,'',0,0,'L');
		//$this->Cell(40,10,'',0,0,'C');
		//$this->Cell(47,10,'',0,0,'C');
		//$this->Cell(35,10,'Hora: '.$hora ,0,0,'L');
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
	
	function LoadDetalle()
	{      // $cont=1;
			$cant=100000;
			$puntero=0;
			$fill=true;
			$sortcol='ITEM.id_supergrupo,COMPON.orden,ITEM.nombre asc';
			$sortdir='asc';
			$criterio_filtro=' OSUCDE.id_salida = '.$_SESSION["rep_mat_id_salida"].' AND OSUCDE.id_tipo_unidad_constructiva = '.$row[6];
			
			$Det=new cls_CustomDBAlmacenes();
			$Det->PedidoMaterialesUCDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
			$detalle=$Det->salida;
		
		$this->detalle=$resp;

		return $resp;
	}
	

	function Maestro($data,$titulo_copia,$header,$header_det)
	{
		//$this->imprimir_footer=1;
				
		$this->SetFont('Arial','B',12);
		
		$this->FancyTable($data,$header,$header_det);
				
	}
		
	function Datos_Cab($data,$detalle)
	{
		    $fill=true;
		    $this->SetFont('Arial','',10);
            
			$this->Cell(40,5,'',0,0,'L');//,'LR',0,'C');
			
			
			$this->Cell(60,5,'Solicitante: ',0,0,'R');//,'LR',0,'C');
			
			$this->SetFont('Arial','B',10);
			$this->Cell(50,5,''.$data[0][7],'LTRB',0,'C');//,'LR',0,'C');
			$this->SetFont('Arial','',10);
			$this->Ln(4);
			
			$this->Cell(40,5,'Receptor autorizado: ',0,0,'L');//,'LR',0,'C');
						
			$this->SetFont('Arial','B',10);
			$this->Cell(60,5,''.$data[0][1],0,0,'L');//,'LR',0,'C');
			$this->SetFont('Arial','',10);
			$this->Ln(4);
			
			$this->Cell(40,5,'Unidad Constructiva:',0,0,'L');//,'LR',0,'C');
			
			
			$this->SetFont('Arial','B',10);
			$this->Cell(60,5,''.$detalle[0]['desc_uc_padre'],0,0,'L');//,'LR',0,'C');
			$this->SetFont('Arial','',10);
						
			$this->Cell(70,5,'Cantidad Solicitada:',0,0,'R');//,'LR',0,'C'); round(valor_float * 100) / 100
						
			$this->SetFillColor(224,235,255);
			$this->Cell(20,5,''.round($detalle[0]['cantidad_uc'] * 100)/100,'LTRB',0,'C',$fill);//,'LR',0,'C'); round(valor_float * 100) / 100
			$this->SetFillColor(255,255,255);
			
			$this->Ln(4);
			$this->Cell(40,5,'Componente:',0,0,'L');//,'LR',0,'C');
			
			
			//$this->SetFillColor(224,235,255);
			$this->SetFont('Arial','B',10);
			$this->Cell(60,5,''.$detalle[0]['desc_uc'],0,0,'L');//,'LR',0,'C');
			//$this->SetFillColor(255,255,255);
			$this->SetFont('Arial','',10);
						
			$this->Cell(70,5,'Torre Nro.:',0,0,'R');//,'LR',0,'C'); round(valor_float * 100) / 100
            
			$this->SetFillColor(224,235,255);
			$this->Cell(20,5,''.$data[0]['uc'],'LTRB',1,'C',$fill);
			$this->SetFillColor(255,255,255);
		
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
		
		$wdet=array(6,23,15,15,10,10,58,13,10,10,20);
		
		$fecha=date("d-m-Y");

		// Se imprime el detalle de cada UC solicitada
		foreach($data as $row)
		{			
			//Obtiene el detalle
			$cont=1;
			$cant=100000;
			$puntero=0;
			$fill=true;
			$sortcol='ITEM.id_supergrupo,COMPON.orden,ITEM.nombre asc';
			$sortdir='asc';
			$criterio_filtro=' OSUCDE.id_salida = '.$_SESSION["rep_mat_id_salida"].' AND OSUCDE.id_tipo_unidad_constructiva = '.$row[6];
			
			$Det=new cls_CustomDBAlmacenes();
			$Det->PedidoMaterialesUCDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
			$detalle=$Det->salida;
						
			if($prim_hoja!=1)
			{				
				$this->AddPage();
			}
            // datos de la cabecera 
            $this->Datos_Cab($data,$detalle);
						
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

					$this->SetY(35);
					//datos de la cabecera
					$this->Datos_Cab($data,$detalle);
					
					$this->Cell(120,10,$row['supergrupo'] ,0,1,'L');
					//Imprime los encabezados
					$this->SetFont('Arial','B',6);
				
					for($i=0;$i<count($header_det);$i++)
					$this->Cell($wdet[$i],5,$header_det[$i],1,0,'C',1);
					$this->Ln();
				}
					
				
				
				$this->SetFont('Arial','',6);
				$this->Cell($wdet[0],4,$cont,'LTRB',0,'C',$fill);
				
                $this->SetFont('Arial','B',6);
				$this->Cell($wdet[1],4,'  '.$row['nombre'],'LTRB',0,'L',$fill);
				$this->SetFont('Arial','',6);
				
				$this->Cell($wdet[2],4,round($row['cant_unit_uc']*100)/100,'LTRB',0,'R',$fill);
				$this->Cell($wdet[3],4,$row['peso_kg'],'LTRB',0,'R',$fill);//$this->Cell($wdet[3],4,$row[10],'LTRB',0,'R',$fill);
				$this->Cell($wdet[4],4,$row['unidad_med'],'LTRB',0,'C',$fill);
				$this->Cell($wdet[5],4,$row['calidad'],'LTRB',0,'C',$fill);
				$x=$this->GetX();
				$y=$this->GetY();
				$this->MultiCell($wdet[6],4,$row[5],'LTRB','L');
				$this->SetXY($x+$wdet[6],$y);
				$this->Cell($wdet[7],4,round($row['peso_total']*100)/100,'LTRB',0,'R',$fill);
				$this->Cell($wdet[8],4,round($row['cantidad_total']*100)/100,'LTRB',0,'R',$fill);
				$this->Cell($wdet[9],4,$row['cant_demasia'],'LTRB',0,'R',$fill);
				$this->Cell($wdet[10],4,round($row['cantidad_total_dem']*100)/100,'LTRB',1,'R',$fill);
				$cont++;
				
			}
		
			//Define que no es la primera página
			$prim_hoja=0;
			/*if($prim_hoja==1){
				for($i=0;$i<count($header_det);$i++)
			$this->Cell($wdet[$i],5,$header_det[$i],1,0,'C',1);
			$this->Ln();
				
			}*/
			
		}
     
	}


}

$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
//Títulos de las columnas
$header=array('Nro.','Unidad Constructiva','Componente','Cantidad');
$header_det=array('Nro.','Posición','Cant.x Comp.','Peso Unitario','Unidad','Calidad','Descripción  del Material','Peso Total','Cantidad','Demasía','Cant. Entregada');

//Carga de datos
$tipo=$tipo;
$data=$pdf->LoadData();

$pdf->SetFont('Arial','',10);
$pdf->SetAutoPageBreak(1,42);
$pdf->SetTopMargin(5);
$pdf->SetRightMargin(15);
$pdf->SetLeftMargin(15);
$pdf->AddPage();
$pdf->Maestro($data,'',$header,$header_det);

$pdf->Output();
?>