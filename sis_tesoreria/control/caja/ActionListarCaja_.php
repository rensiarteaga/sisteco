<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCaja.php
Propósito:				Permite realizar el listado en tts_caja
Tabla:					tts_tts_caja
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-10-21 09:30:44
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloTesoreria.php');

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = 'ActionListarCaja .php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_caja';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> 'si', 'no'
	
	switch ($cod)
	{
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
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	if($m_id_depto){
		$criterio_filtro.=" AND CAJA.estado_caja=1 AND CAJA.id_depto=$m_id_depto ";
		
	}
	if($tipo){
		$criterio_filtro.=" AND CAJA.tipo_caja=$tipo ";
	}
	
	if($estado_repo){//solo cajas activas==> estado_caja=1 (filtro enviado desde proceso_simplificado_factura en COMPRO)
	    $criterio_filtro.=" AND (CAJA.estado_caja=$estado_repo)";
	}
	
	if($estado=='1'){//solo cajas activas==> estado_caja=1 (filtro enviado desde proceso_simplificado_factura en COMPRO)
	    
	    $criterio_filtro.=" AND (CAJA.id_caja in (select * from compro.f_tad_obtener_cajas($id_proceso_compra,''proceso'',''caja'') as (id_caja integer)))";
	}
	if($estado=='2'){//solo cajas activas==> estado_caja=1 (filtro enviado desde proceso_simplificado_factura en COMPRO)
	    
	    $criterio_filtro.=" AND (CAJA.id_caja in (select * from compro.f_tad_obtener_cajas($id_cotizacion,''cotizacion'',''caja'') as (id_caja integer)))";
	}

	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Caja');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarCaja($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_caja',$f["id_caja"]);
			$xml->add_nodo('tipo_caja',$f["tipo_caja"]);
			$xml->add_nodo('id_unidad_organizacional',$f["id_unidad_organizacional"]);
			$xml->add_nodo('desc_unidad_organizacional',$f["desc_unidad_organizacional"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
			$xml->add_nodo('id_dosifica',$f["id_dosifica"]);
			$xml->add_nodo('desc_dosifica',$f["desc_dosifica"]);
			$xml->add_nodo('fecha_inicio',$f["fecha_inicio"]);
			$xml->add_nodo('fecha_cierre',$f["fecha_cierre"]);
			$xml->add_nodo('sw_factura',$f["sw_factura"]);
			$xml->add_nodo('importe_maximo',$f["importe_maximo"]);
			$xml->add_nodo('porcentaje_compra',$f["porcentaje_compra"]);
			$xml->add_nodo('nro_recibo',$f["nro_recibo"]);
			$xml->add_nodo('estado_caja',$f["estado_caja"]);
			$xml->add_nodo('id_partida_cuenta',$f["id_partida_cuenta"]);
			$xml->add_nodo('desc_parcta',$f["desc_par_cta"]);
			$xml->add_nodo('id_auxiliar',$f["id_auxiliar"]);
			$xml->add_nodo('desc_auxiliar',$f["desc_auxiliar"]);
			$xml->add_nodo('id_fina_regi_prog_proy_acti',$f["id_fina_regi_prog_proy_acti"]);
			$xml->add_nodo('epe',$f["desc_epe"]);
			$xml->add_nodo('id_depto',$f["id_depto"]);
			$xml->add_nodo('nombre_depto',$f["nombre_depto"]);
			$xml->add_nodo('codigo_caja',$f["codigo_caja"]);
			$xml->add_nodo('desc_caja',$f["desc_caja"]);

			$xml->fin_rama();
		}
		$xml->mostrar_xml();
	}
	else
	{
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