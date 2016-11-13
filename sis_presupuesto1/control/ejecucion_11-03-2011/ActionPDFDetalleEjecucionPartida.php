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
$nombre_archivo = 'ActionPDFDetalleEjecucionPartida.php';

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
	$sortcolA = 'CUEDOC.fecha_sol, PAREJE.fecha_com_eje';
	$sortcolB = 'COMPRO.fecha_cbte, PAREJE.fecha_com_eje';
	$sortcolC = 'SOLCOM.fecha_reg, PAREJE.fecha_com_eje';
	$sortcolD = 'CUEDOC.fecha_sol, PAREJE3.fecha_com_eje';
	$sortcolE = 'DEVENG.fecha_devengado, PAREJE.fecha_com_eje';
	
	$sortcolBT = 'COMPRO.fecha_cbte';
	$sortcolCT = 'SOLCOM.fecha_reg';
	$sortcolDT = 'CUEDOC.fecha_sol';	
	$sortcolET = 'DEVENG.fecha_devengado';
	$sortdir = 'desc';
	
		$_SESSION['start']=utf8_decode($_GET['start']);
		$_SESSION['limit']=utf8_decode($_GET['limit']);
		$_SESSION['CantFiltros']=utf8_decode($_GET['CantFiltros']);
		$_SESSION['tipo_pres']=utf8_decode($_GET['tipo_pres']);
		$_SESSION['id_parametro']=utf8_decode($_GET['id_parametro']);
		$id_moneda=$_SESSION['id_moneda']=utf8_decode($_GET['id_moneda']);
		
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
		
		$fecha_ini= substr( $_SESSION['fecha_desde'],3,2)."/".substr($_SESSION['fecha_desde'],0,2)."/".substr( $_SESSION['fecha_desde'],6,4);
		$fecha_fin= substr( $_SESSION['fecha_hasta'],3,2)."/".substr($_SESSION['fecha_hasta'],0,2)."/".substr( $_SESSION['fecha_hasta'],6,4);
		
		 
		
		$id_partida=$_SESSION['id_partida']=utf8_decode($_GET['id_partida']);
		$desc_partida=$_SESSION['desc_partida']=utf8_decode($_GET['desc_partida']);
		
		
		$id_presupuesto=utf8_decode($_GET['id_presupuesto']);
		
		/*$id_partida=utf8_decode($_GET['id_partida']);
		$id_partida=utf8_decode($_GET['id_partida']);
		$id_partida=utf8_decode($_GET['id_partida']);
		$id_partida=utf8_decode($_GET['id_partida']);*/		
	
		/*$comprometido = $Custom-> ListarRDEPComprometido(1500,$puntero,$sortcolD,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_comprometido']=$Custom->salida;		
		$comprometido2 = $Custom-> ListarRDEPComprometido2(1500,$puntero,$sortcolA,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_comprometido2']=$Custom->salida;
		$comprometido3 = $Custom-> ListarRDEPComprometido3(1500,$puntero,$sortcolB,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_comprometido3']=$Custom->salida;
		$comprometido4 = $Custom-> ListarRDEPComprometido4(1500,$puntero,$sortcolC,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_comprometido4']=$Custom->salida;
		$comprometido5 = $Custom-> ListarRDEPComprometido5(1500,$puntero,$sortcolC,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_comprometido5']=$Custom->salida;
		$comprometido6 = $Custom-> ListarRDEPComprometido6(1500,$puntero,$sortcolE,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_comprometido6']=$Custom->salida;*/
		
		$comprometidoT = $Custom-> ListarRDEPComprometidoT(1500,$puntero,$sortcolDT,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_comprometidoT']=$Custom->salida;		
		//$comprometido2T = $Custom-> ListarRDEPComprometido2T(1500,$puntero,$sortcolA,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		//$_SESSION['PDF_comprometido2T']=$Custom->salida;
		$comprometido3T = $Custom-> ListarRDEPComprometido3T(1500,$puntero,$sortcolBT,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_comprometido3T']=$Custom->salida;
		$comprometido4T = $Custom-> ListarRDEPComprometido4T(1500,$puntero,$sortcolCT,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_comprometido4T']=$Custom->salida;
		$comprometido5T = $Custom-> ListarRDEPComprometido5T(1500,$puntero,$sortcolCT,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_comprometido5T']=$Custom->salida;
		$comprometido6T = $Custom-> ListarRDEPComprometido6T(1500,$puntero,$sortcolET,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_comprometido6T']=$Custom->salida;
		
		
		/*$revertido = $Custom-> ListarRDEPRevertido(1500,$puntero,$sortcolD,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_revertido']=$Custom->salida;
		$revertido2 = $Custom-> ListarRDEPRevertido2(1500,$puntero,$sortcolA,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_revertido2']=$Custom->salida;
		$revertido3 = $Custom-> ListarRDEPRevertido3(1500,$puntero,$sortcolB,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_revertido3']=$Custom->salida;
		$revertido4 = $Custom-> ListarRDEPRevertido4(1500,$puntero,$sortcolC,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_revertido4']=$Custom->salida;
		$revertido5 = $Custom-> ListarRDEPRevertido5(1500,$puntero,$sortcolC,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_revertido5']=$Custom->salida;
		$revertido6 = $Custom-> ListarRDEPRevertido6(1500,$puntero,$sortcolE,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_revertido6']=$Custom->salida;*/
		
		$devengado = $Custom-> ListarRDEPDevengado(1500,$puntero,$sortcolA,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_devengado']=$Custom->salida;
		$devengado2 = $Custom-> ListarRDEPDevengado2(1500,$puntero,$sortcolA,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_devengado2']=$Custom->salida;
		$devengado3 = $Custom-> ListarRDEPDevengado3(1500,$puntero,$sortcolB,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_devengado3']=$Custom->salida;
		$devengado4 = $Custom-> ListarRDEPDevengado4(1500,$puntero,$sortcolC,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_devengado4']=$Custom->salida;
		$devengado5 = $Custom-> ListarRDEPDevengado5(1500,$puntero,$sortcolC,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_devengado5']=$Custom->salida;
		$devengado6 = $Custom-> ListarRDEPDevengado6(1500,$puntero,$sortcolE,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_devengado6']=$Custom->salida;
		
		$pagado = $Custom-> ListarRDEPPagado(1500,$puntero,$sortcolA,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_pagado']=$Custom->salida;
		$pagado2 = $Custom-> ListarRDEPPagado2(1500,$puntero,$sortcolA,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_pagado2']=$Custom->salida;
		$pagado3 = $Custom-> ListarRDEPPagado3(1500,$puntero,$sortcolB,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_pagado3']=$Custom->salida;
		$pagado4 = $Custom-> ListarRDEPPagado4(1500,$puntero,$sortcolC,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_pagado4']=$Custom->salida;
		$pagado5 = $Custom-> ListarRDEPPagado5(1500,$puntero,$sortcolC,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_pagado5']=$Custom->salida;
		$pagado6 = $Custom-> ListarRDEPPagado6(1500,$puntero,$sortcolE,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$_SESSION['PDF_pagado6']=$Custom->salida;
	
		/*echo "down down".utf8_decode($_GET['id_presupuesto']);
		exit; */
		header("location:PDFEjecucionPartidaDetallado.php");
	
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