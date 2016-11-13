<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarTipoUnidadConstructiva.php
Propósito:				Permite insertar y modificar datos en la tabla tal_tipo_unidad_constructiva
Tabla:					tal_tal_tipo_unidad_constructiva
Parámetros:				$hidden_id_tipo_unidad_constructiva
						$txt_codigo
						$txt_nombre
						$txt_tipo
						$txt_descripcion
						$txt_observaciones
						$txt_fecha_reg

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-11-07 15:46:18
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../rcm_LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = "ActionGuardarTipoUnidadConstructiva.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{

	$decodificado = stripslashes($_REQUEST['datos']);
	$proceso=stripslashes($_REQUEST['proc']);

	$nodo = json_decode($decodificado,true);

	/*	echo "proc:".$proc;
	echo "tipo:".$nodo['tipo'];
	exit;*/

	//Selección de procedimiento a ejecutar en la BD
	if($proc==='del')
	{
		if($nodo['tipo']=='agrupador')
		{
			//$res = $Custom ->EliminarTipoUnidadConstructivaAgrupador($nodo['id']);
			$res = $Custom ->EliminarTipoUnidadConstructiva($nodo['id'],$nodo['id_p']);
			if(!$res)
			{
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] ;
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		}
		elseif($nodo['tipo']=='raiz')
		{
			//$res = $Custom ->EliminarTipoUnidadConstructivaBasurero($nodo['id']);
			$res = $Custom ->EliminarTipoUnidadConstructiva($nodo['id'],$nodo['id_p']);
			if(!$res)
			{
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] ;
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		}
		elseif($nodo['tipo']=='rama')
		{
			//$res = $Custom ->EliminarComposicion($nodo['id'],$nodo['id_p']);
			$res = $Custom ->EliminarTipoUnidadConstructiva($nodo['id'],$nodo['id_p']);
			if(!$res)
			{
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] ;
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		}
		elseif($nodo['tipo']=='item')
		{
			$res = $Custom -> EliminarComponente($nodo['id'],$nodo['id_p']);
			if(!$res)
			{
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] ;
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
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = "MENSAJE ERROR = Tipo desconocido.";
			$resp->origen = "ORIGEN = ";
			$resp->proc = "PROC = ";
			$resp->nivel = "NIVEL = 4";
			echo $resp->get_mensaje();
			exit;
		}

		//Devuelve el mensaje de éxito
		$mensaje_exito = $Custom->salida[1];
		$resp = new cls_manejo_mensajes(false);
		$resp->add_nodo("mensaje",$mensaje_exito);
		$resp->add_nodo("tiempo_resp", "200");
		echo $resp->get_mensaje();
		exit;
	}
	elseif($proc==='add')
	{
		if($nodo['tipo']=='agrupador')
		{
			$res = $Custom -> InsertarTipoUnidadConstructivaAgrupador($nodo['id'],$nodo['id_p'],$nodo['tipo'],$nodo['codigo'],$nodo['nombre'],$nodo['descripcion'],$nodo['observaciones'],$nodo['estado']);
			if(!$res)
			{
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] ;
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;

			}
			$tmp['id'] = $Custom->salida[2];
			echo json_encode($tmp);
			exit;
		}
		elseif($nodo['tipo']=='raiz')
		{
			$res = $Custom -> InsertarTipoUnidadConstructiva($nodo['id'],$nodo['id_p'],$nodo['tipo'],$nodo['codigo'],$nodo['nombre'],$nodo['descripcion'],$nodo['observaciones'],$nodo['estado']);
			if(!$res)
			{
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] ;
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;

			}
			$tmp['id'] = $Custom->salida[2];
			echo json_encode($tmp);
			exit;
		}
		elseif($nodo['tipo']=='rama')
		{
			$res = $Custom -> InsertarTucComposicion($nodo['id'],$nodo['id_p'],$nodo['tipo'],$nodo['codigo'],$nodo['nombre'],$nodo['descripcion'],$nodo['observaciones'],$nodo['cantidad'],$nodo['opcional'],$nodo['estado']);
			if(!$res)
			{
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] ;
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
			$tmp['id'] = $Custom->salida[2];
			$tmp['id_composicion_tuc'] = $Custom->salida[3];
			echo json_encode($tmp);
			exit;
		}

		elseif($nodo['tipo']=='item')
		{
			$res = $Custom -> InsertarComponente($nodo['id'],$nodo['id_p'],$nodo['tipo'],$nodo['descripcion'],$nodo['cantidad'],$nodo['opcional']);
			if(!$res)
			{
				$tmp['success'] = 'false';
				echo json_encode($tmp);
				exit;
			}
		}

		//Devuelve el Id del TUC creado
		$tmp['success'] = 'true';
		echo json_encode($tmp);
		exit;

	}
	elseif($proc==='upd')
	{
		//Verifica si es una inserción de TUC y modificación de Composición simultaneo
		if($nodo['id_padre_nuevo']!='')
		{
			$res = $Custom ->ModificarTucComposicion($nodo['id'],$nodo['id_p'],$nodo['tipo'],$nodo['codigo'],$nodo['nombre'],$nodo['descripcion'],$nodo['observaciones'],$nodo['cantidad'],$nodo['opcional'],$nodo['id_padre_nuevo']);
			if(!$res)
			{
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] ;
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}

			//Devuelve el Id del TUC creado
			$tmp['id'] = $Custom->salida[2];
			echo json_encode($tmp);
			exit;
		}
		else
		{
			if($nodo['tipo']=='agrupador')
			{
				$res = $Custom ->ModificarTipoUnidadConstructiva($nodo['id'],$nodo['codigo'],$nodo['nombre'],$nodo['tipo'],$nodo['descripcion'],$nodo['observaciones'],$nodo['estado']);
				if(!$res)
				{
					$resp = new cls_manejo_mensajes(true, "406");
					$resp->mensaje_error = $Custom->salida[1] ;
					$resp->origen = $Custom->salida[2];
					$resp->proc = $Custom->salida[3];
					$resp->nivel = $Custom->salida[4];
					$resp->query = $Custom->query;
					echo $resp->get_mensaje();
					exit;
				}
			}
			elseif($nodo['tipo']=='raiz')
			{
				$res = $Custom ->ModificarTipoUnidadConstructiva($nodo['id'],$nodo['codigo'],$nodo['nombre'],$nodo['tipo'],$nodo['descripcion'],$nodo['observaciones'],$nodo['estado']);
				if(!$res)
				{
					$resp = new cls_manejo_mensajes(true, "406");
					$resp->mensaje_error = $Custom->salida[1] ;
					$resp->origen = $Custom->salida[2];
					$resp->proc = $Custom->salida[3];
					$resp->nivel = $Custom->salida[4];
					$resp->query = $Custom->query;
					echo $resp->get_mensaje();
					exit;
				}
			}
			elseif($nodo['tipo']=='rama')
			{
				$res = $Custom ->ModificarComposicion($nodo['id'],$nodo['id_p'],$nodo['tipo'],$nodo['codigo'],$nodo['nombre'],$nodo['descripcion'],$nodo['observaciones'],$nodo['cantidad'],$nodo['opcional']);
				if(!$res)
				{
					$resp = new cls_manejo_mensajes(true, "406");
					$resp->mensaje_error = $Custom->salida[1] ;
					$resp->origen = $Custom->salida[2];
					$resp->proc = $Custom->salida[3];
					$resp->nivel = $Custom->salida[4];
					$resp->query = $Custom->query;
					echo $resp->get_mensaje();
					exit;
				}
			}
			elseif($nodo['tipo']=='item')
			{
				$res = $Custom ->ModificarComponente($nodo['id'],$nodo['id_p'],$nodo['tipo'],$nodo['observaciones'],$nodo['cantidad'],$nodo['opcional']);//Observaciones tiene el dato para el campo Descripcion
				if(!$res)
				{
					$resp = new cls_manejo_mensajes(true, "406");
					$resp->mensaje_error = $Custom->salida[1] ;
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
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = "MENSAJE ERROR = Tipo desconocido.";
				$resp->origen = "ORIGEN = ";
				$resp->proc = "PROC = ";
				$resp->nivel = "NIVEL = 4";
				echo $resp->get_mensaje();
				exit;
			}

			//Devuelve el Id del TUC creado
			$tmp['id'] = $Custom->salida[2];
			echo json_encode($tmp);
			exit;
		}

	}
	elseif($proc==='dd')
	{
		if($nodo['tipo']=='raiz')
		{
			$res = $Custom ->DragAndDropRaiz($nodo['id'],$nodo["id_p"],$nodo['id_pn']);
			if(!$res)
			{
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] ;
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
			$tmp['success'] = $Custom->salida[0]=='f' ? 'false':'true';
			echo json_encode($tmp);
			exit;
		}
		elseif($nodo['tipo']=='rama')
		{
			$res = $Custom ->DragAndDropRama($nodo['id'],$nodo['id_p'],$nodo['id_pn']);
			if(!$res)
			{
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] ;
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
			$tmp['success'] = $Custom->salida[0]=='f' ? 'false':'true';
			$tmp['id_composicion_tuc'] = $Custom->salida[2];
			echo json_encode($tmp);
			exit;
		}
		elseif($nodo['tipo']=='item')
		{
			$res = $Custom ->DragAndDropItem($nodo['id'],$nodo['id_p'],$nodo['id_pn']);
			if(!$res)
			{
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] ;
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;

			}
			$tmp['success'] = $Custom->salida[0]=='f' ? 'false':'true';
			echo json_encode($tmp);
			exit;
		}
		else
		{
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = "MENSAJE ERROR = Tipo desconocido.";
			$resp->origen = "ORIGEN = ";
			$resp->proc = "PROC = ";
			$resp->nivel = "NIVEL = 4";
			echo $resp->get_mensaje();
			exit;
		}

		//Respuesta de éxito
		$tmp['success'] = $Custom->salida[0]=='t' ? 'true':'false';
		echo json_encode($tmp);
		exit;
	}
	elseif($proc==='ter')//pa bloquear un TUC  ( estado = terminado)
	{
		bloquearTuc($nodo['id']);
		//Respuesta de éxito
		$tmp['success'] ='true';
		echo json_encode($tmp);
		exit;

	}
	elseif($proc==='des')  //para desbloque un TUC (estado = borrador)
	{
		desbloquearTuc($nodo['id']);
		//Respuesta de éxito
		$tmp['success'] ='true';
		echo json_encode($tmp);
		exit;

	}
	elseif($proc==='copy')  //para desbloque un TUC (estado = borrador)
	{
		$res = $Custom ->CopiarTipoUnidadConstructiva($nodo['id'],$nodo['id_p'],$nodo['id_pn'],$nodo['cantidad'],$nodo['opcional']);
		if(!$res)
		{
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = $Custom->salida[1] ;
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje();
			exit;
			$tmp['success'] = $Custom->salida[0]=='f' ? 'false':'true';
			echo json_encode($tmp);
			exit;
		}
		$tmp['success'] ='true';
		echo json_encode($tmp);
		exit;

	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "401");
		$resp->mensaje_error = "MENSAJE ERROR = Proceso no identificado";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = "NIVEL = 1";
		echo $resp->get_mensaje();
		exit;
	}

}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp->get_mensaje();
	exit;
}

