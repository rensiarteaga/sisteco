<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarSolicitudProcesoCompra.php
Propósito:				Permite realizar el listado en tad_solicitud_proceso_compra
Tabla:					t_tad_solicitud_proceso_compra
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-19 15:28:44
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionListarSolicitudProcesoCompra .php';

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

	if($sort == '') $sortcol = 'SOLCOM.fecha_reg';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'desc';
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

	$cond->add_criterio_extra("SOPRCOM.id_proceso_compra",$m_id_proceso_compra);

	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	if($sortcol=='num_solicitud'){$sortcol='periodo,num_solicitud';}
	if($sortcol=='num_solicitud_sis'){$sortcol='periodo,num_solicitud_sis';}
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'SolicitudProcesoCompra');
	$sortcol = $crit_sort->get_criterio_sort();


	//Obtiene el total de los registros
	$res = $Custom -> ContarSolicitudProcesoCompra($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarSolicitudProcesoCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{

			$xml->add_rama('ROWS');
			$xml->add_nodo('id_solicitud_proceso_compra',$f['id_solicitud_proceso_compra']);
			$xml->add_nodo('fecha_reg',$f['fecha_reg']);
			$xml->add_nodo('id_solicitud_compra',$f['id_solicitud_compra']);
			$xml->add_nodo('id_proceso_compra',$f['id_proceso_compra']);
			$xml->add_nodo('codigo_sicoes',$f['codigo_sicoes']);
			$xml->add_nodo('num_solicitud_sis',$f["periodo_sol"].' / '.$f['num_solicitud_sis']);
			$xml->add_nodo('num_solicitud',$f["periodo_sol"].' / '.$f['num_solicitud']);
			$xml->add_nodo('id_fina_regi_prog_proy_acti',$f['id_fina_regi_prog_proy_acti']);
			$xml->add_nodo('solicitante',$f['solicitante']);
			$xml->add_nodo('id_prog_proy_acti',$f['id_prog_proy_acti']);
			$xml->add_nodo('id_financiador',$f['id_financiador']);
			$xml->add_nodo('id_regional',$f['id_regional']);
			$xml->add_nodo('id_programa',$f['id_programa']);
			$xml->add_nodo('id_proyecto',$f['id_proyecto']);
			$xml->add_nodo('id_actividad',$f['id_actividad']);
			$xml->add_nodo('nombre_financiador',$f['nombre_financiador']);
			$xml->add_nodo('nombre_regional',$f['nombre_regional']);
			$xml->add_nodo('nombre_programa',$f['nombre_programa']);
			$xml->add_nodo('nombre_proyecto',$f['nombre_proyecto']);
			$xml->add_nodo('nombre_actividad',$f['nombre_actividad']);
			$xml->add_nodo('codigo_financiador',$f['codigo_financiador']);
			$xml->add_nodo('codigo_regional',$f['codigo_regional']);
			$xml->add_nodo('codigo_programa',$f['codigo_programa']);
			$xml->add_nodo('codigo_proyecto',$f['codigo_proyecto']);
			$xml->add_nodo('codigo_actividad',$f['codigo_actividad']);
			$xml->add_nodo('id_empleado_frppa_solicitante',$f['id_empleado_frppa_solicitante']);
			$xml->add_nodo('id_tipo_adq',$f['id_tipo_adq']);
			$xml->add_nodo('desc_tipo_adq',$f['desc_tipo_adq']);
			$xml->add_nodo('tipo_adq',$f['tipo_adq']);
			$xml->add_nodo('id_moneda',$f['id_moneda']);
			$xml->add_nodo('simbolo_moneda',$f['simbolo_moneda']);
			$xml->add_nodo('fecha_sol',$f['fecha_sol']);
			$xml->add_nodo('hora_sol',$f['hora_sol']);
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