<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarOec.php
Propósito:				Permite realizar el listado en tpr_oec
Tabla:					tpr_tpr_oec
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-07-07 11:38:59
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarOec .php';

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

	if($sort == '') $sortcol = 'oec.codigo_oec';
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
	
	$tipo_oec = $_GET["tipo_oec"];
	$m_id_partida = $_GET["m_id_partida"];
	if($m_id_partida == null){
		
	//	$tipo_oec = $_POST["tipo_oec"];
		$m_id_partida = $_POST["m_id_partida"];
	}
	$cond->add_criterio_extra("OEC.id_oec",$id_oec);
	$criterio_filtro = $cond -> obtener_criterio_filtro();
		
	if($tipo_oec!=''){
		$criterio_filtro=$criterio_filtro." AND OEC.tipo_oec=$tipo_oec";
	}
	
	if($m_id_partida!=''){
		$criterio_filtro=$criterio_filtro." AND PAROEC.id_partida=$m_id_partida";
	}

	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Oec');
	$sortcol = $crit_sort->get_criterio_sort();

	//Obtiene el total de los registros
	$res = $Custom -> ContarOec($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarOec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		if($oc == "si"){
         	$xml->add_rama('ROWS');
         	$xml->add_nodo('id_oec','%');
			$xml->add_nodo('codigo_oec','Todos');
			$xml->add_nodo('nombre_oec','Todos');
			$xml->add_nodo('desc_oec','Todos');
			$xml->add_nodo('nivel_oec','Todos');
			$xml->add_nodo('sw_transaccional','Todos');
			$xml->add_nodo('tipo_oec','Todos');
			$xml->add_nodo('id_parametro','Todos');
			$xml->add_nodo('desc_parametro','Todos');
			$xml->add_nodo('id_oec_padre','Todos');
			$xml->add_nodo('descrip_oec','Todos');
			$xml->add_nodo('tipo_memoria','Todos');
			$xml->add_nodo('desc_oec','Todos');
			$xml->fin_rama();
        }
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_oec',$f["id_oec"]);
			$xml->add_nodo('codigo_oec',$f["codigo_oec"]);
			$xml->add_nodo('nombre_oec',$f["nombre_oec"]);
			$xml->add_nodo('desc_par',$f["codigo_oec"]." - ".$f["nombre_oec"]);
			$xml->add_nodo('nivel_oec',$f["nivel_oec"]);
			$xml->add_nodo('sw_transaccional',$f["sw_transaccional"]);
			$xml->add_nodo('tipo_oec',$f["tipo_oec"]);
			$xml->add_nodo('id_parametro',$f["id_parametro"]);
			$xml->add_nodo('desc_parametro',$f["desc_parametro"]);
			$xml->add_nodo('id_oec_padre',$f["id_oec_padre"]);
			$xml->add_nodo('descrip_oec',$f["descrip_oec"]);
			$xml->add_nodo('tipo_memoria',$f["tipo_memoria"]);
			$xml->add_nodo('desc_oec',$f["desc_oec"]);

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