<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarPlanCuentas.php
Prop�sito:				Permite realizar el listado en taf_plan_cuentas
Tabla:					taf_plan_cuentas
Par�metros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creaci�n:		12-05-2015
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloActivoFijo.php');

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionListarPlanCuentas.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Par�metros del filtro
	if($limit == '') $cant = 50;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_plan_cuentas';
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
	// Verifica si se manda la cantidad de filtros
	if ($CantFiltros == '')$CantFiltros = 0;
	
	// Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i = 0; $i < $CantFiltros; $i ++) {
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	if ($id_plan_cuentas != '' && $id_plan_cuentas != 'undefined' && $id_plan_cuentas != null) 
	{
		$cond->add_criterio_extra("cta.id_plan_cuentas_fk", $id_plan_cuentas);
		$criterio_filtro = $cond->obtener_criterio_filtro();
		
		if(isset($id_gestion)) 
		{
			$param = $id_gestion;
			$criterio_filtro.=" AND cta.id_gestion LIKE($id_gestion)";
		}
	}
	else 
	{	$param =null;
		$criterio_filtro = "cta.id_plan_cuentas_fk is null";
		if ($id_gestion != '' && $id_gestion != 'undefined' && $id_gestion != null) 
		{
			$criterio_filtro .= " AND cta.id_gestion = " . $id_gestion;
			
		}
		else
		{
			$criterio_filtro.=" AND cta.id_gestion is null";
		}
	}
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarPlanCuentasArb($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $param, $id_regional, $id_programa, $id_proyecto, $id_actividad);
	//echo $Custom->query;exit;
	if($res)
	{
	$tipo_nodo = "plan_ctas";
		foreach ( $Custom->salida as $f ) 
		{
			//$tmp['text'] = utf8_encode("[" . $f["codigo"] . "-". $f["descripcion"]."]");
			
			if($f["nivel"] == 1)
				$tmp['text'] = utf8_encode("[" . $f["codigo"] . " - ". $f["gestion"]."]");
			elseif ($f["nivel"] == 2)
				$tmp['text'] = utf8_encode($f["desc_tipo_activo"]);
			else if($f["nivel"] == 3)
			{
				if($f["programa"] =='DIS')
					$tmp['text'] = utf8_encode( '[ '.$f["programa"].' - '.$f["tension"].' ]	'.$f["desc_cta_activo"]);
				else
					$tmp['text'] = utf8_encode( '[ '.$f["programa"].' - '.$f["tipo_bien"].' ]	'.$f["desc_cta_activo"]);
				/*if($f["nodo"] =='hoja' && $f["id_tipo_activo"] == '')
					$tmp['text'] = utf8_encode($f["desc_cta_activo"]);
				else 
					$tmp['text'] = utf8_encode($f["desc_tipo_activo"]);*/
			}
				
					
			$tmp['id'] = utf8_encode($tipo_nodo . "-" . $f["id_plan_cuentas"]);
			$tmp['cls'] = 'folder';
			$tmp['leaf'] = false;
			$tmp['allowDelete'] = true;
			$tmp['allowDrag'] = false;
			$tmp['allowDrop'] = false;
			$tmp['allowEdit'] = true;	
			$tmp['icon'] = "../../../lib/imagenes/org.png";
			$tmp['qtip'] = $tipo_nodo;
			$tmp['qtipTitle'] = utf8_encode("[" . $f["codigo"] . "]-" . $f["descripcion"]);
			
			$tmp['tipo_nodo'] = $tipo_nodo;
			$tmp['id_plan_cuentas'] = utf8_encode($f["id_plan_cuentas"]);
			$tmp['id_plan_cuentas_fk'] = utf8_encode($f["id_plan_cuentas_fk"]);
			$tmp['id_gestion'] = utf8_encode($f["id_gestion"]);
			$tmp['codigo'] = utf8_encode($f["codigo"]);
			$tmp['descripcion'] = utf8_encode($f["descripcion"]);
			$tmp['estado'] = utf8_encode($f["estado"]);
			
			$tmp['id_tipo_activo'] = utf8_encode($f["id_tipo_activo"]);
			$tmp['id_gestion'] = utf8_encode($f["id_gestion"]);
			$tmp['gestion'] = utf8_encode($f["gestion"]);
			$tmp['id_cta_activo'] =  utf8_encode($f["id_cta_activo"]);
			$tmp['desc_cta_activo'] =  utf8_encode($f["desc_cta_activo"]);
			$tmp['id_aux_activo'] =  utf8_encode($f["id_aux_activo"]);
			$tmp['desc_aux_activo'] =  utf8_encode($f["desc_aux_activo"]);
			$tmp['id_cta_dep_acumulada'] =  utf8_encode($f["id_cta_dep_acumulada"]);
			$tmp['desc_cta_depacum'] =  utf8_encode($f["desc_cta_depacum"]);
			$tmp['id_aux_depacum'] =  utf8_encode($f["id_aux_depacum"]);
			$tmp['desc_aux_depacum'] =  utf8_encode($f["desc_aux_depacum"]);
			$tmp['id_cta_gasto'] =  utf8_encode($f["id_cta_gasto"]);
			$tmp['desc_cta_gasto'] =  utf8_encode($f["desc_cta_gasto"]);
			$tmp['id_aux_cta_gasto'] =  utf8_encode($f["id_aux_cta_gasto"]);
			$tmp['desc_aux_gasto'] =  utf8_encode($f["desc_aux_gasto"]);
			$tmp['desc_tipo_activo'] =utf8_encode($f["desc_tipo_activo"]);
			
			$tmp['programa'] =utf8_encode($f["programa"]);
			$tmp['tension'] =utf8_encode($f["tension"]);
			
			$tmp['tipo_bien_adt'] =utf8_encode($f["tipo_bien"]);
			$tmp['tipo_bien_gen'] =utf8_encode($f["tipo_bien"]);
			
			$tmp['nivel'] = utf8_encode($f["nivel"]);
			$tmp['nodo'] = utf8_encode($f["nodo"]);
			$nodes[] = $tmp;
		}
		header("Content-Type:text/json; charset=" . $_SESSION["CODIFICACION_HEADER"]);
		if (sizeof($nodes) > 0) 
		{
			echo json_encode($nodes);
		} 
		else 
		{
			echo '{}';
		}
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