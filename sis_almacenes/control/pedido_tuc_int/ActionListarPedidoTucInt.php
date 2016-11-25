<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarPedidoTucInt.php
Propósito:				Permite realizar el listado en tal_kardex_logico
Tabla:					t_tal_pedido_tuc_int
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		29/12/2016 15:20:32
Versión:				1.0.0
Autor:					RAC
**********************************************************
*/
session_start();
include_once('../LibModeloAlmacenes.php');

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = 'ActionListarPedidoTucInt.php';

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

	if($sort == '') $sortcol = 'id_pedido_tuc_int';
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
	
	$cond->add_criterio_extra("pti.id_salida",$m_id_salida);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'ParametroAlmacenLogico');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarPedidoTucInt($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarPedidoTucInt($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');						
			$xml->add_nodo('id_pedido_tuc_int',$f["id_pedido_tuc_int"]);
		    $xml->add_nodo('id_salida',$f["id_salida"]);
		    $xml->add_nodo('id_orden_salida_uc_detalle',$f["id_orden_salida_uc_detalle"]);
		    $xml->add_nodo('id_tipo_unidad_constructiva',$f["id_tipo_unidad_constructiva"]);
		    $xml->add_nodo('id_item',$f["id_item"]);
		    $xml->add_nodo('cantidad_solicitada',$f["cantidad_solicitada"]);
		    $xml->add_nodo('nuevo',$f["nuevo"]);
		    $xml->add_nodo('fecha_reg',$f["fecha_reg"]);
		    $xml->add_nodo('usado',$f["usado"]);
		    $xml->add_nodo('demasia',$f["demasia"]);
		    $xml->add_nodo('sw_autorizado',$f["sw_autorizado"]);
		    $xml->add_nodo('sw_entregado',$f["sw_entregado"]);
		    $xml->add_nodo('id_salida_complementaria',$f["id_salida_complementaria"]);
		    $xml->add_nodo('nombre',$f["nombre"]);
		    $xml->add_nodo('codigo',$f["codigo"]);
		    $xml->add_nodo('descripcion',$f["descripcion"]);
		    $xml->add_nodo('correlativo_sal_com',$f["correlativo_sal_com"]); 
		
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