<?php

session_start();
include_once("../../LibModeloFlujo.php");

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = 'ActionPDFEstadisticasExternas.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}

if($_SESSION['autentificado']=="SI")
{
	$cant = 100000;
	$puntero = 0;
	$sortcol = 'CUEDOC.fecha_sol, CUEDOC.nro_documento';	
	$sortdir = 'desc';
	
	
	$_SESSION['PDF_fecha_desde']=$_GET['fecha_inicio'];
	$_SESSION['PDF_fecha_hasta']=$_GET['fecha_fin'];
	$fecha_ini= substr( $_SESSION['PDF_fecha_desde'],3,2)."/".substr($_SESSION['PDF_fecha_desde'],0,2)."/".substr( $_SESSION['PDF_fecha_desde'],6,4);
	$fecha_fin= substr( $_SESSION['PDF_fecha_hasta'],3,2)."/".substr($_SESSION['PDF_fecha_hasta'],0,2)."/".substr( $_SESSION['PDF_fecha_hasta'],6,4);
	 
	
	
	if($_GET['tipo_reporte']=='0'){
		$criterio_fil=" ex.fecha_reg between ''$fecha_ini'' and  ''$fecha_fin''";
		$res = $Custom-> ListarEstadisticasExternasGlob(10000,0,'total_recibidas desc','desc',$criterio_fil,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$_SESSION['PDF_estadisticas']=$Custom->salida;
		header("location:PDFEstadisticasExternasGlob.php");
		
	}
	else{
		$criterio_fil="corrdet.fecha_reg between ''$fecha_ini'' and  ''$fecha_fin''";
		
		if($_GET['tipo_detalle']==1){
			$criterio_fil.=" and corrdet.id_uo=".$_GET['id_unidad_organizacional'];
			
		}else if($_GET['tipo_detalle']==2){
			$criterio_fil.=" and corrdet.id_empleado=".$_GET['id_empleado'];
		}
		if($_GET['estado']==1){
			$criterio_fil.=" and corrdet.estado in(''pendiente_recibido'',''recibido'',''recibido_derivacion'') ";
		}
		else if($_GET['estado']==2){
			$criterio_fil.=" and corrdet.estado in(''archivado'') ";
		}
		if($_GET['prioridad']==1){
			$criterio_fil.=" and corrdet.nivel_prioridad =''alta'' ";
		}
		else if($_GET['prioridad']==2){
			$criterio_fil.=" and corrdet.nivel_prioridad =''media'' ";
		}
		else if($_GET['prioridad']==3){
			$criterio_fil.=" and corrdet.nivel_prioridad =''baja'' ";
		}
		if(isset($_GET['fecha_max_ini']) && $_GET['fecha_max_ini']!='' && isset($_GET['fecha_max_fin']) && $_GET['fecha_max_fin']!=''){
			$criterio_fil.=" and corrdet.fecha_max_res between ''".$_GET['fecha_max_ini']."'' and  ''".$_GET['fecha_max_fin']."'' ";
		}
		
		if($_GET['respuesta']==1){
			$criterio_fil.=" and (corrdet.respuestas is null or corrdet.respuestas='''') ";
		}
		else if($_GET['respuesta']==2){
			$criterio_fil.=" and (corrdet.respuestas is not null and corrdet.respuestas!='''') ";
		}
		
		if(isset($_GET['dias_retraso'])&&$_GET['dias_retraso']!=''){
			$criterio_fil.=" and corrdet.dias_retraso > ".$_GET['dias_retraso'];
		}
		
		if(isset($_GET['id_persona'])&&$_GET['id_persona']!=''){
			$criterio_fil.=" and corrdet.id_persona like ''".$_GET['id_persona']."''";
		}
		
		if(isset($_GET['id_institucion'])&&$_GET['id_institucion']!=''){
			$criterio_fil.=" and corrdet.id_institucion like ''".$_GET['id_institucion']."''";
		} 
		
		//jun2015
		if(isset($_GET["num_correspondencia"]) && $_GET["num_correspondencia"]!=''){
			$criterio_fil.=" and corrdet.numero like ''%".$_GET["num_correspondencia"]."%''";
		}
		
		
		//if($_SESSION["ss_id_usuario"]==120){ echo $criterio_fil; exit;}
		$res = $Custom-> ListarEstadisticasExternasDet(10000,0,'dias_retraso desc','desc',$criterio_fil,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$_SESSION['PDF_estadisticas']=$Custom->salida;
		header("location:PDFEstadisticasExternasDet.php");
	}
	
	
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;
}?>