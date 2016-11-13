<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCotizacionServDet.php
Propósito:				Permite realizar el listado en tad_cotizacion_det de servicios
Tabla:					t_tad_cotizacion_det
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-28 17:32:17
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionListarCotizacionServDet.php';

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

	if($sort == '') $sortcol = 'cotdet.id_cotizacion_det';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
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
	
	$cond->add_criterio_extra("cotdet.id_cotizacion",$m_id_cotizacion);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	
	if($m_cantidad>0){ //`para obtener el Nº de cotizaciones que tiene un proceso, así el usr sabrá si existen mas de 3 cotizaciones para finalizar el registro de cotizaciones
		$criterio_filtro=$criterio_filtro." AND cotdet.cantidad>0 AND cotdet.precio>0 AND cotdet.id_cotizacion in (select distinct id_cotizacion from tad_cotizacion where id_proveedor=$id_proveedor)";
	}
	//Obtiene el criterio de orden de columnas
	//$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'CotizacionDet');
	//$sortcol = $crit_sort->get_criterio_sort();
	if($cotizado>0){// para listar  en la adjudicaicon solo los que cotizaron
		$criterio_filtro=$criterio_filtro." AND cotdet.cantidad>0 AND cotdet.precio>0 AND cotdet.id_cotizacion=$m_id_cotizacion";
	}


	//Obtiene el total de los registros
	$res = $Custom -> ContarCotizacionServDet($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCotizacionServDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_cotizacion_det',$f["id_cotizacion_det"]);
			$xml->add_nodo('servicio',$f["servicio"]);
			$xml->add_nodo('cantidad_solicitada',$f["cantidad_solicitada"]);
			$xml->add_nodo('id_servicio',$f["id_servicio"]);
			$xml->add_nodo('tipo_servicio',$f["tipo_servicio"]);
			$xml->add_nodo('cantidad',$f["cantidad"]);
			$xml->add_nodo('garantia',$f["garantia"]);
			$xml->add_nodo('id_servicio_cotizado',$f["id_servicio_cotizado"]);
			$xml->add_nodo('observaciones',$f["observaciones"]);
			$xml->add_nodo('precio',$f["precio"]);
			$xml->add_nodo('tiempo_entrega',$f["tiempo_entrega"]);
			$xml->add_nodo('observado',$f["observado"]);
			$xml->add_nodo('codigo',$f["codigo"]);
			$xml->add_nodo('id_cotizacion',$f["id_cotizacion"]);
			$xml->add_nodo('nombre_cotizado',$f["nombre_cotizado"]);
			$xml->add_nodo('num_convocatoria',$f["num_convocatoria"]);
			$xml->add_nodo('id_tipo_servicio',$f["id_tipo_servicio"]);
			$xml->add_nodo('estado',$f["estado"]);
			$xml->add_nodo('id_proceso_compra',$f["id_proceso_compra"]);
			$xml->add_nodo('precio_moneda_cotizada',$f["precio_moneda_cotizada"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
			$xml->add_nodo('cant_adj',$f["cant_adj"]);
			$xml->add_nodo('registro_adjudicado',$f["registro_adjudicado"]);
			$xml->add_nodo('reg_cabecera',$f["reg_cabecera"]);
			$xml->add_nodo('reformular',$f["reformular"]);
			$xml->add_nodo('precio_cantidad',$f["precio_cantidad"]);
			$xml->add_nodo('id_unidad_medida_base',$f["id_unidad_medida_base"]);
			$xml->add_nodo('abreviatura',$f["abreviatura"]);
			$xml->add_nodo('especificaciones_tecnicas',$f["especificaciones_tecnicas"]);
			$xml->add_nodo('item_adjudicado_en_proceso',$f["item_adjudicado_en_proceso"]);
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