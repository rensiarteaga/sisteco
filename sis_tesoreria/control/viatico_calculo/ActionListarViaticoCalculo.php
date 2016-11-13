<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarViaticoCalculo.php
Propósito:				Permite realizar el listado en tts_viatico_calculo
Tabla:					tts_tts_viatico_calculo
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2009-04-16 11:37:06
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloTesoreria.php');

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = 'ActionListarViaticoCalculo .php';

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

	if($sort == '') $sortcol = 'id_viatico_calculo';
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
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'id_viatico_calculo');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarViaticoCalculo($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarViaticoCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	//inicializamos las variables de los totales
	$total_nro_dias=0;
	$total_total_pasaje=0;
	$total_total_viaticos=0;
	$total_total_hotel=0;
	$total_importe_otros=0;
	$total_total_general=0;
	$total_importe_retencion=0;	
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_viatico_calculo',$f["id_viatico_calculo"]);
			$xml->add_nodo('id_viatico',$f["id_viatico"]);
			$xml->add_nodo('id_origen',$f["id_origen"]);
			$xml->add_nodo('lugar_origen',$f["lugar_origen"]);
			$xml->add_nodo('id_destino',$f["id_destino"]);
			$xml->add_nodo('lugar_destino',$f["lugar_destino"]);
			$xml->add_nodo('tipo_destino',$f["tipo_destino"]);
			$xml->add_nodo('id_cobertura',$f["id_cobertura"]);
			$xml->add_nodo('desc_cobertura',$f["desc_cobertura"]);
			$xml->add_nodo('id_entidad',$f["id_entidad"]);
			$xml->add_nodo('nombre_entidad',$f["nombre_entidad"]);
			$xml->add_nodo('fecha_inicio',$f["fecha_inicio"]);
			$xml->add_nodo('fecha_final',$f["fecha_final"]);
			$xml->add_nodo('hora_inicio',$f["hora_inicio"]);
			$xml->add_nodo('hora_final',$f["hora_final"]);
			$xml->add_nodo('nro_dias',$f["nro_dias"]);
			$xml->add_nodo('importe_pasaje',$f["importe_pasaje"]);
			$xml->add_nodo('importe_viatico',$f["importe_viatico"]);
			$xml->add_nodo('importe_hotel',$f["importe_hotel"]);
			$xml->add_nodo('importe_otros',$f["importe_otros"]);
			$xml->add_nodo('total_pasaje',$f["total_pasaje"]);
			$xml->add_nodo('total_viaticos',$f["total_viaticos"]);
			$xml->add_nodo('total_hotel',$f["total_hotel"]);
			$xml->add_nodo('total_general',$f["total_general"]);
			$xml->add_nodo('tipo_transporte',$f["tipo_transporte"]);
			$xml->add_nodo('importe_retencion',$f["importe_retencion"]);
			$xml->add_nodo('tipo_registro',$f["tipo_registro"]);
			$xml->add_nodo('tipo_viaje',$f["tipo_viaje"]);
			$xml->add_nodo('detalle_viaticos',$f["detalle_viaticos"]);
			$xml->add_nodo('detalle_otros',$f["detalle_otros"]);

			$xml->fin_rama();
			
			//sumamos los valores de todos los registros listados
			$total_nro_dias=$total_nro_dias+$f["nro_dias"];
			$total_total_pasaje=$total_total_pasaje+$f["total_pasaje"];
			$total_total_viaticos=$total_total_viaticos+$f["total_viaticos"];
			$total_total_hotel=$total_total_hotel+$f["total_hotel"];
			$total_importe_otros=$total_importe_otros+$f["importe_otros"];
			$total_total_general=$total_total_general+$f["total_general"];
			$total_importe_retencion=$total_importe_retencion+$f["importe_retencion"];
		}
		
		//adicionamos la ultima fila de totales al listado de la grilla
		if($total_registros>0)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_viatico_calculo',"0");
			$xml->add_nodo('id_viatico',"0");
			$xml->add_nodo('id_origen',"");
			$xml->add_nodo('lugar_origen',"T O T A L E S");
			$xml->add_nodo('id_destino',"0");
			$xml->add_nodo('lugar_destino',"");
			$xml->add_nodo('tipo_destino',"");
			$xml->add_nodo('id_cobertura',"0");
			$xml->add_nodo('desc_cobertura',"");
			$xml->add_nodo('id_entidad',"0");
			$xml->add_nodo('nombre_entidad',"");
			$xml->add_nodo('fecha_inicio',"");
			$xml->add_nodo('fecha_final',"");
			$xml->add_nodo('hora_inicio',"");
			$xml->add_nodo('hora_final',"");
			$xml->add_nodo('nro_dias',number_format($total_nro_dias,0,',','.'));
			$xml->add_nodo('importe_pasaje',"");
			$xml->add_nodo('importe_viatico',"");
			$xml->add_nodo('importe_hotel',"");
			$xml->add_nodo('importe_otros',number_format($total_importe_otros,2,',','.'));
			$xml->add_nodo('total_pasaje',number_format($total_total_pasaje,2,',','.'));
			$xml->add_nodo('total_viaticos',number_format($total_total_viaticos,2,',','.'));
			$xml->add_nodo('total_hotel',number_format($total_total_hotel,2,',','.'));
			$xml->add_nodo('total_general',number_format($total_total_general,2,',','.'));
			$xml->add_nodo('tipo_transporte',"");
			$xml->add_nodo('importe_retencion',number_format($total_importe_retencion,2,',','.'));
			$xml->add_nodo('tipo_registro',"");
			$xml->add_nodo('tipo_viaje',"");
			$xml->add_nodo('detalle_viaticos',"");
			$xml->add_nodo('detalle_otros',"");				
			
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