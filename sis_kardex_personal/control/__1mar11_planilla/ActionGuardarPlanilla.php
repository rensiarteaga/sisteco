<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarPlanilla.php
Prop�sito:				Permite insertar y modificar datos en la tabla tkp_planilla
Tabla:					tkp_tkp_planilla
Par�metros:				$id_planilla
						$id_tipo_planilla
						$id_periodo
						$id_usuario
						$id_moneda
						$numero
						$estado
						$observaciones
						$fecha_reg

Valores de Retorno:    	N�mero de registros guardados
Fecha de Creaci�n:		2010-08-23 11:07:47
Versi�n:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
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
		
		
		//Verifica si se har� o no la decodificaci�n(s�lo pregunta en caso del GET)
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
	
	//Envia al Custom la bandera que indica si se decodificar� o no
	$Custom->decodificar = $decodificar;

	//Realiza el bucle por todos los ids mandados
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$id_planilla= $_GET["id_planilla_$j"];
			$id_tipo_planilla= $_GET["id_tipo_planilla_$j"];
			$id_periodo= $_GET["id_periodo_$j"];
			$id_moneda= $_GET["id_moneda_$j"];
			$numero= $_GET["numero_$j"];
			$estado= $_GET["estado_$j"];
			$observaciones= $_GET["observaciones_$j"];
			$fecha_planilla= $_GET["fecha_planilla_$j"];

		}
		else
		{
			$id_planilla=$_POST["id_planilla_$j"];
			$id_tipo_planilla=$_POST["id_tipo_planilla_$j"];
			$id_periodo=$_POST["id_periodo_$j"];
			$id_moneda=$_POST["id_moneda_$j"];
			$numero=$_POST["numero_$j"];
			$estado=$_POST["estado_$j"];
			$observaciones=$_POST["observaciones_$j"];
			$fecha_planilla= $_POST["fecha_planilla_$j"];

		}

		if ($id_planilla == "undefined" || $id_planilla == "")
		{
			////////////////////Inserci�n/////////////////////tipo='clon';

			//Validaci�			$id_usuario=$_POST["id_usuario_$j"];n de datos (del lado del servidor)
			$res = $Custom->ValidarPlanilla("insert",$id_planilla,$id_tipo_planilla,$id_periodo,$id_moneda,$numero,$estado,$observaciones);

			if(!$res)
			{
				//Error de validaci�n
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			//Validaci�n satisfactoria, se ejecuta la inserci�n en la tabla tkp_planilla
			$res = $Custom -> InsertarPlanilla($id_planilla,$id_tipo_planilla,$id_periodo,$id_moneda,$numero,$estado,$observaciones,$fecha_planilla);

			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] . " (iteraci�n $cont)";
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		}
		else
		{	///////////////////////Modificaci�n////////////////////
			
			if(isset($_POST["tipo_a_0"]) && $_POST["tipo_a_0"]=='clon'){
			
				$res = $Custom->clonarPlanilla($_POST['id_planilla_0'],$_POST["tipo_a_0"],$id_tipo_planilla,$id_periodo,$id_moneda,$numero,$estado,$observaciones,$fecha_planilla);
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
			//Validaci�n de datos (del lado del servidor)
				$res = $Custom->ValidarPlanilla("update",$id_planilla,$id_tipo_planilla,$id_periodo,$id_moneda,$numero,$estado,$observaciones);

				if(!$res)
				{
					//Error de validaci�n
					$resp = new cls_manejo_mensajes(true, "406");
					$resp->mensaje_error = $Custom->salida[1];
					$resp->origen = $Custom->salida[2];
					$resp->proc = $Custom->salida[3];
					$resp->nivel = $Custom->salida[4];
					echo $resp->get_mensaje();
					exit;
				}

				$res = $Custom->ModificarPlanilla($id_planilla,$id_tipo_planilla,$id_periodo,$id_moneda,$numero,$estado,$observaciones,$fecha_planilla);
	
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

	//Guarda el mensaje de �xito de la operaci�n realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Par�metros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_planilla";
	if($sortdir == "") $sortdir = "asc";
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