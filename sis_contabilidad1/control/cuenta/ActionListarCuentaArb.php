<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCuentaArb.php
Propósito:				Permite realizar el listado en tct_cuenta
Tabla:					tct_cuenta
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
include_once('../LibModeloContabilidad.php');

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarCuentaArb.php';

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

	if($sort == '') $sortcol = 'nro_cuenta';
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
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'CuentaArb');
	$sortcol = $crit_sort->get_criterio_sort();

	$nodos['totalCount']=0;
	if($node=='id'){

		//Obtiene el conjunto de datos de la consulta
		$res = $Custom->ListarCuentaRaiz($cant,$puntero,'tipo_cuenta asc','asc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$gestion);
                                      
		if($res)
		{
			foreach ($Custom->salida as $f){
			    $tmp['text'] = utf8_encode($f["nro_cuenta"])." - ".utf8_encode($f["nombre_cuenta"]);	
			    $tmp['id'] = utf8_encode($f["id_cuenta"]);
				$tmp['cls']	= 'folder';
				$tmp['leaf'] = false;
				$tmp['allowDelete']	= true;
				$tmp['allowDrag']	= false;
				$tmp['allowEdit']	= true;
				$tmp['tipo']	= "agrupador";					
				$tmp['nro_cuenta'] = utf8_encode($f["nro_cuenta"]);
				$tmp['nombre_cuenta'] = utf8_encode($f["nombre_cuenta"]);
				$tmp['desc_cuenta'] = utf8_encode($f["desc_cuenta"]);
				$tmp['nivel_cuenta'] = utf8_encode($f["nivel_cuenta"]);
				$tmp['tipo_cuenta'] = utf8_encode($f["tipo_cuenta"]);
				if($tmp['tipo_cuenta']==1){
					$tmp['icon'] = "../../../lib/imagenes/tuc.png";
				}
				elseif ($tmp['tipo_cuenta']==2){
					$tmp['icon'] = "../../../lib/imagenes/tuc.png";
				}
				elseif ($tmp['tipo_cuenta']==3){
					$tmp['icon'] = "../../../lib/imagenes/tuc.png";
				}
				elseif ($tmp['tipo_cuenta']==4){
					$tmp['icon'] = "../../../lib/imagenes/tuc_in.png";
				}
				else{
					$tmp['icon'] = "../../../lib/imagenes/tucrem.png";
				}
				$tmp['sw_transaccional'] = utf8_encode($f["sw_transaccional"]);
				$tmp['id_parametro'] = utf8_encode($f["id_parametro"]);
				$tmp['cantidad_nivel'] = utf8_encode($f["cantidad_nivel"]);
				$tmp['estado_gestion'] = utf8_encode($f["estado_gestion"]);
				$tmp['gestion_conta'] = utf8_encode($f["gestion_conta"]);
				$tmp['id_moneda'] = utf8_encode($f["id_moneda"]);
				$tmp['nombre_moneda'] = utf8_encode($f["nombre_moneda"]);
				$tmp['dig_nivel'] = utf8_encode($f["dig_nivel"]);
				$tmp['sw_oec'] = utf8_encode($f["sw_oec"]);	
				$tmp['sw_aux'] = utf8_encode($f["sw_aux"]);
				$tmp['descripcion'] = utf8_encode($f["descripcion"]);	
				$tmp['cuenta_sigma'] = utf8_encode($f["cuenta_sigma"]);
                $tmp['sw_sigma'] = utf8_encode($f["sw_sigma"]);
                $tmp['id_cuenta_actualizacion'] = utf8_encode($f["id_cuenta_actualizacion"]);
                $tmp['nombre_cuenta_actualizacion'] = utf8_encode($f["nombre_cuenta_actualizacion"]);
                $tmp['id_auxiliar_actualizacion'] = utf8_encode($f["id_auxiliar_actualizacion"]);
                $tmp['nombre_auxiliar_actualizacion'] = utf8_encode($f["nombre_auxiliar_actualizacion"]);
                $tmp['sw_sistema_actualizacion'] = utf8_encode($f["sw_sistema_actualizacion"]);
                $tmp['id_cuenta_dif'] = utf8_encode($f["id_cuenta_dif"]);
                $tmp['nombre_cuenta_dif'] = utf8_encode($f["nombre_cuenta_dif"]);
                $tmp['id_auxiliar_dif'] = utf8_encode($f["id_auxiliar_dif"]);
                $tmp['nombre_auxiliar_dif'] = utf8_encode($f["nombre_auxiliar_dif"]);
				$tmp['cuenta_flujo_sigma'] = utf8_encode($f["cuenta_flujo_sigma"]);
				$tmp['nota_eeff'] = utf8_encode($f["nota_eeff"]);
				$tmp['id_partida_flu_debe'] = utf8_encode($f["id_partida_flu_debe"]);
				$tmp['id_partida_flu_haber'] = utf8_encode($f["id_partida_flu_haber"]);
				$tmp['id_cuenta_sigma'] = utf8_encode($f["id_cuenta_sigma"]);
				$tmp['desc_sigma'] = utf8_encode($f["desc_sigma"]);
				$tmp['desc_partida_debe'] = utf8_encode($f["desc_partida_debe"]);
				$tmp['desc_partida_haber'] = utf8_encode($f["desc_partida_haber"]);
				$tmp['sw_caif'] = utf8_encode($f["sw_caif"]);
				$tmp['sw_siet'] = utf8_encode($f["sw_siet"]);
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
		$res = $Custom->ListarCuentaArb($cant,$puntero,'nro_cuenta asc','asc',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$node,$gestion);                        
		if($res)
		{
			foreach ($Custom->salida as $f)
			{
				$tmp['text']=utf8_encode($f["nro_cuenta"])." - ".utf8_encode($f["nombre_cuenta"]);
				$tmp['id']=utf8_encode($f["id_cuenta"]);
				$tmp['id_p']=utf8_encode($f["id_cuenta_padre"]);
				$tmp['cls']='folder';
				$tmp['leaf']=false;
				$tmp['allowDelete']=true;
				$tmp['allowEdit']=true;
				$tmp['allowDrag']=false;
				$tmp['nro_cuenta']=utf8_encode($f["nro_cuenta"]);
				$tmp['nombre_cuenta']=utf8_encode($f["nombre_cuenta"]);
				$tmp['desc_cuenta']=utf8_encode($f["desc_cuenta"]);
				$tmp['nivel_cuenta']=utf8_encode($f["nivel_cuenta"]);
				$tmp['tipo_cuenta']=utf8_encode($f["tipo_cuenta"]);
				$tmp['sw_transaccional']=utf8_encode($f["sw_transaccional"]);				
				$tmp['nombre_padre']=utf8_encode($f["nombre_padre"]);
				$tmp['id_parametro']=utf8_encode($f["id_parametro"]);
				$tmp['cantidad_nivel']=utf8_encode($f["cantidad_nivel"]);
				$tmp['estado_gestion']=utf8_encode($f["estado_gestion"]);
				$tmp['gestion_conta']=utf8_encode($f["gestion_conta"]);				
				$tmp['id_moneda']=utf8_encode($f["id_moneda"]);
				$tmp['nombre_moneda']=utf8_encode($f["nombre_moneda"]);
				$tmp['dig_nivel']=utf8_encode($f["dig_nivel"]);
				$tmp['sw_oec'] = utf8_encode($f["sw_oec"]);
				$tmp['sw_aux'] = utf8_encode($f["sw_aux"]);
				$tmp['descripcion'] = utf8_encode($f["descripcion"]);	
				$tmp['cuenta_sigma'] = utf8_encode($f["cuenta_sigma"]);
                $tmp['sw_sigma'] = utf8_encode($f["sw_sigma"]);
                $tmp['id_cuenta_actualizacion'] = utf8_encode($f["id_cuenta_actualizacion"]);
                $tmp['nombre_cuenta_actualizacion'] = utf8_encode($f["nombre_cuenta_actualizacion"]);
                $tmp['id_auxiliar_actualizacion'] = utf8_encode($f["id_auxiliar_actualizacion"]);
                $tmp['nombre_auxiliar_actualizacion'] = utf8_encode($f["nombre_auxiliar_actualizacion"]);
                $tmp['sw_sistema_actualizacion'] = utf8_encode($f["sw_sistema_actualizacion"]);
                $tmp['id_cuenta_dif'] = utf8_encode($f["id_cuenta_dif"]);
                $tmp['nombre_cuenta_dif'] = utf8_encode($f["nombre_cuenta_dif"]);
                $tmp['id_auxiliar_dif'] = utf8_encode($f["id_auxiliar_dif"]);
                $tmp['nombre_auxiliar_dif'] = utf8_encode($f["nombre_auxiliar_dif"]);
				$tmp['cuenta_flujo_sigma'] = utf8_encode($f["cuenta_flujo_sigma"]);
				$tmp['nota_eeff'] = utf8_encode($f["nota_eeff"]);
				$tmp['id_cuenta_sigma'] = utf8_encode($f["id_cuenta_sigma"]);
				$tmp['desc_sigma'] = utf8_encode($f["desc_sigma"]);
				$tmp['id_partida_flu_debe'] = utf8_encode($f["id_partida_flu_debe"]);
				$tmp['id_partida_flu_haber'] = utf8_encode($f["id_partida_flu_haber"]);
				$tmp['desc_partida_debe'] = utf8_encode($f["desc_partida_debe"]);
				$tmp['desc_partida_haber'] = utf8_encode($f["desc_partida_haber"]);
				$tmp['sw_caif'] = utf8_encode($f["sw_caif"]);
				$tmp['sw_siet'] = utf8_encode($f["sw_siet"]);
				 
                if($tmp['tipo_cuenta']==1){
					$tmp['cuenta']="Activo";
				}
				elseif($tmp['tipo_cuenta']==2){
					$tmp['cuenta']="Pasivo";
				}
				elseif($tmp['tipo_cuenta']==3){
					$tmp['cuenta']="Patrimonio";
				}
				elseif($tmp['tipo_cuenta']==4){
					$tmp['cuenta']="Ingresos";
				}
				else{
					$tmp['cuenta']="Egresos";
				}
				if($tmp['sw_transaccional']==1){
					$tmp['icon']="../../../lib/imagenes/tucr_.png";
					$tmp['tipo']="Movimiento";
					$tmp['qtip']="Tipo de Cuenta: ".$tmp['cuenta']." <br \/>Tipo de Transacci&oacute;n: ".$tmp["tipo"]." <br \/>Moneda: ".$tmp["nombre_moneda"];
				    $tmp['qtipTitle']="Cuenta: ".$tmp["nombre_cuenta"];
				}
				else{
					$tmp['icon']="../../../lib/imagenes/tucr.png";
					$tmp['tipo']="Titular";
					$tmp['qtip']="Tipo de Cuenta: ".$tmp['cuenta']." <br \/>Tipo de Transacci&oacute;n: ".$tmp["tipo"];
				    $tmp['qtipTitle']="Cuenta: ".$tmp["nombre_cuenta"];
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