<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?>
<?php

/**
 * **********************************************************
 * Nombre de archivo: ActionListarStockItem.php
 * Prop�sito:				Permite desplegar contenido de la tabla tal_stock_item
 * Tabla:					tal_item
 * Par�metros:				$cant
 * $puntero					unknow
 * $sortcol					unknow
 * $sortdir					unknow
 * $criterio_filtro			unknow
 * $id_usuario_asignacion	unknow
 *
 * Valores de Retorno: Listado de Procesos y total de registros listados
 * Fecha de Creaci�n:		30-05-2014
 * Versi�n:					1.0.0
 * Autor:					UNKNOW
 * *********************************************************
 */
session_start();
include_once ('../LibModeloAlma.php');
$Custom = new cls_CustomDBAlma();
$nombre_archivo = 'ActionListarStockItem.php';

if (! isset($_SESSION['autentificado'])) {
	$_SESSION['autentificado'] = 'NO';
}
if ($_SESSION['autentificado'] == 'SI') {
	
	// Par�metros del filtro
	if ($limit == '')
		$cant = 15;
	else
		$cant = $limit;
	
	if ($start == '')
		$puntero = 0;
	else
		$puntero = $start;
	
	if ($sort == '')
		$sortcol = 'id_stock_item'; // falta
	else
		$sortcol = $sort;
	
	if ($dir == '')
		$sortdir = 'asc';
	else
		$sortdir = $dir;
		
		// Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
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
	
	//control condicion de la ventana maestro
	if($id_almacen != '' && $id_almacen != 'undefined' && id_almacen != null)
	{
		$cond->add_criterio_extra("alm.id_almacen", $_POST["id_almacen"]);
		
		if($id_ubicacion!=''&& $id_ubicacion != 'undefined' && $id_ubicacion != null)
			$cond->add_criterio_extra("stock.id_ubicacion", $_POST["id_ubicacion"]);
	}
	$criterio_filtro = $cond->obtener_criterio_filtro();
	// Obtiene el total de los registros
	$res = $Custom->ContarStockItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	if ($res)
		$total_registros = $Custom->salida;
		
		// Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarStockItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	
	if ($res) {
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount', $total_registros);
		
		foreach ( $Custom->salida as $f ) {
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_stock_item', $f["id_stock_item"]);
			$xml->add_nodo('id_item', $f["id_item"]);
			$xml->add_nodo('desc_item', $f["desc_item"]);
			$xml->add_nodo('id_almacen', $f["id_almacen"]);
			$xml->add_nodo('desc_almacen', $f["desc_almacen"]);
			$xml->add_nodo('minimo', $f["minimo"]);
			$xml->add_nodo('maximo', $f["maximo"]);
			$xml->add_nodo('usuario_reg', $f["usuario_reg"]);
			$xml->add_nodo('fecha_reg', $f["fecha_reg"]);
			$xml->add_nodo('id_unidad_medida_base', $f["id_unidad_medida_base"]);
			$xml->add_nodo('nombre_medida', $f["nombre"]);
			
			//$xml->add_nodo('id_ubicacion', $f["id_ubicacion"]);
			//$xml->add_nodo('desc_ubicacion', $f["desc_ubicacion"]);
		
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