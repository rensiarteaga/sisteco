<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarPublicacion.php
Propósito:				Permite insertar y modificar datos en la tabla com_publicaciones
Tabla:					com_publicaciones
Parámetros:				dependiendo
						

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2013-05-2013
Versión:				1.0.0
Autor:					Morgan Huascar Checa Lopez
**********************************************************
*/
session_start();
include_once('../LibModeloAdministracionComunidad.php');

$Custom = new cls_CustomDBComunidad();
$nombre_archivo = "ActionGuardarPublicacion.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
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
	
	//Envia al Custom la bandera que indica si se decodificará o no
	$Custom->decodificar = $decodificar;

	//Realiza el bucle por todos los ids mandados
	//for($j = 0;$j < $cont; $j++)
	//{
		if ($get)
		{
			$id_publicacion=$_GET["id_publicacion"];
			$nombre_publicacion=$_GET["nombre_publicacion"];
			$descripcion_publicacion=$_GET["descripcion_publicacion"];
			//PARA SUBIR IMAGEN
			$txt_imagen = $_FILES["pub_ruta_imagen"]["tmp_name"];
			$ruta_imagen=$_FILES["pub_ruta_imagen"]["name"];
			$extension_imagen = $_FILES["pub_ruta_imagen"]["type"];
			$directorio_imagen = "../../../../comunidadEnde/imagenes/imagenesAnuncios/";
			//PARA SUBIR ARCHIVO
			$txt_archivo = $_FILES["pub_ruta_archivo"]["tmp_name"];
			$ruta_archivo=$_FILES["pub_ruta_archivo"]["name"];
			$extension_archivo = $_FILES["pub_ruta_archivo"]["type"];
			$directorio_archivo = "../../../../comunidadEnde/vista/archivos/publicaciones/";
			$extension_imagen=substr(strrchr($ruta_imagen, '.'), 1);
			$extension_archivo=substr(strrchr($ruta_archivo, '.'), 1);
			
		
		}
		else
		{

			$id_publicacion=$_POST["id_publicacion"];
			$nombre_publicacion=$_POST["nombre_publicacion"];
			$descripcion_publicacion=$_POST["descripcion_publicacion"];
			//PARA SUBIR IMAGEN
			$txt_imagen = $_FILES["pub_ruta_imagen"]["tmp_name"];
			$ruta_imagen=$_FILES["pub_ruta_imagen"]["name"];
			$extension_imagen = $_FILES["pub_ruta_imagen"]["type"];
			$directorio_imagen = "../../../../comunidadEnde/imagenes/imagenesAnuncios/";
			//PARA SUBIR ARCHIVO
			$txt_archivo = $_FILES["pub_ruta_archivo"]["tmp_name"];
			$ruta_archivo= ($_FILES["pub_ruta_archivo"]["name"]);
			$extension_archivo = $_FILES["pub_ruta_archivo"]["type"];
			$directorio_archivo = '../../../../comunidadEnde/vista/archivos/publicaciones/';
			$extension_imagen=substr(strrchr($ruta_imagen, '.'), 1);
			$extension_archivo=substr(strrchr($ruta_archivo, '.'), 1);

		}
	    
               
		if ($id_publicacion == "undefined" || $id_publicacion== "")
		{
			
			
			include("../ActionSubirImagen.php");
			include("../ActionSubirArchivo.php");
			////////////////////Inserción/////////////////////
					//Validación satisfactoria, se ejecuta la inserción en la tabla com_publicaciones 
					$res = $Custom -> InsertarPublicacion($id_publicacion,$nombre_publicacion,$descripcion_publicacion, $ruta_imagen, $ruta_archivo,$txt_archivo,$directorio_archivo);
					
						if(!$res){
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
			if($ruta_imagen!=''){ include("../ActionSubirImagen.php");}
			
			if($ruta_archivo != ''){ include("../ActionSubirArchivo.php");}
			
				$res = $Custom->ModificarPublicacion($id_publicacion,$nombre_publicacion,$descripcion_publicacion, $ruta_imagen, $ruta_archivo);
			
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

	//}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "PUB.id_publicacion";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0 and PUB.pub_estado_registro=''activo''";

	$res = $Custom->ContarPublicacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
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