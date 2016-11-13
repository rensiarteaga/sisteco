<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarItem.php
Propósito:				Permite desplegar datos de los Items
Tabla:					tal_item
Parámetros:				$cant
$puntero
$sortcol
$sortdir
$criterio_filtro
$id_usuario_asignacion

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		29-09-2007
Versión:				1.0.0
Autor:					Rensi arteaga Copari
**********************************************************
*/
session_start();
include_once("../LibModeloSeguridad.php");

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = 'ActionListarRolMetaprocesoAsignado.php';


if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	//Parámetros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_metaproceso';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	//Obtiene el criterio de orden de columnas
	if($id_rol>0){
		
	//	$criterio_filtro= $criterio_filtro." AND ROLMET.id_rol=COALESCE($id_rol,1)";
		
	}
	
	$nodos['totalCount']=0;
	
	if($node=='id'){
		//$cond = new cls_criterio_filtro($decodificar);
		//$cond->add_criterio_extra("METAPR.id_rol","$id_rol");
		
		//Obtiene el conjunto de datos de la consulta$
		
		$res = $Custom->ListarMetaprocesoRaizAsignado(15,0,'id_metaproceso','asc',$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_rol);
		if($res)
		{
			foreach ($Custom->salida as $f)
			{


				$tmp['text'] = utf8_encode($f["nombre"]);
				$tmp['id'] = $f["id_metaproceso"];
				$tmp['cls']	= 'folder';
				$tmp['leaf'] = false;
				$tmp['allowDelete']	= true;
				$tmp['allowEdit']	= false;
				$tmp['allowDrag']	= false;
				$tmp['tipo'] = "raiz";
				$tmp['id_p'] = $f["id_padre"];
				$tmp['codigo'] = $f["codigo"];
				$tmp['nombre'] = $f["nombre"];
				$tmp['nivel'] = $f["nivel"];
				$tmp['fk_id_metaproceso'] = $f["fk_id_metaproceso"];
				$tmp['id_subsistema'] = $f["id_subsistema"];
				$tmp['nombre_archivo'] = $f["nombre_archivo"];
				$tmp['codigo_procedimiento'] = $f["codigo_procedimiento"];
				$nodes[] = $tmp;
			}

			if(sizeof($nodes)>0){
			
				echo json_encode($nodes);
			}
			else {
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

		//$cond = new cls_criterio_filtro($decodificar);
		//$cond->add_criterio_extra("METAP1.fk_id_metaproceso","''$node''");
		$res = $Custom->ListarMetaprocesoRamaAsignado(15,0,'id_metaproceso','asc',$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$node,$id_rol);
		
		if($res)
		{
			foreach ($Custom->salida as $f)
			{


				$tmp['text'] = utf8_encode($f["nombre"]);
				$tmp['id'] = $f["id_metaproceso"];
				$tmp['cls']	= 'folder';
				$tmp['leaf'] = false;
				$tmp['allowDelete']	= true;
				$tmp['allowEdit']	= false;
				$tmp['allowDrag']	= false;
				$tmp['tipo'] = "rama";
				$tmp['id_p'] = $f["id_padre"];
				$tmp['codigo'] = $f["codigo"];
				$tmp['nombre'] = $f["nombre"];
				$tmp['nivel'] = $f["nivel"];
				$tmp['fk_id_metaproceso'] = $f["fk_id_metaproceso"];
				$tmp['id_subsistema'] = $f["id_subsistema"];
				$tmp['nombre_archivo'] = $f["nombre_archivo"];
				$tmp['codigo_procedimiento'] = $f["codigo_procedimiento"];
				$nodes[] = $tmp;
			}

//			if(sizeof($nodes)>0){
//				echo json_encode($nodes);
//			}
//			
//			else {
//				echo '{}';
//			}


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
	  
		//$cond = new cls_criterio_filtro($decodificar);
		//$cond->add_criterio_extra("METAP1.fk_id_metaproceso","''$node''");
		$res = $Custom->ListarMetaprocesoHojaAsignado(15,0,'id_metaproceso','asc',$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$node,$id_rol);
		if($res)
		{
			foreach ($Custom->salida as $f)
			{


				$tmp['text'] = utf8_encode($f["nombre"]);
				$tmp['id'] = $f["id_metaproceso"];
				$tmp['cls']	= 'folder';
				$tmp['leaf'] = true;
				$tmp['allowDelete']	= true;
				$tmp['allowEdit']	= false;
				$tmp['allowDrag']	= false;
				$tmp['tipo'] = "item";
				$tmp['icon'] = "../../../lib/imagenes/item.png";
				$tmp['id_p'] = $f["id_padre"];
				$tmp['codigo'] = $f["codigo"];
				$tmp['nombre'] = $f["nombre"];
				$tmp['nivel'] = $f["nivel"];
				$tmp['fk_id_metaproceso'] = $f["fk_id_metaproceso"];
				$tmp['id_subsistema'] = $f["id_subsistema"];
				$tmp['nombre_archivo'] = $f["nombre_archivo"];
				$tmp['codigo_procedimiento'] = $f["codigo_procedimiento"];
				$nodes[] = $tmp;
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
			
			if(sizeof($nodes)>0){
				
				echo json_encode($nodes);
			}
			else {
				echo '{}';
			}

	
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