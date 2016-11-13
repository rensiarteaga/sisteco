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
	var $imprimir_firma=0;
	var $fecha_imp;
	
	function Header() {
		//if($this->PageNo()==1){
		$this->Image ( '../../../../lib/images/logo_reporte.jpg', 176, 6, 36, 13 );
		$this->ln(10);
		$this->SetFont('Arial','B',14);
		$this->Cell(50,5,'',0,0,'C');
		$this->Cell(100,5,'SOLICITUD DE PAGO',0,0,'C');
		$this->SetFont('Arial','',10);
		$this->Cell(10,5,'',0,0,'R');
		$this->Cell(40,5,$this->data[0]['correl'],'LRTB',1,'C');

		$this->SetFont('Arial','B',10);
		$this->Cell(200,5,'(Expresado en '.$this->data[0]['moneda'].')',0,1,'C');
		$this->Cell(200,5,'Fecha: '.$this->data[0]['fecha_devengado'],0,1,'C');
		$this->Ln(5);
		//}
		$this->SetFont('Arial','B',8);
		$this->Cell(45,5,'CONCEPTO DE GASTO:  ','LTB',0,'L');
		$this->SetFont('Arial','',8);
		$this->MultiCell(155,5,$this->data[0]['desc_ingas_item_serv'],'RTB','L');
		//$this->Line($this->GetX(),$this->GetY(),$this->GetX()+200,$this->GetY());

		$this->SetFont('Arial','B',8);
		$this->Cell(45,5,'PROVEEDOR:  ','LB',0,'L');
		$this->SetFont('Arial','',8);
		$this->MultiCell(155,5,$this->data[0]['desc_proveedor'],'RB','L');
		
		//RCM: 09-09-09 se aumenta forma de pago 
		$this->SetFont('Arial','B',8);
		$this->Cell(45,5,'FORMA DE PAGO:  ','LB',0,'L');
		$this->SetFont('Arial','',8);
		$this->MultiCell(155,5,$this->data[0]['forma_pago'],'RB','L');
		// FIN RCM

		$this->SetFont('Arial','B',8);
		$this->Cell(45,5,'IMPORTE:','L',0);
		$this->SetFont('Arial','',8);
		$this->Cell(155,5,number_format($this->data[0]['importe_devengado'],2),'R',1,'L');
		$this->SetFont('Arial','B',8);
		$this->Cell(45,5,'SON:  ','LB',0,'L');
		$this->SetFont('Arial','',8);
		$this->MultiCell(155,5,$this->data[0]['literal'],'RB','L');

		$this->SetFont('Arial','B',8);
		$this->Cell(45,5,'PARTIDA PRESUPUESTARIA:','LB',0);
		$this->SetFont('Arial','',8);
		$this->Cell(125,5,$this->data[0]['partida'],'B',0,'L');

		$this->SetFont('Arial','B',7);
		if($this->data[0]['forma_pago']!='Efectivo'){
			$this->Cell(30,5,'DISPONIBLE','RB',1,'R');
		} else {
			$this->Cell(30,5,'','RB',1,'C');
		}

		$this->SetFont('Arial','B',8);
		//$this->Cell(45,5,'OBSERVACIONES:','L',0);
		$this->SetFont('Arial','B',8);
		$this->MultiCell(200,5,'OBSERVACIONES:                         '.$this->data[0]['observaciones'],'LBR','L');

		$this->Cell(200,1,'','LTR',1);

	}
	//Pie de página
	function Footer() {
		$this->Line($this->GetX(),$this->GetY(),$this->GetX()+200,$this->GetY());
		//RCM: 02-09-2009 cambio por requerimiento de usuario
		//$fecha=date("d-m-Y");
		$fecha=date($this->data[0]['fecha_devengado']);
		//Fin RCM
		$hora=date("h:i:s");
		$this->SetY(-18);//-7
		$this->SetFont('Arial','',6);



		//echo "page no:".$this->PageNo().' de {nb}';
		//exit;
		if($this->imprimir_firma==1){
			$this->imprimir_firma=0;
			//if($this->PageNo()=='{nb}'){
			$this->Cell(50,5,'','',1,'C');
			$this->Cell(75,5,'',0,0,'C');
			$this->Cell(50,5,'FIRMA AUTORIZADA',0,1,'C');
			$this->Ln(2);
		} else{
			$this->Ln(8);
		}
		
		

		
		
		//$this->Cell(205,0.2,'',1,1);
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(60,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(60,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');

		/*if($this->imprimir_firma){
		$this->Close();
		}*/

	}

	



	function LoadData() {
		$criterio_filtro = ' DEVENG.id_devengado = ' . $this->id_devengado;
		$Custom = new cls_CustomDBTesoreria();
		$Custom->ReporteDevengadoServiciosFin( 'NULL', 'NULL', 'NULL', 'NULL', $criterio_filtro, $hidden_ep_id_financiador, $hidden_ep_id_regional, $hidden_ep_id_programa, $hidden_ep_id_proyecto, $hidden_ep_id_actividad );
		$resp = $Custom->salida;
		$this->data=$resp;

		/*echo"<pre>";
		print_r($this->data);
		echo"</pre>";*/
	}

	function crear_pdf(){
		//Despliega el detalle
		$this->Cell(200,1,'','LR',1);
		$this->Cell(200,1,'','LR',1);
		$this->Cell(200,1,'','LR',1);
		$this->Cell(200,1,'','LR',1);
		$this->SetFont('Arial','B',8);
		$this->Cell(200,5,'DETALLE DE ASIGNACIONES APROBADAS:','LR',1);
		$this->Cell(200,1,'','LR',1);
		$this->Cell(200,1,'','LR',1);
		$this->Cell(200,1,'','LR',1);
		$this->SetFont('Arial','',8);
		$this->SetWidths(array(40,70,35,55));
		$this->SetVisibles(array(1,1,1,1));
		$this->SetAligns(array('L','L','L','L'));
		$this->SetFonts(array('Arial','Arial','Arial','Arial'));
		$this->SetFontsSizes(array(8,8,8,8));
		$this->SetFontsStyles(array('B','','B',''));
		//$this->SetSpaces(array(4,4,4,4));
		$this->SetSpaces(array(3.5,3.5,3.5,3.5));
		$this->multitabla_borde_externo=1;

		for($i=0;$i<sizeof($this->data);$i++){
			if($i==sizeof($this->data)-1){
				$this->imprimir_firma=1;
			}

			$this->SetDecimales(array(0,0,0,0));
			$array[0]=array('UNIDAD ORGANIZACIONAL:',$this->data[$i]['unidad_org'],'PROGRAMA:',$this->data[$i]['nombre_programa']);
			//$this->MultiTabla($array,2,4,3.5,6);
			$array[1]=array('FINANCIADOR:',$this->data[$i]['nombre_financiador'],'SUBPROGRAMA:',$this->data[$i]['nombre_proyecto']);
			//$this->MultiTabla($array,2,4,3.5,6);
			$array[2]=array('REGIONAL:',$this->data[$i]['nombre_regional'],'ACTIVIDAD:',$this->data[$i]['nombre_actividad']);
			//$this->MultiTabla($array,2,4,3.5,6);
			$this->SetDecimales(array(0,0,0,2));
			$array[3]=array('PORCENTAJE:',$this->data[$i]['porcentaje_devengado'],'IMPORTE ASIGNADO:',$this->data[$i]['importe_detalle']);

			foreach ($array as $row) {
				$this->MultiTabla($row,2,4,3.5,8);
			}

			//Verifica que no llegue al tope para mandar a la otra página
			/*if($this->GetY()>245){
			while($this->GetY()<=263){
			$this->Cell(200,4,'','LR',1);
			}
			$this->Cell(200,4,'','LBR',1);
			$this->AddPage();
			}*/


			$this->SetFont('Arial','B',8);
			$this->Cell(50,5,'RESPONSABLE DE APROBACIÓN:','L',0);
			$this->SetFont('Arial','',8);
			$this->Cell(150,5,$this->data[$i]['responsable_aprob'],'R',1);
			$this->Cell(200,1,'','LR',1);
			$this->Cell(200,1,'','LR',1);
			/*if($i<sizeof($this->data)-1){
			$this->Cell(200,1,'','LR',1);
			$this->Cell(200,1,'','LR',1);
			$this->Cell(200,1,'','LR',1);
			$this->Cell(200,1,'','LR',1);
			//$this->Cell(200,1,'','LR',1);
			}
			else{
			$this->Cell(200,1,'','LR',1);
			}*/
		}

		$this->Line($this->GetX(),$this->GetY(),$this->GetX()+200,$this->GetY());

		//Firma
		/*$this->Ln(20);
		$this->SetFont('Arial','',8);
		$this->Cell(75,5,'',0,0,'C');
		//$this->Cell(50,5,$this->data[0]['firma_autorizada'],'',1,'C');
		$this->Cell(50,5,'','',1,'C');
		$this->Cell(75,5,'',0,0,'C');
		$this->Cell(50,5,'FIRMA AUTORIZADA',0,1,'C');*/

	}
}

//Instancia la clase PDF para generar el reporte
$pdf = new PDF ('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddFont('Tahoma','','tahoma.php');
$pdf->AddFont('Arial','','arial.php');
$pdf->SetMargins(10,10,10);
$pdf->SetAutoPageBreak(true,25);

//Obtiene los parámetros del Reporte
$pdf->id_devengado=$id_devengado;

//Obtiene los Datos del Reporte
$pdf->LoadData();

//Construye el pdf
$pdf->AddPage();
$pdf->crear_pdf();

//Despliega el Reporte
$pdf->Output ();

?>