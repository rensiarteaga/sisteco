<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarTipoNodoEmpleadoSubsistema.php
Prop�sito:				Permite realizar el listado en de los empleados que trabajan en un departamento, que usan un subsistema
Tabla:					tfl_tipo_nodo_empleado
Par�metros:				$id_empleado
						$apellido_paterno
						$apellido_materno
					    $nombre
						$desc_persona
						

Valores de Retorno:    	Listado de empleado que trabajan en los departamentos que usasn el susbsistema
Fecha de Creaci�n:		2011-01-06 10:38:40
Versi�n:				1.0.0
Autor:					Williams Escobar
**********************************************************
*/
session_start();
include_once('../LibModeloFlujo.php');

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = 'ActionListarTipoNodoEmpleadoSubsistema.php';

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

	if($sort == '') $sortcol = 'id_empleado';
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
	$cond->add_criterio_extra("kempleado.id_empleado",$id_empleado);	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	////////verificar por si acaso
	if($subsistema =='FLUJO') //Criterio de filtro que viene desde la vista maestro en la variable $_m_id_tipo_nodo
		{  $criterio_filtro.=" and sub.nombre_corto = ''$subsistema''";
		  
		}			
	//////////////////////
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'id_empleado');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom ->ContarTipoNodoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
	

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarTipoNodoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
	
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_empleado',$f["id_empleado"]);
			$xml->add_nodo('apellido_paterno',$f["apellido_paterno"]);
			$xml->add_nodo('apellido_materno',$f["apellido_materno"]);
			$xml->add_nodo('nombre',$f["nombre"]);
			$xml->add_nodo('desc_persona',$f["desc_persona"]);						
						
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