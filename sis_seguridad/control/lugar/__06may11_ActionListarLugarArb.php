<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarLugarArb.php
Propósito:				Permite desplegar datos de los lugares
Tabla:					tsg_lugar
Parámetros:				$cant
$puntero
$sortcol
$sortdir
$criterio_filtro
$id_usuario_asignacion

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		24-03-2008
Versión:				1.0.0
Autor:					Mercedes Zambrana Meneses
**********************************************************
*/
session_start();
include_once("../LibModeloSeguridad.php");

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = 'ActionListarLugarArb.php';


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

	if($sort == '') $sortcol = 'id_lugar';
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
	if($node=='id'){
		$criterio_filtro= $criterio_filtro." AND LUGARR.id_lugar= LUGARR_1.fk_id_lugar and LUGARR.nivel=0";
	}
	
	$nodos['totalCount']=0;
	if($node=='id'){
		$res = $Custom->ListarLugarArb(15,0,'id_lugar','asc',$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		if($res)
		{
			foreach ($Custom->salida as $f)
			{
				$tmp['text'] = utf8_encode($f["nombre"]);
				$tmp['id'] = $f["id_lugar"];
				$tmp['cls']	= 'folder';
				$tmp['leaf'] = false;
				$tmp['allowDelete']	= true;
				$tmp['allowEdit']	= true;
				$tmp['allowDrag']	= false;
				$tmp['tipo'] = "raiz";
				$tmp['id_p'] = $f["id_padre"];
				$tmp['codigo'] = $f["codigo"];
				$tmp['nombre'] = $f["nombre"];
				$tmp['nivel'] = $f["nivel"];
				$tmp['fk_id_lugar'] = $f["fk_id_lugar"];
				$tmp['ubicacion'] = $f["ubicacion"];
				$tmp['sw_municipio'] = $f["sw_municipio"];
				$tmp['telefono1'] = $f["telefono1"];
				$tmp['telefono2'] = $f["telefono2"];
				$tmp['fax'] = $f["fax"];
				$tmp['nombre_nivel']=$f["nombre_nivel"];
				$tmp['sw_impuesto']=$f["sw_impuesto"];
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
	  { $criterio_filtro= $criterio_filtro." AND LUGARR.id_lugar in  (select fk_id_lugar from tsg_lugar) and LUGARR.nivel>0 and LUGARR.fk_id_lugar= COALESCE($node,1)";
	
		$res = $Custom->ListarLugarRama(15,0,'id_lugar','asc',$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$node);
		
		if($res)
		{
			foreach ($Custom->salida as $f)
			{
				$tmp['text'] = utf8_encode($f["nombre"]);
				$tmp['id'] = $f["id_lugar"];
				$tmp['cls']	= 'folder';
				$tmp['leaf'] = false;
				$tmp['allowDelete']	= true;
				$tmp['allowEdit']	= true;
				$tmp['allowDrag']	= false;
				$tmp['tipo'] = "rama";
				$tmp['id_p'] = $f["id_padre"];
				$tmp['codigo'] = $f["codigo"];
				$tmp['nombre'] = $f["nombre"];
				$tmp['nivel'] = $f["nivel"];
				$tmp['fk_id_lugar'] = $f["fk_id_lugar"];
				$tmp['ubicacion'] = $f["ubicacion"];
				$tmp['sw_municipio'] = $f["sw_municipio"];
				$tmp['telefono1'] = $f["telefono1"];
				$tmp['telefono2'] = $f["telefono2"];
				$tmp['fax'] = $f["fax"];
				$tmp['nombre_nivel']=$f["nombre_nivel"];
				$tmp['sw_impuesto']=$f["sw_impuesto"];
				$nodes[] = $tmp;
			}

//			if(sizeof($nodes)>0){
//				echo json_encode($nodes);
//			}
//			
//			else {
//				echo '{}';
//			}
//

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
	  	$criterio_filtro= '0=0';
	  	
		$res = $Custom->ListarLugarHoja(15,0,'id_lugar','asc',$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$node);
		if($res)
		{
			foreach ($Custom->salida as $f)
			{
				$tmp['text'] = utf8_encode($f["nombre"]);
				$tmp['id'] = $f["id_lugar"];
				$tmp['cls']	= 'folder';
				$tmp['leaf'] = true;
				$tmp['allowDelete']	= true;
				$tmp['allowEdit']	= true;
				$tmp['allowDrag']	= true;
				$tmp['tipo'] = "hoja";
				$tmp['id_p'] = $f["id_padre"];
				$tmp['codigo'] = $f["codigo"];
				$tmp['nombre'] = $f["nombre"];
				$tmp['nivel'] = $f["nivel"];
				$tmp['fk_id_lugar'] = $f["fk_id_lugar"];
				$tmp['ubicacion'] = $f["ubicacion"];
				$tmp['sw_municipio'] = $f["sw_municipio"];
				$tmp['telefono1'] = $f["telefono1"];
				$tmp['telefono2'] = $f["telefono2"];
				$tmp['fax'] = $f["fax"];
				$tmp['nombre_nivel']=$f["nombre_nivel"];
				$tmp['sw_impuesto']=$f["sw_impuesto"];
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