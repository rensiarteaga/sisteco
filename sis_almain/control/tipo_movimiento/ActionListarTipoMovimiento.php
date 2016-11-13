<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?>
<?php
/**
 * **********************************************************
 * Nombre de archivo: ActionListarAlmacen.php
 * Propï¿½sito:				Permite desplegar tipos de movimientos
 * Tabla:					tal_tipo_movimiento
 * Fecha de Creaciï¿½n:		26/07/2013
 * Versiï¿½n:					1.0.0
 * Autor:					Ariel Ayaviri Omonte
 * 							Ruddy Lujan Bravo
 * *********************************************************
 */
session_start();
include_once ('../LibModeloAlma.php');

$Custom = new cls_CustomDBAlma();
$nombre_archivo = 'ActionListarTipoMovimiento.php';

if (! isset($_SESSION['autentificado'])) {
	$_SESSION['autentificado'] = 'NO';
}
if ($_SESSION['autentificado'] == 'SI') {
	
	// Parï¿½metros del filtro
	if ($limit == '')
		$cant = 15;
	else
		$cant = $limit;
	
	if ($start == '')
		$puntero = 0;
	else
		$puntero = $start;
	
	if ($sort == '')
		$sortcol = 'id_tipo_movimiento';
	else
		$sortcol = $sort;
	
	if ($dir == '')
		$sortdir = 'asc';
	else
		$sortdir = $dir;
		
		// Verifica si se harï¿½ o no la decodificaciï¿½n(sï¿½lo pregunta en caso del GET)
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
	$criterio_filtro = $cond->obtener_criterio_filtro();
	
	//aÃ±adido 23/07/2015 filtro documento proyectos
	if(isset($filtro_proy) && $filtro_proy =='si')
	   $criterio_filtro .= " AND (tip.tipo like(''ingreso_proyecto'') OR tip.tipo like(''salida_proyecto''))"; 
	
	//añadido 03082015
	if(isset($filtro_reporte)  && $filtro_reporte == 'si')
		$criterio_filtro .= " AND tip.tipo IN (''ingreso'',''salida'',''solicitud'',''transpaso_salida'',''transpaso_ingreso'',''devolucion'')";
	
	if(isset($ingreso_gral) && $ingreso_gral =='si')
	{
		if($filterValue_1 == 'ingreso')
			$criterio_filtro= " (lower(tip.tipo) LIKE lower(''$filterValue_1'')) AND TIP.tipo NOT IN (''transpaso_ingreso'',''transpaso_salida'')";
		elseif ($filterValue_1 == 'salida')
			$criterio_filtro= " (lower(tip.tipo) LIKE lower(''$filterValue_1'')) OR (lower(tip.tipo) LIKE lower(''%devolucion%'')) AND TIP.tipo NOT IN (''transpaso_ingreso'',''transpaso_salida'')";
	}	
	
		
	// Obtiene el total de los registros
	$res = $Custom->ContarTipoMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	
	if ($res)
		$total_registros = $Custom->salida;
		
		// Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarTipoMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	

	if ($res) {
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount', $total_registros);
		
		foreach ( $Custom->salida as $f ) {
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_tipo_movimiento', $f["id_tipo_movimiento"]);
			$xml->add_nodo('id_documento', $f["id_documento"]);
			$xml->add_nodo('codigo_documento', $f["codigo_documento"]);
			$xml->add_nodo('descripcion_documento', $f["descripcion_documento"]);
			$xml->add_nodo('tipo', $f["tipo"]);
			$xml->add_nodo('requiere_aprobacion', $f["requiere_aprobacion"]);
			$xml->add_nodo('usuario_reg', $f["usuario_reg"]);
			$xml->add_nodo('fecha_reg', $f["fecha_reg"]);
			$xml->add_nodo('documento', $f["documento"]);
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