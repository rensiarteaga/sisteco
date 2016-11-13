<?php

	session_start();
	require_once('../../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php');
	include_once("../../../control/LibModeloActivoFijo.php");
	
	$nombre_archivo='reporte_genral_activo_fijo.xls';
	$docexcel = new Spreadsheet_Excel_Writer();
	$nuevahoja =& $docexcel->addWorksheet("Reporte General Activo Fijo");
	
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
    
    
	$nuevahoja->write(1,5,'REPORTE GENERAL ACTIVO FIJO RESPONSABLE / CUSTODIO',$Ajustar1); //dibuja una celad con contenido y orientacion  x, y     
	
	$titulos_columnas = array(
	'CODIGO ACTIVO FIJO',
	'DENOMINACION',
    'DESCRIPCION',
    'VIDA UTIL ORIGINAL',
	'VIDA UTIL RESTANTE',
	'TASA DEPRECIACION',
	'FECHA ULTIMA DEPRECIACION',
	'DEPRECIACION ACUM ANTERIOR',
	'DEPRECIACION ACUMULADA',
	'DEPRECIACION PERIODO',
	'FLAG REVALORIZACION',
	'VALOR RESCATE',
	'FECHA COMPRA',
	'MONTO COMPRA ORIGINAL',
	'MONTO COMPRA',
	'MONTO ACTUAL',
	'CON GARANTIA',
	'NUM POLIZA GARANTIA',
	'FECHA FIN GARANTIA',
	'FECHA REGISTRO',
	'NUM FACTURA',
	'TIPO DE CAMBIO',
	'ESTADO',	
	'FECHA INI DEP',
	'UBICACION FISICA',
	'ORDEN COMPRA',
	'MONTO ACTUALIZ',
	'ORIGEN',
	'ESTADO ANTERIOR',
	'CLONACION',
	'PROYECTO',
    'TIPO ACTIVO FIJO BIEN',
	'CODIGO ANTERIOR',
	'OBSERVACIONES',

	'ESTADO ASIG',
	'FECHA ASIGNACION',
	'FECHA FIN ASIGNACION',
	'FECHA MAX PRESTAMO',
	'SW PRESTAMO',
	'TIPO',
	'OBSERVACIONES ASIGNACION',

	'CODIGO EMPLEADO',
	'NOMBRE EMPLEADO',
	'FECHA NACIMIENTO',
	'DOC. IDENTIFICACION',
	'GENERO',
	'CASILLA',
	'TELEFONO 1',
	'TELEFONO 2',
	'CELULAR 1',
	'CELULAR 2',
	'EMAIL 1',
	'EMAIL 2',
	'EMAIL 3',
	'OBSERVACIONES EMPLEADO',
	
	'NOMBRE CUSTODIO',
	'FECHA NACIMIENTO',
	'DOC. IDENTIFICACION',
	'GENERO',
	'CASILLA',
	'TELEFONO 1',
	'TELEFONO 2',
	'CELULAR 1',
	'CELULAR 2',
	'EMAIL 1',
	'EMAIL 2',
	'EMAIL 3',
	'DIRECCION',
	'NRO. REGISTRO',
	'EXTENSION',
	'NUMERO',
	'EXPEDICION',
	'OBSERVACIONES CUSTODIO'
			
			
												
	);
	
	
	foreach($titulos_columnas as $key => $columna){
		
		$nuevahoja->write(5,$key,$columna,$Ajustar);
		
	}
	
       	$cant=0;
		$puntero=0;
		$criterio_filtro="afe.estado = ''activo'' AND af.id_activo_fijo like ''%'' ORDER BY vkp.nombre_completo, nombre_custodio DESC";
		$sortcol='';
		$sortdir='';
		
		$Custom = new cls_CustomDBActivoFijo();
			
		
			
			$res = $Custom->ReporteActivoFijoResponsableCustodioGeneral($cant, $puntero, $sortdir, $sortcol, $criterio_filtro);
			$detalle = $Custom->salida;
		
			$fila = 6;
			$cont = 0;
			foreach($detalle as $data){
				
				for($i = 0; $i< sizeof($data)/2 ; $i++){

					$nuevahoja->write($fila,$i,$data[$i]);
					
				}
												
				$fila = $fila+1;
				
				
			}
			 
			
	   		
		
		
	$docexcel->send($nombre_archivo);
	$docexcel->close();	
	
?>