<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDepartamentoUsuario.php
Prop�sito:				Permite realizar el listado en tpm_depto_usuario
Tabla:					t_tpm_depto_usuario
Par�metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci�n:		2009-01-23 10:58:14
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloParametros.php');

$Custom = new cls_CustomDBParametros();
$nombre_archivo = 'ActionListarDepartamentoUsuario .php';

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

	if($sort == '') $sortcol = 'desc_usuario'; 
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
	
	$cond->add_criterio_extra("DEPTO.id_depto",$id_depto);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'DeptoUsuario');
	$sortcol = $crit_sort->get_criterio_sort();
	
//26sep11: adicion de filtro id_usuario para vista proceso_bien/servicio_multiple (compro)
	if(isset($id_usuario_compro)){
	    $criterio_filtro=$criterio_filtro. " and DEPUS.id_usuario=$id_usuario_compro and DEPUS.estado=''activo'' and DEPUS.id_depto in (select id_depto from param.tpm_depto where id_subsistema=4 and estado=''activo'')";
	}
	
	//Obtiene el total de los registros
	$res = $Custom -> ContarDepartamentoUsuario($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarDepartamentoUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_depto_usuario',$f["id_depto_usuario"]);
			$xml->add_nodo('id_depto',$f["id_depto"]);
			$xml->add_nodo('desc_depto',$f["desc_depto"]);
			$xml->add_nodo('id_usuario',$f["id_usuario"]);
			$xml->add_nodo('desc_usuario',$f["desc_usuario"]);
			$xml->add_nodo('apellido_paterno_persona',$f["apellido_paterno_persona"]);
			$xml->add_nodo('apellido_materno_persona',$f["apellido_materno_persona"]);
			$xml->add_nodo('nombre_persona',$f["nombre_persona"]);
			$xml->add_nodo('estado',$f["estado"]);
			$xml->add_nodo('cargo',$f["cargo"]);
			$xml->add_nodo('doc_id',$f["doc_id"]);
			$xml->add_nodo('login',$f["login"]);
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