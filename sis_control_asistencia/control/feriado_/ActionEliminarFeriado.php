<?php
/*
/*
**********************************************************
Nombre de archivo:	    
Propósito:				Permite eliminar registros de la tabla de feriado
Tabla:					tca_feriado
Parámetros:				$hidden_id_feriado	--> id del campo a eliminar
						

Valores de Retorno:    	Número de registros
Fecha de Creación:		21 - 08 - 07
Versión:				1.0.0
Autor:					
**********************************************************
*/
session_start();


include_once("../LibModeloControlAsistencia.php");

$Custom = new cls_CustomDBControlAsistencia();
$nombre_archivo = 'ActionEliminarFeriado.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
		if (sizeof($_GET) >0)
		{
			$get=true;
			$cont=1;
		}
		elseif(sizeof($_POST) >0)
		{
			$get=false;
			$cont =  $_POST['cantidad_ids'];
		}
		else
		{
			$resp = new cls_manejo_mensajes(true, "406");
			$resp->mensaje_error = "MENSAJE ERROR = No existen datos para Eliminar.";
			$resp->origen = "ORIGEN = $nombre_archivo";
			$resp->proc = "PROC = $nombre_archivo";
			$resp->nivel = "NIVEL = 4";
			echo $resp->get_mensaje();
			exit;
		}


		for($j = 0;$j < $cont; $j++)
		{
			if ($get)
			{
				$hidden_id_feriados = $_GET["hidden_id_feriados_$j"];
				
			}
			else
			{
				$hidden_id_feriados = $_POST["hidden_id_feriados_$j"];
				
			}
			//echo "id_parametro_general: ".$hidden_id_parametros_generales.id_parametros_generales;
			//exit;
			if ($hidden_id_feriados == "undefined" || $hidden_id_feriados =="")
			{
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = "MENSAJE ERROR = No existe el metodo  especificado para eliminar.";
				$resp->origen = "ORIGEN = $nombre_archivo";
				$resp->proc = "PROC = $nombre_archivo";
				$resp->nivel = "NIVEL = 4";
				echo $resp->get_mensaje();
				exit;
			}
			else
			{	//Eliminación
		
				$res = $Custom->EliminarFeriado($hidden_id_feriados);
	
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
		}//end for

		//Guarda el mensaje de éxito de la operación realizada
		
	if($cont>1) $mensaje_exito = 'Se eliminaron los registros especificados.';
	else $mensaje_exito = $Custom->salida[1];
	


	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'motivo';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro = '0=0';

	$res = $Custom->ContarListaFeriado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;
	
	
	//echo "cuenta lista....";
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
	$resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp->get_mensaje();
	exit;
}
?>



