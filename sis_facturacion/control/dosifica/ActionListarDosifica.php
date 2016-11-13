<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDosifica.php
Propósito:				Permite desplegar dosifica
Tabla:					tfv_dosifica
Parámetros:				$cant
Autor:					MTSL
Fecha creación:			2014.05
**********************************************************
*/
session_start();
include_once("../LibModeloFactur.php");

$Custom = new cls_CustomDBFactur();
$nombre_archivo = 'ActionListarDosifica.php';


if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	//Parámetros del filtro
	if($limit == "") $cant = 15;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

	if($sort == "") $sortcol = 'dos.id_dosifica';
	else $sortcol = $sort;

	if($dir == "") $sortdir = 'asc';
	else $sortdir = $dir;
	
	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> "si", "no" 
	switch ($cod)
	{
		case "si":
			$decodificar = true;
			break;
		case "no":
			$decodificar = false;
			break;
		default:
			$decodificar = true;
			break;
	}

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=="") $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++){
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	$criterio_filtro = $cond->obtener_criterio_filtro();
	
	if($sw_tipo_fac && $sw_estado){
		$criterio_filtro = $criterio_filtro." AND DOS.tipo_fac = $sw_tipo_fac AND DOS.estado = $sw_estado ";
	}
	
	if($sw_estado == 1){
		//$criterio_filtro = $criterio_filtro." AND DOS.fecha_vence >= CAST(now() AS date) ";
	}
	//Obtiene el total de los registros
	$res = $Custom->ContarDosifica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if($res) $total_registros= $Custom->salida;
		
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarDosifica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if($res){
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		foreach ($Custom->salida as $f){
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_dosifica', $f["id_dosifica"]);
			$xml->add_nodo('tipo_fac', $f["tipo_fac"]);
			$xml->add_nodo('nro_autoriza', $f["nro_autoriza"]);
			$xml->add_nodo('fecha_vence', $f["fecha_vence"]);
			$xml->add_nodo('clave_activa', $f["clave_activa"]);
			$xml->add_nodo('sw_debito', $f["sw_debito"]);
			$xml->add_nodo('nro_inicial', $f["nro_inicial"]);
			$xml->add_nodo('nro_actual', $f["nro_actual"]);
			$xml->add_nodo('actividad', $f["actividad"]);
			$xml->add_nodo('leyenda', $f["leyenda"]);
			$xml->add_nodo('estado', $f["estado"]);
			$xml->add_nodo('desc_usr_reg', $f["desc_usr_reg"]);
			$xml->add_nodo('fecha_reg', $f["fecha_reg"]);
			
			$xml->fin_rama();
		}
		$xml->mostrar_xml();
	}
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = $Custom->salida[1];
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;
		echo $resp->get_mensaje();
		exit;
	}
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;

}?>
