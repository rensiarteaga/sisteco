<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?> 
<?php

session_start();
include_once ('../LibModeloAlma.php');

$Custom = new cls_CustomDBAlma();
$nombre_archivo = 'ActionListarAlmacenUnidadOrganizacional.php';

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
		$sortcol = 'id_almacen_unidad_org'; // falta
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
	$cond->add_criterio_extra("auo.estado", "''activo''");
	
	$criterio_filtro = $cond->obtener_criterio_filtro();

	
	// Obtiene el total de los registros
	$res = $Custom->ContarAlmacenUnidadOrganizacional($cant, $puntero, $sortcol, $sortdir, $criterio_filtro);
	
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
	$res = $Custom->ListarAlmacenUnidadOrganizacional($cant, $puntero, $sortcol, $sortdir, $criterio_filtro);
	
	if ($res) {
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount', $total_registros);
		
		foreach ( $Custom->salida as $f ) {
			$xml->add_rama('ROWS');
			$xml->add_nodo('fecha_reg', $f["fecha_reg"]);
			$xml->add_nodo('usuario_reg', $f["usuario_reg"]);
			$xml->add_nodo('estado', $f["estado"]);
			$xml->add_nodo('id_almacen', $f["id_almacen"]);
			$xml->add_nodo('desc_almacen', $f["desc_almacen"]);
			$xml->add_nodo('id_unidad_organizacional', $f["id_unidad_organizacional"]);
			$xml->add_nodo('nombre_unidad', $f["nombre_unidad"]);
			$xml->add_nodo('descripcion_uo', $f["descripcion_uo"]);
			$xml->add_nodo('id_almacen_unidad_org', $f["id_almacen_unidad_org"]);
			$xml->add_nodo('fecha_desde', $f["fecha_desde"]);
			$xml->add_nodo('fecha_hasta', $f["fecha_hasta"]);
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