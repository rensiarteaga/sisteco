<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?>
<?php

/**
 * **********************************************************
 * Nombre de archivo: ActionListarItemsValorizados.php
 * Prop�sito:				Permite desplegar item
 * Tabla:					tal_item
 * Par�metros:				$cant
 * $puntero
 * $sortcol
 * $sortdir
 * $criterio_filtro
 * $id_usuario_asignacion
 *
 * Valores de Retorno: Listado de Procesos y total de registros listados
 * Fecha de Creaci�n:		27/08/2013
 * Versi�n:				1.0.0
 * Autor:					UNKNOW
 * *********************************************************
 */
session_start();
include_once ('../LibModeloAlma.php');
$Custom = new cls_CustomDBAlma();
$nombre_archivo = 'ActionListarItemsValorizados.php';

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
		$sortcol = 'id_item'; // falta
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
	
	if ($id_almacen != null && $id_almacen != "undefined") {
		$cond->add_criterio_extra("val.id_almacen", $id_almacen);
	}
	
	$criterio_filtro = $cond->obtener_criterio_filtro();
	
	if(isset($filtro_stock) && $filtro_stock=='si')
	{
		$criterio_filtro = " ite.id_item IN (select s.id_item from alma.tai_stock_item s where s.id_almacen=$id_almacen) ";
	}
	
	// Obtiene el total de los registros
	$res = $Custom->ContarItemsValorizados($cant, $puntero, $sortcol, $sortdir, $criterio_filtro);
	
	if ($res)
		$total_registros = $Custom->salida;
	
	// Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarItemsValorizados($cant, $puntero, $sortcol, $sortdir, $criterio_filtro);

	if ($res) 
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount', $total_registros);
		
		foreach ( $Custom->salida as $f ) {
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_item_valoracion', $f["id_item_valoracion"]);
			$xml->add_nodo('id_item', $f["id_item"]);
			$xml->add_nodo('cantidad', $f["cantidad"]);
			$xml->add_nodo('unidad_medida', $f["unidad_medida"]);
			$xml->add_nodo('nombre_item', $f["nombre_item"]);
			$xml->add_nodo('desc_item', $f["desc_item"]);
			
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