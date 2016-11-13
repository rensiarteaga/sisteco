<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarRendicionViaticos.php
Propósito:				Permite realizar el listado en tts_viatico_rinde
Tabla:					t_tts_viatico_rinde
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-11-27 12:11:24
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloTesoreria.php');

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = 'ActionListarRendicionViaticos .php';

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

	if($sort == '') $sortcol = 'fecha_documento';
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
	
	$cond->add_criterio_extra("VIATIC.id_viatico",$id_viatico);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'ViaticoRinde');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarRendicionViaticos($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarRendicionViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	$total_importe_rendicion=0;
	$total_importe_documento=0;
	$contador=0;
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$contador=$contador+1;
			
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_viatico_rinde',$f["id_viatico_rinde"]);
			$xml->add_nodo('id_viatico',$f["id_viatico"]);
			$xml->add_nodo('tipo_documento',$f["tipo_documento"]);
			$xml->add_nodo('desc_plantilla',$f["desc_plantilla"]);
			$xml->add_nodo('nro_documento',$f["nro_documento"]);
			$xml->add_nodo('fecha_documento',$f["fecha_documento"]);
			$xml->add_nodo('razon_social',$f["razon_social"]);
			$xml->add_nodo('nro_nit',$f["nro_nit"]);
			$xml->add_nodo('nro_autorizacion',$f["nro_autorizacion"]);
			$xml->add_nodo('codigo_control',$f["codigo_control"]);
			$xml->add_nodo('id_concepto_ingas',$f["id_concepto_ingas"]);
			$xml->add_nodo('desc_concepto_ingas',$f["desc_concepto_ingas"]);
			$xml->add_nodo('importe_rendicion',$f["importe_rendicion"]);
			$xml->add_nodo('importe_documento',$f["importe_documento"]);
			$xml->add_nodo('id_presupuesto',$f["id_presupuesto"]);
			$xml->add_nodo('desc_presupuesto',$f["desc_presupuesto"]);
			
			$xml->add_nodo('id_transaccion',$f["id_transaccion"]);
			$xml->add_nodo('id_partida_ejecucion',$f["id_partida_ejecucion"]);		
			$xml->add_nodo('estado_rendicion',$f["estado_rendicion"]);
			$xml->add_nodo('descripcion',$f["descripcion"]);
			$xml->add_nodo('contador',number_format($contador,0,',','.'));	

			$xml->fin_rama();
			
			$total_importe_rendicion=$total_importe_rendicion+$f["importe_rendicion"];
			$total_importe_documento=$total_importe_documento+$f["importe_documento"];
		}
		
		//adicionamos la ultima fila de totales al listado de la grilla
		if($total_registros>0)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_viatico_rinde',"");
			$xml->add_nodo('id_viatico',"");
			$xml->add_nodo('tipo_documento',"");
			$xml->add_nodo('desc_plantilla',"");
			$xml->add_nodo('nro_documento',"");
			$xml->add_nodo('fecha_documento',"");
			$xml->add_nodo('razon_social',"");
			$xml->add_nodo('nro_nit',"");
			$xml->add_nodo('nro_autorizacion',"");
			$xml->add_nodo('codigo_control',"");
			$xml->add_nodo('id_concepto_ingas',"");
			$xml->add_nodo('desc_concepto_ingas',"");
			$xml->add_nodo('importe_rendicion',number_format($total_importe_rendicion,2,',','.'));
			$xml->add_nodo('importe_documento',number_format($total_importe_documento,2,',','.'));
			$xml->add_nodo('id_presupuesto',"");
			$xml->add_nodo('desc_presupuesto',"T O T A L :");
			
			$xml->add_nodo('id_transaccion',"");
			$xml->add_nodo('id_partida_ejecucion',"");		
			$xml->add_nodo('estado_rendicion',"");	
			$xml->add_nodo('descripcion',"");

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