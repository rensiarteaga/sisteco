<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarAlmacenEpVista.php
Propósito:				Permite desplegar kardex segun el almacen ep

Parámetros:				

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		20-11-2007
Versión:				1.0.0
Autor:					José Abraham MIta Huanca
**********************************************************
*/
session_start();
include_once('../jmh_LibModeloAlmacenes.php');
	

$Custom = new cls_CustomDBAlmacenes();


//$nombre_archivo = 'ActionListarAlmacenVista.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
	

	//Parámetros del filtro
	if($limit == "") $cant = 10;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

	if($sort == "") $sortcol = 'id_item';
	else $sortcol = $sort;

	if($dir == "") $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> "si", "no"
	switch ($cod)
	{
		case "si":
			$decodificar = true;
			break;
		case "no":
			$decodificar = false;
			break;
		default:
			$decodificar = true;
			break;
	}

	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	$cond->add_criterio_extra("id_almacen",$m_id_ep);
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	$criterio_filtro = $criterio_filtro ."AND id_fina_regi_prog_proy_acti=$id_ep";
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'AlmacenEpVista');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarAlmacenEpVista($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarAlmacenEpVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_item',$f["id_item"]);
			$xml->add_nodo('codigo',$f["codigo"]);
			$xml->add_nodo('descripcion',$f["descripcion"]);
			$xml->add_nodo('precio_venta_almacen',$f["precio_venta_almacen"]);
			$xml->add_nodo('costo_estimado',$f["costo_estimado"]);
			$xml->add_nodo('stock_min',$f["stock_min"]);
			$xml->add_nodo('observaciones',$f["observaciones"]);
			$xml->add_nodo('nivel_convertido',$f["nivel_convertido"]);
			$xml->add_nodo('estado_registro',$f["estado_registro"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('id_unidad_medida_base',$f["id_unidad_medida_base"]);
			$xml->add_nodo('id_id3',$f["id_id3"]);
			$xml->add_nodo('id_id2',$f["id_id2"]);
			$xml->add_nodo('id_id1',$f["id_id1"]);
			$xml->add_nodo('id_subgrupo',$f["id_subgrupo"]);
			$xml->add_nodo('id_grupo',$f["id_grupo"]);
			$xml->add_nodo('id_supergrupo',$f["id_supergrupo"]);
			$xml->add_nodo('nombre',$f["nombre"]);
			$xml->add_nodo('nombre_id3',$f["nombre_id3"]);
			$xml->add_nodo('nombre_id2',$f["nombre_id2"]);
			$xml->add_nodo('nombre_id1',$f["nombre_id1"]);
			$xml->add_nodo('nombre_subg',$f["nombre_subg"]);
			$xml->add_nodo('nombre_grupo',$f["nombre_grupo"]);
			$xml->add_nodo('nombre_supg',$f["nombre_supg"]);
			$xml->add_nodo('nombre_unid_base',$f["nombre_unid_base"]);
			$xml->add_nodo('total',$f["total"]);
			$xml->add_nodo('id_almacen_ep',$f["id_almacen_ep"]);
			$xml->add_nodo('id_fina_regi_prog_proy_acti',$f["id_fina_regi_prog_proy_acti"]);
		
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