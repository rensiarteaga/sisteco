<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarTipoAdq.php
Propósito:				Permite realizar el listado en comunidad.com_normativa_interna
Tabla:					comunidad.com_normativa_interna
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2013-05-16 14:58:47
Versión:				1.0.0
Autor:					Morgan Huascar Checa Lopez
**********************************************************
*/
session_start();
include_once('../LibModeloAdministracionComunidad.php');

$Custom = new cls_CustomDBComunidad();
$nombre_archivo = 'ActionListarTipoAdq .php';

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

	if($sort == '') $sortcol = 'NI.id_normativa_interna';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'ASC';
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
	
	/*if($id_tipo_adq!=''){// para el maestro de tipo_servicio
		$criterio_filtro=$criterio_filtro." AND TIPADQ.id_tipo_adq=$id_tipo_adq";
	}
	
	if($con_servicios!=''){
		$criterio_filtro=$criterio_filtro." AND TIPADQ.id_tipo_adq in (select id_tipo_adq from compro.tad_tipo_servicio where id_tipo_servicio in (select id_servicio from compro.tad_servicio)) or (TIPADQ.tipo_adq=''Bien'')";
	}
	
	
	if($tipo_adq!=''){
	    $criterio_filtro=$criterio_filtro. "AND lower(TIPADQ.tipo_adq)=''$tipo_adq''";
	}
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'TipoAdq');
	$sortcol = $crit_sort->get_criterio_sort();*/
	$criterio_filtro=$criterio_filtro." AND NI.estado_registro=''activo'' ";

	//Obtiene el total de los registros
	$res = $Custom -> ContarNormativas($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarNormativas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_normativa_interna',$f["id_normativa_interna"]);
			$xml->add_nodo('nombre_categoria_normativa',$f["nombre_categoria_normativa"]);
			$xml->add_nodo('descripcion_categoria',$f["descripcion_categoria"]);
			$xml->add_nodo('fecha_registro',$f["fecha_registro"]);
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