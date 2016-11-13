<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarSietDeclara.php
Propósito:				Permite insertar y modificar datos en la tabla tpr_categoria
Tabla:					tpr_tpr_categoria
Parámetros:				$id_categoria
						$desc_categoria

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-07-04 08:54:27
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionGuardarSietDeclara.php";

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
			$id_siet_declara= $_GET["txt_id_siet_declara_$j"];
			$id_gestion= $_GET["txt_id_gestion_$j"];
			$id_periodo= $_GET["txt_id_periodo_$j"];
			$tipo_declara= $_GET["txt_tipo_declara_$j"];
			$estado= $_GET["txt_estado_$j"];
		}
		else 
		{
	        $id_siet_declara= $_POST["txt_id_siet_declara_$j"];
			$id_gestion= $_POST["txt_id_gestion_$j"];
			$id_periodo= $_POST["txt_id_periodo_$j"];
			$tipo_declara= $_POST["txt_tipo_declara_$j"];
			$estado= $_POST["txt_estado_$j"];
		}

		if ($id_siet_declara == "undefined" || $id_siet_declara == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
		/*	$res = $Custom->ValidarSietDeclara("insert",$id_gestion,$id_periodo);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_categoria<a
			
			$res = $Custom -> InsertarSietDeclara($id_siet_declara,$id_gestion,$id_periodo,$tipo_declara);
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
		/*	$res = $Custom->ValidarSietDeclara("update",$id_gestion,$id_periodo);

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
			
			if ($estado=='finalizar'){
				
				$res = $Custom->ModificarSietDeclaraFinalizar($id_siet_declara);
				
			}else if ($estado=='generar_nros'){
				
				$res = $Custom->ModificarSietDeclaraGenNros($id_siet_declara);
				
				}else{
					$res = $Custom->ModificarSietDeclara($id_siet_declara,$id_gestion,$id_periodo,$tipo_declara);
					
				}
			//$res = $Custom->ModificarSietDeclara($id_siet_declara,$id_gestion,$id_periodo,$tipo_declara);

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
	if($sortcol == "") $sortcol = "id_siet_declara";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarSietDeclara($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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
