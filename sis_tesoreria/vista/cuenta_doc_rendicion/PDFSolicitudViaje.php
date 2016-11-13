<?php
/**
 * Autor :              Ana Maria Villegas Quispe
 * Descripcion:         Reporte de Recibo Provisional
 * Ultima Modificacion: 18/02/2010
 * Descripción mod:      Se añadió las firmas y se modificó los bordes y el pie de pagina
 * 						 Se modificó algunas celdas  y colores.	
 */
session_start();
require ('../../../lib/fpdf/fpdf.php');
require ('../../../lib/funciones.inc.php');

class PDF extends FPDF {
	var $sep_decim = '.';
	var $sep_mil = ',';
	var $id_devengado;
	var $data;

	function Header() {
		
	}
	//Pie de página
	function Footer() 
	{
		$data=$_SESSION['PDF_solicitud_viaje'];
	
		$fecha=date("d-m-Y");
		$hora=date("H:i:s");
		$this->SetY(-16);
		$this->SetFont('Arial','',6);
 IF ($_SESSION['ss_id_usuario']==120){
 
		//$this->Cell(70,3,'Usuario:  BUSTAMANTE BARRIENTOS MARIA CECILIA',0,0,'L');
		$this->Cell(70,3,'Usuario:  MANSILLA ANGULO JOVANNA VIRGINIA',0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: 17-10-2016',0,0,'L');
		//$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - TESORO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');
		}else
		{
		$this->Cell(70,3,'Usuario: '.$_SESSION["ss_nombre_usuario"],0,0,'L');
		$this->Cell(50,3,'Página '.$this->PageNo().' de {nb}',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Fecha: '.$data[0]['fecha_sol'],0,0,'L');
		//$this->Cell(18,3,'Fecha: '.$fecha,0,0,'L');
		$this->ln(3);
		$this->Cell(70,3,'Sistema: ENDESIS - TESORO',0,0,'L');
		$this->Cell(50,3,'',0,0,'C');
		$this->Cell(52,3,'',0,0,'L');
		$this->Cell(18,3,'Hora: '.$hora,0,0,'L');
		}
	}
	
}

//Instancia la clase PDF para generar el reporte
$pdf = new PDF ('P','mm','Letter');
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->AddFont('Arial','','arial.php');
$pdf->SetMargins(5,5,5);
$pdf->SetAutoPageBreak(true,20);
$data=$_SESSION['PDF_solicitud_viaje'];
$solicitud_detalle=$_SESSION['PDF_solicitud_viaje_det'];
$estado=$_SESSION['PDF_estado'];
$numero=$data[0]['nro_documento'];


//$pdf->Image ( '../../../lib/images/logo_reporte.jpg', 165, 8, 36, 13 );
$pdf->Image ( '../../../lib/images/logo_reporte.jpg', 5, 8, 36, 13 );
$pdf->ln(10);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(200,5,'SOLICITUD DE VIAJE',0,1,'C');

//if ($estado=='borrador')
if ( strlen($numero) < 2 )
{
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(200,5,'(Vista Previa)',0,1,'C');
}
$pdf->SetFont('Arial','B',10);		
$pdf->Cell(200,5,'Nº '.$data[0]['nro_documento'],'',1,'R');
$pdf->Ln(5);

$pdf->Line($pdf->GetX(),$pdf->GetY(),$pdf->GetX(),180);
$pdf->Line($pdf->GetX()+200,$pdf->GetY(),$pdf->GetX()+200,180);
		
$pdf->SetFillColor(200, 200, 200);	//Plomo oscuro
		
$pdf->SetFont('Arial','B',8);
$pdf->Cell(200,5,'DATOS GENERALES','LTBR',1,'C',true);
		
$pdf->SetFont('Arial','',6);
$pdf->Cell(200,3,'','LR',1);		
	
$pdf->SetFillColor(230 , 230, 230);	//Plomo claro
		
$pdf->Cell(30,5,'NOMBRE SOLICITANTE:  ','L',0,'R');
$pdf->Cell(70,5,$data[0]['person_nombre'],'LTBR',0,'L',true);
$pdf->Cell(50,5,'FECHA SOLICITUD:  ','L',0,'R');
$pdf->Cell(40,5,$data[0]['fecha_sol'],'LTBR',0,'C',true);		
$pdf->Cell(10,5,'','R',1,'R');
$pdf->Cell(200,2,'','LR',1);		//linea de espacio entre filas

$pdf->Cell(30,5,'CARGO:  ','L',0,'R');
$pdf->Cell(70,5,$data[0]['nombre_cargo'],'LTBR',0,'L',true);
$pdf->Cell(50,3,'FECHA LIMITE ENTREGA EN CONTABILIDAD:  ','',0,'R');
$pdf->Cell(40,5,$data[0]['fecha_limite_rendicion'],'LTBR',1,'C',true);
$pdf->Cell(200,2,'','LR',1);		//linea de espacio entre filas	

$pdf->Cell(30,5,'UNIDAD SOLICITANTE:  ','L',0,'R');
$pdf->Cell(70,5,$data[0]['unireg'],'LTBR',1,'L',true);
//$pdf->Cell(30,5,'CARGO:  ','',0,'R');
//$pdf->Cell(60,5,$data[0]['nombre_cargo'],'LTBR',1,'L',true);
$pdf->Cell(200,2,'','LR',1);		//linea de espacio entre filas		
		
		$pdf->Cell(30,5,'MOTIVO DEL VIAJE:  ','L',0,'R');
		$pdf->MultiCell(160,5,$data[0]['motivo'],'LTBR','L',true);
		$pdf->Cell(200,3,'','LR',1);		//linea de espacio entre filas
		
		$pdf->SetFillColor(200, 200, 200);	//Plomo oscuro
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(200,5,'INFORMACIÓN DE VIAJE','LTBR',1,'C',true);
		
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(200,3,'','LR',1);
				
		$pdf->SetFillColor(230 , 230, 230);	//Plomo claro
		
		$pdf->Cell(30,5,'FECHA SALIDA:  ','L',0,'R');
		$pdf->Cell(70,5,$data[0]['fecha_ini'],'LTBR',0,'C',true);
		$pdf->Cell(50,5,'FECHA RETORNO:  ','L',0,'R');
		$pdf->Cell(40,5,$data[0]['fecha_fin'],'LTBR',0,'C',true);		
		$pdf->Cell(10,5,'','R',1,'R');
		$pdf->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
	
		$pdf->Cell(30,5,'RECORRIDO:  ','L',0,'R');		
		$pdf->MultiCell(160,5,$data[0]['recorrido'],'LTBR','L',true);		
		$pdf->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
		$pdf->Cell(30,5,'TIPO TRANSPORTE:  ','L',0,'R');
		$pdf->Cell(70,5,substr ($data[0]['tipo_transporte'], 0, -1),'LTBR',0,'L',true);		
		$pdf->Cell(50,5,'Nº DÍAS VIAJE:  ','L',0,'R');
		$pdf->Cell(40,5,($data[0]['nro_dias']==0)?1:$data[0]['nro_dias'],'LTBR',0,'C',true);		
		$pdf->Cell(10,5,'','',1,'R');
		$pdf->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
	
		$pdf->Cell(30,5,'CATEGORÍA:  ','L',0,'R');
		$pdf->MultiCell(160,5,$data[0]['desc_categoria'],'LTBR','L',true);		
		/*$pdf->Cell(30,5,'','',0,'');
		$pdf->Cell(60,5,'','',0,'C');		
		$pdf->Cell(10,5,'','',1,'R');
		*/$pdf->Cell(200,3,'','LR',1);		//linea de espacio entre filas
				
//----------------------		
		//$pdf->SetFillColor(247, 187, 9);	//Naranja
		$pdf->SetFillColor(200, 200, 200);	//Plomo oscuro
		
		$pdf->SetFont('Arial','B',8);
		$pdf->Cell(200,5,'PRESUPUESTO GLOBAL DEL GASTO','LTBR',1,'C',true);

		
		
 		$pdf->Ln(2);
 		//$pdf->SetX(15);
 		$pdf->SetFillColor(230 , 230, 230);	//Plomo claro
 		$pdf->SetFont('Arial','B',7);
 		$pdf->Cell(40,3,'DESCRIPCIÓN ','LTR',0,'C',true);  
 		$pdf->Cell(14,3,'TIPO ','LTR',0,'C',true); 
 		$pdf->Cell(18,3,'IMPORTE ','LTR',0,'C',true);  
 		$pdf->Cell(18,3,'IMPORTE ','LTR',0,'C',true);  
 		$pdf->Cell(52,3,'PRESUPUESTO ','LTR',0,'C',true);  
 		$pdf->Cell(40,3,'OBSERVACIONES','LTR',0,'C',true);  
 		$pdf->Cell(18,3,'DISPONIBLE','LTR',1,'C',true);  
 
 		$pdf->Cell(40,3,' ','LBR',0,'C',true);  
 		$pdf->Cell(14,3,'DESTINO ','LBR',0,'C',true); 
 		$pdf->Cell(18,3,'SOLICITADO ','LBR',0,'C',true);  
 		$pdf->Cell(18,3,'ENTREGADO ','LBR',0,'C',true);  
 		$pdf->Cell(52,3,' ','LBR',0,'C',true);  
 		$pdf->Cell(40,3,'','LBR',0,'C',true);  
 		$pdf->Cell(18,3,'','LBR',1,'C',true);  
 
 		
		$pdf->SetWidths(array(0,40,14,18,18,52,40,18));
		$pdf->SetFills(array(0,0,0,0,0,0,0,0));
 		$pdf->SetAligns(array('L','L','L','R','R','L','L'));
 		$pdf->SetVisibles(array(0,1,1,1,1,1,1,1));
 		$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6));
 		$pdf->SetFontsStyles(array('','','','','','','',''));
 		$pdf->SetDecimales(array(0,0,0,2,2,0,0,0));
 		$pdf->SetSpaces(array(3,3,3,3,3,3,3,3));
 		$pdf->SetFormatNumber(array(0,0,0,1,1,0,0,0));
		$total_importe_solicitado=0;
		$total_importe_entregado=0;
		for ($i=0;$i<sizeof($solicitud_detalle);$i++){
 	 		
 	 		if($solicitud_detalle[$i][7]=='NO DISPONIBLE'){
 	 		$pdf->SetFontsColors(array(array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(237,10,3)));
 	 			
 	 		}
	  		$pdf->MultiTabla($solicitud_detalle[$i],0,3,3,6,1);
	  		$pdf->SetFontsColors(array(array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0),array(0,0,0)));
	  		
	  		
	  		$total_importe_solicitado=$total_importe_solicitado+$solicitud_detalle[$i][3];
	  		$total_importe_entregado=$total_importe_entregado+$solicitud_detalle[$i][4];
   		}
   		$pdf->SetFont('Arial','',6);
   		$pdf->Cell(54,5,'TOTAL','L',0,'R');
   		$pdf->Cell(18,5,number_format($total_importe_solicitado,2),1,0,'R');
   		$pdf->Cell(18,5,number_format($total_importe_entregado,2),1,0,'R');
   		$pdf->Cell(110,5,'','R',1);
		
		$pdf->Cell(200,3,'','LR',1);		
		//$pdf->SetFillColor(249 , 221, 113);	//Amarillo
		
		$pdf->Cell(30,5,'(IMP. ENTREGADO) SON:  ','L',0,'R');		
		$pdf->Cell(160,5,$pdf->num2letras($total_importe_entregado,false),'LTBR',0,'L',true);		
		$pdf->Cell(10,5,'','R',1,'R');
		$pdf->Cell(200,3,'','LR',1);		//linea de espacio entre filas
		
		
		$pdf->Cell(30,5,'MONEDA:  ','L',0,'R');
		$pdf->Cell(60,5,$data[0]['simbolo'],'LTBR',0,'C',true);	

		$pdf->Cell(30,5,'TIPO DE PAGO:  ','L',0,'R');
		$pdf->Cell(60,5,$data[0]['tipo_pago'],'LTBR',0,'C',true);	
		$pdf->Cell(20,5,'','R',1);		
		$pdf->Cell(200,2,'','LR',1);		//linea de espacio entre filas
		
		
		
		$pdf->Cell(30,5,'TIPO RETENCIÓN:  ','L',0,'R');
	
		switch ($data[0]['tipo_contrato']) {
			case "planta":
				//echo "Planta - Sin retención";
				$pdf->Cell(60,5,"Planta - Sin retención",'LTBR',0,'C',true);
				break;
			case "contrato_cr":
				//echo "Contrato - Sin retención";
				$pdf->Cell(60,5,"Contrato",'LTBR',0,'C',true);
				break;
			case "comision":
				//echo "Comisión - Con retención";
				$pdf->Cell(60,5,"Comisión - Con retención",'LTBR',0,'C',true);
				break;
		}
		
		$pdf->Cell(110,5,'','R',1);	
		$pdf->Cell(200,2,'','LR',1);			
		$y_obs=$pdf->GetY();
		$pdf->Cell(30,5,'OBSERVACIÓN:  ','L',0,'R');	
		$pdf->MultiCell(160,5,$data[0]['observaciones'],'LTBR','L',true);	
		$pdf->SetXY(195,$y_obs);
		$pdf->Cell(10,5,'','R',1);		
		$pdf->Cell(200,3,'','LR',1);		//linea de espacio entre filas
			
