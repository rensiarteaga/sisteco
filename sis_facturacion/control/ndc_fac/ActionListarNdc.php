<?php
/*
**********************************************************
Nombre de archivo:	    ActionListarNdc.php
Propósito:				Permite desplegar Ndc
Tabla:					tfv_Ndc
Fecha de Creación:		2013.05
Versión:				1.0.0
Autor:					MTSL
**********************************************************
*/
session_start();
include_once("../LibModeloFactur.php");

$Custom = new cls_CustomDBFactur();
$nombre_archivo = 'ActionListarNdc.php';


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

	if($sort == "") $sortcol = 'NDC.id_ndc';
	else $sortcol = $sort;

	if($dir == "") $sortdir = 'desc';
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
	
	if($m_id_gestion){
		$criterio_filtro = $criterio_filtro." AND NDC.id_gestion = $m_id_gestion ";
	}
	
	//Obtiene el total de los registros
	$res = $Custom->ContarNdc($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if($res) $total_registros= $Custom->salida;
		
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarNdc($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if($res){
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f){
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_ndc', $f["id_ndc"]);
			$xml->add_nodo('id_gestion', $f["id_gestion"]);
			$xml->add_nodo('id_factura', $f["id_factura"]);
			$xml->add_nodo('id_dosifica', $f["id_dosifica"]);
			$xml->add_nodo('nro_autoriza', $f["nro_autoriza"]);
			$xml->add_nodo('simbolo', $f["simbolo"]);
			$xml->add_nodo('nombre_depto', $f["nombre_depto"]);
			$xml->add_nodo('fac_nombre', $f["fac_nombre"]);
			$xml->add_nodo('fac_nronit', $f["fac_nronit"]);
			$xml->add_nodo('fac_numero', $f["fac_numero"]);
			$xml->add_nodo('ndc_fecha', $f["ndc_fecha"]);
			$xml->add_nodo('ndc_concepto', $f["ndc_concepto"]);
			$xml->add_nodo('ndc_importe', $f["ndc_importe"]);
			$xml->add_nodo('ndc_numero', $f["ndc_numero"]);
			$xml->add_nodo('ndc_control', $f["ndc_control"]);
			$xml->add_nodo('ndc_formula', $f["ndc_formula"]);
			$xml->add_nodo('ndc_estado_vig', $f["ndc_estado_vig"]);
			$xml->add_nodo('usuario_reg', $f["usuario_reg"]);
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
