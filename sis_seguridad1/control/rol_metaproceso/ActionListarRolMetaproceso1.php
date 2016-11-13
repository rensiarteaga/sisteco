<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarTipoUnidadConstructiva.php
Propósito:				Permite realizar el listado en tal_tipo_unidad_constructiva
Tabla:					t_tal_tipo_unidad_constructiva
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2007-11-07 15:46:18
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloSeguridad.php');

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = 'ActionListarRolMetaproceso1.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
	//Parámetros del filtro
	if($limit == '') $cant = 100;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_metaproceso';
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
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Rol Metaproceso');
	$sortcol = $crit_sort->get_criterio_sort();

	$nodos['totalCount']=0;
	
	if($node=='id'){
		
		//Obtiene el conjunto de datos de la consulta and METAPR.visible = ''si'' 
		$criterio_filtro="0=0 ";
		$res = $Custom->ListarMetaprocesoRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_rol);

		if($res)
		{
			foreach ($Custom->salida as $f)
			{

				
				$tmp['text'] = utf8_encode($f["nombre"]);
				$tmp['id'] = $f["id_metaproceso"];
				$tmp['cls']	= 'folder';
				$tmp['leaf'] = false;
				$tmp['allowDelete']	= false;
				$tmp['allowEdit']	= true;
				$tmp['tipo'] = "raiz";
				$tmp['id_metaproceso'] = $f["id_metaproceso"];
				$tmp['nombre'] = $f["nombre"];
				$tmp['nivel'] = $f["nivel"];
				$tmp['fk_id_metaproceso'] = $f["fk_id_metaproceso"];
				$tmp['id_subsistema'] = $f["id_subsistema"];
				$tmp['nombre_archivo'] = $f["nombre_archivo"];
				$tmp['codigo_procedimiento'] = $f["codigo_procedimiento"];
				if($f['checked']=='t'){
					$tmp['checked']=true;
				}
				else {
					$tmp['checked']=false;
				}
				if($f['color']=='t'){
				$tmp['text']="<span style=color:blue>". utf8_encode($f["nombre"]) ."</span>";
				}
				if($f["tipo_vista"]=='hijo' || $f["tipo_vista"]=='padre_hijo'){
					$tmp['icon']= "../../../lib/imagenes/images.png";
					
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
	else
	{

		//Obtiene el conjunto de datos de la consulta and METAP1.visible = ''si''
		$criterio_filtro="0=0 ";
		$res = $Custom->ListarMetaprocesoRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$node,$id_rol);

		if($res)
		{
			foreach ($Custom->salida as $f)
			{

				$tmp['text'] =utf8_encode( $f["nombre"]);
				$tmp['id'] = $f["id_metaproceso"];
				$tmp['leaf'] = false;
				if($f["icono"]!=null && $f["icono"]!=''){
					$tmp['icon']= "../../../lib/imagenes/".$f["icono"];
				}else{
					$tmp['cls'] = "folder";
				}
				$tmp['allowDelete']	= true;
				$tmp['allowEdit']	= true;
				$tmp['tipo'] = "rama";
				$tmp['id_p'] = $f["id_padre"];
				$tmp['codigo'] = $f["codigo"];
				$tmp['nombre'] = $f["nombre"];
				$tmp['nivel'] = $f["nivel"];
				$tmp['fk_id_metaproceso'] = $f["fk_id_metaproceso"];
				$tmp['id_subsistema'] = $f["id_subsistema"];
				$tmp['nombre_archivo'] = $f["nombre_archivo"];
				$tmp['codigo_procedimiento'] = $f["codigo_procedimiento"];
				if($f['checked']=='t'){
				$tmp['checked']=true;
				}
				else {
					$tmp['checked']=false;
				}
				if($f['color']=='t'){
				$tmp['text']="<span style=color:blue>". utf8_encode($f["nombre"]) ."</span>";
				}
				if($f["tipo_vista"]=='hijo' || $f["tipo_vista"]=='padre_hijo'){
					$tmp['icon']= "../../../lib/imagenes/images.png";
				}

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

		$criterio_filtro="0=0  AND METADB.codigo_procedimiento not like ''%COUNT%''" ;
		$res = $Custom->ListarMetaprocesoDB_arb('METADB.codigo_procedimiento','asc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$node,$id_rol);

		if($res)
		{
			foreach ($Custom->salida as $f)
			{

				$tmp['text'] = utf8_encode($f["descripcion"]);
				$tmp['id'] = $f["id_metaproceso_db"];
				$tmp['id_p'] =$f["id_metaproceso"];
				$tmp['icon'] = "../../../lib/imagenes/page_white_gear.png";
				$tmp['leaf'] = true;
				$tmp['allowDelete']	= true;
				$tmp['allowEdit']	= false;
				$tmp['allowDrag']	= false;
				$tmp['tipo']='item';
				$tmp['codigo_procedimiento'] = $f['codigo_procedimiento'];
				$tmp['nombre'] = $tmp['descripcion'];
				$tmp['nombre_funcion'] = $f["nombre_funcion"];
				$tmp['descripcion'] = $f["descripcion"];
				$tmp['qtip'] = utf8_encode("Funcion: ".$tmp['nombre_funcion']." <br>Descripcion: ".$tmp["codigo_procedimiento"]);
				$tmp['qtipTitle']= utf8_encode("Codigo: ".$tmp['id']);
				if($f["checked"]=='t'){
					$tmp['checked']=true;
				}
				else{
					$tmp['checked']=false;
				}

				$nodes[] = $tmp;
				$tmp=null;
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