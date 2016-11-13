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
include_once("../LibModeloAdministracionComunidad.php");

$Custom = new cls_CustomDBComunidad();
$nombre_archivo = "ActionGuardarNormativas.php";

$carpeta_destino = '../../control/persona/archivo/';

/*
 * TAMAÑO MAXIMO DEL ARCHIVO
 */

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
			
	//$vista_per = $_GET['vista_per'];
	//$id_persona = $_GET['id_persona']; 
	echo 'sale algo'.$_FILES['ruta_archivo']['tmp_name'];
	exit;
	$txt_foto_persona = $_FILES['ruta_archivo']['tmp_name'];
	$nombre_foto = $_FILES['foto']['name'];
	$extension = explode("/",$_FILES['foto']['type']);
	
	/*$vista_per = 'true'; //NO BORRAR SIRVE PARA ACTUALIZAR LA TABLA PERSONA CON LAS FOTOS DE LOS FUNCIONARIOS
	$res = $Custom->SeleccionarIdsPersona($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_persona);
	$tamanio = sizeof($Custom->salida);
	''
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
	
	if($_FILES["foto"]["size"] < 1048576 && ($extension[1] == 'jpg' || $extension[1] == 'jpeg' || $extension[1] == 'gif')) 		//menor a 1 Mb y que sea imagen
	{
		$res = $Custom->SubirFoto($id_persona, $txt_foto_persona, $nombre_foto, $numero, $extension[1], $_SESSION["ss_id_empleado"], $vista_per);
		//echo var_dump($Custom); exit;
		
		if($res)
		{
			unlink('../../control/persona/archivo/'.$Custom->salida[2].'.'.$Custom->salida[3]);		
		}
		else 
		{
			if($_FILES["foto"]["error"] == 3)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error =  'El archivo fue subido parcialmente.';
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit; 
			}
			
			if($_FILES["foto"]["error"] == 4)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = 'El archivo no fue cargado al servidor.';  
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit; 
			}
										
			if($_FILES["foto"]["error"] == 6)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = 'La carpeta destino no existe.';  
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit; 
			}
			
			if($_FILES["foto"]["error"] == 7)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = 'No se pudo guardar el archivo en el servidor.';  
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;   
			}
		}
	}

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
<?php

/**
**********************************************************
Nombre de archivo:	    ActionGuardarNormativas.php
Propósito:				Permite insertar y modificar datos en la tabla com_archivos_normativas
Tabla:					com_archivos_normativas
Parámetros:				$id_servicio
						$nombre
						$descripcion
						$fecha_reg
						$id_tipo_servicio

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2013-05-16 14:58:49
Versión:				1.0.0
Autor:					Morgan Huascar Checa Lopez
**********************************************************
*/
/*fin
session_start();
include_once("../LibModeloAdministracionComunidad.php");

$Custom = new cls_CustomDBComunidad();
$nombre_archivo = "ActionGuardarNormativas.php";

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
	
	$txt_foto_persona = $_FILES['foto']['tmp_name'];
	$nombre_foto = $_FILES['foto']['name'];
	$extension = explode("/",$_FILES['foto']['type']);
	
	$ruta_archivo = $_HTTP_POST_FILES['ruta_archivo']['name'];
	$arch = $HTTP_POST_FILES['ruta_archivo']['tmp_name'];
	
	echo $_HTTP_POST_FILES['ruta_archivo']['name'];
	exit;
	
	*///this is fin
	//Verifica si los datos vienen por POST o GET
	/*if (sizeof($_GET) > 0)
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
	elseif(sizeof($_POST) > 0)
	{
		$get = false;
		$cont =  $_POST["cantidad_ids"];
		
		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar.";
		$resp->origen = "ORIGEN = ";
		$resp->proc = "PROC = ";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit;
	}
	*/
	//Envia al Custom la bandera que indica si se decodificará o no
	/*$Custom->decodificar = $decodificar;
	
	include_once("../../../lib/lib_general/cls_archivos.php");
	
	$f = new cls_archivos();
	//Realiza el bucle por todos los ids mandados
	$ruta_archivo = $_HTTP_POST_FILES['ruta_archivo']['name'];
	$arch = $HTTP_POST_FILES['ruta_archivo']['tmp_name'];
	
	echo $_HTTP_POST_FILES['ruta_archivo']['name'];
	exit;
	$direccion = $f->carga_archivo($HTTP_POST_FILES['ruta_archivo'],'../../../../comunidadEnde/vista/archivos/normativaInterna/' );
	
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$id_archivos_normativas= $_GET["id_archivos_normativas_$j"];
			$nombre_archivo= $_GET["nombre_archivo_$j"];
			$descripcion_archivo= $_GET["descripcion_archivo_$j"];
			//$id_detalle_normativa= $_SESSION['id_detalle_normativa'];//$_GET["id_detalle_normativa_$j"];
			$id_detalle_normativa=$m_id_detalle_normativa;
			//$id_detalle_normativa= $_GET["id_detalle_normativa_$j"];
			//PARA SUBIR ARCHIVO
			$txt_archivo = $_FILES["ruta_archivo"]["tmp_name"];
			$ruta_archivo= ($_FILES["ruta_archivo"]["name"]);
			$extension_archivo = $_FILES["ruta_archivo"]["type"];
			$directorio_archivo = '../../../../comunidadEnde/vista/archivos/normativaInterna/';
			$extension_archivo=substr(strrchr($ruta_archivo, '.'), 1);
			
		}
		else
		{
			$id_archivos_normativas= $_POST["id_archivos_normativas_$j"];
			$nombre_archivo= $_POST["nombre_archivo_$j"];
			$descripcion_archivo= $_POST["descripcion_archivo_$j"];
			//$id_detalle_normativa= $_SESSION['id_detalle_normativa'];//$_POST["id_detalle_normativa_$j"];
			//$id_detalle_normativa= $_POST["id_detalle_normativa_$j"];
			$id_detalle_normativa=$m_id_detalle_normativa;
			//$id_detalle_normativa= $_POST["id_detalle_normativa_$j"];
			//PARA SUBIR ARCHIVO ss
			//txt_archivo_0
			/*echo ''.$_POST["txt_archivo_$j"];;
			exit;*/
			//$txt_archivo = $_FILES["ruta_archivo"]["tmp_name"];
			
			
			//$ruta_archivo= ($_FILES["ruta_archivo"]["name"]);
	/*		$txt_archivo =$_POST["txt_archivo_$j"];
			$ruta_archivo=$_POST["txt_archivo_$j"];
			
			//$extension_archivo = $_FILES["ruta_archivo"]["type"];
			$directorio_archivo = '../../../../comunidadEnde/vista/archivos/normativaInterna/';
			$extension_archivo=substr(strrchr($ruta_archivo, '.'), 1);
			
*/
		
/*  hasta el fin  

	if ($id_archivos_normativas == "undefined" || $id_archivos_normativas == "")
		{
			////////////////////Inserción/////////////////////
			include("../ActionSubirArchivo.php");
			//Validación satisfactoria, se ejecuta la inserción en la tabla com_archivos_normativas
			$res = $Custom -> InsertarArchivoNormativa($id_archivos_normativas, $nombre_archivo, $descripcion_archivo, $id_detalle_normativa,$ruta_archivo );
			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] . " (iteración $cont)";
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		}
		else
		{	///////////////////////Modificación////////////////////
			if($ruta_archivo!=''){include("../ActionSubirArchivo.php");}
			$res = $Custom->ModificarArchivoNormativa($id_archivos_normativas, $nombre_archivo, $descripcion_archivo, $id_detalle_normativa,$ruta_archivo );

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
		}

	//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "AN.id_archivos_normativas";
	if($sortdir == "") $sortdir = "DESC";
	
	if($criterio_filtro == "") $criterio_filtro = "AN.estado_registro=''activo''";

	$res = $Custom->ContarArchivoNormativa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
	if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", $total_registros);
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
*///this is fin