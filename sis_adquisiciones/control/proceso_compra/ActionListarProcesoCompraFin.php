<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarProcesoCompra.php
Propósito:				Permite realizar el listado en tad_proceso_compra
Tabla:					t_tad_proceso_compra
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-13 18:03:04
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionListarProcesoCompraFin.php';

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

	if($sort == '') $sortcol = 'prodet.id_proceso_compra';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'desc';
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
   
	if($sort=='numeracion_periodo_proceso'){
		$sortcol="periodo $sortdir, num_proceso $sortdir";
	}
	if($sort=='num_sol_por_proc'){
		$sortcol="num_sol_por_proc, $sortdir";
	}
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'ProcesoCompra');
	$sortcol = $crit_sort->get_criterio_sort();
//	

	$res1 = $Custom->ListarSolicitantes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_id_proceso_compra);
	if($res1)
	{
		$solicitantes=$Custom->salida[0][0];
	}
	
	//Obtiene el total de los registros
	$res = $Custom -> ContarSolicitudProcesoFin($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_id_proceso_compra);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarSolicitudProcesoFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_id_proceso_compra);
	

	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			 /*varchar,proveedor text,impuestos varchar,num_factura integer,fecha_factura date,cantidad_sol numeric,cant_total numeric,id_moneda int4,
			 simbolo varchar,estado_vigente varchar,id_cotizacion int4*/
			
			$xml->add_nodo('nombre',$f["nombre"]);
			$xml->add_nodo('proveedor',$f["proveedor"]);
			$xml->add_nodo('impuestos',$f["impuestos"]);
			$xml->add_nodo('num_factura',$f["num_factura"]);
			$xml->add_nodo('fecha_factura',$f["fecha_factura"]);
			$xml->add_nodo('cantidad_sol',$f["cantidad_sol"]);
			$xml->add_nodo('cant_total',$f["cant_total"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('simbolo',$f["simbolo"]);
			$xml->add_nodo('estado_vigente',$f["estado_vigente"]);
			$xml->add_nodo('id_cotizacion',$f["id_cotizacion"]);
			$xml->add_nodo('solicitantes',$solicitantes);
			$xml->add_nodo('num_sol_por_proc',$f["num_sol_por_proc"]);
			$xml->add_nodo('id_proceso_compra_det',$f["id_proceso_compra_det"]);
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