<?php
	
	session_start();
	
	require_once('../../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php');
	include_once("../../LibModeloFlujo.php");
	
	$nombre_archivo='ESTADO_CORRESPONDENCIA.xls';
	$docexcel = new Spreadsheet_Excel_Writer(); //creamos una instancia de excel
	$nuevahoja =& $docexcel->addWorksheet('ESTADO_CORR'); //colocamos nombre a la pestaña
	
	$fila=0;
	$columna=0;
	$valor_celda='prueba';
	$nuevahoja->setColumn(0,5,15);
	
	//Creamos los diferentes formatos a ser utilizados
	$titulo1=& $docexcel->addFormat();
	$titulo2=& $docexcel->addFormat();
	$negritaCentrado=& $docexcel->addFormat();//creamos el formato negrilla y centrado
	$negritaCentradoSubrayado=& $docexcel->addFormat();	
	$negrita =& $docexcel->addFormat();
	$bordesLaterales =& $docexcel->addFormat();
	$bordesSimplesNegrita =& $docexcel->addFormat();
	
	$titulo1->setBold();
	$titulo1->setAlign(center);
	$titulo1->setSize(14);
	$titulo2->setBold();
	$titulo2->setAlign(center);
	$titulo2->setSize(12);
	$negritaCentrado->setBold();
	$negritaCentrado->setAlign(center);
	$negritaCentrado->setBorder(2);
	$negritaCentradoSubrayado->setBold();
	$negritaCentradoSubrayado->setAlign(center);
	$negritaCentradoSubrayado->setUnderline(1);
	$negritaCentradoSubrayado->setSize(12);
	$negrita->setBold();	
	$bordesSimplesNegrita->setBorder(1);
	$bordesSimplesNegrita->setBold();
	$bordesLaterales->setLeft(1);
	$bordesLaterales->setRight(1);
		
	$nuevahoja->write(2,2,'ESTADO DE CORRESPONDENCIA',$titulo1); //dibuja una celad con contenido y orientacion  x, y 		
	$nuevahoja->write(4,2,'DEL: '.$_SESSION['desde'].' AL: '.$_SESSION['hasta'],$negritaCentradoSubrayado);	
	
	//cabeceras de las columnas	
    $nuevahoja->write(7,0,'NUMERO',$negritaCentrado);
    $nuevahoja->write(7,1,'ESTADO',$negritaCentrado);
    $nuevahoja->write(7,2,'DIGITAL',$negritaCentrado);
    $nuevahoja->write(7,3,'REFERENCIA',$negritaCentrado);	
	$nuevahoja->write(7,4,'USUARIO REG.',$negritaCentrado);	
	$nuevahoja->write(7,5,'UNIDAD ORG.',$negritaCentrado);	
    	
    //Realizamos la consulta
 	$Custom = new cls_CustomDBFlujo();
 		
	$cant=1000;
	$puntero=0;
	$sortcol='corr.numero';
	$sortdir='asc';	    
	
	$fecha_desde = $_SESSION['desde'];
	$fecha_fin = $_SESSION['hasta'];
	$id_unidad_organizacional = $_SESSION['id_uo'];
	
	$criterio_filtro= $criterio_filtro." corr.id_uo like ''$id_unidad_organizacional'' and corr.fecha_reg >= ''$fecha_desde'' and corr.fecha_reg <= ''$fecha_fin'' ";
	
	$res = $Custom-> ListarEstadoCorrespondencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);

	if($res)
	{
		$data=$Custom->salida;    
		$fila=8;
		$num=1;		
		foreach($data as $row)
		{ 			
			$nuevahoja->write($fila,0,$row[0],$bordesLaterales);
			$nuevahoja->write($fila,1,$row[1],$bordesLaterales);
	    	$nuevahoja->write($fila,2,$row[2],$bordesLaterales);
	        $nuevahoja->write($fila,3,$row[3],$bordesLaterales);
			$nuevahoja->write($fila,4,$row[4],$bordesLaterales);
			$nuevahoja->write($fila,5,$row[5],$bordesLaterales);
		    $fila++;
			$num++;
		}//FIN DE FOREACH*/
		
				
		/*$nuevahoja->write($fila+2,4,'FIRMA Y SELLO ',$negrita);
		$nuevahoja->write($fila+3,0,'Elaborado por: ',$negrita);
		$nuevahoja->write($fila+4,0,'Aprobado por: ',$negrita);*/
		
		$docexcel->send($nombre_archivo);
		$docexcel->close();
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "401");
		$resp->mensaje_error = 'MENSAJE ERROR = Error al generar el archivo xls';
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = 'NIVEL = 3';
		echo $resp->get_mensaje();
		exit;
	}	
?>