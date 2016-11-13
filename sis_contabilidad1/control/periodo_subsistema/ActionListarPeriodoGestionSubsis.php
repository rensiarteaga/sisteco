<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarPeriodoGestionSubsis.php
Propósito:				Lista los periodos de una Gestion y de un Subsistema
Tabla:					t_tct_periodo_subsistema
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado y total de registros listados
Fecha de Creación:		03/12/2008
Versión:				1.0.0
Autor:					RCM
**********************************************************
*/
session_start();
include_once('../LibModeloContabilidad.php');

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarPeriodoGestionSubsis.php';

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

	if($sort == '') $sortcol = 'PERIOD.periodo';
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
	
	$cond->add_criterio_extra("GESTIO.id_gestion",$id_gestion);
	$cond->add_criterio_extra("PERIOD.id_subsistema",$id_subistema);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'PeriodoGestionSubsistema');
	$sortcol = $crit_sort->get_criterio_sort();
// williams
	if($id_subsistema==9)
    {
    	$criterio_filtro=$criterio_filtro."  and persis.id_subsistema = 9";
    	$sortcol="  PERSIS.id_periodo";
    }
	//fin williams	
  /* if ($sw_reporte=='libro_compra'){
         $criterio_filtro=" (lower(PERIOD.id_gestion) LIKE lower(".$id_gestion.")) AND  (lower(PERSIS.id_subsistema) LIKE lower(".$id_subsistema.")) ";
   }*/
	//Obtiene el total de los registros
	$res = $Custom -> ContarPeriodoGestionSubsistema($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarPeriodoGestionSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	//echo $Custom->query; exit();
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_periodo_subsistema',$f["id_periodo_subsistema"]);
			$xml->add_nodo('id_periodo',$f["id_periodo"]);
			$xml->add_nodo('desc_periodo',$f["desc_periodo"]);
			$xml->add_nodo('estado_periodo',$f["estado_periodo"]);
			$xml->add_nodo('periodo',$f["periodo"]);

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