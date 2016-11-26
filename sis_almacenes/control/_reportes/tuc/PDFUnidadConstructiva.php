<?php
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
include_once("../../rcm_LibModeloAlmacenes.php");

class PDF extends FPDF
{
	//Cargar los datos
	//Cabecera de página

	function Header()
	{	global $title;
	$this->SetLeftMargin(15);
	$funciones = new funciones();
	//Logo
	$this->Image('../../../../lib/images/logo_reporte.jpg',140,2);
	//Arial bold 15
	$this->SetFont('Arial','B',12);
	//Movernos a la derecha
	$this->Cell(185,13,$_SESSION['nombre_cabecera'],0,0,'C');
	$this->Ln(13);

	}
	//Pie de página
	function Footer(){
		$this->SetY(-35);
		//Arial italic 8
		$this->SetFont('Arial','',10);
		//fecha
		$fecha=date("d-m-Y");
		//hora
		$hora=date("H:i:s");
		if($_SESSION['tipo_maestro']=="raiz"){
			$nombre_padre=$_SESSION['nombre'];

		} else {
			$nombre_padre=$_SESSION['nombre_padre'];
		}
		$this->Cell(35,10,'','LTR',0,'L');
		$this->Cell(115,10,'ENDE','LTR',0,'C');
		$this->Cell(35,10,'','LTR',0,'L');
		$this->ln(5);
		$this->Cell(35,10,'Fecha: '.$fecha,'LR',0,'L');
		//$this->Cell(115,10,'LT 115 KV CARANAVI - TRINIDAD','LR',0,'C');
		$this->Cell(115,10,'Lista de Materiales Unidad Constructiva','LR',0,'C');
		$this->ln(5);
		$this->Cell(35,10,'','LR',0,'L');
		if($_SESSION['tipo_maestro']=="raiz")
		{
			if($this->PageNo()==1 || $this->PageNo()==2)
			{
				$this->Cell(115,10,'','LR',0,'C');
			}
			else
			{
				$this->Cell(115,10,$nombre_padre,'LR',0,'C');}
		}
		else
		{
			$this->Cell(115,10,$_SESSION['nombre_padre'],'LR',0,'C');
		}
		$this->Cell(35,10,'Hora: '.$hora,'LR',0,'L');
		$this->ln(5);
		$this->Cell(35,10,'','LRB',0,'L');
		$this->Cell(115,10,$_SESSION['nombre_pie'],'LRB',0,'C');
		$this->Cell(35,10,'Página '.$this->PageNo().' de {nb}' ,'LRB',0,'L');
	}
	function LoadData($node,$tipo)
	{    $cant=15;
	$puntero=0;
	$sortdir='asc';
	$criterio_filtro='0=0';
	//Leer las líneas del fichero
	$Custom=new cls_CustomDBAlmacenes();
	$CustomItem=new cls_CustomDBAlmacenes();

	if ($tipo==raiz){
		$sortcol='TIPOUC.codigo';
		$Custom->ListarTipoUnidadConstructivaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$node);
		$sortcol='COMP.id_componente';
		$CustomItem->ListarTipoUnidadConstructivaItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$node);

	}
	else{
		$sortcol='COMTUC.id_composicion_tuc';
		$Custom->ListarTipoUnidadConstructivaRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$node);
		$sortcol='COMP.id_componente';
		$CustomItem->ListarTipoUnidadConstructivaItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$node);
	}
	$nodes_rama=$Custom->salida;
	$nodes_item=$CustomItem->salida;
	$rama=sizeof($nodes_rama);
	$item=sizeof($nodes_item);
	
	if($rama!=0 && $item!=0){
		$nodes=array_merge($nodes_rama,$nodes_item);

		return $nodes;
	}


	elseif ($rama==0){
		return $nodes_item;
	}
	else{
		return $nodes_rama;
	}

	}
	function Caratula($nombre,$data,$header,$tipo){
		$this->SetFont('Arial','',13);
		$this->Cell(185,12,'','LTR');
		//$this->Ln(10);
		//$this->Cell(185,12,$nombre,'LRB',0,'C');
		$this->Ln(10);
		$this->Cell(185,30,'','LR');
		$this->Ln(28);
		$this->SetFont('Arial','',15);
		$this->Cell(185,20,'LISTA','LR',0,'C');
		$this->Ln(18);
		$this->Cell(185,20,'DE','LR',0,'C');
		$this->Ln(18);
		$this->Cell(185,30,'MATERIALES','LR',0,'C');
		$this->Ln(28);
		$this->Cell(185,20,'','LRB');
		$this->Ln(18);
		$this->SetFont('Arial','',10);
		$this->Cell(40,10,'Empresa','L');
		$this->Cell(145,10,'','R');
		$this->Ln(9);
		$this->SetFont('Arial','',13);
		$this->Cell(185,13,'EMPRESA NACIONAL DE ELECTRICIDAD','LRB',0,'C');
		$this->Ln(12);
		$this->SetFont('Arial','',10);
		$this->Cell(40,10,'Proyecto','L');
		$this->Cell(145,10,'','R');
		$this->Ln(9);
		$this->SetFont('Arial','',13);
		$this->Cell(185,13,'CONTRUCCIÓN DE LÍNEAS DE TRANSMISION ELÉCTRICA','LRB',0,'C');
		$this->Ln(12);
		$this->AddPage();
		$this->FancyTable($header,$data,$tipo);


	}
	//Tabla coloreada
	function FancyTable($header,$data,$tipo)
	{
		//Colores, ancho de línea y fuente en negrita

		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		//$this->SetDrawColor(0,33,91);190,190,190
		$this->SetDrawColor(190,190,190);
		$this->SetLineWidth(.1);
		$this->SetFont('Arial','',6);
		//Cabecera
		$w=array(40,115,30);
		//$wi=array(35,60,60,30);
		$wi=array(7,23,15,10,105,10,15);
		$rama=array();
		$rama_nombre=array();
		$fecha=date("d-m-Y");
		$cont=1;

		
		if($tipo=="raiz"){
			for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],5,$header[$i],1,0,'C',1);
			$this->Ln();
			//Restauración de colores y fuentes
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('Arial','',6);
			//Datos
			$fill=0;
			//$CustomCantidad= new rcm_cls_CustomDBAlmacenes();

			foreach($data as $row)
			{
				
				if($row["tipo"]=="item"){

					$this->Cell($w[0],4,$row[3],'LTRB',0,'L',$fill);
					$this->Cell($w[1],4,$row[4],'LTRB',0,'L',$fill);
					$this->Cell($w[2],4,$fecha,'LTRB',0,'L',$fill);
				}
				else{

					$this->Cell($w[0],4,$row['codigo'],'LTRB',0,'L',$fill);
					$this->Cell($w[1],4,$row['nombre'],'LTRB',0,'L',$fill);
					$this->Cell($w[2],4,$fecha,'LTRB',0,'L',$fill);
					
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
							$this->Cell($w[0],4,$reemp["desc_tipo_unidad_constructiva"],'LTRB',0,'L',!$fill);
							$this->Cell($w[1],4,$reemp["desc_nombre"],'LTRB',0,'L',!$fill);
							$this->Cell($w[2],4,$fecha,'LTRB',0,'L',!$fill);
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
				
				//$header_item=array('Código','Material','Descripción','Cantidad');
				$header_item=array('Nº','Material','Cant x Comp','Calidad','Descripción','Demasia','Cantidad');
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
			$this->Cell($wi[$i],5,$header[$i],1,0,'C',1);
			$this->Ln();
			//Restauración de colores y fuentes
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			$this->SetFont('Arial','',6);
			
			//Datos
			$fill=0;
			foreach($data as $row)
			{
							
				$this->Cell($wi[0],4,$cont,'LTRB',0,'C',$fill);
				$this->Cell($wi[1],4,$row['nombre_item'],'LTRB',0,'L',$fill);
				$this->Cell($wi[2],4,round($row['cantidad']*100)/100,'LTRB',0,'R',$fill);
				//$this->Cell($wi[2],4,$row['cantidad'],'LTRB',0,'R',$fill);
				$this->Cell($wi[3],4,$row['calidad'],'LTRB',0,'C',$fill);
				//$this->Cell($wi[3],4,$row['unidad_medida'],'LTRB',0,'C',$fill);
				$this->Cell($wi[4],4,$row['descripcion'],'LTRB',0,'L',$fill);
				$this->Cell($wi[5],4,round($row['cant_demasia']*100)/100,'LTRB',0,'R',$fill);
				//$this->Cell($wi[5],4,$row['cant_demasia'],'LTRB',0,'R',$fill);
				$this->Cell($wi[6],4,round($row['cant_tot']*100)/100,'LTRB',0,'R',$fill);
				//$this->Cell($wi[6],4,$row['cant_tot'],'LTRB',0,'R',$fill);
				
				$cont++;
				$this->Ln();
				$fill=!$fill;
			}
		}


	}

}

$pdf=new PDF('P','mm','Letter');
$pdf->AliasNbPages();
//Títulos de las columnas
$header=array('Código','Elemento Estructural','Fecha');
//$header_item=array('Código','Material','Descripción','Cantidad');
$header_item=array('Nº','Material','Cant x Comp','Calidad','Descripción','Demasia','Cantidad');
//Carga de datos
$tipo=$tipo;
$data=$pdf->LoadData($node,$tipo);
//echo json_encode($tipo_torre);
$pdf->SetFont('Arial','',14);
$pdf->SetAutoPageBreak(1,35);
$pdf->SetTopMargin(15);
$pdf->SetRightMargin(15);
$pdf->SetLeftMargin(15);
$pdf->AddPage();

if($tipo=="raiz"){
	$pdf->Caratula($nombre,$data,$header,$tipo);
}
else{
	$pdf->FancyTable($header_item,$data,$tipo);
}
$pdf->Output();
?>