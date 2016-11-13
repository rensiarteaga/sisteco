<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCaiffAjusteCbte.php
Prop�sito:			Permite realizar el listado en tpr_usuario_autorizado
Tabla:					tpr_caiff
Par�metros:			$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci�n:		
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarCaiffAjusteCbte.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Par�metros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'COMPRO.id_comprobante'; //nombre_unidad
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
	//valores permitidos de $cod -> 'si', 'no'
	
	switch ($cod)
	{
		case 'si':
			$decodificar = true;
			break;
		case 'no':
			$decodificar = false;
			break;
		default:
			$decodificar = true;
			break;
	}
 
	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	
	
	
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'CAIFAjusteCbte');
	$sortcol = $crit_sort->get_criterio_sort();
	if($m_sw_vista=='caiff'){
	
	$criterio_filtro=$criterio_filtro." AND COMPRO.fecha_cbte BETWEEN (SELECT fecha_inicio
		FROM presto.tpr_caiff_detalle cd
		WHERE cd.id_caiff=$m_id_caiff) AND (SELECT fecha_fin 
		FROM presto.tpr_caiff_detalle
		WHERE cd.id_caiff=$m_id_caiff) ";
	}

	//Obtiene el total de los registros
	$res = $Custom ->ContarCaiffAjusteCbte($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom-> ListarCaiffAjusteCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{  
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_comprobante',$f["id_comprobante"]);
			$xml->add_nodo('id_parametro',$f["id_parametro"]);
			$xml->add_nodo('desc_parametro',$f["desc_parametro"]);
			$xml->add_nodo('id_periodo_subsistema',$f["id_periodo_subsistema"]);
			$xml->add_nodo('desc_periodo_lite',$f["desc_periodo_lite"]);
			$xml->add_nodo('fecha_cbte',$f["fecha_cbte"]);
			$xml->add_nodo('nro_cbte',$f["nro_cbte"]);
			$xml->add_nodo('acreedor',$f["acreedor"]);
			$xml->add_nodo('aprobacion',$f["aprobacion"]);
			$xml->add_nodo('concepto_cbte',$f["concepto_cbte"]);
			$xml->add_nodo('sw_caif_rep',$f["sw_caif_rep"]);
			$xml->add_nodo('sw_actualizacion',$f["sw_actualizacion"]);
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
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;

}?>