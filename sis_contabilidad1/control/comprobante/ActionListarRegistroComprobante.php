<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarRegistroComprobante.php
Propósito:				Permite realizar el listado en tct_comprobante
Tabla:					tct_tct_comprobante
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-09-16 17:55:38
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloContabilidad.php');


$Custom = new cls_CustomDBContabilidad();

$nombre_archivo = 'ActionListarRegistroComprobante.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 30;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_comprobante';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'desc';
	else $sortdir = $dir;

	//Verifica si se hara o no la decodificacion(solo pregunta en caso del GET)
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

	//Verifica si se mANDa la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mANDar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$_POST['CantFiltros'];$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	//if($m_id_comprobante!=''){
	$cond->add_criterio_extra("COMPRO.id_comprobante",$m_id_comprobante);
	/*}else{
	$cond->add_criterio_extra("COMPRO.id_usuario",$_SESSION["ss_id_usuario"]);}
	*/
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	$id_usuario=$_SESSION["ss_id_usuario"];
	if($m_sw_maximo=='si'){
		$criterio_filtro=$criterio_filtro." AND COMPRO.id_comprobante in
		(select max(com.id_comprobante) from sci.tct_comprobante com where com.id_usuario=".$_SESSION["ss_id_usuario"]."  ) ";
	}
		
	if($m_sw_vista=='presupuesto'){
		$criterio_filtro=$criterio_filtro."  AND cbest.estado_cbte=2 AND cbest.sw_estado=1  AND COMPRO.momento_cbte in (5) ";		
	}
	
	if($m_sw_vista=='contablePresupuestario'){
		$criterio_filtro=$criterio_filtro."  AND cbest.estado_cbte=2 AND cbest.sw_estado=1  AND COMPRO.momento_cbte in (1,2,3,4) AND compro.id_subsistema=9 ";
	}
	
	if($m_sw_vista=='contable'){	
		$criterio_filtro=$criterio_filtro."  AND cbest.estado_cbte=2 AND cbest.sw_estado=1  AND COMPRO.momento_cbte in (0) AND compro.id_subsistema=9";
	}
	
	if($m_sw_vista=='validacion'){  
		$criterio_filtro=$criterio_filtro."  AND cbest.estado_cbte=2 AND cbest.sw_estado=1  AND COMPRO.id_subsistema=9 ";
	}
	
	if($m_sw_vista=='validacionGenerados'){ 	
		$criterio_filtro=$criterio_filtro." AND cbest.estado_cbte=2 AND cbest.sw_estado=1  AND COMPRO.id_subsistema!=9 ";
	//RCM 10062010: Actualización Edición Comprobantes validados
		$criterio_filtro=$criterio_filtro.' AND COMPRO.id_comprobante <= 18142 ';
	//FIN RCM
	}
	if($m_sw_vista=='validacionGeneradosAuxiliar'){ 	
		$criterio_filtro=$criterio_filtro." AND COMPRO.id_subsistema!=9 ";
	}
	
	if($m_sw_vista=='gestionar_cbte'){ 	
		$criterio_filtro=$criterio_filtro."  AND cbest.estado_cbte=2 AND cbest.sw_estado=1  ";
	//RCM 10062010: Actualización Edición Comprobantes validados
		$criterio_filtro=$criterio_filtro.' AND (COMPRO.id_comprobante > 18142 OR COMPRO.id_subsistema = 9) ';
	//FIN RCM
	}	
	
	if($m_sw_vista=='editar_cbte'){ 	
		$criterio_filtro=$criterio_filtro."  AND cbest.estado_cbte=3 AND cbest.sw_estado=1  ";
		$criterio_filtro=$criterio_filtro."  AND (compro.id_usuario_mod=$id_usuario or COALESCE ((SELECT DISTINCT TRUE FROM sss.tsg_usuario_rol usrol WHERE usrol.id_usuario = $id_usuario AND usrol.id_rol IN (1,313)), FALSE))";
	}
	
	if($m_sw_vista=='libro_diario'){ 	
		$criterio_filtro=$criterio_filtro."  AND cbest.estado_cbte=1 AND cbest.sw_estado=1 ";
	}
	if($m_sw_vista=='caiff'){
		
		$criterio_filtro=$criterio_filtro." AND COMPRO.fecha_cbte BETWEEN (SELECT fecha_inicio
		                                                                   FROM presto.tpr_caiff_detalle
		                                                                   WHERE id_caiff=$m_id_caiff) AND (SELECT fecha_fin
											                                                                FROM presto.tpr_caiff_detalle
											                                                                WHERE id_caiff=$m_id_caiff) ";
	}
	if($sw_reg_comp=='si' && $m_id_depto!=''){ 	
		$criterio_filtro=$criterio_filtro."  AND compro.id_depto=$m_id_depto AND cbest.estado_cbte in (1,3) AND cbest.sw_estado=1 ";
	}
	
	$ids_depto='0';
	$ids_depto=$ids_depto.$_POST['m_ids_depto'];
	if (($m_sw_vista =='gestionar_cbte'||$m_sw_vista =='libro_diario' )&&$ids_depto&&$m_fecha_inicio&&$m_fecha_fin) {
		if ($ids_depto!='0'){
			$criterio_filtro=$criterio_filtro." AND compro.id_depto in ($ids_depto)   AND COMPRO.fecha_cbte BETWEEN ''$m_fecha_inicio'' AND ''$m_fecha_fin''";
		}
		if ($ids_depto=='0'){
			$criterio_filtro=$criterio_filtro." AND COMPRO.fecha_cbte BETWEEN ''$m_fecha_inicio'' AND ''$m_fecha_fin''";
		}
	}
	
	if($m_tipo_vista=='libro_diario'){ 
		($ids_financiador) == ""? $ids_financiador="\'NULL\'": $ids_financiador;
		(($ids_regional) == "")? $ids_regional="\'NULL\'": $ids_regional;
		(($ids_programa) == "")? $ids_programa="\'NULL\'": $ids_programa;
		(($ids_proyecto) == "")? $ids_proyecto="\'NULL\'": $ids_proyecto;
		(($ids_actividad) == "")? $ids_actividad="\'NULL\'": $ids_actividad;
		$criterio_filtro=$criterio_filtro." AND COMPRO.id_clase_cbte=$m_id_clase_cbte AND COMPRO.fecha_cbte >=''$m_fecha_inicio'' AND COMPRO.fecha_cbte <= ''$m_fecha_fin''";
		$criterio_filtro=$criterio_filtro." AND COMPRO.id_comprobante IN (select transa.id_comprobante from sci.tct_transaccion transa where transa.id_fina_regi_prog_proy_acti IN (presto.f_tpr_get_EP($ids_programa,$ids_proyecto,$ids_actividad,$ids_regional,$ids_financiador,$id_usuario)))";
	}
	
	if($m_vista_siet=='siet_cbte'){
		//$sortcol = 'nro_cbte';
		$criterio_filtro="  COMPRO.id_comprobante in (SELECT distinct c.id_comprobante
												FROM sci.tct_comprobante c
												WHERE
												      id_clase_cbte in (5,6)
												      and c.id_comprobante not in (SELECT id_cbte 
												      							   FROM sigma.tsi_siet_cbte 
												                                   WHERE  id_cbte=c.id_comprobante)
												      and c.id_periodo_subsis in ( SELECT id_periodo_subsistema
												      								FROM param.tpm_periodo_subsistema 
												                                    WHERE id_subsistema=9 and id_periodo in (                         
												     																		 SELECT id_periodo
												     																		 FROM sigma.tsi_siet_declara
												                                                                             WHERE id_siet_declara=27 ) )   )  ";
													}
	if($m_sw_vista=='sigma'){ 	
		$sortcol = 'nro_cbte';
		$criterio_filtro=$criterio_filtro."  AND cbest.estado_cbte=1 AND cbest.sw_estado=1 AND COMPRO.id_subsistema = 9 AND COMPRO.id_clase_cbte IN (1,7) AND COMPRO.origen NOT IN (''actualizacion'',''cierre_apertura'')
											 AND COMPRO.id_periodo_subsis IN (select ps.id_periodo_subsistema from sigma.tsi_declaracion sd inner join param.tpm_periodo_subsistema ps on sd.id_periodo = ps.id_periodo and ps.id_subsistema = 9 and sd.id_declaracion = $m_id_declaracion) ";
	}
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Comprobante');
	$sortcol = $crit_sort->get_criterio_sort();
	/*if ($_SESSION["ss_id_usuario"]==131){
		echo $criterio_filtro;
		exit;
	}*/
	//$cant=21;
	//Obtiene el total de los registros
	$res = $Custom -> ContarRegistroComprobante($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarRegistroComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_comprobante',$f["id_comprobante"]);
			$xml->add_nodo('id_parametro',$f["id_parametro"]);
			$xml->add_nodo('desc_parametro',$f["desc_parametro"]);
			$xml->add_nodo('nro_cbte',$f["nro_cbte"]);
			$xml->add_nodo('momento_cbte',$f["momento_cbte"]);
			$xml->add_nodo('fecha_cbte',$f["fecha_cbte"]);
			$xml->add_nodo('concepto_cbte',$f["concepto_cbte"]);
			$xml->add_nodo('glosa_cbte',$f["glosa_cbte"]);
			$xml->add_nodo('acreedor',$f["acreedor"]);
			$xml->add_nodo('aprobacion',$f["aprobacion"]);
			$xml->add_nodo('conformidad',$f["conformidad"]);
			$xml->add_nodo('pedido',$f["pedido"]);
			$xml->add_nodo('id_periodo_subsis',$f["id_periodo_subsis"]);
			$xml->add_nodo('desc_periodo',$f["desc_periodo"]);
			$xml->add_nodo('id_moneda_reg',$f["id_moneda_reg"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
			$xml->add_nodo('id_usuario',$f["id_usuario"]);
			$xml->add_nodo('desc_usuario',$f["desc_usuario"]);
			$xml->add_nodo('id_subsistema',$f["id_subsistema"]);
			$xml->add_nodo('desc_subsistema',$f["desc_subsistema"]);
			$xml->add_nodo('id_cbte_clase',$f["id_cbte_clase"]);
			$xml->add_nodo('desc_clase',$f["desc_clases"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
			$xml->add_nodo('id_gestion',$f["id_gestion"]);
			$xml->add_nodo('nombre_depto',$f["nombre_depto"]);
			$xml->add_nodo('id_depto',$f["id_depto"]); 
			$xml->add_nodo('titulo_cbte',$f["titulo_cbte"]);
			$xml->add_nodo('fecha_inicio',$f["fecha_inicio"]);
			$xml->add_nodo('fecha_final',$f["fecha_final"]);
			$xml->add_nodo('id_moneda_cbte',$f["id_moneda_cbte"]);
			$xml->add_nodo('tipo_cambio',$f["tipo_cambio"]);
			$xml->add_nodo('nombre_moneda_cbte',$f["nombre_moneda_cbte"]);
			$xml->add_nodo('prioridad_moneda_cbte',$f["prioridad_moneda_cbte"]);
			$xml->add_nodo('fk_comprobante',$f["fk_comprobante"]);
			$xml->add_nodo('desc_cbte',$f["desc_cbte"]);
			$xml->add_nodo('fk_desc_cbte',$f["fk_desc_cbte"]);
			$xml->add_nodo('tipo_relacion',$f["tipo_relacion"]);
 			$xml->add_nodo('estado_cbte',$f["estado_cbte"]);
 			$xml->add_nodo('sw_activo_fijo',$f["sw_activo_fijo"]);
 			$xml->add_nodo('cbtes_depen',$f["cbtes_depen"]);
 			$xml->add_nodo('variacion_tc',$f["variacion_tc"]);
 			$xml->add_nodo('sw_caif_rep',$f["sw_caif_rep"]);
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