<?php

	/**
	 * Nombre:				XLS_ReporteActivoFijoDepreciacion.php
	 * Descripcion:			Permite la recuperacion de la informacion referente a la depreciacion
	 * 						de los activos fijos de la Gestion Actual en un archivo XLS
	 * Autor:				Daniel Sanchez Torrico
	 * Fecha creación:		23/11/2012
	 *
	 */


	session_start();
	require_once('../../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php');
	include_once("../../../control/LibModeloActivoFijo.php");
	
	$nombre_archivo='XLS_ReporteActivoFijoDepreciacion.xls';
	$docexcel = new Spreadsheet_Excel_Writer();
	$nuevahoja =& $docexcel->addWorksheet("Reporte");
	
	$fila=0;
	$columna=0;
	$valor_celda='prueba';
	
	$nuevahoja->setColumn(0,72,20);	

	$Ajustar = &$docexcel->addFormat();
    $Ajustar->setTextWrap(2);
    $Ajustar->setBold(1);
    
    $Ajustar1 = &$docexcel->addFormat();
    $Ajustar1->setBold(1);
    $Ajustar1->setSize(12);
    $Ajustar2 = &$docexcel->addFormat();
    $Ajustar2->setTop(2);
   
    
    $Ajustar3 = &$docexcel->addFormat();
    $Ajustar3->setBold(1);
    $Ajustar3->setTop(2);
    
    
    $Ajustar4 = &$docexcel->addFormat();
    $Ajustar4->setBold(1);
    $Ajustar4->setSize(10);

    
    
	$nuevahoja->write(1,5,'REPORTE DEPRECIACION ACTIVOS FIJOS 2011',$Ajustar1); //dibuja una celad con contenido y orientacion  x, y     
	
	$titulos_columnas = array(
	'ID TIPO ACTIVO FIJO',
	'TIPO ACTIVO',
	'SUBTIPO ACTIVO',
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
	'REVALORIZADO',
	'DESCRIPCION AF'
					
								
												
	);
	
	
	foreach($titulos_columnas as $key => $columna){
		
		$nuevahoja->write(5,$key,$columna,$Ajustar);
		
	}
	
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
			
			//echo $Custom->query; exit;
			$detalle = $Custom->salida;
		
			$fila = 6;
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
			
			
			foreach($detalle as $data){
				
				$tipoActual = $data[0];
				$regionalActual = $data[15];
				
				if($tipoActual != $tipoAnterior){
					
					$tipoAnterior = $tipoActual;
					
					if($flag != 0){
					
						$nuevahoja->write($fila,6,$sumValorContable,$Ajustar4);
						$nuevahoja->write($fila,7,$sumActualizacion,$Ajustar4);
						$nuevahoja->write($fila,8,$sumValorTotal,$Ajustar4);
						$nuevahoja->write($fila,9,$sumDepreciacionAcumIni,$Ajustar4);
						$nuevahoja->write($fila,10,$sumActualizacionDepre,$Ajustar4);
						$nuevahoja->write($fila,11,$sumDeprecAcumActualiz,$Ajustar4);
						$nuevahoja->write($fila,12,$sumDeprecPeriodo,$Ajustar4);
						$nuevahoja->write($fila,13,$sumDepreciacionAcumul,$Ajustar4);
						$nuevahoja->write($fila,14,$sumValorNeto,$Ajustar4);				
						
						$fila = $fila+1;
						
						$nuevahoja->write($fila,0,'',$Ajustar4);
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
					
					$sumValorContable = $sumValorContable + $data[6];
					$sumActualizacion = $sumActualizacion + $data[7];
					$sumValorTotal = $sumValorTotal + $data[8];
					$sumDepreciacionAcumIni = $sumDepreciacionAcumIni + $data[9];
					$sumActualizacionDepre = $sumActualizacionDepre + $data[10];
					$sumDeprecAcumActualiz = $sumDeprecAcumActualiz + $data[11];
					$sumDeprecPeriodo = $sumDeprecPeriodo + $data[12];
					$sumDepreciacionAcumul = $sumDepreciacionAcumul + $data[13];
					$sumValorNeto = $sumValorNeto + $data[14];
					
					$flag = 1; 
					
				}else{
					
					
					$sumValorContable = $sumValorContable + $data[6];
					$sumActualizacion = $sumActualizacion + $data[7];
					$sumValorTotal = $sumValorTotal + $data[8];
					$sumDepreciacionAcumIni = $sumDepreciacionAcumIni + $data[9];
					$sumActualizacionDepre = $sumActualizacionDepre + $data[10];
					$sumDeprecAcumActualiz = $sumDeprecAcumActualiz + $data[11];
					$sumDeprecPeriodo = $sumDeprecPeriodo + $data[12];
					$sumDepreciacionAcumul = $sumDepreciacionAcumul + $data[13];
					$sumValorNeto = $sumValorNeto + $data[14];
					
				}
				
				for($i = 0; $i< sizeof($data)/2 ; $i++){

					$nuevahoja->write($fila,$i,$data[$i]);
					
				}
												
				$fila = $fila+1;
				
				$sumaTotalValorContable = $sumaTotalValorContable + $data[6];
				$sumaTotalActualizacion = $sumaTotalActualizacion + $data[7];
				$sumaTotalValorTotal = $sumaTotalValorTotal + $data[8];
				$sumaTotalDepreciacionAcumIni = $sumaTotalDepreciacionAcumIni + $data[9];
				$sumaTotalActualizacionDepre = $sumaTotalActualizacionDepre + $data[10];
				$sumaTotalDeprecAcumActualiz = $sumaTotalDeprecAcumActualiz + $data[11];
				$sumaTotalDeprecPeriodo = $sumaTotalDeprecPeriodo + $data[12];
				$sumaTotalDeprecAcumul = $sumaTotalDeprecAcumul + $data[13];
				$sumaTotalValorNeto = $sumaTotalValorNeto + $data[14];
				
				
			}
			 
			$nuevahoja->write($fila,6,$sumValorContable,$Ajustar4);
			$nuevahoja->write($fila,7,$sumActualizacion,$Ajustar4);
			$nuevahoja->write($fila,8,$sumValorTotal,$Ajustar4);
			$nuevahoja->write($fila,9,$sumDepreciacionAcumIni,$Ajustar4);
			$nuevahoja->write($fila,10,$sumActualizacionDepre,$Ajustar4);
			$nuevahoja->write($fila,11,$sumDeprecAcumActualiz,$Ajustar4);
			$nuevahoja->write($fila,12,$sumDeprecPeriodo,$Ajustar4);
			$nuevahoja->write($fila,13,$sumDepreciacionAcumul,$Ajustar4);
			$nuevahoja->write($fila,14,$sumValorNeto,$Ajustar4);
			
			
			$nuevahoja->write($fila+2,6,$sumaTotalValorContable,$Ajustar4);
			$nuevahoja->write($fila+2,7,$sumaTotalActualizacion,$Ajustar4);
			$nuevahoja->write($fila+2,8,$sumaTotalValorTotal,$Ajustar4);
			$nuevahoja->write($fila+2,9,$sumaTotalDepreciacionAcumIni,$Ajustar4);
			$nuevahoja->write($fila+2,10,$sumaTotalActualizacionDepre,$Ajustar4);
			$nuevahoja->write($fila+2,11,$sumaTotalDeprecAcumActualiz,$Ajustar4);
			$nuevahoja->write($fila+2,12,$sumaTotalDeprecPeriodo,$Ajustar4);
			$nuevahoja->write($fila+2,13,$sumaTotalDeprecAcumul,$Ajustar4);
			$nuevahoja->write($fila+2,14,$sumaTotalValorNeto,$Ajustar4);
			$nuevahoja->write($fila+2,16,'Total General ',$Ajustar4);
			
		
	$docexcel->send($nombre_archivo);
	$docexcel->close();	
	
?>