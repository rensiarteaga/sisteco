<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarProceso.php
Propósito:				Permite realizar el listado en tfl_tipo_proceso
Tabla:					t_tfl_tipo_proceso
Parámetros:				$id_tipo_proceso
						$codigo
						$id_usuario_reg
						$nombre_proceso
						$fecha_reg
						$estado_reg

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2010-08-19 10:28:40
Versión:				1.0.0
Autor:					Williams Escobar
**********************************************************
*/
session_start();

include_once('../LibModeloFlujo.php');

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = 'ActionListarTipoProceso.php';

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

	if($sort == '') $sortcol = 'id_tipo_proceso';
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
	
	$cond->add_criterio_extra("TIPPRO.id_tipo_proceso",$id_tipo_proceso);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'id_tipo_proceso');
	$sortcol = $crit_sort->get_criterio_sort();

	if(isset($m_id_tipo_proceso)){
		$criterio_filtro.=" and TIPPRO.id_tipo_proceso = $m_id_tipo_proceso"; 
	}
	//Obtiene el total de los registros
	$res = $Custom ->ContarTipoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarTipoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_tipo_proceso',$f["id_tipo_proceso"]);
			$xml->add_nodo('codigo',$f["codigo"]);
			$xml->add_nodo('id_usuario_reg',$f["id_usuario_reg"]);
			$xml->add_nodo('nombre_proceso',$f["nombre_proceso"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('estado_reg',$f["estado_reg"]);
			$xml->add_nodo('estado',$f["estado"]);
			$xml->add_nodo('id_nodo_inicio',$f["id_nodo_inicio"]);
			$xml->add_nodo('id_formulario_inicio',$f["id_formulario_inicio"]);
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