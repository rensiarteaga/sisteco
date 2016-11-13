<?php
/**
* Nombre de archivo:	    ActionListarSubTipoActivoCuenta.php
* Propósito:				Permite desplegar los registros de los Subtipos de Activos y cuentas
* Tabla:					taf_sub_tipo_activo_cuenta
* Parámetros:
* Valores de Retorno:   	Listado de los Subtipos de Activos, y el total de registros listados
* Autor:					Ana Maria Villegas Quispe
* Fecha de Creación:		08/07/2010
*/

session_start();

include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionListarSubTipoActivoCuenta.php';

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

	if($sort == '') $sortcol = 'id_sub_tipo_activo_cuenta';
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
	
	  $cond->add_criterio_extra("SUTIAC.id_sub_tipo_activo",$m_id_sub_tipo_activo);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	if($id_proceso!=''){//proceso activo fijo 19/07/2010 (usado en vista activo_fijo_grupo_proceso.js)
		$criterio_filtro=$criterio_filtro." AND SUTIAC.id_gestion=$id_gestion and 
		SUTIAC.id_presupuesto=(select m_ppto.id_presupuesto from presto.tpr_presupuesto m_ppto where id_parametro=(select id_parametro from presto.tpr_parametro where id_gestion=$id_gestion)
                     and m_ppto.id_fina_regi_prog_proy_acti=(select id_fina_regi_prog_proy_acti from presto.tpr_presupuesto where id_presupuesto=$id_ppto)
                     and m_ppto.id_unidad_organizacional=(select id_unidad_organizacional from presto.tpr_presupuesto where id_presupuesto=$id_ppto)
                     and m_ppto.tipo_pres=(select tipo_pres from presto.tpr_presupuesto where id_presupuesto=$id_ppto))
		
		and SUTIAC.id_proceso=$id_proceso and (SUTIAC.id_sub_tipo_activo=$id_sub or SUTIAC.id_tipo_activo_fijo=$id_tipo)";
		
		$sortcol='SUTIAC.nivel';
		$puntero=1;
		//$hidden_ep_id_actividad=$id_ppto;
		//$hidden_ep_id_proyecto=$id_gestion;
	}
	//Obtiene el criterio de orden de columnas
	/*if($sortcol=='codigo_entero'){
		$sortcol='codigo';
	}*/
	//$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Servicio');
	/*$sortcol = $crit_sort->get_criterio_sort();
	   if($tipo_vista=='reporte_servicios_proveedores'){
    	$criterio_filtro=$criterio_filtro." and tipadq.nombre=''Servicios Generales''";
    	
    }
*/
	//Obtiene el total de los registros
	$res = $Custom -> ContarSubTipoActivoCuenta($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarSubTipoActivoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
        if($oc == 'si'){
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_sub_tipo_activo_fijo','%');
			$xml->add_nodo('id_sub_tipo_activo','%');
			$xml->add_nodo('estado_reg','Todos');
			$xml->add_nodo('fecha_reg','Todos');
			$xml->add_nodo('id_usuario_reg','%');
			$xml->add_nodo('desc_usuario','Todos');
			$xml->add_nodo('id_cuenta','%');
			$xml->add_nodo('desc_cuenta','Todos');
			$xml->add_nodo('id_auxiliar','%');
			$xml->add_nodo('desc_auxiliar','Todos');
			$xml->add_nodo('id_proceso','%');
			$xml->add_nodo('desc_proceso','Todos');
			$xml->add_nodo('id_gestion','%');
			$xml->add_nodo('gestion','Todos');
		
			$xml->fin_rama();
		}
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_sub_tipo_activo_cuenta',$f["id_sub_tipo_activo_cuenta"]);
			$xml->add_nodo('id_sub_tipo_activo',$f["id_sub_tipo_activo"]);
			$xml->add_nodo('estado_reg',$f["estado_reg"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('id_usuario_reg',$f["id_usuario_reg"]);
			$xml->add_nodo('desc_usuario',$f["desc_usuario"]);
			$xml->add_nodo('id_cuenta',$f["id_cuenta"]);
			$xml->add_nodo('desc_cuenta',$f["desc_cuenta"]);
			$xml->add_nodo('id_auxiliar',$f["id_auxiliar"]);
			$xml->add_nodo('desc_auxiliar',$f["desc_auxiliar"]);
			$xml->add_nodo('id_proceso',$f["id_proceso"]);
			$xml->add_nodo('desc_proceso',$f["desc_proceso"]);
			$xml->add_nodo('id_gestion',$f["id_gestion"]);
			$xml->add_nodo('gestion',$f["gestion"]);
			$xml->add_nodo('id_presupuesto',$f["id_presupuesto"]);
			$xml->add_nodo('desc_estructura',$f["desc_estructura"]);
			$xml->add_nodo('id_fina_regi_prog_proy_acti',$f["id_fina_regi_prog_proy_acti"]);
			$xml->add_nodo('desc_estructura',$f["desc_estructura"]);
            $xml->add_nodo('id_unidad_organizacional',$f["id_unidad_organizacional"]);
			$xml->add_nodo('desc_unidad_organizacional',$f["desc_unidad_organizacional"]);
			$xml->add_nodo('id_cuenta2',$f["id_cuenta2"]);
			$xml->add_nodo('id_auxiliar2',$f["id_auxiliar2"]);
			$xml->add_nodo('desc_cuenta2',$f["desc_cuenta2"]);
			$xml->add_nodo('desc_auxiliar2',$f["desc_auxiliar2"]);
			
			$xml->add_nodo('id_fina_regi_prog_proy_acti',$f["id_fina_regi_prog_proy_acti"]);
			$xml->add_nodo('desc_epe',$f["desc_epe"]);
			$xml->add_nodo('id_tipo_activo',$f["id_tipo_activo"]);
			$xml->add_nodo('desc_sub_tipo_activo',$f["desc_sub_tipo_activo"]);
			$xml->add_nodo('desc_tipo_activo',$f["desc_tipo_activo"]);
			$xml->add_nodo('nivel',$f["nivel"]);

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