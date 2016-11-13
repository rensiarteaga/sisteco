<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDepreciacionGestionDetalle.php
Prop�sito:				Permite realizar el listado en tpm_depreciacion_gestion
Tabla:					tpm_depreciacion_gestion
Par�metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci�n:		27/10/2015
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloActivoFijo.php');

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionListarDepreciacionGestionDetalle .php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Par�metros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'dg.id';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
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
	
	$cond->add_criterio_extra("DG.id_depreciacion_gestion",$id_depreciacion_gestion);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();

	//Obtiene el total de los registros
	$res = $Custom -> ContarDepreciacionGestionDetalle($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarDepreciacionGestionDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_depreciacion_gestion_det',$f["id_depreciacion_gestion_det"]);
			$xml->add_nodo('id_depreciacion_gestion',$f["id_depreciacion_gestion"]);
			$xml->add_nodo('fecha_desde',$f["fecha_desde"]);
			$xml->add_nodo('fecha_hasta',$f["fecha_hasta"]);
			$xml->add_nodo('monto_vigente_ant',$f["monto_vigente_ant"]);
			$xml->add_nodo('monto_vigente',$f["monto_vigente"]);
			$xml->add_nodo('vida_util_restante',$f["vida_util_restante"]);
			$xml->add_nodo('tipo_cambio_ini',$f["tipo_cambio_ini"]);
			$xml->add_nodo('tipo_cambio_fin',$f["tipo_cambio_fin"]);
			$xml->add_nodo('depreciacion_acum_ant',$f["depreciacion_acum_ant"]);
			$xml->add_nodo('depreciacion',$f["depreciacion"]);
			$xml->add_nodo('depreciacion_acum',$f["depreciacion_acum"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
			$xml->add_nodo('monto_actualiz_ant',$f["monto_actualiz_ant"]);
			$xml->add_nodo('monto_actualiz',$f["monto_actualiz"]);
			$xml->add_nodo('dep_acum_actualiz',$f["dep_acum_actualiz"]);
			$xml->add_nodo('id_activo_fijo',$f["id_activo_fijo"]);
			$xml->add_nodo('codigo',$f["codigo"]);
			$xml->add_nodo('vida_util_original',$f["vida_util_original"]);

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