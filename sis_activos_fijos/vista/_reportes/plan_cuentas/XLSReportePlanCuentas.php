<?php

/**
 * Nombre:				XLS_ReportePlanCuentas.php
 * Descripcion:			Permite la recuperacion de la informacion referente a la depreciacion
 * 						de los activos fijos de la Gestion Actual en un archivo XLS
 * Autor:				UNKNOW
 * Fecha creación:		02092015
 *
 */

	session_start();
	require_once('../../../../lib/PHPExcel-1.8/Classes/PHPExcel.php');
	include_once("../../../control/LibModeloActivoFijo.php");
	
	$nombre_archivo='XLS_ReportePlanCuentas.xls';
	$objPHPExcel = new PHPExcel();
	$sheet = $objPHPExcel->getActiveSheet();
	
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
	
	$estilo_raiz=array('font'=>array('bold'=>true,'size'=>12,'name'=>'Calibri'));
	$estilo_rama=array('font'=>array('bold'=>true,'size'=>11,'name'=>'Calibri'));
	
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

	$sheet->getDefaultColumnDimension()->setWidth(20);
	
	if(isset($id_gestion)) $criterio_filtro = " pc.id_gestion like($id_gestion)";

	$cant = 0;
	$puntero = 0;
	$sortdir = 'ASC';
	$sortcol = 'pc.id_plan_cuentas';
	$Custom = new cls_CustomDBActivoFijo();
	$res = $Custom->ReportePlanCuentas($cant, $puntero, $sortdir, $sortcol, $criterio_filtro);
	
	$detalle = $Custom->salida;

	$sheet->setCellvalue('G2','DETALLE PLAN DE CUENTAS');
	$sheet->getStyle('G2')->getFont()->setName('Calibri');
	$sheet->getStyle('G2')->getFont()->setSize(15);
	$sheet->getStyle('G2')->getFont()->setBold(true);
	$sheet->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	
	$sheet->setCellValue('G3','Gestion : '.$detalle[0][15]);
	$sheet->getStyle('G3')->getFont()->setName('Calibri');
	$sheet->getStyle('G3')->getFont()->setSize(12);
	$sheet->getStyle('G3')->getFont()->setBold(true);
	$sheet->getStyle('G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);

	$sheet->setCellValue('C6','TIPO ACTIVO');
	$sheet->setCellValue('D6','PROGRAMA');
	$sheet->setCellValue('E6','TENSION');
	$sheet->setCellValue('F6','TIPO/BIEN');
	$sheet->setCellValue('G6','DETALLE CUENTA ACTIVO');
	$sheet->setCellValue('H6','DETALLE CUENTA DEP. ACUMULADA');
	$sheet->setCellValue('I6','DETALLE CUENTA GASTO');
	
	$sheet->getColumnDimension('G')->setWidth(40);
	$sheet->getColumnDimension('H')->setWidth(40);
	$sheet->getColumnDimension('I')->setWidth(40);
	
	$sheet->getStyle('C6:I6')->applyFromArray($estilo_columnas);;
	

	
	$fila = 7;
	$tipoAnterior=-1;
	$tipoActual = 0;
	
	$flag=true;
	foreach($detalle as $data)
	{
		$tipoActual=$data[6];
		$nivel = $data[14];
		
		if($flag)
		{	
			if($nivel==1)
			{
				$sheet->setCellValueByColumnAndRow(0,$fila,utf8_encode($data[0].' - '.$data[1]) );
				$sheet->getCellByColumnAndRow(0,$fila)->getStyle()->applyFromArray($estilo_raiz);
			}
			elseif ($nivel==2)
			{
				$sheet->setCellValueByColumnAndRow(1,$fila,utf8_encode($data[0].' - '.$data[1]) );
				$sheet->getCellByColumnAndRow(1,$fila)->getStyle()->applyFromArray($estilo_rama);
				$flag=false;
				$tipoAnterior=$data[6];
			}
		}
		else
		{
			if($tipoAnterior != $tipoActual || ($tipoActual == 'undefined' || $tipoActual == null))
			{
				$fila = $fila +2;
				if($nivel==1)
				{
					$sheet->setCellValueByColumnAndRow(0,$fila,utf8_encode($data[0].' - '.$data[1]) );
					$sheet->getCellByColumnAndRow(0,$fila)->getStyle()->applyFromArray($estilo_raiz);
				}
				elseif ($nivel==2)
				{
					$sheet->setCellValueByColumnAndRow(1,$fila,utf8_encode($data[0].' - '.$data[1]) );
					$sheet->getCellByColumnAndRow(1,$fila)->getStyle()->applyFromArray($estilo_rama); 
				}
				else
				{
					$sheet->setCellValueByColumnAndRow(2,$fila,utf8_encode($data[2]));
					$sheet->setCellValueByColumnAndRow(3,$fila,utf8_encode($data[3]));
					$sheet->setCellValueByColumnAndRow(4,$fila,utf8_encode($data[4]));
					$sheet->setCellValueByColumnAndRow(5,$fila,utf8_encode($data[5]));
					$sheet->setCellValueByColumnAndRow(6,$fila,utf8_encode($data[8].' - '.utf8_encode($data[9])));
					//$sheet->setCellValueByColumnAndRow(7,$fila,utf8_encode($data[9].''));
					$sheet->setCellValueByColumnAndRow(7,$fila,utf8_encode($data[10]).' - '.utf8_encode($data[11]));
					//$sheet->setCellValueByColumnAndRow(9,$fila,utf8_encode($data[11]));
					$sheet->setCellValueByColumnAndRow(8,$fila,utf8_encode($data[12]).' - '.utf8_encode($data[13]));
					//$sheet->setCellValueByColumnAndRow(11,$fila,utf8_encode($data[13]));
					
					
				}
				$tipoAnterior=$tipoActual;
			}
			elseif ($tipoAnterior == $tipoActual) 
			{
				$sheet->setCellValueByColumnAndRow(2,$fila,utf8_encode($data[2]));
				$sheet->setCellValueByColumnAndRow(3,$fila,utf8_encode($data[3]));
				$sheet->setCellValueByColumnAndRow(4,$fila,utf8_encode($data[4]));
				$sheet->setCellValueByColumnAndRow(5,$fila,utf8_encode($data[5]));
				$sheet->setCellValueByColumnAndRow(6,$fila,utf8_encode($data[8].' - '.utf8_encode($data[9])));
				//$sheet->setCellValueByColumnAndRow(7,$fila,utf8_encode($data[9]));
				$sheet->setCellValueByColumnAndRow(7,$fila,utf8_encode($data[10]).' - '.utf8_encode($data[11]));
				//$sheet->setCellValueByColumnAndRow(9,$fila,utf8_encode($data[11]));
				$sheet->setCellValueByColumnAndRow(8,$fila,utf8_encode($data[12]).' - '.utf8_encode($data[13]));
				//$sheet->setCellValueByColumnAndRow(11,$fila,utf8_encode($data[13]));
				
				$aux="'A".$fila.":M".$fila."'";
				

				$tipoAnterior=$tipoActual;
				
			}
		}
		$fila = $fila +1;
	}

	$objPHPExcel->getActiveSheet()->setTitle('PlanCuentas');//el titulo no debe contener  mas de 31 caracteres
		
	$objPHPExcel->setActiveSheetIndex(0);
		
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="detalleActivosFijos.xls"');
	header('Cache-Control: max-age=0');
		
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;

?>