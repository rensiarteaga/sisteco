<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarGrupoProcComMul.php
Propósito:				Permite realizar el listado en tad_grupo_sp_det
Tabla:					t_tad_grupo_sp_det
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-20 17:42:58
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionListarGrupoProcComMul .php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
	//Parámetros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '')$puntero=0;
	else $puntero=$start;

	if($sort == '') $sortcol='id_grupo_sp_det';
	else $sortcol=$sort;

	if($dir == '')$sortdir = 'asc';
	else $sortdir=$dir;

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

	if(isset($id_proceso_compra_det)){

		$cond->add_criterio_extra("PRCODE.id_proceso_compra_det",$id_proceso_compra_det);

	}

	if(isset($id_solicitud_compra_det)){
		$cond->add_criterio_extra("SOCODE.id_solicitud_compra_det",$id_solicitud_compra_det);
	}

	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'GrupoSpDet');
	$sortcol = $crit_sort->get_criterio_sort();


	//Obtiene el total de los registros
	$res = $Custom ->ContarGrupoProcDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_proceso_compra,$id_item,$id_servicio);;

	if($res) $total_registros= $Custom->salida;


	$res = $Custom->ListarGrupoProcDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_proceso_compra,$id_item,$id_servicio);


	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_grupo_sp_det',$f["id_grupo_sp_det"]);
			$xml->add_nodo('id_proceso_compra_det',$f["id_proceso_compra_det"]);
			$xml->add_nodo('id_solicitud_compra_det',$f["id_solicitud_compra_det"]);
			$xml->add_nodo('periodo',$f["periodo"]);
			$xml->add_nodo('num_solicitud',$f["num_solicitud"]);
			$xml->add_nodo('num_solicitud_sis',$f["num_solicitud_sis"]);
			$xml->add_nodo('cantidad_proc',$f["cantidad_proc"]);
			$xml->add_nodo('cantidad_sol',$f["cantidad_sol"]);
			$xml->add_nodo('id_cotizacion_det',$f["id_cotizacion_det"]);
			$xml->add_nodo('estado_reg',$f["estado_reg"]);
            $xml->add_nodo('cantidad_adjudicada',$f["cantidad_adjudicada"]);
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