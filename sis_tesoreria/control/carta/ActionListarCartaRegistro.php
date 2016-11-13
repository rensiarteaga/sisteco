<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCartaRegistro.php
Propósito:				Permite realizar el listado en tts_carta
Tabla:					tts_tts_carta
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-11-18 20:39:05
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloTesoreria.php');

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = 'ActionListarCartaRegistro .php';

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

	if($sort == '') $sortcol = 'id_carta';
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
	if($m_id_carta!=''){
		$cond->add_criterio_extra("CARTA.fk_carta",$m_id_carta);
		
	}
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	if($sw_estado==1){
		$criterio_filtro=$criterio_filtro." AND CARTA.estado_carta=1 AND CARTA.importe_pagado=0.00";
	}
	if($sw_estado==2){
		$criterio_filtro=$criterio_filtro." AND CARTA.estado_carta=1 AND CARTA.fk_carta is null";
	}
	if($sw_estado==3){
		$criterio_filtro=$criterio_filtro." AND (CARTA.estado_carta=3 OR CARTA.estado_carta=4)";
	}
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Carta');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarCartaRegistro($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCartaRegistro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_carta',$f["id_carta"]);//id_carta
			$xml->add_nodo('id_fina_regi_prog_proy_acti',$f["id_fina_regi_prog_proy_acti"]);//id_fina_regi_prog_proy_acti
			$xml->add_nodo('id_unidad_organizacional',$f["id_unidad_organizacional"]);//id_unidad_organizacional
			$xml->add_nodo('desc_unidad_organizacional',$f["desc_unidad_organizacional"]);//desc_unidad_organizacional
			$xml->add_nodo('id_moneda',$f["id_moneda"]);//id_moneda
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);//desc_moneda
			$xml->add_nodo('clase_carta',$f["clase_carta"]);//clase_carta
			$xml->add_nodo('tipo_carta',$f["tipo_carta"]);//tipo_carta
			$xml->add_nodo('estado_carta',$f["estado_carta"]);//estado_carta
			$xml->add_nodo('id_cuenta_bancaria',$f["id_cuenta_bancaria"]);//id_cuenta_bancaria
			$xml->add_nodo('nro_cuenta_banco_cuenta_bancaria',$f["nro_cuenta_banco_cuenta_bancaria"]);//nro_cuenta_banco_cuenta_bancaria
			$xml->add_nodo('desc_cuenta_bancaria_inst',$f["desc_cuenta_bancaria_inst"]);//desc_cuenta_bancaria
			$xml->add_nodo('nombre_institucion',$f["nombre_institucion"]);
			$xml->add_nodo('nro_cuenta_banco_cuenta_bancaria',$f["nro_cuenta_banco_cuenta_bancaria"]);
			$xml->add_nodo('id_institucion',$f["id_institucion"]);//id_institucion
			$xml->add_nodo('desc_institucion',$f["desc_institucion"]);//desc_institucion
			$xml->add_nodo('id_proveedor',$f["id_proveedor"]);//id_proveedor
			$xml->add_nodo('desc_proveedor',$f["desc_proveedor"]);//
			$xml->add_nodo('fecha_inicio',$f["fecha_inicio"]);//fecha_inicio
			$xml->add_nodo('fecha_vence',$f["fecha_vence"]);//fecha_vence
			$xml->add_nodo('obs_carta',$f["obs_carta"]);//obs_carta
			$xml->add_nodo('importe_carta',$f["importe_carta"]);//importe_carta
			$xml->add_nodo('importe_pagado',$f["importe_pagado"]);//importe_pagado
			$xml->add_nodo('id_cheque',$f["id_cheque"]);//id_cheque
			$xml->add_nodo('nombre_cheque_cheque',$f["nombre_cheque_cheque"]);//nombre_cheque_cheque
			$xml->add_nodo('nro_cheque_cheque',$f["nro_cheque_cheque"]);//nro_cheque_cheque
			$xml->add_nodo('fecha_cheque_cheque',$f["fecha_cheque_cheque"]);//fecha_cheque_cheque
			$xml->add_nodo('desc_cheque',$f["desc_cheque"]);//desc_cheque
			$xml->add_nodo('id_comprobante',$f["id_comprobante"]);//id_comprobante
			$xml->add_nodo('desc_comprobante',$f["desc_comprobante"]);//desc_comprobante
			$xml->add_nodo('desc_carta',$f["desc_carta"]);//desc_carta
			$xml->add_nodo('fk_carta',$f["fk_carta"]);//fk_carta
			$xml->add_nodo('id_financiador',$f["id_financiador"]);
			$xml->add_nodo('id_regional',$f["id_regional"]);
			$xml->add_nodo('id_programa',$f["id_programa"]);
			$xml->add_nodo('id_proyecto',$f["id_proyecto"]);
			$xml->add_nodo('id_actividad',$f["id_actividad"]);
			$xml->add_nodo('nombre_financiador',$f["nombre_financiador"]);
			$xml->add_nodo('nombre_regional',$f["nombre_regional"]);
			$xml->add_nodo('nombre_programa',$f["nombre_programa"]);
			$xml->add_nodo('nombre_proyecto',$f["nombre_proyecto"]);
			$xml->add_nodo('nombre_actividad',$f["nombre_actividad"]);
			$xml->add_nodo('codigo_financiador',$f["codigo_financiador"]);
			$xml->add_nodo('codigo_regional',$f["codigo_regional"]);
			$xml->add_nodo('codigo_programa',$f["codigo_programa"]);
			$xml->add_nodo('codigo_proyecto',$f["codigo_proyecto"]);
			$xml->add_nodo('codigo_actividad',$f["codigo_actividad"]);

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