<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarProrrateoHoras.php
Propósito:				Permite realizar el listado en tkp_parametro_costo_planilla
Tabla:					tkp_parametro_costo_planilla
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-12 09:24:17
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloKardexPersonal.php');

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = 'ActionListarProrrateoHoras.php';

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

	if($sort == '') $sortcol = 'PACOPLA.fecha_reg';
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
	if($id_resumen_horario_mes!='' && $id_resumen_horario_mes!='null'){
		
		$criterio_filtro= $criterio_filtro. " AND PACOPLA.id_resumen_horario_mes=$id_resumen_horario_mes";
	}
	if($id_empleado_planilla!='' && $id_empleado_planilla!='null'){
		
		$criterio_filtro= $criterio_filtro. " AND PACOPLA.id_empleado_planilla=$id_empleado_planilla";
	}
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'ProrrateoHoras');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarProrrateoHoras($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarProrrateoHoras($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res){
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		
		foreach ($Custom->salida as $f){
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_parametro_costo_planilla',$f["id_parametro_costo_planilla"]);
			$xml->add_nodo('id_empleado_planilla',$f["id_empleado_planilla"]);
			$xml->add_nodo('id_gestion',$f["id_gestion"]);
			$xml->add_nodo('gestion',$f["gestion"]);
			$xml->add_nodo('id_unidad_organizacional',$f["id_unidad_organizacional"]);
			$xml->add_nodo('nombre_unidad',$f["nombre_unidad"]);
			$xml->add_nodo('id_fina_regi_prog_proy_acti',$f["id_fina_regi_prog_proy_acti"]);
			$xml->add_nodo('id_financiador',$f["id_financiador"]);
			$xml->add_nodo('nombre_financiador',$f["nombre_financiador"]);
			$xml->add_nodo('id_regional',$f["id_regional"]);
			$xml->add_nodo('nombre_regional',$f["nombre_regional"]);
			$xml->add_nodo('id_programa',$f["id_programa"]);
			$xml->add_nodo('nombre_programa',$f["nombre_programa"]);
			$xml->add_nodo('id_proyecto',$f["id_proyecto"]);
			$xml->add_nodo('nombre_proyecto',$f["nombre_proyecto"]);
			$xml->add_nodo('id_actividad',$f["id_actividad"]);
			$xml->add_nodo('nombre_actividad',$f["nombre_actividad"]);
			$xml->add_nodo('id_orden_trabajo',$f["id_orden_trabajo"]);
			$xml->add_nodo('desc_orden',$f["desc_orden"]);
			$xml->add_nodo('motivo_orden',$f["motivo_orden"]);
			$xml->add_nodo('descrip_orden',$f["desc_orden"]." - ".$f["motivo_orden"]);
			$xml->add_nodo('id_usuario_reg', $f["id_usuario_reg"]);
			$xml->add_nodo('id_presupuesto',$f["id_presupuesto"]);
			$xml->add_nodo('desc_presupuesto',$f["desc_presupuesto"]);
			$xml->add_nodo('estado_reg',$f["estado_reg"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);    
            $xml->add_nodo('horas_normales',$f["horas_normales"]);
			$xml->add_nodo('costo_horas_normales',$f["costo_horas_normales"]);
			$xml->add_nodo('horas_extra',$f["horas_extra"]);
			$xml->add_nodo('costo_horas_extra',$f["costo_horas_extra"]);
			$xml->add_nodo('horas_nocturnas',$f["horas_nocturnas"]);
			$xml->add_nodo('costo_horas_nocturnas',$f["costo_horas_nocturnas"]);
			$xml->add_nodo('horas_disp',$f["horas_disp"]);
			$xml->add_nodo('costo_horas_disp',$f["costo_horas_disp"]);
			$xml->add_nodo('id_resumen_horario_mes',$f["id_resumen_horario_mes"]);
			$xml->add_nodo('factor_prorrateo',$f["factor_prorrateo"]);
			
			
			
			$xml->add_nodo('total_horas_normales',$f["total_horas_normales"]);
			$xml->add_nodo('total_horas_extra',$f["total_horas_extra"]);
			$xml->add_nodo('total_horas_nocturnas',$f["total_horas_nocturnas"]);
			$xml->add_nodo('total_horas_disp',$f["total_horas_disp"]);
			
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