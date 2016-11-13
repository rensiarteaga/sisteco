<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarContrato.php
Propósito:				Permite insertar y modificar datos en la tabla tkp_Contrato
Tabla:					tkp_Contrato
Parámetros:				$tkp_id_Contrato, nombre, fecha_reg, estado_reg
						

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2010-08-11
Versión:				1.0.0
Autor:					Mercedes Zambrana Meneses
**********************************************************
*/
session_start();
include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = "ActionGuardarContrato.php";

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
	
			$id_relacion_familiar=$_GET["id_relacion_familiar_$j"];
			$id_persona=$_GET["id_persona_$j"];
			$id_empleado=$_GET["id_empleado_$j"];
			$id_institucion=$_GET["id_institucion_$j"];
			$relacion=$_GET["relacion_$j"];
			$desc_person=$_GET["desc_person_$j"];
			$desc_institucion=$_GET["desc_institucion_$j"];
		
		}
		else
		{
			$id_relacion_familiar=$_POST["id_relacion_familiar_$j"];
			$id_persona=$_POST["id_persona_$j"];
			$id_empleado=$_POST["id_empleado_$j"];
			$id_institucion=$_POST["id_institucion_$j"];
			$relacion=$_POST["relacion_$j"];
			$desc_person=$_POST["desc_person_$j"];
			$desc_institucion=$_POST["desc_institucion_$j"];
		}
	   
               
		if ($id_relacion_familiar == "undefined" || $id_relacion_familiar== "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			
			
			//Validación satisfactoria, se ejecuta la inserción en la tabla tsg_persona y tkp_relacion_familiar
			$res = $Custom -> InsertarRelacionFamiliar($id_relacion_familiar,$id_empleado,$id_persona,$id_institucion,$relacion);
			
				if(!$res){
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
			

			$res = $Custom->ModificarRelacionFamiliar($id_relacion_familiar,$id_empleado,$id_persona,$id_institucion,$relacion);

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
	if($sortcol == "") $sortcol = "id_relacion_familiar";
	if($sortdir == "") $sortdir = "desc";
	if($criterio_filtro == "") $criterio_filtro = "RELFAM.id_empleado=$id_empleado";

	$res = $Custom->ContarRelacionFamiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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