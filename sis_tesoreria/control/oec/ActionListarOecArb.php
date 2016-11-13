<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarOecArb.php
Propósito:				Permite realizar el listado en tts_oec
Tabla:					tts_oec
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
include_once('../LibModeloTesoreria.php');

$Custom = new cls_CustomDBTesoreria();
$nombre_archivo = 'ActionListarOecArb.php';

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

	if($sort == '') $sortcol = 'OEC.nro_oec';
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
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'OecArb');
	$sortcol = $crit_sort->get_criterio_sort();

	$nodos['totalCount']=0;
	if($node=='id'){

		//Obtiene el conjunto de datos de la consulta
		$res = $Custom->ListarOecRaiz($cant,$puntero,'OEC.tipo_oec asc','asc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$gestion);
                                      
		if($res)
		{
			foreach ($Custom->salida as $f)
			{
				    $tmp['text'] = utf8_encode($f["nro_oec"])." - ".utf8_encode($f["nombre_oec"]);	
				    $tmp['id'] = utf8_encode($f["id_oec"]);
					$tmp['cls']	= 'folder';
					$tmp['leaf'] = false;
					$tmp['allowDelete']	= true;
					$tmp['allowDrag']	= false;
					$tmp['allowEdit']	= true;
					$tmp['tipo']	= "agrupador";					
					$tmp['nro_oec'] = utf8_encode($f["nro_oec"]);
					$tmp['nombre_oec'] = utf8_encode($f["nombre_oec"]);
					$tmp['desc_oec'] = utf8_encode($f["desc_oec"]);
					$tmp['nivel_oec'] = utf8_encode($f["nivel_oec"]);
					$tmp['tipo_oec'] = utf8_encode($f["tipo_oec"]);
					if($tmp['tipo_oec']==1){
						$tmp['icon'] = "../../../lib/imagenes/tuc.png";
					}
					elseif ($tmp['tipo_oec']==2){
						$tmp['icon'] = "../../../lib/imagenes/tuc.png";
					}
					elseif ($tmp['tipo_oec']==3){
						$tmp['icon'] = "../../../lib/imagenes/tuc.png";
					}
					elseif ($tmp['tipo_oec']==4){
						$tmp['icon'] = "../../../lib/imagenes/tuc_in.png";
					}
					else{
						$tmp['icon'] = "../../../lib/imagenes/tucrem.png";
					}
					$tmp['sw_transaccional'] = utf8_encode($f["sw_transaccional"]);
					$tmp['id_parametro'] = utf8_encode($f["id_parametro"]);
					$tmp['cantidad_nivel'] = utf8_encode($f["cantidad_nivel"]);
					$tmp['estado_gestion'] = utf8_encode($f["estado_gestion"]);
					$tmp['gestion_tesoro'] = utf8_encode($f["gestion_tesoro"]);
					$tmp['dig_nivel'] = utf8_encode($f["dig_nivel"]);
							
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
		//Obtiene el conjunto de datos de la consulta
		$res = $Custom->ListarOecArb($cant,$puntero,'OEC.nro_oec asc','asc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$node,$gestion);                        
		if($res)
		{
			foreach ($Custom->salida as $f)
			{

				$tmp['text']=utf8_encode($f["nro_oec"])." - ".utf8_encode($f["nombre_oec"]);
				$tmp['id']=utf8_encode($f["id_oec"]);
				$tmp['id_p']=utf8_encode($f["id_oec_padre"]);
				$tmp['cls']='folder';
				$tmp['leaf']=false;
				$tmp['allowDelete']=true;
				$tmp['allowEdit']=true;
				$tmp['allowDrag']=false;
				$tmp['nro_oec']=utf8_encode($f["nro_oec"]);
				$tmp['nombre_oec']=utf8_encode($f["nombre_oec"]);
				$tmp['desc_oec']=utf8_encode($f["desc_oec"]);
				$tmp['nivel_oec']=utf8_encode($f["nivel_oec"]);
				$tmp['tipo_oec']=utf8_encode($f["tipo_oec"]);
				$tmp['sw_transaccional']=utf8_encode($f["sw_transaccional"]);				
				$tmp['nombre_padre']=utf8_encode($f["nombre_padre"]);
				$tmp['id_parametro']=utf8_encode($f["id_parametro"]);
				$tmp['cantidad_nivel']=utf8_encode($f["cantidad_nivel"]);
				$tmp['estado_gestion']=utf8_encode($f["estado_gestion"]);
				$tmp['gestion_tesoro']=utf8_encode($f["gestion_tesoro"]);				
				$tmp['dig_nivel']=utf8_encode($f["dig_nivel"]);
				if($tmp['tipo_oec']==1){
					$tmp['oec']="Ingresos Totales";
				}
				elseif($tmp['tipo_oec']==2){
					$tmp['oec']="Egresos Totales";
				}
				elseif($tmp['tipo_oec']==3){
					$tmp['oec']="D&eacute;ficit o Super&aacute;vit";
				}
				elseif($tmp['tipo_oec']==4){
					$tmp['oec']="Financiamiento";
				}
				else{
					$tmp['oec']="Egresos";
				}
				if($tmp['sw_transaccional']==1){
					$tmp['icon']="../../../lib/imagenes/tucr_.png";
					$tmp['tipo']="Movimiento";
					$tmp['qtip']="Tipo de Oec: ".$tmp['oec']." <br \/>Tipo de Transacci&oacute;n: ".$tmp["tipo"];
				    $tmp['qtipTitle']="OEC: ".$tmp["nombre_oec"];
				}
				else{
					$tmp['icon']="../../../lib/imagenes/tucr.png";
					$tmp['tipo']="Titular";
					$tmp['qtip']="Tipo de Oec: ".$tmp['oec']." <br \/>Tipo de Transacci&oacute;n: ".$tmp["tipo"];
				    $tmp['qtipTitle']="OEC: ".$tmp["nombre_oec"];
				}				
				$nodes[]=$tmp;
			}
			if(sizeof($nodes)>0){
				echo json_encode($nodes);
			}
			else{
				echo '{}';
			}
		}
		else{
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