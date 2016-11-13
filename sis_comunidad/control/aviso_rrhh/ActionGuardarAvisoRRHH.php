<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarAvisoRRHH.php
Propósito:				Permite insertar y modificar datos en la tabla comunidad.com_avisos_rrhh
Tabla:					com_avisos_rrhh
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
$nombre_archivo = "ActionGuardarAvisoRRHH.php";

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
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$id_aviso=$_GET["id_aviso_rrhh_$j"];
			$nombre_aviso=$_GET["nombre_aviso_rrhh_$j"];
			$descripcion_aviso=$_GET["descripcion_aviso_rrhh_$j"];
			//PARA SUBIR ARCHIVO
			$txt_archivo = $_FILES["rrhh_ruta_archivo"]["tmp_name"];
			$ruta_archivo= ($_FILES["rrhh_ruta_archivo"]["name"]);
			$extension_archivo = $_FILES["rrhh_ruta_archivo"]["type"];
			$directorio_archivo = '../../../../comunidadEnde/vista/archivos/avisoRecursosHumanos/';
			$extension_archivo=substr(strrchr($ruta_archivo, '.'), 1);
			
		
		}
		else
		{
		
			$id_aviso=$_POST["id_aviso_rrhh_$j"];
			$nombre_aviso=$_POST["nombre_aviso_rrhh_$j"];
			$descripcion_aviso=$_POST["descripcion_aviso_rrhh_$j"];
			//PARA SUBIR ARCHIVO
			$txt_archivo = $_FILES["rrhh_ruta_archivo"]["tmp_name"];
			$ruta_archivo= ($_FILES["rrhh_ruta_archivo"]["name"]);
			$extension_archivo = $_FILES["rrhh_ruta_archivo"]["type"];
			$directorio_archivo = '../../../../comunidadEnde/vista/archivos/avisoRecursosHumanos/';
			$extension_archivo=substr(strrchr($ruta_archivo, '.'), 1);
			

		}
	  /*  echo $txt_archivo;
	    exit;*/
               
		if ($id_aviso == "undefined" || $id_aviso== "")
		{
			include("../ActionSubirArchivo.php");
			////////////////////Inserción/////////////////////
					//Validación satisfactoria, se ejecuta la inserción en la tabla com_publicaciones 
					$res = $Custom -> InsertarAvisoRRHH($id_aviso,$nombre_aviso,$descripcion_aviso,$ruta_archivo);
			
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
			
		
			if($ruta_Archivo!=''){include("../ActionSubirArchivo.php");}
			$res = $Custom->ModificarAvisoRRHH($id_aviso,$nombre_aviso,$descripcion_aviso,$ruta_archivo);

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

	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "RRHH.id_aviso_rrhh ASC";
	if($sortdir == "") $sortdir = " ";
	if($criterio_filtro == "") $criterio_filtro = "0=0 and RRHH.rrhh_estado_registro=''activo''";

	$res = $Custom->ContarAvisoRRHH($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
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