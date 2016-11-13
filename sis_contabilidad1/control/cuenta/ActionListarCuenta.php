<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCuenta.php
Propósito:				Permite desplegar las cuentas
Tabla:					tct_cuenta
Parámetros:				$cant
$puntero
$sortcol
$sortdir
$criterio_filtro
$id_usuario_asignacion

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		02-10-2007
Versión:				1.0.0
Autor:					José A. Mita Huanza
**********************************************************
*/
session_start();
include_once("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarCuenta .php';

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

	if($sort == '') $sortcol = 'CUENTA.nro_cuenta';
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
	$cond->add_criterio_extra("CUENTA.sw_transaccional",$sw_transaccional);
	$cond->add_criterio_extra("PARAME.id_gestion",$id_gestion);
	/*echo $id_gestion;
	exit;
	*/
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	if ($sw_reg_comp=='si'&& $m_id_partida){
		$criterio_filtro=$criterio_filtro." AND CUENTA.id_cuenta in (select id_cuenta from presto.tpr_partida_cuenta where id_partida  =".$m_id_partida.")";
	}
	
	if ($sw_concepto_cta=='si'&& $m_id_partida){
		$criterio_filtro=$criterio_filtro." AND CUENTA.id_cuenta in (select id_cuenta from presto.tpr_partida_cuenta where id_partida  =".$m_id_partida.")";
	}
	
	if($m_id_gestion){
	  	$criterio_filtro=$criterio_filtro." AND GESTION.id_gestion=".$m_id_gestion;	
	}
	
	if($m_id_eeff){
		if($m_vigente == 'si'){
			$criterio_filtro = $criterio_filtro. " AND GESTION.id_gestion IN (SELECT id_gestion_act FROM sci.tct_eeff WHERE id_eeff = ".$m_id_eeff.")";
		}else{
			$criterio_filtro = $criterio_filtro. " AND GESTION.id_gestion IN (SELECT id_gestion_ant FROM sci.tct_eeff WHERE id_eeff = ".$m_id_eeff.")";
		}
	}
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Cuenta');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarCuenta($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_cuenta',$f["id_cuenta"]);
			$xml->add_nodo('desc_cuenta',$f["desc_cuenta"]);
			$xml->add_nodo('desc_cta',$f["desc_cta"]);
			$xml->add_nodo('desc_cta2',$f["nro_cuenta"]." - ".$f["nombre_cuenta"]);
			$xml->add_nodo('nivel_cuenta',$f["nivel_cuenta"]);
			$xml->add_nodo('nombre_cuenta',$f["nombre_cuenta"]);
			$xml->add_nodo('nro_cuenta',$f["nro_cuenta"]);
			$xml->add_nodo('sw_transaccional',$f["sw_transaccional"]);
			$xml->add_nodo('tipo_cuenta',$f["tipo_cuenta"]);
			$xml->add_nodo('id_cuenta_padre',$f["id_cuenta_padre"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('id_parametro',$f["id_parametro"]);
			$xml->add_nodo('nombre_cuenta_padre',$f["nombre_cuenta_padre"]);
			$xml->add_nodo('moneda',$f["moneda"]);
			$xml->add_nodo('nivel_parametro',$f["nivel_parametro"]);
			$xml->add_nodo('sw_oec',$f["sw_oec"]);
			$xml->add_nodo('sw_aux',$f["sw_aux"]);
			$xml->add_nodo('gestion',$f["gestion"]);

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
