<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarInventarioDet.php
Propósito:				Permite insertar y modificar datos en la tabla tal_inventario_det
Tabla:					tal_tal_inventario_det
Parámetros:				$hidden_id_inventario_det
						$txt_cantidad_estimada
						$txt_cantidad_contada
						$txt_fecha_conteo
						$txt_estado_item
						$txt_id_item
						$txt_id_inventario
						$txt_id_responsable_almacen

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-10-31 16:33:10
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../scg_LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = "ActionGuardarInventarioResultadoDet.php";

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
			$hidden_id_inventario_det= $_GET["hidden_id_inventario_det_$j"];
			$txt_cantidad_estimada= $_GET["txt_cantidad_estimada_$j"];
			$txt_cantidad_contada= $_GET["txt_cantidad_contada_$j"];
			$txt_fecha_conteo= $_GET["txt_fecha_conteo_$j"];
			$txt_estado_item= $_GET["txt_estado_item_$j"];
			$txt_id_item= $_GET["txt_id_item_$j"];
			$txt_id_inventario= $_GET["txt_id_inventario_$j"];
			$txt_id_supergrupo= $_GET["hidden_id_supergrupo_$j"];
			$txt_id_grupo= $_GET["hidden_id_grupo_$j"];
			$txt_id_subgrupo= $_GET["hidden_id_subgrupo_$j"];
			$txt_id_id1= $_GET["hidden_id_id1_$j"];
			$txt_id_id2= $_GET["hidden_id_id2_$j"];
			$txt_id_id3= $_GET["hidden_id_id3_$j"];
			$txt_cantidad_contada_nuevo= $_GET["txt_cantidad_contada_nuevo_$j"];
			$txt_cantidad_contada_usado= $_GET["txt_cantidad_contada_usado_$j"];
			
		}
		else
		{
			$hidden_id_inventario_det=$_POST["hidden_id_inventario_det_$j"];
			$txt_cantidad_estimada=$_POST["txt_cantidad_estimada_$j"];
			$txt_cantidad_contada=$_POST["txt_cantidad_contada_$j"];
			$txt_fecha_conteo=$_POST["txt_fecha_conteo_$j"];
			$txt_estado_item=$_POST["txt_estado_item_$j"];
			$txt_id_item=$_POST["txt_id_item_$j"];
			$txt_id_inventario=$_POST["txt_id_inventario_$j"];
			$txt_id_supergrupo=$_POST["hidden_id_supergrupo_$j"];
			$txt_id_grupo=$_POST["hidden_id_grupo_$j"];
			$txt_id_subgrupo=$_POST["hidden_id_subgrupo_$j"];
			$txt_id_id1=$_POST["hidden_id_id1_$j"];
			$txt_id_id2=$_POST["hidden_id_id2_$j"];
			$txt_id_id3=$_POST["hidden_id_id3_$j"];
			$txt_cantidad_contada_nuevo=$_POST["txt_cantidad_contada_nuevo_$j"];
			$txt_cantidad_contada_usado=$_POST["txt_cantidad_contada_usado_$j"];
			
		}
	
	/*	echo"super: ".($txt_id_supergrupo)."<>";
		echo"grupo: ".($txt_id_grupo)."<>";
		echo"subgrupo: ".($txt_id_subgrupo)."<>";
		echo"id1: ".($txt_id_id1)."<>";
		echo"id2: ".($txt_id_id2)."<>";
		echo"id3: ".($txt_id_id3)."<>";
		echo"item: ".($txt_id_item)."<>";
		exit;*/
		if ($hidden_id_inventario_det == "undefined" || $hidden_id_inventario_det == "" && $txt_cantidad_contada_nuevo=="" && $txt_cantidad_contada_usado=="")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			/*$res = $Custom->ValidarInventarioDet("insert",$hidden_id_inventario_det, $txt_cantidad_estimada,$txt_cantidad_contada,$txt_fecha_conteo,$txt_id_item,$txt_id_inventario);

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
			}*/

			//Validación satisfactoria, se ejecuta la inserción en la tabla tal_inventario_det
			$res = $Custom -> InsertarInventarioDet($hidden_id_inventario_det, $txt_cantidad_estimada, $txt_cantidad_contada, $txt_fecha_conteo, $txt_estado_item, $txt_id_item, $txt_id_inventario, $txt_id_supergrupo, $txt_id_grupo,$txt_id_subgrupo, $txt_id_id1, $txt_id_id2, $txt_id_id3, $txt_cantidad_contada_nuevo, $txt_cantidad_contada_usado);

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
			/*$res = $Custom->ValidarInventarioDet("update",$hidden_id_inventario_det, $txt_cantidad_estimada, $txt_cantidad_contada, $txt_fecha_conteo, $txt_id_item, $txt_id_inventario);

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
			}*/
	$res = $Custom->ModificarInventarioDet($hidden_id_inventario_det, $txt_cantidad_estimada, $txt_cantidad_contada, $txt_fecha_conteo, $txt_estado_item, $txt_id_item, $txt_id_inventario, $txt_id_supergrupo, $txt_id_grupo,$txt_id_subgrupo, $txt_id_id1, $txt_id_id2, $txt_id_id3, $txt_cantidad_contada_nuevo, $txt_cantidad_contada_usado);

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
	if($sortcol == "") $sortcol = "id_inventario_det";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "INVENT.id_inventario=''$m_id_inventario''";

	$res = $Custom->ContarInventarioDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$txt_id_inventario);
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