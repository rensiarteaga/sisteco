<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarAutorizacionPresupuesto.php
Propósito:				Permite insertar y modificar datos en la tabla tpr_usuario_autorizado
Tabla:					tpr_tpr_usuario_autorizado
Parámetros:				$id_usuario_autorizado
						$id_usuario
						$id_unidad_organizacional
						$nombre_unidad
						$apellido_paterno
						$apellido_materno
						$nombre

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-08-18 17:10:52
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionGuardarAutorizacionPresupuesto.php";

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
			$id_usuario_autorizado= $_GET["id_usuario_autorizado_$j"];
			$id_usuario= $_GET["id_usuario_$j"];
			$id_unidad_organizacional= $_GET["id_unidad_organizacional_$j"];
			/*$nombre_unidad= $_GET["nombre_unidad_$j"];
			$apellido_paterno= $_GET["apellido_paterno_$j"];
			$apellido_materno= $_GET["apellido_materno_$j"];
			$nombre= $_GET["nombre_$j"];*/
			$sw_responsable= $_GET["sw_responsable_$j"];
			$estado= $_GET["estado_$j"];
		}
		else
		{
			$id_usuario_autorizado=$_POST["id_usuario_autorizado_$j"];
			$id_usuario=$_POST["id_usuario_$j"];
			$id_unidad_organizacional=$_POST["id_unidad_organizacional_$j"];
			/*$nombre_unidad=$_POST["nombre_unidad_$j"];
			$apellido_paterno=$_POST["apellido_paterno_$j"];
			$apellido_materno=$_POST["apellido_materno_$j"];
			$nombre=$_POST["nombre_$j"];*/
			$sw_responsable=$_POST["sw_responsable_$j"];
			$estado=$_POST["estado_$j"];
		}

		if ($id_usuario_autorizado == "undefined" || $id_usuario_autorizado == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarAutorizacionPresupuesto("insert",$id_usuario_autorizado,$id_usuario,$id_unidad_organizacional,$nombre_unidad,$apellido_paterno,$apellido_materno,$nombre);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_usuario_autorizado
			$res = $Custom -> InsertarAutorizacionPresupuesto($id_usuario_autorizado,$id_usuario,$id_unidad_organizacional,/*$nombre_unidad,$apellido_paterno,$apellido_materno,$nombre,*/$sw_responsable,$estado);

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
			
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarAutorizacionPresupuesto("update",$id_usuario_autorizado,$id_usuario,$id_unidad_organizacional,$nombre_unidad,$apellido_paterno,$apellido_materno,$nombre);

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

			$res = $Custom->ModificarAutorizacionPresupuesto($id_usuario_autorizado,$id_usuario,$id_unidad_organizacional,/*$nombre_unidad,$apellido_paterno,$apellido_materno,$nombre,*/$sw_responsable,$estado);

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
	if($sortcol == "") $sortcol = "id_usuario_autorizado";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarAutorizacionPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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