<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarRegionalesActivoFijoDepreciacion.php
Propósito:				Permite Listar la informacion de las regionales cuyos
						activos fueron depreciados a la fecha
						

Fecha de Creación:		09/01/2013
Versión:				1.0.0
Autor:					Daniel Sánchez Torrico
**********************************************************
*/
session_start();

include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();


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
	
	$id_grupo_dep =     $m_id_grupo_depreciacion;
	$fecha_hasta  = 	$txt_mes_fin."/01/".$txt_ano_fin;
	$regional     =     '%';
	
	
	$criterio_filtro = array("$id_grupo_dep","$fecha_hasta","$regional");
	
	$res = $Custom->ListarRegionalesActivoFijoDepreciacion($cant, $puntero, $sortdir, $sortcol, $criterio_filtro);
	//echo $Custom->query; exit;
	//echo sizeof($Custom->salida); exit;
	
	if($res)
	{
		$total_registros = sizeof($Custom->salida);
		
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
	
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('codigo_regional',$f["codigo_regional"]);
			$xml->add_nodo('estado_registro',$f["estado"]);
							
			$xml->fin_rama();
		}
		$xml->mostrar_xml();
	}
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true,'406');
		$resp->mensaje_error = $Custom->salida[1];
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;
		echo $resp->get_mensaje();
		exit;
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