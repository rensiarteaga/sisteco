<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarExtractoBancario.php
Propósito:				Permite realizar el listado en tsi_siet_cbte
Tabla:					tsi_siet_cbte_partida
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		01/11/2015
Versión:				1.0.0
Autor:					A.V.Q
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarExtractoBancario.php';

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

	if($sort == '') $sortcol = 'id_extracto_bancario';
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
	
	if ($get)
	{
		$id_cuenta_bancaria= $_GET["hidden_id_cuenta_bancaria"];
		$id_parametro= $_GET["id_parametro"];
		$id_periodo= $_GET["id_periodo"];
	
	}
	else
	{  $id_cuenta_bancaria= $_POST["hidden_id_cuenta_bancaria"];
	   $id_parametro= $_POST["id_parametro"];
	   $id_periodo= $_POST["id_periodo"];
			
	}
	/*echo $id_siet_declara;
	exit;*/
if ($m_vista=='siet_cbte') {
	$criterio_filtro=$criterio_filtro." AND EXTBAN.id_cuenta_bancaria =$id_cuenta_bancaria1 AND  EXTBAN.tipo_importe =''$tipo_declara'' and EXTBAN.id_periodo=$id_periodo_dec and EXTBAN.sw_asocia is null ";
}else{
$criterio_filtro=$criterio_filtro." AND EXTBAN.id_cuenta_bancaria =$id_cuenta_bancaria AND EXTBAN.id_parametro=$id_parametro AND EXTBAN.id_periodo=$id_periodo ";
}	
	
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'ExtractoBancario');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarExtractoBancario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarExtractoBancario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			
			
			
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_extracto_bancario',$f["id_extracto_bancario"]);
			$xml->add_nodo('id_cuenta_bancaria',$f["id_cuenta_bancaria"]);
			$xml->add_nodo('fecha_movimiento',$f["fecha_movimiento"]);
			$xml->add_nodo('agencia',$f["agencia"]);
			$xml->add_nodo('descripcion',$f["descripcion"]);
			$xml->add_nodo('nro_documento',$f["nro_documento"]);
                     $xml->add_nodo('monto',number_format($f["monto"],2,',','.'));
			
			//$xml->add_nodo('monto',$f["monto"]);
			$xml->add_nodo('tipo_importe',$f["tipo_importe"]);
			$xml->add_nodo('sub_tipo_importe',$f["sub_tipo_importe"]);
			$xml->add_nodo('observaciones',$f["observaciones"]);
                     $xml->add_nodo('nro_cuenta_banco',$f["nro_cuenta_banco"]);
 			$xml->add_nodo('id_cbte',$f["id_cbte"]);
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