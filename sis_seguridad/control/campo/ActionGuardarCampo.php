<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCampo.php
Propósito:				Permite insertar y modificar datos en la tabla tsg_campo
Tabla:					tsg_tsg_campo
Parámetros:				$id_campo
						$nombre
						$id_tabla
						$funcion_grupo
						$label
						$width_reporte
						$funcion
						$casting
						$filtro
						$filtro_grupo
						$formulario
						$grupo

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-30 10:36:36
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloSeguridad.php");

$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = "ActionGuardarCampo.php";

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
			$id_campo= $_GET["id_campo_$j"];
			$nombre= $_GET["nombre_$j"];
			$id_tabla= $_GET["id_tabla_$j"];
			$funcion_grupo= $_GET["funcion_grupo_$j"];
			$label= $_GET["label_$j"];
			$width_reporte= $_GET["width_reporte_$j"];
			$funcion= $_GET["funcion_$j"];
			$casting= $_GET["casting_$j"];
			$filtro= $_GET["filtro_$j"];
			$filtro_grupo= $_GET["filtro_grupo_$j"];
			$formulario= $_GET["formulario_$j"];
			$grupo= $_GET["grupo_$j"];
			$dato_descriptivo= $_GET["dato_descriptivo_$j"];
			$grid_indice= $_GET["grid_indice_$j"];

		}
		else
		{
			$id_campo=$_POST["id_campo_$j"];
			$nombre=$_POST["nombre_$j"];
			$id_tabla=$_POST["id_tabla_$j"];
			$funcion_grupo=$_POST["funcion_grupo_$j"];
			$label=$_POST["label_$j"];
			$width_reporte=$_POST["width_reporte_$j"];
			$funcion=$_POST["funcion_$j"];
			$casting=$_POST["casting_$j"];
			$filtro=$_POST["filtro_$j"];
			$filtro_grupo=$_POST["filtro_grupo_$j"];
			$formulario=$_POST["formulario_$j"];
			$grupo=$_POST["grupo_$j"];
			$dato_descriptivo= $_POST["dato_descriptivo_$j"];
			$grid_indice= $_POST["grid_indice_$j"];

		}

		if ($id_campo == "undefined" || $id_campo == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarCampo("insert",$id_campo, $nombre,$id_tabla,$funcion_grupo,$label,$width_reporte,$funcion,$casting,$filtro,$filtro_grupo,$formulario,$grupo,$dato_descriptivo);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tsg_campo
			$res = $Custom -> InsertarCampo($id_campo, $nombre, $id_tabla, $funcion_grupo, $label, $width_reporte, $funcion, $casting, $filtro, $filtro_grupo, $formulario, $grupo,$dato_descriptivo,$grid_indice);

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
			$res = $Custom->ValidarCampo("update",$id_campo, $nombre, $id_tabla, $funcion_grupo, $label, $width_reporte, $funcion, $casting, $filtro, $filtro_grupo, $formulario, $grupo,$dato_descriptivo);

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

			$res = $Custom->ModificarCampo($id_campo, $nombre, $id_tabla, $funcion_grupo, $label, $width_reporte, $funcion, $casting, $filtro, $filtro_grupo, $formulario, $grupo,$dato_descriptivo,$grid_indice);

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
	if($sortcol == "") $sortcol = "id_campo";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "TABCON_2.id_tabla=''$m_id_tabla''";

	$res = $Custom->ContarCampo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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