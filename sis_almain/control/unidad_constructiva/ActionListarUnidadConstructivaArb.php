<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarUnidadConstructivaArb.php
Proposito:				Lista el arbol de unidades constructivas del sistema
Fecha de Creaci?n:		08-08-2014
Version:				1.0.0
Autor:					UNKNOW
**********************************************************
*/
session_start();
include_once ('../LibModeloAlma.php');

$nombre_archivo = 'ActionListarUnidadConstructivaArb.php';

if (! isset($_SESSION['autentificado'])) {
	$_SESSION['autentificado'] = 'NO';
}
if ($_SESSION['autentificado'] == 'SI') {
	
	// Par?metros del filtro
	if ($limit == '')
		$cant = 15;
	else
		$cant = $limit;
	
	if ($start == '')
		$puntero = 0;
	else
		$puntero = $start;
	
	if ($sort == '')
		$sortcol = 'id_unidad_constructiva';
	else
		$sortcol = $sort;
	
	if ($dir == '')
		$sortdir = 'asc';
	else
		$sortdir = $dir;
		
		// Verifica si se hara o no la decodificacion( pregunta en caso del GET)
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
	
	if ($id_unidad_constructiva != '' && $id_unidad_constructiva != 'undefined' && $id_unidad_constructiva != null) {
		$cond->add_criterio_extra("uni.id_unidad_constructiva_fk", $id_unidad_constructiva);
		$criterio_filtro = $cond->obtener_criterio_filtro();
	} else 
	{
		$criterio_filtro = "uni.id_unidad_constructiva_fk is null";
	}
	
	if($id_unidad_constructiva_fk == 'undefined' || $node=='id')$sortcol='id_unidad_constructiva';
	else $sortcol='orden';
	
	$nodes = Array ();
	
	$Custom = new cls_CustomDBAlma();

	$res = $Custom->ListarUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	if ($res) {
		$tipo_nodo = "unidad_constructiva";
		foreach ( $Custom->salida as $f ) {
			//$tmp['text'] = utf8_encode("[" . $f["codigo"] . "]-" . $f["nombre"]);
			if($f["orden"] == null || $f["orden"] =='')
				$tmp['text'] = utf8_encode($f["orden"]." [" . $f["codigo"] . "] - " . $f["nombre"]);
			else
				$tmp['text'] = utf8_encode("<b>".$f["orden"].".-</b> [" . $f["codigo"] . "] - " . $f["nombre"]);
				
			
			$tmp['id'] = utf8_encode($tipo_nodo . "-" . $f["id_unidad_constructiva"]);
			$tmp['cls'] = 'folder';
			$tmp['leaf'] = false; 
			$tmp['allowDelete'] = true;
			$tmp['allowDrag'] = false;
			$tmp['allowDrop'] = true;
			$tmp['allowEdit'] = true;
			
			$tmp['icon'] = "../../../lib/imagenes/a_table_gear.png";
			$tmp['qtip'] = utf8_encode($f["nombre"]);
			$tmp['qtipTitle'] = utf8_encode($f["codigo"]);
			$tmp['tipo_nodo'] = $tipo_nodo;
			$tmp['id_unidad_constructiva'] = utf8_encode($f["id_unidad_constructiva"]);
			$tmp['id_unidad_constructiva_fk'] = utf8_encode($f["id_unidad_constructiva_fk"]);
			$tmp['codigo'] = utf8_encode($f["codigo"]);
			$tmp['nombre'] = utf8_encode($f["nombre"]);
			$tmp['descripcion'] = utf8_encode($f["descripcion"]);
			$tmp['observaciones'] = utf8_encode($f["observaciones"]);
			$tmp['desc_unidad_const'] = utf8_encode($f["desc_unidad_const"]);
			$tmp['estado'] = utf8_encode($f["estado"]); 
			
			$tmp['tipo_rama'] = utf8_encode($f["tipo_rama"]);
			$tmp['orden'] = utf8_encode($f["orden"]);
			$tmp['cod_tramo'] = utf8_encode($f["cod_tramo"]);
			$nodes[] = $tmp;
		}
		header("Content-Type:text/json; charset=" . $_SESSION["CODIFICACION_HEADER"]);
		if (sizeof($nodes) > 0) {
			echo json_encode($nodes);
		} else {
			echo '{}';
		}
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
function mostrarErrorCustom($Custom) {
	$resp = new cls_manejo_mensajes(true, '406');
	$resp->mensaje_error = $Custom->salida[1];
	$resp->origen = $Custom->salida[2];
	$resp->proc = $Custom->salida[3];
	$resp->nivel = $Custom->salida[4];
	$resp->query = $Custom->query;
	echo $resp->get_mensaje();
	exit();
}
?>