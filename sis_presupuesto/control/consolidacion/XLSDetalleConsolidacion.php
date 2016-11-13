<?php
	
	session_start();
	
	require_once('../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php');
	include_once("../LibModeloPresupuesto.php");
	
	$nombre_archivo='CONSOL_PRESTO.xls';
	$docexcel = new Spreadsheet_Excel_Writer();
	$nuevahoja =& $docexcel->addWorksheet("CONSOL PRESTO");
	$negrita =& $docexcel->addFormat();//adicionando negrita a los totales
	$negrita->setBold();
	
	$fila=0;
	$columna=0;
	$valor_celda='prueba';
	$nuevahoja->setColumn(1,18,15);
	$nuevahoja->write(1,3,'CONSOLIDACIÓN DE LA FORMULACIÓN PRESUPUESTARIA'); //dibuja una celad con contenido y orientacion  x, y 
	$nuevahoja->write(2,3,'Presupuesto de '.$_SESSION['PDF_desc_pres']." Gestión ".$_SESSION['PDF_gestion_pres']);	
	$nuevahoja->write(3,3,'(Expresado en '.$_SESSION['PDF_desc_moneda'].')');
	//cuando el reporte sea por presupuesto mostramos el identificador
	if($_SESSION['PDF_filtro'] == 1)	
	{
		$nuevahoja->write(4,3,'Identificador: '.$_SESSION['PDF_id_presupuesto'] );		
	}
	
	//Filtramos por categoria programatica y mostramos una cabecera
	if($_SESSION['PDF_filtro'] == 2)	 
	{		
		$nuevahoja->write(6,1,'DESCRIPCIÓN: ');
		$nuevahoja->write(6,3,$_SESSION['PDF_descripcion_cp']);			
		
		$nuevahoja->write(7,1,'CATEGORÍA PROGRAMATICA: ');
		$nuevahoja->write(7,3,$_SESSION['PDF_cod_programa']." - ".$_SESSION['PDF_cod_proyecto']." - ".$_SESSION['PDF_cod_actividad']);
		$nuevahoja->write(8,1,'FUENTE DE FINANCIAMIENTO: ');
		$nuevahoja->write(8,3,$_SESSION['PDF_cod_fuente_financiamiento']);
		$nuevahoja->write(9,1,'ORGANISMO FINANCIADOR: ');
		$nuevahoja->write(9,3,$_SESSION['PDF_cod_organismo_financiador']);
		
		if($_SESSION['PDF_tipo_pres']==3)
		{		
			$nuevahoja->write(10,1,'CÓDIGO SISIN: ');
			$nuevahoja->write(10,3,$_SESSION['PDF_codigo_sisin']);
		}	
		
	}
	else //filtramos por presupuesto
	{	
		$nuevahoja->write(6,1,'UNIDAD ORGANIZACIONAL: ');
		$nuevahoja->write(6,3,$_SESSION['PDF_unidad_organizacional'] ." - ".$_SESSION['PDF_proyecto']." - ".$_SESSION['PDF_actividad'] );			
		
		$nuevahoja->write(7,1,'CATEGORÍA PROGRAMATICA: ');
		$nuevahoja->write(7,3,$_SESSION['PDF_cod_programa']." - ".$_SESSION['PDF_cod_proyecto']." - ".$_SESSION['PDF_cod_actividad'] );
		$nuevahoja->write(8,1,'FUENTE DE FINANCIAMIENTO: ');
		$nuevahoja->write(8,3,$_SESSION['PDF_cod_fuente_financiamiento']);
		$nuevahoja->write(9,1,'ORGANISMO FINANCIADOR: ');
		$nuevahoja->write(9,3,$_SESSION['PDF_cod_organismo_financiador']);
		
		if($_SESSION['PDF_tipo_pres']==3)
		{		
			$nuevahoja->write(10,1,'CÓDIGO SISIN: ');
			$nuevahoja->write(10,3,$_SESSION['PDF_codigo_sisin']);
		}		
	
		//adicionando la estructura programtica	
		$epe=" ";	 
	    $nuevahoja->write(6,7,'EP: ');
	    		    
	    if($_SESSION['PDF_regional'])
	    {
	     	$epe=$epe."REGIONAL: ";	     	
	     	$nuevahoja->write(6,8,$epe);
	     	$nuevahoja->write(6,9,$_SESSION['PDF_regional']);
		}
	   	if($_SESSION['PDF_financiador'])
	   	{   
			$epe="FINANCIADOR: ";
			$nuevahoja->write(7,8,$epe);
			$nuevahoja->write(7,9,$_SESSION['PDF_financiador']);
	 	}	 			
		if($_SESSION['PDF_programa'])
		{
			$epe="PROGRAMA: ";
			$nuevahoja->write(8,8,$epe);
			$nuevahoja->write(8,9,$_SESSION['PDF_programa']);		
		}	 		 
		if($_SESSION['PDF_proyecto'])
		{
			$epe="PROYECTO: ";	
			$nuevahoja->write(9,8,$epe);
			$nuevahoja->write(9,9,$_SESSION['PDF_proyecto']);
		}
	 	if($_SESSION['PDF_actividad'])
		{
			$epe="ACTIVIDAD: ";	
			$nuevahoja->write(10,8,$epe);
			$nuevahoja->write(10,9,$_SESSION['PDF_actividad']);
		}
		
			
		if($epe==" ")
		{
			$epe="Todos";		
			$nuevahoja->write(6,9,$epe);
			$nuevahoja->write(7,9,$epe);
			$nuevahoja->write(8,9,$epe);
			$nuevahoja->write(9,9,$epe);
			$nuevahoja->write(10,9,$epe);
			/*$nuevahoja->write(12,9,$epe);
			$nuevahoja->write(13,9,$epe);		*/
		}	
	   //fin de la estructura programatica
	   
	}
   
	//$nuevahoja->write(14,14,$_SESSION['PDF_desc_estado_gral']);
	
    $nuevahoja->write(15,1,'CODIGO',$negrita);
    $nuevahoja->write(15,2,'PARTIDA',$negrita);
    $nuevahoja->write(15,3,'ENERO',$negrita);
    $nuevahoja->write(15,4,'FEBRERO',$negrita);
    $nuevahoja->write(15,5,'MARZO',$negrita);
    $nuevahoja->write(15,6,'ABRIL',$negrita);
    $nuevahoja->write(15,7,'MAYO',$negrita);
    $nuevahoja->write(15,8,'JUNIO',$negrita);
    $nuevahoja->write(15,9,'JULIO',$negrita);
    $nuevahoja->write(15,10,'AGOSTO',$negrita);
    $nuevahoja->write(15,11,'SEPTIEMBRE',$negrita);
    $nuevahoja->write(15,12,'OCTUBRE',$negrita);
    $nuevahoja->write(15,13,'NOVIEMBRE',$negrita);
    $nuevahoja->write(15,14,'DICIEMBRE',$negrita);
    $nuevahoja->write(15,15,'TOTAL',$negrita);
	
 //Realizamos la consulta
 	$Custom = new cls_CustomDBPresupuesto();
    $cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$_SESSION['PDF_CantFiltros'];$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	 $criterio_filtro = $cond -> obtener_criterio_filtro();
	 $res = $Custom->ListarConsiliacionPartida($_SESSION['PDF_limit'],$_SESSION['PDF_start'],'codigo_partida','asc',$criterio_filtro,$id_financiador,$id_regional,
																			$id_programa,$id_proyecto,$id_actividad ,$_SESSION['PDF_tipo_pres'],$_SESSION['PDF_id_parametro'],$_SESSION['PDF_id_moneda'],
																			$_SESSION['PDF_ids_fuente_financiamiento'],$_SESSION['PDF_ids_u_o'],$_SESSION['PDF_ids_financiador'],$_SESSION['PDF_ids_regional'],
																			$_SESSION['PDF_ids_programa'],$_SESSION['PDF_ids_proyecto'],$_SESSION['PDF_ids_actividad'],$_SESSION['PDF_sw_vista'],
																			$_SESSION['PDF_ids_concepto_colectivo'],$_SESSION['PDF_id_categoria_prog'],$_SESSION['PDF_filtro_niveles']);
	 //echo $Custom->query;
	 //exit;
	
	 if($res)
	{
	$data=$Custom->salida;   
	$fila=17;		
		foreach($data as $row)
		{ 
			$nuevahoja->write($fila,1,$row[1]);
			$nuevahoja->write($fila,2,$row[2]);
	    	$nuevahoja->write($fila,3,$row[12]);
	        $nuevahoja->write($fila,4,$row[13]);
	        $nuevahoja->write($fila,5,$row[14]);
	        $nuevahoja->write($fila,6,$row[15]);
	        $nuevahoja->write($fila,7,$row[16]);
	        $nuevahoja->write($fila,8,$row[17]);
	        $nuevahoja->write($fila,9,$row[18]);
	        $nuevahoja->write($fila,10,$row[19]);
	        $nuevahoja->write($fila,11,$row[20]);
	        $nuevahoja->write($fila,12,$row[21]);
	        $nuevahoja->write($fila,13,$row[22]);
	        $nuevahoja->write($fila,14,$row[23]);
	        $nuevahoja->write($fila,15,$row[24],$negrita);									 
		        $fila++;		
		}//FIN DE FOREACH
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