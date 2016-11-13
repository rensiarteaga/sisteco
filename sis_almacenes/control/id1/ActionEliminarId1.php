<?php
/**
**********************************************************
Nombre de archivo:	    ActionEliminarId1.php
Propósito:				Permite eliminar registros de la tabla tal_id1
Tabla:					tal_id1
Parámetros:				$hidden_id_id1
Valores de Retorno:    	Número de registros
Fecha de Creación:		28-09-2007
Versión:				1.0.0
Autor:					Fernando Prudencio Cardona
**********************************************************
*/
session_start();

include_once("../LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = 'ActionEliminarId1.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}

if($_SESSION['autentificado']=="SI")
{
	if (sizeof($_GET) >0)
	{
		$get=true;
		$cont=1;
	}
	elseif(sizeof($_POST) >0)
	{
		$get=false;
		$cont =  $_POST['cantidad_ids'];
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para Eliminar.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit;
	}

	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$hidden_id_id1 = $_GET["hidden_id_id1_$j"];
		}
		else
		{
			$hidden_id_id1 = $_POST["hidden_id_id1_$j"];
		}

		if ($hidden_id_id1 == "undefined" || $hidden_id_id1 =="")
		{
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = "MENSAJE ERROR = No existe Id1.";
			$resp->origen = "ORIGEN = $nombre_archivo";
			$resp->proc = "PROC = $nombre_archivo";
			$resp->nivel = "NIVEL = 4";
			echo $resp->get_mensaje();
			exit;
		}
		else
		{	
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarId1("delete",$hidden_id_id1,$txt_codigo,$txt_nombre,$txt_descripcion,$txt_nivel_convertido,$txt_convertido,$txt_observaciones,$txt_estado_registro,$txt_fecha_reg,$hidden_id_subgrupo,$hidden_id_grupo,$hidden_id_supergrupo);
			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}
			
			//Eliminación
			$res = $Custom-> EliminarId1($hidden_id_id1);
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
	}//end for

	//Guarda el mensaje de éxito de la operación realizada
	if($cont>1) $mensaje_exito = 'Se eliminaron los registros especificados.';
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'id_subgrupo';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro = '0=0';

	$res = $Custom->ContarId1($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo('TotalCount', $total_registros);
	$resp->add_nodo('mensaje',$mensaje_exito);
	$resp->add_nodo('tiempo_resp', '200');
	echo $resp->get_mensaje();
	exit;
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



