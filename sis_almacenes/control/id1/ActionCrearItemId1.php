<?php
/*
**********************************************************
Nombre de archivo:	    ActionCrearItem.php
Propósito:				Permite convertir un material a item
Tabla:					tal_id1
Parámetros:				$hidden_id_id1
Valores de Retorno:    	Número de registros
Fecha de Creación:		28-09-2007
Versión:				1.0.0
Autor:					Fernando Prudencio Cardona
**********************************************************
*/
session_start();
include_once("../LibModeloAlmacenes.php");

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = 'ActionCrearItemId1.php';

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
		$cont =  $_POST['cantidad_ids'];

		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para crear item.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = 'NIVEL = 4';
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
			$hidden_id_id1 = $_GET["hidden_id_id1_$j"];
			$txt_codigo = $_GET["txt_codigo_$j"];
			$txt_nombre = $_GET["txt_nombre_$j"];
			$txt_descripcion = $_GET["txt_descripcion_$j"];
			$txt_nivel_convertido = $_GET["txt_nivel_convertido_$j"];
			$txt_convertido = $_GET["txt_convertido_$j"];
			$txt_observaciones = $_GET["txt_observaciones_$j"];
			$txt_estado_registro = $_GET["txt_estado_registro_$j"];
			$txt_fecha_reg = $_GET["txt_fecha_reg_$j"];
			$hidden_id_subgrupo = $_GET["hidden_id_subgrupo_$j"];
			$hidden_id_grupo = $_GET["hidden_id_grupo_$j"];
			$hidden_id_supergrupo = $_GET["hidden_id_supergrupo_$j"];
			$txt_id_unidad_medida_base = $_GET["txt_id_unidad_medida_base_$j"];
			$txt_costo_estimado = $_GET["txt_costo_estimado_$j"];
			$txt_precio_estimado = $_GET["txt_precio_estimado_$j"];
			$txt_stock_min = $_GET["txt_stock_min_$j"];
		}
		else
		{
			$hidden_id_id1 = $_POST["hidden_id_id1_$j"];
			$txt_codigo = $_POST["txt_codigo_$j"];
			$txt_nombre = $_POST["txt_nombre_$j"];
			$txt_descripcion = $_POST["txt_descripcion_$j"];
			$txt_nivel_convertido = $_POST["txt_nivel_convertido_$j"];
			$txt_convertido = $_POST["txt_convertido_$j"];
			$txt_observaciones = $_POST["txt_observaciones_$j"];
			$txt_estado_registro = $_POST["txt_estado_registro_$j"];
			$txt_fecha_reg = $_POST["txt_fecha_reg_$j"];
			$hidden_id_subgrupo = $_POST["hidden_id_subgrupo_$j"];
			$hidden_id_grupo = $_POST["hidden_id_grupo_$j"];
			$hidden_id_supergrupo = $_POST["hidden_id_supergrupo_$j"];
			$txt_id_unidad_medida_base = $_POST["txt_id_unidad_medida_base_$j"];
			$txt_costo_estimado = $_POST["txt_costo_estimado_$j"];
			$txt_precio_estimado = $_POST["txt_precio_estimado_$j"];
			$txt_stock_min = $_POST["txt_stock_min_$j"];
		}

		////////////////////crea item/////////////////////

		    $res = $Custom->CrearItemId1($hidden_id_id1,$txt_codigo,$txt_nombre,$txt_descripcion,$txt_nivel_convertido,$txt_convertido,$txt_observaciones,$txt_estado_registro,$txt_fecha_reg,$hidden_id_subgrupo,$hidden_id_grupo,$hidden_id_supergrupo,$txt_id_unidad_medida_base,$txt_costo_estimado,$txt_precio_estimado,$txt_stock_min);
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
		
		

	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = 'Se creo el item correctamente.';
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'id_id1';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro = '0=0';

	$res = $Custom->ContarId1($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo('TotalCount', $total_registros);
	$resp->add_nodo('mensaje', $mensaje_exito);
	$resp->add_nodo('tiempo_resp', '200');
	echo $resp->get_mensaje();
	exit;
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 1';
	echo $resp->get_mensaje();
	exit;
}
?>