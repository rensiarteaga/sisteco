<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?>
<?php

/**
 * **********************************************************
 * Nombre de archivo: ActionListarMovimiento.php
 * Propósito:				Permite desplegar movimiento
 * Tabla:					tal_movimiento
 * Parámetros:				$cant
 * $puntero
 * $sortcol
 * $sortdir
 * $criterio_filtro
 * $id_usuario_asignacion
 *
 * Valores de Retorno: Listado de Procesos y total de registros listados
 * Fecha de Creación:		06/09/2013
 * Versión:					1.0.0
 * Autor:					Ruddy Lujan Bravo
 * *********************************************************
 */
session_start();
include_once ('../LibModeloAlma.php');

$Custom = new cls_CustomDBAlma();
$nombre_archivo = 'ActionListarMovimiento.php';

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
		$sortcol = 'id_movimiento'; // falta
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
	
	if ($id_almacen != '' && $id_almacen != 'undefined' && $id_almacen != null) 
	{
		$cond->add_criterio_extra("al.id_almacen", $id_almacen);
	}
	else
	{
		$cond->add_criterio_extra("al.id_almacen", '-1');
	}
	
	if ($nombreVista != '' && $nombreVista != 'undefined' && $nombreVista != null && $nombreVista == "aprobacion_movimiento") {
		$cond->add_criterio_extra("al.estado", "''proceso_aprobacion''");
	}
	
	//control de condicion de estado_movimiento
	if($estado_movimiento != '' && $estado_movimiento != 'undefined' && $estado_movimiento != null)
	{		
		if($estado_movimiento == 'finalizado')
		{
			$criterio_filtro = $cond->obtener_criterio_filtro();
			$criterio_filtro.=" AND (al.estado=''finalizado'' OR al.estado=''valorado'')";
		}
		else 
		{
			$cond->add_criterio_extra("al.estado", "''$estado_movimiento''");
			$criterio_filtro = $cond->obtener_criterio_filtro();
		}
	}
			
	// Obtiene el criterio de orden de columnas
	 $crit_sort = new cls_criterio_sort($sortcol, $sortdir, 'id_movimiento');
	 $sortcol = $crit_sort->get_criterio_sort();
	// Obtiene el total de los registros
	
	$res = $Custom->ContarMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	if ($res)
		$total_registros = $Custom->salida;
		
		// Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	if ($res) {
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount', $total_registros);
		foreach ( $Custom->salida as $f ) 
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('fecha_reg', $f["fecha_reg"]);
			$xml->add_nodo('usuario_reg', $f["usuario_reg"]);
			$xml->add_nodo('id_movimiento', $f["id_movimiento"]);
			$xml->add_nodo('id_tipo_movimiento', $f["id_tipo_movimiento"]);
			$xml->add_nodo('id_almacen', $f["id_almacen"]);
			$xml->add_nodo('id_solicitud_salida', $f["id_solicitud_salida"]);
			$xml->add_nodo('codigo', $f["codigo"]);
			$xml->add_nodo('fecha_movimiento', $f["fecha_movimiento"]);
			$xml->add_nodo('fecha_finalizacion', $f["fecha_finalizacion"]);
			$xml->add_nodo('descripcion', $f["descripcion"]);
			$xml->add_nodo('observaciones', $f["observaciones"]);
			$xml->add_nodo('estado', $f["estado"]);
			$xml->add_nodo('nombre_tipo', $f["nombre_tipo"]);
			$xml->add_nodo('requiere_aprobacion', $f["requiere_aprobacion"]);
			$xml->add_nodo('descripcion_tipo', $f["descripcion_tipo"]);
			$xml->add_nodo('id_almacen_trans', $f["id_almacen_trans"]);
			$xml->add_nodo('desc_almacen', $f["desc_almacen"]);
			$xml->add_nodo('id_movimiento_fk', $f["id_movimiento_fk"]);
			$xml->add_nodo('almacen_destino', $f["almacen_destino"]);
			
			$xml->add_nodo('nro_compra', $f["nro_compra"]);
			
			if(isset($tipo_control) && $tipo_control != '')
				$xml->add_nodo('tipo_control', $tipo_control);
					
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