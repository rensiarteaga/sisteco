<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarProyecto.php
Propósito:				Permite realizar el listado en tpr_proyecto
Tabla:					tpr_proyecto
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-07-15 10:55:06
Versión:				1.0.0
Autor:					Grover Velasquez Colque
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarProyecto.php';

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

	if($sort == '') $sortcol = 'PROYEC.codigo';
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
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
		
	if($m_id_parametro)
	{
		//$cond->add_criterio_extra("PRESUP.id_parametro",$m_id_parametro);	
		$criterio_filtro=$criterio_filtro."  and PROYEC.id_proyecto in ( Select CATPRO.id_proyecto FROM presto.tpr_categoria_prog CATPRO WHERE CATPRO.id_parametro= " .$m_id_parametro." AND CATPRO.id_programa=".$m_id_programa." ) ";
	}
			
	//Obtiene el criterio de orden de columnas
	//$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'ProyectoCatProg');
	//$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarProyecto($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarProyecto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_proyecto',$f["id_proyecto"]);
			$xml->add_nodo('codigo',$f["codigo"]); 
			$xml->add_nodo('descripcion',$f["descripcion"]);
			$xml->add_nodo('sigla',$f["sigla"]);
			$xml->add_nodo('usuario_reg',$f["usuario_reg"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('codigo_sisin',$f["codigo_sisin"]); 
			$xml->add_nodo('sector_economico',$f["sector_economico"]); 
			$xml->add_nodo('subsector_economico',$f["subsector_economico"]); 
			$xml->add_nodo('activ_eco',$f["activ_eco"]); 
			$xml->add_nodo('departamento',$f["departamento"]); 
			$xml->add_nodo('provincia',$f["provincia"]); 
			$xml->add_nodo('seccion_mun',$f["seccion_mun"]); 
			$xml->add_nodo('sisin',$f["sisin"]); 
			$xml->add_nodo('pnd',$f["pnd"]); 
			$xml->add_nodo('cant_proyectos',$f["cant_proyectos"]);

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