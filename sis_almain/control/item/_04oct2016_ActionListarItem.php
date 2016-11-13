<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?>
<?php

/**
 * **********************************************************
 * Nombre de archivo: ActionListarItem.php
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
 * Autor:					Ruddy Lujan Bravo
 * *********************************************************
 */
session_start();
include_once ('../LibModeloAlma.php');
$Custom = new cls_CustomDBAlma();
$nombre_archivo = 'ActionListarItem.php';

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
	/*for($i = 0; $i < $CantFiltros; $i ++) {
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	*/
	
	if ($id_clasificacion != null && $id_clasificacion != "undefined") { 
		$cond->add_criterio_extra("al.id_clasificacion", $id_clasificacion);
	}
	elseif ($filtro_solicitud == 'si')
	{
		//filtro para mostrar solo los items valorizados dado un id_almacen
		$cond->add_criterio_extra("val.id_almacen", $id_almacen);
		//$id_financiador = -1 -> filtro cantidad en solicitud de salida
		$id_financiador= -1;
		$id_actividad=$id_almacen;
		
	}elseif(isset($bienes_compro) && $bienes_compro=='si'){ //jun2015: para pantalla detalle_soliitud sistema COMPRO
		
		$criterio_filtro=$criterio_filtro." AND al.sw_finanzas=''si'' ";
		
	} 
	
	
	$criterio_filtro = $cond->obtener_criterio_filtro();
	
	if ($filtro_stock == 'si' && $id_almacen != null)
	{
		$criterio_filtro=$criterio_filtro." AND al.id_item IN (	SELECT  s.id_item
		FROM alma.tai_stock_item s
		WHERE s.id_almacen=$id_almacen)";
	}
	
	
	// Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol, $sortdir, 'Item'); 
	$sortcol = $crit_sort->get_criterio_sort();

	
	// Obtiene el total de los registros
	$res = $Custom->ContarItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	
	if ($res)
		$total_registros = $Custom->salida;
		
		// Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);

	if ($res) 
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount', $total_registros);
		
		//a�adido 17092015
		if(isset($todos) && $todos=='si')
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_item', '%');
			$xml->add_nodo('nombre', "TODOS");
			$xml->add_nodo('codigo', "TODOS");
			$xml->add_nodo('descripcion', "TODOS");
			$xml->add_nodo('nombre_medida', "TODOS");
			
			$xml->fin_rama();
		}
		
		foreach ( $Custom->salida as $f ) {
			$xml->add_rama('ROWS');
			$xml->add_nodo('usuario_reg', $f["usuario_reg"]);
			$xml->add_nodo('fecha_reg', $f["fecha_reg"]);
			$xml->add_nodo('id_item', $f["id_item"]);
			$xml->add_nodo('id_clasificacion', $f["id_clasificacion"]);
			$xml->add_nodo('id_unidad_medida', $f["id_unidad_medida"]);
			$xml->add_nodo('nombre_clasificacion', $f["nombre_clasificacion"]);
			$xml->add_nodo('nombre_medida', $f["nombre_medida"]);
			$xml->add_nodo('codigo', $f["codigo"]);
			$xml->add_nodo('nombre', $f["nombre"]);
			$xml->add_nodo('descripcion', $f["descripcion"]);
			$xml->add_nodo('codigo_fabrica', $f["codigo_fabrica"]);
			$xml->add_nodo('num_por_clasificacion', $f["num_por_clasificacion"]);
			$xml->add_nodo('bajo_responsabilidad', $f["bajo_responsabilidad"]);
			$xml->add_nodo('estado', $f["estado"]);
			$xml->add_nodo('metodo_valoracion', $f["metodo_valoracion"]);
			$xml->add_nodo('cantidad', $f["cantidad"]);
			
			$xml->add_nodo('peso', $f["peso"]);
			$xml->add_nodo('calidad', $f["calidad"]);
			$xml->add_nodo('orden', $f["orden"]);
			
			$xml->add_nodo('reservados', $f["reservados"]);
			
			$xml->add_nodo('id_tipo_material',$f["id_tipo_material"]);
			$xml->add_nodo('desc_tipo_material',$f["desc_tipo_material"]);
			
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