<?php

session_start();
/*include_once("../../../lib/funciones.inc.php");
$Funciones=new funciones();
$filtro1=$Funciones->eliminarespeciales($_GET["filtro1"]);
$filtro2=$Funciones->eliminarespeciales($_GET["filtro2"]);
$filtro3=$Funciones->eliminarespeciales($_GET["filtro3"]);
$titulo=$_GET["titulo"];
$valor=$_GET["valor"];*/

 
$nombre_archivo = 'ActionReporteConsolidacion.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$cant = 100000;
	$puntero = 0;
	$sortcol = 'nro_cuenta';
	$sortdir = 'asc';
	 
											 
	
		
				/*$_SESSION['start']=utf8_decode($_GET['start']);
				$_SESSION['limit_rep_libro_mayor']=utf8_decode($_GET['limit']);
				$_SESSION['CantFiltros']=utf8_decode($_GET['CantFiltros']);*/
				
				$_SESSION['id_gestion']=utf8_decode($_GET['id_gestion']);
				$_SESSION['id_depto']=utf8_decode($_GET['id_depto']);
				
				
				$_SESSION['fecha_inicio']=utf8_decode($_GET['fecha_inicio']);
				$_SESSION['fecha_final']=utf8_decode($_GET['fecha_final']);
				
				$_SESSION['fecha_inicio_rep']=utf8_decode($_GET['fecha_inicio_rep']);
				$_SESSION['fecha_final_rep']=utf8_decode($_GET['fecha_final_rep']);
				
				
				
				
				$_SESSION['id_moneda']=utf8_decode($_GET['id_moneda']);
				$_SESSION['desc_moneda']=utf8_decode($_GET['desc_moneda']);
				
				$_SESSION['sw_cuenta']=utf8_decode($_GET['sw_cuenta']);
				$_SESSION['sw_auxiliar']=utf8_decode($_GET['sw_auxiliar']);
				$_SESSION['sw_epe']=utf8_decode($_GET['sw_epe']);
				$_SESSION['sw_uo']=utf8_decode($_GET['sw_uo']);
				$_SESSION['sw_ot']=utf8_decode($_GET['sw_ot']);
				
				$_SESSION['id_cuenta_inicial']=utf8_decode($_GET['id_cuenta_inicial']);
				$_SESSION['id_cuenta_final']=utf8_decode($_GET['id_cuenta_final']);
				
				$_SESSION['id_auxiliar_inicial']=utf8_decode($_GET['id_auxiliar_inicial']);
				$_SESSION['id_auxiliar_final']=utf8_decode($_GET['id_auxiliar_final']);
				
				$_SESSION['id_epe_inicial']=utf8_decode($_GET['id_epe_inicial']);
				$_SESSION['id_epe_final']=utf8_decode($_GET['id_epe_final']);
				
				$_SESSION['id_uo_inicial']=utf8_decode($_GET['id_uo_inicial']);
				$_SESSION['id_uo_final']=utf8_decode($_GET['id_uo_final']);
				
				$_SESSION['id_ot_inicial']=utf8_decode($_GET['id_ot_inicial']);
				$_SESSION['id_ot_final']=utf8_decode($_GET['id_ot_final']);
				
				$_SESSION['sw_estado_cbte']=utf8_decode($_GET['sw_estado_cbte']);
				$_SESSION['sw_actualizacion']=utf8_decode($_GET['sw_actualizacion']);
				
				/*echo $_GET['fecha_rep'];
 exit;
 			*/
	 
 			

		//echo( 'tipo_pres'.$_SESSION['tipo_pres'].'id_parametro'.$_SESSION['id_parametro'].'id_moneda'.$_SESSION['id_moneda'].'ids_fuente_financiamiento'.$_SESSION['ids_fuente_financiamiento'].'ids_u_o'.$_SESSION['ids_u_o'].'ids_financiador'.$_SESSION['ids_financiador'].'ids_regional'.$_SESSION['ids_regional'].'ids_programa'.$_SESSION['ids_programa'].'ids_proyecto'.$_SESSION['ids_proyecto'].'ids_actividad'.$_SESSION['ids_actividad'].'sw_vista'.$_SESSION['sw_vista'].'epe'.$_SESSION['epe']);
		//	exit()		;	 
			
//echo "rep_gestion".$txt_gestion."rep_periodo".$txt_periodo."id_param".$hidden_id_param."sw_global".$txt_sw_global."municipio_ini".$txt_cod_municipio_origen."municipio_fin".$txt_cod_municipio_destino."ruta_ini".$txt_cod_ruta_origen."ruta_fin".$txt_cod_ruta_destino."municipio".$txt_municipio."nombre numicipio".$txt_nombre_municipio;
			header("location:PDMayorReporteFormatoSimpleEpeUoOtCuentaAuxiliar.php");
		
				
	
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