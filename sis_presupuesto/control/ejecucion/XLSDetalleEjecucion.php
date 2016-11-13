<?php
	
	session_start();
	
	require_once('../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php');
	include_once("../LibModeloPresupuesto.php");
	
	$nombre_archivo='Ejecucion_Presupuesto.xls';
	$docexcel = new Spreadsheet_Excel_Writer();
	$nuevahoja =& $docexcel->addWorksheet("EJECUCIÓN PRESUPUESTARIA");
	
	$fila=0;
	$columna=0;
	$valor_celda='prueba';
	$nuevahoja->setColumn(1,18,15);
	$nuevahoja->write(1,3,'EJECUCION PRESUPUESTARIA'); //dibuja una celad con contenido y orientacion  x, y 
	$nuevahoja->write(2,3,'Presupuesto de '.$_SESSION['PDF_desc_pres']." Gestión ".$_SESSION['PDF_gestion_pres']);
	$nuevahoja->write(3,3,'Del '.$_SESSION['PDF_fecha_ini']. ' Al '. $_SESSION['PDF_fecha_fin']);	
	$nuevahoja->write(4,3,'(Expresado en '.$_SESSION['PDF_desc_moneda'].')');
	
	//cuando el reporte sea por presupuesto mostramos el identificador
	if($_SESSION['PDF_filtro'] == 1)	
	{
		$nuevahoja->write(4,6,'Identificador: '.$_SESSION['PDF_id_presupuesto'] );		
	}
	
	
	
	//adicionando la estructura programtica
	
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
	
   //fin de la estructura programatica
   $nuevahoja->write(15,1,'CODIGO');
   $nuevahoja->write(15,2,'PARTIDA');
	 IF($_SESSION['PDF_tipo_pres']>1)//PRESUPUESTOS DE GASTO E INVERSION
	    {   
			$nuevahoja->write(15,3,'PRESUPUESTADO');
		    $nuevahoja->write(15,4,'TRASPASO');
		    $nuevahoja->write(15,5,'REFORMULACIÓN');
		    $nuevahoja->write(15,6,'PRESUPUESTO VIGENTE');
		    $nuevahoja->write(15,7,'COMPROMETIDO');
		    $nuevahoja->write(15,8,'DEVENGADO');
		    $nuevahoja->write(15,9,'PAGADO');
		    $nuevahoja->write(15,10,'SALDO POR COMPROMETER');
		    $nuevahoja->write(15,11,'SALDO POR DEVENGAR');
		    $nuevahoja->write(15,12,'SALDO POR PAGAR');
		    $nuevahoja->write(15,13,'EJECUCIÓN (%)');
	    }
	   else   //PRESUPUESTOS DE RECURSOS
	   {
	   		$nuevahoja->write(15,3,'PRESUPUESTADO');	//PRESUPUESTADO
			$nuevahoja->write(15,4,'TRASPASO');	//TRASPASO
			$nuevahoja->write(15,5,'REFORMULACIÓN');//REFORMULACION
			$nuevahoja->write(15,6,'PRESUPUESTO VIGENTE');//PRESUPUESTO VIGENTE
			$nuevahoja->write(15,7,'DEVENGADO');	//DEVENGADO
		    $nuevahoja->write(15,8,'INGRESADO');	//INGRESADO
		    $nuevahoja->write(15,9,'SALDO POR DEVENGAR');	//SALDO POR DEVENGAR
		    $nuevahoja->write(15,10,'SALDO POR INGRESAR');	//SALDO POR INGRESAR
		    $nuevahoja->write(15,11,'EJECUCIÓN (%)'); 	//PORCENTAJE DE EJECUCIÓN
	   } 	
	//Realizamos la consulta
		$Custom = new cls_CustomDBPresupuesto();
		$cond = new cls_criterio_filtro($decodificar);
		for($i=0;$i<$_SESSION['PDF_CantFiltros'];$i++)
		{
			$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
		}
		 $criterio_filtro = $cond -> obtener_criterio_filtro();
		 $fecha_fin= substr( $_SESSION['PDF_fecha_fin'],3,2)."/".substr($_SESSION['PDF_fecha_fin'],0,2)."/".substr( $_SESSION['PDF_fecha_fin'],6,4);
		 $fecha_ini= substr( $_SESSION['PDF_fecha_ini'],3,2)."/".substr($_SESSION['PDF_fecha_ini'],0,2)."/".substr( $_SESSION['PDF_fecha_ini'],6,4);
		 
		 $res = $Custom->ListarEjecucionPartida($_SESSION['PDF_limit'],$_SESSION['PDF_start'],'codigo_partida','asc',$criterio_filtro,$id_financiador,$id_regional,
																			$id_programa,$id_proyecto,$id_actividad ,$_SESSION['PDF_tipo_pres'],$_SESSION['PDF_id_parametro'],$_SESSION['PDF_id_moneda'],
																			$_SESSION['PDF_ids_fuente_financiamiento'],$_SESSION['PDF_ids_u_o'],$_SESSION['PDF_ids_financiador'],$_SESSION['PDF_ids_regional'],
																			$_SESSION['PDF_ids_programa'],$_SESSION['PDF_ids_proyecto'],$_SESSION['PDF_ids_actividad'],$_SESSION['PDF_sw_vista'],
																			$_SESSION['PDF_ids_concepto_colectivo'],$fecha_fin,$fecha_ini,$_SESSION['PDF_id_categoria_prog'],$_SESSION['PDF_filtro_niveles']);
		 //var_dump($res);exit;
	//
