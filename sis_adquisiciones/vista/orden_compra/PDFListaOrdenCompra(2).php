<?php
require('../../../lib/fpdf/fpdf.php');
//require('../../../lib/fpdf/mc_table.php');
define('FPDF_FONTPATH','font/');
include_once("../../control/LibModeloAdquisiciones.php");

class PDF extends FPDF
{
	//Cargar los datos
	//Cabecera de página

	function Header(){
	global $title;
	$this->SetLeftMargin(15);
	//Logo
	$this->Image('../../../lib/images/logo_reporte.jpg',240,2,35,13);
    $this->SetLineWidth(.1);
	$this->SetFont('Arial','B',8);
	//Movernos a la derecha
	$this->Cell(230,10,'LISTADO DE ORDENES DE COMPRA',0,0,'C');
	$this->Ln(15);
	$this->SetFont('Arial','',6);
	$this->Cell(7,5,'Nº OC','LTR',0,'C');
	$this->Cell(12,5,'FECHA','TR',0,'C');
	$this->Cell(21,5,'CODIGO','TR',0,'C');
	$this->Cell(55,5,'PROVEEDOR','TR',0,'C');
	$this->Cell(25,5,'OBSERVACIONES','TR',0,'C');
	$this->Cell(15,5,'IMPORTE','TR',0,'C');
	$this->Cell(15,5,'IMPORTE','TR',0,'C');
	$this->Cell(25,5,'CATEGORIA','TR',0,'C');
	$this->Cell(15,5,'ESTADO','TR',0,'C');
	$this->Cell(15,5,'SALDO POR','TR',0,'C');
	$this->Cell(15,5,'SALDO POR','TR',0,'C');
    $this->Ln(3);
    $this->Cell(7,4,'','LRB',0,'C');
	$this->Cell(12,4,'','RB',0,'C');
	$this->Cell(21,4,'PROCESO','RB',0,'C');
	$this->Cell(55,4,'','RB',0,'C');
	$this->Cell(25,4,'','RB',0,'C');
	$this->Cell(15,4,'Bs','RB',0,'C');
	$this->Cell(15,4,'$us','RB',0,'C');
	$this->Cell(25,4,'COMPRA','RB',0,'C');
	$this->Cell(15,4,'PROCESO','RB',0,'C');
	$this->Cell(15,4,'PAGAR Bs','RB',0,'C');
	$this->Cell(15,4,'PAGAR $us','RB',0,'C');
	$this->Ln(4);
	}
	//Pie de página
	function Footer(){
		$this->SetY(-15);
		//fecha
		$fecha=date("d-m-Y");
		//hora
		$hora=date("H:i:s");
		
		$this->SetFont('Arial','',6);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');		
	}
	function LoadData($tipo_adq,$id_proveedor,$fecha_inicio,$fecha_fin,$id_depto){
		$cant=15;
	    $puntero=0;
	    $sortcol='COT.fecha_orden_compra';
	    $sortdir='asc';	    
	    $criterio_filtro="COT.fecha_orden_compra>= ''$fecha_inicio''";
	    $criterio_filtro=$criterio_filtro."  AND COT.fecha_orden_compra<= ''$fecha_fin''";
	    $criterio_filtro=$criterio_filtro." AND PROCOM.id_depto=".$id_depto;
	    if($id_proveedor!='%'){
	     	$criterio_filtro=$criterio_filtro.'  AND COT.id_proveedor='.$id_proveedor;
	    }
	    if($tipo_adq=='Bien'){
	    	$criterio_filtro=$criterio_filtro.'  AND COTDET1.id_item_aprobado IS NOT NULL';
	    }
	    elseif ($tipo_adq=='Servicio'){
	    	$criterio_filtro=$criterio_filtro.'  AND COTDET1.id_servicio IS NOT NULL';
	    }
	    //Leer las líneas del fichero
	    $Custom = new cls_CustomDBAdquisiciones();
		$Custom->ListarListaOC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	    $data=$Custom->salida;
	    return $data;
	}
	//Tabla coloreada
	function FancyTable($data){
		//Colores, ancho de línea y fuente en negrita
	    $this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(190,190,190);
		$this->SetLineWidth(.1);
		$this->SetFont('Arial','',5);
	  	//Cabecera
		
			//Restauración de colores y fuentes
			$this->SetFillColor(224,235,255);
			$this->SetTextColor(0);
			//Datos
			$fill=0;
		foreach($data as $row){
			$this->Cell(7,4,$row["numero_orden"],'LTRB',0,'L',$fill);
			$this->Cell(12,4,$row["fecha_orden_compra"],'LTRB',0,'L',$fill);
			$this->Cell(21,4,$row["codigo_proceso"],'LTRB',0,'L',$fill);
			$this->Cell(55,4,$row["nombre_proveedor"],'LTRB',0,'L',$fill);
			$this->Cell(25,4,$row["observaciones"],'LTRB',0,'L',$fill);
			if($row["nombre_moneda"]=='Bolivianos'){
			   $this->Cell(15,4,number_format($row["total"],2,'.',','),'LTRB',0,'R',$fill);	
			}
			else{
			   $this->Cell(15,4,number_format($row["total_cambio"],2,'.',','),'LTRB',0,'R',$fill);	
			}
			if($row["nombre_moneda"]=='Dólares Americanos'){
			   $this->Cell(15,4,number_format($row["total"],2,'.',','),'LTRB',0,'R',$fill);	
			}
			else{
			   $this->Cell(15,4,number_format($row["total_cambio"],2,'.',','),'LTRB',0,'R',$fill);	
			} 
			$this->Cell(25,4,$row["categoria"],'LTRB',0,'L',$fill);
			$this->Cell(15,4,$row["estado_vigente"],'LTRB',0,'R',$fill);
			if($row["nombre_moneda"]=='Bolivianos'){
				$this->Cell(15,4,number_format($row["saldo_pagar"],2,'.',','),'LTRB',0,'R',$fill);	
			}
			else{
				$this->Cell(15,4,number_format($row["saldo_cambio"],2,'.',','),'LTRB',0,'R',$fill);	
			}
			if($row["nombre_moneda"]=='Dólares Americanos'){
				$this->Cell(15,4,number_format($row["saldo_pagar"],2,'.',','),'LTRB',0,'R',$fill);	
			}
			else{
				$this->Cell(15,4,number_format($row["saldo_cambio"],2,'.',','),'LTRB',0,'R',$fill);	
			}
			$this->Ln();
			$fill=!$fill;
		}
		}
}
$pdf=new PDF('L','mm','Letter');
$pdf->AliasNbPages();
//Carga de datos
$data=$pdf->LoadData($tipo_adq,$id_proveedor,$fecha_inicio,$fecha_fin,$id_depto);
$pdf->SetFont('Arial','',14);
$pdf->SetAutoPageBreak(1,15);
$pdf->SetTopMargin(13);
$pdf->SetRightMargin(10);
$pdf->SetLeftMargin(15);
$pdf->AddPage();
$pdf->FancyTable($data);
$pdf->Output();
?>