function bloquearTuc($id){

	$Custom = new cls_CustomDBAlmacenes();

	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_tipo_unidad_constructiva asc';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	$criterio_filtro='0=0';

	$res = $Custom->ListarTipoUnidadConstructivaRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id);
	if($res)
	{
		foreach ($Custom->salida as $f)
		{
			if($f["estado"]=='Borrador'){
				bloquearTuc($f["id_tipo_unidad_constructiva"]);
			}
		}

		$res=$Custom->FinalizarTUC($id);
		if(!$res)
		{
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = $Custom->salida[1] ;
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje();
			exit;
		}
	}
}


function desbloquearTuc($id){

	$Custom = new cls_CustomDBAlmacenes();

	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_tipo_unidad_constructiva asc';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	$criterio_filtro='0=0';


	$res=$Custom ->  DesbloquearTUC($id);

	if($res){

		//si es posible desbloquear !! se ejecuta el desbloqueo luego se verifican los hijos
		//$res=$Custom -> DesbloquearTUC($id);
		$res = $Custom->ListarTipoUnidadConstructivaRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id);
		if($res){
			foreach ($Custom->salida as $f){
				//if($f["estado"]=='Terminado'){
				desbloquearTuc($f["id_tipo_unidad_constructiva"]);
				//}
			}
		}

	}
	else{

		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = $Custom->salida[1] ;
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;
		echo $resp->get_mensaje();
		exit;

	}


}


?>