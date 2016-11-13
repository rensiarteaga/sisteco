<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarRpa.php
Propósito:				Permite realizar el listado en tad_rpa
Tabla:					t_tad_rpa
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-12 17:40:12
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionListarRpa .php';

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

	if($sort == '') $sortcol = 'RESCON.id_categoria_adq';
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
	//Obtiene el criterio de orden de columnas
	if($id_frppa>0){
		$criterio_filtro=$criterio_filtro." AND FRPPA.id_fina_regi_prog_proy_acti=$id_frppa";
	}
	if($id_tipo_categoria_adq>0){
		 $criterio_filtro=$criterio_filtro." AND CATADQ.id_categoria_adq=(select id_categoria_adq from compro.tad_tipo_categoria_adq where id_tipo_categoria_adq=$id_tipo_categoria_adq)";
	}
	
	
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Rpa');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarRpa($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	
	$res = $Custom->ListarRpa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
/*	echo "sale?".$sortdir;
	exit;*/
	if($res)
	
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_rpa',$f["id_rpa"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('estado',$f["estado"]);
			$xml->add_nodo('id_empleado_frppa',$f["id_empleado_frppa"]);
			$xml->add_nodo('desc_empleado_tpm_frppa',$f["desc_empleado_tpm_frppa"]);
			$xml->add_nodo('id_categoria_adq',$f["id_categoria_adq"]);
			$xml->add_nodo('desc_categoria_adq',$f["desc_categoria_adq"]);
			$xml->add_nodo('desc_frppa',$f["desc_frppa"]);
            $xml->add_nodo('id_frppa',$f["id_frppa"]);
            $xml->add_nodo('desc_financiador',$f["desc_financiador"]);
            $xml->add_nodo('id_regional',$f["id_regional"]);
            $xml->add_nodo('id_programa',$f["id_programa"]);
            $xml->add_nodo('id_proyecto',$f["id_proyecto"]);
            $xml->add_nodo('id_actividad',$f["id_actividad"]);
            $xml->add_nodo('id_financiador',$f["id_financiador"]);
            $xml->add_nodo('desc_regional',$f["desc_regional"]);
            $xml->add_nodo('desc_programa',$f["desc_programa"]);
            $xml->add_nodo('desc_proyecto',$f["desc_proyecto"]);
            $xml->add_nodo('desc_actividad',$f["desc_actividad"]);
            
            
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