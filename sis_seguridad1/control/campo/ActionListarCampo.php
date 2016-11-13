<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCampo.php
Propósito:				Permite realizar el listado en tsg_campo
Tabla:					t_tsg_campo
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-30 10:36:38
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloSeguridad.php');

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = 'ActionListarCampo .php';

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

	if($sort == '') $sortcol = 'id_campo';
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
	
	$cond->add_criterio_extra("TABCON_2.id_tabla",$m_id_tabla);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Campo');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarCampo($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCampo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_campo',$f["id_campo"]);
			$xml->add_nodo('nombre',$f["nombre"]);
			$xml->add_nodo('id_tabla',$f["id_tabla"]);
			$xml->add_nodo('desc_tabla',$f["desc_tabla"]);
			$xml->add_nodo('nombre_metaproceso',$f["nombre_metaproceso"]);
			$xml->add_nodo('descripcion_metaproceso',$f["descripcion_metaproceso"]);
			$xml->add_nodo('nombre_tabla',$f["nombre_tabla"]);
			$xml->add_nodo('funcion_grupo',$f["funcion_grupo"]);
			$xml->add_nodo('label',$f["label"]);
			$xml->add_nodo('width_reporte',$f["width_reporte"]);
			$xml->add_nodo('funcion',$f["funcion"]);
			$xml->add_nodo('casting',$f["casting"]);
			$xml->add_nodo('filtro',$f["filtro"]);
			$xml->add_nodo('filtro_grupo',$f["filtro_grupo"]);
			$xml->add_nodo('formulario',$f["formulario"]);
			$xml->add_nodo('grupo',$f["grupo"]);
			$xml->add_nodo('dato_descriptivo',$f["dato_descriptivo"]);
			$xml->add_nodo('grid_indice',$f["grid_indice"]);

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