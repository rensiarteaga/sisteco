<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?>
<?php

/**
 * **********************************************************
 * Nombre de archivo: 		ActionListarIngresos.php
 * Propósito:				Permite desplegar ingresos segun el id_costeo
 * Tabla:					tal_ingresos
 * Parámetros:				$cant
 * $puntero
 * $sortcol
 * $sortdir
 * $criterio_filtro
 * $id_usuario_asignacion
 *
 * Valores de Retorno: Listado de Procesos y total de registros listados
 * Fecha de Creación:		05-05-2015
 * Versión:					1.0.0
 
 * *********************************************************
 */
session_start();
include_once ('../LibModeloAlma.php');

$Custom = new cls_CustomDBAlma();
$nombre_archivo = 'ActionListarIngresos.php';

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
		$sortcol = 'id_costeo'; // falta
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
	

	$criterio_filtro = $cond->obtener_criterio_filtro();

	if (isset($id_costeo) && $id_costeo > 0)
	{
		$criterio_filtro .= ' AND ing.id_costeo like('.$id_costeo.')';
	}
	else
	{
		$criterio_filtro .= ' AND ing.id_costeo = -1';
	}
	
	// Obtiene el total de los registros
	$res = $Custom->ContarIngresosFinalizados($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	if ($res) 
		$total_registros = $Custom->salida;
		// Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarIngresosFinalizados($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	if ($res) {
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount', $total_registros);
		foreach ( $Custom->salida as $f ) {
			$xml->add_rama('ROWS');
			
			$xml->add_nodo('id_ingresos', $f["id_ingresos"]);
			$xml->add_nodo('id_movimiento_proyecto', $f["id_movimiento_proyecto"]);
			$xml->add_nodo('desc_mov_proy', $f["desc_mov_proy"]);
			$xml->add_nodo('id_costeo', $f["id_costeo"]);
			$xml->add_nodo('desc_costeo', $f["desc_costeo"]);
			$xml->add_nodo('seleccionado', $f["seleccionado"]);
			$xml->add_nodo('fecha_ingreso', $f["fecha_ingreso"]);
			$xml->add_nodo('peso_neto', $f["peso_neto"]);
		
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