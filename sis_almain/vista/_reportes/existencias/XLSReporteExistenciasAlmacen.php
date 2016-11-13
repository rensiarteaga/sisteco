<?php 
session_start();
require_once('../../../../lib/PHPExcel-1.8/Classes/PHPExcel.php');
include_once("../../../control/LibModeloAlma.php");


$nombre_archivo='XLS_ReporteExistenciasAlmacen.xls';
$objPHPExcel = new PHPExcel();
$sheet = $objPHPExcel->getActiveSheet();

$styleArray = array(
		'font' => array(
				'bold' => true,'name'  => 'Arial','size'=>15
		),
		'alignment'=>array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)
);

$estilo1 = array('font'=>array('bold'=>true,'size'=>12,'name'=>'Arial'),
		'alignment'=>array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,)	);

$alineacion_vertical = array('alignment'=>array('vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,),'alignment'=>array('horizontal'=>PHPExcel_Style_Alignment::HORIZONTAL_CENTER,), 'font'=>array('bold'=>true,'size'=>12,'name'=>'Calibri'));

$bordes = array(
		'borders' => array(
				'allborders' => array(
						'style' => PHPExcel_Style_Border::BORDER_THIN
				)
		)
);



$objPHPExcel->setActiveSheetIndex(0);
$sheet->setCellValue('H2', utf8_encode('INFORMACIÓN DE EXISTENCIAS'));
$sheet->getStyle('H2')->applyFromArray($styleArray);

$sheet->setCellValue('G3', utf8_encode('Al:'));
$sheet->setCellValue('H3', utf8_encode($f_fin));
$sheet->setCellValue('G4', utf8_encode("Almacen :"));
$sheet->setCellValue('H4', utf8_encode($nombre_almacen));

$titulos_columnas = array(utf8_encode('CÓDIGO MATERIAL'),utf8_encode('DESCRIPCIÓN'),'EXISTENCIAS','UNIDAD MEDIDA','PRECIO UNITARIO Bs.','PRECIO TOTAL Bs.');

$columna_inicio=4;
foreach($titulos_columnas as $key => $columna)
{
	$sheet->getStyle(6,$columna_inicio)->applyFromArray($estilo1);	
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columna_inicio,6,$columna);
	$objPHPExcel->getActiveSheet()->getStyle('E6:J6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
	$objPHPExcel->getActiveSheet()->getStyle('E6:J6')->getAlignment()->setWrapText(true);
	$objPHPExcel->getActiveSheet()->getStyle('E6:J6')->applyFromArray($alineacion_vertical);
	$objPHPExcel->getActiveSheet()->getStyle('E6:J6')->applyFromArray($bordes);
	$columna_inicio++;
}

$fila=7;
$columna=4;

$Custom = new cls_CustomDBAlma();
$puntero = $id_almacen;
$criterio = $criterio_filtro;
$cant = 0;

$sum_existencias=0;
$sum_precio_total=0;

$parametro = array();
$parametro = unserialize(stripslashes($param));

$res = $Custom->ReporteExistenciasAlmacen($cant, $parametro['id_almacen'], $sortcol, $sortdir, $parametro['criterio']);

$detalle = $Custom->salida;

foreach($detalle as $data)
{
	for($i = 0; $i< sizeof($data)/2 ; $i++)
	{
		if($columna == 8 OR $columna == 9 OR $columna == 10)
			$objPHPExcel->getActiveSheet()->getStyle($fila,$columna)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1); 
		
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columna,$fila,utf8_encode($data[$i]) );
		$columna++;
	}
	$fila = $fila + 1;
	$columna=4;
	
	$sum_existencias += $data[2];
	$sum_precio_total += $data[5];
}

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5,$fila,'Totales:');
$objPHPExcel->getActiveSheet()->getStyle($fila,7)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(6,$fila,$sum_existencias);
$objPHPExcel->getActiveSheet()->getStyle($fila,9)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$fila,$sum_precio_total);

$objPHPExcel->getActiveSheet()->setTitle('XLSReporteExisten');//el titulono debe contener  mas de 31 caracteres
$objPHPExcel->setActiveSheetIndex(0);
	
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="detalleActivosFijos.xls"');
header('Cache-Control: max-age=0');
	
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;


?>