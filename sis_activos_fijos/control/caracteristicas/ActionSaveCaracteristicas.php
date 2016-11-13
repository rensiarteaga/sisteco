<?php
/**
**********************************************************
Nombre de archivo:	    ActionSaveCaracteristicas.php
Propósito:				Permite insertar y modificar Caracteristicas
Tabla:					taf_caracteristicas
Parámetros:				$hidden_id_caracteristica	--> id de la Caracteristica
$txt_descripcion
$txt_id_tipo_activo

Valores de Retorno:    	Número de registros
Fecha de Creación:		06 - 06 - 07
Versión:				1.0.0
Autor:					Rodrigo Chumacero M.
**********************************************************
*/
session_start();


include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionSaveCaracteristicas.php';

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
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar.";
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
			$hidden_id_caracteristica = $_GET["hidden_id_caracteristica_$j"];
			$txt_id_descripcion = $_GET["txt_descripcion_$j"];
			$hidden_id_subtipo_activo = $_GET["hidden_id_subtipo_activo_$j"];
			//$txt_id_fina_regi_prog_proy_acti = $_GET["txt_id_fina_regi_prog_proy_acti_$j"];
		}
		else
		{
			$hidden_id_caracteristica = $_POST["hidden_id_caracteristica_$j"];
			$txt_descripcion = $_POST["txt_descripcion_$j"];
			$hidden_id_subtipo_activo = $_POST["hidden_id_subtipo_activo_$j"];
			//$txt_id_fina_regi_prog_proy_acti = $_POST["txt_id_fina_regi_prog_proy_acti_$j"];
		}

		if ($hidden_id_caracteristica == "undefined" || $hidden_id_caracteristica == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarCaracteristicas("insert",$hidden_id_caracteristica,$txt_descripcion,$hidden_id_subtipo_activo);
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

			//Validación satisfactoria, se ejecuta la inserción de la persona
			$res = $Custom -> CrearCaracteristicas($hidden_id_caracteristica,$txt_descripcion,$hidden_id_subtipo_activo);
			//***,$txt_id_fina_regi_prog_proy_acti
			//echo "respA->".$res;
			//exit;
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
			$res = $Custom->ValidarCaracteristicas("update",$hidden_id_caracteristica,$txt_descripcion,$hidden_id_subtipo_activo);
			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel =$Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			$res = $Custom -> ModificarCaracteristicas($hidden_id_caracteristica,$txt_descripcion,$hidden_id_subtipo_activo);
      //*******,$txt_id_fina_regi_prog_proy_acti
			
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
	if($cont > 1) $mensaje_exito = 'Se guardaron todos los datos.';
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'descripcion';
	if($sortdir == "") $sortdir = 'asc';
//	if($criterio_filtro == "") $criterio_filtro = '0=0';

if($criterio_filtro=="") $criterio_filtro="car.id_sub_tipo_activo = $hidden_id_subtipo_activo";

	$res = $Custom->ContarListaCaracteristicas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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