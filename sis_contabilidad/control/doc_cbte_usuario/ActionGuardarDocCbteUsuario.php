<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarDocCbteUsuario.php
Propósito:				Permite insertar y modificar datos en la tabla tct_doc_cbte_usuario
Tabla:					tct_tct_doc_cbte_usuario
Parámetros:				$id_doc_cbte_usuario" integer,
						  "$id_documento" integer,
						  "$id_clase_cbte" integer,
						  "$id_usuario" integer,
						  "$id_periodo_subsistema" integer,
						  "$sw_validacion" varchar,
						  "$sw_edicion" varchar

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2011-03-15 10:36:11
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloContabilidad.php");

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = "ActionGuardarDocCbteUsuario.php";

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
		if (!$get)
		{
			$id_doc_cbte_usuario= $_GET["id_doc_cbte_usuario_$j"];
			$id_documento= $_GET["id_documento_$j"];
			$id_usuario= $_GET["id_usuario_$j"];
			$id_clase_cbte= $_GET["id_clase_cbte_$j"];
			$id_periodo_subsistema= $_GET["id_periodo_subsistema_$j"];
			$sw_validacion= $_GET["sw_validacion_$j"];
			$sw_edicion= $_GET["sw_edicion_$j"];          
		}
		else
		{			
			$id_doc_cbte_usuario= $_POST["id_doc_cbte_usuario_$j"];
			$id_documento= $_POST["id_documento_$j"];
			$id_usuario= $_POST["id_usuario_$j"];
			$id_clase_cbte= $_POST["id_clase_cbte_$j"];
			$id_periodo_subsistema= $_POST["id_periodo_subsistema_$j"];
			$sw_validacion= $_POST["sw_validacion_$j"];
			$sw_edicion= $_POST["sw_edicion_$j"];

		}

		if ($id_doc_cbte_usuario == "undefined" || $id_doc_cbte_usuario == "")
		{
			////////////////////Inserción/////////////////////
  			//echo	" doc=$id_doc_cbte_user docume=$id_documento calse=$id_clase_cbte, usr=$id_usuario,persis=$id_periodo_subsistema,$sw_validacion,$sw_edicion";exit;
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarDocCbteUsuario("insert",$id_doc_cbte_usuario,$id_documento,$id_clase_cbte,$id_usuario,$id_periodo_subsistema,$sw_validacion,$sw_edicion);

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
              
			//Validación satisfactoria, se ejecuta la inserción en la tabla tct_usuario_autorizado
			$res = $Custom -> InsertarDocCbteUsuario($id_documento,$id_clase_cbte,$id_usuario,$id_periodo_subsistema,$sw_validacion,$sw_edicion);

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
		{	//echo "get=".$_GET["id_doc_cbte_usuario_0"];///////////////////////Modificación////////////////////
	        //echo "post=".$_POST	["id_doc_cbte_usuario_0"];
			//echo "$id_doc_cbte_user,$id_documento,$id_clase_cbte,$id_usuario,$id_periodo_subsistema,$sw_validacion,$sw_edicion";exit;
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarDocCbteUsuario("update",$id_doc_cbte_usuario,$id_documento,$id_clase_cbte,$id_usuario,$id_periodo_subsistema,$sw_validacion,$sw_edicion);

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
			
			$res = $Custom->ModificarDocCbteUsuario($id_doc_cbte_usuario,$id_documento,$id_clase_cbte,$id_usuario,$id_periodo_subsistema,$sw_validacion,$sw_edicion);
												
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

	$res = $Custom->ContarDocCbteUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
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