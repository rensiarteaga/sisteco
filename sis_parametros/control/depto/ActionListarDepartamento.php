<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDepartamento.php
Prop�sito:				Permite realizar el listado en tpm_depto
Tabla:					tpm_tpm_depto
Par�metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci�n:		2009-01-23 10:58:13
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloParametros.php');

$Custom = new cls_CustomDBParametros();
$nombre_archivo = 'ActionListarDepartamento .php';

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

	if($sort == '') $sortcol = 'id_depto';
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
	$cond->add_criterio_extra("DEPTO.id_subsistema",$m_id_subsistema);
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Depto');
	
	$sortcol = $crit_sort->get_criterio_sort();
	
	if($oc=='si'){
		$criterio_filtro=$criterio_filtro." AND SUBSIS.nombre_corto=''COMPRO''";
	}

	if($tesoro){/*12-05-2009 para listar solo deptos de TESORO, usado en vista orden_compra_item y orden_compra_det*/
		$criterio_filtro=$criterio_filtro." AND SUBSIS.nombre_corto=''TESORO''";
		
		if($usuario){
			$id_usuario=$_SESSION["ss_id_usuario"];
			$criterio_filtro=$criterio_filtro."  AND DEPTO.id_depto IN (SELECT ID_DEPTO FROM PARAM.tpm_depto_usuario WHERE ID_USUARIO = $id_usuario)";
		}
	}
	
	if($estado=='2'){//solo cajas activas==> estado_caja=1 (filtro enviado desde proceso_simplificado_factura en COMPRO)
	    
	    $criterio_filtro.=" AND (DEPTO.id_depto in (select * from compro.f_tad_obtener_cajas($id_cotizacion,''cotizacion'',''depto'') as (id_caja integer)))";
	}
	
	$id_usuario=$_SESSION["ss_id_usuario"];
	if ($subsistema=='sci'){
		$criterio_filtro=$criterio_filtro." AND DEPTO.id_depto IN (SELECT ID_DEPTO FROM PARAM.tpm_depto_usuario WHERE ID_USUARIO = $id_usuario) and DEPTO.id_subsistema=9 ";
	}
	
	if ($subsistema=='actif'){
		$criterio_filtro=$criterio_filtro." AND (DEPTO.id_depto IN (SELECT ID_DEPTO FROM PARAM.tpm_depto_usuario WHERE ID_USUARIO = $id_usuario) and lower(subsis.nombre_corto)=''$subsistema'') ";
	}
	
	if ($subsistema=='kard'){
		$criterio_filtro=$criterio_filtro." AND lower(subsis.nombre_corto)=''$subsistema'' ";
	}
	
	//filtro por subsistema de flujo realizado en fecha 04-01-2011 por Williams Escobar
	if($subsistema =='FLUJO'){
	    $criterio_filtro=$criterio_filtro." AND subsis.nombre_corto=''$subsistema''";	    
	}
	
	if($correspondencia=='si'){
		if($_SESSION["ss_rol_adm"]==0){
			$criterio_filtro.=' and ( DEPTO.id_depto in 
				(select duo.id_depto from flujo.tfl_auxiliar au
				inner join param.tpm_depto_uo duo on(duo.id_unidad_organizacional=au.id_uo)
				where id_usuario='.$_SESSION['ss_id_usuario'].') or ';
			
			$criterio_filtro.=" DEPTO.id_depto in (
				select duo.id_depto
				from sss.tsg_usuario u
				inner join kard.tkp_empleado e on u.id_persona=e.id_persona
				inner join kard.tkp_historico_asignacion ha on ha.id_empleado=e.id_empleado and (ha.estado=''activo'' or ha.estado=''suplente'')
				inner join param.tpm_depto_uo duo on(duo.id_unidad_organizacional=flujo.f_fl_get_uo_correspondencia(ha.id_unidad_organizacional))
				where u.id_usuario= ".$_SESSION['ss_id_usuario'].")) 
				and DEPTO.id_subsistema=(select id_subsistema from sss.tsg_subsistema where nombre_corto=''FLUJO'') 
				and DEPTO.id_tipo_proceso=(select id_tipo_proceso from flujo.tfl_tipo_proceso where codigo=''CORR'')";
		}else{
			$criterio_filtro.= " and DEPTO.id_subsistema=(select id_subsistema from sss.tsg_subsistema where nombre_corto=''FLUJO'')  
			and DEPTO.id_tipo_proceso=(select id_tipo_proceso from flujo.tfl_tipo_proceso where codigo=''CORR'') ";
		}
	}
	
	if ($m_id_subsistema==9){
		$cant = 100;
	}
	
	/********************************************CRITERIO REPORTE ACTIF**************************************************************/
	/* AUTHOR: DANIEL SANCHEZ TORRICO
	 * FECHA: 09/04/2013
	*/
	if($reporteActif == 'si'){
		$criterio_filtro = $criterio_filtro." AND DEPTO.codigo_depto like ''%DAF%''";
	}
	/********************************************************************************************************************************/
	
	//Obtiene el total de los registros
	$res = $Custom -> ContarDepartamento($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarDepartamento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		if($todos=="si"){
         	$xml->add_rama('ROWS');
         	if(isset($_POST['valor']) && $_POST['valor']==0){ //echo "lleag"; exit;
         		$xml->add_nodo('id_depto','0');
         	}else{//echo "else"; exit;
         		$xml->add_nodo('id_depto','%');
         	}
         	
			$xml->add_nodo('codigo_depto','Todos');
			$xml->add_nodo('nombre_depto','Todos');
			$xml->add_nodo('estado','Todos');
			$xml->add_nodo('id_subsistema','%');
			$xml->add_nodo('nombre_corto','Todos');
			$xml->add_nodo('nombre_largo','Todos');
			$xml->add_nodo('despliegue_rep','%');
			$xml->add_nodo('id_lugar','%');
			$xml->add_nodo('desc_lugar','%');
			$xml->add_nodo('id_sucursal','%');
			$xml->add_nodo('id_tipo_proceso','%');
			$xml->add_nodo('desc_tipo_proceso','%');
		      
		 	$xml->fin_rama();
       }
		
       foreach ($Custom->salida as $f){
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_depto',$f["id_depto"]);
			$xml->add_nodo('codigo_depto',$f["codigo_depto"]);
			$xml->add_nodo('nombre_depto',$f["nombre_depto"]);
			$xml->add_nodo('estado',$f["estado"]);
			$xml->add_nodo('id_subsistema',$f["id_subsistema"]);
			$xml->add_nodo('nombre_corto',$f["nombre_corto"]);
			$xml->add_nodo('nombre_largo',$f["nombre_largo"]);
			$xml->add_nodo('despliegue_rep',$f["codigo_depto"].'-'.$f["despliegue_rep"]);
			$xml->add_nodo('id_lugar',$f["id_lugar"]);
			$xml->add_nodo('desc_lugar',$f["desc_lugar"]);
			$xml->add_nodo('id_sucursal',$f["id_sucursal"]);
			//MODIFICACION 23/03/2011 aayaviri
			$xml->add_nodo('id_tipo_proceso',$f["id_tipo_proceso"]);
			$xml->add_nodo('desc_tipo_proceso',$f["desc_tipo_proceso"]);
			//MODIFICACION 03/10/2011 mflores
			$xml->add_nodo('codificacion',$f["codificacion"]);
			//----------------
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