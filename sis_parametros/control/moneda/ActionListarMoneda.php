<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarMoneda.php
Propósito:				Permite realizar el listado en tpm_moneda
Tabla:					t_tpm_moneda
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2007-11-06 20:48:38
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloParametros.php');

$Custom = new cls_CustomDBParametros();
$nombre_archivo = 'ActionListarMoneda .php';

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

	if($sort == '') $sortcol = 'nombre';
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
	if($estado){
	$cond->add_criterio_extra("MONEDA.estado","''".$estado."''");}
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	if($sw_comboPresupuesto=="si"){//obtencion de moneda con prioridad 1 para solicitud de compra en adquisiciones
		$criterio_filtro=$criterio_filtro." AND MONEDA.prioridad <=2 and MONEDA.estado=''activo'' ";
	}
	
	if($sw_combo_presupuesto=="si"){//obtencion de moneda con prioridad 1 para solicitud de compra en adquisiciones
		$criterio_filtro=$criterio_filtro." AND MONEDA.prioridad <=2 and MONEDA.estado=''activo'' ";
	}
	
	if($sw_reg_comp=="si"){//obtencion de moneda con prioridad 1 para solicitud de compra en adquisiciones
		$criterio_filtro=$criterio_filtro." AND  MONEDA.estado=''activo'' ";
	}
	
	if($prioridad>0){//obtencion de moneda con prioridad 1 para solicitud de compra en adquisiciones
		$criterio_filtro=$criterio_filtro." AND MONEDA.prioridad=1";
	}
	
	if($prioridad=0){//obtencion de las monedas con prioridad diferente a la moneda base para tipos de cambio 
		$criterio_filtro=$criterio_filtro." AND MONEDA.prioridad!=1";
	}
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Moneda');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarMoneda($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarMoneda($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('nombre',$f["nombre"]);
			$xml->add_nodo('simbolo',$f["simbolo"]);
			$xml->add_nodo('estado',$f["estado"]);
			$xml->add_nodo('origen',$f["origen"]);
			$xml->add_nodo('prioridad',$f["prioridad"]);

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