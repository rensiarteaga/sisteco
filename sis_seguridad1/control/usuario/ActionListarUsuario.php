<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarUsuario.php
Prop�sito:				Permite realizar el listado en tsg_usuario
Tabla:					t_tsg_usuario
Par�metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci�n:		2007-10-26 17:44:02
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start(); 
include_once('../LibModeloSeguridad.php');

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = 'ActionListarUsuario .php';

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

	if($sort == '') $sortcol = 'desc_persona';
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
	//Obtiene el criterio de orden de columnas
	if($m_id_usuario>0){
		$criterio_filtro=$criterio_filtro." AND USUARI.id_usuario=$m_id_usuario";
	}
	
	
	//Obtiene el total de los registros
	$res = $Custom -> ContarUsuario($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		if ($oc=='si'){
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_usuario','%');
			$xml->add_nodo('id_persona','%');
			$xml->add_nodo('desc_persona','Todos');
			$xml->add_nodo('desc_usuario','Todos');
			$xml->fin_rama();
		}
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_usuario',$f["id_usuario"]);
			$xml->add_nodo('id_persona',$f["id_persona"]);
			$xml->add_nodo('desc_persona',$f["desc_persona"]);
			$xml->add_nodo('login',$f["login"]);
			$xml->add_nodo('contrasenia',$f["contrasenia"]);
			$xml->add_nodo('fecha_registro',$f["fecha_registro"]);
			$xml->add_nodo('hora_registro',$f["hora_registro"]);
			$xml->add_nodo('fecha_ultima_modificacion',$f["fecha_ultima_modificacion"]);
			$xml->add_nodo('hora_ultima_modificacion',$f["hora_ultima_modificacion"]);
			$xml->add_nodo('estado_usuario',$f["estado_usuario"]);
			$xml->add_nodo('estilo_usuario',$f["estilo_usuario"]);
			$xml->add_nodo('filtro_avanzado',$f["filtro_avanzado"]);
			$xml->add_nodo('fecha_expiracion',$f["fecha_expiracion"]);
			$xml->add_nodo('autentificacion',$f["autentificacion"]);
			$xml->add_nodo('desc_usuario',$f["desc_persona"]);
			$xml->add_nodo('id_nivel_seguridad',$f["id_nivel_seguridad"]);
			$xml->add_nodo('nombre_nivel',$f["nombre_nivel"]);
			$xml->add_nodo('prioridad',$f["prioridad"]);
			$xml->add_nodo('fecha_inactivacion',$f["fecha_inactivacion"]);
			
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