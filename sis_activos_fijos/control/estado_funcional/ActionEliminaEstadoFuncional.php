<?php
/*
/*
**********************************************************
Nombre de archivo:	    ActionEliminaetodoDepreciacion.php
Propósito:				Permite eliminar registros de la tabla de MetodoDepreciacion
Tabla:					taf_metodo_depreciacion
Parámetros:				$hidden_id_metodo_depreciacion	--> id del MetodoDepreciacion a eliminar
						

Valores de Retorno:    	Número de registros
Fecha de Creación:		30 - 07 -2008
Versión:				1.0.0
Autor:					Susana Castro
**********************************************************
*/
session_start();


include_once("../LibModeloActivoFijo.php");

$CustomActivos = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionEliminaEstadoFuncional.php';

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
			$resp->mensaje_error = "No existen datos para Eliminar.";
			$resp->origen = $nombre_archivo;
			$resp->proc = $nombre_archivo;
			$resp->nivel = '4';
			echo $resp->get_mensaje();
			exit;
		}


		for($j = 0;$j < $cont; $j++)
		{
			if ($get)
			{
				$hidden_id_estado_funcional = $_GET["id_estado_funcional_$j"];
				
			}
			else
			{
				$hidden_id_estado_funcional = $_POST["id_estado_funcional_$j"];
				
			}

			if ($hidden_id_estado_funcional== "undefined" || $hidden_id_estado_funcional ==" ")
			{
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = "MENSAJE ERROR = No existe el metodo de depreciavion especificado para eliminar.";
				$resp->origen = "ORIGEN = $nombre_archivo";
				$resp->proc = "PROC = $nombre_archivo";
				$resp->nivel = "NIVEL = 4";
				echo $resp->get_mensaje();
				exit;
			}
			else
			{	//Eliminación
		
				$res = $CustomActivos ->EliminarEstadoFuncional($hidden_id_estado_funcional);
	
				if(!$res)
				{
					$resp = new cls_manejo_mensajes(true, "406");
					$resp->mensaje_error = $CustomActivos->salida[1];
					$resp->origen = $CustomActivos->salida[2];
					$resp->proc = $CustomActivos->salida[3];
					$resp->nivel = $CustomActivos->salida[4];
					$resp->query = $CustomActivos->query;
					echo $resp->get_mensaje();
					exit;
				
				}
			}
		}//end for

		//Guarda el mensaje de éxito de la operación realizada
		
	if($cont>1) $mensaje_exito = 'Se eliminaron los registros especificados.';
	else $mensaje_exito = $CustomActivos->salida[1];
	


	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'nombres';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro = '0=0';

	$res = $CustomActivos->ContarListaEstadoFuncional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $CustomActivos->salida;
	
	
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



