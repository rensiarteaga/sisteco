<?php
/**  
 * Nombre del archivo:	ActionSaveActivoFijo.php
 * Propósito:			Permite insertar y modificar registros deActivos Fijos
 * Tabla:				taf_activo_fijo
 * Parámetros:			
 * Valores de Retorno:	
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creación:		12-06-2007
 */
session_start();
include_once("../LibModeloActivoFijo.php");
$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionCambiarActivoFijo.php';

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
		$resp = new cls_manejo_mensajes(true, "503");
		$resp->mensaje_error = "No existen datos para almacenar.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = 'NIVEL = 4';
		echo $resp->get_mensaje();
		exit;
	}

	//Envia al Custom la bandera que indica si se decodificará o no
	$Custom->decodificar = $decodificar;
	
	//Variable para devolver el código del activo
	$cod='';

	//Realiza el bucle por todos los ids mandados
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$id_activo_fijo = $_GET["id_activo_fijo_$j"];
			$id_unidad_constructiva = $_GET["id_unidad_constructiva_$j"];
			$id_ubicacion = $_GET["id_ubicacion_$j"];
			$ubicacion_fisica = $_GET["ubicacion_fisica_$j"];
			$observaciones = $_GET["observaciones_$j"];
			$descripcion_larga = $_GET["descripcion_larga_$j"];
			$id_estado_funcional = $_GET["id_estado_funcional_$j"];
			$descripcion = $_GET["descripcion_$j"];
			$num_factura = $_GET["num_factura_$j"];
		}
		else
		{
			$id_activo_fijo = $_POST["id_activo_fijo_$j"];
			$id_unidad_constructiva = $_POST["id_unidad_constructiva_$j"];
			$id_ubicacion = $_POST["id_ubicacion_$j"];
			$ubicacion_fisica = $_POST["ubicacion_fisica_$j"];
			$observaciones = $_POST["observaciones_$j"];
			$descripcion_larga = $_POST["descripcion_larga_$j"];
			$id_estado_funcional = $_POST["id_estado_funcional_$j"];
			$descripcion = $_POST["descripcion_$j"];
			$num_factura = $_POST["num_factura_$j"];
		}

		$res = $Custom -> CambiarActivoFijo($id_activo_fijo,$id_unidad_constructiva,$id_ubicacion,$ubicacion_fisica,$observaciones,$descripcion_larga,$id_estado_funcional,$descripcion,$num_factura); 
		if(!$res)
		{
			//Se produjo un error
			$resp = new cls_manejo_mensajes(true, "503");
			$resp->mensaje_error = $Custom->salida[1];
			$resp->origen = $Custom->salida[2];
			$resp->proc = $Custom->salida[3];
			$resp->nivel = $Custom->salida[4];
			$resp->query = $Custom->query;
			echo $resp->get_mensaje();
			exit;
		}
	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = 'Se guardaron todos los datos.';
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'nombres';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro = '0=0';

	$res = $Custom->ContarListaActivoFijo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo('TotalCount', $total_registros);
	$resp->add_nodo('mensaje', $mensaje_exito);
	$resp->add_nodo('tiempo_resp', '200');
	if($cod!='')
	{
		$resp->add_nodo('alert', $cod);
	}
	else 
	{
		$resp->add_nodo('alert', '');
	}
	echo $resp->get_mensaje();
	exit;
}
else
{	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = ' Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 1';
	echo $resp->get_mensaje();
	exit;
}
?>