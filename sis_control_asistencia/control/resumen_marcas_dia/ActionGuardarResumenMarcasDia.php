<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarResumenMarcasDia.php
Propósito:				Permite insertar y modificar datos en la tabla tca_ResumenMarcasDia
Tabla:					tca_resumen_marcas_dia
Parámetros:				$hidden_id_empleado
						$txt_id_persona
						$txt_codigo_empleado

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-10-18 09:06:57
Versión:				1.0.0
Autor:					Fernando Prudencio Cardona
**********************************************************
*/
session_start();
include_once("../LibModeloControlAsistencia.php");
$Custom = new cls_CustomDBControlAsistencia();
$nombre_archivo = "ActionGuardarResumenMarcasDia.php";
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
			$hidden_id_resumen_marcas_dia= $_GET["hidden_id_resumen_marcas_dia_$j"];
			$txt_fecha_resumen= $_GET["txt_fecha_resumen_$j"];
			$hidden_id_empleado= $_GET["hidden_id_empleado_$j"];
			$txt_fecha_desde=$_GET["txt_fecha_desde_$j"];
			$txt_fecha_hasta=$_GET["txt_fecha_hasta_$j"];
			$tipo=$_GET["tipo_$j"];
			$txt_aprueba=$_GET["txt_aprueba_$j"];
		}
		else
		{
			$hidden_id_resumen_marcas_dia= $_POST["hidden_id_resumen_marcas_dia_$j"];
			$txt_fecha_resumen= $_POST["txt_fecha_resumen_$j"];
			$hidden_id_empleado= $_POST["hidden_id_empleado_$j"];
			$txt_fecha_desde=$_POST["txt_fecha_desde_$j"];
			$txt_fecha_hasta=$_POST["txt_fecha_hasta_$j"];
			$tipo=$_POST["tipo_$j"];
			$txt_aprueba=$_POST["txt_aprueba_$j"];
		}

		if ($hidden_id_resumen_marcas_dia == "undefined" || $hidden_id_resumen_marcas_dia == "")
		{
			////////////////////Inserción/////////////////////
             
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarResumenMarcasDia("insert",$hidden_id_resumen_marcas_dia,$hidden_id_empleado,$txt_fecha_resumen,$txt_fecha_desde,$txt_fecha_hasta);
                             
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
          
			//Validación satisfactoria, se ejecuta la inserción en la tabla tkp_empleado
			if($tipo==1){
			   $res = $Custom -> InsertarResumenMarcasDia($hidden_id_resumen_marcas_dia, $txt_fecha_desde, $txt_fecha_hasta);	
			}
			else{
			   $res = $Custom -> InsertarResumenMarcasDiaManual($hidden_id_resumen_marcas_dia, $hidden_id_empleado, $txt_fecha_resumen);	
			}
            
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
			$res = $Custom->ValidarResumenMarcasDia("update",$hidden_id_resumen_marcas_dia,$hidden_id_empleado,$txt_fecha_resumen,$txt_fecha_desde,$txt_fecha_hasta);

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
            if($txt_aprueba=="si"){
              $res = $Custom->ModificarResumenMarcasDia($hidden_id_resumen_marcas_dia,$hidden_id_empleado,$txt_fecha_resumen);            	
            }
			else{
				$res = $Custom->DesaprobarResumenMarcasDia($hidden_id_resumen_marcas_dia,$hidden_id_empleado,$txt_fecha_resumen);
			}

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
	if($sortcol == "") $sortcol = "RESMARC.fecha_resumen";
	if($sortdir == "") $sortdir = "desc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarListaResumenMarcasDia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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