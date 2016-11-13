<?php
/*
**********************************************************
Nombre de archivo:	    ActionListarAdjunto.php
Propósito:				Permite listar registros de la tabla tfl_adjunto
Tabla:					tfl_adjunto
Parámetros:				

Valores de Retorno:    	
Fecha de Creación:		2010-12-22
Versión:				1.0.0
Autor:					Marcos A. Flores Valda
**********************************************************
*/
session_start();
include_once('../LibModeloFlujo.php');

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = 'ActionListarAdjunto.php';

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

	if($sort == '') $sortcol = 'id_adjunto';
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
	if($CantFiltros == '') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	$cond->add_criterio_extra("ADJUNT.id_adjunto",$id_adjunto);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	//Filtro por id del layout maestro
	//if(isset($id_correspondencia))
		//$criterio_filtro.="  and ADJUNT.id_correspondencia = $id_correspondencia";
		
		//$criterio_filtro.="  and ADJUNT.id_correspondencia in (660,662,663)";
		//$criterio_filtro.="  and ADJUNT.id_correspondencia in ('select flujo.f_fl_obtener_adjunto_padre(.$id_correspondencia.) ')";	
		
		//$criterio_filtro = $id_correspondencia;
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'id_adjunto');
	$sortcol = $crit_sort->get_criterio_sort();
		
	//Obtiene el total de los registros
	$res = $Custom -> ContarAdjunto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia);
	
	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom -> ListarAdjunto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_adjunto,$id_correspondencia);
			
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_adjunto',$f["id_adjunto"]);
			$xml->add_nodo('nombre_doc',$f["nombre_doc"]);
			$xml->add_nodo('observacion',$f["observacion"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('estado_reg',$f["estado_reg"]);	
			$xml->add_nodo('id_usuario_reg',$f["id_usuario_reg"]);
			$xml->add_nodo('id_correspondencia',$f["id_correspondencia"]);
			$xml->add_nodo('nombre_arch',$f["nombre_arch"]);
			$xml->add_nodo('extension',$f["extension"]);
			$xml->add_nodo('nombre_original',$f["nombre_original"]);
			$xml->add_nodo('desc_persona',$f["desc_persona"]);			
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