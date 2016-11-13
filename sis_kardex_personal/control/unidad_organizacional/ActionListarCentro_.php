<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarUnidadOrganizacional.php
Propósito:				Permite realizar el listado en tkp_unidad_organizacional
Tabla:					t_tkp_unidad_organizacional
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-12 09:24:17
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloKardexPersonal.php');

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = 'ActionListarUnidadOrganizacional .php';

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

	if($sort == '') $sortcol = 'id_unidad_organizacional';
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
	
	
	//$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Verifica si se manda la cantidad de filtros
	
	
	$res = $Custom->ListarUnidadOrganizacionalCentro($id_empleado);
	
	if($res)
	{ 
	   if($Custom->salida!='' && $Custom->salida!= null){  
	   $total_registros=1;
	   }else{
	   	$total_registros=0;
	   }
		   $xml = new cls_manejo_xml('ROOT');
		   $xml->add_nodo('TotalCount',$total_registros);
 			$var1= split('###',$Custom->salida);
 			
		    $xml->add_rama('ROWS');
			$xml->add_nodo('centro',$var1[0]);
			$xml->add_nodo('id_unidad_organizacional',$var1[1]);
			$xml->add_nodo('id_uo_gerencia',$var1[2]);
			$xml->fin_rama();
		
		$xml->mostrar_xml();;	
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