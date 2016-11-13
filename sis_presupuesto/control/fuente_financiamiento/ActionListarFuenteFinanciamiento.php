<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarFuenteFinanciamiento.php
Propósito:				Permite realizar el listado en tpr_fuente_financiamiento
Tabla:					tpr_tpr_fuente_financiamiento
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-07-15 10:55:06
Versión:				1.0.0
Autor:					Grover Velasquez Colque
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarFuenteFinanciamiento .php';

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

	if($sort == '') $sortcol = 'FUNFIN.codigo_fuente';
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
	
	if($sw_reg_comp=='si')
	{
		$criterio_filtro=$criterio_filtro." and FUNFIN.id_fuente_financiamiento in (select id_fuente_financiamiento 
											from presto.tpr_presupuesto 
											where id_parametro IN( select parame.id_parametro 
																from presto.tpr_parametro parame 
																where id_gestion in (select par.id_gestion 
																					from sci.tct_parametro 
																					par where par.id_parametro =".$m_id_parametro."))
												  and id_fina_regi_prog_proy_acti in (select id_ep from param.tpm_depto_ep where id_depto=".$m_id_depto.") ";
			 
			if($m_sw_ingreso=='si'){$criterio_filtro=$criterio_filtro." and tipo_pres =1 ";};
			if($m_sw_ingreso=='no'){$criterio_filtro=$criterio_filtro." and tipo_pres in (2,3) ";};
			$criterio_filtro=$criterio_filtro.")";
	}
	
	if($m_id_programa)
	{
		//$cond->add_criterio_extra("PRESUP.id_parametro",$m_id_parametro);	
		$criterio_filtro=$criterio_filtro."  and FUNFIN.id_fuente_financiamiento in ( Select CATPRO.id_fuente_financiamiento FROM presto.tpr_categoria_prog CATPRO WHERE CATPRO.id_parametro= " .$m_id_parametro." AND CATPRO.id_programa=".$m_id_programa." AND CATPRO.id_proyecto=".$m_id_proyecto."  AND CATPRO.id_actividad=".$m_id_actividad."  AND CATPRO.id_organismo_fin=".$m_id_organismo_fin.") ";
	}
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'FuenteFinanciamiento');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarFuenteFinanciamiento($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarFuenteFinanciamiento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_fuente_financiamiento',$f["id_fuente_financiamiento"]);
			$xml->add_nodo('codigo_fuente',$f["codigo_fuente"]);
			$xml->add_nodo('denominacion',$f["denominacion"]);
			$xml->add_nodo('descripcion',$f["descripcion"]);
			$xml->add_nodo('sigla',$f["sigla"]);
			$xml->add_nodo('usuario_reg',$f["usuario_reg"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);

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