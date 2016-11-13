<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?>
<?php

/**
 * **********************************************************
 * Nombre de archivo: 		ActionListarCosteoDetalle.php
 * Propósito:				Permite desplegar costeo_detalle
 * Tabla:					tal_costeo_detalle
 * Parámetros:				
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
$nombre_archivo = 'ActionListarCosteoDetalle.php';

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
		$sortcol = 'id_costeo_detalle'; // falta
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
	
	
	if($m_id_costeo != null && $m_id_costeo !="undefined" && $m_id_costeo!='')
		$cond->add_criterio_extra("det.id_costeo",$m_id_costeo);

	$criterio_filtro = $cond->obtener_criterio_filtro();

	$res = $Custom->ContarCosteoDetalle($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	if ($res) 
		$total_registros = $Custom->salida;
		// Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCosteoDetalle($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	if ($res) {
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount', $total_registros);
		foreach ( $Custom->salida as $f ) {
			$xml->add_rama('ROWS');
			
			$xml->add_nodo('id_costeo_detalle', $f["id_costeo_detalle"]);
			$xml->add_nodo('valor_costo', $f["valor_costo"]);
			$xml->add_nodo('id_costeo', $f["id_costeo"]);
			$xml->add_nodo('desc_costeo', $f["desc_costeo"]);
			$xml->add_nodo('id_costo', $f["id_costo"]);
			$xml->add_nodo('desc_costo', $f["desc_costo"]);
			
			$xml->add_nodo('estado', $f["estado"]);
			$xml->add_nodo('usuario_reg', $f["usuario_reg"]);
			$xml->add_nodo('fecha_reg', $f["fecha_reg"]);
			
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