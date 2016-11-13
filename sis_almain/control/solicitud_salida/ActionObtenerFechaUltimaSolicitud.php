<?php
ob_start('limpiar');
function limpiar($buffer) {
	return trim($buffer);
}
?>
<?php

session_start();
include_once ('../LibModeloAlma.php');
$Custom = new cls_CustomDBAlma();
$nombre_archivo = 'ActionObtenerFechaUltimaSolicitud.php';

if (! isset($_SESSION['autentificado'])) {
	$_SESSION['autentificado'] = 'NO';
}
if ($_SESSION['autentificado'] == 'SI') {
	
	if(isset($id_almacen))
	{
		$cant = $id_almacen;
		$criterio_filtro = "0=0";
	}
		
	// Obtiene el conjunto de datos de la consulta
	$res = $Custom->ObtenerFechaUltimaSolicitud($cant, $puntero=0, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		
	if ($res) 
	{
		$resul =$Custom->salida[0][0];
		$fecha_sep = explode('-',$resul);
		$fecha = $fecha_sep[2]."/".$fecha_sep[1]."/".$fecha_sep[0];
		
		
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount', 1);
	
		$xml->add_rama('ROWS');
		$xml->add_nodo('fecha',$fecha);
		$xml->fin_rama();
			
		$xml->mostrar_xml();
	} 
	else 
	{
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