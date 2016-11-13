<?php
require ('../../../../lib/fpdf/fpdf.php');
require ('../../../../lib/funciones.inc.php');
include_once ("../../../../lib/configuracion.log.php");
include_once ("../../LibModeloActivoFijo.php");

class PDF extends FPDF {
	var $sep_decim = '.';
	var $sep_mil = ',';
	var $data;

	var $id_financiador;
	var $id_regional;
	var $id_programa;
	var $id_proyecto;
	var $id_actividad;
	
	//var $id_fina_regi_prog_proy_acti;
	var $id_activo_fijo;
	var $fecha_desde;
	var $fecha_hasta;
	var $tipo_data;

	function Header() {
		//if($this->PageNo()==1){
		//$this->Image ( '../../../../lib/images/logo_reporte.jpg', 165, 8, 36, 13 );
		$this->Image('../../../../lib/images/logo_reporte.jpg',235,8,36,13);
		$this->ln(10);
		$this->SetFont('Arial','B',14);
		$this->Cell(270,5,'DETALLE DE DEPRECIACIÓN',0,1,'C');
		$this->SetFont('Arial','B',10);
		$this->Cell(270,5,'Del: '.$this->fecha_desde .'  Al: '.$this->fecha_hasta,0,1,'C');
		$this->Cell(270,5,'(Expresado en Bolivianos)',0,1,'C');
		if($this->tipo_data=='sec'){
			$this->Cell(270,5,'DATOS HISTÓRICOS',0,1,'C');
		}

		$this->Ln(5);
	}
	//Pie de página
	function Footer() {
		$fecha=date("d-m-Y");
		$hora=date("h:i:s");
		$this->SetY(-10);
		$this->SetFont('Arial','',6);
		//$this->Cell(205,0.2,'',1,1);
		/*$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');*/
		$this->Cell(60,10,'Usuario: '.$_SESSION["ss_nombre_usuario"] ,0,0,'L');
		$this->Cell(165,10,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(165,10,'Fecha: '.$fecha ,0,0,'L');
		$this->ln(3);
		$this->Cell(60,10,'',0,0,'L');
		$this->Cell(165,10,'',0,0,'C');
		$this->Cell(165,10,'Hora: '.$hora ,0,0,'L');
	}
	
	function LoadData() 
	{
		/*echo $this->id_activo_fijo;
		exit();*/
		
		$criterio_filtro = "  DEPREC.id_activo_fijo LIKE ''$this->id_activo_fijo''";
		$criterio_filtro .= " AND to_char(DEPREC.fecha_hasta,''mm/yyy'') BETWEEN to_char(''$this->fecha_desde''::date,''mm/yyy'') AND to_char(''$this->fecha_hasta''::date,''mm/yyy'')";
		$Custom = new cls_CustomDBActivoFijo();
		if($this->tipo_data=='sec')
		{
			$Custom->ListarDetalleDepreciacionSec('NULL', 'NULL', 'NULL', 'NULL', $criterio_filtro, $this->id_financiador, $this->id_regional, $this->id_programa, $this->id_proyecto, $this->id_actividad );
			//$Custom->ListarDetalleDepreciacionSec('NULL', 'NULL', 'NULL', 'NULL', $criterio_filtro, $this->id_fina_regi_prog_proy_acti );		
		}
		else
		{
			$Custom->ListarDetalleDepreciacionPri('NULL', 'NULL', 'NULL', 'NULL', $criterio_filtro, $this->id_financiador, $this->id_regional, $this->id_programa, $this->id_proyecto, $this->id_actividad );
			//$Custom->ListarDetalleDepreciacionPri('NULL', 'NULL', 'NULL', 'NULL', $criterio_filtro, $this->id_fina_regi_prog_proy_acti );
		}
		$resp = $Custom->salida;
		$this->data=$resp;

		/*echo"<pre>";
		print_r($this->data);
		echo"</pre>";*/
	}

	function crear_pdf()
	{
		//Despliega el detalle
		$this->SetFont('Arial','',6);
		$this->SetWidths(array(15,20,15,17,15,15,25,17,15,20,15,17,15,15,25,17,17,17,17,17,17,22));
		$this->SetVisibles(array(0,0,0,0,0,0,0,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1));
		$this->SetAligns(array('R','R','R','R','R','R','R','R','C','R','R','R','R','R','R','R','R','R','R','R','R','R'));
		$this->SetFonts(array('Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial','Arial'));
		$this->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6));
		//$this->SetFontsStyles(array('','','','','','','','','','','','','',''));
		$this->SetSpaces(array(4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4,4));
		$this->SetDecimales(array(0,0,0,0,0,0,0,0,2,2,2,2,2,2,2,2,2,2,2,2,2,6));

