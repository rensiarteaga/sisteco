<?php
/**
**********************************************************
Nombre de archivo:	    ActionEliminarUbicacionArb.php
Prop�sito:				Permite eliminar datos
						para las ubicaciones de Almacenes.
Tabla:					tal_ubicacion, tal_almacen

Fecha de Creaci�n:		19-08-2013 11:58am
Versionn:				1.0.0
Autor:					Ruddy Lujan Bravo
**********************************************************
*/
session_start();
include_once ("../LibModeloAlma.php");

$Custom = new cls_CustomDBAlma();
$nombre_archivo = "ActionEliminarUbicacionArb.php";

if (! isset($_SESSION["autentificado"])) {
	$_SESSION["autentificado"] = "NO";
}
if ($_SESSION["autentificado"] == "SI") {
	
	$datosDecodificado = stripslashes($_REQUEST['datos']);
	$proceso = stripslashes($_REQUEST['proc']);
	
	$nodo = json_decode($datosDecodificado, true);
	if ($proc === 'del') {
		$res = $Custom->EliminarUbicacionArb($nodo["hidden_id_ubicacion"]);
		if (! $res) {
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = $Custom->salida[1];
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje();
			exit();
		}
		$tmp['id'] = $nodo["id_p"];
		echo json_encode($tmp);
		exit();
	} elseif ($proc === 'upd') {
		
		$res = $Custom->ModificarUbicacionArb($nodo["hidden_id_ubicacion"], $nodo["hidden_id_ubicacion_fk"], $nodo["hidden_id_almacen"], $nodo["txt_codigo"], $nodo["txt_nombre"], $nodo["txt_estado"]);
		if (! $res) {
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = $Custom->salida[1];
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje();
			exit();
		}
		$tmp['id'] = $nodo["id_p"];
		echo json_encode($tmp);
		exit();
	} else {
		$resp = new cls_manejo_mensajes(true, "401");
		$resp->mensaje_error = "MENSAJE ERROR = Proceso no identificado";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = "NIVEL = 1";
		echo $resp->get_mensaje();
		exit();
	}
} else {
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp->get_mensaje();
	exit();
}
?>