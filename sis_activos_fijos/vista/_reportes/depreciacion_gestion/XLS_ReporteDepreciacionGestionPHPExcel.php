<?php

	/**
	 * Nombre:				XLS_ReporteDepreciacionGestionPHPExcel.php
	 * Descripcion:			Permite la recuperacion de la informacion referente a la depreciacion
	 * 						de los activos fijos de la Gestion Actual en un archivo XLS
	 * Autor:				UNKNOW
	 * Fecha creaci�n:		02092015
	 *
	 */


	session_start();
	require_once('../../../../lib/PHPExcel-1.8/Classes/PHPExcel.php');
	require_once ('../../../../lib/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
	include_once("../../../control/LibModeloActivoFijo.php");

	
	$nombre_archivo='XLS_ReporteDepreciacionGestionPHPExcel.xls';
	$objPHPExcel = new PHPExcel();
	$sheet = $objPHPExcel->getActiveSheet();
	
	
	$estilo1 = array( 'font'=>array('bold'=>true,'size'=>15,'name'=>'Calibri'),
					  'alignment'=>array('horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,)	);
	$alineacion = array('alignment'=>array('horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,));
	
	$alineacion_vertical = array('alignment'=>array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,),'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,), 'font'=>array('bold'=>true,'size'=>12,'name'=>'Calibri'));
	
	$bordes = array(
					'borders' => array(
				          'allborders' => array(
				              'style' => PHPExcel_Style_Border::BORDER_THIN
				          )
				      )
				);
	
	
	function mes_literal($mes)
	{
		$res;
		switch ($mes)
		{
			case 1: $res='Enero';break;
			case 2: $res='Febrero';break;
			case 3: $res='Marzo';break;
			case 4: $res='Abril';break;
			case 5: $res='Mayo';break;
			case 6: $res='Junio';break;
			case 7: $res='Julio';break;
			case 8: $res='Agosto';break;
			case 9: $res='Septiembre';break;
			case 10: $res='Octubre';break;
			case 11: $res='Noviembre';break;
			case 12: $res='Diciembre';break;
			default : $res = 'Error, el mes debe estar en formato numerico';break;
			
		}
		return $res;
	}
	
	$objPHPExcel->setActiveSheetIndex(0);
	$sheet->setCellValue('G2', 'REPORTE DEPRECIACION ACTIVOS FIJOS');
	$sheet->getStyle('G2')->getFont()->setName('Calibri');
	$sheet->getStyle('G2')->getFont()->setSize(15);
	$sheet->getStyle('G2')->getFont()->setBold(true);
	$sheet->getStyle('G2')->applyFromArray($alineacion);
	
	$sheet->setCellValue('G3', 'DESDE '.'01  DE '.mes_literal($mes_ini).' DE '.$anio_ini.'  '.' AL '.$num_dias.' DE '.mes_literal($mes_fin).' DE '.$anio_fin );
	$sheet->getStyle('G3')->getFont()->setSize(12);
	$sheet->getStyle('G3')->getFont()->setBold(true);
	$sheet->getStyle('G3')->applyFromArray($estilo1);
	
	$sheet->setCellValue('G4', 'EXPRESADO EN BOLIVIANOS');
	$sheet->getStyle('G4')->getFont()->setSize(12);
	$sheet->getStyle('G4')->getFont()->setBold(true);
	$sheet->getStyle('G4')->applyFromArray($alineacion);
	
	
	$fila=0;
	$columna=0;	

	
	$titulos_columnas = array(
	'ID TIPO ACTIVO FIJO',
	'TIPO ACTIVO',
	'ID ACTIVO FIJO',
	'CODIGO ACTIVO FIJO',
	'VIDA UTIL ACTUAL',
	'VALOR CONTABLE',
	'ACTUALIZACION',
	'VALOR_TOTAL',
	'DEPRECIACION ACUM. INICIAL',
	'ACTUALIZACION DEPRECIACION',
	'DEPREC. ACUM. ACTUALIZADA',
	'DEPRECIACION PERIODO', 
	'DEPRECIACION ACUMULADA',
	'VALOR NETO',
	'COD FINANCIADORA',
	'COD. REGIONAL',
	'COD. PROGRAMA',
	'COD. PROYECTO',
	'COD. ACTIVIDAD',
	'REVALORIZADO'
	//a�adido 13/02/2014
	,'FECHA INICIO DEPRECIACION','FECHA COMPRA','RESPONSABLE'		
	,'DESCRIPCION'
	//A�ADIDO 30/06/2015
	,'TENSION'		
	,'TIPO BIEN'								
												
	);
	

	foreach($titulos_columnas as $key => $columna)
	{		
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($key,6,$columna);
		    $objPHPExcel->getActiveSheet()->getStyle('A6:Z6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$objPHPExcel->getActiveSheet()->getStyle('A6:Z6')->getFill()->getStartColor()->setARGB('FFa6a6a6');
			$objPHPExcel->getActiveSheet()->getStyle('A6:Z6')->getAlignment()->setWrapText(true);
			$objPHPExcel->getActiveSheet()->getStyle('A6:Z6')->applyFromArray($alineacion_vertical);
			$objPHPExcel->getActiveSheet()->getStyle('A6:Z6')->applyFromArray($bordes);
			
			$objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(18);
	}
		
		
       	$cant=0;
		$puntero=0;
		$criterio_filtro= '';
		
		if($id_grupo_dep != null)
			$criterio_filtro = array("$id_grupo_dep","$fecha_hasta");
		$sortcol='';
		$sortdir='';
	
		$Custom = new cls_CustomDBActivoFijo();
		
		$res = $Custom->ReporteDepreciacionGestionActivosFijos($cant, $puntero, $sortdir, $sortcol, $criterio_filtro);
		
		$detalle = $Custom->salida;
		$fila = 7;
		
		foreach($detalle as $data)
		{
			for($i = 0; $i< sizeof($data)/2 ; $i++)
			{
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,$fila,utf8_encode($data[$i]) );
			}
			$fila = $fila + 1;
		}
 						
			$objPHPExcel->getActiveSheet()->setTitle('XLS_Reporte');//el titulono debe contener  mas de 31 caracteres
			
			$objPHPExcel->setActiveSheetIndex(0);
			
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="XLS_ReporteDepreciacionGestionPHPExcel.xls"');
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			exit();
?>