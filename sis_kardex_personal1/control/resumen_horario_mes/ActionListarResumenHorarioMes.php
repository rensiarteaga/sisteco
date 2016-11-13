<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarResumenHorarioMes.php
Propósito:				Permite realizar el listado en tkp_resumen_horario_mes
Tabla:					tkp_resumen_horario_mes
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
$nombre_archivo = 'ActionListarResumenHorarioMes.php';

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

	if($sort == '') $sortcol = 'fecha_reg';
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
	if($m_id_planilla!='' && $m_id_planilla!='null'){
		
		$criterio_filtro= $criterio_filtro. " AND RESHORMES.id_planilla=$m_id_planilla";
	}
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'ResumenHorarioMes');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarResumenHorarioMes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarResumenHorarioMes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$m_id_planilla);
	
	if($res){
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		
		foreach ($Custom->salida as $f){
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_resumen_horario_mes',$f["id_resumen_horario_mes"]);
			$xml->add_nodo('id_empleado_planilla',$f["id_empleado_planilla"]);
			$xml->add_nodo('usuario_reg',$f["usuario_reg"]);
			$xml->add_nodo('horas_disp',$f["horas_disp"]);
			$xml->add_nodo('horas_normales',$f["horas_normales"]);
			$xml->add_nodo('horas_extra',$f["horas_extra"]);
			$xml->add_nodo('horas_nocturnas',$f["horas_nocturnas"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('estado_reg',$f["estado_reg"]);
			$xml->add_nodo('nombre_completo',$f["nombre_completo"]);
			$xml->add_nodo('id_empleado',$f["id_empleado"]);
			$xml->add_nodo('id_gestion',$f["id_gestion"]);
			$xml->add_nodo('parametrizado',$f["parametrizado"]);
			$xml->add_nodo('id_planilla',$f["id_planilla"]);
			$xml->add_nodo('horas_normales_efectivas',$f["horas_normales_efectivas"]);
			$xml->add_nodo('costo_horas_normales_efectivas',$f["costo_horas_normales_efectivas"]);
			$xml->add_nodo('costo_horas_extra',$f["costo_horas_extra"]);
			$xml->add_nodo('costo_horas_nocturnas',$f["costo_horas_nocturnas"]);
			$xml->add_nodo('costo_horas_disp',$f["costo_horas_disp"]);
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