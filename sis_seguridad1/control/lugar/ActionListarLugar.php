<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarLugar.php
Propósito:				Permite realizar el listado en tsg_lugar
Tabla:					t_tsg_lugar
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2007-10-25 16:40:31
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloSeguridad.php');

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = 'ActionListarLugar .php';

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

	if($sort == '') $sortcol = 'fk_id_lugar, id_lugar';
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
	$cond->add_criterio_extra("LUGARR.nivel",$nivel_padre);
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	
	if($sw_municipio!=""){
		$criterio_filtro=$criterio_filtro ." AND LUGARR.sw_municipio like  ''$sw_municipio'' ";
	}
	
	if($sw_municipio_combo=="si"){
		$criterio_filtro=$criterio_filtro ." AND LUGARR.nivel <4 ";
		if($subsis=='kard'){
			$criterio_filtro=$criterio_filtro ." AND LUGARR.nivel >0 ";
		}
	}
	
	if($id_lugar!=""){
		$criterio_filtro=$criterio_filtro. " AND LUGARR.fk_id_lugar IN (select fk_id_lugar from tsg_lugar) AND LUGARR.id_lugar!=$id_lugar";
	}
	
	if($nivel){
		$criterio_filtro=$criterio_filtro." AND LUGARR.nivel >= ".$nivel;
	}
	
	if($feriado){
		$criterio_filtro=$criterio_filtro." AND LUGARR.nivel <= ".$feriado;
	}
	
	if($padre){
		$criterio_filtro=$criterio_filtro." AND LUGARR.fk_id_lugar = ".$padre;
	}
	
	//adicion de filtro a usarse en KARD - reporte funcionarios 17may11
	if($tipo_reporte_kard=='funcionario'){
		$criterio_filtro=$criterio_filtro." AND LUGARR.id_lugar IN (select id_lugar from kard.tkp_historico_asignacion where estado!=''eliminado'')";	
		$sortcol='LUGARR.prioridad_kard';
	}
	
	//aniadido 05/08/2013, para mostrar los registros < 3 (nivel=0,1,2)
	if($filtro_nivel=='3')
	{
		$criterio_filtro=$criterio_filtro."  AND LUGARR.nivel < 3";
	}
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Lugar');
	$sortcol = $crit_sort->get_criterio_sort();
	
	//Obtiene el total de los registros
	$res = $Custom -> ContarLugar($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
if($tipo_reporte_kard=='funcionario'){
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_lugar','%');
			$xml->add_nodo('codigo',"TODOS");
			$xml->add_nodo('nombre',"TODOS");
			$xml->fin_rama();
		}
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_lugar',$f["id_lugar"]);
			$xml->add_nodo('fk_id_lugar',$f["fk_id_lugar"]);
			$xml->add_nodo('desc_lugar',$f["desc_lugar"]);
			$xml->add_nodo('nivel',$f["nivel"]);
			$xml->add_nodo('codigo',$f["codigo"]);
			$xml->add_nodo('nombre',$f["nombre"]);
			$xml->add_nodo('ubicacion',$f["ubicacion"]);
			$xml->add_nodo('telefono1',$f["telefono1"]);
			$xml->add_nodo('telefono2',$f["telefono2"]);
			$xml->add_nodo('fax',$f["fax"]);
			$xml->add_nodo('observacion',$f["observacion"]);
			$xml->add_nodo('sw_municipio',$f["sw_municipio"]);
			$xml->add_nodo('sw_impuesto',$f["sw_impuesto"]);	
			$xml->add_nodo('prioridad_kard',$f["prioridad_kard"]);
			$xml->add_nodo('sigla_sigma',$f["sigla_sigma"]);
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