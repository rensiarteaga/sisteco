<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarPresupuestoColectivo.php
Propósito:				Permite realizar el listado en tpr_concepto_colectivo
Tabla:					tpr_tpr_concepto_colectivo
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-08-15 16:45:20
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarPresupuestoColectivo .php';

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

	if($sort == '') $sortcol = 'desc_usuario';
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
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'ConceptoColectivo');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarPresupuestoColectivo($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarPresupuestoColectivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		if ($sw_combo_consolidacion=='si') {
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_concepto_colectivo',-1);
			$xml->add_nodo('estado_colectivo',-1);
			$xml->add_nodo('id_usuario',-1);
			$xml->add_nodo('desc_usuario',"Ninguno");
			$xml->add_nodo('desc_colectivo',"Todos");
			$xml->fin_rama();

			/*$xml->add_rama('ROWS');
			$xml->add_nodo('id_concepto_colectivo',-2);
			$xml->add_nodo('estado_colectivo',-1);
			$xml->add_nodo('id_usuario',-1);
			$xml->add_nodo('desc_usuario',"Ninguno");
			$xml->add_nodo('desc_colectivo',"No Colectivos");
			$xml->fin_rama();*/
		}else {
			

			/*$xml->add_rama('ROWS');
			$xml->add_nodo('id_concepto_colectivo',-1);
			$xml->add_nodo('estado_colectivo',-1);
			$xml->add_nodo('id_usuario',-1);
			$xml->add_nodo('desc_usuario',"Ninguno");
			$xml->add_nodo('desc_colectivo',"Ninguno");
			$xml->fin_rama();*/
		}
		
		
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_concepto_colectivo',$f["id_concepto_colectivo"]);
			$xml->add_nodo('estado_colectivo',$f["estado_colectivo"]);
			$xml->add_nodo('id_usuario',$f["id_usuario"]);
			$xml->add_nodo('desc_usuario',$f["desc_usuario"]);
			$xml->add_nodo('desc_colectivo',$f["desc_colectivo"]);
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