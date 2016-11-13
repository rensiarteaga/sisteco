<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDetalleViatico.php
Prop�sito:				Permite realizar el listado en tts_cuenta_doc_det
Tabla:					t_tts_cuenta_doc_det
Par�metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci�n:		2009-10-27 10:40:43
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloTesoreria.php');

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = 'ActionListarDetalleViatico .php';

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

	if($sort == '') $sortcol = 'id_cuenta_doc_det';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
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
	
	$cond->add_criterio_extra("CUDOC.id_cuenta_doc",$id_cuenta_doc);
	
	if($m_id_cuenta_doc_rendicion!=''){
		$cond->add_criterio_extra("CUEREN.id_cuenta_doc_rendicion",$m_id_cuenta_doc_rendicion);
	}
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'CuentaDocDet');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarDetalleViatico($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	$total_importe=0;
	$total_importe_entregado=0;
	$total_importe2=0;
	$total_importe_entregado2=0;
	
	$res2 = $Custom->ListarImportesTotalesRendicionDet($cant,$puntero,'CUDOC.id_cuenta_doc asc, CUEREN.id_cuenta_doc_rendicion ',$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res2)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$id_cuenta_doc=$f["id_cuenta_doc"];
			$id_cuenta_doc_rendicion=$f["id_cuenta_doc_rendicion"];
			$total_importe2=$f["importe"];	
			$total_importe_entregado2=$f["importe_entregado"];	
			
			$total_importe=$total_importe+$total_importe2;
			$total_importe_entregado=$total_importe_entregado+$total_importe_entregado2;
				
		}
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
	
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarDetalleViatico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_cuenta_doc_det',$f["id_cuenta_doc_det"]);
			$xml->add_nodo('id_cuenta_doc',$f["id_cuenta_doc"]);
			$xml->add_nodo('id_concepto_ingas',$f["id_concepto_ingas"]);
			$xml->add_nodo('desc_concepto_ingas',$f["desc_concepto_ingas"]);
			$xml->add_nodo('id_presupuesto',$f["id_presupuesto"]);
			$xml->add_nodo('desc_presupuesto',$f["desc_presupuesto"]);
			$xml->add_nodo('cantidad',$f["cantidad"]);
			$xml->add_nodo('tipo_transporte',$f["tipo_transporte"]);
			$xml->add_nodo('importe',$f["importe"]);
			$xml->add_nodo('importe_entregado',$f["importe_entregado"]);
			$xml->add_nodo('id_tipo_destino',$f["id_tipo_destino"]);
			$xml->add_nodo('desc_tipo_destino',$f["desc_tipo_destino"]);
			$xml->add_nodo('id_cobertura',$f["id_cobertura"]);
			$xml->add_nodo('desc_cobertura',$f["desc_cobertura"]);
			$xml->add_nodo('observaciones',$f["observaciones"]);
			$xml->add_nodo('id_cuenta_doc_rendicion',$f["id_cuenta_doc_rendicion"]);
			$xml->add_nodo('id_orden_trabajo',$f["id_orden_trabajo"]);
			$xml->add_nodo('desc_orden_trabajo',$f["desc_orden_trabajo"]);
			$xml->add_nodo('entrega_importe',$f["entrega_importe"]);
			$xml->add_nodo('nombre_item',$f["nombre_item"]);
            $xml->add_nodo('nombre_servicio',$f["nombre_servicio"]);
            $xml->add_nodo('id_solicitud_compra',$f["id_solicitud_compra"]);
            $xml->add_nodo('desc_conce_item_serv',$f["desc_concepto_ingas"].$f["nombre_item"].$f["nombre_servicio"]);
            
            $xml->add_nodo('id_partida',$f["id_partida"]);
			$xml->add_nodo('desc_partida',$f["desc_partida"]);
			$xml->add_nodo('id_cuenta',$f["id_cuenta"]);
			$xml->add_nodo('desc_cuenta',$f["desc_cuenta"]);
			$xml->add_nodo('id_auxiliar',$f["id_auxiliar"]);
			$xml->add_nodo('desc_auxiliar',$f["desc_auxiliar"]);
			$xml->add_nodo('id_categoria',$f["id_categoria"]);
			$xml->add_nodo('desc_categoria',$f["desc_categoria"]);
			$xml->add_nodo('id_parametro',$f["id_parametro"]);
			$xml->add_nodo('desc_parametro',$f["desc_parametro"]);
			$xml->add_nodo('fecha_ini',$f["fecha_ini"]);
			$xml->add_nodo('fecha_fin',$f["fecha_fin"]);
			$xml->add_nodo('cantidad_dias_ant',$f["cantidad_dias_ant"]);
			$xml->fin_rama();
			
			//$total_importe=$total_importe+$f["importe"];
		}
		
		//adicionamos la ultima fila de totales al listado de la grilla
		if($total_registros>0)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_cuenta_doc_det',"");
			$xml->add_nodo('id_cuenta_doc',"");
			$xml->add_nodo('id_concepto_ingas',"");
			$xml->add_nodo('desc_concepto_ingas',"");
			$xml->add_nodo('id_presupuesto',"");
			$xml->add_nodo('desc_presupuesto',"");
			$xml->add_nodo('cantidad',"");
			$xml->add_nodo('tipo_transporte',"T O T A L E S :");
			$xml->add_nodo('importe',number_format($total_importe,2,',','.'));
			$xml->add_nodo('importe_entregado',number_format($total_importe_entregado,2,',','.'));
			$xml->add_nodo('id_tipo_destino',"");
			$xml->add_nodo('desc_tipo_destino',"");
			$xml->add_nodo('id_cobertura',"");
			$xml->add_nodo('desc_cobertura',"");
			$xml->add_nodo('observaciones',"");
			$xml->add_nodo('id_cuenta_doc_rendicion',"");
			$xml->add_nodo('entrega_importe',"");	
			
			$xml->add_nodo('id_partida',"");
			$xml->add_nodo('desc_partida',"");
			$xml->add_nodo('id_cuenta',"");
			$xml->add_nodo('desc_cuenta',"");
			$xml->add_nodo('id_auxiliar',"");
			$xml->add_nodo('desc_auxiliar',"");
			$xml->add_nodo('id_categoria',"");
			$xml->add_nodo('desc_categoria',"");
			$xml->add_nodo('id_parametro',"");
			$xml->add_nodo('desc_parametro',"");
			$xml->add_nodo('fecha_ini',"");
			$xml->add_nodo('fecha_fin',"");
			$xml->add_nodo('cantidad_dias_ant',"");		
			
			//T O T A L :
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