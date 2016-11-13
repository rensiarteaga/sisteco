<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?>
<?php

/**
 * **********************************************************
 * Nombre de archivo: 		ActionListarUnidadConstructiva.php
 * Propósito:				Permite desplegar una unidad constructiva
 * Tabla:					tal_unidad_constructiva
 * Parámetros:				
 * $cant
 * $puntero
 * $sortcol
 * $sortdir
 * $criterio_filtro
 *
 * Valores de Retorno: 		Listado de Procesos y total de registros listados
 * Fecha de Creación:		15-12-2014
 * Versión:					1.0.0
 * Autor:					UNKNOW
 * *********************************************************
 */
session_start();
include_once ('../LibModeloAlma.php');
$Custom = new cls_CustomDBAlma();
$nombre_archivo = 'ActionListarUnidadConstructiva.php';

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
		$sortcol = 'id_unidad_constructiva'; // falta
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
	
	/*
	if ($m_id_almacen != null && m_id_almacen != "undefined" && $m_id_almacen!='') 
	{
		$cond->add_criterio_extra("fa.id_almacen", $m_id_almacen);
	}
	*/
	
	$criterio_filtro = $cond->obtener_criterio_filtro();
	
	// Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol, $sortdir, ''); 

	//criterio fitro añadido, para registrar solo nodos padre en un tramo
	if($filtro_tramo!=null && $filtro_tramo != 'undefined' && $filtro_tramo != '')
	{
		$criterio_filtro = $criterio_filtro. ' AND uc.id_unidad_constructiva_fk IS NULL';
	}
	
	if(isset($f_salida_uc_det) && $f_salida_uc_det)
	{
		if(isset($id_uc_filtro))
		{
			$criterio_filtro.=' AND  uc.id_unidad_constructiva IN (	select t.id_unidad_constructiva 
																from alma.tmp_unidad_constructiva t 
																where t.id_nodo_padre like('.$id_uc_filtro.')
									 						   )';
		}
	}
	// Obtiene el total de los registros
	$res = $Custom->ContarUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	
	if ($res)
		$total_registros = $Custom->salida;
		// Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarUnidadConstructivaTramo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	
	if ($res) 
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount', $total_registros);
		
		foreach ( $Custom->salida as $f ) 
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_unidad_constructiva', $f["id_unidad_constructiva"]);
			$xml->add_nodo('id_unidad_constructiva_fk', $f["id_unidad_constructiva_fk"]);
			$xml->add_nodo('desc_unidad_constructiva', $f["desc_unidad_constructiva"]);
			$xml->add_nodo('estado', $f["estado"]);
			$xml->add_nodo('descripcion', $f["descripcion"]);
			$xml->add_nodo('observaciones', $f["observaciones"]);
			$xml->add_nodo('fecha_reg', $f["fecha_reg"]);
			$xml->add_nodo('usuario_reg', $f["usuario_reg"]);
			$xml->add_nodo('codigo', $f["codigo"]);
			$xml->add_nodo('nombre', $f["nombre"]);
			
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