<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarSolicitudCompraDet.php
Propósito:				Permite realizar el listado en tad_solicitud_compra_det
Tabla:					t_tad_solicitud_compra_det
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-16 09:53:32
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionListarSolicitudCompraDet .php';

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

	if($sort == '') $sortcol = 'id_solicitud_compra_det';
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
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'SolicitudCompraDet');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarSolicitudCompraDet($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarSolicitudCompraDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_solicitud_compra_det',$f["id_solicitud_compra_det"]);
			$xml->add_nodo('desc_solicitud_compra_det',$f["desc_solicitud_compra_det"]);
			$xml->add_nodo('id_item_antiguo',$f["id_item_antiguo"]);
			$xml->add_nodo('cantidad',$f["cantidad"]);
			$xml->add_nodo('precio_referencial_estimado',$f["precio_referencial_estimado"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('fecha_inicio_serv',$f["fecha_inicio_serv"]);
			$xml->add_nodo('fecha_fin_serv',$f["fecha_fin_serv"]);
			$xml->add_nodo('descripcion',$f["descripcion"]);
			$xml->add_nodo('partida_presupuestaria',$f["partida_presupuestaria"]);
			$xml->add_nodo('estado_reg',$f["estado_reg"]);
			$xml->add_nodo('pac_verificado',$f["pac_verificado"]);
			$xml->add_nodo('id_solicitud_compra',$f["id_solicitud_compra"]);
			$xml->add_nodo('desc_solicitud_compra',$f["desc_solicitud_compra"]);
			$xml->add_nodo('id_servicio',$f["id_servicio"]);
			$xml->add_nodo('desc_servicio',$f["desc_servicio"]);
			$xml->add_nodo('id_item',$f["id_item"]);
			$xml->add_nodo('desc_item',$f["desc_item"]);
			$xml->add_nodo('monto_aprobado',$f["monto_aprobado"]);
			$xml->add_nodo('mat_bajo_responsabilidad',$f["mat_bajo_responsabilidad"]);
			$xml->add_nodo('supergrupo',$f["supergrupo"]);
			$xml->add_nodo('grupo',$f["grupo"]);
			$xml->add_nodo('subgrupo',$f["subgrupo"]);
			$xml->add_nodo('id1',$f["id1"]);
			$xml->add_nodo('id2',$f["id2"]);
			$xml->add_nodo('id3',$f["id3"]);
			$xml->add_nodo('tipo_servicio',$f["tipo_servicio"]);
			$xml->add_nodo('item',$f["item"]);
			$xml->add_nodo('abreviatura',$f["abreviatura"]);
			//$xml->add_nodo('desc_empleado_tpm_frppa',$f["desc_empleado_tpm_frppa"]);
			$xml->add_nodo('num_solicitud',$f["num_solicitud"]);
			$xml->add_nodo('tipo_adq',$f["tipo_adq"]);
			$xml->add_nodo('precio_referencial_moneda_seleccionada',$f["precio_referencial_moneda_seleccionada"]);
			$xml->add_nodo('precio_total_moneda_seleccionada',$f["precio_total_moneda_seleccionada"]);
			$xml->add_nodo('precio_total_referencial',$f["precio_total_referencial"]);
			$xml->add_nodo('especificaciones_tecnicas',$f["especificaciones_tecnicas"]);
			$xml->add_nodo('id_item_reformulado',$f["id_item_reformulado"]);
			$xml->add_nodo('id_servicio_reformulado',$f["id_servicio_reformulado"]);
			$xml->add_nodo('monto_ref_reformulado',$f["monto_ref_reformulado"]);
			$xml->add_nodo('reformular',$f["reformular"]);
			$xml->add_nodo('desc_item_reformulado',$f["desc_item_reformulado"]);
			$xml->add_nodo('desc_servicio_reformulado',$f["desc_servicio_reformulado"]);
			
			$xml->add_nodo('id_cuenta',$f["id_cuenta"]);
			$xml->add_nodo('desc_cuenta',$f["desc_cuenta"]);
			$xml->add_nodo('id_partida',$f["id_partida"]);
			$xml->add_nodo('codigo_partida',$f["codigo_partida"]);
			$xml->add_nodo('almacenable',$f["almacenable"]);
			
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