<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?>
<?php

/**
 * **********************************************************
 * Nombre de archivo: ActionListarSalidaunidadConstructivaDet.php
 * Propósito:				Permite desplegar el detalle de una unidad constructiva
 * Tabla:					tal_salida_uc_det
 * Parámetros:				
 * $cant
 * $puntero
 * $sortcol
 * $sortdir
 * $criterio_filtro
 *
 * Valores de Retorno: Listado de Procesos y total de registros listados
 * Fecha de Creación:		26-12-2014
 * Versión:					1.0.0
 * Autor:					UNKNOW
 * *********************************************************
 */
session_start();
include_once ('../LibModeloAlma.php');
$Custom = new cls_CustomDBAlma();
$nombre_archivo = 'ActionListarSalidaunidadConstructivaDet.php';

if (! isset($_SESSION['autentificado'])) 
{
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
		$sortcol = 'id_salida_uc_detalle'; // falta
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
	if ($CantFiltros == '')$CantFiltros = 0;
		
	// Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i = 0; $i < $CantFiltros; $i ++) 
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	if ($id_salida_uc != null && $id_salida_uc != "undefined" && $id_salida_uc!='') 
	{
		$cond->add_criterio_extra("sucd.id_salida_uc", $id_salida_uc);
	}

    
	$criterio_filtro = $cond->obtener_criterio_filtro();
	
	// Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol, $sortdir, 'salida'); 
	//$sortcol = $crit_sort->get_criterio_sort();
	
	// Obtiene el total de los registros
	$res = $Custom->ContarSalidaUCDet($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	
	
	if ($res)
		$total_registros = $Custom->salida;
		// Obtiene el conjunto de datos de la consulta
	
	$res = $Custom->ListarSalidaUCDet($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	
	if ($res) 
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount', $total_registros);
		
		foreach ( $Custom->salida as $f ) {
			$xml->add_rama('ROWS');
						$xml->add_nodo('id_salida_uc_detalle', $f["id_salida_uc_detalle"]);
                        $xml->add_nodo('id_salida_uc', $f["id_salida_uc"]);
                        $xml->add_nodo('cantidad', $f["cantidad"]);
                        $xml->add_nodo('id_unidad_constructiva', $f["id_unidad_constructiva"]);
                        $xml->add_nodo('desc_uc', $f["desc_uc"]);
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