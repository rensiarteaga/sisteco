<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDeposito.php
Propósito:				Permite realizar el listado en taf_deposito
Tabla:					t_taf_deposito
Parámetros:				$id_deposito
						$nombre_deposito
						$estado
						$id_empleado_responsable
						$id_depto_af
						$fecha_reg
						

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2011-01-07 11:34:57
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloActivoFijo.php');

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionListarDeposito.php';

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

	if($sort == '') $sortcol = 'id_deposito';
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
	$cond->add_criterio_extra("DEPOSI.id_deposito",$id_deposito);	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	//por verificar si se utilizara
	if(isset($id_depto)) //Criterio de filtro que viene desde la vista maestro en la variable $_m_id_proceso
	{	
		$criterio_filtro.=" AND deposi.id_depto_af=$id_depto ";			
	}
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'id_deposito');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom ->ContarDeposito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarDeposito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_deposito',$f["id_deposito"]);
			$xml->add_nodo('nombre_deposito',$f["nombre_deposito"]);
			$xml->add_nodo('estado',$f["estado"]);
			$xml->add_nodo('id_empleado_responsable',$f["id_empleado_responsable"]);			
			$xml->add_nodo('id_depto_af',$f["id_depto_af"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('desc_persona',$f["desc_persona"]);			
			$xml->add_nodo('nombre_depto',$f["nombre_depto"]);
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