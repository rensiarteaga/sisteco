<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCaif.php
Prop�sito:				Permite realizar el listado en tpr_caif
Tabla:					tpr_caiff
Par�metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci�n:		
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarCaif.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Par�metros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_caif'; //nombre_unidad
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
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
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'CAIFFIELD');
	$sortcol = $crit_sort->get_criterio_sort();
	
	IF ($sw_nivel==2) {
	$criterio_filtro=$criterio_filtro.' AND nivel_caif in (0,1,2) or sw_transaccional=1';
	}
	ELSE IF ($sw_nivel==3) {
	$criterio_filtro=$criterio_filtro.' AND sw_transaccional=2 or nivel_caif=0';
	} 
	ELSE IF ($sw_nivel==4) {
	$criterio_filtro=$criterio_filtro.' AND nivel_caif in (0,1,2)';
	}
	ELSE IF ($sw_nivel==1) {
	$criterio_filtro=' 0=0';
	}
    $criterio_filtro=$criterio_filtro.' AND tipo_caif='.$tipo_caif;
	

	//Obtiene el total de los registros
	$res = $Custom ->ContarCaifField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCaifField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);

	if($res)	
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_caif',$f["id_caif"]);
			$xml->add_nodo('desc_caif',$f["desc_caif"]);
			$xml->add_nodo('codigo_caif',$f["codigo_caif"]);
			$xml->add_nodo('nombre_caif',$f["nombre_caiff"]);
			$xml->add_nodo('sw_transaccional',$f["sw_transaccional"]);
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