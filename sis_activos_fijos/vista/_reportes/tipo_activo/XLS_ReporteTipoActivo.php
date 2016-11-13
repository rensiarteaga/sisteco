<?php

	/**
	 * Nombre:				XLS_ReporteTipoActivo.php
	 * Descripcion:			Permite la recuperacion de la informacion referente a los tipos y subtipos de activos fijos en un archivo XLS
	 * Autor:				UNKNOW
	 * Fecha creaci�n:		22/07/2015
	 *
	 */

	session_start();
	require_once('../../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php');
	include_once("../../../control/LibModeloActivoFijo.php");
	
	$nombre_archivo='XLS_ReporteTipoActivo.xls';
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
    $Ajustar1->setSize(12);
    
    $Ajustar2 = &$docexcel->addFormat();
    $Ajustar2->setTop(2);
   
    
    $Ajustar3 = &$docexcel->addFormat();
    //$Ajustar3->setBold(1);
    $Ajustar3->setTop(2);
    
    
    $Ajustar4 = &$docexcel->addFormat();
    $Ajustar4->setBold(1);
    $Ajustar4->setSize(10);

    
    
	$nuevahoja->write(1,5,' TIPOS Y SUBTIPOS DE ACTIVOS FIJOS ',$Ajustar1); //dibuja una celad con contenido y orientacion  x, y     
		
       	$cant=0;
		$puntero=0;
		$criterio_filtro="";
		
		if($id_grupo_dep != null){
			$criterio_filtro = array("$id_grupo_dep","$fecha_hasta");
		}
		
		$sortcol='';
		$sortdir='';
		
		$Custom = new cls_CustomDBActivoFijo();
			

		$res = $Custom->ReporteTipoSubtipoActivoFijo($cant, $puntero, $sortdir, $sortcol, $criterio_filtro);
		
		$detalle = $Custom->salida;
		
		$fila = 6;
		$col=2;
		
		$cont = 0;
						
		$tipoAnterior=-1;
			
		foreach($detalle as $data)
		{
				
				$tipoActual = $data[1];
				
				if($tipoActual != $tipoAnterior)
				{
					$tipoAnterior = $tipoActual;
					$cont = 1;
					
						$nuevahoja->write($fila,$col,'CODIGO TIPO :'.$data[2],$Ajustar4);
						$nuevahoja->write($fila+1,$col,'DESCRIPCION TIPO :'.$data[3],$Ajustar4);
						$nuevahoja->write($fila+2,$col,'DEPRECIABLE :'.$data[4],$Ajustar4);
						$nuevahoja->write($fila+3,$col,'ESTADO :'.$data[5],$Ajustar4);
						
						$fila = $fila+4;
						
						$nuevahoja->write($fila,2,'NUMERO',$Ajustar4);
						$nuevahoja->write($fila,3,'CODIGO SUBTIPO',$Ajustar4);
						$nuevahoja->write($fila,4,'DESCRIPCIUN SUBTIPO',$Ajustar4);
						$nuevahoja->write($fila,5,'VIDA UTIL',$Ajustar4);
						$nuevahoja->write($fila,6,'ESTADO',$Ajustar4);
						$nuevahoja->write($fila,7,'CARACTERISCTICAS',$Ajustar4);
						$fila +=1;
						$nuevahoja->write($fila,2,$cont,$Ajustar3);
						$nuevahoja->write($fila,3,$data[7],$Ajustar3);
						$nuevahoja->write($fila,4,$data[8],$Ajustar3);
						$nuevahoja->write($fila,5,$data[9],$Ajustar3);
						$nuevahoja->write($fila,6,$data[10],$Ajustar3);
						$nuevahoja->write($fila,7,$data[11],$Ajustar3);
						$fila +=1;$cont += 1;

				}
				else 
				{
						$nuevahoja->write($fila,2,$cont,$Ajustar3);
						$nuevahoja->write($fila,3,$data[7],$Ajustar3);
						$nuevahoja->write($fila,4,$data[8],$Ajustar3);
						$nuevahoja->write($fila,5,$data[9],$Ajustar3);
						$nuevahoja->write($fila,6,$data[10],$Ajustar3);
						$nuevahoja->write($fila,7,$data[11],$Ajustar3);
						$fila +=1;
						$cont += 1;
				}
			
			}
		
		
	$docexcel->send($nombre_archivo);
	$docexcel->close();	
	
?>