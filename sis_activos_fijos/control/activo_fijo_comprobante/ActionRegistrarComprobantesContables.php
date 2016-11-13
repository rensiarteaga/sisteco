<?php
/**
**********************************************************
Nombre de archivo:	    ActionRegistrarComprobantes.php
Propósito:				Permite registrar los comprobantes de
						diario en el conin

Fecha de Creación:		2012-12-13
Versión:				1.0.0
Autor:					Daniel Sanchez Torrico
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = "ActionRegistrarComprobantesContables.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{
	$cant = 0;
	$puntero = 0;  
	$sortdir = ''; 
	$sortcol = ''; 
	$criterio_filtro = '';
	$id_grupo_dep = $id_grupo_depreciacion;
	$fecha_fin = $fecha_hasta;
	$cod_regional = $codigo_regional;
	
	
	
	if($txt_edit_0 =='si')//editar actif.taf_depreciacion_cbte_regional
	{
		$res = $Custom->ModificarDepreciacionCbtesRegional($h_id_depreciacion_cbte_regional_0,$h_id_depto_0,$txt_cod_regional_0,$h_id_depto_aux_0);
		
		if(!$res)
		{
			//Se produjo un error
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = $Custom->salida[1];
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje();
			exit;
		}
		
		if($cant == "") $cant = 100;
		if($puntero == "") $puntero = 0;
		if($sortcol == "") $sortcol = 'd.id_depreciacion_cbte_regional';
		if($sortdir == "") $sortdir = 'asc';
		if($criterio_filtro == "") $criterio_filtro = " d.id_grupo_depreciacion like($id_grupo_dep)";
		
		$res = $Custom->CountDepreciacionCbtesRegional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		
		
		if($res) $total_registros = $Custom->salida;
		//Arma el xml para desplegar el mensaje
		$resp = new cls_manejo_mensajes(false);
		$resp->add_nodo('TotalCount', $total_registros);
		$resp->add_nodo('mensaje', 'mensaje');
		$resp->add_nodo('tiempo_resp', '200');
		echo $resp->get_mensaje();
		exit;
	}
	else
	{		
		$res = $Custom->RegistrarActivosFijosDepreciacionComprobantes($cant, $puntero, $sortdir, $sortcol, $criterio_filtro,$id_grupo_dep,$fecha_fin,$cod_regional);
		
		if($res){
			
			$resp = new cls_manejo_mensajes(false);
			$resp->add_nodo("TotalCount", "nuevos comprobantes de ".$cod_regional." en los ");
			$resp->add_nodo("mensaje", "Este es el Mensaje");
			$resp->add_nodo("tiempo_resp", "200");
			echo $resp->get_mensaje();
			exit;
			
		}else{
			
			//Se produjo un error
			$resp = new cls_manejo_mensajes(true);
			$resp->mensaje_error = $Custom->salida[1];
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			echo $resp->get_mensaje();
			exit;
		}
	}
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