<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarAutorizacionPresupuesto.php
Propósito:				Permite realizar el listado en tpr_usuario_autorizado
Tabla:					tpr_tpr_usuario_autorizado
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-08-18 17:10:52
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarAutorizacionPresupuesto .php';

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

	if($sort == '') $sortcol = 'desc_usuario,desc_unidad_organizacional'; //nombre_unidad
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
	
	if($filtroUsuario=='si'){
		$cond->add_criterio_extra("USUAUT.id_usuario",$_SESSION['ss_id_usuario']);
	}
	
	/*if($sw_responsable=='si'){
		$cond->add_criterio_extra("USUAUT.sw_responsable",1); //filtramos solamente a los responsables
	}*/
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	
	if($sw_responsable=='si')
	{		
		$criterio_filtro=$criterio_filtro." and USUAUT.sw_responsable in (1) and USUAUT.estado=''Activo''"; //filtramos solamente a los funcionarios que autorizan
	}
	if ($id_unidad_organizacional)
	{
		$criterio_filtro=$criterio_filtro." and USUAUT.id_unidad_organizacional=".$id_unidad_organizacional;
	}
	
	if($sw_autoriza=='si')
	{
		//$cond->add_criterio_extra("USUAUT.sw_responsable",3); //filtramos solamente a los funcionarios que autorizan
		$criterio_filtro=$criterio_filtro." and USUAUT.sw_responsable in (1,3) and USUAUT.estado=''Activo''"; //filtramos solamente a los funcionarios que autorizan
	}
	
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'UsuarioAutorizado');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarAutorizacionPresupuesto($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarAutorizacionPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_usuario_autorizado',$f["id_usuario_autorizado"]);
			$xml->add_nodo('id_usuario',$f["id_usuario"]);
			$xml->add_nodo('desc_usuario',$f["desc_usuario"]);
			$xml->add_nodo('id_unidad_organizacional',$f["id_unidad_organizacional"]);
			$xml->add_nodo('desc_unidad_organizacional',$f["desc_unidad_organizacional"]);
			$xml->add_nodo('sw_responsable',$f["sw_responsable"]);
			$xml->add_nodo('estado',$f["estado"]);			
			$xml->add_nodo('desc_usuario_reg',$f["desc_usuario_reg"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('fecha_ultima_mod',$f["fecha_ultima_mod"]);
			
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