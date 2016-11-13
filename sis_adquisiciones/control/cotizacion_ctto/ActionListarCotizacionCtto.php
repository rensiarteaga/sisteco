<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCotizacion.php
Propósito:				Permite realizar el listado en tad_cotizacion
Tabla:					t_tad_cotizacion
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-28 16:58:46
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionListarCotizacionCtto.php';

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
	if($sort == '') $sortcol = 'id_cotizacion';
	//else {if($sortcol=='numeracion_periodo'){$sortcol='num_cotizacion';}
	else{
	$sortcol = $sort;}//}
	
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
	
	
	
	if($id_cotizacion>0){//para el html del detalle de cotizacion
		$criterio_filtro=$criterio_filtro."  COT.id_cotizacion=''$id_cotizacion''";
	}
	
	//Obtiene el criterio de orden de columnas
	
	
	//Obtiene el total de los registros
	$res = $Custom -> ContarCotizacionCtto($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCotizacionCtto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_cotizacion_ctto',$f["id_cotizacion_ctto"]);
			$xml->add_nodo('id_cotizacion',$f["id_cotizacion"]);
			
			
			$xml->add_nodo('antecedentes',$f["antecedentes"]);
			$xml->add_nodo('controversias',$f["controversias"]);
			$xml->add_nodo('doc_integrantes',$f["doc_integrantes"]);
			$xml->add_nodo('fecha_ctto',$f["fecha_ctto"]);
			$xml->add_nodo('garantias',$f["garantias"]);
			$xml->add_nodo('legislacion',$f["legislacion"]);
			$xml->add_nodo('multas',$f["multas"]);
			$xml->add_nodo('nro_contrato',$f["nro_contrato"]);
			$xml->add_nodo('obligaciones',$f["obligaciones"]);
			
			$xml->add_nodo('partes',$f["partes"]);
			$xml->add_nodo('usuario_reg',$f["usuario_reg"]);
			$xml->add_nodo('vigencia',$f["vigencia"]);
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