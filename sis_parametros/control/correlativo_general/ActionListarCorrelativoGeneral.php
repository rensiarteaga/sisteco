<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCorrelativoGeneral.php
Propósito:				Permite realizar el listado en tpm_correlativo_general
Tabla:					t_tpm_correlativo_general
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-09-08 09:53:42
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloParametros.php');

$Custom = new cls_CustomDBParametros();
$nombre_archivo = 'ActionListarCorrelativoGeneral .php';

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

	if($sort == '') $sortcol = 'gestion, id_periodo, DEPTO.id_depto,DOCUME.id_documento, id_correlativo_general';
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
	
	//$cond->add_criterio_extra("DOCUME.id_documento",$m_id_documento);
	if($m_id_gestion_subsistema==''){
		
	   $cond->add_criterio_extra("DOCUME.id_documento",$m_id_documento);
	}else{
		
	   $cond->add_criterio_extra("GESUBS.id_gestion_subsistema",$m_id_gestion_subsistema);
	}
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	
	if($m_nombre_corto=='compro'){
	    $criterio_filtro=$criterio_filtro." and DOCUME.id_subsistema=(select id_subsistema from sss.tsg_subsistema where lower(nombre_corto)=''compro'')
                            and date_part(''month'',(case
                           when (PARADQ.estado=''activo'') then
                                (SELECT distinct now())
                           when (PARADQ.estado=''congelado'') then
                                (SELECT PARADQ.fecha)
                       end))=PERIOD.periodo ";
	}
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'CorrelativoGeneral');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarCorrelativoGeneral($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCorrelativoGeneral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_correlativo_general',$f["id_correlativo_general"]);
			$xml->add_nodo('nro_doc_siguiente',$f["nro_doc_siguiente"]);
			$xml->add_nodo('nro_doc_actual',$f["nro_doc_actual"]);
			$xml->add_nodo('id_documento',$f["id_documento"]);
			$xml->add_nodo('desc_documento',$f["desc_documento"]);
			$xml->add_nodo('id_empresa',$f["id_empresa"]);
			$xml->add_nodo('desc_empresa',$f["desc_empresa"]);
			$xml->add_nodo('id_periodo',$f["id_periodo"]);
			$xml->add_nodo('desc_periodo',$f["desc_periodo"]);
			$xml->add_nodo('gestion',$f["gestion"]);
			$xml->add_nodo('desc_depto',$f["desc_depto"]);

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