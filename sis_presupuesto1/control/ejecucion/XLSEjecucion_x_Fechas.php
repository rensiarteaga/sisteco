<?php
	
	session_start();
	require_once('../../../lib/Spreadsheet_Excel_Writer-0.9.2/Spreadsheet/Excel/Writer.php');
	include_once("../LibModeloPresupuesto.php");
	
	$nombre_archivo='Ejecucion_x_Fecha.xls';
	$docexcel = new Spreadsheet_Excel_Writer();
	$nuevahoja =& $docexcel->addWorksheet("EJECUCIÓN POR FECHAS");
	
	$fila=0;
	$columna=0;
	$valor_celda='prueba';
	$nuevahoja->setColumn(1,18,15);
	
	
	
	$nuevahoja->write(1,2,'EJECUCIÓN PRESUPUESTARIA'); //dibuja una celad con contenido y orientacion  x, y 
	$nuevahoja->write(2,2,'Presupuesto de '.$_SESSION['PDF_desc_pres']." Gestión ".$_SESSION['PDF_gestion_pres']);
	$nuevahoja->write(3,2,'Del '.$_SESSION['PDF_fecha_desde']. ' Al '. $_SESSION['PDF_fecha_hasta']);	
	$nuevahoja->write(4,2,'(Expresado en '.$_SESSION['PDF_desc_moneda'].')');
	//adicionando la estructura programtica
	
	$epe=" ";  	   
	    $nuevahoja->write(6,1,'ESTRUCTURA PROGRAMATICA: ');
	    		    
	    if($_SESSION['PDF_regional'])
	    {
	     	$epe=$epe."REGIONAL: ";	     	
	     	$nuevahoja->write(6,2,$epe);
	     	$nuevahoja->write(6,3,$_SESSION['PDF_regional']);
		}
	   	if($_SESSION['PDF_financiador'])
	   	{	   
	     		$epe="FINANCIADOR: ";
	     		$nuevahoja->write(7,2,$epe);
	     		$nuevahoja->write(7,3,$_SESSION['PDF_financiador']);
	 	}
	 			
		if($_SESSION['PDF_programa']){
		$epe="PROGRAMA: ";
		$nuevahoja->write(8,2,$epe);
	    $nuevahoja->write(8,3,$_SESSION['PDF_programa']);		
		}
		if($_SESSION['PDF_proyecto']){
		$epe="PROYECTO: ";	
		$nuevahoja->write(9,2,$epe);
	    $nuevahoja->write(9,3,$_SESSION['PDF_proyecto']);
		}
	 	if($_SESSION['PDF_actividad']){
		$epe="ACTIVIDAD: ";	
	 	$nuevahoja->write(10,2,$epe);
	    $nuevahoja->write(10,3,$_SESSION['PDF_actividad']);
		}
		
		$nuevahoja->write(12,1,'UNIDAD ORGANIZACIONAL: ');
		$nuevahoja->write(12,2,$_SESSION['PDF_unidad_organizacional']);
		$nuevahoja->write(13,1,'FUENTE DE FINANCIAMIENTO: ');
		$nuevahoja->write(13,2,$_SESSION['PDF_Fuente_financiamiento']);
	 	
	if($epe==" ")
	{
		$epe="Todos";
		$nuevahoja->write(6,3,$epe);
		$nuevahoja->write(7,3,$epe);
		$nuevahoja->write(8,3,$epe);
		$nuevahoja->write(9,3,$epe);
		$nuevahoja->write(10,3,$epe);
		$nuevahoja->write(12,3,$epe);
		$nuevahoja->write(13,3,$epe);			
	}	
   //fin de la estructura programatica
   $nuevahoja->write(15,1,'CODIGO');
   $nuevahoja->write(15,2,'PARTIDA');
   
	 IF($_SESSION['PDF_tipo_pres']>1)//PRESUPUESTOS DE GASTO E INVERSION
	    {   
	    $nuevahoja->write(15,3,'COMPROMETIDO');
	    $nuevahoja->write(15,4,'DEVENGADO');
	    $nuevahoja->write(15,5,'PAGADO');
	    }
	   else   //PRESUPUESTOS DE RECURSOS
	   {	   		
			$nuevahoja->write(15,3,'DEVENGADO');	//DEVENGADO
		    $nuevahoja->write(15,4,'INGRESADO');	//INGRESADO		 
	   } 	
	//Realizamos la consulta
	   $Custom = new cls_CustomDBPresupuesto();
	   $cond = new cls_criterio_filtro($decodificar);
		for($i=0;$i<$_SESSION['PDF_CantFiltros'];$i++)
		{
			$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
		}
		 $criterio_filtro = $cond -> obtener_criterio_filtro();
		 $fecha_fin= substr( $_SESSION['PDF_fecha_hasta'],3,2)."/".substr($_SESSION['PDF_fecha_hasta'],0,2)."/".substr( $_SESSION['PDF_fecha_hasta'],6,4);
		 $fecha_ini= substr( $_SESSION['PDF_fecha_desde'],3,2)."/".substr($_SESSION['PDF_fecha_desde'],0,2)."/".substr( $_SESSION['PDF_fecha_desde'],6,4);
		 
		 $res = $Custom->ListarEjecucionPartida_x_fechas($_SESSION['PDF_limit'],$_SESSION['PDF_start'],'codigo_partida','asc',$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$_SESSION['PDF_tipo_pres'],$_SESSION['PDF_id_parametro'],$_SESSION['PDF_id_moneda'],$_SESSION['PDF_ids_fuente_financiamiento'],$_SESSION['PDF_ids_u_o'],$_SESSION['PDF_ids_financiador'],$_SESSION['PDF_ids_regional'],$_SESSION['PDF_ids_programa'],$_SESSION['PDF_ids_proyecto'],$_SESSION['PDF_ids_actividad'],$_SESSION['PDF_sw_vista'],$_SESSION['PDF_ids_concepto_colectivo'],$fecha_ini,$fecha_fin);		 
			 //var_dump($res);exit;
	//
if($res)
{	$data=$Custom->salida;   
	$fila=17;
	IF($_SESSION['PDF_tipo_pres']>1)	//Presupuestos de gasto o inversion
	{	
		foreach($data as $row)
		{
		 $nuevahoja->write($fila,1,$row[1]);
		 $nuevahoja->write($fila,2,$row[2]);
		 $nuevahoja->write($fila,3,$row[4]);
		 $nuevahoja->write($fila,4,$row[5]);
		 $nuevahoja->write($fila,5,$row[6]);					 									 
		 $fila++;			
		}//FIN DE FOREACH
	}//FIN DE IF SESSION	
	// Presupuestos de recursos 
	ELSE 
	{
		foreach($data as $row)
		{ 
		 $nuevahoja->write($fila,1,$row[1]);
		 $nuevahoja->write($fila,2,$row[2]);		
         $nuevahoja->write($fila,3,$row[5]);
		 $nuevahoja->write($fila,4,$row[6]);							 
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