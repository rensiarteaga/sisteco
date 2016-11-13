<?php
/**
 * Nombre del archivo:	ActionObtenerNumAdq.php
 * Propósito:			Devolver el num_doc de parametro_adq en funcion a tipo_doc y tipo_adq
 * Parámetros:			$tipo_doc, $tipo_adq
 * Valores de Retorno:	num_doc
 * Autor:				Mercedes Zambrana Meneses
 * Fecha creación:		18-06-2008
 */
session_start();

include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionObtenerGestionAdq.php';


if (!isset($_SESSION['autentificado']))
{ 
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	$id_empresa=$_SESSION['ss_id_empresa'];
	$id_usuario=$_SESSION['ss_id_usuario'];
	$txt_gestion=$_GET['m_gestion'];
//	
	if($txt_gestion>0){
		$txt_gestion=$m_gestion;
}
	else{
	    $var_g = new cls_middle("f_pm_get_fecha_bd","");
	    $var_g->exec_function();
	    $salida_g = $var_g->salida;
	    $fecha_g = $salida_g[0][0];//devuelve yyyy-mm-dd
	
	    $fecha_sep_g = explode('-',$fecha_g);
	    //$fecha_g = $fecha_sep_g[2]."/".$fecha_sep_g[1]."/".$fecha_sep_g[0];
	    $txt_gestion=$fecha_sep_g[0];
	}
		//$txt_gestion=$m_gestion;
		
	 	$var = new cls_middle("f_tad_obtener_gestion_adq"," " );
	    $var->add_param($id_empresa);//id_empresa
	    $var->add_param($txt_gestion);
	    $var->add_param($id_usuario);
	    $var->exec_function();
	    $salida = $var->salida;
	  
	    $cad = $salida[0][0];//devuelve yyyy-mm-dd
	    $cadena=split('###',$cad);
	
    	//$cadena[0];==> gestion
    	//$cadena[1];==> fecha
    	//$cadena[2];==> estado
    	//$cadena[3]==>  gestion_fin
    	//$cadena[4]==>  gestion_ini
    	
    	$fecha_sep = explode('-',$cadena[1]);
    	$fecha = $fecha_sep[2]."/".$fecha_sep[1]."/".$fecha_sep[0];
    	
    	$fecha_ini_sep= explode('-',$cadena[3]);
    	$fecha_ini=$fecha_ini_sep[2]."/".$fecha_ini_sep[1]."/".$fecha_ini_sep[0];
    		
    	$fecha_fin_sep= explode('-',$cadena[4]);
    	$fecha_fin=$fecha_fin_sep[2]."/".$fecha_fin_sep[1]."/".$fecha_fin_sep[0];
    	$total=0;
		//Forma el xml de salida para la vista
		$xml = new cls_manejo_xml('ROOT');
	    if($fecha!=''){
		    if($salida[0][0]=='00/00/00'){
		      $total=0;
		    }else{
		      $total=1;
		    }
		}
		
		if($cadena[2]=='congelado'){
			$hora='08:30:00';    
		}else{
			$var_hora = new cls_middle("f_pm_get_hora_bd","");
	        $var_hora->exec_function();
	        $salida_hora = $var_hora->salida;
	        $hora = $salida_hora[0][0];
	        $fecha_sep = explode('.',$hora);
	        $hora= $fecha_sep[0];
        }
		
		$xml->add_nodo('TotalCount',$total);
		$xml->add_rama('ROWS');
		$xml->add_nodo('gestion', $cadena[0]);
		$xml->add_nodo('fecha', $fecha);
		$xml->add_nodo('estado', $cadena[2]);
		$xml->add_nodo('fecha_fin', $fecha_fin);
		$xml->add_nodo('fecha_ini', $fecha_ini);
		$xml->add_nodo('id_moneda',$cadena[5]);
		$xml->add_nodo('nombre_moneda',$cadena[6]);
		$xml->add_nodo('id_parametro_adq',$cadena[7]);
		$xml->add_nodo('cargo',$cadena[8]);
		$xml->add_nodo('hora',$hora);
		$xml->add_nodo('gestion_sig', $cadena[0]+1);
		$xml->fin_rama();
		$xml->mostrar_xml();
	
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp->get_mensaje();
	exit;
}
?>
