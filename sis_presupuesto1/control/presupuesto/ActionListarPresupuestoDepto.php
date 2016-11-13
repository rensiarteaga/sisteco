<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarFormulacionPresupuesto.php
Prop�sito:				Permite realizar el listado en tpr_presupuesto
Tabla:					tpr_tpr_presupuesto
Par�metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci�n:		2008-07-10 09:08:14
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarPresupuestoDepto.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Par�metros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'nombre_unidad';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
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
	
	//Aumentado para filtrar por id_presupuesto
	$cond->add_criterio_extra("PRESUP.id_presupuesto",$id_presupuesto);
	
	if($sw_reporte_ejecucion!='si'){
		
	//$cond->add_criterio_extra("PRESUP.tipo_pres",$tipo_pres);	
	}

 
 
	$criterio_filtro = $cond -> obtener_criterio_filtro();	
	if ($sw_reg_comp=='nuevo_edicion' && $m_id_depto && $m_id_parametro_conta){ 
				$criterio_filtro=	$criterio_filtro." and  PRESUP.id_presupuesto in (select id_presupuesto from  param.tpm_depto_conta where id_depto=$m_id_depto) ";
				$criterio_filtro=	$criterio_filtro." and PARAMP.id_gestion in  (	select id_gestion 
                                													from sci.tct_parametro 
                                													where id_parametro=$m_id_parametro_conta)";
		}
	
	if ($sw_reg_comp=='si'&& $m_id_depto && $m_id_parametro_conta){ 
				$criterio_filtro=	$criterio_filtro." and  DEP.id_depto=$m_id_depto"; // filtra las epes del deparatamento
				$criterio_filtro=	$criterio_filtro." and PARAMP.id_gestion in  (	select id_gestion 
                                													from sci.tct_parametro 
                                													where id_parametro=$m_id_parametro_conta)"; //filtra la gestion de las epes
      //         	if (  //$m_momento==0 || 
      //         			$m_nro_cbte!=0 || $m_id_subsistema!=9){                  													
      //          $criterio_filtro=	$criterio_filtro." and PRESUP.id_presupuesto in  (	select id_presupuesto 
      //          																		from param.tpm_depto_conta 
      //          																		where id_depto=$m_id_depto)";   
      //         	}
               														             													
                                													
		}
	if ($m_id_presupuesto && $m_nro_cbte!=0 ){ 
				$criterio_filtro=	$criterio_filtro." and  PRESUP.id_presupuesto =$m_id_presupuesto";
				 
		}
		
	if($id_gestion){
		$criterio_filtro=$criterio_filtro." AND PARAMP.id_gestion =$id_gestion and presup.id_unidad_organizacional in (select id_unidad_organizacional from kard.tkp_unidad_organizacional where sw_presto=1)";
	}
		
	if ($sw_reg_depto_conta=='si'&& $m_id_depto  ){ 
				$criterio_filtro=	$criterio_filtro." and  DEP.id_depto=$m_id_depto";
				$criterio_filtro=	$criterio_filtro." and PARAMP.gestion_pres in  (select gestion
																					from param.tpm_gestion 
																					 where estado_ges_gral=''abierto''  )";
		}	
	
		
	//max( gestion)
			
	
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'PresupuestoDepto');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarPresupuestoDepto($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarPresupuestoDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

        
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_presupuesto',$f["id_presupuesto"]);
			$xml->add_nodo('desc_presupuesto',$f["desc_presupuesto"]);
			$xml->add_nodo('tipo_pres',$f["tipo_pres"]);
			$xml->add_nodo('estado_pres',$f["estado_pres"]);
			$xml->add_nodo('id_fuente_financiamiento',$f["id_fuente_financiamiento"]); 
			$xml->add_nodo('nombre_fuente_financiamiento',$f["nombre_fuente_financiamiento"]);
			$xml->add_nodo('id_unidad_organizacional',$f["id_unidad_organizacional"]);
			$xml->add_nodo('nombre_unidad',$f["nombre_unidad"]);
			$xml->add_nodo('id_fina_regi_prog_proy_acti',$f["id_fina_regi_prog_proy_acti"]);
			$xml->add_nodo('desc_epe',$f["desc_epe"]);
			$xml->add_nodo('nombre_financiador',$f["nombre_financiador"]);
			$xml->add_nodo('nombre_regional',$f["nombre_regional"]);
			$xml->add_nodo('nombre_programa',$f["nombre_programa"]);
			$xml->add_nodo('nombre_proyecto',$f["nombre_proyecto"]);
			$xml->add_nodo('nombre_actividad',$f["nombre_actividad"]); 
			$xml->add_nodo('id_parametro',$f["id_parametro"]);
			$xml->add_nodo('gestion_pres',$f["gestion_pres"]);
			
			$xml->add_nodo('id_categoria_prog',$f["id_categoria_prog"]);
			$xml->add_nodo('cod_categoria_prog',$f["cod_categoria_prog"]);			
			$xml->add_nodo('cp_cod_programa',$f["cp_cod_programa"]);		
			$xml->add_nodo('cp_cod_proyecto',$f["cp_cod_proyecto"]);
			$xml->add_nodo('cp_cod_actividad',$f["cp_cod_actividad"]);
			$xml->add_nodo('cp_cod_organismo_fin',$f["cp_cod_organismo_fin"]);
			$xml->add_nodo('cp_cod_fuente_financiamiento',$f["cp_cod_fuente_financiamiento"]);
			$xml->add_nodo('codigo_sisin',$f["codigo_sisin"]);	
			$xml->fin_rama();
			
  
			
			
		}
		 /*** fin b) **/
		
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