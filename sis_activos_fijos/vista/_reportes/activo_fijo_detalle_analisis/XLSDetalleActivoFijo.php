<?php

	/**
	 * Nombre:				XLSDetalleActivoFijo.php
	 * Descripcion:			Permite la recuperacion de la informacion de los activos fijos					
	 * Autor:				Daniel Sanchez Torrico
	 * Fecha creación:		09/04/2013
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
	
	
	$nuevahoja->write(1,5,'REPORTE DETALLE DE ACTIVOS FIJOS',$Ajustar1); //dibuja una celad con contenido y orientacion  x, y
	
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
	);
	$posiciones = $_SESSION['posiciones_cabeceras'];
	$criterio_cabeceras = $_SESSION['criterio_cabeceras'];
	
	//echo $criterio_cabeceras; exit;
	
	$titulos_columnas = array();
	
	foreach($posiciones as $pos){
		$titulos_columnas[] = $titulos_columnas_total[$pos];
	}
	
	
	foreach($titulos_columnas as $key => $columna){
	
		$nuevahoja->write(5,$key,$columna,$Ajustar);
	
	}
	
	//añadido 14/07/2015
	$nuevahoja->write(5,count($titulos_columnas),'PROGRAMA',$Ajustar);
	$nuevahoja->write(5,count($titulos_columnas)+1,'TENSION',$Ajustar);
	
	$cant=0;
	$puntero=0;
	$sortcol='';
	$sortdir='';
	$criterio_filtro = $_SESSION['detalle_criterio_filtro'];
	
	$Custom = new cls_CustomDBActivoFijo();
	
	$res = $Custom->ReporteDetalleActivoFijoAnalisis($cant, $puntero, $sortdir, $sortcol, $criterio_filtro,$criterio_cabeceras);

	$detalle = $Custom->salida;

	//echo $Custom->query;exit;
	
	$fila = 6;

	/*echo sizeof($detalle);
	echo sizeof($detalle[0]);exit;*/
		
	foreach($detalle as $data){

	
		for($i = 0; $i< sizeof($data)/2 ; $i++){
	
			$nuevahoja->write($fila,$i,$data[$i]);
				
		}
		
		$fila = $fila + 1;
		
	}

		
	
	$docexcel->send($nombre_archivo);
	$docexcel->close();
	
?>