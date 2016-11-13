<?php

	/**
	 * Nombre:				XLS_ReporteActivoFijoDepreciacionPHPExcel.php
	 * Descripcion:			Permite la recuperacion de la informacion referente a la depreciacion
	 * 						de los activos fijos de la Gestion Actual en un archivo XLS
	 * Autor:				UNKNOW
	 * Fecha creaci�n:		02092015
	 *
	 */


	session_start();
	require_once('../../../../lib/PHPExcel-1.8/Classes/PHPExcel.php');
	include_once("../../../control/LibModeloActivoFijo.php");

	
	$nombre_archivo='XLS_ReporteActivoFijoDepreciacionPHPExcel.xls';
	$objPHPExcel = new PHPExcel();
	$sheet = $objPHPExcel->getActiveSheet();
	
	$styleArray = array(
    'font' => array(
        'bold' => true,'name'  => 'Arial','size'=>15	
    ),
    'alignment'=>array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
	);
	
	$estilo1 = array('font'=>array('bold'=>true,'size'=>12,'name'=>'Arial'),
					  'alignment'=>array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
			
			'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
					'startcolor' => array(
							'argb' => 'FF90EE90',)
			)
		);
	
	$estilo2 = array('font' => array('bold' => true));
	
	$estilo_cabeceras=array('font'=>array('bold'=>false,'size'=>10,'name'=>'Arial'),
							'alignment'=>array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,));
	$estilo_columnas=array(
			'font'=>array('bold'=>true,'size'=>'12','name'=>'Arial'),
			'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					'rotation'   => 0,
					'wrap'=> true),
			'borders'=>array('allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN) ),
			'fill'=>array('type'=>PHPExcel_Style_Fill::FILL_SOLID,
					'startcolor' => array(
							'argb' => 'FFa6a6a6',)		)
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
	$sheet->setCellValue('I2', ' REPORTE DEPRECIACION ACTIVOS FIJOS  '.$m_anio);
	$sheet->getStyle('I2')->applyFromArray($styleArray);
	
	$sheet->setCellValue('I3', 'AL '.$num_dias.' DE '.mes_literal($m_mes).' DE '.$m_anio );
	$sheet->getStyle('I3')->applyFromArray($estilo_cabeceras);
	
	$sheet->setCellValue('I4', 'EXPRESADO EN BOLIVIANOS');
	$sheet->getStyle('I4')->applyFromArray($estilo_cabeceras);
	
	$fila=0;
	$columna=0;	

    
	
	$titulos_columnas = array(
	'ID TIPO ACTIVO FIJO',
	'TIPO ACTIVO',
	'ID ACTIVO FIJO',
	'CODIGO ACTIVO FIJO',
	'VIDA_UTIL_ACTUAL',
	'VALOR_CONTABLE',
	'ACTUALIZACION',
	'VALOR_TOTAL',
	'DEPRECIACION_ACUM_INI',
	'ACTUALIZACION_DEPRE',
	'DEPREC_ACUM_ACTUALIZ',
	'DEPRECIACION_PERIODO',
	'DEPRECIACION_ACUMULADA',
	'VALOR_NETO',
	'COD_FINANC',
	'COD_REGION',
	'COD_PROGR',
	'COD_PROYEC',
	'COD_ACTIVIDAD',
	'REVALORIZADO'
	//a�adido 13/02/2014
	,'FECHA INICIO DEPRECIACION','FECHA COMPRA','RESPONSABLE'		
	,'DESCRIPCION'
	//A�ADIDO 30/06/2015
	,'DETALLE CUENTA CONTABLE','CUENTA DEPRECIACION ACUMULADA','CUENTA GASTO'		
	,'TENSION / TIPO BIEN'								
												
	);
	
	foreach($titulos_columnas as $key => $columna)
	{ 		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($key,7,$columna);
		
		$sheet->getCellByColumnAndRow($key,7)->getStyle()->applyFromArray($estilo_columnas);
	}
	$sheet->getRowDimension(7)->setRowHeight(50);
	$sheet->getDefaultColumnDimension()->setWidth(20);
		
       	$cant=0;
		$puntero=0;
		$criterio_filtro="";
		
		if($id_grupo_dep != null){
			$criterio_filtro = array("$id_grupo_dep","$fecha_hasta");
		}
		
		$sortcol='';
		$sortdir='';
		
		$Custom = new cls_CustomDBActivoFijo();
			

			$res = $Custom->ReporteActivosFijosDepreciacionNuevo($cant, $puntero, $sortdir, $sortcol, $criterio_filtro);
			//echo $Custom->query;exit;
			$detalle = $Custom->salida;
			
			$fila = 8;
			$cont = 0;
			
			$tipoActual = '';
			$tipoAnterior='';

			$regionalActual = '';
			$regionalAnterior='';
			$regionalTemp='';
			
			
			//Sumas parciales por tipo de activo
			
			$sumValorContable = 0;
			$sumActualizacion = 0;
			$sumValorTotal = 0;
			$sumDepreciacionAcumIni = 0;
			$sumActualizacionDepre = 0;
			$sumDeprecAcumActualiz = 0;
			$sumDeprecPeriodo = 0;
			$sumDepreciacionAcumul = 0;
			$sumValorNeto = 0;
			
			//Sumas parciales por EP's
			
			$sumValorContable2 = 0;
			$sumActualizacion2 = 0;
			$sumValorTotal2 = 0;
			$sumDepreciacionAcumIni2 = 0;
			$sumActualizacionDepre2 = 0;
			$sumDeprecAcumActualiz2 = 0;
			$sumDeprecPeriodo2 = 0;
			$sumDepreciacionAcumul2 = 0;
			$sumValorNeto2 = 0;		
			
			//Sumas totales 
			$sumaTotalValorContable = 0;
			$sumaTotalActualizacion = 0;
			$sumaTotalValorTotal = 0;
			$sumaTotalDepreciacionAcumIni = 0;
			$sumaTotalActualizacionDepre = 0;
			$sumaTotalDeprecAcumActualiz = 0;
			$sumaTotalDeprecPeriodo = 0;
			$sumaTotalDeprecAcumul = 0;
			$sumaTotalValorNeto = 0;		

			$flag = 0;
			
			$lineasAdicionales = 0;
			
			foreach($detalle as $data)
			{
				
				$tipoActual = $data[0];
				$regionalActual = $data[15];
				
				if($tipoActual != $tipoAnterior)
				{
					$tipoAnterior = $tipoActual;
					
					if($flag != 0)
					{
// 						$sheet->getStyle(5,$fila)->applyFromArray($estilo2);
// 						$sheet->getStyle(6,$fila)->applyFromArray($estilo2);
// 						$sheet->getStyle(7,$fila)->applyFromArray($estilo2);
// 						$sheet->getStyle(8,$fila)->applyFromArray($estilo2);
// 						$sheet->getStyle(9,$fila)->applyFromArray($estilo2);
// 						$sheet->getStyle(10,$fila)->applyFromArray($estilo2);
// 						$sheet->getStyle(11,$fila)->applyFromArray($estilo2);
// 						$sheet->getStyle(12,$fila)->applyFromArray($estilo2);
// 						$sheet->getStyle(13,$fila)->applyFromArray($estilo2);
						
						$sheet->setCellValueByColumnAndRow(5,$fila,$sumValorContable);	
						$sheet->getStyleByColumnAndRow(5,$fila)->getNumberFormat()->setFormatCode('#,##0.00');
						$sheet->getStyleByColumnAndRow(5,$fila)->applyFromArray($estilo2);
						
						$sheet->setCellValueByColumnAndRow(6,$fila,$sumActualizacion);
						$sheet->getStyleByColumnAndRow(6,$fila)->getNumberFormat()->setFormatCode('#,##0.00');
						$sheet->getStyleByColumnAndRow(6,$fila)->applyFromArray($estilo2);
						
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$fila,$sumValorTotal);	
						$sheet->getStyleByColumnAndRow(7,$fila)->getNumberFormat()->setFormatCode('#,##0.00');
						$sheet->getStyleByColumnAndRow(7,$fila)->applyFromArray($estilo2);
						
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$fila,$sumDepreciacionAcumIni);
						$sheet->getStyleByColumnAndRow(8,$fila)->getNumberFormat()->setFormatCode('#,##0.00');
						$sheet->getStyleByColumnAndRow(8,$fila)->applyFromArray($estilo2);
						
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$fila,$sumActualizacionDepre);
						$sheet->getStyleByColumnAndRow(9,$fila)->getNumberFormat()->setFormatCode('#,##0.00');
						$sheet->getStyleByColumnAndRow(9,$fila)->applyFromArray($estilo2);
						
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$fila,$sumDeprecAcumActualiz);
						$sheet->getStyleByColumnAndRow(10,$fila)->getNumberFormat()->setFormatCode('#,##0.00');
						$sheet->getStyleByColumnAndRow(10,$fila)->applyFromArray($estilo2);
						
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$fila,$sumDeprecPeriodo);
						$sheet->getStyleByColumnAndRow(11,$fila)->getNumberFormat()->setFormatCode('#,##0.00');
						$sheet->getStyleByColumnAndRow(11,$fila)->applyFromArray($estilo2);
						
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$fila,$sumDepreciacionAcumul);
						$sheet->getStyleByColumnAndRow(12,$fila)->getNumberFormat()->setFormatCode('#,##0.00');
						$sheet->getStyleByColumnAndRow(12,$fila)->applyFromArray($estilo2);
						
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$fila,$sumValorNeto);
						$sheet->getStyleByColumnAndRow(13,$fila)->getNumberFormat()->setFormatCode('#,##0.00');
						$sheet->getStyleByColumnAndRow(13,$fila)->applyFromArray($estilo2); 
 						
						$fila = $fila+1;
						
						$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$fila,'');
						$fila = $fila+1;
						
						$lineasAdicionales++;
					
					}
					
					$sumValorContable = 0;
					$sumActualizacion = 0;
					$sumValorTotal = 0;
					$sumDepreciacionAcumIni = 0;
					$sumActualizacionDepre = 0;
					$sumDeprecAcumActualiz = 0;
					$sumDeprecPeriodo = 0;
					$sumDepreciacionAcumul = 0;
					$sumValorNeto = 0;
					
					$sumValorContable = $sumValorContable + $data[5];
					$sumActualizacion = $sumActualizacion + $data[6];
					$sumValorTotal = $sumValorTotal + $data[7];
					$sumDepreciacionAcumIni = $sumDepreciacionAcumIni + $data[8];
					$sumActualizacionDepre = $sumActualizacionDepre + $data[9];
					$sumDeprecAcumActualiz = $sumDeprecAcumActualiz + $data[10];
					$sumDeprecPeriodo = $sumDeprecPeriodo + $data[11];
					$sumDepreciacionAcumul = $sumDepreciacionAcumul + $data[12];
					$sumValorNeto = $sumValorNeto + $data[13];
					
					$flag = 1; 
					  
				}else{
					
					
					$sumValorContable = $sumValorContable + $data[5];
					$sumActualizacion = $sumActualizacion + $data[6];
					$sumValorTotal = $sumValorTotal + $data[7];
					$sumDepreciacionAcumIni = $sumDepreciacionAcumIni + $data[8];
					$sumActualizacionDepre = $sumActualizacionDepre + $data[9];
					$sumDeprecAcumActualiz = $sumDeprecAcumActualiz + $data[10];
					$sumDeprecPeriodo = $sumDeprecPeriodo + $data[11];
					$sumDepreciacionAcumul = $sumDepreciacionAcumul + $data[12];
					$sumValorNeto = $sumValorNeto + $data[13];
					
				}
				
			
				
				for($i = 0; $i< sizeof($data)/2 ; $i++)
				{
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,$fila,utf8_encode($data[$i]));	
				}
									
				$fila = $fila+1;
				
				$sumaTotalValorContable = $sumaTotalValorContable + $data[5];
				$sumaTotalActualizacion = $sumaTotalActualizacion + $data[6];
				$sumaTotalValorTotal = $sumaTotalValorTotal + $data[7];
				$sumaTotalDepreciacionAcumIni = $sumaTotalDepreciacionAcumIni + $data[8];
				$sumaTotalActualizacionDepre = $sumaTotalActualizacionDepre + $data[9];
				$sumaTotalDeprecAcumActualiz = $sumaTotalDeprecAcumActualiz + $data[10];
				$sumaTotalDeprecPeriodo = $sumaTotalDeprecPeriodo + $data[11];
				$sumaTotalDeprecAcumul = $sumaTotalDeprecAcumul + $data[12];
				$sumaTotalValorNeto = $sumaTotalValorNeto + $data[13];
				
				
			}
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$fila,$sumValorContable);	
			$sheet->getStyleByColumnAndRow(5,$fila)->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->getStyleByColumnAndRow(5,$fila)->applyFromArray($estilo2);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$fila,$sumActualizacion );	
			$sheet->getStyleByColumnAndRow(6,$fila)->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->getStyleByColumnAndRow(6,$fila)->applyFromArray($estilo2);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$fila,$sumValorTotal );
			$sheet->getStyleByColumnAndRow(7,$fila)->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->getStyleByColumnAndRow(7,$fila)->applyFromArray($estilo2);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$fila,$sumDepreciacionAcumIni );	
			$sheet->getStyleByColumnAndRow(8,$fila)->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->getStyleByColumnAndRow(8,$fila)->applyFromArray($estilo2);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$fila,$sumActualizacionDepre );
			$sheet->getStyleByColumnAndRow(9,$fila)->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->getStyleByColumnAndRow(9,$fila)->applyFromArray($estilo2);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$fila,$sumDeprecAcumActualiz );
			$sheet->getStyleByColumnAndRow(10,$fila)->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->getStyleByColumnAndRow(10,$fila)->applyFromArray($estilo2);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$fila,$sumDeprecPeriodo );
			$sheet->getStyleByColumnAndRow(11,$fila)->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->getStyleByColumnAndRow(11,$fila)->applyFromArray($estilo2);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$fila,$sumDepreciacionAcumul );
			$sheet->getStyleByColumnAndRow(12,$fila)->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->getStyleByColumnAndRow(12,$fila)->applyFromArray($estilo2);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$fila,$sumValorNeto );
			$sheet->getStyleByColumnAndRow(13,$fila)->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->getStyleByColumnAndRow(13,$fila)->applyFromArray($estilo2);
			
			//totales
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$fila+2,$sumaTotalValorContable );	
			$sheet->getStyleByColumnAndRow(5,$fila+2)->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->getStyleByColumnAndRow(5,$fila+2)->applyFromArray($estilo2);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$fila+2,$sumaTotalActualizacion );
			$sheet->getStyleByColumnAndRow(6,$fila+2)->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->getStyleByColumnAndRow(6,$fila+2)->applyFromArray($estilo2);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(7,$fila+2,$sumaTotalValorTotal );
			$sheet->getStyleByColumnAndRow(7,$fila+2)->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->getStyleByColumnAndRow(7,$fila+2)->applyFromArray($estilo2);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(8,$fila+2,$sumaTotalDepreciacionAcumIni );
			$sheet->getStyleByColumnAndRow(8,$fila+2)->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->getStyleByColumnAndRow(8,$fila+2)->applyFromArray($estilo2);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$fila+2,$sumaTotalActualizacionDepre );
			$sheet->getStyleByColumnAndRow(9,$fila+2)->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->getStyleByColumnAndRow(9,$fila+2)->applyFromArray($estilo2);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$fila+2,$sumaTotalDeprecAcumActualiz );
			$sheet->getStyleByColumnAndRow(10,$fila+2)->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->getStyleByColumnAndRow(10,$fila+2)->applyFromArray($estilo2);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(11,$fila+2,$sumaTotalDeprecPeriodo );
			$sheet->getStyleByColumnAndRow(11,$fila+2)->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->getStyleByColumnAndRow(11,$fila+2)->applyFromArray($estilo2);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(12,$fila+2,$sumaTotalDeprecAcumul );
			$sheet->getStyleByColumnAndRow(12,$fila+2)->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->getStyleByColumnAndRow(12,$fila+2)->applyFromArray($estilo2);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(13,$fila+2,$sumaTotalValorNeto );
			$sheet->getStyleByColumnAndRow(13,$fila+2)->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->getStyleByColumnAndRow(13,$fila+2)->applyFromArray($estilo2);
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(15,$fila+2,'Total General' );
			$sheet->getStyleByColumnAndRow(15,$fila+2)->getNumberFormat()->setFormatCode('#,##0.00');
			$sheet->getStyleByColumnAndRow(15,$fila+2)->applyFromArray($estilo2);
 						
			$objPHPExcel->getActiveSheet()->setTitle('XLSReporteDepreciacion');//el titulono debe contener  mas de 31 caracteres
			
			$objPHPExcel->setActiveSheetIndex(0);
			
			header('Content-Type: application/octet');
			header('Content-Disposition: attachment;filename="detActivosFijos.xls"');
			header('Cache-Control: max-age=0');
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			exit; 
?>