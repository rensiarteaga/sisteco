<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?>
<?php

/**
 * **********************************************************
 * Nombre de archivo: ActionListarClasificacion.php
 * Propósito:				Permite desplegar contenido de la tabla tal_clasificacion
 * Tabla:					tal_item
 * Parámetros:				$cant
 * $puntero					unknow
 * $sortcol					unknow
 * $sortdir					unknow
 * $criterio_filtro			unknow
 * $id_usuario_asignacion	unknow
 *
 * Valores de Retorno: Listado de Procesos y total de registros listados
 * Fecha de Creación:		30-05-2014
 * Versión:					1.0.0
 * Autor:					UNKNOW
 * *********************************************************
 */
session_start();
include_once ('../LibModeloAlma.php');
$Custom = new cls_CustomDBAlma();
$nombre_archivo = 'ActionListarClasificacion.php';

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
		$sortcol = 'id_clasificacion'; // falta
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
	//condicion aniadida para que solo se listen las clasificaciones activas
	// y con id_clasificacion_fk -> NULL
	if ($id_clasificacion != '' &&$id_clasificacion!='undefined' && $id_clasificacion!= null)
	{
		$cond->add_criterio_extra("cla.estado","''activo''");
		$criterio_filtro = $cond->obtener_criterio_filtro();
	}
	else 
	{
		$cond->add_criterio_extra("cla.estado","''activo''");
		$criterio_filtro = $cond->obtener_criterio_filtro();
		$criterio_filtro=$criterio_filtro." AND cla.id_clasificacion_fk is null";
	}		
	
	if(isset($load_num))
	{
		$criterio_filtro .= " AND  cla.id_clasificacion in ( select c.id_clasificacion from alma.tai_clasificacion c where c.id_clasificacion_fk like($id_clasificacion) order by c.orden DESC limit 1)";
	}
	
	// Obtiene el total de los registros
	$res = $Custom->ContarClasificacion($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	if ($res)
		$total_registros = $Custom->salida;
		
		// Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarClasificacion($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	
	if ($res) {
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount', $total_registros);
		
		foreach ( $Custom->salida as $f ) {
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_clasificacion', $f["id_clasificacion"]);
			$xml->add_nodo('codigo', $f["codigo"]);
			$xml->add_nodo('codigo_largo', $f["codigo_largo"]);
			$xml->add_nodo('nombre', $f["nombre"]);
			$xml->add_nodo('estado', $f["estado"]);
			$xml->add_nodo('id_clasificacion_fk', $f["id_clasificacion_fk"]);
			$xml->add_nodo('usuario_mod', $f["usuario_mod"]);
			$xml->add_nodo('fecha_mod', $f["fecha_mod"]);
			$xml->add_nodo('orden', $f["orden"]);
		
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