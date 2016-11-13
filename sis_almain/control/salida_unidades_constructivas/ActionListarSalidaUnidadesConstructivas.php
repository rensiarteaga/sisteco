<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?>
<?php

/**
 * **********************************************************
 * Nombre de archivo: ActionListarSalidaUnidadesConstructivas.php
 * Prop�sito:				Permite desplegar la salida de las unidades constructivas
 * Tabla:					tal_salida_uc
 * Par�metros:				
 * $cant
 * $puntero
 * $sortcol
 * $sortdir
 * $criterio_filtro
 *
 * Valores de Retorno: Listado de Procesos y total de registros listados
 * Fecha de Creaci�n:		23-12-2014
 * Versi�n:					1.0.0
 * Autor:					UNKNOW
 * *********************************************************
 */
session_start();
include_once ('../LibModeloAlma.php');
$Custom = new cls_CustomDBAlma();
$nombre_archivo = 'ActionListarSalidaUnidadesConstructivas.php';

if (! isset($_SESSION['autentificado'])) 
{
	$_SESSION['autentificado'] = 'NO';
}
if ($_SESSION['autentificado'] == 'SI') {
	
	// Par�metros del filtro
	if ($limit == '')
		$cant = 15;
	else
		$cant = $limit;
	
	if ($start == '')
		$puntero = 0;
	else
		$puntero = $start;
	
	if ($sort == '')
		$sortcol = 'suc.id_salida_uc'; // falta
	else
		$sortcol = $sort;
	
	if ($dir == '')
		$sortdir = 'desc';
	else
		$sortdir = $dir;
		
		// Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
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
	if ($m_id_almacen != null && m_id_almacen != "undefined" && $m_id_almacen!='') 
	{
		$cond->add_criterio_extra("suc.id_almacen", $m_id_almacen);
	} 

	$criterio_filtro = $cond->obtener_criterio_filtro();
	// Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol, $sortdir, 'salida_uc'); 
	//$sortcol = $crit_sort->get_criterio_sort();
	// Obtiene el total de los registros
	$res = $Custom->ContarSalidaUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	
	if ($res)
		$total_registros = $Custom->salida;
		// Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarSalidaUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	
	if ($res) 
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount', $total_registros);
		 
		foreach ( $Custom->salida as $f ) {
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_salida_uc', $f["id_salida_uc"]);
			$xml->add_nodo('id_almacen', $f["id_almacen"]);
			$xml->add_nodo('desc_almacen', $f["desc_almacen"]);
			$xml->add_nodo('id_contratista', $f["id_contratista"]);
			$xml->add_nodo('desc_contratista', $f["desc_contratista"]);
			$xml->add_nodo('id_proveedor', $f["id_proveedor"]);
			$xml->add_nodo('desc_proveedor', $f["desc_proveedor"]);
			$xml->add_nodo('id_empleado', $f["id_empleado"]);
			$xml->add_nodo('desc_empleado', $f["desc_empleado"]);
			$xml->add_nodo('id_institucion', $f["id_institucion"]);
			$xml->add_nodo('desc_institucion', $f["desc_institucion"]);
			$xml->add_nodo('id_fase', $f["id_fase"]);
			$xml->add_nodo('desc_fase', $f["desc_fase"]);
			$xml->add_nodo('id_tramo', $f["id_tramo"]);
			$xml->add_nodo('desc_tramo', $f["desc_tramo"]);
			$xml->add_nodo('id_unidad_constructiva', $f["id_unidad_constructiva"]);
			$xml->add_nodo('desc_uc', $f["desc_uc"]);
			$xml->add_nodo('nro_contrato', $f["nro_contrato"]);
			$xml->add_nodo('fecha_salida', $f["fecha_salida"]);
			$xml->add_nodo('concepto_salida', $f["concepto_salida"]);
			$xml->add_nodo('observaciones', $f["observaciones"]);
			$xml->add_nodo('supervisor', $f["supervisor"]);
			$xml->add_nodo('ci_supervisor', $f["ci_supervisor"]);
			$xml->add_nodo('receptor', $f["receptor"]);
			$xml->add_nodo('ci_receptor', $f["ci_receptor"]);
			$xml->add_nodo('solicitante', $f["solicitante"]);
			$xml->add_nodo('ci_solicitante', $f["ci_solicitante"]);
			$xml->add_nodo('fecha_reg', $f["fecha_reg"]);
			$xml->add_nodo('usuario_reg', $f["usuario_reg"]);
			$xml->add_nodo('origen_salida', $f["origen_salida"]);
			
			$xml->add_nodo('estado', $f["estado"]);
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