<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarPlanPago.php
Propósito:				Permite realizar el listado en tad_plan_pago
Tabla:					t_tad_plan_pago
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-28 17:32:19
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionListarPlanPago .php';

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

	//if($sort == '') 
	$sortcol = 'nro_cuota';
	//else $sortcol = $sort;

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
	$cond->add_criterio_extra("cotiza.id_cotizacion",$m_id_cotizacion);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
//	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'PlanPago');
//	$sortcol = $crit_sort->get_criterio_sort();


	//Obtiene el total de los registros
	$res = $Custom -> ContarPlanPago($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_id_cotizacion);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarPlanPagoCuota($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_id_cotizacion);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('monto_a_pagar',$f["monto_a_pagar"]);
			$xml->add_nodo('cuota_a_pagar',$f["cuota_a_pagar"]);
			$xml->add_nodo('estado',$f["estado"]);
			$xml->add_nodo('fecha_pago',$f["fecha_pago"]);
			$xml->add_nodo('id_cotizacion',$f["id_cotizacion"]);
			$xml->add_nodo('id_plan_pago',$f["id_plan_pago"]);
			$xml->add_nodo('monto',$f["monto"]);
			$xml->add_nodo('nro_cuota',$f["nro_cuota"]);
			$xml->add_nodo('tipo_pago',$f["tipo_pago"]);
			$xml->add_nodo('precio_total',$f["precio_total"]);
			$xml->add_nodo('pagado',$f["pagado"]);
			$xml->add_nodo('falta_pagar',$f["falta_pagar"]);
			$xml->add_nodo('num_pagos',$f["num_pagos"]);
			$xml->add_nodo('fecha_pagado',$f["fecha_pagado"]);			
			$fecha_sep = explode('-',$f["fecha_reg_cotizacion"]);
			$fecha = $fecha_sep[2]."/".$fecha_sep[1]."/".$fecha_sep[0];
			$xml->add_nodo('fecha_reg_cotizacion',$fecha);
			$xml->add_nodo('por_anticipo',$f["por_anticipo"]);
			$xml->add_nodo('por_retgar',$f["por_retgar"]);
			$xml->add_nodo('pagado_anticipo',$f["pagado_anticipo"]);
			
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