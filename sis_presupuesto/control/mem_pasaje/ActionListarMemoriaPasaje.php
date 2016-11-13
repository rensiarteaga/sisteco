<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarMemoria.php
Propósito:				Permite realizar el listado en tpr_mem_pasaje
Tabla:					t_tpr_mem_pasaje
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-08-25 18:50:55
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarActionListarMemoriaPasaje.php';

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
	if($sw_combo!="si"){
	$cond->add_criterio_extra("MEMCAL.id_memoria_calculo",$m_id_memoria_calculo);}
	
	$cond->add_criterio_extra("MEMPAS.id_moneda",$m_id_moneda);
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	//Obtiene el criterio de orden de columnas
	if($sw_combo=="si")
	{
		$criterio_filtro=$criterio_filtro." and MEMPAS.id_mem_pasaje not in (select COALESCE(id_mem_pasaje,''0'') from  presto.tpr_mem_viaje) ";	
	
	
/*	$criterio_filtro=$criterio_filtro." and MEMPAS.id_mem_pasaje in( select mpa.id_mem_pasaje from presto.tpr_presupuesto pre 
inner join presto.tpr_partida_presupuesto ppr on pre.id_presupuesto=ppr.id_presupuesto
inner join presto.tpr_memoria_calculo mca on mca.id_partida_presupuesto=ppr.id_partida_presupuesto
INNER join  presto.tpr_mem_pasaje mpa on mca.id_memoria_calculo=mpa.id_memoria_calculo
where pre.id_fina_regi_prog_proy_acti in
(
select aes.id_fina_regi_prog_proy_acti from sss.tsg_asignacion_estructura_tpm_frppa aes where aes.id_asignacion_estructura in 
(select usa.id_asignacion_estructura from  sss.tsg_usuario_asignacion usa
where usa.id_usuario=".$_SESSION["ss_id_usuario"].")))  ";	*/
/*	
$criterio_filtro=$criterio_filtro." and MEMPAS.id_mem_pasaje in(  select  mpa.id_mem_pasaje
from presto.tpr_partida_presupuesto ppr
     inner join presto.tpr_memoria_calculo mca on ppr.id_partida_presupuesto =
      mca.id_partida_presupuesto
     inner join presto.tpr_mem_pasaje mpa on mca.id_memoria_calculo =
      mpa.id_memoria_calculo
where id_presupuesto in (select id_presupuesto from presto.tpr_presupuesto
 where id_unidad_organizacional in (select id_unidad_organizacional from
  presto.tpr_usuario_autorizado where id_usuario =".$_SESSION["ss_id_usuario"].")))   ";	*/
	$criterio_filtro=$criterio_filtro." and  MEMPAS.id_mem_pasaje in (select id_mem_pasaje from presto.tpr_partida_presupuesto ppr 
	inner join presto.tpr_memoria_calculo mca on ppr.id_partida_presupuesto=mca.id_partida_presupuesto
	inner join  presto.tpr_mem_pasaje mpa on mca.id_memoria_calculo=mpa.id_memoria_calculo

	where ppr.id_presupuesto in 
	(select id_presupuesto from presto.tpr_partida_presupuesto where id_partida_presupuesto 
	in(select id_partida_presupuesto from presto.tpr_memoria_calculo where id_memoria_calculo =	 ".$m_id_memoria_calculo."))) ";	
	
	}
	
	if($filtro==1){
		$criterio_filtro=$criterio_filtro." AND MEMPAS.id_moneda=".$valor_filtro;
	}
	
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'MemPasaje');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarMemoriaPasaje($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarMemoriaPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_mem_pasaje',$f["id_mem_pasaje"]);
			$xml->add_nodo('id_destino',$f["id_destino"]);
			$xml->add_nodo('desc_destino',$f["desc_destino"]);
			$xml->add_nodo('nombre_lugar',$f["nombre_lugar"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
			$xml->add_nodo('periodo_pres',$f["periodo_pres"]);
			$xml->add_nodo('total_general',$f["total_general"]);
			$xml->add_nodo('id_memoria_calculo',$f["id_memoria_calculo"]);
			$xml->add_nodo('desc_memoria_calculo',$f["desc_memoria_calculo"]);
			$xml->add_nodo('id_categoria',$f["id_categoria"]);
			$xml->add_nodo('desc_categoria',number_format($f["desc_categoria"]));

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