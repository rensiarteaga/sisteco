<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarSolicitudLicencia.php
Propósito:				Permite realizar el listado en tkp_vacacion
Tabla:					tkp_tkp_vacacion
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2010-08-17 09:25:59
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloKardexPersonal.php');

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = 'ActionListarSolicitudLicencia.php';

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

	if($sort == '') $sortcol = 'VACACI.id_gestion';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'desc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> 'si', 'no'
	
	switch ($cod){
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
	if ($_SESSION["ss_rol_adm"]!=1){
	  $cond->add_criterio_extra("VACACI.id_empleado",$_SESSION["ss_id_empleado"]);	
	}
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	if($tipo=="rrhh"){
		if($m_tipo_contrato=="planta"){
			$criterio_filtro=$criterio_filtro." AND CONTRA.tipo_contrato=''$m_tipo_contrato''";
		}
		else{
			$criterio_filtro=$criterio_filtro." AND CONTRA.tipo_contrato!=''planta''";
		}
	}
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'SolicitudLicencia');
	$sortcol = $crit_sort->get_criterio_sort();
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarSolicitudLicencia($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarSolicitudLicencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_vacacion',$f["id_vacacion"]);
			$xml->add_nodo('id_gestion',$f["id_gestion"]);
			$xml->add_nodo('desc_gestion',$f["desc_gestion"]);
			$xml->add_nodo('id_empleado',$f["id_empleado"]);
			$xml->add_nodo('nombre_completo',$f["nombre_completo"]);
			$xml->add_nodo('total_dias',$f["total_dias"]);
			$xml->add_nodo('id_categoria_vacacion',$f["id_categoria_vacacion"]);
			$xml->add_nodo('desc_categoria_vacacion',$f["desc_categoria_vacacion"]);
			$xml->add_nodo('dias_vacacion',$f["dias_vacacion"]);
			$xml->add_nodo('dias_tomados',$f["dias_tomados"]);
			$xml->add_nodo('fecha_reg',$f["fecha_reg"]);
			$xml->add_nodo('estado_reg',$f["estado_reg"]);
            $xml->add_nodo('dias_disponibles',$f["dias_disponibles"]);
            $xml->add_nodo('dias_acumulados',$f["dias_acumulados"]);
            $xml->add_nodo('dias_adelantados',$f["dias_adelantados"]);
            $xml->add_nodo('id_empleado_aprobador',$f["id_empleado_aprobador"]);
			$xml->add_nodo('dias_compensacion',$f["dias_compensacion"]);
			$xml->add_nodo('tipo_contrato',$f["tipo_contrato"]);
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