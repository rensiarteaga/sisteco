<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarMetaproceso.php
Propósito:				Permite realizar el listado en tsg_metaproceso
Tabla:					t_tsg_metaproceso
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2007-10-26 16:42:28
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloSeguridad.php');

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = 'ActionListarMetaproceso .php';

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

	if($sort == '') $sortcol = 'id_metaproceso';
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
		
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Metaproceso');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarMetaproceso($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_metaproceso',$f["id_metaproceso"]);
			$xml->add_nodo('id_subsistema',$f["id_subsistema"]);
			$xml->add_nodo('desc_subsistema',$f["desc_subsistema"]);
			$xml->add_nodo('fk_id_metaproceso',$f["fk_id_metaproceso"]);
			$xml->add_nodo('desc_metaproceso',$f["desc_metaproceso"]);
			$xml->add_nodo('nivel',$f["nivel"]);
			$xml->add_nodo('nombre',$f["nombre"]);
			$xml->add_nodo('codigo_procedimiento',$f["codigo_procedimiento"]);
			$xml->add_nodo('nombre_achivo',$f["nombre_achivo"]);
			$xml->add_nodo('ruta_archivo',$f["ruta_archivo"]);
			$xml->add_nodo('fecha_registro',$f["fecha_registro"]);
			$xml->add_nodo('hora_registro',$f["hora_registro"]);
			$xml->add_nodo('fecha_ultima_modificacion',$f["fecha_ultima_modificacion"]);
			$xml->add_nodo('hora_ultima_modificacion',$f["hora_ultima_modificacion"]);
			$xml->add_nodo('descripcion',$f["descripcion"]);
			$xml->add_nodo('visible',$f["visible"]);
			$xml->add_nodo('habilitar_log',$f["habilitar_log"]);
			$xml->add_nodo('orden_logico',$f["orden_logico"]);
			$xml->add_nodo('icono',$f["icono"]);
			$xml->add_nodo('nombre_tabla',$f["nombre_tabla"]);
			$xml->add_nodo('prefijo',$f["prefijo"]);
			$xml->add_nodo('codigo_base',$f["codigo_base"]);
			$xml->add_nodo('tipo_vista',$f["tipo_vista"]);
			$xml->add_nodo('con_ep',$f["con_ep"]);
			$xml->add_nodo('con_interfaz',$f["con_interfaz"]);
			$xml->add_nodo('num_datos_hijo',$f["num_datos_hijo"]);

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