<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarPartida.php
Propósito:				Permite realizar el listado en tpr_partida
Tabla:					tpr_tpr_partida
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-07-07 11:38:59
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarPartida .php';

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

	if($sort == '') $sortcol = 'partid.codigo_partida';
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
	
	$tipo_partida = $_GET["tipo_partida"];
	if($tipo_partida == null){
		
		$tipo_partida = $_POST["tipo_partida"];
	}
	$cond->add_criterio_extra("PARTID.id_concepto_colectivo",$id_concepto_colectivo);
	$criterio_filtro = $cond -> obtener_criterio_filtro();
		
	if($tipo_partida!=''){
		$criterio_filtro=$criterio_filtro." AND PARTID.tipo_partida=$tipo_partida";
	}
	
	if ($sw_reg_comp == 'si' && $m_id_presupuesto){
		$criterio_filtro=$criterio_filtro." AND PARTID.id_partida IN (SELECT id_partida FROM presto.tpr_partida_presupuesto 
																	  WHERE id_presupuesto =".$m_id_presupuesto."
																	  UNION
																	  SELECT id_partida FROM presto.tpr_partida WHERE sw_movimiento=2 AND  sw_transaccional=1 and
																		   id_parametro IN (SELECT id_parametro FROM presto.tpr_parametro WHERE id_gestion=".$m_id_gestion.")	   
																	) ";
	}

	if ($sw_traspaso == 'si' && $m_id_presupuesto){		
		if($m_id_presupuesto != '%'){		
			$criterio_filtro=$criterio_filtro." AND PARTID.id_partida IN (	SELECT id_partida 
																			FROM presto.tpr_partida_presupuesto 
																			WHERE id_presupuesto =".$m_id_presupuesto." ) ";	
		}else{
			//cuando la opcion seleccionada del combo de presupuestos es TODOS
			if ($m_id_parametro){
				$criterio_filtro=$criterio_filtro." AND  PARTID.id_partida IN (	SELECT distinct partid.id_partida
																				FROM presto.tpr_presupuesto presup
																				INNER JOIN presto.tpr_partida_presupuesto parpre ON (parpre.id_presupuesto=presup.id_presupuesto)
																				INNER JOIN presto.tpr_partida partid ON (parpre.id_partida=partid.id_partida)
																				WHERE presup.tipo_pres IN ($m_id_tipo_pres) AND partid.id_parametro = $m_id_parametro)";
	 		}																
			if ($m_id_gestion){
				$criterio_filtro=$criterio_filtro." AND  PARTID.id_partida IN (	SELECT distinct partid.id_partida
																				FROM presto.tpr_presupuesto presup
																				INNER JOIN presto.tpr_partida_presupuesto parpre ON (parpre.id_presupuesto = presup.id_presupuesto)
																				INNER JOIN presto.tpr_partida partid ON (parpre.id_partida=partid.id_partida)
																				WHERE presup.tipo_pres IN ($m_id_tipo_pres) AND partid.id_parametro IN (SELECT id_parametro FROM presto.tpr_parametro WHERE id_gestion = ".$m_id_gestion."))";
			}	
		}			
	}
	
	if ($sw_flujo == 'si' && $m_id_presupuesto){
		$criterio_filtro=$criterio_filtro." AND PARTID.id_partida IN (	SELECT id_partida 
																		FROM presto.tpr_partida_presupuesto 
																		WHERE id_presupuesto =".$m_id_presupuesto." 
																		UNION
																		SELECT id_partida
																		FROM presto.tpr_partida
																		WHERE sw_movimiento=2 AND  sw_transaccional=1 AND
																		id_parametro IN (SELECT id_parametro FROM presto.tpr_presupuesto WHERE id_presupuesto=".$m_id_presupuesto.")
																	) ";
	}
	
	if($id_parametro == ''){
		$id_parametro=$rep_id_parametro;
	}
	
	if ($sw_vista_reporte == 'rep_ejecucion_partida'){      
		$criterio_filtro=$criterio_filtro." AND  PARTID.id_partida IN (	SELECT distinct partid.id_partida
																		FROM presto.tpr_presupuesto presup
																		INNER JOIN presto.tpr_partida_presupuesto parpre ON (parpre.id_presupuesto=presup.id_presupuesto)
																		INNER JOIN presto.tpr_partida partid ON (parpre.id_partida=partid.id_partida)
																		WHERE presup.tipo_pres=$id_tipo_pres AND partid.id_parametro=$id_parametro)
 																		";
	}

	//Para listar en el reporte de formulacion por partida 
	if ($sw_vista_reporte == 'rep_formulacion_partida')
	{      
		$criterio_filtro=$criterio_filtro." AND  PARTID.id_partida IN (	SELECT distinct partid.id_partida
																		FROM presto.tpr_presupuesto presup
																		INNER JOIN presto.tpr_partida_presupuesto parpre ON (parpre.id_presupuesto=presup.id_presupuesto)
																		INNER JOIN presto.tpr_partida partid ON (parpre.id_partida=partid.id_partida)
																		WHERE presup.tipo_pres=$id_tipo_presupuesto_rgi AND partid.id_parametro=$id_parametro)
 																		";
	}
	//Para el reporte de Procesos en curso
	if ($vista == 'rep_procesos_en_curso'){      
		$criterio_filtro=$criterio_filtro." AND  PARTID.id_partida IN (	SELECT distinct partid.id_partida
																		FROM presto.tpr_presupuesto presup
																		INNER JOIN presto.tpr_partida_presupuesto parpre ON (parpre.id_presupuesto=presup.id_presupuesto)
																		INNER JOIN presto.tpr_partida partid ON (parpre.id_partida=partid.id_partida)
																		WHERE presup.id_presupuesto like ''$rep_procur_id_presupuesto'' AND partid.id_parametro IN (SELECT id_parametro FROM presto.tpr_parametro WHERE id_gestion=$id_gestion))
 																		";
	}
	
	if($sw_transaccional == 1){
		$criterio_filtro=$criterio_filtro." AND PARTID.sw_transaccional=1 AND PARTID.id_parametro IN (SELECT id_parametro FROM presto.tpr_parametro WHERE id_gestion=".$id_gestion_reporte.")";
	}
	
	// agregado para el filtro de la vista sis_parametros/vista/depto_conta/js/departamento_conta.js AND partid.sw_movimiento=1 
    if($sw_movimiento == 1){
    	$criterio_filtro=$criterio_filtro. " AND partid.sw_transaccional=1 "; 
    }
	if($m_gestion){
		$criterio_filtro=$criterio_filtro." AND PARTID.id_parametro IN (SELECT id_parametro FROM presto.tpr_parametro WHERE gestion_pres=".$m_gestion.")";
	}
	if($m_id_gestion){
		$criterio_filtro=$criterio_filtro." AND PARTID.sw_movimiento=2 AND  PARTID.sw_transaccional=1 AND PARTID.id_parametro IN (SELECT id_parametro FROM presto.tpr_parametro WHERE id_gestion=".$m_id_gestion.")";
	}
	if($sw_ges_vigente){
		$criterio_filtro= $criterio_filtro. " AND PARAMP.gestion_pres IN (SELECT gestion FROM param.tpm_gestion WHERE estado_vigente = ''si'') ";
	}
	
	if($m_id_eeff){
		if($m_vigente == 'si'){
			$criterio_filtro = $criterio_filtro. " AND GESTION.id_gestion IN (SELECT id_gestion_act FROM presto.tpr_eeff WHERE id_eeff = ".$m_id_eeff.")";
		}else{
			$criterio_filtro = $criterio_filtro. " AND GESTION.id_gestion IN (SELECT id_gestion_ant FROM presto.tpr_eeff WHERE id_eeff = ".$m_id_eeff.")";
		}
	}
	
	/*echo $criterio_filtro;
	exit;*/
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Partida');
	$sortcol = $crit_sort->get_criterio_sort();

	//Obtiene el total de los registros
	$res = $Custom -> ContarPartida($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		if($oc == "si"){
         	$xml->add_rama('ROWS');
         	$xml->add_nodo('id_partida','%');
			$xml->add_nodo('codigo_partida','Todos');
			$xml->add_nodo('nombre_partida','Todos');
			$xml->add_nodo('desc_par','Todos');
			$xml->add_nodo('nivel_partida','Todos');
			$xml->add_nodo('sw_transaccional','Todos');
			$xml->add_nodo('tipo_partida','Todos');
			$xml->add_nodo('id_parametro','Todos');
			$xml->add_nodo('desc_parametro','Todos');
			$xml->add_nodo('id_partida_padre','Todos');
			$xml->add_nodo('descrip_partida','Todos');
			$xml->add_nodo('tipo_memoria','Todos');
			$xml->add_nodo('desc_partida','Todos');
			$xml->fin_rama();
        }
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_partida',$f["id_partida"]);
			$xml->add_nodo('codigo_partida',$f["codigo_partida"]);
			$xml->add_nodo('nombre_partida',$f["nombre_partida"]);
			$xml->add_nodo('desc_par',$f["codigo_partida"]." - ".$f["nombre_partida"]);
			$xml->add_nodo('nivel_partida',$f["nivel_partida"]);
			$xml->add_nodo('sw_transaccional',$f["sw_transaccional"]);
			$xml->add_nodo('tipo_partida',$f["tipo_partida"]);
			$xml->add_nodo('id_parametro',$f["id_parametro"]);
			$xml->add_nodo('desc_parametro',$f["desc_parametro"]);
			$xml->add_nodo('id_partida_padre',$f["id_partida_padre"]);
			$xml->add_nodo('descrip_partida',$f["descrip_partida"]);
			$xml->add_nodo('tipo_memoria',$f["tipo_memoria"]);
			$xml->add_nodo('desc_partida',$f["desc_partida"]);
			$xml->add_nodo('sw_movimiento',$f["sw_movimiento"]);
			//$xml->add_nodo('desc_partida_caif',$f["desc_partida_caif"]);

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