<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDescargo.php
Propósito:				Permite realizar el listado en tts_avance
Tabla:					tts_tts_avance
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-10-17 10:39:24
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloTesoreria.php');

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = 'ActionListarDescargo.php';

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

	if($sort == '') $sortcol = 'fecha_avance';
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
	$cond->add_criterio_extra("AVANPA.id_avance",$id_avance);
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Descargo');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarDescargo($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarDescargo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_avance',$f["id_avance"]);
			$xml->add_nodo('id_empleado',$f["id_empleado"]);
			$xml->add_nodo('desc_empleado',$f["desc_empleado"]);
			$xml->add_nodo('tipo_avance',$f["tipo_avance"]);
			$xml->add_nodo('fecha_avance',$f["fecha_avance"]);
			$xml->add_nodo('importe_avance',$f["importe_avance"]);
			$xml->add_nodo('estado_avance',$f["estado_avance"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('nombre_moneda',$f["nombre_moneda"]);
			$xml->add_nodo('id_cheque',$f["id_cheque"]);
			$xml->add_nodo('nro_cheque',$f["nro_cheque"]);
			$xml->add_nodo('id_documento',$f["id_documento"]);
			$xml->add_nodo('nro_documento',$f["nro_documento"]);
			$xml->add_nodo('id_comprobante',$f["id_comprobante"]);
			$xml->add_nodo('nro_comprobante',$f["nro_comprobante"]);
			$xml->add_nodo('fk_avance',$f["fk_avance"]);			
			$xml->add_nodo('nro_avance',$f["nro_avance"]);	
			$xml->add_nodo('fecha_ini_rendicion',$f["fecha_ini_rendicion"]);
			$xml->add_nodo('fecha_fin_rendicion',$f["fecha_fin_rendicion"]);
			$xml->add_nodo('id_plan_pago',$f["id_plan_pago"]);	
			$xml->add_nodo('id_usr_reg',$f["id_usr_reg"]);
			$xml->add_nodo('id_depto',$f["id_depto"]);
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