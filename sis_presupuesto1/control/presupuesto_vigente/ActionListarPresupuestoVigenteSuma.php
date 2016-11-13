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
$nombre_archivo = 'ActionListarPresupuestoVigenteSuma.php';

//echo 'id_moneda: '.$_POST['id_moneda'].'id_gestion: '.$_POST['id_gestion']; exit;

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

	if($sort == '') $sortcol = 'nombre_unidad';
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
	
	$id_gestion = $_POST['id_gestion'];
	$id_moneda = $_POST['id_moneda'];

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	//$cond->add_criterio_extra("PRESUP.tipo_pres",$s_tipo_pres);
	
	if($estado_pres==2){
		$cond->add_criterio_extra("PRESUP.estado_pres",$estado_pres);
	}
	

		if ($sw_reg_comp=='si'&& $m_id_fuente_financiamiento&& $m_id_unidad_organizacional&& $m_id_epe)
		{
		 	$cond->add_criterio_extra("PRESUP.id_fuente_financiamiento",$m_id_fuente_financiamiento);
		 	$cond->add_criterio_extra("PRESUP.id_unidad_organizacional",$m_id_unidad_organizacional);
		 	$cond->add_criterio_extra("PRESUP.id_fina_regi_prog_proy_acti",$m_id_epe);
		 	$cond->add_criterio_extra("PARAMP.id_gestion",$m_id_gestion);
		 	
		 	if ($m_sw_ingreso=='si')		 
		 	{
		 		$cond->add_criterio_extra("PRESUP.tipo_pres",1);//1
		 	}	 	
		}		
		
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();	
	
	//filtramos por tipo de presupuesto
	if($s_tipo_pres==1)
	{		 
		$criterio_filtro=$criterio_filtro."  and PRESUP.tipo_pres in(1,4) ";		
	}
	
	if($s_tipo_pres==2)
	{		 
		$criterio_filtro=$criterio_filtro."  and PRESUP.tipo_pres in(2,5) ";		
	}
	
	if($s_tipo_pres==3)
	{		 
		$criterio_filtro=$criterio_filtro."  and PRESUP.tipo_pres in(3,6) ";		
	}
	
	//Filtramos por estado de presupuesto
	if($estado_pres==1)
	{		 
		$criterio_filtro=$criterio_filtro."  and PRESUP.estado_pres in(1,2) ";		
	}
	
	if($estado_pres==3)
	{		 
		$criterio_filtro=$criterio_filtro."  and PRESUP.estado_pres in(1,2,3,4,5) ";		
	}
	
	if($estado_pres==4)
	{		 
		$criterio_filtro=$criterio_filtro."  and PRESUP.estado_pres in(3,4) ";		
	}
	
	if($m_sw_ingreso=='no')
	{		 
		$criterio_filtro=$criterio_filtro."  and PRESUP.tipo_pres in(3,2) ";		
	}	
	
	/*if ($sw_colectivo==-1)
	{ 
		$criterio_filtro=$criterio_filtro." and PRESUP.id_concepto_colectivo is null";		
	}*/
	
	if($sw_colectivo==1&&$sw_colectivo==1)
	{	
		$criterio_filtro=$criterio_filtro." and CONCOL.id_concepto_colectivo in( select id_concepto_colectivo from presto.tpr_concepto_colectivo where id_usuario=".$_SESSION["ss_id_usuario"].") ";		
	}
	
	else
	{
		if ($sw_colectivo==1)
		{
			$criterio_filtro=$criterio_filtro." and PRESUP.id_concepto_colectivo >0";			
		}
		if ($sw_usuario==1)
		{
			$criterio_filtro=$criterio_filtro." and PRESUP.id_unidad_organizacional in (select id_unidad_organizacional from presto.tpr_usuario_autorizado where estado=''Activo'' and id_usuario=".$_SESSION["ss_id_usuario"].")   "; 
		}
	}
			
	$criterio_filtro = $criterio_filtro."  and COALESCE(PARDET.id_moneda,".$id_moneda.")=".$id_moneda." ";
		
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Presupuesto');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarPresupuestoVigenteSuma($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_gestion);
	
	//echo var_dump($Custom); exit;

	if($res) $total_registros= $Custom->salida;
	
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom-> ListarPresupuestoVigenteSuma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_gestion);
	
	//echo var_dump($Custom); exit;
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f) 
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_presupuesto',$f["id_presupuesto"]);
			$xml->add_nodo('tipo_pres',$f["tipo_pres"]);
			$xml->add_nodo('estado_pres',$f["estado_pres"]);
			$xml->add_nodo('id_fina_regi_prog_proy_acti',$f["id_fina_regi_prog_proy_acti"]);
			$xml->add_nodo('desc_fina_regi_prog_proy_acti',$f["desc_fina_regi_prog_proy_acti"]);
			$xml->add_nodo('id_unidad_organizacional',$f["id_unidad_organizacional"]);
			$xml->add_nodo('desc_unidad_organizacional',$f["desc_unidad_organizacional"]);
			$xml->add_nodo('id_fuente_financiamiento',$f["id_fuente_financiamiento"]);
			$xml->add_nodo('denominacion',$f["denominacion"]);
			$xml->add_nodo('id_parametro',$f["id_parametro"]);
			$xml->add_nodo('desc_parametro',$f["desc_parametro"]);
			$xml->add_nodo('id_financiador',$f["id_financiador"]);
			$xml->add_nodo('id_regional',$f["id_regional"]);
			$xml->add_nodo('id_programa',$f["id_programa"]);
			$xml->add_nodo('id_proyecto',$f["id_proyecto"]);
			$xml->add_nodo('id_actividad',$f["id_actividad"]);
			$xml->add_nodo('nombre_financiador',$f["nombre_financiador"]);
			$xml->add_nodo('nombre_regional',$f["nombre_regional"]);
			$xml->add_nodo('nombre_programa',$f["nombre_programa"]);
			$xml->add_nodo('nombre_proyecto',$f["nombre_proyecto"]);
			$xml->add_nodo('nombre_actividad',$f["nombre_actividad"]);			
			$xml->add_nodo('total',$f["total"]);	
					
			/*$xml->add_nodo('total',number_format($f["total"],0,'','.'));
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);*/
			
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('usuario',$f["usuario"]);
			$xml->add_nodo('estado',$f["estado"]);
		
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