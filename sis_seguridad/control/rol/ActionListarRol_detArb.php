<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarRol_detArb.php
Propósito:				Permite realizar el listado en tsg_usuario_rol
Tabla:					tsg_usuario_rol
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-05-17 11:06:18
Versión:				1.0.0
Autor:					Mercedes Zambrana Meneses
**********************************************************
*/
session_start();
include_once('../LibModeloSeguridad.php');

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = 'ActionListarRol_detArb.php';

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

	if($sort == '') $sortcol = 'id_rol';
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
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Rol');
	$sortcol = $crit_sort->get_criterio_sort();



	$nodos['totalCount']=0;
	
	if($node=='id'){
		
		//Obtiene el conjunto de datos de la consulta
		$criterio_filtro='0=0';
		$res = $Custom->ListarRolArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_usuario);

		if($res)
		{
			foreach ($Custom->salida as $f)
			{

				
				$tmp['text'] = utf8_encode($f["nombre"]);
				$tmp['id'] = $f["id_rol"];
				$tmp['cls']	= 'folder';
				$tmp['leaf'] =true;
				$tmp['allowDelete']	= false;
				$tmp['allowEdit']	= true;
				$tmp['tipo'] = "raiz";
				$tmp['id_rol'] = $f["id_rol"];
				$tmp['nombre'] = $f["nombre"];
				$tmp['descripcion'] = $f["descripcion"];
				if($f['checked']=='t'){
					$tmp['checked']=true;
				}
				else {
					$tmp['checked']=false;
				}
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