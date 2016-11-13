<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarAprobProrrateo.php
Propósito:				Permite realizar el listado en tts_devengado
Tabla:					tts_tts_devengado
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		10/03/2009
Versión:				1.0.0
Autor:					RCM
**********************************************************
*/
session_start();
include_once('../LibModeloTesoreria.php');

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = 'ActionListarAprobProrrateo.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
	//Parámetros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'DEVENG.fecha_devengado';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'desc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
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

	//echo "sss: ".$tipoFormDev;
	//exit;

	//Verifica el tipo de coportamiento en función de la bandera tipoFormDev

	//Filtro para no desplegar los devengados que tienen padre
	$criterio_filtro.=' AND DEVENG.fk_devengado IS NULL';
	$criterio_filtro.=' AND DEVENG.estado_devengado IN (3,14)';
	$criterio_filtro.=' AND DEVENG.id_cotizacion IS NULL';


	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'DevengadoAprobProrrat');
	$sortcol = $crit_sort->get_criterio_sort();


	//Obtiene el total de los registros
	$res = $Custom -> ContarAprobacionProrrateo($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarAprobacionProrrateo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_devengado',$f["id_devengado"]);
			$xml->add_nodo('id_devengado_detalle',$f["id_devengado_detalle"]);
			$xml->add_nodo('desc_concepto_ingas',$f["desc_concepto_ingas"]);
			$xml->add_nodo('desc_proveedor',$f["desc_proveedor"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
			$xml->add_nodo('importe_devengado',$f["importe_devengado"]);
			$xml->add_nodo('porcentaje_devengado',$f["porcentaje_devengado"]);
			$xml->add_nodo('fecha_devengado',$f["fecha_devengado"]);
			$xml->add_nodo('observaciones',$f["observaciones"]);
			$xml->add_nodo('nombre_financiador',$f["nombre_financiador"]);
			$xml->add_nodo('nombre_regional',$f["nombre_regional"]);
			$xml->add_nodo('nombre_programa',$f["nombre_programa"]);
			$xml->add_nodo('nombre_proyecto',$f["nombre_proyecto"]);
			$xml->add_nodo('nombre_actividad',$f["nombre_actividad"]);
			$xml->add_nodo('desc_unidad_organizacional',$f["desc_unidad_organizacional"]);
			$xml->add_nodo('aprobado',$f["aprobado"]);
			$xml->add_nodo('responsable_aprob',$f["responsable_aprob"]);
			$xml->add_nodo('partida',$f["partida"]);
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