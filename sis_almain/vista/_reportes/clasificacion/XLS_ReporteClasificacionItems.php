<?php

	/**
	 * Nombre:				XLS_ReporteTipoActivo.php
	 * Descripcion:			Permite la recuperacion de la informacion referente a la clasificacion de los items en un archivo XLS
	 * Autor:				UNKNOW
	 * Fecha creaci�n:		
	 *
	 */

	session_start();
	require_once('../../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php');
	include_once("../../../control/LibModeloAlma.php");
	
	$nombre_archivo='XLS_ReporteClasificacionItems.php';
	$docexcel = new Spreadsheet_Excel_Writer();
	$nuevahoja =& $docexcel->addWorksheet("Reporte");
	
	$fila=6;
	$columna=4;
	$valor_celda='prueba';
	
	$nuevahoja->setColumn(0,72,20);	

	$Ajustar = &$docexcel->addFormat();
    $Ajustar->setTextWrap(2);
    $Ajustar->setBold(1);
    
    $Ajustar1 = &$docexcel->addFormat();
    $Ajustar1->setBold(1);
    $Ajustar1->setSize(16);
    
    $Ajustar2 = &$docexcel->addFormat();
    $Ajustar2->setBold(0);
    $Ajustar2->setAlign('left');
    
   // $Ajustar2->setTop(2);
   
    
    $Ajustar3 = &$docexcel->addFormat();
    //$Ajustar3->setBold(1);
    $Ajustar3->setTop(2);
    
    
    $Ajustar4 = &$docexcel->addFormat();
    $Ajustar4->setBold(1);
    $Ajustar4->setSize(10);

    
    
	$nuevahoja->write(1,5,' CLASIFICACION 	DE 	ITEMS ',$Ajustar1); //dibuja una celad con contenido y orientacion  x, y     
		
       	$cant=0;
		$puntero=0;
		$criterio_filtro="0=0";		
		$sortcol='';
		$sortdir='';
		
		$Custom = new cls_CustomDBAlma(); 

		$res = $Custom->ReporteClasificacionItems($cant, $puntero, $sortdir, $sortcol, $criterio_filtro);
		
		$detalle = $Custom->salida;
		
		$fila = 4;
		$col=2;
		
		$cont = 0;
		$fila = 5;
			
		foreach($detalle as $data)
		{
			
			if($data[5] == '' || $data[5] == null)
			{
				$nuevahoja->write($fila,4,$data[7],$Ajustar4);
				
			}
			else
			{
				$nuevahoja->write($fila,4,$data[7],$Ajustar2);
			}
			
			$fila++;
			$col=4;					
		}
		
		
	$docexcel->send($nombre_archivo);
	$docexcel->close();	
	
?>