//----------------------
		//$pdf->SetFillColor(247, 187, 9);	//Naranja
		$pdf->SetFillColor(200, 200, 200);	//Plomo oscuro
		$y_pos=$pdf->GetY();
		//$pdf->Cell(200,5,'askjdf'.$y_pos,1,1);
		if($y_pos>=235){
			$pdf->Cell(200,0.002,'',1,1);
			$pdf->AddPage();
		}
		//verificamos si tiene la firma de aprobacion para mostrar la casilla
		if(strlen($pdf->data[0]['firma_aprobador']) > 5)
		{		
		//==============================================================	Permite Mostrar las 4 Firmas	
		    /*if ($data[0]['nro_dias']>=5){
		    	
		    }*/
			$pdf->SetFont('Arial','B',6);
			$pdf->Cell(50,5,'SOLICITUD','LTBR',0,'C',true);
			$pdf->Cell(50,5,'APROBACIÓN','LTBR',0,'C',true);
			
		if ($data[0]['nro_dias']>=5){
			$pdf->Cell(50,5,'AUTORIZACIÓN','LTBR',0,'C',true);
		    $pdf->Cell(50,5,'Vo. Bo.','LTBR',1,'C',true);
			
		    }
		    else {
                $pdf->Cell(100,5,'AUTORIZACIÓN','LTBR',1,'C',true);
		    	//$pdf->Cell(100,5,'Vo. Bo.','LTBR',1,'C',true);
		    }
			$pdf->SetFont('Arial','B',8);
			
			$pdf->Cell(50,15,'','LTBR',0,'C');
			$pdf->Cell(50,15,'','LTBR',0,'C');
			
			if ($data[0]['nro_dias']>=5){
			  	$pdf->Cell(50,15,'','LTBR',0,'C');
			    $pdf->Cell(50,15,'','LTBR',1,'C');
			
			}else{
				$pdf->Cell(100,15,'','LTBR',1,'C');
			}
			
			
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(50,3,$data[0]['person_nombre'],'LTBR',0,'C');
			$pdf->Cell(50,3,$data[0]['firma_aprobador'],'LTBR',0,'C');
			if ($data[0]['nro_dias']>=5){
			  $pdf->Cell(50,3,$data[0]['firma_autorizador'],'LTBR',0,'C');
			  $pdf->Cell(50,3,$data[0]['gerente_financiero'],'LTBR',1,'C');	
			}else{
				$pdf->Cell(100,3,$data[0]['firma_autorizador'],'LTBR',1,'C');
			  
			}
			
			
			
			$pdf->SetFont('Arial','B',6);
			$pdf->Cell(50,3,'Solicitante','LTBR',0,'C',true);
			$pdf->Cell(50,3,$data[0]['cargo_aprobador'],'LTBR',0,'C',true);	
			if ($data[0]['nro_dias']>=5){
				$pdf->Cell(50,3,$data[0]['cargo_autorizador'],'LTBR',0,'C',true);	
				$pdf->Cell(50,3,$data[0]['cargo_vo_bo'],'LTBR',1,'C',true);
				
			}else{
			    $pdf->Cell(50,3,$data[0]['cargo_autorizador'],'LTBR',1,'C',true);	
			}	
			
			
		//=================================================================		
		}
		else
		{
			$pdf->SetFont('Arial','B',6);
			
		//	$pdf->Cell(66.7,5,'AUTORIZACIÓN','LTBR',0,'C',true);
			if ($data[0]['nro_dias']>5){
				$pdf->Cell(66.6,5,'SOLICITUD','LTBR',0,'C',true);		
				$pdf->Cell(66.7,5,'AUTORIZACIÓN','LTBR',0,'C',true);
				$pdf->Cell(66.7,5,'Vo. Bo.','LTBR',1,'C',true);
			}else{
				$pdf->Cell(100,5,'SOLICITUD','LTBR',0,'C',true);		
				$pdf->Cell(100,5,'AUTORIZACIÓN','LTBR',1,'C',true);
				
			}
			
			$pdf->SetFont('Arial','B',8);
			
		
			
			if ($data[0]['nro_dias']>5){
				$pdf->Cell(66.6,15,'','LTBR',0,'C');		
			$pdf->Cell(66.7,15,'','LTBR',0,'C');
			$pdf->Cell(66.7,15,'','LTBR',1,'C');	
			}else{
				$pdf->Cell(100,15,'','LTBR',0,'C');		
				$pdf->Cell(100,15,'','LTBR',1,'C');
			}
			
				
			$pdf->SetFont('Arial','',6);
			//$pdf->Cell(66.6,3,$data[0]['person_nombre'],'LTBR',0,'C');		
			if ($data[0]['nro_dias']>5){
				$pdf->Cell(66.6,3,$data[0]['person_nombre'],'LTBR',0,'C');		
				$pdf->Cell(66.7,3,$data[0]['firma_autorizador'],'LTBR',0,'C');
				$pdf->Cell(66.7,3,$data[0]['gerente_financiero'],'LTBR',1,'C');
				
			}else{
				$pdf->Cell(100,3,$data[0]['person_nombre'],'LTBR',0,'C');		
				$pdf->Cell(100,3,$data[0]['firma_autorizador'],'LTBR',1,'C');
			}
			
			
			$pdf->SetFont('Arial','B',6);
			//$pdf->Cell(66.6,3,'Solicitante','LTBR',0,'C',true);	
        	//$pdf->Cell(66.7,3,$data[0]['cargo_autorizador'],'LTBR',0,'C',true);		
        	if ($data[0]['nro_dias']>5){
        		$pdf->Cell(66.6,3,'Solicitante','LTBR',0,'C',true);	
        		$pdf->Cell(66.7,3,$data[0]['cargo_autorizador'],'LTBR',0,'C',true);		
        		$pdf->Cell(66.7,3,$data[0]['cargo_vo_bo'],'LTBR',1,'C',true);	
        	}else{
        		$pdf->Cell(100,3,'Solicitante','LTBR',0,'C',true);	
        		$pdf->Cell(100,3,$data[0]['cargo_autorizador'],'LTBR',1,'C',true);		
        		
        	}
			
			
			
			/* ana
			$pdf->SetFont('Arial','B',6);
			$pdf->Cell(66.6,5,'SOLICITUD','LTBR',0,'C',true);		
			$pdf->Cell(66.7,5,'AUTORIZACIÓN','LTBR',0,'C',true);
			$pdf->Cell(66.7,5,'Vo. Bo.','LTBR',1,'C',true);
			$pdf->SetFont('Arial','B',8);
			
			$pdf->Cell(66.6,15,'','LTBR',0,'C');		
			$pdf->Cell(66.7,15,'','LTBR',0,'C');
			$pdf->Cell(66.7,15,'','LTBR',1,'C');
				
			$pdf->SetFont('Arial','',6);
			$pdf->Cell(66.6,3,$data[0]['person_nombre'],'LTBR',0,'C');		
			$pdf->Cell(66.7,3,$data[0]['firma_autorizador'],'LTBR',0,'C');
			$pdf->Cell(66.7,3,$data[0]['gerente_financiero'],'LTBR',1,'C');
			
			
			$pdf->SetFont('Arial','B',6);
			$pdf->Cell(66.6,3,'Solicitante','LTBR',0,'C',true);	
        	$pdf->Cell(66.7,3,$data[0]['cargo_autorizador'],'LTBR',0,'C',true);		 
			$pdf->Cell(66.7,3,$data[0]['cargo_vo_bo'],'LTBR',1,'C',true);
			*/
		}
		 
		
		$pdf->SetFont('Arial','',6);
		//echo $data[0]['fecha_sol']>'02-05-2015'; exit;
		if($data[0]['fecha_sol']>'01-06-2015'){
			$pdf->SetFont('Arial','B',7);
			$pdf->MultiCell(200,3,'IMPORTANTE','','L',false);
			$pdf->SetFont('Arial','',6);
			$pdf->MultiCell(200,3,'* Personal de planta y consultores, posteriormente al viaje deberán PRESENTAR al Departamento de Economía Empresarial (DEEM - Contabilidad) su RENDICIÓN DE CUENTAS DENTRO LOS CINCO (5) días hábiles siguientes a su retorno.','','L',false);
			$pdf->MultiCell(200,3,'* En el PERIODO DE CIERRE, establecido por la Gerencia Nacional de Desarrollo Empresarial y Ecnonomía (GDEE), las RENDICIONES DE CUENTAS deben PRESENTARSE AL DIA SIGUIENTE DE SU LLEGADA.','','L',false);
			$pdf->MultiCell(200,3,'* Rendiciones presentadas, HASTA UN MÁXIMO DE OCHO (8) DÍAS HÁBILES, deberán contar con un INFORME CON JUSTIFICACIONES VÁLIDAS dirigido al GNEE. Informes sin justificaciones válidas serán rechazadas.','','L',false);
			$pdf->MultiCell(200,3,'* Rendiciones presentadas, POSTERIORMENTE A LOS OCHO (8) DÍAS HÁBILES, SERÁN CONSIDERADAS COMO GASTOS PARTICULARES y se aplicaran sanciones del Art. 51 del Reglamento de Viaje en Comisión.','','L',false);
			$pdf->MultiCell(200,3,'* CUMPLIDO EL PLAZO establecido de presentación de descargos, ENDE no reconocerá ningún gasto y EL SOLICITANTE ASUMIRÁ EL IMPORTE NO RENDIDO mediante descuento mensual a su remuneración.','','L',false);
		}else{
		
		
		$pdf->MultiCell(200,3,'* Todo el personal de planta y consultor de la Empresa Nacional de Electricidad que realizó el viaje, debe presentar al Departamento de Contabilidad la rendición de gastos DENTRO DE LOS CINCO (5) días hábiles siguientes a su retorno.','','L',false);	
		$pdf->MultiCell(200,3,'* Excepcionalmente a lo indicado en el párrafo precedente, se establece que en el PERIODO DE CIERRE, las rendiciones de gastos deben presentarse AL DIA SIGUIENTE DE SU LLEGADA.','','L',false);	
		$pdf->MultiCell(200,3,'* Las rendiciones que no sean presentadas en el plazo establecido deberán ser justificadas en su informe de viaje y autorizadas por escrito por el Gerente Administrativo Financiero para su recepción en el Departamento de Contabilidad.','','L',false);	
		$pdf->MultiCell(200,3,'* Pasado el plazo establecido para la presentacion de la documentación para el descargo de fondos asignados (total o parcial), la Empresa no reconocerá los gastos y EL INTERESADO ASUMIRÁ EL MONTO DEL IMPORTE NO RENDIDO a travéz del descuento de su remuneracion del mes siguiente, salvo devolución del importe mediante deposito.','','L',false);	
		}
		
//Despliega el Reporte
$pdf->Output ();
?>