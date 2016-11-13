<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarMetaArb.php
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
include_once("../LibModeloSeguridad.php");

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = "ActionGuardarMetaArb.php";
if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{

	$decodificado = stripslashes($_REQUEST['datos']);
	$proceso=stripslashes($_REQUEST['proc']);

	$nodo = json_decode($decodificado,true);

	//Selección de procedimiento a ejecutar en la BD

   
	//es metaproceso ==> vista
	if($proc==='add' && $nodo['tipo']!='item')
	{	 
		$res = $Custom -> InsertarMetaprocesoArb($nodo['id'],$nodo['txt_id_subsistema'],$nodo['id_p'],$nodo['txt_nivel'],$nodo['txt_nombre'],$nodo['txt_codigo_procedimiento'],$nodo['txt_nombre_archivo'],$nodo['txt_ruta_archivo'],$nodo['txt_fecha_registro'],$nodo['txt_hora_registro'],$nodo['txt_fecha_ultima_modificacion'],$nodo['txt_hora_ultima_modificacion'],$nodo['txt_descripcion'],$nodo['txt_visible'],$nodo['txt_habilitar_log'],$nodo['txt_orden_logico'],$nodo['txt_icono'],$nodo['txt_nombre_tabla'],$nodo['txt_prefijo'],$nodo['txt_codigo_base'],$nodo['txt_tipo_vista'],$nodo['txt_con_ep'],$nodo['txt_con_interfaz'],$nodo['txt_num_datos_hijo']);
		
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
	elseif($proc==='add' && $nodo['tipo']=='item')
	{ 
		$res = $Custom -> InsertarMetaprocesoDBArb($nodo['id_p'],$nodo['codigo_procedimiento']);
		
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
		$tmp['success']='true'; 
		$tmp['id'] = $Custom->salida[2];
		echo json_encode($tmp);
		exit;

	}
	elseif($proc==='upd')
	{
		$res = $Custom -> ModificarMetaprocesoArb($nodo['id'],$nodo['txt_id_subsistema'],$nodo['id_p'],$nodo['txt_nivel'],$nodo['txt_nombre'],$nodo['txt_codigo_procedimiento'],$nodo['txt_nombre_archivo'],$nodo['txt_ruta_archivo'],$nodo['txt_fecha_registro'],$nodo['txt_hora_registro'],$nodo['txt_fecha_ultima_modificacion'],$nodo['txt_hora_ultima_modificacion'],$nodo['txt_descripcion'],$nodo['txt_visible'],$nodo['txt_habilitar_log'],$nodo['txt_orden_logico'],$nodo['txt_icono'],$nodo['txt_nombre_tabla'],$nodo['txt_prefijo'],$nodo['txt_codigo_base'],$nodo['txt_tipo_vista'],$nodo['txt_con_ep'],$nodo['txt_con_interfaz'],$nodo['txt_num_datos_hijo']);
		
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
	elseif($proc==='del' && $nodo['tipo']!='item')
	{
		$res = $Custom -> EliminarMetaproceso($nodo['id']);
		
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
		//Devuelve el mensaje de éxito
		$mensaje_exito = $Custom->salida[1];
		$resp = new cls_manejo_mensajes(false);
		$resp->add_nodo("mensaje",$mensaje_exito);
		$resp->add_nodo("tiempo_resp", "200");
		echo $resp->get_mensaje();
		exit;
	}
	elseif($proc==='del' && $nodo['tipo']=='item')
	{
		$res = $Custom -> EliminarMetaprocesoDB($nodo['id']);
		
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
		//Devuelve el mensaje de éxito
		$mensaje_exito = $Custom->salida[1];
		$resp = new cls_manejo_mensajes(false);
		$resp->add_nodo("mensaje",$mensaje_exito);
		$resp->add_nodo("tiempo_resp", "200");
		echo $resp->get_mensaje();
		exit;
	}
	elseif($proc==='dd')
	{
		/*if($nodo['tipo']=='raiz')
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
				$tmp['success'] = $Custom->salida[0]=='f' ? 'false':'true';
				echo json_encode($tmp);
				exit;
			}&
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
				$tmp['success'] = $Custom->salida[0]=='f' ? 'false':'true';
				echo json_encode($tmp);
				exit;
			}
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
				$tmp['success'] = $Custom->salida[0]=='f' ? 'false':'true';
				echo json_encode($tmp);
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
*/
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
		$resp = new cls_manejo_mensajes(true, "406");
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

?>