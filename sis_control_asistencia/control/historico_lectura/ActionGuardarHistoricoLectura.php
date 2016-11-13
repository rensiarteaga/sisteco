<?php
/*
**********************************************************
Nombre de archivo:	    ActionGuardarHistoricoLectura.php
Propósito:				Permite insertar y modificar Historicos de Lectura
Tabla:					tca_historico_lectura
Parámetros:				$hidden_id_historico_lectura	--> id del historico_lectura
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

$Custom = new cls_CustomDBControlAsistencia();
$nombre_archivo = 'ActionGuardarHistoricoLectura.php';

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
			$hidden_id_historico_lectura = $_GET["hidden_id_historico_lectura_$j"];
			$txt_hora = $_GET["txt_hora_$j"];
			$txt_tipo_movimiento = $_GET["txt_tipo_movimiento_$j"];
			$hidden_id_lectura_procesada = $_GET["hidden_id_lectura_procesada_$j"];
			
		}
		else
		{
			$hidden_id_historico_lectura = $_POST["hidden_id_historico_lectura_$j"];
			$txt_hora = $_POST["txt_hora_$j"];
			$txt_tipo_movimiento = $_POST["txt_tipo_movimiento_$j"];
			$hidden_id_lectura_procesada = $_POST["hidden_id_lectura_procesada_$j"];
		
		}

	
		if ($hidden_id_historico_lectura == "undefined" || $hidden_id_historico_lectura =="")
		{
			///////////////////Inserción
			//Validación de datos (del lado del servidor)
		
					
			$res = $Custom->ValidarHistoricoLectura("insert",$hidden_id_historico_lectura,$txt_hora,$txt_tipo_movimiento,$hidden_id_lectura_procesada);
			
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

			$res = $Custom ->CrearHistoricoLectura($hidden_id_historico_lectura,$txt_hora,$txt_tipo_movimiento,$hidden_id_lectura_procesada);
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
			$res = $Custom->ValidarHistoricoLectura("update",$hidden_id_historico_lectura,$txt_hora,$txt_tipo_movimiento,$hidden_id_lectura_procesada);
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
				
			$res = $Custom->ModificarHistoricoLectura($hidden_id_historico_lectura,$txt_hora,$txt_tipo_movimiento,$hidden_id_lectura_procesada);
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
	if($sortcol == "") $sortcol = 'tipo_movimiento';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro = '0=0';

	$res = $Custom->ContarListaHistoricoLectura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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