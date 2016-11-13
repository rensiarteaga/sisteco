<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarEstadoAutorizado.php
Propósito:				Permite realizar el listado en tpr_estado_autorizado
Tabla:					t_tpr_estado_autorizado
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-09-03 14:44:35
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarEstadoAutorizado .php';

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

	if($sort == '') $sortcol = 'estado_autorizado';
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
	
	$cond->add_criterio_extra("USUAUT.id_usuario_autorizado",$m_id_usuario_autorizado);
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	if($sw_comboPresupuesto=="si"){
	$criterio_filtro=$criterio_filtro." and USUAUT.id_usuario_autorizado
	in ((select id_usuario_autorizado from presto.tpr_usuario_autorizado where id_usuario=".$_SESSION["ss_id_usuario"]." and id_unidad_organizacional=".$id_unidad_organizacional."))";	
	}
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'EstadoAutorizado');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarEstadoAutorizado($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarEstadoAutorizado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			if($estado_gral==2){$xml->add_rama('ROWS');
			$xml->add_nodo('id_estado_autorizado',0);
			$xml->add_nodo('id_usuario_autorizado',$f["id_usuario_autorizado"]);
			$xml->add_nodo('desc_usuario_autorizado',$f["desc_usuario_autorizado"]);
			$xml->add_nodo('id_concepto_colectivo',$f["id_concepto_colectivo"]);
			$xml->add_nodo('desc_concepto_colectivo',$f["desc_concepto_colectivo"]);
			$xml->add_nodo('estado_autorizado',3);
			$xml->add_nodo('desc_estado_autorizado',$f["desc_estado_autorizado"]);
			$xml->fin_rama();}
			if($estado_gral==3){$xml->add_rama('ROWS');
			$xml->add_nodo('id_estado_autorizado',0);
			$xml->add_nodo('id_usuario_autorizado',$f["id_usuario_autorizado"]);
			$xml->add_nodo('desc_usuario_autorizado',$f["desc_usuario_autorizado"]);
			$xml->add_nodo('id_concepto_colectivo',$f["id_concepto_colectivo"]);
			$xml->add_nodo('desc_concepto_colectivo',$f["desc_concepto_colectivo"]);
			$xml->add_nodo('estado_autorizado',4);
			$xml->add_nodo('desc_estado_autorizado',$f["desc_estado_autorizado"]);
			$xml->fin_rama();}
			
			
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_estado_autorizado',$f["id_estado_autorizado"]);
			$xml->add_nodo('id_usuario_autorizado',$f["id_usuario_autorizado"]);
			$xml->add_nodo('desc_usuario_autorizado',$f["desc_usuario_autorizado"]);
			$xml->add_nodo('id_concepto_colectivo',$f["id_concepto_colectivo"]);
			$xml->add_nodo('desc_concepto_colectivo',$f["desc_concepto_colectivo"]);
			$xml->add_nodo('estado_autorizado',$f["estado_autorizado"]);
			$xml->add_nodo('desc_estado_autorizado',$f["desc_estado_autorizado"]);
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