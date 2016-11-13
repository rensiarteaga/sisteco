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

    
    
	$nuevahoja->write(1,5,'REPORTE DEPRECIACION ACTIVOS FIJOS ',$Ajustar1); //dibuja una celad con contenido y orientacion  x, y     
	
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
	//añadido 13/02/2014
	,'FECHA INICIO DEPRECIACION','FECHA COMPRA','RESPONSABLE'		
	,'DESCRIPCION'							
												
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
					
						$nuevahoja->write($fila,5,$sumValorContable,$Ajustar4);
						$nuevahoja->write($fila,6,$sumActualizacion,$Ajustar4);
						$nuevahoja->write($fila,7,$sumValorTotal,$Ajustar4);
						$nuevahoja->write($fila,8,$sumDepreciacionAcumIni,$Ajustar4);
						$nuevahoja->write($fila,9,$sumActualizacionDepre,$Ajustar4);
						$nuevahoja->write($fila,10,$sumDeprecAcumActualiz,$Ajustar4);
						$nuevahoja->write($fila,11,$sumDeprecPeriodo,$Ajustar4);
						$nuevahoja->write($fila,12,$sumDepreciacionAcumul,$Ajustar4);
						$nuevahoja->write($fila,13,$sumValorNeto,$Ajustar4);				
						
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
				
				/*if($regionalActual != $regionalAnterior){
					$regionalTemp = $regionalAnterior;
					$regionalAnterior = $regionalActual;
					
					if($flag != 0){
					
						$nuevahoja->write($fila-1,5,$sumValorContable2,$Ajustar4);
						$nuevahoja->write($fila-1,6,$sumActualizacion2,$Ajustar4);
						$nuevahoja->write($fila-1,7,$sumValorTotal2,$Ajustar4);
						$nuevahoja->write($fila-1,8,$sumDepreciacionAcumIni2,$Ajustar4);
						$nuevahoja->write($fila-1,9,$sumActualizacionDepre2,$Ajustar4);
						$nuevahoja->write($fila-1,10,$sumDeprecAcumActualiz2,$Ajustar4);
						$nuevahoja->write($fila-1,11,$sumDeprecPeriodo2,$Ajustar4);
						$nuevahoja->write($fila-1,12,$sumDepreciacionAcumul2,$Ajustar4);
						$nuevahoja->write($fila-1,13,$sumValorNeto2,$Ajustar4);				
						$nuevahoja->write($fila-1,15,'Total '.$regionalTemp,$Ajustar4);				
						
						$fila = $fila+1;
						
						$nuevahoja->write($fila,0,'',$Ajustar4);
						$fila = $fila+1;
					
						
						$lineasAdicionales++;
					}
					
					$sumValorContable2 = 0;
					$sumActualizacion2 = 0;
					$sumValorTotal2 = 0;
					$sumDepreciacionAcumIni2 = 0;
					$sumActualizacionDepre2 = 0;
					$sumDeprecAcumActualiz2 = 0;
					$sumDeprecPeriodo2 = 0;
					$sumDepreciacionAcumul2 = 0;
					$sumValorNeto2 = 0;
					
					$sumValorContable2 = $sumValorContable2 + $data[5];
					$sumActualizacion2 = $sumActualizacion2 + $data[6];
					$sumValorTotal2 = $sumValorTotal2 + $data[7];
					$sumDepreciacionAcumIni2 = $sumDepreciacionAcumIni2 + $data[8];
					$sumActualizacionDepre2 = $sumActualizacionDepre2 + $data[9];
					$sumDeprecAcumActualiz2 = $sumDeprecAcumActualiz2 + $data[10];
					$sumDeprecPeriodo2 = $sumDeprecPeriodo2 + $data[11];
					$sumDepreciacionAcumul2 = $sumDepreciacionAcumul2 + $data[12];
					$sumValorNeto2 = $sumValorNeto2 + $data[13];
					
					$flag = 1; 
					
				}else{
					
					
					$sumValorContable2 = $sumValorContable2 + $data[5];
					$sumActualizacion2 = $sumActualizacion2 + $data[6];
					$sumValorTotal2 = $sumValorTotal2 + $data[7];
					$sumDepreciacionAcumIni2 = $sumDepreciacionAcumIni2 + $data[8];
					$sumActualizacionDepre2 = $sumActualizacionDepre2 + $data[9];
					$sumDeprecAcumActualiz2 = $sumDeprecAcumActualiz2 + $data[10];
					$sumDeprecPeriodo2 = $sumDeprecPeriodo2 + $data[11];
					$sumDepreciacionAcumul2 = $sumDepreciacionAcumul2 + $data[12];
					$sumValorNeto2 = $sumValorNeto2 + $data[13];
					
				}*/
				
				for($i = 0; $i< sizeof($data)/2 ; $i++){

					$nuevahoja->write($fila,$i,$data[$i]);
					
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
			 
			$nuevahoja->write($fila,5,$sumValorContable,$Ajustar4);
			$nuevahoja->write($fila,6,$sumActualizacion,$Ajustar4);
			$nuevahoja->write($fila,7,$sumValorTotal,$Ajustar4);
			$nuevahoja->write($fila,8,$sumDepreciacionAcumIni,$Ajustar4);
			$nuevahoja->write($fila,9,$sumActualizacionDepre,$Ajustar4);
			$nuevahoja->write($fila,10,$sumDeprecAcumActualiz,$Ajustar4);
			$nuevahoja->write($fila,11,$sumDeprecPeriodo,$Ajustar4);
			$nuevahoja->write($fila,12,$sumDepreciacionAcumul,$Ajustar4);
			$nuevahoja->write($fila,13,$sumValorNeto,$Ajustar4);
			
			/*$nuevahoja->write($fila+1,5,$sumValorContable2,$Ajustar4);
			$nuevahoja->write($fila+1,6,$sumActualizacion2,$Ajustar4);
			$nuevahoja->write($fila+1,7,$sumValorTotal2,$Ajustar4);
			$nuevahoja->write($fila+1,8,$sumDepreciacionAcumIni2,$Ajustar4);
			$nuevahoja->write($fila+1,9,$sumActualizacionDepre2,$Ajustar4);
			$nuevahoja->write($fila+1,10,$sumDeprecAcumActualiz2,$Ajustar4);
			$nuevahoja->write($fila+1,11,$sumDeprecPeriodo2,$Ajustar4);
			$nuevahoja->write($fila+1,12,$sumDepreciacionAcumul2,$Ajustar4);
			$nuevahoja->write($fila+1,13,$sumValorNeto2,$Ajustar4);
			$nuevahoja->write($fila+1,15,'Total '.$regionalActual,$Ajustar4);*/
			
			//$lineasAdicionales = $lineasAdicionales +2;
			//$nuevahoja->write($fila+2,4,"Lineas Adicionales".$lineasAdicionales,$Ajustar4);
			
			$nuevahoja->write($fila+2,5,$sumaTotalValorContable,$Ajustar4);
			$nuevahoja->write($fila+2,6,$sumaTotalActualizacion,$Ajustar4);
			$nuevahoja->write($fila+2,7,$sumaTotalValorTotal,$Ajustar4);
			$nuevahoja->write($fila+2,8,$sumaTotalDepreciacionAcumIni,$Ajustar4);
			$nuevahoja->write($fila+2,9,$sumaTotalActualizacionDepre,$Ajustar4);
			$nuevahoja->write($fila+2,10,$sumaTotalDeprecAcumActualiz,$Ajustar4);
			$nuevahoja->write($fila+2,11,$sumaTotalDeprecPeriodo,$Ajustar4);
			$nuevahoja->write($fila+2,12,$sumaTotalDeprecAcumul,$Ajustar4);
			$nuevahoja->write($fila+2,13,$sumaTotalValorNeto,$Ajustar4);
			$nuevahoja->write($fila+2,15,'Total General ',$Ajustar4);
			
		
	$docexcel->send($nombre_archivo);
	$docexcel->close();	
	
?>