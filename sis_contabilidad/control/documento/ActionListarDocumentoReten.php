<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDocumentoReten.php
Propósito:				Permite realizar el listado en tct_rubro
Tabla:					t_tct_rubro
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-10-02 11:34:34
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloContabilidad.php');
include_once('../../../lib/lib_control/GestionarExcel.php');

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarDocumentoReten.php';

if (!isset($_SESSION['autentificado'])){
	$_SESSION['autentificado']='NO';
}

if($_SESSION['autentificado']=='SI')
{
	//Parámetros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'DOC.fecha_documento';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> 'si', 'no'
	
	switch ($cod){
		case 'si':
			$decodificar = true;
			break;
		case 'no':
			$decodificar = false;
			break;
		default:
			$decodificar = true;
			break;
	}

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;
	
	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++){
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
 
	if ($por_comprobante=='true'){
		$sortcol = 'COM.desc_comprobante,DOC.fecha_documento ';
	}else{
		$sortcol = 'DOC.fecha_documento, COM.desc_comprobante ';
	}
		
	if($toda_gestion=='true'){
		$hidden_ep_id_actividad = $m_gestion;
	}
	//echo $hidden_ep_id_actividad; exit;	

	if($sw_totales=='true'){
		//Obtiene el total de los registros
		$res = $Custom -> ContarDocumentoIvaTotal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_periodo,$m_id_moneda,$sw_retencion,$m_id_depto,$tipo_documento);
		if($res) $total_registros= $Custom->salida;
	
		//Obtiene el conjunto de datos de la consulta
		$res = $Custom->ListarDocumentoRetenTotal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_periodo,$m_id_moneda,$sw_retencion,$m_id_depto,$tipo_documento);
	}else{
		//Obtiene el total de los registros
		$res = $Custom -> ContarDocumentoIva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_periodo,$m_id_moneda,$sw_retencion,$m_id_depto,$tipo_documento);
		if($res) $total_registros= $Custom->salida;
	
		//Obtiene el conjunto de datos de la consulta
		$res = $Custom->ListarDocumentoReten($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_periodo,$m_id_moneda,$sw_retencion,$m_id_depto,$tipo_documento);
	}
	
	if($res){ 
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f){
			$xml->add_rama('ROWS');			

			$xml->add_nodo('id_documento',$f["id_documento"]);
			$xml->add_nodo('desc_plantilla',$f["desc_plantilla"]);
			$xml->add_nodo('desc_comprobante',$f["desc_comprobante"]);
			$xml->add_nodo('fecha_documento',$f["fecha_documento"]);
			$xml->add_nodo('razon_social',$f["razon_social"]);
			$xml->add_nodo('nro_documento',$f["nro_documento"]);
			$xml->add_nodo('importe_total',$f["importe_total"]);
			$xml->add_nodo('importe_iue',$f["importe_iue"]);
			$xml->add_nodo('importe_it',$f["importe_it"]);
			$xml->add_nodo('importe_credito',$f["importe_credito"]);
			$xml->add_nodo('importe_neto',$f["importe_neto"]);
			
			$xml->fin_rama();
		}
		$xml->mostrar_xml();
	}else{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true,'406');
		$resp->mensaje_error = $Custom->salida[1];
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;
		echo $resp->get_mensaje();
		exit;
	}
}
else{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;
}?>