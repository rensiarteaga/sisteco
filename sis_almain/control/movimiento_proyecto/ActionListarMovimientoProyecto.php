<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?>
<?php

/**
 * **********************************************************
 * Nombre de archivo: ActionListarMovimientoProyecto.php
 * Propósito:				Permite desplegar movimiento_proyecto
 * Tabla:					tal_movimiento_proyecto
 * Parámetros:				$cant
 * $puntero
 * $sortcol
 * $sortdir
 * $criterio_filtro
 * $id_usuario_asignacion
 *
 * Valores de Retorno: Listado de Procesos y total de registros listados
 * Fecha de Creación:		23-10-2014
 * Versión:					1.0.0
 
 * *********************************************************
 */
session_start();
include_once ('../LibModeloAlma.php');

$Custom = new cls_CustomDBAlma();
$nombre_archivo = 'ActionListarMovimientoProyecto.php';

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
		$sortcol = 'id_movimiento_proyecto'; // falta
	else
		$sortcol = $sort;
	if ($dir == '')
		$sortdir = 'asc';
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
		$cond->add_criterio_extra("alm.id_almacen", $id_almacen);
	}
	else
	{
		$cond->add_criterio_extra("alm.id_almacen", '-1');
	}
	
	/*if ($nombreVista != '' && $nombreVista != 'undefined' && $nombreVista != null && $nombreVista == "aprobacion_movimiento") {
		$cond->add_criterio_extra("al.estado", "''proceso_aprobacion''");
	}*/
	
	//control de condicion de estado_movimiento
	if($estado_movimiento_proy != '' && $estado_movimiento_proy != 'undefined' && $estado_movimiento_proy != null)
	{		
		if($estado_movimiento_proy == 'finalizado')
		{
			$criterio_filtro = $cond->obtener_criterio_filtro();
			$criterio_filtro.=" AND (movpr.estado=''finalizado'' OR movpr.estado=''pendiente_costeo'')";//OR movpr.estado=''pendiente_costeo''
		}
		else 
		{
			//$cond->add_criterio_extra("movpr.estado", "''$estado_movimiento_proy''");
			$criterio_filtro = $cond->obtener_criterio_filtro();
			$criterio_filtro.=" AND (movpr.estado=''borrador'')";

		}
	} 
	
	//05-05-2015
	if(isset($filtro_costeo) && $filtro_costeo =='si') 
		$criterio_filtro .= "0=0 AND movpr.estado=''finalizado'' AND movpr.id_almacen LIKE(".$id_almacen.") AND movpr.id_tipo_movimiento IN (SELECT m.id_tipo_movimiento FROM alma.tal_tipo_movimiento m WHERE m.tipo LIKE(''ingreso%'') )";

	// Obtiene el criterio de orden de columnas
	 //$crit_sort = new cls_criterio_sort($sortcol, $sortdir, 'id_movimiento_proyecto');
	// $sortcol = $crit_sort->get_criterio_sort();
	 
	// Obtiene el total de los registros
	$res = $Custom->ContarMovimientoProyecto($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	if ($res)
		$total_registros = $Custom->salida;
		// Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarMovimientoProyecto($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	if ($res) {
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount', $total_registros);
		foreach ( $Custom->salida as $f ) {
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_movimiento_proyecto', $f["id_movimiento_proyecto"]);
			$xml->add_nodo('id_almacen', $f["id_almacen"]);
			$xml->add_nodo('desc_almacen', $f["desc_almacen"]);
			$xml->add_nodo('id_tipo_movimiento', $f["id_tipo_movimiento"]);
			$xml->add_nodo('tipo', $f["tipo"]);
			$xml->add_nodo('id_documento', $f["id_documento"]);
			$xml->add_nodo('id_contratista', $f["id_contratista"]);
			$xml->add_nodo('desc_contratista', $f["desc_contratista"]);
			$xml->add_nodo('id_proveedor', $f["id_proveedor"]);
			$xml->add_nodo('desc_proveedor', $f["desc_proveedor"]);
			$xml->add_nodo('id_institucion', $f["id_institucion"]);
			$xml->add_nodo('desc_institucion', $f["desc_institucion"]);
			$xml->add_nodo('id_empleado', $f["id_empleado"]);
			$xml->add_nodo('desc_empleado', $f["desc_empleado"]);
			$xml->add_nodo('fecha_ingreso', $f["fecha_ingreso"]);
			$xml->add_nodo('origen_ingreso', $f["origen_ingreso"]);
			$xml->add_nodo('concepto_ingreso', $f["concepto_ingreso"]);
			$xml->add_nodo('observaciones', $f["observaciones"]); 
			$xml->add_nodo('estado', $f["estado"]);
			$xml->add_nodo('usuario_reg', $f["usuario_reg"]);
			$xml->add_nodo('fecha_reg', $f["fecha_reg"]);
			$xml->add_nodo('nro_contrato', $f["nro_contrato"]);
			$xml->add_nodo('nota_remision', $f["nota_remision"]);
			$xml->add_nodo('entregado_por', $f["entregado_por"]);
			//añadido 12-05-2015
			$xml->add_nodo('peso_neto', $f["peso_neto"]);
			$xml->add_nodo('codigo', $f["codigo"]);
			
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