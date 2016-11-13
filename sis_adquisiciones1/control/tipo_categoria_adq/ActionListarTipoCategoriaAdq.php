<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarTipoCategoriaAdq.php
Propósito:				Permite realizar el listado en tad_tipo_categoria_adq
Tabla:					t_tad_tipo_categoria_adq
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-12 10:18:00
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionListarTipoCategoriaAdq .php';

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

	if($sort == ''){
		$sw=0;
		$sortcol = 'CATADQ.norma desc, CATADQ.precio_min';
	}
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
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	if($m_id_tipo_categoria_adq>0){
	    $criterio_filtro=$criterio_filtro." AND TIPCAT.id_tipo_categoria_adq=$m_id_tipo_categoria_adq";
	}
	if($tipo=='sol'){
	    $criterio_filtro=$criterio_filtro." AND lower(TIPCAT.tipo)=''solicitud''";
	}
	//Obtiene el criterio de orden de columnas
	//$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'TipoCategoriaAdq');
	//$sortcol = $crit_sort->get_criterio_sort();
	
	
	$sortcol= $sortcol.' '.$sortdir;
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarTipoCategoriaAdq($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarTipoCategoriaAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_tipo_categoria_adq',$f["id_tipo_categoria_adq"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('id_categoria_adq',$f["id_categoria_adq"]);
			$xml->add_nodo('desc_categoria_adq',$f["desc_categoria_adq"]);
			$xml->add_nodo('estado_categoria',$f["estado_categoria"]);
			$xml->add_nodo('tipo',$f["tipo"]);
			$xml->add_nodo('nombre',$f["nombre"]);
			$xml->add_nodo('precio_min',$f["precio_min"]);
			$xml->add_nodo('precio_max',$f["precio_max"]);
			$xml->add_nodo('doc_respaldo',$f["doc_respaldo"]);
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