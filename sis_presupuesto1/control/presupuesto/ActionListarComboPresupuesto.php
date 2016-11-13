<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarFormulacionPresupuesto.php
Propósito:				Permite realizar el listado en tpr_presupuesto
Tabla:					tpr_tpr_presupuesto
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-07-10 09:08:14
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarComboPresupuesto .php';

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

	if($sort == '') $sortcol = 'id_presupuesto';
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
    
	if ($sw_reg_comp=='si'&& $m_id_depto && $m_id_parametro_conta){ 
		$criterio_filtro=	$criterio_filtro." and presup.id_fina_regi_prog_proy_acti in (select id_ep from param.tpm_depto_ep where id_depto=$m_id_depto)";
		$criterio_filtro=	$criterio_filtro." and presup.id_parametro in (	select id_parametro 
															from presto.tpr_parametro 
															where id_gestion in (	select id_gestion 
																					from sci.tct_parametro 
																					where id_parametro=$m_id_parametro_conta))";
	}
	
	if($m_nombre_vista=='rendicion_viaticos'){$criterio_filtro= $criterio_filtro." and presup.id_unidad_organizacional = $m_id_uo ";}
	
	if($sw_inv_gasto=='si')	{$criterio_filtro= $criterio_filtro." and presup.tipo_press  in (0,2,3,5,6)";}
	
	if($m_id_concepto_gasto!=''){
		$criterio_filtro= $criterio_filtro." and presup.id_presupuesto  in (select id_presupuesto  from presto.tpr_partida_presupuesto  
																			where id_partida  in (	select id_partida 
																									from presto.tpr_concepto_ingas 
																			                        where id_concepto_ingas = $m_id_concepto_gasto)
																			union
																		 	select id_presupuesto 
																			from param.tpm_depto_conta 	
																			where (select sw_movimiento=2 
																					from presto.tpr_partida 
																					where id_partida in (	select id_partida 
																											from presto.tpr_concepto_ingas 
																			              				    where id_concepto_ingas =$m_id_concepto_gasto)
																			         ) 	
																			)";
	}
	
	if ($m_sw_menu_boton=='si'){
		$criterio_filtro= $criterio_filtro."  AND presup.id_parametro > 1 ";
	}
	if ($m_fecha_fin){
		$criterio_filtro= $criterio_filtro."  AND presup.estado_gral < 6 ";
		//$criterio_filtro= $criterio_filtro."  AND presup.id_gestion in (select id_gestion from param.tpm_periodo where fecha_final = ''$m_fecha_fin'') ";
	}
	
	if ($avance=='si'){
		$criterio_filtro= $criterio_filtro." AND presup.id_fina_regi_prog_proy_acti  in (SELECT id_ep from param.tpm_depto_ep where id_depto=$id_departamento AND estado=''activo'' AND id_ep IN (SELECT id_fina_regi_prog_proy_acti FROM kard.tkp_empleado_tpm_frppa WHERE id_empleado=$id_empleado_reg))";
	}
	
	if (isset($id_depto)){
		$criterio_filtro= $criterio_filtro." AND presup.id_fina_regi_prog_proy_acti  in (select id_ep from param.tpm_depto_ep where id_depto=$id_depto and estado=''activo'') ";
	}
	
	//comentado por un conflicto con la variable id_parametro en la vista compro->parametros->clasificacion de servicios->tipo servicio cuenta partida->listado de presupuesto
	if(isset($id_parametro)){
		$criterio_filtro= $criterio_filtro." AND presup.id_parametro = $id_parametro ";
	}
	
	if(isset($id_gestion)){// para combo presupuesto en vistas ServicioCuentaPartida(compro) e ItemCuentaPartida(almin)
		$criterio_filtro=	$criterio_filtro." and presup.id_parametro in (	select id_parametro 
															from presto.tpr_parametro 
															where id_gestion =$id_gestion)";
	}
	
	if(isset($m_id_solicitante)){ //8ago11: filtro de presupuestos que coincidan con la ep que tiene el empleado, usado en vista compro.tad_solicitud_compra
		$criterio_filtro=	$criterio_filtro." and presup.tipo_press in (1,2,3) and presup.id_fina_regi_prog_proy_acti in (	 select id_fina_regi_prog_proy_acti from kard.tkp_empleado_tpm_frppa where id_empleado=$m_id_solicitante)";
	}
	
	$id_usuario=$_SESSION["ss_id_usuario"];
	 
	if ($vista=='libro_mayor_partida'){
		$criterio_filtro= $criterio_filtro." AND presup.id_parametro in (
																		select param.id_parametro
																		from param.tpm_gestion gestio
																		inner join presto.tpr_parametro param on (param.id_gestion=gestio.id_gestion) 
																		where gestio.id_gestion=$id_gestion_rlm) AND presup.id_fina_regi_prog_proy_acti  in (select id_ep from param.tpm_depto_ep where id_depto like ''$rlmp_id_depto'' and estado=''activo'') and presup.id_fina_regi_prog_proy_acti in (select aep.id_fina_regi_prog_proy_acti from sss.tsg_usuario_asignacion usa
										inner join sss.tsg_asignacion_estructura ase
                                        on usa.id_asignacion_estructura=ase.id_asignacion_estructura
										inner join sss.tsg_asignacion_estructura_tpm_frppa aep
                                        on aep.id_asignacion_estructura=ase.id_asignacion_estructura
										where usa.id_usuario=$id_usuario) ";
	}
	
	//25/11/2013: adicion de filtro para sistema de seguridad
	if(isset($m_id_asignacion_estructura)){
		$criterio_filtro= $criterio_filtro." AND presup.id_fina_regi_prog_proy_acti in (
			select id_fina_regi_prog_proy_acti from sss.tsg_asignacion_estructura_tpm_frppa where id_asignacion_estructura =$m_id_asignacion_estructura)";
	}
	
	//FACTUR
	if($m_id_factura!=''){
		$criterio_filtro= $criterio_filtro." AND presup.tipo_press IN ($m_tipo_press) AND presup.id_parametro IN (SELECT id_parametro FROM presto.tpr_parametro WHERE id_gestion IN 
												 (SELECT id_gestion FROM factur.tfv_factura WHERE id_factura = $m_id_factura))";
	}
	
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Presupuesto');
	$sortcol = $crit_sort->get_criterio_sort();
	//if($_SESSION["ss_id_usuario"]==120){echo $criterio_filtro; exit;}
	//Obtiene el total de los registros
	$res = $Custom -> ContarComboPresupuesto($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarComboPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	//echo $Custom->query;
	//exit;
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
        if($oc=="si"){
     		$xml->add_rama('ROWS');
	        $xml->add_nodo('id_presupuesto','%');
	        $xml->add_nodo('tipo_pres','Todos');
	        $xml->add_nodo('estado_pres','Todos');
	        $xml->add_nodo('id_unidad_organizacional','Todos');
	        $xml->add_nodo('nombre_unidad','Todos');
	        $xml->add_nodo('id_fina_regi_prog_proy_acti','%');
	        $xml->add_nodo('desc_epe','Todos');
	        $xml->add_nodo('id_fuente_financiamiento','Todos');
	        $xml->add_nodo('sigla','Todos');
	        $xml->add_nodo('id_parametro','Todos');
	        $xml->add_nodo('gestion_pres','Todos');
	        $xml->add_nodo('estado_gral','Todos');
	        $xml->add_nodo('id_gestion','Todos');
	        $xml->add_nodo('desc_presupuesto','Todos');
	        $xml->add_nodo('nombre_financiador','Todos');
	        $xml->add_nodo('nombre_regional','Todos');
	        $xml->add_nodo('nombre_programa','Todos');
	        $xml->add_nodo('nombre_proyecto','Todos');
	        $xml->add_nodo('nombre_actividad','Todos');
		 
			$xml->fin_rama();
        }
        
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_presupuesto',$f["id_presupuesto"]);
			$xml->add_nodo('tipo_pres',$f["tipo_pres"]);
			$xml->add_nodo('estado_pres',$f["estado_pres"]);
			$xml->add_nodo('id_unidad_organizacional',$f["id_unidad_organizacional"]);
			$xml->add_nodo('nombre_unidad',$f["nombre_unidad"]);
			$xml->add_nodo('id_fina_regi_prog_proy_acti',$f["id_fina_regi_prog_proy_acti"]);
			$xml->add_nodo('desc_epe',$f["desc_epe"]);
			$xml->add_nodo('id_fuente_financiamiento',$f["id_fuente_financiamiento"]);
			$xml->add_nodo('sigla',$f["sigla"]);
			$xml->add_nodo('id_parametro',$f["id_parametro"]);
			$xml->add_nodo('gestion_pres',$f["gestion_pres"]);
			$xml->add_nodo('estado_gral',$f["estado_gral"]);
			$xml->add_nodo('id_gestion',$f["id_gestion"]);
			$xml->add_nodo('desc_presupuesto',$f["desc_presupuesto"]);
			$xml->add_nodo('nombre_financiador',$f["nombre_financiador"]);
			$xml->add_nodo('nombre_regional',$f["nombre_regional"]);
			$xml->add_nodo('nombre_programa',$f["nombre_programa"]);
			$xml->add_nodo('nombre_proyecto',$f["nombre_proyecto"]);
			$xml->add_nodo('nombre_actividad',$f["nombre_actividad"]);
			
			$xml->add_nodo('id_categoria_prog',$f["id_categoria_prog"]);
			$xml->add_nodo('cod_categoria_prog',$f["cod_categoria_prog"]);
			$xml->add_nodo('cp_cod_programa',$f["cp_cod_programa"]);		
			$xml->add_nodo('cp_cod_proyecto',$f["cp_cod_proyecto"]);
			$xml->add_nodo('cp_cod_actividad',$f["cp_cod_actividad"]);
			$xml->add_nodo('cp_cod_organismo_fin',$f["cp_cod_organismo_fin"]);
			$xml->add_nodo('cp_cod_fuente_financiamiento',$f["cp_cod_fuente_financiamiento"]);
			$xml->add_nodo('codigo_sisin',$f["codigo_sisin"]);
			//jun2015
			$xml->add_nodo('obliga_ot',$f["obliga_ot"]);
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
