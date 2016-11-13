<?php
session_start();
include_once("../LibModeloPresupuesto.php");
/**
 * Nombre de la clase:	ActionPDFEjecucionInstitucional.php
 * Propósito:			Permite ejecutar toda la funcionalidad del reporte Ejecucion Institucional
 * Autor:				Ana Maria villegas Quispe
 * Fecha creación:		10/02/2010
 */
$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionPDFEjecucionInstitucional.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$cant = 100000;
	$puntero = 0;
	$sortcol = 'gestion_lec, periodo_lec';
	$sortdir = 'asc';
			
		$_SESSION['start']=utf8_decode($_GET['start']);
		$_SESSION['limit']=utf8_decode($_GET['limit']);
		$_SESSION['CantFiltros']=utf8_decode($_GET['CantFiltros']);
		$_SESSION['tipo_pres']=utf8_decode($_GET['tipo_pres']);
		$_SESSION['id_parametro']=utf8_decode($_GET['id_parametro']);
		$_SESSION['id_moneda']=utf8_decode($_GET['id_moneda']);
		$_SESSION['ids_fuente_financiamiento']=utf8_decode($_GET['ids_fuente_financiamiento']);
		$_SESSION['ids_u_o']=utf8_decode($_GET['ids_u_o']);
		$_SESSION['ids_financiador']=utf8_decode($_GET['ids_financiador']);
		$_SESSION['ids_regional']=utf8_decode($_GET['ids_regional']);
		$_SESSION['ids_programa']=utf8_decode($_GET['ids_programa']);
		$_SESSION['ids_proyecto']=utf8_decode($_GET['ids_proyecto']);
		$_SESSION['ids_actividad']=utf8_decode($_GET['ids_actividad']);
		$_SESSION['sw_vista']=utf8_decode($_GET['sw_vista']);
		$_SESSION['ids_concepto_colectivo']=utf8_decode($_GET['ids_concepto_colectivo']);
		$_SESSION['regional']=utf8_decode($_GET['regional']);
		$_SESSION['financiador']=utf8_decode($_GET['financiador']);
		$_SESSION['programa']=utf8_decode($_GET['programa']);
		$_SESSION['proyecto']=utf8_decode($_GET['proyecto']);
		$_SESSION['actividad']=utf8_decode($_GET['actividad']);
		$_SESSION['unidad_organizacional']=utf8_decode($_GET['unidad_organizacional']);
		$_SESSION['Fuente_financiamiento']=utf8_decode($_GET['Fuente_financiamiento']);
		$_SESSION['colectivo']=utf8_decode($_GET['colectivo']);
		$_SESSION['desc_moneda']=utf8_decode($_GET['desc_moneda']);
		$_SESSION['desc_pres']=utf8_decode($_GET['desc_pres']);
		$_SESSION['desc_estado_gral']=utf8_decode($_GET['desc_estado_gral']);
		$_SESSION['gestion_pres']=utf8_decode($_GET['gestion_pres']);
		$_SESSION['fecha_desde']=utf8_decode($_GET['fecha_desde']);
		$_SESSION['fecha_hasta']=utf8_decode($_GET['fecha_hasta']);	
		$_SESSION['m_id_presupuesto']=utf8_decode($_GET['m_id_presupuesto']);	
		$_SESSION['desc_presupuesto']=utf8_decode($_GET['desc_presupuesto']);	
		
		$cond = new cls_criterio_filtro($decodificar);
		for($i=0;$i<$_SESSION['CantFiltros'];$i++)
		{
			$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
		}
		 $criterio_filtro = $cond -> obtener_criterio_filtro();
		 $fecha_fin= substr( $_SESSION['fecha_hasta'],3,2)."/".substr($_SESSION['fecha_hasta'],0,2)."/".substr( $_SESSION['fecha_hasta'],6,4);
		 $fecha_ini= substr( $_SESSION['fecha_desde'],3,2)."/".substr($_SESSION['fecha_desde'],0,2)."/".substr( $_SESSION['fecha_desde'],6,4);
		$EjecucionInstitucional=array();
		
		$EjecucionInstitucional = $Custom->ListarEjecucionInstitucional($_SESSION['limit'],$_SESSION['start'],'codigo_partida','asc',$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,"'(".$_SESSION['tipo_pres'].")'",$_SESSION['id_parametro'],$_SESSION['id_moneda'],$_SESSION['ids_fuente_financiamiento'],$_SESSION['ids_u_o'],$_SESSION['ids_financiador'],$_SESSION['ids_regional'],$_SESSION['ids_programa'],$_SESSION['ids_proyecto'],$_SESSION['ids_actividad'],$_SESSION['sw_vista'],$_SESSION['ids_concepto_colectivo'],$fecha_fin,$fecha_ini,$_SESSION['m_id_presupuesto']);

		//echo $Custom->query;
		//exit;
		 
		$_SESSION['PDF_det_ejecucion_institucional']=$Custom->salida;
		$_SESSION['fecha_ini']=$_SESSION['fecha_desde'];
		$_SESSION['fecha_fin']=$_SESSION['fecha_hasta'];  
		
		header("location: ../../vista/ejecucion_institucional/PDFEjecucionInstitucional.php");
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