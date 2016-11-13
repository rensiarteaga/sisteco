<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarSistemas.php
Propósito:				Permite realizar el listado en comunidad.com_sistema_informatico
Tabla:					comunidad.com_sistema_informatico
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
$nombre_archivo = 'ActionListarSistemas.php';

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

	if($sort == '') $sortcol = 'SIST.id_sistema_informatico DESC';
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
	
	
	$criterio_filtro=$criterio_filtro. " and SIST.sis_estado_registro=''activo''";
	

	//Obtiene el total de los registros
	//$res = $Custom -> ContarPublicacion($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro);

	//if($res) $total_registros= $Custom->salida;
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarSistemas($cant, $puntero, $sortcol, $sortdir, $criterio_filtro);//$Custom->ListarTipoObligacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		/*$xml->add_rama('ROWS');
		$xml->add_nodo('id_publicacion',0);
		$xml->add_nodo('nombre_publicacion','NINGUNO');
		$xml->add_nodo('descripcion_publicacion','Ninguno');
		$xml->add_nodo('pub_fecha_registro','activo');
		$xml->fin_rama();*/
//$xml->add_nodo('foto_persona',$f["foto_persona"]);
		foreach ($Custom->salida as $f)
		{
			
			
			
			$xml->add_rama('ROWS');
			
			$xml->add_nodo('id_sistema_informatico',$f["id_sistema_informatico"]);
			$xml->add_nodo('nombre_sistema_informatico',$f["nombre_sistema_informatico"]);
			$xml->add_nodo('enlace_sistema',$f["enlace_sistema"]);
			$xml->add_nodo('sis_fecha_registro',$f["sis_fecha_registro"]);
			$xml->add_nodo('sistema',$f["sistema"]);
			
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