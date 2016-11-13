<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?>
<?php

/**
 * **********************************************************
 * Nombre de archivo: 		ActionListarMovimientoProyectoDet.php
 * Propósito:				Permite desplegar el detalle de los ingresos de proyectos
 * Tabla:					tal_movimiento_proyecto_det
 * Fecha de Creación:		27-10-2014
 * Versión:					1.0.0
 * Autor:					UNKNOW
 * *********************************************************
 */
session_start();
include_once ('../LibModeloAlma.php');

$Custom = new cls_CustomDBAlma();
$nombre_archivo = 'ActionListarMovimientoProyectoDet.php';

if (! isset($_SESSION['autentificado'])) {
	$_SESSION['autentificado'] = 'NO';
}
if ($_SESSION['autentificado'] == 'SI') {
	
	// Parámetros del filtro
	if ($limit == '')
		$cant = 15;
	else
		$cant = $limit;
	
	if ($start == '')
		$puntero = 0;
	else
		$puntero = $start;
	
	if ($sort == '')
		$sortcol = 'id_proyecto_mov_det';
	else
		$sortcol = $sort;
	
	if ($dir == '')
		$sortdir = 'desc';
	else
		$sortdir = $dir;
		
		// Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
		// valores permitidos de $cod -> 'si', 'no'
	
	switch ($cod) {
		case 'si' :
			$decodificar = true;
			break;
		case 'no' :
			$decodificar = false;
			break;
		default :
			$decodificar = true;
			break;
	}
	
	// Verifica si se manda la cantidad de filtros
	if ($CantFiltros == '') 
		$CantFiltros = 0;
		
		// Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i = 0; $i < $CantFiltros; $i ++) {
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	if ($m_id_movimiento_proyecto != '' && $m_id_movimiento_proyecto != 'undefined' && $m_id_movimiento_proyecto != null) {
		$cond->add_criterio_extra("movdet.id_movimiento_proyecto", $m_id_movimiento_proyecto);
	}
	$criterio_filtro = $cond->obtener_criterio_filtro();

	//echo $criterio_filtro;exit;
	// Obtiene el total de los registros
	$res = $Custom->ContarMovimientoProyectoDet($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	
	if ($res)
		$total_registros = $Custom->salida;
	
	// Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarMovimientoProyectoDet($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	
	if ($res) {
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount', $total_registros);
		
		foreach ( $Custom->salida as $f ) {
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_proyecto_mov_det', $f["id_proyecto_mov_det"]);
			$xml->add_nodo('id_movimiento_proyecto', $f["id_movimiento_proyecto"]);
			$xml->add_nodo('cantidad', $f["cantidad"]);
			$xml->add_nodo('unidad_medida', $f["unidad_medida"]);
			$xml->add_nodo('id_item', $f["id_item"]);
			$xml->add_nodo('desc_item', $f["desc_item"]);
			$xml->add_nodo('id_unidad_medida_base', $f["id_unidad_medida_base"]);
			$xml->add_nodo('nombre_medida', $f["nombre_medida"]);
			$xml->add_nodo('usuario_reg', $f["usuario_reg"]);
			$xml->add_nodo('fecha_reg', $f["fecha_reg"]);
			$xml->add_nodo('precio_unitario', $f["precio_unitario"]);
			$xml->add_nodo('costo_unitario', $f["costo_unitario"]);
			 
			$xml->fin_rama();
		}
		$xml->mostrar_xml();
	} else {
		// Se produjo un error
		$resp = new cls_manejo_mensajes(true, '406');
		$resp->mensaje_error = $Custom->salida[1];
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;
		echo $resp->get_mensaje();
		exit();
	}
} else {
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit();
}
?>
<?php ob_end_flush();?>