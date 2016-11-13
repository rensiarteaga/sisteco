<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?>
<?php

/**
 * **********************************************************
 * Nombre de archivo: 		ActionListarSolicitudSalida.php
 * Propósito:				Permite desplegar los registros de la tabla tal_solicitud_salida
 * Tabla:					tal_solicitud_salida
 * Valores de Retorno: 		Listado de Procesos y total de registros listados
 * Fecha de Creación:		11/09/2013
 * Versión:					1.0.0
 * Autor:					Ariel Ayaviri Omonte
 * 							Ruddy Lujan Bravo
 * *********************************************************
 */
session_start();
include_once ('../LibModeloAlma.php');
$Custom = new cls_CustomDBAlma();
$nombre_archivo = 'ActionListarSolicitudSalida.php';

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
		$sortcol = 'id_solicitud_salida';
	else
		$sortcol = $sort;
	
	if ($dir == '')
		$sortdir = 'asc';
	else
		$sortdir = $dir;
		
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
	
	if ($CantFiltros == '')
		$CantFiltros = 0;
		
	// Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i = 0; $i < $CantFiltros; $i ++) {
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}

	if ($id_almacen == '' || $id_almacen == 'undefined' || $id_almacen == null)
	{
		$id_almacen='-1';	
	}
	
	if ($nombreVista != '' && $nombreVista != 'undefined' && $nombreVista != null && $nombreVista == "aprobacion_solicitud") {
		$cond->add_criterio_extra("sol.estado", "''pendiente_aprobacion''");
		
	}
	$criterio_filtro = $cond->obtener_criterio_filtro();
	if ($nombreVista != '' && $nombreVista != 'undefined' && $nombreVista != null && $nombreVista == "procesar_solicitud") {
		$criterio_filtro .= " and (sol.estado = ''pendiente_entrega'' OR sol.estado = ''proceso_entrega'')"; 
	}
	
	//control de condicion de estado_solicitud
	if($estado_solicitud != '' && $estado_solicitud != 'undefined' && $estado_solicitud != null)
	{
		if ($estado_solicitud == 'borrador' )
		{
			$cond->add_criterio_extra("sol.estado", "''$estado_solicitud''");
			$criterio_filtro = $cond->obtener_criterio_filtro();
		}
		elseif ($estado_solicitud == 'pendiente_aprobacion' || $estado_solicitud=='entregado')
		{
			$cond->add_criterio_extra("sol.estado", "''$estado_solicitud''");
			$cond->add_criterio_extra("sol.id_almacen", "$id_almacen");
			
			$criterio_filtro = $cond->obtener_criterio_filtro();
			
			//filtro para listar solicitudes pendientes de aprobacion a un aprobador logeado
			/*if($estado_solicitud == 'pendiente_aprobacion')
			{
				$criterio_filtro = $criterio_filtro."  AND  sol.id_aprobador = $_SESSION[ss_id_empleado]";
			}*/
		}
			
		elseif ($estado_solicitud == 'proceso_entrega') 
		{
			$cond->add_criterio_extra("sol.id_almacen", "$id_almacen");
			$criterio_filtro = $cond->obtener_criterio_filtro();
			$criterio_filtro .= " and (sol.estado = ''pendiente_entrega'' OR sol.estado = ''proceso_entrega'')";
		}	
	}
	// Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol, $sortdir, 'solicitud_salida');
	$sortcol = $crit_sort->get_criterio_sort();

	
	// Obtiene el total de los registros
	$res = $Custom->ContarSolicitudSalida($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	
	if ($res)
		$total_registros = $Custom->salida;
	else {
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
	// Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarSolicitudSalida($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);

	if ($res) {
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount', $total_registros);
		
		foreach ( $Custom->salida as $f ) {
			$xml->add_rama('ROWS');
			$xml->add_nodo('usuario_reg', $f["usuario_reg"]);
			$xml->add_nodo('fecha_reg', $f["fecha_reg"]);
			$xml->add_nodo('usuario_mod', $f["usuario_mod"]);
			$xml->add_nodo('fecha_mod', $f["fecha_mod"]);
			$xml->add_nodo('id_solicitud_salida', $f["id_solicitud_salida"]);
			$xml->add_nodo('id_almacen', $f["id_almacen"]);
			$xml->add_nodo('id_unidad_organizacional', $f["id_unidad_organizacional"]);
			$xml->add_nodo('uo_empleado', $f["uo_empleado"]);
			$xml->add_nodo('id_empleado', $f["id_empleado"]);
			$xml->add_nodo('nombre_empleado', $f["nombre_empleado"]);
			$xml->add_nodo('cargo_empleado', $f["cargo_empleado"]);
			$xml->add_nodo('id_aprobador', $f["id_aprobador"]);
			$xml->add_nodo('uo_aprobador', $f["uo_aprobador"]);
			$xml->add_nodo('nombre_aprobador', $f["nombre_aprobador"]);
			$xml->add_nodo('fecha_solicitud', $f["fecha_solicitud"]);
			$xml->add_nodo('descripcion', $f["descripcion"]);
			$xml->add_nodo('estado', $f["estado"]);
			$xml->add_nodo('codigo', $f["codigo"]);
			$xml->add_nodo('desc_almacen', $f["desc_almacen"]);
			
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