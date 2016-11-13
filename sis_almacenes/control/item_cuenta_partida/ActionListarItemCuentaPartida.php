<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarItemArchivo.php
Propósito:				Permite realizar el listado en tal_item_archivo
Tabla:					tal_item_archivo
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		
Versión:				
Autor:					
**********************************************************
*/
session_start();
include_once('../LibModeloAlmacenes.php');

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = 'ActionListarItemCuentaPartida.php';



if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
	//echo $m_gestion;exit;
//Parámetros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_item_cuenta_partida';
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
	$criterio_filtro =" ICUPAR.id_item_cuenta_partida<0 ";
	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;
	
	if($m_gestion>0){
		//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	$cond->add_criterio_extra("GESTION.id_gestion",$m_gestion);
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'ItemCuentaPartida');
	$sortcol = $crit_sort->get_criterio_sort();

	}
	
	//Obtiene el total de los registros
	$res = $Custom -> ContarItemCuentaPartida($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarItemCuentaPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_item_cuenta_partida',$f["id_item_cuenta_partida"]);
			$xml->add_nodo('nivel',$f["nivel"]);
			$xml->add_nodo('id_gral',$f["id_gral"]);
			$xml->add_nodo('id_supergrupo',$f["id_supergrupo"]);
			$xml->add_nodo('nombre_supergrupo',$f["nombre_supergrupo"]);
			$xml->add_nodo('id_grupo',$f["id_grupo"]);
			$xml->add_nodo('nombre_grupo',$f["nombre_grupo"]);
			$xml->add_nodo('id_subgrupo',$f["id_subgrupo"]);
			$xml->add_nodo('nombre_subgrupo',$f["nombre_subgrupo"]);
			$xml->add_nodo('id_id1',$f["id_id1"]);
			$xml->add_nodo('nombre_id1',$f["nombre_id1"]);
			$xml->add_nodo('id_id2',$f["id_id2"]);
			$xml->add_nodo('nombre_id2',$f["nombre_id2"]);
			$xml->add_nodo('id_id3',$f["id_id3"]);
			$xml->add_nodo('nombre_id3',$f["nombre_id3"]);
			$xml->add_nodo('desc_item_cuenta_partida',$f["desc_item_cuenta_partida"]);
			$xml->add_nodo('id_cuenta',$f["id_cuenta"]);
			$xml->add_nodo('nombre_cuenta',$f["nombre_cuenta"]);
			$xml->add_nodo('id_partida',$f["id_partida"]);
			$xml->add_nodo('nombre_partida',$f["nombre_partida"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('id_gestion',$f["id_gestion"]);
			$xml->add_nodo('gestion',$f["gestion"]);
			$xml->add_nodo('id_cuenta_gasto',$f["id_cuenta_gasto"]);
			$xml->add_nodo('desc_cuenta_gasto',$f["desc_cuenta_gasto"]);
			$xml->add_nodo('id_presupuesto',$f["id_presupuesto"]);
			$xml->add_nodo('desc_presupuesto',$f["desc_presupuesto"]);						
			$xml->add_nodo('id_auxiliar_activo',$f["id_auxiliar_activo"]);
			$xml->add_nodo('desc_auxiliar_activo',$f["desc_auxiliar_activo"]);
			$xml->add_nodo('id_auxiliar_gasto',$f["id_auxiliar_gasto"]);
			$xml->add_nodo('desc_auxiliar_gasto',$f["desc_auxiliar_gasto"]);
			$xml->add_nodo('detalle_usado',$f["detalle_usado"]);
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
	/*}
	else {
		echo $m_gestion;exit;
	}*/
	
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