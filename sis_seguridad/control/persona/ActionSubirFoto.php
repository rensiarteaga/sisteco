<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCorrespondencia.php
Propósito:				Permite insertar y modificar datos en la tabla tfl_correspondencia
Tabla:					tfl_tfl_correspondencia
Parámetros:				$id_correspondencia
						$id_depto
						$id_documento
						$id_empleado_origen
						$id_uo_origen
						$id_institucion
						$id_persona
						$referencia
						$fecha_origen
						$hora_origen
						$fecha_destino
						$hora_destino
						$accion

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2011-02-11 10:52:59
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloSeguridad.php");

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = "ActionGuardarPersona.php";

$carpeta_destino = '../../control/persona/archivo/';

/*
 * TAMAÑO MAXIMO DEL ARCHIVO
 */

$tMax = 105857600;
if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{
	//Parámetros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = '0=0';
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
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'id_persona');
	$sortcol = $crit_sort->get_criterio_sort();	
	/*echo 'sssss'.$_FILES['foto']['tmp_name'];
	exit;*/
	$vista_per = $_GET['vista_per'];
	$id_persona = $_GET['id_persona']; 
	$txt_foto_persona = $_FILES['foto']['tmp_name'];
	$nombre_foto = $_FILES['foto']['name'];
	$extension = explode("/",$_FILES['foto']['type']);
	
	############ MFLORES - PARA ACTUALIZAR TODA LA TABLA
	
	/*$vista_per = 'true';
	$res = $Custom->SeleccionarIdsPersona($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_persona);	
	$tamanio = sizeof($Custom->salida);
	
	$f = $Custom->salida;
	
	for($i = 0; $i < $tamanio; $i++)
	{
		$res = $Custom->SeleccionarFoto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$f[$i]['id_persona']);			
		$ruta_foto = "funcionario/".$Custom->salida[0]['ruta_archivo'];
		
		$nombre_foto = $Custom->salida[0]['ruta_archivo'];
		$extension = explode(".",$nombre_foto);
		$tamanio_ext = sizeof($extension);
		
		$res = $Custom->SubirFoto($f[$i]['id_persona'], $ruta_foto, $nombre_foto, $numero, $extension[($tamanio_ext) - 1], $_SESSION["ss_id_empleado"], $vista_per);
	}
	
	exit;*/
	
	############ MFLORES - PARA ACTUALIZAR TODA LA TABLA
		
	$res = $Custom->SubirFoto($id_persona, $txt_foto_persona, $nombre_foto, $numero, $extension[1], $_SESSION["ss_id_empleado"], $vista_per);
		
	if($res)
		unlink('../../control/persona/archivo/'.$Custom->salida[2].'.'.$Custom->salida[3]);

	if(!$res)
	{		
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = $Custom->salida[1];
		$resp->origen = $Custom->salida[2];
		$resp->proc = $Custom->salida[3];
		$resp->nivel = $Custom->salida[4];
		$resp->query = $Custom->query;
		echo $resp->get_mensaje();
		exit;
	}

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) 
		$mensaje_exito = "Se guardaron todos los datos.";
	else 
		$mensaje_exito = $Custom->salida[1];
	
	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", 1);
	$resp->add_nodo("mensaje", $mensaje_exito);
	$resp->add_nodo("tiempo_resp", "200");
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