		/*echo"<pre>";
		print_r($this->data);
		echo"</pre>";*/
		$activo=0;
		$sw=0;
		$tot_actualiz=0;
		$tot_dep_actualiz=0;
		$tot_dep_men=0;

		for ($i=0;$i<sizeof($this->data);$i++){
			if(!$sw){
				$sw=1;
				$activo=$this->data[$i]['codigo'];

				$this->SetFont('Arial','B',8);
				$this->Cell(35,5,'CÓDIGO ACTIVO FIJO:  ','',0,'L');
				$this->SetFont('Arial','',8);
				$this->Cell(30,5,$this->data[$i]['codigo'],0,0,'L');
				//$this->Line($this->GetX(),$this->GetY(),$this->GetX()+200,$this->GetY());

				$this->SetFont('Arial','B',8);
				$this->Cell(28,5,'DENOMINACIÓN:  ','',0,'L');
				$this->SetFont('Arial','',8);
				$this->Cell(165,5,$this->data[$i]['descripcion'],0,1,'L');

				$this->SetFont('Arial','B',8);
				$this->Cell(35,5,'DESCRIPCIÓN:  ','',0,'L');
				$this->SetFont('Arial','',8);
				$this->MultiCell(218,5,$this->data[$i]['descripcion_larga'],'','L');

				$this->SetFont('Arial','B',8);
				$this->Cell(35,5,'TIPO ACTIVO FIJO:  ','',0,'L');
				$this->SetFont('Arial','',8);
				$this->MultiCell(155,5,$this->data[$i]['tipo_activo'],'','L');

				$this->SetFont('Arial','B',8);
				$this->Cell(35,5,'SUBTIPO ACTIVO FIJO:  ','',0,'L');
				$this->SetFont('Arial','',8);
				$this->Cell(155,5,$this->data[$i]['subtipo_activo'],0,0,'L');

				$this->SetFont('Arial','B',8);
				$this->Cell(35,5,'VIDA ÚTIL ORIGINAL:  ','',0,'L');
				$this->SetFont('Arial','',8);
				$this->Cell(155,5,$this->data[$i]['vida_util_original'],0,1,'L');

				$this->SetFont('Arial','B',8);
				$this->Cell(35,5,'MONTO COMPRA:  ','',0,'L');
				$this->SetFont('Arial','',8);
				$this->Cell(155,5,number_format($this->data[$i]['monto_compra'],2,'.',','),0,0,'L');

				$this->SetFont('Arial','B',8);
				$this->Cell(35,5,'FECHA INICIO DEP:  ','',0,'L');
				$this->SetFont('Arial','',8);
				$this->Cell(155,5,$this->data[$i]['fecha_ini_dep'],0,1,'L');
				$this->Ln(3);

				//DESPLIEGUE DE TÍTULOS DE COLUMNAS
				$this->SetFont('Arial','B',6);
				$this->Cell(15,5,'FECHA',1,0,'C');
				$this->Cell(20,5,'VALOR CONTABLE',1,0,'C');
				$this->Cell(15,5,'ACTUALIZ.',1,0,'C');
				$this->Cell(17,5,'VALOR TOTAL',1,0,'C');
				$this->Cell(15,5,'DEP.ACUM.INI',1,0,'C');
				$this->Cell(15,5,'ACTUALIZ.',1,0,'C');
				$this->Cell(25,5,'DEP.ACUM.ACTUALIZ.',1,0,'C');
				$this->Cell(17,5,'DEP.MENSUAL',1,0,'C');
				$this->Cell(17,5,'DEP.ACUM.',1,0,'C');
				$this->Cell(17,5,'VALOR NETO',1,0,'C');
				$this->Cell(17,5,'VIDA ÚTIL',1,0,'C');
				$this->Cell(17,5,'T/C INI.',1,0,'C');
				$this->Cell(17,5,'T/C FIN.',1,0,'C');
				$this->Cell(22,5,'FACTOR ACTUALIZ.',1,1,'C');
			}
			else{
				if($this->data[$i]['codigo']!=$activo){
					//Imprime los totales
					$this->SetFont('Arial','B',6);
					$this->Cell(15,3.5,'TOTALES','LB',0,'L');
					$this->Cell(20,3.5,'','B',0,'L');
					$this->Cell(15,3.5,number_format($tot_actualiz,2,'.',','),'B',0,'R');
					$this->Cell(17,3.5,'','B',0,'');
					$this->Cell(15,3.5,'','B',0,'');
					$this->Cell(15,3.5,number_format($tot_dep_actualiz,2,'.',','),'B',0,'R');
					$this->Cell(25,3.5,'','B',0,'');
					$this->Cell(17,3.5,number_format($tot_dep_men,2,'.',','),'B',0,'R');
					$this->Cell(107,3.5,'','BR',1,'R');

					//Iguala el codigo del activo fijo y adiciona una página
					$activo=$this->data[$i]['codigo'];
					$this->AddPAge();

					$this->SetFont('Arial','B',8);
					$this->Cell(35,5,'CÓDIGO ACTIVO FIJO:  ','',0,'L');
					$this->SetFont('Arial','',8);
					$this->Cell(30,5,$this->data[$i]['codigo'],0,0,'L');
					//$this->Line($this->GetX(),$this->GetY(),$this->GetX()+200,$this->GetY());

					$this->SetFont('Arial','B',8);
					$this->Cell(28,5,'DENOMINACIÓN:  ','',0,'L');
					$this->SetFont('Arial','',8);
					$this->Cell(165,5,$this->data[$i]['descripcion'],0,1,'L');

					$this->SetFont('Arial','B',8);
					$this->Cell(35,5,'DESCRIPCIÓN:  ','',0,'L');
					$this->SetFont('Arial','',8);
					$this->MultiCell(218,5,$this->data[$i]['descripcion_larga'],'','L');

					$this->SetFont('Arial','B',8);
					$this->Cell(35,5,'TIPO ACTIVO FIJO:  ','',0,'L');
					$this->SetFont('Arial','',8);
					$this->MultiCell(155,5,$this->data[$i]['tipo_activo'],'','L');

					$this->SetFont('Arial','B',8);
					$this->Cell(35,5,'SUBTIPO ACTIVO FIJO:  ','',0,'L');
					$this->SetFont('Arial','',8);
					$this->Cell(155,5,$this->data[$i]['subtipo_activo'],0,0,'L');

					$this->SetFont('Arial','B',8);
					$this->Cell(35,5,'VIDA ÚTIL ORIGINAL:  ','',0,'L');
					$this->SetFont('Arial','',8);
					$this->Cell(155,5,$this->data[$i]['vida_util_original'],0,1,'L');

					$this->SetFont('Arial','B',8);
					$this->Cell(35,5,'MONTO COMPRA:  ','',0,'L');
					$this->SetFont('Arial','',8);
					$this->Cell(155,5,number_format($this->data[$i]['monto_compra'],2,'.',','),0,0,'L');

					$this->SetFont('Arial','B',8);
					$this->Cell(35,5,'FECHA INICIO DEP:  ','',0,'L');
					$this->SetFont('Arial','',8);
					$this->Cell(155,5,$this->data[$i]['fecha_ini_dep'],0,1,'L');
					$this->Ln(3);

					//DESPLIEGUE DE TÍTULOS DE COLUMNAS
					$this->SetFont('Arial','B',6);
					$this->Cell(15,5,'FECHA',1,0,'C');
					$this->Cell(20,5,'VALOR CONTABLE',1,0,'C');
					$this->Cell(15,5,'ACTUALIZ.',1,0,'C');
					$this->Cell(17,5,'VALOR TOTAL',1,0,'C');
					$this->Cell(15,5,'DEP.ACUM.INI',1,0,'C');
					$this->Cell(15,5,'ACTUALIZ.',1,0,'C');
					$this->Cell(25,5,'DEP.ACUM.ACTUALIZ.',1,0,'C');
					$this->Cell(17,5,'DEP.MENSUAL',1,0,'C');
					$this->Cell(17,5,'DEP.ACUM.',1,0,'C');
					$this->Cell(17,5,'VALOR NETO',1,0,'C');
					$this->Cell(17,5,'VIDA ÚTIL',1,0,'C');
					$this->Cell(17,5,'T/C INI.',1,0,'C');
					$this->Cell(17,5,'T/C FIN.',1,0,'C');
					$this->Cell(22,5,'FACTOR ACTUALIZ.',1,1,'C');



					//Inicializa las variables de los totales
					$tot_actualiz=0;
					$tot_dep_actualiz=0;
					$tot_dep_men=0;
				}

			}
			$this->MultiTabla($this->data[$i],2,3,3.5,6);
			$tot_actualiz+=$this->data[$i]['actualiz_valor'];
			$tot_dep_actualiz+=$this->data[$i]['actualiz_dep'];
			$tot_dep_men+=$this->data[$i]['dep_mensual'];
		}
		//15,20,15,17,15,15,25,17,17,17,17,17,17,22
		//15,20,15,17,15,15,25,17,17
		//$this->SetWidths(array(15,20,15,17,15,15,25,17,15,20,15,17,15,15,25,17,17,17,17,17,17,22));
		$this->SetFont('Arial','B',6);
		$this->Cell(15,3.5,'TOTALES','LB',0,'L');
		$this->Cell(20,3.5,'','B',0,'L');
		$this->Cell(15,3.5,number_format($tot_actualiz,2,'.',','),'B',0,'R');
		$this->Cell(17,3.5,'','B',0,'');
		$this->Cell(15,3.5,'','B',0,'');
		$this->Cell(15,3.5,number_format($tot_dep_actualiz,2,'.',','),'B',0,'R');
		$this->Cell(25,3.5,'','B',0,'');
		$this->Cell(17,3.5,number_format($tot_dep_men,2,'.',','),'B',0,'R');
		$this->Cell(107,3.5,'','BR',1,'R');
		//$this->Line($this->GetX(),$this->GetY(),$this->GetX()+200,$this->GetY());
	}
}

//Instancia la clase PDF para generar el reporte
$pdf = new PDF ('L','mm','Letter');
$pdf->AliasNbPages();
//$pdf->AddFont('Tahoma','','tahoma.php');
$pdf->AddFont('Arial','','arial.php');
$pdf->SetMargins(10,10,10);
$pdf->SetAutoPageBreak(true,15);

//Obtiene los parámetros del Reporte
$pdf->id_financiador=$id_financiador;
$pdf->id_regional=$id_regional;
$pdf->id_programa=$id_programa;
$pdf->id_proyecto=$id_proyecto;
$pdf->id_actividad=$id_actividad;

//$pdf->id_fina_regi_prog_proy_acti=$id_fina_regi_prog_proy_acti;
$pdf->id_activo_fijo=$id_activo_fijo;
$pdf->fecha_desde=$fecha_desde;
$pdf->fecha_hasta=$fecha_hasta;
$pdf->tipo_data=$tipo_data;

//Obtiene los Datos del Reporte
$pdf->LoadData();

//Construye el pdf
$pdf->AddPage();
$pdf->crear_pdf();

//Despliega el Reporte
$pdf->Output ();
?>