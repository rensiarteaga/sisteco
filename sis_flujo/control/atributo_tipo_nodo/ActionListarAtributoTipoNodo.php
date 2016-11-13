<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarTipoCircuito.php
Propósito:				Permite realizar el listado en tfl_tipo_circuito
Tabla:					tfl_tipo_circuito
Parámetros:				$id_tipo_circuito
						$id_tipo_nodo_inicio
						$nombre_nodo_inicio
						$id_tipo_nodo_fin
						$nombre_nodo_fin

Valores de Retorno:    	Listado de tipos de circuitos y total de registros listados
Fecha de Creación:		2010-12-27 16:28:47
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloFlujo.php');

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = 'ActionListarAtributoTipoNodo.php';

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

	if($sort == '') $sortcol = 'id_atributo_tipo_nodo';
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
	
	//aumenta un criterio de busqueda de acuerdo al id del maestro.
	if(isset($m_id_tipo_nodo)){
		$criterio_filtro.=" and ATRTIPNOD.id_tipo_nodo = $m_id_tipo_nodo";}
	if(isset($m_id_tipo_formulario)){
		$criterio_filtro.=" and TIPATR.id_tipo_formulario = $m_id_tipo_formulario";
	}
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'AtributoTipoNodo');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarAtributoTipoNodo($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarAtributoTipoNodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
	
	if($res){
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f){
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_atributo_tipo_nodo',$f["id_atributo_tipo_nodo"]);
			$xml->add_nodo('id_atributo',$f["id_atributo"]);
			$xml->add_nodo('id_tipo_nodo',$f["id_tipo_nodo"]);
			$xml->add_nodo('nombre',$f["nombre"]);
			$xml->add_nodo('label',$f["label"]);
			$xml->add_nodo('tipo_datos',$f["tipo_datos"]);
			$xml->add_nodo('tipo_field',$f["tipo_field"]);
			$xml->add_nodo('opcional',$f["opcional"]);
			$xml->add_nodo('visible',$f["visible"]);
			$xml->add_nodo('editable',$f["editable"]);
			$xml->add_nodo('orden',$f["orden"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('estado_reg',$f["estado_reg"]);
			$xml->fin_rama();
		}
		$xml->mostrar_xml();
	}
	else{
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