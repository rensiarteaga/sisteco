<?php

session_start();
include_once("../../LibModeloTesoreria.php");

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = 'ActionPDFEstadoSolicitudes.php';

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
	
	/*$_SESSION['start']=utf8_decode($_GET['start']);
	$_SESSION['limit']=utf8_decode($_GET['limit']);
	$_SESSION['CantFiltros']=utf8_decode($_GET['CantFiltros']);*/
	
	$_SESSION['PDF_tipo_reporte']=utf8_decode($_GET['tipo_reporte']);
	
	$_SESSION['PDF_id_depto']=$id_depto=utf8_decode($_GET['id_depto']);
	$_SESSION['PDF_id_usuario']=$id_usuario=utf8_decode($_GET['id_usuario']);
	$_SESSION['PDF_id_empleado']=$id_empleado=utf8_decode($_GET['id_empleado']);
	$_SESSION['PDF_id_unidad_organizacional']=$id_unidad_organizacional=utf8_decode($_GET['id_unidad_organizacional']);
	
	$_SESSION['PDF_desc_depto']=utf8_decode($_GET['desc_depto']);
	$_SESSION['PDF_desc_usuario']=utf8_decode($_GET['desc_usuario']);
	$_SESSION['PDF_desc_empleado']=utf8_decode($_GET['desc_empleado']);
	$_SESSION['PDF_desc_unidad_organizacional']=utf8_decode($_GET['desc_unidad_organizacional']);
	$_SESSION['PDF_tipo_solicitud']=$tipo_solicitud=utf8_decode($_GET['tipo_solicitud']);
	$_SESSION['PDF_estado_solicitud']=$estado_solicitud=utf8_decode($_GET['estado_solicitud']);		
	
	$_SESSION['PDF_fecha_desde']=utf8_decode($_GET['fecha_desde']); 
	$_SESSION['PDF_fecha_hasta']=utf8_decode($_GET['fecha_hasta']);
	
	$fecha_ini= substr( $_SESSION['PDF_fecha_desde'],3,2)."/".substr($_SESSION['PDF_fecha_desde'],0,2)."/".substr( $_SESSION['PDF_fecha_desde'],6,4);
	$fecha_fin= substr( $_SESSION['PDF_fecha_hasta'],3,2)."/".substr($_SESSION['PDF_fecha_hasta'],0,2)."/".substr( $_SESSION['PDF_fecha_hasta'],6,4);
	 
	if($id_usuario == "undefined" || $id_usuario == "" || $id_usuario == 'null')
	{
		if($id_unidad_organizacional == "undefined" || $id_unidad_organizacional == "" || $id_unidad_organizacional == 'null')
		{
			if($id_depto == "undefined" || $id_depto == "" || $id_depto == 'null') 
			{
				$criterio_fil=' and CUEDOC.id_empleado like \'\''.$id_empleado.'\'\' '; 
			}
			else 
			{
				$criterio_fil=' and CUEDOC.id_depto like \'\''.$id_depto.'\'\' ';
			}	
		}
		else 
		{
			$criterio_fil=' and PRESUP.id_unidad_organizacional like \'\''.$id_unidad_organizacional.'\'\' ';
		}
	}
	else 
	{		
		$criterio_fil=' and CUEDOC.id_usuario_reg like \'\''.$id_usuario.'\'\' ';	
	}
	
	//$estado_rendiciones = $Custom-> ListarReporteEstadoRendiciones(1500,$puntero,$sortcol,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_depto,$estado_rendicion,$fecha_ini,$fecha_fin);
	$estado_solicitudes = $Custom-> ListarReporteEstadoSolicitudes(15000,$puntero,$sortcol,$sortdir,$criterio_fil,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_depto,$estado_solicitud,$fecha_ini,$fecha_fin,$tipo_solicitud);
	
	$_SESSION['PDF_estado_solicitudes']=$Custom->salida;
	/*echo "down down".utf8_decode($_GET['id_presupuesto']);
	exit; */
	header("location:PDFEstadoSolicitudes.php");	
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