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

//echo $_GET['tipo_reporte']; exit;

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
	$sortcolF = 'PLANIL.fecha_planilla, PAREJE.fecha_com_eje';
	$sortcolG = 'PAREJE.fecha_com_eje';
	
	$sortcolBT = 'COMPRO.fecha_cbte';
	$sortcolCT = 'SOLCOM.fecha_reg';
	$sortcolDT = 'CUEDOC.fecha_sol';	
	$sortcolET = 'DEVENG.fecha_devengado';
	$sortcolFT = 'PLANIL.fecha_planilla';
	$sortcolGT = 'PAREJE.fecha_com_eje';
	$sortdir = 'desc';
	
	$_SESSION['PDF_start']=utf8_decode($_GET['start']);
	$_SESSION['PDF_limit']=utf8_decode($_GET['limit']);
	$_SESSION['PDF_CantFiltros']=utf8_decode($_GET['CantFiltros']);
	$_SESSION['PDF_tipo_pres']=utf8_decode($_GET['id_tipo_pres']);
	$_SESSION['PDF_id_parametro']=utf8_decode($_GET['id_parametro']);
	$_SESSION['PDF_id_presupuesto']=utf8_decode($_GET['id_presupuesto']);
	$id_moneda=$_SESSION['PDF_id_moneda']=utf8_decode($_GET['id_moneda']);
	
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
	$_SESSION['PDF_categoria_prog']=utf8_decode($_GET['categoria_prog']);		
	
	$_SESSION['PDF_desc_moneda']=utf8_decode($_GET['desc_moneda']);
	$_SESSION['PDF_desc_pres']=utf8_decode($_GET['desc_pres']);
	$_SESSION['PDF_desc_estado_gral']=utf8_decode($_GET['desc_estado_gral']);
	$_SESSION['PDF_gestion_pres']=utf8_decode($_GET['gestion_pres']);
	$_SESSION['PDF_fecha_desde']=utf8_decode($_GET['fecha_desde']);
	$_SESSION['PDF_fecha_hasta']=utf8_decode($_GET['fecha_hasta']);
	
	$fecha_ini= substr( $_SESSION['PDF_fecha_desde'],3,2)."/".substr($_SESSION['PDF_fecha_desde'],0,2)."/".substr( $_SESSION['PDF_fecha_desde'],6,4);
	$fecha_fin= substr( $_SESSION['PDF_fecha_hasta'],3,2)."/".substr($_SESSION['PDF_fecha_hasta'],0,2)."/".substr( $_SESSION['PDF_fecha_hasta'],6,4);
	
	$id_partida=$_SESSION['PDF_id_partida']=utf8_decode($_GET['id_partida']);
	$desc_partida=$_SESSION['PDF_desc_partida']=utf8_decode($_GET['desc_partida']);

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
	
	$comprometidoT = $Custom-> ListarRDEPComprometidoT(1500,$puntero,$sortcolDT,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	$_SESSION['PDF_comprometidoT']=$Custom->salida;					
	//$comprometido2T = $Custom-> ListarRDEPComprometido2T(1500,$puntero,$sortcolA,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	//$_SESSION['PDF_comprometido2T']=$Custom->salida;
	$comprometido3T = $Custom-> ListarRDEPComprometido3T(1500,$puntero,$sortcolBT,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	$_SESSION['PDF_comprometido3T']=$Custom->salida;						
	$comprometido4T = $Custom-> ListarRDEPComprometido4T(1500,$puntero,$sortcolCT,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	$_SESSION['PDF_comprometido4T']=$Custom->salida;				
	$comprometido5T = $Custom-> ListarRDEPComprometido5T(1500,$puntero,$sortcolCT,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	$_SESSION['PDF_comprometido5T']=$Custom->salida;			
	$comprometido6T = $Custom-> ListarRDEPComprometido6T(1500,$puntero,$sortcolET,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	$_SESSION['PDF_comprometido6T']=$Custom->salida;	
	$comprometido7T = $Custom-> ListarRDEPComprometido7T(1500,$puntero,$sortcolFT,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	$_SESSION['PDF_comprometido7T']=$Custom->salida; 
	$comprometido8T = $Custom-> ListarRDEPComprometido8T(1500,$puntero,$sortcolGT,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	$_SESSION['PDF_comprometido8T']=$Custom->salida; 
	
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
	
	$devengado = $Custom-> ListarRDEPDevengado(1500,$puntero,$sortcolA,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	$_SESSION['PDF_devengado']=$Custom->salida;
	$devengado2 = $Custom-> ListarRDEPDevengado2(1500,$puntero,$sortcolA,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	$_SESSION['PDF_devengado2']=$Custom->salida;		
	$devengado3 = $Custom-> ListarRDEPDevengado3(1500,$puntero,$sortcolB,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	$_SESSION['PDF_devengado3']=$Custom->salida;
	$devengado4 = $Custom-> ListarRDEPDevengado4(1500,$puntero,$sortcolC,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	$_SESSION['PDF_devengado4']=$Custom->salida;
	$devengado5 = $Custom-> ListarRDEPDevengado5(1500,$puntero,$sortcolC,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	$_SESSION['PDF_devengado5']=$Custom->salida;
	$devengado6 = $Custom-> ListarRDEPDevengado6(1500,$puntero,$sortcolE,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	$_SESSION['PDF_devengado6']=$Custom->salida;
	$devengado7 = $Custom-> ListarRDEPDevengado7(1500,$puntero,$sortcolF,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	$_SESSION['PDF_devengado7']=$Custom->salida;
	$devengado8 = $Custom-> ListarRDEPDevengado8(1500,$puntero,$sortcolG,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	$_SESSION['PDF_devengado8']=$Custom->salida;
	
	$pagado = $Custom-> ListarRDEPPagado(1500,$puntero,$sortcolA,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	$_SESSION['PDF_pagado']=$Custom->salida;
	$pagado2 = $Custom-> ListarRDEPPagado2(1500,$puntero,$sortcolA,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	$_SESSION['PDF_pagado2']=$Custom->salida;
	$pagado3 = $Custom-> ListarRDEPPagado3(1500,$puntero,$sortcolB,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	$_SESSION['PDF_pagado3']=$Custom->salida;
	$pagado4 = $Custom-> ListarRDEPPagado4(1500,$puntero,$sortcolC,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	$_SESSION['PDF_pagado4']=$Custom->salida;
	$pagado5 = $Custom-> ListarRDEPPagado5(1500,$puntero,$sortcolC,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	$_SESSION['PDF_pagado5']=$Custom->salida;
	$pagado6 = $Custom-> ListarRDEPPagado6(1500,$puntero,$sortcolE,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	$_SESSION['PDF_pagado6']=$Custom->salida;
	$pagado7 = $Custom-> ListarRDEPPagado7(1500,$puntero,$sortcolF,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	$_SESSION['PDF_pagado7']=$Custom->salida;
	$pagado8 = $Custom-> ListarRDEPPagado8(1500,$puntero,$sortcolG,$sortdir,' ',$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
	$_SESSION['PDF_pagado8']=$Custom->salida;

	/*echo "down down".utf8_decode($_GET['id_presupuesto']);
	exit; */
	if ($_GET['tipo_reporte'] == 1) 
	
		header("location:PDFEjecucionPartidaDetallado.php");
	
	else 
		header("location:XLSEjecucionPartidaDetallado.php");
	
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