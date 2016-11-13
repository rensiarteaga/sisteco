<?php
require('../../../../lib/fpdf/fpdf.php');
require('../../../../lib/funciones.inc.php');
include_once("../../../../lib/configuracion.log.php");
include_once("../../LibModeloAlmacenes.php");
define('FPDF_FONTPATH','font/');

class PDF extends FPDF
{
	var $sep_decim='.';
	var $sep_mil=',';
	
	function PDF($orientation='P',$unit='mm',$format='Letter')
    {
    //Llama al constructor de la clase padre
    $this->FPDF($orientation,$unit,$format);
    //Iniciación de variables
    }
	
	

	function Header()
	{
		global $title;
		$imprimir_footer=1;
		$this->SetLeftMargin(15);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(190,190,190);
		$this->SetLineWidth(.1);
		
		$w=array(7,20,80,14,14,17,15,14,14,17,14,14,14);
		$header=array('#','Item','Descripción','Saldo Ant.','Ingresos','Transferencias','Devoluciones','Parcial','Salidas','Transferencias','Demasía','Parcial','Saldo');
		$funciones = new funciones();
		//Logo
		
		
		// establecemos el idioma de la página
		setlocale (LC_TIME,"spanish", "es_ES@euro", "es_ES", "es");
		//creamos la cadena con los especificadores necesarios
		$formato = "%d de %B de %Y";
		//$formato = "%A, %d de %B de %Y";
		
		$fechad=$_SESSION["part_dia_fecha_desde"];

		$mes = substr($fechad, 0, 2);
		$dia = substr($fechad, 3, 2);
		$anio = substr($fechad, -4);
		$fechad=$dia.'-'.$mes.'-'.$anio;
		//Mostramos la fecha, ahora sí en el idioma deseado.
		$fechad=strftime($formato, strtotime($fechad));

		$fechah=$_SESSION["part_dia_fecha_hasta"];

		$mes = substr($fechah, 0, 2);
		$dia = substr($fechah, 3, 2);
		$anio = substr($fechah, -4);
		$fechah=$dia.'-'.$mes.'-'.$anio;

		//Mostramos la fecha, ahora sí en el idioma deseado.
		$fechah=strftime($formato, strtotime($fechah));
		
		
		$this->Image('../../../../lib/images/logo_reporte.jpg',25,11,36,12);

		$this->SetFont('Arial','',8);
		//$this->SetX(247);
		$this->Cell(60,5,'','LRT',0,'L');
		$this->Cell(134,5,'','LRT',0,'L');
		$this->Cell(20,5,'Desde:','LT',0,'R');
		$this->SetFont('Arial','B',8);
		$this->Cell(40,5,$fechad,'RT',1,'L');
		
		$this->Cell(60,5,'','LR',0,'L');
		$this->SetFont('Arial','B',12);
		$this->Cell(134,5,'MOVIMIENTO FÍSICO DE ALMACÉN','LR',0,'C');
		$this->SetFont('Arial','',8);
		$this->Cell(20,5,'Hasta:','L',0,'R');
		$this->SetFont('Arial','B',8);
		$this->Cell(40,5,$fechah,'R',1,'L');
		
		$this->Cell(60,5,'','LRB',0,'L');
		$this->Cell(134,5,'','LRB',0,'L');
		$this->SetFont('Arial','',8);
		$this->Cell(20,5,'Página:','LB',0,'R');
		$this->SetFont('Arial','B',8);
		$this->Cell(40,5,$this->PageNo().' de {nb}','RB',1,'L');
		$this->ln(3);
				
        $this->SetFont('Arial','B',9);
		$this->Cell(60,5,'Almacén Físico:',0,0,'R');
		$this->SetFont('Arial','',9);
		$this->Cell(67,5,$_SESSION['part_dia_desc_almacen'],0,0,'L');
		//$this->ln(5);
		$this->SetFont('Arial','B',9);
		$this->Cell(67,5,'Almacén Lógico:',0,0,'R');
		$this->SetFont('Arial','',9);
		$this->Cell(60,5,$_SESSION['part_dia_desc_almacen_logico'],0,1,'L');
		$this->ln(3);	
			
		//Imprime los rótulos de las columnas
        $this->SetFont('Arial','B',6);
		$this->Cell(121,3,'',0,0,'C',1);
		$this->Cell(46,3,'INGRESOS','LTR',0,'C',1);
		$this->Cell(14,3,'','L',0,'C',1);
		$this->Cell(45,3,'SALIDAS','LTR',1,'C',1);

		for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],5,$header[$i],1,0,'C',1);
		$this->Ln();

	}
	//Pie de página
	function Footer()
	{
		//Posición: a 1,5 cm del final

		$this->SetY(-15);
		//Arial italic 8
		$this->SetFont('Arial','',8);
		//ip
		$ip = captura_ip();
		//Número de página
		$fecha=date("d-m-Y");
		//hora
		$hora=date("H:i:s");
		$this->Cell(254,0.2,'',1,1);
		$this->Cell(60,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L');
		$this->Cell(165,10,'',0,0,'C');
		$this->Cell(165,10,'Fecha: '.$fecha ,0,0,'L');
		$this->ln(3);
		$this->Cell(60,10,'',0,0,'L');
		$this->Cell(165,10,'',0,0,'C');
		//$this->Cell(165,10,'Hora: '.$hora ,0,0,'L');
		//fecha
	}

	//Tabla coloreada
	function FancyTable($data,$header,$header_det)
	{
		$cant=100000;
		$puntero=0;
		$sortcol='ITEM.nombre';
		$sortdir='asc';
		$criterio_filtro="";
		//$criterio_filtro=" INGRES.fecha_finalizado_cancelado = ''".$_SESSION["part_dia_fecha_desde"]."''";
		$Custom=new cls_CustomDBAlmacenes();

		//Obtiene los Ingresos por Item
		//echo "desde:".$_SESSION['part_dia_fecha_desde'];
		//echo "----- hasta:".$_SESSION['part_dia_fecha_hasta'];
		
		$Custom->ListarParteDiario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$_SESSION['part_dia_id_financiador'],$_SESSION['part_dia_id_regional'],$_SESSION['part_dia_id_programa'],$_SESSION['part_dia_id_proyecto'],$_SESSION['part_dia_id_actividad'],$_SESSION['part_dia_id_parametro_almacen'],$_SESSION['part_dia_fecha_desde'],$_SESSION['part_dia_fecha_hasta'],$_SESSION['part_dia_id_almacen'],$_SESSION['part_dia_id_almacen_logico']);
		$resp_ing=$Custom->salida;

	
		//Contador hoja
		$prim_hoja=1;

		$this->SetFont('Arial','',10);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(190,190,190);
		$this->SetLineWidth(.1);
		$this->SetFont('','',10);

		//Cabecera
			
		$fecha=date("d-m-Y");
		
		$cont=0;
		$id_item='';
		$tot_item=0;
		
		//$this->ImprimirTabla($resp_ing,5,0.6,$header,$w,$a);
		 $this->SetFont('Arial','',6);
         $this->SetWidths(array(7,20,20,80,14,14,17,15,14,14,17,14,14,14));
         $this->SetVisibles(array(1,0,1,1,1,1,1,1,1,1,1,1,1,1));
         $this->SetAligns(array('C','L','L','L','R','R','R','R','R','R','R','R','R','R'));
         $this->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
         $this->SetFontsStyles(array('','','','','','B','','','','B','','','','B'));
         $this->SetFontsSizes(array(5,5,6,6,6,6,6,6,6,6,6,6,6,6));
         $this->SetSpaces(array(3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5,3.5));
         $this->SetDecimales(array(0,0,0,2,2,2,2,2,2,2,2,2,2,2));

		
		for ($i=0;$i<sizeof($resp_ing);$i++){
 	        $cont=$i+1;
 	      
            $this->MultiTabla(array_merge((array)$cont,(array)$resp_ing[$i]),2,3,4,6);
       
          }

		 
	}




}

$pdf=new PDF('L','mm','Letter');
$pdf->AliasNbPages();
//Títulos de las columnas
$header=array('#','Item','Descripción','Saldo Ant.','Ingresos','Transferencias','Devoluciones','Parcial','Salidas','Transferencias','Demasía','Parcial','Saldo');


//Carga de datos
$tipo=$tipo;
//$data=$pdf->LoadData();
//echo json_encode($tipo_torre);
$pdf->SetFont('Arial','',10);
$pdf->SetAutoPageBreak(1,20);
$pdf->SetTopMargin(10);
$pdf->SetRightMargin(15);
$pdf->SetLeftMargin(15);
$pdf->AddPage();
//$pdf->Maestro($data,'Original',$header,$header_det);
$pdf->FancyTable('',$header,'');
$pdf->Output();
?>