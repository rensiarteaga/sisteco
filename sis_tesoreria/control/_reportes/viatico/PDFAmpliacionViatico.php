<?php
require ('../../../../lib/fpdf/fpdf.php');
require ('../../../../lib/funciones.inc.php');
include_once ("../../../../lib/configuracion.log.php");
include_once ("../../LibModeloTesoreria.php");

class PDF extends FPDF {
	var $sep_decim = '.';
	var $sep_mil = ',';
	var $id_devengado;
	var $data;

	function Header() {
		//if($this->PageNo()==1){
		$this->Image ( '../../../../lib/images/logo_reporte.jpg', 165, 8, 36, 13 );
		$this->ln(10);
		$this->SetFont('Arial','B',14);
		$this->Cell(200,5,'AMPLIACIÓN DE VIAJE',0,1,'C');
		$this->SetFont('Arial','B',10);		
		$this->Cell(200,5,'Nº '.$this->data[0]['num_solicitud'],'',1,'R');
		$this->Ln(5);
		
//----------------------

		$this->Line($this->GetX(),$this->GetY(),$this->GetX(),200);
		$this->Line($this->GetX()+200,$this->GetY(),$this->GetX()+200,200);
		
		//$this->SetFillColor(247, 187, 9);	//Naranja
		$this->SetFillColor(200, 200, 200);	//Plomo oscuro
		
		$this->SetFont('Arial','B',8);
		$this->Cell(200,5,'DATOS GENERALES','LTBR',1,'C',true);
		
		$this->SetFont('Arial','',6);
		$this->Cell(200,3,'','LR',1);		
		
		//$this->SetFillColor(249 , 221, 113);	//Amarillo
		$this->SetFillColor(230 , 230, 230);	//Plomo claro
		
		$this->Cell(30,5,'NOMBRE SOLICITANTE:  ','L',0,'R');
		$this->Cell(70,5,$this->data[0]['desc_empleado'],'LTBR',0,'L',true);
		$this->Cell(30,5,'FECHA SOLICITUD:  ','L',0,'R');
		$this->Cell(60,5,$this->data[0]['fecha_solicitud'],'LTBR',0,'C',true);		
		$this->Cell(10,5,'','R',1,'R');
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
		$this->Cell(30,5,'CARGO:  ','L',0,'R');
		$this->Cell(70,5,$this->data[0]['cargo'],'LTBR',0,'L',true);
		$this->Cell(30,5,'Nº AMPLIACIÓN:  ','L',0,'R');
		$this->Cell(60,5,$this->data[0]['num_solicitud'],'LTBR',0,'C',true);	
		$this->Cell(10,5,'','R',1,'R');
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
		$this->Cell(30,5,'UNIDAD SOLICITANTE:  ','L',0,'R');
		$this->Cell(70,5,$this->data[0]['desc_unidad_organizacional'],'LTBR',0,'L',true);
		$this->Cell(30,5,'','',0,'R');
		$this->Cell(60,5,'','',0,'C');		
		$this->Cell(10,5,'','',1,'R');
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas		
		
		$this->Cell(30,5,'MOTIVO DE AMPLIACIÓN:  ','L',0,'R');
		$this->MultiCell(160,5,$this->data[0]['motivo_viaje'],'LTBR','L',true);
		//$this->Cell(155,5,$this->data[0]['motivo_viaje'],'LTBR',0,'L',true);		
		//$this->Cell(10,5,'','R',1,'R');
		$this->Cell(200,3,'','LR',1);		//linea de espacio entre filas
		
//----------------------
		//$this->SetFillColor(247, 187, 9);	//Naranja
		$this->SetFillColor(200, 200, 200);	//Plomo oscuro
		$this->SetFont('Arial','B',8);
		$this->Cell(200,5,'INFORMACIÓN DE AMPLIACIÓN','LTBR',1,'C',true);
		
		$this->SetFont('Arial','',6);
		$this->Cell(200,3,'','LR',1);
				
		//$this->SetFillColor(249 , 221, 113);	//Amarillo		
		$this->SetFillColor(230 , 230, 230);	//Plomo claro
		
		$this->Cell(30,5,'FECHA INICIO:  ','L',0,'R');
		$this->Cell(70,5,$this->data[0]['fecha_inicio'],'LTBR',0,'C',true);
		$this->Cell(30,5,'HORA INICIO:  ','L',0,'R');
		$this->Cell(60,5,$this->data[0]['hora_inicio'],'LTBR',0,'C',true);		
		$this->Cell(10,5,'','R',1,'R');
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
		$this->Cell(30,5,'FECHA FIN:  ','L',0,'R');
		$this->Cell(70,5,$this->data[0]['fecha_final'],'LTBR',0,'C',true);
		$this->Cell(30,5,'HORA FIN:  ','L',0,'R');
		$this->Cell(60,5,$this->data[0]['hora_final'],'LTBR',0,'C',true);	
		$this->Cell(10,5,'','R',1,'R');
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
		$this->Cell(30,5,'LUGAR:  ','L',0,'R');		
		$this->MultiCell(160,5,$this->data[0]['lugar_origen'],'LTBR','L',true);		
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
		$this->Cell(30,5,'TIPO DE TRANSPORTE:  ','L',0,'R');
		$this->Cell(70,5,$this->data[0]['tipo_viaje'],'LTBR',0,'L',true);		
		$this->Cell(30,5,'Nº DE DÍAS:  ','L',0,'R');
		$this->Cell(60,5,$this->data[0]['nro_dias'],'LTBR',0,'C',true);		
		$this->Cell(10,5,'','',1,'R');
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
		$this->Cell(30,5,'EMPRESA:  ','L',0,'R');
		$this->Cell(160,5,$this->data[0]['institucion'],'LTBR',0,'L',true);		
		$this->Cell(10,5,'','',1,'R');
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
		$this->Cell(30,5,'CATEGORÍA:  ','L',0,'R');
		$this->Cell(70,5,$this->data[0]['desc_categoria'],'LTBR',0,'C',true);		
		$this->Cell(30,5,'','',0,'');
		$this->Cell(60,5,'','',0,'C');		
		$this->Cell(10,5,'','',1,'R');
		$this->Cell(200,3,'','LR',1);		//linea de espacio entre filas
				
//----------------------		
		//$this->SetFillColor(247, 187, 9);	//Naranja
		$this->SetFillColor(200, 200, 200);	//Plomo oscuro
		
		$this->SetFont('Arial','B',8);
		$this->Cell(200,5,'PRESUPUESTO GLOBAL DEL GASTO','LTBR',1,'C',true);

		$this->SetFont('Arial','',6);
		$this->Cell(200,3,'','LR',1);		
		//$this->SetFillColor(249 , 221, 113);	//Amarillo
		$this->SetFillColor(230 , 230, 230);	//Plomo claro
		
		$this->Cell(30,5,'ESTRUC. PROGRAMATICA:  ','L',0,'R');		
		$this->MultiCell(160,5,$this->data[0]['estructura_programatica'],'LTBR','L',true);	
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas	
		
		$this->Cell(30,5,'IMPORTE PASAJES:  ','L',0,'R');
		$this->Cell(70,5,$this->data[0]['total_pasaje'],'LTBR',0,'C',true);
		$this->Cell(30,5,'MONEDA:  ','L',0,'R');
		$this->Cell(60,5,$this->data[0]['desc_moneda'],'LTBR',0,'C',true);	
		$this->Cell(90,5,'','R',1,'R');
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
		$this->Cell(30,5,'IMPORTE VIÁTICOS:  ','L',0,'R');
		$this->Cell(70,5,$this->data[0]['total_viatico'],'LTBR',0,'C',true);
		$this->Cell(30,5,'TIPO DE PAGO:  ','L',0,'R');
		$this->Cell(60,5,$this->data[0]['tipo_pago'],'LTBR',0,'C',true);			
		$this->Cell(90,5,'','R',1,'R');
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
		$this->Cell(30,5,'GASTOS HOTEL:  ','L',0,'R');
		$this->Cell(70,5,$this->data[0]['total_hotel'],'LTBR',0,'C',true);
		$this->Cell(30,5,'TIPO RETENCIÓN:  ','L',0,'R');
		$this->Cell(60,5,$this->data[0]['sw_retencion'],'LTBR',0,'C',true);			
		$this->Cell(90,5,'','R',1,'R');
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
		$this->Cell(30,5,'OTROS:  ','L',0,'R');
		$this->Cell(70,5,$this->data[0]['total_otros'],'LTBR',0,'C',true);	
		$this->Cell(30,5,'RETENCIÓN:  ','L',0,'R');
		$this->Cell(60,5,$this->data[0]['retencion'],'LTBR',0,'C',true);	
		$this->Cell(90,5,'','R',1,'R');
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
		$this->Cell(30,5,'IMPORTE TOTAL:  ','L',0,'R');
		$this->Cell(70,5,$this->data[0]['total_general'],'LTBR',0,'C',true);		
		$this->Cell(90,5,'','',1,'R');
		$this->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
		$this->Cell(30,5,'SON:  ','L',0,'R');		
		$this->Cell(160,5,$this->data[0]['literal_total'].' '.$this->data[0]['desc_moneda'],'LTBR',0,'L',true);		
		$this->Cell(10,5,'','R',1,'R');
		$this->Cell(200,3,'','LR',1);		//linea de espacio entre filas
		
		$this->Cell(30,5,'DETALLE DE VIÁTICOS:  ','L',0,'R');
		$this->MultiCell(160,5,$this->data[0]['detalle_viaticos'],'LTBR','L',true);		
		$this->Cell(200,3,'','LR',1);		//linea de espacio entre filas
		
		$this->Cell(30,5,'OTROS GASTOS:  ','L',0,'R');	
		$this->MultiCell(160,5,$this->data[0]['detalle_otros'],'LTBR','L',true);		
		$this->Cell(200,3,'','LR',1);		//linea de espacio entre filas
		
		$this->Cell(30,5,'OBSERVACIONES:  ','L',0,'R');	
		$this->MultiCell(160,5,$this->data[0]['obs_viatico'],'LTBR','L',true);		
		$this->Cell(200,3,'','LR',1);		//linea de espacio entre filas
			
//----------------------
		//$this->SetFillColor(247, 187, 9);	//Naranja
		$this->SetFillColor(200, 200, 200);	//Plomo oscuro
		
		//verificamos si tiene la firma de aprobacion para mostrar la casilla
		if(strlen($this->data[0]['firma_aprobador']) > 5)
		{		
		//==============================================================	Permite Mostrar las 4 Firmas	
			$this->SetFont('Arial','B',6);
			$this->Cell(50,5,'SOLICITUD','LTBR',0,'C',true);
			$this->Cell(50,5,'APROBACIÓN','LTBR',0,'C',true);
			$this->Cell(50,5,'AUTORIZACIÓN','LTBR',0,'C',true);
			$this->Cell(50,5,'Vo. Bo.','LTBR',1,'C',true);
			$this->SetFont('Arial','B',8);
			
			$this->Cell(50,15,'','LTBR',0,'C');
			$this->Cell(50,15,'','LTBR',0,'C');
			$this->Cell(50,15,'','LTBR',0,'C');
			$this->Cell(50,15,'','LTBR',1,'C');
			
			/*$this->Cell(50,15,'','LTR',0,'C');	//este grupo oculta las lineas de divicion vertical 
			$this->Cell(50,15,'','LTR',0,'C');
			$this->Cell(50,15,'','LTR',0,'C');
			$this->Cell(50,15,'','LTR',1,'C');*/
			
			$this->SetFont('Arial','',6);
			$this->Cell(50,3,$this->data[0]['desc_empleado'],'LTBR',0,'C');
			$this->Cell(50,3,$this->data[0]['firma_aprobador'],'LTBR',0,'C');
			$this->Cell(50,3,$this->data[0]['firma_autorizador'],'LTBR',0,'C');
			$this->Cell(50,3,$this->data[0]['gerente_financiero'],'LTBR',1,'C');
			
			/*$this->Cell(50,3,'','LR',0,'C');		//este grupo oculta las lineas de las descripciones
			$this->Cell(50,3,'','LR',0,'C');
			$this->Cell(50,3,'','LR',0,'C');
			$this->Cell(50,3,'','LR',1,'C');*/
			
			$this->SetFont('Arial','B',6);
			$this->Cell(50,3,'Solicitante','LTBR',0,'C',true);
			$this->Cell(50,3,$this->data[0]['cargo_aprobador'],'LTBR',0,'C',true);	
			$this->Cell(50,3,$this->data[0]['cargo_autorizador'],'LTBR',0,'C',true);		
			$this->Cell(50,3,$this->data[0]['cargo_vo_bo'],'LTBR',1,'C',true);
			
			/*$this->Cell(50,3,'','LBR',0,'C',false);	//este grupo oculta los cargos de los firmantes
			$this->Cell(50,3,'','LBR',0,'C',false);
			$this->Cell(50,3,'','LBR',0,'C',false);
			$this->Cell(50,3,'','LBR',1,'C',false);	*/
		//=================================================================		
		}
		else
		{	
			$this->SetFont('Arial','B',6);
			$this->Cell(66.6,5,'SOLICITUD','LTBR',0,'C',true);		
			$this->Cell(66.7,5,'AUTORIZACIÓN','LTBR',0,'C',true);
			$this->Cell(66.7,5,'Vo. Bo.','LTBR',1,'C',true);
			$this->SetFont('Arial','B',8);
			
			$this->Cell(66.6,15,'','LTBR',0,'C');		
			$this->Cell(66.7,15,'','LTBR',0,'C');
			$this->Cell(66.7,15,'','LTBR',1,'C');
				
			$this->SetFont('Arial','',6);
			$this->Cell(66.6,3,$this->data[0]['desc_empleado'],'LTBR',0,'C');		
			$this->Cell(66.7,3,$this->data[0]['firma_autorizador'],'LTBR',0,'C');
			$this->Cell(66.7,3,$this->data[0]['gerente_financiero'],'LTBR',1,'C');
				
			$this->SetFont('Arial','B',6);
			$this->Cell(66.6,3,'Solicitante','LTBR',0,'C',true);		
			$this->Cell(66.7,3,$this->data[0]['cargo_autorizador'],'LTBR',0,'C',true);		
			$this->Cell(66.7,3,$this->data[0]['cargo_vo_bo'],'LTBR',1,'C',true);
		}		
	}
	//Pie de página
	function Footer() {
		$fecha=date("d-m-Y");
		$hora=date("h:i:s");
		$this->SetY(-16);
		$this->SetFont('Arial','',6);	
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - TESORO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');
	}
	function LoadData() {
		$criterio_filtro = ' VIATIC.id_viatico = ' . $this->id_viatico;
		$Custom = new cls_CustomDBTesoreria();
		$Custom->ListarReporteSolicitudViaticos( 'NULL', 'NULL', 'NULL', 'NULL', $criterio_filtro, $hidden_ep_id_financiador, $hidden_ep_id_regional, $hidden_ep_id_programa, $hidden_ep_id_proyecto, $hidden_ep_id_actividad );
		$resp = $Custom->salida;
		$this->data=$resp;

		/*echo"<pre>";
		print_r($this->data);
		echo"</pre>";*/
	}
	
}

//Instancia la clase PDF para generar el reporte
$pdf = new PDF ('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddFont('Tahoma','','tahoma.php');
$pdf->AddFont('Arial','','arial.php');
$pdf->SetMargins(5,5,5);
$pdf->SetAutoPageBreak(true,20);

//Obtiene los parámetros del Reporte
$pdf->id_viatico=$id_viatico;

//Obtiene los Datos del Reporte
$pdf->LoadData();

//Construye el pdf
$pdf->AddPage();

//Despliega el Reporte
$pdf->Output ();
?>