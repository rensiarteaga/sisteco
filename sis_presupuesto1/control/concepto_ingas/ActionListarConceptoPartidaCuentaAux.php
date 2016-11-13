<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarConceptoIngas.php
Propósito:				Permite realizar el listado en tpr_concepto_ingas
Tabla:					t_tpr_concepto_ingas
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-07-07 15:19:35
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarConceptoPartidaCuentaAux.php';

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

	if($sort == '') $sortcol = 'desc_ingas_item_serv';
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
	
	if($ver_ant=='si'){
		//No hace nada es para habilitar la versión anterior de viáticos
	} else{
		//Filtramos los conceptos de gasto que tengan sw_tesoro = si, viaticos, avance, cajas 
		if($sw_tesoro==1){
			$criterio_filtro=	$criterio_filtro." and  CONING.sw_tesoro in (1,3,4,5,6) ";
		}
		
		//Filtramos solo los conceptos de gasto de viaticos
		if($sw_tesoro==3){
			$criterio_filtro=	$criterio_filtro." and  CONING.sw_tesoro in (1,3,6,7) ";
		}	
	
		//Filtramos solo los conceptos de gasto de fondos en avance
		if($sw_tesoro==4){
			$criterio_filtro=	$criterio_filtro." and  CONING.sw_tesoro in (1,4,5) ";
		}
		
		//Filtramos solo los conceptos de gasto de cajas
		if($sw_tesoro==5){
			$criterio_filtro=	$criterio_filtro." and  CONING.sw_tesoro in (1,5) ";
		}
		
		//Filtramos solo los conceptos de gasto de viaticos (No por agencia 6)
		if($sw_tesoro==6){
			$criterio_filtro=	$criterio_filtro." and  CONING.sw_tesoro in (1,3) ";
		}
	}
	
	if($m_id_presupuesto&&$m_sw_rendicion=='si'){	
		$criterio_filtro=	$criterio_filtro." and PRESTO.id_presupuesto =".$m_id_presupuesto."	";		
	}	
	
	if($m_id_presupuesto&&$m_sw_rendicion=='no'){	
		$criterio_filtro=	$criterio_filtro." and PRESTO.id_presupuesto =".$m_id_presupuesto."	";
		//echo $criterio_filtro;
	}
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'ConceptoIngas_02');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	//ContarConceptoIngas
	$res = $Custom -> ContarConceptoPartidaCuentaAux($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarConceptoPartidaCuentaAux($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_concepto_ingas',$f["id_concepto_ingas"]);
			$xml->add_nodo('desc_ingas',$f["desc_ingas"]);
			$xml->add_nodo('id_partida',$f["id_partida"]);
			$xml->add_nodo('desc_partida',$f["desc_partida"]);          
			$xml->add_nodo('desc_ingas_item_serv',$f["desc_ingas_item_serv"]);			
			$xml->add_nodo('sw_tesoro',$f["sw_tesoro"]);	
			$xml->add_nodo('id_cuenta',$f["id_cuenta"]);		
			$xml->add_nodo('desc_cuenta',$f["desc_cuenta"]);
			$xml->add_nodo('id_auxiliar',$f["id_auxiliar"]);
			$xml->add_nodo('desc_auxiliar',$f["desc_auxiliar"]);
			$xml->add_nodo('id_presupuesto',$f["id_presupuesto"]);
			$xml->add_nodo('id_unidad_organizacional',$f["id_unidad_organizacional"]);
			
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