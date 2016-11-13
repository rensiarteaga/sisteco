<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarSubCategoriaNormativa.php
Propósito:				Permite insertar y modificar datos en la tabla tad_servicio
Tabla:					tad_tad_servicio
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
session_start();
include_once("../LibModeloAdministracionComunidad.php");

$Custom = new cls_CustomDBComunidad();
$nombre_archivo = "ActionGuardarSubCategoriaNormativa.php";

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
			$id_detalle_normativa= $_GET["id_detalle_normativa_$j"];
			$nombre_subcategoria= $_GET["nombre_subcategoria_$j"];
			$descripcion_subcategoria= $_GET["descripcion_subcategoria_$j"];
			$id_normativa_interna= $_SESSION['id_normativa_interna'];//$_GET["id_normativa_interna_$j"];
		}
		else
		{
			$id_detalle_normativa= $_POST["id_detalle_normativa_$j"];
			$nombre_subcategoria= $_POST["nombre_subcategoria_$j"];
			$descripcion_subcategoria= $_POST["descripcion_subcategoria_$j"];
			$id_normativa_interna= $_SESSION['id_normativa_interna'];//$_POST["id_normativa_interna_$j"];

		}
/*echo "muestra el id_tipo servicio".$id_tipo_servicio;
exit;*/
	if ($id_detalle_normativa == "undefined" || $id_detalle_normativa == "")
		{
			////////////////////Inserción/////////////////////

			//Validación satisfactoria, se ejecuta la inserción en la tabla tad_servicio
			$res = $Custom -> InsertarDetalleNormativa($id_detalle_normativa, $nombre_subcategoria, $descripcion_subcategoria, $id_normativa_interna);
			unset($_SESSION['id_normativa_interna']);//elimino la sesion

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
		
			$res = $Custom->ModificarDetalleNormativa($id_detalle_normativa, $nombre_subcategoria, $descripcion_subcategoria, $id_normativa_interna);

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
	if($sortcol == "") $sortcol = "DN.id_detalle_normativa";
	if($sortdir == "") $sortdir = "ASC";
	if($criterio_filtro == "") $criterio_filtro = "DN.estado_registro=''activo'' and DN.id_normativa_interna=$id_normativa_interna";

	$res = $Custom->ContarDetalleNormativa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
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