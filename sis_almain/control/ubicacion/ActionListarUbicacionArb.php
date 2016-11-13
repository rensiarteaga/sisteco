<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarUbicacionArb.php
Prop?sito:				Lista el arbol de las entidades financieras y sucursales para la asignacion de Funcionarios.
Tabla:					tcb_ubicacion, tcb_almacen

Fecha de Creaci?n:		09-08-2013
Versi?n:				1.0.0
Autor:					Ruddy Lujan Bravo
**********************************************************
*/
session_start();
include_once ('../LibModeloAlma.php');
$nombre_archivo = 'ActionListarUbicacionArb.php';

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
		$sortcol = 'ub.codigo';
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
	
	if ($id_ubicacion != '' && $id_ubicacion != 'undefined' && $id_ubicacion != null) {
		$cond->add_criterio_extra("ub.id_ubicacion_fk", $id_ubicacion);
		$criterio_filtro = $cond->obtener_criterio_filtro();
	} else {
		$criterio_filtro = "ub.id_ubicacion_fk is null";
		if ($id_almacen != '' && $id_almacen != 'undefined' && $id_almacen != null) {
			$criterio_filtro .= " and ub.id_almacen = " . $id_almacen;
		}
		else
		{
			$criterio_filtro.=" AND ub.id_almacen is null";
		}
	}
	$nodes = Array ();
	
	$Custom = new cls_CustomDBAlma();

	$res = $Custom->ListarUbicacionArb($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $hidden_ep_id_financiador, $hidden_ep_id_regional, $hidden_ep_id_programa, $hidden_ep_id_proyecto, $hidden_ep_id_actividad);
	if ($res) {
		$tipo_nodo = "ubicacion";
		foreach ( $Custom->salida as $f ) {
			$tmp['text'] = utf8_encode("[" . $f["codigo"] . "]-" . $f["nombre"]);
			$tmp['id'] = utf8_encode($tipo_nodo . "-" . $f["id_ubicacion"]);
			$tmp['cls'] = 'folder';
			$tmp['leaf'] = false;
			$tmp['allowDelete'] = true;
			$tmp['allowDrag'] = false;
			$tmp['allowDrop'] = false;
			$tmp['allowEdit'] = true;
			
			if ($tipo_nodo == "ubicacion") {
				if ($f["estado"] == "Activo") {
					$tmp['icon'] = "../../../lib/imagenes/house.png";
				} else {
					$tmp['icon'] = "../../../lib/imagenes/house_inactive.png";
				}
			}
			
			$tmp['icon'] = "../../../lib/imagenes/org.png";
			$tmp['qtip'] = $tipo_nodo;
			$tmp['qtipTitle'] = utf8_encode("[" . $f["codigo"] . "]-" . $f["nombre"]);
			
			$tmp['tipo_nodo'] = $tipo_nodo;
			$tmp['id_ubicacion'] = utf8_encode($f["id_ubicacion"]);
			$tmp['id_ubicacion_fk'] = utf8_encode($f["id_ubicacion_fk"]);
			$tmp['id_almacen'] = utf8_encode($f["id_almacen"]);
			$tmp['codigo'] = utf8_encode($f["codigo"]);
			$tmp['nombre'] = utf8_encode($f["nombre"]);
			$tmp['estado'] = utf8_encode($f["estado"]);
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