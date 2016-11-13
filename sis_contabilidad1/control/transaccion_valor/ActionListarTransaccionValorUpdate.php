<?php
/*
**********************************************************
Nombre de archivo:	    ActionListarTransaccionValor.php
Propósito:				Permite listar registros de la tabla sci.tct_transaccion_valor
Tabla:					sci.tct_transaccion_valor
Parámetros:				

Valores de Retorno:    	
Fecha de Creación:		2011-03-11
Versión:				1.0.0
Autor:					Williams Escobar
**********************************************************
*/
session_start();
include_once('../LibModeloContabilidad.php');
$Custom = new cls_CustomDBcontabilidad();
$nombre_archivo = 'ActionListarTransaccionValor.php';

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

	if($sort == '') $sortcol = 'tc.id_comprobante';
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
	if($CantFiltros == '') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}	
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	//Filtro por id del layout maestro
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'tc.id_comprobante');
	$sortcol = $crit_sort->get_criterio_sort();	

	//Obtiene el total de los registros
	$res = $Custom -> ContarTransValor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$m_id_comprobante,$m_id_transaccion,$m_id_moneda);
	
	if($res) $total_registros= $Custom->salida;
         
	//Obtiene el conjunto de datos de la consulta 
	$res = $Custom->ListarTransValor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$m_id_comprobante,$m_id_transaccion,$m_id_moneda);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_transac_valor',$f["id_transac_valor"]);
			$xml->add_nodo('importe_debe',$f["importe_debe"]);
			$xml->add_nodo('importe_haber',$f["importe_haber"]);
			$xml->add_nodo('tipo_moneda',$f["tipo_moneda"]);
			$xml->add_nodo('id_comprobante',$f["id_comprobante"]);
			$xml->add_nodo('id_transaccion',$f["id_transaccion"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
				
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