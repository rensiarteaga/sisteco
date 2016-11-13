<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarRecuperacionVejezGral.php
Propósito:				Permite realizar el listado en tfv_reclamo
Tabla:					tfv_tfv_reclamo
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2011-05-19 11:33:45
Versión:				1.0.0
Autor:					José Mita
**********************************************************
*/
session_start();
include_once('../LibModeloContabilidad.php');

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarRecuperacionVejezGral.php';

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

	if($sort == '') $sortcol = 'id_archivo_control';
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
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Recuperación Vejez');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarRecuperacionVejez($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarRecuperacionVejez($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_archivo_control',$f["id_archivo_control"]);
			$xml->add_nodo('id_factura',$f["id_factura"]);
			$xml->add_nodo('nro_factura',$f["nro_factura"]);
			$xml->add_nodo('nro_autoriza',$f["nro_autoriza"]);
			$xml->add_nodo('fecha_envio',$f["fecha_envio"]);
			$xml->add_nodo('nro_nit',$f["nro_nit"]);
			$xml->add_nodo('razon_social',$f["razon_social"]);
			$xml->add_nodo('codigo_form',$f["codigo_form"]);
			$xml->add_nodo('numero_orden',$f["numero_orden"]);
			$xml->add_nodo('mes_per_fiscal',$f["mes_per_fiscal"]);
			$xml->add_nodo('anio_per_fiscal',$f["anio_per_fiscal"]);
			$xml->add_nodo('fecha_emision',$f["fecha_emision"]);
			$xml->add_nodo('importe_factura',$f["importe_factura"]);
			$xml->add_nodo('cantidad_valor_solicitado',$f["cantidad_valor_solicitado"]);
			$xml->add_nodo('nro_beneficiarios_directos',$f["nro_beneficiarios_directos"]);
			$xml->add_nodo('nro_beneficiarios_indirectos',$f["nro_beneficiarios_indirectos"]);
			$xml->add_nodo('cant_reg_beneficiarios',$f["cant_reg_beneficiarios"]);
			$xml->add_nodo('importe_directo',$f["importe_directo"]);
			$xml->add_nodo('importe_indirecto',$f["importe_indirecto"]);
			$xml->add_nodo('importe_total',$f["importe_total"]);
			$xml->add_nodo('cod_control',$f["cod_control"]);
			$xml->add_nodo('estado',$f["estado"]);
			
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