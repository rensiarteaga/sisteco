<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarcaifArb.php
Propósito:				Permite realizar el listado en tpr_caif
Tabla:					tpr_caif
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
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarCaifArb.php';

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

	if($sort == '') $sortcol = 'codigo_caif';
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
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'CaifArb');
	$sortcol = $crit_sort->get_criterio_sort();

	$nodos['totalCount']=0;
	
	if($node=='id'){
		//Obtiene el conjunto de datos de la consulta
		$res = $Custom->ListarCaifRaiz($cant,$puntero,'id_caif desc','desc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$gestion);                       
		if($res)
		{
			foreach ($Custom->salida as $f)
			{
				$tmp['text'] = utf8_encode($f["nombre_caif"])." - Gesti&oacute;n: ".utf8_encode($f["gestion_pres"]);
				$tmp['id'] = utf8_encode($f["id_caif"]);
				$tmp['cls']	= 'folder';
				$tmp['leaf'] = false;
				$tmp['allowDelete']	= true;
				$tmp['allowDrag']	= false;
				$tmp['allowEdit']	= true;
				$tmp['tipo']	= "agrupador";
				$tmp['icon'] = "../../../lib/imagenes/tuc.png";
				$tmp['codigo_caif'] = utf8_encode($f["codigo_caif"]);
				$tmp['nombre_caif'] = utf8_encode($f["nombre_caif"]);
				$tmp['desc_caif'] = utf8_encode($f["desc_caif"]);
				$tmp['nivel_caif'] = utf8_encode($f["nivel_caif"]);
				$tmp['sw_transaccional'] = utf8_encode($f["sw_transaccional"]);
				$tmp['sw_movimiento']=utf8_encode($f["sw_movimiento"]);
				$tmp['tipo_caif'] = utf8_encode($f["tipo_caif"]);
				$tmp['id_parametro'] = utf8_encode($f["id_parametro"]);
				$tmp['gestion_pres'] = utf8_encode($f["gestion_pres"]);
				$tmp['estado_gral'] = utf8_encode($f["estado_gral"]);
				//$tmp['tipo_memoria'] = utf8_encode($f["tipo_memoria"]);
				$tmp['dig_nivel'] = utf8_encode($f["dig_nivel"]);
				$tmp['qtipTitle']="caif: ".$tmp["nombre_caif"];
				
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
		$res = $Custom->ListarcaifArb($cant,$puntero,'codigo_caif asc','asc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$node,$gestion);                        
		if($res)
		{
			foreach ($Custom->salida as $f)
			{
				$tmp['text'] = utf8_encode($f["codigo_caif"])." - ".utf8_encode($f["nombre_caif"]);
				$tmp['id'] = utf8_encode($f["id_caif"]);
				$tmp['id_p'] = utf8_encode($f["id_caif_padre"]);
				$tmp['cls']	= 'folder';
				$tmp['leaf'] = false;
				$tmp['allowDelete']	=true;
				$tmp['allowEdit']	=true;
				$tmp['allowDrag']	=false;
				$tmp['centro']=utf8_encode($f["centro"]);
				$tmp['codigo_caif']=utf8_encode($f["codigo_caif"]);
				$tmp['nombre_caif']=utf8_encode($f["nombre_caif"]);
				$tmp['desc_caif']=utf8_encode($f["desc_caif"]);
				$tmp['nivel_caif']=utf8_encode($f["nivel_caif"]);
				$tmp['sw_transaccional']=utf8_encode($f["sw_transaccional"]);
				$tmp['tipo_caif']=utf8_encode($f["tipo_caif"]);
				$tmp['id_parametro']=utf8_encode($f["id_parametro"]);
				$tmp['gestion_pres']=utf8_encode($f["gestion_pres"]);
				$tmp['estado_gral'] = utf8_encode($f["estado_gral"]);
				$tmp['nombre_padre']=utf8_encode($f["nombre_padre"]);
				$tmp['codigo_padre']=utf8_encode($f["codigo_padre"]);
				//$tmp['tipo_memoria']=utf8_encode($f["tipo_memoria"]);
				$tmp['dig_nivel'] = utf8_encode($f["dig_nivel"]);
				/*$tmp['id_concepto_colectivo'] = utf8_encode($f["id_concepto_colectivo"]);
				$tmp['desc_colectivo'] = utf8_encode($f["desc_colectivo"]);
				$tmp['sw_movimiento']=utf8_encode($f["sw_movimiento"]);
				
				if($tmp['sw_transaccional']==1){
					$tmp['icon'] = "../../../lib/imagenes/tucr_.png";
					$tmp['tipo']	= "Movimiento";
				}
				else{
					$tmp['icon'] = "../../../lib/imagenes/tucr.png";
					$tmp['tipo']	= "Titular";
				}
				if($tmp['sw_movimiento']==1){
					$tmp['movimiento']	= "Presupuesto";
				}
				else{
					$tmp['movimiento']	= "Flujo";
				}*/
				
				/*if($tmp['tipo_memoria']==1){$tmp['memoria']	= "Recursos";}
				if($tmp['tipo_memoria']==2){$tmp['memoria']	= "Gasto";}
				if($tmp['tipo_memoria']==3){$tmp['memoria']	= "Inversiones";}
				if($tmp['tipo_memoria']==4){$tmp['memoria']	= "Pasajes";}
				if($tmp['tipo_memoria']==5){$tmp['memoria']	= "Viajes";}
				if($tmp['tipo_memoria']==6){$tmp['memoria']	= "RRHH";}
				if($tmp['tipo_memoria']==7){$tmp['memoria']	= "Servicios";}
				if($tmp['tipo_memoria']==8){$tmp['memoria']	= "Otros Gastos";}
				if($tmp['tipo_memoria']==9){$tmp['memoria']	= "Combustible";}*/
				
			/*	$tmp['qtip'] = "Tipo de Movimiento: ".$tmp['movimiento']." <br \/>Tipo de Memoria: ".$tmp["memoria"]." <br \/>Descripci&oacute;n: ".$tmp["desc_caif"];
				$tmp['qtipTitle']="caif: ".$tmp["nombre_caif"];
				$tmp['id_oec_sigma'] = utf8_encode($f["id_oec_sigma"]);
				$tmp['ent_trf']=utf8_encode($f["ent_trf"]);
				$tmp['cod_ascii']=utf8_encode($f["cod_ascii"]);
				$tmp['cod_excel']=utf8_encode($f["cod_excel"]);
				$tmp['cod_trans']=utf8_encode($f["cod_trans"]);*/
				$nodes[] = $tmp;
			}
			if(sizeof($nodes)>0){
				echo json_encode($nodes);
			}
			else {
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