<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDeclaracion.php
Propósito:				Permite realizar el listado en tsi_declaracion
Tabla:					tsi_declaracion
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-10-16 12:20:40
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloSigma.php');

$Custom = new cls_CustomDBSigma();
$nombre_archivo = __FILE__;

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

	if($sort == '') $sortcol = 'id_cbte_det';
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
	
	$cond->add_criterio_extra("CBTEDE.id_cab_cbte",$m_id_cab_cbte);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'cbte_det_dfaewr');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarCbteDet($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCbteDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_cbte_det',$f["id_cbte_det"]);
			$xml->add_nodo('ent_trf',$f["ent_trf"]);
			$xml->add_nodo('libreta',$f["libreta"]);
			$xml->add_nodo('importe',$f["importe"]);
		 	$xml->add_nodo('tipo_dato',$f["tipo_dato"]);
			$xml->add_nodo('tipo',$f["tipo"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('id_cab_cbte',$f["id_cab_cbte"]);
			$xml->add_nodo('id_presupuesto',$f["id_presupuesto"]);
			$xml->add_nodo('id_partida',$f["id_partida"]);
			$xml->add_nodo('id_oec',$f["id_oec"]);
			$xml->add_nodo('id_cuenta_bancaria',$f["id_cuenta_bancaria"]);
			$xml->add_nodo('cuenta_sigma',$f["cuenta_sigma"]);
			$xml->add_nodo('id_transaccion',$f["id_transaccion"]);
			$xml->add_nodo('desc_presupuesto',$f["desc_presupuesto"]);
			$xml->add_nodo('partida',$f["partida"]);
			$xml->add_nodo('sigla_oec',$f["sigla_oec"]);
			$xml->add_nodo('codigo_oec',$f["codigo_oec"]);
			$xml->add_nodo('desc_oec',$f["desc_oec"]);
			$xml->add_nodo('banco',$f["banco"]);
			$xml->add_nodo('reportar',$f["reportar"]);
			$xml->add_nodo('fuente_fin',$f["fuente_fin"]);
			$xml->add_nodo('organismo_fin',$f["organismo_fin"]);
			$xml->add_nodo('programa',$f["programa"]);
			$xml->add_nodo('proyecto',$f["proyecto"]);
			$xml->add_nodo('actividad',$f["actividad"]);
			$xml->add_nodo('desc_cuenta',$f["desc_cuenta"]);
			$xml->add_nodo('cuenta_sigma',$f["cuenta_sigma"]);
			$xml->add_nodo('modificado',$f["modificado"]);
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