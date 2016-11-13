<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDevengarServicios.php
Prop�sito:				Permite realizar el listado en tts_devengado
Tabla:					tts_tts_devengado
Par�metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci�n:		2008-10-21 15:43:27
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloTesoreria.php');

$Custom = new cls_CustomDBTesoreria();


$nombre_archivo = 'ActionListarDevengarServicios .php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
	//Par�metros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_devengado';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'desc';
	else $sortdir = $dir;

	//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
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

	//echo "sss: ".$tipoFormDev;
	//exit;

	//Verifica el tipo de coportamiento en funci�n de la bandera tipoFormDev
	if($tipoFormDev=='dev'){
		//Filtro para solo desplegar los devengados padre hasta antes de pasar a Solicitud de Pagos
		$criterio_filtro.=' AND fk_devengado IS NULL';
		$criterio_filtro.=' AND estado_devengado IN (1,2,3,7,8,14,15,16)';
		$criterio_filtro.=' AND id_cotizacion IS NULL';
	}
	elseif ($tipoFormDev=='pag'){
		//Filtro para desplegar s�lo los devengados padre para la Solicitud de Pagos
		$criterio_filtro.=' AND fk_devengado IS NULL';
		$criterio_filtro.=' AND estado_devengado IN (4,5,17,18)';
	}
	elseif ($tipoFormDev=='detpag'){
		//Filtro para desplegar los devengados hijos para generar los pagos
		$sortcol = 'id_devengado,fecha_devengado';
		$sortdir = 'asc';
		$criterio_filtro.=' AND fk_devengado='.$m_id_devengado;
	}
	elseif ($tipoFormDev=='fin'){
		//Filtro para desplegar los devengados padre que ya fueron pagados completamente
		$criterio_filtro.=' AND fk_devengado IS NULL';
		$criterio_filtro.=' AND estado_devengado IN (6,99)';
		//$criterio_filtro.=' AND (tipo_gen_pago = 1 OR tipo_gen_pago IS NULL)';
		$criterio_filtro.=' AND id_devengado NOT IN (SELECT DISTINCT
                     							     fk_devengado
                     								FROM tesoro.tts_devengado
                     								WHERE fk_devengado IS NOT NULL
                     								AND estado_devengado = 12
                     								AND tipo_gen_pago = 2)';
	}
	elseif($tipoFormDev=='aprob'){
		//Filtro para desplegar los prorrateos por devengado para su aprobaci�n
		$criterio_filtro.=' AND fk_devengado IS NULL';
		$criterio_filtro.=' AND estado_devengado IN (1,2,3)';
		$criterio_filtro.=' AND id_cotizacion IS NULL';
	}
	elseif($tipoFormDev=='desc'){
		//Filtro para desplegar los devengados padre ya pagados pero pendientes de descargo con documentos
		$criterio_filtro.=' AND fk_devengado IS NULL';
		$criterio_filtro.=' AND estado_devengado = 6';
		$criterio_filtro.=' AND id_devengado IN (SELECT DISTINCT
                     							fk_devengado
                     							FROM tesoro.tts_devengado
                     							WHERE fk_devengado IS NOT NULL
                     							AND estado_devengado = 12
                     							AND tipo_gen_pago = 2)';
	}

	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Devengado');
	$sortcol = $crit_sort->get_criterio_sort();


	//Obtiene el total de los registros
	$res = $Custom -> ContarDevengarServicios($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarDevengarServicios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_devengado',$f["id_devengado"]);
			$xml->add_nodo('id_concepto_ingas',$f["id_concepto_ingas"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('importe_devengado',$f["importe_devengado"]);
			$xml->add_nodo('importe_pagado',$f["importe_pagado"]);
			$xml->add_nodo('importe_saldo',$f["importe_saldo"]);
			$xml->add_nodo('estado_devengado',$f["estado_devengado"]);
			$xml->add_nodo('fk_devengado',$f["fk_devengado"]);
			$xml->add_nodo('id_proveedor',$f["id_proveedor"]);
			$xml->add_nodo('id_cheque',$f["id_cheque"]);
			$xml->add_nodo('id_comprobante',$f["id_comprobante"]);
			$xml->add_nodo('tipo_devengado',$f["tipo_devengado"]);
			$xml->add_nodo('fecha_devengado',$f["fecha_devengado"]);
			$xml->add_nodo('desc_concepto_ingas',$f["desc_concepto_ingas"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
			$xml->add_nodo('desc_proveedor',$f["desc_proveedor"]);
			$xml->add_nodo('desc_tipo_devengado',$f["desc_tipo_devengado"]);
			$xml->add_nodo('desc_estado_devengado',$f["desc_estado_devengado"]);
			$xml->add_nodo('tot_importe_det',$f["tot_importe_det"]);
			$xml->add_nodo('tot_porcentaje_det',$f["tot_porcentaje_det"]);
			$xml->add_nodo('nombre_pago',$f["nombre_pago"]);
			$xml->add_nodo('nro_cheque',$f["nro_cheque"]);
			$xml->add_nodo('fecha_cheque',$f["fecha_cheque"]);
			$xml->add_nodo('nombre_cheque',$f["nombre_cheque"]);
			$xml->add_nodo('estado_cheque',$f["estado_cheque"]);
			$xml->add_nodo('desc_estado_cheque',$f["desc_estado_cheque"]);
			$xml->add_nodo('importe_multa',$f["importe_multa"]);
			$xml->add_nodo('id_plan_pago',$f["id_plan_pago"]);
			$xml->add_nodo('id_cotizacion',$f["id_cotizacion"]);
			$xml->add_nodo('nivel_documento',$f["nivel_documento"]);
			$xml->add_nodo('banco',$f["banco"]);
			$xml->add_nodo('observaciones',$f["observaciones"]);
			$xml->add_nodo('id_depto',$f["id_depto"]);
			$xml->add_nodo('nombre_depto',$f["nombre_depto"]);
			$xml->add_nodo('id_empleado',$f["id_empleado"]);
			$xml->add_nodo('desc_empleado',$f["desc_empleado"]);
			$xml->add_nodo('nit',$f["nit"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('id_periodo_subsistema',$f["id_periodo_subsistema"]);
			$xml->add_nodo('tipo_gen_pago',$f["tipo_gen_pago"]);
			$xml->add_nodo('desc_tipo_gen_pago',$f["desc_tipo_gen_pago"]);
			$xml->add_nodo('obs_contabilidad',$f["obs_contabilidad"]);
			$xml->add_nodo('tipo_desembolso',$f["tipo_desembolso"]);
			$xml->add_nodo('id_cajero',$f["id_cajero"]);
			$xml->add_nodo('cajero',$f["cajero"]);
			$xml->add_nodo('id_caja',$f["id_caja"]);
			$xml->add_nodo('desc_caja',$f["desc_caja"]);
			$xml->add_nodo('id_emp_recep_caja',$f["id_emp_recep_caja"]);
			$xml->add_nodo('desc_emp_recep_caja',$f["desc_emp_recep_caja"]);
			$xml->add_nodo('id_moneda_cueban',$f["id_moneda_cueban"]);
			$xml->add_nodo('desc_periodo_subsistema',$f["desc_periodo_subsistema"]);
			$xml->add_nodo('entrega_doc',$f["entrega_doc"]);
			$xml->add_nodo('tipo_plantilla',$f["tipo_plantilla"]);
			$xml->add_nodo('desc_tipo_plantilla',$f["desc_tipo_plantilla"]);
			$xml->add_nodo('tipo_pago',$f["tipo_pago"]);
			$xml->add_nodo('id_cuenta_bancaria',$f["id_cuenta_bancaria"]);
			$xml->add_nodo('liquido_pagable',$f["liquido_pagable"]);
			$xml->add_nodo('sw_pago_comprometido',$f["sw_pago_comprometido"]);
			$xml->add_nodo('sw_solo_devengado',$f["sw_solo_devengado"]);
			$xml->add_nodo('id_comprobante_reg',$f["id_comprobante_reg"]);
			$xml->add_nodo('importe_otros_con',$f["importe_otros_con"]);
			$xml->add_nodo('importe_total',$f["importe_total"]);
			$xml->add_nodo('correl',$f["correl"]);
			$xml->add_nodo('id_planilla',$f["id_planilla"]);
			$xml->add_nodo('id_parametro',$f["id_parametro"]);
			$xml->add_nodo('gestion_pres',$f["gestion_pres"]);
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