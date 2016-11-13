<?php
/*
**********************************************************
Nombre de archivo:	    ActionGuardarActivoFijoGrupoProceso.php
Propósito:				Permite insertar y modificarActivoFijoProceso
Tabla:					taf_activo_fijo_proceso
Parámetros:				$hidden_id_activo_fijo_proceso	--> id del ActivoFijoProceso
						$descripcion
						

Valores de Retorno:    	Número de registros
Fecha de Creación:		12-07-2010
Versión:				
Autor:					Mercedes Zambrana Meneses
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");
$CustomActivos = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionGuardarActivoFijoGrupoProceso.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	//Verifica si los datos vienen por post o get
	if (sizeof($_GET) >0)
	{
		$get=true;
		$cont=1;
		
		//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
		//valores permitidos de $cod -> "si", "no"
		switch ($cod)
		{
			case "si":
				$decodificar = true;
				break;
			case "no":
				$decodificar = false;
				break;
			default:
				$decodificar = true;
				break;
		}
	}
	elseif(sizeof($_POST) >0)
	{
		$get=false;
		$cont =  $_POST['cantidad_ids'];
		
		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar";
		$resp->origen = "ORIGEN= $nombre_archivo";
		$resp->proc = "PROC =$nombre_archivo";
		$resp->nivel = 'NIVEL = 4';
		echo $resp->get_mensaje();
		exit;
	}
	
	//Envia al Custom la bandera que indica si se decodificará o no
	$CustomActivos->decodificar = $decodificar;

	//Realiza el bucle por todos los ids mandados
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$id_activo_fijo_proceso=$_GET["id_activo_fijo_proceso_$j"];
			$id_activo_fijo=$_GET["id_activo_fijo_$j"];
			$monto_revalorizacion=$_GET["monto_revalorizacion_$j"];
			$vida_util_revalorizacion=$_GET["vida_util_revalorizacion_$j"];
			$fecha_ini_dep=$_GET["fecha_ini_dep_$j"];
			$id_grupo_proceso=$_GET["id_grupo_proceso_$j"];
			$observaciones=$_GET["observaciones_$j"];
			$asignar=$_GET["asignar_$j"];
			
			
		}
		else
		{
			$id_activo_fijo_proceso=$_POST["id_activo_fijo_proceso_$j"];
			$id_activo_fijo=$_POST["id_activo_fijo_$j"];
			$monto_revalorizacion=$_POST["monto_revalorizacion_$j"];
			$vida_util_revalorizacion=$_POST["vida_util_revalorizacion_$j"];
			$fecha_ini_dep=$_POST["fecha_ini_dep_$j"];
			$id_grupo_proceso=$_POST["id_grupo_proceso_$j"];
			$observaciones=$_POST["observaciones_$j"];
			$asignar=$_POST["asignar_$j"];
			
		}


		if ($id_activo_fijo_proceso == "undefined" || $id_activo_fijo_proceso=="")
		{
			
			
			$res = $CustomActivos ->InsertarActivoFijoGrupoProceso($id_grupo_proceso,$id_activo_fijo,$monto_revalorizacion,$vida_util_revalorizacion,$fecha_ini_dep,$observaciones);			
			if(!$res)  
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $CustomActivos->salida[1];
				$resp->origen = $CustomActivos->salida[2];
				$resp->proc = $CustomActivos->salida[3];
				$resp->nivel = $CustomActivos->salida[4];
				$resp->query = $CustomActivos->query;
				echo $resp->get_mensaje();
				exit;
			}
			
		}
		else
		{	
							
			$res = $CustomActivos->ModificarActivoFijoGrupoProceso($id_activo_fijo_proceso,$id_grupo_proceso,$id_activo_fijo,$monto_revalorizacion,$vida_util_revalorizacion,$fecha_ini_dep,$observaciones,$asignar);
			
			if(!$res)
			{
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $CustomActivos->salida[1];
				$resp->origen = $CustomActivos->salida[2];
				$resp->proc = $CustomActivos->salida[3];
				$resp->nivel = $CustomActivos->salida[4];
				$resp->query = $CustomActivos->query;
				echo $resp->get_mensaje();
				exit;
			}
		}

	}//END FOR

	/***************no entra aqui cuando es $_GET*************/
	///Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = 'Se guardaron todos los datos.';
	else $mensaje_exito = $CustomActivos->salida[1];
	
	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'nombres';
	if($sortdir == "") $sortdir = 'asc';
	//if($criterio_filtro == "") $criterio_filtro = '0=0';
	
	if($criterio_filtro=="") $criterio_filtro=" afp.id_grupo_proceso = $id_grupo_proceso";

	$res = $CustomActivos->ContarActivoFijoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	if($res) $total_registros = $CustomActivos->salida;

	
	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo('TotalCount', $total_registros);
	$resp->add_nodo('mensaje', $mensaje_exito);
	$resp->add_nodo('tiempo_resp', '200');
	echo $resp->get_mensaje();
	exit;
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 1';
	echo $resp->get_mensaje();
	exit;
}
?>