<?php
/**
**********************************************************
Nombre de archivo:	ActionListaPermiso.php
Propósito:			Permite desplegar los permisos asignados a un usuario
Tabla:				tsg_metaproceso
Parámetros:			$cant
					$puntero
					$sortcol
					$sortdir
					$criterio_filtro
					$id_usuario_asignacion

Valores de Retorno:    	Listado de Permisos para el usuario
Fecha de Creación:		08 - 06 - 07
Versión:				1.0.0
Autor:					
**********************************************************
**/
session_start();
include_once("../LibModeloSeguridad.php");
$CustomSeguridad = new CustomDBSeguridad();

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	
	//Parámetros del filtro
	if($limit == "") $cant = 15;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

	if($sort == "") $sortcol = 'descripcion';
	else $sortcol = $sort;

	if($dir == "") $sortdir = 'asc';
	else $sortdir = $dir;
	//Obtiene la lista de permisos para el id_usuario, si existe caso contrario la funcion devolvera un error
	$res = $CustomSeguridad->ListaPermiso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_usuario,$ip_origen,$mac_maquina);
	
	if($res)
	{ 
		// PREPARA EL Archivo de menu
		
		
		$_html = "<a id='welcome-link' href='welcome.html'>Sistema ENDESIS</a>";
		$_html .= "<div class='pkg'><h3>Sistema ENDESIS</h3>
				   <div class='pkg-body'>";
				   
		
		
		foreach ($CustomSeguridad->salida as $f)
		{ 
		    $_xml->add_rama('ROWS');
		    $_xml->add_nodo('id_metodo_depreciacion',$f["id_metodo_depreciacion"]);
		    $_xml->add_nodo('descripcion',$f["descripcion"]);
			$_xml->fin_rama();
		}
		
		header('Content-Type: text/html');
		echo $_xml->cadena_xml();
	}
	else
	{
		//Se produjo un error
		header("HTTP/1.0 406 Not Acceptable");
		header('Content-Type: text/xml');
		$resp = new manejo_mensajes(true);
		$resp->mensaje_error = $CustomSeguridad->salida[1];
		$resp->origen = 'ActionListaPermiso.php';
		$resp->proc = 'ActionListaPermiso.php';
		$resp->nivel = '3';
		echo $resp->mensaje();
		exit;
	}
	
}
else
{
	header("HTTP/1.0 401 No autorizado");
	header('Content-Type: text/xml; charset=iso-8859-1');
	$resp = new manejo_mensajes(true);
	$resp->mensaje_error = 'Usuario no Autentificado';
	$resp->origen = 'ActionListaMetodoDepreciacion.php';
	$resp->proc = 'ActionListaMetodoDepreciacion.php';
	$resp->nivel = '3';
	echo $resp->mensaje();
	exit;

}

?>