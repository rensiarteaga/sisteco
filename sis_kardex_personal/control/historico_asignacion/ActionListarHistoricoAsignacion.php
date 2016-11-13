<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarUnidadOrganizacional.php
Propósito:				Permite realizar el listado en tkp_unidad_organizacional
Tabla:					t_tkp_unidad_organizacional
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-12 09:24:17
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloKardexPersonal.php');

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = 'ActionListarHistoricoAsignacion.php';

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

	if($sort == '') $sortcol = 'fecha_asignacion';
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
	if($maestro_id_unidad_organizacional!='' && $maestro_id_unidad_organizacional!='null'){
		
		$criterio_filtro= $criterio_filtro. " AND UNIORG.id_unidad_organizacional=$maestro_id_unidad_organizacional";
	}
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'HistoricoAsignacion');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarHistoricoAsignacion($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;
//echo $criterio_filtro; exit;
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarHistoricoAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res){
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		
		foreach ($Custom->salida as $f){
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_historico_asignacion',$f["id_historico_asignacion"]);
			$xml->add_nodo('fecha_asignacion',$f["fecha_asignacion"]);
			$xml->add_nodo('estado',$f["estado"]);
			$xml->add_nodo('id_unidad_organizacional',$f["id_unidad_organizacional"]);
			$xml->add_nodo('id_empleado',$f["id_empleado"]);
			$xml->add_nodo('fecha_finalizacion',$f["fecha_finalizacion"]);
			$xml->add_nodo('fecha_registro',$f["fecha_registro"]);
			$xml->add_nodo('nombre_unidad',$f["nombre_unidad"]);
			$xml->add_nodo('nombre_cargo',$f["nombre_cargo"]);
			$xml->add_nodo('id_persona',$f["id_persona"]);
			$xml->add_nodo('desc_persona',$f["desc_persona"]);
			$xml->add_nodo('id_empleado_suplente',$f["id_empleado_suplente"]);
			$xml->add_nodo('suplente',$f["suplente"]);
			$xml->add_nodo('id_lugar',$f["id_lugar"]);
			$xml->add_nodo('desc_lugar',$f["desc_lugar"]);
			
			$xml->add_nodo('usuario_reg',$f["usuario_reg"]);
			$xml->add_nodo('usuario_mod',$f["usuario_mod"]);
			$xml->add_nodo('fecha_ultima_mod',$f["fecha_ultima_mod"]);
			
			$xml->add_nodo('id_cargo',$f["id_cargo"]);
			$xml->add_nodo('id_tipo_contrato',$f["id_tipo_contrato"]);
			$xml->add_nodo('desc_cargo',$f["desc_cargo"]);
			$xml->add_nodo('desc_tipo_contrato',$f["desc_tipo_contrato"]);
			$xml->add_nodo('tipo_registro',$f["tipo_registro"]);
			$xml->add_nodo('sw_impuesto',$f["sw_impuesto"]);
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