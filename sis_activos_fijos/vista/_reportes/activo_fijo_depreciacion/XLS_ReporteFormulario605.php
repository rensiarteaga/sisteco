<?php

	session_start();
	require_once('../../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php');
	include_once("../../../control/LibModeloActivoFijo.php");
	
	$nombre_archivo='ReporteFormulario605.xls';
	$docexcel = new Spreadsheet_Excel_Writer();
	$nuevahoja =& $docexcel->addWorksheet("Formulario 605");
	
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
    //$Ajustar4->setSize(10);
    
	$nuevahoja->write(1,5,'',$Ajustar1); //dibuja una celad con contenido y orientacion  x, y     
	
	$titulos_columnas = array(
	'CODIGO ACTIVO FIJO', 'DESCRIPCION ACTIVO FIJO','CANTIDAD','VALOR NETO REAL','BAJAS' 											
	);
	
	
	foreach($titulos_columnas as $key => $columna){
		
		$nuevahoja->write(0,$key,$columna,$Ajustar);
		
	}

       	$cant=0;
		$puntero=0;
		$criterio_filtro=array("$id_grupo_dep");
		$sortcol='';
		$sortdir='';
		
		$Custom = new cls_CustomDBActivoFijo();
			
			
			
			$res = $Custom->ReporteActivoFijoFormulario605($cant, $puntero, $sortdir, $sortcol, $criterio_filtro);
			$detalle = $Custom->salida;
		
			$fila = 1;
			$cont = 0;
			$total_valor_neto=0;
			$total_cantidad=0;
			foreach($detalle as $data)
			{
				for($i = 0; $i<sizeof($data) ; $i++)
				{
					$nuevahoja->write($fila,$i,$data[$i]);
				}
												
				$fila = $fila+1;
				$total_valor_neto+=$data[3];
				$total_cantidad+=$data[2];	
			}
			$nuevahoja->write($fila+4,2,number_format($total_cantidad,2),$Ajustar4);
			$nuevahoja->write($fila+4,3,number_format($total_valor_neto,2),$Ajustar4);

	$docexcel->send($nombre_archivo);
	$docexcel->close();	
	
?>