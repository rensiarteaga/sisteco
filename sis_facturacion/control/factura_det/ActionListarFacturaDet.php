<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarFacturaDet.php
Propósito:				Permite desplegar factura_det
Tabla:					tfv_factura_det
Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2014.05
Versión:				1.0.0
Autor:					MTSL
**********************************************************
*/
session_start();
include_once("../LibModeloFactur.php");

$Custom = new cls_CustomDBFactur();
$nombre_archivo = 'ActionListarFacturaDet.php';


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

	if($sort == "") $sortcol = 'DET.id_factura_det';
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
	
	if($m_id_factura){
		$criterio_filtro = $criterio_filtro. " AND DET.id_factura = $m_id_factura";
	}
	
	//Obtiene el total de los registros
	$res = $Custom->ContarFacturaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if($res) $total_registros= $Custom->salida;
		
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarFacturaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if($res){
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f){
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_factura_det', $f["id_factura_det"]);
			$xml->add_nodo('id_factura', $f["id_factura"]);
            $xml->add_nodo('id_presupuesto', $f["id_presupuesto"]);
			$xml->add_nodo('desc_presupuesto', $f["desc_presupuesto"]);
			$xml->add_nodo('id_ppto_gasto', $f["id_ppto_gasto"]);
			$xml->add_nodo('desc_gasto', $f["desc_gasto"]);
			$xml->add_nodo('id_concepto_ingas', $f["id_concepto_ingas"]);
			$xml->add_nodo('desc_ingas', $f["desc_ingas"]);
			$xml->add_nodo('id_partida', $f["id_partida"]);
			$xml->add_nodo('despar', $f["despar"]);
			$xml->add_nodo('id_cuenta', $f["id_cuenta"]);
			$xml->add_nodo('descta', $f["descta"]);
			$xml->add_nodo('id_auxiliar', $f["id_auxiliar"]);
			$xml->add_nodo('desaux', $f["desaux"]);
			$xml->add_nodo('fac_importe', $f["fac_importe"]);
			$xml->add_nodo('fac_descuento', $f["fac_descuento"]);
			$xml->add_nodo('fac_obsdesc', $f["fac_obsdesc"]);
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
