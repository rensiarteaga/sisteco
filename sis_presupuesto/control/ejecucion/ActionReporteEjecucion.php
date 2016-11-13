<?php

session_start();
/*include_once("../../../lib/funciones.inc.php");
$Funciones=new funciones();
$filtro1=$Funciones->eliminarespeciales($_GET["filtro1"]);
$filtro2=$Funciones->eliminarespeciales($_GET["filtro2"]);
$filtro3=$Funciones->eliminarespeciales($_GET["filtro3"]);
$titulo=$_GET["titulo"];
$valor=$_GET["valor"];*/

include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionReporteConsolidacion.php';

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
			
		$_SESSION['PDF_start']=utf8_decode($_GET['start']);
		$_SESSION['PDF_limit']=utf8_decode($_GET['limit']);
		$_SESSION['PDF_CantFiltros']=utf8_decode($_GET['CantFiltros']);
		$_SESSION['PDF_tipo_pres']=utf8_decode($_GET['tipo_pres']);
		$_SESSION['PDF_id_parametro']=utf8_decode($_GET['id_parametro']);
		$_SESSION['PDF_id_moneda']=utf8_decode($_GET['id_moneda']);
		$_SESSION['PDF_ids_fuente_financiamiento']=utf8_decode($_GET['ids_fuente_financiamiento']);
		$_SESSION['PDF_ids_u_o']=utf8_decode($_GET['ids_u_o']);
		$_SESSION['PDF_ids_financiador']=utf8_decode($_GET['ids_financiador']);
		$_SESSION['PDF_ids_regional']=utf8_decode($_GET['ids_regional']);
		$_SESSION['PDF_ids_programa']=utf8_decode($_GET['ids_programa']);
		$_SESSION['PDF_ids_proyecto']=utf8_decode($_GET['ids_proyecto']);
		$_SESSION['PDF_ids_actividad']=utf8_decode($_GET['ids_actividad']);
		$_SESSION['PDF_sw_vista']=utf8_decode($_GET['sw_vista']);
		$_SESSION['PDF_ids_concepto_colectivo']=utf8_decode($_GET['ids_concepto_colectivo']);
		$_SESSION['PDF_regional']=utf8_decode($_GET['regional']);
		$_SESSION['PDF_financiador']=utf8_decode($_GET['financiador']);
		$_SESSION['PDF_programa']=utf8_decode($_GET['programa']);
		$_SESSION['PDF_proyecto']=utf8_decode($_GET['proyecto']);
		$_SESSION['PDF_actividad']=utf8_decode($_GET['actividad']);
		$_SESSION['PDF_unidad_organizacional']=utf8_decode($_GET['unidad_organizacional']);
		$_SESSION['PDF_Fuente_financiamiento']=utf8_decode($_GET['Fuente_financiamiento']);
		$_SESSION['PDF_colectivo']=utf8_decode($_GET['colectivo']);
		
		
		$_SESSION['PDF_desc_moneda']=utf8_decode($_GET['desc_moneda']);
		$_SESSION['PDF_desc_pres']=utf8_decode($_GET['desc_pres']);
		$_SESSION['PDF_desc_estado_gral']=utf8_decode($_GET['desc_estado_gral']);
		$_SESSION['PDF_gestion_pres']=utf8_decode($_GET['gestion_pres']);
		$_SESSION['PDF_fecha_fin']=utf8_decode($_GET['fecha_fin']);
		$_SESSION['PDF_fecha_ini']=utf8_decode($_GET['fecha_ini']);
		
		$_SESSION['PDF_filtro']=utf8_decode($_GET['filtro']);
		$_SESSION['PDF_id_categoria_prog']=utf8_decode($_GET['id_categoria_prog']);
		$_SESSION['PDF_desc_categoria_prog']=utf8_decode($_GET['desc_categoria_prog']);
		
		$_SESSION['PDF_cod_programa']=utf8_decode($_GET['cod_programa']);
		$_SESSION['PDF_cod_proyecto']=utf8_decode($_GET['cod_proyecto']);
		$_SESSION['PDF_cod_actividad']=utf8_decode($_GET['cod_actividad']);
		$_SESSION['PDF_cod_fuente_financiamiento']=utf8_decode($_GET['cod_fuente_financiamiento']);
		$_SESSION['PDF_cod_organismo_financiador']=utf8_decode($_GET['cod_organismo_financiador']);
		$_SESSION['PDF_codigo_sisin']=utf8_decode($_GET['codigo_sisin']);
		$_SESSION['PDF_descripcion_cp']=utf8_decode($_GET['descripcion_cp']);
		$_SESSION['PDF_id_presupuesto']=utf8_decode($_GET['id_presupuesto']);
		
		$_SESSION['PDF_filtro_niveles']=utf8_decode($_GET['filtro_niveles']);

			
		//echo "rep_gestion".$txt_gestion."rep_periodo".$txt_periodo."id_param".$hidden_id_param."sw_global".$txt_sw_global."municipio_ini".$txt_cod_municipio_origen."municipio_fin".$txt_cod_municipio_destino."ruta_ini".$txt_cod_ruta_origen."ruta_fin".$txt_cod_ruta_destino."municipio".$txt_municipio."nombre numicipio".$txt_nombre_municipio; exit;
		if ($_GET['tipo_reporte'] == 2) 
			//header("location:PDFDetalleEjecucion.php");
			header("location:XLSDetalleEjecucion.php");
		
		else 
			header("location:PDFDetalleEjecucion.php");
			//header("location:XLSDetalleEjecucion.php");
				
	
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