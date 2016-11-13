<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarPlantillaCalculo.php
Propósito:				Permite realizar el listado en tct_plantilla_calculo
Tabla:					t_tct_plantilla_calculo
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-10-16 12:20:41
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloContabilidad.php');

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarPlantillaCalculo .php';

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

	if($sort == '') $sortcol = 'id_plantilla_calculo';
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
	
	$cond->add_criterio_extra("PLANT.id_plantilla",$m_id_plantilla);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	if($m_id_gestion){
	  	$criterio_filtro=$criterio_filtro." AND PARAM.id_gestion=".$m_id_gestion;
	}
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'PlantillaCalculo');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarPlantillaCalculo($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarPlantillaCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_plantilla_calculo',$f["id_plantilla_calculo"]);
			$xml->add_nodo('id_plantilla',$f["id_plantilla"]);
			$xml->add_nodo('desc_plantilla',$f["desc_plantilla"]);
			$xml->add_nodo('tipo_cuenta',$f["tipo_cuenta"]);
			$xml->add_nodo('id_ejercicio',$f["id_ejercicio"]);
			$xml->add_nodo('desc_ejercicio',$f["desc_ejercicio"]);
			$xml->add_nodo('desc_cuenta_ejercicio',$f["desc_cuenta_ejercicio"]);
			$xml->add_nodo('debe_haber',$f["debe_haber"]);
			$xml->add_nodo('porcen_calculo',$f["porcen_calculo"]);
			$xml->add_nodo('campo_doc',$f["campo_doc"]);
			$xml->add_nodo('sw_porcentaje',$f["sw_porcentaje"]);
			$xml->add_nodo('sw_retencion',$f["sw_retencion"]);
            $xml->add_nodo('sw_contabilizacion',$f["sw_contabilizacion"]);

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