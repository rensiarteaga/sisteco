<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarRegistroComprobante.php
Propósito:				Permite realizar el listado en tct_comprobante
Tabla:					tct_tct_comprobante
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-09-16 17:55:38
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloContabilidad.php');

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarLibroDiario.php';
/*echo "sdfsdkfjksd ";
exit;*/
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

	if($sort == '') $sortcol = 'id_comprobante';
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
	
	/*$cond->add_criterio_extra("COMPRO.id_comprobante",$m_id_comprobante);
	$cond->add_criterio_extra("COMPRO.id_usuario",$_SESSION["ss_id_usuario"]);
	*/
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	$criterio_filtro=$criterio_filtro." AND COMPROB.id_depto=$m_id_depto AND COMPROB.fecha_cbte >=''$m_fecha_inicio'' and COMPROB.fecha_cbte <= ''$m_fecha_fin''";
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Comprobante');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarLibroDiarioComprobante($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ReporteLibroDiarioComprobante($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_comprobante',$f["id_comprobante"]);
			$xml->add_nodo('nro_cbte',$f["nro_cbte"]);
			$xml->add_nodo('fecha_cbte',$f["fecha_cbte"]);
			$xml->add_nodo('prefijo',$f["prefijo"]);
			$xml->add_nodo('nombre_acreedor',$f["nombre_acreedor"]);
			$xml->add_nodo('concepto_cbte',$f["concepto_cbte"]);
			$xml->add_nodo('desc_clase',$f["desc_clase"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
			$xml->add_nodo('momento_cbte',$f["momento_cbte"]);
			$xml->add_nodo('titulo_cbte',$f["titulo_cbte"]);
		
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