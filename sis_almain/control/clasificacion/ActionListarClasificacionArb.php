<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarAlmacenUbicacionArb.php
Prop?sito:				Lista el arbol de las entidades financieras y sucursales para la asignacion de Funcionarios.
Tabla:					tcb_ubicacion, tcb_almacen

Fecha de Creaci?n:		09-08-2013
Versi?n:				1.0.0
Autor:					Ruddy Lujan Bravo
**********************************************************
*/
session_start();
include_once ('../LibModeloAlma.php');
// $Custom = new cls_CustomDBAlma();
$nombre_archivo = 'ActionListarClasificacionArb.php';

if (! isset($_SESSION['autentificado'])) {
	$_SESSION['autentificado'] = 'NO';
}
if ($_SESSION['autentificado'] == 'SI') {
	
	// Par?metros del filtro
	if ($limit == '')
		$cant = 30;
	else
		$cant = $limit;
	
	if ($start == '')
		$puntero = 0;
	else
		$puntero = $start;
	
	if ($sort == '')
		$sortcol = 'id_clasificacion';
		//$sortcol ='cla.orden'; 
	else
		$sortcol = $sort;
	
	if ($dir == '')
		$sortdir = 'asc';
	else
		$sortdir = $dir;
		
		// Verifica si se har? o no la decodificaci?n(s?lo pregunta en caso del GET)
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
	
	if ($id_clasificacion != '' && $id_clasificacion != 'undefined' && $id_clasificacion != null) {
		$cond->add_criterio_extra("id_clasificacion_fk", $id_clasificacion);
		$criterio_filtro = $cond->obtener_criterio_filtro();
	} else {
		$criterio_filtro = "id_clasificacion_fk is null";
	}
	if($id_clasificacion_fk == 'undefined' || $node=='id' ) $sortcol ='cla.id_clasificacion'; 
	else $sortcol ='cla.orden';
		
	$nodes = Array ();
	
	$Custom = new cls_CustomDBAlma();
	//echo $id_clasificacion_fk.'   '.$sortcol;exit;
	$res = $Custom->ListarClasificacion($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $hidden_ep_id_financiador, $hidden_ep_id_regional, $hidden_ep_id_programa, $hidden_ep_id_proyecto, $hidden_ep_id_actividad);
	if ($res) {
		$tipo_nodo = "clasificacion";
		foreach ( $Custom->salida as $f ) {
			//$tmp['text'] = utf8_encode($f["orden"]." [" . $f["codigo_largo"] . "] - " . $f["nombre"]);
			if($f["orden"] == null || $f["orden"] =='')
					$tmp['text'] = utf8_encode($f["orden"]." [" . $f["codigo_largo"] . "] - " . $f["nombre"]);
			else 
					$tmp['text'] = utf8_encode("<b>".$f["orden"].".-</b>  [" . $f["codigo_largo"] . "] - " . $f["nombre"]);
			
			$tmp['id'] = utf8_encode($tipo_nodo . "-" . $f["id_clasificacion"]);
			$tmp['cls'] = 'folder';
			$tmp['leaf'] = false;
			$tmp['allowDelete'] = true;
			$tmp['allowDrag'] = false;
			$tmp['allowDrop'] = true;
			$tmp['allowEdit'] = true;
			
			$tmp['icon'] = "../../../lib/imagenes/a_table_gear.png";
			$tmp['qtip'] = utf8_encode($f["nombre"]);
			$tmp['qtipTitle'] = utf8_encode($f["codigo_largo"]);
			$tmp['tipo_nodo'] = $tipo_nodo;
			$tmp['id_clasificacion'] = utf8_encode($f["id_clasificacion"]);
			$tmp['id_clasificacion_fk'] = utf8_encode($f["id_clasificacion_fk"]);
			$tmp['codigo'] = utf8_encode($f["codigo"]);
			$tmp['nombre'] = utf8_encode($f["nombre"]);
			$tmp['estado'] = utf8_encode($f["estado"]);
			$tmp['sw_demasia'] = utf8_encode($f["sw_demasia"]);
			
			$tmp['tipo_rama'] = utf8_encode($f["tipo_rama"]);
			$tmp['orden'] = utf8_encode($f["orden"]);
			
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