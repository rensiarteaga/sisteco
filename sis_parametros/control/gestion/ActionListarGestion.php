<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarGestion.php
Propósito:				Permite realizar el listado en tpm_gestion
Tabla:					tpm_tpm_gestion
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-08-13 16:02:05
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloParametros.php');

$Custom = new cls_CustomDBParametros();
$nombre_archivo = 'ActionListarGestion .php';

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

	if($sort == '') $sortcol = 'gestion';
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
	
	//Solo listamos las gestiones con estado abierto
	//$estado = 'abierto';
	//$cond->add_criterio_extra("GESTIO.estado_ges_gral",$estado);
	//$criterio_filtro = $criterio_filtro." AND estado_ges_gral = "."$estado";
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	if ($tipo_vista=='conta_parametro'){
		$criterio_filtro=$criterio_filtro."  AND GESTIO.estado_ges_gral=''abierto'' AND  GESTIO.id_gestion   not IN(select id_gestion from sci.tct_parametro )      ";
	}
	if ($tipo_vista=='cobra_sis'){
		$criterio_filtro=$criterio_filtro."  AND GESTIO.estado_ges_gral=''abierto''  ";
	}
	if ($tipo_vista=='plan_pago'){
		
	     if($sgte_gestion=='no'){
	         $criterio_filtro=$criterio_filtro."  AND GESTIO.gestion=$anio and GESTIO.estado_ges_gral=''abierto''";
	     }else{
	     	
		   $criterio_filtro=$criterio_filtro."  AND GESTIO.gestion>=$anio ";
	     }
	}
	if($estado=='abierto'){
		$criterio_filtro=$criterio_filtro."  AND (GESTIO.estado_ges_gral=''abierto'' OR  GESTIO.estado_ges_gral=''semi-abierto'') AND GESTIO.id_empresa=".$_SESSION['ss_id_empresa'] ;
	}
	
	if($tipo_filtro=='ultima_gestion_activa'){
		$criterio_filtro=$criterio_filtro." AND GESTIO.gestion=(select max(gestion) 
                    from param.tpm_gestion
                    where estado_ges_gral=''abierto'')";
	}
	
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Gestion');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarGestion($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_gestion',$f["id_gestion"]);
			$xml->add_nodo('id_empresa',$f["id_empresa"]);
			$xml->add_nodo('desc_empresa',$f["desc_empresa"]);
			$xml->add_nodo('id_moneda_base',$f["id_moneda_base"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
			$xml->add_nodo('gestion',$f["gestion"]);
			$xml->add_nodo('estado_ges_gral',$f["estado_ges_gral"]);

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