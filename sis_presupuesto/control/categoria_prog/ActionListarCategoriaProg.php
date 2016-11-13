<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCategoriaProg.php
Propósito:				Permite realizar el listado en tpr_categoria_prog
Tabla:					t_tpr_categoria_prog
Parámetros:		$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2007-11-06 16:42:14
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarCategoriaProg.php';

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

	if($sort == '') $sortcol = 'PROGRA.codigo,PROYEC.codigo,ACTIVI.codigo,FUEFIN.codigo_fuente,ORGFIN.codigo';
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
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Categoria Programatica');
	$sortcol = $crit_sort->get_criterio_sort();
	
	if($m_id_gestion)
	{
	    $criterio_filtro=$criterio_filtro." AND PARAME.id_gestion=".$m_id_gestion;	
	}
	else 
	{
		 if($m_id_parametro)
		 {
			$criterio_filtro=$criterio_filtro."  AND CATPRO.id_parametro=$m_id_parametro ";
		 }
		 else
		 {
			$criterio_filtro=$criterio_filtro." AND PARAME.gestion_pres=(select max(PARAME.gestion_pres) from presto.tpr_parametro PARAME) ";	
		}
	}
	
	 if ($tipo_vista=='formulacion' or $tipo_vista=='ejecucion' )
	 {	     
			$criterio_filtro=$criterio_filtro."  AND CATPRO.id_categoria_prog in (SELECT distinct id_categoria_prog
																					FROM presto.tpr_presupuesto pres
																					WHERE	 pres.id_parametro=$m_id_parametro and pres.tipo_pres in ( $m_tipo_pres )  )	  ";
     }
	 
	
	 
	  if($m_estado)
	 {
		$criterio_filtro=$criterio_filtro."  AND CATPRO.estado=''$m_estado''  ";
	 }
	
	//Obtiene el total de los registros
	$res = $Custom -> ContarCategoriaProg($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCategoriaProg($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		 if($oc=="si")
		 {
			$xml->add_rama('ROWS');			
			$xml->add_nodo('id_categoria_prog','%');
			$xml->add_nodo('id_programa','Todos');
			$xml->add_nodo('cod_programa','Todos');
			$xml->add_nodo('desc_programa','Todos');
			$xml->add_nodo('id_proyecto','Todos');
			$xml->add_nodo('cod_proyecto','Todos');
			$xml->add_nodo('desc_proyecto','Todos');
			$xml->add_nodo('id_actividad','Todos');
			$xml->add_nodo('cod_actividad','Todos');
			$xml->add_nodo('desc_actividad','Todos');
			$xml->add_nodo('id_organismo_fin','Todos');
			$xml->add_nodo('cod_organismo_fin','Todos');
			$xml->add_nodo('desc_organismo_fin','Todos');
			$xml->add_nodo('id_fuente_financiamiento','Todos');
			$xml->add_nodo('cod_fuente_financiamiento','Todos');
			$xml->add_nodo('desc_fuente_financiamiento','Todos');	
			$xml->add_nodo('login','Todos');
			$xml->add_nodo('fecha_reg','Todos');
			$xml->add_nodo('id_parametro','Todos');
			$xml->add_nodo('desc_parametro','Todos');
			$xml->add_nodo('cod_categoria_prog','Todos');
			$xml->add_nodo('descripcion_cp','Todos');
			$xml->add_nodo('estado','Todos');
			$xml->add_nodo('usuario_mod','Todos');
			$xml->add_nodo('fecha_mod','Todos');
			$xml->add_nodo('codigo_sisin','Todos');
			$xml->add_nodo('cant_presupuestos','Todos');				
		 
			$xml->fin_rama();
		 }
		 
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_categoria_prog',$f["id_categoria_prog"]);
			$xml->add_nodo('id_programa',$f["id_programa"]);
			$xml->add_nodo('cod_programa',$f["cod_programa"]);
			$xml->add_nodo('desc_programa',$f["desc_programa"]);
			$xml->add_nodo('id_proyecto',$f["id_proyecto"]);
			$xml->add_nodo('cod_proyecto',$f["cod_proyecto"]);
			$xml->add_nodo('desc_proyecto',$f["desc_proyecto"]);
			$xml->add_nodo('id_actividad',$f["id_actividad"]);
			$xml->add_nodo('cod_actividad',$f["cod_actividad"]);
			$xml->add_nodo('desc_actividad',$f["desc_actividad"]);
			$xml->add_nodo('id_organismo_fin',$f["id_organismo_fin"]);
			$xml->add_nodo('cod_organismo_fin',$f["cod_organismo_fin"]);
			$xml->add_nodo('desc_organismo_fin',$f["desc_organismo_fin"]);
			$xml->add_nodo('id_fuente_financiamiento',$f["id_fuente_financiamiento"]);
			$xml->add_nodo('cod_fuente_financiamiento',$f["cod_fuente_financiamiento"]);
			$xml->add_nodo('desc_fuente_financiamiento',$f["desc_fuente_financiamiento"]);	
			$xml->add_nodo('login',$f["login"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('id_parametro',$f["id_parametro"]);
			$xml->add_nodo('desc_parametro',$f["desc_parametro"]);
			$xml->add_nodo('cod_categoria_prog',$f["cod_categoria_prog"]);
			$xml->add_nodo('descripcion_cp',$f["descripcion_cp"]);
			$xml->add_nodo('estado',$f["estado"]);
			$xml->add_nodo('usuario_mod',$f["usuario_mod"]);
			$xml->add_nodo('fecha_mod',$f["fecha_mod"]);
			$xml->add_nodo('codigo_sisin',$f["codigo_sisin"]);
			$xml->add_nodo('cant_presupuestos',$f["cant_presupuestos"]);

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