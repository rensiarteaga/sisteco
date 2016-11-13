<?php
/*
**********************************************************
Nombre de archivo:	    ActionGuardarLecturaReloj.php
Propósito:				Permite insertar y modificar Lecturas Reloj
Tabla:					tca_lectura_reloj
Parámetros:				$hidden_id_lectura_reloj	--> id de la lectura
						$descripcion
						$txt_id_usuario_asignacion

Valores de Retorno:    	Número de registros
Fecha de Creación:		24-05-2007
Versión:				
Autor:					Fernando Prudencio Cardona
**********************************************************
*/
session_start();
include_once("../LibModeloControlAsistencia.php");
///////////
include_once("../../lib/funciones.inc.php");
		$f = new funciones();
		///////////////
$Custom = new cls_CustomDBControlAsistencia();
$nombre_archivo = 'ActionGuardarLecturaDepurada.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	//Verifica si los datos vienen por post o get
	if (sizeof($_GET) >0)
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
	elseif(sizeof($_POST) >0)
	{
		$get=false;
		$cont =  $_POST['cantidad_ids'];
		
		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar";
		$resp->origen = "ORIGEN= $nombre_archivo";
		$resp->proc = "PROC =$nombre_archivo";
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
			$hidden_id_lectura_depurada = $_GET["hidden_id_lectura_depurada_$j"];
			$txt_id_empleado = $_GET["txt_id_empleado_$j"];
			$txt_fecha = $_GET["txt_fecha_$j"];
			$txt_hora = $_GET["txt_hora_$j"];
			$txt_tipo_movimiento = $_GET["txt_tipo_movimiento_$j"];
			$txt_observaciones = $_GET["txt_observaciones_$j"];
			$txt_turno = $_GET["txt_turno_$j"];
		    $txt_aprobado = $_GET["txt_aprobado_$j"];
		    $resumen = $_GET["resumen"];
		}
		else
		{
			$hidden_id_lectura_depurada = $_POST["hidden_id_lectura_depurada_$j"];
			$txt_id_empleado = $_POST["txt_id_empleado_$j"];
			$txt_fecha = $_POST["txt_fecha_$j"];
			$txt_hora = $_POST["txt_hora_$j"];
			$txt_tipo_movimiento = $_POST["txt_tipo_movimiento_$j"];
			$txt_observaciones = $_POST["txt_observaciones_$j"];
			$txt_turno = $_POST["txt_turno_$j"];
			$txt_aprobado = $_POST["txt_aprobado_$j"];
			$resumen = $_POST["resumen"];
		}
	    if ($txt_aprobado=='true' || $txt_aprobado=='si'){
        	$txt_aprobado='si';
    
        }
        else{
        	$txt_aprobado='no';
            }
         
		if ($hidden_id_lectura_depurada == "undefined" || $hidden_id_lectura_depurada =="")
		{
			///////////////////Inserción
			//Validación de datos (del lado del servidor)
		
					
			$res = $Custom->ValidarLecturaDepurada("insert",$hidden_id_lectura_depurada,$txt_id_empleado,$txt_fecha,$txt_hora,$txt_tipo_movimiento,$txt_observaciones,$txt_turno,$txt_aprobado);
			
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

			$res = $Custom ->InsertarLecturaDepurada($hidden_id_lectura_depurada,$txt_id_empleado,$txt_fecha,$txt_hora,$txt_tipo_movimiento,$txt_observaciones,$txt_turno,$txt_aprobado);
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
		else
		{	//Modificación
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarLecturaDepurada("update",$hidden_id_lectura_depurada,$txt_id_empleado,$txt_fecha,$txt_hora,$txt_tipo_movimiento,$txt_observaciones,$txt_turno,$txt_aprobado);
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
				
			$res = $Custom->ModificarLecturaDepurada($hidden_id_lectura_depurada,$txt_id_empleado,$txt_fecha,$txt_hora,$txt_tipo_movimiento,$txt_observaciones,$txt_turno,$txt_aprobado);
			if(!$res)
			{
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

	/***************no entra aqui cuando es $_GET*************/
	///Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = 'Se guardaron todos los datos.';
	else $mensaje_exito = $Custom->salida[1];
	
	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'id_lectura_depurada';
	if($sortdir == "") $sortdir = 'asc';
	if ($resumen=="si") {$criterio_filtro="LECDEP.id_empleado=".$txt_id_empleado." AND LECDEP.fecha=''$txt_fecha''";}
	else{
	 $criterio_filtro = '0=0';}
	

	$res = $Custom->ContarListaLecturaDepurada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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