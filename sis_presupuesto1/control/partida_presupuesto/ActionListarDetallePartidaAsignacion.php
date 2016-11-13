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
include_once('../LibModeloPresupuesto.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarDetallePartidaAsignacion.php';

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

	if($sort == '') $sortcol = 'codigo_partida';
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
	$cond->add_criterio_extra("PARTID.tipo_partida",$tipo_pres);
	//$cond->add_criterio_extra("PARAM.estado_gral",$estado_gral);
	$cond->add_criterio_extra("PARTID.id_parametro",$id_parametro);
	
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	//Obtiene el criterio de orden de columnas
	
	
	/*echo ('Rol Metaproceso');
	exit ;*/
	//$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Rol Metaproceso');

	//echo $crit_sort."cri_sort";
	//$sortcol = $crit_sort->get_criterio_sort();

	$nodos['totalCount']=0;
	
	if($node=='id')
	{		
		//Obtiene el conjunto de datos de la consulta
		//$criterio_filtro='0=0';
	
		$res = $Custom->ListarDetallePartidaAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_presupuesto);
	
		if($res)
		{
			foreach ($Custom->salida as $f)
			{				
				//exit();
				//echo $f["nombre"];_
				//$tmp['text'] = utf8_encode($f["codigopartida"]."  ".$f["nombre_partida"]);
				$tmp['text'] = utf8_encode($f["codigopartida"]."  ".$f["nombre_partida"])." - Gesti&oacute;n: ".utf8_encode($f["gestion_pres"]);
				$tmp['id'] = $f["id_partida"];
				$tmp['cls']	= 'folder';
				$tmp['leaf'] = false;
				$tmp['allowDelete']	= false;
				$tmp['allowEdit']	= true;
				$tmp['tipo'] = "raiz";
				
				$tmp['id_partida'] = $f["id_partida"];
				$tmp['nombre_partida'] = $f["nombre_partida"];
				$tmp['codigo_partida'] = $f["codigo_partida"];
				$tmp['desc_partida'] = $f["desc_partida"];
				$tmp['nivel_partida'] = $f["nivel_partida"];
				$tmp['sw_transaccional'] = $f["sw_transaccional"];
				$tmp['tipo_partida'] = $f["tipo_partida"];
				$tmp['id_parametro'] = $f["id_parametro"];
				$tmp['tipo_memoria'] = $f["tipo_memoria"];
				$tmp['sw_movimiento'] = $f["sw_movimiento"];
				
				if($f["sw_transaccional"]==1)
				{
					if($f['checked']=='t')
					{
						$tmp['checked']=true;
					}
					else 
					{
						$tmp['checked']=false;
					}
				}				
					
				if($f['color']=='t')
				{
					$tmp['text']="<span style=color:blue>". utf8_encode($f["nombre"]) ."</span>";
				}
		

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
				}
				$tmp['qtip'] = "Tipo de Movimiento: ".$tmp['movimiento']." <br \/>Descripci&oacute;n: ".$tmp["desc_partida"];
				$tmp['qtipTitle']="Partida: ".$tmp["nombre_partida"];	 
				
				$nodes[] = $tmp;
			}

			if(sizeof($nodes)>0)
			{				
				echo json_encode($nodes);
			}
			else 
			{
				echo '{1. No existe una raiz para la gestion}';
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
	{	//Obtiene el conjunto de datos de la consulta
		$cond->add_criterio_extra("PARTID.tipo_partida",$tipo_pres);
		$cond->add_criterio_extra("PARAM.estado_gral",$estado_gral);
		$res = $Custom->ListarDetallePartidaAsignacionRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$node,$id_presupuesto);
		if($res)
		{
			foreach ($Custom->salida as $f)
			{	if($f['sw_transaccional']==1)
				{
					$tmp['text'] = utf8_encode($f["codigo_partida"]." - ".$f["nombre_partida"]);
					$tmp['id'] = $f["id_partida"];
					$tmp['cls']	= 'folder';
					$tmp['leaf'] = false;
					$tmp['allowDelete']	= false;
					$tmp['allowEdit']	= true;
					$tmp['tipo'] = "raiz";
					
					$tmp['id_partida'] = $f["id_partida"];
					$tmp['nombre_partida'] = $f["nombre_partida"];
					$tmp['codigo_partida'] = $f["codigo_partida"];
					$tmp['desc_partida'] = $f["desc_partida"];
					$tmp['nivel_partida'] = $f["nivel_partida"];
					$tmp['sw_transaccional'] = $f["sw_transaccional"];
					$tmp['tipo_partida'] = $f["tipo_partida"];
					$tmp['id_parametro'] = $f["id_parametro"];
					$tmp['tipo_memoria'] = $f["tipo_memoria"];
					$tmp['sw_movimiento'] = $f["sw_movimiento"];			
					
					$tmp['icon'] = "../../../lib/imagenes/tucr_.png";
					$tmp['tipo']	= "Movimiento";
					
					if($f['checked']=='t'){$tmp['checked']=true;}
					else {$tmp['checked']=false;}
					
					if($tmp['sw_movimiento']==1){$tmp['movimiento']	= "Presupuesto";}
					else{$tmp['movimiento']	= "Flujo";}
				
					if($tmp['tipo_memoria']==1){$tmp['memoria']	= "Recursos";}
					if($tmp['tipo_memoria']==2){$tmp['memoria']	= "Gasto";}
					if($tmp['tipo_memoria']==3){$tmp['memoria']	= "Inversiones";}
					if($tmp['tipo_memoria']==4){$tmp['memoria']	= "Pasajes";}
					if($tmp['tipo_memoria']==5){$tmp['memoria']	= "Viajes";}
					if($tmp['tipo_memoria']==6){$tmp['memoria']	= "RRHH";}
					if($tmp['tipo_memoria']==7){$tmp['memoria']	= "Servicios";}
					if($tmp['tipo_memoria']==8){$tmp['memoria']	= "Otros Gastos";}
					if($tmp['tipo_memoria']==9){$tmp['memoria']	= "Combustible";}				
				
					$tmp['qtip'] = "Tipo de Movimiento: ".$tmp['movimiento']." <br \/>Tipo de Memoria: ".$tmp["memoria"]." <br \/>Descripci&oacute;n: ".$tmp["desc_partida"];
					//$tmp['qtip'] = "Tipo de Movimiento: ".$tmp['movimiento']." <br \/>Tipo de Partida: ".$tmp["tipo"];
					$tmp['qtipTitle']="Partida: ".$tmp["nombre_partida"];
					$nodes[] = $tmp;
				}
				else 
				{
					$tmp_2['text'] = utf8_encode($f["codigo_partida"]." - ".$f["nombre_partida"]);
					$tmp_2['id'] = $f["id_partida"];
					$tmp_2['cls']	= 'folder';
					$tmp_2['leaf'] = false;
					$tmp_2['allowDelete']	= false;
					$tmp_2['allowEdit']	= true;
					$tmp_2['tipo'] = "raiz";
					
					$tmp_2['id_partida'] = $f["id_partida"];
					$tmp_2['nombre_partida'] = $f["nombre_partida"];
					$tmp_2['codigo_partida'] = $f["codigo_partida"];
					$tmp_2['desc_partida'] = $f["desc_partida"];
					$tmp_2['nivel_partida'] = $f["nivel_partida"];
					$tmp_2['sw_transaccional'] = $f["sw_transaccional"];
					$tmp_2['tipo_partida'] = $f["tipo_partida"];
					$tmp_2['id_parametro'] = $f["id_parametro"];
					$tmp_2['tipo_memoria'] = $f["tipo_memoria"];
					$tmp_2['sw_movimiento'] = $f["sw_movimiento"];
					
					$tmp_2['icon'] = "../../../lib/imagenes/tucr.png";
					$tmp_2['tipo']	= "Titular";
					
					if($tmp_2['sw_movimiento']==1){$tmp_2['movimiento']	= "Presupuesto";}
					else{$tmp_2['movimiento']	= "Flujo";}
				
					$tmp_2['qtip'] = "Tipo de Movimiento: ".$tmp_2['movimiento']." <br \/>Descripci&oacute;n: ".$tmp_2["desc_partida"];
					$tmp_2['qtipTitle']="Partida: ".$tmp_2["nombre_partida"];
					//echo $f['sw_transaccional']."    sw_t ra";
					
					//echo json_encode($tmp_2);
					$nodes[] = $tmp_2;	
			
				}
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
			
		if(sizeof($nodes)>0)
		{
			echo json_encode($nodes);
		}
		else 
		{
			echo '{2. No existen ramas para el nodo padre}';
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