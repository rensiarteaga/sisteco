<?php

/**
* Nombre de archivo:	    subir_archivo
* Propósito:				Permite subir archivos a la BD
* Fecha de Creación:		2011-02-08
* Autor:					Marcos A. Flores Valda
*/

session_start();
include_once("../LibModeloFlujo.php");
//require("../../../lib/lib_modelo/cls_conexion.php");

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = "ActionSubirArchivo.php";

$var_grilla = 0;
$var_form = 0;

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{	
	//Verifica si los datos vienen por POST o GET
	if (sizeof($_GET) > 0)
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
		
		if($_POST["subearchivo"] == 'si')
			$cont =  1;
		else
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
	
	$Custom->decodificar = $decodificar;	

	for($j = 0; $j < $cont; $j++)
	{
		if($_POST["subearchivo"] == 'si')
		{
			if ($get)
			{
				$id_anexo = $_GET["id_anexo"];
				$nombre = $_GET["nombre"];
				$foto = $_GET["foto"];
			}
			else
			{
				$id_anexo = $_POST["id_anexo"];
				$nombre = $_POST["nombre"];
				$foto = $_POST["foto"];
			}	
			
			$var_grilla = 1;
		}
		
		else 
		{
			if ($get)
			{
				$id_anexo = $_GET["id_anexo_$j"];
				$nombre = $_GET["nombre_$j"];
				$foto = $_GET["foto_$j"];
			}
			else
			{
				$id_anexo = $_POST["id_anexo_$j"];
				$nombre = $_POST["nombre_$j"];
				$foto = $_POST["foto_$j"];
			}		
			
			$var_form = 1;	
		}		
					
		if($_FILES['foto']['type'] == 'image/jpeg' or 'image/gif' or 'image/png')
		{
			$nombre = $_FILES['foto']['name'];
													
			$res = $Custom ->InsertarArchivoBD($id_anexo,$nombre);
			
			$data  = file_get_contents($_FILES['foto']['tmp_name']);				
			$imagen = pg_escape_bytea($data);						
			$conn  = pg_connect("host=".$_SESSION["HOST"]." dbname=".trim($_SESSION["BASE_DATOS"])." user=".(addslashes(htmlentities($_SESSION["BASE_DATOS"],ENT_QUOTES))."_".addslashes(htmlentities($_SESSION["ss_usuario"],ENT_QUOTES)))." password=".trim(addslashes(htmlentities($_SESSION["ss_contrasenia"],ENT_QUOTES)))." port=5432");
			pg_query($conn, "UPDATE flujo.tfl_anexo SET foto = '{$imagen}' WHERE id_anexo = 86");
			pg_close($conn);
													
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
	}	
								
	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) 
		$mensaje_exito = "Se guardaron todos los datos.";
	
	else 
		$mensaje_exito = $Custom->salida[1];	

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_anexo";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = " 0=0 ";
	
	if(isset($id_anexo))
		$criterio_filtro.=" and ADJUNT.id_anexo=$id_anexo";
		
	$res = $Custom -> ContarAnexo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
	
	if($res) 
		$total_registros = $Custom->salida;

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