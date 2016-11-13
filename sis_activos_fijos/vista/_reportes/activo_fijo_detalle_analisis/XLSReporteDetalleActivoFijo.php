<?php
/**
	 * Nombre:				XLSReporteDetalleActivoFijo.php
	 * Descripcion:			Permite la recuperacion de la informacion de los activos fijos					
	 * Autor:				UNKNOW
	 * Fecha creaci�n:		26082015
	 *
 */
session_start();

require_once('../../../../lib/PHPExcel-1.8/Classes/PHPExcel.php');
include_once("../../../control/LibModeloActivoFijo.php");

$nombre_archivo='XLS_ReporteDetalleActivoFijoDepreciacion.xls';

$objPHPExcel = new PHPExcel();

$sheet = $objPHPExcel->getActiveSheet();

$styleArray = array(
    'font' => array(
        'bold' => true,'name'  => 'Calibri','size'=>17  ),
    	'alignment'=>array('horizontal' => PHPExcel_Style_Alignment::VERTICAL_CENTER,)
); 

$objPHPExcel->
	getProperties()
		->setCreator("endesis")
		->setLastModifiedBy("endesis")
		->setTitle("Exportar Excel con PHP")
		->setSubject("Reporte Detalle de Activos Fijos")
		->setDescription("Documento generado con PHPExcel")
		->setKeywords("phpexcel")
		->setCategory("reportes");


$objPHPExcel->setActiveSheetIndex(0);

$sheet->setCellValue('I2', 'REPORTE DETALLE DE ACTIVOS FIJOS');
// otra forma $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columna,$fila,$valor);

$sheet->getStyle('I2')->applyFromArray($styleArray);


$subtitulo = array(
				    	'font'  => array(
				        'bold'  => true, 
				        'size'  => 11,
				        'name'  => 'Arial'),
						//'alignment'=>array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
				    	);

$estilo1 = array('font'=>array('bold'=>true,'size'=>12,'name'=>'Arial'),
		'alignment'=>array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
			
		'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
				'startcolor' => array(
						'argb' => 'FF90EE90',)
		)
);

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

$titulos_columnas_total = array(
			'CODIGO',
			'NOMBRE',
			'DESCRIPCION',
			'TIPO ACTIVO',
			'SUBTIPO ACTIVO',
			'ESTADO',
			'ESTADO FUNCIONAL',
			'FECHA COMPRA',
			'FECHA INI DEPRECIACION',
			'MONTO COMPRA',
			'NUMERO FACTURA',
			'ORDEN DE COMPRA', 
			'MONTO ACTUAL',
			'MONTO ACTUALIZADO',
			'UBICACION',
			'VIDA UTIL',
			'VIDA UTIL RESTANTE',
			'REVALORIZADO',
			'PROYECTO',
			'OBSERVACIONES',
			'ORIGEN',
			'RESPONSABLE',
			'CUSTODIO',
			'UNIDAD ORGANIZACIONAL',
			'FINANCIADOR',
			'REGIONAL',
			'PROGRAMA',
			'PROYECTO',
			'ACTIVIDAD',
			'ESTRUCTURA PROGRAMATICA',
			'DEPARTAMENTO' 
			,'ID CBTE.ALTA','FECHA CBTE.'
		    ,'UNIDAD ORGANIZACIONAL ACTIVO FIJO'
	);
	$posiciones = $_SESSION['posiciones_cabeceras'];
	$criterio_cabeceras = $_SESSION['criterio_cabeceras'];
	
	
	$titulos_columnas = array();
	 
	foreach($posiciones as $pos){
		$titulos_columnas[] = $titulos_columnas_total[$pos];
	}
	 
	
	foreach($titulos_columnas as $key => $columna)
	{
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($key,5,$columna);
		
		$sheet->getCellByColumnAndRow($key,5)->getStyle()->applyFromArray($estilo_columnas);
		
	}

	$sheet->getRowDimension(5)->setRowHeight(50);
	
	$sheet->setCellValueByColumnAndRow(count($titulos_columnas),5,'PROGRAMA');
	$sheet->getCellByColumnAndRow(count($titulos_columnas),5)->getStyle()->applyFromArray($estilo_columnas);
	
	$sheet->setCellValueByColumnAndRow(count($titulos_columnas)+1,5,'TENSION');
	$sheet->getCellByColumnAndRow(count($titulos_columnas)+1,5)->getStyle()->applyFromArray($estilo_columnas);

	$sheet->getDefaultColumnDimension()->setWidth(18);

	$cant=0;
	$puntero=0;
	$sortcol='';
	$sortdir='';
	$criterio_filtro = $_SESSION['detalle_criterio_filtro'];
	
	$Custom = new cls_CustomDBActivoFijo();

	$res = $Custom->ReporteDetalleActivoFijoAnalisis($cant, $puntero, $sortdir, $sortcol, $criterio_filtro,$criterio_cabeceras);
	$detalle = $Custom->salida;
	
	$fila = 6;

	foreach($detalle as $data)
	{ 
		
		for($i = 0; $i< sizeof($data)/2 ; $i++)
		{
			
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i,$fila,utf8_encode($data[$i]) );	
		}
		$fila = $fila + 1;
		
	}
		
	$objPHPExcel->getActiveSheet()->setTitle('XLSReporteDetalleActivosFijos');
	$objPHPExcel->setActiveSheetIndex(0);
	
	
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="detalleActivosFijos.xls"');
	header('Cache-Control: max-age=0');
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit; 

?>