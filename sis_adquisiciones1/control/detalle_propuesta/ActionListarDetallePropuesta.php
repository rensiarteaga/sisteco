<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDetallePropuesta.php
Propósito:				Permite realizar el listado en tad_detalle_propuesta
Tabla:					t_tad_detalle_propuesta
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2009-02-03 11:26:29
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionListarDetallePropuesta .php';

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

	if($sort == '') $sortcol = 'id_detalle_propuesta';
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
	
	$cond->add_criterio_extra("id_cotizacion_det",$id_cotizacion_det);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	//$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'DetallePropuesta');
	
	
	
	if($sortcol=='res_desc'){
		$sortcol='ITEM.descripcion, DETPROP.nombre  '.$sortdir;
	}
	elseif ($sortcol=='precio_total'){
		
		$sortcol='DETPROP.precio '.$sortdir;
	}
	else {
		$sortcol=$sortcol.' '.$sortdir;
		
	}
	
	
	//$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarDetallePropuesta($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarDetallePropuesta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_detalle_propuesta',$f["id_detalle_propuesta"]);
			$xml->add_nodo('id_cotizacion_det',$f["id_cotizacion_det"]);
			$xml->add_nodo('desc_cotizacion_det',$f["desc_cotizacion_det"]);
			$xml->add_nodo('id_item',$f["id_item"]);
			
			$xml->add_nodo('desc_item',$f["desc_item"]);
			$xml->add_nodo('id_servicio',$f["id_servicio"]);
			$xml->add_nodo('desc_servicio',$f["desc_servicio"]);
			$xml->add_nodo('precio',round($f["precio"],6));
			$xml->add_nodo('cantidad',round($f["cantidad"],2));
			
			//$xml->add_nodo('precio_total',round($f["precio"]*$f["cantidad"] * 1000000) / 1000000 );
			
			$xml->add_nodo('precio_total',round($f["precio"]*$f["cantidad"],6));
		
			
			
			$xml->add_nodo('descripcion',$f["descripcion"]);
			$xml->add_nodo('nombre',$f["nombre"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('id_item_solicitado',$f["id_item_solicitado"]);
			$xml->add_nodo('desc_item',$f["desc_item"]);
			$xml->add_nodo('id_servicio_solicitado',$f["id_servicio_solicitado"]);
			$xml->add_nodo('desc_servicio',$f["desc_servicio"]);
			$xml->add_nodo('garantia',$f["garantia"]);
			$xml->add_nodo('observaciones',$f["observaciones"]);
			$xml->add_nodo('estado',$f["estado"]);
			
			
			if($f["estado"]=='registrado')
			{
				$xml->add_nodo('clasificado','no');
				$xml->add_nodo('codigo_item','No clasificado');				
				$xml->add_nodo('res_desc',$f["nombre"].': '.$f["descripcion"]);
				
				
			}
			else{
				
				$xml->add_nodo('clasificado','si');
				$xml->add_nodo('codigo_item',$f["codigo_item"]);			
				$xml->add_nodo('res_desc',$f["desc_item"]);
				
			}
            $xml->add_nodo('id_unidad_medida_base',$f["id_unidad_medida_base"]);
			$xml->add_nodo('desc_unidad_medida',$f["desc_unidad_medida"]);
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

    