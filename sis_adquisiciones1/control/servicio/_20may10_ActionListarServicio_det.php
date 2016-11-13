<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarServicio.php
Propósito:				Permite realizar el listado en tad_servicio
Tabla:					t_tad_servicio
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-16 14:58:50
Versión:				1.0.0
Autor:					Ana Maria Villegas Quispe
Fecha de modificación:  29/09/2009 
Descripción:            Adición de atributo nombre del tipo de adquisición.
**********************************************************
*/
session_start();
include_once('../LibModeloAdquisiciones.php');

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = 'ActionListarServicio .php';

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

	if($sort == '') $sortcol = 'id_servicio';
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
	
	$cond->add_criterio_extra("TIPSER.id_tipo_servicio",$m_id_tipo_servicio);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	if($sortcol=='codigo_entero'){
		$sortcol='codigo';
	}
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Servicio');
	$sortcol = $crit_sort->get_criterio_sort();
	   if($tipo_vista=='reporte_servicios_proveedores'){
    	$criterio_filtro=$criterio_filtro." and tipadq.nombre=''Servicios Generales''";
    	
    }

	//Obtiene el total de los registros
	$res = $Custom -> ContarServicio($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_servicio',$f["id_servicio"]);
			$xml->add_nodo('nombre',$f["nombre"]);
			$xml->add_nodo('descripcion',$f["descripcion"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('id_tipo_servicio',$f["id_tipo_servicio"]);
			$xml->add_nodo('desc_tipo_servicio',$f["desc_tipo_servicio"]);
			$xml->add_nodo('codigo_entero',$f["codigo"]);
			$pos_codigo=strrpos($f["codigo"],'.');
			$cadena=substr($f["codigo"],$pos_codigo+1);
			
			$xml->add_nodo('codigo',$cadena);
            $xml->add_nodo('continuo',$f["continuo"]);
             $xml->add_nodo('estado',$f["estado"]);
             $xml->add_nodo('desc_tipo_adq',$f["desc_tipo_adq"]);
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