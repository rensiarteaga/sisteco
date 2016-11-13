<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDepartamento.php
Propósito:				Permite realizar el listado en tpm_depto
Tabla:					tpm_tpm_depto
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2009-01-23 10:58:13
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloParametros.php');

$Custom = new cls_CustomDBParametros();
$nombre_archivo = 'ActionListarDepartamento .php';

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

	if($sort == '') $sortcol = 'id_depto';
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
	$cond->add_criterio_extra("DEPTO.id_subsistema",$m_id_subsistema);
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Depto');
	
	$sortcol = $crit_sort->get_criterio_sort();
	
	if($oc=='si'){
		$criterio_filtro=$criterio_filtro." AND SUBSIS.nombre_corto=''COMPRO''";
	}

	if($tesoro){/*12-05-2009 para listar solo deptos de TESORO, usado en vista orden_compra_item y orden_compra_det*/
		$criterio_filtro=$criterio_filtro." AND SUBSIS.nombre_corto=''TESORO''";
	}
	if($estado=='2'){//solo cajas activas==> estado_caja=1 (filtro enviado desde proceso_simplificado_factura en COMPRO)
	    
	    $criterio_filtro.=" AND (DEPTO.id_depto in (select * from compro.f_tad_obtener_cajas($id_cotizacion,''cotizacion'',''depto'') as (id_caja integer)))";
	}
	if ($subsistema=='sci') {
		$id_usuario=$_SESSION["ss_id_usuario"];
		$criterio_filtro=$criterio_filtro." 		AND DEPTO.id_depto IN (SELECT ID_DEPTO 
                													FROM PARAM.tpm_depto_usuario 
                													WHERE ID_USUARIO = $id_usuario) and DEPTO.id_subsistema=9 ";

	}
	
	
	
	
	
	
	
	//Obtiene el total de los registros
	$res = $Custom -> ContarDepartamento($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarDepartamento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
       foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_depto',$f["id_depto"]);
			$xml->add_nodo('codigo_depto',$f["codigo_depto"]);
			$xml->add_nodo('nombre_depto',$f["nombre_depto"]);
			$xml->add_nodo('estado',$f["estado"]);
			$xml->add_nodo('id_subsistema',$f["id_subsistema"]);
			$xml->add_nodo('nombre_corto',$f["nombre_corto"]);
			$xml->add_nodo('nombre_largo',$f["nombre_largo"]);
			$xml->add_nodo('despliegue_rep',$f["codigo_depto"].'-'.$f["despliegue_rep"]);
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