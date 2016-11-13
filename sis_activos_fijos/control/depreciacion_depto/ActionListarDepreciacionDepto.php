<?php

session_start();
include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionListarDepreciacionDepto.php';


if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	if($limit == "") $cant = 20;
	else $cant = $limit;
	
	if($start == "") $puntero = 0;
	else $puntero = $start;
	
	if($sort == "") $sortcol = 'id_depreciacion_depto';
	else $sortcol = $sort;
	
	if($dir == "") $sortdir = 'DESC';
	else $sortdir = $dir;
	
	
	switch ($cod)
	{
		case "si":
			$decodificar = true;
			break;
		case "no":
			$decodificar = false;
			break;
		default:
			$decodificar = true;
			break;
	}
	
	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=="") $CantFiltros = 0;
	
	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
	$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
		
	$id_grupo_dep =  $m_id_grupo;
	$fecha_hasta  = $txt_mes_fin."/01/".$txt_ano_fin;

	$criterio_filtro = array("$id_grupo_dep","$fecha_hasta");
	
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarDepreciacionDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
;
	if($res)
	{
		$total_registros = sizeof($Custom->salida);
		
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			
			$xml->add_nodo('id_depreciacion_depto', $f["id_depreciacion_depto"]);
			$xml->add_nodo('estado', $f["estado"]);
			$xml->add_nodo('comprobantes', $f["comprobantes"]);
			$xml->add_nodo('id_cbte_depto', $f["id_cbte_depto"]);
			$xml->add_nodo('id_depto', $f["id_depto"]);
			$xml->add_nodo('desc_depto', $f["desc_depto"]);
			$xml->add_nodo('id_grupo_depreciacion', $f["id_grupo_depreciacion"]);
				
			$xml->fin_rama();
		}
		$xml->mostrar_xml();
	}
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = $CustomActivos->salida[1];
		$resp->origen = $CustomActivos->salida[2];
		$resp->proc = $CustomActivos->salida[3];
		$resp->nivel = $CustomActivos->salida[4];
		$resp->query = $CustomActivos->query;
		echo $resp->get_mensaje();
		exit;
	}
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
