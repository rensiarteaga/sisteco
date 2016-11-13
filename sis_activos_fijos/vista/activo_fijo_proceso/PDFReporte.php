<?php

	session_start();
	require('../../../lib/fpdf/fpdf.php');
	define('FPDF_FONTPATH','font/');
	include_once("../../control/LibModeloActivoFijo.php");
	
	class PDF extends FPDF {
		var $codigo_proceso;
		
		function PDF($orientation='L',$unit='mm',$format='Letter'){
			$this->FPDF($orientation,$unit,$format);
			$this->codigo_proceso=substr($_SESSION['PDF_desc_proceso'],0,(strpos($_SESSION['PDF_desc_proceso'],'-')-1));
		}
		
		function Header() {
			$this->Image ( '../../../lib/images/logo_reporte.jpg', 165, 8, 36, 13 );
			$this->ln(20);
			$this->SetFont('Arial','B',14);
			
			// tipo de formulario
			if($this->codigo_proceso=='REACT')
				$this->Cell(200,5,'FORMULARIO DE TRANSFERENCIA DE ACTIVO FIJO',0,1,'C');
			
			if($this->codigo_proceso=='REAEMP')
				$this->Cell(200,5,'FORMULARIO DE TRANSFERENCIA DE ACTIVOS FIJOS POR EMPLEADO',0,1,'C');
			
			if ($this->codigo_proceso=='DEVOL')
				$this->Cell(200,5,'FORMULARIO DE DEVOLUCION DE ACTIVO FIJO',0,1,'C');
			
			if ($this->codigo_proceso=='CUST')
				$this->Cell(200,5,'FORMULARIO DE CUSTODIO DE ACTIVO FIJO',0,1,'C');
			
			if ($this->codigo_proceso=='DEVCUS')
				$this->Cell(200,5,'FORMULARIO DE DEVOLUCION DE CUSTODIO DE ACTIVO FIJO',0,1,'C');
			
			else if($this->codigo_proceso=='ASIG'){
				if($_SESSION['PDF_sw_prestamo']=='si' && $_SESSION['PDF_sw_devol_prestamo']=='no')
					$this->Cell(200,5,'FORMULARIO DE PRESTAMO DE ACTIVOS FIJOS',0,1,'C');
				elseif ($_SESSION['PDF_sw_prestamo']=='si' && $_SESSION['PDF_sw_devol_prestamo']=='si' &&$_SESSION['PDF_estado']=='finalizado')
					$this->Cell(200,5,'FORMULARIO DE DEVOLUCIÓN DE ACTIVOS FIJOS PRESTADOS',0,1,'C');
				elseif ($_SESSION['PDF_sw_prestamo']=='si' && $_SESSION['PDF_sw_devol_prestamo']=='si' &&$_SESSION['PDF_estado']!='finalizado')
					$this->Cell(200,5,'FORMULARIO DE DEVOLUCIÓN PARCIAL DE ACTIVOS FIJOS PRESTADOS',0,1,'C');
				else
				$this->Cell(200,5,'FORMULARIO DE ASIGNACION DE ACTIVOS FIJOS',0,1,'C');
			}
			
			$this->SetFont('Arial','B',10);
			$this->Ln(5);
			if($this->page!=1){
			$this->SetFont('Arial','',6);
			$this->SetFillColor(230 , 230, 230);//Plomo claro
			$this->Cell(7,3,'NO','TRL',0,'C',true);
			$this->Cell(15,3,'CODIGO','TRL',0,'C',true);
			$this->Cell(33,3,'DENOMINACION ','TRL',0,'C',true);
			$this->Cell(60,3,'DESCRIPCION','TRL',0,'C',true);
			$this->Cell(25,3,'SUB TIPO ACTIVO','TRL',0,'C',true);
			$this->Cell(60,3,'OBSERVACIONES','TRL',1,'C',true);
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
			$this->Cell(70,3,'Sistema: ENDESIS-ACTIF',0,0,'L');
			$this->Cell(50,3,'',0,0,'C');
			$this->Cell(52,3,'',0,0,'L');
			$this->Cell(18,3,'Hora: '.$hora,0,0,'L');
		}
	}

	//Instancia la clase PDF para generar el reporte
	$pdf = new PDF ('P','mm','Letter');
	$pdf->AddPage();
	$pdf->AliasNbPages();
	$pdf->AddFont('Tahoma','','tahoma.php');
	$pdf->AddFont('Arial','','arial.php');
	$pdf->SetAutoPageBreak(true,20);
	
	//-----------para los datos generales
	$pdf->SetFillColor(200, 200, 200);//Plomo oscuro
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(200,5,'DATOS GENERALES','LTBR',1,'C',true);
	
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(200,3,'','LR',1);
	
	$pdf->SetFillColor(230 , 230, 230);//Plomo claro
	
	$pdf->Cell(30,5,'DEPARTAMENTO AF:  ','L',0,'R');
	$pdf->Cell(70,5,''.utf8_decode($_SESSION['PDF_desc_depto_des']),'LTBR',0,'L',true);
	
	if($pdf->codigo_proceso=='REACT' || $pdf->codigo_proceso=='REAEMP' || $pdf->codigo_proceso=='DEVOL'){
		$pdf->Cell(30,5,'EMPLEADO ORIGEN:  ','L',0,'R');
		$pdf->Cell(70,5,''.utf8_decode($_SESSION['PDF_desc_empleado_ori']),'LTBR',1,'L',true);
		$pdf->Cell(200,2,'','LR',1);
	}
	
	//mflores 23-09-11 para los custodios
	elseif ($pdf->codigo_proceso=='CUST'){
		$pdf->Cell(30,5,'RESPONSABLE:  ','L',0,'R');
		$pdf->Cell(70,5,''.utf8_decode($_SESSION['PDF_desc_empleado_ori']),'LTBR',1,'L',true);
		$pdf->Cell(200,2,'','LR',1);
	}

	//mflores 26-09-11 para la devolucion de los custodios
	elseif ($pdf->codigo_proceso=='DEVCUS'){
		$pdf->Cell(30,5,'CUSTODIO:  ','L',0,'R');
	$pdf->Cell(70,5,''.utf8_decode($_SESSION['PDF_custodio']),'LTBR',1,'L',true);
		$pdf->Cell(200,2,'','LR',1);
	}
	
	else{
		$pdf->Cell(30,5,'EMPLEADO ASIGNADO:  ','L',0,'R');
		$pdf->Cell(70,5,''.utf8_decode($_SESSION['PDF_desc_empleado_des']),'LTBR',1,'L',true);
		$pdf->Cell(200,2,'','LR',1);
	}

	//$pdf->Cell(10,5,'','R',1,'R');
	$pdf->Cell(200,2,'','LR',1);
	$pdf->Cell(30,5,'DESCRIPCION:  ','L',0,'R');
	$pdf->Cell(70,5,''.utf8_decode($_SESSION['PDF_descripcion']),'LTBR',0,'L',true); 
	
	if($pdf->codigo_proceso=='REACT' ||$pdf->codigo_proceso=='REAEMP'){
		$pdf->Cell(30,5,'EMPLEADO ASIGNADO:  ','L',0,'R');
		$pdf->Cell(70,5,''.utf8_decode($_SESSION['PDF_desc_empleado_des']),'LTBR',1,'L',true);
		$pdf->Cell(200,2,'','LR',1);
	}
	//mflores 23-09-11 para los custodios
	elseif ($pdf->codigo_proceso=='CUST'){
		$pdf->Cell(30,5,'CUSTODIO:  ','L',0,'R');
		$pdf->Cell(70,5,''.utf8_decode($_SESSION['PDF_custodio']),'LTBR',1,'L',true);
		$pdf->Cell(200,2,'','LR',1);
	}
	
	else if($pdf->codigo_proceso=='ASIG' && $_SESSION['PDF_sw_prestamo']=='si'){	
		$pdf->Cell(30,5,'FECHA MAX DEVOLUCION:  ','L',0,'R');
		$pdf->Cell(70,5,''.$_SESSION['PDF_fecha_devolucion'],'LTBR',1,'L',true);
		//$pdf->Cell(200,2,'','LR',1);
	}
	else{
		$pdf->Cell(30,5,'','L',0,'R');
		$pdf->Cell(70,5,'','R',1,'C',false);
		$pdf->Cell(200,2,'','LR',1);
	}
	
	$pdf->Cell(200,2,'','LR',1);
	$pdf->Cell(30,5,'FECHA PROCESO:  ','L',0,'R');
	$pdf->Cell(70,5,''.$_SESSION['PDF_fecha_contabilizacion'],'LTBR',0,'L',true);
	
	$pdf->Cell(30,5,'','L',0,'R');
	$pdf->Cell(70,5,'','R',1,'C',false);
	$pdf->Cell(200,2,'','LR',1);
	
	//-----------para el Detalle
	$pdf->SetFillColor(200, 200, 200);//Plomo oscuro
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(200,5,'DETALLE','LTBR',1,'C',true);
	
	$pdf->SetFont('Arial','',6);
	$pdf->Cell(200,3,'','LR',1);
	
	$pdf->SetFillColor(230 , 230, 230);//Plomo claro
	$pdf->Cell(7,3,'NO','TRL',0,'C',true);
	$pdf->Cell(15,3,'CODIGO','TRL',0,'C',true);
	$pdf->Cell(33,3,'DENOMINACION ','TRL',0,'C',true);
	$pdf->Cell(60,3,'DESCRIPCION','TRL',0,'C',true);
	$pdf->Cell(25,3,'SUB TIPO ACTIVO','TRL',0,'C',true);
	
	if($_SESSION['PDF_sw_prestamo']=='si' && $_SESSION['PDF_sw_devol_prestamo']=='si'){
		$pdf->Cell(40,3,'OBSERVACIONES','TRL',0,'C',true);
		$pdf->Cell(20,3,'ESTADO PREST.','TRL',1,'C',true);
	}else{	
		$pdf->Cell(60,3,'OBSERVACIONES','TRL',1,'C',true);
	}
	
	if($_SESSION['PDF_sw_prestamo']=='si' && $_SESSION['PDF_sw_devol_prestamo']=='si'){
		$pdf->SetWidths(array(7,15,33,60,25,40,20));
		$pdf->SetVisibles(array(1,1,1,1,1,1,1,0,0));
		$pdf->SetFontsSizes(array(6,6,6,6,6,6,6));
		$pdf->SetSpaces(array(3,3,3,3,3,3,3));
	}else{
		$pdf->SetWidths(array(7,15,33,60,25,60));
		$pdf->SetVisibles(array(1,1,1,1,1,1,0,0));
		$pdf->SetFontsSizes(array(6,6,6,6,6,6,6));
		$pdf->SetSpaces(array(3,3,3,3,3,3,3));
	}
	
	$v_setdetalle=$_SESSION['PDF_activo_fijo_proceso'];
	/*echo '<pre>';
	print_r($v_setdetalle);
	echo '</pre>';
	exit;*/
	
	for ($i=0;$i<sizeof($v_setdetalle);$i++){
		array_unshift($v_setdetalle[$i],$i+1);
		$pdf->SetLineWidth(0.05);
		$pdf->MultiTabla($v_setdetalle[$i],0,3,3,6);
	}
	$pdf->SetFillColor(200, 200, 200);//Plomo oscuro
	
	$pdf->Cell(200,2,'',0,1);
	$pdf->Cell(30,5,'',0,0,'R');
	$pdf->Cell(170,5,'',0,1,'C',false);
	$pdf->Cell(30,5,'',0,0,'R');
	$pdf->Cell(170,5,'',0,1,'C',false);
	$pdf->Cell(30,5,'',0,0,'R');
	$pdf->Cell(170,5,'',0,1,'C',false);
	 
	//Permite Mostrar las Firmas
	if($pdf->codigo_proceso=='REACT' || $pdf->codigo_proceso=='REAEMP'){
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(66.6,5,'ENCARGADO ACTIVOS','LTBR',0,'C',true);
		$pdf->Cell(66.7,5,'EMPLEADO ORIGEN','LTBR',0,'C',true);
		$pdf->Cell(66.7,5,'EMPLEADO ASIGNACION','LTBR',1,'C',true);
		$pdf->SetFont('Arial','B',8);
		
		$pdf->Cell(66.6,15,'','LTBR',0,'C');
		$pdf->Cell(66.7,15,'','LTBR',0,'C');
		$pdf->Cell(66.7,15,'','LTBR',1,'C');
			
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(66.6,3,''.$v_setdetalle[0][8],'LTBR',0,'C');	
		$pdf->Cell(66.7,3,''.utf8_decode($_SESSION['PDF_desc_empleado_ori']),'LTBR',0,'C');
		$pdf->Cell(66.7,3,''.utf8_decode($_SESSION['PDF_desc_empleado_des']),'LTBR',1,'C');
			
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(66.6,3,'','LTBR',0,'C',true);
		$pdf->Cell(66.7,3,$v_setdetalle[0][9],'LTBR',0,'C',true);
		$pdf->Cell(66.7,3,$v_setdetalle[0][10],'LTBR',1,'C',true);
	} 
	
	if($pdf->codigo_proceso=='ASIG'){
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(66.6,5,'RESPONSABLE DE ACTIVOS FIJOS','LTBR',0,'C',true);
		$pdf->Cell(66.7,5,'EMPLEADO ASIGNACION','LTBR',0,'C',true);
		$pdf->Cell(66.7,5,'ENCARGADO DEPOSITO ','LTBR',1,'C',true);
		$pdf->SetFont('Arial','B',8);
		
		$pdf->Cell(66.6,15,'','LTBR',0,'C');
		$pdf->Cell(66.7,15,'','LTBR',0,'C');
		$pdf->Cell(66.7,15,'','LTBR',1,'C');
			
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(66.6,3,''.$v_setdetalle[0][8],'LTBR',0,'C');	
		$pdf->Cell(66.7,3,''.utf8_decode($_SESSION['PDF_desc_empleado_des']),'LTBR',0,'C');
		$pdf->Cell(66.7,3,'','LTBR',1,'C');
			
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(66.6,3,'','LTBR',0,'C',true);
		$pdf->Cell(66.7,3,$v_setdetalle[0][9],'LTBR',0,'C',true);
		$pdf->Cell(66.7,3,'','LTBR',1,'C',true);
	}
	
	else if($pdf->codigo_proceso=='DEVOL'){
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(66.6,5,'RESPONSABLE DE ACTIVOS FIJOS','LTBR',0,'C',true);
		$pdf->Cell(66.7,5,'EMPLEADO ORIGEN','LTBR',0,'C',true);
		$pdf->Cell(66.7,5,'ENCARGADO DEPOSITO ','LTBR',1,'C',true);
		$pdf->SetFont('Arial','B',8);
		
		$pdf->Cell(66.6,15,'','LTBR',0,'C');		
		$pdf->Cell(66.7,15,'','LTBR',0,'C');
		$pdf->Cell(66.7,15,'','LTBR',1,'C');
			
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(66.6,3,''.$v_setdetalle[0][8],'LTBR',0,'C');	
		$pdf->Cell(66.7,3,''.utf8_decode($_SESSION['PDF_desc_empleado_ori']),'LTBR',0,'C');
		$pdf->Cell(66.7,3,'','LTBR',1,'C');
			
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(66.6,3,'','LTBR',0,'C',true);		
		$pdf->Cell(66.7,3,$v_setdetalle[0][9],'LTBR',0,'C',true);
		$pdf->Cell(66.7,3,'','LTBR',1,'C',true);
	}
	
	else if($pdf->codigo_proceso=='CUST'){
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(66.6,5,'ENTREGUE CONFORME','LTBR',0,'C',true);
		$pdf->Cell(66.7,5,'RECIBI CONFORME','LTBR',0,'C',true);
		$pdf->Cell(66.7,5,'','LTBR',1,'C',true);
		$pdf->SetFont('Arial','B',8);
		
		$pdf->Cell(66.6,15,'','LTBR',0,'C');
		$pdf->Cell(66.7,15,'','LTBR',0,'C');
		$pdf->Cell(66.7,15,'','LTBR',1,'C');
			
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(66.6,3,''.$_SESSION['PDF_desc_empleado_ori'],'LTBR',0,'C');
		$pdf->Cell(66.7,3,''.$_SESSION['PDF_custodio'],'LTBR',0,'C');
		$pdf->Cell(66.7,3,'','LTBR',1,'C');
	}
	
	else if($pdf->codigo_proceso=='DEVCUS'){
		$pdf->SetFont('Arial','B',6);
		$pdf->Cell(66.6,5,'ENTREGUE CONFORME','LTBR',0,'C',true);
		$pdf->Cell(66.7,5,'RECIBI CONFORME','LTBR',0,'C',true);
		$pdf->Cell(66.7,5,'','LTBR',1,'C',true);
		$pdf->SetFont('Arial','B',8);
		
		$pdf->Cell(66.6,15,'','LTBR',0,'C');
		$pdf->Cell(66.7,15,'','LTBR',0,'C');
		$pdf->Cell(66.7,15,'','LTBR',1,'C');
			
		$pdf->SetFont('Arial','',6);
		$pdf->Cell(66.6,3,''.utf8_decode($_SESSION['PDF_custodio']),'LTBR',0,'C');
		$pdf->Cell(66.7,3,''.utf8_decode($_SESSION['PDF_responsable']),'LTBR',0,'C');
		$pdf->Cell(66.7,3,'','LTBR',1,'C');
	} 

	/**********************NOTA AL PIE*****************************************************/
	/* Author: Daniel Sanchez Torrico Fecha:  21/03/2013 */
	if($pdf->codigo_proceso!='DEVCUS' && $pdf->codigo_proceso!='DEVOL'){
		$pdf->Cell(10,2,'',0,1,'L');
		$pdf->SetFont('Arial','B',7);
		$pdf->Cell(10,3,'Nota: ',0,0,'L');
		$pdf->Ln();
		$pdf->SetFont('Arial','I',7);
		$pdf->Cell(200,3,"''Para ser liberado de la responsabilidad, deberá comunicar y devolver al Area de Activos Fijos el o los bienes que estaban a su cargo,debiendo recabar la conformidad escrita del  ",0,1,'L');
		$pdf->Cell(180,3,"Area de Activos Fijos, mientras no lo haga, estará sujeto al régimen de responsabilidad establecido en la",0,1,'L');
		//retorna del salto de linea
		$pdf->setY($pdf->getY()-3);
		//$pdf->setX(120);
		$pdf->setX($pdf->getX()+116);
		$pdf->SetFont('Arial','B',7);
		$pdf->Cell(20,3," 	'Ley 1178'",0,1,'L');
		$pdf->SetFont('Arial','I',7);
		$pdf->setY($pdf->getY()-3);
		$pdf->setX(135);
		$pdf->Cell(20,3," y sus Decretos Reglamentarios''.",0,1,'L');
		
		$pdf->SetFont('Arial','B',7);
		$pdf->Cell(15,3,'Prohibición:',0,0,'L');
		$pdf->SetFont('Arial','I',7);
		$pdf->Cell(200,3,"''-Usar los activos fijos para beneficio particular o privado. -Prestar o transferir estos bienes a otro trabajador, sin la formalización del Area de Activos Fijos.",0,1,'L');
		$pdf->Cell(200,3,"-Dañar o alterar las características físicas de los activos fijos. -Ingresar bienes particulares sin autorización del Area de Activos Fijos. -Poner en riesgo el bien asignado.",0,1,'L');
		$pdf->Cell(200,3,"-Disponer de otros bienes que no estén a su cargo.-Retirar los bienes de la empresa sin el conocimiento y autorización de la jefatura del departamento administrativo,",0,1,'L');
		$pdf->Cell(200,3,"salvo que por las características propias de trabajo del trabajador así lo requiera''.",0,1,'L');
	}
  
	//Despliega el Reporte
	$pdf->Output ();
?> 