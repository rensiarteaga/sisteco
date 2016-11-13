<?php
/**
**********************************************************
Nombre de archivo:	    ActionListaGrupoProceso.php
Propósito:				Permite desplegar las Procesos registradas
Tabla:					taf_proceso
Parámetros:				$cant
$puntero
$sortcol
$sortdir
$criterio_filtro
$id_usuario_asignacion

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		07/07/2010
Versión:				1.0.0
Autor:					Mercedes Zambrana Meneses
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");
$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionListarGrupoProceso.php';


if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	//Parámetros del filtro
	if($limit == "") $cant = 15;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

	if($sort == "") $sortcol = 'id_grupo_proceso';
	elseif ($sort == "codigo_proceso")
	{
		$sortcol = 'pro.descripcion';
	}
	else  $sortcol = $sort;

	if($dir == "") $sortdir = 'asc';
	else $sortdir = $dir;
	
	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> "si", "no"
	switch ($cod)
	{
		case "si":
			$decodificar = true;
			break;
		case "no":
			$decodificar = false;
			break;
		default:
			$decodificar = true;
			break;
	}

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=="") $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	$criterio_filtro = $cond->obtener_criterio_filtro();
	
	if($estado!=''){
		$criterio_filtro=$criterio_filtro." AND gru.estado=''$estado''";
	}
	
	if($estado=='borrador' ||$estado=='pendiente' || $estado=='finalizado' || $estado=='en_prestamo' || $estado=='aprobado'){
		if($_SESSION["ss_rol_adm"]==0){
			$criterio_filtro=$criterio_filtro." AND gru.id_depto_org in (select de.id_depto 
																	from param.tpm_depto de 
																	inner join param.tpm_depto_usuario du 
																		on(du.id_depto=de.id_depto)
																	where de.id_subsistema=2 and du.id_usuario=".$_SESSION['ss_id_usuario']." 
																		and du.estado=''activo'') ";
		}
	}
	else{
		if($_SESSION["ss_rol_adm"]==0){
			$criterio_filtro=$criterio_filtro." AND gru.id_usuario_reg=".$_SESSION['ss_id_usuario']." ";
		}
		
	}

	//Obtiene el total de los registros
	$res = $Custom->ContarGrupoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros= $Custom->salida;
		
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarGrupoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_grupo_proceso', $f["id_grupo_proceso"]);
			$xml->add_nodo('estado', $f["estado"]);
			$xml->add_nodo('descripcion', $f["descripcion"]);
			$xml->add_nodo('agrupador', $f["agrupador"]);
			$xml->add_nodo('fecha_reg', $f["fecha_reg"]);
			$xml->add_nodo('fecha_contabilizacion', $f["fecha_contabilizacion"]);
			$xml->add_nodo('sw_prestamo', $f["sw_prestamo"]);
			$xml->add_nodo('id_depto_org', $f["id_depto_org"]);
			$xml->add_nodo('desc_depto_ori', $f["desc_depto_ori"]);
			$xml->add_nodo('id_proceso', $f["id_proceso"]);
			$xml->add_nodo('id_depto_des', $f["id_depto_des"]);
			$xml->add_nodo('desc_depto_des', $f["desc_depto_des"]);
			$xml->add_nodo('id_empleado_org', $f["id_empleado_org"]);
			$xml->add_nodo('desc_empleado_ori', $f["desc_empleado_ori"]);
			$xml->add_nodo('id_empleado_des', $f["id_empleado_des"]);
			$xml->add_nodo('desc_empleado_des', $f["desc_empleado_des"]);
			$xml->add_nodo('id_presupuesto_org', $f["id_presupuesto_org"]);
			$xml->add_nodo('desc_presupuesto_ori', $f["desc_presupuesto_ori"]);
			$xml->add_nodo('id_presupuesto_des', $f["id_presupuesto_des"]);
			$xml->add_nodo('desc_presupuesto_des', $f["desc_presupuesto_des"]);
			$xml->add_nodo('id_activo_fijo', $f["id_activo_fijo"]);
			$xml->add_nodo('desc_activo_fijo', $f["desc_activo_fijo"]);
			$xml->add_nodo('codigo_proceso', $f["codigo_proceso"]);
			$xml->add_nodo('fecha_devolucion', $f["fecha_devolucion"]);
			$xml->add_nodo('sw_bien_responsabilidad', $f["sw_bien_responsabilidad"]);
			$xml->add_nodo('identificador', $f["id_grupo_proceso"]);
			$xml->add_nodo('id_persona', $f["id_persona"]);
			$xml->add_nodo('custodio', $f["custodio"]);
			
			$xml->fin_rama();
		}
		$xml->mostrar_xml();
	}
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true, "406");
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
