<?php
	
	session_start();
	
	require_once('../../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php');
	include_once("../../LibModeloPresupuesto.php");
	
	$nombre_archivo='MEMORIA_CALC_RRHH_GRAL.xls';
	$docexcel = new Spreadsheet_Excel_Writer(); //creamos una instancia de excel
	$nuevahoja =& $docexcel->addWorksheet($_SESSION['rep_mem_cal_codigo_partida']); //colocamos nombre a la pesta�a
	
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
	
	
	$fila=0;
	$columna=0;
	$valor_celda='prueba';
	$nuevahoja->setColumn(0,5,15);
	$nuevahoja->write(2,2,'DIRECCION GENERAL DE ASUNTOS ADMINISTRATIVOS',$titulo1); //dibuja una celad con contenido y orientacion  x, y 
	$nuevahoja->write(3,2,'MEMORIAS DE CALCULO',$titulo1);	
	$nuevahoja->write(4,2,'ANTEPROYECTO PRESUPUESTO GESTION '.$_SESSION['rep_mem_cal_gestion_pres'],$titulo2);
	$nuevahoja->write(5,2,'COSTOS ESTIMADOS POR PARTIDA DE GASTO',$titulo2);	
	$nuevahoja->write(7,2,'PARTIDA '.$_SESSION['rep_mem_cal_codigo_partida'].' "'.$_SESSION['rep_mem_cal_nombre_partida'].'"',$negritaCentradoSubrayado);	
	
	
	if($_SESSION['filtro'] == 1)
	{ 
		//adicionando la estructura programtica	    
		$nuevahoja->write(9,0,"REGIONAL: ");
		$nuevahoja->write(9,1,$_SESSION['rep_mem_cal_regional']);
		  
		$nuevahoja->write(10,0,"ORGANISMO FINANCIADOR: ");
		$nuevahoja->write(10,1,$_SESSION['rep_mem_cal_financiador']);
		
		$nuevahoja->write(11,0,"PROGRAMA: ");
		$nuevahoja->write(11,1,$_SESSION['rep_mem_cal_programa']);
		
		$nuevahoja->write(12,0,"PROYECTO: ");
		$nuevahoja->write(12,1,$_SESSION['rep_mem_cal_proyecto']);
		
		$nuevahoja->write(13,0,"ACTIVIDAD: ");
		$nuevahoja->write(13,1,$_SESSION['rep_mem_cal_actividad']);
			
		$nuevahoja->write(14,0,'FUENTE DE FINANCIAMIENTO: ');
		$nuevahoja->write(14,1,$_SESSION['rep_mem_serv_fuente_financiamiento']);
		
		$nuevahoja->write(15,0,'UNIDAD ORGANIZACIONAL: ');
		$nuevahoja->write(15,1,$_SESSION['rep_mem_cal_unidad_organizacional']);
	}
	else
	{
		//adicionando la categoria programatica
		$nuevahoja->write(10,0,"PROGRAMA: ");
		$nuevahoja->write(10,1,$_SESSION['rep_mem_cal_programa']);
		//$nuevahoja->write(10,1,$cod_prog);
		
		$nuevahoja->write(11,0,"PROYECTO: ");
		$nuevahoja->write(11,1,$_SESSION['rep_mem_cal_proyecto']);
		//$nuevahoja->write(11,1,$cod_proy);
		
		$nuevahoja->write(12,0,"ACTIVIDAD: ");
		$nuevahoja->write(12,1,$_SESSION['rep_mem_cal_actividad']);
		//$nuevahoja->write(12,1,$cod_act);
		
		$nuevahoja->write(13,0,"ORGANISMO FINANCIADOR: ");
		$nuevahoja->write(13,1,$_SESSION['rep_mem_cal_financiador']);
		//$nuevahoja->write(13,1,$cod_organismo);
			
		$nuevahoja->write(14,0,'FUENTE DE FINANCIAMIENTO: ');
		$nuevahoja->write(14,1,$_SESSION['rep_mem_serv_fuente_financiamiento']);
		//$nuevahoja->write(14,1,$cod_fuente_fin);
	}
	
	
	
	$nuevahoja->write(12,4,$_SESSION['rep_mem_cal_cod_formulario_gasto'],$bordesSimplesNegrita);
	$nuevahoja->write(14,4,'GESTION:     '.$_SESSION['rep_mem_cal_gestion_pres'],$bordesSimplesNegrita);
	$nuevahoja->write(15,4,'FECHA ELAB.: '.$_SESSION['rep_mem_cal_fecha_elaboracion'],$bordesSimplesNegrita);	

	
	//cabeceras de las columnas	
     $nuevahoja->write(18,0,'Nro.',$negritaCentrado);
    $nuevahoja->write(18,1,'DESCRIPCION',$negritaCentrado);
    $nuevahoja->write(18,2,'COSTO MENSUAL',$negritaCentrado);
    $nuevahoja->write(18,3,'COSTO ANUAL',$negritaCentrado);	
	$nuevahoja->write(18,4,'JUSTIFICACION',$negritaCentrado);	
    
	
    //Realizamos la consulta
 	$Custom = new cls_CustomDBPresupuesto();
	$CustomS = new cls_CustomDBPresupuesto();
    	
	$cant=1000;
	//$cant=15;
	$puntero=0;
	//$sortcol='SERVIC.nombre';
	$sortcol='CINGAS.desc_ingas_item_serv';
	$sortdir='asc';	    
	if($_SESSION['filtro'] == 1)
	{    
		$criterio_filtro="PARPRE.id_partida=$id_partida AND PRESUP.id_presupuesto like ''$id_presupuesto'' AND MEMCAL.tipo_detalle= $tipo_memoria AND MONEDA.id_moneda=$id_moneda AND PRESUP.tipo_pres =$tipo_pres ";
	}
	else 
	{
		$criterio_filtro="PARPRE.id_partida=$id_partida AND VPRE.cod_prg = ''$cod_prog'' and vpre.cod_proy = ''$cod_proy'' and vpre.cod_act = ''$cod_act'' and vpre.cod_fin = ''$cod_organismo'' and vpre.codigo_fuente = ''$cod_fuente_fin'' AND MEMCAL.tipo_detalle= $tipo_memoria AND MONEDA.id_moneda=$id_moneda AND PRESUP.tipo_pres =$tipo_pres ";
	}
	$res = $Custom->ListarRepGralMemoriaCalculoRRHH($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);		
	       
	
	if($res)
	{
		$data=$Custom->salida;    
		$fila=19;
		$num=1;		
		foreach($data as $row)
		{ 
			$nuevahoja->write($fila,0,$num,$bordesLaterales);
			$nuevahoja->write($fila,1,$row[0],$bordesLaterales);
			$nuevahoja->write($fila,2,$row[1],$bordesLaterales);
	    	$nuevahoja->write($fila,3,$row[2],$bordesLaterales);
	        $nuevahoja->write($fila,4,$row[3],$bordesLaterales);
			$nuevahoja->write($fila,5,$row[4],$bordesLaterales);

			
		    $fila++;
			$num++;
		}//FIN DE FOREACH*/
		
		if($_SESSION['filtro'] == 1)
	    {	
			$criterio_suma="PARPRE.id_partida=$id_partida AND PRESUP.id_presupuesto like ''$id_presupuesto'' AND MEMCAL.tipo_detalle=$tipo_memoria AND MONEDA.id_moneda=$id_moneda AND PRESUP.tipo_pres =$tipo_pres";
	    }
	    else 
	    {
	    	$criterio_suma="PARPRE.id_partida=$id_partida AND VPRE.cod_prg = ''$cod_prog'' and vpre.cod_proy = ''$cod_proy'' and vpre.cod_act = ''$cod_act'' and vpre.cod_fin = ''$cod_organismo'' and vpre.codigo_fuente = ''$cod_fuente_fin'' AND MEMCAL.tipo_detalle= $tipo_memoria AND MONEDA.id_moneda=$id_moneda AND PRESUP.tipo_pres =$tipo_pres ";
	    }
		$res2 = $CustomS->SumaCostoMemoriaCalculoRRHH(15,0,'','',$criterio_suma,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);		
		$suma_total=$CustomS->salida;
		
		$nuevahoja->write($fila,0,'TOTAL PRESUPUESTO ANUAL ',$bordesSimplesNegrita);
		$nuevahoja->write($fila,1,'',$bordesSimplesNegrita);
		$nuevahoja->write($fila,2,'',$bordesSimplesNegrita);
		$nuevahoja->write($fila,3,number_format($suma_total, 2, '.', ','),$bordesSimplesNegrita);
		$nuevahoja->write($fila,4,'',$bordesSimplesNegrita);

		
		$nuevahoja->write($fila+2,4,'FIRMA Y SELLO ',$negrita);
		$nuevahoja->write($fila+3,0,'Elaborado por: ',$negrita);
		$nuevahoja->write($fila+4,0,'Aprobado por: ',$negrita);
		
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