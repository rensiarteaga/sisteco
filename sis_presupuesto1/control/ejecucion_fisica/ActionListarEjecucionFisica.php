<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarEjecucionFisica.php
Propósito:				Permite realizar el listado en tpr_ejecucion_fisica
Tabla:					tpr_tpr_ejecucion_fisica
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-07-04 08:54:27
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarEjecucionFisica .php';

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

	if($sort == '') $sortcol = 'periodo_pres';
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
	
	$cond->add_criterio_extra("EJEFIS.id_proyecto",$m_id_proyecto);
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	///Filtramos por el id parametro
	/*if($filtro==1)
	{
		$criterio_filtro=$criterio_filtro." AND EJEFIS.id_parametro=".$valor_filtro;
	}*/
	
	if($valor_filtro>0)
	{	        
        $criterio_filtro=$criterio_filtro." AND EJEFIS.id_parametro = ".$valor_filtro	;		
    }
    else 
    {
    	$criterio_filtro=$criterio_filtro." AND EJEFIS.id_parametro = (select max(PARAMP.id_parametro) from presto.tpr_parametro PARAMP) ";	    	
    }
	
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'periodo_pres');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarEjecucionFisica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarEjecucionFisica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	$total_porcentaje=0;
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_ejecucion_fisica',$f["id_ejecucion_fisica"]);
			$xml->add_nodo('id_parametro',$f["id_parametro"]);
			$xml->add_nodo('desc_parametro',$f["desc_parametro"]);
			$xml->add_nodo('id_proyecto',$f["id_proyecto"]);
			$xml->add_nodo('periodo_pres',$f["periodo_pres"]);
			$xml->add_nodo('porcentaje_ejecucion',$f["porcentaje_ejecucion"].' %');
			$xml->add_nodo('estado',$f["estado"]);
			$xml->add_nodo('id_usr_reg',$f["id_usr_reg"]);
			$xml->add_nodo('desc_usr_reg',$f["desc_usr_reg"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('id_usr_mod',$f["id_usr_mod"]);
			$xml->add_nodo('desc_usr_mod',$f["desc_usr_mod"]);
			$xml->add_nodo('fecha_mod',$f["fecha_mod"]);
			$xml->add_nodo('justificacion_fisica',$f["justificacion_fisica"]);
			$xml->add_nodo('justificacion_financiera',$f["justificacion_financiera"]);	
			$xml->add_nodo('acciones_fisica',$f["acciones_fisica"]);
			$xml->add_nodo('acciones_financiera',$f["acciones_financiera"]);
			$xml->add_nodo('problemas_fisica',$f["problemas_fisica"]);
			$xml->add_nodo('tiempo_solucion',$f["tiempo_solucion"]);

			$xml->add_nodo('presupuesto_aprobado',number_format( $f["presupuesto_aprobado"], 2, '.', ','));			
			$xml->add_nodo('presupuesto_vigente',number_format( $f["presupuesto_vigente"], 2, '.', ','));
			$xml->add_nodo('ejecucion_financiera',number_format( $f["ejecucion_financiera"], 2, '.', ','));
			$xml->add_nodo('porcentaje_financiera',  number_format( $f["ejecucion_financiera"] * 100 / ( $f["presupuesto_vigente"] + 0.1) ,1).' %'    );

			$xml->fin_rama();
			
			$total_porcentaje=$total_porcentaje+$f["porcentaje_ejecucion"];
		}
		//adicionamos la ultima fila de totales al listado de la grilla
		if($total_registros>0)
		{			
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_ejecucion_fisica',"");
			$xml->add_nodo('id_parametro',"");
			$xml->add_nodo('desc_parametro',"");
			$xml->add_nodo('id_proyecto',"");
			$xml->add_nodo('periodo_pres',"T O T A L :");
			$xml->add_nodo('porcentaje_ejecucion',$total_porcentaje.' %');
			$xml->add_nodo('estado',"");
			$xml->add_nodo('id_usr_reg',"");
			$xml->add_nodo('desc_usr_reg',"");
			$xml->add_nodo('fecha_reg',"");
			$xml->add_nodo('id_usr_mod',"");
			$xml->add_nodo('desc_usr_mod',"");
			$xml->add_nodo('fecha_mod',"");
			$xml->add_nodo('justificacion_fisica',"");
			$xml->add_nodo('justificacion_financiera',"");	
			$xml->add_nodo('acciones_fisica',"");
			$xml->add_nodo('acciones_financiera',"");
			$xml->add_nodo('problemas_fisica',"");
			$xml->add_nodo('tiempo_solucion',"");			

			$xml->add_nodo('presupuesto_aprobado',"");			
			$xml->add_nodo('presupuesto_vigente',"");
			$xml->add_nodo('ejecucion_financiera',"");
			$xml->add_nodo('porcentaje_financiera',"");

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