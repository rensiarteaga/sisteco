<?php

	session_start ();
	/**
	 * Autor: RCM
	 * Fecha de creacion: 29-04-2011
	 * Descripción: Formulario de Asignación
	 * **/
	
	require ('../../../../lib/fpdf/fpdf.php');
	define ( 'FPDF_FONTPATH', 'font/' );
	
	class PDF extends FPDF {
		function PDF($orientation = 'L', $unit = 'mm', $format = 'Letter') {
			//Llama al constructor de la clase padre
			$this->FPDF ( $orientation, $unit, $format );
			$this->AddFont ( 'Arial', '', 'arial.php' );
		}
	
		function Header() {
			$this->Image ( '../../../../lib/images/logo_reporte.jpg', 165, 8, 36, 13 );
			$this->Ln ( 5 );
			$this->SetFont ( 'Arial', 'B', 8 );
			$this->SetX ( 15 );
			$this->Ln ( 1.5 );
			
			$this->SetFont ( 'Arial', 'B', 12 );
			$this->Cell ( 0, 6, 'FORMULARIO GENERAL DE ASIGNACION', 0, 1, 'C' );
			$this->Cell ( 0, 6, 'DE ACTIVOS FIJOS / BIENES BAJO RESPONSABILIDAD', 0, 1, 'C' );
			
			if($this->page!=1){
				$this->SetFont ( 'Arial', '', 6 );
				$this->Cell ( 200, 3, '', '', 1 );
				
				$this->SetFillColor ( 230, 230, 230 ); //Plomo claro
				$this->Cell ( 7, 3, 'NO', 'TRL', 0, 'C', true );
				$this->Cell ( 18, 3, 'CODIGO', 'TRL', 0, 'C', true );
				$this->Cell ( 11, 3, 'TIPO', 'TRL', 0, 'C', true );
				$this->Cell ( 32, 3, 'DENOMINACION ', 'TRL', 0, 'C', true );
				$this->Cell ( 55, 3, 'DESCRIPCION', 'TRL', 0, 'C', true );
				$this->Cell ( 45, 3, 'UBICACION', 'TRL', 0, 'C', true );
				$this->Cell ( 32, 3, 'OBSERVACIONES', 'TRL', 1, 'C', true );
			}
		}
		//Pie de página
		function Footer() {
			$fecha=date("d-m-Y");
	        $hora=date("h:i:s");
	        $this->SetY(-7);
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
	$pdf = new PDF ( 'P', 'mm', 'Letter' );
	$pdf->AddPage ();
	$pdf->AliasNbPages ();
	$pdf->SetAutoPageBreak ( true, 20 );
	
	//-----------para los datos generales
	$pdf->SetFillColor ( 200, 200, 200 ); //Plomo oscuro
	
	$pdf->SetFont ( 'Arial', 'B', 8 );
	$pdf->Cell ( 200, 5, 'DATOS GENERALES', 'LTBR', 1, 'C', true );
	
	$pdf->SetFont ( 'Arial', '', 6 );
	$pdf->Cell ( 200, 3, '', 'LR', 1 );
	
	$pdf->SetFillColor ( 230, 230, 230 ); //Plomo claro
	
	$v_setdetalle=$_SESSION['PDF_activo_fijo_empleado_detalle'];
	
	$pdf->Cell ( 30, 5, 'RESPONSABLE:  ', 'L', 0, 'R' );
	$pdf->Cell ( 70, 5, '' . $v_setdetalle[0]['nombre_completo'], 'LTBR', 0, 'L', true );
	
	$pdf->Cell ( 30, 5, 'DEPARTAMENTO AF:  ', 'L', 0, 'R' );
	$pdf->Cell ( 70, 5, '' . $v_setdetalle[0]['nombre_depto'], 'LTBR', 1, 'L', true );
	$pdf->Cell ( 200, 2, '', 'LR', 1 );
	
	//-----------para el Detalle
	$pdf->SetFillColor ( 200, 200, 200 ); //Plomo oscuro
	$pdf->SetFont ( 'Arial', 'B', 8 );
	$pdf->Cell ( 200, 5, 'DETALLE', 'LTBR', 1, 'C', true );
	
	$pdf->SetFont ( 'Arial', '', 6 );
	$pdf->Cell ( 200, 3, '', 'LR', 1 );
	
	$pdf->SetFillColor ( 230, 230, 230 ); //Plomo claro
	$pdf->Cell ( 7, 3, 'NO', 'TRL', 0, 'C', true );
	$pdf->Cell ( 18, 3, 'CODIGO', 'TRL', 0, 'C', true );
	$pdf->Cell ( 11, 3, 'TIPO', 'TRL', 0, 'C', true );
	$pdf->Cell ( 32, 3, 'DENOMINACION ', 'TRL', 0, 'C', true );
	$pdf->Cell ( 55, 3, 'DESCRIPCION', 'TRL', 0, 'C', true );
	$pdf->Cell ( 45, 3, 'UBICACION', 'TRL', 0, 'C', true );
	$pdf->Cell ( 32, 3, 'OBSERVACIONES', 'TRL', 1, 'C', true );
	
	$pdf->SetWidths(array(7,18,11,32,55,45,32));
	$pdf->SetFills(array(0,0,0,0,0,0,0,0,0,0));
	$pdf->SetAligns(array('L','L','C','L','L','L','L','L','L','L'));
	$pdf->SetVisibles(array(1,1,1,1,1,1,1,0,0,0,0));
	$pdf->SetFontsSizes(array(6,6,6,6,6,6,6,6,6,6));
	$pdf->SetFontsStyles(array('','','','','','','','','',''));
	$pdf->SetDecimales(array(0,0,0,0,0,0,0,0,0,0));
	$pdf->SetSpaces(array(3,3,3,3,3,3,3,3,3,3));
	$pdf->SetFormatNumber(array(0,0,0,0,0,0,0,0,0,0));
	
	//var_dump($v_setdetalle);exit;
	/*echo "<pre>";
	print_r($v_setdetalle);
	echo "</pre>";*/
	
	for($i = 0; $i < sizeof ( $v_setdetalle ); $i ++) {
		array_unshift ( $v_setdetalle [$i], $i + 1 );
		$pdf->SetLineWidth ( 0.05 );
		$pdf->MultiTabla($v_setdetalle[$i],0,3,3,6,1);
	}

	$pdf->SetFillColor ( 200, 200, 200 ); //Plomo oscuro
	
	$pdf->Cell ( 200, 2, '', 'LR', 1 );
	$pdf->Cell ( 30, 5, '', 'L', 0, 'R' );
	$pdf->Cell ( 170, 5, '', 'R', 1, 'C', false );
	$pdf->Cell ( 30, 5, '', 'L', 0, 'R' );
	$pdf->Cell ( 170, 5, '', 'R', 1, 'C', false );
	$pdf->Cell ( 30, 5, '', 'L', 0, 'R' );
	$pdf->Cell ( 170, 5, '', 'R', 1, 'C', false );
	$pdf->Cell ( 200, 2, '', 'LR', 1 );

//   Permite Mostrar las Firmas
	$pdf->SetFont ( 'Arial', 'B', 6 );
	$pdf->Cell ( 66.6, 5, 'ENCARGADO ACTIVOS FIJOS', 'LTBR', 0, 'C', true );
	$pdf->Cell ( 66.7, 5, 'RESPONSABLE', 'LTBR', 0, 'C', true );
	$pdf->Cell ( 66.7, 5, '', 'LTBR', 1, 'C', true );
	$pdf->SetFont ( 'Arial', 'B', 8 );
	
	$pdf->Cell ( 66.6, 15, '', 'LTBR', 0, 'C' );
	$pdf->Cell ( 66.7, 15, '', 'LTBR', 0, 'C' );
	$pdf->Cell ( 66.7, 15, '', 'LTBR', 1, 'C' );
	
	$pdf->SetFont ( 'Arial', '', 6 );
	$pdf->Cell ( 66.6, 3, '' . $v_setdetalle [0] ['resp_af'], 'LTBR', 0, 'C' );
	$pdf->Cell ( 66.7, 3, '' . $v_setdetalle [0] ['nombre_completo'], 'LTBR', 0, 'C' );
	$pdf->Cell ( 66.7, 3, '' . '', 'LTBR', 1, 'C' );
	
	$pdf->SetFont ( 'Arial', 'B', 6 );
	$pdf->Cell ( 66.6, 3, '', 'LTBR', 0, 'C', true );
	$pdf->Cell ( 66.7, 3, '', 'LTBR', 0, 'C', true );
	$pdf->Cell ( 66.7, 3, '', 'LTBR', 1, 'C', true );

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

	//Despliega el Reporte
	$pdf->Output ();
?>