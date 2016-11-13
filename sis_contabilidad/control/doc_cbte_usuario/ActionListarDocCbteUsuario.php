<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDocCbteUsuario.php
Propósito:				Permite realizar el listado en tct_doc_cbte_usuario
Tabla:					tct_tct_doc_cbte_usuario
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2011-03-15 10:46:11
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloContabilidad.php');

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarDocCbteUsuario.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 30;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_doc_cbte_usuario';
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
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'id_doc_cbte_usuario');
	$sortcol = $crit_sort->get_criterio_sort();
	if(isset($m_id_periodo_subsistema)){$criterio_filtro=$criterio_filtro." and   dcuser.id_periodo_subsistema=$m_id_periodo_subsistema";}
     	
	//Obtiene el total de los registros
	$res = $Custom -> ContarDocCbteUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarDocCbteUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('documento',$f["documento"]);
			$xml->add_nodo('desc_persona',$f["desc_persona"]);			
			$xml->add_nodo('titulo_cbte',$f["titulo_cbte"]);
			$xml->add_nodo('desc_clase',$f["desc_clase"]);
			$xml->add_nodo('sw_validacion',$f["sw_validacion"]);
			$xml->add_nodo('sw_edicion',$f["sw_edicion"]);
			///
			$xml->add_nodo('id_doc_cbte_usuario',$f["id_doc_cbte_usuario"]);
			$xml->add_nodo('id_documento',$f["id_documento"]);
			$xml->add_nodo('id_clase_cbte',$f["id_clase_cbte"]);
			$xml->add_nodo('id_usuario',$f["id_usuario"]);
			$xml->add_nodo('id_periodo_subsistema',$f["id_periodo_subsistema"]);
			
			
			
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