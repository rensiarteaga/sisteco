<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCuentaDocRendicion.php
Propósito:				Permite realizar el listado en tts_devengado_detalle
Tabla:					t_tts_cuenta_doc_rendicion
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		29/10/2009
Versión:				1.0.0
Autor:					RCM
**********************************************************
*/
session_start();
include_once('../LibModeloTesoreria.php');

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = 'ActionListarCuentaDocRendicion.php';

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

	if($sort == '') $sortcol = 'CUEREN.id_cuenta_doc_rendicion';
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
	
	$cond->add_criterio_extra("CUEDOC.id_cuenta_doc",$m_id_cuenta_doc);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'CuentaDocRendicionReg');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarCuentaDocRendicion($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;
	
	$total_importe_total=0;
	$total_importe_total_ren=0;
	$total_importe_ice=0;
	$total_importe_exento=0;
	$total_importe_sujeto=0;
	$total_importe_credito=0;
	$total_importe_iue=0;
	$total_importe_it=0;
	//$total_importe_debito=0;	
	$total_importe_rendicion=0; //importe_liquido
	$contador=0;
	
	// /*
	$res2 = $Custom->ListarImportesTotalesRendicion($cant,$puntero,'CUEREN.id_cuenta_doc',$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res2)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$id_cuenta_doc=$f["id_cuenta_doc"];
			$total_importe_total=$f["importe_total"];
			$total_importe_total_ren=$f["importe_total_ren"];
			$total_importe_ice=$f["importe_ice"];
			$total_importe_exento=$f["importe_exento"];
			$total_importe_sujeto=$f["importe_sujeto"];
			$total_importe_credito=$f["importe_credito"];
			$total_importe_iue=$f["importe_iue"];
			$total_importe_it=$f["importe_it"];
			//$total_importe_debito=$f["importe_debito"];
			$total_importe_rendicion=$f["importe_rendicion"]; //importe_liquido
		}
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

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCuentaDocRendicion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$contador=$contador+1;
			
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_cuenta_doc_rendicion',$f["id_cuenta_doc_rendicion"]);
			$xml->add_nodo('id_cuenta_doc',$f["id_cuenta_doc"]);
			$xml->add_nodo('id_documento',$f["id_documento"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('id_transaccion',$f["id_transaccion"]);
			$xml->add_nodo('tipo_documento',$f["tipo_documento"]);
			$xml->add_nodo('nro_documento',$f["nro_documento"]);
			$xml->add_nodo('fecha_documento',$f["fecha_documento"]);
			$xml->add_nodo('razon_social',$f["razon_social"]);
			$xml->add_nodo('nro_nit',$f["nro_nit"]);
			$xml->add_nodo('nro_autorizacion',$f["nro_autorizacion"]);
			$xml->add_nodo('codigo_control',$f["codigo_control"]);
			$xml->add_nodo('poliza_dui',$f["poliza_dui"]);
			$xml->add_nodo('formulario',$f["formulario"]);
			$xml->add_nodo('tipo_retencion',$f["tipo_retencion"]);
			$xml->add_nodo('estado_documento',$f["estado_documento"]);
			$xml->add_nodo('id_documento_valor',$f["id_documento_valor"]);
			$xml->add_nodo('importe_total',$f["importe_total"]);
			$xml->add_nodo('importe_ice',$f["importe_ice"]);
			$xml->add_nodo('importe_exento',$f["importe_exento"]);
			$xml->add_nodo('importe_sujeto',$f["importe_sujeto"]);
			$xml->add_nodo('importe_credito',$f["importe_credito"]);
			$xml->add_nodo('importe_iue',$f["importe_iue"]);
			$xml->add_nodo('importe_it',$f["importe_it"]);
			$xml->add_nodo('importe_debito',$f["importe_debito"]);
			$xml->add_nodo('desc_tipo_documento',$f["desc_tipo_documento"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
			$xml->add_nodo('importe_rendicion',$f["importe_rendicion"]);
			
			$xml->add_nodo('id_presupuesto',$f["id_presupuesto"]);
			$xml->add_nodo('desc_presupuesto',$f["desc_presupuesto"]);
			$xml->add_nodo('id_concepto_ingas',$f["id_concepto_inga"]);
			$xml->add_nodo('desc_concepto_ingas',$f["desc_concepto_ingas"]);
			$xml->add_nodo('id_orden_trabajo',$f["id_orden_trabajo"]);
			$xml->add_nodo('desc_orden_trabajo',$f["desc_orden_trabajo"]);
			$xml->add_nodo('importe_total_ren',$f["importe_total_ren"]);
			$xml->add_nodo('estado',$f["estado"]);
			
			$xml->add_nodo('id_partida',$f["id_partida"]);
			$xml->add_nodo('desc_partida',$f["desc_partida"]);
			$xml->add_nodo('id_cuenta',$f["id_cuenta"]);
			$xml->add_nodo('desc_cuenta',$f["desc_cuenta"]);
			$xml->add_nodo('id_auxiliar',$f["id_auxiliar"]);
			$xml->add_nodo('desc_auxiliar',$f["desc_auxiliar"]);
			$xml->add_nodo('id_parametro',$f["id_parametro"]);
			$xml->add_nodo('desc_parametro',$f["desc_parametro"]);
			$xml->add_nodo('fecha_ini',$f["fecha_ini"]);
			$xml->add_nodo('fecha_fin',$f["fecha_fin"]);
			$xml->add_nodo('sw_viatico',$f["sw_viatico"]);
			$xml->add_nodo('importe_retencion',$f["importe_retencion"]);
			
			$xml->add_nodo('contador',number_format($contador,0,',','.'));
			$xml->fin_rama();
			
			/*$total_importe_total=$total_importe_total+$f["importe_total"];
			$total_importe_total_ren=$total_importe_total_ren+$f["importe_total_ren"];
			$total_importe_ice=$total_importe_ice+$f["importe_ice"];
			$total_importe_exento=$total_importe_exento+$f["importe_exento"];
			$total_importe_sujeto=$total_importe_sujeto+$f["importe_sujeto"];
			$total_importe_credito=$total_importe_credito+$f["importe_credito"];
			$total_importe_iue=$total_importe_iue+$f["importe_iue"];
			$total_importe_it=$total_importe_it+$f["importe_it"];
			//$total_importe_debito=$total_importe_debito+$f["importe_debito"];
			$total_importe_rendicion=$total_importe_rendicion+$f["importe_rendicion"]; //importe_liquido*/
		}
		
		//adicionamos la ultima fila de totales al listado de la grilla
		if($total_registros>0)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_cuenta_doc_rendicion',"");
			$xml->add_nodo('id_cuenta_doc',"");
			$xml->add_nodo('id_documento',"");
			$xml->add_nodo('fecha_reg',"");
			$xml->add_nodo('id_transaccion',"");
			$xml->add_nodo('tipo_documento',"");
			$xml->add_nodo('nro_documento',"");
			$xml->add_nodo('fecha_documento',"");
			$xml->add_nodo('razon_social',"T O T A L E S:");
			$xml->add_nodo('nro_nit',"");
			$xml->add_nodo('nro_autorizacion',"");
			$xml->add_nodo('codigo_control',"");
			$xml->add_nodo('poliza_dui',"");
			$xml->add_nodo('formulario',"");
			$xml->add_nodo('tipo_retencion',"");
			$xml->add_nodo('estado_documento',"");
			$xml->add_nodo('id_documento_valor',"");
			$xml->add_nodo('importe_total',$total_importe_total);//number_format($total_importe_total,2,',','.'));
			$xml->add_nodo('importe_ice',$total_importe_ice);//number_format($total_importe_ice,2,',','.'));
			$xml->add_nodo('importe_exento',$total_importe_exento);//number_format($total_importe_exento,2,',','.'));
			$xml->add_nodo('importe_sujeto',$total_importe_sujeto);//number_format($total_importe_sujeto,2,',','.'));
			$xml->add_nodo('importe_credito',$total_importe_credito);//number_format($total_importe_credito,2,',','.'));
			$xml->add_nodo('importe_iue',$total_importe_iue);//number_format($total_importe_iue,2,',','.'));
			$xml->add_nodo('importe_it',$total_importe_it);//number_format($total_importe_it,2,',','.'));
			$xml->add_nodo('importe_debito',"");
			$xml->add_nodo('desc_tipo_documento',"");
			$xml->add_nodo('id_moneda',"");
			$xml->add_nodo('desc_moneda',"");
			$xml->add_nodo('importe_rendicion',$total_importe_rendicion);//number_format($total_importe_rendicion,2,',','.'));	//importe_liquido		
			
			$xml->add_nodo('id_presupuesto',"");
			$xml->add_nodo('desc_presupuesto',"");
			$xml->add_nodo('id_concepto_ingas',"");
			$xml->add_nodo('desc_concepto_ingas',"");
			$xml->add_nodo('id_orden_trabajo',"");
			$xml->add_nodo('desc_orden_trabajo',"");
			$xml->add_nodo('importe_total_ren',$total_importe_total_ren);//number_format($total_importe_total_ren,2,',','.'));
			$xml->add_nodo('estado',"");
			
			$xml->add_nodo('id_partida',"");
			$xml->add_nodo('desc_partida',"");
			$xml->add_nodo('id_cuenta',"");
			$xml->add_nodo('desc_cuenta',"");
			$xml->add_nodo('id_auxiliar',"");
			$xml->add_nodo('desc_auxiliar',"");	
			$xml->add_nodo('id_parametro',"");
			$xml->add_nodo('desc_parametro',"");
			$xml->add_nodo('fecha_ini',"");
			$xml->add_nodo('fecha_fin',"");	
			$xml->add_nodo('sw_viatico',"");	
			$xml->add_nodo('importe_retencion',"");
			$xml->add_nodo('contador',"");
			
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