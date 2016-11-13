<?php
/*
**********************************************************
Nombre de archivo:	    ActionGuardarHorario.php
Propósito:				Permite insertar y modificar Horarios
Tabla:					tca_horario
Parámetros:				$hidden_id_codigo_horario	--> id del horario
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
$nombre_archivo = 'ActionGuardarHorario.php';

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
			$hidden_id_codigo_horario = $_GET["hidden_id_codigo_horario_$j"];
			$txt_entra_lunes = $_GET["txt_entra_lunes_$j"];
			$txt_sale_lunes = $_GET["txt_sale_lunes_$j"];
			$txt_entra_martes = $_GET["txt_entra_martes_$j"];
			$txt_sale_martes = $_GET["txt_sale_martes_$j"];
			$txt_entra_miercoles = $_GET["txt_entra_miercoles_$j"];
			$txt_sale_miercoles = $_GET["txt_sale_miercoles_$j"];
			$txt_entra_jueves = $_GET["txt_entra_jueves_$j"];
			$txt_sale_jueves = $_GET["txt_sale_jueves_$j"];
			$txt_entra_viernes = $_GET["txt_entra_viernes_$j"];
			$txt_sale_viernes = $_GET["txt_sale_viernes_$j"];
			$txt_entra_sabado = $_GET["txt_entra_sabado_$j"];
			$txt_sale_sabado = $_GET["txt_sale_sabado_$j"];
			$txt_entra_domingo = $_GET["txt_entra_domingo_$j"];
			$txt_sale_domingo = $_GET["txt_sale_domingo_$j"];
			$txt_min_tolerancia_entra = $_GET["txt_min_tolerancia_entra_$j"];
			$txt_hora_extra_lunes = $_GET["txt_hora_extra_lunes_$j"];
			$txt_hora_extra_martes = $_GET["txt_hora_extra_martes_$j"];
			$txt_hora_extra_miercoles = $_GET["txt_hora_extra_miercoles_$j"];
			$txt_hora_extra_jueves = $_GET["txt_hora_extra_jueves_$j"];
			$txt_hora_extra_viernes = $_GET["txt_hora_extra_viernes_$j"];
			$txt_hora_extra_sabado = $_GET["txt_hora_extra_sabado_$j"];
			$txt_hora_extra_domingo = $_GET["txt_hora_extra_domingo_$j"];
			$hidden_id_grupo_horario = $_GET["hidden_id_grupo_horario_$j"];
			
		}
		else
		{
			$hidden_id_codigo_horario = $_POST["hidden_id_codigo_horario_$j"];
			$txt_entra_lunes = $_POST["txt_entra_lunes_$j"];
			$txt_sale_lunes = $_POST["txt_sale_lunes_$j"];
			$txt_entra_martes = $_POST["txt_entra_martes_$j"];
			$txt_sale_martes = $_POST["txt_sale_martes_$j"];
			$txt_entra_miercoles = $_POST["txt_entra_miercoles_$j"];
			$txt_sale_miercoles = $_POST["txt_sale_miercoles_$j"];
			$txt_entra_jueves = $_POST["txt_entra_jueves_$j"];
			$txt_sale_jueves = $_POST["txt_sale_jueves_$j"];
			$txt_entra_viernes = $_POST["txt_entra_viernes_$j"];
			$txt_sale_viernes = $_POST["txt_sale_viernes_$j"];
			$txt_entra_sabado = $_POST["txt_entra_sabado_$j"];
			$txt_sale_sabado = $_POST["txt_sale_sabado_$j"];
			$txt_entra_domingo = $_POST["txt_entra_domingo_$j"];
			$txt_sale_domingo = $_POST["txt_sale_domingo_$j"];
			$txt_min_tolerancia_entra = $_POST["txt_min_tolerancia_entra_$j"];
			$txt_hora_extra_lunes = $_POST["txt_hora_extra_lunes_$j"];
			$txt_hora_extra_martes = $_POST["txt_hora_extra_martes_$j"];
			$txt_hora_extra_miercoles = $_POST["txt_hora_extra_miercoles_$j"];
			$txt_hora_extra_jueves = $_POST["txt_hora_extra_jueves_$j"];
			$txt_hora_extra_viernes = $_POST["txt_hora_extra_viernes_$j"];
			$txt_hora_extra_sabado = $_POST["txt_hora_extra_sabado_$j"];
			$txt_hora_extra_domingo = $_POST["txt_hora_extra_domingo_$j"];
			$hidden_id_grupo_horario = $_POST["hidden_id_grupo_horario_$j"];
		
		}

	
		if ($hidden_id_codigo_horario == "undefined" || $hidden_id_codigo_horario =="")
		{
			///////////////////Inserción
			//Validación de datos (del lado del servidor)
		
					
			$res = $Custom->ValidarHorario("insert",$hidden_id_codigo_horario,$txt_entra_lunes,$txt_sale_lunes,$txt_entra_martes,$txt_sale_martes,$txt_entra_miercoles,$txt_sale_miercoles,$txt_entra_jueves,$txt_sale_jueves,$txt_entra_viernes,$txt_sale_viernes,$txt_entra_sabado,$txt_sale_sabado,$txt_entra_domingo,$txt_sale_domingo,$txt_min_tolerancia_entra,$txt_hora_extra_lunes,$txt_hora_extra_martes,$txt_hora_extra_miercoles,$txt_hora_extra_jueves,$txt_hora_extra_viernes,$txt_hora_extra_sabado,$txt_hora_extra_domingo,$hidden_id_grupo_horario);
			
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

			$res = $Custom ->CrearHorario($hidden_id_codigo_horario,$txt_entra_lunes,$txt_sale_lunes,$txt_entra_martes,$txt_sale_martes,$txt_entra_miercoles,$txt_sale_miercoles,$txt_entra_jueves,$txt_sale_jueves,$txt_entra_viernes,$txt_sale_viernes,$txt_entra_sabado,$txt_sale_sabado,$txt_entra_domingo,$txt_sale_domingo,$txt_min_tolerancia_entra,$txt_hora_extra_lunes,$txt_hora_extra_martes,$txt_hora_extra_miercoles,$txt_hora_extra_jueves,$txt_hora_extra_viernes,$txt_hora_extra_sabado,$txt_hora_extra_domingo,$hidden_id_grupo_horario);
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
			$res = $Custom->ValidarHorario("update",$hidden_id_codigo_horario,$txt_entra_lunes,$txt_sale_lunes,$txt_entra_martes,$txt_sale_martes,$txt_entra_miercoles,$txt_sale_miercoles,$txt_entra_jueves,$txt_sale_jueves,$txt_entra_viernes,$txt_sale_viernes,$txt_entra_sabado,$txt_sale_sabado,$txt_entra_domingo,$txt_sale_domingo,$txt_min_tolerancia_entra,$txt_hora_extra_lunes,$txt_hora_extra_martes,$txt_hora_extra_miercoles,$txt_hora_extra_jueves,$txt_hora_extra_viernes,$txt_hora_extra_sabado,$txt_hora_extra_domingo,$hidden_id_grupo_horario);
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
				
			$res = $Custom->ModificarHorario($hidden_id_codigo_horario,$txt_entra_lunes,$txt_sale_lunes,$txt_entra_martes,$txt_sale_martes,$txt_entra_miercoles,$txt_sale_miercoles,$txt_entra_jueves,$txt_sale_jueves,$txt_entra_viernes,$txt_sale_viernes,$txt_entra_sabado,$txt_sale_sabado,$txt_entra_domingo,$txt_sale_domingo,$txt_min_tolerancia_entra,$txt_hora_extra_lunes,$txt_hora_extra_martes,$txt_hora_extra_miercoles,$txt_hora_extra_jueves,$txt_hora_extra_viernes,$txt_hora_extra_sabado,$txt_hora_extra_domingo,$hidden_id_grupo_horario);
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
	if($sortcol == "") $sortcol = 'motivo';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro = '0=0';

	$res = $Custom->ContarListaHorario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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