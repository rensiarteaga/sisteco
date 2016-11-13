<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarPensamientoDia.php
Propósito:				Permite realizar el listado en comunidad.com_publicaciones
Tabla:					comunidad.com_publicaciones
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2013-05-14
Versión:				1.0.0
Autor:					Morgan Huascar Checa Lopez
**********************************************************
*/
session_start();
include_once('../LibModeloAdministracionComunidad.php');

$Custom = new cls_CustomDBComunidad();
$nombre_archivo = 'ActionListarPensamientoDia.php';

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

	if($sort == '') $sortcol = 'PENS.id_pensamiento_dia DESC';
	else $sortcol = $sort;

	if($dir == '') $sortdir = '';
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
	
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();//0=0
	
	
	$criterio_filtro=$criterio_filtro. " and PENS.pens_estado_registro=''activo''";
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarPensamiento($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarPensamientoDia($cant, $puntero, $sortcol, $sortdir, $criterio_filtro);//$Custom->ListarTipoObligacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		/*$xml->add_rama('ROWS');
		$xml->add_nodo('id_pensamiento_dia',0);
		$xml->add_nodo('texto_pensamiento','NINGUNO');
		$xml->add_nodo('fecha_colocado_pensamiento',date("d/m/Y"));
		$xml->add_nodo('fecha_fin',date("d/m/Y")+1);
		$xml->fin_rama();*/
//$xml->add_nodo('foto_persona',$f["foto_persona"]);
		foreach ($Custom->salida as $f)
		{
			
			
			
			$xml->add_rama('ROWS');
			
			$xml->add_nodo('id_pensamiento_dia',$f["id_pensamiento_dia"]);
			$xml->add_nodo('texto_pensamiento',$f["texto_pensamiento"]);
			$xml->add_nodo('fecha_colocado_pensamiento',$f["fecha_colocado_pensamiento"]);
			$xml->add_nodo('fecha_fin',$f["fecha_fin"]);
			
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