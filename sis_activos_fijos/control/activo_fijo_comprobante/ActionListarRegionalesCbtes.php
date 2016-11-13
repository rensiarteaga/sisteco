<?php
/*
 * Lista las regionales de todos los AF depreciados dado un grupo_depreciacion
 * 
 * */
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

	$criterio_filtro = array("$id_grupo_dep","$fecha_hasta");

	//$res = $Custom->ListarRegionalesActivoFijoDepreciacion($cant, $puntero, $sortdir, $sortcol, $criterio_filtro);
	$res = $Custom->ListarRegionalesDepreciacionNuevo($cant, $puntero, $sortdir, $sortcol, $criterio_filtro);


	if($res)
	{
		$total_registros = sizeof($Custom->salida);

		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_depreciacion_cbte_regional',$f["id_depreciacion_cbte_regional"]);
			$xml->add_nodo('id_grupo_depreciacion',$f["id_grupo_depreciacion"]);
			$xml->add_nodo('codigo_regional',$f["cod_regional"]);
			$xml->add_nodo('id_depto',$f["id_depto"]);
			$xml->add_nodo('id_depto_aux',$f["id_depto_aux"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('usuario_reg',$f["usuario_reg"]);
			$xml->add_nodo('estado_registro',$f["estado"]);
			$xml->add_nodo('ids_comprobantes',$f["ids_comprobantes"]);
			$xml->add_nodo('id_depreciacion_comprobante',$f["id_depreciacion_comprobante"]);

			$xml->add_nodo('desc_depto',$f["desc_depto"]);
			$xml->add_nodo('id_presupuesto',$f["id_presupuesto"]);
			$xml->add_nodo('desc_presto',$f["desc_presupuesto"]);
				
			$xml->add_nodo('desc_depto_aux',$f["desc_depto_aux"]);
				
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









?>