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
$nombre_archivo = 'ActionPDFEjecucion_x_Fechas.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
/*echo "down down".utf8_decode($_GET['fecha_desde']);
exit; */
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
		$_SESSION['PDF_fecha_desde']=utf8_decode($_GET['fecha_desde']);
		$_SESSION['PDF_fecha_hasta']=utf8_decode($_GET['fecha_hasta']);

	/*	$_SESSION['start']=utf8_decode($_GET['start']);
		$_SESSION['limit']=utf8_decode($_GET['limit']);
		$_SESSION['CantFiltros']=utf8_decode($_GET['CantFiltros']);
		$_SESSION['id_moneda']=utf8_decode($_GET['id_moneda']);
		$_SESSION['id_presupuesto']=utf8_decode($_GET['id_presupuesto']);
				
		$_SESSION['desc_moneda']=utf8_decode($_GET['desc_moneda']);
		$_SESSION['desc_pres']=utf8_decode($_GET['desc_pres']);
		$_SESSION['desc_estado_gral']=utf8_decode($_GET['desc_estado_gral']);
		$_SESSION['gestion_pres']=utf8_decode($_GET['gestion_pres']);
		$_SESSION['fecha_desde']=utf8_decode($_GET['fecha_desde']);
		$_SESSION['fecha_hasta']=utf8_decode($_GET['fecha_hasta']);
*/
	
	/*echo "down down".utf8_decode($_GET['id_presupuesto']);
exit; */
	header("location:PDFEjecucion_x_Fechas.php");
		}

		//echo "rep_gestion".$txt_gestion."rep_periodo".$txt_periodo."id_param".$hidden_id_param."sw_global".$txt_sw_global."municipio_ini".$txt_cod_municipio_origen."municipio_fin".$txt_cod_municipio_destino."ruta_ini".$txt_cod_ruta_origen."ruta_fin".$txt_cod_ruta_destino."municipio".$txt_municipio."nombre numicipio".$txt_nombre_municipio;
		
				
	

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