if($res)
{	$data=$Custom->salida;   
	$fila=16;
	IF($_SESSION['PDF_tipo_pres']>1)	//Presupuestos de gasto o inversion
	{	
		foreach($data as $row)
		{
			//if($row[5]!=1)	//PARA LAS PARTIDAS TOTALITARIAS
			//{		
					 $nuevahoja->write($fila,1,$row[1]);
					 $nuevahoja->write($fila,2,$row[2]);
					 $nuevahoja->write($fila,3,$row[24]);
					 $nuevahoja->write($fila,4,$row[32]);
					 $nuevahoja->write($fila,5,$row[33]);
					 $nuevahoja->write($fila,6,$row[34]);
					 $nuevahoja->write($fila,7,$row[25]);
					 $nuevahoja->write($fila,8,$row[28]);
					 $nuevahoja->write($fila,9,$row[29]);
					 $nuevahoja->write($fila,10,$row[27]);
					 $nuevahoja->write($fila,11,$row[30]);
					 $nuevahoja->write($fila,12,$row[31]);
					
					 	//$dato=round((100-( ($row[27]*100) / ($row[34] + 0.01) ) ) * 100) / 100;
					 $dato=number_format( $row[28]*100 / ($row[34]  + 0.01),1);
					 
					 $nuevahoja->write($fila,13,$dato." %");										 
				     $fila++;
			//}
			//else		//PARA LAS PARTIDAS DE MOVIMIENTO
			//{
				
			//}
		}//FIN DE FOREACH
	}//FIN DE IF SESSION	
	ELSE
	{
		foreach($data as $row)
		{ 
		 $nuevahoja->write($fila,1,$row[1]);
		 $nuevahoja->write($fila,2,$row[2]);		
         $nuevahoja->write($fila,3,$row[24]);
		 $nuevahoja->write($fila,4,$row[32]);
		 $nuevahoja->write($fila,5,$row[33]);
		 $nuevahoja->write($fila,6,$row[34]);
		 $nuevahoja->write($fila,7,$row[28]);
		 $nuevahoja->write($fila,8,$row[29]);
		 $nuevahoja->write($fila,9,$row[35]);
		 $nuevahoja->write($fila,10,$row[31]);
		
		 //$dato=number_format(($suma6*100 / $suma4 + 0.01 ),1);
		 $dato=number_format($row[28]*100 / ($row[34]  + 0.01),1);
		 
		 $nuevahoja->write($fila,11,$dato." %");						 
	     $fila++;
		}
  }
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