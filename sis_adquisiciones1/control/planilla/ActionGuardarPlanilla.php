<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarPlanilla.php
Propósito:				Permite insertar y modificar datos en la tabla tad_planilla
Tabla:					tad_planilla
Parámetros:				$id_planilla
						
Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-28 17:32:19
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarPlanilla.php";

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
			$id_planilla= $_GET["id_planilla_$j"];
			$observaciones=$_GET["observaciones_$j"];
			$fecha_planilla=$_GET["fecha_planilla_$j"];
			$id_gestion=$_GET["id_gestion_$j"];
			$id_periodo=$_GET["id_periodo_$j"];
			$id_depto_tesoro=$_GET["id_depto_tesoro_$j"];
			$plantilla=$_GET["plantilla_$j"];
			$con_plantilla=$_GET["con_plantilla_$j"];
			$id_plantilla=$_GET["id_plantilla_$j"];
			$descripcion=$_GET["descripcion_$j"];
		}
		else
		{
			$id_planilla=$_POST["id_planilla_$j"];
			$observaciones=$_POST["observaciones_$j"];
			$fecha_planilla=$_POST["fecha_planilla_$j"];
			$id_gestion=$_POST["id_gestion_$j"];
			$id_periodo=$_POST["id_periodo_$j"];
			$id_depto_tesoro=$_POST["id_depto_tesoro_$j"];
			$plantilla=$_POST["plantilla_$j"];
			$con_plantilla=$_POST["con_plantilla_$j"];
			$id_plantilla=$_POST["id_plantilla_$j"];
			$descripcion=$_POST["descripcion_$j"];
		}

		if ($id_planilla == "undefined" || $id_planilla == "")
		{
			
				$res = $Custom->InsertarPlanilla($id_planilla,$observaciones,$fecha_planilla,$id_gestion,$id_periodo,$id_depto_tesoro,$plantilla,$descripcion);
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
		{	///////////////////////Modificación////////////////////
			
			if($con_plantilla=='si'){
			
				$res = $Custom->ImportarPlanilla($id_planilla,$id_plantilla);
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
				
				
				
			}else{
				
				
				
				$res = $Custom->ModificarPlanilla($id_planilla,$observaciones,$fecha_planilla,$id_gestion,$id_periodo,$id_depto_tesoro,$plantilla,$descripcion);
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
		}
		   
	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_planilla";
	if($sortdir == "") $sortdir = "desc";
	
	
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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