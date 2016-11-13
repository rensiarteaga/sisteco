<?php
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
//include_once("../../rcm_LibModeloAlmacenes.php");
include_once("../../LibModeloActivoFijo.php");
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{    //Cargar los datos
	//Cabecera de página

	function Header(){
		$header=array('NUM','CÓDIGO','DESCRIPCIÓN','ESTADO','ESTADO FUNCIONAL','FECHA COMPRA','MONTO COMPRA','UBICACIÓN','RESPONSABLE','UNIDAD ORGANIZACIONAL');//toodo lo que quiero mostrar en mis columnas
		global $title;
		$this->SetLeftMargin(15);
		$funciones = new funciones();
		//Logo
		$this->Image('../../../../lib/images/logo_reporte.jpg',230,2,36,13);
		
		//RCM:18/09/2009 Se mueve a header las columnas para cada hoja. antes estaba sólo en la primera
		$this->SetDrawColor(190,190,190);
		$this->SetLineWidth(.1);
		$this->SetFont('Arial','B',12);
		//Movernos a la derecha
		$this->Cell(250,10,'DETALLE DE ACTIVOS FIJOS',0,0,'C');
		$this->Ln(8);
		$this->SetFont('Arial','B',7);
		$this->Cell(185,10,'Fecha Compra (inicio) :  '.$_SESSION['rep_af_det_fecha1'],0,0,'L');
		$this->Ln(5);
		$this->Cell(185,10,'Fecha Compra (fin)      :  '.$_SESSION['rep_af_det_fecha2'],0,0,'L');
		$this->Ln(8);
		
		/*//Colores, ancho de línea y fuente en negrita
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(0,33,91);
		//$this->SetLineWidth(0.3);*/
    
		$this->SetWidths(array(10,20,45,15,20,20,20,45,30,28));
		//codigo, descripcion,estado,estado funcional,fecha compra,monto compra,ubicacion, responsable,unidad organizacional

		$this->SetAligns( array('C','C','C','C','C','C','C','C','C','C'));// para centrear los titulos del header

		///para dibujar la linea que no salia
		$y=$this->GetY();
		$this->Cell(253,0,'','T',1,'');
		$this->Row($header,1);
		$y2=$this->GetY();
		$this->Line(268,$y,268,$y2);
		$this->Cell(253,0,'','B',1,'');
		
		$this->SetAligns( array('C','L','L','L','L','C','R','L','L'));
		
		//FIN RCM
	}

	function Footer()
	{	//Posición: a 1,5 cm del final
		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','I',6);
		//Número de página
		$fecha=date("d-m-Y");
		//hora
		$hora=date("H:i:s");
		$this->Cell(120,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L');
		$this->Cell(110,10,'Página '.$this->PageNo().' de {nb}',0,0,'L');
		$this->Cell(100,10,'Fecha: '.$fecha ,0,0,'L');
		$this->ln(3);
		$this->Cell(100,10,'',0,0,'L');
		$this->Cell(130,10,'',0,0,'L');
		$this->Cell(200,10,'Hora: '.$hora ,0,0,'L');
		
	}


	/////////////////////////////////////////////////////////////////////////////

	function LoadData($id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_tipo_activo,$id_sub_tipo_activo,$id_estado_funcional,$id_unidad_organizacional,$fecha_compra1,$fecha_compra2,$estado,$ubicacion_fisica)
	{    
		$cant=20;
	$puntero=0;
	$sortcol='actif.codigo';
	$sortdir='asc';
	$criterio_filtro="subtip.id_sub_tipo_activo like ''$id_sub_tipo_activo''";
	$criterio_filtro=$criterio_filtro." and tipo.id_tipo_activo like ''$id_tipo_activo''";
	$criterio_filtro=$criterio_filtro." and efunc.id_estado_funcional like ''$id_estado_funcional''";
	$criterio_filtro=$criterio_filtro." and (uniorg.id_unidad_organizacional like ''$id_unidad_organizacional'' or uniorg.id_unidad_organizacional is null)";
	$criterio_filtro=$criterio_filtro." and actif.estado like ''$estado''";
	$criterio_filtro=$criterio_filtro." and actif.fecha_compra >= ''$fecha_compra1''";
	$criterio_filtro=$criterio_filtro." and actif.fecha_compra <= ''$fecha_compra2''";
	if($ubicacion_fisica!=''){
		$criterio_filtro=$criterio_filtro." and lower(actif.ubicacion_fisica) LIKE  lower(''%$ubicacion_fisica%'')";	
	}
	
	
	//echo "criterio: ".$criterio_filtro;
	//exit;

	//Leer las líneas del fichero
	$Custom=new cls_CustomDBActivoFijo();
	$Custom->ListarActivoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$var1=$Custom->salida;
	
	return $var1;
	}

	//Tabla coloreada
	function FancyTable($header,$data)
	{	
		$this->SetDrawColor(190,190,190);
		$this->SetLineWidth(.1);
		$this->SetFont('Arial','B',12);

		$this->SetFont('','B',6);
        $data1=array();
        $cont=1;
        foreach($data as $d){
        	$aux=array();
        	
        	array_push($aux,$cont);
        	for($i=0;$i<9;$i++){
        		array_push($aux,$d[$i]);
        	}
        	$cont++;
        	array_push($data1,$aux);
        }
        
        $data=$data1;

		//$this->SetFillColor(0, 0, 0);

		$this->SetFont('','',6);//tamaño de la letra del detalle
		$this->SetAligns( array('C','L','L','L','L','C','R','L','L'));// para convertir el centrado lado izquierdo

		$total=0;
		foreach ($data as $d){
			//Suma el total de los montos de compra
			$total+=$d[6];
			//Define el monto de compra con number_format
			$d[6]=number_format($d[6],2);
			//Dibuja el reporte
			$y=$this->GetY();
			$this->Cell(253,0,'','T',1,'');
			$this->Row($d,1);
			$y2=$this->GetY();
			$this->Line(268,$y,268,$y2);
		}
		$this->Cell(253,0,'','B',1,'');
		$rama_nombre=array();
		$fecha=date("d-m-Y");
	
		//Despliega el total de los montos de compra de los activos fijos
		$this->SetFont('Arial','B',8);
		$this->Cell(130,6,'TOTAL','',0,'');
		$this->Cell(20,6,number_format($total,2),'B',1,'R');
		$this->SetFont('Arial','',8);
	}

}


$pdf=new PDF('L','mm','Letter');


$pdf->AliasNbPages();
//Títulos de las columnas
$header=array('NUM','CÓDIGO','DESCRIPCIÓN','ESTADO','ESTADO FUNCIONAL','FECHA COMPRA','MONTO COMPRA','UBICACIÓN','RESPONSABLE','UNIDAD ORGANIZACIONAL');//toodo lo que quiero mostrar en mis columnas
//$header_item=array('Código','Material','Descripción','Cantidad');
//Carga de datos
//$tipo=$tipo;
//echo "ubicacionwww: ".$ubicacion_fisica;
//exit;
$data=$pdf->LoadData($id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_tipo_activo,$id_sub_tipo_activo,$id_estado_funcional,$id_unidad_organizacional,$fecha_compra1,$fecha_compra2,$estado,$ubicacion_fisica);

$pdf->SetFont('Arial','',12);
$pdf->SetAutoPageBreak(1,35);
$pdf->SetTopMargin(15);
$pdf->SetRightMargin(10);
$pdf->SetLeftMargin(10);
$pdf->AddPage();
$pdf->FancyTable($header,$data);
$pdf->Output();

?>