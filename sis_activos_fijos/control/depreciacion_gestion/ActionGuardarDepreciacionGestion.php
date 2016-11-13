<?php
/*
**********************************************************
Nombre de archivo:	    ActionGuardarDepreciacionGestion.php
Propósito:				Permite sertar y modificar procesos
Tabla:					taf_depreciacion_gestion
Parámetros:				$hidden_id_depreciacion_gestion	--> id del proceso

Valores de Retorno:    	Número de registros
Fecha de Creación:		29092015
Versión:				1.0.0
Autor:					unknow
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionGuardarDepreciacionGestion.php';

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
			$id_depreciacion_gestion = $_GET["id_depreciacion_gestion_$j"];
			$id_gestion_ini=$_GET["id_gestion_ini_$j"];
			$id_gestion_fin=$_GET["id_gestion_fin_$j"];
			$proyecto=$_GET["proyecto_$j"];
			$id_depto=$_GET["txt_id_depto_$j"];
			$estado=$_GET["txt_estado_$j"];	
			$mes_ini=$_GET["txt_mes_ini_$j"];
			$mes_fin=$_GET["txt_mes_fin_$j"];	
			$id_proyecto=$_GET["h_id_proyecto_$j"];
			
		}
		else
		{
			$id_depreciacion_gestion = $_POST["id_depreciacion_gestion_$j"];
			$id_gestion_ini=$_POST["id_gestion_ini_$j"];
			$id_gestion_fin=$_POST["id_gestion_fin_$j"];
			$proyecto=$_POST["proyecto_$j"];
			$id_depto=$_POST["txt_id_depto_$j"];	
			$estado=$_POST["txt_estado_$j"];
			$mes_ini=$_POST["txt_mes_ini_$j"];
			$mes_fin=$_POST["txt_mes_fin_$j"];
			$id_proyecto=$_POST["h_id_proyecto_$j"];
		}
;
		if ($id_depreciacion_gestion== "undefined" || $id_depreciacion_gestion== "")
		{ 
			////////////////////Inserción/////////////////////
			$res = $Custom->InsertarDepreciacionGestion($id_gestion_ini,$id_gestion_fin,$proyecto,$id_depto,$estado,$mes_ini,$mes_fin,$id_proyecto);
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
		{   
			$res = $Custom->ModificarDepreciacionGestion($id_depreciacion_gestion,$id_gestion_ini,$id_gestion_fin,$proyecto,$id_depto,$estado,$mes_ini,$mes_fin,$id_proyecto);
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
	if($sortcol == "") $sortcol = 'dg.id_depreciacion_gestion';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarDepreciacionGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,null,$id_actividad);
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